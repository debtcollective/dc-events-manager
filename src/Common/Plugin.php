<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://debtcollective.org
 * @since      1.0.0
 *
 * @package    DC_Events_Manager
 * @subpackage DC_Events_Manager/src
 */
namespace DCEventsManager\Common;

use DCEventsManager\App\Admin\Admin;
use DCEventsManager\App\Frontend\Frontend;
use DCEventsManager\Common\Loader;
use DCEventsManager\Common\I18n;
use DCEventsManager\App\General\General;
use DCEventsManager\App\Integration\Integration;
use DCEventsManager\App\Blocks\Blocks;

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    DC_Events_Manager
 * @subpackage DC_Events_Manager/src
 * @author     Debt Collective <pea@misfist.com>
 */
class Plugin {

	private static $instance;

	/**
	 * @var array : will be filled with data from the plugin config class
	 * @see Plugin
	 */
	protected $plugin = [];

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * The basename location this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $basename 
	 */
	protected $basename;

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      DCEventsManager\Common\Loader   $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * Instance of Admin class
	 *
	 * @var object Admin
	 */
	protected $plugin_admin;

	/**
	 * Instance of Frontend class
	 *
	 * @var object Frontend
	 */
	protected $plugin_public;

	/**
	 * Construct
	 *
	 * @param string $version
	 * @param string $plugin_name
	 */
	public function __construct( $version, $plugin_name, $basename ) {
		$this->version = $version;
		$this->plugin_name = $plugin_name;
		$this->basename = $basename;

		// $this::instantiate();
		$this->init();
	}

	/**
	 * @return self
	 * @since 1.0.0
	 */
	public static function instantiate(): self {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	/**
	 * Initialize
	 *
	 * @param string $version
	 * @param string $plugin_name
	 * @return void
	 */
	public function init() {
		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - DCEventsManager\Common\Loader. Orchestrates the hooks of the plugin.
	 * - DCEventsManager\Common\I18n. Defines internationalization functionality.
	 * - DCEventsManager\App\Admin\Admin. Defines all hooks for the admin area.
	 * - DCEventsManager\App\Frontend\Frontend. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		$this->loader = new Loader();
		include_once 'template_tags.php';

		$this->plugin_admin = new Admin( $this->version, $this->plugin_name, $this->basename );
		new Blocks( $this->version, $this->plugin_name, $this->basename );
		$this->plugin_public = new Frontend( $this->version, $this->plugin_name );
		new General( $this->version, $this->plugin_name );
		new Integration( $this->version, $this->plugin_name );
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the I18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new I18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {
		$this->loader->add_action( 'admin_enqueue_scripts', $this->plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $this->plugin_admin, 'enqueue_scripts' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {
		$this->loader->add_action( 'wp_enqueue_scripts', $this->plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $this->plugin_public, 'enqueue_scripts' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    DCEventsManager\Common\Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
