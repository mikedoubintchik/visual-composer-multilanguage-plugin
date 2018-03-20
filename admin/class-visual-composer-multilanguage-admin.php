<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://allurewebsolutions.com
 * @since      1.0.0
 *
 * @package    Visual_Composer_Multilanguage
 * @subpackage Visual_Composer_Multilanguage/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Visual_Composer_Multilanguage
 * @subpackage Visual_Composer_Multilanguage/admin
 * @author     Allure Web Solutions <info@allurewebsolutions.com>
 */
class Visual_Composer_Multilanguage_Admin {

	/**
	 * The options name to be used in this plugin
	 *
	 * @since    1.0.0
	 * @access    private
	 * @var    string $option_name Option name of this plugin
	 */
	private $option_name = 'visual_composer_multilanguage';

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
	 * @param      string $plugin_name The name of this plugin.
	 * @param      string $version The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Visual_Composer_Multilanguage_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Visual_Composer_Multilanguage_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/visual-composer-multilanguage-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Visual_Composer_Multilanguage_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Visual_Composer_Multilanguage_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/visual-composer-multilanguage-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Add an options page under the Settings submenu
	 *
	 * @since  1.0.0
	 */
	public function add_options_page() {

		$this->plugin_screen_hook_suffix = add_options_page(
			__( 'VC Multilanguage Settings', 'visual-composer-multilanguage' ),
			__( 'VC Multilanguage', 'visual-composer-multilanguage' ),
			'manage_options',
			$this->plugin_name,
			array( $this, 'display_options_page' )
		);

	}

