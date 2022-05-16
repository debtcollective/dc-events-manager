<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://debtcollective.org
 * @since      1.0.0
 *
 * @package    DC_Events_Manager
 * @subpackage DC_Events_Manager/admin
 */
namespace DCEventsManager\App\Admin;

use DCEventsManager\Common\Abstracts\Base;
use DCEventsManager\App\Admin\Options;

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    DC_Events_Manager
 * @subpackage DC_Events_Manager/admin
 * @author     Debt Collective <pea@misfist.com>
 */
class Admin extends Base {

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
		new Options( $this->version, $this->plugin_name, $this->basename );

		\add_action( 'admin_enqueue_scripts', array( $this, 'enqueueStyles' ) );
		\add_action( 'admin_enqueue_scripts', array( $this, 'enqueueScripts' ) );
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueueStyles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in DC_Events_Manager_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The DC_Events_Manager_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		\wp_enqueue_style( $this->plugin_name, \esc_url( DCEVENTS_PLUGIN_URL . 'assets/public/css/admin.css' ), array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueueScripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in DC_Events_Manager_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The DC_Events_Manager_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		\wp_register_script( $this->plugin_name, \esc_url( DCEVENTS_PLUGIN_URL . 'assets/public/js/admin.js' ), array(), $this->version, false );

	}

}
