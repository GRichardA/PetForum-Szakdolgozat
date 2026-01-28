# ADR 0002 – Infrastruktúra Kezelési Stratégia (IaC)

## Dátum
2025-11-20

## Kontextus
A kézi szerverkonfigurálás (Manual ClickOps) nem reprodukálható és hibákhoz vezet. A projekt célja, hogy az infrastruktúra (szerver, hálózat) kódként legyen definiálva.

## Döntés
A **Terraform** eszközt használjuk az AWS infrastruktúra tervezésére. A Sprint 2-ben a cél a **Terraform Plan** sikeres futtatása (a terv validálása), a tényleges erőforrás-létrehozás (Apply) nélkül, költségkímélési okokból.

## Alternatívák
* **Shell Scriptek:** Nehézkes az állapotkezelés.
* **Kézi beállítás:** Nem felel meg a kurzus követelményeinek.

## Következmények
* A `infra/terraform` mappában definiáljuk az AWS providert és egy EC2 erőforrást.
* A CI pipeline-ban lefuttatjuk a `terraform validate` és `terraform plan` parancsokat, ezzel bizonyítva az IaC helyességét.