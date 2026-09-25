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
define( 'FPS_FILE', __FILE__ );

/*
 * Autoloader guard: refuse to boot when Composer dependencies are missing.
 * This prevents a white-screen fatal if the plugin is uploaded without
 * running `composer install` (or the release ZIP is broken).
 */
$fps_autoload = FPS_PATH . 'vendor/autoload.php';
if ( ! file_exists( $fps_autoload ) ) {
	add_action(
		'admin_notices',
		static function () {
			if ( ! current_user_can( 'activate_plugins' ) ) {
				return;
			}
			echo '<div class="notice notice-error"><p>';
			echo esc_html__(
				'Formula Price Sync: فایل‌های Composer یافت نشد. لطفاً از بستهٔ رسمی استفاده کنید یا composer install را اجرا کنید.',
				'formula-price-sync'
			);
			echo '</p></div>';
		}
	);
	return;
}
require_once $fps_autoload;

/**
 * Bootstrap the plugin after plugins_loaded so WooCommerce is available.
 *
 * @return void
 */
function fps_boot() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		add_action( 'admin_notices', 'fps_woocommerce_missing_notice' );
		return;
	}
	if ( class_exists( '\\FPS\\Plugin' ) ) {
		\\FPS\\Plugin::instance();
	}
}
add_action( 'plugins_loaded', 'fps_boot', 20 );

register_activation_hook( __FILE__, array( '\\FPS\\Core\\DB_Installer', 'activate' ) );
register_deactivation_hook( __FILE__, array( '\\FPS\\Core\\Cron_Manager', 'deactivate' ) );

/**
 * Admin notice when WooCommerce is missing.
 *
 * @return void
 */
function fps_woocommerce_missing_notice() {
	if ( ! current_user_can( 'activate_plugins' ) ) {
		return;
	}
	?>
	<div class="notice notice-error">
		<p>
			<?php
			echo esc_html__(
				'افزونه طلا ارز پرو (Formula Price Sync) نیاز به نصب و فعال بودن ووکامرس دارد.',
				'formula-price-sync'
			);
			?>
		</p>
	</div>
	<?php
}
