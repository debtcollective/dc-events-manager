<?php
/**
 * Events Manager - Debt Collective Add-on
 *
 * @package   DC_Events_Manager
 */
namespace DCEventsManager\App\General;

use DCEventsManager\Common\Abstracts\Base;
use DCEventsManager\App\General\PostTypes\PostTypes;
use DCEventsManager\App\General\Taxonomies\EventCrmTag;

/**
 * Class Taxonomies
 *
 * @package DCEventsManager\App\General
 * @since 1.0.0
 */
class Settings extends Base {

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

		/**
		 * Enable REST API for 
		 * @see https://wp-events-plugin.com/blog/2018/12/06/wordpress-5-0-and-gutenberg-compatibility/
		 */
		if( ! defined( 'EM_GUTENBERG' ) ) {
			define( 'EM_GUTENBERG', true );
		}

		/**
		 * Allow nexted conditional placeholders
		 * @see https://wp-events-plugin.com/documentation/conditional-placeholders/
		 * @since 1.0.2
		 */
		if( ! defined( 'EM_CONDITIONAL_RECURSIONS' ) ) {
			define( 'EM_CONDITIONAL_RECURSIONS', 2 );
		}
	}

}
