<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://allurewebsolutions.com
 * @since      1.0.0
 *
 * @package    Wpbakery_Page_Builder_Multilanguage
 * @subpackage Wpbakery_Page_Builder_Multilanguage/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Wpbakery_Page_Builder_Multilanguage
 * @subpackage Wpbakery_Page_Builder_Multilanguage/includes
 * @author     Allure Web Solutions <info@allurewebsolutions.com>
 */
class Wpbakery_Page_Builder_Multilanguage_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'wpbakery-page-builder-multilanguage',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
