# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What This Is

A **FilamentPHP v5 form field plugin** distributed as a Laravel package: `vitisstudio/filament-choosable-chips`, namespace `VitisStudio\FilamentChoosableChips` ([composer.json](composer.json)). The field renders checkbox/radio options as dismissable, colorable, icon-bearing badge "chips" with a fluent options API modeled on Filament's `Select`. The package is scaffolded from the Spatie Laravel package skeleton and already configured (the `configure.php` scaffolder has been run and removed) — the `src/` classes are still the skeleton's example `FilamentChoosableChips` / facade / command and have **not** yet been replaced with the actual chip-field implementation.

Built against Filament v5 (`filament/forms` is a runtime dep; `support`, `schemas`, `infolists`, `actions`, `notifications` are pulled transitively into `vendor/filament/`). PHP **8.4+** only.

## Running & Previewing the Package

There is **no root Laravel app and no root `artisan`**. A bootable preview app lives in [workbench/](workbench/) (Orchestra Testbench), configured by [testbench.yaml](testbench.yaml). All artisan-style commands go through testbench:

```bash
composer serve                       # build workbench assets + serve the preview app (artisan serve equivalent)
vendor/bin/testbench <artisan cmd>   # any artisan command, e.g. route:list, tinker
vendor/bin/testbench package:discover  # re-register the package provider (also run by composer install)
```

Add a route/page in [workbench/routes/web.php](workbench/routes/web.php) and views under [workbench/resources/](workbench/resources/) to render the field for manual preview. Register dev-only services in [workbench/app/Providers/WorkbenchServiceProvider.php](workbench/app/Providers/WorkbenchServiceProvider.php) (commented out in `testbench.yaml` until needed).

`composer install`/`dump-autoload` runs `post-autoload-dump` → `package:purge-skeleton` + `package:discover`, so the provider is auto-registered into the testbench harness.

## Laravel Boost / AI tooling

Laravel Boost is installed (`laravel/boost` dev dep) and wired via [.mcp.json](.mcp.json), which runs `artisan boost:mcp`. Because there's no root artisan, the Boost MCP server resolves against the **workbench** app. `filament/blueprint` (dev dep) ships Filament's AI planning guidelines + a `filament-security-audit` skill under `vendor/filament/blueprint/resources/` — it is guideline content, not runnable code. The Boost guideline block at the bottom of this file (search-docs, artisan, tinker, PHP conventions) is authoritative — follow it, especially **`search-docs` before any Filament code change** to get version-correct v5 API.

## Commands

```bash
composer test            # Pest test suite (vendor/bin/pest)
composer test-coverage   # Pest with coverage
composer analyse         # PHPStan / Larastan, level 5 (src, config, database)
composer format          # Laravel Pint (default Laravel preset, no pint.json)
composer lint            # Pint + PHPStan together
```

Single test file or filter:

```bash
vendor/bin/pest tests/ArchTest.php
vendor/bin/pest --filter='it can run'
```

## Architecture

