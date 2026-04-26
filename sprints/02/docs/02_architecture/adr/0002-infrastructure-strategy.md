# ADR 0002 — Infrastruktúra kódként (IaC) stratégia

- Állapot: Elfogadva
- Dátum: 2025-11-20

## Kontextus
A manuális infrastruktúra-beállítás nem reprodukálható, és növeli a konfigurációs eltérések (drift) kockázatát.

## Döntés
Terraformot használok az infrastruktúra definiálására és validálására (`validate`, `plan`) alapértelmezett mérnöki munkafolyamatként.

## Alternatívák
- Manuális beállítás a felhőszolgáltató konzolján keresztül.
- Eseti (ad-hoc) shell scriptek állapotkövetés nélkül.

## Következmények
- Előnyök: nyomon követhető, ellenőrizhető és reprodukálható infrastruktúra-változtatások.
- Hátrányok: plusz tanulási görbe és karbantartási igény az IaC miatt.
- Kockázatcsökkentés: a sablonokat a szakdolgozat keretein belül minimális szinten tartom, és a CI folyamatban validálom őket.