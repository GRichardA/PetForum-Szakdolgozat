# Modulok, interfészek és API

## Modulfelelősségek

| Modul | Felelősség | Publikus interfész | Függőségek | Tesztelési mód |
|---|---|---|---|---|
| **AuthService** (bootstrap, middleware) | Hitelesítés, session | middleware auth, user auth()->user() | Laravel Auth | Unit + Feature (TC-01) |
| **PetService** (app/Services) | Pet lifecycle validáció | store(), update(), delete() | PetModel, UserModel | Unit test PetService |
| **RegistrationService** | Regisztráció validáció (fajta, oltás, kapacitás) | validateRegistration(), register() | PetModel, EventModel, Registration | Feature test (TC-05, TC-06) |
| **EventService** | Esemény szűrés, kapacitás-check | canRegisterPet(), isFull() | EventModel, CategoryModel | Feature + Unit |
| **CommentModerator** | Komment szűrés, HTML sanitizálás | sanitize(), isValid() | HtmlPurifier lib | Unit test |
| **PetPolicy** | Pet ownership ellenőrzés | can(view/edit/delete, pet, user) | Eloquent Policy | Unit test (TC-SEC-02) |
| **EventPolicy** | Event szervezői jogosultság | can(edit/delete, event, user) | Eloquent Policy | Unit test |

## API végpontok (web routes + opcional JSON)

| Végpont | Metódus | Auth | Request | Response | Hibakódok | Kapcsolódó követelmény | Teszt |
|---|---|---|---|---|---|---|---|
| `/login` | GET | nincs | - | Login form | - | FK-01 | TC-01 |
| `/login` | POST | nincs | email, password | session/token, redirect | 401 | FK-01 | TC-01 |
| `/logout` | POST | auth | CSRF token | redirect / | - | FK-01 | TC-01 |
| `/pets` | GET | auth | - | pets list view | 401 | FK-02 | TC-02 |
| `/pets/create` | GET | auth | - | form view | 401 | FK-02 | TC-02 |
| `/pets` | POST | auth | name, species, breed, vaccinated | pet created, redirect | 422 (validation), 401 | FK-02 | TC-02 |
| `/pets/{id}/edit` | GET | auth | id | form prefilled | 403 (not owner), 404 | FK-02 | TC-03 |
| `/pets/{id}` | PUT | auth | name, species, breed, vaccinated | pet updated, redirect | 422, 403, 404, 401 | FK-02 | TC-03 |
| `/pets/{id}` | DELETE | auth | CSRF | redirect, deleted | 403, 404, 401 | FK-02 | TC-03 |
| `/events` | GET | - | category, search | events list | - | FK-03 | TC-04 |
| `/events/{id}` | GET | - | id | event detail view | 404 | FK-04 | TC-04, TC-05 |
| `/events/create` | GET | auth, admin | - | form view | 401, 403 | FK-03 | TC-04 |
| `/events` | POST | auth, admin | title, allowed_species, allowed_breeds, require_vaccinated, capacity, ... | event created | 422, 401, 403 | FK-03 | TC-04 |
| `/registrations` | POST | auth | pet_id, event_id | registration created | 422 (not eligible), 400 (capacity), 401, 403 (pet owner) | FK-04 | TC-05, TC-06 |
| `/registrations/{id}` | DELETE | auth | id | registration deleted | 403 (not owner), 404, 401 | FK-05 | TC-07 |
| `/comments` | POST | auth | event_id, body | comment created | 422, 401 | FK-07 | TC-09 |
| `/admin/events/{id}` | DELETE | auth, admin | id | event deleted | 403 (admin), 404, 401 | FK-06 | TC-08 |

## Modell-interfészek (Eloquent Model relations)

### User Model
```php
class User extends Authenticatable {
    public function pets() // 1:N
    public function registrations() // 1:N
    public function comments() // 1:N
    public function isAdmin(): bool
}
```

### Pet Model
```php
class Pet extends Model {
    public function user() // N:1
    public function registrations() // 1:N
    public function isVaccinated(): bool
}
```

### Event Model
```php
class Event extends Model {
    public function registrations() // 1:N
    public function category() // N:1
    public function canRegisterPet(Pet $pet): bool // fajta, oltás, kapacitás
    public function isFull(): bool
    public function availableSpots(): int
    public $casts = ['allowed_species' => 'json', 'allowed_breeds' => 'json']
}
```

### Registration Model
```php
class Registration extends Model {
    public function user() // N:1
    public function pet() // N:1
    public function event() // N:1
    public function canBeCancelledBy(User $user): bool
}
```

## Hibakezelési interfész

| Hiba | HTTP kód | Üzenet | Kezelés |
|---|---|---|---|
| Nem hitelesített | 401 | "Kérjük, jelentkezz be" | Redirect /login |
| Nincs jogosultság | 403 | "Nem módosíthatod ezt az erőforrást" | Blade error view |
| Nem található | 404 | "Az erőforrás nem létezik" | Blade 404 view |
| Validáció hiba | 422 | Field-specifikus üzenetek | Blade form back(), errors() |
| Szerver hiba | 500 | "Szerver hiba, próbáld később" | Log + error view |

## DTO-k (Data Transfer Objects) — opcionális, de javasolt

```php
// Az MVP egyszerűsége miatt nem kötelező, de dokumentáció:
class RegisterPetDTO {
    public string $name;
    public string $species; // 'dog', 'cat', etc.
    public string $breed;
    public bool $vaccinated;
}

class RegisterToEventDTO {
    public int $petId;
    public int $eventId;
    public ?int $specialRequests; // null vagy notes text
}
```

## Összefoglalás
A modulok és interfészek egyértelműek és szeparáltok — így a tesztelés, fejlesztés és skálázás később könnyebb lesz.