<?php
/**
 * Events Manager - Debt Collective Add-on
 *
 * @package   DC_Events_Manager
 */
namespace DCEventsManager\App\Integration;

use DCEventsManager\Common\Abstracts\Base;

/**
 * Class Placeholders
 *
 * @package DCEventsManager\App\General
 * @since 1.0.0
 */
class Placeholders extends Base {

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
		\add_filter( 'em_event_output_placeholder', array( $this, 'recurrences' ), 1, 3 );
	}

	/**
	 * Show List of Recurrences
	 *
	 * @param string $replace
	 * @param object $EM_Event
	 * @param string $result
	 * @return string   $replace
	 */
	public function recurrences( $replace, $EM_Event, $result ) {
		return $replace;
	}

}
