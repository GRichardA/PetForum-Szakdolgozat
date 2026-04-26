# Observability

Date: 2026-04-25
Scope: operational visibility baseline for PetForum.

## Objectives

1. Detect service degradation quickly.
2. Provide reproducible evidence for health and log status.
3. Support incident diagnosis with minimal ambiguity.

## Current implementation

- Health endpoints:
  - GET /health
  - GET /api/v1/health
- Logging channels:
  - single
  - daily
  - json (Monolog JsonFormatter)
- Operational docs:
  - deploy and incident procedures in runbook

Code references:
- [app/Http/Controllers/HealthController.php](app/Http/Controllers/HealthController.php)
- [config/logging.php](config/logging.php)
- [docs/05_security_ops/deploy_runbook.md](docs/05_security_ops/deploy_runbook.md)

## SLI/SLO baseline (beta)

- Availability (health success ratio): >= 99.0% / 30 days
- API 5xx error ratio: <= 1.0% daily
- p95 latency (main list/API endpoints): <= 800 ms
- Deploy success ratio: >= 95% monthly

## Alert thresholds (initial)

- Critical: /health fails 3 consecutive times in 5 minutes
- High: API 5xx ratio > 2% over 10-minute window
- Medium: p95 > 1.2s for 15 minutes

## Evidence snapshot (2026-04-25)

1. Route registration:
- command: php artisan route:list --path=health
- result: 2 routes registered (health and api/v1/health)

2. Health contract test:
- command: php artisan test --filter=test_health_contract_shape
- result: pass (1 test, 4 assertions)

3. Log file presence:
- command: Get-ChildItem storage/logs
- result: laravel.log present and updating

## Known gaps

1. No centralized metrics backend (Prometheus/Grafana) yet.
2. No standardized request correlation id in every log line yet.
3. No automated alert delivery channel configured yet.

## Next steps

1. Add request_id and duration_ms consistently to logs.
2. Add CI-exported health and latency summary artifact.
3. Add minimal alert simulation procedure in runbook.

## Related docs

- [docs/observability_and_deploy.md](docs/observability_and_deploy.md)
- [docs/05_security_ops/deploy_runbook.md](docs/05_security_ops/deploy_runbook.md)
- [docs/04_quality/performance.md](docs/04_quality/performance.md)
