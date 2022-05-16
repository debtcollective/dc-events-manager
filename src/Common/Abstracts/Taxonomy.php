<?php
/**
 * Events Manager - Debt Collective Add-on
 *
 * @package   DC_Events_Manager
 */
namespace DCEventsManager\Common\Abstracts;

use DCEventsManager\Common\Abstracts\Base;

/**
 * Class Taxonomies
 *
 * @package DCEventsManager\App\General
 * @since 1.0.0
 */
abstract class Taxonomy extends Base {

	/**
	 * Taxonomy data
	 */
	public const TAXONOMY = self::TAXONOMY;

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

		add_action( 'init', array( $this, 'register' ) );

	}

	/**
	 * Register taxonomy
	 *
	 * @since 1.0.0
	 */
	public function register() {

		$labels = array(
			'name'                       => _x( $this::TAXONOMY['title'], 'Taxonomy General Name', 'dc-events-manager' ),
			'singular_name'              => _x( $this::TAXONOMY['singular'], 'Taxonomy Singular Name', 'dc-events-manager' ),
			'menu_name'                  => __( $this::TAXONOMY['menu'], 'dc-events-manager' ),
			'all_items'                  => sprintf( /* translators: %s: post type title */ __( 'All %s', 'dc-events-manager' ), $this::TAXONOMY['title'] ),
			'parent_item'                => sprintf( /* translators: %s: post type title */ __( 'Parent %s', 'dc-events-manager' ), $this::TAXONOMY['singular'] ),
			'parent_item_colon'          => sprintf( /* translators: %s: post type title */ __( 'Parent %s:', 'dc-events-manager' ), $this::TAXONOMY['singular'] ),
			'new_item_name'              => sprintf( /* translators: %s: post type singular title */ __( 'New %s Name', 'dc-events-manager' ), $this::TAXONOMY['singular'] ),
			'add_new_item'               => sprintf( /* translators: %s: post type singular title */ __( 'Add New %s', 'dc-events-manager' ), $this::TAXONOMY['singular'] ),
			'edit_item'                  => sprintf( /* translators: %s: post type singular title */ __( 'Edit %s', 'dc-events-manager' ), $this::TAXONOMY['singular'] ),
			'update_item'                => sprintf( /* translators: %s: post type title */ __( 'Update %s', 'dc-events-manager' ), $this::TAXONOMY['singular'] ),
			'view_item'                  => sprintf( /* translators: %s: post type singular title */ __( 'View %s', 'dc-events-manager' ), $this::TAXONOMY['singular'] ),
			'search_items'               => sprintf( /* translators: %s: post type title */ __( 'Search %s', 'dc-events-manager' ), $this::TAXONOMY['title'] ),

			'separate_items_with_commas' => sprintf( /* translators: %s: post type title */ __( 'Separate %s with commas', 'dc-events-manager' ), strtolower( $this::TAXONOMY['title'] ) ),
			'add_or_remove_items'        => sprintf( /* translators: %s: post type title */ __( 'Add or remove %s', 'dc-events-manager' ), strtolower( $this::TAXONOMY['title'] ) ),
			'popular_items'              => sprintf( /* translators: %s: post type title */ __( 'Popular %s', 'dc-events-manager' ), $this::TAXONOMY['title'] ),
			'search_items'               => sprintf( /* translators: %s: post type title */ __( 'Search %s', 'dc-events-manager' ), $this::TAXONOMY['title'] ),
			'no_terms'                   => sprintf( /* translators: %s: post type title */ __( 'No %s', 'dc-events-manager' ), strtolower( $this::TAXONOMY['title'] ) ),
			'items_list'                 => sprintf( /* translators: %s: post type title */ __( '%s list', 'dc-events-manager' ), $this::TAXONOMY['title'] ),
			'items_list_navigation'      => sprintf( /* translators: %s: post type title */ __( '%s list navigation', 'dc-events-manager' ), $this::TAXONOMY['title'] ),
		);

		$args = array(
			'labels'            => $labels,
			'hierarchical'      => false,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => true,
			'show_tagcloud'     => true,
			'show_in_rest'      => true,
			'rest_base'         => $this::TAXONOMY['rest'],
		);
		\register_taxonomy(
			$this::TAXONOMY['id'],
			(array) $this::TAXONOMY['post_types'],
			\apply_filters( \get_class( $this ) . '\Args', $args )
		);
	}
}
