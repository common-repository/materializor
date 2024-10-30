<?php

namespace Materializor\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

/**
 * Class MTZR_Widget
 * @package Materializor\Widgets
 * @since 1.0.0
 */
abstract class MTZR_Widget extends Widget_Base
{
    /**
     * @return string
     */
    public function get_icon()
    {
        return 'mtz-icons-materializor';
    }

    /**
     * @return string[]
     */
    public function get_categories()
    {
        return [ 'materializor' ];
    }

    /**
     * @param string $name
     * @param array $args
     */
    protected function add_shadow_control( string $name = 'shadow', array $args = [] )
    {
        $args = array_merge(
            [
                'label' => esc_html__( 'Shadow', 'materializor' ),
                'type' => Controls_Manager::SELECT,
                'default' => '',
                'depth' => [
                    'min' => 1,
                    'max' => 24,
                ],
                'options' => [
                    '' => esc_html__( 'Default', 'materializor' ),
                ]
            ],
            $args
        );

        foreach ( range( $args['depth']['min'], $args['depth']['max'] ) as $dp ) {
            $args['options']["mtz-shadow-{$dp}dp"] = $dp . 'dp';
        }

        $this->add_control( $name, $args );
    }

    /**
     * @param string $name
     * @param array $args
     */
    protected function add_hover_shadow_control( string $name = 'hover_shadow', array $args = [] )
    {
        $args = array_merge(
            [
                'label' => esc_html__( 'Shadow', 'materializor' ),
                'type' => Controls_Manager::SELECT,
                'default' => '',
                'depth' => [
                    'min' => 1,
                    'max' => 24,
                ],
                'options' => [
                    '' => esc_html__( 'Default', 'materializor' ),
                ]
            ],
            $args
        );

        foreach ( range( $args['depth']['min'], $args['depth']['max'] ) as $dp ) {
            $args['options']["mtz-hover-shadow-{$dp}dp"] = $dp . 'dp';
        }

        $this->add_control( $name, $args );
    }

}