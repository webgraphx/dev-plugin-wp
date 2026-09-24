<?php
/**
 * Audit log list page.
 *
 * @package FPS\Admin
 */

namespace FPS\Admin;

class Log_List_Page {

	public static function render(): void {
		echo '<div class="wrap fps-wrap">';
		echo '<h1>' . esc_html__( 'Logs', 'formula-price-sync' ) . '</h1>';
		echo '<div class="fps-card"><p>' . esc_html__( 'Audit log entries will appear here.', 'formula-price-sync' ) . '</p></div>';
		echo '</div>';
	}
}
