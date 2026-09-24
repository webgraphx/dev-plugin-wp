<?php
/**
 * Product metabox for formula assignment.
 *
 * @package FPS\Admin
 */

namespace FPS\Admin;

class Metaboxes {

	public static function init(): void {
		add_action( 'add_meta_boxes', array( __CLASS__, 'add' ) );
		add_action( 'save_post_product', array( __CLASS__, 'save' ), 10, 2 );
	}

	public static function add(): void {
		add_meta_box(
			'fps_formula',
			__( 'FPS Formula', 'formula-price-sync' ),
			array( __CLASS__, 'render' ),
			'product',
			'side'
		);
	}

	public static function render( \WP_Post $post ): void {
		$formula = get_post_meta( $post->ID, '_fps_formula', true );
		wp_nonce_field( 'fps_metabox', 'fps_metabox_nonce' );
		echo '<p><label for="fps_formula_field">' . esc_html__( 'Formula', 'formula-price-sync' ) . '</label></p>';
		echo '<input type="text" id="fps_formula_field" name="fps_formula" value="' . esc_attr( $formula ) . '" class="widefat" />';
	}

	public static function save( int $post_id, \WP_Post $post ): void {
		if ( ! isset( $_POST['fps_metabox_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['fps_metabox_nonce'] ) ), 'fps_metabox' ) ) {
			return;
		}
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		if ( isset( $_POST['fps_formula'] ) ) {
			update_post_meta( $post_id, '_fps_formula', sanitize_text_field( wp_unslash( $_POST['fps_formula'] ) ) );
		}
	}
}
