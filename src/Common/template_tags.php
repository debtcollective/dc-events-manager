<?php

/**
 * Template Tags
 *
 * @link       https://debtcollective.org
 * @since      1.0.0
 *
 * @package    DC_Events_Manager
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Render Virtual Event Location
 *
 * @param obj   $EM_Event
 * @param array $args
 * @return void
 */
function dcem_virtual_location( $EM_Event, $args = array() ) {
	if ( ! is_object( $EM_Event ) ) {
		return;
	}

	$defaults = array(
		'target' => '_blank',
	);

	$args = wp_parse_args( $args, $defaults );

	$types = array(
		'url',
		'zoom_meeting',
		'zoom_room',
		'zoom_webinar',
	);

	if ( $EM_Event->has_event_location() ) {
		$EM_Location   = $EM_Event->get_event_location();
		$location_type = $EM_Event->event_location_type;

		if ( 'url' === $location_type ) :
			$url = $EM_Location->data['url'];
			?>

			<?php esc_html_e( 'Virtual', 'debt-collective' ); ?>

			<?php
		elseif ( in_array( $location_type, $types ) ) :
			?>
			
			<?php esc_html_e( 'Virtual', 'debt-collective' ); ?>

			<?php
		endif;
	}
}

/**
 * Render Event Address using EM Placeholders
 *
 * @link https://wp-events-plugin.com/documentation/placeholders/
 * @link https://wp-events-plugin.com/documentation/location-types/
 *
 * @param object $EM_Event
 * @param array  $args
 * @return void
 */
function dcem_physical_location( $EM_Event ) {
    if ( ! is_object( $EM_Event ) ) {
		return;
	}
	?>
	<div class="event__location-address">
		<div class="event__location-name"><?php echo $EM_Event->output( '#_LOCATIONNAME' ); ?></div>
		<div class="event__address">
			<div class="event__location-street"><?php echo $EM_Event->output( '#_LOCATIONADDRESS' ); ?></div>
			<div class="event__location-city"><?php echo $EM_Event->output( '#_LOCATIONTOWN' ); ?></div>
			<div class="event__location-state"><?php echo $EM_Event->output( '#_LOCATIONSTATE' ); ?></div>
			<div class="event__location-zip"><?php echo $EM_Event->output( '#_LOCATIONPOSTCODE' ); ?></div>
		</div>
	</div>
	<?php
}
