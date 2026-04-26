# ADR 0005 — Profilkép tárolás

- Állapot: Elfogadva
- Dátum: 2026-04-18

## Kontextus
A felhasználók avatarokat töltenek fel a rendszerbe. Szükségem van ezek méretezésére és biztonságos kiszolgálására.

## Döntés
Az avatarokat a Laravel tárolórendszerében (storage) tárolom, szerveroldali méretezéssel (Intervention + GD fallback), és egyedi útvonalon keresztül szolgálom ki őket.

## Következmények
- Előny: kontrollált fájlhozzáférés, az útvonal-bejárásos (path traversal) kockázatok csökkentése.
- Hátrány: többlet alkalmazáslogikát és tárolási jogosultság-kezelést igényel.
- Mitigálása: feltöltési validáció, fájlméret-korlát, valamint tárolóegység (storage) állapotellenőrzés alkalmazása.