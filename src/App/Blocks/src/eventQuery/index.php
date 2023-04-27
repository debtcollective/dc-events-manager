<?php
/**
 * Server-side rendering of the `dc-events-manager/event-query` block.
 *
 * @package WordPress
 */
namespace DCEventsManager\App\Blocks\Event_Query;

use DCEventsManager\App\General\PostTypes\Event;
use DCEventsManager\App\General\Taxonomies\EventTag;
use DCEventsManager\Common\Util\TemplateLoader;
use DCEventsManager\App\Blocks\Blocks;
use DCEventsManager\App\Admin\Options;
use DCEventsManager\App\General\Queries;

/**
 * Renders the `dc-events-manager/event-query` block on the server.
 *
 * @param array    $attributes Block attributes.
 * @param string   $content    Block default content.
 * @param WP_Block $block      Block instance.
 * @return string Returns the filtered post date for the current post wrapped inside "time" tags.
 */
function render( $attributes, $content, $block ) {

	$block_type_attributes = $block->block_type->attributes;
	$default               = $block_type_attributes['query']['default'];

	$args = array(
		'limit' => isset( $attributes['query']['per_page'] ) ? (int) $attributes['query']['per_page'] : $default['per_page'],
		'order' => isset( $attributes['query']['order'] ) ? $attributes['query']['order'] : $default['order'],
		'scope' => isset( $attributes['query']['scope'] ) ? $attributes['query']['scope'] : $default['scope'],
	);

	if ( isset( $attributes['query']['event-tags'] ) && ! empty( $attributes['query']['event-tags'] ) ) {
		$args['tag'] = implode( ',', $attributes['query']['event-tags'] );
	}

	if ( isset( $attributes['query']['categories'] ) && ! empty( $attributes['query']['categories'] ) ) {
		$args['category'] = implode( ',', $attributes['query']['categories'] );
	}

	if ( isset( $attributes['query']['orderby'] ) ) {
		$args['orderby'] = ( 'start' === $attributes['query']['orderby'] ) ? 'event_start_date' : 'event_name';
	}

	ob_start();

	$events = Queries::getEMEvents( $args );

	if ( ! empty( $events ) ) :
		$classes = array(
			'events__list',
			'scope-' . $args['scope'],
			'found-' . count( $events ),
		);

		$wrapper_attributes = \get_block_wrapper_attributes( array( 'class' => implode( ' ', $classes ) ) );
		$loader_params      = Blocks::getLoaderParams();
		$template_loader    = new TemplateLoader( $loader_params );

		?>

		<<?php echo ( $attributes['wrapperTagName'] ); ?> <?php echo $wrapper_attributes; ?>>

		<?php
		foreach ( $events as $event ) :

			$template_loader
				->setTemplateData(
					array(
						'post_id'    => $event->post_id,
						'EM_Event'   => $event,
						'args'       => $attributes,
						'query_args' => $args,
					)
				)
				->getTemplatePart( 'event' );
			?>

			<?php
		endforeach;
		?>
		
		</<?php echo ( $attributes['wrapperTagName'] ); ?>><!-- .events__list -->

		<?php
		wp_reset_postdata();

	endif;

	$output = ob_get_clean();

	return $output;
}

/**
 * Registers the `dc-events-manager/event-query` block on the server.
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
