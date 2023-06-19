WECHANGE COLLECTION
===================

This plugin combines some nice utilities to integrate WECHANGE with your WordPress site.

Currently there is:
- a shortcode for fetch statistics
- a shortcode to show projects
- a shortcode to show notes
- a shortcode to show events
- a utility to redirect logged in users directly to the WECHANGE platform

SETUP
-----

There is a Constant needed in the wp-config file called WECHANGE_BASE_URL
define it like this
`define('WECHANGE_BASE_URL', 'https://yourinstallation.tld' );`

If you intstallation has multiple partners you can define a scope - eg. for separate statistisc
`define('WECHANGE_SCOPE', 'thispartner');`

Default caching time for content that is fetched from the API is 2 hours.
There are filter to overwrite this.

The utility to redirect logged in users to the platform is disabled by default. 
Activate it like this in your theme:
`add_theme_support( 'wechange-collection-login-status' );`

All template files can be overwritten - see the template files for more information.

The plugin can be translated. See the language folder.

It might be handy to disable caching for wp_debug:
```
add_filter( 'wechange_collection_cache_time', 'wechange_collection_disable_cache_for_debug' );
function wechange_collection_disable_cache_for_debug( $cache_time ) {
	if ( true === WP_DEBUG ) { 
		return 1; // cache time in seconds - 0 means: never change
	}
	return $cache_time;
}
```
Remember to flush transients after doing that. 