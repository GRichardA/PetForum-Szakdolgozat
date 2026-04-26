# ADR 0007 — API Versioning Approach

- Status: Accepted
- Date: 2026-04-18

## Context
A projekt jelenleg web-first, de kesobb formalizalt API endpointok is szuksegesek lehetnek.

## Decision
A mostani iteracioban nem vezetunk be kulon API verziot, de a jovobeli API route-ok `api/v1` prefix alatt indulnak.

## Consequences
- Elony: egyszeru jelenlegi kodbazis, tiszta migracios ut.
- Hatrany: jelenleg nincs teljes OpenAPI-lefedett API reteg.
- Mitigalasa: kovetkezo merfoldkoben OpenAPI spec + contract tesztek bevezetese.
