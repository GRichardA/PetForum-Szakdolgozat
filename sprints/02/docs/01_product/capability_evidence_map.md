# Capability to Evidence Map

Date: 2026-04-25
Purpose: map each declared product capability to implementation and verification evidence.

## Capability matrix

| Capability | Product source | Implementation evidence | Verification evidence | Operational evidence |
|---|---|---|---|---|
| Auth (register/login/logout) | [docs/01_product/scope_contract.md](docs/01_product/scope_contract.md) | [routes/web.php](routes/web.php), [app/Http/Controllers/AuthController.php](app/Http/Controllers/AuthController.php) | [tests/Feature/AuthTest.php](tests/Feature/AuthTest.php), [tests/Feature/E2EFlowTest.php](tests/Feature/E2EFlowTest.php) | [docs/04_quality/test_report.md](docs/04_quality/test_report.md) |
| Event create/search/filter | [docs/01_product/scope_contract.md](docs/01_product/scope_contract.md) | [app/Http/Controllers/EventController.php](app/Http/Controllers/EventController.php), [resources/views/events/index.blade.php](resources/views/events/index.blade.php), [resources/views/events/create.blade.php](resources/views/events/create.blade.php) | [tests/Feature/EventTest.php](tests/Feature/EventTest.php), [tests/Feature/E2EFlowTest.php](tests/Feature/E2EFlowTest.php) | [docs/03_design/openapi.yaml](docs/03_design/openapi.yaml) |
| Comment and reply | [docs/01_product/scope_contract.md](docs/01_product/scope_contract.md) | [app/Http/Controllers/CommentController.php](app/Http/Controllers/CommentController.php), [resources/views/events/show.blade.php](resources/views/events/show.blade.php), [resources/views/events/_comment.blade.php](resources/views/events/_comment.blade.php) | [tests/Feature/CommentTest.php](tests/Feature/CommentTest.php), [tests/Feature/ApiContractTest.php](tests/Feature/ApiContractTest.php) | [docs/03_design/ux_flows.md](docs/03_design/ux_flows.md) |
| Profile edit + avatar | [docs/01_product/scope_contract.md](docs/01_product/scope_contract.md) | [app/Http/Controllers/ProfileController.php](app/Http/Controllers/ProfileController.php), [resources/views/profile/edit.blade.php](resources/views/profile/edit.blade.php), [app/Models/User.php](app/Models/User.php) | [tests/Feature/ProfileTest.php](tests/Feature/ProfileTest.php), [tests/Feature/AvatarUploadTest.php](tests/Feature/AvatarUploadTest.php) | [docs/05_security_ops/deploy_runbook.md](docs/05_security_ops/deploy_runbook.md) |
| API contract layer (/api/v1) | [docs/api_contracts.md](docs/api_contracts.md) | [routes/api.php](routes/api.php), [app/Http/Controllers/Api/EventApiController.php](app/Http/Controllers/Api/EventApiController.php) | [tests/Feature/ApiContractTest.php](tests/Feature/ApiContractTest.php) | [docs/03_design/openapi.yaml](docs/03_design/openapi.yaml) |
| Deploy and observability baseline | [docs/01_product/vision.md](docs/01_product/vision.md) | [app/Http/Controllers/HealthController.php](app/Http/Controllers/HealthController.php), [config/logging.php](config/logging.php) | [tests/Feature/ApiContractTest.php](tests/Feature/ApiContractTest.php) | [docs/observability_and_deploy.md](docs/observability_and_deploy.md), [docs/05_security_ops/deploy_runbook.md](docs/05_security_ops/deploy_runbook.md) |

## Notes

- This map is intended for review traceability and thesis defense walkthrough.
- It should be updated whenever a capability is added, removed, or materially changed.
