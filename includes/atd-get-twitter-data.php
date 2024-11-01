<?php
/**
* Return Twitter Data
*
* Functions to return Twitter data to user
*
* @package	Artiss-Twitter-Data
*/

/**
* Twitter Shortcode
*
* Shortcode to return a single piece of Twitter profile data
*
* @since		1.0
*
* @uses 	get_twitter_profile		Return profile data
*
* @param	string  $paras          Parameters
* @return	string					User data
*/

function atd_twitter_sc( $paras ) {

	extract( shortcode_atts( array( 'user' => '', 'data' => '', 'cache' => '' ), $paras ) );

	return get_twitter_profile( 'user=' . $user . '&data=' . $data . '&cache=' . $cache );
}

add_shortcode( 'twitter', 'atd_twitter_sc' );
add_shortcode( 'twitter-data', 'atd_twitter_sc' );

/**
* Return Twitter Data
*
* Get user data from Twitter and return the requested data
*
* @since	1.0
*
* @uses 	atd_get_parameter       Extract parameter
* @uses     atd_report_error        Show an error message
* @uses     atd_get_data_parameters Extract data parameters
* @uses     atd_extract_xml         Extract data from XML
* @uses     atd_relative_time       Return the relative time
*
* @param	string  $paras          Parameters
* @return	string					User data (array or single string)
*/

function get_twitter_profile( $paras ) {

	$error = false;
	$options = atd_get_option_values();

	// Extract the parameters

	$username = atd_get_parameter( $paras, 'user' );
	if ( $username == '' ) {
		if ( $options[ 'user' ] != '' ) {
			$username = $options[ 'user' ];
		} else {
			return atd_report_error( __( 'No username was specified', 'simple-twitter-data' ), 'Artiss Twitter Data', false );
		}
	}

	$data = atd_get_parameter( $paras, 'data' );
	if ( $data == '' ) { return atd_report_error( __( 'Data request not specified', 'simple-twitter-data' ), 'Artiss Twitter Data', false ); }

	$data_requests = atd_get_data_parameters( $data );

	$nofollow = strtolower( atd_get_parameter( $paras, 'nofollow' ) );
	if ( $nofollow == 'yes') { $nofollow = ' rel="nofollow"'; } else { $nofollow = ''; }

	$target = strtolower( atd_get_parameter( $paras, 'target' ) );
	if ( $target == '' ) { $target = '_blank'; }

	// Calculate cache time

	$cache_time = strtolower( atd_get_parameter( $paras, 'cache' ) );

	if ( $cache_time == '' ) { $cache_time = $options[ 'cache' ]; }
	if ( !is_numeric( $cache_time ) ) { $cache_time = 0; } else { $cache_time = $cache_time * 3600; }
	if ( $cache_time < 10 ) { $cache_time = 10; }

	// Try and get the output from cache

	$cache_key = 'atd_output_' . md5( $username . $data . $cache_time . $nofollow . $target );
	$cache_data = get_transient( $cache_key );

	if ( !$cache_data ) {

		// Get the Twitter Data

		$twitter = get_data_from_twitter( $username, $cache_time );
		if ( $twitter[ 'error' ] != '' ) { return $twitter[ 'error' ]; }

		// Now process the data (whether from cache or direct from Twitter)

		$array = $twitter[ 'data' ];

		$loop = 1;
		while ( $loop <= $data_requests[ 0 ] ) {
			$data = $data_requests[ $loop ];
			$tag = '';

			// Convert the requested data to the XML field name

			if ( $data == 'image' ) { $tag = 'profile_image_url'; }
			if ( $data == 'image73' ) { $tag = 'profile_image_url'; }
			if ( ( $data == 'followers' ) or ( $data == 'followers-sep' ) ) { $tag = 'followers_count'; }
			if ( ( $data == 'following' ) or ( $data == 'following-sep' ) ) { $tag = 'friends_count'; }
			if ( $data == 'status' ) { $tag = 'text'; }
			if ( $data == 'created' ) { $tag = 'created_at'; }
			if ( $data == 'relative' ) { $tag = 'created_at'; }
			if ( ( $data == 'name' ) or ( $data == 'location' ) or ( $data == 'description' ) or ( $data == 'id' ) or ( $data == 'source' ) or ( $data == 'url' ) ) { $tag = $data; }

			// Show an error if an invalid tag was specified

			if ( $tag == '' ) {

				return atd_report_error( __( 'Invalid data item', 'simple-twitter-data' ) . ' - ' . $data, 'Artiss Twitter Data', false );

			} else {

				// Now extract the requested Twitter data from the XML

				if ( ( $tag == 'created_at' ) or ( $tag == 'id' ) ) {
					$source_array = atd_extract_xml( $array, 'status' );
					$output_data[ $data ] = atd_extract_xml( $source_array, $tag );
					if ( $data == 'relative' ) { $output_data[ $data ] = atd_relative_time( $output_data[ $data ] ); }
					if ( $data == 'id' ) { $output_data[ $data ] = 'http://twitter.com/' . $username . '/statuses/' . $output_data[ $data ]; }
				} else {
				   $output_data[ $data ] = atd_extract_xml( $array, $tag );
				}

				if ( $tag == 'source' ) { $output_data[ $data ] = html_entity_decode( $output_data[ $data ], ENT_QUOTES ); }
				if ( $tag == 'text' ) { $output_data[ $data ] = ereg_replace( "[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]", "<a href=\"\\0\" target=\"" . $target . "\"" . $nofollow . ">\\0</a>", htmlentities( $output_data[ $data ] ) ); }
				if ( $data == 'image73' ) { $output_data[ $data ] = str_replace( '_normal.', '_bigger.', $output_data[ $data ] ); }
				if ( ( $data == 'followers-sep' ) or ( $data == 'following-sep' ) ) { $output_data[ $data ] = number_format( $output_data[ $data ] ); }

				if ( $output_data[ $data ] == '' ) {
					$output_data[ $data ] = false;
				} else {
					$output_data[ $data ] = atd_decode( $output_data[ $data ] );
				}

				$single_out = $output_data[ $data ];
			}
			$loop++;
		}

		// Seperate out the results depending on whether 1 or more fields were requested

		if ( $data_requests[ 0 ] == 1 ) {
			$return_data = $single_out;
		} else {
			$return_data = $output_data;
		}

		// Save the output in cache

		set_transient( $cache_key, $return_data, $cache_time );

	} else {

		$return_data = $cache_data;
	}

	return $return_data;
}

