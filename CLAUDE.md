# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project

Makhah Taxi is a Laravel 13 / PHP 8.3 rebuild of a legacy WordPress taxi-booking site.
The public frontend is a pixel clone of the original WordPress theme (`vw-taxi-booking`);
the fleet, booking engine, customer accounts, admin panel and payments are re-implemented
natively. Admin is Filament v3 at `/admin`; payments use Stripe Checkout (optional).

## Commands

```bash
composer install                    # PHP deps
php artisan migrate                 # build schema (MySQL, see below)
php artisan wp:import --fresh       # import fleet/pages/posts from legacy WP DB
php artisan serve --port=8090       # dev server — do NOT use port 8000 (occupied on this machine)
npm run dev                         # Vite dev (Tailwind v4); npm run build for prod assets

php artisan test                    # run all tests (composer test also clears config first)
php artisan test --filter=test_fare_estimate_endpoint   # single test
vendor/bin/pint                     # format (Laravel Pint)
php artisan pail                    # tail logs
```

Tests run against **sqlite `:memory:`** (see `phpunit.xml`) with `RefreshDatabase`, so they
do not touch the MySQL dev database and need no DB setup.

## Database

Two connections are configured (`config/database.php`):

- **`mysql`** (default) — app DB `makhahtaxi_laravel` on **XAMPP MySQL, port 3307** (not 3306).
- **`wp`** — read-only source connection to the legacy WordPress DB, driven by `WPDB_*` vars
  in `.env`. Used **only** by the `wp:import` command.

## Architecture

**Frontend rendering.** `resources/views/layouts/wp.blade.php` embeds raw captured WordPress
HTML (head/header/footer) wrapped in `@verbatim ... @endverbatim` blocks so Blade does not
try to parse the WP markup. `scripts/extract_layout.php` is a one-time build-time tool that
generated this layout from a captured homepage render (`_wpcapture/home.html`); it is not part
of the request lifecycle. Legacy `wp-content/uploads` paths are rewritten to `/wp-uploads`
(the uploads folder was copied to `public/wp-uploads`).

**WordPress import.** `app/Console/Commands/ImportWordpress.php` (`wp:import`) reads the `wp`
connection and `updateOrCreate`s `Vehicle`/`Page`/`Post` rows keyed on `wp_id`. It strips
Gutenberg `<!-- wp:... -->` block comments, rewrites image URLs, and classifies WP pages:
slugs in `$vehicleSlugs` become fleet vehicles, `$pageSlugs` become CMS pages, everything of
`post_type=post` becomes a blog post. **Fare pricing does not exist in the WP data**, so the
importer seeds default rates — adjust per-vehicle rates in the admin afterward.

**Routing (`routes/web.php`).** Order matters: `routes/auth.php` is required, and the generic
CMS catch-all `GET /{slug}` **must stay last** so it doesn't shadow named routes. Public pages,
fleet, booking flow, blog and contact are all defined before it. `Vehicle` uses `slug` as its
route key; `Booking` is looked up by `booking_no`, not id.

**Booking + fare flow.** All fare math is centralized in `Vehicle::estimateFare($tripType,
$distanceKm, $hours)` — used by both the AJAX estimate endpoint (`POST /booking/estimate`) and
`BookingController::store`. Trip types are `distance | hourly | fixed`; fare = `base_fare` +
(`per_km`×km or `per_hour`×hours), floored at `min_fare`. Bookings get an `MKT-XXXXXXXX`
`booking_no` auto-assigned in `Booking::booted()`'s `creating` hook.

**Payments (`PaymentController`).** When `services.stripe.secret` is empty the checkout route
falls back to `cash` / pay-on-arrival and redirects to confirmation — so the whole flow works
without Stripe keys. With keys set it creates a Stripe Checkout session and marks the booking
paid/confirmed on return.

**Admin (Filament).** Panel defined in `app/Providers/Filament/AdminPanelProvider.php`; resources
auto-discovered from `app/Filament/Resources`. Access is gated by `User::canAccessPanel()`, which
requires `is_admin = true`. Dashboard stats come from `app/Filament/Widgets/StatsOverview.php`.

**Models** use `$guarded = []` (fully mass-assignable) with `$casts` for typed/JSON columns
(e.g. `Vehicle::$gallery`/`features` are `array`). `User` declares Filament contracts and uses
PHP-attribute `#[Fillable]`/`#[Hidden]` instead of properties.

## Conventions

- Keep the `GET /{slug}` route last in `web.php`.
- Route new fare logic through `Vehicle::estimateFare()` rather than recomputing inline.
- Preserve the `@verbatim` wrapping in `wp.blade.php`; the embedded markup is intentionally raw.
