# ADR 0003 — Hitelesítési stratégia

- Állapot: Elfogadva
- Dátum: 2026-04-18

## Kontextus
A projektem jelenleg egy Blade-alapú webalkalmazás, ahol a legfontosabb folyamat a bejelentkezés utáni védett CRUD műveletek kezelése.

## Döntés
Laravel session-alapú hitelesítést használok (beépített auth middleware), nem pedig JWT/OAuth alapú API hitelesítést.

## Következmények
- Előny: egyszerűbb implementáció, gyorsabb szakdolgozati reprodukció, kevesebb infrastruktúra-függőség.
- Hátrány: a külső kliensek API hitelesítési skálázhatósága korlátozottabb.
- Mitigálása: később külön API hitelesítési réteg bevezetése lehetséges.