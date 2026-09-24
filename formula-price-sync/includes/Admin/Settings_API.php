<?php
/**
 * Settings registration and rendering.
 *
 * @package FPS\Admin
 */

namespace FPS\Admin;

class Settings_API {

	public static function init(): void {
		add_action( 'admin_init', array( __CLASS__, 'register' ) );
	}

	public static function register(): void {
		register_setting( 'fps_settings_group', 'fps_settings' );
	}

	public static function render_page(): void {
		echo '<div class="wrap fps-wrap"><h1>' . esc_html__( 'Settings', 'formula-price-sync' ) . '</h1>';
		echo '<form id="fps-settings-form" method="post">';
		settings_fields( 'fps_settings_group' );
		echo '<div class="fps-card"><p>' . esc_html__( 'Configure rate providers and general options.', 'formula-price-sync' ) . '</p>';
		echo '<p><button type="button" id="fps-save-settings" class="fps-btn fps-btn-primary">' . esc_html__( 'Save', 'formula-price-sync' ) . '</button></p></div>';
		echo '</form></div>';
	}

	public static function save_from_request() {
		// Persist posted settings.
		return true;
	}
}
