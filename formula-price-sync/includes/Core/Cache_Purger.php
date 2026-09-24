<?php
/**
 * Cache purging helpers (object cache, product transients, etc.).
 *
 * @package FPS\Core
 */

namespace FPS\Core;

class Cache_Purger {

	public static function purge_product( int $product_id ): void {
		clean_post_cache( $product_id );
		wc_delete_product_transients( $product_id );
		if ( function_exists( 'wc_delete_shop_order_transients' ) ) {
			// no-op for products
		}
	}

	public static function purge_all_rates(): void {
		delete_transient( 'fps_rates_cache' );
		wp_cache_delete( 'fps_rates', 'fps' );
	}
}
