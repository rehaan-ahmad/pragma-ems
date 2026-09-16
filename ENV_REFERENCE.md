# Environment Variables Reference

This document describes every environment variable used across the project, grouped by file.

---

## `backend/.env`

> Copy from `backend/.env.example`. Used by the Laravel backend.

### App Core

| Variable | Purpose |
|---|---|
| `APP_NAME` | Application display name |
| `APP_ENV` | Environment mode (`local`, `production`, etc.) |
| `APP_KEY` | Laravel encryption key — generate with `php artisan key:generate` |
| `APP_DEBUG` | Show detailed error pages. **Must be `false` in production** |
| `APP_LOG_QUERIES` | Log all SQL queries — useful for debugging, disable in production |
| `APP_URL` | The backend's own base URL |
| `APP_PORT` | Port the backend server listens on |
| `APP_FRONTEND_URL` | Frontend URL — used for CORS, email links, and redirects |
| `APP_CDN_URL` | Base URL for serving public assets/files (e.g. MinIO or S3) |
| `APP_SAAS_MODE_ENABLED` | Enables multi-tenant SaaS mode where each organizer has their own Stripe account |
| `APP_SAAS_STRIPE_APPLICATION_FEE_PERCENT` | Platform cut (%) taken from each transaction in SaaS mode |
| `APP_HOMEPAGE_VIEWS_UPDATE_BATCH_SIZE` | How many page view counts are batched before being flushed to the DB |
| `APP_DISABLE_REGISTRATION` | Locks down public user registration |
| `APP_STRIPE_CONNECT_ACCOUNT_TYPE` | Type of Stripe Connect account (`express` or `standard`) for SaaS |
| `APP_PLATFORM_SUPPORT_EMAIL` | Support email shown in the app and in emails |
| `APP_ALLOWED_INTERNAL_WEBHOOK_HOSTS` | Whitelist of hosts allowed to trigger internal webhooks |

### Stripe

| Variable | Purpose |
|---|---|
| `STRIPE_PUBLIC_KEY` | Stripe publishable key (used client-side) |
| `STRIPE_SECRET_KEY` | Stripe secret key (used server-side for charges) |
| `STRIPE_WEBHOOK_SECRET` | Secret to verify incoming Stripe webhook payloads |
| `STRIPE_IN_SECRET_KEY` *(optional)* | Stripe secret key for Indian accounts (UPI payments) |
| `STRIPE_IN_PUBLIC_KEY` *(optional)* | Stripe public key for Indian accounts |
| `STRIPE_IN_WEBHOOK_SECRET` *(optional)* | Webhook secret for the Indian Stripe account |

### CORS

| Variable | Purpose |
|---|---|
| `CORS_ALLOWED_ORIGINS` | Comma-separated list of allowed frontend origins for API requests |

### Logging

| Variable | Purpose |
|---|---|
| `LOG_CHANNEL` | Where logs are sent (`stderr`, `stack`, `single`, etc.) |
| `LOG_DEPRECATIONS_CHANNEL` | Where PHP deprecation warnings are logged |
| `LOG_LEVEL` | Minimum log severity (`debug`, `info`, `warning`, `error`, etc.) |

### Database

| Variable | Purpose |
|---|---|
| `DB_CONNECTION` | Database driver (`pgsql` = PostgreSQL) |
| `DB_HOST` | Database hostname |
| `DB_PORT` | Database port (PostgreSQL default: `5432`) |
| `DB_DATABASE` | Database name |
| `DB_USERNAME` | Database user |
| `DB_PASSWORD` | Database password |

### Drivers & Storage

