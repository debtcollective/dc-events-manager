<?php
/**
 * Events Manager - Debt Collective Add-on
 *
 * @package   DC_Events_Manager
 */
namespace DCEventsManager\App\General;

use DCEventsManager\Common\Abstracts\Base;
use DCEventsManager\App\Admin\Options;
use const DCEventsManager\PLUGIN_VERSION;
use const DCEventsManager\PLUGIN_NAME;

/**
 * Class Queries
 *
 * @package DCEventsManager\App\General
 * @since 1.0.0
 */
class Queries extends Base {

	/**
	 * Transient ID
	 *
	 * @since 1.0.1
	 */
	const QUERY_TRANSIENT = 'dc_events_manager';

	/**
	 * Transitient Duration
	 *
	 * @since 1.0.1
	 *
	 * @var int
	 */
	public $query_transient_duration = 1;

	/**
	 * Plugin Options
	 *
	 * @since 1.0.1
	 *
	 * @var array
	 */
	protected $options;

	/**
	 * Scope padding
	 *
	 * @var string
	 */
	protected $time_diff = 'now';

	/**
	 * Initialize the class.
	 *
	 * @since 1.0.0
	 */
	public function init() {
		/**
		 * This general class is always being instantiated as requested in the Bootstrap class
		 */
		$this->options = \get_option( Options::OPTIONS_NAME );
	}

	/**
	 * Query Events
	 *
	 * @since 1.0.1
	 *
	 * @link https://developer.wordpress.org/apis/handbook/transients/
	 *
	 * @param string $scope
	 * @param array  $args
	 * @return array \WP_Post
	 */
	public function getEvents( $scope = 'all', $args = array() ): array {
		global $post;

		$scope                    = ( $event_scope = \get_post_meta( \get_the_ID(), 'event_scope', true ) ) ? $event_scope : $scope;
		$transient_id             = self::QUERY_TRANSIENT . '_objects_' . $scope;
		$query_transient_duration = isset( $this->options['query_cache_duration'] ) ? (int) $this->options['query_cache_duration'] : (int) 1;

		if ( false === ( $query = \get_transient( $transient_id ) ) ) {

			/**
			 * Maybe pad date
			 */
			$date_time = new \DateTime( $this->time_diff );
			$date_time->setTimezone( new \DateTimeZone( \wp_timezone_string() ) );
			$sort = ( $sort = \get_post_meta( get_the_ID(), 'event_sort', true ) ) ? strtoupper( \esc_attr( $sort ) ) : 'DESC';

			$defaults = array(
				'post_type'      => array( Event::POST_TYPE['id'] ),
				'posts_per_page' => 500,
				'orderby'        => 'meta_value',
				'order'          => $sort,
				'meta_key'       => 'start_date',
				'meta_type'      => 'DATETIME',
				'meta_query'     => array(
					array(
						'relation' => 'OR',
						array(
							'key'     => 'is_hidden',
							'compare' => 'NOT EXISTS',
						),
						array(
							'key'     => 'is_hidden',
							'value'   => array( '1', true ),
							'compare' => 'NOT IN',
						),
					),
					array(
						'relation' => 'OR',
						array(
							'key'     => 'hidden',
							'compare' => 'NOT EXISTS',
						),
						array(
							'key'     => 'hidden',
							'value'   => array( '1', true ),
							'compare' => 'NOT IN',
						),
					),
					array(
						'key'     => 'visibility',
						'value'   => 'private',
						'compare' => '!=',
					),
				),
			);

			$args = \wp_parse_args( $args, $defaults );

			if ( isset( $this->options['hide_canceled'] ) && 'checked' == $this->options['hide_canceled'] ) {
				$args['post_status'] = array( 'publish' );
			}

			if ( 'future' === $scope ) {
				$args['meta_query'][] = array(
					'key'     => 'start_date',
					'value'   => $date_time->format( 'c' ),
					'compare' => '>=',
				);
			} elseif ( 'past' === $scope ) {
				$args['meta_query'][] = array(
					'key'     => 'start_date',
					'value'   => $date_time->format( 'c' ),
					'compare' => '<',
				);
			}

			$query = new \WP_Query( $args );

			\set_transient( $transient_id, $query->posts, (int) $query_transient_duration * HOUR_IN_SECONDS );

			return $query->posts;
		}

		return $query;
	}

