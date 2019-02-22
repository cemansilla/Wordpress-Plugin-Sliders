<?php
if(!defined('ABSPATH')) exit;

/*
Plugin Name:  DM Sliders
Plugin URI:
Description:  Administración y generación de shortcode para la generación de un slider de contenidos con múltiples funcionalidades.
Version:      1.0
Author:       DMFusión
Author URI:http://www.dmfusion.com
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  dm_sliders
*/

/**
 * Incluyo funciones
 */
require_once(plugin_dir_path(__FILE__) . "includes/functions.php");

/**
 * Agrego post type de sliders
 */
require_once(plugin_dir_path(__FILE__) . "includes/posttypes.php");

/**
 * Regenera las URLs al activar el plugin
 */
register_activation_hook(__FILE__, 'dm_sliders_rewrite_flush');

/**
 * Agrego roles
 */
require_once(plugin_dir_path(__FILE__) . "includes/roles.php");
register_activation_hook(__FILE__, 'dm_sliders_create_role');
register_deactivation_hook(__FILE__, 'dm_sliders_remove_role');

/**
 * Agrego capabilities
 */
register_activation_hook( __FILE__, 'dm_sliders_add_capabilities' );
register_deactivation_hook( __FILE__, 'dm_sliders_remove_capabilities' );

/**
 * Agrego metaboxes al CPT de dm_sliders
 */
require_once(plugin_dir_path(__FILE__) . "includes/metaboxes.php");

/**
 * Agrego shortcode
 */
require_once(plugin_dir_path(__FILE__) . "includes/shortcode.php");

/**
 * Agrego css y js
 */
require_once(plugin_dir_path(__FILE__) . "includes/scripts.php");

/**
 * Agrego AJAX
 */
require_once(plugin_dir_path(__FILE__) . "includes/async.php");

/**
 * Agrego código de shortcode como columna en el listado de sliders
 */
require_once(plugin_dir_path(__FILE__) . "includes/columns.php");