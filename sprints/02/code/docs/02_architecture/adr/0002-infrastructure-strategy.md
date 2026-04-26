# ADR 0002 — Infrastructure as Code Strategy

- Status: Accepted
- Date: 2025-11-20

## Context
Manual infrastructure setup is not reproducible and increases configuration drift risk.

## Decision
Use Terraform for infrastructure definition and validation (`validate`, `plan`) as the default engineering workflow.

## Alternatives
- Manual ClickOps setup in cloud console.
- Ad-hoc shell scripts without state tracking.

## Consequences
- Pros: traceable, reviewable, reproducible infra changes.
- Cons: additional IaC learning and maintenance effort.
- Risk mitigation: keep templates minimal during thesis scope and validate in CI.