Spatie `laravel-package-tools` package. PSR-4: `VitisStudio\FilamentChoosableChips\` → [src/](src/); factories → [database/factories/](database/factories/); test/workbench namespaces in `autoload-dev`.

- **[src/FilamentChoosableChipsServiceProvider.php](src/FilamentChoosableChipsServiceProvider.php)** — the single wiring point. Extends `PackageServiceProvider`; declares capabilities fluently in `configurePackage()` (`->hasConfigFile()`, `->hasViews()`, `->hasMigration()`, `->hasCommand()`). The base class handles publishing/registration. Read this first to see what the package exposes. The chip field's Blade view(s) will be registered through `->hasViews()` and live under [resources/views/](resources/views/) (published with the `filament-choosable-chips` tag).
- **[src/FilamentChoosableChips.php](src/FilamentChoosableChips.php)**, **[src/Facades/FilamentChoosableChips.php](src/Facades/FilamentChoosableChips.php)**, **[src/Commands/FilamentChoosableChipsCommand.php](src/Commands/FilamentChoosableChipsCommand.php)** — skeleton placeholders. The actual form-field class (extending Filament's field base, with a fluent options/colors/icons API and a `multiple()` single-vs-multi toggle) is **still to be written**; these are the slots it replaces.
- **Migrations** ship as `.php.stub` in [database/migrations/](database/migrations/) (published into the host app, not run in-package).

### Building the chip field (intended design)

- One field class, fluent API patterned on `Select::make()->options([...])`: per-option `label`, plus overridable `color`, `icon`, `label`.
- Default = single-select (radio semantics, one chip). `->multiple()` = multi-select (checkbox semantics) — mirrors Filament `Select`'s own `multiple()` convention.
- Each chip reuses Filament's **built-in badge component**; chips are dismissable, carry a color and icon.
- Style with Tailwind utility classes; **prefer Filament defaults** (badge component, color tokens) over custom CSS wherever possible.

## Testing

Pest 4 (arch + Laravel plugins) on Orchestra Testbench — no full Laravel app.

- **[tests/TestCase.php](tests/TestCase.php)** registers `FilamentChoosableChipsServiceProvider` via `getPackageProviders()` and sets factory name resolution. The migration-load loop in `getEnvironmentSetUp()` is commented out — uncomment to run package migrations against the test DB.
- **[tests/Pest.php](tests/Pest.php)** binds `TestCase` to every test under `tests/`.
- **[tests/ArchTest.php](tests/ArchTest.php)** bans `dd`/`dump`/`ray` in committed code — keep debugging calls out of `src/`.
- [phpunit.xml.dist](phpunit.xml.dist) is strict: `failOnWarning`, `failOnRisky`, `failOnEmptyTestSuite`, random order. Output during a test, or an empty suite, fails the run.

## CI

[.github/workflows/run-tests.yml](.github/workflows/run-tests.yml): matrix PHP 8.3–8.5 × Laravel 12/13 × prefer-lowest/stable on Ubuntu + Windows. PHPStan runs in its own workflow. Code style is auto-fixed by the `fix-php-code-style-issues` (Pint) workflow — don't hand-fight formatting.

===

<laravel-boost-guidelines>
=== foundation rules ===

# Laravel Boost Guidelines

The Laravel Boost guidelines are specifically curated by Laravel maintainers for this application. These guidelines should be followed closely to ensure the best experience when building Laravel applications.

## Foundational Context

This application is a Laravel application and its main Laravel ecosystems package & versions are below. You are an expert with them all. Ensure you abide by these specific packages & versions.

- php - 8.4

## Skills Activation

This project has domain-specific skills available in `**/skills/**`. You MUST activate the relevant skill whenever you work in that domain—don't wait until you're stuck.

## Conventions

- You must follow all existing code conventions used in this application. When creating or editing a file, check sibling files for the correct structure, approach, and naming.
- Use descriptive names for variables and methods. For example, `isRegisteredForDiscounts`, not `discount()`.
- Check for existing components to reuse before writing a new one.

## Verification Scripts

- Do not create verification scripts or tinker when tests cover that functionality and prove they work. Unit and feature tests are more important.

## Application Structure & Architecture

- Stick to existing directory structure; don't create new base folders without approval.
- Do not change the application's dependencies without approval.

## Frontend Bundling

- If the user doesn't see a frontend change reflected in the UI, it could mean they need to run `npm run build`, `npm run dev`, or `composer run dev`. Ask them.

## Documentation Files

- You must only create documentation files if explicitly requested by the user.

## Replies

- Be concise in your explanations - focus on what's important rather than explaining obvious details.

=== boost rules ===

# Laravel Boost

## Tools

- Laravel Boost is an MCP server with tools designed specifically for this application. Prefer Boost tools over manual alternatives like shell commands or file reads.
- Use `database-query` to run read-only queries against the database instead of writing raw SQL in tinker.
- Use `database-schema` to inspect table structure before writing migrations or models.
- Use `get-absolute-url` to resolve the correct scheme, domain, and port for project URLs. Always use this before sharing a URL with the user.
- Use `browser-logs` to read browser logs, errors, and exceptions. Only recent logs are useful, ignore old entries.

## Searching Documentation (IMPORTANT)

- Always use `search-docs` before making code changes. Do not skip this step. It returns version-specific docs based on installed packages automatically.
- Pass a `packages` array to scope results when you know which packages are relevant.
- Use multiple broad, topic-based queries: `['rate limiting', 'routing rate limiting', 'routing']`. Expect the most relevant results first.
- Do not add package names to queries because package info is already shared. Use `test resource table`, not `filament 4 test resource table`.

### Search Syntax

1. Use words for auto-stemmed AND logic: `rate limit` matches both "rate" AND "limit".
2. Use `"quoted phrases"` for exact position matching: `"infinite scroll"` requires adjacent words in order.
3. Combine words and phrases for mixed queries: `middleware "rate limit"`.
4. Use multiple queries for OR logic: `queries=["authentication", "middleware"]`.

## Artisan

- Run Artisan commands directly via the command line (e.g., `php artisan route:list`). Use `php artisan list` to discover available commands and `php artisan [command] --help` to check parameters.
- Inspect routes with `php artisan route:list`. Filter with: `--method=GET`, `--name=users`, `--path=api`, `--except-vendor`, `--only-vendor`.
- Read configuration values using dot notation: `php artisan config:show app.name`, `php artisan config:show database.default`. Or read config files directly from the `config/` directory.

## Tinker

- Execute PHP in app context for debugging and testing code. Do not create models without user approval, prefer tests with factories instead. Prefer existing Artisan commands over custom tinker code.
- Always use single quotes to prevent shell expansion: `php artisan tinker --execute 'Your::code();'`
  - Double quotes for PHP strings inside: `php artisan tinker --execute 'User::where("active", true)->count();'`

=== php rules ===

# PHP

- Always use curly braces for control structures, even for single-line bodies.
- Use PHP 8 constructor property promotion: `public function __construct(public GitHub $github) { }`. Do not leave empty zero-parameter `__construct()` methods unless the constructor is private.
- Use explicit return type declarations and type hints for all method parameters: `function isAccessible(User $user, ?string $path = null): bool`
- Use TitleCase for Enum keys: `FavoritePerson`, `BestLake`, `Monthly`.
- Prefer PHPDoc blocks over inline comments. Only add inline comments for exceptionally complex logic.
- Use array shape type definitions in PHPDoc blocks.

=== deployments rules ===

# Deployment

- Laravel can be deployed using [Laravel Cloud](https://cloud.laravel.com/), which is the fastest way to deploy and scale production Laravel applications.

</laravel-boost-guidelines>
