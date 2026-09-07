<div align="center">

<img src="https://hievents-public.s3.us-west-1.amazonaws.com/website/github-banner.png?v=1" alt="Pragma Event Management System" width="100%" style="border-radius: 8px;">

# ⚡ Pragma EMS

### Enterprise Event Ticketing & Management Platform — Hardened & India-Ready

*Sell tickets online for conferences, nightlife events, concerts, workshops, and festivals with zero per-ticket fees, native UPI payment flows, and hardened enterprise security.*

<br>

[![License: AGPL v3](https://img.shields.io/badge/License-AGPL_v3-blue.svg)](LICENCE)
[![Security: Hardened](https://img.shields.io/badge/Security-Hardened%20A%2B-emerald.svg)](#-enterprise-security-hardening)
[![India Stack: UPI & GST](https://img.shields.io/badge/India%20Stack-UPI%20%7C%20INR%20%7C%2018%25%20GST-orange.svg)](#-india-region--upi-payments)
[![Laravel 10](https://img.shields.io/badge/Backend-Laravel%2010-red.svg)](backend)
[![React 18](https://img.shields.io/badge/Frontend-React%2018-blue.svg)](frontend)
[![Docker Ready](https://img.shields.io/badge/Docker-Ready-2496ED.svg)](docker)

<br>

[⚡ Quick Start](#-quick-start) · [🛡️ Security Features](#-enterprise-security-hardening) · [🇮🇳 India & UPI Integration](#-india-region--upi-payments) · [📖 Hosting Guide](HOSTING_GUIDE.md) · [📋 Handover Log](HANDOVER.md)

</div>

<br>

---

## 🌟 Why Pragma EMS?

Most event platforms lock you into heavy per-ticket platform fees, slow payouts, and generic regional defaults. **Pragma EMS** is a modern, open-source, high-performance event management system engineered for high availability, enterprise-grade security, and seamless regional payment support.

> [!IMPORTANT]
> **Built for Scale & Security**: Optimized with strict API rate limiting, short-lived JWT session security, strict CORS isolation, native **Stripe UPI (Google Pay, PhonePe, Paytm, BHIM)** checkout flows, and automated **18% Indian GST** handling out of the box.

<br>

<img alt="Pragma EMS Dashboard" src="https://hievents-public.s3.us-west-1.amazonaws.com/website/github-screenshot.png" style="border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.15);"/>

<br>

---

## 🔥 Key Enterprise Enhancements

<table>
<tr>
<td width="50%" valign="top">

### 🇮🇳 India Region & UPI Native Payments

- **Native Stripe UPI Integration**: Seamless checkout via Google Pay, PhonePe, Paytm, BHIM & UPI ID.
- **Async UPI Intent Authorization**: Intelligent polling engine (30s window) handling async 3D Secure / UPI approvals gracefully.
- **Indian Financial Defaults**: Standardized to `INR (₹)` currency, `Asia/Kolkata` timezone, and default **18% GST** tax calculation engine.
- **Dedicated Stripe India Platform**: Dedicated `STRIPE_IN_*` configuration profile supporting Indian Stripe Connect accounts.

</td>
<td width="50%" valign="top">

### 🛡️ Enterprise Security Hardening

- **API Throttling & DDoS Protection**: Strict rate limits on `/login`, `/register` (5 req/min) and Payment Intent endpoints (10 req/min).
- **Hardened JWT Auth**: Short-lived access token TTL (24h) and strict 7-day refresh windows to minimize token theft risk.
- **Strict CORS & Cookie Policies**: Production CORS origin matching, HTTPS-only secure session cookies (`SameSite=Lax`).
- **Zero Secrets Leakage**: Removed all hardcoded cryptographic secrets and enforced strict runtime key generation.

</td>
</tr>
</table>

<br>

---

## ✨ Features at a Glance

<table>
<tr>
<td width="50%" valign="top">

### 🎟️ Ticketing & Revenue Engine

- **Flexible Ticket Types**: Free, paid, donation, tiered, and hidden presale tickets.
- **Promo Codes & Access Limits**: Code-protected tickets, bulk discounts, and shared capacity pools.
- **Product Add-Ons & Merch**: Upsell merchandise, VIP passes, and parking add-ons during checkout.
- **Automated Tax & GST Handling**: Full support for tax inclusive/exclusive pricing with custom GST rules.
- **Instant Stripe Payouts**: Direct ticket revenue dispatch via Stripe Connect.

</td>
<td width="50%" valign="top">

### 🎨 Customization & Branding

- **Conversion-Optimized Checkout**: Ultra-fast, responsive single-page checkout tailored for mobile.
- **Embeddable Ticket Widgets**: Drop-in registration forms for your existing websites.
- **Custom PDF Ticket Generation**: Print-ready PDF tickets with unique QR codes & branding.
- **Organizer Landing Pages**: Branded homepages listing all upcoming and past events.
- **SEO & Social Cards**: Built-in Open Graph metadata and dynamic social preview tags.

</td>
</tr>
<tr>
<td width="50%" valign="top">

### 👥 Attendee & Access Management

- **Real-Time QR Code Check-in**: Mobile check-in app with live scan logs and duplicate detection.
- **Custom Checkout Surveys**: Gather custom attendee fields (dietary, t-shirt size, company).
- **Granular Refunds & Swaps**: Issue full or partial refunds with automatic ticket invalidation.
- **Targeted Bulk Broadcasts**: Send targeted email announcements to specific ticket tiers.

</td>
<td width="50%" valign="top">

### 📊 Analytics & Integrations

- **Live Sales Dashboard**: Real-time sales velocity, revenue metrics, and channel analytics.
- **Affiliate & Referral Tracking**: Track promoter performance and referral link conversions.
- **Webhooks & Automation**: Trigger external workflows via webhooks (Zapier, Make, custom CRMs).
- **Data Export & Ownership**: Export full attendee rosters to CSV and Excel anytime.

</td>
</tr>
</table>

<br>

---

## ⚡ Feature Comparison

| Feature | Pragma EMS ⚡ | Eventbrite ❌ | TicketTailor ❌ | Dice ❌ |
| :--- | :---: | :---: | :---: | :---: |
| **Self-Hosted & Own Your Data** | ✅ **Yes** | ❌ No | ❌ No | ❌ No |
| **Zero Per-Ticket Platform Fees** | ✅ **Yes** | ❌ No | ❌ No | ❌ No |
| **Native UPI Payments (India)** | ✅ **Yes** | ❌ No | ❌ No | ❌ No |
| **Automated 18% GST Calculation** | ✅ **Yes** | ❌ No | ❌ Limited | ❌ No |
| **Hardened Rate Limiting & Auth** | ✅ **Yes** | 🔒 Proprietary | 🔒 Proprietary | 🔒 Proprietary |
| **Custom PDF Ticket Builder** | ✅ **Yes** | ❌ No | ✅ Yes | ❌ No |
| **Affiliate & Promoter Tracking** | ✅ **Yes** | ✅ Yes | ❌ No | ❌ No |
| **Full REST API & Webhooks** | ✅ **Yes** | ✅ Yes | ✅ Yes | ❌ Limited |

<br>

---

## 🛡️ Enterprise Security Hardening

Security is at the core of Pragma EMS. The platform includes the following critical security controls:

> [!NOTE]
> Detailed audit logs and verification records can be viewed in [`HANDOVER.md`](HANDOVER.md) and [`SECURITY.md`](SECURITY.md).

1. **Strict Rate Limiting**:
   - Authentication Endpoints (`/login`, `/register`, `/forgot-password`): **5 requests / minute**.
   - Payment Intent Creation (`/api/v1/payment/intent`): **10 requests / minute**.
   - Global API Baseline: **60 requests / minute**.

2. **Session & JWT Security**:
   - Access Token TTL: **24 hours** (1,440 mins).
   - Refresh Token TTL: **7 days** (10,080 mins).
   - Cookies: `HTTPS-only` (Secure=true) with `SameSite=Lax` protection.

3. **CORS & Input Validation**:
   - Strict origin whitelist matching via `CORS_ALLOWED_ORIGINS`.
   - Preflight caching set to `3600s` to eliminate excess OPTIONS overhead.

<br>

---

## 🇮🇳 India Region & UPI Setup

To enable native **UPI payments (Google Pay, PhonePe, Paytm, BHIM)** and Indian financial defaults:

```env
# backend/.env

# Financial Defaults
APP_TIMEZONE="Asia/Kolkata"
APP_CURRENCY="INR"
APP_TAX_RATE=0.18
APP_TAX_COUNTRY="IN"
APP_TAX_INDIA_GST_HANDLING_ENABLED=true

# Stripe India Connect Platform
STRIPE_IN_PUBLIC_KEY="pk_live_..."
STRIPE_IN_SECRET_KEY="sk_live_..."
STRIPE_IN_WEBHOOK_SECRET="whsec_..."
```

> [!TIP]
> When `APP_CURRENCY=INR`, Pragma automatically switches Stripe payment intent generation to explicit `['card', 'upi']` method types and triggers the interactive UPI confirmation flow on the frontend with a 30-second polling timeout.

<br>

---

## 🚀 Quick Start

### Docker Compose (Recommended)

```bash
# 1. Clone the repository
git clone https://github.com/rehaan-ahmad/pragma-ems.git
cd pragma-ems/docker/all-in-one

# 2. Generate secure application keys
echo "APP_KEY=base64:$(openssl rand -base64 32)" >> .env
echo "JWT_SECRET=$(openssl rand -base64 32)" >> .env

# 3. Spin up the containers
docker compose up -d
```

Open `http://localhost:8123` in your browser to complete setup!

<br>

### Manual Local Development Setup

#### Backend (Laravel 10)
```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
php artisan jwt:secret
php artisan migrate --seed
php artisan serve
```

#### Frontend (React 18 + Vite)
```bash
cd frontend
npm install
npm run dev
```

<br>

---

## 📚 Documentation & Resources

- 📖 **[Comprehensive Hosting Guide](HOSTING_GUIDE.md)** — Step-by-step production deployment & hardening checklist.
- 📋 **[Handover Document](HANDOVER.md)** — Technical changelog of all recent security & UPI updates.
- 🔒 **[Security Policy](SECURITY.md)** — Vulnerability reporting and security architecture details.
- 🤝 **[Contributing Guidelines](CONTRIBUTING.md)** — How to contribute features and bug fixes.

<br>

---

## 📜 License

Pragma EMS is open-source software licensed under the **AGPL-3.0 License** with commercial licensing options available.

<br>

<div align="center">

**Pragma EMS** · *Empowering Event Organizers Worldwide*

Made with ❤️ & ⚡

</div>
