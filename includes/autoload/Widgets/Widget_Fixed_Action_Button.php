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
 * Class MTZR_Widget_Fixed_Action_Button
 * @package Materializor\Widgets
 * @since 1.0.0
 */
class MTZR_Widget_Fixed_Action_Button extends MTZR_Widget
{
    /**
     * @return string
     */
    public function get_name()
    {
        return 'materializor-fixed-action-button';
    }

    /**
     * @return string
     */
    public function get_title()
    {
        return esc_html__( 'Fixed Action Button', 'materializor' );
    }

    /**
     * @return string[]
     */
    public function get_keywords()
    {
        return [
            'material design',
            'fab',
            'actions',
            'floating',
            'toolbar',
            'menu',
        ];
    }

    /**
     * @return string[]
     */
    public static function get_fixed_action_button_type_options()
    {
        return [
            'single' => esc_html__( 'Single Button', 'materializor' ),
            'vertical' => esc_html__( 'Vertical Menu', 'materializor' ),
            'horizontal' => esc_html__( 'Horizontal Menu', 'materializor' ),
            'toolbar' => esc_html__( 'Toolbar', 'materializor' ),
        ];
    }

    /**
     * @return string[]
     */
    public static function get_fixed_action_button_position_options()
    {
        return [
            'left' => esc_html__( 'Bottom Left', 'materializor' ),
            'right' => esc_html__( 'Bottom Right', 'materializor' ),
        ];
    }

