<?php
/**
 * Events Manager - Debt Collective Add-on
 *
 * @package   DC_Events_Manager
 */
namespace DCEventsManager\App\Integration;

use DCEventsManager\Common\Abstracts\Base;
use DCEventsManager\App\Integration\RestFilters;
use DCEventsManager\App\Integration\Conditionals;
use DCEventsManager\App\Integration\Placeholders;

/**
 * Class Integration
 *
 * @package DCEventsManager\App\General
 * @since 1.0.0
 */
class Integration extends Base {

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
		$conditionals = new Conditionals( $this->version, $this->plugin_name );
		$placeholders = new Placeholders( $this->version, $this->plugin_name );

	}

}
