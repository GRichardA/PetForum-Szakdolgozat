# Szakdolgozat Vázlat és Adatgyűjtés

Projekt: PetForum
Szerző: [A te neved]
Dátum: 2026-05-02

Ez a dokumentum nem a végleges szakdolgozat, hanem egy részletes adatgyűjtő és szerkesztő vázlat. Az a célja, hogy összeszedje mindazt a tényszerű, hivatkozható és kibővíthető információt, ami egy 50-60 oldalas szakdolgozat megírásához felhasználható. A dokumentum magyar nyelvű, a szakmai rövidítések, technológiák és nevezéktanok angolul maradnak, ahol ez a szokásos.

## 1. Címoldalhoz szükséges adatok

- Címjavaslat: PetForum - közösségi eseménykezelő és kommentelhető webalkalmazás Laravel alapon
- Intézmény: [ide kerül az intézmény neve]
- Kar / szak: [ide kerül]
- Neptun / azonosító: [ide kerül]
- Témavezető: [ide kerül]
- Készítés helye és éve: [ide kerül]

## 2. Rövid összefoglalóhoz felhasználható alap

A PetForum egy közösségi webplatform, amely helyi állattartó közösségek számára teszi lehetővé események létrehozását, keresését, megjelenítését és kommentelését. A rendszer célja, hogy egy egyszerű, gyorsan használható, moderálható felületet biztosítson eseményekhez, profilkezeléshez, avatárokhoz és adminisztratív műveletekhez. A projekt Laravel alapokon készült, Blade sablonokkal és MySQL adattárolással.

## 3. Bevezetéshez felhasználható tartalom

### 3.1 Problémafelvetés
- Helyi állattartó közösségeknek nehéz megtalálni és szervezni helyi eseményeket.
- A tipikus közösségi platformok túl általánosak, ezért a helyi események, találkozók, vásárok és oltási akciók kezelése nem elég célzott.
- A felhasználóknak olyan felület kell, ahol eseményt tudnak létrehozni, keresni, moderálni és megvitatni.

### 3.2 Célcsoport
- Anna, 28 éves macskatartó: eseményeket szervezne, meghívókat szeretne kezelni, kommenteket moderálni.
- Gábor, 42 éves kutyatartó: témák, aktivitások és kategóriák alapján keresne eseményeket.

### 3.3 A projekt célja
- Egyszerű, gyors, közösség-orientált webes platform megvalósítása.
- Legyen alkalmas események létrehozására, keresésére, kommentelésére és moderálására.
- Legyen jól tesztelt, dokumentált, és szakdolgozatban bemutatható módon reprodukálható.

## 4. Vízió és termékcélok

Forrás: [docs/01_product/vision.md](01_product/vision.md)

- Értékajánlat: gyors, könnyen használható webes platform helyi állatközösségek eseményeinek létrehozására, keresésére és megbeszélésére.
- North Star metrika: havi aktív eseményteremtők száma.
- Guardrail metrikák:
  - event creation success rate >= 95%
  - event listing p95 load < 300 ms (korai cél / smoke baseline)
- Non-goal:
  - mobil natív alkalmazás nem cél
  - teljes Google Maps / fizetési integráció nem cél

## 5. Scope Contract és MVP

Forrás: [docs/01_product/scope_contract.md](01_product/scope_contract.md)

### 5.1 MVP user storyk
1. Autentikált felhasználó eseményt hoz létre cím, dátum, helyszín és kategória megadásával.
2. Felhasználó eseményeket keres cím és leírás alapján, illetve kategória szerint szűr.
3. Bejelentkezett felhasználó kommentelhet és egy szint mélységű választ írhat.
4. Admin kommenteket moderálhat, törölhet.
5. Felhasználó szerkesztheti profilját és avatart tölthet fel.

### 5.2 Kiterjesztések / stretch célok
- RSVP / résztvevő kezelés
- e-mail értesítések esemény létrehozásról

### 5.3 Korlátok
- Lokális demo/prototípus
- Nincs cloud üzemeltetés
- Nincs bonyolult külső integráció

### 5.4 Definition of Done
- Minden user storyhoz van automata teszt
- CI zöld
- README quickstart működik
- Dokumentáció rendelkezésre áll

## 6. A rendszer fő képességei

