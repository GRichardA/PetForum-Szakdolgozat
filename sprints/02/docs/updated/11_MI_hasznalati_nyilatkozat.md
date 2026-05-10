# MI-használati nyilatkozat és napló

## Rövid nyilatkozat a szakdolgozatba

A szakdolgozat készítése során GitHub Copilot és Claude-alapú MI eszközöket használtam **ötletelésre, szövegtervezésre, kódmagyarázatra, hibakeresésre, refactoringra és tesztadat-generálásra**. Az MI által javasolt tartalmakat (kódből és dokumentációból) önállóan ellenőriztem, tesztelem, módosítottam, és ahol szükséges, lecseréltem. A végső szakmai felelősséget vállalom. A dolgozatban szereplő megoldások, döntések és következtetések saját mérnöki munkám eredményei.

## MI-használati napló

| Dátum | Eszköz | Feladat | Prompt szöveg (rövid) | Eredmény | Ellenőrzés módja | Beépült? | Saját módosítás |
|---|---|---|---|---|---|---|---|
| 2026-05-08 | GitHub Copilot | Pet Model implementáció | "Írj Laravel Model-t Pet entitáshoz user_id, species, breed, vaccinated mezőkkel" | Eloquent Model boilerplate | Unit teszt: PetFactory | igen | Relációk, `isVaccinated()` method hozzáadva |
| 2026-05-08 | GitHub Copilot | Registration logika | "Validálj Registration: pet fajta és oltás ellenőrzés" | Validation logika vázlat | Feature teszt TC-05, TC-06 | igen | Specifikus egyenlőség-ellenőrzés (=== vs in_array) a JSONben |
| 2026-05-08 | GitHub Copilot | PetFactory hibaelhárítás | "Miért hibázik a Faker unique() meghívás 50 petből? Vajon kevés a név generálás?" | Faker ciklus-végetlenség magyarázat | Teszt + hibakeresés | igen | Removed unique() constraint; randomizáció elegendő az MVP-hez |
| 2026-05-08 | Claude (via Copilot) | Bootstrap CSRF hiba | "Laravel test 419 CSRF error — hogyan disableljem testing environment alatt?" | Middleware disable az env check alapján | Manual teszt `php artisan test` | igen | Raw $_ENV['APP_ENV'] === 'testing' check (nem app()->environment()) |
| 2026-05-09 | GitHub Copilot | Seeder magyar adatok | "Generálj PetSeeder magyar állatneveket, fajták listát" | Faker HU locale + breed array | Visual inspection + seeded DB | igen | Hozzáadtam 15 autentikus magyar kutyafajtát és cicaneveket |
| 2026-05-09 | GitHub Copilot | Event SQL dump parse | "Hogyan értsem meg a SQL dump szerkezetét a magyar helyszínekről?" | Schema introspection tanácsok | SQL dump megnyitása + manuális olvasás | igen | Manuálisan Extract helyszín-nevek; Seeder kódba |
| 2026-05-09 | Claude | Dokumentáció sablonok | "MVP brief, use case spec, data model documentation layout?" | Markdown template-ek | Fájl létrehozás `docs/updated/` | igen | Projekt-specifikus értékek kitöltése (pet domain, magyar) |
| 2026-05-09 | Claude | Security checklist | "Melyik a legfontosabb security szempont a pet regisztrációs rendszerhez?" | Ownership check, input validation, CSRF lista | Code review + test planning | igen | Pet ownership assertion (`canBeCancelledBy`, PetPolicy) tesztelve |
| 2026-05-10 | Claude | Piaci elemzés írás | "Meetup vs Facebook Events vs saját pet regisztráció — mi az érték?" | Comparative table + niche analysis | Reflexió az MVP design döntéseken | igen | Saját értékpropozíció (pet-domain + magyar) hangsúlyozva |

## Eszközök, amelyeket nem használtam (de felismerem a kockázatot)

| Eszköz | Miért nem | Kockázat |
|---|---|---|
| **Code generation (copilot-full)** | Előfizető, de csak code hints-et használtam | Over-reliance; auto-complete zavarása |
| **Image generator (DALL-E, Midjourney)** | N/A (nem volt szükség szemléltetésre) | Ha lennék UI mockup, képgenerálás etikai szürkezónája |
| **LLM API (OpenAI/Anthropic közvetlen)** | Local API nincs; Copilot app elég | Költség, latency, data privacy ha érzékeny |

## MI etikai & kontrollmekanizmusok

1. **Prompt ellenőrzés**: Valódi feladat-kontextus, nem csak "generálj kódot".
2. **Output validáció**: Alle MI javaslat: unit teszt, manual review, szintaxis-check.
3. **Attribúció**: Ez a napló explicit módon jelzet az MI segítséget.
4. **Limitation acknowledgement**: MI hibajelenséget (pl. hallucináció: "use Carbon; Date"?) azonnal helyesbítettem.

## Konklúzió
Az MI-eszközöket **asszisztensnek** használtam, nem csodavárázsasnak. A MVP architecture, design döntések és tesztelés tisztán saját munka, az MI csak a boilerplate-et gyorsította.