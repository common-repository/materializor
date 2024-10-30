<?php

namespace Materializor\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;

/**
 * Class MTZR_Widget_Spinner
 * @package Materializor\Widgets
 * @since 1.0.0
 */
class MTZR_Widget_Spinner extends MTZR_Widget
{
    /**
     * @return string
     */
    public function get_name()
    {
        return 'materializor-spinner';
    }

    /**
     * @return string
     */
    public function get_title()
    {
        return esc_html__( 'Spinner', 'materializor' );
    }

    /**
     * @return string[]
     */
    public function get_keywords()
    {
        return [
            'material design',
            'circular',
            'time',
            'indicator',
            'loading',
            'process',
            'complete',
        ];
    }

    /**
     *
     */
    protected function register_controls()
    {
        $this->start_controls_section(
            'spinner_content_section',
            [
                'label' => esc_html__( 'Spinner', 'materializor' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'color',
            [
                'label' => esc_html__( 'Color', 'materializor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mtz-spinner-layer' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'size',
            [
                'label' => esc_html__( 'Size', 'materializor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],
                'range' => [
                    'px' => [
                        'max' => 600,
                    ],
                    'em' => [
                        'max' => 50,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .mtz-preloader-wrapper' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'align',
            [
                'label' => esc_html__( 'Alignment', 'materializor' ),
                'type' => Controls_Manager::CHOOSE,
                'default' => '',
                'options' => [
                    'left'    => [
                        'title' => esc_html__( 'Left', 'materializor' ),
                        'icon' => "eicon-text-align-left",
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'materializor' ),
                        'icon' => "eicon-text-align-center",
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'materializor' ),
                        'icon' => "eicon-text-align-right",
                    ],
                ],
                'prefix_class' => 'elementor%s-align-',
            ]
        );

        $this->add_control(
            'timeout_heading',
            [
                'label' => esc_html__( 'Timeout', 'materializor' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'timeout_enabled',
            [
                'label' => esc_html__( 'Enabled', 'materializor' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'description' => esc_html__( 'It will not hide in edit mode', 'materializor' ),
            ]
        );

        $this->add_control(
            'timeout_ms',
            [
                'label' => esc_html__( 'Milliseconds', 'materializor' ),
                'type' => Controls_Manager::NUMBER,
                'default' => 5000,
                'step' => 1000,
                'condition' => [
                    'timeout_enabled' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'spinned_css_id',
            [
                'label' => esc_html__( 'Spinner ID', 'materializor' ),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => '',
                'title' => esc_html__( 'Add your custom id WITHOUT the Pound key. e.g: my-id', 'materializor' ),
                'description' => wp_kses(
                    __( 'Please make sure the ID is unique and not used elsewhere on the page this form is displayed. This field allows <code>A-z 0-9</code> & underscore chars without spaces.', 'materializor' ),
                    [ 'code' => [] ]
                ),
                'separator' => 'before',
            ]
        );

        $this->end_controls_section();
    }

    /**
     *
     */
    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute( 'preloader_wrapper', 'class', 'mtz-preloader-wrapper mtz-active' );

        if ( ! empty( $settings['spinner_css_id'] ) ) {
            $this->add_render_attribute( 'preloader_wrapper', 'id', $settings['spinner_css_id'] );
        }

        if ( ! materializor_is_edit_mode() ) {
            if ( 'yes' === $settings['timeout_enabled'] && ! empty( $settings['timeout_ms'] ) ) {
                $this->add_render_attribute( 'preloader_wrapper', 'data-timeout', $settings['timeout_ms'] );
            }
        }
        ?>
        <div class="mtz">
            <div <?php echo $this->get_render_attribute_string( 'preloader_wrapper' ); ?>>
                <div class="mtz-spinner-layer">
                    <div class="mtz-circle-clipper mtz-left">
                        <div class="mtz-circle"></div>
                    </div>
                    <div class="mtz-gap-patch">
                        <div class="mtz-circle"></div>
                    </div>
                    <div class="mtz-circle-clipper mtz-right">
                        <div class="mtz-circle"></div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     *
     */
    protected function content_template()
    {
        ?>
        <div class="mtz">
            <div id="{{ settings.spinner_css_id }}"
                 class="mtz-preloader-wrapper mtz-active">
                <div class="mtz-spinner-layer">
                    <div class="mtz-circle-clipper mtz-left">
                        <div class="mtz-circle"></div>
                    </div>
                    <div class="mtz-gap-patch">
                        <div class="mtz-circle"></div>
                    </div>
                    <div class="mtz-circle-clipper mtz-right">
                        <div class="mtz-circle"></div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

}