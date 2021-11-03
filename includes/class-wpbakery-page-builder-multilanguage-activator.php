<?php

/**
 * Fired during plugin activation
 *
 * @link       https://allurewebsolutions.com
 * @since      1.0.0
 *
 * @package    Wpbakery_Page_Builder_Multilanguage
 * @subpackage Wpbakery_Page_Builder_Multilanguage/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wpbakery_Page_Builder_Multilanguage
 * @subpackage Wpbakery_Page_Builder_Multilanguage/includes
 * @author     Allure Web Solutions <info@allurewebsolutions.com>
 */
class Wpbakery_Page_Builder_Multilanguage_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		if ( ! function_exists( 'vc_add_param' ) ) {
			// Deactivate the plugin
			deactivate_plugins( __FILE__ );

			// Throw an error in the wordpress admin console
			$error_message = __( 'This plugin requires <a href="https://codecanyon.net/item/visual-composer-page-builder-for-wordpress/242431">WPBakery Page Builder</a> plugin to be active!', 'woocommerce' );
			die( $error_message );
		}
	}

}
