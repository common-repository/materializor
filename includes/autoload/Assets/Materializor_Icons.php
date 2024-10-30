<?php

namespace Materializor\Assets;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Class MTZR_Materializor_Icons
 * @package Materializor\Modules
 * @since 1.0.0
 */
final class MTZR_Materializor_Icons
{
    const VERSION = '1.0.0';

    const HANDLE = 'materializor-icons';

    /**
     * @param bool $enqueue
     *
     * @return string
     */
    public static function register_style( bool $enqueue = false )
    {
        wp_register_style(
            self::HANDLE,
            materializor_css_url( 'materializor-icons.css' ),
            [],
            self::VERSION
        );

        if ( $enqueue ) {
            wp_enqueue_style( self::HANDLE );
        }

        return self::HANDLE;
    }


}