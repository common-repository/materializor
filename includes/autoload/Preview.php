<?php

namespace Materializor;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use Materializor\Assets\MTZR_Material_Design_Icons;

/**
 * Class MTZR_Preview
 * @package Materializor
 * @since 1.0.0
 */
final class MTZR_Preview
{
    /**
     * MTZR_Preview constructor.
     */
    public function __construct()
    {
        add_action( 'elementor/preview/enqueue_styles', [ $this, 'enqueue_styles' ] );
    }

    /**
     *
     */
    public function enqueue_styles()
    {

    }

}