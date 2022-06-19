<?php
/**
 * Events Manager - Debt Collective Add-on
 *
 * @package   DC_Events_Manager
 */
namespace DCEventsManager\App\Integration;

use DCEventsManager\Common\Abstracts\Base;

/**
 * Class Conditionals
 *
 * @package DCEventsManager\App\General
 * @since 1.0.0
 */
class Conditionals extends Base {

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
		\add_action( 'em_event_output_show_condition', array( $this, 'is_current_recurrence' ), 1, 4 );
		\add_action( 'em_event_output_show_condition', array( $this, 'is_not_current_recurrence' ), 1, 4 );
	}

	/**
	 * If recurrence is the current event
	 *
	 * @param bool   $show
	 * @param string $condition
	 * @param string $full_match
	 * @param object $EM_Event
	 * @return boolean
	 */
	public function is_current_recurrence( $show, $condition, $full_match, $EM_Event ) {
		global $post;
		if ( is_object( $post ) && is_a( $post, '\WP_Post' ) && 'is_current_recurrence' === $condition ) {
			$show = $post->ID === $EM_Event->post_id;
		}
		return $show;
	}

	/**
	 * If recurrence is not the current event
	 *
	 * @param bool   $show
	 * @param string $condition
	 * @param string $full_match
	 * @param object $EM_Event
	 * @return boolean
	 */
	public function is_not_current_recurrence( $show, $condition, $full_match, $EM_Event ) {
		global $post;
		if ( is_object( $post ) && is_a( $post, '\WP_Post' ) && 'is_not_current_recurrence' === $condition ) {
			$show = $post->ID !== $EM_Event->post_id;
		}
		return $show;
	}

}
