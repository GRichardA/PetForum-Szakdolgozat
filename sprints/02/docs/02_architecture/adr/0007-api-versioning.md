# ADR 0007 — API verziózási megközelítés

- Állapot: Elfogadva
- Dátum: 2026-04-18

## Kontextus
A projekt jelenleg web-központú, de később szükségem lehet formalizált API végpontokra is.

## Döntés
A jelenlegi iterációban nem vezetek be külön API verziót, de a jövőbeli API útvonalakat az `api/v1` előtag alatt indítom el.

## Következmények
- Előny: egyszerű jelenlegi kódalap, tiszta migrációs út.
- Hátrány: jelenleg nincs teljes OpenAPI-lefedettségű API réteg.
- Mitigálása: a következő mérföldkőben OpenAPI specifikáció és szerződésalapú (contract) tesztek bevezetése várható.