# 0001: Kezdeti technológiai stack kiválasztása

- Dátum: 2025-10-25
- Státusz: Elfogadva

## Kontextus
A PetShop weboldal MVP-jének (Minimum Viable Product) elsődleges célja a tartalom és adatok gyors kezelése (helyi szolgáltatók listája, események, blogcikkek). A gyors adminisztrációs felület elengedhetetlen a naprakész szolgáltatói adatok biztosításához (az interjúk alapján kritikus szempont). A fejlesztő csapata erős PHP/MySQL tapasztalattal rendelkezik, ami gyors prototípuskészítést tesz lehetővé a kezdeti fázisban.

## Döntés
A backend alapját PHP-re építjük, tiszta architektúra (pl. Laravel keretrendszer) alkalmazásával, és MySQL/MariaDB-t választunk elsődleges adatbázisként. A frontend statikus részekhez HTML-t és alapszintű JavaScript-et használunk, a későbbi reaktivitás érdekében megőrizve a könnyű áttérést modern könyvtárakra.

## Megfontolt alternatívák
React / Vue.js + Node.js (Express): Kiváló választás lenne a modern, reaktív felhasználói felülethez (UX). Azonban a különálló frontend és backend miatt növeli az MVP fejlesztési idejét, és a szükséges adminisztrációs felületet (szolgáltatók kezelése) külön kellene felépíteni (a PHP keretrendszerek ezt gyorsabban biztosítják).

Python / Django: Kiemelkedő beépített admin felülettel rendelkezik, ami ideális a tartalomkezeléshez. A választás oka az elvetésre a meglévő csapattudás hiánya Pythonban (feltételezve, hogy a fejlesztő a PHP-t ismeri jobban), ami lassítaná a kezdeti fázist.

Speciális adatbázis / szerver (pl. MongoDB / AWS RDS): Bár a PostgreSQL jobb lehet bizonyos térbeli lekérdezésekhez, a MySQL egyszerűbb kezelhetősége és a rendelkezésre álló szerverekkel (pl. standard LAMP stack) való könnyű kompatibilitása miatt előnyt élvez az MVP fázisban.

## Következmények
Pozitív: A PHP/MySQL/HTML stack gyors és költséghatékony telepítést és fejlesztést tesz lehetővé a meglévő szaktudásra alapozva. A tartalomkezelő rendszerek (pl. Laravel Admin) egyszerűen implementálhatók.

Negatív: A natív HTML/PHP stack kezdetben nem biztosít modern, reaktív UX-et a térképes keresésnél és a szűrésnél. Ez a korlát a későbbi sprintekben szükségessé teheti a React/Vue.js könyvtárak beemelését a frontend kritikus részeire.

További lépések: Az első fejlesztési sprintben (Sprint 2) a választott PHP keretrendszer bemutatására kerül sor, amely a tartalom adminisztrációját is.
