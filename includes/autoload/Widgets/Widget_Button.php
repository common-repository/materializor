<?php

namespace Materializor\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Materializor\Assets\MTZR_Material_Design_Icons;

/**
 * Class MTZR_Widget_Button
 * @package Materializor\Widgets
 * @since 1.0.0
 */
class MTZR_Widget_Button extends MTZR_Widget
{
    /**
     * @return string
     */
    public function get_name()
    {
        return 'materializor-button';
    }

    /**
     * @return string
     */
    public function get_title()
    {
        return esc_html__( 'Button', 'materializor' );
    }

    /**
     * @return string[]
     */
    public function get_keywords()
    {
        return [
            'material design',
            'click',
            'link',
            'action',
            'raised',
            'flat',
            'floating',
            'fab',
        ];
    }

    /**
     * @return string[]
     */
    public static function get_button_type_options()
    {
        return [
            'flat' => esc_html__( 'Flat', 'materializor' ),
            'floating' => esc_html__( 'Floating', 'materializor' ),
            'raised' => esc_html__( 'Raised', 'materializor' ),
        ];
    }

    /**
     * @return string[]
     */
    public static function get_button_size_options()
    {
        return [
            'medium' => esc_html__( 'Medium', 'materializor' ),
            'large' => esc_html__( 'Large', 'materializor' ),
        ];
    }

