<?php
/*
Plugin Name: Materializor
Plugin URI: https://runcoders.net/materializor
Description: Adds Material Design widgets and icons to your Elementor website
Version: 1.0.3
Author: RunCoders
Author URI: https://runcoders.net
Text Domain: materializor
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( wp_installing() ) {
    return;
}


define( 'MATERIALIZOR_VERSION',         '1.0.3' );
define( 'MATERIALIZOR_NAME',            'materializor' );
define( 'MATERIALIZOR_TITLE',           'Materializor' );
define( 'MATERIALIZOR_NAMESPACE',       'Materializor' );
define( 'MATERIALIZOR_CLASS_PREFIX',    'MTZR_' );
define( 'MATERIALIZOR_INDEX',           __FILE__ );
define( 'MATERIALIZOR_DIR',             plugin_dir_path( __FILE__ ) );
define( 'MATERIALIZOR_INCLUDES_PATH',   trailingslashit( MATERIALIZOR_DIR . 'includes' ) );
define( 'MATERIALIZOR_ADMIN_PATH',      trailingslashit( MATERIALIZOR_INCLUDES_PATH . 'admin' ) );
define( 'MATERIALIZOR_AUTOLOAD_PATH',   trailingslashit( MATERIALIZOR_INCLUDES_PATH . 'autoload' ) );
define( 'MATERIALIZOR_LANGUAGES_PATH',  trailingslashit( MATERIALIZOR_DIR . 'languages' ) );
define( 'MATERIALIZOR_ASSETS_PATH',     trailingslashit( MATERIALIZOR_DIR . 'assets' ) );
define( 'MATERIALIZOR_ASSETS_URL',      trailingslashit( plugins_url( 'assets' , __FILE__ ) ) );
define( 'MATERIALIZOR_CSS_PATH',        trailingslashit( MATERIALIZOR_ASSETS_PATH . 'css' ) );
define( 'MATERIALIZOR_CSS_URL',         trailingslashit( plugins_url( 'assets/css' , __FILE__ ) ) );
define( 'MATERIALIZOR_JS_PATH',         trailingslashit( MATERIALIZOR_ASSETS_PATH . 'js' ) );
define( 'MATERIALIZOR_JS_URL',          trailingslashit( plugins_url( 'assets/js' , __FILE__ ) ) );
define( 'MATERIALIZOR_FONT_PATH',       trailingslashit( MATERIALIZOR_ASSETS_PATH . 'font' ) );
define( 'MATERIALIZOR_FONT_URL',        trailingslashit( plugins_url( 'assets/font' , __FILE__ ) ) );
define( 'MATERIALIZOR_VENDOR_PATH',     trailingslashit( MATERIALIZOR_ASSETS_PATH . 'vendor' ) );
define( 'MATERIALIZOR_VENDOR_URL',      trailingslashit( plugins_url( 'assets/vendor' , __FILE__ ) ) );


if ( ! function_exists('materializor_include') ) {
    function materializor_include($name ) {
        $filepath = MATERIALIZOR_INCLUDES_PATH . $name . '.php';
        include $filepath;
    }
}

materializor_include( 'autoloader' );
materializor_include( 'functions' );

\Materializor\MTZR_Plugin::instance();

