<?php

namespace Materializor\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Materializor\Assets\MTZR_Material_Design_Icons;

/**
 * Class MTZR_Widget_Collapsible
 * @package Materializor\Widgets
 * @since 1.0.0
 */
class MTZR_Widget_Collapsible extends MTZR_Widget
{
    /**
     * @return string
     */
    public function get_name()
    {
        return 'materializor-collapsible';
    }

    /**
     * @return string
     */
    public function get_title()
    {
        return esc_html__( 'Collapsible', 'materializor' );
    }

    /**
     * @return string[]
     */
    public function get_keywords()
    {
        return [
            'material design',
            'content',
            'accordion',
            'section',
        ];
    }

    /**
     * @return string[]
     */
    public static function get_collapsible_type_options()
    {
        return [
            'accordion' => esc_html__( 'Accordion', 'materializor' ),
            'expandable' => esc_html__( 'Expandable', 'materializor' ),
            'popout' => esc_html__( 'Popout', 'materializor' ),
        ];
    }

    /**
     *
     */
    protected function register_controls()
    {
        if ( MTZR_Material_Design_Icons::is_enabled() ) {
            $items_icon_default = [
                'library' => 'material-icons',
                'value' => 'material-icons mdi-expand-more',
            ];
        } else {
            $items_icon_default = [
                'library' => 'solid',
                'value' => 'fas fa-angle-down',
            ];
        }

        $this->start_controls_section(
            'collapsible_content_section',
            [
                'label' => esc_html__( 'Collapsible', 'materializor' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $items = new Repeater();

        $items->add_control(
            'active',
            [
                'label' => esc_html__( 'Active', 'materializor' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
            ]
        );

        $items->add_control(
            'icon',
            [
                'label' => esc_html__( 'Icon', 'materializor' ),
                'type' => Controls_Manager::ICONS,
                'default' => $items_icon_default,
                'label_block' => false,
                'skin' => 'inline',
                'exclude_inline_options' => [ 'svg' ],
            ]
        );

        $items->add_control(
            'title',
            [
                'label' => esc_html__( 'Title', 'materializor' ),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 1,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => esc_html__( 'Title', 'materializor' ),
                'placeholder' => esc_html__( 'Title', 'materializor' )
            ]
        );

        $items->add_control(
            'content',
            [
                'label' => esc_html__( 'Content', 'materializor' ),
                'type' => Controls_Manager::WYSIWYG,
                'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'materializor' ),
            ]
        );

        $this->add_control(
            'items',
            [
                'label' => esc_html__( 'Items', 'materializor' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $items->get_controls(),
                'title_field' => '{{{ title }}}',
                'default' => [
                    [
                        'active' => 'yes',
                    ],
                ],
            ]
        );

        $this->add_control(
            'collapsible_type',
            [
                'label' => esc_html__( 'Type', 'materializor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'accordion',
                'options' => self::get_collapsible_type_options(),
                'separator' => 'before',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'collapsible_style_section',
            [
                'label' => esc_html__( 'Collapsible', 'materializor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'header_style_heading',
            [
                'label' => esc_html__( 'Header', 'materializor' ),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'header_background_color',
            [
                'label' => esc_html__( 'Background Color', 'materializor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mtz-collapsible-header' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'header_text_color',
            [
                'label' => esc_html__( 'Text Color', 'materializor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mtz-collapsible-header' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'body_style_heading',
            [
                'label' => esc_html__( 'Body', 'materializor' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'body_background_color',
            [
                'label' => esc_html__( 'Background Color', 'materializor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mtz-collapsible-body' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'body_text_color',
            [
                'label' => esc_html__( 'Text Color', 'materializor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mtz-collapsible-body' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'border_color',
            [
                'label' => esc_html__( 'Border Color', 'materializor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mtz-collapsible' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .mtz-collapsible-header' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .mtz-collapsible-body' => 'border-color: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'border_width',
            [
                'label' => esc_html__( 'Border Width', 'materializor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 30,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .mtz-collapsible' => 'border-top-width: {{SIZE}}{{UNIT}}; border-right-width: {{SIZE}}{{UNIT}}; border-left-width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mtz-collapsible-header' => 'border-bottom-width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .mtz-collapsible-body' => 'border-bottom-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_shadow_control(
            'shadow',
            [
                'condition' => [
                    'collapsible_type!' => 'popout',
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

        $this->add_render_attribute( 'collapsible', 'class', 'mtz-collapsible' );
        if ( 'expandable' === $settings['collapsible_type'] ) {
            $this->add_render_attribute( 'collapsible', 'data-collapsible', 'expandable' );
        } else {
            $this->add_render_attribute( 'collapsible', 'data-collapsible', 'accordion' );
            if ( 'popout' === $settings['collapsible_type'] ) {
                $this->add_render_attribute( 'collapsible', 'class', 'mtz-popout' );
            }
        }

        if ( ! empty( $settings['shadow'] ) && 'popout' !== $settings['collapsible_type'] ) {
            $this->add_render_attribute( 'collapsible', 'class', $settings['shadow'] );
        }
        ?>
        <div class="mtz">
            <ul <?php echo $this->get_render_attribute_string( 'collapsible' ); ?>>
                <?php foreach ( $settings['items'] as $index => $item ) :
                    $header_key  = $this->get_repeater_setting_key( 'header', 'items', $index );
                    $title_key   = $this->get_repeater_setting_key( 'title', 'items', $index );
                    $content_key = $this->get_repeater_setting_key( 'content', 'items', $index );

                    $this->add_render_attribute( $header_key, 'class', 'mtz-collapsible-header' );
                    if ( 'yes' === $item['active'] ) {
                        $this->add_render_attribute( $header_key, 'class', 'mtz-active' );
                    }

                    $this->add_inline_editing_attributes( $title_key );

                    $this->add_render_attribute( $content_key, 'class', 'mtz-collapsible-body' );
                    $this->add_inline_editing_attributes( $content_key, 'advanced' );
                ?>
                    <li>
                        <div <?php echo $this->get_render_attribute_string( $header_key ); ?>>
                            <?php Icons_Manager::render_icon( $item['icon'], [ 'aria-hidden' => 'true' ] ); ?>
                            <span <?php echo $this->get_render_attribute_string( $title_key ); ?>>
                                <?php echo materializor_kses_basic( $item['title'] ); ?>
                            </span>
                        </div>
                        <div <?php echo $this->get_render_attribute_string( $content_key ); ?>>
                            <?php echo wp_kses_post( $this->parse_text_editor( $item['content'] ) ); ?>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
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
        view.addRenderAttribute('collapsible', 'class', 'mtz-collapsible');
        if (settings.collapsible_type === 'expandable') {
            view.addRenderAttribute('collapsible', 'data-collapsible', 'expandable');
        } else {
            view.addRenderAttribute('collapsible', 'data-collapsible', 'accordion');
            if (settings.collapsible_type === 'popout') view.addRenderAttribute('collapsible', 'class', 'mtz-popout');
        }

        if (settings.shadow && settings.collapsible_type !== 'popout') view.addRenderAttribute('collapsible', 'class', settings.shadow);
        #>
        <div class="mtz">
            <ul {{{ view.getRenderAttributeString('collapsible') }}}>
                <#
                _.each(settings.items, function(item, index) {
                    var headerKey = view.getRepeaterSettingKey('header', 'items', index);
                    var titleKey = view.getRepeaterSettingKey('title', 'items', index);
                    var contentKey = view.getRepeaterSettingKey('content', 'items', index);

                    view.addRenderAttribute(headerKey, 'class', 'mtz-collapsible-header');
                    if (item.active === 'yes') view.addRenderAttribute(headerKey, 'class', 'mtz-collapsible-header');

                    view.addInlineEditingAttributes(titleKey);

                    view.addRenderAttribute(contentKey, 'class', 'mtz-collapsible-body');
                    view.addInlineEditingAttributes(contentKey, 'advanced');
                    #>
                    <li>
                        <div {{{ view.getRenderAttributeString(headerKey) }}}>
                            {{{ elementor.helpers.renderIcon(view, item.icon) }}}
                            <span {{{ view.getRenderAttributeString(titleKey) }}}>
                                {{{ item.title }}}
                            </span>
                        </div>
                        <div {{{ view.getRenderAttributeString(contentKey) }}}>
                            {{{ item.content }}}
                        </div>
                    </li>
                    <#
                });
                #>
            </ul>
        </div>
        <?php
    }
}