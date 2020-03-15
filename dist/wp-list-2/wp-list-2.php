<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://pramod.com
 * @since             1.0.0
 * @package           Wp_List_2
 *
 * @wordpress-plugin
 * Plugin Name:       WP List creator 2
 * Plugin URI:        http://pramod.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Pramod
 * Author URI:        http://pramod.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-list-2
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WP_LIST_2_VERSION', '1.0.0' );
define( 'WP_LIST_2_PATH', plugin_dir_path( __FILE__ ) );
define( 'WP_LIST_2_URL', plugin_dir_url( __FILE__ ) );
define( 'WP_LIST_2_FILE', __FILE__ );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-list-2-activator.php
 */
function activate_wp_list_2() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-list-2-activator.php';
	Wp_List_2_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-list-2-deactivator.php
 */
function deactivate_wp_list_2() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-list-2-deactivator.php';
	Wp_List_2_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_list_2' );
register_deactivation_hook( __FILE__, 'deactivate_wp_list_2' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-list-2.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_list_2() {
	$GLOBALS['wp_list_2'] = new Wp_List_2();
	$GLOBALS['wp_list_2']->run();
}

run_wp_list_2();
