# Biztonsági minimum

## Ellenőrző lista
| Terület | Kötelező ellenőrzés | Bizonyíték | Eredmény |
|---|---|---|---|
| XSS | minden megjelenített felhasználói input escape-elt / sanitizált | blade `{{ }}` és `e()` használat; Comment sanitizer | OK |
| Injection | adatbázis és API paraméterek validáltak | FormRequest/validator + prepared statements (Eloquent) | OK |
| Credential | nincs titok repo-ban, `.env.example` van | `.gitignore`, secret-scan eredmény | javítandó (ellenőrzés javasolt) |
| AAA | authentication (Laravel), authorization (policies), accounting (audit log) | `PetPolicy`, ownership checks, `canBeCancelledBy()` | OK |
| CSRF | űrlapok CSRF tokennel | `@csrf` blade + middleware | OK (tesztkörnyezetben a token kezelése külön) |

## Konkrét védelmi elemek és kódrészletek
- Ownership check: a `PetController` és `RegistrationController` ellenőrzi, hogy az érintett `Pet` a bejelentkezett userhez tartozik (401/403 visszaadva). Ezt Unit/Feature tesztek is lefedik.
- Input validáció: minden felhasználói űrlap `FormRequest`-en keresztül validál (pl. `RegisterPetRequest`, `RegisterToEventRequest`) — mezőszintek, enumok, dátumok ellenőrizve.
- XSS elleni védelem: blade templating automatikusan escapeli a kimenetet; kommenteknél HTML-t csak whitelist-szel engedünk (ha kell).
- Secrets: `.env` nincs verziókezelésben; `.env.example` tartalmazza a szükséges kulcsokat. Javasolt: GitHub secret scan futtatása és CI titok-scan pipeline.

## Ajánlott teendők
- CI-be titok-ellenőrzést integrálni (GitHub Actions + secret-scan).
- Részletes audit-log (ki, mikor, mit módosított) bevezetése kritikus műveleteknél (törlés, admin műveletek).

---

A dolgozathoz mellékelj környezetkonfigurációs részletet (auth/roles, policies kódrészletek) és 2-3 konkrét kódrészletet, amit be tudsz csatolni a mellékletben.