<?php
/**
 * Events Manager - Debt Collective Add-on
 *
 * @package   DC_Events_Manager
 */
namespace DCEventsManager\Common\Abstracts;

use DCEventsManager\App\Admin\Options;
use DCEventsManager\Common\Util\log_remote_request;

/**
 * The Data class which can be extended by other classes to load in default methods
 *
 * @package DCEventsManager\Common\Abstracts
 * @since 1.0.0
 */
abstract class GetData {

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
	 * Base URL
	 *
	 * @since    1.0.0
	 * @var string
	 */
	private $base_url;

	/**
	 * API Key.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string   $api_key
	 */
	protected $api_key;

	/**
	 * Endpoint.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string   $endpoint
	 */
	protected $endpoint;

	/**
	 * Array of args.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array   $args
	 */
	protected $args;

	/**
	 * Status.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array   $status
	 */
	protected $status;

	/**
	 * Log.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array   $log
	 */
	protected $log;

	/**
	 * API Data.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      object   $data
	 */
	protected $data;

	/**
	 * Records Per Page
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var int
	 */
	protected $per_page;

	/**
	 * Filter By Modification Date
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var string
	 */
	protected $search_filter;

	/**
	 * Current Page Number
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var int
	 */
	protected $current_page;

	/**
	 * Total Number of Records
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var int
	 */
	protected $total_records;

	/**
	 * Total Number of Pages
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var int
	 */
	protected $total_pages;



	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct( string $version, string $plugin_name, string $endpoint, $args = array() ) {
		$this->endpoint      = $endpoint;
		$this->version       = $version;
		$this->plugin_name   = $plugin_name;
		$this->search_filter = isset( $args['filter'] ) ? $args['filter'] : null;
		$this->per_page      = isset( $args['per_page'] ) ? (int) $args['per_page'] : 25;
		$this->current_page  = 0;

		$options        = Options::getOptions();
		$this->api_key  = isset( $options['api_key'] ) ? $options['api_key'] : null;
		$this->base_url = isset( $options['base_url'] ) ? $options['base_url'] : null;

		if ( $this->api_key && $this->base_url ) {
			$this->getRecords();
		} else {
			$this->setStatus( 'request', 'error' );
			$this->setLog( 'request', __( 'API Key or Base URL not provided', 'dc-events-manager' ) );
		}
	}

	/**
	 * Make Request
	 *
	 * @link https://developer.wordpress.org/reference/functions/wp_remote_get/
	 *
	 * @param string $url
	 * @return mixed object $request || WP_Error
	 */
	public function request( $url ) {
		$options = array(
			'headers'     => array(
				'Content-Type'   => 'application/json',
				'OSDI-API-Token' => $this->api_key,
			),
			'timeout'     => 100,
			'redirection' => 5,
		);

		$request = \wp_remote_get( $url, $options );

		if ( is_a( $request, '\WP_Error' ) ) {
			throw new \Exception( \wp_remote_retrieve_response_code( $request ) . ': ' . json_decode( \wp_remote_retrieve_body( $request ), false )->error );
		}

		return $request;
	}

	/**
	 * Get Records
	 *
	 * @return mixed object $response || null $response
	 */
	public function getRecords() {
		$args = array(
			'per_page' => $this->per_page,
		);
		if ( $this->search_filter ) {
			$args['filter'] = "modified_date gt '{$this->search_filter}'";
		}
		$url = \add_query_arg(
			$args,
			\esc_url( $this->base_url . $this->endpoint )
		);

		try {
			$request    = $this->request( $url );
			$response   = $this->handleRequest( $url, $request );
			$this->data = $response->{'_embedded'}->{'osdi:events'};

			while ( $response->total_pages > $response->page && isset( $response->{'_links'}->next->href ) ) {
					$url      = $response->{'_links'}->next->href;
					$request  = $this->request( $url );
					$response = $this->handleRequest( $url, $request );
					$this->data = array_merge( $this->data, $response->{'_embedded'}->{'osdi:events'} );
			}

			$this->setLog( 'found', count( $this->data ) );
		} catch ( \Exception $exception ) {
			$response = null;
		}
		return $response;
	}

	/**
	 * Get Record Data
	 *
	 * @return mixed object || null
	 */
	public function getData() {
		return $this->data;
	}

	/**
	 * Handle Request
	 *
	 * @param object $request
	 * @return mixed object $response || null;
	 */
	public function handleRequest( $url, $request ) {
		$response      = \wp_remote_retrieve_body( $request );
		$response_code = (int) \wp_remote_retrieve_response_code( $request );
		$this->setLog( 'response', $response_code );
		if ( 200 === $response_code ) {
			$response = json_decode( $response, false );
			$this->setStatus( 'response', 'success' );
		} elseif ( 401 === $response_code ) { // 401 Unauthorized
			$response = false;
			log_remote_request( $url, $request, $response );
			$this->setStatus( 'response', 'error' );
		} else {
			$response = null;
			log_remote_request( $url, $request, $response );
			$this->setStatus( 'response', 'error' );
		}
		return $response;
	}

	/**
	 * Set log
	 *
	 * @param string $prop
	 * @param mixed $value
	 * @return void
	 */
	public function setLog( $prop, $value ) {
		$this->log[$prop] = $value;
	}

	/**
	 * Get log
	 *
	 * @param string $prop
	 * @param mixed $value
	 * @return array $this->log
	 */
	public function getLog() {
		return $this->log;
	}

	/**
	 * Set status
	 *
	 * @param string $prop
	 * @param mixed $value
	 * @return void
	 */
	public function setStatus( $prop, $value ) {
		$this->status[$prop] = $value;
	}

	/**
	 * Get tatus
	 *
	 * @param string $prop
	 * @param mixed $value
	 * @return array $this->status
	 */
	public function getStatus() {
		return $this->status;
	}

	/**
	 * Enqueue Scripts
	 *
	 * @see https://developer.wordpress.org/reference/hooks/admin_enqueue_scripts/
	 *
	 * @return void
	 */
	public function enqueueScripts() {
		\wp_register_script( $this->plugin_name, esc_url( DCEVENTS_PLUGIN_URL . 'assets/public/js/admin.js' ), array( 'jquery' ), $this->version, false );

		$localized = array(
			'action'   => Options::SYNC_ACTION_NAME,
			'endpoint' => $this->endpoint,
			'ajax_url' => \admin_url( 'admin-ajax.php' ),
		);

		\wp_localize_script( $this->plugin_name, 'wpANEData', $localized );

		\wp_enqueue_script( $this->plugin_name );
	}
}
