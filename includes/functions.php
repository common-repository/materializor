<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! function_exists( 'materializor_add_option' ) ) {
    /**
     * @param string $option
     * @param mixed $value
     * @param string $deprecated
     * @param string|bool $autoload
     *
     * @return bool
     */
    function materializor_add_option(string $option, $value = '', $deprecated = '', $autoload = false ) {
        return add_option( 'materializor_' . $option, $value, $deprecated, $autoload );
    }
}

if ( ! function_exists( 'materializor_get_option' ) ) {
    /**
     * @param string $option
     * @param mixed $default
     *
     * @return mixed
     */
    function materializor_get_option( string $option, $default = false ) {
        $option = 'materializor_' . $option;
        return get_option( $option, $default );
    }
}

if ( ! function_exists( 'materializor_update_option' ) ) {
    /**
     * @param string $option
     * @param mixed $value
     *
     * @return bool
     */
    function materializor_update_option( string $option, $value ) {
        $option = 'materializor_' . $option;
        return update_option( $option, $value );
    }
}

if ( ! function_exists( 'materializor_delete_option' ) ) {
    /**
     * @param string $option
     *
     * @return bool
     */
    function materializor_delete_option( string $option ) {
        $option = 'materializor_' . $option;
        return delete_option( $option );
    }
}

if ( ! function_exists( 'materializor_get_transient' ) ) {
    /**
     * @param string $transient
     *
     * @return mixed
     */
    function materializor_get_transient( string $transient ) {
        $transient = 'materializor_' . $transient;
        return get_transient( $transient );
    }
}

if ( ! function_exists( 'materializor_set_transient' ) ) {
    /**
     * @param string $transient
     * @param mixed $value
     * @param int $expiration
     *
     * @return bool
     */
    function materializor_set_transient( string $transient, $value, int $expiration = 0 ) {
        $transient = 'materializor_' . $transient;
        return set_transient( $transient, $value, $expiration );
    }
}

if ( ! function_exists( 'materializor_delete_transient' ) ) {
    /**
     * @param string $transient
     *
     * @return mixed
     */
    function materializor_delete_transient( string $transient ) {
        $transient = 'materializor_' . $transient;
        return get_transient( $transient );
    }
}

if ( ! function_exists( 'materializor_assets_path' ) ) {
    /**
     * @param string $path
     *
     * @return string
     */
    function materializor_assets_path( string $path ) {
        return MATERIALIZOR_ASSETS_PATH . $path;
    }
}

if ( ! function_exists( 'materializor_assets_url' ) ) {
    /**
     * @param string $path
     *
     * @return string
     */
    function materializor_assets_url( string $path ) {
        return MATERIALIZOR_ASSETS_URL . $path;
    }
}

if ( ! function_exists( 'materializor_css_path' ) ) {
    /**
     * @param string $path
     *
     * @return string
     */
    function materializor_css_path( string $path ) {
        return MATERIALIZOR_CSS_PATH . $path;
    }
}

if ( ! function_exists( 'materializor_css_url' ) ) {
    /**
     * @param string $path
     *
     * @return string
     */
    function materializor_css_url( string $path ) {
        return MATERIALIZOR_CSS_URL . $path;
    }
}

if ( ! function_exists( 'materializor_js_path' ) ) {
    /**
     * @param string $path
     *
     * @return string
     */
    function materializor_js_path( string $path ) {
        return MATERIALIZOR_JS_PATH . $path;
    }
}

if ( ! function_exists( 'materializor_js_url' ) ) {
    /**
     * @param string $path
     *
     * @return string
     */
    function materializor_js_url( string $path ) {
        return MATERIALIZOR_JS_URL . $path;
    }
}

if ( ! function_exists( 'materializor_font_path' ) ) {
    /**
     * @param string $path
     *
     * @return string
     */
    function materializor_font_path( string $path ) {
        return MATERIALIZOR_FONT_PATH . $path;
    }
}

if ( ! function_exists( 'materializor_font_url' ) ) {
    /**
     * @param string $path
     *
     * @return string
     */
    function materializor_font_url( string $path ) {
        return MATERIALIZOR_FONT_URL . $path;
    }
}

if ( ! function_exists( 'materializor_vendor_path' ) ) {
    /**
     * @param string $path
     *
     * @return string
     */
    function materializor_vendor_path( string $path ) {
        return MATERIALIZOR_VENDOR_PATH . $path;
    }
}

if ( ! function_exists( 'materializor_vendor_url' ) ) {
    /**
     * @param string $path
     *
     * @return string
     */
    function materializor_vendor_url( string $path ) {
        return MATERIALIZOR_VENDOR_URL . $path;
    }
}

if ( ! function_exists( 'materializor_add_inline_script' ) ) {
    /**
     * @param string $handle
     * @param string $variable
     * @param mixed $data
     * @param string $position
     *
     * @return bool
     */
    function materializor_add_inline_script( string $handle, string $variable, $data, $position = 'before' ) {
        $data_string = '/* <![CDATA[ */';
        $data_string .= "\n";
        $data_string .= sprintf( 'window.%s = %s;', $variable, wp_json_encode( $data ) );
        $data_string .= "\n";
        $data_string .= '/* ]]> */';

        return wp_add_inline_script( $handle, $data_string, $position );
    }
}

if ( ! function_exists( 'materializor_query_rfc3986' ) ) {
    /**
     * @param array $query
     *
     * @return string
     */
    function materializor_query_rfc3986( $query ) {
        return http_build_query( $query, null, '&', PHP_QUERY_RFC3986 );
    }
}

if ( ! function_exists( 'materializor_is_edit_mode' ) ) {
    /**
     * @return bool
     */
    function materializor_is_edit_mode() {
        return class_exists( '\Elementor\Plugin' ) && \Elementor\Plugin::$instance->editor->is_edit_mode();
    }
}

if ( ! function_exists( 'materializor_is_preview_mode' ) ) {
	/**
	 * @return bool
	 */
	function materializor_is_preview_mode() {
		return class_exists( '\Elementor\Plugin' ) && \Elementor\Plugin::$instance->preview->is_preview_mode();
	}
}

if ( ! function_exists( 'materializor_kses_basic' ) ) {
    /**
     * @param string $string
     * @return string
     */
    function materializor_kses_basic( $string ) {
        $allowed_html = [
            'b' => [],
            'u' => [],
            'i' => [],
            'strong' => [],
            'em' => [],
            'small' => [],
            'big' => [],
            'del' => [],
            'mark' => [],
            'ins' => [],
            'sub' => [],
            'sup' => [],
        ];

        return wp_kses( $string, $allowed_html );
    }
}