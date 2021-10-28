<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://allurewebsolutions.com
 * @since      1.0.0
 *
 * @package    Wpbakery_Page_Builder_Multilanguage
 * @subpackage Wpbakery_Page_Builder_Multilanguage/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wpbakery_Page_Builder_Multilanguage
 * @subpackage Wpbakery_Page_Builder_Multilanguage/public
 * @author     Allure Web Solutions <info@allurewebsolutions.com>
 */
class Wpbakery_Page_Builder_Multilanguage_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 *
	 * @param      string $plugin_name The name of the plugin.
	 * @param      string $version The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wpbakery_Page_Builder_Multilanguage_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wpbakery_Page_Builder_Multilanguage_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wpbakery-page-builder-multilanguage-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wpbakery_Page_Builder_Multilanguage_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wpbakery_Page_Builder_Multilanguage_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wpbakery-page-builder-multilanguage-public.js', array( 'jquery' ), $this->version, false );

		wp_localize_script( $this->plugin_name, 'vc', array(
			'pluginUrl'       => plugin_dir_url( __FILE__ ),
			'ajax_url'        => admin_url( 'admin-ajax.php' ),
			'siteUrl'         => get_bloginfo( 'url' ),
			'defaultLanguage' => get_option( 'wpbakery_page_builder_multilanguage_default_language' ),
		) );

	}


	/**
	 * Add data-lang attribute to VC Rows
	 */
	public function extend_wpbakery_page_builder() {
		// Get languages from plugin settings
		$languages = explode( ',', str_replace( ' ', '', get_option( 'wpbakery_page_builder_multilanguage_languages', 'English' ) ) );

		// Add language dropdown to wpbakery page builder settings
		if ( function_exists( 'vc_add_param' ) ) {
			vc_add_param( 'vc_row', array(
				'type'        => 'dropdown',
				'heading'     => "Language",
				'param_name'  => 'language',
				'value'       => $languages,
				'description' => __( "Select Language", "discprofile" ),
				'weight'      => 1, //  default 0 (unsorted, appened to bottom, 1- append to top)
			) );
		}

		// Set custom html_template to display data-lang attribute
		$dir = __DIR__ . '/vc_templates';
		vc_set_shortcodes_templates_dir( $dir );
	}

	/**
	 * Add language switcher
	 */
	public function add_language_switcher() {
		if ( get_option( 'wpbakery_page_builder_multilanguage_switcher' ) === "switcher" ) {
			$languages     = explode( ',', str_replace( ' ', '', get_option( 'wpbakery_page_builder_multilanguage_languages', 'English' ) ) );
			$switcher_html = '<p id="language-selector"><strong>Change Language To: </strong>';

			foreach ( $languages as $language ) {
				$switcher_html .= '<a href="#" class="js-lang-option" data-lang-val="' . $language . '">' . $language . '</a> ';
			}

			echo $switcher_html;

		}
	}

	function plugin_settings_passthrough() {
		$googleapikey  = get_option( 'wpbakery_page_builder_multilanguage_googleapikey' );
		$styling       = get_option( 'wpbakery_page_builder_multilanguage_styling' );
		$autotranslate = get_option( 'wpbakery_page_builder_multilanguage_autotranslate' );
		echo '<div id="plugin-settings" style="display:none;" data-googleapikey="' . $googleapikey . '" data-styling="' . $styling . '" data-autotranslate="' . $autotranslate . '"></div>';
	}

}
