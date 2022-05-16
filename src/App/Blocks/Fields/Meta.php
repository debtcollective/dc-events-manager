<?php
/**
 * Events Manager - Debt Collective Add-on
 *
 * @package   DC_Events_Manager
 */

declare( strict_types = 1 );

namespace DCEventsManager\App\Blocks\Fields;

use DCEventsManager\Common\Abstracts\Base;

/**
 * Class Meta
 *
 * @package DCEventsManager\App\General
 * @since 1.0.0
 */
class Meta extends Base {

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
		 */
	}

}
