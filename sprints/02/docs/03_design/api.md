# API Dokumentáció

Dátum: 2026-04-25
Hatáskör: megvalósított JSON API felület szerződésalapú integrációhoz és dolgozat bizonyítékához.

## Alapinformációk

- API alapútvonal: /api/v1
- Fő szerződés forráskódja: [docs/03_design/openapi.yaml](docs/03_design/openapi.yaml)
- Szerződés tesztkódja: [tests/Feature/ApiContractTest.php](tests/Feature/ApiContractTest.php)

## Endpoints

### GET /api/v1/health

Cél:
- Minimális szolgáltatás-állapot pillanatkép.

Válasz (200):
- status
- database
- storage

Megvalósítás:
- [app/Http/Controllers/HealthController.php](app/Http/Controllers/HealthController.php)

## GET /api/v1/events

Cél:
- Események listázása kategória és szerző hivatkozásokkal.

Válasz (200):
- data[]
  - id, title, event_date, location, description
  - category: id, name, slug
  - user: id, name
- meta.count

Megvalósítás:
- [app/Http/Controllers/Api/EventApiController.php](app/Http/Controllers/Api/EventApiController.php)

### GET /api/v1/events/{eventId}

Cél:
- Részletes esemény reprezentáció kommentekkel és egy szintű gyermekekkel.

Válasz (200):
- data
  - alapvető esemény mezői
  - comments[]
    - id, body, user
    - children[] (id, body, user)

Válasz (404):
- Esemény nem található.

Megvalósítás:
- [app/Http/Controllers/Api/EventApiController.php](app/Http/Controllers/Api/EventApiController.php)

## Útvonalak

- [routes/api.php](routes/api.php)
- API útvonal regisztrálás a bootstrap-ben: [bootstrap/app.php](bootstrap/app.php)

## Validáció és auth határok megjegyzése

- Az API olvasó végpontok (`/api/v1/*`) nyilvános szerződés végpontok.
- Web mutációs folyamatok (esemény/komment/profil írás) web útvonalak és form validáció segítségével kezelve.
- Komment törlés végrehajtja a tulajdonlás vagy admin szerepkör ellenőrzését; jogosulatlan kísérletek 403-at adnak vissza.
- Negatív és autorizáció viselkedés feature tesztekben fedett.

Függeléki bizonyítékok:
- [tests/Feature/EventTest.php](tests/Feature/EventTest.php)
- [tests/Feature/CommentTest.php](tests/Feature/CommentTest.php) - komment törlés tesztek beépítve
- [tests/Feature/ProfileTest.php](tests/Feature/ProfileTest.php)
- [tests/Feature/AdminTest.php](tests/Feature/AdminTest.php)

## Hiba válasz alaptörvény

- 404 hiányzó eseményhez a /api/v1/events/{eventId}-n.
- Validáció és auth hibák web folyamatokban Laravel átirányítás/session hiba mechanizmussal.
- Dedikált hibakezelési megjegyzés: [docs/03_design/error_handling.md](docs/03_design/error_handling.md)
