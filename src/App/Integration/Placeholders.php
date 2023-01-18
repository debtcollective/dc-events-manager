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
		if ( ! class_exists( '\EM_Events' ) ) {
			return;
		}

		if( $result == '#_RECURRENCES' ) {
			$args = array(
				'recurrence'    => (int) $EM_Event->recurrence_id,
				'scope'         => 'all',
				'format_header' => '<ul class="recurrences__list">',
				'format_footer' => '</ul>',
			);

			$args['format'] = '<li id="post-#_EVENTPOSTID" class="event-container event{is_past} past{/is_past}{is_future} future{/is_future}{is_recurrence} is-recurring{/is_recurrence}{is_current_recurrence} is-current{/is_current_recurrence}">
				{is_current_recurrence}<h4 class="recurrences__event-title">{/is_current_recurrence}
				{is_not_current_recurrence}<h4 class="recurrences__event-title"><a href="#_EVENTURL" title="#_EVENTNAME">{/is_not_current_recurrence}
				#_EVENTNAME
				{is_current_recurrence}</h4><!-- .recurrences__event-title -->{/is_current_recurrence}
				{is_not_current_recurrence}</a></h4><!-- .recurrences__event-title -->{/is_not_current_recurrence}
					<div class="event__date">
						<time datetime="#_{Y-m-d H:i:s}">#_EVENTDATES</time>
					</div>
			
					<div class="event__time event__time-start">
						<time datetime="#_{Y-m-d H:i:s}">#_EVENTTIMES</time>
					</div>
				</li>';

			$replace = \EM_Events::output( $args );
		}

		return $replace;
	}

}
