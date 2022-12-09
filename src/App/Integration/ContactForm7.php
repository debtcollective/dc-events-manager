<?php
/**
 * Events Manager - Debt Collective Add-on
 *
 * @package   DC_Events_Manager
 */
namespace DCEventsManager\App\Integration;

use DCEventsManager\Common\Abstracts\Base;
use DCEventsManager\App\Integration\Webhooks;
use DCEventsManager\App\Admin\Options;

/**
 * Class ContactForm7
 *
 * @package DCEventsManager\App\Integration
 * @since 1.0.0
 */
class ContactForm7 extends Base {

	/**
	 * Endpoint for RSVP
	 *
	 * @var string
	 */
	protected $endpoint;

	/**
	 * API Key
	 *
	 * @var string
	 */
	protected $api_key;

	/**
	 * RSVP Form
	 *
	 * @var string
	 */
	protected $rsvp_form;

	/**
	 * Event fields on Save
	 *
	 * @var array
	 */
	protected $fields = array(
		'event_id',
		'event_name',
		'post_id',
		'zoom_id',
		'first_name',
		'last_name',
		'email',
		'phone',
	);

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct( $version, $plugin_name ) {
		parent::__construct( $version, $plugin_name );
		$options         = \get_option( Options::OPTIONS_NAME, array() );
		$this->endpoint  = array_key_exists( 'register_endpoint', $options ) ? $options['register_endpoint'] : null;
		$this->api_key   = array_key_exists( 'api_key', $options ) ? $options['api_key'] : null;
		$this->rsvp_form = array_key_exists( 'rsvp_form', $options ) ? $options['rsvp_form'] : null;

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

		if ( isset( $this->endpoint ) && $this->rsvp_form && ! empty( $this->endpoint ) && ! empty( $this->rsvp_form ) ) {

			\add_action( 'admin_init', array( $this, 'set_options' ) );
			\add_action( 'acf/init', array( $this, 'register_fields' ) );

			\add_action( 'wpcf7_before_send_mail', array( $this, 'send_data' ), 10, 3 );
			\add_filter( 'shortcode_atts_wpcf7', array( $this, 'add_atts' ), 10, 3 );

			// \add_filter( 'wpcf7_contact_form_properties', array( $this, 'add_form_properties' ), 10, 2 );
		}
	}

	/**
	 * Turn off built-in registration
	 *
	 * @link https://developer.wordpress.org/reference/functions/update_option/
	 *
	 * @return void
	 */
	public function set_options() {
		\update_option( 'dbem_rsvp_enabled', 0 );
	}

	/**
	 * Save Registrant Action
	 *
	 * @param int  $post_id
	 * @param obj  $post
	 * @param bool $update
	 * @return void
	 */
	public function send_data( $contact_form, &$abort, $submission ) {
		if ( $this->rsvp_form == $contact_form->id() ) {
			$data     = $this->parse_data( $submission );
			$response = ( new Webhooks( $this->version, $this->plugin_name ) )->call( $this->endpoint, $data );
			// \error_log( __METHOD__ . ': ' . json_encode( $response ) );
		}
	}

	/**
	 * Parse the rsvp data
	 *
	 * @param object $submission
	 * @return array $data
	 */
	public function parse_data( $submission ) {
		$submission_data = $submission->get_posted_data();
		$data            = array();
		foreach ( $this->fields as $field ) {
			$data[ $field ] = isset( $submission_data[ $field ] ) ? \esc_attr( $submission_data[ $field ] ) : '';
		}
		return (object) $data;
	}

	/**
	 * Has RSVP
	 *
	 * @param integer $id
	 * @return boolean
	 */
	public function has_rsvp( int $post_id ) {
		return \get_post_meta( $post_id, 'enable_rsvp', true );
	}

	/**
	 * Register fields
	 *
	 * @link https://www.advancedcustomfields.com/resources/register-fields-via-php/
	 *
	 * @return void
	 */
	public function register_fields() {
		\acf_add_local_field_group(
			array(
				'key'                   => 'group_event_details',
				'title'                 => \__( 'Event Details', 'site-functionality' ),
				'fields'                => array(
					array(
						'key'               => 'field_enable_rsvp',
						'label'             => \__( 'Enable RSVP', 'site-functionality' ),
						'name'              => 'enable_rsvp',
						'type'              => 'true_false',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'message'           => \__( 'Display RSVP form on single event page', 'site-functionality' ),
						'default_value'     => 1,
						'ui'                => 1,
						'ui_on_text'        => '',
						'ui_off_text'       => '',
					),
				),
				'location'              => array(
					array(
						array(
							'param'    => 'post_type',
							'operator' => '==',
							'value'    => 'event',
						),
					),
					array(
						array(
							'param'    => 'post_type',
							'operator' => '==',
							'value'    => 'event-recurring',
						),
					),
				),
				'menu_order'            => 0,
				'position'              => 'normal',
				'style'                 => 'seamless',
				'label_placement'       => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen'        => '',
				'active'                => true,
				'description'           => '',
				'show_in_rest'          => 0,
			)
		);
	}

	/**
	 * Set Attributes
	 *
	 * @link https://contactform7.com/getting-default-values-from-shortcode-attributes/
	 *
	 * @param array $out
	 * @param array $pairs
	 * @param array $atts
	 * @return array $out
	 */
	public function add_atts( $out, $pairs, $atts ) {
		$attributes = array(
			'post_id',
			'event_name',
			'event_id',
			'zoom_id',
		);

		foreach ( $attributes as $attr ) {
			if ( isset( $atts[ $attr ] ) ) {
				$out[ $attr ] = $atts[ $attr ];
			}
		}

		return $out;
	}

}
