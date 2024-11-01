<?php

/**
 * This class defines all code necessary to handle admin page's AJAX calls.
 *
 * @since      1.0.0
 * @package    Xelion_Webchat
 * @subpackage Xelion_Webchat/includes
 * @author     Jauhari
 */
class Xelion_Webchat_Ajax_Admin {

  private $api_base_url;
  private $api_headers;

  public function __construct() {
    
    $this->xwc_set_base_url();
    $this->xwc_set_headers();

  }

  private function xwc_set_base_url() {

    $https = 'https://';
    $host = preg_replace( '/\s+/', '', get_option( 'xwc_api_host' ) );
    $tenant = preg_replace( '/\s+/', '', get_option( 'xwc_api_tenant' ) );

    /**
     * If the user set the host value with https://, or http://,
     * correct it
     */
    if ( preg_match( '/^(https:\/\/)/i', $host ) ) {

      $host = preg_replace( '/(https:\/\/)/i', '', $host );

    } elseif ( preg_match( '/^(http:\/\/)/i', $host ) ) {

      $host = preg_replace( '/(http:\/\/)/i', '', $host );

    }

    /**
     * If tenant value is empty, set it to master,
     * otherwise, set it to its value
     */
    if ( $tenant === false || $tenant === '' ) {

      $tenant = 'master';

    }

    $this->api_base_url = $https . $host . '/api/v1/' . $tenant . '/server/version';

  }

  private function xwc_set_headers() {

    $this->api_headers = array(
      'Content-Type' => 'application/json'
    );

  }

  /**
   * Private method to safely output JSON object
   * 
   * @since    1.0.0
   */
  private function xwc_echo_json( $response ) {

    $response_body = wp_remote_retrieve_body( $response );

    $response_body_decoded = json_decode( $response_body );

    wp_send_json( $response_body_decoded );

  }

  /**
   * Private method to validate a string
   * 
   * @since    1.0.0
   */
  private function xwc_validate_string( $value ) {

    $validated = '';

    if ( isset( $value ) && !empty( $value ) ) {

      if ( is_string( $value ) ) {

        $validated = $value;

      } else {

        $validated = json_encode( $value );

      }

    }

    return $validated;

  }

  /**
   * Public methods
   */

  /**
   * Handle save settings.
   * 
   * $_POST["settings"] param accepts an array of objects with the following format:
   * [{ option_name: <DB option_name>, value: <DB option's value> }, ...]
   * 
   * @since    1.0.0
   */
  public function xwc_save_settings() {

    $settings = $this->xwc_validate_string( $_POST["settings"] );

    /**
     * Decode JSON string to array
     */
    $settings = json_decode( stripslashes( $settings ), true );

    if ( is_array( $settings ) ) {

      foreach ($settings as $setting) {

        // if $setting['option_name'] or $setting['value'] does not exist, skip this iteration
        if ( !isset( $setting['option_name'] ) || !isset( $setting['value'] ) ) {

          continue;

        }

        /**
         * If the option exists, update it
         * Otherwise, create a new one
         */
        if ( get_option( $setting['option_name'] ) !== false ) {

          update_option( $setting['option_name'], $setting['value'] );

        } else {

          add_option( $setting['option_name'], $setting['value'] );
        
        }

      }

      echo 'settings saved';
    
    } else {

      echo null;

    }

    die();

  }

  /**
   * Handle check Xelion server version.
   * 
   * @since    1.0.0
   */
  public function xwc_get_xelion_server_version() {

    $response = wp_remote_get( $this->api_base_url, array( 'headers' => $this->api_headers ) );

    $this->xwc_echo_json( $response );

    die();

  }

  /**
   * Handle update API validity.
   * 
   * @since          1.0.0
   * @lastupdated    8.3.0
   */
  public function xwc_update_api_validity() {

    $api_validity = xelion_webchat_func_check_API_validity();
    xelion_webchat_func_save_option( 'xwc_api_is_valid', $api_validity );
      
    wp_send_json( $api_validity );

    die();

  }

}
