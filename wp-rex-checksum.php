<?php
	/**
	 * Use this script to verify md5 checksums of WordPress core files.
	 * This script was originally published by: @HertogJanR (Twitter)
	 * Thank you very much! I just modified his script.
	 * 
	 * Put this file in the your WordPress root folder, leave ABSPATH
	 * defined  as './'.
	 */

	
	// define ABSPATH for wordpress directory
	define('ABSPATH', './');

	// GO!
	if ( defined( 'ABSPATH' ) ) {

		// NECESSARY: include file to get wp-version
		include( ABSPATH . 'wp-includes/version.php' );
		
		// get locales
		$wp_locale = isset( $wp_local_package ) ? $wp_local_package : 'en_US';
		
		// set wp-api-url and get checksums from wordpress api
		$apiurl = 'https://api.wordpress.org/core/checksums/1.0/?version=' . $wp_version . '&locale=' .  $wp_locale;
		$json = json_decode ( file_get_contents ( $apiurl ) );
		$checksums = $json->checksums;

		// iterate over all files to compare checksums
		foreach( $checksums as $file => $checksum ) {
			$file_path = ABSPATH . $file;
			if ( file_exists( $file_path ) ) {
				if ( md5_file ($file_path) !== $checksum ) {
					// do something when a checksum doesn't match
					echo "WARNING! Checksum for " .$file_path ." does not match!\n";
				}
			}
		}
	}
?>