# Tesztelés és validáció

## Tesztterv (összefoglaló)
| Teszt ID | Típus | Cél | Előfeltétel | Lépések | Várt eredmény | Kapcsolódó követelmény | Eredmény |
|---|---|---|---|---|---|---|---|
| TC-01 | funkcionális | sikeres belépés | létező user | email+jelszó megadása | dashboard megjelenik | UC-01 | sikeres |
| TC-02 | funkcionális | pet CRUD | bejelentkezett user | pet létrehozása/szerkesztése/törlése | műveletek sikeresek | UC-02 | sikeres |
| TC-03 | funkcionális | esemény létrehozás | admin/szervező | event create form | esemény mentve szabályokkal | UC-03 | sikeres |
| TC-04 | integráció | regisztráció validáció | user+pet+event | pet regisztrálása eseményre | csak engedélyezett pet regisztrál | UC-04 | sikeres |
| TC-05 | határeset | kapacitás kezelése | esemény kapacitással | több regisztráció létrehozása | kapacitás betelése jelzése | UC-04 | sikeres |

## Automatizált tesztek
- A projekt tartalmaz PHPUnit teszteket (`tests/Feature`, `tests/Unit`). A jelenlegi állapot: összes teszt futtatható és sikeres.
- Gyors parancsok:

```bash
php artisan migrate:fresh --seed --env=testing
php artisan test --env=testing
```

## Validációs bizonyítékok
- Funkcionális automatizált tesztek: jelenleg 71 teszt fut le sikeresen (lokális futtatás eredménye).
- Reprodukálható futtatás: `migrate:fresh --seed` és `php artisan test --env=testing` parancsokkal reprodukálható a környezet.
- Security minimum ellenőrzés: lásd `09_biztonsagi_minimum.md`.

## Kézi teszt javaslatok
- End-to-end forgatókönyv: 1) Új user létrehozása; 2) Pet hozzáadása; 3) Esemény böngészése; 4) Pet regisztrálása; 5) Regisztráció törlése.
- Edge-case: próbáld regisztrálni nem-tulajdonolt pet-tel (kell 403-at adni).

---

Következő lépés: szeretnéd, hogy ezeket commitáljam és PR-t készítsek, vagy előbb átnézed és módosítasz valamit? (Rövid választ várok.)