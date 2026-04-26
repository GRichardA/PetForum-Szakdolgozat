# Scope Contract — PetForum

## MVP user story lista (3-6)
1. Mint autentikált felhasználó, szeretnék eseményt létrehozni cím, dátum, helyszín és kategória megadásával, hogy mások csatlakozzanak.
   - Acceptance: validációs hibák kezelve, sikeres mentés visszajelzéssel, redirect az esemény oldalra.
2. Mint felhasználó, szeretnék eseményeket keresni cím és leírás alapján, valamint kategória szerint szűrni.
   - Acceptance: releváns találatok, kategoriák dropdown működik.
3. Mint bejelentkezett felhasználó, szeretnék kommentelni események alatt, reply-ket létrehozni, hogy beszélgetések alakuljanak.
   - Acceptance: komment mentése, 1 szint mélységű válasz, megjelenik a kommentek listájában.
4. Mint admin, szeretnék moderálni kommenteket (törlés), hogy a közösség tiszta maradjon.
   - Acceptance: admin jogosultsággal rendelkező felhasználó törölni tud kommentet.
5. Mint felhasználó, szeretném szerkeszteni a profilomat és feltölteni avatart, amely szerveroldalon át lesz méretezve.
   - Acceptance: avatar feltöltés, fallback alapértelmezett avatar, 256x256 méretű képek.

## Stretch (opcionális)
- Eseményhez RSVP/ résztvevők kezelése.
- E-mail értesítések esemény létrehozásról.

## Korlátok
- Lokális demo/prototípus; nem szükséges cloud üzemeltetés.
- Nem bonyolított integrációk (nem használunk külső fizetési szolgáltatást).

## Definition of Done (DoD)
- Minden user story-hoz van automata teszt (feature vagy unit), és a CI zöld.
- README quickstart működik friss klónon (composer install, migrate --seed, php artisan serve).
- Dokumentáció (vision, scope, AI logs, deploy runbook) megléte a `docs/` alatt.

## Acceptance testing
- Parancsok és lépések a reviewer számára: `composer install`, `php artisan migrate --seed`, `php artisan serve`, nyisd meg `http://127.0.0.1:8000` és kövesd demo scriptet (docs/06_release/demo_script.md).

## Related release and evidence docs
- Capability-evidence map: `docs/01_product/capability_evidence_map.md`
- Demo script: `docs/06_release/demo_script.md`
- Metrics baseline: `docs/06_release/metrics.md`
