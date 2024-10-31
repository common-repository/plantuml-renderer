<?php
/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://datamad.co.uk
 * @since      0.0.1
 *
 * @package    Plantuml_Renderer
 * @subpackage Plantuml_Renderer/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      0.0.1
 * @package    Plantuml_Renderer
 * @subpackage Plantuml_Renderer/includes
 * @author     Todd Halfpenny <todd@toddhalfpenny.com>
 */
class Plantuml_Renderer_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    0.0.1
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'plantuml-renderer',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}
}
