# Product Metrics Baseline

Date: 2026-04-25
Scope: thesis-level metrics definition with practical measurement sources.

## Metric catalog

| Metric type | Name | Definition | Target | Measurement source |
|---|---|---|---|---|
| North Star | Monthly active event creators | Unique users who create >=1 event/month | Upward trend | events table aggregation |
| Guardrail | Event creation success rate | Successful event create requests / total event create attempts | >= 95% | app logs + validation failures |
| Guardrail | Events API p95 latency | p95 response time for /api/v1/events | <= 800 ms (beta SLO) | Performance smoke + future benchmark |
| Guardrail | API error rate (5xx) | 5xx responses / total API responses | <= 1.0% daily | logs/monitoring |
| Guardrail | Deploy success rate | Successful deployments / total deployments | >= 95% monthly | CI/CD history |
| Risk metric | Open dependency advisories | Count of unresolved high/medium advisories | Trend down | composer audit, npm audit |

## Current baseline evidence

1. Test and quality baseline:
- [docs/04_quality/test_report.md](docs/04_quality/test_report.md)
- Latest known run: 30 passed, 87 assertions.

2. Performance baseline:
- [docs/04_quality/performance.md](docs/04_quality/performance.md)
- Smoke signal: p95-like threshold assertion in test.

3. Observability baseline:
- [docs/observability_and_deploy.md](docs/observability_and_deploy.md)
- Health endpoint and logging evidence documented.

4. Security/dependency baseline:
- [docs/05_security_ops/privacy_licensing.md](docs/05_security_ops/privacy_licensing.md)
- Composer advisories currently present; npm audit not available locally.

## Measurement implementation notes

- SQL example (North Star): count distinct user_id from events grouped by month.
- API error rate and latency: derive from structured logs after request_id and duration_ms standardization.
- Deploy success rate: parse CI workflow outcomes for main branch.

## Next implementation steps

1. Add simple scheduled metric extraction script (daily summary).
2. Store metric snapshots in docs/06_release/metrics_history.md or CI artifact.
3. Add CI gate warning if high severity advisories remain unresolved.
4. Add browser E2E pass rate as an additional guardrail once framework is integrated.
