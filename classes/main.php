<?php
namespace WPMN;
use WPMN\Shortcodes\Shortcode_Factory;

/**
 * The purpose of the main class is to init all the plugin base code like :
 *  - Taxonomies
 *  - Post types
 *  - Shortcodes
 *  - Posts to posts relations etc.
 *  - Loading the text domain
 *
 * Class Main
 * @package WPMN
 */
class Main {
	/**
	 * Use the trait
	 */
	use Singleton;

	protected function init() {
		add_action( 'init', array( $this, 'init_translations' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_marginotes_lib' ) );
		add_action( 'init', array( $this, 'init_shortcodes' ) );
	}

	/**
	 * Load the plugin translation
	 */
	public static function init_translations() {
		// Load translations
		load_plugin_textdomain( WPMN_TXTDOMAIN, false, WPMN_PLUGIN_DIRNAME . '/languages' );
	}

	/**
	 * Load margin notes script on singular tpl
	 */
	public function enqueue_marginotes_lib() {
		$marginotes_registration = wp_register_script( 'margin-notes', WPMN_URL . 'assets/js/vendor/marginotes.js', array( 'jquery' ), false, true);
		if ( false === $marginotes_registration ) {
			trigger_error( __( 'WP Margin Notes : wp_register_script fails to register assets/js/vendor/marginotes.js', WPMN_TXTDOMAIN ) );
		}

		$script_registration = wp_register_script( 'wpmn', WPMN_URL . 'assets/js/script.js', array( 'jquery', 'margin-notes' ), false, true);
		if ( false === $script_registration ) {
			trigger_error( __( 'WP Margin Notes : wp_register_script fails to register assets/js/script.js', WPMN_TXTDOMAIN ) );
		}

		// Load the script only in singular tpl (pages, posts, cpts)
		if ( is_singular() ) {
			wp_enqueue_script( 'margin-notes' );
			wp_enqueue_script( 'wpmn' );
		}
	}

	public static function init_shortcodes() {
		Shortcode_Factory::register( 'Margin_Notes' ); // Initialise the shortcode
	}
}