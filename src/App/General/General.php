<?php
/**
 * Events Manager - Debt Collective Add-on
 *
 * @package   DC_Events_Manager
 */
namespace DCEventsManager\App\General;

use DCEventsManager\Common\Abstracts\Base;
use DCEventsManager\App\General\ContentFilters;
use DCEventsManager\App\General\CustomFields;
use DCEventsManager\App\General\PostTypes\PostTypes;
use DCEventsManager\App\General\Taxonomies\Taxonomies;
use DCEventsManager\App\General\Settings;
use DCEventsManager\App\General\Queries;

/**
 * Class Taxonomies
 *
 * @package DCEventsManager\App\General
 * @since 1.0.0
 */
class General extends Base {

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
		 *
		 */
		new ContentFilters( $this->version, $this->plugin_name );
		new CustomFields( $this->version, $this->plugin_name );
		new PostTypes( $this->version, $this->plugin_name );
		new Taxonomies( $this->version, $this->plugin_name );
		new Settings( $this->version, $this->plugin_name );
	}

}
