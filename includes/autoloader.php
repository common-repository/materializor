<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

spl_autoload_register(
    function ( $class ) {
        $namespace = MATERIALIZOR_NAMESPACE . '\\';
        if ( 0 !== strpos( $class, $namespace ) ) {
            return;
        }

        $class_name = str_replace( $namespace, '', $class );
        $class_name = str_replace( MATERIALIZOR_CLASS_PREFIX, '', $class_name );
        $class_file = str_replace( '\\', '/', $class_name ) . '.php';
        $filepath   = MATERIALIZOR_AUTOLOAD_PATH . $class_file;

        include $filepath;
    }
);