    /**
     *
     */
    protected function register_controls()
    {
        if ( MTZR_Material_Design_Icons::is_enabled() ) {
            $icon_default = [
                'library' => 'material-icons',
                'value' => 'material-icons mdi-add',
            ];
        } else {
            $icon_default = [
                'library' => 'solid',
                'value' => 'fas fa-plus',
            ];
        }

        $this->start_controls_section(
            'button_content_section',
            [
                'label' => esc_html__( 'Button', 'materializor' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'type',
            [
                'label' => esc_html__( 'Type', 'materializor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'raised',
                'options' => self::get_button_type_options(),
            ]
        );

        $this->add_control(
            'text',
            [
                'label' => esc_html__( 'Text', 'materializor' ),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => esc_html__( 'Click here', 'materializor' ),
                'placeholder' => esc_html__( 'Click here', 'materializor' ),
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'type',
                            'operator' => 'in',
                            'value' => [
                                'flat',
                                'raised',
                            ],
                        ],
                    ]
                ],
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
                'default' => [
                    'url' => '#',
                ],
            ]
        );

        $this->add_control(
            'icon_enabled',
            [
                'label' => esc_html__( 'Use Icon', 'materializor' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'condition' => [
                    'type!' => 'floating',
                ],
            ]
        );

        $this->add_control(
            'icon',
            [
                'label' => esc_html__( 'Icon', 'materializor' ),
                'type' => Controls_Manager::ICONS,
                'skin' => 'inline',
                'exclude_inline_options' => [ 'svg' ],
                'label_block' => false,
                'default' => $icon_default,
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'type',
                            'operator' => '===',
                            'value' => 'floating',
                        ],
                        [
                            'name' => 'icon_enabled',
                            'operator' => '===',
                            'value' => 'yes',
                        ],
                    ]
                ],
            ]
        );

        $this->add_control(
            'icon_align',
            [
                'label' => esc_html__( 'Icon Position', 'materializor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'left',
                'options' => [
                    'left' => esc_html__( 'Before', 'materializor' ),
                    'right' => esc_html__( 'After', 'materializor' ),
                ],
                'condition' => [
                    'type!' => 'floating',
                    'icon_enabled' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_align',
            [
                'label' => esc_html__( 'Alignment', 'materializor' ),
                'type' => Controls_Manager::CHOOSE,
                'default' => '',
                'options' => [
                    'left'    => [
                        'title' => esc_html__( 'Left', 'materializor' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'materializor' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'materializor' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => esc_html__( 'Justified', 'materializor' ),
                        'icon' => 'eicon-text-align-justify',
                    ],
                ],
                'prefix_class' => 'elementor%s-align-',
                'condition' => [
                    'type!' => 'floating',
                ],
            ]
        );

        $this->add_responsive_control(
            'floating_align',
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
                'condition' => [
                    'type' => 'floating',
                ],
            ]
        );

        $this->add_control(
            'button_css_id',
            [
                'label' => esc_html__( 'Button ID', 'materializor' ),
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
            'button_style_section',
            [
                'label' => esc_html__( 'Button', 'materializor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'size',
            [
                'label' => esc_html__( 'Size', 'materializor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'medium',
                'options' => self::get_button_size_options(),
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'type',
                            'operator' => 'in',
                            'value' => [
                                'raised',
                                'floating',
                            ]
                        ]
                    ]
                ],
            ]
        );

        $this->add_control(
            'pulse',
            [
                'label' => esc_html__( 'Pulse Effect', 'materializor' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'condition' => [
                    'type' => 'floating',
                ],
            ]
        );

        $this->add_control(
            'waves_enabled',
            [
                'label' => esc_html__( 'Waves Effect', 'materializor' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
            ]
        );

        $this->add_control(
            'waves_color',
            [
                'label' => esc_html__( 'Waves Color', 'materializor' ),
                'type' => Controls_Manager::COLOR,
                'default' => 'rgba(0, 0, 0, 0.2)',
                'selectors' => [
                    '{{WRAPPER}} .mtz-waves-effect .mtz-waves-ripple' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'waves_enabled' => 'yes',
                ],
            ]
        );

        $this->start_controls_tabs( 'button_states' );

        $this->start_controls_tab(
            'button_normal',
            [
                'label' => esc_html__( 'Normal', 'materializor' ),
            ]
        );

        $this->add_control(
            'background_color',
            [
                'label' => esc_html__( 'Background Color', 'materializor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mtz [class*="mtz-btn"]' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => esc_html__( 'Text Color', 'materializor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mtz [class*="mtz-btn"]' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_shadow_control(
            'shadow',
            [
                'condition' => [
                    'type!' => 'flat'
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'button_hover',
            [
                'label' => esc_html__( 'Hover', 'materializor' ),
            ]
        );

        $this->add_control(
            'hover_background_color',
            [
                'label' => esc_html__( 'Background Color', 'materializor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mtz [class*="mtz-btn"]:hover' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .mtz [class*="mtz-btn"]:focus' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'hover_text_color',
            [
                'label' => esc_html__( 'Text Color', 'materializor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mtz [class*="mtz-btn"]:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .mtz [class*="mtz-btn"]:focus' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_hover_shadow_control(
            'hover_shadow',
            [
                'condition' => [
                    'type!' => 'flat'
                ]
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    /**
     *
     */
    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $type = $settings['type'];
        $text = '';

        $this->add_render_attribute( 'button', 'role', 'button' );

        if ( 'floating' === $type ) {
            $this->add_render_attribute( 'button', 'class', 'mtz-btn-floating' );

            if ( 'yes' === $settings['pulse'] ) {
                $this->add_render_attribute( 'button', 'class', 'mtz-pulse' );
            }

            if ( 'large' === $settings['size'] ) {
                $this->add_render_attribute( 'button', 'class', 'mtz-btn-large' );
            }
        } else {
            $text = $settings['text'];
            if ( 'flat' === $type ) {
                $this->add_render_attribute( 'button', 'class', 'mtz-btn-flat' );
            } elseif ( 'large' === $settings['size'] ) {
                $this->add_render_attribute( 'button', 'class', 'mtz-btn-large' );
            } else {
                $this->add_render_attribute( 'button', 'class', 'mtz-btn' );
            }
        }

        if ( 'flat' !== $type ) {
            if ( ! empty( $settings['shadow'] ) ) {
                $this->add_render_attribute( 'button', 'class', $settings['shadow'] );
            }
            if ( ! empty( $settings['hover_shadow'] ) ) {
                $this->add_render_attribute( 'button', 'class', $settings['hover_shadow'] );
            }
        }

        if ( 'yes' === $settings['waves_enabled'] ) {
            $this->add_render_attribute( 'button', 'class', 'mtz-waves-effect' );
        }

        if ( ! empty( $settings['link']['url'] ) ) {
            $this->add_link_attributes( 'button', $settings['link'] );
        }

        if ( ! empty( $settings['button_css_id'] ) ) {
            $this->add_render_attribute( 'button', 'id', $settings['button_css_id'] );
        }
        ?>
        <div class="mtz">
            <a <?php echo $this->get_render_attribute_string( 'button' ); ?>>
                <?php
                    if ( 'floating' === $type ) {
                        Icons_Manager::render_icon(
                            $settings['icon'],
                            [ 'aria-hidden' => 'true' ]
                        );
                    } elseif ( 'yes' === $settings['icon_enabled'] ) {
                        Icons_Manager::render_icon(
                            $settings['icon'],
                            [
                                'aria-hidden' => 'true',
                                'class' => 'mtz-' . $settings['icon_align'],
                            ]
                        );
                    }
                ?>
                <?php echo esc_html( $text ); ?>
            </a>
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
        var type = settings.type;
        var size = settings.size;
        var buttonText = '';
        var buttonIcon = '';

        view.addRenderAttribute('button', {
            id: settings.button_css_id,
            href: settings.link.url,
            role: 'button'
        });

        if (type === 'floating') {
            view.addRenderAttribute('button', 'class', 'mtz-btn-floating');
            if (settings.pulse === 'yes') view.addRenderAttribute('button', 'class', 'mtz-pulse');
            if (size === 'large') view.addRenderAttribute('button', 'class', 'mtz-btn-large');
            buttonIcon = elementor.helpers.renderIcon(view, settings.icon);
        } else {
            buttonText = settings.text;
            if (type === 'flat') view.addRenderAttribute('button', 'class', 'mtz-btn-flat');
            else if (size === 'large') view.addRenderAttribute('button', 'class', 'mtz-btn-large');
            else view.addRenderAttribute('button', 'class', 'mtz-btn');

            if (settings.icon_enabled === 'yes') {
                buttonIcon = elementor.helpers.renderIcon(view, settings.icon, {class: 'mtz-'+settings.icon_align});
            }
        }

        if (type !== 'flat') {
            if (settings.shadow) view.addRenderAttribute('button', 'class', settings.shadow);
            if (settings.hover_shadow) view.addRenderAttribute('button', 'class', settings.hover_shadow);
        }

        if (settings.waves_enabled === 'yes') view.addRenderAttribute('button', 'class', 'mtz-waves-effect');
        #>
        <div class="mtz">
            <a {{{ view.getRenderAttributeString('button') }}}>
                {{{ buttonIcon }}}
                {{ buttonText }}
            </a>
        </div>
        <?php
    }

}