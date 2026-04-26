# ADR 0005 — Avatar Image Storage

- Status: Accepted
- Date: 2026-04-18

## Context
A felhasznalok avatarokat toltenek fel. Szukseg van meretezesre es biztonsagos kiszolgalasra.

## Decision
Az avatarokat a Laravel storage rendszerben taroljuk, szerveroldali meretezessel (Intervention + GD fallback), es route-on keresztul szolgaljuk ki.

## Consequences
- Elony: kontrollalt file-hozzaferes, path traversal kockazat csokkentese.
- Hatrany: plusz alkalmazas logika es storage jogok kezelese.
- Mitigalasa: upload validacio, file size limit, health/storage ellenorzes.
