<?php
/**
 * Fired during plugin activation
 *
 * @link       https://debtcollective.org
 * @since      1.0.0
 *
 * @package    DC_Events_Manager
 * @subpackage DC_Events_Manager/src
 */
namespace DCEventsManager;

use DCEventsManager\App\Admin\Options;

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    DC_Events_Manager
 * @subpackage DC_Events_Manager/src
 * @author     Debt Collective <pea@misfist.com>
 */
class Activator {

	/**
	 * Activator
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		\flush_rewrite_rules();

		\update_option( 'dc_events_manager_active', true );
	}

}
