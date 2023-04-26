<?php
/**
 * Events Manager - Debt Collective Add-on
 *
 * @package   DC_Events_Manager
 */
namespace DCEventsManager\App\General;

use DCEventsManager\Common\Abstracts\Base;
use DCEventsManager\App\Admin\Options;
use const DCEventsManager\PLUGIN_VERSION;
use const DCEventsManager\PLUGIN_NAME;

/**
 * Class Queries
 *
 * @package DCEventsManager\App\General
 * @since 1.0.0
 */
class Queries extends Base {

	/**
	 * Transient ID
	 *
	 * @since 1.0.1
	 */
	const QUERY_TRANSIENT = 'dc_events_manager';

	/**
	 * Transitient Duration
	 *
	 * @since 1.0.1
	 *
	 * @var int
	 */
	public $query_transient_duration = 1;

	/**
	 * Plugin Options
	 *
	 * @since 1.0.1
	 *
	 * @var array
	 */
	protected $options;

	/**
	 * Scope padding
	 *
	 * @var string
	 */
	protected $time_diff = 'now';

	/**
	 * Initialize the class.
	 *
	 * @since 1.0.0
	 */
	public function init() {
		/**
		 * This general class is always being instantiated as requested in the Bootstrap class
		 */
		$this->options = \get_option( Options::OPTIONS_NAME );
	}

	/**
	 * Query Events
	 *
	 * @since 1.0.1
	 *
	 * @link https://developer.wordpress.org/apis/handbook/transients/
	 *
	 * @param string $scope
	 * @param array  $args
	 * @return array \WP_Post
	 */
	public function getEvents( $args = array() ): array {

		$defaults = array(
			'limit'   => 500,
		);

		$args = \wp_parse_args( $args, $defaults );
		return \EM_Events::get( $args );
	}

	/**
	 * Get Events
	 *
	 * @since 1.0.1
	 *
	 * @param string $scope
	 * @param array  $args
	 * @return void
	 */
	public static function getEMEvents( $args = array() ) {
		$call = new Queries( PLUGIN_VERSION, PLUGIN_NAME );
		return $call->getEvents( $args );
	}
}
