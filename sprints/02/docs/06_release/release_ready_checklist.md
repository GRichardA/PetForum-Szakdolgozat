# Release-Ready Checklist

Date: 2026-04-25
Purpose: practical acceptance checklist before final thesis defense/demo.

## A) Reproducibility and setup

- [ ] Fresh clone can be started from README commands.
- [ ] .env.example is complete and no real secrets are committed.
- [ ] Database migration and seeding complete without manual SQL patching.
- [ ] Storage link is created and avatar serving works.

Evidence:
- [README.md](README.md)
- [docs/local_setup.md](docs/local_setup.md)

## B) Functional and UX readiness

- [ ] Core happy path works: register -> login -> create event -> comment.
- [ ] Negative path works: guest protection + validation messages.
- [ ] Profile and avatar flow works (upload and default choice).

Evidence:
- [docs/03_design/ux_flows.md](docs/03_design/ux_flows.md)
- [docs/06_release/demo_script.md](docs/06_release/demo_script.md)

## C) Contract and data consistency

- [ ] API v1 routes are registered.
- [ ] OpenAPI contract matches implemented JSON structure.
- [ ] Data model docs match migrations and relations.

Evidence:
- [docs/03_design/openapi.yaml](docs/03_design/openapi.yaml)
- [docs/03_design/data_model.md](docs/03_design/data_model.md)
- [docs/api_contracts.md](docs/api_contracts.md)

## D) Testing and quality gates

- [ ] Full suite is passing.
- [ ] Contract tests pass for API v1.
- [ ] Performance smoke baseline is available.
- [ ] Known gaps are explicitly listed.

Evidence:
- [docs/04_quality/test_report.md](docs/04_quality/test_report.md)
- [docs/04_quality/performance.md](docs/04_quality/performance.md)

## E) Operations and security

- [ ] Deploy and incident runbook exists and is actionable.
- [ ] Health endpoint evidence is present.
- [ ] Threat model and privacy/licensing baseline are documented.
- [ ] Dependency audit status is known and action plan exists.

Evidence:
- [docs/05_security_ops/deploy_runbook.md](docs/05_security_ops/deploy_runbook.md)
- [docs/observability_and_deploy.md](docs/observability_and_deploy.md)
- [docs/05_security_ops/threat_model.md](docs/05_security_ops/threat_model.md)
- [docs/05_security_ops/privacy_licensing.md](docs/05_security_ops/privacy_licensing.md)

## F) AI transparency

- [ ] AI manifest is present.
- [ ] Prompt log and verification log are up to date.
- [ ] Verification includes pass/fail and concrete command evidence.

Evidence:
- [docs/07_ai/ai_manifest.md](docs/07_ai/ai_manifest.md)
- [docs/07_ai/prompt_log.md](docs/07_ai/prompt_log.md)
- [docs/07_ai/verification_log.md](docs/07_ai/verification_log.md)

## Go / No-Go decision

Go criteria:
1. All A-D sections pass.
2. E section has no unacknowledged high-risk blocker.
3. Known gaps are documented with owner and next action.

Current recommendation (as of 2026-04-25):
- CONDITIONAL GO
- Blockers to close soon: dependency advisory remediation and browser-level E2E coverage.
