<?php
/**
 * Atomic option-based lock (CAS-style) for concurrent safety.
 *
 * @package FPS\Core
 */

namespace FPS\Core;

class Atomic_Option_Lock {

	private string $key;
	private int $ttl;

	public function __construct( string $key, int $ttl = 30 ) {
		$this->key = 'fps_lock_' . $key;
		$this->ttl = max( 5, $ttl );
	}

	/**
	 * Try to acquire the lock.
	 */
	public function acquire(): bool {
		$now = time();
		$current = get_option( $this->key, null );
		if ( is_array( $current ) && isset( $current['expires'] ) && $current['expires'] > $now ) {
			return false;
		}
		$value = array( 'owner' => wp_generate_uuid4(), 'expires' => $now + $this->ttl );
		// Simple CAS: only write if still free or expired.
		$existing = get_option( $this->key, null );
		if ( is_array( $existing ) && isset( $existing['expires'] ) && $existing['expires'] > $now ) {
			return false;
		}
		update_option( $this->key, $value, false );
		return true;
	}

	public function release(): void {
		delete_option( $this->key );
	}
}
