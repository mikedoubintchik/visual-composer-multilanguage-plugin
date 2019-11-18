<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://allurewebsolutions.com
 * @since             1.0.0
 * @package           Visual_Composer_Multilanguage
 *
 * @wordpress-plugin
 * Plugin Name:       WP Bakery Multilanguage
 * Plugin URI:        https://allurewebsolutions.com/projects/visual-composer-multilanguage
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           2.1.2
 * Author:            Allure Web Solutions
 * Author URI:        https://allurewebsolutions.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       visual-composer-multilanguage
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-visual-composer-multilanguage-activator.php
 */
function activate_visual_composer_multilanguage()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-visual-composer-multilanguage-activator.php';
	Visual_Composer_Multilanguage_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-visual-composer-multilanguage-deactivator.php
 */
function deactivate_visual_composer_multilanguage()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-visual-composer-multilanguage-deactivator.php';
	Visual_Composer_Multilanguage_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_visual_composer_multilanguage');
register_deactivation_hook(__FILE__, 'deactivate_visual_composer_multilanguage');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-visual-composer-multilanguage.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_visual_composer_multilanguage()
{

	$plugin = new Visual_Composer_Multilanguage();
	$plugin->run();
}
run_visual_composer_multilanguage();
