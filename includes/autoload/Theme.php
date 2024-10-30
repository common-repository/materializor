<?php

namespace Materializor;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}


/**
 * Class MTZR_Theme
 * @package Materializor
 * @since 1.0.0
 */
final class MTZR_Theme
{
    /**
     * @param array $rgb
     *
     * @return string
     */
    public function hex_string( array $rgb )
    {
        return vsprintf( '#%02x%02x%02x', $rgb );
    }

    /**
     * @param array $rgb
     *
     * @return string
     */
    public function rgb_string( array $rgb )
    {
        return vsprintf( 'rgb(%d,%d,%d)', $rgb );
    }

    /**
     * @param array $rgba
     *
     * @return string
     */
    public function rgba_string( array $rgba )
    {
        return vsprintf( 'rgba(%d,%d,%d,%.2f)', $rgba );
    }

    /**
     * @param string $hex
     *
     * @return array|false
     */
    public function hex_string_to_rgb( string $hex )
    {
        $hex = str_replace( '#', '', $hex );
        if ( 3 === strlen( $hex ) ) {
            $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
        }
        if ( preg_match( '/^(?<r>[a-f\d]{2})(?<g>[a-f\d]{2})(?<b>[a-f\d]{2})$/i', $hex, $matches ) ) {
            return [
                hexdec( $matches['r'] ),
                hexdec( $matches['g'] ),
                hexdec( $matches['b'] ),
            ];
        }
        return false;
    }

    /**
     * @param array $rgb
     * @param float $alpha
     *
     * @return array
     */
    public function rgba( array $rgb, float $alpha )
    {
        $rgb[3] = $alpha;
        return $rgb;
    }


    /**
     * @param array $rgb
     *
     * @return array
     */
    public function rgb_to_hsl( array $rgb )
    {
        $r   = $rgb[0] / 255;
        $g   = $rgb[1] / 255;
        $b   = $rgb[2] / 255;
        $min = min( $r, $g, $b );
        $max = max( $r, $g, $b );
        $l   = ( $max + $min ) / 2;

        if ( $max === $min ) {
            $h = $s = 0;
        } else {
            $d = $max - $min;
            $s = $l > 0.5 ? $d / ( 2 - $max - $min ) : $d / ($max + $min);

            if ( $max === $r ) {
                $h = ( $g - $b ) / $d + ( $g < $b ? 6 : 0 );
            } elseif ( $max === $g ) {
                $h = ( $b - $r ) / $d + 2;
            } elseif ( $max === $b ) {
                $h = ( $r - $g ) / $d + 4;
            } else {
                $h = $max;
            }
            $h = $h / 6;
        }

        return [
            round( $h * 360 ),
            round( $s * 100 ),
            round( $l * 100 ),
        ];
    }

    /**
     * @param float $p
     * @param float $q
     * @param float $t
     *
     * @return mixed
     */
    private function hue_to_rgb( float $p, float $q, float $t )
    {
        if ( $t < 0 ) {
            $t++;
        }
        if ( $t > 1 ) {
            $t--;
        }
        if ( $t < 1/6 ) {
            return $p + ( $q - $p ) * 6 * $t;
        }
        if ( $t < 1/2 ) {
            return $q;
        }
        if ( $t < 2/3 ) {
            return $p + ( $q - $p ) * ( 2/3 - $t ) * 6;
        }
        return $p;
    }

    /**
     * @param array $hsl
     *
     * @return int[]
     */
    public function hsl_to_rgb( array $hsl )
    {
        $h = $hsl[0] / 360;
        $s = $hsl[1] / 100;
        $l = $hsl[2] / 100;

        if ( 0 === $s ) {
            $r = $g = $b = $l;
        } else {
            $q = $l < 0.5 ? $l * (1 + $s) : $l + $s - $l * $s;
            $p = 2 * $l - $q;
            $r = $this->hue_to_rgb( $p, $q, $h + 1/3 );
            $g = $this->hue_to_rgb( $p, $q, $h );
            $b = $this->hue_to_rgb( $p, $q, $h - 1/3 );
        }

        return [
            round( $r * 255 ),
            round( $g * 255 ),
            round( $b * 255 ),
        ];
    }

    /**
     * @param array $hsl
     * @param int $percent
     *
     * @return array
     */
    public function lighten( array $hsl, int $percent )
    {
        $hsl[2] = min( 100, max( 0, $hsl[2] + $percent ) );
        return $hsl;
    }

