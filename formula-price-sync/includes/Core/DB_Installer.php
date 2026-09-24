<?php
/**
 * Database schema installer / migrator.
 *
 * @package FPS\Core
 */

namespace FPS\Core;

class DB_Installer {

	const SCHEMA_VERSION = '2.0.1';

	public static function maybe_install(): void {
		$installed = get_option( 'fps_schema_version', '' );
		if ( $installed === self::SCHEMA_VERSION ) {
			return;
		}
		self::install();
	}

	public static function install(): void {
		global $wpdb;
		$charset = $wpdb->get_charset_collate();

		$table_snapshots = $wpdb->prefix . 'fps_rate_snapshots';
		$sql1 = "CREATE TABLE $table_snapshots (
			id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			provider varchar(32) NOT NULL,
			rates longtext NOT NULL,
			created_at datetime NOT NULL,
			PRIMARY KEY  (id),
			KEY provider (provider)
		) $charset;";

		$table_log = $wpdb->prefix . 'fps_audit_log';
		$sql2 = "CREATE TABLE $table_log (
			id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			level varchar(16) NOT NULL,
			message text NOT NULL,
			context longtext,
			created_at datetime NOT NULL,
			PRIMARY KEY  (id)
		) $charset;";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql1 );
		dbDelta( $sql2 );

		update_option( 'fps_schema_version', self::SCHEMA_VERSION );
	}
}
