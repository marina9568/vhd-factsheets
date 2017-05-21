<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/marina9568/vhd-factsheets
 * @since      1.0.0
 *
 * @package    Vhd_Factsheets
 * @subpackage Vhd_Factsheets/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Vhd_Factsheets
 * @subpackage Vhd_Factsheets/public
 * @author     Sokolova Marina <marina9568@gmail.com>
 */
class Vhd_Factsheets_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Vhd_Factsheets_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Vhd_Factsheets_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/vhd-factsheets-public.css', array(), $this->version, 'all' );
                
                wp_enqueue_style( 'vhd-bootstrap', plugin_dir_url( __FILE__ ) . 'css/bootstrap.min.css', array(), '3.3.7', 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Vhd_Factsheets_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Vhd_Factsheets_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
                
                wp_enqueue_script( 'vhd-bootstrap', plugin_dir_url( __FILE__ ) . 'js/bootstrap.min.js', array(), '3.3.7', 'all' );
                
                wp_enqueue_script( 'vhd-modal', plugin_dir_url( __FILE__ ) . 'js/modal.js', array(), $this->version, 'all' );

	}

}
