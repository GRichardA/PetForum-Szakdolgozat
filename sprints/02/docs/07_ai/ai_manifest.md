# AI Manifest

Projekt: PetForum
Dátum: 2026-04-18
Szerző: [A te neved]

## Rövid leírás
Ez a dokumentum felsorolja az AI eszközöket és azokat a területeket, ahol AI-t használtunk a PetForum fejlesztésében.

## Használt eszközök
- ChatGPT (OpenAI) – promptok generálása: architektúra javaslatok, kódminták, dokumentáció vázlatok.
- GitHub Copilot – inline kódjavaslatok refaktorálásnál és repetitív kódnál.

## Használati területek
- Tervezés: MVP story-k és capability ötletek.
- Kódgenerálás: kisebb helper függvények, tesztminták kezdéshez.
- Dokumentáció vázlatok: README, vision, scope contract vázlatok.
- Tesztötletek és verifikációs javaslatok.

## Korlátozások és tiltások
- Soha nem küldtünk PII-t vagy titkos kulcsokat a promptokba.
- Kritikus biztonsági döntéseket az AI javaslata alapján nem automatikusan fogadtunk el; minden ilyen javaslatot manuálisan ellenőriztünk és teszteltünk.

## Kritikus döntések (példák)
- Avatar processing fallback: Intervention Image használata + GD fallback (a döntést manuálisan validáltuk és verifikáltuk tesztekkel).
- Auth: beépített Laravel session auth használata a helyi fejlesztéshez (nem külső OAuth) — egyszerűbb reproduce és grading célokra.

## Hogyan dolgoztunk AI-val (folyamat)
1. Prompt terv és kontextus megadása (repo részletek, célok).
2. AI válasz feldolgozása: javaslatok listázása és manuális reviú.
3. Implementáció: kód írása/refaktorálása emberi fejlesztő által.
4. Verifikáció: automatizált tesztek vagy manuális PoC futtatása (lásd verification_log.md).


---
Nyomkövetés: a `docs/07_ai/prompt_log.md` és `docs/07_ai/verification_log.md` fájlok tartalmazzák az egyedi promptokat és verifikációs bejegyzéseket.