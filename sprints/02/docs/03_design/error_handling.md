# Hibakezelés

Dátum: 2026-04-25
Hatáskör: gyakorlati hibakezelés viselkedés API és web folyamatokhoz.

## Célok

1. Megelzőzés a műszaki verem nyomok megjelenésének normál felhasználó ellenezéseknél.
2. Szerződések kiszamítható maradása az API fogyasztoinak.
3. Validáció és autorizació hibák explicit és tesztelhető maradása.

## Hibakategoriák

### 1) Validációs hibák

Web folyamat viselkedés:
- Érvénytelen form bemenét visszairányít session hibakkal.
- Felhasználói bementő az old() értékekkel Blade formokban még van tartva.

Példák:
- Érvénytelen kategória esemény létrehozásnál.
- Üres hozzászólás állómány.
- Profil email egyediség ütközés.

Bizonyíték:
- [tests/Feature/EventTest.php](tests/Feature/EventTest.php)
- [tests/Feature/CommentTest.php](tests/Feature/CommentTest.php)
- [tests/Feature/ProfileTest.php](tests/Feature/ProfileTest.php)

### 2) Authentication and authorization errors

Behavior:
- Guest access to protected routes redirects to login.
- Non-owner event update/delete attempts are blocked.
- Non-owner or non-admin comment delete attempts return 403.
- Admin can delete any comment or event.

Evidence:
- [tests/Feature/AuthTest.php](tests/Feature/AuthTest.php)
- [tests/Feature/EventTest.php](tests/Feature/EventTest.php)
- [tests/Feature/CommentTest.php](tests/Feature/CommentTest.php) - includes comment owner/admin authorization tests
- [tests/Feature/ProfileTest.php](tests/Feature/ProfileTest.php)
- [tests/Feature/AdminTest.php](tests/Feature/AdminTest.php)

### 3) Nem található hibák

Viselkedés:
- /api/v1/events/{eventId} 404-et ad vissza, ha az esemény nem létezik.

Bizonyíték:
- [tests/Feature/ApiContractTest.php](tests/Feature/ApiContractTest.php)

### 4) Infrastruktúra-kapcsolat hibák (DB/storage)

Viselkedés alaptörvény:
- Az egészség végpont állapot összefoglalást tesz közössé adatbázis és storage részére.
- Tájékoztató könyv meghatározza az operátor cselekvéseit DB és storage hibákhoz.

Bizonyíték:
- [app/Http/Controllers/HealthController.php](app/Http/Controllers/HealthController.php)
- [docs/05_security_ops/deploy_runbook.md](docs/05_security_ops/deploy_runbook.md)

## API error object policy

Current state:
- API currently guarantees explicit 404 for missing event and 200 contracts for implemented read endpoints.
- A fully uniform JSON error envelope (code/message/details/traceId) is not yet globally enforced.

Recommended next step:
1. Add centralized API exception mapping in Laravel exception handler.
2. Standardize JSON error schema for 401/403/404/422/500.
3. Add contract tests for each error category.

## Prodúckció biztonsági alaptörvény

- Keep APP_DEBUG=false a helyi fejlésztésen kívül.
- Kerüljék az érzékeny adatok naplózását (jelszavak, jetonok, nyers titkok).
- Ellenőrizze az egészség végpontot és naplókat post-deploy.

Függeléki dokumentumok:
- [docs/03_design/api.md](docs/03_design/api.md)
- [docs/05_security_ops/privacy_licensing.md](docs/05_security_ops/privacy_licensing.md)
- [docs/05_security_ops/observability.md](docs/05_security_ops/observability.md)
