# Changelog

All notable changes to `VenezuelanForeignExchanges` will be documented in this file.

## [1.0.1] - 2026-05-28

### Security
- Updated Laravel 13 dependencies for Symfony security patches
- Updated vulnerable Symfony packages:
  - symfony/polyfill-intl-idn (v1.37.0 -> v1.38.1) - CVE-2026-46644
  - symfony/routing (v7.4.8 -> v7.4.13) - CVE-2026-48784, CVE-2026-45065
  - symfony/yaml (v7.4.8 -> v7.4.13) - CVE-2026-45304, CVE-2026-45305, CVE-2026-45133
- Updated orchestra/testbench-core (v11.3.1 -> v11.3.3)

### Changes
- Updated composer.lock with 40 dependency updates
- Composer audit: No vulnerabilities found

## [1.0.0] - 2026-05-01

### Initial Release
- Venezuelan foreign exchange rates management
- Models for exchange rates
- API resources
- Facade
