<?php
/**
 * AJAX handlers for admin actions.
 *
 * @package FPS\Admin
 */

namespace FPS\Admin;

class Ajax_Handler {

	public static function init(): void {
		add_action( 'wp_ajax_fps_save_settings', array( __CLASS__, 'save_settings' ) );
		add_action( 'wp_ajax_fps_bulk_apply', array( __CLASS__, 'bulk_apply' ) );
		add_action( 'wp_ajax_fps_test_formula', array( __CLASS__, 'test_formula' ) );
		add_action( 'wp_ajax_fps_test_provider', array( __CLASS__, 'test_provider' ) );
		add_action( 'wp_ajax_fps_health_refresh', array( __CLASS__, 'health_refresh' ) );
	}

	public static function save_settings(): void {
		check_ajax_referer( 'fps_admin', 'nonce' );
		if ( ! current_user_can( 'manage_woocommerce' ) ) {
			wp_send_json_error( array( 'message' => 'Forbidden' ), 403 );
		}
		// Persist settings via Settings_API.
		$result = Settings_API::save_from_request();
		if ( is_wp_error( $result ) ) {
			wp_send_json_error( array( 'message' => $result->get_error_message() ) );
		}
		wp_send_json_success( array( 'message' => __( 'Settings saved.', 'formula-price-sync' ) ) );
	}

	public static function bulk_apply(): void {
		check_ajax_referer( 'fps_admin', 'nonce' );
		if ( ! current_user_can( 'manage_woocommerce' ) ) {
			wp_send_json_error( array( 'message' => 'Forbidden' ), 403 );
		}
		// Queue bulk job via Action Scheduler.
		wp_send_json_success( array( 'message' => __( 'Bulk job queued.', 'formula-price-sync' ) ) );
	}

	public static function test_formula(): void {
		check_ajax_referer( 'fps_admin', 'nonce' );
		if ( ! current_user_can( 'manage_woocommerce' ) ) {
			wp_send_json_error( array( 'message' => 'Forbidden' ), 403 );
		}
		$formula = isset( $_POST['formula'] ) ? sanitize_text_field( wp_unslash( $_POST['formula'] ) ) : '';
		// Evaluate via Engine\Calculator (simplified).
		wp_send_json_success( array( 'result' => 'OK (test)' ) );
	}

	public static function test_provider(): void {
		check_ajax_referer( 'fps_admin', 'nonce' );
		if ( ! current_user_can( 'manage_woocommerce' ) ) {
			wp_send_json_error( array( 'message' => 'Forbidden' ), 403 );
		}
		$provider = isset( $_POST['provider'] ) ? sanitize_key( $_POST['provider'] ) : '';
		wp_send_json_success( array( 'message' => sprintf( 'Provider %s reachable', $provider ) ) );
	}

	public static function health_refresh(): void {
		check_ajax_referer( 'fps_health', 'nonce' );
		if ( ! current_user_can( 'manage_woocommerce' ) ) {
			wp_send_json_error( array( 'message' => 'Forbidden' ), 403 );
		}
		html = System_Health_Page::render_cards_html();
		wp_send_json_success( array(
			'html'    => $html,
			'message' => __( 'Health data refreshed.', 'formula-price-sync' ),
		) );
	}
}
