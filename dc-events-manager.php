<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also src all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://debtcollective.org
 * @since             1.0.0
 * @package           DC_Events_Manager
 *
 * @wordpress-plugin
 * Plugin Name:       Events Manager - Debt Collective Add-on
 * Plugin URI:        https://github.com/debtcollective/dc-events-manager
 * Description:       Sync and display events from Action Network.
 * Version:           1.0.0
 * Author:            Debt Collective
 * Author URI:        https://debtcollective.org
 * License:           GPL-3.0
 * License URI:       http://www.gnu.org/licenses/lgpl-3.0.txt
 * Text Domain:       dc-events-manager
 * Domain Path:       /languages
 */
namespace DCEventsManager;

require plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

use DCEventsManager\App\Admin\Options;
use DCEventsManager\Activator as Activator;
use DCEventsManager\Deactivator as Deactivator;

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
const PLUGIN_NAME    = 'dc-events-manager';
const PLUGIN_VERSION = '1.0.0';

define( 'DCEVENTS_PLUGIN_DIR_PATH', \plugin_dir_path( __FILE__ ) );
define( 'DCEVENTS_PLUGIN_URL', \plugin_dir_url( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in src/activator.php
 */
function activate_dc_events_manager() {
	require_once \plugin_dir_path( __FILE__ ) . 'Activator.php';
	Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in src/deactivator.php
 */
function deactivate_dc_events_manager() {
	require_once \plugin_dir_path( __FILE__ ) . 'Deactivator.php';
	Deactivator::deactivate();
}
\register_activation_hook( __FILE__, __NAMESPACE__ . '\activate_dc_events_manager' );
\register_deactivation_hook( __FILE__, __NAMESPACE__ . '\deactivate_dc_events_manager' );

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function init() {
	if( ! defined( '\EM_VERSION' ) ) {
		return;
	}
	$plugin = new Common\Plugin( PLUGIN_VERSION, PLUGIN_NAME, \plugin_basename( __FILE__ ) );
	return $plugin;
}
\add_action( 'plugins_loaded', __NAMESPACE__ . '\init' );