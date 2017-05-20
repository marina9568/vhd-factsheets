<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/marina9568/vhd-factsheets
 * @since             1.0.0
 * @package           Vhd_Factsheets
 *
 * @wordpress-plugin
 * Plugin Name:       VetHelpDirect Factsheets
 * Plugin URI:        http://vethelpdirect.com/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Sokolova Marina
 * Author URI:        https://github.com/marina9568/vhd-factsheets
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       vhd-factsheets
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-vhd-factsheets-activator.php
 */
function activate_vhd_factsheets() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-vhd-factsheets-activator.php';
	Vhd_Factsheets_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-vhd-factsheets-deactivator.php
 */
function deactivate_vhd_factsheets() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-vhd-factsheets-deactivator.php';
	Vhd_Factsheets_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_vhd_factsheets' );
register_deactivation_hook( __FILE__, 'deactivate_vhd_factsheets' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-vhd-factsheets.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_vhd_factsheets() {

	$plugin = new Vhd_Factsheets();
	$plugin->run();

}
run_vhd_factsheets();
