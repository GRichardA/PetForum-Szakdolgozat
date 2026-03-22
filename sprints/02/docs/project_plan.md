# Project Plan – PetForum

## Egy mondatos értékajánlat

A PetForum egy közösségi webplatform, ahol felhasználók eseményeket hozhatnak létre, kereshetnek és kommentálhatnak, személyre szabott profilokkal és avatarokkal, Laravel alapokon építve, amely elősegíti a helyi közösségek összekapcsolását és az események hatékony szervezését.

## Képességek

| Képesség | Kategória | Komplexitás | Miért nem triviális? |
|---|---|---|---|
| Bejelentkezés és szerepkörök | Productization | M | Laravel Sanctum vagy session-alapú auth implementáció, role-based route védelem, biztonságos jelszókezelés és session management. |
| Esemény létrehozás és keresés | Value | M | Form validáció, adatbázis kapcsolatok, keresési logika (cím és leírás alapján), category dropdown implementáció. |
| Kommentek kezelése | Value | M | Rekurzív kommentfák, felhasználói avatarok megjelenítése, AJAX vagy form-based submit, moderációs alapok. |
| Profil szerkesztés avatarral | Value | M | Képfeltöltés, szerver-oldali resizing (Intervention vagy GD), alapértelmezett SVG avatarok, storage link kezelés. |
| Automata tesztek és CI | Productization | L | PHPUnit tesztek írása (unit, feature, e2e), GitHub Actions workflow konfiguráció, coverage és quality gates beállítása. |
| Deploy és observability | Productization | L | Laravel deploy runbook, health endpoint, JSON logging, environment konfiguráció, rollback stratégia. |

## A legnehezebb rész

Az avatar képfeldolgozás és resizing nem fog elsőre működni, mert a GD vagy Intervention Image könyvtár konfigurációja (extension engedélyezés, fallback logika) és a storage symlink kezelése bonyolult lehet különböző környezetekben, valamint a különböző képformátumok kezelése (JPEG, PNG, WebP) és a memória limit kezelése nagy képeknél.

## Tech stack – indoklással

| Réteg | Technológia | Miért ezt és nem mást? |
|---|---|---|
| UI | Blade templates + Tailwind CSS | Laravel natív templating rendszer egyszerű és gyors prototipizáláshoz, Tailwind pedig utility-first CSS keretrendszer, amely gyors UI fejlesztést tesz lehetővé CDN-nel, anélkül hogy bonyolult build folyamatot igényelne, szemben React/Vue-val, ami túlzott lenne egy MVP-hez. |
| Backend / logika | Laravel (PHP 8.2+) | Robusztos MVC keretrendszer, beépített routing, validation, ORM (Eloquent), migration-ök és artisan parancsok, amelyek gyorsítják a fejlesztést; PHP széles körben támogatott, és a Laravel közösség nagy, szemben Node.js-szel, ami több konfigurációt igényelne. |
| Adattárolás | MySQL | Relációs adatbázis, amely jól illeszkedik a Laravel Eloquent ORM-hoz, támogatja a komplex lekérdezéseket és kapcsolatokat (events-users-categories); egyszerűbb telepíteni XAMPP-pal, mint PostgreSQL vagy NoSQL megoldások, amelyek felesleges komplexitást hoznának. |
| Auth | Laravel built-in session auth | Egyszerű, beépített megoldás cookie-alapú session kezeléssel, amely elegendő egy közösségi platformhoz; nem igényel külső szolgáltatót (OAuth), mint Firebase Auth, ami bonyolítaná a helyi fejlesztést. |

## Ami kimarad (non-goals)

- Mobil alkalmazás vagy PWA implementáció (fókusz webes MVP-re).
- Külső API integrációk (pl. Google Maps teljes API, fizetési gateway) — csak alap térkép megjelenítés.
- Valós idejű chat vagy notification rendszer (WebSocket nélkül).
- Többnyelvűség (i18n) és accessibility audit teljes körűen.
- Éles deployment cloud szolgáltatókra (csak lokális/demo környezet).

## Ami még nem tiszta

- A teljes AI dokumentáció (prompt log, verification log) részleteinek kidolgozása, mivel sok iteráció történt.
- A performance baseline mérése és optimalizálása nagy adatmennyiségnél (pl. 1000+ esemény).
- A security threat model részletes mitigációinak implementálása és tesztelése.