Források:
- [docs/01_product/capability_evidence_map.md](01_product/capability_evidence_map.md)
- [docs/03_design/ux_flows.md](03_design/ux_flows.md)
- [docs/03_design/data_model.md](03_design/data_model.md)

### 6.1 Fő funkciók
- Auth: regisztráció, bejelentkezés, kijelentkezés
- Event CRUD: létrehozás, lista, részletek, szerkesztés, törlés
- Keresés és kategória-szűrés
- Kommentek és válaszok hierarchikus megjelenítése
- Komment törlés: saját kommentet a user, bármely kommentet az admin
- Admin panel: kategória CRUD és event moderálás
- Profil szerkesztés és avatar kezelés
- Sötét módhoz igazított UI

### 6.2 Jelenlegi aktuális admin képességek
- Admin dashboard
- Kategória létrehozás, szerkesztés, törlés
- Események moderálása, törlése
- Kommentek törlése, ha jogosult a felhasználó

## 7. Szakdolgozatban leírható felhasználói történetek

### 7.1 Felhasználói oldal
- Események listázása és keresése
- Esemény részleteinek megtekintése
- Hozzászólás és válasz írása
- Saját komment törlése
- Profil módosítása, avatár feltöltése

### 7.2 Admin oldal
- Kategóriák kezelése
- Események moderálása
- Bármely komment törlése
- Jogosultsági ellenőrzés

### 7.3 Negatív útvonalak
- Vendég ne férjen hozzá védett műveletekhez
- Érvénytelen adat validációs hibát okozzon
- Nem jogosult felhasználó 403 választ kapjon
- Hiányzó erőforrás 404-et adjon

## 8. Technológiai stack

Források:
- [README.md](../code/README.md)
- [docs/02_architecture/README.md](02_architecture/README.md)
- [docs/04_quality/test_report.md](04_quality/test_report.md)

### 8.1 Backend
- PHP 8.2+
- Laravel 12
- Eloquent ORM
- Controller + Model + Middleware alapú felépítés

### 8.2 Frontend
- Blade template rendszer
- Tailwind CSS
- Theme switching és dark mode támogatás
- JavaScript a felületi interakciókhoz, például jelszó láthatóság és színelőnézet

### 8.3 Adatbázis
- MySQL
- Migrációk és seederek
- Relációk: users, events, categories, comments

### 8.4 Fejlesztési környezet
- Windows
- XAMPP
- Local PHP artisan futtatás
- Composer alapú csomagkezelés

## 9. Architektúra vázlat

Források:
- [docs/02_architecture/README.md](02_architecture/README.md)
- [docs/02_architecture/quality_attributes.md](02_architecture/quality_attributes.md)
- [docs/02_architecture/c4_context.mmd](02_architecture/c4_context.mmd)
- [docs/02_architecture/c4_container.mmd](02_architecture/c4_container.mmd)

### 9.1 Koncepcionális architektúra
- Felhasználó böngészőből éri el a webalkalmazást.
- Laravel kezeli a web és API útvonalakat.
- MySQL tárolja az üzleti adatokat.
- A renderelés döntően szerveroldali Blade sablonokkal történik.

### 9.2 Konténer szintű elemek
- Web UI
- Application layer (Controllers, Middleware, Form validation)
- Domain / Model layer (Event, Comment, Category, User)
- Database layer
- Storage layer avatárokhoz és feltöltésekhez

### 9.3 Minőségi attribútumok
- Security
- Performance
- Reliability
- Maintainability
- Observability
- Data integrity

### 9.4 Kiemelt architekturális döntések
- Laravel session auth használata
- Blade + Tailwind választás frontendhez
- Admin role middleware alapján
- Kommentfa rekurzív kezelés
- Health endpointok üzemeltetési célra

## 10. Adatmodell és tartalmi elemek

Forrás: [docs/03_design/data_model.md](03_design/data_model.md)

### 10.1 Fő entitások
- users
- categories
- events
- comments

### 10.2 Entitásleírások

#### users
- Név, e-mail, jelszó, avatar, avatar_choice, is_admin
- is_admin alapértelmezés szerint false

#### categories
- Név, slug, color_code
- Kategória a kereséshez és megjelenítéshez

