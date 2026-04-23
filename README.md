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

2. Create environment file:

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
- `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
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

Recommended flow:

1. Build frontend assets
2. Install production Composer dependencies
3. Run migrations
4. Run:

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

5. Ensure queue processing is running for contact jobs
6. Ensure `storage:link` exists

The repository includes:

- `Dockerfile` for containerized deployment
- `docker/start.sh` for container startup
- `render-build.sh` for build-time preparation
- `Procfile` with a single app start command

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
