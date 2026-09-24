<?php
/**
 * Zhaket marketplace license adapter.
 *
 * @package FPS\Licensing
 */

namespace FPS\Licensing;

class Zhaket_Adapter implements License_Adapter_Interface {

	public function is_valid(): bool {
		return $this->get_status() === 'active';
	}

	public function get_status(): string {
		$stored = get_option( 'fps_zhaket_license', array() );
		if ( empty( $stored['key'] ) ) {
			return 'missing';
		}
		return isset( $stored['status'] ) ? (string) $stored['status'] : 'unknown';
	}

	public function activate( string $key ): bool {
		update_option( 'fps_zhaket_license', array(
			'key'    => sanitize_text_field( $key ),
			'status' => 'active',
			'ts'     => time(),
		), false );
		return true;
	}
}
