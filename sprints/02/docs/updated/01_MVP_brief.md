# MVP Brief

## 1. Probléma és cél
- Megoldandó probléma: Kisállatos közösségi eseménykezelő egyszerű, magyar nyelvű MVP: a gazdik létrehozhatnak eseményeket, megadhatnak kisállat-specifikus szabályokat (állat típus, engedélyezett fajták, oltottság, kapacitás), és más gazdik regisztrálhatnak saját kisállataikkal.
- Célfelhasználók: hobbiállat-tulajdonosok (kutya/macska/madár/nyúl), rendezvényszervezők kis közösségekben, állatvédő szervezetek.
- A termék ígérete: egyszerű, megbízható regisztrációs folyamat kisállat-specifikus validációval és admin moderációval magyar nyelven.

## 2. MVP határ
| Elem | MVP-ben benne van? | Indoklás | Elfogadási jel |
|---|---:|---|---|
| Felhasználói belépés | igen | alapfunkciókhoz szükséges | sikeres bejelentkezés/session kezelése |
| Kisállat CRUD (User-owned) | igen | eseményregisztrációhoz elengedhetetlen | felhasználó létrehoz, szerkeszt, töröl kisállatot |
| Esemény CRUD | igen | rendezvények publikus listája és részletek | esemény létrehozás pet-szabályokkal |
| Regisztráció kisállattal | igen | core feature | pet-ellenőrzés + regisztráció létrejön |
| Admin moderáció | részben | események és kategóriák kezelése | admin törölheti rendezvényeket és kategóriákat |
| Email verification | nem | scope-bővítésként később | - |
| Ajánlórendszer / AI javaslatok | nem | scope out, később építhető | - |

## 3. Nem célok
- Fizetési rendszerek, bonyolult hírfolyam/ajánlások, multi-tenant architektúra.

## 4. Sikerességi mérőszámok
| Mérőszám | Célérték | Mérés módja |
|---|---:|---|
| Kritikus use case-ek teljesítése | 100% | automatizált tesztek (phpunit) |
| Teljes automatizált teszt lefedettség | 71 pass | `php artisan test --env=testing` |
| Reprodukálható telepítés | igen | `migrate:fresh --seed` siker |
| Alap UX validáció | 3 manuális felhasználói teszt | demo forgatókönyv teljesítése |

---

Következő lépés: részletes use case-ok és UX képernyőspecifikáció elkészítése.