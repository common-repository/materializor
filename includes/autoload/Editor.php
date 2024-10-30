<?php

namespace Materializor;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use Materializor\Assets\MTZR_Material_Design_Icons;
use Materializor\Assets\MTZR_Materializor_Icons;

/**
 * Class MTZR_Editor
 * @package Materializor
 * @since 1.0.0
 */
final class MTZR_Editor
{
    /**
     * MTZR_Editor constructor.
     */
    public function __construct()
    {
        add_action( 'elementor/editor/before_enqueue_scripts', [ $this, 'before_enqueue_scripts' ] );
    }

    /**
     *
     */
    public function before_enqueue_scripts()
    {
        MTZR_Materializor_Icons::register_style( true );
    }

}