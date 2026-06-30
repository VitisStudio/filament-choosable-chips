# Contributing

Contributions are welcome and will be fully credited.

## Pull requests

- **Add tests.** Patches without tests for new behaviour or bug fixes won't be merged.
- **Keep the style consistent.** Run `composer format` (Laravel Pint) before committing.
- **Pass static analysis.** Run `composer analyse` (PHPStan) and fix any new errors.
- **Document behaviour changes** in the README and the [CHANGELOG](CHANGELOG.md).
- **One pull request per feature.** Open separate PRs for unrelated changes.

## Running the checks

```bash
composer test       # Pest test suite
composer analyse    # PHPStan
composer format     # Laravel Pint
```

To preview the field in a browser while developing, use the bundled Testbench workbench app:

```bash
composer serve
```

## Reporting security issues

Please review the [security policy](README.md#security-vulnerabilities) for how to report vulnerabilities responsibly.

**Happy coding!**
