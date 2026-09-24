<?php
/**
 * Product list table columns for FPS status.
 *
 * @package FPS\Admin
 */

namespace FPS\Admin;

class Product_Columns {

	public static function init(): void {
		add_filter( 'manage_edit-product_columns', array( __CLASS__, 'add_column' ) );
		add_action( 'manage_product_posts_custom_column', array( __CLASS__, 'render_column' ), 10, 2 );
	}

	public static function add_column( array $columns ): array {
		$columns['fps_formula'] = __( 'FPS Formula', 'formula-price-sync' );
		return $columns;
	}

	public static function render_column( string $column, int $post_id ): void {
		if ( 'fps_formula' !== $column ) {
			return;
		}
		$formula = get_post_meta( $post_id, '_fps_formula', true );
		echo $formula ? esc_html( $formula ) : '—';
	}
}
