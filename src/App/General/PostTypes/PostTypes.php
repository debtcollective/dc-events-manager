<?php
/**
 * Events Manager - Debt Collective Add-on
 *
 * @package   DC_Events_Manager
 */
namespace DCEventsManager\App\General\PostTypes;

use DCEventsManager\Common\Abstracts\Base;

/**
 * Class Taxonomies
 *
 * @package DCEventsManager\App\General
 * @since 1.0.0
 */
class PostTypes extends Base {

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
		 */

		\add_filter( 'em_cpt_event', array( $this, 'modify_event_args' ), 9 );
		\add_filter( 'em_cpt_event_recurring', array( $this, 'modify_recurring_event_args' ), 9 );
	}

	/**
	 * Modify CPT Args
	 *
	 * @param array $args
	 * @return array $args
	 */
	public function modify_event_args( $args ) : array {
		$args['description']  = '';
		$args['show_in_rest'] = true;
		$args['rest_base']    = 'events';
		return $args;
	}

	/**
	 * Modify CPT Args
	 *
	 * @param array $args
	 * @return array $args
	 */
	public function modify_recurring_event_args( $args ) : array {
		$args['description']  = '';
		$args['show_in_rest'] = true;
		$args['rest_base']    = 'recurring-events';
		return $args;
	}

}
