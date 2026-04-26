# ADR 0008 — Seeding stratégia demóhoz és teszteléshez

- Állapot: Elfogadva
- Dátum: 2026-04-18

## Kontextus
A bemutatóhoz valósághű, a tesztekhez pedig reprodukálható adatokra van szükségem.

## Döntés
Kettős adatfeltöltési (seeding) stratégiát alkalmazok:
- Demó seeder-ek valósághű esemény- és kategórianevekkel.
- Tesztfuttatások során gyári (factory) adatok izoláltan, a `RefreshDatabase` trait használata mellett.

## Következmények
- Előny: javul a demó minősége, a tesztek stabilabbak.
- Hátrány: két különböző adat-előkészítési útvonal karbantartási költsége.
- Mitigálása: dokumentált adatfeltöltési folyamat és egységes elnevezési konvenciók használata.