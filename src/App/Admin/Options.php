<?php

/**
 * The plugin options.
 *
 * @link       https://debtcollective.org
 * @since      1.0.0
 *
 * @package    DC_Events_Manager
 * @subpackage DC_Events_Manager/admin
 */
namespace DCEventsManager\App\Admin;

use DCEventsManager\Common\Abstracts\Base;
use DCEventsManager\App\Admin\Notices;
use DCEventsManager\App\General\PostTypes\Event;
use DCEventsManager\App\Integration\Sync;

/**
 * Plugin Options
 *
 * @package    DC_Events_Manager
 * @subpackage DC_Events_Manager/admin
 * @author     Debt Collective <pea@misfist.com>
 */
class Options extends Base {
	/**
	 * Cap required to edit settings
	 *
	 * @var string
	 */
	const OPTIONS_CAP = 'edit_events';

	/**
	 * Name of options field
	 *
	 * @var string
	 */
	const OPTIONS_NAME = 'dc_events_manager_options';

	/**
	 * ID of Options page
	 *
	 * @var string
	 */
	const OPTIONS_PAGE_NAME = 'options-dc-events-manager';

	/**
	 * Plugin Options
	 *
	 * @var array
	 */
	protected $options;

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct( $version, $plugin_name, $basename ) {
		parent::__construct( $version, $plugin_name, $basename );
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
		$this->setOptions();
		\add_action( 'admin_menu', array( $this, 'add_admin_menu' ), 20 );
		\add_action( 'admin_menu', array( $this, 'remove_admin_menu' ), 20 );
		\add_action( 'admin_init', array( $this, 'init_settings' ) );
	}

	/**
	 * Add Menu
	 *
	 * @link https://developer.wordpress.org/reference/functions/add_submenu_page/
	 *
	 * @return void
	 */
	public function add_admin_menu() {

		\add_submenu_page(
			'edit.php?post_type=' . \EM_POST_TYPE_EVENT,
			\esc_html__( 'Debt Collective Events Settings', 'dc-events-manager' ),
			\esc_html__( 'DC Settings', 'dc-events-manager' ),
			self::OPTIONS_CAP,
			self::OPTIONS_PAGE_NAME,
			array( $this, 'render_page' )
		);

		\add_submenu_page(
			'edit.php?post_type=' . \EM_POST_TYPE_EVENT,
			\esc_html__( 'Event Cancellation Settings', 'dc-events-manager' ),
			\esc_html__( 'Cancellation Settings', 'dc-events-manager' ),
			self::OPTIONS_CAP,
			'admin.php?page=stonehenge-em-cancellation',
		);
	}

	/**
	 * Add Menu
	 *
	 * @link https://developer.wordpress.org/reference/functions/remove_menu_page/
	 *
	 * @return void
	 */
	public function remove_admin_menu() {
		\remove_menu_page( 'stonehenge-creations' );
		\remove_menu_page( 'stonehenge_forums' );
		\remove_menu_page( 'stonehenge_support' );
	}

	/**
	 * Initialize the class.
	 *
	 * @since 1.0.0
	 */
	public function init_settings() {

		\register_setting(
			self::OPTIONS_NAME,
			self::OPTIONS_NAME
		);

		\add_settings_section(
			self::OPTIONS_NAME . '_section',
			'',
			false,
			self::OPTIONS_NAME
		);

		\add_settings_field(
			'event_endpoint',
			\__( 'Event Endpoint', 'dc-events-manager' ),
			array( $this, 'renderEventEndpointField' ),
			self::OPTIONS_NAME,
			self::OPTIONS_NAME . '_section'
		);
		\add_settings_field(
			'register_endpoint',
			\__( 'RSVP Endpoint', 'dc-events-manager' ),
			array( $this, 'renderRegisterEndpointField' ),
			self::OPTIONS_NAME,
			self::OPTIONS_NAME . '_section'
		);
		\add_settings_field(
			'api_key',
			\__( 'API Key', 'dc-events-manager' ),
			array( $this, 'renderApiKeyField' ),
			self::OPTIONS_NAME,
			self::OPTIONS_NAME . '_section'
		);
		\add_settings_field(
			'rsvp_form',
			__( 'RSVP Form', 'dc-events-manager' ),
			array( $this, 'renderSelectRSVPForm' ),
			self::OPTIONS_NAME,
			self::OPTIONS_NAME . '_section'
		);
		\add_settings_field(
			'hide_canceled',
			__( 'Hide Canceled Events', 'dc-events-manager' ),
			array( $this, 'renderHideCanceledField' ),
			self::OPTIONS_NAME,
			self::OPTIONS_NAME . '_section'
		);

	}

