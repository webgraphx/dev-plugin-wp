<?php
/**
 * Plugin Name: Formula Price Sync / طلا ارز پرو
 * Plugin URI:  https://webgraphx.ir
 * Description: Automated product pricing by gold & currency formulas (Iranian guild rules). Supports HPOS, Action Scheduler, and multi-provider rate feeds.
 * Version:     2.0.0
 * Author:      WebGraphx
 * Author URI:  https://webgraphx.ir
 * Text Domain: formula-price-sync
 * Domain Path: /languages
 * Requires at least: 5.8
 * Requires PHP: 7.4
 * WC requires at least: 6.0
 * WC tested up to: 9.3
 * License:     GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'FPS_VERSION', '2.0.0' );
define( 'FPS_PLUGIN_FILE', __FILE__ );
define( 'FPS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'FPS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'FPS_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

// Autoloader (Composer or simple).
if ( file_exists( FPS_PLUGIN_DIR . 'vendor/autoload.php' ) ) {
	require_once FPS_PLUGIN_DIR . 'vendor/autoload.php';
}

// Bootstrap.
require_once FPS_PLUGIN_DIR . 'includes/index.php';

/**
 * Main plugin bootstrap.
 */
function fps_init() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		add_action( 'admin_notices', function () {
			echo '<div class="notice notice-error"><p>';
			echo esc_html__( 'Formula Price Sync requires WooCommerce to be active.', 'formula-price-sync' );
			echo '</p></div>';
		} );
		return;
	}

	// Load text domain.
	load_plugin_textdomain( 'formula-price-sync', false, dirname( FPS_PLUGIN_BASENAME ) . '/languages' );

	// Core services.
	\FPS\Core\DB_Installer::maybe_install();
	\FPS\Core\Cron_Manager::init();
	\FPS\Queue\Action_Scheduler_Handler::init();
	\FPS\Admin\Admin_Menu::init();
	\FPS\Admin\Ajax_Handler::init();
	\FPS\Admin\Metaboxes::init();
	\FPS\Admin\Product_Columns::init();
	\FPS\Admin\Settings_API::init();
	\FPS\Integrations\Notifier::init();
	\FPS\Licensing\License_Guard::init();
}
add_action( 'plugins_loaded', 'fps_init', 20 );

register_activation_hook( __FILE__, function () {
	\FPS\Core\DB_Installer::install();
	\FPS\Core\Cron_Manager::schedule();
} );

register_deactivation_hook( __FILE__, function () {
	\FPS\Core\Cron_Manager::unschedule();
} );
