# Necessary Updates for Personal Hosting

This document lists all required updates to the codebase and configuration to ensure the system is safe and functional for personal hosting.

## Configuration Updates
- [ ] **Environment Variables**: Update `.env` with actual production values.
- [ ] **Application Keys**: Generate unique `APP_KEY` and `JWT_SECRET`. **DO NOT** use the defaults provided in `.env.example`.
- [ ] **Stripe API**: Configure `STRIPE_PUBLIC_KEY`, `STRIPE_SECRET_KEY`, and `STRIPE_WEBHOOK_SECRET`.
- [ ] **Email Service**: Configure `MAIL_` settings (Host, Port, Username, Password) to use a real SMTP provider.
- [ ] **Object Storage**: Configure `AWS_` settings for S3-compatible storage (Bucket names, keys, endpoints).
- [ ] **Database**: Set a strong `POSTGRES_PASSWORD`.
- [ ] **Frontend URLs**: Update `VITE_FRONTEND_URL`, `VITE_API_URL_CLIENT`, and `VITE_API_URL_SERVER` to match the hosting domain.

## Security Updates
- [ ] **Secret Rotation**: Ensure all default passwords in `docker-compose.yml` (if used) are overridden by `.env` values.
- [ ] **JWT Secret**: Ensure `JWT_SECRET` is generated using `openssl rand -base64 32`.

## Infrastructure Updates
- [ ] **SSL Certificates**: Set up HTTPS (e.g., using Let's Encrypt).
- [ ] **Reverse Proxy**: Configure Nginx or another proxy if not using the all-in-one image's internal proxy.
- [ ] **Database Backups**: Implement a backup strategy for the PostgreSQL database.
- [ ] **Storage Backups**: Implement a backup strategy for the S3/local storage buckets.
