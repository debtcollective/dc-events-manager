<?php
/**
 * Events Manager - Debt Collective Add-on
 *
 * @package   DC_Events_Manager
 */
namespace DCEventsManager\App\General\Taxonomies;

use DCEventsManager\Common\Abstracts\Taxonomy;
use DCEventsManager\App\General\PostTypes\PostTypes;

/**
 * Class Taxonomies
 *
 * @package DCEventsManager\App\General
 * @since 1.0.0
 */
class EventCrmTag extends Taxonomy {

	/**
	 * Taxonomy data
	 */
	public const TAXONOMY = array(
		'id'         => 'event_an_tag',
		'archive'    => 'an-tags',
		'title'      => 'AN Tags',
		'singular'   => 'AN Tag',
		'menu'       => 'AN Tags',
		'icon'       => 'dashicons-tag',
		'post_types' => array( 'event', 'event-recurring' ),
		'rest'       => 'an-tags',
	);

	/**
	 * Initialize the class.
	 *
	 * @since 1.0.0
	 */
	public function settings() {
		\add_action( 'init', array( $this, 'register_taxonomy' ), 100 );
	}

	/**
	 * Register Taxonomy
	 * 
	 * @link https://developer.wordpress.org/reference/functions/register_taxonomy_for_object_type/
	 *
	 * @param array $args
	 * @return array $args
	 */
	public function register_taxonomy() {
		foreach( self::TAXONOMY['post_types'] as $post_type ) {
			\register_taxonomy_for_object_type( self::TAXONOMY['id'], $post_type );
		}
	}


}
