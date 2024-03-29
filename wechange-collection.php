<?php

/*
Plugin Name:  WECHANGE Collection
Description:  A collection of helpers eg. shortcodes to support connection to WECHANGE
Version:      1.1.2
Author:       Sebastian Gärtner for WECHANGE, Markus Kosmal from WECHANGE
Text Domain:  wechange-collection
*/

namespace WechangeCollection;

define( 'WECHANGE_COLLECTION_DIR', plugin_dir_path( __FILE__ ) );

require_once WECHANGE_COLLECTION_DIR . 'vendor/parsedown/Parsedown.php';
require_once WECHANGE_COLLECTION_DIR . 'class-template-loader.php';

require_once WECHANGE_COLLECTION_DIR . 'utilities.php';
require_once WECHANGE_COLLECTION_DIR . 'shortcode-statistics.php';
require_once WECHANGE_COLLECTION_DIR . 'shortcode-projects.php';
require_once WECHANGE_COLLECTION_DIR . 'shortcode-notes.php';
require_once WECHANGE_COLLECTION_DIR . 'shortcode-events.php';
require_once WECHANGE_COLLECTION_DIR . 'shortcode-conferences.php';
require_once WECHANGE_COLLECTION_DIR . 'login-status.php';
