<?php
/**
 * Uninstall Formula Price Sync.
 *
 * @package FormulaPriceSync
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// Optional: clean up options and custom tables if desired.
// By default we leave data for safety; enable only if the user opts in.

$cleanup = get_option( 'fps_cleanup_on_uninstall', false );
if ( ! $cleanup ) {
	return;
}

global $wpdb;

// Delete options.
$options = array(
	'fps_settings',
	'fps_license',
	'fps_schema_version',
	'fps_cleanup_on_uninstall',
);
foreach ( $options as $opt ) {
	delete_option( $opt );
}

// Drop custom tables if they exist.
$tables = array(
	$wpdb->prefix . 'fps_rate_snapshots',
	$wpdb->prefix . 'fps_audit_log',
);
foreach ( $tables as $table ) {
	$wpdb->query( "DROP TABLE IF EXISTS {$table}" ); // phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
}
