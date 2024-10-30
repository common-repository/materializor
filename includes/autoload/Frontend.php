<?php

namespace Materializor;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use Materializor\Assets\MTZR_Material_Design_Icons;
use Materializor\Assets\MTZR_Roboto;

/**
 * Class MTZR_Frontend
 * @package Materializor
 * @since 1.0.0
 */
final class MTZR_Frontend
{
    /**
     * @var MTZR_Theme
     */
    public $theme;

    /**
     * MTZR_Frontend constructor.
     */
    public function __construct()
    {
        $this->theme = new MTZR_Theme();

        $this->enqueue_fonts();

        add_action( 'elementor/frontend/after_register_styles', [ $this, 'enqueue_styles' ] );
        add_action( 'elementor/frontend/before_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
    }

    /**
     *
     */
    private function enqueue_fonts()
    {
        if ( MTZR_Material_Design_Icons::is_enabled() ) {
            \Elementor\Plugin::$instance->frontend->enqueue_font( MTZR_Material_Design_Icons::NAME );
        }
    }

    /**
     *
     */
    public function enqueue_styles()
    {
        $settings = MTZR_Plugin::$instance->get_settings();

        MTZR_Roboto::register_style( $settings['roboto_source'], true );

        wp_enqueue_style(
            'materializor',
            materializor_css_url( 'frontend/materializor.css' ),
            [],
            MATERIALIZOR_VERSION
        );

        wp_add_inline_style( 'materializor', $this->theme->get_inline_style() );
    }

    /**
     *
     */
    public function enqueue_scripts()
    {
        wp_register_script(
            'jquery-easing',
            materializor_vendor_url( 'jquery-easing/jquery.easing.min.js' ),
            [ 'jquery' ],
            '1.4.1',
            true
        );

        wp_register_script(
            'hammer',
            materializor_vendor_url( 'hammerjs/hammer.min.js' ),
            [ 'jquery' ],
            '2.0.8',
            true
        );

        wp_register_script(
            'velocity',
            materializor_vendor_url( 'velocity/velocity.min.js' ),
            [ 'jquery' ],
            '1.5.2',
            true
        );

        wp_register_script(
            'materializor',
            materializor_js_url( 'dist/frontend/materializor.js' ),
            [
                'jquery-easing',
                'hammer',
                'velocity',
            ],
            MATERIALIZOR_VERSION,
            true
        );

        wp_enqueue_script(
            'materializor-widgets',
            materializor_js_url( 'dist/frontend/widgets.js' ),
            [
                'materializor',
                'elementor-frontend',
            ],
            MATERIALIZOR_VERSION,
            true
        );
    }

}