#### events
- title
- event_date
- location
- description
- user_id
- category_id

#### comments
- event_id
- user_id
- parent_id
- body
- Hierarchikus kommentfa támogatása

### 10.3 Kapcsolatok
- User -> many Events
- Category -> many Events
- Event -> many Comments
- User -> many Comments
- Comment -> many child Comments

### 10.4 Integritási szabályok
- idegen kulcsok
- kaszkádos törlési logika bizonyos kapcsolatoknál
- kommenteknél parent-child rekurzív törlés

## 11. Felhasználói folyamatok és UX

Forrás: [docs/03_design/ux_flows.md](03_design/ux_flows.md)

### 11.1 Esemény felfedezés és szűrés
- /events listaoldal
- kategória szűrő
- keresőmező
- üres állapot kezelése

### 11.2 Regisztráció és bejelentkezés
- /register
- /login
- hibák kezelése: duplikált e-mail, rossz jelszó

### 11.3 Event létrehozás
- /events/create
- title, category, date, location, description
- validáció

### 11.4 Tulajdonosi műveletek
- szerkesztés, törlés
- non-owner tiltás

### 11.5 Komment és válasz folyamat
- /events/{event}
- komment írás
- válasz írás egy szint mélységben
- kommentfa megjelenítése

### 11.6 Profil és avatar kezelés
- név, e-mail, jelszó módosítás
- avatar feltöltés
- default avatar választás

### 11.7 Kommentelemek törlése
- user törli saját kommentjét
- admin törli bármely kommentet
- child kommentek is törlődnek

## 12. Implementációs részletek, amiket érdemes leírni

### 12.1 Auth és jogosultság
- session auth alapú bejelentkezés
- auth middleware a védett útvonalakra
- is_admin middleware az admin panelhez
- comment owner / admin alapú törlési jogosultság

### 12.2 Admin panel
- dashboard statisztikákkal
- kategória CRUD
- esemény moderálás
- admin felhasználó seedelve

### 12.3 Kommentkezelés
- komment mentés form alapján
- parent_id alapú válaszok
- rekurzív gyerek kommentek
- törléskor az egész ág eltűnik

### 12.4 Event model és dátumkezelés
- event_date datetime cast
- Carbon alapú formázás
- admin view-ban is kezelve a dátum megjelenítés

### 12.5 UI és dark mode
- sötét módban javított olvashatóság
- admin gombok és szövegek kontrasztja
- form inputok és színválasztók

### 12.6 Avatar kezelés
- upload és default choice
- avatar_url accessor a User modellen
- storage link és fájlkiszolgálás

## 13. Minőség és tesztelés

Források:
- [docs/04_quality/test_strategy.md](04_quality/test_strategy.md)
- [docs/04_quality/test_report.md](04_quality/test_report.md)
- [docs/04_quality/performance.md](04_quality/performance.md)

### 13.1 Tesztelési stratégia
- PHPUnit a Laravel alapértelmezett tesztelője
- Feature tesztek a fő felhasználói útvonalakra
- Unit tesztek a modellekre
- Performance smoke teszt a listázási teljesítményre

### 13.2 Aktuális tesztállapot
- Legutóbbi teljes futás: 67 passed
- Hibák száma: 0
- Szándékos skip nincs

### 13.3 Tesztkategóriák
- AuthTest
- EventTest
- CommentTest
- AdminTest
- ProfileTest
- AvatarUploadTest
- CategoryTest
- MiddlewareTest
- UserTest
- EventTest (unit)
- ApiContractTest

### 13.4 Minőségi megállapítások
- A fő CRUD utak tesztelve vannak
- A komment hierarchia és törlés külön tesztelve van
- A jogosultságok több szinten vizsgálva vannak
- A browser-level E2E még fejleszthető

### 13.5 Teljesítmény
- p95-like smoke limit: 800 ms
- 120 eventtel is fut a smoke teszt
- Ez baseline, nem production benchmark

## 14. Biztonság, adatvédelem és jogosultság

Források:
- [docs/05_security_ops/threat_model.md](05_security_ops/threat_model.md)
- [docs/05_security_ops/privacy_licensing.md](05_security_ops/privacy_licensing.md)
- [docs/03_design/error_handling.md](03_design/error_handling.md)

