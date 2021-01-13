<?php

namespace WechangeCollection;
use \Gamajo_Template_Loader;
/**
 * WECHANGE Collection
 *
 * @package   WechangeCollection
 * @author    Sebastian Gärtner
 * @link      
 * @copyright 20190 Sebastian Gärtner
 * @license   GPL-2.0+
 */

if ( ! class_exists( 'Gamajo_Template_Loader' ) ) {
  require 'vendor/class-gamajo-template-loader.php';
}

/**
 * Template loader for WechangeCollection.
 *
 * Only need to specify class properties here.
 *
 * @package WechangeCollection
 * @author  Sebastian Gärtner
 */
class WechangeCollection_Template_Loader extends Gamajo_Template_Loader {
  /**
   * Prefix for filter names.
   *
   * @since 1.0.0
   *
   * @var string
   */
  protected $filter_prefix = 'wechange';

  /**
   * Directory name where custom templates for this plugin should be found in the theme.
   *
   * @since 1.0.0
   *
   * @var string
   */
  protected $theme_template_directory = 'wechange';

  /**
   * Reference to the root directory path of this plugin.
   *
   * Can either be a defined constant, or a relative reference from where the subclass lives.
   *
   * In this case, `WECHANGE_COLLECTION_DIR` would be defined in the root plugin file as:
   *
   * ~~~
   * define( 'WECHANGE_COLLECTION_DIR', plugin_dir_path( __FILE__ ) );
   * ~~~
   *
   * @since 1.0.0
   *
   * @var string
   */
  protected $plugin_directory = WECHANGE_COLLECTION_DIR;

  /**
   * Directory name where templates are found in this plugin.
   *
   * Can either be a defined constant, or a relative reference from where the subclass lives.
   *
   * e.g. 'templates' or 'includes/templates', etc.
   *
   * @since 1.1.0
   *
   * @var string
   */
  protected $plugin_template_directory = 'templates';
}