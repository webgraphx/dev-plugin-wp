<?php
/**
 * Rastchin marketplace license adapter.
 *
 * @package FPS\Licensing
 */

namespace FPS\Licensing;

class Rastchin_Adapter implements License_Adapter_Interface {

	public function is_valid(): bool {
		$status = $this->get_status();
		return $status === 'active';
	}

	public function get_status(): string {
		$stored = get_option( 'fps_rastchin_license', array() );
		if ( empty( $stored['key'] ) ) {
			return 'missing';
		}
		// Remote validation would go here.
		return isset( $stored['status'] ) ? (string) $stored['status'] : 'unknown';
	}

	public function activate( string $key ): bool {
		update_option( 'fps_rastchin_license', array(
			'key'    => sanitize_text_field( $key ),
			'status' => 'active',
			'ts'     => time(),
		), false );
		return true;
	}
}