### 14.1 Fenyegetési modell fő pontjai
- session cookie ellopás
- manipulált request
- jogosultság-eskaláció
- információszivárgás logokban
- DoS egyszerű endpointokon

### 14.2 Védekezési mechanizmusok
- auth middleware
- role check middleware
- validáció
- hashed password
- APP_DEBUG=false éles környezetben
- log fegyelem
- health endpoint monitorozás

### 14.3 Adatvédelmi szempontok
- e-mail, jelszó hash, avatar path, session meta adatok
- nincs fizetés, nincs különleges személyes adat
- törléshez kapcsolódó baseline workflow dokumentálva

### 14.4 Jelenlegi security állapot
- composer audit még jelzett advisoriakat a korábbi státuszban
- npm audit lokálisan nem futott, mert npm nem volt elérhető
- ezek a szakdolgozatban külön korlátozásként vagy további munkaként szerepeltethetők

## 15. Üzemeltetés és observability

Források:
- [docs/observability_and_deploy.md](observability_and_deploy.md)
- [docs/05_security_ops/deploy_runbook.md](05_security_ops/deploy_runbook.md)

### 15.1 Health és ellenőrzések
- /health
- /api/v1/health
- DB és storage ellenőrzés

### 15.2 Logging
- single
- daily
- json
- request_id, user_id, route, method, status_code, duration_ms mezők mint javaslat

### 15.3 Deploy baseline
- composer install --no-dev --optimize-autoloader
- php artisan migrate --force
- php artisan config:cache
- php artisan route:cache
- php artisan view:cache

### 15.4 Runbook elemek
- RTO 30 perc
- RPO 24 óra
- SEV-1, SEV-2, SEV-3 osztályozás
- DB és storage incidensek kezelése

### 15.5 Recovery és rollback
- migrate:rollback --step=1
- migrate:reset csak demo/staging esetén
- backup/restore eljárás

## 16. Mérőszámok és eredmények

Forrás: [docs/06_release/metrics.md](06_release/metrics.md)

### 16.1 North Star
- Monthly active event creators

### 16.2 Guardrail metrikák
- event creation success rate
- API p95 latency
- API error rate
- deploy success rate
- open dependency advisories

### 16.3 Jelenlegi baseline
- teszt csomag zöld
- teljesítmény smoke meglévő
- observability baseline dokumentált

## 17. Szakdolgozatba beépíthető konkrét számok

### 17.1 Kódbázis és funkcionalitás
- Laravel 12.x
- PHP 8.2.x
- MySQL
- Blade + Tailwind
- 67 automata teszt a legutóbbi futás szerint
- 0 hibás teszt a legutóbbi futás szerint

### 17.2 Fő funkciók száma
- auth: 3 alapművelet
- event CRUD: 4 alapművelet
- comment flow: létrehozás, válasz, törlés, hierarchia
- admin: kategória CRUD + event moderálás + komment törlés
- profile: profil és avatar kezelése

### 17.3 Dokumentált útvonalak
- /events
- /events/create
- /events/{event}
- /profile
- /admin
- /admin/categories
- /admin/events
- /api/v1/health
- /api/v1/events
- /api/v1/events/{eventId}

## 18. AI használat és verifikáció

Források:
- [docs/07_ai/ai_manifest.md](07_ai/ai_manifest.md)
- [docs/07_ai/prompt_log.md](07_ai/prompt_log.md)
- [docs/07_ai/verification_log.md](07_ai/verification_log.md)

### 18.1 Használt eszközök
- ChatGPT
- GitHub Copilot

### 18.2 Mire használtad az AI-t
- MVP storyk és capability ötletek
- architektúra javaslatok
- kódminták kezdéshez
- dokumentáció vázlatok
- tesztötletek

### 18.3 Mit kell hangsúlyozni a dolgozatban
- az AI nem döntött önállóan kritikus részekről
- minden javaslat manuálisan ellenőrizve lett
- a verifikáció külön logban dokumentált

## 19. Eredmények és következtetések

### 19.1 Mit oldott meg a projekt
- események közösségi kezelése
- kommentelhető interakciós tér
- adminisztratív moderáció
- profil és avatar személyre szabás
- működő tesztelési és üzemeltetési baseline

