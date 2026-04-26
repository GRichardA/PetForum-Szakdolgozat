# ADR 0006 — Hibakezelés és naplózás

- Állapot: Elfogadva
- Dátum: 2026-04-18

## Kontextus
A thesis kovetelmeny resze a hibak kovethetosege es diagnosztizalhatosaga.

## Döntés
Laravel exception handling + validacios hibak standard valaszai maradnak, kiegeszitve JSON log channellel es incident runbook dokumentacioval.

## Következmények
- Elony: gyors hibadiagnosztika, reprodukalhato operational lepesek.
- Hatrany: metric/tracing hianyaban korlatozott melysegi elemzes.
- Mitigalasa: kovetkezo iteracioban p95/error-rate metrikak es request correlation ID.
