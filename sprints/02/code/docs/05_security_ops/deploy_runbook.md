# Deploy Runbook — PetForum

Dátum: 2026-04-18
Szerző: [A te neved]

Cél: lépések a lokális/demo telepítéshez, valamint rollback, incidenskezelés és ellenőrizhető üzemeltetési baseline.

Üzemeltetési célértékek (beta)
- RTO: 30 perc (kritikus hiba esetén szolgáltatás-helyreállítás célideje)
- RPO: 24 óra (elfogadott adatvesztési ablak napi backup mellett)
- SLO Availability: 99.0% (30 napos ablak)

Incidens súlyosság (SEV)
- SEV-1: teljes szolgáltatás kiesés vagy adatvesztés gyanú
- SEV-2: kulcsfunkció részleges kiesése (pl. auth vagy létrehozás hibás)
- SEV-3: nem kritikus hiba, workaround elérhető

Eszkalációs rend (minimum)
- SEV-1: azonnali beavatkozás, rollback mérlegelés 10 percen belül
- SEV-2: diagnózis 30 percen belül, javítás vagy rollback 2 órán belül
- SEV-3: ticket, tervezett javítás következő kiadásban

Prerequisites
- PHP 8.2+, Composer
- MySQL (XAMPP vagy Docker), `DB_*` környezeti változók beállítva
- `composer install` futtatva
- `storage` könyvtár írható (php artisan storage:link ha szükséges)

Startup (lokál, gyors):
1. Klónozd a repót és lépj a projekt mappába.
```powershell
git clone <repo-url>
cd code
cp .env.example .env
# állítsd be a .env DB adatokat
composer install
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
php artisan serve --host=127.0.0.1 --port=8000
```
2. Ellenőrizd a health endpointot:
```powershell
Invoke-RestMethod -Uri http://127.0.0.1:8000/health | ConvertTo-Json -Depth 5
```

Docker (opcionális) — egyszerű dev compose vázlat (ha szükséges)
- Javaslat: későbbi lépésként adni `docker-compose.yml`-t, jelenleg a lokális útvonal elegendő a leadáshoz.

Deploy (demo/prod koncepció)
- Build: `composer install --no-dev --optimize-autoloader`
- Migrate: `php artisan migrate --force`
- Seed csak ha szükséges: `php artisan db:seed --force`
- Cache: `php artisan config:cache && php artisan route:cache && php artisan view:cache`
- Start: `php artisan queue:work` (ha használsz queue-t), és futtasd a webserver-t (nginx/php-fpm vagy `php artisan serve` demohoz)

Pre-deploy checklist
- Tesztek zöldek: `php artisan test`
- Konfiguráció: `APP_ENV=production`, `APP_DEBUG=false`, DB credential ellenőrizve
- Migráció dry-run ellenőrzés: `php artisan migrate --pretend`
- Backup elkészült és visszaállítás tesztelve legalább staging környezetben

Post-deploy checklist
- Route ellenőrzés: `php artisan route:list --path=health`
- Health ellenőrzés: `GET /health` és `GET /api/v1/health`
- Logok ellenőrzése: `storage/logs/laravel.log` (+ opcionális JSON log)
- Kritikus user flow smoke test: login -> event list -> event create -> comment create

Rollback (ha valami rosszul sül el)
1. Azonnali rollback (ha migráció okozta a problémát):
```powershell
php artisan migrate:rollback --step=1
```
Ellenőrizd a hibát a logokban, javítsd a migrációt, majd futtasd újra.

2. Teljes visszaállítás (ha több migráció okozta a problémát):
```powershell
php artisan migrate:reset
php artisan migrate --seed
```
Figyelem: ez törli az adatokat — használni csak demo vagy staging környezetben.

Rollback döntési szabály
- Ha SEV-1 és 10 percen belül nincs stabil hotfix: rollback.
- Ha adatinkonzisztencia jele látszik migráció után: rollback + restore.
- Ha SEV-2 és van gyors javítás (<30 perc): hotfix előnyben, különben rollback.

Monitoring és troubleshooting
- Logok: `storage/logs/laravel.log` — nézd meg a legfrissebb hibákat.
- Health endpoint: `GET /health` — DB és storage státusz.
- Storage/permissions: ha fájlfeltöltés nem működik, ellenőrizd `storage` és `public/storage` jogosultságait.
- Composer dependencies: ha valami hiányzik, futtasd `composer install` újra és ellenőrizd az `vendor` mappát.

Incident runbook (2 tipikus forgatókönyv)

Incident A — DB kapcsolat megszakad
Tünetek:
- `/health` jelzi a DB hibát
- 500-as hibák a tranzakciók során
Gyors diagnózis:
1. Ellenőrizd a `.env` `DB_HOST`/`DB_PORT`/`DB_DATABASE`/`DB_USERNAME` beállításokat
2. Próbálj meg belépni a DB-be CLI-vel: `mysql -u user -p -h host database`
Gyors mitigáció:
- Indítsd újra a MySQL szolgáltatást (pl. XAMPP control panel)
Végleges javítás:
- Ha a DB sérült, restore a legfrissebb backupból (lásd backup szakasz)

Incident B — Storage/Avatar upload hibák
Tünetek:
- Fájlfeltöltés 500-at ad vissza
- `/health` jelzi, hogy a storage nem írható
Gyors diagnózis:
1. Ellenőrizd `storage/logs/laravel.log` hibákat
2. Ellenőrizd `php artisan storage:link` és a `public/storage` elérhetőségét
Gyors mitigáció:
- Állíts be ideiglenes alapértelmezett avatar URL-t, hogy a UI ne essen össze
Végleges javítás:
- Javítsd a jogosultságokat (`chmod`/Windows ACL) és hozd rendbe a storage linket

Backup & Restore (ajánlott gyakorlat)
- Lokálisan: rendszeres `mysqldump` export előtti állapotról
```powershell
mysqldump -u root -p your_db_name > backup_$(Get-Date -Format yyyyMMdd).sql
```
- Restore:
```powershell
mysql -u root -p your_db_name < backup_file.sql
```

Rendszeres ellenőrzések (checklist)
- CI zöld a main branch-en
- `php artisan migrate --pretend` futtatása deploy előtt
- Health endpoint működése
- Log monitoring: heti ellenőrzés

Operációs evidencia (2026-04-25)
- `php artisan route:list --path=health`
	- 2 route aktív: `health` és `api/v1/health`.
- `php artisan test --filter=test_health_contract_shape`
	- PASS (1 teszt, 4 assertion).
- `Get-ChildItem storage/logs | Select-Object Name,Length,LastWriteTime`
	- `laravel.log` jelen van és frissül.

---
Végjegyzet: ez a runbook demo/staging célú. Ha éles deploy szükséges, érdemes konténerezni és automatizált CI/CD pipeline-t készíteni (artifact build, tag, deploy, healthchecks, rollback automatizálás).