<?php
/**
 * Event Template
 *
 * Override this template with one placed in {theme}/template-parts/components/event.php
 */

global $EM_Event;
$args = $data->args;

$post_id  = isset( $data->post_id ) ? (int) $data->post_id : get_the_id();
$EM_Event = isset( $data->EM_Event ) ? $data->EM_Event : em_get_event( $post_id, 'post_id' );
$taxonomy = 'event-tags';

$start_date   = $EM_Event->event_start_date;
$is_past      = $start_date < date( 'Y-m-d', time() );
$is_recurring = property_exists( $EM_Event, 'recurrence_id' ) && $EM_Event->recurrence_id;
$classes      = get_post_class( $is_past ? \esc_attr( 'past' ) : \esc_attr( 'future' ), $post_id );
$classes[]    = 'event-container';
$classes[]    = $is_recurring ? 'is-recurring' : '';
?>

<article id="post-<?php echo $post_id; ?>" class="<?php echo implode( ' ', $classes ); ?>">
	<a href="<?php echo \esc_url( \get_permalink( $post_id ) ); ?>">

		<?php
		if ( $args['display']['showTags'] ) :
			?>

			<div class="event__tag">
				<?php echo $EM_Event->output( '#_TAGNAME' ); ?>
			</div>

			<?php
		endif;
		?>

		<?php
		if ( $args['display']['showFeaturedImage'] && ( $image_url = $EM_Event->image_url ) ) :
			$image_id = \attachment_url_to_postid( $image_url );
			?>
			<picture className="event__media">
				<?php echo wp_get_attachment_image( $image_id, 'medium' ); ?>
			</picture>

			<?php
		endif;
		?>

		<?php
		if ( $args['display']['showTitle'] ) :
			?>

			<h3 class="event__title"><?php echo $EM_Event->output( '#_EVENTNAME' ); ?></h3>

			<?php
		endif;
		?>

		<?php
		if ( $args['display']['showDate'] ) :
			?>

			<div class="event__date">
				<time datetime="<?php echo $EM_Event->output( '#_{Y-m-d H:i:s}' ); ?>"><?php echo $EM_Event->output( '#_{' . $args['dateFormat'] . '}' ); ?></time>
			</div>

			<?php
		endif;
		?>

		<?php
		if ( $args['display']['showTime'] ) :
			?>

			<div class="event__time">
				<time datetime="<?php echo $EM_Event->output( '#_{Y-m-d H:i:s}' ); ?>"><?php echo $EM_Event->output( '#_{' . $args['timeFormat'] . '}' ); ?></time>

				<?php
				if ( $args['display']['showEndTime'] && ( $end_time = $EM_Event->event_end_time ) ) :
					?>
					<span className="separator"> - </span>
					<time datetime="<?php echo $EM_Event->output( '#@Y-#@m-#@d #@H:#@i:#@s' ); ?>"><?php echo date( $args['timeFormat'], strtotime( $end_time ) ); ?></time>
					<?php
				endif;
				?>

				<span class="timezone"><?php echo $EM_Event->output( '#_{T}' ); ?></span>
			</div>

			<?php
		endif;
		?>

		<?php
		if ( $args['display']['showLocation'] ) :
			?>

			<div class="event__location">
				<?php
				if ( $EM_Event->has_location() ) :
					?>

					<?php dcem_physical_location( $EM_Event ); ?>

					<?php
				elseif ( $EM_Event->has_event_location() ) :
					?>

					<?php dcem_virtual_location( $EM_Event ); ?>

					<?php
				endif;
				?>
			</div>
		   
			<?php
		endif;
		?>

	</a>

</article><!-- #post-## -->


