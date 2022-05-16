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
abstract class PostType extends Base {

	/**
	 * PostType data
	 */
	public const POST_TYPE = self::POST_TYPE;

	/**
	 * Post Type fields
	 */
	public const FIELDS = self::FIELDS;

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
		\add_action( 'init', 		[ $this, 'register' ] );
		\add_filter( 'query_vars', 	[ $this, 'registerQueryVars' ] );
	}

	/**
	 * Register post type
	 *
	 * @since 1.0.0
	 */
	public function register() {
		$labels = array(
			'name'                  => _x( $this::POST_TYPE['title'], 'Post Type General Name', 'dc-events-manager' ),
			'singular_name'         => _x( $this::POST_TYPE['singular'], 'Post Type Singular Name', 'dc-events-manager' ),
			'menu_name'             => __( $this::POST_TYPE['menu'], 'dc-events-manager' ),
			'name_admin_bar'        => __( $this::POST_TYPE['singular'], 'dc-events-manager' ),

			'add_new'        => sprintf( /* translators: %s: post type singular title */ __( 'New %s', 'dc-events-manager' ), $this::POST_TYPE['singular'] ),
			'add_new_item'   => sprintf( /* translators: %s: post type singular title */ __( 'Add New %s', 'dc-events-manager' ), $this::POST_TYPE['singular'] ),
			'new_item'       => sprintf( /* translators: %s: post type singular title */ __( 'New %s', 'dc-events-manager' ), $this::POST_TYPE['singular'] ),
			'edit_item'      => sprintf( /* translators: %s: post type singular title */ __( 'Edit %s', 'dc-events-manager' ), $this::POST_TYPE['singular'] ),
			'view_item'      => sprintf( /* translators: %s: post type singular title */ __( 'View %s', 'dc-events-manager' ), $this::POST_TYPE['singular'] ),
			'view_items'     => sprintf( /* translators: %s: post type title */ __( 'View %s', 'dc-events-manager' ), $this::POST_TYPE['title'] ),
			'all_items'      => sprintf( /* translators: %s: post type title */ __( 'All %s', 'dc-events-manager' ), $this::POST_TYPE['title'] ),
			'search_items'   => sprintf( /* translators: %s: post type title */ __( 'Search %s', 'dc-events-manager' ), $this::POST_TYPE['title'] ),


			'archives'              => sprintf( /* translators: %s: post type title */ __( '%s Archives', 'dc-events-manager' ), $this::POST_TYPE['singular'] ),
			'attributes'            => sprintf( /* translators: %s: post type title */ __( '%s Attributes', 'dc-events-manager' ), $this::POST_TYPE['singular'] ),
			'parent_item_colon'     => sprintf( /* translators: %s: post type title */ __( 'Parent %s:', 'dc-events-manager' ), $this::POST_TYPE['singular'] ),
			'update_item'           => sprintf( /* translators: %s: post type title */ __( 'Update %s', 'dc-events-manager' ), $this::POST_TYPE['singular'] ),
			'items_list'            => sprintf( /* translators: %s: post type singular title */ __( '%s List', 'dc-events-manager' ), $this::POST_TYPE['title'] ),
			'items_list_navigation' => sprintf( /* translators: %s: post type singular title */ __( '%s list navigation', 'dc-events-manager' ), $this::POST_TYPE['title'] ),

			'insert_into_item'      => sprintf( /* translators: %s: post type title */ __( 'Insert into %s', 'dc-events-manager' ), strtolower( $this::POST_TYPE['singular'] ) ),
			'uploaded_to_this_item' => sprintf( /* translators: %s: post type title */ __( 'Uploaded to this %s', 'dc-events-manager' ), strtolower( $this::POST_TYPE['singular'] ) ),
			'filter_items_list'     => sprintf( /* translators: %s: post type title */ __( 'Filter %s list', 'dc-events-manager' ), strtolower( $this::POST_TYPE['title'] ) ),
			'featured_image'        => __( 'Featured Image', 'dc-events-manager' ),
		);
		$args = array(
			'label'                 => $this::POST_TYPE['title'],
			'labels'                => $labels,
			'supports'              => isset( $this::POST_TYPE['supports'] ) ? (array) $this::POST_TYPE['supports'] : array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
			'taxonomies'            => $this::POST_TYPE['taxonomies'],
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_icon'          	=> $this::POST_TYPE['icon'],
			'menu_position'         => isset( $this::POST_TYPE['position'] ) ? (int) $this::POST_TYPE['position'] : 4,
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'        	=> $this::POST_TYPE['archive'],
			'rewrite'            => [
				'slug'       => $this::POST_TYPE['slug'],
				'with_front' => true,
			],
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'show_in_rest'          => true,
			'rest_base'             => $this::POST_TYPE['rest_base'],
			'capability_type'		=> $this::POST_TYPE['capability_type'],
			'map_meta_cap'			=> $this::POST_TYPE['map_meta_cap']
		);

		\register_post_type( 
			$this::POST_TYPE['id'], 
			\apply_filters( \get_class( $this ) . '\Args', $args )
		);
	
	}

	/**
	 * Register custom query vars
	 * 
	 * @link https://developer.wordpress.org/reference/hooks/query_vars/
	 *
	 * @param array $vars The array of available query variables
	 */
	abstract public function registerQueryVars( $vars );

}