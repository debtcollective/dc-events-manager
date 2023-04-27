<?php
/**
 * Events Manager - Debt Collective Add-on Blocks
 *
 * @package   DC_Events_Manager
 */
namespace DCEventsManager\App\Blocks;

use DCEventsManager\Common\Abstracts\Base;
use DCEventsManager\App\Blocks\Patterns;
use DCEventsManager\App\Blocks\Fields\Meta;
use DCEventsManager\Common\Util\TemplateLoader;

/**
 * Class Blocks
 *
 * @package DCEventsManager\App\General
 * @since 1.0.0
 */
class Blocks extends Base {

	public static $loader_params = array();

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
		/**
		 * add_filter( 'DCEventsManager\App\Blocks\Blocks\LoaderParams', $params );
		 */
		self::$loader_params = \apply_filters(
			\get_class() . '\LoaderParams',
			array(
				'filter_prefix'             => 'dc_events_manager',
				'plugin_directory'          => DCEVENTS_PLUGIN_DIR_PATH,
				'plugin_template_directory' => 'src/App/Blocks/templates',
				'theme_template_directory'  => 'template-parts/components',
			)
		);

		/**
		 * @link https://developer.wordpress.org/block-editor/reference-guides/filters/block-filters/#managing-block-categories
		 */
		if ( class_exists( '\WP_Block_Editor_Context' ) ) {
			\add_filter( 'block_categories_all', array( $this, 'registerBlockCategory' ), 10, 2 );
		} else {
			\add_filter( 'block_categories', array( $this, 'registerBlockCategory' ), 10, 2 );
		}

		new Patterns( $this->version, $this->plugin_name );

		\add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_blocks_scripts' ) );

		include_once \plugin_dir_path( __FILE__ ) . 'src/eventQuery/index.php';
		include_once \plugin_dir_path( __FILE__ ) . 'src/eventsTout/index.php';
		
		// include_once \plugin_dir_path( __FILE__ ) . 'src/eventDate/index.php';
		// include_once \plugin_dir_path( __FILE__ ) . 'src/eventLocation/index.php';
		// include_once \plugin_dir_path( __FILE__ ) . 'src/eventTime/index.php';
		// include_once \plugin_dir_path( __FILE__ ) . 'src/eventsComponent/index.php';

		if ( function_exists( '\wp_set_script_translations' ) ) {
			\add_action( 'init', array( $this, 'setScriptTranslations' ) );
		}
	}

	/**
	 * Register script translation
	 *
	 * @return void
	 */
	public function setScriptTranslations() {
		/**
		 * May be extended to wp_set_script_translations( 'my-handle', 'my-domain',
		 * plugin_dir_path( MY_PLUGIN ) . 'languages' ) ). For details see
		 * https://make.wordpress.org/core/2018/11/09/new-javascript-i18n-support-in-wordpress/
		 */
		\wp_set_script_translations( 'dc-events-manager', 'dc-events-manager' );
	}

	/**
	 * Register custom block category
	 *
	 * @see https://developer.wordpress.org/block-editor/reference-guides/filters/block-filters/#managing-block-categories
	 */
	public function registerBlockCategory( $block_categories, $editor_context ) {
		if ( ! in_array( 'events', $block_categories ) ) {
			array_push(
				$block_categories,
				array(
					'slug'  => 'events',
					'title' => __( 'Events', 'site-functionality' ),
					'icon'  => 'calendar-alt',
				)
			);
		}
		return $block_categories;
	}

	/**
	 * Register custom pattern category
	 *
	 * @see https://developer.wordpress.org/reference/functions/register_block_pattern_category/
	 */
	public function registerBlockPatternCategory() {}

	/**
	 * Get loader params
	 *
	 * @return array
	 */
	public static function getLoaderParams() : array {
		return self::$loader_params;
	}

	/**
	 * Enqueue Build Script
	 *
	 * When using @wordpress/create-block set-up with multiple blocks, we get "Block ... is already registered." error because each block's block.json file calls the build script again.
	 * Remove build script reference in block.json files
	 *
	 * @link https://wordpress.slack.com/archives/C02QB2JS7/p1629116113108600
	 *
	 * @return void
	 */
	public function enqueue_blocks_scripts() {
		$asset_file = require \plugin_dir_path( __FILE__ ) . 'build/index.asset.php';
		\wp_enqueue_script( 'dc-events-manager', \plugins_url( '/build/index.js', __FILE__ ), $asset_file['dependencies'], $asset_file['version'], false );
	}

}
