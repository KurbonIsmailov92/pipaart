# Fly.io deployment (free trial) + Postgres + custom domain

This guide deploys the Laravel app to Fly.io with a managed Postgres database
and connects the custom domain `pipaa.tj`.

## Prerequisites
- Fly.io account
- Fly CLI installed (`https://fly.io/docs/hands-on/install-flyctl/`)

## 1) Authenticate
```bash
fly auth login
```

## 2) Create the app
```bash
fly launch --name pipaa --region fra --no-deploy
```

## 3) Create a Postgres cluster (free tier)
```bash
fly postgres create --name pipaa-db --region fra --vm-size shared-cpu-1x --volume-size 1
```

Attach Postgres to the app:
```bash
fly postgres attach --app pipaa pipaa-db
```

This sets `DATABASE_URL` in Fly secrets.

## 4) Set app secrets
Generate the app key locally:
```bash
php artisan key:generate --show
```

Set secrets in Fly:
```bash
fly secrets set \
  APP_KEY="base64:..." \
  APP_ENV=production \
  APP_DEBUG=false \
  APP_URL="https://pipaa.tj"
```

## 5) Deploy
```bash
fly deploy
```

## 6) Run migrations (first deploy only)
```bash
fly ssh console -C "php artisan migrate --force"
```

## 7) Connect the custom domain
Add domains:
```bash
fly domains add pipaa.tj
fly domains add www.pipaa.tj
```

Fly will show the required DNS records. Add them at the registrar:
- A record for `@` pointing to the Fly-provided IP.
- CNAME for `www` pointing to `pipaa.fly.dev`.

## 8) Verify
```bash
fly status
```


## 9) Configure SMTP for password reset emails
Password reset links are sent by email, so set mail secrets before using the
"Forgot password" flow:

```bash
fly secrets set \
  MAIL_MAILER=smtp \
  MAIL_HOST=smtp.gmail.com \
  MAIL_PORT=587 \
  MAIL_USERNAME=your@email.com \
  MAIL_PASSWORD=your-app-password \
  MAIL_ENCRYPTION=tls \
  MAIL_FROM_ADDRESS=no-reply@pipaa.tj \
  MAIL_FROM_NAME="PIPAA"
```

Then redeploy:
```bash
fly deploy
```
