<?php
/**
* Artiss Plugin Ads (1.3)
*
* Generate an advert - intended for use within Artiss plugin administration screens/
* All output is responsive and is image based.
* No data is sent back to an external website (unless links are clicked on).
*
*/

/**
* Generate Ad Code
*
* Combine 2 ads and add additional information
*
* @param    string                  trans           Translation name
* @param    string                  width           Width of output
* @uses     artiss_fetch_ad_code                    Get a random advert
*/

function artiss_plugin_ads( $trans, $width = 750 ) {

	$advertisers = 5;

	// Get first advert

	$ad_array = artiss_fetch_ad_code( rand( 1, $advertisers ) );
	$code1 = $ad_array[ 'code' ];

	// Now choose another advertiser

	$next_ad = $ad_array[ 'ad' ] + 1;
	if ( $next_ad > $advertisers ) { $next_ad = 1; }

	// Get a second advert

	$ad_array = artiss_fetch_ad_code( $next_ad );
	$code2 = $ad_array[ 'code' ];

	// Generate the advert code

	$newline = "\n";

	$code = '<p><div style="width: ' . $width . 'px; height: 125px; border: 1px solid #ddd; padding: 10px;">' . $newline;
	$code .= $code1 . $newline . $code2 . $newline;
	$code .= '<span style="font-weight: bold">' . __( 'Donate', $trans ) . '</span>' . $newline;
	$code .= '<br/>' . __( 'If you like this plugin and appreciate the effort being put into it, <a href="http://www.artiss.co.uk/donate">please consider donating</a>.', $trans ) . '<br/>' . $newline;
	$code .= '<br/><span style="font-weight: bold">' . __( 'Follow Me', $trans ) . '</span>' . $newline;
	$code .= '<br/>' . __( 'Please stay in touch with the latest news via one of the following social streams...', $trans ) . '<br/>' . $newline;
	$code .= '<div align="center" style="padding-top: 10px;">' . $newline;
	$code .= '<a href="http://www.twitter.com/artiss_tech"><img src="https://dl.dropbox.com/u/61522/Artiss.co.uk/Plugins/ads/Twitter.png" alt="' . __( 'Follow Artiss.co.uk on Twitter', $trans ) . '" title="' . __( 'Follow Artiss.co.uk on Twitter', $trans ) . '" style="margin-right: 20px;"></a>' . $newline;
	$code .= '<a href="http://www.facebook.com/artiss.co.uk"><img src="https://dl.dropbox.com/u/61522/Artiss.co.uk/Plugins/ads/Facebook.png" alt="' . __( 'Follow Artiss.co.uk on Facebook', $trans ) . '" title="' . __( 'Follow Artiss.co.uk on Facebook', $trans ) . '" style="margin-right: 20px;"></a>' . $newline;
	$code .= '<a href="https://plus.google.com/108446415028687420620?rel=author"><img src="https://dl.dropbox.com/u/61522/Artiss.co.uk/Plugins/ads/Google%2B.png" alt="' . __( 'Follow Artiss.co.uk on Google+', $trans ) . '" title="' . __( 'Follow Artiss.co.uk on Google+', $trans ) . '" style="margin-right: 20px;"></a>' . $newline;
	$code .= '<a href="http://www.artiss.co.uk/feed"><img src="https://dl.dropbox.com/u/61522/Artiss.co.uk/Plugins/ads/RSS.png" alt="' . __( 'Follow Artiss.co.uk on RSS feed', $trans ) . '" title="' . __( 'Follow Artiss.co.uk on RSS feed', $trans ) . '"></a>' . $newline;
	$code .= '</div></div></p>' . $newline;

	echo $code;
	return;
}

/**
* Get a random advert
*
* Picks a random advert and generated the code for it
*
* @return   array   Code and advert numbers
*/

