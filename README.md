# PIPAA CMS

Laravel 11 CMS for the Public Institute of Professional Accountants and Auditors. The current Blade UI is preserved while routing, localization, media handling, migrations, tests, and deployment are hardened for production use.

## Stack

- PHP 8.2+
- Laravel 11
- Blade + Vite
- Tailwind CSS
- SQLite for tests
- PostgreSQL or MySQL for production

## Local Setup

1. Install dependencies:

```bash
composer install
npm ci
```

2. Create the environment file and application key:

```bash
cp .env.example .env
php artisan key:generate
```

3. Configure `.env`:

- `APP_URL`
- `APP_KEY`
- `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
- `FILESYSTEM_DISK=public`
- `LOG_CHANNEL=stderr` for containers

4. Run the database setup and storage link:

```bash
php artisan migrate --seed
php artisan storage:link
```

5. Start local development:

```bash
composer run dev
```

## Public Routing

- `/` redirects to `/ru`
- Public pages live under `/{locale}`
- Supported locales: `ru`, `tg`, `en`
- Auth routes stay outside the locale prefix under `/auth`
- Admin routes live under `/admin`

When generating public URLs, always pass the locale:

```php
route('courses.show', [
    'locale' => app()->getLocale(),
    'course' => $course,
]);
```

## Admin Access

- Login: `/auth/login`
- Seeded admin email: `ADMIN_EMAIL` or `admin@pipaa.tj`
- Seeded admin name: `ADMIN_NAME` or `PIPAA Admin`
- Set `ADMIN_PASSWORD` in production secrets to control the deployed admin password

In production, only the admin account is seeded. Sample courses and sample news are seeded only outside production.

## Media Uploads

- Course, news, and gallery uploads use the `public` filesystem disk
- Public access requires `php artisan storage:link`
- Views should use `$model->image_url` directly
- Do not wrap `image_url` with `Storage::url()`

## Validation Commands

Run the same checks locally that CI runs:

```bash
composer validate
vendor/bin/pint --test
php artisan route:list
php artisan route:clear
php artisan route:cache
php artisan migrate:fresh --seed
php artisan test
npm run build
```

## Deployment

### Required Production Variables

- `APP_ENV=production`
- `APP_DEBUG=false`
- `APP_KEY=base64:...`
- `APP_URL=https://your-domain.example`
- `ADMIN_EMAIL=admin@pipaa.tj`
- `ADMIN_PASSWORD=...`
- `ADMIN_NAME="PIPAA Admin"`
- `LOG_CHANNEL=stderr`
- `FILESYSTEM_DISK=public`

### Render

- Use `./render-build.sh` as the build command
- `render-build.sh` installs dependencies, builds assets, clears stale optimize caches, and caches config/routes/views
- It does not start a server
- It does not run migrations or seeders in the build phase
- Use `bash ./render-release.sh` as the release/pre-deploy command so every deploy runs migrations and seeders

### Railway

- `railway/pre-deploy.sh` is the release-phase hook
- It runs:
  - `php artisan migrate --force`
  - `php artisan db:seed --force`
  - `php artisan storage:link || true`
  - `php artisan config:cache`
  - `php artisan route:cache`
  - `php artisan view:cache`

### Docker / Container Startup

- `docker/start.sh` will:
  - fail immediately if `APP_KEY` is missing
  - run `php artisan storage:link || true`
  - run `php artisan migrate --force`
  - run `php artisan db:seed --force`
  - start Apache

Production startup never generates a new runtime `APP_KEY`. Provide it through environment variables or a mounted `.env`.

`DatabaseSeeder` is safe to run repeatedly during deploys. It upserts the required admin user and skips sample content in production.

## CI

GitHub Actions runs:

- `composer install`
- `npm ci`
- `.env` bootstrap + `php artisan key:generate`
- `php artisan migrate:fresh --seed`
- `vendor/bin/pint --test`
- `php artisan test`
- `npm run build`

## Troubleshooting

### `/ru` returns `500`

Clear stale caches and confirm the app key and database are ready:

```bash
php artisan optimize:clear
php artisan route:clear
```

### SQLite migration fails around indexed translated columns

The translation migration keeps legacy text columns as backups instead of destructively dropping them. Re-run:

```bash
php artisan migrate:fresh --seed
```

### Images are not showing

- Confirm `FILESYSTEM_DISK=public`
- Confirm `php artisan storage:link`
- Check that the file exists under `storage/app/public`
- Use `$model->image_url` in Blade

### News is visible in admin but not public

Public news shows only records where:

- `is_published = true`
- `published_at` is `null` or not in the future

Leaving `published_at` empty in the admin form publishes immediately.

### Missing required parameter: locale

All public route generation must include `locale`:

```php
route('news.index', ['locale' => app()->getLocale()]);
```
