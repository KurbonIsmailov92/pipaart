# PIPAA CMS

PIPAA CMS is a Laravel 11 content management system for the Public Institute of Professional Accountants and Auditors. It rebuilds the legacy `pipaa.tj` structure into a modern admin-managed website with public pages, certifications, courses, schedule, news, gallery, contact information, and user management.

## Tech Stack

- Laravel 11
- PHP 8.2+
- Blade + Vite
- PostgreSQL or MySQL
- Laravel queues for contact delivery
- Tailwind/utility-based UI with reusable Blade components

## Main Features

- Public website sections:
  - Home
  - About
  - Certifications
  - Courses
  - Schedule
  - News
  - Gallery
  - Contact
- Admin CMS for:
  - Pages
  - Courses
  - Schedule
  - News
  - Gallery
  - Users
  - Settings
- Role-based access control:
  - `admin`
  - `teacher`
  - `student`
  - `guest`
- Queued contact workflow with stored messages
- Media uploads through Laravel Storage

## Roles

- `admin`: full CMS access, users, settings, gallery
- `teacher`: access to dashboard, pages, courses, schedule, news
- `student`: read-only public access
- `guest`: unauthenticated public access

## Setup

1. Install dependencies:

```bash
composer install
npm install
```

2. Create environment file for local development:

```bash
cp .env.example .env
php artisan key:generate
```

3. Configure database, mail, queue, and storage values in `.env`.

4. Run migrations and create the storage symlink:

```bash
php artisan migrate
php artisan storage:link
```

5. Start local development:

```bash
composer run dev
```

## Important Environment Variables

- `APP_URL`
- `APP_KEY`
- `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
- `DATABASE_URL` as an optional Railway-friendly alternative to the individual `DB_*` values
- `QUEUE_CONNECTION`
- `FILESYSTEM_DISK=public`
- `MAIL_MAILER`, `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`, `MAIL_PASSWORD`
- `CONTACT_RECIPIENT_EMAIL`
- `CONTACT_BACKUP_EMAIL`
- `CONTACT_PHONE`
- `CMS_SITE_NAME`

## Admin Usage

- Login through `/auth/login`
- Open `/admin`
- Manage public pages from `/admin/pages`
- Manage courses from `/admin/courses`
- Manage schedule from `/admin/schedules`
- Manage news from `/admin/news`
- Manage gallery from `/admin/gallery`
- Manage users from `/admin/users`
- Manage site settings from `/admin/settings`

## Deployment

Production deployment should use a real web server or container runtime. Do not use `php artisan serve`.

### Railway

This repository is configured for Railway-native Laravel deployment via `railway.json`.

- Railway is forced to use `RAILPACK`, so the service runs as a Laravel app with php-fpm and Caddy instead of the repo `Dockerfile`.
- `railway/pre-deploy.sh` runs `php artisan migrate --force`, `php artisan storage:link`, `php artisan config:cache`, and `php artisan view:cache`.
- `php artisan route:cache` is intentionally skipped because `routes/web.php` contains closure routes.
- `APP_KEY` must come from Railway Variables. No real `.env` file should be committed or required in Railway.
- `config/database.php` accepts either `DATABASE_URL` / `DB_URL` or the standard `DB_*` variables.
- Application defaults are intentionally bootstrap-safe: `SESSION_DRIVER=file`, `CACHE_STORE=file`, `QUEUE_CONNECTION=sync`. Switch them to database-backed values in Railway Variables if you want DB persistence for sessions, cache, or queues.

Deploy from GitHub:

1. Create a new Railway project.
2. Choose `Deploy from GitHub repo` and select this repository.
3. Add the required Railway Variables before the first real deploy.
4. Add a Postgres service in the same Railway project if you want Railway-managed Postgres.
5. Redeploy after variables are saved.
6. In `Settings -> Networking`, click `Generate Domain` to get the public `*.up.railway.app` URL.

Recommended Railway Variables:

- `APP_NAME=PIPAA`
- `APP_ENV=production`
- `APP_DEBUG=false`
- `APP_KEY=base64:...`
- `APP_URL=https://your-domain.com` or your Railway public domain until the custom domain is ready
- `LOG_CHANNEL=stderr`
- `LOG_LEVEL=info`
- `QUEUE_CONNECTION=database`
- `SESSION_DRIVER=database`
- `CACHE_STORE=database`
- `FILESYSTEM_DISK=public`
- `DB_CONNECTION=pgsql`
- `DATABASE_URL=${{Postgres.DATABASE_URL}}` or set `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` manually
- `DB_SCHEMA=public`
- `DB_SSLMODE=prefer`

App-specific variables you likely also want in Railway:

- `CMS_SITE_NAME`
- `CONTACT_RECIPIENT_EMAIL`
- `CONTACT_BACKUP_EMAIL`
- `CONTACT_PHONE`
- `CONTACT_ADDRESS`
- `MAIL_MAILER`, `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`, `MAIL_PASSWORD`, `MAIL_FROM_ADDRESS`
- `SMS_ENABLED`, `SMS_API_URL`, `SMS_API_TOKEN`, `SMS_TO`, `SMS_SENDER` if SMS is used

Generate an application key locally and paste it into Railway Variables:

```bash
php artisan key:generate --show
```

What not to do on Railway:

- Do not commit a production `.env`.
- Do not run `php artisan key:generate` during build or startup.
- Do not use `php artisan serve`.
- Do not run migrations from the web start command.

### Custom Domain

1. Open the app service in Railway.
2. Go to `Settings -> Networking -> + Custom Domain`.
3. Add your apex domain (for example `example.com`) and/or `www.example.com`.
4. Railway will show the exact DNS records required for that domain. Add exactly those records at your registrar or DNS provider.
5. Wait for Railway to verify the records and provision SSL automatically.

Suggested domain setup:

- Use the apex domain as the canonical `APP_URL`, for example `https://example.com`.
- Add `www.example.com` as a second custom domain if you want it.
- Redirect either `www` to apex or apex to `www` at your DNS/CDN layer so there is one canonical hostname.

### Migrations and Workers

- App deploys run migrations in `railway/pre-deploy.sh` before the new deployment starts serving traffic.
- If you need queued jobs in production, create a separate Railway worker service later that runs `php artisan queue:work`.
- If you need scheduled tasks, create a separate Railway cron service later that runs `php artisan schedule:work` or a cron-triggered `php artisan schedule:run`.

## Testing

Feature coverage includes:

- admin access control
- page and course CMS operations
- public page rendering
- contact form queuing and validation

Run tests with:

```bash
php artisan test
```

## Notes

- This project preserves the legacy information architecture while moving content into a maintainable CMS.
- Some legacy static sections may still exist in the repository for historical compatibility, but the main public site now centers on CMS-managed content.
