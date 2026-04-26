# Error Handling

Date: 2026-04-25
Scope: practical error handling behavior for API and web flows.

## Goals

1. Prevent technical stack traces in normal user-facing paths.
2. Keep contracts predictable for API consumers.
3. Ensure validation and authorization failures are explicit and testable.

## Error categories

### 1) Validation errors

Web flow behavior:
- Invalid form input redirects back with session errors.
- User input is preserved with old() values in Blade forms.

Examples:
- Invalid category on event creation.
- Empty comment body.
- Profile email uniqueness conflict.

Evidence:
- [tests/Feature/EventTest.php](tests/Feature/EventTest.php)
- [tests/Feature/CommentTest.php](tests/Feature/CommentTest.php)
- [tests/Feature/ProfileTest.php](tests/Feature/ProfileTest.php)

### 2) Authentication and authorization errors

Behavior:
- Guest access to protected routes redirects to login.
- Non-owner event update/delete attempts are blocked.

Evidence:
- [tests/Feature/AuthTest.php](tests/Feature/AuthTest.php)
- [tests/Feature/EventTest.php](tests/Feature/EventTest.php)
- [tests/Feature/ProfileTest.php](tests/Feature/ProfileTest.php)

### 3) Not found errors

Behavior:
- /api/v1/events/{eventId} returns 404 when event does not exist.

Evidence:
- [tests/Feature/ApiContractTest.php](tests/Feature/ApiContractTest.php)

### 4) Infrastructure-related errors (DB/storage)

Behavior baseline:
- Health endpoint exposes status summary for database and storage.
- Incident runbook defines operator actions for DB and storage failures.

Evidence:
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

## Production safety baseline

- Keep APP_DEBUG=false outside local development.
- Avoid logging sensitive data (passwords, tokens, raw secrets).
- Verify health endpoint and logs post-deploy.

Related docs:
- [docs/03_design/api.md](docs/03_design/api.md)
- [docs/05_security_ops/privacy_licensing.md](docs/05_security_ops/privacy_licensing.md)
- [docs/05_security_ops/observability.md](docs/05_security_ops/observability.md)
