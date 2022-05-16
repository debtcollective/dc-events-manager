<?php
/**
 * Fired during plugin deactivation
 *
 * @link       https://debtcollective.org
 * @since      1.0.0
 *
 * @package    DC_Events_Manager
 * @subpackage DC_Events_Manager/src
 */
namespace DCEventsManager;

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    DC_Events_Manager
 * @subpackage DC_Events_Manager/src
 * @author     Debt Collective <pea@misfist.com>
 */
class Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		\flush_rewrite_rules();

		\update_option( 'dc_events_manager_active', false );
	}

}
