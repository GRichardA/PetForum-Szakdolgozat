Observability and deploy (summary)

- Logging: configure Monolog to write JSON-formatted logs to `storage/logs/laravel.log` (see `config/logging.php`).
- Error tracking: integrate Sentry (composer require sentry/sentry-laravel), set `SENTRY_DSN` in `.env` for prod.
- Health endpoint: add `GET /health` that checks DB connectivity and storage writability.
- CI/CD: use GitHub Actions to run tests and optionally deploy to a hosting provider (Heroku, Fly.io, Vercel for PHP via adapter).

Health endpoint example:
- Response 200 { status: "ok", database: "ok", storage: "writable" }

Deploy checklist:
- Set `APP_ENV=production`, `APP_DEBUG=false`, set correct DB creds.
- Run `php artisan migrate --force` on deploy and seed if needed.
- Ensure storage is writable and `storage:link` exists or use cloud storage.
