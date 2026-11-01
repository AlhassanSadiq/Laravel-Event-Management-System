# Laravel Event Management System

A professional, scalable event ticketing and landing page system built with Laravel 12. Designed specifically for high-conversion event registrations and seamless check-ins.

## 🚀 Key Features

- **Premium Landing Page:** Modern, responsive design with high-conversion registration forms.
- **Paystack Integration:** Seamless online payment processing for tickets.
- **QR Code Generation:** Automated ticket generation with unique QR codes for every attendee.
- **Admin Dashboard:**
    - Monitor real-time sales and revenue analytics.
    - Issue tickets manually (for bank transfers/cash).
    - Manage custom coupons (Fixed or Percentage based).
    - Edit event details (Price, Date, Location) dynamically.
    - Search and filter attendees and payments.
- **Ticket Verification:** Built-in scanner/verification system for event organizers.
- **Email Notifications:** Automated ticket delivery via SMTP.
- **Downloadable Tickets:** Attendees and admins can download tickets as professional image files for easy sharing.

## 🛠 Tech Stack

- **Framework:** Laravel 12
- **Styling:** Custom CSS (Modern Aesthetics)
- **Database:** SQLite (Local) / MySQL (Production)
- **Payment Gateway:** Paystack
- **QR Engine:** Chillerlan PHP-QRCode
- **Frontend Tools:** html2canvas (for ticket downloads)

## 📦 Installation & Setup

Prerequisites: PHP 8.2 or later with PDO SQLite enabled for the default local database, Composer, Node.js 22.12 or later, and npm.

1. **Clone the repository:**
   ```bash
   git clone https://github.com/AlhassanSadiq/Laravel-Event-Management-System.git
   cd Laravel-Event-Management-System
   ```

2. **Install dependencies:**
   ```bash
   composer install
   npm install
   ```

3. **Configure Environment:**
   Copy `.env.example` to `.env` and set your database and Paystack keys.
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Prepare the local database and run migrations:**
   The example environment uses SQLite. Create its database file before migrating:
   ```bash
   php -r "file_exists('database/database.sqlite') || touch('database/database.sqlite');"
   php artisan migrate
   ```
   If using MySQL instead, create your database and configure `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` in `.env` before running migrations.

5. **Build the frontend assets:**
   ```bash
   npm run build
   ```

6. **Start the local server:**
   ```bash
   php artisan serve
   ```

Open http://127.0.0.1:8000 after starting the server. For frontend development, run `npm run dev` in a second terminal instead of rebuilding after each change.

The example environment uses `MAIL_MAILER=log`, so local emails are written to the application log. Configure your SMTP settings to deliver real emails.

## 🌐 Production Deployment (cPanel)

1. Upload the project files to your cPanel directory.
2. Ensure the `public/` directory is set as the document root (or use the provided `.htaccess` in the root).
3. Create a MySQL database and update the `.env` file.
4. Install Composer dependencies and run `php artisan migrate --force` against the configured production database. The repository does not include a SQL dump. Build frontend assets with `npm install` and `npm run build` before uploading, or on the server if Node.js is available.
5. Ensure `storage` and `bootstrap/cache` folders are writable (775 or 755).

---

Developed for **AWE Academy** by **Antigravity AI**.
