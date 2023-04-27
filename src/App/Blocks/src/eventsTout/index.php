<?php
/**
 * Register and Render Block
 *
 * @since   1.0.0
 * @package Site_Functionality
 */
namespace DCEventsManager\App\Blocks\eventsTout;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Render Block
 *
 * @param array $block_attributes
 * @param string $content
 * @return string
 */
function render( $attributes, $content, $block ) {
	$wrapper_attributes = \get_block_wrapper_attributes( array( 'class' => 'events-tout' ) );
	$content = '';

	if( ( $query_block = \dcem_get_inner_block( $block ) ) && isset( $query_block['attrs']['postsFound'] ) ) {
		$content .= '<div ' . $wrapper_attributes . '>';

		foreach ( $block->inner_blocks as $inner_block ) {
			$content .= $inner_block->render();
		}
	
		$content .= '</div><!-- .events-tout -->';
	} else {
		$content .= sprintf( '<!-- %s has no posts -->', $block->parsed_block['blockName'] );
	}

	return $content;
}

/**
 * Registers the `dc-events-manager/events-tout` block on the server.
 */
function register() {
	\register_block_type(
		__DIR__,
		array(
			'render_callback' => __NAMESPACE__ . '\render',
		)
	);
}
add_action( 'init', __NAMESPACE__ . '\register' );