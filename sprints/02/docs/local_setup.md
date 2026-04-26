Local setup — gyors útmutató

1) Szükséges szoftverek
- PHP 8.2+ (CLI)
- Composer
- Node.js
- MySQL, Apache (Xampp)
- Laravel (Backend)
- Blade PHP, Tailwind CSS (Frontend)

2) Projekt klónozása
```bash
cd path/to/workspace
git clone <repo-url> code
cd code
```

3) Környezeti fájl
- Másold az `.env.example`-t `.env`-re és állítsd be a DB kapcsolatot (XAMPP alappélda):
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=petshop
DB_USERNAME=root
DB_PASSWORD=
```

4) Telepítés
```bash
composer install
cp .env.example .env
php artisan key:generate
```

5) Adatbázis és migrációk
- Hozz létre egy adatbázist (pl. `petshop`) phpMyAdminban vagy MySQL CLI-vel, ezután a seeder lefutatásával feltöltheted adattal vagy akár használhatod a sql_code.txt fájl sql kódját is feltöltésre(Ezek az emberibb példák).
```bash
php artisan migrate
php artisan db:seed
```

6) Fájlok elérése
- Hozd létre a storage symlink-et (apache/XAMPP esetén lehet, hogy junction szükséges):
```bash
php artisan storage:link
```
- Ha a symlink nem működik Windows+Apache alatt, a projekt tartalmaz egy Laravel route-ot (`/user-avatars/{filename}`), ami kiszolgálja a feltöltött avatarokat.

7) Szerver indítása (fejlesztés)
```bash
php artisan serve
# vagy XAMPP Apache elindítása és a projekt public mappájának elérése
```

8) Oldal megnyitása
```bash
Kattints a Server running on [http://127.0.0.1:8000]. link részére vagy http://127.0.0.1:8000/events beírása a böngészőbe.
```

Gyakori problémák
- "Could not open input file: artisan": lépj be a projekt gyökérkönyvtárába (`cd code`), ahol az `artisan` fájl van.
- Composer zip/zip_ext hibák Windows-on: telepítsd a 7-Zip-et és engedélyezd a `zip` PHP extension-t.
- GD/Imagick: képfeldolgozáshoz győződj meg, hogy a `gd` vagy `imagick` extension engedélyezett (phpinfo()).

További lépések
- Ha CI-t vagy Sentry-t szeretnél, nézd meg a `docs/observability_and_deploy.md` fájlt.
