# Architektúra és ADR (Architectural Decision Records)

## Fő minőségi célok

| Attribútum | Elvárás | Következmény a tervben |
|---|---|---|
| **Biztonság** | Jogosultság (pet ownership) és adatvédelem (saját adatok) | Eloquent Policy/ownership-check, FormRequest validáció, CSRF middleware |
| **Karbantarthatóság** | Jól elkülönülő rétegek és modulok | Controller→Service→Model, FormRequest validation, Seeders |
| **Tesztelhetőség** | Automatizálható ellenőrzések | PHPUnit Feature+Unit tesztek, RefreshDatabase, szeparálható Service logika |
| **Reprodukálhatóság** | Tiszta gépről futtatható | Docker-ready (opcionális), migrate:fresh --seed, .env.example |
| **Skalázhatóság** | Későbbi növekedéshez prepare | JSON mezők helyett normalizálás lehetséges, Laravel Queue, API-first design |

## ADR-001: Monolitikus Laravel webalkalmazás (nem microservices)

| Mező | Tartalom |
|---|---|
| **ADR ID** | ADR-001 |
| **Döntési pont** | Alkalmazás-architektúra: monolít vs microservices vs serverless |
| **Kontextus** | Szakdolgozati MVP, egy csapatbeli dev, közös DB, valós idejű közösségi funkciók (kommentek, regisztráció) |
| **Alternatívák** | 1) Monolítikus Laravel (választott); 2) Microservices (Spring Boot auth + Node.js eventos); 3) Serverless (AWS Lambda + DynamoDB) |
| **Döntés** | Monolitikus Laravel 12 + MySQL |
| **Indoklás** | Gyors MVP, egy személy fejleszthet, deploy egyszerű (shared hosting/VPS), közös DB konzisztencia, debugging könnyű |
| **Kompromisszumok** | Horizontális skálázás nehezebb (sessio/cache-kezelés); késedelem-érzékeny valós idejű funkciók (kommentek) nincs WebSocket; de MVP-hez elegendő |
| **Kockázat** | DB bottleneck, ha много simultán user; session share több szerver között (Redis szükséges); DevOps többlet |
| **Validáció** | Prototípus futott helyi dev + XAMPP-on; migration és seeding sikeres; 71 teszt zöld |

## ADR-002: MySQL relációs adatbázis (JSON típussal a pet-paraméterekhez)

| Mező | Tartalom |
|---|---|
| **ADR ID** | ADR-002 |
| **Döntési pont** | Adatbázis-séma: normalizálás vs JSON típusok |
| **Kontextus** | Event allowed_species és allowed_breeds dinamikus lista (eseményenként más); normalizálás extra joins |
| **Alternatívák** | 1) Relációs (N+1 tábla) `event_allowed_breeds`; 2) JSON (választott: events.allowed_breeds JSON); 3) Document DB (MongoDB) |
| **Döntés** | MySQL JSON típus (events.allowed_species, events.allowed_breeds) |
| **Indoklás** | Egyszerű implementáció (0-5 érték per esemény), Eloquent native casting, lekérdezésben szűrés lehetséges `JSON_CONTAINS` |
| **Kompromisszumok** | Index nehezebb (de MVP nem szükséges); normalizáláshoz később tábla bevezetése |
| **Kockázat** | Ha 1000+ esemény, majd породы szűrése lassú; akkor: `event_allowed_breeds` junction tábla + index |
| **Validáció** | Seeder és teszt futott; JSON cast működik |

## ADR-003: Blade templating + Tailwind CSS (nem SPA/React)

| Mező | Tartalom |
|---|---|
| **ADR ID** | ADR-003 |
| **Döntési pont** | Frontend: Blade szerver-oldali + form POST vs React/Vue SPA |
| **Kontextus** | MVP egyszerű UI, form-intenzív (pet create, event register), szerveroldali session auth, nincs valós idő |
| **Alternatívák** | 1) Blade + Tailwind (választott); 2) React SPA + API; 3) Livewire (Laravel interaktív componens) |
| **Döntés** | Blade szerver-oldali template + Tailwind CSS, API route-ok (feature teszteléshez) |
| **Indoklás** | Szóbeli autentikáció elegendő; POST formon CSRF token beépített; Tailwind gyors prototípus |
| **Kompromisszumok** | JavaScript szintű interakció korlátozott; ha real-time chat jön, Livewire/WebSocket szükséges |
| **Kockázat** | UX: page reload az összes form afternél (de MVP-hez OK); SPA később refactoriálható |
| **Validáció** | Lokális fejlesztés, képernyők működnek |