### 19.2 Miért értékes
- valós, lokális közösségi problémára ad megoldást
- nem csak prototípus, hanem dokumentált és tesztelt rendszer
- a teljes fejlesztési folyamat bizonyítékokkal alátámasztott

### 19.3 Korlátok
- nincs browser-level E2E framework
- nincs coverage riport CI-ben
- bizonyos security advisories még nyitottak lehetnek a dokumentációs baseline szerint
- a projekt lokális/demo fókuszú, nem production deployment

## 20. Jövőbeli fejlesztések

- Browser E2E Playwright vagy Dusk alapokon
- coverage jelentés CI-ben
- dependency advisories folyamatos kezelése
- metric history és trendek
- avatar processing további hardening
- admin policy finomítás
- RSS / e-mail értesítések
- RSVP és részvételi lista

## 21. Mellékletek, amiket később be lehet emelni

### 21.1 Táblázatok
- követelmény-táblázat
- user story tábla
- funkció-bizonyíték tábla
- teszt mátrix
- SLI/SLO tábla

### 21.2 Ábrák
- C4 context diagram
- C4 container diagram
- adatmodell ER diagram
- UX flow diagramok
- screenshotok a fő képernyőkről

### 21.3 Kódrészletek
- auth middleware
- comment controller
- admin controller
- event model cast
- view fragment a comment fa megjelenítéséhez

## 22. Írási terv 50-60 oldalhoz

Javasolt oldalszám-elosztás:
- Bevezetés és problémafelvetés: 4-5 oldal
- Célok, scope, user stories: 4-5 oldal
- Architektúra: 8-10 oldal
- Adatmodell és megvalósítás: 10-12 oldal
- UX és működés: 6-8 oldal
- Tesztelés és minőség: 6-8 oldal
- Biztonság és üzemeltetés: 6-8 oldal
- AI használat és verifikáció: 3-4 oldal
- Következtetések és jövőbeli fejlesztések: 3-4 oldal
- Mellékletek, táblázatok, ábrák: 5-10 oldal

## 23. Íráshoz ajánlott sorrend

1. Bevezetés
2. Vízió és scope
3. Architektúra
4. Adatmodell
5. Implementáció
6. Tesztelés
7. Security és observability
8. AI használat
9. Konklúzió
10. Mellékletek

## 24. Rövid forráslista a dolgozat mellé

- [docs/00_index.md](00_index.md)
- [docs/01_product/vision.md](01_product/vision.md)
- [docs/01_product/scope_contract.md](01_product/scope_contract.md)
- [docs/01_product/capability_evidence_map.md](01_product/capability_evidence_map.md)
- [docs/02_architecture/README.md](02_architecture/README.md)
- [docs/02_architecture/quality_attributes.md](02_architecture/quality_attributes.md)
- [docs/03_design/api.md](03_design/api.md)
- [docs/03_design/data_model.md](03_design/data_model.md)
- [docs/03_design/error_handling.md](03_design/error_handling.md)
- [docs/03_design/ux_flows.md](03_design/ux_flows.md)
- [docs/04_quality/test_strategy.md](04_quality/test_strategy.md)
- [docs/04_quality/test_report.md](04_quality/test_report.md)
- [docs/04_quality/performance.md](04_quality/performance.md)
- [docs/05_security_ops/threat_model.md](05_security_ops/threat_model.md)
- [docs/05_security_ops/privacy_licensing.md](05_security_ops/privacy_licensing.md)
- [docs/05_security_ops/deploy_runbook.md](05_security_ops/deploy_runbook.md)
- [docs/observability_and_deploy.md](observability_and_deploy.md)
- [docs/06_release/demo_script.md](06_release/demo_script.md)
- [docs/06_release/metrics.md](06_release/metrics.md)
- [docs/06_release/self_assessment.md](06_release/self_assessment.md)
- [docs/07_ai/ai_manifest.md](07_ai/ai_manifest.md)
- [docs/07_ai/verification_log.md](07_ai/verification_log.md)

## 25. Záró megjegyzés

Ez a fájl azért készült, hogy egy helyen összegyűjtse mindazt az anyagot, amelyből a végleges szakdolgozat megírható. A következő lépés az lehet, hogy ebből a vázlatból fejezetenként külön szöveget írunk, és a mellékleteket, ábrákat, táblázatokat is véglegesítjük.

