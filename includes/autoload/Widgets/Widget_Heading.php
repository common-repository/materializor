<?php

namespace Materializor\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Utils;

/**
 * Class MTZR_Widget_Heading
 * @package Materializor\Widgets
 * @since 1.0.0
 */
class MTZR_Widget_Heading extends MTZR_Widget
{
    /**
     * @return string
     */
    public function get_name()
    {
        return 'materializor-heading';
    }

    /**
     * @return string
     */
    public function get_title()
    {
        return esc_html__( 'Heading', 'materializor' );
    }

    /**
     * @return string[]
     */
    public function get_keywords()
    {
        return [
            'material design',
            'title',
            'header',
            'text',
            'display',
        ];
    }

    /**
     * @return string[]
     */
    public static function get_heading_style_options()
    {
        return [
            'display-4' => esc_html__( 'Display 4', 'materializor' ),
            'display-3' => esc_html__( 'Display 3', 'materializor' ),
            'display-2' => esc_html__( 'Display 2', 'materializor' ),
            'display-1' => esc_html__( 'Display 1', 'materializor' ),
            'headline'  => esc_html__( 'Headline', 'materializor' ),
            'title'     => esc_html__( 'Title', 'materializor' ),
            'subhead'   => esc_html__( 'Subhead', 'materializor' ),
        ];
    }

    /**
     *
     */
    protected function register_controls()
    {
        $this->start_controls_section(
            'heading_content_section',
            [
                'label' => esc_html__( 'Heading', 'materializor' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'style',
            [
                'label' => esc_html__( 'Style', 'materializor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'display-2',
                'options' => self::get_heading_style_options(),
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => esc_html__( 'Title', 'materializor' ),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 2,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => esc_html__( 'Heading', 'materializor' ),
                'placeholder' => esc_html__( 'Heading', 'materializor' ),
            ]
        );

        $this->add_control(
            'link',
            [
                'label' => esc_html__( 'Link', 'materializor' ),
                'type' => Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => esc_html__( 'https://your-link.com', 'materializor' ),
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => esc_html__( 'Text Color', 'materializor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mtz-heading' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .mtz-heading a' => 'color: {{VALUE}};',
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

        $this->end_controls_section();
    }

    /**
     *
     */
    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute( 'heading', 'class', [ 'mtz-heading', 'mtz-' . $settings['style'] ] );

        $this->add_inline_editing_attributes( 'title' );
        ?>
        <div class="mtz">
            <div <?php echo $this->get_render_attribute_string( 'heading' ); ?>>
                <?php if ( empty( $settings['link']['url'] ) ) : ?>
                    <span <?php echo $this->get_render_attribute_string( 'title' ); ?>>
                        <?php echo materializor_kses_basic( $settings['title'] ); ?>
                    </span>
                <?php else : $this->add_link_attributes( 'title', $settings['link'] ); ?>
                    <a <?php echo $this->get_render_attribute_string( 'title' ); ?>>
                        <?php echo materializor_kses_basic( $settings['title'] ); ?>
                    </a>
                <?php endif; ?>
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
        view.addRenderAttribute('heading', 'class', ['mtz-heading', 'mtz-' + settings.style]);

        view.addInlineEditingAttributes('title');
        #>
        <div class="mtz">
            <div {{{ view.getRenderAttributeString('heading') }}}>
                <# if (settings.link.url) { #>
                    <a href="{{{ settings.link.url }}}" {{{ view.getRenderAttributeString('title') }}}>
                        {{{ settings.title }}}
                    </a>
                <# } else { #>
                    <span {{{ view.getRenderAttributeString('title') }}}>
                        {{{ settings.title }}}
                    </span>
                <# } #>
            </div>
        </div>
        <?php
    }

}