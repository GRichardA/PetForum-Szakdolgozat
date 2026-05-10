## Local setup — gyors útmutató

### 1) Szükséges szoftverek
```
- PHP 8.2+ (CLI)
- Composer
- Node.js
- MySQL, Apache (Xampp)
- Laravel (Backend)
- Blade PHP, Tailwind CSS (Frontend)
```

### 2) Projekt klónozása
```bash
cd path/to/workspace
git clone <repo-url> code
cd code
```

### 3) Környezeti fájl
- Másold az `.env.example`-t `.env`-re és állítsd be a DB kapcsolatot (XAMPP alappélda):
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=petshop
DB_USERNAME=root
DB_PASSWORD=
```

### 4) Telepítés
```bash
composer install
cp .env.example .env
php artisan key:generate
```

### 5) Adatbázis és migrációk
- Hozz létre egy adatbázist (pl. `petshop`) phpMyAdminban vagy MySQL CLI-vel, ezután a seeder lefutatásával feltöltheted adattal vagy akár használhatod a sql_code.txt fájl sql kódját is feltöltésre(Ezek az emberibb példák).
```bash
php artisan migrate
php artisan db:seed
```

### 6) Fájlok elérése
- Hozd létre a storage symlink-et (apache/XAMPP esetén lehet, hogy junction szükséges):
```bash
php artisan storage:link
```
- Ha a symlink nem működik Windows+Apache alatt, a projekt tartalmaz egy Laravel route-ot (`/user-avatars/{filename}`), ami kiszolgálja a feltöltött avatarokat.

### 7) Szerver indítása (fejlesztés)
```bash
php artisan serve
# vagy XAMPP Apache elindítása és a projekt public mappájának elérése
```

### 8) Oldal megnyitása
```bash
Kattints a Server running on [http://127.0.0.1:8000]. link részére vagy http://127.0.0.1:8000/events beírása a böngészőbe.
```

### Gyakori problémák
- "Could not open input file: artisan": lépj be a projekt gyökérkönyvtárába (`cd code`), ahol az `artisan` fájl van.
- Composer zip/zip_ext hibák Windows-on: telepítsd a 7-Zip-et és engedélyezd a `zip` PHP extension-t.
- GD/Imagick: képfeldolgozáshoz győződj meg, hogy a `gd` vagy `imagick` extension engedélyezett (phpinfo()).


## Telepítés teljesen üres gépre (Clean install — Windows)

Ha az alábbi szoftvereket még nem telepítpted:

### 1. XAMPP (PHP + MySQL + Apache csomag)
1. Töltsd le: https://www.apachefriends.org/
2. Telepítés Windows-ra (alapértelmezett útvonal: `C:\xampp`)
3. XAMPP Control Panel indítása
4. Kattints az "Apache" és "MySQL" melletti "Start" gombokra

### 2. Git (verziókezeléshez)
1. Töltsd le: https://git-scm.com/download/win
2. Telepítés: Alapértelmezett beállítások

### 3. Projekt letöltése
```bash
# PowerShell vagy Command Prompt megnyitása
cd C:\xampp\htdocs
git clone <repo-url> petshop
cd petshop

# Vagy: ZIP letöltés és kicsomagolás
# C:\xampp\htdocs\petshop\
```

### 4. PHP és Composer verifikáció
```bash
php --version  # PHP 8.2+ kell
composer --version  # Composer telepítve kell legyen
```

### 5. Projekt dependenciák
```bash
cd C:\xampp\htdocs\petshop
composer install
```

### 6. Környezeti beállítás
```bash
# .env.example másolása
copy .env.example .env

# Vagy PowerShell-ben:
Copy-Item .env.example -Destination .env
```

Szerkeszd a `.env` fájlt (Notepad++ vagy VS Code):
```env
APP_KEY=  # php artisan key:generate után kitöltődik
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=petshop
DB_USERNAME=root
DB_PASSWORD=
```

### 7. Alkalmazás inicializálása
```bash
php artisan key:generate
```

### 8. Adatbázis létrehozása
- XAMPP Control Panel → "Admin" gomb MySQL mellett (phpMyAdmin megnyitása)
- Bal oldal: "Új" → "Adatbázis" → Név: `petshop` → Létrehozás

Vagy parancssorból:
```bash
mysql -u root -p
# (jelszó beírása — általában üres)
CREATE DATABASE petshop;
EXIT;
```

### 9. Migrációk és seeding
```bash
php artisan migrate --seed
# Sikeres futáskor: "Database seeding completed successfully."
```

### 10. Storage link (fájlfeltöltéshez)
```bash
php artisan storage:link
```

Ha hibát kapsz, ezzel próbáld:
```bash
# PowerShell-ben admin módban:
cmd /c mklink /J public\storage storage\app\public
```

### 11. Szerver indítása
```bash
php artisan serve
```

### 12. Böngészőben nyitás
```
http://localhost:8000
```

### Teszt futtatása
```bash
php artisan test --env=testing
# Sikeres: "Tests: 71 passed"
```

---

## Egy lépésben — XAMPP + Projekt

Ha még nincs XAMPP:
1. XAMPP letöltés és telepítés
2. `C:\xampp\htdocs\petshop` mappába projekt
3. XAMPP Control Panel: Apache + MySQL start
4. PowerShell: `cd C:\xampp\htdocs\petshop && composer install`
5. `copy .env.example .env`
6. `php artisan key:generate && php artisan migrate --seed`
7. `http://localhost/petshop/public` vagy `php artisan serve`

---

## Linux / macOS clean install

### Ubuntu/Debian:
```bash
# Frissítés és szoftverek telepítése
sudo apt-get update
sudo apt-get install -y php8.2-cli php8.2-mysql php8.2-curl php8.2-mbstring mysql-server composer

# Projekt letöltése
git clone <repo-url> ~/petshop
cd ~/petshop

# Telepítés
composer install
cp .env.example .env
php artisan key:generate

# MySQL adatbázis
sudo mysql -u root -p
# CREATE DATABASE petshop;
# EXIT;

# Migrációk
php artisan migrate --seed

# Szerver
php artisan serve
```

### macOS (Homebrew):
```bash
# Homebrew install (ha nincs): https://brew.sh/
brew install php@8.2 mysql composer

# Projekt és telepítés ugyanez, mint Linux
```

---

További lépések
- Ha CI-t vagy Sentry-t szeretnél, nézd meg a `docs/observability_and_deploy.md` fájlt.
- Teljes reprodukciós útmutató: `docs/updated/12_reprodukcios_README.md`

További lépések
- Ha CI-t vagy Sentry-t szeretnél, nézd meg a `docs/observability_and_deploy.md` fájlt.
