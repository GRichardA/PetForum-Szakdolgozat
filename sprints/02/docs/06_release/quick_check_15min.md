# Quick Check (15 minutes)

Date: 2026-04-25
Goal: fast readiness validation before review or defense.

## Step 1 - Repo and docs sanity (3 min)

1. Open [README.md](README.md)
2. Open [docs/00_index.md](docs/00_index.md)
3. Verify required sections exist in docs tree

Pass condition:
- Reviewer can navigate product, design, quality, security, release, and AI docs without dead ends.

## Step 2 - Runtime and routes sanity (4 min)

Run:
- php artisan route:list --path=health
- php artisan route:list --path=api/v1

Pass condition:
- Health routes present (/health, /api/v1/health)
- API v1 routes present (/api/v1/events, /api/v1/events/{event})

## Step 3 - Test baseline sanity (4 min)

Run:
- php artisan test --testsuite=Feature,Unit

Pass condition:
- Full suite passes
- No critical regression in auth/event/comment/profile/api contract areas

## Step 4 - Security and ops sanity (4 min)

Run:
- composer audit --no-interaction
- (optional where available) npm audit --omit=dev

Check docs:
- [docs/05_security_ops/deploy_runbook.md](docs/05_security_ops/deploy_runbook.md)
- [docs/05_security_ops/privacy_licensing.md](docs/05_security_ops/privacy_licensing.md)
- [docs/05_security_ops/observability.md](docs/05_security_ops/observability.md)

Pass condition:
- Advisory status known and documented
- Clear action plan exists for unresolved risks

## Current snapshot (2026-04-25)

- Health routes: PASS (2 routes)
- API v1 routes: PASS (3 routes)
- Composer audit: FAIL (5 advisories across 4 packages)
- npm audit: NOT VERIFIED LOCALLY (npm unavailable in this environment)
- Test suite: see [docs/06_release/gate_checklist.md](docs/06_release/gate_checklist.md)

## Decision rubric

- GO: all runtime/test checks pass and no unmitigated high-risk blocker.
- CONDITIONAL GO: core flows pass, but known security/quality gaps remain with documented mitigation plan.
- NO-GO: core flow fails or no reliable recovery path documented.
