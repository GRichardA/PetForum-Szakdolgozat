# 📄 PetShop - Sprint 2 Zárójelentés

---

## Általános Információk

| Kategória | Érték |
| :--- | :--- |
| **Dátum** | 2025.12.01. |
| **Fejlesztő** | [HD99H8 - Galváts Richárd Ákos] |
| **Státusz** | Kész (Teljes CRUD + UI Csiszolás) |

---

## 1. Vezetői Összefoglaló

Ebben a sprintben elkészült a PetShop "Vertikális Szelete": a **közösségi események kezelése (Events CRUD)**. A rendszer képes eseményeket létrehozni, listázni, szerkeszteni és törölni. A fejlesztés a **DRY elvet** (Don't Repeat Yourself) követve, Blade Layoutok használatával történt, és a felhasználói felületet modern **Tailwind CSS** keretrendszerrel alakítottuk ki.

---

## 2. Technikai Stack (Megvalósult)

A funkció megvalósításához használt főbb technológiák és beállítások:

* **Backend:** Laravel 11 (PHP 8.2)
* **Adatbázis:** MySQL 8.0 (`petshop` adatbázis)
* **Adatmodell:** `App\Models\Event` (A `$fillable` védett mezőkkel konfigurálva)
* **Logika:** `App\Http\Controllers\EventController` (Resource Controller)
* **Frontend:** Blade Templates + Tailwind CSS (CDN)
* **Környezet:** XAMPP (Apache + MySQL Localhost)

---

## 3. Elkészült Funkciók (User Stories)

Az alábbi táblázat mutatja a sprint során megvalósított, felhasználói szintű funkciókat és azok státuszát:

| ID | Leírás | Státusz | Tesztelve? |
| :--- | :--- | :--- | :--- |
| **US-01** | Üres állapot kezelése (Empty State) | Kész | Igen |
| **US-02** | Esemény létrehozása (Validációval) | Kész | Igen |
| **US-03** | Események listázása (Kártya nézet) | Kész | Igen |
| **US-04** | Esemény szerkesztése (`PUT` metódussal) | Kész | Igen |
| **US-05** | Esemény törlése (`DELETE` metódussal) | Kész | Igen |

---

## 4. Onboarding & Indítási Útmutató

Új fejlesztő számára a Sprint 2 kódjának indítása a `sprints/02/code` mappából:

1.  **Függőségek telepítése:** Győződjön meg róla, hogy a `vendor` mappa létezik (`composer install` szükséges).
2.  **Adatbázis beállítása:** Az XAMPP MySQL szervernek futnia kell, és a `.env` fájlnak a `petshop` adatbázisra kell mutatnia.
3.  **Adatbázis migráció:** Hozza létre a táblákat: `php artisan migrate`
4.  **Szerver indítása:** `php artisan serve`

Az alkalmazás elérhető: `http://127.0.0.1:8000/events`