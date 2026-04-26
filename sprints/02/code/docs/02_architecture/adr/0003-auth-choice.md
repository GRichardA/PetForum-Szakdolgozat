# ADR 0003 — Authentication Strategy

- Status: Accepted
- Date: 2026-04-18

## Context
A projekt jelenleg Blade-alapu webalkalmazas, ahol a legfontosabb flow a bejelentkezes utan vedett CRUD muveletek kezelese.

## Decision
Laravel session-based authentikaciot hasznalunk (beepitett auth middleware), nem JWT/OAuth alapu API authot.

## Consequences
- Elony: egyszerubb implementacio, gyorsabb thesis-reprodukcio, kevesebb infrastrukturafugges.
- Hatrany: kulso kliens API auth skala korlatozottabb.
- Mitigalasa: kesobb kulon API auth reteg bevezetese lehetseges.