| Variable | Purpose |
|---|---|
| `BROADCAST_DRIVER` | How real-time events are broadcast (`log`, `redis`, `pusher`) |
| `CACHE_DRIVER` | Cache backend (`file`, `redis`, `database`) |
| `FILESYSTEM_PUBLIC_DISK` | Disk used for publicly accessible files (e.g. event images) |
| `FILESYSTEM_PRIVATE_DISK` | Disk used for private/secure files (e.g. tickets, invoices) |
| `QUEUE_CONNECTION` | Queue driver — `sync` runs jobs inline, `redis` runs them in the background |
| `SESSION_DRIVER` | How sessions are stored (`file`, `redis`, `database`) |
| `SESSION_LIFETIME` | Session expiry in minutes |

### Redis

| Variable | Purpose |
|---|---|
| `REDIS_HOST` | Redis server hostname |
| `REDIS_PASSWORD` | Redis auth password (`null` = no auth required) |
| `REDIS_PORT` | Redis port (default: `6379`) |

### Mail

| Variable | Purpose |
|---|---|
| `MAIL_MAILER` | Mail driver (`smtp`, `log`, `ses`, etc.) |
| `MAIL_HOST` | SMTP server hostname |
| `MAIL_PORT` | SMTP port |
| `MAIL_USERNAME` | SMTP auth username |
| `MAIL_PASSWORD` | SMTP auth password |
| `MAIL_ENCRYPTION` | SMTP encryption (`tls`, `ssl`, or `null`) |
| `MAIL_AUTO_TLS` | Automatically upgrade to TLS if the server supports it |
| `MAIL_VERIFY_PEER` | Verify the mail server's SSL certificate |
| `MAIL_FROM_ADDRESS` | The "from" email address on all outbound emails |
| `MAIL_FROM_NAME` | The "from" display name on all outbound emails |

### AWS / MinIO (File Storage)

| Variable | Purpose |
|---|---|
| `AWS_ACCESS_KEY_ID` | S3 or MinIO access key |
| `AWS_SECRET_ACCESS_KEY` | S3 or MinIO secret key |
| `AWS_DEFAULT_REGION` | AWS region (not critical for local MinIO) |
| `AWS_PUBLIC_BUCKET` | S3 bucket for publicly accessible uploads |
| `AWS_PRIVATE_BUCKET` | S3 bucket for private/secure uploads |
| `AWS_ENDPOINT` | Custom S3-compatible endpoint (used for local MinIO) |
| `AWS_USE_PATH_STYLE_ENDPOINT` | Use path-style URLs instead of subdomain-style — required for MinIO |

### Auth

| Variable | Purpose |
|---|---|
| `JWT_SECRET` | Secret used to sign JWT authentication tokens — generate a strong random string |
| `JWT_ALGO` | Algorithm for JWT signing (`HS256` = HMAC SHA-256) |
| `OPEN_EXCHANGE_RATES_APP_ID` *(optional)* | API key for currency conversion — only needed in SaaS fee mode |

---

## `frontend/.env`

> Copy from `frontend/.env.example`. Used by the Vite/React frontend.
>
> All variables are prefixed `VITE_` so that Vite exposes them to the browser bundle.

> **Note on the URL split:** The app uses SSR (Server-Side Rendering). The browser and the SSR Node process live in different network contexts — the browser uses the public URL, while the SSR process can talk directly to the backend container over Docker's internal network. This is why there are two API URL variables.

| Variable | Purpose |
|---|---|
| `VITE_API_URL_CLIENT` | API URL used by the **browser** — must be publicly accessible |
| `VITE_API_URL_SERVER` | API URL used by the **SSR server** — can be an internal Docker hostname |
| `VITE_FRONTEND_URL` | The frontend's own public URL — used for generating absolute links |
| `VITE_STRIPE_PUBLISHABLE_KEY` | Stripe public key for initializing Stripe.js on the checkout page |

---

## `docker/all-in-one/.env`

> Copy from `docker/all-in-one/.env.example`.
> Used when running the **all-in-one Docker image** (frontend + backend in a single container).
> Combines both frontend `VITE_*` variables and backend variables in one file.

