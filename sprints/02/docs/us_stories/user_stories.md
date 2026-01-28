# User Stories & Acceptance Criteria (Sprint 2)

A Sprint 2 célja a közösségi események kezelésének (CRUD) megvalósítása.

### US-01: Üres állapot megjelenítése
Mint új látogató, szeretném látni, ha még nincsenek események a rendszerben, de tudni akarom, hogyan adhatok hozzá egyet.

**AC1 – Nincs adat**
* **Given** az adatbázis `events` táblája üres
* **When** megnyitom a `/events` (vagy főoldal) útvonalat
* **Then** a "Jelenleg nincsenek események" üzenetet látom
* **And** megjelenik egy feltűnő "Esemény létrehozása" gomb.

---

### US-02: Új esemény létrehozása (Happy Path)
Mint szervező gazdi, szeretnék eseményt hirdetni, hogy mások is csatlakozhassanak.

**AC1 – Sikeres mentés**
* **Given** a `/events/create` űrlapon vagyok
* **When** kitöltöm a mezőket (Cím: "Kutyaséta", Dátum: "Jövő hét", Helyszín: "Városliget")
* **And** rákattintok a "Mentés" gombra
* **Then** az adatbázisba bekerül az új rekord
* **And** átirányítanak a listára, ahol megjelenik a "Sikeres mentés" zöld üzenet.

---

### US-03: Érvénytelen adatbevitel (Validáció)
Mint felhasználó, szeretnék visszajelzést kapni, ha rosszul töltöttem ki az űrlapot, hogy javíthassam.

**AC1 – Kötelező mezők**
* **Given** az űrlapon vagyok
* **When** üresen hagyom a "Cím" mezőt és megpróbálok menteni
* **Then** nem történik adatbázis mentés
* **And** az űrlap újratöltődik a beírt adatokkal
* **And** a "Cím" mező alatt piros hibaüzenet jelzi: "A cím megadása kötelező".

**AC2 – Múltbeli dátum**
* **Given** az űrlapon vagyok
* **When** tegnapi dátumot adok meg esemény időpontnak
* **Then** validációs hibaüzenetet kapok: "Az esemény nem lehet a múltban".

---

### US-04: Eseménylista megjelenítése
Mint gazdi, látni akarom az elérhető programokat, hogy választhassak közülük.

**AC1 – Adatok megjelenítése**
* **Given** van 3 jövőbeli esemény az adatbázisban
* **When** megnyitom a listát
* **Then** mind a 3 esemény kártyája megjelenik
* **And** minden kártyán látszik a: Cím, Időpont és Helyszín.

---

### US-05: Adatbázis hiba kezelése (Tech Story)
Mint üzemeltető, szeretném, ha adatbázis leállás esetén a felhasználó nem látna technikai kódokat.

**AC1 – Graceful Degradation**
* **Given** az SQL szerver nem elérhető
* **When** a felhasználó megnyitja az oldalt
* **Then** egy "A szolgáltatás átmenetileg nem elérhető, kérjük próbáld később" üzenet jelenik meg (HTTP 500 vagy 503), stack trace nélkül.