# UX Flows and Evidence Matrix

Date: 2026-04-25
Scope: formal UX flow documentation for thesis quality point 7.

## UX-01 Event discovery and filtering

Goal:
- User can browse upcoming events, filter by category, and search by keyword.

Entry:
- Route: /events

Primary flow:
1. User opens events list page.
2. User selects category filter or enters search text.
3. System returns filtered event cards.
4. User opens event details page.

Alternate paths:
- If no event matches, system shows explicit empty state and CTA.

UI evidence:
- [resources/views/events/index.blade.php](resources/views/events/index.blade.php)
- [docs/wireframes/readme.md](docs/wireframes/readme.md)

Test evidence:
- [tests/Feature/EventTest.php](tests/Feature/EventTest.php)

## UX-02 Registration and login

Goal:
- New user can register, then log in and continue protected actions.

Entry:
- Routes: /register, /login

Primary flow:
1. User submits registration form.
2. Account is created.
3. User logs in with credentials.
4. User is redirected to application flow.

Alternate paths:
- Duplicate email blocks registration with validation error.
- Wrong password returns to login with error.

UI evidence:
- [resources/views/auth/register.blade.php](resources/views/auth/register.blade.php)
- [resources/views/auth/login.blade.php](resources/views/auth/login.blade.php)

Test evidence:
- [tests/Feature/AuthTest.php](tests/Feature/AuthTest.php)
- [tests/Feature/E2EFlowTest.php](tests/Feature/E2EFlowTest.php)

## UX-03 Event creation

Goal:
- Authenticated user creates an event with category, date, and location.

Entry:
- Route: /events/create

Primary flow:
1. Authenticated user opens create form.
2. User fills title, category, date, location, description.
3. System validates and stores event.
4. User is redirected with success feedback.

Alternate paths:
- Guest user is redirected to login.
- Invalid category or missing fields produce validation errors.

UI evidence:
- [resources/views/events/create.blade.php](resources/views/events/create.blade.php)
- [docs/wireframes/readme.md](docs/wireframes/readme.md)

Test evidence:
- [tests/Feature/EventTest.php](tests/Feature/EventTest.php)
- [tests/Feature/E2EFlowTest.php](tests/Feature/E2EFlowTest.php)

## UX-04 Event ownership management

Goal:
- Event owner can edit/delete own events; non-owner cannot.

Entry:
- Routes: /events/{event}/edit, /events/{event}

Primary flow:
1. Owner opens event card actions.
2. Owner edits event and saves, or deletes event.
3. System applies change and redirects.

Alternate paths:
- Non-owner action is blocked and redirected to safe page.

UI evidence:
- [resources/views/events/index.blade.php](resources/views/events/index.blade.php)
- [resources/views/events/edit.blade.php](resources/views/events/edit.blade.php)

Test evidence:
- [tests/Feature/EventTest.php](tests/Feature/EventTest.php)

## UX-05 Comment and reply flow

Goal:
- Authenticated user can post comment and one-level reply under an event.

Entry:
- Route: /events/{event}

Primary flow:
1. User opens event detail page.
2. User submits comment.
3. Optional: user submits reply to parent comment.
4. System stores and renders comment tree.

Alternate paths:
- Guest user is redirected to login.
- Empty comment body fails validation.
- Invalid parent_id fails validation.

UI evidence:
- [resources/views/events/show.blade.php](resources/views/events/show.blade.php)
- [resources/views/events/_comment.blade.php](resources/views/events/_comment.blade.php)

Test evidence:
- [tests/Feature/CommentTest.php](tests/Feature/CommentTest.php)
- [tests/Feature/ApiContractTest.php](tests/Feature/ApiContractTest.php)

## UX-06 Profile and avatar management

Goal:
- Authenticated user updates profile and avatar (upload or default choice).

Entry:
- Route: /profile

Primary flow:
1. User opens profile edit page.
2. User updates name/email and optional password.
3. User uploads avatar file or chooses default avatar.
4. System saves profile and shows updated avatar.

Alternate paths:
- Guest cannot update profile.
- Duplicate email fails validation.
- Password confirmation mismatch fails validation.

UI evidence:
- [resources/views/profile/edit.blade.php](resources/views/profile/edit.blade.php)
- [public/images/avatars/default-avatar.svg](public/images/avatars/default-avatar.svg)
- [public/images/avatars/default-1.svg](public/images/avatars/default-1.svg)
- [public/images/avatars/default-2.svg](public/images/avatars/default-2.svg)

Test evidence:
- [tests/Feature/ProfileTest.php](tests/Feature/ProfileTest.php)
- [tests/Feature/AvatarUploadTest.php](tests/Feature/AvatarUploadTest.php)

## Traceability summary

- Product intent baseline: [docs/01_product/scope_contract.md](docs/01_product/scope_contract.md)
- API contract baseline for UI-backed data operations: [docs/api_contracts.md](docs/api_contracts.md)
- Quality evidence baseline: [docs/04_quality/test_report.md](docs/04_quality/test_report.md)

## Known gaps

1. Browser-level E2E framework is still not integrated (current flow evidence is feature-level).
2. Screenshot pack is referenced by wireframe descriptions, but no timestamped runtime screenshots are archived yet.
3. Accessibility audit evidence is not yet included in this flow pack.
