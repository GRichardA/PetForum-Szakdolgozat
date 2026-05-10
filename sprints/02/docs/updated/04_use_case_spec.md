# Use Case specifikáció

## Use case lista
| ID | Név | Aktor | Rövid cél | Prioritás | Érintett követelmények |
|---|---|---|---|---|---|
| UC-01 | Felhasználó bejelentkezése | Vendég | Hozzáférés saját funkciókhoz | Must | FK-01 |
| UC-02 | Kisállat létrehozása / szerkesztése / törlése | Bejelentkezett user | Gazdi kezelje saját kisállatait | Must | FK-02 |
| UC-03 | Esemény létrehozása (pet-szabályok) | Szervező | Rendezvény admin megadja feltételeket | Must | FK-03 |
| UC-04 | Kisállattal történő regisztráció eseményre | User | Gazdi regisztrálja kisállatát eseményre | Must | FK-04 |
| UC-05 | Regisztráció törlése / lemondás | User | Gazdi törli saját regisztrációját | Should | FK-04 |
| UC-06 | Admin moderáció | Admin | Hibás tartalom eltávolítása | Should | NFK-ADMIN |

## Use case részletes lap (példa: UC-04)
| Mező | Tartalom |
|---|---|
| ID | UC-04 |
| Név | Kisállattal történő regisztráció eseményre |
| Elsődleges aktor | Bejelentkezett gazdi |
| Előfeltétel | Létezik esemény; felhasználónak van legalább egy pet-je |
| Trigger | A felhasználó az esemény "Regisztráció" gombját megnyomja |
| Fő sikeres lefutás | 1. Gazdi kiválasztja a pet-et; 2. Szerver ellenőrzi: típus és fajta engedélyezett-e; 3. Ha oltottság szükséges, ellenőrzi `isVaccinated()`; 4. Kapacitás ellenőrzése; 5. Regisztráció létrejön; 6. Visszaigazoló üzenet megjelenik |
| Alternatív lefutás | - Nem engedélyezett fajta → hibaüzenet; - Kapacitás megtelt → várólista üzenet; - Pet nem az adott useré → 403 |
| Utófeltétel | Regisztrációt hoztunk létre, státusz `registered` |
| Tesztek | TC-04, TC-05, TC-06 |

---

Minden use case-hez rövid tesztidők és prioritás társítva — következő körben automata teszteseteket javaslom íratni a kritikus UC-kre.