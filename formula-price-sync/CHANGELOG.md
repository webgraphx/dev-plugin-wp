# Changelog

All notable changes to Formula Price Sync are documented in this file.

## [2.0.0] - 2026-09-22 — R17 IMPROVED

### Added
- Full production-ready architecture (API, Engine, Queue, Admin, Licensing, Core)
- Circuit Breaker + Rate Snapshot Store
- Atomic Option Lock (CAS) for concurrent safety
- System Health Page with live diagnostics
- History / Log List / Bulk Form admin pages
- Zhaket + Rastchin license adapters
- Action Scheduler integration for chunked product updates
- Unit + Integration test suite (PHPUnit)
- Playwright e2e smoke tests
- Persian (fa_IR) translation files
- Tanha font for admin UI
- build-release.sh with strict exclude + safety checks

### Security
- Formula_Parser hardened against injection
- Nonce + capability checks on all AJAX
- License gate before process_chunk

### Fixed
- HPOS compatibility
- Cache purging after price updates
- Rounding edge cases for gold formulas

## [1.x] — Legacy

Previous marketplace releases.
