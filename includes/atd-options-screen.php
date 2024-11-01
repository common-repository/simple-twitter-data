<?php
/**
* Options screen
*
* Screen for Twitter Data options
*
* @package	Artiss-Twitter-Data
* @since	2.2
*/

?>
<div class="wrap">
<div class="icon32"><img src="<?php echo plugins_url(); ?>/simple-twitter-data/images/screen_icon.png" alt="" title="" height="32px" width="32px"/><br /></div>

<h2>Artiss Twitter Data</h2>

<?php

// If options have been updated on screen, update the database

if ( ( !empty( $_POST ) ) && ( check_admin_referer( 'twitter-data-options', 'twitter_data_options_nonce' ) ) ) {

	$options[ 'cache' ] = $_POST[ 'twitter_data_cache' ];
	$options[ 'user' ] = $_POST[ 'twitter_data_user' ];
	if ( substr( $options[ 'user' ], 0, 1 ) == '@' ) { $options[ 'user' ] = substr( $options[ 'user' ], 1 ); }
	$options[ 'donated' ] = $_POST[ 'twitter_data_donated' ];

	// Update the options

	update_option( 'atd_options', $options );

	echo '<div class="updated fade"><p><strong>' . __( 'Settings Saved.', 'simple-twitter-data' ) . "</strong></p></div>\n";
}

// Get options

$options = atd_get_option_values();

// Display ads

if ( $options[ 'donated'] != 1 ) { artiss_plugin_ads( 'simple-twitter-data' ); }

// Show top information

if ( !atd_contextual_help_type() ) {
	echo atd_help_text();
} else {
	echo '<p>' . __( 'These are the default settings for Artiss Twitter Data.', 'simple-twitter-data' ) . '</p>';
}
?>

<form method="post" action="<?php echo get_bloginfo( 'wpurl' ).'/wp-admin/options-general.php?page=twitter-data-options' ?>">

<table class="form-table">

<tr>
<th scope="row"><?php _e( 'Remove Adverts', 'simple-twitter-data' ); ?></th>
<td><input type="checkbox" name="twitter_data_donated" value="1"<?php if ( $options[ 'donated' ] == "1" ) { echo ' checked="checked"'; } ?>/>&nbsp;<span class="description"><?php _e( "If you've <a href=\"http://www.artiss.co.uk/donate\">donated</a>, tick here to remove the adverts above", 'simple-twitter-data' ); ?></span></td>
</tr>

<tr>
<th scope="row"><?php _e( 'Default cache', 'simple-twitter-data' ); ?></th>
<td><input type="text" size="3" maxlength="3" name="twitter_data_cache" value="<?php echo $options [ 'cache' ]; ?>"/>&nbsp;<span class="description"><?php _e( 'Time in hours. Set to Off to deactivate caching', 'simple-twitter-data' ); ?></span></td>
</tr>

<tr>
<th scope="row"><?php _e( 'Twitter user', 'simple-twitter-data' ); ?></th>
<td><input type="text" size="20" maxlength="20" name="twitter_data_user" value="<?php echo $options[ 'user' ]; ?>"/>&nbsp;<span class="description"><?php _e( 'Default twitter user name', 'simple-twitter-data' ); ?></span></td>
</tr>

</table>

<?php wp_nonce_field( 'twitter-data-options', 'twitter_data_options_nonce', true, true ); ?>

<p class="submit"><input type="submit" name="Submit" class="button-primary" value="<?php _e( 'Save Settings', 'simple-twitter-data' ); ?>"/></p>

</form>

<?php if ( !atd_contextual_help_type() ) { echo atd_support_text(); } ?>

</div>