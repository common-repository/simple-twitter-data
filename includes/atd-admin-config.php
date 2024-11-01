<?php
/**
* Admin Menu Functions
*
* Various administration config changes
*
* @package	Artiss-Twitter-Data
*/

/**
* Add meta to plugin details
*
* Add options to plugin meta line
*
* @since	2.0
*
* @param	string  $links	Current links
* @param	string  $file	File in use
* @return   string			Links, now with settings added
*/

function atd_set_plugin_meta( $links, $file ) {

	if ( strpos( $file, 'simple-twitter-data.php' ) !== false ) {
		$links = array_merge( $links, array( '<a href="http://www.artiss.co.uk/forum">' . __( 'Support', 'simple-twitter-data' ) . '</a>' ) );
		$links = array_merge( $links, array( '<a href="http://www.artiss.co.uk/donate">' . __( 'Donate', 'simple-twitter-data' ) . '</a>' ) );
	}

	return $links;
}
add_filter( 'plugin_row_meta', 'atd_set_plugin_meta', 10, 2 );

/**
* Add Settings link to plugin list
*
* Add a Settings link to the options listed against this plugin
*
* @since	2.2
*
* @param	string  $links	Current links
* @param	string  $file	File in use
* @return   string			Links, now with settings added
*/

function atd_add_settings_link( $links, $file ) {

	static $this_plugin;

	if ( !$this_plugin ) { $this_plugin = plugin_basename( __FILE__ ); }

	if ( strpos( $file, 'twitter-data.php' ) !== false ) {
		$settings_link = '<a href="options-general.php?page=twitter-data-options">' . __( 'Settings', 'simple-twitter-data' ) . '</a>';
		array_unshift( $links, $settings_link );
	}

	return $links;
}
add_filter( 'plugin_action_links', 'atd_add_settings_link', 10, 2 );

/**
* Add Menu Option
*
* Add a new menu option to the adminstration screen.
*
* @since	2.2
*/

function atd_add_menu_option() {

	// Depending on WordPress version and available functions decide which (if any) contextual help system to use

	$contextual_help = atd_contextual_help_type();

	// Add main admin option

	$atd_options_hook = add_options_page( 'Artiss Twitter Data Options', 'Twitter Data', 'delete_plugins', 'twitter-data-options', 'twitter_data_options' );

	// Add contextual help

	if ( $contextual_help == 'new' ) { add_action( 'load-' . $atd_options_hook, 'atd_add_options_help' ); }

	if ( $contextual_help == 'old' ) { add_contextual_help( $atd_options_hook, atd_options_help() ); }

}
add_action( 'admin_menu', 'atd_add_menu_option' );

/**
* Add Options Screen
*
* Define the option screen that the admin menu will link to
*
* @since	2.2
*/

function twitter_data_options() {

	include_once( WP_PLUGIN_DIR . '/simple-twitter-data/includes/atd-options-screen.php' );

}

/**
* Add Options Help
*
* Add help tab to options screen
*
* @since	2.2
*
* @uses     acr_options_help    Return help text
*/

function atd_add_options_help() {

	$screen = get_current_screen();

	if ( $screen->id != 'settings_page_twitter-data-options' ) { return; }

	$screen -> add_help_tab( array( 'id' => 'atd-options-help-tab', 'title'	=> __( 'Help', 'simple-twitter-data' ), 'content' => atd_help_text() ) );

	$screen -> add_help_tab( array( 'id' => 'atd-options-support-tab', 'title'	=> __( 'Support', 'simple-twitter-data' ), 'content' => atd_support_text() ) );
}

/**
* Help text
*
* Generate single text for contextual help
*
* @since	2.2
*
* @return	string	Help Text
*/

function atd_options_help() {

	return atd_help_text() . atd_support_text();

}

/**
* Help text
*
* Return help text for contextual help
*
* @since	2.2
*
* @return	string	Help Text
*/

function atd_help_text() {

	$text = '<p>' . __( 'This screen allows you to set default options for Artiss Twitter Data.', 'artiss-twitter-data' ) . '</p><p>' . __( 'Simply change the required options and then click the Save Settings button at the bottom of the screen for the new settings to take effect.', 'artiss-twitter-data' ) . '</p>';

	return $text;
}

/**
* Support text
*
* Return support text for contextual help
*
* @since	2.2
*
* @return	string	Support Text
*/

function atd_support_text() {

	$text = '<p><strong>' . __( 'For further help:', 'artiss-twitter-data' ) . '</strong></p><p><a href="http://www.artiss.co.uk/twitter-data">' . __( 'Artiss Twitter Data Plugin Documentation', 'artiss-twitter-data' ) . '</a></p>';
	$text .= '<p><a href="http://www.artiss.co.uk/forum/specific-plugins-group2/artiss-twitter-data-forum12">' . __( 'Artiss Twitter Data Support Forum', 'artiss-twitter-data' ) . '</a></p>';
	$text .= '<h4>' . __( 'This plugin, and all support, is supplied for free, but <a title="Donate" href="http://artiss.co.uk/donate" target="_blank">donations</a> are always welcome.', 'artiss-twitter-data' ) . '</h4>';

	return $text;
}

/**
* Get contextual help type
*
* Return whether this WP installation requires the new or old contextual help type, or none at all
*
* @since	2.2
*
* @return   string			Contextual help type - 'new', 'old' or false
*/

function atd_contextual_help_type() {

	global $wp_version;

	$type = false;

	if ( ( float ) $wp_version >= 3.3 ) {
		$type = 'new';
	} else {
		if ( function_exists( 'add_contextual_help' ) ) {
			$type = 'old';
		}
	}

	return $type;
}
?>