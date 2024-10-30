<?php

namespace Materializor\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;

/**
 * Class MTZR_Widget_Progress
 * @package Materializor\Widgets
 * @since 1.0.0
 */
class MTZR_Widget_Progress extends MTZR_Widget
{
    /**
     * @return string
     */
    public function get_name()
    {
        return 'materializor-progress';
    }

    /**
     * @return string
     */
    public function get_title()
    {
        return esc_html__( 'Progress', 'materializor' );
    }

    /**
     * @return string[]
     */
    public function get_keywords()
    {
        return [
            'material design',
            'linear',
            'time',
            'indicator',
            'loading',
            'process',
            'complete',
        ];
    }

    /**
     * @return string[]
     */
    public static function get_progress_state_options()
    {
        return [
            'determinate' => esc_html__( 'Determinate' ),
            'indeterminate' => esc_html__( 'Indeterminate' ),
        ];
    }

    /**
     *
     */
    protected function register_controls()
    {
        $this->start_controls_section(
            'progress_content_section',
            [
                'label' => esc_html__( 'Progress', 'materializor' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'state',
            [
                'label' => esc_html__( 'State', 'materializor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'determinate',
                'options' => self::get_progress_state_options(),
            ]
        );

        $this->add_control(
            'percentage',
            [
                'label' => esc_html__( 'Percentage', 'materializor' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 50,
                    'unit' => '%',
                ],
                'dynamic' => [
                    'active' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .mtz-determinate' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'state' => 'determinate',
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
                        'icon' => "eicon-h-align-left",
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'materializor' ),
                        'icon' => "eicon-h-align-center",
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'materializor' ),
                        'icon' => "eicon-h-align-right",
                    ],
                ],
                'prefix_class' => 'mtz%s-flex-',
            ]
        );

        $this->add_control(
            'incrementer_heading',
            [
                'label' => esc_html__( 'Incrementer', 'materializor' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'state' => 'determinate',
                ],
            ]
        );

        $this->add_control(
            'incrementer_enabled',
            [
                'label' => esc_html__( 'Enabled', 'materializor' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'condition' => [
                    'state' => 'determinate',
                ],
            ]
        );

        $this->add_control(
            'incrementer_duration',
            [
                'label' => esc_html__( 'Duration (Seconds)', 'materializor' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'default' => 5,
                'condition' => [
                    'state' => 'determinate',
                    'incrementer_enabled' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'incrementer_hide',
            [
                'label' => esc_html__( 'Hide at 100%', 'materializor' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'description' => esc_html__( 'It will not hide in edit mode', 'materializor' ),
                'condition' => [
                    'state' => 'determinate',
                    'incrementer_enabled' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'timeout_heading',
            [
                'label' => esc_html__( 'Timeout', 'materializor' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'state' => 'indeterminate',
                ],
            ]
        );

        $this->add_control(
            'timeout_enabled',
            [
                'label' => esc_html__( 'Enabled', 'materializor' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'condition' => [
                    'state' => 'indeterminate',
                ],
            ]
        );

        $this->add_control(
            'timeout_ms',
            [
                'label' => esc_html__( 'Milliseconds', 'materializor' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'default' => 5000,
                'description' => esc_html__( 'It will not hide in edit mode', 'materializor' ),
                'condition' => [
                    'state' => 'indeterminate',
                    'timeout_enabled' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'progress_css_id',
            [
                'label' => esc_html__( 'Progress ID', 'materializor' ),
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

        $this->start_controls_section(
            'progress_style_section',
            [
                'label' => esc_html__( 'Progress', 'materializor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'width',
            [
                'label' => esc_html__( 'Width', 'materializor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', '%' ],
                'default' => [
                    'size' => 100,
                    'unit' => '%',
                ],
                'range' => [
                    'px' => [
                        'max' => 1000
                    ],
                    'em' => [
                        'max' => 100
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .mtz-progress' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'height',
            [
                'label' => esc_html__( 'Height', 'materializor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .mtz-progress' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'background_color',
            [
                'label' => esc_html__( 'Background Color', 'materializor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mtz-progress' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'bar_color',
            [
                'label' => esc_html__( 'Bar Color', 'materializor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mtz-progress .mtz-determinate' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .mtz-progress .mtz-indeterminate' => 'background-color: {{VALUE}};',
                ],
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

        $this->add_render_attribute( 'progress', 'class', 'mtz-progress' );

        $this->add_render_attribute( 'bar', 'class', [ 'mtz-progress-bar', 'mtz-' . $settings['state'] ] );

        if ( ! empty( $settings['progress_css_id'] ) ) {
            $this->add_render_attribute( 'progress', 'id', $settings['progress_css_id'] );
        }

        if ( 'determinate' === $settings['state'] && 'yes' === $settings['incrementer_enabled'] ) {
            $this->add_render_attribute(
                'progress',
                [
                    'data-incrementer' => 'yes',
                    'data-incrementer-start' => $settings['percentage']['size'],
                    'data-incrementer-duration' => $settings['incrementer_duration'],
                ]
            );
            if( ! materializor_is_edit_mode() ) {
                $this->add_render_attribute( 'progress', 'data-incrementer-hide', $settings['incrementer_hide'] );
            }
        }

        if ( ! materializor_is_edit_mode() ) {
            if ( 'indeterminate' === $settings['state'] && 'yes' === $settings['timeout_enabled'] && ! empty( $settings['timeout_ms'] ) ) {
                $this->add_render_attribute( 'progress', 'data-timeout', $settings['timeout_ms'] );
            }
        }
        ?>
        <div class="mtz">
            <div <?php echo $this->get_render_attribute_string( 'progress' ); ?>>
                <div <?php echo $this->get_render_attribute_string( 'bar' ); ?>></div>
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
        <#
        view.addRenderAttribute('progress', 'class', 'mtz-progress');
        view.addRenderAttribute('progress', 'id', settings.progress_css_id);
        if (settings.state === 'determinate' && settings.incrementer_enabled === 'yes') {
            view.addRenderAttribute(
                'progress',
                {
                    'data-incrementer': 'yes',
                    'data-incrementer-start': settings.percentage.size || 0,
                    'data-incrementer-duration': settings.incrementer_duration || 1,
                }
            );
        }
        #>
        <div class="mtz">
            <div {{{ view.getRenderAttributeString('progress') }}}>
                <div class="mtz-progress-bar mtz-{{ settings.state }}"></div>
            </div>
        </div>
        <?php
    }

}