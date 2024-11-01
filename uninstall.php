<?php
/**
* Uninstaller
*
* Uninstall the plugin by removing any options from the database
*
* @package	Artiss-Twitter-Data
* @since	2.2
*/

// If the uninstall was not called by WordPress, exit

if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

// Remove options

delete_option( 'atd_options' );
?>