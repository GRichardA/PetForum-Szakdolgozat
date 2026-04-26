# ADR 0004 — Gyorsítótárazási stratégia

- Állapot: Elfogadva
- Dátum: 2026-04-18

## Kontextus
Az eseménylista és a kategóriák gyakran lekért adatok. A célom egy egyszerű teljesítményjavítás elérése bonyolult gyorsítótár-érvénytelenítés (cache invalidation) nélkül.

## Döntés
Kezdetben minimális gyorsítótárazási stratégiát alkalmazok:
- Konfiguráció, útvonal (route) és nézet (view) cache-elés telepítéskor.
- Alkalmazásszintű adatgyorsítótár csak ott, ahol alacsony a változási gyakoriság (pl. kategóriák).

## Következmények
- Előny: egyszerű üzemeltetés, alacsony hibakockázat.
- Hátrány: nagy terhelésnél további optimalizációra lehet szükség.
- Mitigálása: később célzott lekérdezés-gyorsítótárazás (query cache) vezethető be kulcsalapú érvénytelenítéssel.