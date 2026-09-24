=== Formula Price Sync / طلا ارز پرو ===
Contributors: webgraphx
Tags: woocommerce, pricing, gold, currency, iran, formula
Requires at least: 5.8
Tested up to: 6.6
Requires PHP: 7.4
Stable tag: 2.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Automated product pricing by gold & currency formulas (Iranian guild rules). Supports HPOS and Action Scheduler.

== Description ==

Formula Price Sync (طلا ارز پرو) lets you define pricing formulas based on live gold and currency rates from Iranian providers (TGJU, Navasan, Nobitex, Manual). Prices are recalculated automatically via cron or Action Scheduler.

Features:
* Multiple rate providers with circuit breaker and rate limiting
* HPOS compatible
* Action Scheduler queue for large catalogs
* License guard for marketplace distribution (Zhaket / Rastchin)
* Full audit log and system health page
* Persian (Jalali) date support and number-to-words helpers

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/formula-price-sync` directory, or install through the WordPress plugins screen.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Go to Formula Price Sync settings and configure your rate providers and formulas.

== Frequently Asked Questions ==

= Does it support HPOS? =
Yes, fully tested with WooCommerce High-Performance Order Storage.

= Which rate providers are supported? =
TGJU, Navasan, Nobitex and a Manual provider.

== Changelog ==

= 2.0.0 =
* Complete redevelopment with hardening (R14–R17)
* License Guard + marketplace adapters
* Action Scheduler integration
* Improved admin UI and health checks
