<?php
/**
 * Manual rate provider (admin-entered rates).
 *
 * @package FPS\API\Providers
 */

namespace FPS\API\Providers;

use FPS\API\Fetcher_Interface;

class Manual implements Fetcher_Interface {

	public function get_id(): string {
		return 'manual';
	}

	public function fetch(): array {
		$rates = get_option( 'fps_manual_rates', array() );
		if ( ! is_array( $rates ) ) {
			return array();
		}
		$out = array();
		foreach ( $rates as $symbol => $value ) {
			$out[ (string) $symbol ] = (float) $value;
		}
		return $out;
	}
}
