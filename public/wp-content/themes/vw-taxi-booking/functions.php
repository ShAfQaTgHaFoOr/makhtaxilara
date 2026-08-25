<?php
/**
 * VW Taxi Booking functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package VW Taxi Booking
 */

if ( ! defined( 'VW_TAXI_BOOKING_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( 'VW_TAXI_BOOKING_VERSION', wp_get_theme()->get( 'Version' ) );
}

if ( ! function_exists( 'vw_taxi_booking_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function vw_taxi_booking_setup() {

		load_theme_textdomain( 'vw-taxi-booking', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		add_theme_support( 'align-wide' );

		add_theme_support( 'woocommerce' );

		// Add support for block styles.
		add_theme_support( 'wp-block-styles' );

		// Enqueue editor styles.
		add_editor_style( 'style.css' );

		// Add support for core custom logo.
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 192,
				'width'       => 192,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);

		// Enqueue editor styles.
		// add_editor_style( 'style.css' );

		// Experimental support for adding blocks inside nav menus
		add_theme_support( 'block-nav-menus' );

		// Add support for experimental link color control.
		add_theme_support( 'experimental-link-color' );
	}
endif;
add_action( 'after_setup_theme', 'vw_taxi_booking_setup' );

/**
 * Enqueue scripts and styles.
 */
function vw_taxi_booking_scripts() {
	wp_enqueue_style('vw-taxi-booking-style', get_stylesheet_uri(), array() );
	wp_enqueue_script( 'jquery-wow', esc_url(get_template_directory_uri()) . '/js/wow.js', array('jquery') );
	wp_enqueue_style( 'animate-css', esc_url(get_template_directory_uri()).'/css/animate.css' );
	wp_enqueue_style( 'owl.carousel-style', get_template_directory_uri().'/css/owl.carousel.css' );
	wp_enqueue_script( 'owl.carousel-js', get_template_directory_uri(). '/js/owl.carousel.js', array('jquery') ,'',true);
	wp_enqueue_script( 'vw-taxi-booking-custom-scripts', get_template_directory_uri() . '/js/custom.js', array('jquery'),'' ,true );
	wp_style_add_data( 'vw-taxi-booking-style', 'rtl', 'replace' );
}
add_action( 'wp_enqueue_scripts', 'vw_taxi_booking_scripts' );

/**
 * Enqueue block editor style
 */
function vw_taxi_booking_block_editor_styles() {
	wp_enqueue_style( 'vw-taxi-booking-block-patterns-style-editor', get_theme_file_uri( '/css/block-editor.css' ), false, '1.0', 'all' );	
}
add_action( 'enqueue_block_editor_assets', 'vw_taxi_booking_block_editor_styles' );

function vw_taxi_booking_init_setup() {
	define('VW_TAXI_BOOKING_BUY_NOW',__('https://www.vwthemes.com/products/taxi-wordpress-theme','vw-taxi-booking'));
	define('VW_TAXI_BOOKING_SUPPORT',__('https://wordpress.org/support/theme/vw-taxi-booking/','vw-taxi-booking'));
	define('VW_TAXI_BOOKING_REVIEW',__('https://wordpress.org/support/theme/vw-taxi-booking/reviews/','vw-taxi-booking'));
	define('VW_TAXI_BOOKING_LIVE_DEMO',__('https://www.vwthemes.net/vw-taxi-booking-pro/','vw-taxi-booking'));
	define('VW_TAXI_BOOKING_PRO_DOC',__('https://preview.vwthemesdemo.com/docs/vw-taxi-booking-pro/','vw-taxi-booking'));
	define('VW_TAXI_BOOKING_FREE_DOC',__('https://preview.vwthemesdemo.com/docs/free-vw-taxi-booking/','vw-taxi-booking'));
	define('VW_TAXI_BOOKING_THEME_BUNDLE_BUY_NOW',__('https://www.vwthemes.com/products/wp-theme-bundle','vw-taxi-booking'));
	define('VW_TAXI_BOOKING_THEME_BUNDLE_DOC',__('https://preview.vwthemesdemo.com/docs/theme-bundle/','vw-taxi-booking'));
	
	// Add block patterns
	require get_template_directory() . '/inc/block-patterns.php';
	
	/**
	 * Section Pro
	 */
	require get_template_directory() . '/inc/section-pro/customizer.php';

	/**
	 * TGM
	 */
	require_once get_template_directory() . '/inc/tgm/plugin-activation.php';

	/**
	 * notice
	 */
	require get_template_directory() . '/inc/core/activation-notice.php';

	/**
	 * Load core file.
	 */
	require_once get_template_directory() . '/inc/core/theme-info.php';

	require_once get_template_directory() . '/inc/core/template-functions.php';
	
}
add_action( 'after_setup_theme', 'vw_taxi_booking_init_setup' );

/* Enqueue admin-notice-script js */
add_action('admin_enqueue_scripts', function ($hook) {
    if ($hook !== 'appearance_page_vw-taxi-booking') return;

    wp_enqueue_script('admin-notice-script', get_template_directory_uri() . 'inc/core/js/admin-notice-script.js', ['jquery'], null, true);
    wp_localize_script('admin-notice-script', 'pluginInstallerData', [
        'ajaxurl'     => admin_url('admin-ajax.php'),
        'nonce'       => wp_create_nonce('install_plugin_nonce'), // Match this with PHP nonce check
        'redirectUrl' => admin_url('themes.php?page=vw-taxi-booking-info'),
    ]);
});

add_action('wp_ajax_check_plugin_activation', function () {
    if (!isset($_POST['plugin']) || empty($_POST['plugin'])) {
        wp_send_json_error(['message' => 'Missing plugin identifier']);
    }

    include_once ABSPATH . 'wp-admin/includes/plugin.php';

    // Map plugin identifiers to their main files
    $vw_taxi_booking_plugin_map = [
        'woocommerce'                => 'woocommerce/woocommerce.php',
        'taxi-booking-manager'       => 'ecab-taxi-booking-manager/MPTBM_Plugin.php',
        'currency_switcher'          => 'currency-switcher-woocommerce/currency-switcher-woocommerce.php',
        'gtranslate'               	 => 'gtranslate/gtranslate.php',
        'ibtana'               		 => 'ibtana-visual-editor/plugin.php',
    ];

    $vw_taxi_booking_requested_plugin = sanitize_text_field($_POST['plugin']);

    if (!isset($vw_taxi_booking_plugin_map[$vw_taxi_booking_requested_plugin])) {
        wp_send_json_error(['message' => 'Invalid plugin']);
    }

    $vw_taxi_booking_plugin_file = $vw_taxi_booking_plugin_map[$vw_taxi_booking_requested_plugin];
    $vw_taxi_booking_is_active   = is_plugin_active($vw_taxi_booking_plugin_file);

    wp_send_json_success(['active' => $vw_taxi_booking_is_active]);
});
add_filter( 'woocommerce_enable_setup_wizard', '__return_false' );