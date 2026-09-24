<?php
// Composer autoload stub (run composer install for full vendor).
spl_autoload_register( function ( $class ) {
	if ( strpos( $class, 'FPS\\' ) !== 0 ) {
		return;
	}
	$rel = str_replace( '\\', '/', substr( $class, 4 ) ) . '.php';
	$file = dirname( __DIR__ ) . '/includes/' . $rel;
	if ( file_exists( $file ) ) {
		require $file;
	}
} );
