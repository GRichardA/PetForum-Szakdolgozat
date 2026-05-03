# API Contracts

## Formal spec
- OpenAPI source: `docs/03_design/openapi.yaml`
- Version: OpenAPI 3.0.3

## Implemented JSON endpoints (v1)

### GET /api/v1/health
- Leírás: rendszer állapot rövid ellenőrzése
- Sikeres válasz: `200 OK`
- Response fields: `status`, `database`, `storage`

### GET /api/v1/events
- Leírás: események listázása JSON formátumban
- Sikeres válasz: `200 OK`
- Response contract:
	- `data[]`: esemény objektum (`id`, `title`, `event_date`, `location`, `description`, `category`, `user`)
	- `meta.count`: lista elemszáma

### GET /api/v1/events/{eventId}
- Leírás: egy esemény részletei komment fával
- Sikeres válasz: `200 OK`
- Hiba: `404 Not Found` ha az esemény nem létezik
- Response contract:
	- `data`: esemény objektum
	- `data.comments[]`: gyökér kommentek
	- `data.comments[].children[]`: gyermek kommentek

## Contract test coverage
- `tests/Feature/ApiContractTest.php` ellenőrzi:
	- events index JSON szerkezetet
	- event show JSON szerkezetet kommentekkel

## Web routes (nem JSON API)
- A Blade UI endpointok (`/events`, `/profile`, `/events/{event}/comments`) továbbra is web workflow-t szolgálnak (redirect/session).

## Comment management (web routes)

### POST /events/{event}/comments
- **Leírás**: Komment vagy válasz létrehozása egy eseményhez
- **Auth**: Kötelező (auth middleware)
- **Validáció**: `body` (max 1000 karakter), `parent_id` (optional, válaszokhoz)
- **Sikeres válasz**: Redirect az esemény megjelenítéshez success üzenettel
- **Implementáció**: [app/Http/Controllers/CommentController.php](app/Http/Controllers/CommentController.php)

### DELETE /events/{event}/comments/{comment}
- **Leírás**: Komment és az összes gyermek kommentjei törlése
- **Auth**: Kötelező (auth middleware)
- **Jogosultság**: Komment szerzője VAGY admin
- **Sikeres válasz (200)**: Redirect az esemény megjelenítéshez success üzenettel
- **Hiba (403)**: Jogosultsági hiba, ha a user sem a komment szerzője, sem admin
- **Hiba (404)**: Komment vagy esemény nem található
- **Kaszkád viselkedés**: Parent komment törlése rekurzívan törli az összes child kommentjeit
- **Implementáció**: [app/Http/Controllers/CommentController.php](app/Http/Controllers/CommentController.php)
