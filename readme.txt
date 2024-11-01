=== Artiss Twitter Data ===
Contributors: dartiss
Donate link: http://artiss.co.uk/donate
Tags: API, artiss, data, followers, following, image, location, profile, social, Twitter, user
Requires at least: 2.0
Tested up to: 3.4.2
Stable tag: 2.2.1

Artiss Twitter Data (previously Simple Twitter Data) uses the Twitter API to return basic user data.

== Description ==

This plugin uses the Twitter API to get basic user information. You can fetch the information using either a PHP function call within your theme or by using a shortcode in your posts and pages.

Whichever method you use there are a number of data types that you can request. These are as follows...

* name
* location
* description
* image (a 48 pixel version of the users Twitter image)
* image73 (a 73 pixel version of the users Twitter image)
* followers
* followers-sep (the same as followers but with thousand seperators)
* following
* following (the same as following but with thousand seperators)
* status (your last Tweet)
* source (where the last Tweet came from)
* url (the users homepage)
* created (the timestamp of the last Tweet)
* relative (the relative time since the last Tweet - e.g. "2 hours ago")
* id (the URL of the last Tweet)

The plugin is also fully internationalized ready for translations. **If you would like to add a translation to his plugin then please [contact me](http://artiss.co.uk/contact "Contact")**

**For help with this plugin, or simply to comment or get in touch, please read the appropriate section in "Other Notes" for details. This plugin, and all support, is supplied for free, but [donations](http://artiss.co.uk/donate "Donate") are always welcome.**

**Using the Shortcode**

Simply add the following to any post or page to output one piece of Twitter data for a particular user...

`[twitter user="username" data="dataitem"]`

Where `username` is the Twitter username and `dataitem` is the data item that you require (as per the list above).

There is an additional parameter of `cache`. Twitter data is cached locally for a number of hours - use this option to specify the number of hours that a cache should be used for. The default is 0.5. Specify `NO` to switch off caching.

For example, to output the latest Tweet for artiss_tech and to cache it for 1 hour you would put in a post...

`[twitter user="artiss_tech" data="status" cache=1]`

**Using the PHP Function Call**

To grab Twitter data you will need to insert the following code, where appropriate, into your theme…

`<?php get_twitter_profile( 'paras' ); ?>`

Where `paras` is a list of parameters each separated by an ampersand...

**user=** : This is the Twitter username

**data=** : This is the list of Twitter data that you wish to have returned. Each data item must be separated by a comma and should be from the list above.

**cache=** : Twitter data is cached locally for a number of hours - use this option to specify the number of hours that a cache should be used for. The default is 0.5. Specify `NO` to switch off caching.

The following 2 parameters are only relevant to any links contained with a returned Tweet (by default all Tweets will be HTML character encoded and URLs will have links)...

**nofollow=** - If specified as `ON` this will turn on the `NOFOLLOW` attribute for the links. By default, this is switched off.

**target=** - Allows you to override the standard `TARGET` of `_BLANK`.

The Twitter data is returned in an array with the data item being the array element.

So, let's say you want to grab the name and Tweet for artiss_tech...

`<?php $return_data = get_twitter_profile( 'user=artiss_tech&data=name,status&cache=1' ); ?>`

This asks for the name and status of the user 'artiss_tech' and makes it cache the results for 1 hour. `$return_data[ 'name' ]` will now contain the name and `$return_data[ 'status' ]` will contain the status.

The following is an example of how it could be used, with a `function_exists` check so that it doesn't cause problems if the plugin is not active...

`<?php
if ( function_exists( 'get_twitter_profile' ) ) {
    $return_data = get_twitter_profile( 'user=artiss_tech&data=name,status&cache=24' );
}
?>`

**Get URL References**

There is an additional PHP function which will return the number of times a URL has been referenced. This will work with shortened URLs as well, so the count will reflect the resultant URL, not the shortened version. The format is...

`<?php get_twitter_count( 'url', 'paras' ); ?>`

Where `url` is the URL that you wish to return a count for and `paras` is a list of additiona parameters, each seperate by an ampersand. However, at the moment there is only one parameter...

**cache=** : URL reference data is cached locally for a number of hours - use this option to specify the number of hours that a cache should be used for. The default is 0.5. Specify `NO` to switch off caching.

**Options Screen**

Within Administration and under the Options menu, there is a sub-menu option named "Twitter Data". Selecting this allows you to specify a number of default values (namely the cache length and twitter user).

If you don't specify either of these in the shortcode/PHP function then the value from this screen will be used instead.

== Licence ==

This WordPress plugin is licensed under the [GPLv2 (or later)](http://wordpress.org/about/gpl/ "GNU General Public License").

== Support ==

All of my plugins are supported via [my website](http://www.artiss.co.uk "Artiss.co.uk").

Please feel free to visit the site for plugin updates and development news - either visit the site regularly or [follow me on Twitter](http://www.twitter.com/artiss_tech "Artiss.co.uk on Twitter") (@artiss_tech).

For problems, suggestions or enhancements for this plugin, there is [a dedicated page]([[http://www.artiss.co.uk/twitter-data "Artiss Twitter Data"]]) and [a forum](http://www.artiss.co.uk/forum "WordPress Plugins Forum"). The dedicated page will also list any known issues and planned enhancements.

**This plugin, and all support, is supplied for free, but [donations](http://artiss.co.uk/donate "Donate") are always welcome.**

== Installation ==

1. Upload the entire `simple-twitter-data`folder to your wp-content/plugins/ directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. That's it, you're done - you just need to add the function call or short code!

== Frequently Asked Questions ==

= Which version of PHP does this plugin work with? =

It has been tested and been found valid from PHP 4 upwards.

Please note, however, that the minimum for WordPress is now PHP 5.2.4. Even though this plugin supports a lower version, I am not coding specifically to achieve this - therefore this minimum may change in the future.

= Why do I need to request specific Twitter fields? Why can't I just have all of them everytime? =

Each field has to be found in the XML returned from Twitter - the more you request the more time it takes the plugin. Therefore requesting ONLY those that you require ensures maximum plugin efficiency.

= Another plugin I use makes use of the same twitter shortcode =

You can also use the shortcode [twitter-data] - it works just the same as [twitter] with the same parameters.

== Changelog ==

= 2.2.1 =
* Bug: Added cache time to the API cache key
* Bug: Fixed PHP warning in list extraction routine
* Enhancement: Ensured that minimum caching time can't be overridden
* Enhancement: Improved error messages

= 2.2 =
* Maintenance: Updated the Twitter API URL
* Maintenance: Updated shared routines, including file handling
* Enhancement: Moved some functions to allow them to work with Ajax-based sites
* Enhancement: Re-written caching routines to be more efficient
* Enhancement: Minimum cache now in place, to ensure that multiple requests per page will only result in one call to Twitter API
* Enhancement: Added uninstaller routine
* Enhancement: Improved error reporting
* Enhancement: Added options screen to allow default values to be set

= 2.1.1 =
* Enhancement: Added 2nd shortcode

= 2.1 =
* Enhancement: Added internationalisation

= 2.0.1 =
* Maintenance: Removed dashboard widget

= 2.0 =
* Maintenance: Renamed to Artiss Twitter Data
* Maintenance: Improved coding standards throughout
* Maintenance: Updated shared functions
* Enhancement: Now using built in WP caching
* Enhancement: Error reporting improved
* Enhancement: Added cache parameter to shortcode
* Enhancement: New data types for numeric fields so that a thousand seperator can be specified
* Bug: Special character HTML values in fields are now decoded

= 1.2.1 =
* Bug: Fixed file fetching bug

= 1.2 =
* Maintenance: Updated shared functions
* Enhancement: Added image73 as a new data item to request
* Enhancement: Added inline tag function to add Twitter data dynamically to posts and pages

= 1.1 =
* Enhancement: Added get_twitter_count function to return a count of references to a URL

= 1.0 =
* Initial release

== Upgrade Notice ==

= 2.2.1 =
* Upgrade to fix some minor issues

= 2.2 =
* Urgent fix for Twitter API changes

= 2.1.1 =
* Upgrade to add a secondary shortcode, in case the main one is unavailable

= 2.1 =
* Update to add internationalisation

= 2.0.1 =
* Upgrade to remove the dashboard widget

= 2.0 =
* Upgrade to add various enhancements

= 1.2.1 =
* Upgrade to fix critical file fetching bug