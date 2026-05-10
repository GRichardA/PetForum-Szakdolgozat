# Reprodukciós README

## Célok
Ez az útmutató biztosítja, hogy a szakdolgozat témavezetője, bírálói és a szakmai közösség el tudják indítani a rendszert egy tiszta, üres gépről.

## Projekt futtatása

### 1. Szükséges szoftverek telepítése

#### Windows (XAMPP csomag via):
```bash
# Option A: XAMPP (Bundle: Apache + MySQL + PHP)
# Letöltés: https://www.apachefriends.org/
# Telepítés: Default útvonal: C:\xampp
# MySQL és Apache indítása: XAMPP Control Panel

# Option B: Egyedi telepítés (választható)
# PHP 8.2+ : https://www.php.net/downloads.php
# MySQL 8.0+ : https://dev.mysql.com/downloads/mysql/
# Composer : https://getcomposer.org/download/
# Node.js 18+ : https://nodejs.org/
```

#### Linux (Ubuntu/Debian):
```bash
# PHP 8.2 + MySQL + Composer + Node.js
sudo apt-get update
sudo apt-get install php8.2-cli php8.2-mysql php8.2-curl php8.2-mbstring mysql-server composer nodejs npm
```

#### macOS (Homebrew):
```bash
brew install php@8.2 mysql composer node
```

### 2. Projekt klónozása vagy letöltése

```bash
# Git clone (ha repo elérhető)
git clone <repo-url> petshop
cd petshop

# Vagy: ZIP letöltés és kicsomagolás
unzip petshop.zip
cd petshop
```

### 3. Függőségek telepítése

```bash
# PHP dependenciák (Composer)
composer install

# Node.js dependenciák (CSS/JS build — opcionális MVP-nél)
npm install
npm run build  # vagy: npm run dev
```

### 4. Környezeti konfigurációs fájl

```bash
# .env.example másolása
cp .env.example .env

# Windows (PowerShell)
Copy-Item .env.example -Destination .env
```

#### Az `.env` fájl szerkesztése:

**XAMPP (alapértelmezett):**
```env
APP_NAME=PetShop
APP_ENV=local
APP_KEY=  # php artisan key:generate után kitöltődik
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=petshop
DB_USERNAME=root
DB_PASSWORD=
```

**Felhő vagy más szerver:**
```env
DB_HOST=your-server.com
DB_PORT=3306
DB_DATABASE=petshop_prod
DB_USERNAME=petshop_user
DB_PASSWORD=secure_password_here
```

### 5. Alkalmazás kulcsa és adatbázis inicializálása

```bash
# Laravel application key generálása (kötelező)
php artisan key:generate

# Adatbázis létrehozása (MySQL CLI vagy phpMyAdmin)
# MySQL CLI:
mysql -u root -p
# CREATE DATABASE petshop;
# EXIT;

# Vagy phpMyAdmin: Adatbázisok > Új adatbázis > "petshop"

# Migrációk futtatása és seeding
php artisan migrate --seed

# Teszt adatbázis (opcionális, de ajánlott)
php artisan migrate --env=testing --seed
```

### 6. Storage symlink (fájlfeltöltéshez)

```bash
php artisan storage:link
# Windows + Apache alatt Junction lehet szükséges (ha nem működik)
# mklink /J public/storage storage/app/public
```

### 7. Szerver indítása (fejlesztés)

```bash
# Laravel beépített szerver (egyszerű fejlesztéshez)
php artisan serve
# URL: http://localhost:8000

# Vagy: Apache XAMPP-nél
# VirtualHost: C:\xampp\apache\conf\extra\httpd-vhosts.conf
# <VirtualHost *:80>
#     ServerName petshop.local
#     DocumentRoot "C:\xampp\htdocs\petshop\public"
# </VirtualHost>
# hosts fájl: C:\Windows\System32\drivers\etc\hosts
# 127.0.0.1 petshop.local
# Böngészőben: http://petshop.local
```

## Tesztek futtatása

```bash
# Teljes teszt csomag (71 teszt)
php artisan test

# Teszt adatbázison (ajánlott)
php artisan test --env=testing

# Csak Feature tesztek
php artisan test --filter Feature

# Csak Unit tesztek
php artisan test --filter Unit

# Verbose output
php artisan test --verbose
```

## Demo felhasználók (Seeding után)

Automatikusan elvetett adatok a `database/seeders/`:

| Email | Jelszó | Szerep | Cél |
|---|---|---|---|
| `janos@example.hu` | `password` | user | Alap felhasználó (pet-ek és regisztrációk kezelése) |
| `maria@example.hu` | `password` | user | Második felhasználó |
| `admin@example.hu` | `password` | admin | Admin jelölt (opcionális, ha bevezetett) |

**Belépés**: `http://localhost:8000/login`

## Fő funkciók gyors tesztje

1. **Bejelentkezés**: `janos@example.hu` / `password`
2. **Pet hozzáadása**: Profil → Kisállatok → + Pet
3. **Eseménybrowzing**: Főoldal → Események listája
4. **Regisztráció eseményre**: Esemény részlet → Pet kiválasztása → Regisztráció
5. **Komment**: Esemény oldalon Comment mező
6. **Admin (ha van)**: `/admin` → Moderáció
7. **Kijelentkezés**: Profil → Logout

## Hibaelhárítás

### 1. "Class 'env' does not exist"
- **Ok**: `app()->environment()` nem működik bootstrap alatt.
- **Megoldás**: `.env` fájl manuális check vagy `$_ENV` használat.

### 2. "CSRF token mismatch" (Blade formáknál)
- **Ok**: Form nincs `@csrf` direktívával.
- **Megoldás**: Blade template-en belül `@csrf` hozzáadása.

### 3. "Database connection failed"
- **Ok**: MySQL nincs futva vagy `.env` adatok helytelenek.
- **Megoldás**: 
  - XAMPP: MySQL start Control Panel-ben
  - `.env` ellenőrzés: `DB_HOST`, `DB_USERNAME`, `DB_PASSWORD`
  - `mysql -u root -p` teszt a CLI-ből

### 4. "Port 8000 already in use" (php artisan serve)
- **Ok**: Másik alkalmazás használja a portot.
- **Megoldás**: `php artisan serve --port=8001`

### 5. "npm: command not found"
- **Ok**: Node.js nincs telepítve.
- **Megoldás**: Node.js telepítés (nodejs.org)

## Docker (opcionális, jövőbeli telepítéshez)

Ha Docker elérhető:
```bash
docker-compose up -d
docker-compose exec app php artisan migrate --seed
```

*(Dockerfile és docker-compose.yml szeparátum dokumentáció)*

## Várható kimenet

### Bejelentkezés után:
- Főoldal: Események listája + Szűrés (kategória, keresés)
- Saját profil: Személyes adatok, saját pet-ek, regisztrációk
- Esemény részlet: Résztvevők, kommentek, regisztráció gomb

### Tesztek futtatása után:
```
Tests: 71 passed (162 assertions)
```

## Támogatás és dokumentáció

- **Teljes dokumentáció**: `docs/` mappa
- **Kódrepo struktúra**: `code/` mappa
- **Adatmodell**: `docs/07_adatmodell.md`
- **API endpoints**: `docs/08_modulok_interfeszek_API.md`
- **Biztonsági szempont**: `docs/09_biztonsagi_minimum.md`

---

**Frissítés**: 2026-05-10  
**Verzió**: 1.0 MVP  
**Készítette**: GRichardA