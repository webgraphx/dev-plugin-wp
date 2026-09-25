<?php
/**
 * Plugin Name: Formula Price Sync / طلا ارز پرو
 * Plugin URI:  https://webgraphx.ir
 * Description: قیمت‌گذاری خودکار محصولات ووکامرس بر اساس نرخ ارز، طلا و فرمول‌های سفارشی – با پشتیبانی از محصولات ساده و متغیر، Circuit Breaker و لاگ تغییرات قیمت.
 * Version:     2.0.0
 * Author:      WebGraphx
 * Author URI:  https://webgraphx.ir
 * Text Domain: formula-price-sync
 * Domain Path: /languages
 * Requires at least: 5.8
 * Requires PHP: 7.4
 * WC requires at least: 5.0
 * WC tested up to: 9.0
 * License:     GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 *
 * @package FormulaPriceSync
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'FPS_VERSION' ) ) {
	define( 'FPS_VERSION', '2.0.0' );
}
define( 'FPS_PATH', plugin_dir_path( __FILE__ ) );
define( 'FPS_URL', plugin_dir_url( __FILE__ ) );
define( 'FPS_BASENAME', plugin_basename( __FILE__ ) );
define( 'FPS_DB_VERSION', '2.0.0' );

// Autoload (Composer + simple fallback).
$fps_autoload = FPS_PATH . 'vendor/autoload.php';
if ( file_exists( $fps_autoload ) ) {
	require_once $fps_autoload;
}

// Bootstrap.
require_once FPS_PATH . 'includes/bootstrap.php';

/**
 * Main plugin bootstrap.
 */
function fps_init() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		add_action( 'admin_notices', function () {
			echo '<div class="notice notice-error"><p>' . esc_html__( 'Formula Price Sync requires WooCommerce to be active.', 'formula-price-sync' ) . '</p></div>';
		} );
		return;
	}
	\FPS\Plugin::instance();
}
add_action( 'plugins_loaded', 'fps_init', 20 );

register_activation_hook( __FILE__, array( 'FPS\\Core\\DB_Installer', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'FPS\\Core\\Cron_Manager', 'deactivate' ) );
