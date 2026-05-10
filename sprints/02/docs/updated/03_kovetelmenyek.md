# Funkcionális és nem funkcionális követelmények

## Funkcionális követelmények (FK)

| ID | Követelmény | Felhasználói érték | Prioritás | Elfogadási kritérium | Kapcsolódó use case | Kapcsolódó képernyő | Teszt ID |
|---|---|---|---|---|---|---|---|
| FK-01 | Bejelentkezés és session | Személyes adatok és műveletek elkülönítése | Must | Érvényes adatokkal belép, hibás adatokkal hibaüzenet | UC-01 | SCR-LOGIN | TC-01 |
| FK-02 | Pet CRUD (User-owned) | Saját kisállatok kezelése | Must | Felhasználó létrehoz, szerkeszt, töröl pet-et | UC-02 | SCR-PETS | TC-02, TC-03 |
| FK-03 | Esemény CRUD + pet-paraméterek | Rendezvény szervezés pet-szabályokkal | Must | Esemény létrehozva allowed_species, allowed_breeds, require_vaccinated, capacity-val | UC-03 | SCR-EVENT-CREATE | TC-04 |
| FK-04 | Regisztráció pet-tel eseményre | Gazdi regisztrálja kisállatát | Must | Pet kiválasztása, fajta+oltás ellenőrzés, kapacitás-check, regisztráció siker | UC-04 | SCR-EVENT-DETAIL | TC-05, TC-06 |
| FK-05 | Regisztráció törlése | Gazdi lemondja részvételét | Should | Felhasználó képes saját regisztrációját töröl | UC-05 | SCR-EVENT-DETAIL | TC-07 |
| FK-06 | Admin moderáció | Hibás tartalom eltávolítása | Should | Admin képes eseményt, kategóriát, kommentet töröl | UC-06 | SCR-ADMIN | TC-08 |
| FK-07 | Esemény-kommentek | Közösségi visszajelzés | Should | Felhasználó rögzít kommentet, admin moderálja | UC-04, UC-05 | SCR-EVENT-DETAIL | TC-09 |

## Nem funkcionális követelmények (NFK)

| ID | Minőségi attribútum | Követelmény | Mérési mód | Célérték | Kapcsolódó teszt |
|---|---|---|---|---|---|
| NFK-01 | Teljesítmény | Eseménylista betöltése normál terhelésnél | Response time mérés | p95 < 2s | TC-PERF-01 |
| NFK-02 | Biztonság: Titokkezelés | Nincs API-kulcs vagy DB-jelszó a repóban | git secret-scan | 0 titok | CI secret-scan |
| NFK-03 | Biztonság: AAA | Ownership check minden felhasználó-specifikus műveletnél | Kódreview + unit/feature teszt | 100% | TC-SEC-01, TC-SEC-02 |
| NFK-04 | Biztonság: CSRF | Wszystkie POST/PUT/DELETE CSRF token-nel védve | Blade `@csrf` használat | 100% | TC-SEC-03 |
| NFK-05 | Biztonság: Input validáció | Minden felhasználói input validálva a szerveren | FormRequest + validátor | 100% | TC-SEC-04 |
| NFK-06 | Biztonság: XSS | Kimeneti HTML escape-elve vagy sanitizálva | Blade `{{ }}` + e() | 100% | TC-SEC-05 |
| NFK-07 | Karbantarthatóság | Kód modularitása és tesztelhetősége | Code review + test coverage | >80% kritikus path | Unit+Feature testesetek |
| NFK-08 | Reprodukálhatóság | Tiszta gépről telepíthető és futtatható | README alapján 1 körben futás | Siker | README teszt |
| NFK-09 | Mobilitás: Responsivity | Mobil (375px) és asztali (1920px) megtekintés | CSS media queries + screenshot teszt | Olvasható mindkét méretben | UX teszt |
| NFK-10 | Lokalizáció | Minden UI szöveg magyar | I18n ellenőrzés | 100% magyar | Audit |

## Követelményminőség ellenőrzése
- **Konkrétség**: Minden FK-nek van elfogadási kritériuma (mit látsz sikeres futáskor).
- **Tesztelhetőség**: Mindegyik TC-hez kapcsolódik.
- **Függetlenség**: Nem kever több önálló funkciót (pl. FK-04 ≠ FK-05).

## Prioritás magyarázat
- **Must**: Nélküle nincs MVP. (FK-01..FK-04)
- **Should**: Értéknövelő, de elhagyható scope-bővítés. (FK-05..FK-07)