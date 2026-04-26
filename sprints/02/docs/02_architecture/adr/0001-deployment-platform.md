# ADR 0001 — Telepítési platform kiválasztása

- Állapot: Elfogadva
- Dátum: 2025-11-20

## Kontextus
A PetForum MVP (Laravel + MySQL) számára egy alacsony költségű, reprodukálható, IaC támogatással rendelkező telepítési környezetet kell biztosítanom.

## Döntés
Az AWS Free Tier-t választottam elsődleges célplatformnak (EC2 t2.micro osztálynak megfelelő gépet a demó környezetekhez).

## Alternatívák
- Railway/Heroku-szerű PaaS szolgáltatók: egyszerűbb beállítás, de az ingyenes korlátok szigorúbbak és kevesebb az IaC feletti kontroll.
- Osztott tárhely (Shared hosting): alacsony költség, de gyenge az IaC és a CI/CD integráció.
- Csak localhost: fejlesztésre alkalmas, de nem valódi telepítési stratégia.

## Következmények
- Előnyök: jó Terraform kompatibilitás, reprodukálható infrastruktúra-tervezés.
- Hátrányok: bonyolultabb beállítás egy egyszerű PaaS megoldáshoz képest.
- Kockázat: véletlen túllépés az ingyenes kereten, ami költségekkel járhat.