/**
* Get data from Twitter
*
* Get XML data from Twitter, or from cache
*
* @since	2.2
*
* @uses     atd_report_error        Show an error message
* @uses     atd_get_file            Fetch a file
*
* @param	string  $username       Twitter user name
* @param    string  $cache_time     Length of time to cache
* @return	string					Twitter data and errors (array)
*/

function get_data_from_twitter( $username, $cache_time ) {

	$cache_key = 'atd_xml_' . md5( $username . $cache_time );
	$cache_data = get_transient( $cache_key );

	$return[ 'error' ] = '';
	$return[ 'data' ] = '';

	// If no cache available, get it from Twitter

	if ( !$cache_data ) {

		$xmlfile = 'http://api.twitter.com/1/users/show.xml?screen_name=' . $username;

		$file = atd_get_file( $xmlfile );

		// Check for errors

		if ( $file[ 'response' ] != 200 ) {
			if ( $file[ 'response' ] == 404 ) {
				$return[ 'error' ] = atd_report_error( __( 'Twitter user not found', 'simple-twitter-data' ), 'Artiss Twitter Data', false );
			} else {
				if ( ( $file[ 'response' ] == 400 ) or ( $file[ 'response' ] == 420 ) ) {
					$return[ 'error' ] = atd_report_error( __( 'Rate limit exceeded', 'simple-twitter-data' ) . ' (RC:' . $file[ 'response' ] . ')', 'Artiss Twitter Data', false );
				} else {
					if ( $file[ 'response' ] >= 500 ) {
						$return[ 'error' ] = atd_report_error( __( 'Twitter is currently down', 'simple-twitter-data' ) . ', RC:' . $file[ 'response' ], 'Artiss Twitter Data', false );
					} else {
						$return[ 'error' ] = atd_report_error( __( 'Error fetching Twitter data', 'simple-twitter-data' ) . ', RC:' . $file[ 'response' ], 'Artiss Twitter Data', false );
					}
				}
			}
		} else {

			$return[ 'data' ] = $file[ 'file' ];

			// If no errors, update the cache

			set_transient( $cache_key, $return[ 'data' ], $cache_time );
		}
	} else {

		$return[ 'data' ] = $cache_data;

	}

	return $return;
}

/**
* Return URL references
*
* Use TweetMeMe to return the number of times that URL has been referenced
*
* @since	1.1
*
* @uses 	atd_get_file            Fetch a file
* @uses     atd_extract_xml         Extract data from XML
*
* @param    string  $url            URL to check for
* @param	string  $paras          Parameters
* @return	string					Number of times URL has been referenced
*/

function get_twitter_count( $url, $paras = '' ) {

	$cache_time = strtolower( atd_get_parameter( $paras, 'cache' ) );
	if ( $cache_time == '' ) {
		$options = atd_get_option_values();
		$cache = $options[ 'cache' ];
	}

	$xmlfile = 'http://api.tweetmeme.com/url_info?url=' . $url;

	if ( $cache_time == 'no' ) { $cache_time = 10; } else { $cache_time = $cache_time * 3600; }

	$cache_key = 'atd_count_' . md5( $xmlfile . $paras );
	$count = get_transient( $cache_key );

	if ( !$count ) {
		$array = atd_get_file( $xmlfile );
		$count = atd_extract_xml( $array, 'url_count' );
		if ( $cache_time != 'no' ) { set_transient( $cache_key, $count, $cache_time ); }
	}

	return $count;
}
?>