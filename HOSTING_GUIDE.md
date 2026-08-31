# Hosting Guide for hi.events EMS

This guide provides step-by-step instructions for hosting a personal instance of the hi.events Event Management System.

## 🚀 Recommended Hosting Services

Since this instance is needed for a short duration (3 months) and requires Docker, PostgreSQL, and Redis, we recommend the following options based on your priority:

### Option 1: DigitalOcean (Best for Ease of Use)
DigitalOcean is highly recommended because it is a standard for Laravel apps and offers a "One-Click Deploy" option for hi.events.
- **Plan**: Basic Droplet (1 vCPU, 2GB RAM, 50GB SSD)
- **Pros**: Extremely easy setup, excellent documentation, reliable.
- **Estimated Cost (3 Months)**: 
  - Droplet: ~$12/month $\times$ 3 = $36
  - Spaces (S3 Storage): ~$5/month $\times$ 3 = $15
  - **Total**: ~$51 $\approx$ **₹4,200 - ₹4,500 INR**

### Option 2: Hetzner (Best for Value/Cost)
If you are looking for the highest performance at the lowest price, Hetzner is the best choice.
- **Plan**: Cloud Server (e.g., CX21 - 2 vCPU, 4GB RAM)
- **Pros**: Unbeatable price-to-performance ratio.
- **Estimated Cost (3 Months)**:
  - Server: ~$5-7/month $\times$ 3 = $15 - $21
  - S3 Storage (AWS S3 or similar): ~$2-5/month $\times$ 3 = $6 - $15
  - **Total**: ~$21 - $36 $\approx$ **₹1,800 - ₹3,000 INR**

---

## 1. Before Hosting (Preparation)

### Hardware/Server Requirements
- A server with Docker and Docker Compose installed.
- Minimum 2GB RAM recommended for a small instance.
- Basic Linux knowledge (Ubuntu/Debian recommended).

### Software Dependencies
- **Docker**: Latest stable version.
- **Docker Compose**: Latest stable version.
- **OpenSSL**: Required for generating application keys.
- **PHP 8.2+**, **PostgreSQL 13+**, **Redis**, and **Node.js 20+** are required if hosting without Docker.

### Domain and SSL Setup
- A domain name pointing to your server's IP.
- SSL certificates (using Certbot/Let's Encrypt or a reverse proxy like Nginx Proxy Manager/Traefik).

### Account/API Key Preparation
You will need accounts for the following services:
- **Stripe**: For payment processing (create a Stripe account and obtain API keys).
- **Mail Provider**: (e.g., Mailgun, SendGrid, Amazon SES) for sending transactional emails.
- **Object Storage**: (e.g., AWS S3, DigitalOcean Spaces, or local MinIO) for storing ticket PDFs and event images.

## 2. During Hosting (Deployment)

### Option A: All-in-One Docker (Simplest for Personal Use)
This method runs the frontend and backend in a single container.

1. **Clone the Repository**:
   ```bash
   git clone git@github.com:HiEventsDev/hi.events.git
   cd hi.events/docker/all-in-one
   ```

2. **Configure Environment**:
   - Copy the example environment file: `cp .env.example .env`
   - **CRITICAL**: Generate and add a unique `APP_KEY` and `JWT_SECRET`. Do not use defaults.
     ```bash
     echo "APP_KEY=base64:$(openssl rand -base64 32)" >> .env
     echo "JWT_SECRET=$(openssl rand -base64 32)" >> .env
     ```
   - Edit `.env` and update the following:
     - `VITE_FRONTEND_URL`: Your public domain (e.g., `https://events.yourdomain.com`)
     - `VITE_API_URL_CLIENT`: Your public API URL (e.g., `https://events.yourdomain.com/api`)
     - `STRIPE_PUBLIC_KEY` & `STRIPE_SECRET_KEY`: Your Stripe API keys.
     - `MAIL_` settings: Your SMTP provider details.
     - `POSTGRES_PASSWORD`: A strong password for your database.

3. **Start the Instance**:
   ```bash
   docker compose up -d
   ```

4. **Initial Setup**:
   - Visit `http://your-domain.com/auth/register` to create the first admin account.

### Option B: Separated Backend and Frontend (Recommended for Production)
(Details to be added after full code review of the separate Dockerfiles).

## 3. After Hosting (Post-Deployment)

### Security Hardening
- **Secret Audit**: Double-check that no default passwords or secrets from `.env.example` are used in production.
- **Debug Mode**: Ensure `APP_DEBUG=false` in production to prevent leaking system information.
- **Firewall**: Configure a firewall (e.g., UFW) to only allow ports 80, 443, and SSH.
- **Database Access**: Ensure the PostgreSQL port (5432) is not exposed to the public internet.

### Testing Core Functionality
- [ ] Create an event.
- [ ] Create a ticket type.
- [ ] Test the checkout flow (using Stripe test mode).
- [ ] Test email delivery.
- [ ] Test ticket PDF generation and download.

### Backup Strategy
- **Database**: Schedule a daily `pg_dump` of the PostgreSQL database.
- **Files**: Back up the storage volume containing uploaded images and generated tickets.

### Monitoring and Logging
- Check logs using `docker compose logs -f`.
- Monitor server resources (CPU/RAM).
