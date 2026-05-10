# Piaci / területi elemzés

## Cél
Az elemzés azt mutatja, hogy mely meglévő megoldások léteznek, és hol az értékünk. A saját MVP döntéseire ez az analízis alapoz.

## Összehasonlító elemzés – Kisállat-közösségi rendezvények

| Megoldás | Célcsoport | Fő funkciók | Erősségek | Hiányosságok | UX tanulság | Technológiai tanulság | Saját rendszerre következtetés |
|---|---|---|---|---|---|---|---|
| **Meetup.com** | Általános közösségi események | Eseménylista, RSVP, chat, csoport | Nagy közösség, keresés | Nincs pet-specifikus filter, nem magyar | Egyértelmű RSVP flow | Robosztus backend, skálázás | Kell magyar UI, pet-domain |
| **Facebook Events** | Általános felhasználók | Esemény, meghívók, foto, komment | Integrált social | Nem szakosított (nem állat-barát) | Fényképek és érzelmek | Milliós skálázás | Nem szabad másolni, saját niche jobb |
| **Eventbrite** | Ticketed events | Jegyvásárlás, regisztráció, report | Fizetés, analytics | Komplex UI, nem ingyenes API | Paid model | SaaS infrastruktúra | MVP: ingyenes, egyszerű |
| **Helyi állatvédő szervezetek** | Speciális közösség | Email lista, szóbeszéd, papíralapú | Bizalom, személyes | Nincs digitális platform, alacsony UX | Személyes kapcsolat | Nincs | **Digitális megoldás hiánya = értéklehetőség** |
| **Saját MVP** | Hobbiállat-tulajdonosok | Pet CRUD, esemény pet-paraméterekkel, regisztráció, komment | Egyszerű, pet-fókusz, magyar | Kevés felhasználó, induló | Clear pet selector és regisztráció | Relációs DB + Laravel + Blade | **Niche, de jól támogatott domain** |

## Piaci szegmentáció és hiányok
- **Megállapítás 1**: A nagy platformok (Meetup, Facebook) nem szakosított pet-domain támogatást nyújtanak → ha mégis szükséges szűrés, az user-side vagy event descriptionban történik.
- **Megállapítás 2**: Helyi állatvédelmi szervezeteknek nincs dedikált digitális platform → e-mail és szóbeszéd maradt.
- **Megállapítás 3**: Az MVP értéke a pet-specifikus paraméterek (fajta, oltottság) és a magyar interface.

## Saját MVP vonzódi

1. **Szakosított domén**: Pet regisztráció, fajta-szűrés, oltottság-validáció.
2. **Magyar nyelvűség**: Kulcsfontosságú a helyi közösségeknek.
3. **Egyszerűség**: Nem versenyez Meetup-pal, hanem egyedi niche-et tölt be.
4. **Karbantarthatóság**: Szándékosan kicsi és nyíltvégű a fejlesztéshez.

## Konklúzió
- Mi a saját rendszer értéke? → **Pet-domén + magyar + egyszerűség**
- Mit szalvírozunk a versenytársaktól? → **Egyértelmű UX, RSVP megoldás, közösségi funkciók karete**
- Mit kerülünk? → **Túlösszetetség, fizetési modell, scammesítés**
- Milyen UX hibákat kerülünk el? → **Nem felhasználó-fókuszú keresés; összekavarva pet-param nincs**