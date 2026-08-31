# Handover Document

This document tracks the progress of preparing the hi.events EMS for personal hosting.

## Status
- [x] Initial Project Exploration
- [x] Extensive Code Review (Security, Config, Deps)
- [x] Identification of Necessary Updates
- [x] Creation of Comprehensive Hosting Guide
- [x] Security Vulnerability Fixes (6 fixes across 8 files)
- [x] India Stripe Platform & UPI Payment Support (8 changes across 7 files)

## Tasks Completed
- [x] Create Handover and Guide files
- [x] Initial exploration of project structure and environment configs
- [x] Performed extensive security and hosting readiness review via autonomous agent
- [x] Identified necessary updates and documented them in `NECESSARY_UPDATES.md`
- [x] Created a comprehensive `HOSTING_GUIDE.md` with pre, during, and post hosting steps.

---

## Security Fixes (Aug 2026)

### CRITICAL: Removed Hardcoded APP_KEY
- **File**: `backend/.env.example`
- The example env shipped a real `APP_KEY` (`base64:DwMidgIu8YVSEg0BLMrh5JS2dk1POpCn3rvDaZk3fEQ=`). Anyone using this key would have predictable encryption for sessions, passwords, and tokens. Changed to empty — users must run `php artisan key:generate`.

### HIGH: CORS Hardening
- **File**: `backend/config/cors.php`
- Removed wildcard `*` from `paths` (was applying CORS to all routes, not just `api/*`).
- Added `max_age: 3600` for preflight response caching (was `0`, causing an OPTIONS request on every call).
- **File**: `backend/.env.example` — Changed `CORS_ALLOWED_ORIGINS` default from `*` to empty, forcing explicit configuration.

### HIGH: Rate Limiting on Auth & Payment Routes
- **File**: `backend/app/Providers/RouteServiceProvider.php` — Added `auth` (5 req/min) and `payment` (10 req/min) rate limiter definitions.
- **File**: `backend/routes/api.php` — Applied `throttle:auth` to `/login`, `/register`, `/forgot-password`. Applied `throttle:payment` to Stripe payment intent creation endpoint. Previously, these had **no rate limiting**, enabling brute-force and payment abuse.

### HIGH: JWT Token Lifetime Reduction
- **File**: `backend/config/jwt.php`
- JWT TTL reduced from **7 days** to **1 day** (`60 * 24` minutes).
- Refresh TTL reduced from **14 days** to **7 days** (`60 * 24 * 7` minutes).
- Both remain overridable via `JWT_TTL` and `JWT_REFRESH_TTL` env vars.

### MEDIUM: Session Cookie Security
- **File**: `backend/config/session.php`
- Changed `secure` cookie default from `null` to `true`, ensuring session cookies are HTTPS-only by default. Override with `SESSION_SECURE_COOKIE=false` for local HTTP development.

### LOW: Custom Exception for Stripe Refund Service
- **New file**: `backend/app/Exceptions/Stripe/StripeRefundConfigurationException.php`
- **File**: `backend/app/Services/Domain/Payment/Stripe/StripePaymentIntentRefundService.php` — Replaced bare `RuntimeException` with domain-specific `StripeRefundConfigurationException`, per project conventions (see `CLAUDE.md`).

---

## India Stripe Platform & UPI Payments (Aug 2026)

### StripePlatform Enum
- **File**: `backend/app/DomainObjects/Enums/StripePlatform.php`
- Added `case INDIA = 'in'` alongside existing `CANADA` (`ca`) and `IRELAND` (`ie`).

### Stripe Configuration Service
- **File**: `backend/app/Services/Infrastructure/Stripe/StripeConfigurationService.php`
- Added `StripePlatform::INDIA` resolution in `getSecretKey()`, `getPublicKey()`, and `getAllWebhookSecrets()`.

### India Stripe Config Keys
- **File**: `backend/config/services.php` — Added `in_secret_key`, `in_public_key`, `in_webhook_secret` with `STRIPE_IN_*` env variable fallbacks.
- **File**: `backend/.env.example` — Added commented-out `STRIPE_IN_SECRET_KEY`, `STRIPE_IN_PUBLIC_KEY`, `STRIPE_IN_WEBHOOK_SECRET`.

### Indian Standard Defaults
- **File**: `backend/config/app.php`
- `default_timezone`: `America/Vancouver` → `Asia/Kolkata`
- `default_currency_code`: `USD` → `INR`
- `default_vat_rate`: `0.23` (Irish VAT) → `0.18` (18% Indian GST)
- `default_vat_country`: `IE` → `IN`
- Added `india_gst_handling_enabled` config flag (via `APP_TAX_INDIA_GST_HANDLING_ENABLED` env).

### UPI Payment Method Integration (Backend)
- **File**: `backend/app/Services/Domain/Payment/Stripe/StripePaymentIntentCreationService.php`
- When currency is `INR`, payment intents are created with explicit `payment_method_types: ['card', 'upi']` instead of `automatic_payment_methods: true`.
- Stripe's API makes these two approaches **mutually exclusive**. UPI requires explicit `payment_method_types` for reliable availability in India.
- For all other currencies, the existing `automatic_payment_methods` behaviour is preserved.

### UPI Payment Flow (Frontend)
- **File**: `frontend/src/components/forms/StripeCheckoutForm/index.tsx` — Added `requires_action` case in payment status handling. UPI payments go through async confirmation (user must approve in their UPI app), so without this case users saw "Something went wrong" instead of "Please complete the payment in your UPI app."
- **File**: `frontend/src/components/routes/product-widget/PaymentReturn/index.tsx` — Extended payment confirmation polling timeout from **10 seconds** to **30 seconds**. UPI payments require the user to open their banking app and approve, which routinely exceeds 10s.

---

## Files Changed Summary

| File | Action | Category |
|------|--------|----------|
| `backend/.env.example` | Modified | Security + India |
| `backend/config/cors.php` | Modified | Security |
| `backend/config/session.php` | Modified | Security |
| `backend/config/jwt.php` | Modified | Security |
| `backend/config/app.php` | Modified | India |
| `backend/config/services.php` | Modified | India |
| `backend/routes/api.php` | Modified | Security |
| `backend/app/Providers/RouteServiceProvider.php` | Modified | Security |
| `backend/app/DomainObjects/Enums/StripePlatform.php` | Modified | India |
| `backend/app/Services/Infrastructure/Stripe/StripeConfigurationService.php` | Modified | India |
| `backend/app/Services/Domain/Payment/Stripe/StripePaymentIntentCreationService.php` | Modified | UPI |
| `backend/app/Services/Domain/Payment/Stripe/StripePaymentIntentRefundService.php` | Modified | Security |
| `backend/app/Exceptions/Stripe/StripeRefundConfigurationException.php` | **New** | Security |
| `frontend/src/components/forms/StripeCheckoutForm/index.tsx` | Modified | UPI |
| `frontend/src/components/routes/product-widget/PaymentReturn/index.tsx` | Modified | UPI |
