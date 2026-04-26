# Test Strategy — PetForum

## Scope
This strategy defines how automated tests protect core product flows and reduce regression risk.

## Pyramid (current target)
- Unit: basic logic checks (currently minimal)
- Feature/Integration: dominant layer (Laravel HTTP + DB + validation)
- E2E-like flow: one end-to-end feature flow test
- Contract: JSON API contract tests for `/api/v1/*`

## Current suite groups
- Auth: register/login flow
- Events: list, create, auth/validation negatives
- Comments: create, auth/validation negatives
- Profile/avatar: update, auth negative, upload processing
- API contracts: index/show/404/health JSON shape
- Performance smoke: p95-like timing check on events API index
- E2E flow: register -> login -> create event -> comment

## Quality gates
- Local: `php artisan test`
- CI: workflow should run tests on every push/PR
- Failure policy: failing tests block merge

## Tradeoffs and known gaps
- Browser-level E2E framework (Dusk/Playwright) is not yet integrated.
- Test count is increasing, but still below the strict 30+ thesis threshold.
- Performance test is smoke-level, not full load test.

## Next quality steps
1. Add browser E2E smoke with real DOM assertions.
2. Raise unit test count for model/service logic.
3. Add dedicated negative security tests (authorization boundary checks).
