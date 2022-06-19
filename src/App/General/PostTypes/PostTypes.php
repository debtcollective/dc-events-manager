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

	public const POST_TYPE = array(
		'id' => array( 'event', 'event-recurring' ),
	);

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

		\add_filter( 'em_cpt_event', array( $this, 'modify_event_cpt_args' ) );
	}

	/**
	 * Modify CPT Args
	 *
	 * @param array $args
	 * @return array $args
	 */
	public function modify_event_cpt_args( $args ) {
		$args['description'] = '';
		return $args;
	}

}
