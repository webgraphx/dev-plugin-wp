<?php
/**
 * Admin menu registration and page callbacks.
 *
 * @package FPS\Admin
 */

namespace FPS\Admin;

class Admin_Menu {

	public static function init(): void {
		add_action( 'admin_menu', array( __CLASS__, 'register_menus' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_assets' ) );
	}

	public static function register_menus(): void {
		add_menu_page(
			__( 'Formula Price Sync', 'formula-price-sync' ),
			__( 'طلا ارز پرو', 'formula-price-sync' ),
			'manage_woocommerce',
			'fps-dashboard',
			array( __CLASS__, 'render_dashboard' ),
			'dashicons-chart-line',
			56
		);

		add_submenu_page(
			'fps-dashboard',
			__( 'Settings', 'formula-price-sync' ),
			__( 'تنظیمات', 'formula-price-sync' ),
			'manage_woocommerce',
			'fps-settings',
			array( __CLASS__, 'render_settings' )
		);

		add_submenu_page(
			'fps-dashboard',
			__( 'Bulk Formulas', 'formula-price-sync' ),
			__( 'فرمول گروهی', 'formula-price-sync' ),
			'manage_woocommerce',
			'fps-bulk',
			array( __CLASS__, 'render_bulk' )
		);

		add_submenu_page(
			'fps-dashboard',
			__( 'History', 'formula-price-sync' ),
			__( 'تاریخچه', 'formula-price-sync' ),
			'manage_woocommerce',
			'fps-history',
			array( __CLASS__, 'render_history' )
		);

		add_submenu_page(
			'fps-dashboard',
			__( 'System Health', 'formula-price-sync' ),
			__( 'سلامت سیستم', 'formula-price-sync' ),
			'manage_woocommerce',
			'fps-health',
			array( __CLASS__, 'render_health' )
		);

		add_submenu_page(
			'fps-dashboard',
			__( 'Logs', 'formula-price-sync' ),
			__( 'لاگ‌ها', 'formula-price-sync' ),
			'manage_woocommerce',
			'fps-logs',
			array( __CLASS__, 'render_logs' )
		);
	}

	public static function enqueue_assets( string $hook ): void {
		if ( strpos( $hook, 'fps-' ) === false && strpos( $hook, 'fps_dashboard' ) === false ) {
			return;
		}

		wp_enqueue_style(
			'fps-admin',
			FPS_PLUGIN_URL . 'assets/css/admin.css',
			array(),
			FPS_VERSION
		);

		wp_enqueue_script(
			'fps-admin-app',
			FPS_PLUGIN_URL . 'assets/js/admin-app.js',
			array( 'jquery' ),
			FPS_VERSION,
			true
		);

		wp_localize_script( 'fps-admin-app', 'FPSAdmin', array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'fps_admin' ),
			'i18n'    => array(
				'saved'      => __( 'Saved', 'formula-price-sync' ),
				'error'      => __( 'Error', 'formula-price-sync' ),
				'working'    => __( 'Working…', 'formula-price-sync' ),
				'confirmBulk'=> __( 'Apply formula to selected products?', 'formula-price-sync' ),
				'bulkOk'     => __( 'Bulk apply completed', 'formula-price-sync' ),
			),
		) );

		if ( strpos( $hook, 'fps-health' ) !== false ) {
			wp_enqueue_script(
				'fps-health',
				FPS_PLUGIN_URL . 'assets/js/health-page.js',
				array( 'jquery' ),
				FPS_VERSION,
				true
			);
			wp_localize_script( 'fps-health', 'FPSHealth', array(
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'nonce'   => wp_create_nonce( 'fps_health' ),
				'i18n'    => array(
					'refreshing' => __( 'Refreshing…', 'formula-price-sync' ),
					'refreshed'  => __( 'Updated', 'formula-price-sync' ),
					'error'      => __( 'Error', 'formula-price-sync' ),
					'refreshBtn' => __( 'Refresh', 'formula-price-sync' ),
				),
			) );
		}

		if ( strpos( $hook, 'fps-history' ) !== false ) {
			wp_enqueue_script(
				'fps-history',
				FPS_PLUGIN_URL . 'assets/js/history-page.js',
				array( 'jquery' ),
				FPS_VERSION,
				true
			);
		}
	}

	public static function render_dashboard(): void {
		echo '<div class="wrap fps-wrap"><h1>' . esc_html__( 'Formula Price Sync', 'formula-price-sync' ) . '</h1>';
		echo '<p>' . esc_html__( 'Dashboard overview.', 'formula-price-sync' ) . '</p></div>';
	}

	public static function render_settings(): void {
		Settings_API::render_page();
	}

	public static function render_bulk(): void {
		Bulk_Form_Page::render();
	}

	public static function render_history(): void {
		History_Page::render();
	}

	public static function render_health(): void {
		System_Health_Page::render();
	}

	public static function render_logs(): void {
		Log_List_Page::render();
	}
}
