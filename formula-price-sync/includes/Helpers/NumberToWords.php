<?php
/**
 * Convert numbers to Persian words (simplified).
 *
 * @package FPS\Helpers
 */

namespace FPS\Helpers;

class NumberToWords {

	private static $ones = array( '', 'یک', 'دو', 'سه', 'چهار', 'پنج', 'شش', 'هفت', 'هشت', 'نه' );

	public static function convert( int $n ): string {
		if ( $n === 0 ) {
			return 'صفر';
		}
		if ( $n < 10 ) {
			return self::$ones[ $n ];
		}
		// Simplified – extend for full production use.
		return (string) $n;
	}
}
