<?php
/**
 * Register and Render Block
 *
 * @since   1.0.0
 * @package Site_Functionality
 */
namespace DCEventsManager\App\Blocks\eventsComponent;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Render Block
 *
 * @param array $block_attributes
 * @param string $content
 * @param object $block
 * @return string
 */
function render( $attributes, $content, $block ) {
    $tagName = isset( $attributes['tagName'] ) ? \esc_attr( $attributes['tagName'] ) : \esc_attr( 'section' );
    $className = isset( $attributes['className'] ) ? \esc_attr( $attributes['className'] ) : \esc_attr( 'dc-events-manager-events' );
    $wrapper_attributes = \get_block_wrapper_attributes();

    $content = sprintf( '<%s %s>', $tagName, $wrapper_attributes );

    foreach ( $block->inner_blocks as $inner_block ) { 
        $content .= $inner_block->render(); 
    }

    $content .= sprintf( '</%s><!-- .%s -->', $tagName, $className );

    return $content;
}

/**
 * Registers the `dc-events-manager/events` block on the server.
 */
function register() {
	\register_block_type(
		__DIR__,
		[
			'render_callback' 	=> __NAMESPACE__ . '\render',
		]
	);
}
add_action( 'init', __NAMESPACE__ . '\register' );