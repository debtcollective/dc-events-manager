<?php
/**
 * Events Manager - Debt Collective Add-on
 *
 * @package   DC_Events_Manager
 */
namespace DCEventsManager\App\Integration;

use DCEventsManager\Common\Abstracts\Base;

/**
 * Class RestFilters
 *
 * @package DCEventsManager\App\Integration
 * @since 1.0.0
 */
class RestFilters extends Base {

	public const POST_TYPE = 'event';

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct( $version, $plugin_name ) {
		parent::__construct( $version, $plugin_name );
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
		 *
		 * Add plugin code here
		 */
		\add_filter( 'rest_query_vars', array( $this, 'rest_query_vars' ) );
		\add_filter( 'rest_' . self::POST_TYPE . '_query', array( $this, 'rest_query_start_date' ), 10, 2 );
		\add_filter( 'rest_' . self::POST_TYPE . '_collection_params', array( $this, 'rest_collection_params' ), 10, 2 );

	}

	/**
	 * Add rest query variables
	 *
	 * @param array $current_vars
	 * @return array
	 */
	function rest_query_vars( $current_vars ) {
		$current_vars = array_merge( $current_vars, array( 'meta_key', 'scope' ) );
		return $current_vars;
	}

	/**
	 * Modify query
	 * Orderby `meta_value` if `orderby=start` is passed
	 *
	 * @see https://developer.wordpress.org/reference/hooks/rest_this-post_type_query/
	 *
	 * @param array $params
	 * @param obj   $request
	 * @return array $params
	 */
	function rest_query_start_date( $params, $request ) {
		if ( isset( $request['orderby'] ) && 'start' === $request['orderby'] ) {
			$params['orderby']  = 'meta_value';
			$params['meta_key'] = '_event_start';
		}
		if ( isset( $request['scope'] ) && 'all' !== $request['scope'] ) {
			$compare = '>=';
			if ( 'past' === $request['scope'] ) {
				$compare = '<';
			}
			$params['meta_query'] = array(
				array(
					'key'     => '_event_start',
					'value'   => \date( 'c' ),
					'compare' => $compare,
					'type'    => 'DATETIME',
				),
			);
		}
		return $params;
	}

	/**
	 * Register collection parameters
	 * Add `start` as valid value for `orderby`
	 * Add `scope` parameter
	 *
	 * @see https://developer.wordpress.org/reference/hooks/rest_this-post_type_collection_params/
	 *
	 * @param array  $params
	 * @param string $post_type
	 * @return void
	 */
	function rest_collection_params( $params, $post_type ) {
		// array_push( $params['orderby']['enum'], 'start' );
		$params['scope'] = array(
			'description' => __( 'Limit scope of events to future or past.', 'dc-events-manager' ),
			'type'        => 'string',
			'default'     => 'future',
			'enum'        => array(
				'future',
				'past',
				'all',
			),
		);
		$params['orderby'] = array(
			'description' => __( 'Sort by start date or name.', 'dc-events-manager' ),
			'type'        => 'string',
			'default'     => 'start',
			'enum'        => array(
				'name',
				'start',
			),
		);
		return $params;
	}

}
