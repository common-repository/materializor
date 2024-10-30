<?php

namespace Materializor\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;
use Elementor\Icons_Manager;
use Elementor\Utils;
use Materializor\Assets\MTZR_Material_Design_Icons;

/**
 * Class MTZR_Widget_Card
 * @package Materializor\Widgets
 * @since 1.0.0
 */
class MTZR_Widget_Card extends MTZR_Widget
{
    /**
     * @return string
     */
    public function get_name()
    {
        return 'materializor-card';
    }

    /**
     * @return string
     */
    public function get_title()
    {
        return esc_html__( 'Card', 'materializor' );
    }

    /**
     * @return string[]
     */
    public function get_keywords()
    {
        return [
            'material design',
            'content',
            'box',
            'media',
            'image',
            'actions',
        ];
    }

    /**
     * @return string[]
     */
    public static function get_card_size_options()
    {
        return [
            'small' => esc_html__( 'Small', 'materializor' ),
            'medium' => esc_html__( 'Medium', 'materializor' ),
            'large' => esc_html__( 'Large', 'materializor' ),
        ];
    }

    /**
     * @return string[]
     */
    public static function get_card_action_item_type_options()
    {
        return [
            'link' => esc_html__( 'Link', 'materializor' ),
            'btn-flat' => esc_html__( 'Flat Button', 'materializor' ),
            'btn' => esc_html__( 'Raised Button', 'materializor' ),
            'btn-floating' => esc_html__( 'Floating Button', 'materializor' ),
        ];
    }

    /**
     * @return string[]
     */
    public static function get_card_fab_position_options()
    {
        return [
            'left' => esc_html__( 'Left', 'materializor' ),
            'right' => esc_html__( 'Right', 'materializor' ),
        ];
    }

