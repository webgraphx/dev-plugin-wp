<?php
/**
 * Price update history page.
 *
 * @package FPS\Admin
 */

namespace FPS\Admin;

class History_Page {

	public static function render(): void {
		echo '<div class="wrap fps-wrap"><h1>' . esc_html__( 'History', 'formula-price-sync' ) . '</h1>';
		echo '<div class="fps-card"><table class="fps-table fps-history-table"><thead><tr><th>ID</th><th>Product</th><th>Old</th><th>New</th><th>Time</th></tr></thead><tbody>';
		echo '<tr><td colspan="5">' . esc_html__( 'No history entries yet.', 'formula-price-sync' ) . '</td></tr>';
		echo '</tbody></table></div></div>';
	}
}
