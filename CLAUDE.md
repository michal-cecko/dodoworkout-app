# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project

DodoWorkout — Slovak fitness brand's public site (multilingual SK/EN) with blog, events, custom form builder, orders/payments, and a Filament v3 admin panel. Laravel 12, PHP 8.2+ (8.4 in prod), PostgreSQL, Redis, Vite, Tailwind/DaisyUI. Deployed to Dokploy via a two-stage Dockerfile.

## Commands

```bash
composer install                    # requires auth.json (Filament Pro + synapps repman creds)
npm install
php artisan key:generate
php artisan migrate --seed          # PostgreSQL — see docker-compose.yml for Sail stack

composer dev                        # concurrently: artisan serve + queue:listen + pail + vite
npm run dev                         # vite only
npm run build                       # production assets

php artisan test                    # PHPUnit 11, suites: Unit, Feature (testing DB is "testing")
./vendor/bin/phpunit --filter=SomeTest
./vendor/bin/pint                   # code style (Laravel Pint)
php artisan filament:upgrade        # runs automatically on composer post-autoload-dump
```

Admin panel lives at `/dashboard` (not `/admin`, despite the README). SK routes are bare (`/blog`, `/eventy`); EN routes are prefixed (`/en/blog`, `/en/events`).

## Architecture

### Locales are first-class
SK is the default/fallback; EN is the only non-default locale. The `Locale` enum (`app/Enum/Locale.php`) drives `config('app.locales')` everywhere — adding a third locale means updating the enum and the route file.

- **Routing**: `routes/web.php` defines bare SK routes plus an `/en` group whose route names are prefixed (`en.post`, `en.event`, …). `SetLocale` middleware reads the current route name to set `App::setLocale()`.
- **URL building**: never call `route()` directly for user-facing links — use `LocaleService::getLocalizedRoutePathByName()` so the right locale prefix and route-name variant are chosen. `Post::permalink` and `Event::permalink` accessors already do this and honor each record's `locale_scope`.
- **Translatable columns** (Spatie): JSON columns like `title`, `slug`, `content`, `excerpt`, `address` store `{"sk": "...", "en": "..."}`. Query by locale with `whereRaw("slug->> ? = ?", [App::currentLocale(), $slug])`.

### Model conventions
Editable content models (`Post`, `Event`) compose a stack of contracts + traits + observer:

- `Sluggable` + `HasSlug` + `SlugObserver` (attached via `#[ObservedBy]`) auto-generates a unique slug **per locale** on `creating` using each model's `slugFormat(Locale)`. Slugs are immutable thereafter.
- `HasDraft` adds a `visible()` query scope (`is_draft = false`). All public controllers (`PageController`) chain `->visible()`.
- `CanCopyLocaleMutations` + `HasCopyLocaleMutations` + `CopyLocaleFieldsAction` (Filament) lets admins copy SK↔EN translations on a record.
- File storage paths come from accessors like `storage_base_path`; deleted-model hooks clear both Spatie media and the on-disk directory.

### MorphMap is the source of truth for polymorphic types
`App\Misc\MorphMap::make()` registers short string keys (`"EVENT"`, `"POST"`, `"ORDER_ITEM"`, …) and is wired up in `AppServiceProvider::boot()` via `Relation::morphMap()`. **Polymorphic columns store these keys, not FQCNs.** `OrderService` resolves them via `MorphMap::getModelByKey()` when processing line items. If you add a polymorphic model, register it here.

### Order flow
`OrderController::storeOrder` builds three DTOs (`OrderBillingDataDTO`, `OrderShippingDataDTO`, `StoreOrderDTO`) from a validated request and calls `OrderService::storeOrder($dto, $products)`. The service groups the product collection by `type` (a MorphMap key), looks each batch up via the resolved model class, computes VAT per `config/order.php` (`vat_percentages` keyed by `OrderCountry`, currently all zeroed for SK), and writes `Order` + `OrderItem`s. VAT logic lives in `OrderService::getVatPercentageForSpecificCountry` — extend this when adding foreign country rules.

### Filament admin
`DashboardPanelProvider` (default panel, path `/dashboard`) auto-discovers `app/Filament/Resources`, `app/Filament/Pages`, `app/Filament/Widgets`. The translatable plugin is configured from `config('app.locales')`. All resources extend `App\Filament\Resources\CommonResource`, which extends `Synapps\Filament\Resources\CommonResource` (an in-house package from `synapps.repo.repman.io`) and adds Filament's `Translatable` concern. Form scaffolding for content-heavy pages comes from the `UseContentBuilder` and `UseMapField` traits in `app/Filament/Trait/`.

### Strict ORM defaults
`AppServiceProvider::boot()` enables `Model::preventLazyLoading(!app()->isProduction())` — N+1 queries throw in non-prod. Always eager-load relations explicitly (see `PageController` for examples: `with(['media', 'tags'])`, `with(['media', 'category', 'form.formFields'])`).

### Slovak everywhere
User-facing labels, Filament notifications, exception messages, and admin UI strings are written in Slovak. Match this when editing existing code; only change to English if the message is also being moved into the `lang/` translation files.

## Required setup notes

- `auth.json` (gitignored) must contain Composer credentials for Filament Pro (`filament.com`) and the `synapps.repo.repman.io` repository — composer install fails without it.
- `.env` defaults to PostgreSQL on host `pgsql` (the Sail service name) and Redis for sessions/cache.
- `APP_LOCALE` and `APP_FALLBACK_LOCALE` should both be `sk` to keep the default-locale-has-bare-URLs assumption intact.
