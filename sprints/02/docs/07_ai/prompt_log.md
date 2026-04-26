# Prompt Log

Cél: a projekt kulcs-promptjainak dokumentálása. Minden bejegyzés rövid és hivatkozható.

## Formátum
- Dátum / ID
- Cél
- Prompt (rövidített)
- AI válasz rövid kivonata
- Hová került az eredmény (fájl/commit)
- Mit módosítottunk kézzel

---

### P-001 (2026-02-10)
- Cél: Esemény modell és migráció javaslat
- Prompt: "Suggest an events table schema for community event app (title, date, location, category, user)
- AI válasz: Javasolt mezők + indexelés
- Hová: `database/migrations/2025_11_22_160321_create_events_table.php`
- Módosítás: mezők pontosítása, index hozzáadva a `event_date`-hez

### P-002 (2026-02-15)
- Cél: Avatar processing flow javaslat
- Prompt: "How to implement avatar upload + server-side resizing in Laravel, fallback if Intervention not available"
- AI válasz: Intervention Image pipeline javaslat + GD fallback ötlet
- Hová: `app/Http/Controllers/ProfileController.php` (implementáció során refaktorálva)
- Módosítás: GD fallback rész kézzel írva, részletes logging hozzáadva


(Adj hozzá további fontos promptokat ide — cél: 10–20 bejegyzés.)
### P-003 (2026-02-20)
- Cél: Tesztstratégia vázlat generálása
- Prompt: "Suggest a test strategy for a Laravel app with events, comments and user profiles (unit/integration/e2e split)"
- AI válasz: Javaslat a teszt-piramissal, ajánlott arányok és sample tesztek
- Hová: `docs/04_quality/testing_strategy.md` (tervezet)
- Módosítás: adaptáltuk a projekt stackre és CI folyamatra

### P-004 (2026-02-22)
- Cél: Health endpoint implementáció
- Prompt: "What should a /health endpoint check in a small web app? Provide recommended checks and JSON schema"
- AI válasz: DB connection, storage writable, optional external API checks; sample JSON
- Hová: `app/Http/Controllers/HealthController.php` és `routes/web.php`
- Módosítás: csak DB + storage checks implementálva

### P-005 (2026-03-01)
- Cél: CI workflow javaslat
- Prompt: "Create a GitHub Actions workflow for PHP/Laravel that runs composer install, migrations, and phpunit tests"
- AI válasz: workflow vázlat lépésekkel (setup-php, composer install, migrate, test)
- Hová: `.github/workflows/ci.yml`
- Módosítás: environment secrets és caching beállítások hozzáadva kézzel

### P-006 (2026-03-05)
- Cél: Image serving security
- Prompt: "How to securely serve user uploaded images in Laravel without exposing storage path or allowing path traversal?"
- AI válasz: use response()->file or streamed response with validation on filename, store outside public and route through controller
- Hová: `routes/web.php` (user.avatar route) és `ProfileController`
- Módosítás: route implementáció finomítva és file_exists ellenőrzés

### P-007 (2026-03-10)
- Cél: Seeder ötletek realisztikus eseményekhez
- Prompt: "Generate 20 realistic community pet event names, short descriptions, and plausible dates/locations for Hungary (Budapest areas)"
- AI válasz: listát adott eseménynevekkel és rövid leírásokkal
- Hová: `database/seeders/EventSeeder.php` (vázlat feltöltése)
- Módosítás: leírások rövidítve és lokalizálva

### P-008 (2026-03-12)
- Cél: ADR sablon és példa
- Prompt: "Provide an ADR template and a short example ADR for choosing session-based auth vs JWT in a small web app"
- AI válasz: ADR sablon + példa döntés (session auth választása egyszerűség miatt)
- Hová: `docs/02_architecture/adr/0001-auth-choice.md`
- Módosítás: példa ADR finomítva a project követelményeihez

### P-009 (2026-03-20)
- Cél: Performance smoke test javaslat
- Prompt: "Suggest a lightweight performance smoke test for the events index endpoint (measure p95 latency under 50 concurrent users)"
- AI válasz: javaslat ApacheBench/hey script és metrika gyűjtés
- Hová: `docs/04_quality/performance.md` és CI script ötlet
- Módosítás: egyszerű hey parancs beillesztve a docs-ba

### P-010 (2026-04-05)
- Cél: Verification log sablon ötlet
- Prompt: "How to structure a verification log for AI-generated code so each entry has risk, test, result, and conclusion"
- AI válasz: javasolt mezők és rövid példa bejegyzés
- Hová: `docs/07_ai/verification_log.md`
- Módosítás: bevezető rész testreszabva a projekt igényeire

### P-011 (2026-04-06)
- Cél: Role-based middleware implementation
- Prompt: "How to implement role-based middleware in Laravel and test admin-only routes"
- AI válasz: sample middleware, gate/policy usage, and test case outline
- Hová: `app/Http/Middleware/EnsureUserHasRole.php`, `tests/Feature/AuthTest.php`
- Módosítás: adaptálva a projekt `roles` oszlopára és a tesztekre

### P-012 (2026-04-07)
- Cél: Image optimization pipeline
- Prompt: "Suggest an image optimization pipeline for user avatars (resize, strip metadata, convert to webp) in PHP/Laravel"
- AI válasz: steps using Intervention + spatie/laravel-image-optimizer or external binary, fallback details
- Hová: `app/Services/ImageService.php` (terv) és `ProfileController`
- Módosítás: külső bináris használatát csak opcióként hagytuk, server-side webp konverzió beállítva

### P-013 (2026-04-10)
- Cél: Notification strategy (email) vázlat
- Prompt: "Propose a simple email notification strategy for event creators (on RSVP or comment) for a small Laravel app"
- AI válasz: use mailables, queue emails, basic templates, opt-in preference
- Hová: `docs/06_release/demo_script.md` és future `Notification` mappák
- Módosítás: queue használata ajánlva, de alap implementáció sync módban

### P-014 (2026-04-12)
- Cél: API error format
- Prompt: "Design a consistent JSON error object schema for API responses (validation, auth, not found, server error)"
- AI válasz: suggested error object `{code, message, details?, traceId?}` and mapping for HTTP statuses
- Hová: `docs/03_design/error_handling.md` és `app/Exceptions/Handler.php` mapping
- Módosítás: `traceId` csak dev-ben, `details` for validation only

### P-015 (2026-04-15)
- Cél: Seeder randomness determinism for tests
- Prompt: "How to make seeders produce deterministic test data for CI while still realistic locally"
- AI válasz: use env var or `--seed` flags, `srand()`/faker seed, separate factories for test vs demo
- Hová: `database/seeders/DatabaseSeeder.php` notes and CI script
- Módosítás: added guidance to use `FAKER_SEED` env var in CI

### P-016 (2026-04-18)
- Cél: Thesis AI documentation lezárása evidence-alapon
- Prompt: "Kezdjük az 1. ponttal: készíts 10+ verification bejegyzést valós parancs outputokkal (teszt, route, migrate, audit)."
- AI válasz: javasolt command csomag + struktúra (pass/fail is dokumentálva)
- Hová: `docs/07_ai/verification_log.md`
- Módosítás: a parancsokat lokálban futtattuk és a tényleges output került a logba (8 teszt pass, composer audit advisory-k, npm hiányzó bináris)
