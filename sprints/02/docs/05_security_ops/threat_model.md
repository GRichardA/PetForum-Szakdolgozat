# Threat Model (STRIDE) — PetForum

Dátum: 2026-04-18
Szerző: [A te neved]

Cél: azonosítani a legfontosabb fenyegetéseket és mitigációkat a PetForum webalkalmazás számára.

| STRIDE kategória | Fenyegetés | Hatás | Valószínűség | Mitigáció | Verification (hogyan ellenőrizzük) |
|---|---|---:|---:|---|---|
| Spoofing (Identity) | Ellopott session cookie / weak passwords | Jogosulatlan hozzáférés, account takeover | Medium | HTTPS-only cookie, secure session settings, rate-limit login, strong password policy, optional 2FA for admins | Auth tests, session cookie flags ellenőrzése, pentest checklist |
| Tampering (Data tampering) | Manipulált API requestek (pl. jogosultság nélküli módosítás) | Adatinkonzisztencia, jogosultsági kiterjesztés | Medium | Server-side authorization checks (gates/policies), input validation, use of policies/gates in controllers | Authorization tests (attempt forbidden actions), code review az gates használatára |
| Repudiation (Non-repudiation) | Felhasználói műveletek naplózásának hiánya | Nehéz visszakövetni visszaélés esetén | Low-Medium | Audit log basic examples for critical actions (create/delete event, delete comment) | Manual log inspection és unit tesztek, log minták a docs-ban |
| Information Disclosure | PII leak in logs or error messages | Privacy breach, GDPR issues | Medium | Avoid logging PII, mask sensitive data, ensure error responses not leaking stack traces in prod | Log scan for PII, review error responses in staging |
| Denial of Service | Excessive requests to events index or image upload endpoint | Service slowdown, poor UX | Medium | Rate limiting (per IP), validate upload size, queue heavy jobs, fast-fail on large uploads | Load test smoke (hey/ab) and observe p95; simulate large uploads |
| Elevation of Privilege | Missing checks allow normal user to perform admin actions | Data deletion or configuration change | Low-Medium | Proper role checks (middleware), use `can`/policies, tests for admin-only endpoints | Authorization test suite covering admin vs user actions |

## Kiegészítő megjegyzések
- Secrets: minden titok `.env`-ben, nincs commitolva. CI uses secrets store.
- Image uploads: limit file types (jpg/png/webp), max size 2MB, scan filename for path traversal.
- Backup/restore: dokumentálni kell a DB backup folyamatot (runbook részletek).

## Prioritás és következő lépések
1. Implement role-based policies + unit tests (high priority).
2. Add rate-limiting middleware on upload and search endpoints (medium priority).
3. Add simple audit logging for create/delete actions (low-medium priority).

## Verification checklist (quick)
- [ ] Auth tests cover forbidden actions (403 expected).
- [ ] No PII appears in `storage/logs/laravel.log` during normal flows.
- [ ] Upload endpoint rejects >2MB files.
- [ ] Health endpoint does not return stack traces on failure.
