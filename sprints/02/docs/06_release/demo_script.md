# Demo Script (5-7 minutes)

Date: 2026-04-25
Goal: stable thesis demo aligned to scope contract and quality evidence.

## 1) 30 sec - Problem and value proposition

Narrative:
- Local pet communities need a simple way to create and discover events.
- PetForum provides event creation, discovery, comments, and profile/avatar personalization.

Evidence:
- Vision: [docs/01_product/vision.md](docs/01_product/vision.md)
- Scope contract: [docs/01_product/scope_contract.md](docs/01_product/scope_contract.md)

## 2) 2-3 min - Main user flow #1 (happy path)

Flow:
1. Register a new user on /register.
2. Log in on /login.
3. Open /events/create and create an event with category/date/location.
4. Return to /events and open event details.

Expected outcome:
- Event is visible on list and details page.

Evidence:
- UX flow doc: [docs/03_design/ux_flows.md](docs/03_design/ux_flows.md)
- E2E-like test: [tests/Feature/E2EFlowTest.php](tests/Feature/E2EFlowTest.php)
- Event tests: [tests/Feature/EventTest.php](tests/Feature/EventTest.php)

## 3) 1 min - Main user flow #2 (community interaction)

Flow:
1. Open event details page.
2. Add a comment.
3. Add a one-level reply.

Expected outcome:
- Comment tree is rendered and persisted.

Evidence:
- Comment tests: [tests/Feature/CommentTest.php](tests/Feature/CommentTest.php)
- API contract comment shape: [tests/Feature/ApiContractTest.php](tests/Feature/ApiContractTest.php)

## 4) 1 min - Error handling / negative path

Flow:
1. Try to create event as guest.
2. Try invalid category_id or empty comment body.
3. Show guest protection for profile update.

Expected outcome:
- Redirect to login for protected actions.
- Validation errors are returned; invalid data is not persisted.

Evidence:
- Auth boundary tests: [tests/Feature/EventTest.php](tests/Feature/EventTest.php)
- Validation tests: [tests/Feature/CommentTest.php](tests/Feature/CommentTest.php)
- Profile guard tests: [tests/Feature/ProfileTest.php](tests/Feature/ProfileTest.php)

## 5) 30-60 sec - Product quality snapshot

Show:
- Test status (30 passed, 87 assertions).
- Health endpoints (/health and /api/v1/health).
- Runbook + observability baseline.

Evidence:
- Test report: [docs/04_quality/test_report.md](docs/04_quality/test_report.md)
- Observability: [docs/observability_and_deploy.md](docs/observability_and_deploy.md)
- Runbook: [docs/05_security_ops/deploy_runbook.md](docs/05_security_ops/deploy_runbook.md)

## 6) 30 sec - Next steps / roadmap

Planned:
- Browser-level E2E (Playwright or Dusk).
- Coverage report in CI.
- Dependency vulnerability remediation and recurring audits.

Evidence:
- Quality gaps: [docs/04_quality/test_report.md](docs/04_quality/test_report.md)
- Privacy/licensing actions: [docs/05_security_ops/privacy_licensing.md](docs/05_security_ops/privacy_licensing.md)

## Demo reliability checklist

Before presentation:
1. Run database reset and seed: php artisan migrate:fresh --seed
2. Run tests: php artisan test
3. Verify routes: php artisan route:list --path=health
4. Start app: php artisan serve --host=127.0.0.1 --port=8000
5. Keep one prepared user for fallback login.
