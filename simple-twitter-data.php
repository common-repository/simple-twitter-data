<?php
/*
Plugin Name: Artiss Twitter Data
Plugin URI: http://www.artiss.co.uk/twitter-data
Description: Returns Twitter data
Version: 2.2.1
Author: David Artiss
Author URI: http://www.artiss.co.uk
*/

/**
* Artiss Twitter Data
*
* Output Twitter Data
*
* @package	Artiss-Twitter-Data
* @since	2.0
*/

define( 'artiss_twitter_data_version', '2.2.1' );

/**
* Plugin initialisation
*
* Loads the plugin's translated strings
*
* @since	2.1
*/

function atd_plugin_init() {

	$language_dir = plugin_basename( dirname( __FILE__ ) ) . '/languages/';

	load_plugin_textdomain( 'simple-twitter-data', false, $language_dir );

}

add_action( 'init', 'atd_plugin_init' );

/**
* Code includes
*
* Includes for all the plugin functions
*
* @since	2.0
*/

$functions_dir = WP_PLUGIN_DIR . '/simple-twitter-data/includes/';

include_once( $functions_dir . 'atd-shared-functions.php' );		    	// Get the default options

include_once( $functions_dir . 'atd-set-option-defaults.php' );		    	// Set the default settings

include_once( $functions_dir . 'atd-get-twitter-data.php' );				// Code to return Twitter data

if ( is_admin() ) {

	if ( !function_exists( 'artiss_plugin_ads' ) ) {

		include_once( $functions_dir . 'artiss-plugin-ads.php' );   		// Option screen ads

	}

	include_once( $functions_dir . 'atd-admin-config.php' );				// Administration config

} else {

	include_once( $functions_dir . 'atd-deprecated.php' );				    // Deprecated function

}
?>