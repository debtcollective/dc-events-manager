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
		if ( defined( 'EM_GUTENBERG' ) && EM_GUTENBERG ) {
			add_filter( 'em_ct_tags', array( $this, 'enable_block_editor' ) );
			add_filter( 'em_ct_categories', array( $this, 'enable_block_editor' ) );
		}
	}

	public function enable_block_editor( $args ) {
		$args['show_in_rest'] = true;
		return $args;
	}

}
