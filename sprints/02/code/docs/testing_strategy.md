Testing strategy

- Use PHPUnit (Laravel default) for Feature and Unit tests.
- Create Feature tests for: Event creation, Event show+comments, Comment store, Profile update, Auth flow.
- Run tests locally with:
```
php artisan test
# or
vendor/bin/phpunit
```
- CI should run tests in sqlite in-memory mode for speed: set `DB_CONNECTION=sqlite` and `DB_DATABASE=:memory:` in workflow during test step.

Test examples to implement:
- `tests/Feature/EventTest.php`: create event (happy path), missing fields.
- `tests/Feature/CommentTest.php`: posting comment requires auth.
- `tests/Feature/ProfileTest.php`: updating profile fields and avatar validation.
- `tests/Feature/AuthTest.php`: register/login/logout flow.
- `tests/Feature/AvatarUploadTest.php`: invalid type/file size.
