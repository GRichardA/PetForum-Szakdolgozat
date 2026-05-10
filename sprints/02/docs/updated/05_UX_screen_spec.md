# UX és képernyőspecifikáció

## Design célok
- Egységes, magyar nyelvű felület és rövid, egyértelmű állapotüzenetek.
- Kiemelt fókusz: regisztrációs folyamat egyszerűsítése (pet selector), hibamegelőzés (validációk a formon).

## Képernyőspecifikáció (fő képernyők)
| Képernyő ID | Név | Cél | Fő elemek | Kapcsolódó use case | Állapotok | Hibák és üzenetek | Akadálymentességi szempont |
|---|---|---|---|---|---|---|---|
| SCR-LOGIN | Bejelentkezés | Felhasználó azonosítása | email, jelszó, belépés | UC-01 | üres, valid, invalid, loading | hibás e-mail/jelszó | label, fókusz, kontraszt |
| SCR-PETS | Saját kisállatok | Pet lista és CRUD | lista, új pet, szerkeszt, törlés | UC-02 | üres, lista, szerkeszt | név kötelező, fajta kötelező | billentyűzet-navigáció |
| SCR-EVENTS-LIST | Eseménylista | Böngészés | esemény kártyák, keresés, filter (kategória) | UC-03 | betöltés, üres, listázott | - | kontraszt, kártya min. méret |
| SCR-EVENT-DETAIL | Esemény részletek | Regisztráció pet-tel | részletek, pet-selector, regisztráció gomb | UC-04 | nyitott, zárt, telített | "Nincs engedélyezett pet" | fókusz a regisztrációs űrlapon |
| SCR-ADMIN | Admin panel | Moderáció | események listája, törlés, módosítás | UC-06 | lista, művelet végrehajtva | művelet visszaigazolása | role-based access |

## UX validáció
- Javasolt manuális feladatok: 1) Pet létrehozása és regisztráció eseményre; 2) Regisztráció visszamondása; 3) Admin törlés. 
- Gyűjts 2-3 felhasználói megjegyzést és iterálj a hibák megjelenítésén (pl. fajta nem engedélyezett → javasolt alternatíva megjelenítése).

---

Következő: készítem az adatmodell-sablont és a biztonsági minimumot.