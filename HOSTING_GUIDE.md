# Hosting Guide for hi.events EMS

This guide provides comprehensive, step-by-step instructions for hosting a personal instance of the hi.events Event Management System.

## 🚀 Recommended Hosting Services

Since this instance is needed for a short duration (3 months) and requires Docker, PostgreSQL, and Redis, we recommend the following options:

### Option 1: DigitalOcean (Best for Ease of Use)
Ideal for those who want a fast setup with reliable infrastructure.
- **Plan**: Basic Droplet (1 vCPU, 2GB RAM, 50GB SSD)
- **Pros**: Fast deployment, great documentation, high reliability.
- **Estimated Cost (3 Months)**: 
  - Droplet: ~$12/month $\times$ 3 = $36
  - Spaces (S3 Storage): ~$5/month $\times$ 3 = $15
  - **Total**: ~$51 $\approx$ **₹4,200 - ₹4,500 INR**

### Option 2: Hetzner (Best for Value/Cost)
Ideal for maximizing performance while minimizing expenses.
- **Plan**: Cloud Server (e.g., CX21 - 2 vCPU, 4GB RAM)
- **Pros**: Superior price-to-performance ratio.
- **Estimated Cost (3 Months)**:
  - Server: ~$5-7/month $\times$ 3 = $15 - $21
  - S3 Storage (AWS S3 or similar): ~$2-5/month $\times$ 3 = $6 - $15
  - **Total**: ~$21 - $36 $\approx$ **₹1,800 - ₹3,000 INR**

---

## 1. Before Hosting (Preparation)

### Hardware/Server Requirements
- **OS**: Ubuntu 22.04 or 24.04 LTS (Recommended).
- **Resources**: Minimum 2GB RAM (4GB recommended for smoother performance).
- **Tools**: Docker and Docker Compose installed.
- **Knowledge**: Basic Linux CLI proficiency.

### Software Dependencies
- **Docker & Docker Compose**: Latest stable versions.
- **OpenSSL**: Required for generating secure application keys.
- **PHP 8.2+, PostgreSQL 13+, Redis, Node.js 20+**: Only required if you choose to host without Docker.

### Domain and SSL Setup
- **Domain**: A registered domain or subdomain pointing to your server's public IP.
- **SSL**: HTTPS is **mandatory** for Stripe and secure auth. Use:
  - **Certbot / Let's Encrypt**: For free automated certificates.
  - **Reverse Proxy**: Nginx Proxy Manager or Traefik for easier SSL management.

### Account & API Key Preparation
Prepare these accounts before starting the deployment:
- **Stripe**: Create an account $\rightarrow$ API Keys $\rightarrow$ Get `Publishable Key` and `Secret Key`.
- **Mail Provider**: (e.g., Mailgun, SendGrid, Amazon SES) for transactional emails (Order confirmations, tickets).
- **Object Storage**: (e.g., AWS S3, DigitalOcean Spaces, Minio) for storing event images and ticket PDFs.

---

## 2. During Hosting (Deployment)

### The "All-in-One" Docker Deployment (Recommended)
This is the fastest way to get the system running by bundling the frontend and backend.

#### Step 1: Clone and Enter
```bash
git clone git@github.com:HiEventsDev/hi.events.git
cd hi.events/docker/all-in-one
```

#### Step 2: Configure Environment
1. Copy the example environment file:
   ```bash
   cp .env.example .env
   ```
2. **CRITICAL: Generate Secure Keys**. Do not use defaults to prevent authentication forgery:
   ```bash
   echo "APP_KEY=base64:$(openssl rand -base64 32)" >> .env
   echo "JWT_SECRET=$(openssl rand -base64 32)" >> .env
   ```
3. Edit `.env` and update these production values:
   - `VITE_FRONTEND_URL`: `https://events.yourdomain.com`
   - `VITE_API_URL_CLIENT`: `https://events.yourdomain.com/api`
   - `STRIPE_PUBLIC_KEY` & `STRIPE_SECRET_KEY`: Your actual Stripe keys.
   - `MAIL_` settings: Your SMTP provider's Host, Port, User, and Password.
   - `POSTGRES_PASSWORD`: A strong, unique password.
   - `AWS_` settings: Your S3 bucket and access keys.

#### Step 3: Launch
```bash
docker compose up -d
```

#### Step 4: Initial Setup
1. Open your browser and visit: `https://events.yourdomain.com/auth/register`
2. Create the first account. This user will have administrative access to the platform.

---

## 3. After Hosting (Post-Deployment)

### 🛡️ Security Hardening (Crucial)
- **Disable Debug Mode**: Ensure `APP_DEBUG=false` in your `.env` to prevent sensitive system info from appearing in errors.
- **Audit Secrets**: Verify that no default passwords (like `secret` or `password`) remain in your configuration.
- **Firewall Setup**: Use `ufw` to block all ports except 80 (HTTP), 443 (HTTPS), and your SSH port.
- **Database Isolation**: Ensure the PostgreSQL port (5432) is **NOT** exposed to the public internet.

### ✅ Testing Core Functionality
Verify the following flow before going live:
- [ ] **Event Creation**: Can you create an event and a ticket type?
- [ ] **Checkout**: Does the checkout redirect to Stripe correctly? (Use Stripe Test Mode).
- [ ] **Payments**: Does the order status change to "Paid" after a successful test payment?
- [ ] **Emails**: Do you receive the order confirmation email?
- [ ] **Tickets**: Can you generate and download the ticket PDF?

### 💾 Backup & Maintenance
- **Database Backup**: Set up a cron job to run `pg_dump` daily.
- **Storage Backup**: Ensure your S3 bucket has versioning enabled or is backed up regularly.
- **Logs**: Monitor for errors using `docker compose logs -f`.
- **Updates**: Regularly pull the latest code from the repository and run `docker compose pull && docker compose up -d`.
