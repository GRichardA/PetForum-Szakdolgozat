# API Documentation

Date: 2026-04-25
Scope: implemented JSON API surface for contract-based integration and thesis evidence.

## Base information

- API base path: /api/v1
- Main contract source: [docs/03_design/openapi.yaml](docs/03_design/openapi.yaml)
- Contract test source: [tests/Feature/ApiContractTest.php](tests/Feature/ApiContractTest.php)

## Endpoints

### GET /api/v1/health

Purpose:
- Minimal service health snapshot.

Response (200):
- status
- database
- storage

Implementation:
- [app/Http/Controllers/HealthController.php](app/Http/Controllers/HealthController.php)

### GET /api/v1/events

Purpose:
- List events with category and author references.

Response (200):
- data[]
  - id, title, event_date, location, description
  - category: id, name, slug
  - user: id, name
- meta.count

Implementation:
- [app/Http/Controllers/Api/EventApiController.php](app/Http/Controllers/Api/EventApiController.php)

### GET /api/v1/events/{eventId}

Purpose:
- Return detailed event representation with comments and one-level children.

Response (200):
- data
  - base event fields
  - comments[]
    - id, body, user
    - children[] (id, body, user)

Response (404):
- Event not found.

Implementation:
- [app/Http/Controllers/Api/EventApiController.php](app/Http/Controllers/Api/EventApiController.php)

## Routing

- [routes/api.php](routes/api.php)
- API route registration in bootstrap: [bootstrap/app.php](bootstrap/app.php)

## Validation and auth boundary notes

- The above endpoints are read-only public contract endpoints.
- Web mutation flows (event create/comment/profile update) are handled via web routes and form validation.
- Negative and authorization behavior is covered in feature tests.

Related evidence:
- [tests/Feature/EventTest.php](tests/Feature/EventTest.php)
- [tests/Feature/CommentTest.php](tests/Feature/CommentTest.php)
- [tests/Feature/ProfileTest.php](tests/Feature/ProfileTest.php)

## Error response baseline

- 404 for missing event on /api/v1/events/{eventId}.
- Validation and auth errors in web flows use Laravel redirect/session error mechanism.
- Dedicated error-handling notes: [docs/03_design/error_handling.md](docs/03_design/error_handling.md)
