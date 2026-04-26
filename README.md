# PIPAA CMS

Laravel 11 CMS for the Public Institute of Professional Accountants and Auditors. The existing Blade-based public site and admin CMS are preserved, while routing, localization, media handling, migrations, tests, and deployment are hardened for production.

## Stack

- PHP 8.2+
- Laravel 11
- Blade + Vite
- Tailwind CSS
- SQLite for tests, PostgreSQL/MySQL in production

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

3. Configure your database and production-style basics in `.env`:

- `APP_URL`
- `APP_KEY`
- `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
- `FILESYSTEM_DISK=public`
- `LOG_CHANNEL=stderr` for container platforms

4. Run the app setup:

```bash
php artisan migrate --seed
php artisan storage:link
```

5. Start development:

```bash
composer run dev
```

## Admin Access

- Login URL: `/auth/login`
- Seeded admin email: `admin@admin.com`
- Seeded admin password: `password1234`

Production seeding is intentionally limited: `DatabaseSeeder` only upserts the admin user in production, while sample courses/news seed only outside production.

## Routing and Localization

- `/` redirects to `/ru`
- Public pages are localized under `/{locale}`
- Supported locales: `ru`, `tg`, `en`
- Auth routes stay outside the locale prefix under `/auth`
- Admin CMS lives under `/admin`

When generating public URLs in Blade or controllers, always pass the locale:

```php
route('courses.index', ['locale' => app()->getLocale()])
```

## Media Uploads

- Uploaded course, news, and gallery images use the `public` filesystem disk
- Public access expects `php artisan storage:link`
- Models expose a normalized `image_url` accessor that avoids duplicate `/storage/storage/...` paths
- Blade templates should use `$model->image_url` directly instead of wrapping it in `Storage::url()`

## Validation and Quality Checks

Run the full baseline locally:

```bash
composer validate
vendor/bin/pint --test
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
- `LOG_CHANNEL=stderr`
- `FILESYSTEM_DISK=public`

### Render

- Build command: `./render-build.sh`
- Start command: your container/web runtime start command
- `render-build.sh` only installs dependencies, builds assets, and caches config/routes/views
- Database migrations and seeding should happen in a release/start phase, not in the build phase

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
  - run `storage:link || true`
  - run `php artisan migrate --force`
  - run `php artisan db:seed --force`
  - start Apache

Do not rely on runtime APP key generation. Production containers must receive `APP_KEY` from environment variables or a mounted `.env`.

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

- Clear stale caches:

```bash
php artisan optimize:clear
php artisan route:clear
```

- Confirm `APP_KEY` is set
- Confirm the database is migrated

### SQLite migration fails on `courses_title_index`

- The translation migration is now SQLite-safe and non-destructive
- Re-run:

```bash
php artisan migrate:fresh --seed
```

If this still fails, verify you are on the latest code and not using an older cached migration file.

### Images are not showing

- Confirm `FILESYSTEM_DISK=public`
- Confirm `php artisan storage:link` has been run
- Check that the uploaded path exists under `storage/app/public`
- Use `$model->image_url` in Blade instead of `Storage::url($model->image_url)`

### News appears in admin but not publicly

Public news only shows posts where:

- `is_published = true`
- `published_at` is `null` or not in the future

Leaving `published_at` empty in the admin form publishes immediately.

### Missing required parameter: locale

- Public route generation must include `locale`
- Example:

```php
route('news.show', [
    'locale' => app()->getLocale(),
    'newsPost' => $newsPost,
])
```
