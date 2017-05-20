<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://github.com/marina9568/vhd-factsheets
 * @since      1.0.0
 *
 * @package    Vhd_Factsheets
 * @subpackage Vhd_Factsheets/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Vhd_Factsheets
 * @subpackage Vhd_Factsheets/includes
 * @author     Sokolova Marina <marina9568@gmail.com>
 */
class Vhd_Factsheets_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'vhd-factsheets',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
