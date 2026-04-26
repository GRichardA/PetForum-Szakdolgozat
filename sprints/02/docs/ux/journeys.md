# A 3 legfontosabb felhasználói út (User Journey)

**Dátum:** 2026-04-25

---

## 1. Út – Új felhasználó létrehozza az első eseményét

**Perszóna:**
* Egy helyi szervező, aki gyorsan közzé szeretne tenni egy új eseményt.

**Belépési pont:**
* Deep link az S01-re (/register), majd automatikus vagy manuális bejelentkezés.

**Lépések:**
1. **S01** – A felhasználó regisztrál névvel, e-mail címmel és jelszóval.
    * **Rendszerválasz:** Fiók létrehozva vagy validációs hibák.
    * **Hibaág:** Duplikált e-mail cím megakadályozza a regisztrációt.
2. **S02** – A felhasználó látja az eseménylistát, és a létrehozás műveletet választja.
    * **Rendszerválasz:** Navigálás az S03-ra.
3. **S03** – A felhasználó kitölti az esemény mezőit és beküldi.
    * **Rendszerválasz:** Esemény mentve, átirányítás az S06-ra vagy S04-re.
    * **Hibaág:** Hiányzó cím vagy érvénytelen kategória esetén mezőszintű hibák jelennek meg.
4. **S04** – A felhasználó megnyitja az esemény részleteit és ellenőrzi a tartalmat.
    * **Siker kritériuma:** Az esemény látható a helyes metaadatokkal.

**Becsült időtartam:**
* 60–120 másodperc, körülbelül 8–12 interakció.

---

## 2. Út – Visszatérő felhasználó hozzászól egy eseményhez

**Perszóna:**
* Egy közösségi tag, aki reagálni szeretne egy listázott eseményre.

**Belépési pont:**
* S02 a kezdőlapról (/events).

**Lépések:**
1. **S02** – A felhasználó megkeresi/kiválasztja az esemény kártyáját.
    * **Rendszerválasz:** Megnyílik az S04.
2. **S04** – A felhasználó megírja a hozzászólást és beküldi.
    * **Rendszerválasz:** A hozzászólás megjelenik a szálban.
    * **Hibaág:** Az üres hozzászólás elutasításra kerül.
3. **S04** – A felhasználó válaszol egy meglévő hozzászólásra.
    * **Rendszerválasz:** A válasz beágyazódik a szülő hozzászólás alá.
    * **Hibaág:** Érvénytelen szülő ID esetén elutasítva.

**Siker kritériuma:**
* A hozzászólás és az opcionális válasz is látható, és a felhasználóhoz van kötve.

**Becsült időtartam:**
* 30–75 másodperc, körülbelül 4–7 interakció.

---

## 3. Út – Felhasználó frissíti a profilját és az avatarját

**Perszóna:**
* Bejelentkezett felhasználó, aki frissíti a személyazonosságát és a profilképét.

**Belépési pont:**
* Profil link az S05-re (/profile).

**Lépések:**
1. **S05** – A felhasználó szerkeszti a megjelenített nevét/e-mail címét és opcionálisan a jelszavát.
    * **Rendszerválasz:** Validáció vagy sikeres mentés.
2. **S05** – A felhasználó feltölt egy avatart vagy alapértelmezett képet választ.
    * **Rendszerválasz:** Kép feldolgozva, profil frissítve.
    * **Hibaág:** Érvénytelen fájltípus vagy méret esetén sikertelen.
3. **S02** – A felhasználó visszatér a főképernyőre, és ellenőrzi az avatart a felületen.

**Siker kritériuma:**
* A frissített profiladatok és az avatar konzisztensen megjelennek.

**Becsült időtartam:**
* 45–90 másodperc, körülbelül 5–9 interakció.