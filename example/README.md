# Choosable Chips — example app

A minimal Filament v5 panel that demonstrates the
[`vitisstudio/filament-choosable-chips`](../) field in a real application. The
package is linked from the repository root via a Composer **path repository**, so
any edit you make to the package is reflected here immediately.

## What it shows

A single Filament page (`app/Filament/Pages/ChoosableChipsDemo.php`) with the
`ChoosableChips` field used several ways:

- single select (radio) with per-option colors and icons
- multiple select (checkbox) with the automatic selected-check
- icons, a disabled option, and `required()` validation
- `checkSelected()` and `size()`

Saving the form sends a notification containing the form state, so you can see how
single-select stores a scalar and multi-select stores an array.

## Run it

From this directory:

```bash
composer install          # installs Filament + the package (symlinked from ../)
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate

npm install
npm run build             # compiles the panel theme (incl. the chip styles)

# create a login
php artisan tinker --execute "App\Models\User::create(['name' => 'Demo', 'email' => 'demo@example.com', 'password' => bcrypt('password')]);"

php artisan serve
```

Then open `/admin`, sign in with `demo@example.com` / `password`, and choose
**Choosable Chips** in the sidebar.

> The custom colors used in the demo (`indigo`, `purple`, `teal`, `cyan`) are
> registered in `app/Providers/AppServiceProvider.php` via `FilamentColor::register()`.
> Any color token not registered in your panel falls back to gray.
