<?php
/**
 * Events Manager - Debt Collective Add-on
 *
 * @package   DC_Events_Manager
 */
namespace DCEventsManager\App\General\Taxonomies;

use DCEventsManager\Common\Abstracts\Base;

/**
 * Class Taxonomies
 *
 * @package DCEventsManager\App\General
 * @since 1.0.0
 */
class Taxonomies extends Base {

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
		\add_filter( 'em_ct_categories', array( $this, 'modify_taxonomy_args' ) );
		\add_filter( 'em_ct_tags', array( $this, 'modify_taxonomy_args' ), 9 );

	}

	/**
	 * Modify taxonomy args
	 *
	 * @param array $args
	 * @return array $args
	 */
	public function modify_taxonomy_args( $args ) : array {
		$args['show_in_rest'] = true;
		return $args;
	}


}
