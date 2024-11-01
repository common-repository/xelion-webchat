<?php

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @since      1.0.0
 * @package    Xelion_Webchat
 * @subpackage Xelion_Webchat/public
 * @author     Jauhari
 */
class Xelion_Webchat_Public {

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
	 * Append the php for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function add_xwc_on_every_page() {

    // Get the path to the partial
    $xwc_content_path = plugin_dir_path( __FILE__ ) . 'partials/xelion-webchat-public-display.php';

    // Get the content of the partial
    ob_start();
    include $xwc_content_path;
    $xwc_content = ob_get_clean();

    // Add the allowed html elements to be echoed
    $xwc_allowed_html = array(
      'div' => array(
        'id' => array(),
        'data-xwc_ajaxurl' => array(),
        'data-xwc_language' => array(),
      ),
    );

    // Append extra attributes to the allowed html elements
    foreach ( XELION_WEBCHAT_CUSTOM_FIELDS as $field ) {

      if ( $field['public'] ) {

        $additional_element = 'data-' . preg_replace('/\s+/', '', $field['option_name'] );
        $xwc_allowed_html['div'][$additional_element] = array();

      }

    }

    // Safely echo the content
    echo wp_kses( $xwc_content, $xwc_allowed_html );
  
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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
    wp_enqueue_style( $this->plugin_name . '-public' . '-react', plugin_dir_url( __FILE__ ) . 'css/xelion-webchat-public-react.css', array(), $this->version, 'all' );

		// Non-react styles
		wp_enqueue_style( $this->plugin_name . '-public', plugin_dir_url( __FILE__ ) . 'css/xelion-webchat-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

    // React script
		wp_enqueue_script( $this->plugin_name . '-public' . '-react', plugin_dir_url( __FILE__ ) . 'js/xelion-webchat-public-react.js', array(), $this->version, false );

		// Non-react script
		wp_enqueue_script( $this->plugin_name . '-public', plugin_dir_url( __FILE__ ) . 'js/xelion-webchat-public.js', array(), $this->version, false );

	}

  /**
   * Defer the loading of xwc scripts.
   * 
   * @since    1.0.0
   */
  public function defer_xwc_scripts( $tag, $handle, $src ) {

    if ( strpos( $handle, $this->plugin_name . '-public' ) ) {
      
      $tag = str_replace( '></script>', ' defer></script>', $tag );
    
    }

    return $tag;
  
  }

}
