# Quality Attributes — PetForum

## Cel
Ez a dokumentum a rendszer legfontosabb nemfunkcionalis kovetelmenyeit es ket merheto scenariot rogzit.

## Attribútumok

1. Security
- Cel: csak jogosult felhasznalok erjenek el vedett muveleteket.
- Megvalositas: Laravel auth middleware, request validacio, role-check endpointoknal.
- Meres: tiltott muveletek 100%-a 403 valasszal ter vissza tesztben.

2. Performance
- Cel: esemenylista gyors betoltese normal terhelesen.
- Megvalositas: indexek, paginalas, egyszeru queryk, cache opciok.
- Meres: p95 latency cel <= 300 ms helyi benchmarkban.

3. Reliability
- Cel: alkalmazas hibaturoen mukodjon alap szolgaltatas kieses eseten.
- Megvalositas: health endpoint, exception logging, graceful error kezeles.
- Meres: /health endpoint minden deploy utan sikeres valaszt ad.

4. Maintainability
- Cel: konnyen modosithato kodbazis.
- Megvalositas: Laravel strukturalt retegek (Controller/Model/Request), ADR nyomkovetes, tesztek.
- Meres: regresszios hibak szama csokken, tesztcsomag zold marad refaktor utan.

5. Observability
- Cel: hibak gyors diagnosztizalasa.
- Megvalositas: JSON log channel, incident runbook, health endpoint.
- Meres: kritikus hibak root cause ideje < 30 perc demo/staging kornyezetben.

6. Data integrity
- Cel: ervenyes adatok keruljenek az adatbazisba.
- Megvalositas: migraciok, idegen kulcsok, Request validacio.
- Meres: tesztekben invalid input nem kerul mentesre.

## Merheto quality scenario 1 (Performance)
- Given: 30+ seedelt esemeny, futo alkalmazas lokalisan
- When: a felhasznalo megnyitja az esemenylista oldalt 50 ismertelten
- Then: a valaszido p95 <= 300 ms
- Meres modja: `hey` vagy `ab` smoke teszt eredmeny riporttal

## Merheto quality scenario 2 (Security)
- Given: normal user jogosultsag
- When: admin-only muveletet hiv (pl. komment torles admin policy mellett)
- Then: a rendszer 403 Forbidden valasszal reagal es audit log bejegyzest ir
- Meres modja: Feature test + log ellenorzes

## Nyitott teendok
- Performance smoke teszt script commitolasa
- Admin policy explicit tesztjeinek bovitese
- Log correlation ID hozzaadasa hibaanalizishez
