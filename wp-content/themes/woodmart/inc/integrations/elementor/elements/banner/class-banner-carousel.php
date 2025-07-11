<?php
/**
 * Banners carousel map.
 *
 * @package Woodmart
 */

namespace XTS\Elementor;

use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

/**
 * Elementor widget that inserts an embeddable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Banner_Carousel extends Widget_Base {
	/**
	 * Get widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'wd_banner_carousel';
	}

	/**
	 * Get widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Banners carousel', 'woodmart' );
	}

	/**
	 * Get widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'wd-icon-banner-carousel';
	}

	/**
	 * Get widget categories.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return array( 'wd-elements' );
	}

	/**
	 * Register the widget controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {
		/**
		 * Content tab.
		 */

		/**
		 * General settings.
		 */
		$this->start_controls_section(
			'general_content_section',
			array(
				'label' => esc_html__( 'General', 'woodmart' ),
			)
		);

		$this->add_control(
			'extra_width_classes',
			array(
				'type'         => 'wd_css_class',
				'default'      => 'wd-width-100',
				'prefix_class' => '',
			)
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'banner_tabs' );

		$repeater->start_controls_tab(
			'link_tab',
			array(
				'label' => esc_html__( 'Link', 'woodmart' ),
			)
		);

		$repeater->add_control(
			'link',
			array(
				'label'       => esc_html__( 'Link', 'woodmart' ),
				'description' => esc_html__( 'Enter URL if you want this banner to have a link.', 'woodmart' ),
				'type'        => Controls_Manager::URL,
				'default'     => array(
					'url'         => '#',
					'is_external' => false,
					'nofollow'    => false,
				),
			)
		);

		$repeater->end_controls_tab();

		$repeater->start_controls_tab(
			'image_tab',
			array(
				'label' => esc_html__( 'Background', 'woodmart' ),
			)
		);

		$repeater->add_control(
			'source_type',
			array(
				'label'   => esc_html__( 'Source', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'image' => esc_html__( 'Image', 'woodmart' ),
					'video' => esc_html__( 'Video', 'woodmart' ),
				),
				'default' => 'image',
			)
		);

		$repeater->add_control(
			'video',
			array(
				'label'      => esc_html__( 'Choose video', 'woodmart' ),
				'type'       => Controls_Manager::MEDIA,
				'media_type' => 'video',
				'condition'  => array(
					'source_type' => 'video',
				),
			)
		);

		$repeater->add_control(
			'video_poster',
			array(
				'label'     => esc_html__( 'Fallback image', 'woodmart' ),
				'type'      => Controls_Manager::MEDIA,
				'condition' => array(
					'source_type' => 'video',
				),
			)
		);

		$repeater->add_group_control(
			Group_Control_Image_Size::get_type(),
			array(
				'name'           => 'video_poster',
				'fields_options' => array(
					'size'             => array(
						'label' => esc_html__( 'Fallback image size', 'woodmart' ),
					),
					'custom_dimension' => array(
						'label' => esc_html__( 'Fallback image Dimension', 'woodmart' ),
					),
				),
				'default'        => 'full',
				'separator'      => 'none',
				'condition'      => array(
					'source_type' => 'video',
				),
			)
		);

		$repeater->add_control(
			'image',
			array(
				'label'     => esc_html__( 'Choose image', 'woodmart' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => array(
					'url' => Utils::get_placeholder_image_src(),
				),
				'condition' => array(
					'source_type' => 'image',
				),
			)
		);

		$repeater->add_group_control(
			Group_Control_Image_Size::get_type(),
			array(
				'name'      => 'image',
				'default'   => 'thumbnail',
				'separator' => 'none',
				'condition' => array(
					'source_type' => 'image',
				),
			)
		);

		$repeater->add_control(
			'custom_height',
			array(
				'label'        => esc_html__( 'Fixed height', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'label_on'     => esc_html__( 'Yes', 'woodmart' ),
				'label_off'    => esc_html__( 'No', 'woodmart' ),
				'return_value' => 'Yes',
			)
		);

		$repeater->add_responsive_control(
			'image_height',
			array(
				'label'     => esc_html__( 'Banner height', 'woodmart' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'size' => 340,
				),
				'range'     => array(
					'px' => array(
						'min'  => 100,
						'max'  => 2000,
						'step' => 1,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} {{CURRENT_ITEM}}' => '--wd-img-height: {{SIZE}}{{UNIT}};',
				),
				'condition' => array(
					'custom_height' => array( 'Yes' ),
				),
			)
		);

		$repeater->add_control(
			'image_bg_position',
			array(
				'label'     => esc_html__( 'Background position', 'woodmart' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'center center' => esc_html__( 'Center', 'woodmart' ),
					'center top'    => esc_html__( 'Top', 'woodmart' ),
					'center bottom' => esc_html__( 'Bottom', 'woodmart' ),
					'left center'   => esc_html__( 'Left', 'woodmart' ),
					'right center'  => esc_html__( 'Right', 'woodmart' ),
				),
				'default'   => 'center center',
				'selectors' => array(
					'{{WRAPPER}} {{CURRENT_ITEM}} .banner-image' => 'object-position: {{VALUE}};',
				),
				'condition' => array(
					'custom_height' => array( 'Yes' ),
					'source_type'   => 'image',
				),
			)
		);

		$repeater->end_controls_tab();

		$repeater->start_controls_tab(
			'text_tab',
			array(
				'label' => esc_html__( 'Text', 'woodmart' ),
			)
		);

		$repeater->add_control(
			'subtitle',
			array(
				'label'   => esc_html__( 'Subtitle', 'woodmart' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => 'Banner subtitle text',
			)
		);

		$repeater->add_control(
			'title',
			array(
				'label'   => esc_html__( 'Title', 'woodmart' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => 'Banner title, click to edit.',
			)
		);

		$repeater->add_control(
			'content',
			array(
				'label' => esc_html__( 'Content', 'woodmart' ),
				'type'  => Controls_Manager::TEXTAREA,
			)
		);

		$repeater->add_control(
			'show_countdown',
			array(
				'label'        => esc_html__( 'Show countdown', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'label_on'     => esc_html__( 'Yes', 'woodmart' ),
				'label_off'    => esc_html__( 'No', 'woodmart' ),
				'return_value' => 'yes',
			)
		);

		$repeater->add_control(
			'date',
			array(
				'label'   => esc_html__( 'Date', 'woodmart' ),
				'type'    => Controls_Manager::DATE_TIME,
				'default' => date( 'Y-m-d', strtotime( ' +2 months' ) ),
				'condition' => array(
					'show_countdown' => array( 'yes' ),
				),
			)
		);

		$repeater->add_control(
			'btn_text',
			array(
				'label'   => esc_html__( 'Button text', 'woodmart' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'Read more',
			)
		);

		$repeater->end_controls_tab();

		$repeater->start_controls_tab(
			'layout_tab',
			array(
				'label' => esc_html__( 'Layout', 'woodmart' ),
			)
		);

		$repeater->add_control(
			'horizontal_alignment',
			array(
				'label'   => esc_html__( 'Content horizontal alignment', 'woodmart' ),
				'type'    => 'wd_buttons',
				'options' => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'woodmart' ),
						'image' => WOODMART_ASSETS_IMAGES . '/settings/content-align/horizontal/left.png',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'woodmart' ),
						'image' => WOODMART_ASSETS_IMAGES . '/settings/content-align/horizontal/center.png',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'woodmart' ),
						'image' => WOODMART_ASSETS_IMAGES . '/settings/content-align/horizontal/right.png',
					),
				),
				'default' => 'left',
			)
		);

		$repeater->add_control(
			'vertical_alignment',
			array(
				'label'   => esc_html__( 'Content vertical alignment', 'woodmart' ),
				'type'    => 'wd_buttons',
				'options' => array(
					'top'    => array(
						'title' => esc_html__( 'Top', 'woodmart' ),
						'image' => WOODMART_ASSETS_IMAGES . '/settings/content-align/vertical/top.png',
					),
					'middle' => array(
						'title' => esc_html__( 'Middle', 'woodmart' ),
						'image' => WOODMART_ASSETS_IMAGES . '/settings/content-align/vertical/middle.png',
					),
					'bottom' => array(
						'title' => esc_html__( 'Bottom', 'woodmart' ),
						'image' => WOODMART_ASSETS_IMAGES . '/settings/content-align/vertical/bottom.png',
					),
				),
				'default' => 'top',
			)
		);

		$repeater->add_control(
			'text_alignment',
			array(
				'label'   => esc_html__( 'Text alignment', 'woodmart' ),
				'type'    => 'wd_buttons',
				'options' => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'woodmart' ),
						'image' => WOODMART_ASSETS_IMAGES . '/settings/align/left.jpg',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'woodmart' ),
						'image' => WOODMART_ASSETS_IMAGES . '/settings/align/center.jpg',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'woodmart' ),
						'image' => WOODMART_ASSETS_IMAGES . '/settings/align/right.jpg',
					),
				),
				'default' => 'left',
			)
		);

		$repeater->add_responsive_control(
			'width',
			array(
				'label'          => esc_html__( 'Width', 'woodmart' ),
				'type'           => Controls_Manager::SLIDER,
				'default'        => array(
					'unit' => '%',
				),
				'tablet_default' => array(
					'unit' => '%',
				),
				'mobile_default' => array(
					'unit' => '%',
				),
				'size_units'     => array( '%', 'px' ),
				'range'          => array(
					'%'  => array(
						'min' => 1,
						'max' => 100,
					),
					'px' => array(
						'min' => 1,
						'max' => 1000,
					),
				),
				'selectors'      => array(
					'{{WRAPPER}} {{CURRENT_ITEM}} .promo-banner:not(.banner-content-background) .content-banner, {{WRAPPER}} {{CURRENT_ITEM}} .promo-banner.banner-content-background .wrapper-content-banner' => 'max-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$repeater->add_control(
			'increase_spaces',
			array(
				'label'        => esc_html__( 'Increase spaces', 'woodmart' ),
				'description'  => esc_html__( 'Suggest to use this option if you have large banners. Padding will be set in percentage to your screen width.', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'label_on'     => esc_html__( 'Yes', 'woodmart' ),
				'label_off'    => esc_html__( 'No', 'woodmart' ),
				'return_value' => 'yes',
			)
		);

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		/**
		 * Repeater settings
		 */
		$this->add_control(
			'content_repeater',
			array(
				'type'        => Controls_Manager::REPEATER,
				'title_field' => '{{{ title }}}',
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'title'    => 'Banner title, click to edit.',
						'subtitle' => 'Banner subtitle text',
					),
					array(
						'title'    => 'Banner title, click to edit.',
						'subtitle' => 'Banner subtitle text',
					),
					array(
						'title'    => 'Banner title, click to edit.',
						'subtitle' => 'Banner subtitle text',
					),
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Style tab.
		 */

		/**
		 * General settings.
		 */
		$this->start_controls_section(
			'general_style_section',
			array(
				'label' => esc_html__( 'General', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'style',
			array(
				'label'       => esc_html__( 'Style', 'woodmart' ),
				'description' => esc_html__( 'You can use some of our predefined styles for your banner content.', 'woodmart' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'default'            => esc_html__( 'Default', 'woodmart' ),
					'mask'               => esc_html__( 'Color mask', 'woodmart' ),
					'shadow'             => esc_html__( 'Mask with shadow', 'woodmart' ),
					'border'             => esc_html__( 'Bordered', 'woodmart' ),
					'background'         => esc_html__( 'Bordered background', 'woodmart' ),
					'content-background' => esc_html__( 'Content background', 'woodmart' ),
				),
				'default'     => 'default',
			)
		);

		$this->add_control(
			'hover',
			array(
				'label'       => esc_html__( 'Hover effect', 'woodmart' ),
				'description' => esc_html__( 'Set beautiful hover effects for your banner.', 'woodmart' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'zoom'         => esc_html__( 'Zoom image', 'woodmart' ),
					'parallax'     => esc_html__( 'Parallax', 'woodmart' ),
					'background'   => esc_html__( 'Background', 'woodmart' ),
					'border'       => esc_html__( 'Bordered', 'woodmart' ),
					'zoom-reverse' => esc_html__( 'Zoom reverse', 'woodmart' ),
					'none'         => esc_html__( 'Disable', 'woodmart' ),
				),
				'default'     => 'none',
			)
		);

		$this->add_control(
			'rounding_size',
			array(
				'label'     => esc_html__( 'Rounding', 'woodmart' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					''       => esc_html__( 'Inherit', 'woodmart' ),
					'0'      => esc_html__( '0', 'woodmart' ),
					'5'      => esc_html__( '5', 'woodmart' ),
					'8'      => esc_html__( '8', 'woodmart' ),
					'12'     => esc_html__( '12', 'woodmart' ),
					'custom' => esc_html__( 'Custom', 'woodmart' ),
				),
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}}' => '--wd-brd-radius: {{VALUE}}px;',
				),
			)
		);

		$this->add_control(
			'custom_rounding_size',
			array(
				'label'      => esc_html__( 'Custom rounding', 'woodmart' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( '%', 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 1,
						'max'  => 300,
						'step' => 1,
					),
					'%'  => array(
						'min'  => 1,
						'max'  => 100,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}}' => '--wd-brd-radius: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'rounding_size' => array( 'custom' ),
				),
			)
		);

		$this->add_control(
			'woodmart_color_scheme',
			array(
				'label'   => esc_html__( 'Color scheme', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					''      => esc_html__( 'Inherit', 'woodmart' ),
					'light' => esc_html__( 'Light', 'woodmart' ),
					'dark'  => esc_html__( 'Dark', 'woodmart' ),
				),
				'default' => '',
			)
		);

		$this->add_control(
			'title_size',
			array(
				'label'   => esc_html__( 'Predefined size', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'default'     => esc_html__( 'Default (22px)', 'woodmart' ),
					'small'       => esc_html__( 'Small (16px)', 'woodmart' ),
					'large'       => esc_html__( 'Large (26px)', 'woodmart' ),
					'extra-large' => esc_html__( 'Extra Large (36px)', 'woodmart' ),
				),
				'default' => 'default',
			)
		);

		$this->add_control(
			'custom_content_bg_color',
			array(
				'label'     => esc_html__( 'Content background color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wrapper-content-banner' => 'background-color: {{VALUE}}',
				),
				'condition' => array(
					'style' => 'content-background',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Title settings.
		 */
		$this->start_controls_section(
			'title_style_section',
			array(
				'label' => esc_html__( 'Title', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'title_tag',
			array(
				'label'   => esc_html__( 'Tag', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'h1'   => esc_html__( 'h1', 'woodmart' ),
					'h2'   => esc_html__( 'h2', 'woodmart' ),
					'h3'   => esc_html__( 'h3', 'woodmart' ),
					'h4'   => esc_html__( 'h4', 'woodmart' ),
					'h5'   => esc_html__( 'h5', 'woodmart' ),
					'h6'   => esc_html__( 'h6', 'woodmart' ),
					'p'    => esc_html__( 'p', 'woodmart' ),
					'div'  => esc_html__( 'div', 'woodmart' ),
					'span' => esc_html__( 'span', 'woodmart' ),
				),
				'default' => 'h4',
			)
		);

		$this->add_control(
			'title_decoration_style',
			array(
				'label'       => esc_html__( 'Highlight text style', 'woodmart' ),
				'description' => esc_html__( 'The text must be wrapped with the <u></u> tag to highlight it.', 'woodmart' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'default'     => esc_html__( 'Default', 'woodmart' ),
					'colored'     => esc_html__( 'Primary color', 'woodmart' ),
					'colored-alt' => esc_html__( 'Primary color + secondary font', 'woodmart' ),
					'bordered'    => esc_html__( 'Bordered', 'woodmart' ),
				),
				'default'     => 'default',
			)
		);

		$this->add_control(
			'custom_title_color',
			array(
				'label'     => esc_html__( 'Color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .banner-title' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Custom typography', 'woodmart' ),
				'selector' => '{{WRAPPER}} .banner-title',
			)
		);

		$this->end_controls_section();

		/**
		 * Subtitle settings.
		 */
		$this->start_controls_section(
			'subtitle_style_section',
			array(
				'label' => esc_html__( 'Subtitle', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'subtitle_style',
			array(
				'label'   => esc_html__( 'Subtitle style', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'default'    => esc_html__( 'Default', 'woodmart' ),
					'background' => esc_html__( 'Background', 'woodmart' ),
				),
				'default' => 'default',
			)
		);

		$this->add_control(
			'subtitle_color',
			array(
				'label'   => esc_html__( 'Predefined color', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'default' => esc_html__( 'Default', 'woodmart' ),
					'primary' => esc_html__( 'Primary', 'woodmart' ),
					'alt'     => esc_html__( 'Alternative', 'woodmart' ),
				),
				'default' => 'default',
			)
		);

		$this->add_control(
			'custom_subtitle_color',
			array(
				'label'     => esc_html__( 'Color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .banner-subtitle' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'custom_subtitle_bg_color',
			array(
				'label'     => esc_html__( 'Background color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .banner-subtitle' => 'background-color: {{VALUE}}',
				),
				'condition' => array(
					'subtitle_style' => array( 'background' ),
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'subtitle_typography',
				'label'    => esc_html__( 'Custom typography', 'woodmart' ),
				'selector' => '{{WRAPPER}} .banner-subtitle',
			)
		);

		$this->end_controls_section();

		/**
		 * Content settings.
		 */
		$this->start_controls_section(
			'content_style_section',
			array(
				'label' => esc_html__( 'Content', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'content_text_size',
			array(
				'label'   => esc_html__( 'Predefined size', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'default' => esc_html__( 'Default (14px)', 'woodmart' ),
					'medium'  => esc_html__( 'Medium (16px)', 'woodmart' ),
					'large'   => esc_html__( 'Large (18px)', 'woodmart' ),
				),
				'default' => 'default',
			)
		);

		$this->add_control(
			'custom_text_color',
			array(
				'label'     => esc_html__( 'Color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .banner-inner' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'text_typography',
				'label'    => esc_html__( 'Custom typography', 'woodmart' ),
				'selector' => '{{WRAPPER}} .banner-inner',
			)
		);

		$this->end_controls_section();

		/**
		 * Countdown settings.
		 */
		$this->start_controls_section(
			'countdown_style_section',
			array(
				'label' => esc_html__( 'Countdown', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'countdown_style',
			[
				'label'   => esc_html__( 'Style', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'standard'    => esc_html__( 'Default', 'woodmart' ),
					'transparent' => esc_html__( 'Shadow', 'woodmart' ),
					'active'      => esc_html__( 'Primary color', 'woodmart' ),
					'simple'      => esc_html__( 'Simple', 'woodmart' ),
				],
				'default' => 'standard',
			]
		);

		$this->add_control(
			'countdown_color_scheme',
			[
				'label'   => esc_html__( 'Color scheme', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					''      => esc_html__( 'Inherit', 'woodmart' ),
					'light' => esc_html__( 'Light', 'woodmart' ),
					'dark'  => esc_html__( 'Dark', 'woodmart' ),
				],
				'default' => '',
			]
		);

		$this->add_control(
			'countdown_size',
			[
				'label'   => esc_html__( 'Predefined size', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'small'  => esc_html__( 'Small (20px)', 'woodmart' ),
					'medium' => esc_html__( 'Medium (24px)', 'woodmart' ),
					'large'  => esc_html__( 'Large (28px)', 'woodmart' ),
					'xlarge' => esc_html__( 'Extra Large (42px)', 'woodmart' ),
				],
				'default' => 'medium',
			]
		);

		$this->end_controls_section();

		/**
		 * Button settings.
		 */
		$this->start_controls_section(
			'button_style_section',
			array(
				'label' => esc_html__( 'Button', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'btn_position',
			array(
				'label'     => esc_html__( 'Button position', 'woodmart' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'hover'  => esc_html__( 'Show on hover', 'woodmart' ),
					'static' => esc_html__( 'Static', 'woodmart' ),
				),
				'default'   => 'hover',
				'condition' => array(
					'style!' => 'content-background',
				),
			)
		);

		$this->add_control(
			'btn_size',
			array(
				'label'   => esc_html__( 'Predefined size', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'default'     => esc_html__( 'Default', 'woodmart' ),
					'extra-small' => esc_html__( 'Extra Small', 'woodmart' ),
					'small'       => esc_html__( 'Small', 'woodmart' ),
					'large'       => esc_html__( 'Large', 'woodmart' ),
					'extra-large' => esc_html__( 'Extra Large', 'woodmart' ),
				),
				'default' => 'default',
			)
		);

		$this->add_control(
			'btn_color',
			array(
				'label'   => esc_html__( 'Predefined color', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'default' => esc_html__( 'Default', 'woodmart' ),
					'primary' => esc_html__( 'Primary', 'woodmart' ),
					'alt'     => esc_html__( 'Alternative', 'woodmart' ),
					'black'   => esc_html__( 'Black', 'woodmart' ),
					'white'   => esc_html__( 'White', 'woodmart' ),
					'custom'  => esc_html__( 'Custom', 'woodmart' ),
				),
				'default' => 'default',
			)
		);

		$this->start_controls_tabs(
			'button_tabs_style',
			array(
				'condition' => array(
					'color' => array( 'custom' ),
				),
			)
		);

		$this->start_controls_tab(
			'button_tab_normal',
			array(
				'label' => esc_html__( 'Normal', 'woodmart' ),
			)
		);

		$this->add_control(
			'bg_color',
			array(
				'label'     => esc_html__( 'Background color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wd-button-wrapper a' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'color_scheme',
			array(
				'label'   => esc_html__( 'Text color scheme', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'inherit' => esc_html__( 'Inherit', 'woodmart' ),
					'dark'    => esc_html__( 'Dark', 'woodmart' ),
					'light'   => esc_html__( 'Light', 'woodmart' ),
				),
				'default' => 'inherit',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'button_tab_hover',
			array(
				'label' => esc_html__( 'Hover', 'woodmart' ),
			)
		);

		$this->add_control(
			'bg_color_hover',
			array(
				'label'     => esc_html__( 'Background color hover', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wd-button-wrapper:hover a' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'color_scheme_hover',
			array(
				'label'   => esc_html__( 'Text color scheme on hover', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'inherit' => esc_html__( 'Inherit', 'woodmart' ),
					'dark'    => esc_html__( 'Dark', 'woodmart' ),
					'light'   => esc_html__( 'Light', 'woodmart' ),
				),
				'default' => 'inherit',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'btn_style',
			array(
				'label'   => esc_html__( 'Style', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'default'  => esc_html__( 'Flat', 'woodmart' ),
					'bordered' => esc_html__( 'Bordered', 'woodmart' ),
					'link'     => esc_html__( 'Link button', 'woodmart' ),
					'3d'       => esc_html__( '3D', 'woodmart' ),
				),
				'default' => 'default',
			)
		);

		$this->add_control(
			'btn_shape',
			array(
				'label'     => esc_html__( 'Shape', 'woodmart' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'rectangle'  => esc_html__( 'Rectangle', 'woodmart' ),
					'round'      => esc_html__( 'Round', 'woodmart' ),
					'semi-round' => esc_html__( 'Rounded', 'woodmart' ),
				),
				'condition' => array(
					'btn_style!' => array( 'link' ),
				),
				'default'   => 'rectangle',
			)
		);

		$this->add_control(
			'button_icon_heading',
			array(
				'label'     => esc_html__( 'Icon', 'woodmart' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		woodmart_get_button_style_icon_map( $this, 'btn_' );

		$this->add_control(
			'button_layout_heading',
			array(
				'label'     => esc_html__( 'Layout', 'woodmart' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'full_width',
			array(
				'label'        => esc_html__( 'Full width', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'label_on'     => esc_html__( 'Yes', 'woodmart' ),
				'label_off'    => esc_html__( 'No', 'woodmart' ),
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'button_hr',
			array(
				'type'  => Controls_Manager::DIVIDER,
				'style' => 'thick',
			)
		);

		$this->add_control(
			'hide_btn_tablet',
			array(
				'label'        => esc_html__( 'Hide button on tablet', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'label_on'     => esc_html__( 'Yes', 'woodmart' ),
				'label_off'    => esc_html__( 'No', 'woodmart' ),
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'hide_btn_mobile',
			array(
				'label'        => esc_html__( 'Hide button on mobile', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'label_on'     => esc_html__( 'Yes', 'woodmart' ),
				'label_off'    => esc_html__( 'No', 'woodmart' ),
				'return_value' => 'yes',
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function render() {
		woodmart_elementor_banner_carousel_template( $this->get_settings_for_display(), $this );
	}
}

Plugin::instance()->widgets_manager->register( new Banner_Carousel() );
