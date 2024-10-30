<?php

namespace Materializor\Assets;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Class MTZR_Roboto
 * @package Materializor\Modules
 * @since 1.0.0
 */
final class MTZR_Roboto
{
    /**
     * @return string[]
     */
    public static function get_sources()
    {
        return [
            'disabled' => esc_html__( 'Disabled', 'materializor' ),
            'local'    => esc_html__( 'Local', 'materializor' ),
            'google'   => esc_html__( 'Google Fonts', 'materializor' ),
        ];
    }

    /**
     * @param string $source
     * @param bool $enqueue
     *
     * @return string
     */
    public static function register_style( string $source = 'local', bool $enqueue = false )
    {
        if ( 'local' === $source ) {
            $url = materializor_css_url( 'roboto.css' );
            $handle = 'roboto';
        } elseif ( 'google' === $source ) {
            $url = 'https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap';
            // as registered in \Elementor\Editor
            $handle = 'google-font-roboto';
        } else {
            return false;
        }

        wp_register_style( $handle, $url, [], null );

        if ( $enqueue ) {
            wp_enqueue_style( $handle );
        }

        return $handle;
    }


}