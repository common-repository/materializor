<?php

namespace Materializor\Assets;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use Elementor\Utils;
use Materializor\MTZR_Plugin;

/**
 * Class MTZR_Material_Icons
 * @package Materializor
 * @since 1.0.0
 */
final class MTZR_Material_Design_Icons
{
    const VERSION = '7.0.96';

    const NAME = 'mdi';

    /**
     * @return array[]
     */
    public static function get_icon_types()
    {
        $libraries['mdi'] = [
            'name' => 'mdi',
            'label' => esc_html__( 'Material Design Icons', 'materializor' ),
            'url' => self::get_url( 'css/materialdesignicons.min.css' ),
            'enqueue' => [
                self::get_url( 'css/materialdesignicons.min.css' ),
            ],
            'prefix' => 'mdi-',
            'displayPrefix' => '',
            'labelIcon' => 'fab fa-google',
            'ver' => self::VERSION,
            'fetchJson' => self::get_url( 'icons.js' ),
            'native' => false,
            'render_callback' => [ __CLASS__, 'render_icon_html' ],
        ];

        return $libraries;
    }

    /**
     * @param string $path
     *
     * @return string
     */
    public static function get_url( string $path = '' )
    {
        return materializor_vendor_url( 'material-design-icons/' . $path );
    }

    /**
     * @return bool
     */
    public static function is_enabled()
    {
        return MTZR_Plugin::$instance->get_settings( 'mdi_enabled' );
    }
    
}