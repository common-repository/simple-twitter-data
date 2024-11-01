<?php
/**
* Deprecated Functions
*
* Functions that are now deprecated but retained here for backwards
* compatibility
*
* @package	Artiss-Twitter-Data
*/

/**
* Return Twitter Data
*
* Get user data from Twitter and return the requested data
*
* @since	1.0
*
* @uses 	get_twitter_data   		Return profile data
*
* @param	string  $paras          Parameters
* @return	string					User data
*/

function simple_twitter_data( $paras_in ) {
	return get_twitter_profile( $paras_in );
}
?>