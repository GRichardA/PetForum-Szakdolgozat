# ADR 0001 – Deployment Platform Kiválasztása

## Dátum
2025-11-20

## Kontextus
A PetShop MVP (PHP/Laravel + Tailwind CSS + MySQL) üzemeltetéséhez szükség van egy szerverre és adatbázisra. Kiemelt szempont a **költséghatékonyság (ingyenesség)** a fejlesztés korai szakaszában, valamint az, hogy a választott platform támogassa az Infrastructure as Code (IaC) eszközöket a kurzus követelményei szerint.

## Döntés
Az **AWS (Amazon Web Services) Free Tier** megoldását választjuk, konkrétan egy **EC2 t2.micro** instancot (virtuális gépet).

## Alternatívák
* **Railway / Heroku:** Könnyű kezelni, de az ingyenes sávok korlátozottak (időben vagy erőforrásban), és a MySQL adatbázis gyakran fizetős kiegészítő.
* **Ingyenes Tárhely (pl. 000webhost):** Teljesen ingyenes PHP/MySQL, de **nem támogatja a Terraformot** és a modern CI/CD folyamatokat (csak FTP-t), így nem felel meg a mérnöki követelményeknek.
* **Saját gép (Localhost):** Fejlesztéshez tökéletes, de nem "deployment" célpont. (A demóhoz ezt használjuk, de a tervben felhős környezetet célzunk meg).

## Következmények
* **Pozitív:** Az AWS 12 hónapig ingyenesen biztosít EC2 szervert, amin futhat a PHP és a MySQL. A Terraform támogatottsága kiváló, így teljesíthető az IaC követelmény.
* **Negatív:** Az AWS beállítása bonyolultabb, mint egy PaaS szolgáltatóé, de tanulási szempontból értékesebb.
* **Kockázat:** Ha túllépjük az ingyenes keretet, költség merülhet fel (de mivel a Sprintben csak `terraform plan`-t futtatunk, `apply`-t nem, ez a kockázat 0).