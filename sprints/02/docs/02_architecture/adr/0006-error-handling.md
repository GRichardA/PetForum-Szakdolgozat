# ADR 0006 — Error Handling and Logging

- Status: Accepted
- Date: 2026-04-18

## Context
A thesis kovetelmeny resze a hibak kovethetosege es diagnosztizalhatosaga.

## Decision
Laravel exception handling + validacios hibak standard valaszai maradnak, kiegeszitve JSON log channellel es incident runbook dokumentacioval.

## Consequences
- Elony: gyors hibadiagnosztika, reprodukalhato operational lepesek.
- Hatrany: metric/tracing hianyaban korlatozott melysegi elemzes.
- Mitigalasa: kovetkezo iteracioban p95/error-rate metrikak es request correlation ID.