	/**
	 * Query Event IDs
	 *
	 * @since 1.0.1
	 *
	 * @link https://developer.wordpress.org/apis/handbook/transients/
	 *
	 * @param string $scope
	 * @param array  $args
	 * @return array \WP_Post()->ID
	 */
	public function getEventIds( $scope = 'all', $args = array() ): array {
		global $post;

		$scope                    = ( $event_scope = \get_post_meta( \get_the_ID(), 'event_scope', true ) ) ? $event_scope : $scope;
		$transient_id             = self::QUERY_TRANSIENT . '_ids_' . $scope;
		$query_transient_duration = isset( $this->options['query_cache_duration'] ) ? (int) $this->options['query_cache_duration'] : (int) 1;

		if ( false === ( $query = \get_transient( $transient_id ) ) ) {

			/**
			 * Keep events current for a few hours
			 */
			$date_time = new \DateTime( $this->time_diff );
			$date_time->setTimezone( new \DateTimeZone( \wp_timezone_string() ) );
			$scope = ( $event_scope = \get_post_meta( \get_the_ID(), 'event_scope', true ) ) ? $event_scope : $scope;

			$defaults = array(
				'post_type'      => array( Event::POST_TYPE['id'] ),
				'posts_per_page' => 500,
				'fields'         => 'ids',
				'meta_query'     => array(
					array(
						'relation' => 'OR',
						array(
							'key'     => 'is_hidden',
							'compare' => 'NOT EXISTS',
						),
						array(
							'key'     => 'is_hidden',
							'value'   => array( '1', true ),
							'compare' => 'NOT IN',
						),
					),
					array(
						'relation' => 'OR',
						array(
							'key'     => 'hidden',
							'compare' => 'NOT EXISTS',
						),
						array(
							'key'     => 'hidden',
							'value'   => array( '1', true ),
							'compare' => 'NOT IN',
						),
					),
					array(
						'key'     => 'visibility',
						'value'   => 'private',
						'compare' => '!=',
					),
				),
			);

			$args = \wp_parse_args( $args, $defaults );

			if ( isset( $this->options['hide_canceled'] ) && 'checked' == $this->options['hide_canceled'] ) {
				$args['post_status'] = array( 'publish' );
			}

			if ( 'future' === $scope ) {
				$args['meta_query'][] = array(
					'key'     => 'start_date',
					'value'   => $date_time->format( 'c' ),
					'compare' => '>=',
				);
			} elseif ( 'past' === $scope ) {
				$args['meta_query'][] = array(
					'key'     => 'start_date',
					'value'   => $date_time->format( 'c' ),
					'compare' => '<',
				);
			}

			$query = new \WP_Query( $args );

			\set_transient( $transient_id, $query->posts, (int) $query_transient_duration * HOUR_IN_SECONDS );

			return $query->posts;
		}

		return $query;
	}

	/**
	 * Get Events
	 *
	 * @since 1.0.1
	 *
	 * @param string $scope
	 * @param array  $args
	 * @return void
	 */
	static function getAnEvents( $scope = 'all', $args = array() ) {
		$call = new Queries( PLUGIN_VERSION, PLUGIN_NAME );
		return $call->getEvents( $scope, $args );
	}

	/**
	 * Get Event IDs
	 *
	 * @since 1.0.1
	 *
	 * @param string $scope
	 * @param array  $args
	 * @return void
	 */
	static function getAnEventIds( $scope = 'all', $args = array() ) {
		$call = new Queries( PLUGIN_VERSION, PLUGIN_NAME );
		return $call->getEventIds( $scope, $args );
	}

}
