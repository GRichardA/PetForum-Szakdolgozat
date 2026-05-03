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
| **US-06** | Hozzászólások (Comments) CRUD | Kész | Igen |
| **US-07** | Hozzászólás törlés (saját + admin) | Kész | Igen |
| **US-08** | Hozzászólások hierarchiája (válaszok) | Kész | Igen |
| **US-09** | Admin panel és kategória kezelés | Kész | Igen |
| **US-10** | Event moderálás (admin) | Kész | Igen |
| **US-11** | Dark mode UI javítások | Kész | Igen |

---

## 4. Onboarding & Indítási Útmutató

Új fejlesztő számára a Sprint 2 kódjának indítása a `sprints/02/code` mappából:

1.  **Függőségek telepítése:** Győződjön meg róla, hogy a `vendor` mappa létezik (`composer install` szükséges).
2.  **Adatbázis beállítása:** Az XAMPP MySQL szervernek futnia kell, és a `.env` fájlnak a `petshop` adatbázisra kell mutatnia.
3.  **Adatbázis migráció:** Hozza létre a táblákat: `php artisan migrate`
4.  **Szerver indítása:** `php artisan serve`

Az alkalmazás elérhető: `http://127.0.0.1:8000/events`

---

## 5. Tesztelési Lefedettség

A Sprint 2-ben végzett tesztelés:

```bash
php artisan test
```

**Tesztelés státusza:**
- ✅ **67 teszt sikeresen lefut**
- 0 teszt sikertelen
- 0 szándékos skip

### Fő tesztkategóriák:

| Teszt Fájl | Teszt Esetek | Tárgy |
| :--- | :--- | :--- |
| `tests/Feature/AuthTest.php` | 6 | Regisztráció, bejelentkezés, kijelentkezés |
| `tests/Feature/EventTest.php` | 10 | Event CRUD, validáció, tulajdonos ellenőrzés |
| `tests/Feature/CommentTest.php` | 8 | Hozzászólás írás, törlés (saját + admin), kaszkád törlés |
| `tests/Feature/AdminTest.php` | 15 | Admin panel, kategória CRUD, event moderálás |
| `tests/Feature/ProfileTest.php` | 5 | Profil szerkesztés, jelszó frissítés |
| `tests/Feature/AvatarUploadTest.php` | 3 | Avatár feltöltés, validáció |
| `tests/Feature/CategoryTest.php` | 5 | Kategória modell, slug generálás |
| `tests/Feature/MiddlewareTest.php` | 5 | Admin middleware, authorization |
| `tests/Unit/UserTest.php` | 6 | User model, admin role |
| `tests/Unit/EventTest.php` | 5 | Event model, date casting |
| `tests/Feature/ApiContractTest.php` | 1 | API contract tesztek |

### Fontos tesztelési esetek (Comment modulhoz):

1. **test_user_can_delete_own_comment** - Felhasználó törölheti saját kommentjét
2. **test_user_cannot_delete_others_comment** - Felhasználó nem törölheti másét (403)
3. **test_admin_can_delete_any_comment** - Admin bármelyik kommentettörölheti
4. **test_deleting_comment_cascades_to_children** - Parent törlése törli a gyermek kommenteket