## ADR-004: Eloquent Model Policy + ownership check (nem RBAC alacsony szinten)

| Mező | Tartalom |
|---|---|
| **ADR ID** | ADR-004 |
| **Döntési pont** | Jogosultság-kezelés: RBAC vs Policy vs ACL |
| **Kontextus** | Kisszámú szerep (user, admin); pet csak tulajdonosé; event szervezője módosíthat |
| **Alternatívák** | 1) Blade if + middleware (könnyű, korlátok); 2) Eloquent Policy (választott); 3) Spatie/Permission RBAC (overkill MVP-nél) |
| **Döntés** | Eloquent Policy + model binding + controller ownership check |
| **Indoklás** | Beépített Laravel, teszthető, deklaratív (`$this->authorize('delete', $pet)`) |
| **Kompromisszumok** | Minden resource-hoz Policy; de értékelhető consistency + tesztelhetőség |
| **Kockázat** | Elfelejtett owner check egy routban → 403 helyett 200 + data leak |
| **Validáció** | Unit teszt: PetControllerTest, RegistrationControllerTest pass |

## ADR-005: Kétszintű tesztelési stratégia (Unit + Feature, nem E2E)

| Mező | Tartalom |
|---|---|
| **ADR ID** | ADR-005 |
| **Döntési pont** | Teszt piramis: Unit vs Feature vs E2E |
| **Kontextus** | MVP scope, CI/CD pipeline nincs (GitHub Actions opcionális), manuális release |
| **Alternatívák** | 1) Csak kézi teszt; 2) Unit + Feature (választott); 3) Full E2E (Selenium/Cypress) |
| **Döntés** | PHPUnit Feature tesztek (HTTP Request) + Unit (Model/Service); nincs E2E |
| **Indoklás** | Feature teszt: gyors feedback a fő use case-eken; Unit: service logika validáció; E2E: CI pipeline szükséges |
| **Kompromisszumok** | JS interakciók (vanilla vagy alpine) manuálisan tesztelt; E2E E2E pipeline később |
| **Kockázat** | GUI hibaállapotok (pl. CSS eltörik) nem detektálva automatán |
| **Validáció** | `php artisan test --env=testing` → 71 pass |

## ADR-006: Szeparált test DB (petshop_test) environment-specifikus konfigurációval

| Mező | Tartalom |
|---|---|
| **ADR ID** | ADR-006 |
| **Döntési pont** | Test DB: in-memory SQLite vs MySQL clone |
| **Kontextus** | Windows dev + XAMPP MySQL; CI pipeline esetén könnyebb lenne SQLite; de consistency MySQL-hez |
| **Alternatívák** | 1) SQLite in-memory (gyors); 2) MySQL copy/separate DB (választott); 3) PostgreSQL test slave |
| **Döntés** | MySQL test DB (`petshop_test`) environment detektálás bootstrap/app.php-ben |
| **Indoklás** | Prodban MySQL; teszt is MySQL → nincs overrallis SQL dialect meglepetés |
| **Kompromisszumok** | Gyorsabb: SQLite; de eltérés teszt–prod között |
| **Kockázat** | CI pipeline-ban SQLite használat → teszt zöld, prod hiba (pl. JSON operátor) |
| **Validáció** | `--env=testing` flag működik; migrate:fresh --seed --env=testing OK |

## Építészeti diagram (rövid szöveges leírás)

```
┌──────────────────────┐
│   Browser (User)     │
└──────────┬───────────┘
           │ HTTP GET/POST
           ▼
┌──────────────────────────────┐
│   Laravel Web Route (web.php) │
│   + Middleware (Auth, CSRF)   │
└──────────┬───────────────────┘
           │
           ▼
┌──────────────────────┐
│   Controller         │
│ (PetController, etc) │
└──────────┬───────────┘
           │
           ▼
┌──────────────────────────┐
│   Eloquent Model + Policy │
│ (Pet, Event, User, etc)   │
└──────────┬────────────────┘
           │
           ▼
┌──────────────────────┐
│    MySQL Database    │
│  (users, pets, ...)  │
└──────────────────────┘

┌─────────────────────────┐
│  Blade Template Engine  │
│  (resources/views)      │
└─────────────────────────┘
         ↑
         │ View render
┌────────────────┐
│  Tailwind CSS  │
└────────────────┘
```

## Összefoglalás
Ez az architektúra a **monolitikus, szerver-oldali**, **MVP-cél** megvalósítására optimalizált. Skálázás vagy valós idejű funkciók később refactoriálhatóak.