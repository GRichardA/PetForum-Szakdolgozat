# ADR 0008 — Seeding Strategy for Demo and Testing

- Status: Accepted
- Date: 2026-04-18

## Context
A demonstraciohoz realisztikus, a tesztekhez reprodukalhato adatok kellenek.

## Decision
Dualis seeding strategiat alkalmazunk:
- demo seederek realisztikus esemeny/kategoria nevekkel,
- tesztfuttatasban gyari/factory adatok izolaltan, RefreshDatabase mellett.

## Consequences
- Elony: demo minoseg javul, tesztek stabilabbak.
- Hatrany: ket adatelokeszitesi utvonal karbantartasi koltsege.
- Mitigalasa: dokumentalt seeding flow es egységes naming konvencio.