    /**
     *
     */
    protected function register_controls()
    {
        if ( MTZR_Material_Design_Icons::is_enabled() ) {
            $main_button_icon_default = [
                'library' => 'material-icons',
                'value' => 'material-icons mdi-menu',
            ];
            $items_icon_default = [
                'library' => 'material-icons',
                'value' => 'material-icons mdi-link',
            ];
        } else {
            $main_button_icon_default = [
                'library' => 'solid',
                'value' => 'fas fa-bars',
            ];
            $items_icon_default = [
                'library' => 'solid',
                'value' => 'fas fa-external-link-alt',
            ];
        }

        $this->start_controls_section(
            'fixed_button_action_content_section',
            [
                'label' => esc_html__( 'Fixed Action Button', 'materializor' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'type',
            [
                'label' => esc_html__( 'Type', 'materializor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'vertical',
                'options' => self::get_fixed_action_button_type_options(),
            ]
        );

        $this->add_control(
            'position',
            [
                'label' => esc_html__( 'Position', 'materializor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'right',
                'options' => self::get_fixed_action_button_position_options(),
            ]
        );

        $this->add_control(
            'main_button_content_heading',
            [
                'label' => esc_html__( 'Main Button', 'materializor' ),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'main_button_icon',
            [
                'label' => esc_html__( 'Icon', 'materializor' ),
                'type' => Controls_Manager::ICONS,
                'skin' => 'inline',
                'exclude_inline_options' => [ 'svg' ],
                'label_block' => false,
                'default' => $main_button_icon_default,
            ]
        );

        $this->add_control(
            'click_toggle',
            [
                'label' => esc_html__( 'Show On Click', 'materializor' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'type',
                            'operator' => 'in',
                            'value' => [
                                'vertical',
                                'horizontal',
                            ]
                        ]
                    ]
                ],
            ]
        );

        $this->add_control(
            'main_button_link',
            [
                'label' => esc_html__( 'Link', 'materializor' ),
                'type' => Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => esc_html__( 'https://your-link.com', 'materializor' ),
                'default' => [
                    'url' => '#',
                ],
                'condition' => [
                    'type' => 'single',
                ],
            ]
        );

        $items = new Repeater();

        $items->add_control(
            'icon',
            [
                'label' => esc_html__( 'Icon', 'materializor' ),
                'type' => Controls_Manager::ICONS,
                'skin' => 'inline',
                'exclude_inline_options' => [ 'svg' ],
                'label_block' => false,
                'default' => $items_icon_default,
            ]
        );

        $items->add_control(
            'background_color',
            [
                'label' => esc_html__( 'Background Color', 'materializor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mtz-fixed-action-btn:not(.mtz-toolbar) {{CURRENT_ITEM}} .mtz-btn-floating' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $items->add_control(
            'text_color',
            [
                'label' => esc_html__( 'Icon Color', 'materializor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mtz-fixed-action-btn:not(.mtz-toolbar) {{CURRENT_ITEM}} .mtz-btn-floating' => 'color: {{VALUE}};',
                ],
            ]
        );

        $items->add_control(
            'link',
            [
                'label' => esc_html__( 'Link', 'materializor' ),
                'type' => Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => esc_html__( 'https://your-link.com', 'materializor' ),
                'default' => [
                    'url' => '#',
                ],
            ]
        );

        $this->add_control(
            'items',
            [
                'label' => esc_html__( 'Items', 'materializor' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $items->get_controls(),
                'default' => [
                    [
                        'link' => '#',
                        'icon' => $items_icon_default,
                    ],
                ],
                'condition' => [
                    'type!' => 'single',
                ],
                'separator' => 'before',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'fixed_button_action_style_section',
            [
                'label' => esc_html__( 'Fixed Action Button', 'materializor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'main_button_style_heading',
            [
                'label' => esc_html__( 'Main Button', 'materializor' ),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'background_color',
            [
                'label' => esc_html__( 'Background Color', 'materializor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mtz-fab' => 'background: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => esc_html__( 'Icon Color', 'materializor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mtz-fab' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'pulse',
            [
                'label' => esc_html__( 'Pulse Effect', 'materializor' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
            ]
        );

        $this->add_control(
            'toolbar_item_heading',
            [
                'label' => esc_html__( 'Toolbar Item', 'materializor' ),
                'type' => Controls_Manager::HEADING,
                'condition' => [
                    'type' => 'toolbar',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'toolbar_item_waves_enabled',
            [
                'label' => esc_html__( 'Waves Effect', 'materializor' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'condition' => [
                    'type' => 'toolbar',
                ],
            ]
        );

        $this->add_control(
            'toolbar_item_waves_color',
            [
                'label' => esc_html__( 'Waves Color', 'materializor' ),
                'type' => Controls_Manager::COLOR,
                'default' => 'rgba(0, 0, 0, 0.2)',
                'selectors' => [
                    '{{WRAPPER}} li.mtz-waves-effect .mtz-waves-ripple' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'type' => 'toolbar',
                    'item_waves_enabled' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     *
     */
    protected function render_placeholder_title()
    {
        ?>
        <div class="mtz">
            <div class="mtz-headline mtz-center-align">
                <?php echo esc_html( $this->get_title() ); ?>
            </div>
        </div>
        <?php
    }

    /**
     *
     */
    protected function render()
    {
        if ( materializor_is_edit_mode() ) {
            $this->render_placeholder_title();
        }

        $settings = $this->get_settings_for_display();

        $is_toolbar = 'toolbar' === $settings['type'];
        $is_single  = 'single'  === $settings['type'];

        $this->add_render_attribute(
            'fixed_action_button',
            'class',
            [
                'mtz-fixed-action-btn',
                'mtz-' . $settings['type'],
                'mtz-fixed-' . $settings['position'],
            ]
        );

        $this->add_render_attribute(
            'fab',
            'class',
            [
                'mtz-btn-floating',
                'mtz-btn-large',
                'mtz-fab',
            ]
        );

        if ( $is_single && ! empty( $settings['main_button_link']['url'] ) ) {
            $this->add_link_attributes( 'fab', $settings['main_button_link'] );
        }

        if ( ! $is_toolbar && 'yes' === $settings['click_toggle'] ) {
            $this->add_render_attribute( 'fixed_action_button', 'class', 'mtz-click-to-toggle' );
        }

        if ( 'yes' === $settings['pulse'] ) {
            $this->add_render_attribute( 'fab', 'class', 'mtz-pulse' );
        }
        ?>
        <div class="mtz">
            <div <?php echo $this->get_render_attribute_string( 'fixed_action_button' ); ?>>
                <a <?php echo $this->get_render_attribute_string( 'fab' ); ?>>
                    <?php Icons_Manager::render_icon( $settings['main_button_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                </a>
                <?php if ( ! $is_single ) : ?>
                    <ul>
                        <?php foreach ( $settings['items'] as $index => $item ) :
                            $item_key   = 'item_' . $index;
                            $button_key = 'button_' . $index;

                            $this->add_render_attribute( $item_key, 'class', 'elementor-repeater-item-' . $item['_id'] );
                            $this->add_render_attribute( $button_key, 'class', 'mtz-fab-item' );

                            if ( $is_toolbar ) {
                                if ( 'yes' === $settings['toolbar_item_waves_enabled'] ) {
                                    $this->add_render_attribute( $item_key, 'class', 'mtz-waves-effect' );
                                }
                            } else {
                                $this->add_render_attribute( $button_key, 'class', 'mtz-btn-floating' );
                            }

                            if ( ! empty( $item['link']['url'] ) ) {
                                $this->add_link_attributes( $button_key, $item['link'] );
                            }
                            ?>
                            <li <?php echo $this->get_render_attribute_string( $item_key ); ?>>
                                <a <?php echo $this->get_render_attribute_string( $button_key ); ?>>
                                    <?php Icons_Manager::render_icon( $item['icon'], [ 'aria-hidden' => 'true' ] ); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }

    protected function content_template()
    {
        $this->render_placeholder_title();
        ?>
        <#
        var isToolbar = settings.type === 'toolbar';
        var isSingle = settings.type === 'single';

        view.addRenderAttribute('fixed_action_button', 'class', [
            'mtz-fixed-action-btn',
            'mtz-' + settings.type,
            'mtz-fixed-' + settings.position
        ]);

        view.addRenderAttribute('fab', 'class', ['mtz-btn-floating', 'mtz-btn-large', 'mtz-fab']);

        if (isSingle && settings.main_button_link && settings.main_button_link.url) {
            view.addRenderAttribute('fab', 'href', settings.main_button_link.url);
        }

        if (!isToolbar && settings.click_toggle === 'yes') {
            view.addRenderAttribute('fixed_action_button', 'class', 'mtz-click-to-toggle');
        }

        if (settings.pulse === 'yes') {
            view.addRenderAttribute('fab', 'class', 'mtz-pulse');
        }
        #>
        <div class="mtz">
            <div {{{ view.getRenderAttributeString('fixed_action_button') }}}>
                <a {{{ view.getRenderAttributeString('fab') }}}>
                    {{{ elementor.helpers.renderIcon(view, settings.main_button_icon) }}}
                </a>
                <# if (!isSingle) { #>
                    <ul>
                        <# _.each(settings.items, function(item, index) {
                            var itemKey = 'item_' + index;
                            var buttonKey = 'link_' + index;

                            view.addRenderAttribute(itemKey, 'class', 'elementor-repeater-item-' + item._id);
                            view.addRenderAttribute(buttonKey, 'class', 'mtz-fab-item');

                            if (isToolbar) {
                                if (settings.toolbar_item_waves_enabled === 'yes') view.addRenderAttribute(itemKey, 'class', 'mtz-waves-effect');
                            } else {
                                view.addRenderAttribute(buttonKey, 'class', 'mtz-btn-floating');
                            }

                            if (item.link.url) view.addRenderAttribute(buttonKey, 'href', item.link.url);
                        #>
                            <li {{{ view.getRenderAttributeString(itemKey) }}}>
                                <a {{{ view.getRenderAttributeString(buttonKey) }}}>
                                    {{{ elementor.helpers.renderIcon(view, item.icon) }}}
                                </a>
                            </li>
                        <# }); #>
                    </ul>
                <# } #>
            </div>
        </div>
        <?php
    }
}