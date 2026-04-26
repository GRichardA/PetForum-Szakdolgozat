# ADR 0001 — Deployment Platform Selection

- Status: Accepted
- Date: 2025-11-20

## Context
The PetForum MVP (Laravel + MySQL) needs a reproducible deployment target with low cost and IaC support.

## Decision
Use AWS Free Tier as the primary target platform (EC2 t2.micro class equivalent for demo environments).

## Alternatives
- Railway/Heroku-like PaaS: easier setup, but free-tier limits and less IaC control.
- Shared hosting: low cost, but weak IaC and CI/CD integration.
- Localhost only: suitable for development but not a deployment strategy.

## Consequences
- Pros: good Terraform compatibility, reproducible infra planning.
- Cons: more setup complexity than simple PaaS.
- Risk: accidental cost overrun if free limits are exceeded.
