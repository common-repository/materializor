<?php

namespace Materializor;

use Materializor\Assets\MTZR_Material_Design_Icons;
use Materializor\Assets\MTZR_Roboto;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Class MTZR_Plugin
 * @package Materializor
 * @since 1.0.0
 */
final class MTZR_Plugin
{
    const MINIMUM_PHP_VERSION = '7.0.0';

    const MINIMUM_ELEMENTOR_VERSION = '3.0.0';

    /**
     * @var null|self
     */
    public static $instance;

    /**
     * @var MTZR_Frontend
     */
    public $frontend;

    /**
     * @var MTZR_Preview
     */
    public $preview;

    /**
     * @var MTZR_Editor
     */
    public $editor;

    /**
     * @var MTZR_Theme
     */
    public $admin;

    /**
     * MTZR_Plugin constructor.
     */
    private function __construct()
    {
        add_action( 'plugins_loaded', [ $this, 'plugins_loaded' ] );
        add_action( 'after_setup_theme', [ $this, 'add_image_sizes' ] );
        add_action( 'after_setup_theme', [ $this, 'load_textdomain' ] );
    }

    /**
     * @return self
     */
    public static function instance()
    {
        if ( ! self::$instance ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     *
     */
    public function add_image_sizes()
    {
        add_image_size( 'materializor_original', 9999, 9999 );
    }

    /**
     * @return bool
     */
    public function is_compatible()
    {
        if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
            return false;
        }

        if ( ! did_action( 'elementor/loaded' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
            return false;
        }

        if ( ! defined( 'ELEMENTOR_VERSION' ) || ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
            return false;
        }

        return true;
    }

    /**
     *
     */
    public function plugins_loaded()
    {
        if ( $this->is_compatible() ) {
            add_action( 'elementor/init', [ $this, 'init' ] );
        }
    }

    /**
     *
     */
    public function load_textdomain()
    {
        load_theme_textdomain( 'materializor', MATERIALIZOR_LANGUAGES_PATH );
    }

    /**
     *
     */
    public function init()
    {
        $this->frontend = new MTZR_Frontend();
        $this->preview  = new MTZR_Preview();
        $this->editor   = new MTZR_Editor();
        $this->admin    = new MTZR_Admin();

        add_action( 'elementor/elements/categories_registered', [ $this, 'categories_registered' ] );
        add_action( 'elementor/widgets/widgets_registered', [ $this, 'widgets_registered' ] );

        add_filter( 'elementor/icons_manager/additional_tabs', [ $this, 'add_icons_additional_tabs' ] );
    }

    /**
     *
     */
    public function admin_notice_minimum_php_version()
    {
        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }

        $message = sprintf(
            esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'materializor' ),
            '<strong>' . esc_html__( MATERIALIZOR_TITLE, 'materializor' ) . '</strong>',
            '<strong>' . esc_html__( 'PHP', 'materializor' ) . '</strong>',
            self::MINIMUM_PHP_VERSION
        );

        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }

    /**
     *
     */
    public function admin_notice_missing_main_plugin()
    {
        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }

        $message = sprintf(
            esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'materializor' ),
            '<strong>' . esc_html__( MATERIALIZOR_TITLE, 'materializor' ) . '</strong>',
            '<strong>' . esc_html__( 'Elementor', 'materializor' ) . '</strong>'
        );

        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }

    /**
     *
     */
    public function admin_notice_minimum_elementor_version()
    {
        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }

        $message = sprintf(
            esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'materializor' ),
            '<strong>' . esc_html__( MATERIALIZOR_TITLE, 'materializor' ) . '</strong>',
            '<strong>' . esc_html__( 'Elementor', 'materializor' ) . '</strong>',
            self::MINIMUM_ELEMENTOR_VERSION
        );

        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }

    /**
     * @param \Elementor\Elements_Manager $elements_manager
     */
    public function categories_registered( $elements_manager )
    {
        $elements_manager->add_category(
            'materializor',
            [
                'title' => esc_html__( 'Materializor', 'materializor' ),
                'icon'  => 'mtz-icons-materializor',
            ]
        );
    }

    /**
     * @return string[]
     */
    public function get_widget_classes()
    {
        return [
            \Materializor\Widgets\MTZR_Widget_Button::class,
            \Materializor\Widgets\MTZR_Widget_Card::class,
            \Materializor\Widgets\MTZR_Widget_Chip::class,
            \Materializor\Widgets\MTZR_Widget_Collapsible::class,
            \Materializor\Widgets\MTZR_Widget_Fixed_Action_Button::class,
            \Materializor\Widgets\MTZR_Widget_Heading::class,
            \Materializor\Widgets\MTZR_Widget_Progress::class,
            \Materializor\Widgets\MTZR_Widget_Spinner::class,
            \Materializor\Widgets\MTZR_Widget_Tabs::class,
        ];
    }

    /**
     * @param \Elementor\Widgets_Manager $widget_manager
     */
    public function widgets_registered( $widget_manager )
    {
        foreach ( $this->get_widget_classes() as $widget_class ) {
            $widget_manager->register_widget_type( new $widget_class() );
        }
    }

    /**
     * @param array $tabs
     *
     * @return array
     */
    public function add_icons_additional_tabs( $tabs )
    {
        if ( is_array( $tabs ) && MTZR_Material_Design_Icons::is_enabled() ) {
            return array_merge( $tabs, MTZR_Material_Design_Icons::get_icon_types() );
        }
        return $tabs;
    }

    /**
     * @return array
     */
    public function get_default_settings()
    {
        return [
            'roboto_source' => 'disabled',
            'mdi_enabled' => true,
        ];
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function get_settings( string $key = '' )
    {
        $settings = array_merge( $this->get_default_settings(), materializor_get_option( 'settings' ) ?: [] );

        if ( '' !== $key && array_key_exists( $key, $settings ) ) {
            return $settings[ $key ];
        }

        return $settings;
    }

    /**
     * @param array $new_settings
     */
    public function save_settings( array $new_settings )
    {
        $old_settings = $this->get_settings();
        $settings = [];

        $roboto_sources = MTZR_Roboto::get_sources();
        if ( empty( $roboto_sources[ $new_settings['roboto_source'] ] ) ) {
            $settings['roboto_source'] = $old_settings['roboto_source'];
        } else {
            $settings['roboto_source'] = $new_settings['roboto_source'];
        }

        if ( isset( $new_settings['mdi_enabled'] ) && is_bool( $new_settings['mdi_enabled'] ) ) {
            $settings['mdi_enabled'] = $new_settings['mdi_enabled'];
        } else {
            $settings['mdi_enabled'] = $old_settings['mdi_enabled'];
        }

        materializor_update_option( 'settings', $settings );
    }



}