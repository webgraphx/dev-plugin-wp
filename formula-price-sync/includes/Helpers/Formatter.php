<?php
/**
 * Number and price formatting helpers.
 *
 * @package FPS\Helpers
 */

namespace FPS\Helpers;

class Formatter {

	public static function price( float $amount ): string {
		return number_format( $amount, 0, '.', ',' ) . ' تومان';
	}

	public static function number( float $n, int $decimals = 0 ): string {
		return number_format( $n, $decimals, '.', ',' );
	}
}