    /**
     * @return string[]
     */
    public static function get_card_fab_size_options()
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
            $fab_icon_default = [
                'library' => 'material-icons',
                'value' => 'material-icons mdi-add',
            ];
            $reveal_icon_default = [
                'library' => 'material-icons',
                'value' => 'material-icons mdi-more-vert',
            ];
        } else {
            $fab_icon_default = [
                'library' => 'solid',
                'value' => 'fas fa-plus',
            ];
            $reveal_icon_default = [
                'library' => 'solid',
                'value' => 'fas fa-ellipsis-v',
            ];
        }

        $this->start_controls_section(
            'card_content_section',
            [
                'label' => esc_html__( 'Card', 'materializor' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'size',
            [
                'label' => esc_html__( 'Size', 'materializor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'medium',
                'options' => self::get_card_size_options(),
            ]
        );

        $this->add_control(
            'body_title',
            [
                'label' => esc_html__( 'Title', 'materializor' ),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 1,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => esc_html__( 'Title', 'materializor' ),
                'placeholder' => esc_html__( 'Body Title', 'materializor' )
            ]
        );

        $this->add_control(
            'body_content',
            [
                'label' => esc_html__( 'Content', 'materializor' ),
                'type' => Controls_Manager::WYSIWYG,
                'default' => '<p>' . esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.' ) . '</p>',
            ]
        );

        $this->add_control(
            'body_link',
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
            'image_enabled',
            [
                'label' => esc_html__( 'Image', 'materializor' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'fab_enabled',
            [
                'label' => esc_html__( 'FAB', 'materializor' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'condition' => [
                    'image_enabled' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'action_enabled',
            [
                'label' => esc_html__( 'Action', 'materializor' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
            ]
        );

        $this->add_control(
            'reveal_enabled',
            [
                'label' => esc_html__( 'Reveal', 'materializor' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
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
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'materializor' ),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'materializor' ),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'prefix_class' => 'mtz%s-flex-',
                'separator' => 'before',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'image_content_section',
            [
                'label' => esc_html__( 'Image', 'materializor' ),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'image_enabled' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'image',
            [
                'label' => esc_html__( 'Choose Image', 'materializor' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'image',
                'default' => 'large',
                'separator' => 'none',
            ]
        );

        $this->add_control(
            'image_title',
            [
                'label' => esc_html__( 'Title', 'materializor' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => '',
                'placeholder' => esc_html__( 'Image Title', 'materializor' ),
            ]
        );

        $this->add_control(
            'image_link',
            [
                'label' => esc_html__( 'Link', 'materializor' ),
                'type' => Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => esc_html__( 'https://your-link.com', 'materializor' ),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'action_content_section',
            [
                'label' => esc_html__( 'Action', 'materializor' ),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'action_enabled' => 'yes',
                ]
            ]
        );

        $action_items = new Repeater();

        $action_items->add_control(
            'type',
            [
                'label' => esc_html__( 'Type', 'materializor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'link',
                'options' => self::get_card_action_item_type_options(),
            ]
        );

        $action_items->add_control(
            'text',
            [
                'label' => esc_html__( 'Text', 'materializor' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => esc_html__( 'Text', 'materializor' ),
                'placeholder' => esc_html__( 'Text', 'materializor' )
            ]
        );

        $action_items->add_control(
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

        $action_items->add_control(
            'icon',
            [
                'label' => esc_html__( 'Icon', 'materializor' ),
                'type' => Controls_Manager::ICONS,
                'skin' => 'inline',
                'exclude_inline_options' => [ 'svg' ],
                'label_block' => false,
                'condition' => [
                    'type!' => 'link',
                ]
            ]
        );

        $action_items->add_control(
            'icon_align',
            [
                'label' => esc_html__( 'Icon Position', 'materializor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'left',
                'options' => [
                    'left' => esc_html__( 'Before', 'materializor' ),
                    'right' => esc_html__( 'After', 'materializor' ),
                ],
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'type',
                            'operator' => 'in',
                            'value' => [ 'btn', 'btn-flat' ],
                        ],
                    ],
                ],
            ]
        );

        $action_items->start_controls_tabs( 'action_item_states' );

        $action_items->start_controls_tab(
            'action_item_normal',
            [
                'label' => esc_html__( 'Normal', 'materializor' ),
            ]
        );

        $action_items->add_control(
            'background_color',
            [
                'label' => esc_html__( 'Background Color', 'materializor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mtz .mtz-card .mtz-card-action {{CURRENT_ITEM}}' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'type!' => 'link',
                ]
            ]
        );

        $action_items->add_control(
            'text_color',
            [
                'label' => esc_html__( 'Text Color', 'materializor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mtz .mtz-card .mtz-card-action {{CURRENT_ITEM}}' => 'color: {{VALUE}} ;',
                ],
            ]
        );

        $action_items->end_controls_tab();

        $action_items->start_controls_tab(
            'action_item_hover',
            [
                'label' => esc_html__( 'Hover', 'materializor' ),
            ]
        );

        $action_items->add_control(
            'hover_background_color',
            [
                'label' => esc_html__( 'Background Color', 'materializor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mtz .mtz-card .mtz-card-action {{CURRENT_ITEM}}:hover' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .mtz .mtz-card .mtz-card-action {{CURRENT_ITEM}}:focus' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'type!' => 'link',
                ]
            ]
        );

        $action_items->add_control(
            'hover_text_color',
            [
                'label' => esc_html__( 'Text Color', 'materializor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mtz .mtz-card .mtz-card-action {{CURRENT_ITEM}}:hover' => 'color: {{VALUE}} ;',
                    '{{WRAPPER}} .mtz .mtz-card .mtz-card-action {{CURRENT_ITEM}}:focus' => 'color: {{VALUE}} ;',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'action_items',
            [
                'label' => esc_html__( 'Items', 'materializor' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $action_items->get_controls(),
                'default' => [],
                'title_field' => '{{{ text }}}',
                'prevent_empty' => false,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'fab_content_section',
            [
                'label' => esc_html__( 'FAB', 'materializor' ),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'image_enabled' => 'yes',
                    'fab_enabled' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'fab_position',
            [
                'label' => esc_html__( 'Position', 'materializor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'right',
                'options' => self::get_card_fab_position_options(),
            ]
        );

        $this->add_control(
            'fab_icon',
            [
                'label' => esc_html__( 'Icon', 'materializor' ),
                'type' => Controls_Manager::ICONS,
                'skin' => 'inline',
                'exclude_inline_options' => [ 'svg' ],
                'label_block' => false,
                'default' => $fab_icon_default,
            ]
        );

        $this->add_control(
            'fab_link',
            [
                'label' => esc_html__( 'Link', 'materializor' ),
                'type' => Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => esc_html__( 'https://your-link.com', 'materializor' ),
                'default' => [
                    'url' => '',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'reveal_content_section',
            [
                'label' => esc_html__( 'Reveal', 'materializor' ),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'reveal_enabled' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'reveal_title',
            [
                'label' => esc_html__( 'Title', 'materializor' ),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 1,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => esc_html__( 'Reveal Title', 'materializor' ),
                'placeholder' => esc_html__( 'Title', 'materializor' ),
            ]
        );

        $this->add_control(
            'reveal_content',
            [
                'label' => esc_html__( 'Content', 'materializor' ),
                'type' => Controls_Manager::WYSIWYG,
                'default' => '<p>' . esc_html__( 'Reveal Content', 'materializor' ) . '</p>',
            ]
        );

        $this->add_control(
            'reveal_trigger_icon',
            [
                'label' => esc_html__( 'Trigger on icon', 'materializor' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'reveal_icon',
            [
                'label' => esc_html__( 'Icon', 'materializor' ),
                'type' => Controls_Manager::ICONS,
                'skin' => 'inline',
                'exclude_inline_options' => [ 'svg' ],
                'label_block' => false,
                'default' => $reveal_icon_default,
                'condition' => [
                    'reveal_trigger_icon' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'reveal_trigger_image',
            [
                'label' => esc_html__( 'Trigger on image', 'materializor' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'condition' => [
                    'image_enabled' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'reveal_trigger_fab',
            [
                'label' => esc_html__( 'Trigger on FAB', 'materializor' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'condition' => [
                    'fab_enabled' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'card_style_section',
            [
                'label' => esc_html__( 'Card', 'materializor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'width',
            [
                'label' => esc_html__( 'Width', 'materializor' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'max' => 1600
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mtz-card' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->start_controls_tabs( 'card_states' );

        $this->start_controls_tab(
            'card_normal',
            [
                'label' => esc_html__( 'Normal', 'materializor' ),
            ]
        );

        $this->add_shadow_control();

        $this->end_controls_tab();

        $this->start_controls_tab(
            'card_hover',
            [
                'label' => esc_html__( 'Hover', 'materializor' ),
            ]
        );

        $this->add_hover_shadow_control();

        $this->end_controls_tab();

        $this->end_controls_tabs();

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
                    '{{WRAPPER}} .mtz-card .mtz-card-body' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'body_title_color',
            [
                'label' => esc_html__( 'Title Color', 'materializor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mtz-card .mtz-card-body .mtz-card-title' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .mtz-card .mtz-card-body .mtz-card-title > a' => 'color: {{VALUE}} !important;',
                    '{{WRAPPER}} .mtz-card .mtz-card-body .mtz-card-title > span' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'body_reveal_icon_color',
            [
                'label' => esc_html__( 'Reveal Icon Color', 'materializor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mtz-card .mtz-card-body .mtz-card-title > i.mtz-activator' => 'color: {{VALUE}} !important;',
                ],
                'condition' => [
                    'reveal_enabled' => 'yes',
                    'reveal_trigger_icon' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'body_text_color',
            [
                'label' => esc_html__( 'Text Color', 'materializor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mtz-card .mtz-card-body .mtz-card-content' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'body_min_height',
            [
                'label' => esc_html__( 'Min. Height', 'materializor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1000
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mtz-card .mtz-card-body' => 'min-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'image_style_heading',
            [
                'label' => esc_html__( 'Image', 'materializor' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'image_enabled' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'image_background_color',
            [
                'label' => esc_html__( 'Background Color', 'materializor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mtz-card .mtz-card-image' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'image_enabled' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'image_title_color',
            [
                'label' => esc_html__( 'Title Color', 'materializor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mtz-card .mtz-card-image .mtz-card-title' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'image_enabled' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'image_waves_enabled',
            [
                'label' => esc_html__( 'Waves Effect', 'materializor' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'condition' => [
                    'image_enabled' => 'yes',
                    'fab_enabled!' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'image_waves_color',
            [
                'label' => esc_html__( 'Waves Color', 'materializor' ),
                'type' => Controls_Manager::COLOR,
                'default' => 'rgba(255, 255, 255, 0.45)',
                'selectors' => [
                    '{{WRAPPER}} .mtz-card-image.mtz-waves-effect .mtz-waves-ripple' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'image_enabled' => 'yes',
                    'fab_enabled!' => 'yes',
                    'image_waves_enabled' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'action_style_heading',
            [
                'label' => esc_html__( 'Action', 'materializor' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'action_enabled' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'action_background_color',
            [
                'label' => esc_html__( 'Background Color', 'materializor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mtz-card .mtz-card-action' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'action_enabled' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'action_border_color',
            [
                'label' => esc_html__( 'Border Top Color', 'materializor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mtz-card .mtz-card-action' => 'border-top-color: {{VALUE}};',
                ],
                'condition' => [
                    'action_enabled' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'action_border_width',
            [
                'label' => esc_html__( 'Border Top Width', 'materializor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 30,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .mtz-card .mtz-card-action' => 'border-top-width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'action_enabled' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'fab_style_section',
            [
                'label' => esc_html__( 'FAB', 'materializor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'fab_enabled' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'fab_size',
            [
                'label' => esc_html__( 'Size', 'materializor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'medium',
                'options' => self::get_card_fab_size_options(),
            ]
        );

        $this->add_control(
            'fab_waves_enabled',
            [
                'label' => esc_html__( 'Waves Effect', 'materializor' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
            ]
        );

        $this->add_control(
            'fab_waves_color',
            [
                'label' => esc_html__( 'Waves Color', 'materializor' ),
                'type' => Controls_Manager::COLOR,
                'default' => 'rgba(255, 255, 255, 0.45)',
                'selectors' => [
                    '{{WRAPPER}} .mtz-halfway-fab.mtz-waves-effect .mtz-waves-ripple' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'fab_waves_enabled' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'fab_bottom_padding',
            [
                'label' => esc_html__( 'Bottom Padding', 'materializor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                       'min' => 16,
                        'max' => 48
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mtz-card > div:nth-child(2)' => 'padding-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'fab_states' );

        $this->start_controls_tab(
            'fab_normal',
            [
                'label' => esc_html__( 'Normal', 'materializor' ),
            ]
        );

        $this->add_control(
            'fab_background_color',
            [
                'label' => esc_html__( 'Background Color', 'materializor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mtz-card-image .mtz-btn-floating' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'fab_icon_color',
            [
                'label' => esc_html__( 'Icon Color', 'materializor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mtz-card-image .mtz-btn-floating' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'fab_hover',
            [
                'label' => esc_html__( 'Hover', 'materializor' ),
            ]
        );

        $this->add_control(
            'fab_hover_background_color',
            [
                'label' => esc_html__( 'Background Color', 'materializor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mtz-card-image .mtz-btn-floating:hover' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .mtz-card-image .mtz-btn-floating:focus' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'fab_hover_icon_color',
            [
                'label' => esc_html__( 'Icon Color', 'materializor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mtz-card-image .mtz-btn-floating:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .mtz-card-image .mtz-btn-floating:focus' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'reveal_style_section',
            [
                'label' => esc_html__( 'Reveal', 'materializor' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'reveal_enabled' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'reveal_background_color',
            [
                'label' => esc_html__( 'Background Color', 'materializor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mtz-card .mtz-card-reveal' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'reveal_title_color',
            [
                'label' => esc_html__( 'Title Color', 'materializor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mtz-card .mtz-card-reveal .mtz-card-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'reveal_close_icon_color',
            [
                'label' => esc_html__( 'Close Icon Color', 'materializor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mtz-card .mtz-card-reveal .mtz-card-title > i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'reveal_text_color',
            [
                'label' => esc_html__( 'Text Color', 'materializor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mtz-card .mtz-card-reveal .mtz-card-content' => 'color: {{VALUE}};',
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

        $this->add_render_attribute( 'card', 'class', [ 'mtz-card', 'mtz-card-' . $settings['size'] ] );

        if ( ! empty( $settings['shadow'] ) ) {
            $this->add_render_attribute( 'card', 'class', $settings['shadow'] );
        }
        if ( ! empty( $settings['hover_shadow'] ) ) {
            $this->add_render_attribute( 'card', 'class', $settings['hover_shadow'] );
        }
        ?>
        <div class="mtz">
            <div <?php echo $this->get_render_attribute_string( 'card' ); ?>>
                <?php
                    $this->render_card_image( $settings );
                    $this->render_card_body( $settings );
                    $this->render_card_action( $settings );
                    $this->render_card_reveal( $settings );
                ?>
            </div>
        </div>
        <?php
    }

    /**
     * @param array $settings
     */
    protected function render_card_image( array $settings )
    {
        if ( 'yes' !== $settings['image_enabled'] || empty( $settings['image']['url'] ) ) {
            return;
        }

        $this->add_render_attribute( 'card_image', 'class', 'mtz-card-image' );
        if ( 'yes' === $settings['image_waves_enabled'] && 'yes' !== $settings['fab_enabled'] ) {
            $this->add_render_attribute( 'card_image', 'class', 'mtz-waves-effect mtz-waves-block' );
        }

        $image_link = empty( $settings['image_link']['url'] ) ? false : $settings['image_link'];

        $reveal = 'yes' === $settings['reveal_enabled'];
        $reveal_on_image = $reveal && 'yes' === $settings['reveal_trigger_image'];
        if ( $reveal_on_image ) {
            $this->add_render_attribute( 'card_image', 'class', 'mtz-add-activator' );
        }
        ?>
        <div <?php echo $this->get_render_attribute_string( 'card_image' ); ?>>
            <?php if ( ! $reveal_on_image && $image_link ) : $this->add_link_attributes( 'image_link', $image_link ); ?>
                <a <?php echo $this->get_render_attribute_string( 'image_link' ); ?>>
            <?php endif; ?>
                    <?php echo Group_Control_Image_Size::get_attachment_image_html( $settings ); ?>
            <?php if ( ! $reveal_on_image && $image_link ) : ?>
                </a>
            <?php endif; ?>
            <?php
                if ( strlen( $settings['image_title'] ) ) {
                    $this->add_render_attribute( 'image_title', 'class', 'mtz-card-title' );
                    $this->add_inline_editing_attributes( 'image_title' );

                    if ( ! $reveal_on_image && $image_link ) {
                        $this->add_link_attributes( 'image_title', $image_link );
                        ?>
                        <a <?php echo $this->get_render_attribute_string( 'image_title' ); ?>>
                            <?php echo materializor_kses_basic( $settings['image_title'] ); ?>
                        </a>
                        <?php
                    } else {
                        if ( $reveal_on_image) {
                            $this->add_render_attribute( 'image_title', 'class', 'mtz-activator' );
                        }
                        ?>
                        <span <?php echo $this->get_render_attribute_string( 'image_title' ); ?>>
                            <?php echo materializor_kses_basic( $settings['image_title'] ); ?>
                        </span>
                        <?php
                    }
                }

                if ( 'yes' === $settings['fab_enabled'] ) {
                    $this->add_render_attribute(
                        'fab',
                        'class',
                        [
                            'mtz-btn-floating',
                            'mtz-halfway-fab',
                            'mtz-btn-' . $settings['fab_size'],
                        ]
                    );
                    if ( 'left' === $settings['fab_position'] ) {
                        $this->add_render_attribute( 'fab', 'class', 'mtz-left' );
                    }
                    if ( 'yes' === $settings['fab_waves_enabled'] ) {
                        $this->add_render_attribute( 'fab', 'class', 'mtz-waves-effect' );
                    }

                    if ( $reveal && 'yes' === $settings['reveal_trigger_fab'] ) {
                        $this->add_render_attribute( 'fab', 'class', 'mtz-activator' );
                    } elseif ( ! empty( $settings['fab_link']['url'] ) ) {
                        $this->add_link_attributes( 'fab', $settings['fab_link'] );
                    }
                    ?>
                    <a <?php echo $this->get_render_attribute_string( 'fab' ); ?>>
                        <?php Icons_Manager::render_icon( $settings['fab_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                    </a>
                    <?php
                }
            ?>
        </div>
        <?php
    }


    /**
     * @param array $settings
     */
    protected function render_card_body( array $settings )
    {
        $content          = $this->parse_text_editor( $settings['body_content'] );
        $has_content      = strlen( $content );
        $reveal           = 'yes' === $settings['reveal_enabled'];
        $show_reveal_icon = $reveal && $settings['reveal_trigger_icon'] && ! empty( $settings['reveal_icon']['value'] );
        $has_title        = strlen( $settings['body_title'] );

        if ( ! $has_content && ! $has_title && ! $show_reveal_icon ) {
            return;
        }

        $this->add_render_attribute( 'card_body', 'class', 'mtz-card-body' );
        if ( 'yes' === $settings['reveal_enabled'] && ( 'yes' !== $settings['action_enabled'] || empty( $settings['action_items'] ) ) ) {
            $this->add_render_attribute( 'card_body', 'class', 'mtz-last-child' );
        }

        ?>
        <div <?php echo $this->get_render_attribute_string( 'card_body' ); ?>>
            <?php
                if ( $has_title || $show_reveal_icon ) {
                    $this->add_render_attribute( 'card_title', 'class', 'mtz-card-title' );

                    if ( $show_reveal_icon && empty( $settings['body_link']['url'] ) ) {
                        $this->add_render_attribute( 'card_title', 'class', 'mtz-activator' );
                    }
                    ?>
                    <div <?php echo $this->get_render_attribute_string( 'card_title' ); ?>>
                        <?php
                            if ( $has_title ) {
                                $this->add_inline_editing_attributes( 'body_title' );
                                if ( empty( $settings['body_link']['url'] ) ) {
                                    ?>
                                    <span <?php echo $this->get_render_attribute_string( 'body_title' ); ?>>
                                        <?php echo materializor_kses_basic( $settings['body_title'] ); ?>
                                    </span>
                                    <?php
                                } else {
                                    $this->add_link_attributes( 'body_title', $settings['body_link'] );
                                    ?>
                                    <a <?php echo $this->get_render_attribute_string( 'body_title' ); ?>>
                                        <?php echo materializor_kses_basic( $settings['body_title'] ); ?>
                                    </a>
                                    <?php
                                }
                            }

                            if ( $show_reveal_icon ) {
                                Icons_Manager::render_icon(
                                    $settings['reveal_icon'],
                                    [
                                        'aria-hidden' => 'true',
                                        'class' => 'mtz-right mtz-activator',
                                    ]
                                );
                            }
                        ?>
                    </div>
                    <?php
                }

                if ( $has_content ) {
                    $this->add_render_attribute( 'body_content', 'class', 'mtz-card-content' );
                    $this->add_inline_editing_attributes( 'body_content', 'advanced' );
                    ?>
                    <div <?php echo $this->get_render_attribute_string( 'body_content' ); ?>>
                        <?php echo wp_kses_post( $this->parse_text_editor( $content ) ); ?>
                    </div>
                    <?php
                }
            ?>
        </div>
        <?php
    }

    /**
     * @param array $settings
     */
    protected function render_card_action( array $settings )
    {
        if ( 'yes' !== $settings['action_enabled'] || empty( $settings['action_items'] ) ) {
            return;
        }

        $this->add_render_attribute( 'card_action', 'class', 'mtz-card-action' );

        if ( MTZR_Material_Design_Icons::is_enabled() ) {
            $default_icon = [
                'library' => 'material-icons',
                'value' => 'material-icons mdi-launch'
            ];
        } else {
            $default_icon =  [
                'library' => 'solid',
                'value' => 'fas fas fa-link',
            ];
        }
        ?>
        <div class="mtz-card-action">
            <?php foreach ( $settings['action_items'] as $index => $item ) :
                $is_link   = 'link' === $item['type'];
                $is_button = 'btn' === $item['type'] || 'btn-flat' === $item['type'];
                $is_fab    = 'btn-floating' === $item['type'];
                $link_key  = 'link_' . $index;

                $this->add_render_attribute(
                    $link_key,
                    'class',
                    [
                        'mtz-' . $item['type'],
                        'elementor-repeater-item-' . $item['_id'],
                    ]
                );

                $this->add_link_attributes( $link_key, $item['link'] );
                ?>
                <a <?php echo $this->get_render_attribute_string( $link_key ); ?>>
                    <?php
                        if ( ! $is_link ) {
                            $icon_attrs = [ 'aria-hidden' => 'true' ];

                            if ( $is_fab && empty( $item['icon']['value'] ) ) {
                                $item['icon'] = $default_icon;
                            }

                            if ( ! empty( $item['icon']['value'] ) ) {
                                if ( $is_button ) {
                                    $icon_attrs['class'] = 'mtz-' . $item['icon_align'];
                                }

                                Icons_Manager::render_icon( $item['icon'], $icon_attrs );
                            }
                        }

                        if ( ! $is_fab ) {
                            echo esc_html( $item['text'] );
                        }
                    ?>
                </a>
            <?php endforeach; ?>
        </div>
        <?php
    }

    /**
     * @param array $settings
     */
    protected function render_card_reveal( array $settings )
    {
        if ( 'yes' !== $settings['reveal_enabled'] ) {
            return;
        }

        $this->add_inline_editing_attributes( 'reveal_title' );

        $this->add_render_attribute( 'reveal_content', 'class', 'mtz-card-content' );
        $this->add_inline_editing_attributes( 'reveal_content', 'advanced' );

	    $reveal_close_icon = [
		    'library' => 'solid',
		    'value' => 'fas fa-times',
	    ];
        ?>
        <div class="mtz-card-reveal">
            <div class="mtz-card-title">
                <span <?php echo $this->get_render_attribute_string( 'reveal_title' ); ?>>
                    <?php echo materializor_kses_basic( $settings['reveal_title'] ); ?>
                </span>
                <?php Icons_Manager::render_icon( $reveal_close_icon, [ 'aria-hidden' => 'true', 'class' => 'mtz-right' ] ); ?>
            </div>
            <div <?php echo $this->get_render_attribute_string( 'reveal_content' ); ?>>
                <?php echo wp_kses_post( $this->parse_text_editor( $settings['reveal_content'] ) ); ?>
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
        view.addRenderAttribute('card', 'class', ['mtz-card', 'mtz-card-' + settings.size]);
        if (settings.shadow) {
            view.addRenderAttribute('card', 'class', settings.shadow);
        }
        if (settings.hover_shadow) {
            view.addRenderAttribute('card', 'class', settings.hover_shadow);
        }
        #>
        <div class="mtz">
            <div {{{ view.getRenderAttributeString('card') }}}>
                <?php
                    $this->content_template_card_image();
                    $this->content_template_card_body();
                    $this->content_template_card_action();
                    $this->content_template_card_reveal();
                ?>
            </div>
        </div>
        <?php
    }

    /**
     *
     */
    protected function content_template_card_image()
    {
        ?>
        <#
        if (settings.image_enabled === 'yes' && settings.image.url) {
            var image = {
                id: settings.image.id,
                url: settings.image.url,
                size: settings.image_size,
                dimension: settings.image_custom_dimension,
                model: view.getEditModel()
            };

            var imageUrl = elementor.imagesManager.getImageUrl(image);
            if (!imageUrl) return;

            view.addRenderAttribute('card_image', 'class', 'mtz-card-image');
            if (settings.image_waves_enabled === 'yes' && settings.fab_enabled !== 'yes') {
                view.addRenderAttribute('card_image', 'class', 'mtz-waves-effect mtz-waves-block');
            }

            var imageLink = settings.image_link.url ? settings.image_link.url : false;

            var reveal = settings.reveal_enabled === 'yes';
            var revealOnImage = reveal && settings.reveal_trigger_image === 'yes';
            if (revealOnImage) view.addRenderAttribute('card_image', 'class', 'mtz-add-activator');
            #>
            <div {{{ view.getRenderAttributeString('card_image') }}}>
                <#
                if (!revealOnImage && imageLink) {
                    #><a href="{{ imageLink.url }}"><#
                }

                #><img src="{{ imageUrl }}" alt=""><#

                if (!revealOnImage && imageLink) {
                    #></a><#
                }

                if (settings.image_title && settings.image_title.length) {
                    view.addRenderAttribute('image_title', 'class', 'mtz-card-title');
                    view.addInlineEditingAttributes('image_title');
                    if (!revealOnImage && imageLink) {
                        view.addRenderAttribute('image_title', 'href', imageLink.url);
                        #><a {{{ view.getRenderAttributeString('image_title') }}}>{{{ settings.image_title }}}</a><#
                    } else {
                        if (revealOnImage) view.addRenderAttribute('image_title', 'class', 'mtz-activator');
                        #><span {{{ view.getRenderAttributeString('image_title') }}}>{{{ settings.image_title }}}</span><#
                    }
                }

                if (settings.fab_enabled === 'yes') {
                    view.addRenderAttribute('fab', 'class', ['mtz-btn-floating', 'mtz-halfway-fab', 'mtz-btn-'+settings.fab_size]);
                    if (settings.fab_position === 'left') view.addRenderAttribute('fab', 'class', 'mtz-left');
                    if (settings.fab_waves_enabled === 'yes') view.addRenderAttribute('fab', 'class', 'mtz-waves-effect');

                    if (reveal && settings.reveal_trigger_fab === 'yes') view.addRenderAttribute('fab', 'class', 'mtz-activator');
                    else if (settings.fab_link.url) view.addRenderAttribute('fab', 'href', settings.fab_link.url);

                    #>
                    <a {{{ view.getRenderAttributeString('fab') }}}>
                        {{{ elementor.helpers.renderIcon(view, settings.fab_icon) }}}
                    </a>
                    <#
                }
                #>
            </div>
            <#
        }
        #>
        <?php
    }

    /**
     *
     */
    protected function content_template_card_body()
    {
        ?>
        <#
        var hasContent = settings.body_content && settings.body_content.length;
        var reveal = settings.reveal_enabled === 'yes';
        var showRevealIcon = reveal && settings.reveal_trigger_icon === 'yes' && settings.reveal_icon.value;
        var hasTitle = settings.body_title && settings.body_title.length;

        if (hasContent || hasTitle || showRevealIcon) {
            view.addRenderAttribute('card_body', 'class', 'mtz-card-body');
            if (settings.reveal_enabled === 'yes' && (settings.action_enabled !== 'yes' || !settings.action_items || !!settings.action_items.length)) {
                view.addRenderAttribute('card_body', 'class', 'mtz-last-child');
            }
            #>
            <div {{{ view.getRenderAttributeString('card_body') }}}>
                <#
                if (hasTitle || showRevealIcon) {
                    view.addRenderAttribute('card_title', 'class', 'mtz-card-title');

                    if (showRevealIcon && !settings.body_link.url) view.addRenderAttribute('card_title', 'class', 'mtz-activator');
                    #>
                    <div {{{ view.getRenderAttributeString('card_title') }}}>
                        <#
                        if (hasTitle) {
                            view.addInlineEditingAttributes('body_title');
                            if (settings.body_link.url) {
                                #><a href="{{ settings.body_link.url }}">{{{ settings.body_title }}}</a><#
                            } else {
                                #><span>{{{ settings.body_title }}}</span><#
                            }
                        }

                        if (showRevealIcon) {
                            print(elementor.helpers.renderIcon(view, settings.reveal_icon, {class: 'mtz-right mtz-activator'}));
                        }
                        #>
                    </div>
                    <#
                }

                if (hasContent) {
                    view.addRenderAttribute('body_content', 'class', 'mtz-card-content');
                    view.addInlineEditingAttributes('body_content', 'advanced');
                    #>
                    <div {{{ view.getRenderAttributeString('body_content') }}}>
                        {{{ settings.body_content }}}
                    </div>
                    <#
                }
                #>
            </div>
            <#
        }
        #>
        <?php
    }

    /**
     *
     */
    protected function content_template_card_action()
    {
        ?>
        <#
        if (settings.action_enabled === 'yes' && settings.action_items && settings.action_items.length) {
            #>
            <div class="mtz-card-action">
                <#
                _.each(settings.action_items, function(item, index) {
                    var isLink   = item.type === 'link';
                    var isButton = item.type === 'btn' || item.type === 'btn-flat';
                    var isFAB    = item.type === 'btn-floating';
                    var linkKey  = 'link_' + index;

                    view.addRenderAttribute(linkKey, {
                        class: ['mtz-' + item.type, 'elementor-repeater-item-' + item._id],
                        href: item.link.url
                    });
                    #>
                    <a {{{ view.getRenderAttributeString(linkKey) }}}>
                        <#
                        if (!isLink) {
                            var itemIcon = item.icon;
                            var itemIconAttrs = {};

                            if (isFAB && !(itemIcon && itemIcon.value)) {
                                if (elementor.helpers.getIconLibrarySettings('material-icons')) {
                                    itemIcon = {
                                        library: 'material-icons',
                                        value: 'material-icons mdi-launch'
                                    };
                                } else {
                                    itemIcon = {
                                        library: 'fa-solid',
                                        value: 'fas fas fa-link'
                                    };
                                }
                            }

                            if (itemIcon && itemIcon.value) {
                                if (isButton) itemIconAttrs.class = 'mtz-' + item.icon_align;
                                #>{{{ elementor.helpers.renderIcon(view, itemIcon, itemIconAttrs) }}}<#
                            }
                        }

                        if (!isFAB) {
                            #>{{{ item.text }}}<#
                        }
                        #>
                    </a>
                    <#
                });
                #>
            </div>
            <#
        }
        #>
        <?php
    }

    /**
     *
     */
    protected function content_template_card_reveal()
    {
        ?>
        <#
        if (settings.reveal_enabled === 'yes') {
            view.addInlineEditingAttributes('reveal_title');

            view.addInlineEditingAttributes('reveal_content', 'advanced');
            view.addRenderAttribute('reveal_content', 'class', 'mtz-card-content');

            var revealCloseIcon;
            if (elementor.helpers.getIconLibrarySettings('material-icons')) {
                revealCloseIcon = {
                    library: 'material-icons',
                    value: 'material-icons mdi-close'
                };
            } else {
                revealCloseIcon = {
                    library: 'solid',
                    value: 'fas fa-times'
                };
            }
            #>
            <div class="mtz-card-reveal">
                <div class="mtz-card-title">
                    <span {{{ view.getRenderAttributeString('reveal_title') }}}>
                        {{{ settings.reveal_title }}}
                    </span>
                    {{{ elementor.helpers.renderIcon(view, revealCloseIcon, {class: 'mtz-right'}) }}}
                </div>
                <div {{{ view.getRenderAttributeString('reveal_content') }}}>
                    {{{ settings.reveal_content }}}
                </div>
            </div>
            <#
        }
        #>
        <?php
    }
}