Tesztelési stratégia

- Használd a PHPUnit-ot (Laravel alapértelmezés) Feature és Unit tesztekhez.
- Hozz létre Feature teszteket: Event létrehozás, Event megjelenítés+kommentek, Komment tárolás, Profil frissítés, Auth folyamat.
- Futtasd a teszteket helyileg:
```
php artisan test
# vagy
vendor/bin/phpunit
```
- CI-nek a teszteket sqlite memória módban kell futtatnia a gyorsaság érdekében: állítsd be a `DB_CONNECTION=sqlite` és `DB_DATABASE=:memory:` értékeket a workflow teszt lépésében.

Implementálandó teszt példák:
- `tests/Feature/EventTest.php`: event létrehozás (happy path), hiányzó mezők.
- `tests/Feature/CommentTest.php`: komment írás auth-t igényel, komment törlés (owner/admin jogosultság, kaszkádos törlés).
- `tests/Feature/AdminTest.php`: admin irányítópult, kategória CRUD, esemény moderálás.
- `tests/Feature/ProfileTest.php`: profil mezők frissítés és avatár validáció.
- `tests/Feature/AuthTest.php`: regisztráció/bejelentkezés/kijelentkezés folyamat.
- `tests/Feature/AvatarUploadTest.php`: érvénytelen típus/fájl méret.
- `tests/Feature/MiddlewareTest.php`: admin middleware jogosultság ellenőrzés.
- `tests/Unit/UserTest.php`: user admin szerepkör hozzárendelés és alapértelmezések.
- `tests/Unit/EventTest.php`: event dátum casting és Carbon formázás.