## 26. Szakdolgozat-szerű összefoglaló szöveg

A PetForum egy Laravel alapú, közösségi eseménykezelő webalkalmazás, amelyet kifejezetten helyi állattartó közösségek igényeire terveztem. A rendszer célja, hogy egy egyszerűen használható, mégis jól strukturált online felületet biztosítson események létrehozására, keresésére, megjelenítésére és megvitatására. A fejlesztés során arra törekedtem, hogy az alkalmazás ne csupán egy működő prototípus legyen, hanem egy olyan, dokumentált és tesztelt rendszer, amely szakdolgozati szinten is bemutatható.

A projekt központi problémája az volt, hogy a helyi közösségek számára nem áll rendelkezésre egy olyan célzott felület, ahol az állatokhoz kapcsolódó találkozók, vásárok, oltási akciók vagy tematikus programok könnyen kezelhetők lennének. Ezt a hiányt a PetForum úgy próbálja megoldani, hogy az eseményeket kategóriákba rendezi, lehetővé teszi a keresést és szűrést, valamint biztosítja a kommentelést és a válaszok hierarchikus megjelenítését. A felület egyszerre szolgálja a hétköznapi felhasználót, aki eseményeket keres vagy hozzászól, és az adminisztrátort, aki moderálni tudja a közösségi tartalmat.

A rendszer megvalósításánál a Laravel keretrendszer bizonyult a legmegfelelőbb választásnak, mert jól támogatja a gyors fejlesztést, a biztonságos autentikációt, az adatbázis-kezelést, a validációt és a jól szervezett MVC alapú struktúrát. A Blade sablonokkal készült felület egyszerűen karbantartható, a Tailwind CSS pedig lehetővé tette, hogy a felhasználói élmény modern, letisztult és reszponzív legyen. Külön figyelmet kapott a sötét mód, mivel a projekt használatakor ez több helyen olvashatósági problémát okozott, ezért a véglegesített UI kontrasztját célzott CSS szabályokkal javítottam.

A funkcionális oldalhoz tartozik az események teljes életciklusa: létrehozás, listázás, megtekintés, szerkesztés és törlés. Ehhez kapcsolódik a kategóriakezelés, amely az admin felületen keresztül érhető el, valamint a kommentrendszer, amely a közösségi interakció egyik legfontosabb része. A kommentek esetében nemcsak az írás és megjelenítés, hanem a törlés is megvalósult, mégpedig úgy, hogy a felhasználó a saját hozzászólását, az admin pedig bármelyik hozzászólást törölhesse. A hierarchikus kommentfa kezelésénél fontos tervezési szempont volt, hogy egy szülő komment törlése automatikusan magával vonja az összes kapcsolódó gyermek komment eltávolítását is.

A projekt része továbbá a profilkezelés és az avatárkezelés is. A felhasználók saját profiladataikat módosíthatják, jelszót frissíthetnek, illetve képesek egyéni avatárt feltölteni vagy előre definiált alapértelmezett avatárt választani. Ez a funkció nemcsak a személyre szabhatóságot növeli, hanem a közösségi jellegű használatot is erősíti. Mindezt kiegészíti az adminisztratív vezérlőfelület, ahol kategóriák létrehozása, szerkesztése és törlése, valamint események moderálása valósul meg.

A fejlesztés során különösen fontos volt a minőségbiztosítás. A rendszerhez kiterjedt tesztkészlet készült, amely lefedi az autentikációt, az események működését, a kommentelést, a jogosultsági szabályokat, az admin funkciókat, a profilkezelést és a modellek viselkedését is. A legutóbbi teljes futás alapján 67 automata teszt sikeresen lefutott, ami jó alapot ad a további bővítéshez és a regressziók elkerüléséhez. A tesztelés mellett operációs dokumentáció is készült, amely tartalmazza az üzembe helyezési lépéseket, a health endpointok szerepét, a logolás alapjait, valamint a rollback és incidenskezelési szabályokat.

