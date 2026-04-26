# Vision — PetForum

## Probléma
Helyi állattartó közösségeknek nehéz megtalálni és szervezni helyi eseményeket (találkozók, vásárok, oltási akciók), nincs könnyű és közösség-orientált platform erre.

## Célfelhasználó (persona)
- "Anna", 28, macskatartó, szeret helyi találkozókat szervezni. Célja: gyorsan létrehozni eseményt, meghívni résztvevőket és moderálni a kommenteket.
- "Gábor", 42, kutyás, szeret keresni témák/tevékenységek szerint (pl. agility tréning). Célja: gyorsan találni releváns eseményeket.

## Értékajánlat
PetForum: gyors, könnyen használható webes platform helyi állatközösségek eseményeinek létrehozására, keresésére és megbeszélésére — egyszerű profilokkal és moderációs eszközökkel.

## North Star & guardrails
- North Star: havi aktív eseményteremtők száma (MAU of event creators).
- Guardrails: success rate of event creation (>= 95%), average event listing load p95 < 300ms.

## Non-goals
- Nem cél a mobil natív app fejlesztése a leadás részeként.
- Nem integrálunk fizetési megoldást vagy komplex külső API-kat (pl. teljes Google Maps API).

## Mérés
- Esemény létrehozások száma / hét
- Felhasználói retention (7 nap)
- Event list p95 latency (benchmark)
