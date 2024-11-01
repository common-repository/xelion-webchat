<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Xelion_Webchat
 * @subpackage Xelion_Webchat/admin
 * @author     Jauhari
 */
class Xelion_Webchat_Admin {

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
	 * The array of admin settings.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array    $settings    The settings registered in the admin panel.
	 */
	private $settings;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->settings = array();
		$this->sections = array();
		$this->set_settings();

	}

	/**
	 * Populate settings with custom fields constant.
	 *
	 * @since    1.0.0
	 */
	private function set_settings() {

		$this->settings = XELION_WEBCHAT_CUSTOM_FIELDS;

	}

	/**
	 * Xelion Webchat admin menu. Add menu.
	 *
	 * @since    1.0.0
	 */
	public function add_xwc_admin_menu() {

		// Add menu
		add_menu_page('Xelion Webchat', 'Xelion Webchat', 'manage_options', 'xelion-webchat/settings.php', array( $this, 'get_xwc_admin_page' ), XELION_WEBCHAT_ICON, 100);

	}

	/**
	 * Xelion Webchat admin menu. The callback function for add_xwc_admin_menu's add_menu_page.
	 *
	 * @since    1.0.0
	 */
	public function get_xwc_admin_page() {

		// Return views
		require_once 'partials/xelion-webchat-admin-display.php';

	}

  /**
	 * Register custom fields for plugin settings.
	 *
	 * @since    1.0.0
	 */
	public function register_custom_fields() {

		// Register the settings
		foreach( $this->settings as $setting ) {

			register_setting( $setting['option_group'], $setting['option_name'], ( isset( $setting['default_value'] ) ? $setting['default_value'] : '' ) );

		}

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * An instance of this class should be passed to the run() function
		 * defined in Xelion_Webchat_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Xelion_Webchat_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

    // React styles
    wp_enqueue_style( $this->plugin_name . '-admin' . '-react', plugin_dir_url( __FILE__ ) . 'css/xelion-webchat-admin-react.css', array(), $this->version, 'all' );

    // Non-react styles
		wp_enqueue_style( $this->plugin_name . '-admin', plugin_dir_url( __FILE__ ) . 'css/xelion-webchat-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * An instance of this class should be passed to the run() function
		 * defined in Xelion_Webchat_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Xelion_Webchat_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

    /**
     * React script.
     *
     * Only load when on the plugin's admin page
     */
    if ( isset($_GET["page"]) && $_GET["page"] == 'xelion-webchat/settings.php' ) {
      wp_enqueue_script( $this->plugin_name . '-admin' . '-react', plugin_dir_url( __FILE__ ) . 'js/xelion-webchat-admin-react.js', array(), $this->version, false );
    }

    // Non-react script
		wp_enqueue_script( $this->plugin_name . '-admin', plugin_dir_url( __FILE__ ) . 'js/xelion-webchat-admin.js', array(), $this->version, false );

	}

  /**
   * Defer the loading of xwc scripts.
   * 
   * @since    1.0.0
   */
  public function defer_xwc_scripts( $tag, $handle, $src ) {

    if ( strpos( $handle, $this->plugin_name . '-admin' ) ) {
      
      $tag = str_replace( '></script>', ' defer></script>', $tag );
    
    }

    return $tag;
  
  }

}
