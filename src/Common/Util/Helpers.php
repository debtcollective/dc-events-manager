<?php
/**
 * Helper Functions
 *
 * @since   1.0.0
 * @package DC_Events_Manager
 */

namespace DCEventsManager\Common\Util;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Convert a string to currency-formatted number
 *
 * @param string  $string
 * @param boolean $decimal
 * @return float $formatted
 */
function convert_string_to_number( $string, $decimal = true, $trim = true ) {
	$pattern = '/[^0-9\.{1}]/';
	// $cleaned_number = preg_replace( $pattern, '', $string );
	$cleaned_number = filter_var( preg_replace( $pattern, '', $string ), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
	$formatted      = number_format( $cleaned_number, $decimal ? 2 : 0 );
	$formatted      = $trim ? str_replace( '.00', '', $formatted ) : $formatted;
	return $formatted;
}

/**
 * Triggers an error about a remote HTTP request and response.
 *
 * @param string         $url The resource URL.
 * @param array          $request Request arguments.
 * @param array|WP_Error $response The response or WP_Error on failure.
 */
function log_remote_request( $url, $request, $response ) {
	$log = sprintf(
		/* translators: 1: response code, 2: message, 3: body, 4: URL */
		__( 'HTTP Response: %1$s %2$s %3$s from %4$s', 'dc-events-manager' ),
		(int) \wp_remote_retrieve_response_code( $response ),
		\wp_remote_retrieve_response_message( $response ),
		\wp_remote_retrieve_body( $response ),
		$url
	);

	$log = \apply_filters(
		'DCEventsManager\Common\Util\log',
		$log,
		$url,
		$request,
		$response
	);

	if ( $log ) {
		trigger_error( $log );
	}
}

/**
 * Debug Helper
 */
if ( ! function_exists( 'console_log' ) ) {
	function console_log( $data ) {
		$output = $data;
		if ( is_array( $output ) ) {
			$output = implode( ',', $output );
		}

		echo "<script>console.log( $output );</script>";
	}
}

/**
 * Simple helper to debug to the console
 *
 * @param data object, array, string             $data
 * @param $context string  Optional a description.
 *
 * @return string
 */
function debug_to_console( $data, $context = 'Debug in Console' ) {

	// Buffering to solve problems frameworks, like header() in this and not a solid return.
	ob_start();

	$output  = 'console.info(\'' . $context . ':\');';
	$output .= 'console.log(' . json_encode( $data ) . ');';
	$output  = sprintf( '<script>%s</script>', $output );

	echo $output;
}
