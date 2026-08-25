# Makhah Taxi — Laravel

A Laravel rebuild of the Makhah Taxi WordPress site. The public frontend is an exact
clone of the original WordPress theme (`vw-taxi-booking`); the fleet, booking engine,
customer accounts, admin panel and payments are re-implemented natively in Laravel.

- **Framework:** Laravel 13 (PHP 8.3)
- **Admin:** Filament v3 (`/admin`)
- **Payments:** Stripe Checkout (optional; falls back to pay-on-arrival)
- **DB:** MySQL/MariaDB (XAMPP, port **3307**)

## Requirements

- PHP 8.3+, Composer
- MySQL/MariaDB running (this project is configured for XAMPP on `127.0.0.1:3307`)

## Setup

```bash
composer install
# .env is already configured for the local XAMPP DB (makhahtaxi_laravel @ 127.0.0.1:3307).
php artisan migrate
php artisan wp:import --fresh   # migrate fleet, pages & blog from the WordPress DB
php artisan serve --port=8090
```

Then open <http://127.0.0.1:8090>.

> The dev server must NOT use port 8000 on this machine — another app already occupies it.
> Use `--port=8090` (or any free port).

## Admin panel

- URL: <http://127.0.0.1:8090/admin>
- Login: **admin@makhahtaxi.com** / **Admin@12345**  (change this in production!)

Only users with `is_admin = true` can access the panel. Manage vehicles, bookings,
pages, blog posts and contact messages there. The dashboard shows booking / revenue stats.

Create another admin:

```bash
php artisan tinker --execute="\App\Models\User::create(['name'=>'X','email'=>'x@y.com','password'=>bcrypt('secret'),'is_admin'=>true]);"
```

## Data migration from WordPress

`php artisan wp:import [--fresh]` reads the legacy WordPress database via the read-only
`wp` connection (configured with the `WPDB_*` vars in `.env`) and imports:

- **Vehicles** — the fleet pages (Camry, Coaster, Hyundai Staria, GMC Yukon, Toyota Hiace, Luxury Bus)
- **Pages** — About Us, Contact, Our Taxis
- **Posts** — all published blog posts

Gutenberg block markup is cleaned and image URLs are rewritten to `/wp-uploads` (the
original `wp-content/uploads` folder was copied to `public/wp-uploads`).

Fleet pricing (per-km / per-hour / base / min fare) is **not** present in the WordPress
data, so the importer seeds sensible defaults — adjust each vehicle's rates in the admin.

## Frontend clone

The WordPress homepage render was captured and split into a Blade layout
(`resources/views/layouts/wp.blade.php`) containing the original `<head>` (inline CSS),
site header and footer. Theme assets live in `public/wp-content/themes/vw-taxi-booking`.
`scripts/extract_layout.php` regenerates the layout from the capture if needed.

New Laravel pages (fleet, vehicle, booking, contact, blog, auth, account) extend that
layout and are styled with `public/assets/site.css` to match the amber/black theme.

## Booking & fare

- `/booking` — booking form with live fare estimate (JS + `POST /booking/estimate`)
- Fare = `base_fare + (distance × per_km)` or `+ (hours × per_hour)`, floored at `min_fare`
- After booking, the customer lands on a confirmation page and can pay.

## Payments (Stripe)

Set these in `.env` to enable card payments via Stripe Checkout:

```
STRIPE_KEY=pk_live_xxx
STRIPE_SECRET=sk_live_xxx
CASHIER_CURRENCY=usd
```

Without keys, "Pay now" records the booking as **cash / pay-on-arrival**.

## Customer accounts

`/register`, `/login`, `/my-bookings` (booking history). Auth is session based and uses
the same site layout.

## Tests

```bash
php artisan test
```

`AdminSmokeTest` covers panel access control + every resource page; `FrontendTest`
covers public pages, fare estimation, the booking→payment flow, and register/login.
