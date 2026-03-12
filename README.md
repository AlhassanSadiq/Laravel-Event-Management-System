# Laravel Event Management System

A professional, scalable event ticketing and landing page system built with Laravel 11. Designed specifically for high-conversion event registrations and seamless check-ins.

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

- **Framework:** Laravel 11
- **Styling:** Custom CSS (Modern Aesthetics)
- **Database:** SQLite (Local) / MySQL (Production)
- **Payment Gateway:** Paystack
- **QR Engine:** Chillerlan PHP-QRCode
- **Frontend Tools:** html2canvas (for ticket downloads)

## 📦 Installation & Setup

1. **Clone the repository:**
   ```bash
   git clone <your-repo-url>
   cd event
   ```

2. **Install dependencies:**
   ```bash
   composer install
   ```

3. **Configure Environment:**
   Copy `.env.example` to `.env` and set your database and Paystack keys.
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Run Migrations:**
   ```bash
   php artisan migrate
   ```

5. **Start the local server:**
   ```bash
   php artisan serve
   ```

## 🌐 Production Deployment (cPanel)

1. Upload the project files to your cPanel directory.
2. Ensure the `public/` directory is set as the document root (or use the provided `.htaccess` in the root).
3. Create a MySQL database and update the `.env` file.
4. Import the `database_mysql.sql` file via phpMyAdmin.
5. Ensure `storage` and `bootstrap/cache` folders are writable (775 or 755).

---

Developed for **AWE Academy** by **Antigravity AI**.
