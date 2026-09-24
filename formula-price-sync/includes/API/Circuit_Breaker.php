<?php
/**
 * Simple circuit breaker for rate providers.
 *
 * @package FPS\API
 */

namespace FPS\API;

class Circuit_Breaker {

	private const OPTION_KEY = 'fps_circuit_breaker';
	private const FAILURE_THRESHOLD = 5;
	private const COOLDOWN_SECONDS = 300;

	/**
	 * Whether the provider is currently allowed to be called.
	 */
	public function is_available( string $provider_id ): bool {
		$state = $this->get_state( $provider_id );
		if ( empty( $state['open_until'] ) ) {
			return true;
		}
		return time() >= (int) $state['open_until'];
	}

	public function record_success( string $provider_id ): void {
		$all = get_option( self::OPTION_KEY, array() );
		$all[ $provider_id ] = array(
			'failures'   => 0,
			'open_until' => 0,
		);
		update_option( self::OPTION_KEY, $all, false );
	}

	public function record_failure( string $provider_id ): void {
		$all = get_option( self::OPTION_KEY, array() );
		$state = isset( $all[ $provider_id ] ) && is_array( $all[ $provider_id ] )
			? $all[ $provider_id ]
			: array( 'failures' => 0, 'open_until' => 0 );
		$state['failures'] = (int) $state['failures'] + 1;
		if ( $state['failures'] >= self::FAILURE_THRESHOLD ) {
			$state['open_until'] = time() + self::COOLDOWN_SECONDS;
			$state['failures']   = 0;
		}
		$all[ $provider_id ] = $state;
		update_option( self::OPTION_KEY, $all, false );
	}

	private function get_state( string $provider_id ): array {
		$all = get_option( self::OPTION_KEY, array() );
		return isset( $all[ $provider_id ] ) && is_array( $all[ $provider_id ] )
			? $all[ $provider_id ]
			: array( 'failures' => 0, 'open_until' => 0 );
	}
}