	/**
	 * Render page
	 *
	 * @return void
	 */
	public function render_page() {

		// Check required user capability
		if ( ! \current_user_can( self::OPTIONS_CAP ) ) {
			\wp_die( \esc_html__( 'You do not have sufficient permissions to access this page.', 'dc-events-manager' ) );
		}

		// Admin Page Layout
		echo '<div class="wrap">' . "\n";
		echo '	<h1>' . \get_admin_page_title() . '</h1>' . "\n";
		echo '	<form action="options.php" method="post">' . "\n";

		\settings_fields( self::OPTIONS_NAME );
		\do_settings_sections( self::OPTIONS_NAME );
		\submit_button();

		echo '	</form>' . "\n";
		echo '</div>' . "\n";

	}

	/**
	 * Render Field
	 *
	 * @return void
	 */
	public function renderEventEndpointField() {
		$value = isset( $this->options['event_endpoint'] ) ? $this->options['event_endpoint'] : \esc_url( '' );

		echo '<input type="url" name="' . self::OPTIONS_NAME . '[event_endpoint]" class="large-text event_endpoint_field" placeholder="' . \esc_attr__( '', 'dc-events-manager' ) . '" value="' . \esc_attr( $value ) . '">';
	}

	/**
	 * Render Field
	 *
	 * @return void
	 */
	public function renderRegisterEndpointField() {
		$value = isset( $this->options['register_endpoint'] ) ? $this->options['register_endpoint'] : \esc_url( '' );

		echo '<input type="url" name="' . self::OPTIONS_NAME . '[register_endpoint]" class="large-text register_endpoint_field" placeholder="' . \esc_attr__( '', 'dc-events-manager' ) . '" value="' . \esc_attr( $value ) . '">';
	}

	/**
	 * Render Field
	 *
	 * @return void
	 */
	public function renderApiKeyField() {
		$value = isset( $this->options['api_key'] ) ? $this->options['api_key'] : '';

		echo '<input type="text" name="' . self::OPTIONS_NAME . '[api_key]" class="regular-text api_key_field" placeholder="' . \esc_attr__( '', 'dc-events-manager' ) . '" value="' . \esc_attr( $value ) . '">';
	}

	/**
	 * Render Field
	 *
	 * @return void
	 */
	public function renderHideCanceledField() {
		$value = isset( $this->options['hide_canceled'] ) ? $this->options['hide_canceled'] : 'false';

		printf(
			'<input type="checkbox" name="%s[hide_canceled]" class="hide_canceled_field" value="checked" %s> %s',
			self::OPTIONS_NAME,
			\checked( $value, 'checked', false ),
			\esc_attr__( 'Hide', 'dc-events-manager' )
		);
		echo '<p class="description">' . \__( 'Hide canceled events on site.', 'dc-events-manager' ) . '</p>';
	}

	/**
	 * Render Field
	 *
	 * @return void
	 */
	public function renderSelectRSVPForm() {
		$value = isset( $this->options['rsvp_form'] ) ? $this->options['rsvp_form'] : '0';

		if ( $options = $this->get_form_select_options() ) :
			?>
			<select name="<?php echo self::OPTIONS_NAME; ?>[rsvp_form]" class="rsvp_form_field">
				<option value="0"><?php echo \esc_html__( '-- Select form --', 'dc-events-manager' ); ?></option>
				<?
				foreach( $options as $id => $title ) :

					var_dump( $value === $id );

					printf( '<option value="%s" %s>%s</option>', $id, \selected( $value, $id, false ), $title );

				endforeach;
				?>
			</select>
			<?php
		endif;

	}

	/**
	 * Get all the forms
	 *
	 * @link https://developer.wordpress.org/reference/classes/wp_query
	 *
	 * @return string
	 */
	public function get_form_select_options() {
		$form_elements = array();
		$forms = $this->get_forms();
		if( ! empty( $forms ) && ! \is_wp_error( $forms ) ) {
			foreach( $forms as $form ) {
				$form_elements[$form->ID] = $form->post_title;
			}
		}
		return $form_elements;
	}

	/**
	 * Get all the forms
	 *
	 * @link https://developer.wordpress.org/reference/classes/wp_query
	 *
	 * @return array
	 */
	public function get_forms() : array {
		if ( ! class_exists( '\WPCF7_ContactForm' ) ) {
			return array();
		}
		$args = array(
			'post_type'      => array( \WPCF7_ContactForm::post_type ),
			'posts_per_page' => -1,
			'order'          => 'ASC',
			'orderby'        => 'title',
		);
		return \get_posts( $args );
	}

	/**
	 * Get Options
	 *
	 * @see https://developer.wordpress.org/reference/functions/get_option/
	 *
	 * @return mixed array || false
	 */
	static function getOptions() {
		return \get_option( self::OPTIONS_NAME );
	}

	/**
	 * Set options
	 *
	 * @return void
	 */
	function setOptions() {
		$this->options = self::getOptions();
	}
}
