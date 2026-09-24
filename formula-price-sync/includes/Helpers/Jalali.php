<?php
/**
 * Simple Jalali (Persian) date helpers.
 *
 * @package FPS\Helpers
 */

namespace FPS\Helpers;

class Jalali {

	public static function from_gregorian( int $gy, int $gm, int $gd ): array {
		// Simplified conversion (for full accuracy use a proper library).
		$g_d_m = array( 0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334 );
		$gy2 = ( $gm > 2 ) ? ( $gy + 1 ) : $gy;
		days = 355666 + ( 365 * $gy ) + (int) ( ( $gy2 + 3 ) / 4 ) - (int) ( ( $gy2 + 99 ) / 100 ) + (int) ( ( $gy2 + 399 ) / 400 ) + $gd + $g_d_m[ $gm - 1 ];
		$jy = -1595 + ( 33 * (int) ( $days / 12053 ) );
		$days %= 12053;
		$jy += 4 * (int) ( $days / 1461 );
		$days %= 1461;
		if ( $days > 365 ) {
			$jy += (int) ( ( $days - 1 ) / 365 );
			$days = ( $days - 1 ) % 365;
		}
		if ( $days < 186 ) {
			$jm = 1 + (int) ( $days / 31 );
			$jd = 1 + ( $days % 31 );
		} else {
			$jm = 7 + (int) ( ( $days - 186 ) / 30 );
			$jd = 1 + ( ( $days - 186 ) % 30 );
		}
		return array( $jy, $jm, $jd );
	}

	public static function format( int $timestamp = 0 ): string {
		if ( ! $timestamp ) {
			$timestamp = time();
		}
		$y = (int) date( 'Y', $timestamp );
		$m = (int) date( 'n', $timestamp );
		$d = (int) date( 'j', $timestamp );
		list( $jy, $jm, $jd ) = self::from_gregorian( $y, $m, $d );
		return sprintf( '%04d/%02d/%02d', $jy, $jm, $jd );
	}
}
