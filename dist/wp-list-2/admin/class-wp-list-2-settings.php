<?php
/**
 * Interface with the WP Settings Framework.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Wp_List_2
 */

/**
 * Settings Interface class.
 */
class Wp_List_2_Settings {
	/**
	 * Plugin Path
	 *
	 * @var String
	 */
	private $plugin_path;

	/**
	 * WordPress Settings Framework
	 *
	 * @var WordPressSettingsFramework
	 */
	private $wpsf;

	/**
	 * Constructor.
	 */
	public function __construct() {
		// Include and create a new WordPressSettingsFramework Object.
		require_once WP_LIST_2_PATH . 'vendor/WordPress-Settings-Framework/wp-settings-framework.php';
		$this->wpsf = new WordPressSettingsFramework( WP_LIST_2_PATH . 'admin/settings.php', 'plugin_name' );

		// Add admin menu.
		add_action( 'admin_menu', array( $this, 'add_settings_page' ), 20 );

		// Settings validation.
		add_filter( $this->wpsf->get_option_group() . '_settings_validate', array( &$this, 'validate_settings' ) );
	}

	/**
	 * Add settings page.
	 */
	public function add_settings_page() {
		$this->wpsf->add_settings_page(
			array(
				'parent_slug' => 'woocommerce',
				'page_title'  => __( 'WP List creator 2', 'wp-list-2' ),
				'menu_title'  => __( 'WP List creator 2', 'wp-list-2' ),
				'capability'  => 'manage_woocommerce',
			)
		);
	}

	/**
	 * Validate settings.
	 *
	 * @param array $input The input to be processed.
	 *
	 * @return array
	 */
	public function validate_settings( $input ) {
		// Do your settings validation here.
		// Same as $sanitize_callback from http://codex.wordpress.org/Function_Reference/register_setting.
		return $input;
	}
}
