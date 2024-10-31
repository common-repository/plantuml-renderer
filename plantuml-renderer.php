<?php
/**
 * PlantUML Renderer
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://datamad.co.uk
 * @since             0.0.1
 * @package           Plantuml_Renderer
 *
 * @wordpress-plugin
 * Plugin Name:       PlantUML Renderer
 * Plugin URI:        https://datamad.co.uk/plantuml-renderer
 * Description:       Insert PlantUML diagrams
 * Version:           0.0.3
 * Author:            Todd Halfpenny
 * Author URI:        https://datamad.co.uk
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       plantuml-renderer
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! defined( 'PUMLR_PLUGIN_VERSION' ) ) {
	define( 'PUMLR_PLUGIN_VERSION', '0.0.3' );
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-plantuml-renderer-activator.php
 */
function activate_plantuml_renderer() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-plantuml-renderer-activator.php';
	Plantuml_Renderer_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plantuml-renderer-deactivator.php
 */
function deactivate_plantuml_renderer() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-plantuml-renderer-deactivator.php';
	Plantuml_Renderer_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_plantuml_renderer' );
register_deactivation_hook( __FILE__, 'deactivate_plantuml_renderer' );


/**
 * Also check if we have updated - note activation hook not fired upon updates
 */
function pumlr_plugin_check_version() {
	if ( PUMLR_PLUGIN_VERSION !== get_option( 'pumlr_plugin_version' ) ) {
		activate_plantuml_renderer( PUMLR_PLUGIN_VERSION );
	}
}

add_action( 'plugins_loaded', 'pumlr_plugin_check_version' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-plantuml-renderer.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    0.0.1
 */
function run_plantuml_renderer() {

	$plugin = new Plantuml_Renderer();
	$plugin->run();

}
run_plantuml_renderer();
