<?php

/**
 * This class defines all code necessary to handle public's AJAX calls.
 *
 * @since      1.0.0
 * @package    Xelion_Webchat
 * @subpackage Xelion_Webchat/includes
 * @author     Jauhari
 */
class Xelion_Webchat_Ajax_Public {

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
    $gateway = preg_replace( '/\s+/', '', get_option( 'xwc_api_gateway' ) );

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

    $this->api_base_url = $https . $host . '/portal/chat/' . $tenant . '/gateways/' . $gateway;

  }

  private function xwc_set_headers() {

    $token = get_option( 'xwc_api_token' );

    $this->api_headers = array(
      'Content-Type' => 'application/json',
      'Authorization' => $token
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

    // If response_body_decoded throws something other than 0 (JSON_ERROR_NONE), it means that response_body is already a JSON object
    if ( json_last_error() !== 0 ) {
      
      $response_body_decoded = $response_body;

    }

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
   * Check if webchat is active or on DND mode
   */
  public function xwc_webchat_status_check() {

    $response = wp_remote_get( $this->api_base_url . '/status', array(
      'headers' => $this->api_headers
    ));

    $this->xwc_echo_json( $response );

    die();

  }

  /**
	 * Handle request chat session.
	 *
	 * @since    1.0.0
	 */
  public function xwc_request_session() {

    $client_id = $this->xwc_validate_string( $_POST["client_id"] );
    $client_email = $this->xwc_validate_string( $_POST["client_email"] );
    $client_phone = $this->xwc_validate_string( $_POST["client_phone"] );

    // if any of the above is empty, it will be an empty string
    $api_body = '{"clientId": "' . $client_id . '", ' . '"emailAddress": "' . $client_email . '", ' . '"phoneNumber": "' . $client_phone . '"}';

    $response = wp_remote_post( $this->api_base_url . '/sessions', array(
      'headers' => $this->api_headers,
      'body' => $api_body,
      'timeout' => 10,
      'blocking' => true,
    ));

    $this->xwc_echo_json( $response );

    die();

  }

  /**
   * Handle check session.
   * 
   * @since    1.0.0
   */
  public function xwc_check_session() {

    $session_id = $this->xwc_validate_string( $_POST["session_id"] );

    $response = wp_remote_get( $this->api_base_url . '/sessions' . '/' . $session_id, array(
      'headers' => $this->api_headers
    ));

    $this->xwc_echo_json( $response );

    die();
    
  }

  /**
	 * Handle get previous messages.
	 *
	 * @since    1.0.0
	 */
  public function xwc_get_previous_messages() {

    $session_id = $this->xwc_validate_string( $_POST["session_id"] );

    $response = wp_remote_get( $this->api_base_url . '/sessions' . '/' . $session_id . '/messages', array(
      'headers' => $this->api_headers
    ));

    $this->xwc_echo_json( $response );

    die();

  }

  /**
	 * Handle sending chat.
	 *
	 * @since    1.0.0
	 */
  public function xwc_send_chat() {

    $text = $this->xwc_validate_string( $_POST["text"] );
    $session_id = $this->xwc_validate_string( $_POST["session_id"] );

    $api_body = '{"text": "' . $text . '"}';

    $response = wp_remote_post( $this->api_base_url . '/sessions' . '/' . $session_id . '/messages', array(
      'headers' => $this->api_headers,
      'body' => $api_body
    ));

    $this->xwc_echo_json( $response );

    die();

  }

  /**
	 * Handle websocket init.
   * Get a websocket address.
	 *
	 * @since    1.0.0
	 */
  public function xwc_websocket_init() {

    $session_id = $this->xwc_validate_string( $_POST["session_id"] );

    $response = wp_remote_get( $this->api_base_url  . '/sessions'. '/' . $session_id . '/websocket', array(
      'headers' => $this->api_headers
    ));

    $this->xwc_echo_json( $response );

    die();

  }

  /**
   * Handle check transcript.
   * To see whether request transcript option is enabled.
   * 
   * @since    1.0.0
   */
  public function xwc_is_transcript_enabled() {

    $response = wp_remote_get( $this->api_base_url . '/transcript_enabled', array(
      'headers' => $this->api_headers
    ));

    $this->xwc_echo_json( $response );

    die();

  }

  /**
   * Handle request transcript.
   * 
   * @since    1.0.0
   */
  public function xwc_request_transcript() {

    $email = $this->xwc_validate_string( $_POST["email"] );
    $session_id = $this->xwc_validate_string( $_POST["session_id"] );

    $api_body = '{"value": "' . $email . '"}';

    $response = wp_remote_post( $this->api_base_url . '/sessions' . '/' . $session_id . '/transcript', array(
      'headers' => $this->api_headers,
      'body' => $api_body,
      'timeout' => 10,
      'blocking' => true,
    ));

    $this->xwc_echo_json( $response );

    die();

  }

  /**
   * Handle chat feedback.
   * 
   * @since    1.0.0
   */
  public function xwc_send_feedback() {

    $rating = $this->xwc_validate_string( $_POST["rating"] );
    $feedback = $this->xwc_validate_string( $_POST["feedback"] );
    $session_id = $this->xwc_validate_string( $_POST["session_id"] );

    $api_body = '{"rating": ' . $rating . ', ' . '"feedback": "' . $feedback . '"}';

    $response = wp_remote_post( $this->api_base_url . '/sessions' . '/' . $session_id . '/feedback', array(
      'headers' => $this->api_headers,
      'body' => $api_body,
      'timeout' => 10,
      'blocking' => true,
    ));

    $this->xwc_echo_json( $response );

    die();

  }
  
  /**
   * Handle close session.
   * 
   * @since    1.0.0
   */
  public function xwc_close_session() {

    $session_id = $this->xwc_validate_string( $_POST["session_id"] );

    $response = wp_remote_post( $this->api_base_url . '/sessions' . '/' . $session_id . '/close', array(
      'headers' => $this->api_headers
    ));

    $this->xwc_echo_json( $response );

    die();

  }

}
