# ADR 0004 — Cache Strategy

- Status: Accepted
- Date: 2026-04-18

## Context
Az esemenylista es kategoriak gyakran olvasott adatok. A cel az egyszeru teljesitmenyjavitas bonyolult cache invalidacio nelkul.

## Decision
Kezdetben minimalis cache-strategiat alkalmazunk:
- konfiguracio/route/view cache deploykor,
- alkalmazas szintu adatkache csak ott, ahol alacsony a valtozasi frekvencia (pl. kategoriak).

## Consequences
- Elony: egyszeru uzemeltetes, alacsony hibakockazat.
- Hatrany: nagy terhelesnel tovabbi optimalizacio kellhet.
- Mitigalasa: kesobb targeted query cache bevezetese kulcsalapu invalidacioval.
