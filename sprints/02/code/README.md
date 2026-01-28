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