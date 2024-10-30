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
 * Class MTZR_Widget_Tabs
 * @package Materializor\Widgets
 * @since 1.0.0
 */
class MTZR_Widget_Tabs extends MTZR_Widget
{
    /**
     * @return string
     */
    public function get_name()
    {
        return 'materializor-tabs';
    }

    /**
     * @return string
     */
    public function get_title()
    {
        return esc_html__( 'Tabs', 'materializor' );
    }

    /**
     * @return string[]
     */
    public function get_keywords()
    {
        return [
            'material design',
            'content',
            'section',
            'nav',
            'text',
        ];
    }

    /**
     * @return string[]
     */
    public static function get_tabs_type_options()
    {
        return [
            'default' => esc_html__( 'Default', 'materializor' ),
            'card' => esc_html__( 'Card', 'materializor' ),
            'navbar' => esc_html__( 'Navbar', 'materializor' ),
        ];
    }

    /**
     * @return string[]
     */
    public static function get_tab_state_options()
    {
        return [
            '' => esc_html__( 'Normal', 'materializor' ),
            'active' => esc_html__( 'Active', 'materializor' ),
            'disabled' => esc_html__( 'Disabled', 'materializor' ),
        ];
    }

    /**
     *
     */
    protected function register_controls()
    {
        $this->start_controls_section(
            'tabs_content_section',
            [
                'label' => esc_html__( 'Tabs', 'materializor' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $items = new Repeater();

        $items->add_control(
            'type',
            [
                'label' => esc_html__( 'Type', 'materializor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'content',
                'options' => [
                    'content' => esc_html__( 'Content', 'materializor' ),
                    'link' => esc_html__( 'Link', 'materializor' ),
                ]
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
                'default' => esc_html__( 'Tab', 'materializor' ),
                'placeholder' => esc_html__( 'Title', 'materializor' )
            ]
        );

        $items->add_control(
            'content',
            [
                'label' => esc_html__( 'Content', 'materializor' ),
                'type' => Controls_Manager::WYSIWYG,
                'condition' => [
                    'type' => 'content',
                ],
                'default' => '<p>' . esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'materializor' ) . '</p>',
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
                'condition' => [
                    'type' => 'link',
                ],
            ]
        );

        $items->add_control(
            'state',
            [
                'label' => esc_html__( 'State', 'materializor' ),
                'type' => Controls_Manager::SELECT,
                'default' => '',
                'options' => self::get_tab_state_options(),
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
                        'title' => esc_html__( 'Tab #1', 'materializor' ),
                        'content' => '<p>' . esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'materializor' ) . '</p>',
                    ],
                    [
                        'title' => esc_html__( 'Tab #2', 'materializor' ),
                        'content' => '<p>' . esc_html__( 'Ut eu vehicula dui, vitae luctus justo. Aenean mollis aliquet enim, eu rhoncus metus lacinia in.', 'materializor' ) . '</p>',
                    ],
                    [
                        'title' => esc_html__( 'Tab #3', 'materializor' ),
                        'content' => '<p>' . esc_html__( 'Duis convallis, velit vel malesuada pretium, dui odio hendrerit urna, id condimentum urna nibh non ante.', 'materializor' ) . '</p>',
                    ],
                ],
            ]
        );

        $this->add_control(
            'tabs_fixed_width',
            [
                'label' => esc_html__( 'Equal Width Titles', 'materializor' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'separator' => 'before',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'tabs_style_section',
            [
                'label' => esc_html__( 'Tabs', 'materializor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'tabs_style',
            [
                'label' => esc_html__( 'Style', 'materializor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => self::get_tabs_type_options(),
            ]
        );

        $this->add_shadow_control(
            'shadow',
            [
                'condition' => [
                    'tabs_style' => 'card',
                ]
            ]
        );

        $this->add_control(
            'background_color',
            [
                'label' => esc_html__( 'Background Color', 'materializor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mtz-tabs-wrapper.mtz-card-panel' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .mtz-tabs' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'tab_title_style_heading',
            [
                'label' => esc_html__( 'Title', 'materializor' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'title_waves_enabled',
            [
                'label' => esc_html__( 'Waves Effect', 'materializor' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
            ]
        );

        $this->add_control(
            'title_waves_color',
            [
                'label' => esc_html__( 'Waves Color', 'materializor' ),
                'type' => Controls_Manager::COLOR,
                'default' => 'rgba(0, 0, 0, 0.2)',
                'selectors' => [
                    '{{WRAPPER}} .mtz-tab .mtz-waves-effect .mtz-waves-ripple' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'title_waves_enabled' => 'yes',
                ],
            ]
        );

        $this->start_controls_tabs( 'tab_title_states' );

        $this->start_controls_tab(
            'tab_title_normal',
            [
                'label' => esc_html__( 'Normal', 'materializor' ),
            ]
        );

        $this->add_control(
            'title_text_color',
            [
                'label' => esc_html__( 'Text Color', 'materializor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mtz-tabs .mtz-tab a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_hover_text_color',
            [
                'label' => esc_html__( 'Hover Text Color', 'materializor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mtz-tabs .mtz-tab a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_title_active',
            [
                'label' => esc_html__( 'Active', 'materializor' ),
            ]
        );

        $this->add_control(
            'title_active_text_color',
            [
                'label' => esc_html__( 'Text Color', 'materializor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mtz-tabs .mtz-tab a.mtz-active' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_active_hover_text_color',
            [
                'label' => esc_html__( 'Hover Text Color', 'materializor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mtz-tabs .mtz-tab a.mtz-active:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_indicator_color',
            [
                'label' => esc_html__( 'Indicator Color', 'materializor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mtz-tabs .mtz-indicator' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_indicator_height',
            [
                'label' => esc_html__( 'Indicator Height', 'materializor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 20,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mtz-tabs .mtz-indicator' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_title_disabled',
            [
                'label' => esc_html__( 'Disabled', 'materializor' ),
            ]
        );

        $this->add_control(
            'title_disabled_color',
            [
                'label' => esc_html__( 'Text Color', 'materializor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mtz-tabs .mtz-tab.mtz-disabled a, {{WRAPPER}} .mtz-tabs .mtz-tab.mtz-disabled a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();


        $this->add_control(
            'tab_content_style_heading',
            [
                'label' => esc_html__( 'Content', 'materializor' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'tab_content_color',
            [
                'label' => esc_html__( 'Text Color', 'materializor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mtz-tab-content' => 'color: {{VALUE}};',
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

        $this->add_render_attribute( 'tabs_wrapper', 'class', 'mtz-tabs-wrapper' );
        $this->add_render_attribute( 'tabs', 'class', [ 'mtz-tabs', 'mtz-tabs-' . $settings['tabs_style'] ] );

        if ( 'yes' === $settings['tabs_fixed_width'] ) {
            $this->add_render_attribute( 'tabs', 'class', 'mtz-tabs-fixed-width' );
        }

        if ( 'card' === $settings['tabs_style'] ) {
            $this->add_render_attribute( 'tabs_wrapper', 'class', 'mtz-card-panel' );
            if ( ! empty( $settings['shadow'] ) ) {
                $this->add_render_attribute( 'tabs_wrapper', 'class', $settings['shadow'] );
            }
        }

        $id_prefix = 'tabs-' . $this->get_id() . '-';

        $has_active = false;
        ?>
        <div class="mtz">
            <div <?php echo $this->get_render_attribute_string( 'tabs_wrapper' ); ?>>
                <ul <?php echo $this->get_render_attribute_string( 'tabs' ); ?>>
                    <?php
                        foreach ( $settings['items'] as $index => $item ) {
                            $tab_key = $this->get_repeater_setting_key( 'tab', 'items', $index );
                            $tab_title_key = $this->get_repeater_setting_key( 'title', 'items', $index );

                            $this->add_render_attribute( $tab_key, 'class', 'mtz-tab' );

                            if ( 'disabled' === $item['state'] ) {
                                $this->add_render_attribute( $tab_key, 'class', 'mtz-disabled' );
                            } elseif ( 'active' === $item['state'] && ! $has_active ) {
                                $has_active = true;
                                $this->add_render_attribute( $tab_title_key, 'class', 'mtz-active' );
                            }

                            if ( 'link' === $item['type'] ) {
                                $this->add_link_attributes( $tab_title_key, $item['link'] );
                                if ( empty( $this->get_render_attributes( $tab_title_key, 'target' ) ) ) {
                                    $this->add_render_attribute( $tab_title_key, 'target', '_self' );
                                }
                            } else {
                                $this->add_render_attribute( $tab_title_key, 'href', '#' . $id_prefix . $index );
                            }

                            if ( 'yes' === $settings['title_waves_enabled'] ) {
                                $this->add_render_attribute( $tab_title_key, 'class', 'mtz-waves-effect' );
                            }

                            $this->add_inline_editing_attributes( $tab_title_key );
                            ?>
                            <li <?php echo $this->get_render_attribute_string( $tab_key ); ?>>
                                <a <?php echo $this->get_render_attribute_string( $tab_title_key ); ?>>
                                    <?php echo materializor_kses_basic( $item['title'] ); ?>
                                </a>
                            </li>
                            <?php
                        }
                    ?>
                </ul>
                <?php
                    foreach ( $settings['items'] as $index => $item ) {
                        if ( 'link' === $item['type'] ) {
                            continue;
                        }

                        $tab_content_key  = $this->get_repeater_setting_key( 'content', 'items', $index );
                        $this->add_render_attribute( $tab_content_key, 'class', 'mtz-tab-content' );
                        $this->add_render_attribute( $tab_content_key, 'id', $id_prefix . $index );
                        $this->add_inline_editing_attributes( $tab_content_key, 'advanced' );
                        ?>
                        <div <?php echo $this->get_render_attribute_string( $tab_content_key ); ?>>
                            <?php echo wp_kses_post( $this->parse_text_editor( $item['content'] ) ); ?>
                        </div>
                        <?php
                    }
                ?>
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
        view.addRenderAttribute('tabs_wrapper', 'class', 'mtz-tabs-wrapper');
        view.addRenderAttribute('tabs', 'class', ['mtz-tabs', 'mtz-tabs-' + settings.tabs_style]);

        if (settings.tabs_fixed_width === 'yes') {
            view.addRenderAttribute('tabs', 'class', 'mtz-tabs-fixed-width');
        }
        if (settings.tabs_style === 'card') {
            view.addRenderAttribute('tabs_wrapper', 'class', 'mtz-card-panel');
            if (settings.shadow) view.addRenderAttribute('tabs_wrapper', 'class', settings.shadow);
        }

        var idPrefix = 'tabs-<?php echo esc_attr( $this->get_id() ); ?>-';

        var hasActive = false;
        #>
        <div class="mtz">
            <div {{{ view.getRenderAttributeString('tabs_wrapper') }}}>
                <ul {{{ view.getRenderAttributeString('tabs') }}}>
                    <#
                    _.each(settings.items, function(item, index) {
                        var tabKey = view.getRepeaterSettingKey('tab', 'items', index);
                        var tabTitleKey = view.getRepeaterSettingKey('title', 'items', index);

                        view.addRenderAttribute(tabKey, 'class', 'mtz-tab');

                        if (item.state === 'disabled') view.addRenderAttribute(tabKey, 'class', 'mtz-disabled');
                        else if (item.state === 'active' && !hasActive) {
                            hasActive = true;
                            view.addRenderAttribute(tabTitleKey, 'class', 'mtz-active');
                        }

                        if (item.type === 'link') {
                            view.addRenderAttribute(tabTitleKey, 'target', '_self');
                            view.addRenderAttribute(tabTitleKey, 'href', item.link.url);
                        } else {
                            view.addRenderAttribute(tabTitleKey, 'href', '#' + idPrefix + index);
                        }

                        if (settings.title_waves_enabled === 'yes') view.addRenderAttribute(tabTitleKey, 'class', 'mtz-waves-effect');

                        view.addInlineEditingAttributes(tabTitleKey);
                        #>
                        <li {{{ view.getRenderAttributeString(tabKey) }}}>
                            <a {{{ view.getRenderAttributeString(tabTitleKey) }}}>
                                {{{ item.title }}}
                            </a>
                        </li>
                        <#
                    });
                    #>
                </ul>
                <#
                _.each(settings.items, function(item, index) {
                    if (item.type === 'link') return;

                    var tabContentKey = view.getRepeaterSettingKey('content', 'items', index);
                    view.addRenderAttribute(tabContentKey, {
                        id: idPrefix + index,
                        class: 'mtz-tab-content'
                    });
                    view.addInlineEditingAttributes(tabContentKey);
                    #>
                    <div {{{ view.getRenderAttributeString(tabContentKey) }}}>
                        {{{ item.content }}}
                    </div>
                    <#
                });
                #>
            </div>
        </div>
        <?php
    }
}