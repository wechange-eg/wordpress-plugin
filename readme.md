WECHANGE COLLECTION
===================

WECHANGE works very well with WordPress CMS. Usually the homepage and all informational pages are powered by WordPress. Therefor we recommend to run WordPress in a subdirectory (e.g. wechange.de/cms). We usually use the Divi theme but of course you're free to choose.

In order to integrate WECHANGE data into WordPress pages, you can

- install our projects shortcode plugin: https://github.com/wechange-eg/wordpress-plugin (see below)
- reuse and adapt our code snippets at https://gist.github.com/simonline/f3ded7504701ce0594992184b6729246
- make use of our API directly within your Javascript code or custom WordPress plugin: https://wechange.de/swagger/

## Wechange-WordPress-Plugin
This plugin combines some nice utilities to integrate WECHANGE with your WordPress site and introduces a shortcode to display projects (and/or groups) from a WECHANGE platform.

Currently there are:
- a shortcode for fetch statistics
- a shortcode to show projects / groups
- a shortcode to show notes
- a shortcode to show events
- a utility to redirect logged in users directly to the WECHANGE platform

### SETUP

There is a Constant needed in the wp-config file called WECHANGE_BASE_URL
define it like this
```php
define('WECHANGE_BASE_URL', 'https://yourinstallation.tld' );
```

If you intstallation has multiple partners you can define a scope - eg. for separate statistisc
```php
define('WECHANGE_SCOPE', 'thispartner');
```

All template files can be overwritten - see the template files for more information.

The plugin can be translated. See the language folder.


### What are the shortcodes actually doing?

When you place a shortcode in your side, the shortcode will
- Call the API of your WECHANGE installation (defined via Constant or manually set)
- API response will be cached (per default for 2 hours).
- The response is themed through template files (can be overwritten to your preference)
- The result is echoed at the place you put the shortcode


### Usage

#### Statistics Shortcode

This shortcode will echo one plain number (or an error message) - this number can be styled through the surrounding element who ever you want. 

```php
[wechange-statistics attribute="SomeAttribute"]
```

**Known attributes:**
- number of active users:
```
[wechange-statistics attribute="users_active"]
``` 
- number of projects:
```
[wechange-statistics attribute="projects"]
``` 
- number of notes:
```
[wechange-statistics attribute="notes"]
``` 


If ```WECHANGE_SCOPE``` is set, than the statistics are for this partner only, not for all partners on that installation.

**Available Filters:**  
- cache time
```php
apply_filters( 'wechange_collection_cache_time_statistics', 'addValueInSecondsHere' )
```

#### Notes Shortcode

Usage like
```
[wechange_notes parameters="limit=3&group=534"]
```

There are two possible parameters
- 'url' - is not needed if `WECHANGE_BASE_URL` is set
- 'parameters' - which is attached to the basic API call. In this example we limit the answer to 3 items and just take notes from group 534 - see API documentation for further parameters

**available filter**
```php
apply_filters( 'wechange_collection_cache_time_notes', 'TimeInSecondsHere' ); // caching time in seconds
apply_filters( 'wechange_collection_notes_html_before', '<section class="wechange-events">'); // html before the listing of items
apply_filters( 'wechange_collection_notes_html_after', '</section>'); // html after the listing of items
```

#### Notes Projects

Usage like
```
[wechange_projects parameters="limit=3"]
```

There are two possible parameters
- 'url' - is not needed if `WECHANGE_BASE_URL` is set
- 'parameters' - which is attached to the basic API call. In this example we limit the answer to 3 items - see API documentation for further parameters

**available filter**
```php
apply_filters( 'wechange_collection_cache_time_projects', 'TimeInSecondsHere' ); // caching time in seconds
apply_filters( 'wechange_collection_projects_html_before', '<section class="wechange-events">'); // html before the listing of items
apply_filters( 'wechange_collection_projects_html_after', '</section>'); // html after the listing of items
```

#### Events Shortcode

Usage like
```
[wechange_events parameters="limit=3" upcoming="true"]
```

There are three possible parameters
- 'url' - is not needed if `WECHANGE_BASE_URL` is set
- 'upcoming' - just show events in the future (default: true - only show events in the future)
- 'parameters' - which is attached to the basic API call. In this example we limit the answer to 3 items - see API documentation for further parameters

**available filter**
```php
apply_filters( 'wechange_collection_cache_time_events', 'TimeInSecondsHere' ); // caching time in seconds
apply_filters( 'wechange_collection_events_html_before', '<section class="wechange-events">'); // html before the listing of items
apply_filters( 'wechange_collection_events_html_after', '</section>'); // html after the listing of items
```

#### Plugin wide filters

```php
apply_filters( 'wechange_collection_cache_time', 2 * HOUR_IN_SECONDS ); // standard caching time are 2 hours - while building maybe set to zero
```


#### Redirect users who are logged in in WECHANGE from WordPress to WECHANGE

activate by adding
The utility to redirect logged in users to the platform is disabled by default. 
Activate it by putting this code eg in your themes functions.php:
```php
add_theme_support( 'wechange-collection-login-status' );
```
This will embed a small JS file.
