<?php

namespace Materializor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Materializor\Assets\MTZR_Materializor_Icons;

/**
 * Class MTZR_Admin
 * @package Materializor
 * @since 1.0.0
 */
final class MTZR_Admin
{
    /**
     * MTZR_Admin constructor.
     */
	public function __construct()
	{
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue_scripts' ] );
		add_action( 'admin_menu', [ $this, 'admin_menu' ] );
	}

	/**
	 *
	 */
	public function admin_enqueue_scripts()
	{
		wp_enqueue_style(
			'materializor-admin',
			materializor_css_url( 'admin/admin.css' ),
			[
			    MTZR_Materializor_Icons::register_style()
            ],
			MATERIALIZOR_VERSION
		);
	}

	/**
	 *
	 */
	public function admin_menu()
	{
		$menu_hook = add_menu_page(
            esc_html__( 'Materializor', 'materializor' ),
            esc_html__( 'Materializor', 'materializor' ),
			'manage_options',
			'materializor',
			function () {
				materializor_include( 'admin/page-settings' );
			},
			'none'
		);

		add_action( "admin_print_styles-{$menu_hook}", [ $this, 'page_settings_enqueue_styles' ] );
		add_action( "admin_print_scripts-{$menu_hook}", [ $this, 'page_settings_enqueue_scripts' ] );
	}

	/**
	 *
	 */
	public function page_settings_enqueue_styles()
	{
        wp_enqueue_style(
            'simonwep-pickr-classic',
            materializor_vendor_url( 'simonwep/pickr/themes/classic.min.css' ),
            [],
            '1.8.0'
        );
    }

	/**
	 *
	 */
	public function page_settings_enqueue_scripts()
	{
        wp_register_script(
            'simonwep-pickr',
            materializor_vendor_url( 'simonwep/pickr/pickr.min.js' ),
            [],
            '1.8.0',
            true
        );

        wp_enqueue_script(
			'materializor-admin-settings',
			materializor_js_url( 'dist/admin/settings.js' ),
			[
			    'jquery',
                'simonwep-pickr',
            ],
			'materializor',
            true
		);
	}

}