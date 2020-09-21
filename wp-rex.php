<?php

/**
 * README:
 * 1. Please upload this file in the root directory of your wordpress installation
 * 2. Navigate to "yourwordpressdomain.tld/wp-rex.php"
 */

/**
 * function checksum()
 * 
 * checks all file checksums of the wordpress installation with wordpress-core checksums
 * this does not (or in limited extend) affect themes and / or plugins
 * 
 */

function checksum () {

	// define ABSPATH for wordpress directory
	define('ABSPATH', './');

	// GO!
	echo nl2br("Starting checksum comparison:\n");
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
					echo nl2br("WARNING! Checksum for " .$file_path ." does not match!\n");
				}
			}
		}
	}
	echo nl2br("\n\n\n");
}


/**
 * function detector()
 * 
 * searches for files changes in the last 7 days
 * searches for malicious code snippets used in most of the wordpress malware
 * 
 */

function detector() {
	echo nl2br("Starting possible corrupted file detection:\n");
	$regex = '"(((\%[[:alnum:]]{2,5}\%[[:alnum:]]{2,5}){5,})|(\/\*([[:alnum:]]){1,5}\*\/)|(((\\\\\[[:digit:]]{3}).?){3,}))"';
	$cmd1 = 'find . -name "*.php*" | grep -v "wp-rex*" | xargs grep -iE '.$regex;
	$output = htmlentities(shell_exec($cmd1), ENT_QUOTES | ENT_IGNORE);
	if (is_string($output)) {
		foreach (explode("\n", $output) as $file) {
			echo nl2br($file."\n");
		}
	}
	echo nl2br("\n\n\n");
}


/**
 * function checkpermissions() 
 * 
 * COMING SOON
 * 
 */


/**
 * main
 */

checksum();
detector();

?>