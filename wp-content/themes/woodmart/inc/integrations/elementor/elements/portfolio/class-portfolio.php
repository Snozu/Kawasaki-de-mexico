<?php
/**
 * Portfolio map.
 */

namespace XTS\Elementor;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

/**
 * Elementor widget that inserts an embeddable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Portfolio extends Widget_Base {
	/**
	 * Get widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'wd_portfolio';
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
		return esc_html__( 'Portfolio', 'woodmart' );
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
		return 'wd-icon-portfolio';
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
		return [ 'wd-elements' ];
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
			[
				'label' => esc_html__( 'General', 'woodmart' ),
			]
		);

		$this->add_control(
			'extra_width_classes',
			array(
				'type'         => 'wd_css_class',
				'default'      => 'wd-width-100',
				'prefix_class' => '',
			)
		);

		$this->add_control(
			'element_title',
			[
				'label' => esc_html__( 'Element title', 'woodmart' ),
				'type'  => Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'post_type',
			[
				'label'       => esc_html__( 'Data source', 'woodmart' ),
				'description' => esc_html__( 'Select content type for your grid.', 'woodmart' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => woodmart_get_options_depend_builder(
					array(
						'portfolio' => esc_html__( 'Portfolio', 'woodmart' ),
						'ids'       => esc_html__( 'List of IDs', 'woodmart' ),
					),
					array(
						'single_portfolio' => array(
							'related_projects' => esc_html__( 'Related projects', 'woodmart' ),
						),
					)
				),
				'default'     => 'portfolio',
			]
		);

		$this->add_control(
			'include',
			[
				'label'       => esc_html__( 'Include only', 'woodmart' ),
				'description' => esc_html__( 'Add posts, pages, etc. by title.', 'woodmart' ),
				'type'        => 'wd_autocomplete',
				'search'      => 'woodmart_get_posts_by_query',
				'render'      => 'woodmart_get_posts_title_by_id',
				'post_type'   => 'portfolio',
				'multiple'    => true,
				'label_block' => true,
				'condition'   => [
					'post_type' => 'ids',
				],
			]
		);

		$this->add_control(
			'categories',
			[
				'label'       => esc_html__( 'Categories or tags', 'woodmart' ),
				'description' => esc_html__( 'List of portfolio categories.', 'woodmart' ),
				'type'        => 'wd_autocomplete',
				'search'      => 'woodmart_get_taxonomies_by_query',
				'render'      => 'woodmart_get_taxonomies_title_by_id',
				'taxonomy'    => [ 'project-cat' ],
				'multiple'    => true,
				'label_block' => true,
				'condition'   => [
					'post_type!' => array( 'ids', 'related_projects' ),
				]
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'   => esc_html__( 'Order by', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => array(
					''           => '',
					'date'       => esc_html__( 'Date', 'woodmart' ),
					'id'         => esc_html__( 'ID', 'woodmart' ),
					'title'      => esc_html__( 'Title', 'woodmart' ),
					'modified'   => esc_html__( 'Last modified date', 'woodmart' ),
					'menu_order' => esc_html__( 'Menu order', 'woodmart' ),
				),
				'condition'   => [
					'post_type!' => array( 'ids', 'related_projects' ),
				]
			]
		);

		$this->add_control(
			'order',
			[
				'label'   => esc_html__( 'Sort order', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => array(
					''     => esc_html__( 'Inherit', 'woodmart' ),
					'DESC' => esc_html__( 'Descending', 'woodmart' ),
					'ASC'  => esc_html__( 'Ascending', 'woodmart' ),
				),
				'condition'   => [
					'post_type!' => array( 'ids', 'related_projects' ),
				],
			]
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
			[
				'label' => esc_html__( 'General', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'layout',
			[
				'label'   => esc_html__( 'Layout', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'grid'     => esc_html__( 'Grid', 'woodmart' ),
					'carousel' => esc_html__( 'Carousel', 'woodmart' ),
				],
				'default' => 'grid',
			]
		);

		$this->add_control(
			'style',
			[
				'label'   => esc_html__( 'Style', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'inherit'       => esc_html__( 'Inherit from Theme Settings', 'woodmart' ),
					'hover'         => esc_html__( 'Show text on mouse over', 'woodmart' ),
					'hover-inverse' => esc_html__( 'Alternative', 'woodmart' ),
					'text-shown'    => esc_html__( 'Text under image', 'woodmart' ),
					'parallax'      => esc_html__( 'Mouse move parallax', 'woodmart' ),
				],
				'default' => 'inherit',
			]
		);

		$this->add_control(
			'posts_per_page',
			[
				'label' => esc_html__( 'Number of projects per page', 'woodmart' ),
				'type'  => Controls_Manager::TEXT,
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label'       => esc_html__( 'Columns', 'woodmart' ),
				'description' => esc_html__( 'Number of columns in the grid.', 'woodmart' ),
				'type'        => Controls_Manager::SLIDER,
				'default'     => [
					'size' => 4,
				],
				'size_units'  => '',
				'condition'   => [
					'layout' => 'grid',
				],
				'range'       => [
					'px' => [
						'min'  => 1,
						'max'  => 6,
						'step' => 1,
					],
				],
				'devices'     => array( 'desktop', 'tablet', 'mobile' ),
				'classes'     => 'wd-hide-custom-breakpoints',
			]
		);

		$this->add_responsive_control(
			'spacing',
			[
				'label'   => esc_html__( 'Space between', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'' => esc_html__( 'Inherit from Theme Settings', 'woodmart' ),
					0  => esc_html__( '0 px', 'woodmart' ),
					2  => esc_html__( '2 px', 'woodmart' ),
					6  => esc_html__( '6 px', 'woodmart' ),
					10 => esc_html__( '10 px', 'woodmart' ),
					20 => esc_html__( '20 px', 'woodmart' ),
					30 => esc_html__( '30 px', 'woodmart' ),
				],
				'default' => '',
				'devices' => array( 'desktop', 'tablet', 'mobile' ),
				'classes' => 'wd-hide-custom-breakpoints',
			]
		);

		$this->add_control(
			'filters',
			[
				'label'        => esc_html__( 'Show categories filters', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '0',
				'label_on'     => esc_html__( 'Yes', 'woodmart' ),
				'label_off'    => esc_html__( 'No', 'woodmart' ),
				'condition'    => [
					'layout' => 'grid',
				],
				'return_value' => '1',
			]
		);

		$this->add_control(
			'filters_type',
			[
				'label'     => esc_html__( 'Filters type', 'woodmart' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'links'   => esc_html__( 'Links', 'woodmart' ),
					'masonry' => esc_html__( 'Masonry', 'woodmart' ),
				],
				'default'   => 'masonry',
				'condition' => [
					'filters' => '1',
					'layout'  => 'grid',
				],
			]
		);

		$this->add_control(
			'pagination',
			[
				'label'     => esc_html__( 'Pagination', 'woodmart' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => array(
					''           => esc_html__( 'Inherit', 'woodmart' ),
					'pagination' => esc_html__( 'Pagination', 'woodmart' ),
					'load_more'  => esc_html__( 'Load more button', 'woodmart' ),
					'infinit'    => esc_html__( 'Infinit scrolling', 'woodmart' ),
					'disable'    => esc_html__( 'Disable', 'woodmart' ),
				),
				'condition' => [
					'layout' => 'grid',
				],
			]
		);

		$this->add_control(
			'image_size',
			[
				'label'   => esc_html__( 'Image size', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'large',
				'options' => woodmart_get_all_image_sizes_names( 'elementor' ),
			]
		);

		$this->add_control(
			'image_size_custom',
			[
				'label'       => esc_html__( 'Image dimension', 'woodmart' ),
				'type'        => Controls_Manager::IMAGE_DIMENSIONS,
				'description' => esc_html__( 'You can crop the original image size to any custom size. You can also set a single value for height or width in order to keep the original size ratio.', 'woodmart' ),
				'condition'   => [
					'image_size' => 'custom',
				],
			]
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
			'element_title_tag',
			array(
				'label'   => esc_html__( 'Tag', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h4',
				'options' => array(
					'h1'   => esc_html__( 'h1', 'woodmart' ),
					'h2'   => esc_html__( 'h2', 'woodmart' ),
					'h3'   => esc_html__( 'h3', 'woodmart' ),
					'h4'   => esc_html__( 'h4', 'woodmart' ),
					'h5'   => esc_html__( 'h5', 'woodmart' ),
					'h6'   => esc_html__( 'h6', 'woodmart' ),
					'div'  => esc_html__( 'div', 'woodmart' ),
					'p'    => esc_html__( 'p', 'woodmart' ),
					'span' => esc_html__( 'span', 'woodmart' ),
				),
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wd-el-title' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Typography', 'woodmart' ),
				'selector' => '{{WRAPPER}} .wd-el-title',
			)
		);

		$this->end_controls_section();

		/**
		 * Extra settings.
		 */
		$this->start_controls_section(
			'extra_style_section',
			[
				'label' => esc_html__( 'Extra', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'lazy_loading',
			[
				'label'        => esc_html__( 'Lazy loading for images', 'woodmart' ),
				'description'  => esc_html__( 'Enable lazy loading for images for this element.', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'label_on'     => esc_html__( 'Yes', 'woodmart' ),
				'label_off'    => esc_html__( 'No', 'woodmart' ),
				'return_value' => 'yes',
			]
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
		woodmart_elementor_portfolio_template( $this->get_settings_for_display() );
	}
}

Plugin::instance()->widgets_manager->register( new Portfolio() );
