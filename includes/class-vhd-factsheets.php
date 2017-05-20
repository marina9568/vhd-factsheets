<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://github.com/marina9568/vhd-factsheets
 * @since      1.0.0
 *
 * @package    Vhd_Factsheets
 * @subpackage Vhd_Factsheets/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Vhd_Factsheets
 * @subpackage Vhd_Factsheets/includes
 * @author     Sokolova Marina <marina9568@gmail.com>
 */
class Vhd_Factsheets {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Vhd_Factsheets_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'vhd-factsheets';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
                add_shortcode('vhd_factsheets', array($this, 'vhd_factsheets_shortcode'));

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Vhd_Factsheets_Loader. Orchestrates the hooks of the plugin.
	 * - Vhd_Factsheets_i18n. Defines internationalization functionality.
	 * - Vhd_Factsheets_Admin. Defines all hooks for the admin area.
	 * - Vhd_Factsheets_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-vhd-factsheets-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-vhd-factsheets-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-vhd-factsheets-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-vhd-factsheets-public.php';

		$this->loader = new Vhd_Factsheets_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Vhd_Factsheets_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Vhd_Factsheets_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Vhd_Factsheets_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Vhd_Factsheets_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Vhd_Factsheets_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}
        
        function vhd_factsheets_shortcode() {
            $factsheets = self::get_factsheets();
            
            echo '<pre>';
            print_r($factsheets);
            echo '</pre>';

        }
        
        static function get_array_from_files() {
            $path = plugin_dir_path( dirname( __FILE__ ) ) . 'assets/';

            $pets = array(
                'cat',
                'dog',
                'rabbit'
            );
            
            $types = array('conditions', 'management');
            
            $pets_array = array();
            
            foreach ($pets as $pet) {
                
                $types_array = array();
                
                foreach ($types as $type) {
                    $file = $path . $pet . '_' . $type . '.csv';

                    if (!file_exists($file)) {
                        continue;
                    }
                    
                    $array = $fields = array();
                    $i = 0;
                    $handle = @fopen($file, "r");
                    if ($handle) {
                        while (($row = fgetcsv($handle, 10000)) !== false) {
                            if (empty($fields)) {
                                $fields = $row;
                                continue;
                            }
                            foreach ($row as $k=>$value) {
                                $array[$i][$fields[$k]] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
                            }
                            $i++;
                        }
                        fclose($handle);

                        $types_array[$type] = $array;
                    }
                    $pets_array[$pet] = $types_array;
                }
            }
            
            return $pets_array;
            
        }
        
        static function get_factsheets() {
            $result = get_option('vhd_factsheets_array');
            
            if (! $result) {
                
                $result = self::get_array_from_files();
                
                add_option('vhd_factsheets_array', maybe_serialize( $result ) );
                
            } else {
                
                $result = maybe_unserialize($result);
                
            }
            
            return $result;
        }

}
