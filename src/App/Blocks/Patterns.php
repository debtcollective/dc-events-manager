<?php
/**
 * Events Manager - Debt Collective Add-on
 *
 * @package   DC_Events_Manager
 */
namespace DCEventsManager\App\Blocks;

use DCEventsManager\Common\Abstracts\Base;

/**
 * Class Patterns
 *
 * @package DCEventsManager\App\General
 * @since 1.0.0
 */
class Patterns extends Base {

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
		// \add_action( 'init', [ $this, 'register_block_patterns' ] );
		// \add_action( 'init', [ $this, 'register_block_pattern_category' ] );
	}

	/**
	 * Register Block Pattern Category
	 *
	 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-patterns/#register_block_pattern_category
	 *
	 * @return void
	 */
	public function register_block_pattern_category() {
		\register_block_pattern_category(
			'events',
			[
				'label' => __( 'Events', 'dc-events-manager' )
			]
		);
	}

	/**
	 * Register Block Patterns
	 *
	 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-patterns/
	 *
	 * @return void
	 */
	public function register_block_patterns() {}
}
