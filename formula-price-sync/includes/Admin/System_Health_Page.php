<?php
/**
 * System health dashboard.
 *
 * @package FPS\Admin
 */

namespace FPS\Admin;

class System_Health_Page {

	public static function render(): void {
		echo '<div class="wrap fps-wrap"><h1>' . esc_html__( 'System Health', 'formula-price-sync' ) . '</h1>';
		echo '<p><button type="button" id="fps-health-refresh" class="fps-btn fps-btn-secondary">' . esc_html__( 'Refresh', 'formula-price-sync' ) . '</button> ';
		echo '<span id="fps-health-last-updated"></span></p>';
		echo '<div id="fps-health-cards">' . self::render_cards_html() . '</div></div>';
	}

	public static function render_cards_html(): string {
		html = '<div class="fps-health-card"><div class="label">PHP</div><div class="value">' . esc_html( PHP_VERSION ) . '</div></div>';
		$html .= '<div class="fps-health-card"><div class="label">WordPress</div><div class="value">' . esc_html( get_bloginfo( 'version' ) ) . '</div></div>';
		return $html;
	}
}