| Variable | Purpose |
|---|---|
| `APP_KEY` | Laravel encryption key |
| `JWT_SECRET` | JWT signing secret |
| `VITE_FRONTEND_URL` | Public URL of the frontend (browser-side) |
| `VITE_API_URL_CLIENT` | API URL used by the browser |
| `VITE_API_URL_SERVER` | API URL used by the SSR server internally |
| `VITE_STRIPE_PUBLISHABLE_KEY` | Stripe public key for frontend checkout |
| `VITE_APP_NAME` | App name shown in the frontend UI |
| `LOG_CHANNEL` | Where backend logs go |
| `QUEUE_CONNECTION` | Queue driver (`redis` recommended for async jobs) |
| `APP_CDN_URL` | URL where uploaded files are served from |
| `APP_FRONTEND_URL` | Frontend URL used by the backend for links and redirects |
| `APP_DISABLE_REGISTRATION` | Block new user signups |
| `APP_SAAS_MODE_ENABLED` | Enable SaaS multi-tenant mode |
| `APP_SAAS_STRIPE_APPLICATION_FEE_PERCENT` | Platform fee percentage in SaaS mode |
| `APP_SAAS_STRIPE_APPLICATION_FEE_FIXED` | Fixed platform fee amount in SaaS mode |
| `APP_EMAIL_LOGO_URL` | URL to a logo image embedded in outbound emails |
| `APP_EMAIL_LOGO_LINK_URL` | URL the logo in emails links to when clicked |
| `MAIL_MAILER` | Mail driver (`log` for local testing, `smtp` for production) |
| `MAIL_HOST` | SMTP server hostname |
| `MAIL_PORT` | SMTP port |
| `MAIL_USERNAME` | SMTP auth username |
| `MAIL_PASSWORD` | SMTP auth password |
| `MAIL_ENCRYPTION` | SMTP encryption (`tls`, `ssl`, or `null`) |
| `MAIL_AUTO_TLS` | Auto-upgrade to TLS if supported |
| `MAIL_VERIFY_PEER` | Verify the mail server's SSL certificate |
| `MAIL_FROM_ADDRESS` | From email address on outbound emails |
| `MAIL_FROM_NAME` | From display name on outbound emails |
| `FILESYSTEM_PUBLIC_DISK` | Public file storage disk (`public` = local filesystem) |
| `FILESYSTEM_PRIVATE_DISK` | Private file storage disk (`local` = local filesystem) |
| `POSTGRES_DB` | PostgreSQL database name — used by Docker to initialise the DB |
| `POSTGRES_USER` | PostgreSQL username |
| `POSTGRES_PASSWORD` | PostgreSQL password |
| `DATABASE_URL` | Full connection string — alternative to individual `DB_*` vars |
| `STRIPE_PUBLIC_KEY` | Stripe publishable key (backend copy) |
| `STRIPE_SECRET_KEY` | Stripe secret key |
| `STRIPE_WEBHOOK_SECRET` | Stripe webhook verification secret |
| `REDIS_HOST` | Redis hostname |
| `REDIS_PASSWORD` | Redis auth password |
| `REDIS_PORT` | Redis port |

---

## `docker/development/.env`

> Used for **local Docker development only**. Already committed with safe placeholder/dev values.

| Variable | Purpose |
|---|---|
| `APP_NAME` | App display name |
| `APP_ENV` | Set to `local` for development |
| `APP_KEY` | A dev-only Laravel encryption key |
| `APP_DEBUG` | `true` — shows full error stack traces locally |
| `API_URL_CLIENT` | API URL the browser hits (HTTPS via nginx proxy) |
| `API_URL_SERVER` | API URL used internally between containers (bypasses nginx) |
| `STRIPE_PUBLIC_KEY` | Placeholder test Stripe key |
| `FRONTEND_URL` | Local frontend URL |
| `DB_CONNECTION` | PostgreSQL driver |
| `DB_HOST` | DB container hostname |
| `DB_PORT` | DB port |
| `DB_DATABASE` | Dev database name |
| `DB_USERNAME` | Dev DB username |
| `DB_PASSWORD` | Dev DB password |
