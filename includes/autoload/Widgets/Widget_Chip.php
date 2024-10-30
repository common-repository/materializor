<?php

namespace Materializor\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Icons_Manager;
use Elementor\Utils;
use Materializor\Assets\MTZR_Material_Design_Icons;

/**
 * Class MTZR_Widget_Chip
 * @package Materializor\Widgets
 * @since 1.0.0
 */
class MTZR_Widget_Chip extends MTZR_Widget
{
    /**
     * @return string
     */
    public function get_name()
    {
        return 'materializor-chip';
    }

    /**
     * @return string
     */
    public function get_title()
    {
        return esc_html__( 'Chip', 'materializor' );
    }

    /**
     * @return string[]
     */
    public function get_keywords()
    {
        return [
            'material design',
            'block',
            'action',
            'input',
            'attribute',
            'tag',
            'label',
        ];
    }

    /**
     *
     */
    protected function register_controls()
    {
        $this->start_controls_section(
            'chip_content_section',
            [
                'label' => esc_html__( 'Chip', 'materializor' ),
                'tab' => Controls_Manager::TAB_CONTENT,
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
                'default' => esc_html__( 'Chip', 'materializor' ),
                'placeholder' => esc_html__( 'Chip', 'materializor' ),
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
            'image',
            [
                'label' => esc_html__( 'Choose Image', 'materializor' ),
                'type' => Controls_Manager::MEDIA,
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'image',
                'default' => 'thumbnail',
                'separator' => 'none',
            ]
        );

        $this->add_control(
            'close',
            [
                'label' => esc_html__( 'Deletable', 'materializor' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'description' => esc_html__( 'It will not hide in edit mode', 'materializor' ),
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
                ],
                'prefix_class' => 'elementor%s-align-',
            ]
        );

        $this->add_control(
            'chip_css_id',
            [
                'label' => esc_html__( 'Chip ID', 'materializor' ),
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
            'chip_style_section',
            [
                'label' => esc_html__( 'Chip', 'materializor' ),
                'tab' => Controls_Manager::TAB_STYLE,
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

        $this->start_controls_tabs( 'chip_states' );

        $this->start_controls_tab(
            'chip_normal',
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
                    '{{WRAPPER}} .mtz-chip' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => esc_html__( 'Text Color', 'materializor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mtz-chip' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'chip_hover',
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
                    '{{WRAPPER}} .mtz-chip:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'hover_text_color',
            [
                'label' => esc_html__( 'Text Color', 'materializor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mtz-chip:hover' => 'color: {{VALUE}};',
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

        if ( ! empty( $settings['chip_css_id'] ) ) {
            $this->add_render_attribute( 'chip', 'id', $settings['chip_css_id'] );
        }

        $this->add_render_attribute( 'chip', 'class', 'mtz-chip' );

        if ( empty( $settings['link']['url'] ) ) {
            $tag = 'div';
        } else {
            $tag = 'a';
            $this->add_link_attributes( 'chip', $settings['link'] );
        }

        if ( 'yes' === $settings['waves_enabled'] ) {
            $this->add_render_attribute( 'chip', 'class', 'mtz-waves-effect' );
        }
        if ( ! empty( $settings['shadow'] ) ) {
            $this->add_render_attribute( 'chip', 'class', $settings['shadow'] );
        }
        if ( ! empty( $settings['hover_shadow'] ) ) {
            $this->add_render_attribute( 'chip', 'class', $settings['hover_shadow'] );
        }

        ?>
        <div class="mtz">
            <<?php echo esc_html( $tag ) . ' ' . $this->get_render_attribute_string( 'chip' ); ?>>
                <?php
                    if ( ! empty( $settings['image']['url'] ) ) {
                        echo Group_Control_Image_Size::get_attachment_image_html( $settings );
                    }

                    ?>
                    <span><?php echo esc_html( $settings['text'] ); ?></span>
                    <?php

                    if ( 'yes' === $settings['close'] ) {
	                    $close_icon = [
		                    'library' => 'solid',
		                    'value' => 'fas fa-times',
	                    ];

                        Icons_Manager::render_icon( $close_icon, [ 'aria-hidden' => 'true', 'class' => 'mtz-close' ] );
                    }
                ?>
            </<?php echo esc_html( $tag ); ?>>
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
        if (settings.chip_css_id) view.addRenderAttribute('chip', 'id', settings.chip_css_id);
        view.addRenderAttribute('chip', 'class', 'mtz-chip');

        var imageUrl;
        if (settings.image && settings.image.url) {
            var image = {
                id: settings.image.id,
                url: settings.image.url,
                size: settings.image_size,
                dimension: settings.image_custom_dimension,
                model: view.getEditModel()
            };
            imageUrl = elementor.imagesManager.getImageUrl(image);
        }

        var chipTag = 'div';
        if (settings.link && settings.link.url) {
            view.addRenderAttribute('chip', 'href', settings.link.url);
            chipTag = 'a';
        }

        if (settings.waves_enabled === 'yes') view.addRenderAttribute('chip', 'class', 'mtz-waves-effect');
        if (settings.shadow) view.addRenderAttribute('chip', 'class', settings.shadow);
        if (settings.hover_shadow) view.addRenderAttribute('chip', 'class', settings.hover_shadow);

        var closeIcon = false;
        if ('yes' === settings.close) {
            if (elementor.helpers.getIconLibrarySettings('material-icons')) {
                closeIcon = {
                    library: 'material-icons',
                    value: 'material-icons mdi-close'
                }
            } else {
                closeIcon = {
                    library: 'fa-solid',
                    value: 'fas fa-times'
                }
            }
        }
        #>
        <div class="mtz">
            <{{{ chipTag }}} {{{ view.getRenderAttributeString('chip') }}}>
                <#
                    if (imageUrl) {
                        #><img src="{{ imageUrl }}" alt=""><#
                    }

                    #>
                    <span>{{ settings.text }}</span>
                    <#

                    if (closeIcon) {
                        print(elementor.helpers.renderIcon(view, closeIcon, {class: 'mtz-close'}));
                    }
                #>
            </{{{ chipTag }}}>
        </div>
        <?php
    }

}