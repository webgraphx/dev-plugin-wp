<?php
/**
 * Simple audit / debug logger.
 *
 * @package FPS\Core
 */

namespace FPS\Core;

class Logger {

	public static function log( string $message, string $level = 'info', array $context = array() ): void {
		$entry = array(
			'ts'      => time(),
			'level'   => $level,
			'message' => $message,
			'context' => $context,
		);
		$logs = get_option( 'fps_audit_log', array() );
		if ( ! is_array( $logs ) ) {
			$logs = array();
		}
		array_unshift( $logs, $entry );
		$logs = array_slice( $logs, 0, 500 ); // keep last 500
		update_option( 'fps_audit_log', $logs, false );
	}

	public static function info( string $message, array $context = array() ): void {
		self::log( $message, 'info', $context );
	}

	public static function error( string $message, array $context = array() ): void {
		self::log( $message, 'error', $context );
	}
}