	/**
	 * Register all related settings of this plugin
	 *
	 * @since  1.0.0
	 */
	public function register_setting() {
		add_settings_section(
			$this->option_name . '_general',
			__( 'General', 'visual-composer-multilanguage' ),
			array( $this, $this->option_name . '_general_cb' ),
			$this->plugin_name
		);

		// Supported languages text field
		add_settings_field(
			$this->option_name . '_languages',
			__( 'Languages', 'visual-composer-multilanguage' ),
			array( $this, $this->option_name . '_languages_cb' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_languages' )
		);

		// Supported languages text field
		add_settings_field(
			$this->option_name . '_default_language',
			__( 'Select Default Language', 'visual-composer-multilanguage' ),
			array( $this, $this->option_name . '_default_language_cb' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_default_language' )
		);

		// Activate language switcher
		add_settings_field(
			$this->option_name . '_switcher',
			__( 'Activate Language Switcher', 'visual-composer-multilanguage' ),
			array( $this, $this->option_name . '_switcher_cb' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_switcher' )
		);

		// Activate automatic translations
		add_settings_field(
			$this->option_name . '_autotranslate',
			__( 'Activate Automatic Translations', 'visual-composer-multilanguage' ),
			array( $this, $this->option_name . '_autotranslate_cb' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_autotranslate' )
		);

		// Activate styling
		add_settings_field(
			$this->option_name . '_styling',
			__( 'Activate Styling', 'visual-composer-multilanguage' ),
			array( $this, $this->option_name . '_styling_cb' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_styling' )
		);

		// Google API Key
		add_settings_field(
			$this->option_name . '_googleapikey',
			__( 'Google Cloud Translate API Key', 'visual-composer-multilanguage' ),
			array( $this, $this->option_name . '_googleapikey_cb' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_googleapikey' )
		);

		register_setting( $this->plugin_name, $this->option_name . '_languages', array(
			$this,
			$this->option_name . '_sanitize_languages'
		) );
		register_setting( $this->plugin_name, $this->option_name . '_default_language', array(
			$this,
			$this->option_name . '_sanitize_default_language'
		) );
		register_setting( $this->plugin_name, $this->option_name . '_switcher', array(
			$this,
			$this->option_name . '_sanitize_switcher'
		) );
		register_setting( $this->plugin_name, $this->option_name . '_autotranslate', array(
			$this,
			$this->option_name . '_sanitize_autotranslate'
		) );
		register_setting( $this->plugin_name, $this->option_name . '_styling', array(
			$this,
			$this->option_name . '_sanitize_styling'
		) );
		register_setting( $this->plugin_name, $this->option_name . '_googleapikey', array(
			$this,
			$this->option_name . '_googleapikey_styling'
		) );


	}

	/**
	 * Render the text input for possible languages
	 *
	 * @since  1.0.0
	 */
	public function visual_composer_multilanguage_languages_cb() {
		$languages = get_option( $this->option_name . '_languages' );
		?>
        <fieldset>
            <input type="text" name="<?php echo $this->option_name . '_languages' ?>"
                   id="<?php echo $this->option_name . '_languages' ?>"
                   value="<?php echo get_option( $this->option_name . '_languages' ) ?>"
                   placeholder="<?php _e( 'English', 'visual-composer-multilanguage' ); ?>"/>
        </fieldset>
		<?php
	}

	/**
	 * Render the text input for default language
	 *
	 * @since  1.0.0
	 */
	public function visual_composer_multilanguage_default_language_cb() {
		?>
        <fieldset>
            <input type="text" name="<?php echo $this->option_name . '_default_language' ?>"
                   id="<?php echo $this->option_name . '_default_language' ?>"
                   value="<?php echo get_option( $this->option_name . '_default_language' ) ?>"
                   placeholder="<?php _e( 'English', 'visual-composer-multilanguage' ); ?>"/>
        </fieldset>
		<?php
	}

	/**
	 * Render the checkbox for adding language switcher
	 *
	 * @since  1.0.0
	 */
	public function visual_composer_multilanguage_switcher_cb() {
		$switcher = get_option( $this->option_name . '_switcher' );
		?>
        <fieldset>
            <label>
                <input type="checkbox" name="<?php echo $this->option_name . '_switcher' ?>"
                       id="<?php echo $this->option_name . '_switcher' ?>"
                       value="switcher" <?php checked( $switcher, 'switcher' ); ?>
            </label>
        </fieldset>
		<?php
	}

	/**
	 * Render the checkbox for auto translations
	 *
	 * @since  1.0.0
	 */
	public function visual_composer_multilanguage_autotranslate_cb() {
		$autotranslate = get_option( $this->option_name . '_autotranslate' );
		?>
        <fieldset>
            <label>
                <input type="checkbox" name="<?php echo $this->option_name . '_autotranslate' ?>"
                       id="<?php echo $this->option_name . '_autotranslate' ?>"
                       value="autotranslate" <?php checked( $autotranslate, 'autotranslate' ); ?>
            </label>
        </fieldset>
		<?php
	}

	/**
	 * Render the checkbox for styling
	 *
	 * @since  1.0.0
	 */
	public function visual_composer_multilanguage_styling_cb() {
		$styling = get_option( $this->option_name . '_styling' );
		?>
        <fieldset>
            <label>
                <input type="checkbox" name="<?php echo $this->option_name . '_styling' ?>"
                       id="<?php echo $this->option_name . '_styling' ?>"
                       value="styling" <?php checked( $styling, 'styling' ); ?>
            </label>
        </fieldset>
		<?php
	}

	/**
	 * Render the text input for Google API Key
	 *
	 * @since  1.0.0
	 */
	public function visual_composer_multilanguage_googleapikey_cb() {
		$googleapikey = get_option( $this->option_name . '_googleapikey' );
		?>
        <fieldset>
            <input type="text" name="<?php echo $this->option_name . '_googleapikey' ?>"
                   id="<?php echo $this->option_name . '_googleapikey' ?>"
                   value="<?php echo get_option( $this->option_name . '_googleapikey' ) ?>"
                   placeholder="<?php _e( 'API KEY', 'visual-composer-multilanguage' ); ?>"/>
        </fieldset>
		<?php
	}

	/**
	 * Render the text for the general section
	 *
	 * @since  1.0.0
	 */
	public function visual_composer_multilanguage_general_cb() {
		echo '<p>' . __( 'List languages you would like supported, separated by a comma.', 'visual-composer-multilanguage' ) . '</p>';
	}

	/**
	 * Render the options page for plugin
	 *
	 * @since  1.0.0
	 */
	public function display_options_page() {
		include_once 'partials/visual-composer-multilanguage-admin-display.php';
	}

}
