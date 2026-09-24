<?php
/**
 * Central license guard – fail-closed for marketplace distribution.
 *
 * @package FPS\Licensing
 */

namespace FPS\Licensing;

class License_Guard {

	/** @var License_Adapter_Interface|null */
	private static $adapter = null;

	public static function init(): void {
		// Select adapter based on config / constant.
		if ( defined( 'FPS_ZHAKET_PRODUCT_TOKEN' ) ) {
			self::$adapter = new Zhaket_Adapter();
		} else {
			self::$adapter = new Rastchin_Adapter();
		}
	}

	public static function is_licensed(): bool {
		if ( ! self::$adapter ) {
			self::init();
		}
		return self::$adapter ? self::$adapter->is_valid() : false;
	}

	public static function require_license(): void {
		if ( ! self::is_licensed() ) {
			wp_die( esc_html__( 'Valid license required.', 'formula-price-sync' ), 403 );
		}
	}
}
