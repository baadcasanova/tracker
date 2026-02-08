# Tracker SaaS (PHP/MySQL)

A production-ready, bilingual (Arabic/English) Project & Client Tracking System for Software & IT companies. Built with pure PHP + MySQL (no frameworks).

## Features
- Arabic/English support with RTL/LTR switching.
- Light/Dark mode.
- Secure authentication with password hashing, CSRF protection, and session management.
- Roles: Admin / Staff / Client.
- Optional 2FA for Admin (demo code shown on screen; replace with email/SMS in production).
- Client dashboard with projects, milestones, tasks, comments, and deadlines.
- Project modules: expenses, invoices, notes (private/client), files, messages, activity logs.
- Password vault with AES encryption.
- Public token view page.

## Folder Structure
```
app/
  core/         # Core services (DB, auth, CSRF, crypto)
  lang/         # en.php / ar.php
  models/       # Simple data access models
  views/        # Shared partials
config/
  config.php
  database.php
public/
  assets/
  admin.php
  dashboard.php
  login.php
  logout.php
  project.php
  project-view.php
  index.php
storage/
  uploads/
  logs/
database/
  schema.sql
  sample_data.sql
```

## Setup
1. **Create the database** and import the schema:
   ```bash
   mysql -u root -p < database/schema.sql
   mysql -u root -p < database/sample_data.sql
   ```
2. **Update configuration**:
   - `config/database.php` for DB credentials.
   - `config/config.php` for `base_url`, timezone, and encryption key.
3. **Run locally** (example):
   ```bash
   php -S localhost:8000 -t public
   ```
4. **Open** http://localhost:8000

## Sample Users
| Role | Email | Password |
|------|-------|----------|
| Admin | admin@tracker.com | Admin123! |
| Staff | staff@tracker.com | Staff123! |
| Client | client@tracker.com | Client123! |

## Public Project View
`/project-view.php?token=TOKEN1234567890`

## Security Notes
- Replace the demo 2FA with a real delivery mechanism (TOTP, email, SMS).
- Use HTTPS and rotate encryption keys for password vault entries.
- Store uploads outside the public directory in production.

## Encryption
The password vault uses AES-256-CBC via OpenSSL. Update the encryption key in `config/config.php`.
