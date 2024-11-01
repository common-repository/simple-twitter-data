<?php
/**
* Set Default Options
*
* Set up default option values
*
* @package	Artiss-Twitter-Data
* @since	2.2
*
* @return   string				Options array
*/

function atd_get_option_values() {

	$options = get_option( 'atd_options' );
	$changed = false;

	// Because of upgrading, check each option - if not set, apply default

	if ( !array_key_exists( 'cache', $options ) ) { $options[ 'cache' ] = 0.5; $changed = true; }
	if ( !array_key_exists( 'user', $options ) ) { $options[ 'user' ] = ''; $changed = true; }
	if ( !array_key_exists( 'donated', $options ) ) { $options[ 'donated' ] = ''; $changed = true; }

	// Update the options, if changed, and return the result

	if ( $changed ) { update_option( 'atd_options', $options ); }
	return $options;
}
?>