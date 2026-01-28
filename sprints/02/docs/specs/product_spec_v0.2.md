# Product Spec v0.2 – PetShop: Közösségi Eseménytér

## Cél
A PetShop MVP célja, hogy a helyi kutyás közösségek számára lehetőséget biztosítson események (séták, találkozók) egyszerű szervezésére. Jelenleg a Facebook csoportok zaja miatt ezek az információk elvesznek; a PetShop egy strukturált, kereshető felületet ad, ahol a gazdik megbízhatóan megtalálják a programokat.

## Scope (In/Out)

### In (A Sprint 2 fókusza - Vertikális Szelet)
* **Események listázása:** A főoldalon megjelennek a feltöltött események (Időpont, Helyszín, Cím).
* **Új esemény beküldése:** Űrlap, amellyel a felhasználó új eseményt hozhat létre.
* **Validáció:** Hibás adatok (pl. múltbeli dátum, üres cím) kezelése szerveroldalon (PHP).
* **Részletes nézet:** Egy eseményre kattintva megjelenik a leírás és a "Jelentkezés" gomb (statikus).
* **Üres és Hiba állapotok:** Ha nincs adat, vagy adatbázis hiba van, a rendszer szépen kezeli.

### Out (Későbbi sprintek)
* Felhasználói regisztráció/bejelentkezés (most mindenki "vendég" vagy egyszerűsített user).
* Események moderálása/admin felület.
* Térképes integráció (Google Maps).
* Komplex jogosultságkezelés (ki fogadhat el jelentkezést).

## User Story térkép
* **US-01:** Üres állapot (Első látogatás élménye)
* **US-02:** Új esemény létrehozása (Sikeres mentés)
* **US-03:** Érvénytelen adatbevitel kezelése (Validáció)
* **US-04:** Eseménylista böngészése
* **US-05:** Esemény részleteinek megtekintése

## NFR (Nem-funkcionális követelmények)
* **NFR-1:** A szerveroldali válaszidő (TTFB) < 500ms (PHP renderelésnél).
* **NFR-2:** Az adatbázis kapcsolat hibája esetén a felhasználó "barátságos" hibaüzenetet kapjon, ne stack trace-t.
* **NFR-3:** A CI folyamatban a smoke tesztek aránya 100% (minden deploy után fusson le).

## Fő AC-k (Kritikus folyamat)
* **AC1 (Létrehozás):** Ha a felhasználó kitölti az űrlapot valid adatokkal, az esemény mentésre kerül az adatbázisba, és a felhasználó visszakerül a listához egy "Sikeres mentés" üzenettel.
* **AC2 (Lista):** A lista időrendi sorrendben mutatja az eseményeket, a lejárt eseményeket automatikusan nem listázza (vagy külön jelöli).