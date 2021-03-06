<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// No need to proceed if Kirki already exists.
if ( class_exists( 'Kirki' ) ) {
	return;
}

// Include the autoloader.
require_once dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'class-kirki-autoload.php';
new Kirki_Autoload();

if ( ! defined( 'KIRKI_PLUGIN_FILE' ) ) {
	define( 'KIRKI_PLUGIN_FILE', __FILE__ );
}


// Make sure the path is properly set.
Kirki::$path = wp_normalize_path( dirname( __FILE__ ) );
Kirki_Init::set_url();

new Kirki_Controls();

if ( ! function_exists( 'Kirki' ) ) {
	/**
	 * Returns an instance of the Kirki object.
	 */
	function kirki() {
		$kirki = Kirki_Toolkit::get_instance();
		return $kirki;
	}
}

// Start Kirki.
global $kirki;
$kirki = kirki();

// Instantiate the modules.
$kirki->modules = new Kirki_Modules();

// Instantiate classes.
new Kirki();
new Kirki_L10n();

Kirki::$url = get_template_directory_uri() . '/inc/customizer-controls';
Kirki::$path = get_template_directory_uri() . '/inc/customizer-controls';

// Include deprecated functions & methods.
require_once wp_normalize_path( dirname( __FILE__ ) . '/deprecated/deprecated.php' );

// Include the ariColor library.
require_once wp_normalize_path( dirname( __FILE__ ) . '/lib/class-aricolor.php' );

// Add an empty config for global fields.
Kirki::add_config( '' );

$custom_config_path = dirname( __FILE__ ) . '/custom-config.php';
$custom_config_path = wp_normalize_path( $custom_config_path );
if ( file_exists( $custom_config_path ) ) {
	require_once $custom_config_path;
}

// Add theme controls
require_once wp_normalize_path( dirname( __FILE__ ) . '/theme-controls.php' );
