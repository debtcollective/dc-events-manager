<?php
/**
 * Events Manager - Debt Collective Add-on
 *
 * @package   DC_Events_Manager
 */
namespace DCEventsManager\App\Integration;

use DCEventsManager\Common\Abstracts\Base;
use DCEventsManager\App\Admin\Options;

/**
 * Class Webhooks
 *
 * @package DCEventsManager\App\Integration
 * @since 1.0.0
 */
class Webhooks extends Base {

	/**
	 * Endpoint
	 *
	 * @var string
	 */
	protected $event_endpoint;

	/**
	 * Endpoint
	 *
	 * @var string
	 */
	protected $register_endpoint;

	/**
	 * API Key
	 *
	 * @var string
	 */
	protected $api_key;

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct( $version, $plugin_name ) {
		parent::__construct( $version, $plugin_name );
		$options                 = Options::getOptions();
		$this->event_endpoint    = $options['event_endpoint'];
		$this->register_endpoint = $options['register_endpoint'];
		$this->api_key           = $options['api_key'];
		$this->init();
	}

	/**
	 * Initialize the class.
	 *
	 * @since 1.0.0
	 */
	public function init() {
		/**
		 * This general class is always being instantiated as requested in the Bootstrap class
		 *
		 * @see Bootstrap::__construct
		 */
		\add_action( 'save_post_event', array( $this, 'send_event_data' ), 10, 3 );
	}

	/**
	 * Send
	 *
	 * @param string $endpoint
	 * @param object $data
	 * @return void
	 */
	public function call( string $endpoint, object $data ) {
		$options = array(
			'body'        => json_encode( $data ),
			'headers'     => array(
				'Cache-Control' => 'no-cache',
			),
			'timeout'     => 60,
			'redirection' => 5,
			'blocking'    => true,
			'httpversion' => '1.0',
			'sslverify'   => false,
			'data_format' => 'body',
		);
		$request = \wp_remote_post( $endpoint, $options );
		return $request;
	}

	/**
	 * Save Event Action
	 *
	 * @param int  $post_id
	 * @param obj  $post
	 * @param bool $update
	 * @return void
	 */
	public function send_event_data( $post_id, $post, $update ) {
		if( ! property_exists( $this->event_endpoint ) || empty( $this->event_endpoint ) ) {
			return;
		}

		$EM_Event = \em_get_event( $post );

		if ( $EM_Event && ! is_wp_error( $EM_Event ) ) {
			$response = $this->call( $this->event_endpoint, $EM_Event );
			// error_log( get_class() . ': ' . json_encode( $response ) );
		}
	}

	/**
	 * Save Registrant Action
	 *
	 * @param int  $post_id
	 * @param obj  $post
	 * @param bool $update
	 * @return void
	 */
	public function send_registrant_data( $post_id, $post, $update ) {}

}
