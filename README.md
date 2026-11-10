# ERP Core

A multi-branch, multi-warehouse Enterprise Resource Planning (ERP) system covering the full business flow: **purchasing → inventory → production → sales → invoicing → accounting**, with role-based access control and an audit trail throughout.

Built on a modern Laravel starter stack with a React (Inertia) frontend and a Filament admin panel.

## Features

### Product Catalog
- Products with categories, units of measurement, barcodes, images, and metadata
- Purchase / selling / cost price tracking with full price change history
- Soft deletes and UUID-based identification on key entities

### Inventory
- Warehouses, branches, and bin-level inventory locations (`LocationStock`)
- Full inventory transaction log for every stock movement
- Stock adjustments with request/approval workflow
- Inter-warehouse transfers with requested/approved/shipped/received lifecycle

### Manufacturing
- Bills of Materials (BOMs) per product
- Production orders tracking raw material consumption against BOMs

### Sales
- Customers and sales representatives (with assigned managers)
- Sales orders (polymorphic buyer) with creation/approval workflow
- Daily sales reports by representatives
- Invoices and payment recording

### Purchasing
- Suppliers with per-supplier product catalogs
- Purchase orders with approval workflow
- Goods receipts (GRN) with items matched to purchase order lines

### Accounting
- Double-entry style ledger entries and account balances

### System
- Role-based permissions (Spatie Laravel Permission)
- Users assignable to multiple branches and warehouses (primary assignment supported)
- Audit logs, settings, and notifications tables
- Two-factor authentication fields on users

## Tech Stack

| Layer          | Technology                                        |
| -------------- | ------------------------------------------------- |
| Backend        | Laravel (PHP 8.3+), Tinker                         |
| Admin panel    | Filament 5 (`/dashboard`)                          |
| Frontend       | React 19 + Inertia.js v3 (SSR-ready), Tailwind CSS 4 |
| Routing (FE)   | Laravel Wayfinder (typed `@/actions`, `@/routes`)  |
| Bundler        | Vite 8 (`vite-plus`), React Compiler (Babel plugin) |
| Authorization  | Spatie Laravel Permission                          |
| Dev tooling    | Pest 4, Larastan (PHPStan), Pint, Laravel Boost    |
| Environment    | Laravel Sail (Docker) + MySQL 8.4                  |

## Requirements

- PHP 8.3+ (8.5 for the Sail Docker runtime)
- Composer
- Node.js + npm
- SQLite (default) or MySQL 8.4 (via Sail)

## Getting Started

### One-shot setup

```bash
composer setup
```

This installs dependencies, copies `.env.example` to `.env`, generates the app key, runs migrations, and builds the frontend assets.

### Manual setup

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm install
npm run build
```

### Docker (Laravel Sail) with MySQL

```bash
./vendor/bin/sail up -d
./vendor/bin/sail composer setup   # or run the manual steps inside the container
```

### Development servers

```bash
composer dev          # runs dev + frontend via `php artisan dev`
# or separately:
php artisan serve     # backend
npm run dev           # Vite dev server (with SSR support)
```

## Available Commands

| Command                     | Description                                        |
| --------------------------- | -------------------------------------------------- |
| `composer dev`              | Start the combined dev environment                 |
| `composer test`             | Lint check + static analysis + full test suite     |
| `composer ci:check`         | Frontend check, TypeScript check, and tests (CI)   |
| `composer lint`             | Fix code style with Pint                           |
| `composer lint:check`       | Check code style without fixing                    |
| `composer types:check`      | Run PHPStan / Larastan static analysis             |
| `npm run build`             | Build frontend assets                              |
| `npm run types:check`       | TypeScript check (`tsc --noEmit`)                  |
| `npm run check` / `check:fix` | Frontend lint/fix via `vite-plus`                |
| `vendor/bin/pest`           | Run the Pest test runner directly                  |

## Project Structure

```
app/
├── Models/            # Eloquent models (44 entities) + Concerns/HasUuid
├── Http/              # Controllers & Inertia middleware
└── Providers/
    └── Filament/      # Dashboard panel (login, emerald theme)
database/
├── migrations/        # Schema: catalog, inventory, manufacturing, sales, purchasing, accounting
└── seeders/
resources/
└── js/
    ├── actions/       # Wayfinder-generated typed controller actions
    ├── routes/        # Wayfinder-generated typed route functions
    ├── pages/         # Inertia pages (React .tsx)
    └── types/         # Shared TypeScript types
routes/
└── web.php            # Inertia routes (`/` welcome page)
```

## Domain Model Overview

Key relationships:

- **Product** → category, unit, images, price history, location stock, transactions, BOMs
- **Warehouse → InventoryLocation → LocationStock → Product** (bin-level stock)
- **Bom → BomItem (raw materials) → ProductionOrder → ProductionOrderMaterial**
- **SalesOrder → SalesOrderItem → Invoices → Payments**
- **PurchaseOrder → PurchaseOrderItem → GoodsReceipts → GRN items**
- **LedgerEntry → AccountBalance** (accounting)
- **User** → branch/warehouse assignments, approvals (`approved_by`), audit logs

Most financial and stock documents follow a **request → approve → execute** lifecycle with `created_by` / `approved_by` tracking.

## Testing & Quality

- **Pest** for unit and feature tests (`tests/Feature`, `tests/Unit`)
- **Pint** enforces the project code style (`pint.json`)
- **Larastan** for static analysis (`phpstan.neon`)

Run the full check locally before opening a PR:

```bash
composer test
```
