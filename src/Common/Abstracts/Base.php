<?php
/**
 * Events Manager - Debt Collective Add-on
 *
 * @package   DC_Events_Manager
 */
namespace DCEventsManager\Common\Abstracts;

/**
 * The Base class which can be extended by other classes to load in default methods
 *
 * @package DCEventsManager\Common\Abstracts
 * @since 1.0.0
 */
abstract class Base {

	/**
	 * Singleton trait
	 */
	// use Singleton;

	// private static $instance;

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
	 * The basename of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $basename
	 */
	protected $basename;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * The status.
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      array    $status 
	 */
	public $status;

	/**
	 * The log.
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      array    $log 
	 */
	public $log;

	/**
	 * The errors.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array    $errors 
	 */
	protected $errors;

	/**
	 * Base constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct( $version , $plugin_name, $basename = '' ) {
		$this->version = $version;
		$this->plugin_name = $plugin_name;
		$this->basename = $basename;
	}

	/**
	 * Handle Errors
	 *
	 * @return void
	 */
	protected function handleError( $exception ) {
		$this->errors[] = $exception;
		// throw new \Exception( $exception );
	}

	/**
	 * Set log
	 *
	 * @param string $prop
	 * @param mixed $value
	 * @return void
	 */
	public function setLog( $prop, $value ) {
		$this->log[$prop] = $value;
	}

	/**
	 * Get log
	 *
	 * @param string $prop
	 * @param mixed $value
	 * @return array $this->log
	 */
	public function getLog() {
		return $this->log;
	}

	/**
	 * Set status
	 *
	 * @param string $prop
	 * @param mixed $value
	 * @return void
	 */
	public function setStatus( $prop, $value ) {
		$this->status[$prop] = $value;
	}

	/**
	 * Get tatus
	 *
	 * @param string $prop
	 * @param mixed $value
	 * @return array $this->status
	 */
	public function getStatus() {
		return $this->status;
	}
}
