<?php
/**
 * Navasan rate provider.
 *
 * @package FPS\API\Providers
 */

namespace FPS\API\Providers;

use FPS\API\Fetcher_Interface;

class Navasan implements Fetcher_Interface {

	public function get_id(): string {
		return 'navasan';
	}

	public function fetch(): array {
		// Implementation fetches from Navasan API endpoints.
		// Returns map of symbol => rate.
		$response = wp_remote_get( 'https://api.navasan.tech/latest/', array(
			'timeout' => 15,
			headers' => array( 'Accept' => 'application/json' ),
		) );

		if ( is_wp_error( $response ) ) {
			throw new \RuntimeException( $response->get_error_message() );
		}

		$code = wp_remote_retrieve_response_code( $response );
		if ( $code < 200 || $code >= 300 ) {
			throw new \RuntimeException( 'Navasan HTTP ' . $code );
		}

		body = json_decode( wp_remote_retrieve_body( $response ), true );
		if ( ! is_array( $body ) ) {
			return array();
		}

		$rates = array();
		foreach ( $body as $key => $item ) {
			if ( isset( $item['value'] ) ) {
				$rates[ (string) $key ] = (float) $item['value'];
			}
		}
		return $rates;
	}
}