function artiss_fetch_ad_code( $ad_number ) {

	$sub_ad = '';

	// iThemes

	if ( $ad_number == 1 ) {

		$sub_ad = rand( 1, 9 );

		if ( $sub_ad == 1 ) { $ad_code = '<a rel="nofollow" href="http://ithemes.com/member/go.php?r=32106&i=b0"><img src="http://ithemes.com/wp-content/uploads/2008/02/ithemes125ad.gif" border=0 alt="WordPress Themes" width=125 height=125></a>'; }

		if ( $sub_ad == 2 ) { $ad_code = '<a href="http://ithemes.com/member/go.php?r=32106&i=b1"><img src="http://ithemes.com/wp-content/uploads/2008/11/ithemes-ad1.jpg" border=0 alt="WordPress Themes" width=125 height=125></a>'; }

		if ( $sub_ad == 3 ) { $ad_code = '<a href="http://ithemes.com/member/go.php?r=32106&i=b2"><img src="http://ithemes.com/wp-content/uploads/2009/02/flexx125x125.jpg" border=0 alt="Flexx WP Blog Theme" width=125 height=125></a>'; }

		if ( $sub_ad == 4 ) { $ad_code = '<a href="http://ithemes.com/member/go.php?r=32106&i=b5"><img src="http://ithemes.com/graphics/allaccessad1.jpg" border=0 alt="All Access Pass - 30+ WP Themes" width=125 height=125></a>'; }

		if ( $sub_ad == 5 ) { $ad_code = '<a href="http://ithemes.com/member/go.php?r=32106&i=b15"><img src="http://ithemes.com/graphics/backupbuddy-125.gif" border=0 alt="Backup WordPress Easily" width=125 height=125></a>'; }

		if ( $sub_ad == 6 ) { $ad_code = '<a href="http://ithemes.com/member/go.php?r=32106&i=b17"><img src="http://ithemes.com/graphics/pluginbuddy_ads/pb-mobile-static.png" border=0 alt="PluginBuddy Mobile" width=125 height=125></a>'; }

		if ( $sub_ad == 7 ) { $ad_code = '<a href="http://ithemes.com/member/go.php?r=32106&i=b23"><img src="http://ithemes.com/graphics/builder-ads/builderforum125.png" border=0 alt="iThemes Builder" width=125 height=125></a>'; }

		if ( $sub_ad == 8 ) { $ad_code = '<a href="http://ithemes.com/member/go.php?r=32106&i=b25"><img src="http://ithemes.com/graphics/pluginbuddy_ads/ebuddy-125.png" border=0 alt="EmailBuddy" width=125 height=125></a>'; }

		if ( $sub_ad == 9 ) { $ad_code = '<a href="http://ithemes.com/member/go.php?r=32106&i=b27"><img src="http://affiliates.ithemes.com/files/2010/11/fxEa.loopbuddy125.png" border=0 alt="LoopBuddy from PluginBuddy.com" width=125 height=125></a>'; }

	}

	// Tribulant

	if ( $ad_number == 2 ) {

		$sub_ad = rand( 1, 7 );

		if ( $sub_ad == 1 ) { $ad_code = '<a href="http://tribulant.com/plugins/view/10/wordpress-shopping-cart-plugin?a_aid=artisscouk&amp;a_bid=67d9e505" target=""><img src="http://tribulant.postaffiliatepro.com/accounts/default1/banners/shopping-cart-small.jpg" alt="wordpress-shopping-cart-plugin" title="wordpress-shopping-cart-plugin" width="125" height="125" /></a>'; }

		if ( $sub_ad == 2 ) { $ad_code = '<a href="http://tribulant.com/plugins/view/1/wordpress-mailing-list-plugin?a_aid=artisscouk&amp;a_bid=48d79f09" target=""><img src="http://tribulant.postaffiliatepro.com/accounts/default1/banners/newsletter-small.jpg" alt="wordpress-newsletters-plugin" title="wordpress-newsletters-plugin" width="125" height="125" /></a>'; }

		if ( $sub_ad == 3 ) { $ad_code = '<a href="http://tribulant.com/products/view/12/wordpress-whois-plugin?a_aid=artisscouk&amp;a_bid=4d629414" target=""><img src="http://tribulant.postaffiliatepro.com/accounts/default1/banners/domain-whois-small.jpg" alt="wordpress-whois-plugin" title="wordpress-whois-plugin" width="125" height="125" /></a>'; }

		if ( $sub_ad == 4 ) { $ad_code = '<a href="http://tribulant.com/products/view/9/wordpress-lightbox-plugin?a_aid=artisscouk&amp;a_bid=9acc8d37" target=""><img src="http://tribulant.postaffiliatepro.com/accounts/default1/banners/lightbox-js-small.jpg" alt="wordpress-lightbox-js-plugin" title="wordpress-lightbox-js-plugin" width="125" height="125" /></a>'; }

		if ( $sub_ad == 5 ) { $ad_code = '<a href="http://tribulant.com/plugins/view/8/wordpress-faqs-plugin?a_aid=artisscouk&amp;a_bid=b9082471" target=""><img src="http://tribulant.postaffiliatepro.com/accounts/default1/banners/questions-small.jpg" alt="wordpress-faqs-plugin" title="wordpress-faqs-plugin" width="125" height="125" /></a>'; }

		if ( $sub_ad == 6 ) { $ad_code = '<a href="http://tribulant.com/plugins/view/7/wordpress-custom-fields-plugin?a_aid=artisscouk&amp;a_bid=38fc0021" target=""><img src="http://tribulant.postaffiliatepro.com/accounts/default1/banners/custom-fields-small.jpg" alt="wordpress-custom-fields-plugin" title="wordpress-custom-fields-plugin" width="125" height="125" /></a>'; }

		if ( $sub_ad == 7 ) { $ad_code = '<a href="http://tribulant.com/plugins/view/2/wordpress-banner-rotator-plugin?a_aid=artisscouk&amp;a_bid=418973f2" target=""><img src="http://tribulant.postaffiliatepro.com/accounts/default1/banners/banner-rotator-small.jpg" alt="wordpress-banners-plugin" title="wordpress-banners-plugin" width="125" height="125" /></a>'; }

	}

	// WP Download Manager

	if ( $ad_number == 3 ) {

		$sub_ad = rand( 1, 3 );

		$ad_code = '<a href="http://www.wpdownloadmanager.com/?affid=dartiss" target="_top"><img src="https://dl.dropbox.com/u/61522/Artiss.co.uk/Plugins/ads/webMkt_banner_125x125_' . $sub_ad . '.jpg" alt="WP Download Manager" title="WP Download Manager" width="125" height="125" /></a>';

	}

	// Solostream

	if ( $ad_number == 4 ) {

		$sub_ad = rand( 1, 2 );

		if ( $sub_ad == 1 ) { $ad_code = '<a href="http://www.solostream.com/amember/go.php?r=7855&i=b0"><img src="http://www.solostream.com/images/solo-banner-125-1.gif" border=0 alt="Premium WordPress Themes" width=125 height=125 /></a>'; }

		if ( $sub_ad == 2 ) { $ad_code = '<a href="http://www.solostream.com/amember/go.php?r=7855&i=b1"><img src="http://www.solostream.com/images/solo-banner-125-2.gif" border=0 alt="Premium WordPress Themes" width=125 height=125 /></a>'; }

	}

	// ManageWP

	if ( $ad_number == 5 ) {

		$sub_ad = rand( 1, 2 );

		if ( $sub_ad == 1 ) { $ad_code = '<a href="https://managewp.com/?utm_source=A&utm_medium=Banner&utm_content=mwp_banner_4_125x125&utm_campaign=A&utm_mrl=52"><img src="https://managewp.com/banners/affiliate/mwp_banner_4_125x125.jpg" /></a>'; }

		if ( $sub_ad == 2 ) { $ad_code = '<a href="https://managewp.com/?utm_source=A&utm_medium=Banner&utm_content=mwp_banner_5_125x125&utm_campaign=A&utm_mrl=52"><img src="https://managewp.com/banners/affiliate/mwp_banner_5_125x125.jpg" /></a>'; }

	}

	// Add NOFOLLOW to the ad

	$ad_code = '<a rel="nofollow"' . substr( $ad_code, 2 );

	// Add STYLE to image

	$pos = strpos( $ad_code, '<img ' );
	$ad_code = substr( $ad_code, 0, $pos + 5 ) . 'style="float: left; padding-right: 10px;" ' . substr( $ad_code, $pos + 5 );

	// Add the details into an array and return it

	$return[ 'code' ] = $ad_code;
	$return[ 'ad' ] = $ad_number;
	$return[ 'sub-ad' ] = $sub_ad;

	return $return;
}
?>