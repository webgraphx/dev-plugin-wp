<?php
/**
 * Cron scheduling and event handlers.
 *
 * @package FPS\Core
 */

namespace FPS\Core;

class Cron_Manager {

	const HOOK = 'fps_fetch_rates_event';

	public static function init(): void {
		add_action( self::HOOK, array( __CLASS__, 'run_fetch' ) );
	}

	public static function schedule(): void {
		if ( ! wp_next_scheduled( self::HOOK ) ) {
			wp_schedule_event( time() + 60, 'hourly', self::HOOK );
		}
	}

	public static function unschedule(): void {
		$timestamp = wp_next_scheduled( self::HOOK );
		if ( $timestamp ) {
			wp_unschedule_event( $timestamp, self::HOOK );
		}
	}

	public static function run_fetch(): void {
		// Trigger rate fetch via API_Manager and optionally queue product updates.
		if ( class_exists( '\\FPS\\API\\API_Manager' ) ) {
			$manager = new \FPS\API\API_Manager();
			$manager->fetch_all();
		}
	}
}
