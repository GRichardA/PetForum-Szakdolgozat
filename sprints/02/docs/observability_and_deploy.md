Megfigyelhetőség és üzembe helyezés

Cél
- Üzemeltetési átláthatóság biztosítása mérhető SLA/SLO célokkal.
- Gyors hibafelismerés és reprodukálható incidenskezelés.
- Konzisztens deploy folyamat rollback forgatókönyvvel.

Aktuális implementáció
- Health endpointok: GET /health és GET /api/v1/health.
- Logging csatornák: single, daily, json (Monolog JsonFormatter).
- Automatizált ellenőrzések: GitHub Actions + PHPUnit.

SLI/SLO javaslat (beta környezet)
- SLI 1: Availability (health endpoint sikeres válasz aránya).
	- SLO: >= 99.0% 30 napos ablakban.
- SLI 2: API hiba arány (5xx / összes kérés).
	- SLO: <= 1.0% napi szinten.
- SLI 3: Válaszidő p95 (fő listázó oldalak és API endpointok).
	- SLO: <= 800 ms p95.
- SLI 4: Deploy sikeresség.
	- SLO: >= 95% sikeres deploy / hónap.

Riasztási küszöbök (kezdeti)
- Critical: /health 3 egymást követő sikertelen mérés 5 percen belül.
- High: API 5xx arány > 2% 10 perces ablakban.
- Medium: p95 válaszidő > 1.2 s 15 percen keresztül.

Strukturált logolás
- A JSON log csatorna elérhető a config/logging.php fájlban json néven.
- Javasolt környezeti beállítás produkcióra:
	- LOG_CHANNEL=stack
	- LOG_STACK=json,single
	- LOG_LEVEL=info
- Kimeneti fájl JSON csatornához: storage/logs/laravel-json.log.

Minta log mezők (javaslat)
- timestamp
- level
- message
- request_id
- user_id (ha van)
- route
- method
- status_code
- duration_ms

Health endpoint kontraktus
- Példa válasz:
	- status: ok
	- checks.database: ok
	- checks.storage: writable
	- timestamp: ISO-8601

Deploy baseline
- Release előkészítés:
	- composer install --no-dev --optimize-autoloader
	- php artisan test
- Kiadás:
	- php artisan migrate --force
	- php artisan config:cache
	- php artisan route:cache
	- php artisan view:cache
- Post-deploy validáció:
	- route lista ellenőrzés /health útvonalra
	- health contract teszt futtatás
	- log fájlok és jogosultságok ellenőrzése

Evidence (2026-04-25)
- Route ellenőrzés:
	- php artisan route:list --path=health
	- Eredmény: 2 route (health és api/v1/health) regisztrálva.
- Health contract teszt:
	- php artisan test --filter=test_health_contract_shape
	- Eredmény: PASS, 1 teszt, 4 assertion.
- Log fájl ellenőrzés:
	- Get-ChildItem storage/logs
	- Eredmény: laravel.log jelen van és frissül.

Megjegyzés lokális futtatásról
- Runtime HTTP health lekérés csak futó alkalmazás mellett működik.
- Ha a helyi szerver nem fut (php artisan serve vagy webserver), a 127.0.0.1:8000/health hívás nem elérhető.
