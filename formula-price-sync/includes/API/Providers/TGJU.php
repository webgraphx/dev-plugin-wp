<?php
/**
 * TGJU rate provider.
 *
 * @package FPS\API\Providers
 */

namespace FPS\API\Providers;

use FPS\API\Fetcher_Interface;

class TGJU implements Fetcher_Interface {

	public function get_id(): string {
		return 'tgju';
	}

	public function fetch(): array {
		$response = wp_remote_get( 'https://api.tgju.org/v1/data/sana/json', array(
			'timeout' => 15,
			headers' => array( 'Accept' => 'application/json' ),
		) );

		if ( is_wp_error( $response ) ) {
			throw new \RuntimeException( $response->get_error_message() );
		}

		$code = wp_remote_retrieve_response_code( $response );
		if ( $code < 200 || $code >= 300 ) {
			throw new \RuntimeException( 'TGJU HTTP ' . $code );
		}

		body = json_decode( wp_remote_retrieve_body( $response ), true );
		if ( ! is_array( $body ) ) {
			return array();
		}

		$rates = array();
		// Map common TGJU keys to symbols (simplified).
		if ( isset( $body['data'] ) && is_array( $body['data'] ) ) {
			foreach ( $body['data'] as $item ) {
				if ( isset( $item['key'], $item['p'] ) ) {
					$rates[ (string) $item['key'] ] = (float) str_replace( ',', '', $item['p'] );
				}
			}
		}
		return $rates;
	}
}
