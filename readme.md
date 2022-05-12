WECHANGE COLLECTION
===================

WECHANGE works very well with WordPress CMS. Usually the homepage and all informational pages are powered by WordPress. Therefor we recommend to run WordPress in a subdirectory (e.g. wechange.de/cms). We usually use the Divi theme but of course you're free to choose.

In order to integrate WECHANGE data into WordPress pages, you can

- install our projects shortcode plugin: https://github.com/wechange-eg/wordpress-plugin (see below)
- reuse and adapt our code snippets at https://gist.github.com/simonline/f3ded7504701ce0594992184b6729246
- make use of our API directly within your Javascript code or custom WordPress plugin: https://wechange.de/swagger/

## Wechange-WordPress-Plugin
This plugin combines some nice utilities to integrate WECHANGE with your WordPress site and introduces a shortcode to display projects (and/or groups) from a WECHANGE platform.

Currently there is:
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

Default caching time for content that is fetched from the API is 2 hours.
There are filter to overwrite this.

The utility to redirect logged in users to the platform is disabled by default. 
Activate it like this in your theme:
```php
add_theme_support( 'wechange-collection-login-status' );
```

All template files can be overwritten - see the template files for more information.

The plugin can be translated. See the language folder.

### Usage

Sample:
```
[wechange_projects parent=1002 tags=2018 limit=5 view='row' order='created']
```

### Parameters

- parent: Shows only projects that belong to a group
- tags: Shows only projects that have a keyword
- limit: Limits the number of displayed projects
- view: Sets the view ('grid' for multiline, 'row' for single-line)
- order: Defines the sorting ('created' for "most recent" projects first)
