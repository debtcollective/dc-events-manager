<?php
/**
 * Events Manager - Debt Collective Add-on
 *
 * @package   DC_Events_Manager
 */
namespace DCEventsManager\App\General;

use DCEventsManager\Common\Abstracts\Base;
use DCEventsManager\App\General\Taxonomies\Taxonomies;
use DCEventsManager\App\General\PostTypes\PostTypes;

/**
 * Class CustomFields
 *
 * @package DCEventsManager\App\General
 * @since 1.0.0
 */
class CustomFields extends Base {

	/**
	 * Post types
	 */
	public const POST_TYPES = array(
		'event',
		'event-recurring'
	);

	/**
	 * Custom fields
	 */
	public const FIELDS = array(
		'_event_location_type',
		'_event_location_url_text',
		'_location_id',
		'_event_start',
		'_event_end',
		'_event_timezone',
	);

	/**
	 * Field Mapping
	 *
	 * @var array
	 */
	public const FIELD_MAP = array(
		'post_title'         => 'title',
		'post_content'       => 'description',
		'post_date'          => 'created_date',
		'post_modified'      => 'modified_date',
		'post_status'        => '',
		'browser_url'        => 'browser_url',
		'_links_to'          => 'browser_url',
		'_links_to_target'   => 'blank',
		'an_id'              => 'identifiers[0]',
		'instructions'       => 'instructions',
		'start_date'         => 'start_date',
		'end_date'           => 'end_date',
		'featured_image'     => 'featured_image_url',
		'location_venue'     => 'location->venue',
		'location_latitude'  => 'location->location->latitude',
		'location_longitude' => 'location->location->longitute',
		'status'             => 'status',
		'visibility'         => 'visibility',
		'an_campaign_id'     => 'action_network:event_campaign_id',
		'internal_name'      => 'name',
		'hidden'             => 'action_network:hidden',
	);

	/**
	 * Timezone Regions
	 */
	protected $regions = array(
		\DateTimeZone::AMERICA,
		\DateTimeZone::PACIFIC,
	);

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
		\add_action( 'acf/input/admin_enqueue_scripts', array( $this, 'enqueueScripts' ), 10, 0 );
		\add_action( 'init', array( $this, 'registerPostMeta' ) );
	}

	/**
	 * Register post meta with Rest API
	 *
	 * @see https://developer.wordpress.org/reference/functions/register_post_meta/
	 *
	 * @return void
	 */
	public function registerPostMeta() {

		foreach ( self::FIELDS as $field ) {
			$numeric = array(
				'_location_id'
			);
			foreach( self::POST_TYPES as $post_type ) {
				\register_post_meta(
					$post_type,
					$field,
					array(
						'show_in_rest' => true,
						'single'       => true,
						'type'         => ( in_array( $field, $numeric ) ) ? 'boolean' : 'string',
					)
				);
			}
		}
	}

	/**
	 * Load ACF JS
	 *
	 * @return void
	 */
	public function enqueueScripts() {
		\wp_enqueue_script( $this->plugin_name . '-acf', \esc_url( DCEVENTS_PLUGIN_URL . 'assets/public/js/acf.js' ), array(), $this->version, false );
	}
}
