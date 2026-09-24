# Formula Price Sync 2.0.0 — Redevelopment Hardening

- **Post-R17 hardening:** bumped schema version to `2.0.1`; removed the `FPS_ENGINEERING_CANDIDATE` release bypass; added configurable `License_Guard` + `Rastchin_Adapter` server-side licensing; normalized external booleans safely; removed buyer-facing build instructions.


## Final hardening stages

- **R14 — Static Quality:** PHPCS + static analysis gates, release reproducibility checks.
- **R15 — Real DB + HPOS:** MySQL CAS concurrency, real WP/WC/HPOS E2E.
- **R16 — Action Scheduler + Notifier:** full queue integration, Telegram/SMS notifications.
- **R17 — Marketplace packaging + License Guard:** Zhaket + Rastchin adapters, fail-closed license checks, clean release ZIP without tests/bin.

See individual commit messages and `bin/` scripts for the exact verification steps used in CI.
