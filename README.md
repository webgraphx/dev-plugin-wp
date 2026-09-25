# Dev-Plugin-Wp — Formula Price Sync

**Baseline source of truth:** `formula-price-sync-2.0.0-R17-IMPROVED.zip`

This repository tracks the **Formula Price Sync** (طلا ارز پرو) WordPress plugin developed by WebGraphx.

## Current status

| Item | Value |
|------|-------|
| Version | 2.0.0 (R17 IMPROVED) |
| Branch for full replace | `feature/r17-improved-full-replace` |
| Test site | https://keepkey.s6-tastewp.com/ |
| Package | See project artifacts / release zip |

## Plugin location

```
formula-price-sync/
├── formula-price-sync.php   # main bootstrap
├── includes/                # API, Admin, Core, Engine, Queue, Licensing, …
├── assets/
├── tests/
├── bin/build-release.sh
└── …
```

## How to work with this repo

1. All code changes are made on feature branches and merged via Pull Request.
2. After merge to `main`, the plugin is installed/tested on the TasteWP site.
3. Release packages are produced with `bin/build-release.sh` (excludes tests, bin, node, ts, etc.).

## Installing the R17 IMPROVED package on TasteWP

1. Download `formula-price-sync-2.0.0-R17-IMPROVED.zip`.
2. In WordPress admin → Plugins → Add New → Upload Plugin.
3. Activate and configure under **Formula Price Sync** menu.

## Notes

- The R17 IMPROVED zip is the audited production candidate.
- Three remaining P0 fixes are tracked in the project backlog (packaging leak, AtomicOptionLock tests, Calculator breakdown tests).
- Binary assets (fonts `.woff`/`.woff2`, `.mo`) must be kept in sync when replacing the tree.