    /**
     * @param array $hsl
     * @param int $percent
     *
     * @return array
     */
    public function darken( array $hsl, int $percent )
    {
        $hsl[2] = min( 100, max( 0, $hsl[2] - $percent ) );
        return $hsl;
    }

    /**
     * @param array $hsl
     * @param int $percent
     *
     * @return array
     */
    public function saturate( array $hsl, int $percent )
    {
        $hsl[1] = min( 100, max( 0, $hsl[1] + $percent ) );
        return $hsl;
    }

    /**
     * @param array $hsl
     * @param int $percent
     *
     * @return array
     */
    public function desaturate( array $hsl, int $percent )
    {
        $hsl[1] = min( 100, max( 0, $hsl[1] - $percent ) );
        return $hsl;
    }

    /**
     * @return array
     */
    public function get_default_options()
    {
        return [
            'main_color' => [ 0, 151, 167 ],
            'link_color' => [ 30, 136, 229 ],
        ];
    }

    /**
     * @param null|string $key
     *
     * @return mixed
     */
    public function get_options( $key = null )
    {
        $default  = $this->get_default_options();
        $options = materializor_get_option( 'theme' );

        if ( is_array( $options ) ) {
            $options =  array_merge( $default, $options );
        } else {
            $options = $default;
        }

        if ( is_string( $key ) && array_key_exists( $key, $options ) ) {
            return $options[ $key ];
        }

        return $options;
    }

    /**
     * @return mixed
     */
    public function get_options_values( $key = null )
    {
        $options = $this->get_options();

        $values = [
            'main_color' => $this->hex_string( $options['main_color'] ),
            'link_color' => $this->hex_string( $options['link_color'] ),
        ];

        if ( is_string( $key ) ) {
            return array_key_exists( $key, $values ) ? $values[ $key ] : null;
        }

        return $values;
    }

    /**
     * @param array $new_options
     */
    public function save_options( array $new_options )
    {
        $options = [];
        $old_options = $this->get_options();

        $colors = [
            'main_color',
            'link_color',
        ];
        foreach ( $colors as $color ) {
            if ( ! empty( $new_options[ $color ] ) ) {
                $options[ $color ] = $this->hex_string_to_rgb( $new_options[ $color ] );
            }
            if ( empty( $options[ $color ] ) ) {
                $options[ $color ] = $old_options[ $color ];
            }
        }

        materializor_update_option( 'theme', $options );
    }

    /**
     * @return array
     */
    public function get_css_variables()
    {
        $options  = $this->get_options();
        $main_rgb = $options['main_color'];
        $main_hsl = $this->rgb_to_hsl( $main_rgb );
        $link_rgb = $options['link_color'];
        $link_hsl = $this->rgb_to_hsl( $link_rgb );

        $vars['main-color']     = $this->hex_string( $main_rgb );
        $vars['main-color-a25'] = $this->rgba_string( $this->rgba( $main_rgb, 0.25 ) );
        $vars['main-color-a60'] = $this->rgba_string( $this->rgba( $main_rgb, 0.6 ) );
        $vars['main-color-a85'] = $this->rgba_string( $this->rgba( $main_rgb, 0.85 ) );
        $vars['main-color-l05'] = $this->hex_string( $this->hsl_to_rgb( $this->lighten( $main_hsl, 5 ) ) );
        $vars['main-color-l40'] = $this->hex_string( $this->hsl_to_rgb( $this->lighten( $main_hsl, 40 ) ) );
        $vars['main-color-l55'] = $this->hex_string( $this->hsl_to_rgb( $this->lighten( $main_hsl, 55 ) ) );
        $vars['main-color-d10'] = $this->hex_string( $this->hsl_to_rgb( $this->darken( $main_hsl, 10 ) ) );
        $vars['main-color-d15'] = $this->hex_string( $this->hsl_to_rgb( $this->darken( $main_hsl, 15 ) ) );

        $main_l25_ds25_hsl = $this->desaturate( $this->lighten( $main_hsl, 25 ), 25 );
        $vars['main-color-l25-ds25'] = $this->hex_string( $this->hsl_to_rgb( $main_l25_ds25_hsl ) );

        $vars['link']     = $this->hex_string( $link_rgb );
        $vars['link-l20'] = $this->hex_string( $this->hsl_to_rgb( $this->lighten( $link_hsl, 20 ) ) );

        return $vars;
    }

    /**
     * @return string
     */
    public function get_inline_style()
    {
        $variables = $this->get_css_variables();

        $style = ':root{';
        foreach ( $variables as $name => $value ) {
            $style .= sprintf( '--mtz-%s:%s;', $name, $value );
        }
        $style .= '}';

        return $style;
    }

}