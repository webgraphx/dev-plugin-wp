<?php
/**
 * Nobitex rate provider.
 *
 * @package FPS\API\Providers
 */

namespace FPS\API\Providers;

use FPS\API\Fetcher_Interface;

class Nobitex implements Fetcher_Interface {

	public function get_id(): string {
		return 'nobitex';
	}

	public function fetch(): array {
		$response = wp_remote_get( 'https://api.nobitex.ir/market/stats', array(
			'timeout' => 15,
			headers' => array( 'Accept' => 'application/json' ),
		) );

		if ( is_wp_error( $response ) ) {
			throw new \RuntimeException( $response->get_error_message() );
		}

		$code = wp_remote_retrieve_response_code( $response );
		if ( $code < 200 || $code >= 300 ) {
			throw new \RuntimeException( 'Nobitex HTTP ' . $code );
		}

		body = json_decode( wp_remote_retrieve_body( $response ), true );
		if ( ! is_array( $body ) || empty( $body['stats'] ) ) {
			return array();
		}

		$rates = array();
		foreach ( $body['stats'] as $symbol => $data ) {
			if ( isset( $data['latest'] ) ) {
				$rates[ (string) $symbol ] = (float) $data['latest'];
			}
		}
		return $rates;
	}
}
