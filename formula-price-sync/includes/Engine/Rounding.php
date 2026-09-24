<?php
/**
 * Price rounding helpers according to Iranian guild conventions.
 *
 * @package FPS\Engine
 */

namespace FPS\Engine;

class Rounding {

	public static function round( float $value, string $mode = 'nearest_1000' ): float {
		switch ( $mode ) {
			case 'nearest_100':
				return (float) ( round( $value / 100 ) * 100 );
			case 'nearest_1000':
				return (float) ( round( $value / 1000 ) * 1000 );
			case 'floor_1000':
				return (float) ( floor( $value / 1000 ) * 1000 );
			case 'ceil_1000':
				return (float) ( ceil( $value / 1000 ) * 1000 );
			default:
				return round( $value, 0 );
		}
	}
}
