# Privacy and Licensing Baseline - PetForum

Date: 2026-04-25
Owner: [Your Name]
Scope: thesis quality evidence for privacy, dependency licensing, and dependency security status.

## 1) Personal data inventory

The application stores the following user-related data in MySQL:
- users.name
- users.email
- users.password (hashed)
- users.avatar (uploaded file path, optional)
- users.avatar_choice (selected default avatar id, optional)
- sessions.user_id
- sessions.ip_address
- sessions.user_agent

Additional content data that can contain personal information by user input:
- events.title, events.location, events.description
- comments.body

Sources in code:
- User model fillable and hidden fields
- users, sessions, events, comments migrations

## 2) Data handling principles

- Data minimization:
  - Only fields needed for authentication and core forum capability are stored.
  - No payment or special-category personal data is collected.
- Protection:
  - Password is stored hashed.
  - Auth uses Laravel session-based protection.
  - Production must run with APP_DEBUG=false.
- Logging discipline:
  - Do not log raw passwords, auth tokens, or full PII payloads.
  - Prefer structured logs and only operational fields.

## 3) Retention and deletion baseline

- Account data retention: until user account deletion request or project reset.
- Session data retention: framework-managed session lifecycle.
- Uploaded avatars: deleted when profile avatar is replaced or account removed (operational rule).
- Demo/staging reset policy: migrate:fresh --seed is allowed because it is non-production.

## 4) Data subject rights workflow (project baseline)

For thesis/demo scope, requests are handled manually by the maintainer:
- Access request: provide stored profile and related content snapshot.
- Correction request: user edits own profile via UI.
- Deletion request: maintainer removes account and related content according to FK rules.
- Response target time: 7 calendar days (demo SLA).

## 5) Dependency licensing evidence

Command executed:
- composer licenses --format=json

Observed status:
- Project license: MIT.
- Most dependencies: MIT.
- Also present: BSD-3-Clause and Apache-2.0.
- Dual-license package example (nette/*): BSD-3-Clause OR GPL-2.0-only OR GPL-3.0-only.

Risk note:
- For dual-license packages, the effective compatible option must be selected/documented (BSD-3-Clause in this project context).

## 6) Dependency security audit evidence

Commands executed:
- composer audit --no-interaction
- npm audit --omit=dev

Observed status:
- Composer audit: FAIL (5 advisories affecting 4 packages), including:
  - phpunit/phpunit (high)
  - league/commonmark (medium, multiple advisories)
  - psy/psysh (medium)
  - symfony/process (medium)
- NPM audit in local environment: failed to run because npm command is not available on this machine.

## 7) Required follow-up actions

Priority P1:
- Upgrade phpunit/phpunit to a non-affected version range.
- Upgrade league/commonmark to a non-affected version range.
- Upgrade symfony/process to a fixed version range.

Priority P2:
- Upgrade psy/psysh to a non-affected version.
- Re-run composer audit and archive output in docs.

Priority P3:
- Ensure Node.js/NPM availability in CI and run npm audit there.
- Add third-party asset attribution file if any avatar/icon source is external.

## 8) Compliance boundary statement

This baseline is for thesis/demo quality documentation, not legal advice.
Before production usage, a formal legal/privacy review is required for jurisdiction-specific obligations.
