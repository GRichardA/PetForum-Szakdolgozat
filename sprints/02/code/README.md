# 🐾 Petshop Webalkalmazás

Ez egy Laravel alapú webalkalmazás, amely Tailwind CSS-t használ a frontend megjelenítéshez és MySQL adatbázist az adatok tárolásához.

## 🛠 Technológiai Stack
- **Backend:** PHP 8.2+ (Laravel Framework)
- **Frontend:** Blade PHP, Tailwind CSS (Vite build tool)
- **Adatbázis:** MySQL (XAMPP környezetben tesztelve)

---

## 🚀 Lokális Telepítés (Quick Start)

Kövesd az alábbi lépéseket a projekt futtatásához:

### 1. Előfeltételek
Győződj meg róla, hogy telepítve van:
- PHP 8.2+ & Composer
- Node.js & NPM
- XAMPP (Apache & MySQL)

### 2. Projekt klónozása és függőségek
- git clone <a-te-repo-url-ed>
- cd <projekt-mappa-neve>

# Backend függőségek
- composer install

# Frontend függőségek és Tailwind build
- npm install
- npm run build

# Környezeti beállítások
- cp .env.example .env
- php artisan key:generate

# Adatbázis inicializálása
- php artisan migrate --seed
- php artisan storage:link

# Szerver indítása
- php artisan serve
- http://127.0.0.1:8000

---

## 🔐 Admin Panel & Felhasználók

### Admin fiók (alapértelmezett):
- **Email:** admin@admin.com
- **Jelszó:** Admin1234
- **Hozzáférés:** http://127.0.0.1:8000/admin

Az admin felület lehetővé teszi:
- Kategóriák létrehozása és kezelése
- Események moderálása (törlése)
- Bármelyik hozzászólás törlése

### Tesztelő fiók (lekérdezés):
```bash
php artisan tinker
User::all();
```

---

## 🧪 Tesztelés

Összes teszt futtatása:
```bash
php artisan test
```

Specifikus tesztek:
```bash
# Csak az admin teszteket
php artisan test tests/Feature/AdminTest.php

# Csak a komment teszteket
php artisan test tests/Feature/CommentTest.php

# Egy konkrét teszt
php artisan test --filter=test_user_can_delete_own_comment
```

**Tesztelés státusza:** 67 teszt, 0 hiba

---

## ✨ Fő funkciók

- ✅ **Eventos CRUD:** Esemény létrehozás, szerkesztés, törlés
- ✅ **Hozzászólások:** Kommenteket írás, válaszok, hierarchikus megjelenítés
- ✅ **Komment törlés:** Felhasználó törölheti saját kommentjét, admin bármelyiket (kaszkádos törlés)
- ✅ **Admin panel:** Kategória kezelés, event moderálás
- ✅ **Profil szerkesztés:** Avatár feltöltés, jelszó módosítás
- ✅ **Dark mode:** UI klasszis és sötét megjelenítés
- ✅ **Tesztek:** 67 automatizált feature és unit teszt