Az alkalmazás egyes tervezési döntései tudatos kompromisszumok eredményei. A projekt nem mobilalkalmazásként, hanem webes MVP-ként készült, mivel a cél az volt, hogy a lehető legkevesebb komplexitással egy jól bizonyítható, stabil és átlátható rendszer jöjjön létre. A használati esetek és az architektúra így szorosan kapcsolódnak egymáshoz: a termékvízió, a scope contract, a UX flow-k, a data model, a quality attributes, a test strategy és a security dokumentumok együtt adják a rendszer teljes szakmai leírását.

### 26.1 Ide illő ábrák és képek helye

Az alábbi helyeken érdemes a végleges szakdolgozatba diagramokat és képernyőképeket beszúrni:

- Ide illik a rendszer kontextusdiagramja.
- Ide illik a konténerdiagram, amely megmutatja a böngésző, a Laravel alkalmazás és az adatbázis kapcsolatát.
- Ide illik az ER diagram, amely az users, events, categories és comments táblák kapcsolatát mutatja.
- Ide illik az eseménylista oldal képernyőképe.
- Ide illik az esemény részletező oldal képernyőképe.
- Ide illik az admin dashboard képernyőképe.
- Ide illik a kategóriakezelő felület képernyőképe.
- Ide illik a kommentfa és a törlés gombokat bemutató képernyőkép.
- Ide illik a profiloldal és avatárkezelés képernyőképe.

### 26.2 Javasolt képjelölések a végleges dokumentumhoz

Ha később elkészülnek a képek, az alábbi típusú ábrákat érdemes beilleszteni:

- 1. ábra: PetForum rendszerkörnyezet
- 2. ábra: C4 konténerdiagram
- 3. ábra: Adatmodell ER diagram
- 4. ábra: Eseménylista és szűrés
- 5. ábra: Esemény részletek kommentekkel
- 6. ábra: Admin irányítópult
- 7. ábra: Komment törlés és válaszkezelés
- 8. ábra: Profil szerkesztés és avatár választás

## 27. Rövid, bekezdéses dolgozatszöveg minta

A PetForum fejlesztésének középpontjában egy valós, jól körülírható közösségi probléma állt: a helyi állattartó közösségek számára nem állt rendelkezésre olyan célzott webes felület, amely egyszerre támogatja az események létrehozását, a keresést, a kommentelést és az adminisztratív moderációt. A projekt ezt a hiányt egy Laravel alapú rendszerrel pótolja, amely a szerveroldali logikát, az adatkezelést és a felhasználói felületet egységes struktúrában kezeli.

A megvalósítás során az alkalmazás fő funkciói a felhasználói szerepek mentén kerültek kialakításra. Az autentikált felhasználók eseményeket hozhatnak létre, szerkeszthetnek és kommentelhetnek, míg az adminisztrátorok külön kezelőfelületet kapnak a kategóriák karbantartására és az események moderálására. A kommentrendszer külön figyelmet kapott, mivel a felhasználói interakció egyik legfontosabb eleme. A hozzászólások hierarchikus szerkezete lehetővé teszi a válaszok megjelenítését, a törlési logika pedig biztosítja, hogy a kapcsolódó gyermek kommentek se maradjanak árván a rendszerben.

A projekt nemcsak funkcionális, hanem minőségi szempontból is dokumentált. A tesztkészlet lefedi az alapvető felhasználói folyamatokat, a jogosultsági határokat, a modellek viselkedését és a kommentkezelést is. Az üzemeltetéshez kapcsolódóan health endpointok, logolási baseline, deploy runbook és security/threat model dokumentumok is készültek. Ennek eredményeként a PetForum nemcsak egy alkalmazás, hanem egy bizonyítékokkal alátámasztott fejlesztési és dokumentációs csomag is, amely alkalmas szakdolgozati bemutatásra.

## 28. Következő szerkesztési lépés javaslat

Ha ezt a fájlt végleges dolgozat alapjául használjuk, akkor a következő lépés az lehet, hogy fejezetenként külön kifejtjük az alábbi részeket:

1. Bevezetés és problémafelvetés.
2. Szakirodalmi és technológiai háttér.
3. Követelményanalízis és scope.
4. Architektúra és rendszertervezés.
5. Megvalósítás részletei.
6. Tesztelés és minőségbiztosítás.
7. Üzemeltetés, biztonság és adatvédelem.
8. AI használat és verifikáció.
9. Összegzés és továbbfejlesztési lehetőségek.
