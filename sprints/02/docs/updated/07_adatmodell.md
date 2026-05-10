# Adatmodell

## Entitásleírás
| Entitás | Felelősség | Fontos mezők | Kapcsolatok | Validáció | Biztonsági megjegyzés |
|---|---|---|---|---|---|
| User | Azonosított szereplő | id, name, email, role | hasMany: pets, registrations | email formátum, szerepkör | saját profil módosítható csak sajátként |
| Pet | Felhasználóhoz tartozó állat | id, user_id, name, species, breed, vaccinated (bool) | belongsTo: user; hasMany: registrations | species in [dog,cat,...], breed string | csak tulaj módosíthatja |
| Event | Rendezvény | id, title, location, date, allowed_species (JSON), allowed_breeds (JSON), require_vaccinated (bool), capacity (int) | hasMany: registrations | capacity >=0, dates valid | csak szervező/admin szerkesztheti |
| Registration | Pet ↔ Event | id, user_id, pet_id, event_id, status | belongsTo: user, pet, event | status enum (registered,cancelled) | ownership check a törlésnél |
| Category | Esemény kategória | id, name | hasMany: events | name unique | readonly admin számára |
| Comment | Esemény komment | id, user_id, event_id, body | belongsTo: user,event | body not empty | XSS sanitizálás |

## Adatmodell döntések
- Adatbázis: relációs (MySQL) – a kapcsolatok és tranzakciók egyszerűbb kezelése miatt, valamint mert a projekt kisméretű és konzisztencia fontos.
- JSON mezők (`allowed_species`, `allowed_breeds`) az `events` táblában: rugalmas, mert eseményenként eltérő szabályok lehetnek; egyszerűbb implementációt ad az MVP-ben. Hátrány: nehezebb indexelni; ha skálázás jön, akkor külön referencia-tábla (event_allowed_breeds) javasolt.

## ERD (egyszerű leírás)
- `users` 1..* `pets`
- `users` 1..* `registrations`
- `pets` 1..* `registrations`
- `events` 1..* `registrations`

---

Javaslat a továbbfejlesztésre: ha sok lekérdezés lesz a fajtákra vagy rendezvény-szűrőkre, normalizáljuk a `allowed_breeds`-et külön táblába a hatékonyabb indexelésért.