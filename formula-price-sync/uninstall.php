<?php
/**
 * Uninstall Formula Price Sync.
 *
 * @package FormulaPriceSync
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

global $wpdb;

// Options.
$options = array(
	'fps_settings',
	'fps_license',
	'fps_db_version',
	'fps_circuit_breaker',
	'fps_rate_snapshots',
	'fps_last_sync',
);

foreach ( $options as $opt ) {
	delete_option( $opt );
	delete_site_option( $opt );
}

// Transients.
$wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_fps_%' OR option_name LIKE '_transient_timeout_fps_%'" );

// Custom table.
$table = $wpdb->prefix . 'fps_price_logs';
$wpdb->query( "DROP TABLE IF EXISTS {$table}" ); // phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared

// Product meta cleanup (optional — keep if user may reinstall).
// $wpdb->query( "DELETE FROM {$wpdb->postmeta} WHERE meta_key LIKE '_fps_%'" );
