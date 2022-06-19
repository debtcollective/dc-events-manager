<?php
/**
 * Events Manager - Debt Collective Add-on
 *
 * @package   DC_Events_Manager
 */
namespace DCEventsManager\App\General;

use DCEventsManager\Common\Abstracts\Base;

/**
 * Class ContentFilters
 *
 * @package DCEventsManager\App\General
 * @since 1.0.0
 */
class ContentFilters extends Base {

	var $events_page_id;

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
		$this->event_page_id = get_option( 'dbem_events_page' );

		if ( ! get_option( 'dbem_events_page' ) ) {
			// \remove_filter( 'the_content', 'em_content' );
		} else {
			// \add_filter( 'em_content', array( $this, 'em_content' ) );
		}
	}

	/**
	 * Filter Event Content
	 *
	 * @param string $content
	 * @return string
	 */
	public function em_content_pre( string $content ) : string {
		return $content;
	}

		/**
		 * Filter Event Content
		 *
		 * @param string $content
		 * @return string
		 */
	public function em_content( string $content ) : string {
		$content = '';
		return $content;
	}

}
