<?php
/**
 * Price calculator – applies formulas to products using current rates.
 *
 * @package FPS\Engine
 */

namespace FPS\Engine;

use FPS\API\API_Manager;
use FPS\Core\Logger;

class Calculator {

	private Formula_Parser $parser;
	private API_Manager $api;

	public function __construct() {
		$this->parser = new Formula_Parser();
		$this->api    = new API_Manager();
	}

	/**
	 * Calculate new price for a product given its formula meta.
	 *
	 * @return Product_Update_Result
	 */
	public function calculate_for_product( int $product_id ): Product_Update_Result {
		$product = wc_get_product( $product_id );
		if ( ! $product ) {
			return new Product_Update_Result( $product_id, false, null, null, 'Product not found' );
		}

		$formula = get_post_meta( $product_id, '_fps_formula', true );
		if ( ! is_string( $formula ) || $formula === '' ) {
			return new Product_Update_Result( $product_id, false, null, null, 'No formula' );
		}

		$rates = $this->api->get_cached_rates();
		if ( empty( $rates ) ) {
			$rates = $this->api->fetch_all();
		}

		try {
			$raw = $this->parser->evaluate( $formula, $rates );
			$rounded = Rounding::round( $raw, 'nearest_1000' );
		} catch ( \Throwable $e ) {
			Logger::error( 'Formula eval failed', array( 'product_id' => $product_id, 'error' => $e->getMessage() ) );
			return new Product_Update_Result( $product_id, false, null, null, $e->getMessage() );
		}

		$old = (float) $product->get_regular_price();
		return new Product_Update_Result( $product_id, true, $old, $rounded, 'OK' );
	}

	/**
	 * Apply calculated price to the product.
	 */
	public function apply( Product_Update_Result $result ): bool {
		if ( ! $result->success || $result->new_price === null ) {
			return false;
		}
		$product = wc_get_product( $result->product_id );
		if ( ! $product ) {
			return false;
		}
		$product->set_regular_price( (string) $result->new_price );
		$product->save();
		\FPS\Core\Cache_Purger::purge_product( $result->product_id );
		Logger::info( 'Price updated', array(
			'product_id' => $result->product_id,
			'old'        => $result->old_price,
			'new'        => $result->new_price,
		) );
		return true;
	}
}
