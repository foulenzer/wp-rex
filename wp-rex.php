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

	// Define ABSPATH for wordpress directory
	define('ABSPATH', './');

	// Go!
	echo nl2br("Starting checksum comparison:\n");
	if (defined('ABSPATH')) {

		// NECESSARY: include file to get wp-version
		include(ABSPATH.'wp-includes/version.php');
		
		// Get locales
		$wp_locale = isset($wp_local_package) ? $wp_local_package : 'en_US';
		
		// Set wp-api-url and get checksums from wordpress api
		$apiurl = 'https://api.wordpress.org/core/checksums/1.0/?version='.$wp_version.'&locale='.$wp_locale;
		$json = json_decode(file_get_contents($apiurl));
		$checksums = $json->checksums;

		// Iterate over all files to compare checksums
		foreach($checksums as $file => $checksum) {
			$file_path = ABSPATH.$file;
			if (file_exists($file_path)) {
				if (md5_file($file_path) !== $checksum) {
					// Do something when a checksum doesn't match
					echo nl2br("WARNING! Checksum for ".$file_path ." does not match!\n");
				}
			}
		}
	}
	echo nl2br("\n\n\n");
}


/**
 * function lastchanges()
 * 
 * searches for files changes in the last 7 days
 * 
 */

function lastchanges() {
	echo nl2br("Starting scanning for recently changed files:\n");

	// Prepare data
	$cmd1 = 'find . -type f | grep -v "wp-rex*"';

	// Go!
	$output = trim(htmlentities(shell_exec($cmd1), ENT_QUOTES | ENT_IGNORE));
	if (is_string($output)) {
		foreach (explode("\n", $output) as $file) {

			// Check for last change less than 7 days
			$stat = stat($file);
			if ($stat['mtime'] > (time()-(7*24*60*60))) {
				echo nl2br("$file : Last modified on: ".date("F-d-Y H:i:s.", $stat['mtime'])."\n");
			}
			if ($stat['ctime'] > (time()-(7*24*60*60))) {
				echo nl2br("$file : Last file system change on: ".date("F-d-Y H:i:s.", $stat['ctime'])."\n");
			}
		}
	}
	echo nl2br("\n\n\n");
}


/**
 * function snippets()
 * 
 * searches for malicious code snippets used in most of the wordpress malware
 * 
 */

function snippets() {
	echo nl2br("Starting scanning for malicous snippets:\n");

	// Prepare data
	$regex = '"(((\%[[:alnum:]]{2,5}\%[[:alnum:]]{2,5}){5,})|(\/\*([[:alnum:]]){1,5}\*\/)|(((\\\\\[[:digit:]]{3}).?){3,}))|(eval\(base64_decode\()|(\/\*\*\* PHP Encode v1\.0 by zeura\.com \*\*\*\/)"';
	$cmd2 = 'find . -name "*.php*" | grep -v "wp-rex*" | xargs grep -iE '.$regex;

	// Go!
	$output = htmlentities(shell_exec($cmd2), ENT_QUOTES | ENT_IGNORE);
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
lastchanges();
snippets();

?>