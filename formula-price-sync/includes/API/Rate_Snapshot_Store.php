<?php
/**
 * Persist last successful rate snapshots.
 *
 * @package FPS\API
 */

namespace FPS\API;

class Rate_Snapshot_Store {

	private const OPTION_KEY = 'fps_rate_snapshots';

	/**
	 * @param array<string, float> $rates
	 */
	public function save_snapshot( string $provider_id, array $rates ): void {
		$all = get_option( self::OPTION_KEY, array() );
		$all[ $provider_id ] = array(
			'ts'    => time(),
			'rates' => $rates,
		);
		update_option( self::OPTION_KEY, $all, false );
	}

	/**
	 * @return array<string, float>
	 */
	public function get_latest(): array {
		$all = get_option( self::OPTION_KEY, array() );
		$merged = array();
		foreach ( $all as $entry ) {
			if ( isset( $entry['rates'] ) && is_array( $entry['rates'] ) ) {
				$merged = array_merge( $merged, $entry['rates'] );
			}
		}
		return $merged;
	}
}
