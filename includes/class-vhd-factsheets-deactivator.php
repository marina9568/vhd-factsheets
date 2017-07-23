<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://github.com/marina9568/vhd-factsheets
 * @since      1.0.0
 *
 * @package    Vhd_Factsheets
 * @subpackage Vhd_Factsheets/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Vhd_Factsheets
 * @subpackage Vhd_Factsheets/includes
 * @author     Sokolova Marina <marina9568@gmail.com>
 */
class Vhd_Factsheets_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
            add_option('vhd_factsheets_array', '');
	}

}
