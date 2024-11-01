<?php
/**
* Shared Functions
*
* @package	Artiss-Twitter-Data
*/

/**
* Report an error (1.4)
*
* Function to report an error
*
* @since	1.0
*
* @param	$error			string	Error message
* @param	$plugin_name	string	The name of the plugin
* @param	$echo			string	True or false, depending on whether you wish to return or echo the results
* @return					string	True
*/

function atd_report_error( $error, $plugin_name, $echo = true ) {

	$output = '<p style="color: #f00; font-weight: bold;">' . $plugin_name . ': ' . $error . "</p>\n";

	if ( $echo ) {
		echo $output;
		return true;
	} else {
		return $output;
	}

}

/**
* Extract Parameters (1.1)
*
* Function to extract parameters from an input string
*
* @since	1.0
*
* @param	$input	string	Input string
* @param	$para	string	Parameter to find
* @return			string	Parameter value
*/

function atd_get_parameter( $input, $para, $divider = '=', $seperator = '&' ) {

	$start = strpos( strtolower( $input ), $para . $divider);
	$content = '';
	if ( $start !== false ) {
		$start = $start + strlen( $para ) + 1;
		$end = strpos( strtolower( $input ), $seperator, $start );
		if ( $end !== false ) { $end = $end - 1; } else { $end = strlen( $input ); }
		$content = substr( $input, $start, $end - $start + 1 );
	}
	return $content;
}

/**
* Extract parameters to an array (1.3)
*
* Function to extract parameters from an input string and
* add to an array
*
* @since	1.0
*
* @param	$input	    string	Input string
* @param	$seperator	string	Seperator
* @return			    string	Array of parameters
*/

function atd_get_data_parameters( $input, $seperator = '' ) {

	if ( $seperator == '' ) { $seperator = ','; }
	$comma = strpos( strtolower( $input ), $seperator );

	$item = 0;
	while ( $comma !== false ) {
		$item++;
		$content[ $item ] = substr( $input, 0, $comma );
		$input = substr( $input, $comma + strlen( $seperator ) );
		$comma = strpos( $input, $seperator );
	}

	if ( $input != '' ) {
		$item++;
		$content[ $item ] = substr( $input, 0  );	
	}

	$content[ 0 ] = $item;
	return $content;
}

/**
* Fetch a file (1.6)
*
* Use WordPress API to fetch a file and check results
* RC is 0 to indicate success, -1 a failure
*
* @since	1.0
*
* @param	string	$filein		File name to fetch
* @param	string	$header		Only get headers?
* @return	string				Array containing file contents and response
*/

function atd_get_file( $filein, $header = false ) {

	$rc = 0;
	$error = '';
	if ( $header ) {
		$fileout = wp_remote_head( $filein );
		if ( is_wp_error( $fileout ) ) {
			$error = 'Header: ' . $fileout -> get_error_message();
			$rc = -1;
		}
	} else {
		$fileout = wp_remote_get( $filein );
		if ( is_wp_error( $fileout ) ) {
			$error = 'Body: ' . $fileout -> get_error_message();
			$rc = -1;
		} else {
			if ( isset( $fileout[ 'body' ] ) ) {
				$file_return[ 'file' ] = $fileout[ 'body' ];
			}
		}
	}

	$file_return[ 'error' ] = $error;
	$file_return[ 'rc' ] = $rc;
	if ( !is_wp_error( $fileout ) ) {
		if ( isset( $fileout[ 'response' ][ 'code' ] ) ) {
			$file_return[ 'response' ] = $fileout[ 'response' ][ 'code' ];
		}
	}

	return $file_return;
}

/**
* Extract XML (1.3)
*
* Function to extract from an XML compatible file
*
* @since	1.0
*
* @param	string	$filein	The XML file
* @param	string	$tag	The tag to search for
* @return	string			The tag contents
*/

function atd_extract_xml( $filein, $tag ) {

	$tag_space = strpos( $tag, ' ',1 );

	if ( $tag_space != 0 ) {
		$tag_start = strpos( $filein, '<' . $tag );
		$bracket_find = strpos( $filein, '>', $tag_start );
		$tag_end = strpos( $filein, '</' . substr( $tag, 1, $tag_space - 1 ) . '>', $tag_start );
		$tag_extend = $bracket_find - $tag_end;
	} else {
		$tag_start = strpos( $filein, '<' . $tag . '>' );
		$tag_extend = 0;
		$tag_end = strpos( $filein, '</' . $tag . '>', $tag_start );
	}

	if ( ( $tag_start === false ) or ( $tag_end === false ) ) {
		$field = '';
	} else {
		$field_start = $tag_start + strlen( $tag ) + 2;
		$field_end = $tag_end + $tag_extend - 1;
		$field = substr( $filein, $field_start, $field_end - $field_start + 1 );
	}

	return $field;
}

/**
* Return a relative data
*
* Function to return a relative data from a supplied date
* Based on code from http://www.gyford.com/phil/writing/resources/2006/12/02/twitter.txt
*
* @since	1.0
*
* @param	string	$date	The date
* @return	string			The relative date
*/

function atd_relative_time( $date ) {

	$diff = gmmktime() - strtotime( $date );
	$months = floor( $diff / 2419200 );
	$diff -= $months * 2419200;
	$weeks = floor( $diff / 604800 );
	$diff -= $weeks * 604800;
	$days = floor( $diff / 86400 );
	$diff -= $days * 86400;
	$hours = floor( $diff / 3600 );
	$diff -= $hours * 3600;
	$minutes = floor( $diff / 60 );
	$diff -= $minutes * 60;
	$seconds = $diff;
	$relative_date = '';

	if ( $weeks > 0 ) {
		// Weeks and days
		$relative_date .= ($relative_date?', ':'') . $weeks . ' week' . ($weeks>1?'s':'');
		$relative_date .= $days>0?($relative_date?', ':'') . $days . ' day' . ($days>1?'s':''):'';
	} elseif ( $days > 0 ) {
		// days and hours
		$relative_date .= ($relative_date?', ':'') . $days . ' day' . ($days>1?'s':'');
		$relative_date .= $hours>0?($relative_date?', ':'') . $hours . ' hr' . ($hours>1?'s':''):'';
	} elseif ( $hours > 0 ) {
		// hours and minutes
		$relative_date .= ($relative_date?', ':'') . $hours . ' hr' . ($hours>1?'s':'');
		$relative_date .= $minutes>0?($relative_date?', ':'') . $minutes . ' min'.($minutes>1?'s':''):'';
	} elseif ( $minutes > 0 ) {
		// minutes only
		$relative_date .= ($relative_date?', ':'') . $minutes . ' min' . ($minutes>1?'s':'');
	} else {
		// seconds only
		$relative_date .= ($relative_date?', ':'') . $seconds . ' sec' . ($seconds>1?'s':'');
	}

	return $relative_date . ' ago';
}

/**
* Decode a string v1.1
*
* Decode an HTML encoded string. This is in preference to using
* htmlspecialchars_decode to maintain PHP 4 compatibility.
*
* @since	2.0
*
* @param	string		$encoded	The encoded string
* @return	string					The decoded string
*/

function atd_decode( $encoded ) {

	$find = array( '&amp;', '&quot;', '&#039;', '&lt;', '&gt;' );
	$replace = array( '&', '"', "'", '<', '>' );

	return str_replace( $find, $replace, $encoded );
}
?>