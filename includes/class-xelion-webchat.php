<?php

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
 * @package    Xelion_Webchat
 * @subpackage Xelion_Webchat/includes
 * @author     Jauhari
 */
class Xelion_Webchat {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Xelion_Webchat_Loader    $loader    Maintains and registers all hooks for the plugin.
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

		if ( defined( 'XELION_WEBCHAT_VERSION' ) ) {
			$this->version = XELION_WEBCHAT_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'xelion-webchat';

		$this->load_dependencies();
		$this->set_locale();
		$this->set_action_links();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Xelion_Webchat_Loader. Orchestrates the hooks of the plugin.
	 * - Xelion_Webchat_i18n. Defines internationalization functionality.
	 * - Xelion_Webchat_Admin. Defines all hooks for the admin area.
	 * - Xelion_Webchat_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

    /**
     * Utility functions.
     */
    require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/utility-xelion-webchat-utility-functions.php';
		
		/**
		 * The custom fields.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/const-xelion-webchat-custom-fields.php';

		/**
		 * The icons.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/const-xelion-webchat-icons.php';

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-xelion-webchat-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-xelion-webchat-i18n.php';

		/**
		 * This class is responsible to add action links.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-xelion-webchat-action-links.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-xelion-webchat-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-xelion-webchat-public.php';

		/**
		 * The class responsible for handling admin's AJAX calls.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-xelion-webchat-ajax-admin.php';

    /**
		 * The class responsible for handling public's AJAX calls.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-xelion-webchat-ajax-public.php';

		$this->loader = new Xelion_Webchat_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Xelion_Webchat_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Xelion_Webchat_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register extra action links.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_action_links() {

		$plugin_links = new Xelion_Webchat_ActionLinks( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_filter( 'plugin_action_links_' . XELION_WEBCHAT_BASENAME, $plugin_links, 'add_links' );
		
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Xelion_Webchat_Admin( $this->get_plugin_name(), $this->get_version() );
    $plugin_ajax_admin = new Xelion_Webchat_Ajax_Admin();

		// Add admin menu items
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_xwc_admin_menu' );

		// Enqueue scripts and styles
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

    // Defer xwc scripts
    $this->loader->add_filter( 'script_loader_tag', $plugin_admin, 'defer_xwc_scripts', 10, 3 );

		// Register general settings
		$this->loader->add_action( 'admin_init', $plugin_admin, 'register_custom_fields' );

    // Ajax handlers
    $this->loader->add_action( 'wp_ajax_xwc_save_settings', $plugin_ajax_admin, 'xwc_save_settings' );
    $this->loader->add_action( 'wp_ajax_xwc_get_xelion_server_version', $plugin_ajax_admin, 'xwc_get_xelion_server_version' );
    $this->loader->add_action( 'wp_ajax_xwc_update_api_validity', $plugin_ajax_admin, 'xwc_update_api_validity' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

    // If xwc_api_is_correct is true, show plugin, else do nothing
    if ( get_option( 'xwc_api_is_valid' ) === 'valid' &&  xelion_webchat_func_check_API_validity() === 'valid') {

      $plugin_public = new Xelion_Webchat_Public( $this->get_plugin_name(), $this->get_version() );
      $plugin_ajax_public = new Xelion_Webchat_Ajax_Public();
  
      // Add xwc on every public-facing page
      $this->loader->add_action( 'wp_footer', $plugin_public, 'add_xwc_on_every_page');
  
      // Enqueue scripts and styles
      $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
      $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
  
      // Defer xwc scripts
      $this->loader->add_filter( 'script_loader_tag', $plugin_public, 'defer_xwc_scripts', 10, 3 );
  
      /**
       * Ajax handlers
       */
      // When user is not logged in
      $this->loader->add_action( 'wp_ajax_nopriv_xwc_webchat_status_check', $plugin_ajax_public, 'xwc_webchat_status_check' );
      $this->loader->add_action( 'wp_ajax_nopriv_xwc_request_session', $plugin_ajax_public, 'xwc_request_session' );
      $this->loader->add_action( 'wp_ajax_nopriv_xwc_check_session', $plugin_ajax_public, 'xwc_check_session' );
      $this->loader->add_action( 'wp_ajax_nopriv_xwc_get_previous_messages', $plugin_ajax_public, 'xwc_get_previous_messages' );
      $this->loader->add_action( 'wp_ajax_nopriv_xwc_send_chat', $plugin_ajax_public, 'xwc_send_chat' );
      $this->loader->add_action( 'wp_ajax_nopriv_xwc_websocket_init', $plugin_ajax_public, 'xwc_websocket_init' );
      $this->loader->add_action( 'wp_ajax_nopriv_xwc_is_transcript_enabled', $plugin_ajax_public, 'xwc_is_transcript_enabled' );
      $this->loader->add_action( 'wp_ajax_nopriv_xwc_request_transcript', $plugin_ajax_public, 'xwc_request_transcript' );
      $this->loader->add_action( 'wp_ajax_nopriv_xwc_send_feedback', $plugin_ajax_public, 'xwc_send_feedback' );
      $this->loader->add_action( 'wp_ajax_nopriv_xwc_close_session', $plugin_ajax_public, 'xwc_close_session' );
      // When user is logged in
      $this->loader->add_action( 'wp_ajax_xwc_webchat_status_check', $plugin_ajax_public, 'xwc_webchat_status_check' );
      $this->loader->add_action( 'wp_ajax_xwc_request_session', $plugin_ajax_public, 'xwc_request_session' );
      $this->loader->add_action( 'wp_ajax_xwc_check_session', $plugin_ajax_public, 'xwc_check_session' );
      $this->loader->add_action( 'wp_ajax_xwc_get_previous_messages', $plugin_ajax_public, 'xwc_get_previous_messages' );
      $this->loader->add_action( 'wp_ajax_xwc_send_chat', $plugin_ajax_public, 'xwc_send_chat' );
      $this->loader->add_action( 'wp_ajax_xwc_websocket_init', $plugin_ajax_public, 'xwc_websocket_init' );
      $this->loader->add_action( 'wp_ajax_xwc_is_transcript_enabled', $plugin_ajax_public, 'xwc_is_transcript_enabled' );
      $this->loader->add_action( 'wp_ajax_xwc_request_transcript', $plugin_ajax_public, 'xwc_request_transcript' );
      $this->loader->add_action( 'wp_ajax_xwc_send_feedback', $plugin_ajax_public, 'xwc_send_feedback' );
      $this->loader->add_action( 'wp_ajax_xwc_close_session', $plugin_ajax_public, 'xwc_close_session' );

    }
  
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
	 * @return    Xelion_Webchat_Loader    Orchestrates the hooks of the plugin.
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

}
