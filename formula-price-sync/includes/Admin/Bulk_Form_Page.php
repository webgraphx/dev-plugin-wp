<?php
/**
 * Bulk formula application page.
 *
 * @package FPS\Admin
 */

namespace FPS\Admin;

class Bulk_Form_Page {

	public static function render(): void {
		echo '<div class="wrap fps-wrap">';
		echo '<h1>' . esc_html__( 'Bulk Formulas', 'formula-price-sync' ) . '</h1>';
		echo '<form id="fps-bulk-form" method="post">';
		echo '<div class="fps-card">';
		echo '<p>' . esc_html__( 'Select products and apply a pricing formula.', 'formula-price-sync' ) . '</p>';
		echo '<p><button type="button" id="fps-bulk-apply" class="fps-btn fps-btn-primary">' . esc_html__( 'Apply', 'formula-price-sync' ) . '</button></p>';
		echo '</div></form></div>';
	}
}
