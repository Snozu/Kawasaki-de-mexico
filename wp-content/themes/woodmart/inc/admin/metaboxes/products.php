<?php
/**
 * Product metaboxes
 *
 * @package xts
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

use XTS\Admin\Modules\Options\Metaboxes;

if ( ! function_exists( 'woodmart_register_product_metaboxes' ) ) {
	/**
	 * Register page metaboxes
	 *
	 * @since 1.0.0
	 */
	function woodmart_register_product_metaboxes() {
		global $woodmart_transfer_options, $woodmart_prefix;

		$woodmart_prefix = '_woodmart_';

		$product_metabox = Metaboxes::add_metabox(
			array(
				'id'         => 'xts_product_metaboxes',
				'title'      => esc_html__( 'Product Setting (custom metabox from theme)', 'woodmart' ),
				'post_types' => array( 'product' ),
			)
		);

		$product_metabox->add_section(
			array(
				'id'       => 'product_general_section',
				'name'     => esc_html__( 'General', 'woodmart' ),
				'icon'     => 'xts-i-cog',
				'priority' => 10,
			)
		);

		$product_metabox->add_section(
			array(
				'id'       => 'layout_options_section',
				'name'     => esc_html__( 'Layout', 'woodmart' ),
				'icon'     => 'xts-i-layout',
				'priority' => 15,
			)
		);

		$product_metabox->add_section(
			array(
				'id'       => 'design_color_options_section',
				'name'     => esc_html__( 'Style', 'woodmart' ),
				'icon'     => 'xts-i-brush',
				'priority' => 20,
			)
		);

		$product_metabox->add_section(
			array(
				'id'       => 'sidebar_options_section',
				'name'     => esc_html__( 'Sidebar', 'woodmart' ),
				'icon'     => 'xts-i-sidebars',
				'priority' => 30,
			)
		);

		$product_metabox->add_section(
			array(
				'id'       => 'tab_options_section',
				'name'     => esc_html__( 'Tabs', 'woodmart' ),
				'icon'     => 'xts-i-footer',
				'priority' => 50,
			)
		);

		$product_metabox->add_field(
			array(
				'id'          => $woodmart_prefix . 'new_label',
				'type'        => 'checkbox',
				'name'        => esc_html__( 'Permanent "New" label', 'woodmart' ),
				'hint'        => wp_kses( '<img data-src="' . WOODMART_TOOLTIP_URL . 'permanent-new-label.jpg" alt="">', true ),
				'description' => esc_html__( 'Enable this option to make your product have "New" status forever.', 'woodmart' ),
				'section'     => 'product_general_section',
				'priority'    => 10,
				'class'       => 'xts-col-6',
			)
		);

		$product_metabox->add_field(
			array(
				'id'          => $woodmart_prefix . 'new_label_date',
				'type'        => 'text_input',
				'name'        => esc_html__( 'Mark product as "New" till date', 'woodmart' ),
				'description' => esc_html__( 'Specify the end date when the "New" status will be retired. NOTE: "Permanent "New" label" option should be disabled if you use the exact date.', 'woodmart' ),
				'section'     => 'product_general_section',
				'datepicker'  => true,
				'priority'    => 20,
				'class'       => 'xts-col-6',
			)
		);

		$taxonomies_list = array(
			'' => array(
				'name'  => esc_html__( 'Select', 'woodmart' ),
				'value' => '',
			),
		);
		$taxonomies      = get_taxonomies();
		foreach ( $taxonomies as $taxonomy ) {
			$taxonomies_list[ $taxonomy ] = array(
				'name'  => $taxonomy,
				'value' => $taxonomy,
			);
		}

		$product_metabox->add_field(
			array(
				'id'          => $woodmart_prefix . 'swatches_attribute',
				'type'        => 'select',
				'name'        => esc_html__( 'Grid swatch attribute to display', 'woodmart' ),
				'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'grid-swatch-attribute-to-display.mp4" autoplay loop muted></video>',
				'description' => esc_html__( 'Choose attribute that will be shown on products grid for this particular product', 'woodmart' ),
				'section'     => 'product_general_section',
				'options'     => $taxonomies_list,
				'priority'    => 30,
			)
		);

		$product_metabox->add_field(
			array(
				'id'          => $woodmart_prefix . 'related_off',
				'type'        => 'checkbox',
				'name'        => esc_html__( 'Hide related products', 'woodmart' ),
				'hint'        => wp_kses( '<img data-src="' . WOODMART_TOOLTIP_URL . 'show-related-products.jpg" alt="">', true ),
				'description' => esc_html__( 'You can hide related products on this page', 'woodmart' ),
				'section'     => 'product_general_section',
				'on-text'     => esc_html__( 'Yes', 'woodmart' ),
				'off-text'    => esc_html__( 'No', 'woodmart' ),
				'priority'    => 40,
			)
		);

		$product_metabox->add_field(
			array(
				'id'       => $woodmart_prefix . 'exclude_show_single_variation',
				'type'     => 'checkbox',
				'name'     => esc_html__( 'Exclude variation products on grid', 'woodmart' ),
				'section'  => 'product_general_section',
				'on-text'  => esc_html__( 'Yes', 'woodmart' ),
				'off-text' => esc_html__( 'No', 'woodmart' ),
				'priority' => 45,
				'class'    => 'xts-col-6',
			)
		);

		$product_metabox->add_field(
			array(
				'id'          => $woodmart_prefix . 'product_video',
				'type'        => 'text_input',
				'name'        => esc_html__( 'Product video URL', 'woodmart' ),
				'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'product-video-url.mp4" autoplay loop muted></video>',
				'description' => esc_html__( 'URL example: https://www.youtube.com/watch?v=LXb3EKWsInQ', 'woodmart' ),
				'section'     => 'product_general_section',
				'priority'    => 50,
			)
		);

		$product_metabox->add_field(
			array(
				'id'          => $woodmart_prefix . 'product_hashtag',
				'type'        => 'text_input',
				'name'        => esc_html__( 'Instagram product hashtag (deprecated)', 'woodmart' ),
				'description' => wp_kses( __( 'Insert tag that will be used to display images from instagram from your customers. For example: <strong>#nike_rush_run</strong>', 'woodmart' ), 'default' ),
				'section'     => 'product_general_section',
				'class'       => 'xts-hidden',
				'priority'    => 60,
			)
		);

		$product_metabox->add_field(
			array(
				'id'          => $woodmart_prefix . 'single_product_style',
				'name'        => esc_html__( 'Product page layout', 'woodmart' ),
				'description' => esc_html__( 'You can choose different page layout depending on the product image size you need.', 'woodmart' ),
				'type'        => 'select',
				'section'     => 'layout_options_section',
				'options'     => array(
					'inherit' => array(
						'name'  => esc_html__( 'Inherit', 'woodmart' ),
						'value' => 'inherit',
					),
					1         => array(
						'name'  => esc_html__( 'Small image', 'woodmart' ),
						'value' => 1,
					),
					2         => array(
						'name'  => esc_html__( 'Medium', 'woodmart' ),
						'value' => 2,
					),
					3         => array(
						'name'  => esc_html__( 'Large', 'woodmart' ),
						'value' => 3,
					),
					4         => array(
						'name'  => esc_html__( 'Full width (container)', 'woodmart' ),
						'value' => 4,
					),
					5         => array(
						'name'  => esc_html__( 'Full width (window)', 'woodmart' ),
						'value' => 5,
					),
				),
				'default'     => 'inherit',
				'priority'    => 10,
			)
		);

		$product_metabox->add_field(
			array(
				'id'       => $woodmart_prefix . 'thums_position',
				'name'     => esc_html__( 'Thumbnails position', 'woodmart' ),
				'type'     => 'select',
				'section'  => 'layout_options_section',
				'options'  => array(
					'inherit'              => array(
						'name'  => esc_html__( 'Inherit', 'woodmart' ),
						'value' => 'inherit',
					),
					'left'                 => array(
						'name'  => esc_html__( 'Left (vertical position)', 'woodmart' ),
						'value' => 'left',
					),
					'bottom'               => array(
						'name'  => esc_html__( 'Bottom (horizontal carousel)', 'woodmart' ),
						'value' => 'bottom',
					),
					'bottom_column'        => array(
						'name'  => esc_html__( 'Bottom (1 column)', 'woodmart' ),
						'value' => 'left',
					),
					'bottom_grid'          => array(
						'name'  => esc_html__( 'Bottom (2 columns)', 'woodmart' ),
						'value' => 'left',
					),
					'bottom_combined'      => array(
						'name'  => esc_html__( 'Combined grid (1:2:1)', 'woodmart' ),
						'value' => 'bottom_combined',
					),
					'without'              => array(
						'name'  => esc_html__( 'Without', 'woodmart' ),
						'value' => 'without',
					),
				),
				'status'   => 'deprecated',
				'status_description' => esc_html__( 'This option is deprecated. You can now use "Layouts" or "Theme settings presets" to change one or several individual product pages.', 'woodmart' ),
				'default'  => 'inherit',
				'priority' => 20,
			)
		);

		$product_metabox->add_field(
			array(
				'id'          => $woodmart_prefix . 'whb_header',
				'name'        => esc_html__( 'Custom header for this product', 'woodmart' ),
				'description' => esc_html__( 'You can select a different header from the list for this particular product.', 'woodmart' ),
				'type'        => 'select',
				'section'     => 'layout_options_section',
				'options'     => '',
				'callback'    => 'woodmart_get_theme_settings_headers_array',
				'default'     => 'inherit',
				'priority'    => 9,
			)
		);

		$product_metabox->add_field(
			array(
				'id'           => $woodmart_prefix . 'extra_content',
				'name'         => esc_html__( 'Extra content block', 'woodmart' ),
				'description'  => esc_html__( 'You can create some extra content with WPBakery Page Builder (in Admin panel / HTML Blocks / Add new) and add it to this product', 'woodmart' ),
				'type'         => 'select',
				'section'      => 'layout_options_section',
				'select2'      => true,
				'empty_option' => true,
				'autocomplete' => array(
					'type'   => 'post',
					'value'  => 'cms_block',
					'search' => 'woodmart_get_post_by_query_autocomplete',
					'render' => 'woodmart_get_post_by_ids_autocomplete',
				),
				'priority'     => 30,
			)
		);

		$product_metabox->add_field(
			array(
				'id'       => $woodmart_prefix . 'extra_position',
				'name'     => esc_html__( 'Extra content position', 'woodmart' ),
				'type'     => 'buttons',
				'section'  => 'layout_options_section',
				'options'  => array(
					'after'     => array(
						'name'  => esc_html__( 'After content', 'woodmart' ),
						'hint'  => wp_kses( '<img data-src="' . WOODMART_TOOLTIP_URL . 'extra-content-position-affter-content.jpg" alt="">', true ),
						'value' => 'after',
					),
					'before'    => array(
						'name'  => esc_html__( 'Before content', 'woodmart' ),
						'hint'  => wp_kses( '<img data-src="' . WOODMART_TOOLTIP_URL . 'extra-content-position-before-content.jpg" alt="">', true ),
						'value' => 'before',
					),
					'prefooter' => array(
						'name'  => esc_html__( 'Prefooter', 'woodmart' ),
						'hint'  => wp_kses( '<img data-src="' . WOODMART_TOOLTIP_URL . 'extra-content-position-prefooter.jpg" alt="">', true ),
						'value' => 'prefooter',
					),
				),
				'default'  => 'after',
				'priority' => 40,
			)
		);

		$product_metabox->add_field(
			array(
				'id'          => $woodmart_prefix . 'product_design',
				'name'        => esc_html__( 'Product page design', 'woodmart' ),
				'description' => esc_html__( 'Choose between different predefined designs.', 'woodmart' ),
				'type'        => 'buttons',
				'section'     => 'design_color_options_section',
				'options'     => array(
					'inherit' => array(
						'name'  => esc_html__( 'Inherit', 'woodmart' ),
						'value' => 'inherit',
					),
					'default' => array(
						'name'  => esc_html__( 'Default', 'woodmart' ),
						'value' => 'default',
					),
					'alt'     => array(
						'name'  => esc_html__( 'Centered', 'woodmart' ),
						'value' => 'default',
					),
				),
				'default'     => 'inherit',
				'priority'    => 10,
			)
		);

		$product_metabox->add_field(
			array(
				'id'          => $woodmart_prefix . 'product-background',
				'name'        => esc_html__( 'Product background', 'woodmart' ),
				'description' => esc_html__( 'Set background for this particular product page.', 'woodmart' ),
				'type'        => 'color',
				'section'     => 'design_color_options_section',
				'data_type'   => 'hex',
				'priority'    => 20,
			)
		);

		$product_metabox->add_field(
			array(
				'id'          => $woodmart_prefix . 'main_layout',
				'name'        => esc_html__( 'Sidebar position', 'woodmart' ),
				'description' => esc_html__( 'Select main content and sidebar alignment.', 'woodmart' ),
				'type'        => 'buttons',
				'section'     => 'sidebar_options_section',
				'options'     => array(
					'default'       => array(
						'name'  => esc_html__( 'Inherit', 'woodmart' ),
						'value' => 'default',
					),
					'full-width'    => array(
						'name'  => esc_html__( 'Without', 'woodmart' ),
						'value' => 'full-width',
					),
					'sidebar-left'  => array(
						'name'  => esc_html__( 'Left', 'woodmart' ),
						'value' => 'sidebar-left',
					),
					'sidebar-right' => array(
						'name'  => esc_html__( 'Right', 'woodmart' ),
						'value' => 'sidebar-right',
					),
				),
				'default'     => 'default',
				'priority'    => 10,
			)
		);

		$product_metabox->add_field(
			array(
				'id'          => $woodmart_prefix . 'sidebar_width',
				'name'        => esc_html__( 'Sidebar size', 'woodmart' ),
				'description' => esc_html__( 'You can set different sizes for your pages sidebar', 'woodmart' ),
				'type'        => 'buttons',
				'section'     => 'sidebar_options_section',
				'options'     => array(
					'default' => array(
						'name'  => esc_html__( 'Inherit', 'woodmart' ),
						'value' => 'default',
					),
					2         => array(
						'name'  => esc_html__( 'Small', 'woodmart' ),
						'value' => 2,
					),
					3         => array(
						'name'  => esc_html__( 'Medium', 'woodmart' ),
						'value' => 3,
					),
					4         => array(
						'name'  => esc_html__( 'Large', 'woodmart' ),
						'value' => 4,
					),
				),
				'default'     => 'default',
				'priority'    => 20,
			)
		);

		$product_metabox->add_field(
			array(
				'id'       => $woodmart_prefix . 'custom_sidebar',
				'name'     => esc_html__( 'Custom sidebar for this product', 'woodmart' ),
				'type'     => 'select',
				'section'  => 'sidebar_options_section',
				'options'  => '',
				'callback' => 'woodmart_get_theme_settings_sidebars_array',
				'priority' => 30,
			)
		);

		$product_metabox->add_field(
			array(
				'id'          => $woodmart_prefix . 'hide_tabs_titles',
				'type'        => 'checkbox',
				'name'        => esc_html__( 'Hide tabs headings', 'woodmart' ),
				'hint'        => wp_kses( '<img data-src="' . WOODMART_TOOLTIP_URL . 'hide-tabs-headings.jpg" alt="">', true ),
				'description' => esc_html__( 'Description and Additional information', 'woodmart' ),
				'section'     => 'tab_options_section',
				'on-text'     => esc_html__( 'Yes', 'woodmart' ),
				'off-text'    => esc_html__( 'No', 'woodmart' ),
				'priority'    => 10,
			)
		);

		$product_metabox->add_field(
			array(
				'id'       => $woodmart_prefix . 'product_custom_tab_title',
				'type'     => 'text_input',
				'name'     => esc_html__( 'Custom tab title', 'woodmart' ),
				'section'  => 'tab_options_section',
				't_tab'    => array(
					'id'    => 'custom_tabs',
					'tab'   => esc_html__( 'Tab [1]', 'woodmart' ),
					'style' => 'default',
				),
				'class'    => 'xts-col-6',
				'priority' => 20,
			)
		);

		$product_metabox->add_field(
			array(
				'id'         => $woodmart_prefix . 'product_custom_tab_priority',
				'type'       => 'text_input',
				'name'       => esc_html__( 'Priority', 'woodmart' ),
				'section'    => 'tab_options_section',
				'attributes' => array(
					'type'        => 'number',
					'min'         => '1',
					'placeholder' => '80',
				),
				't_tab'      => array(
					'id'    => 'custom_tabs',
					'tab'   => esc_html__( 'Tab [1]', 'woodmart' ),
					'style' => 'default',
				),
				'class'      => 'xts-col-6',
				'priority'   => 25,
			)
		);

		$product_metabox->add_field(
			array(
				'id'       => $woodmart_prefix . 'product_custom_tab_content_type',
				'name'     => esc_html__( 'Custom tab content', 'woodmart' ),
				'type'     => 'buttons',
				'options'  => array(
					'text'       => array(
						'name'  => esc_html__( 'Text', 'woodmart' ),
						'value' => 'text',
					),
					'html_block' => array(
						'name'  => esc_html__( 'HTML Block', 'woodmart' ),
						'value' => 'html_block',
					),
				),
				'default'  => 'text',
				'section'  => 'tab_options_section',
				't_tab'    => array(
					'id'    => 'custom_tabs',
					'tab'   => esc_html__( 'Tab [1]', 'woodmart' ),
					'style' => 'default',
				),
				'class'    => 'xts-html-block-switch',
				'priority' => 30,
			)
		);

		$product_metabox->add_field(
			array(
				'id'       => $woodmart_prefix . 'product_custom_tab_content',
				'type'     => 'textarea',
				'wysiwyg'  => true,
				'name'     => esc_html__( 'Custom tab content', 'woodmart' ),
				'section'  => 'tab_options_section',
				't_tab'    => array(
					'id'  => 'custom_tabs',
					'tab' => esc_html__( 'Tab [1]', 'woodmart' ),
				),
				'requires' => array(
					array(
						'key'     => $woodmart_prefix . 'product_custom_tab_content_type',
						'compare' => 'equals',
						'value'   => 'text',
					),
				),
				'priority' => 40,
			)
		);

		$product_metabox->add_field(
			array(
				'id'           => $woodmart_prefix . 'product_custom_tab_html_block',
				'type'         => 'select',
				'section'      => 'tab_options_section',
				'name'         => esc_html__( 'HTML Block', 'woodmart' ),
				'select2'      => true,
				'empty_option' => true,
				'autocomplete' => array(
					'type'   => 'post',
					'value'  => 'cms_block',
					'search' => 'woodmart_get_post_by_query_autocomplete',
					'render' => 'woodmart_get_post_by_ids_autocomplete',
				),
				't_tab'        => array(
					'id'  => 'custom_tabs',
					'tab' => esc_html__( 'Tab [1]', 'woodmart' ),
				),
				'requires'     => array(
					array(
						'key'     => $woodmart_prefix . 'product_custom_tab_content_type',
						'compare' => 'equals',
						'value'   => 'html_block',
					),
				),
				'priority'     => 50,
			)
		);

		$product_metabox->add_field(
			array(
				'id'       => $woodmart_prefix . 'product_custom_tab_title_2',
				'type'     => 'text_input',
				'name'     => esc_html__( 'Custom tab title', 'woodmart' ),
				'section'  => 'tab_options_section',
				't_tab'    => array(
					'id'  => 'custom_tabs',
					'tab' => esc_html__( 'Tab [2]', 'woodmart' ),
				),
				'class'    => 'xts-col-6',
				'priority' => 60,
			)
		);

		$product_metabox->add_field(
			array(
				'id'         => $woodmart_prefix . 'product_custom_tab_priority_2',
				'type'       => 'text_input',
				'name'       => esc_html__( 'Priority', 'woodmart' ),
				'section'    => 'tab_options_section',
				'attributes' => array(
					'type'        => 'number',
					'min'         => '1',
					'placeholder' => '90',
				),
				't_tab'      => array(
					'id'    => 'custom_tabs',
					'tab'   => esc_html__( 'Tab [2]', 'woodmart' ),
					'style' => 'default',
				),
				'class'      => 'xts-col-6',
				'priority'   => 65,
			)
		);

		$product_metabox->add_field(
			array(
				'id'       => $woodmart_prefix . 'product_custom_tab_content_type_2',
				'name'     => esc_html__( 'Custom tab content', 'woodmart' ),
				'type'     => 'buttons',
				'options'  => array(
					'text'       => array(
						'name'  => esc_html__( 'Text', 'woodmart' ),
						'value' => 'text',
					),
					'html_block' => array(
						'name'  => esc_html__( 'HTML Block', 'woodmart' ),
						'value' => 'html_block',
					),
				),
				'default'  => 'text',
				'section'  => 'tab_options_section',
				't_tab'    => array(
					'id'  => 'custom_tabs',
					'tab' => esc_html__( 'Tab [2]', 'woodmart' ),
				),
				'class'    => 'xts-html-block-switch',
				'priority' => 70,
			)
		);

		$product_metabox->add_field(
			array(
				'id'       => $woodmart_prefix . 'product_custom_tab_content_2',
				'type'     => 'textarea',
				'wysiwyg'  => true,
				'name'     => esc_html__( 'Custom tab content', 'woodmart' ),
				'section'  => 'tab_options_section',
				't_tab'    => array(
					'id'  => 'custom_tabs',
					'tab' => esc_html__( 'Tab [2]', 'woodmart' ),
				),
				'requires' => array(
					array(
						'key'     => $woodmart_prefix . 'product_custom_tab_content_type_2',
						'compare' => 'equals',
						'value'   => 'text',
					),
				),
				'priority' => 80,
			)
		);

		$product_metabox->add_field(
			array(
				'id'           => $woodmart_prefix . 'product_custom_tab_html_block_2',
				'type'         => 'select',
				'section'      => 'tab_options_section',
				'name'         => esc_html__( 'HTML Block', 'woodmart' ),
				'select2'      => true,
				'empty_option' => true,
				'autocomplete' => array(
					'type'   => 'post',
					'value'  => 'cms_block',
					'search' => 'woodmart_get_post_by_query_autocomplete',
					'render' => 'woodmart_get_post_by_ids_autocomplete',
				),
				't_tab'        => array(
					'id'  => 'custom_tabs',
					'tab' => esc_html__( 'Tab [2]', 'woodmart' ),
				),
				'requires'     => array(
					array(
						'key'     => $woodmart_prefix . 'product_custom_tab_content_type_2',
						'compare' => 'equals',
						'value'   => 'html_block',
					),
				),
				'priority'     => 90,
			)
		);

		$product_metabox->add_field(
			array(
				'id'       => $woodmart_prefix . 'product_custom_tab_title_3',
				'type'     => 'text_input',
				'name'     => esc_html__( 'Custom tab title', 'woodmart' ),
				'section'  => 'tab_options_section',
				't_tab'    => array(
					'id'  => 'custom_tabs',
					'tab' => esc_html__( 'Tab [3]', 'woodmart' ),
				),
				'class'    => 'xts-col-6',
				'priority' => 100,
			)
		);

		$product_metabox->add_field(
			array(
				'id'         => $woodmart_prefix . 'product_custom_tab_priority_3',
				'type'       => 'text_input',
				'name'       => esc_html__( 'Priority', 'woodmart' ),
				'section'    => 'tab_options_section',
				'attributes' => array(
					'type'        => 'number',
					'min'         => '1',
					'placeholder' => '100',
				),
				't_tab'      => array(
					'id'    => 'custom_tabs',
					'tab'   => esc_html__( 'Tab [3]', 'woodmart' ),
					'style' => 'default',
				),
				'class'      => 'xts-col-6',
				'priority'   => 105,
			)
		);

		$product_metabox->add_field(
			array(
				'id'       => $woodmart_prefix . 'product_custom_tab_content_type_3',
				'name'     => esc_html__( 'Custom tab content', 'woodmart' ),
				'type'     => 'buttons',
				'options'  => array(
					'text'       => array(
						'name'  => esc_html__( 'Text', 'woodmart' ),
						'value' => 'text',
					),
					'html_block' => array(
						'name'  => esc_html__( 'HTML Block', 'woodmart' ),
						'value' => 'html_block',
					),
				),
				'default'  => 'text',
				'section'  => 'tab_options_section',
				't_tab'    => array(
					'id'  => 'custom_tabs',
					'tab' => esc_html__( 'Tab [3]', 'woodmart' ),
				),
				'class'    => 'xts-html-block-switch',
				'priority' => 110,
			)
		);

		$product_metabox->add_field(
			array(
				'id'       => $woodmart_prefix . 'product_custom_tab_content_3',
				'type'     => 'textarea',
				'wysiwyg'  => true,
				'name'     => esc_html__( 'Custom tab content', 'woodmart' ),
				'section'  => 'tab_options_section',
				't_tab'    => array(
					'id'  => 'custom_tabs',
					'tab' => esc_html__( 'Tab [3]', 'woodmart' ),
				),
				'requires' => array(
					array(
						'key'     => $woodmart_prefix . 'product_custom_tab_content_type_3',
						'compare' => 'equals',
						'value'   => 'text',
					),
				),
				'priority' => 120,
			)
		);

		$product_metabox->add_field(
			array(
				'id'           => $woodmart_prefix . 'product_custom_tab_html_block_3',
				'type'         => 'select',
				'section'      => 'tab_options_section',
				'name'         => esc_html__( 'HTML Block', 'woodmart' ),
				'select2'      => true,
				'empty_option' => true,
				'autocomplete' => array(
					'type'   => 'post',
					'value'  => 'cms_block',
					'search' => 'woodmart_get_post_by_query_autocomplete',
					'render' => 'woodmart_get_post_by_ids_autocomplete',
				),
				't_tab'        => array(
					'id'  => 'custom_tabs',
					'tab' => esc_html__( 'Tab [3]', 'woodmart' ),
				),
				'requires'     => array(
					array(
						'key'     => $woodmart_prefix . 'product_custom_tab_content_type_3',
						'compare' => 'equals',
						'value'   => 'html_block',
					),
				),
				'priority'     => 130,
			)
		);

		$product_metabox->add_field(
			array(
				'id'       => $woodmart_prefix . 'product_custom_tab_title_4',
				'type'     => 'text_input',
				'name'     => esc_html__( 'Custom tab title', 'woodmart' ),
				'section'  => 'tab_options_section',
				't_tab'    => array(
					'id'  => 'custom_tabs',
					'tab' => esc_html__( 'Tab [4]', 'woodmart' ),
				),
				'class'    => 'xts-col-6',
				'priority' => 140,
			)
		);

		$product_metabox->add_field(
			array(
				'id'         => $woodmart_prefix . 'product_custom_tab_priority_4',
				'type'       => 'text_input',
				'name'       => esc_html__( 'Priority', 'woodmart' ),
				'section'    => 'tab_options_section',
				'attributes' => array(
					'type'        => 'number',
					'min'         => '1',
					'placeholder' => '110',
				),
				't_tab'      => array(
					'id'    => 'custom_tabs',
					'tab'   => esc_html__( 'Tab [4]', 'woodmart' ),
					'style' => 'default',
				),
				'class'      => 'xts-col-6',
				'priority'   => 145,
			)
		);

		$product_metabox->add_field(
			array(
				'id'       => $woodmart_prefix . 'product_custom_tab_content_type_4',
				'name'     => esc_html__( 'Custom tab content', 'woodmart' ),
				'type'     => 'buttons',
				'options'  => array(
					'text'       => array(
						'name'  => esc_html__( 'Text', 'woodmart' ),
						'value' => 'text',
					),
					'html_block' => array(
						'name'  => esc_html__( 'HTML Block', 'woodmart' ),
						'value' => 'html_block',
					),
				),
				'default'  => 'text',
				'section'  => 'tab_options_section',
				't_tab'    => array(
					'id'  => 'custom_tabs',
					'tab' => esc_html__( 'Tab [4]', 'woodmart' ),
				),
				'class'    => 'xts-html-block-switch',
				'priority' => 150,
			)
		);

		$product_metabox->add_field(
			array(
				'id'       => $woodmart_prefix . 'product_custom_tab_content_4',
				'type'     => 'textarea',
				'wysiwyg'  => true,
				'name'     => esc_html__( 'Custom tab content', 'woodmart' ),
				'section'  => 'tab_options_section',
				't_tab'    => array(
					'id'  => 'custom_tabs',
					'tab' => esc_html__( 'Tab [4]', 'woodmart' ),
				),
				'requires' => array(
					array(
						'key'     => $woodmart_prefix . 'product_custom_tab_content_type_4',
						'compare' => 'equals',
						'value'   => 'text',
					),
				),
				'priority' => 160,
			)
		);

		$product_metabox->add_field(
			array(
				'id'           => $woodmart_prefix . 'product_custom_tab_html_block_4',
				'type'         => 'select',
				'section'      => 'tab_options_section',
				'name'         => esc_html__( 'HTML Block', 'woodmart' ),
				'select2'      => true,
				'empty_option' => true,
				'autocomplete' => array(
					'type'   => 'post',
					'value'  => 'cms_block',
					'search' => 'woodmart_get_post_by_query_autocomplete',
					'render' => 'woodmart_get_post_by_ids_autocomplete',
				),
				't_tab'        => array(
					'id'  => 'custom_tabs',
					'tab' => esc_html__( 'Tab [4]', 'woodmart' ),
				),
				'requires'     => array(
					array(
						'key'     => $woodmart_prefix . 'product_custom_tab_content_type_4',
						'compare' => 'equals',
						'value'   => 'html_block',
					),
				),
				'priority'     => 170,
			)
		);

		$product_metabox->add_field(
			array(
				'id'       => $woodmart_prefix . 'product_custom_tab_title_5',
				'type'     => 'text_input',
				'name'     => esc_html__( 'Custom tab title', 'woodmart' ),
				'section'  => 'tab_options_section',
				't_tab'    => array(
					'id'  => 'custom_tabs',
					'tab' => esc_html__( 'Tab [5]', 'woodmart' ),
				),
				'class'    => 'xts-col-6',
				'priority' => 180,
			)
		);

		$product_metabox->add_field(
			array(
				'id'         => $woodmart_prefix . 'product_custom_tab_priority_5',
				'type'       => 'text_input',
				'name'       => esc_html__( 'Priority', 'woodmart' ),
				'section'    => 'tab_options_section',
				'attributes' => array(
					'type'        => 'number',
					'min'         => '1',
					'placeholder' => '120',
				),
				't_tab'      => array(
					'id'    => 'custom_tabs',
					'tab'   => esc_html__( 'Tab [5]', 'woodmart' ),
					'style' => 'default',
				),
				'class'      => 'xts-col-6',
				'priority'   => 185,
			)
		);

		$product_metabox->add_field(
			array(
				'id'       => $woodmart_prefix . 'product_custom_tab_content_type_5',
				'name'     => esc_html__( 'Custom tab content', 'woodmart' ),
				'type'     => 'buttons',
				'options'  => array(
					'text'       => array(
						'name'  => esc_html__( 'Text', 'woodmart' ),
						'value' => 'text',
					),
					'html_block' => array(
						'name'  => esc_html__( 'HTML Block', 'woodmart' ),
						'value' => 'html_block',
					),
				),
				'default'  => 'text',
				'section'  => 'tab_options_section',
				't_tab'    => array(
					'id'  => 'custom_tabs',
					'tab' => esc_html__( 'Tab [5]', 'woodmart' ),
				),
				'class'    => 'xts-html-block-switch',
				'priority' => 190,
			)
		);

		$product_metabox->add_field(
			array(
				'id'       => $woodmart_prefix . 'product_custom_tab_content_5',
				'type'     => 'textarea',
				'wysiwyg'  => true,
				'name'     => esc_html__( 'Custom tab content', 'woodmart' ),
				'section'  => 'tab_options_section',
				't_tab'    => array(
					'id'  => 'custom_tabs',
					'tab' => esc_html__( 'Tab [5]', 'woodmart' ),
				),
				'requires' => array(
					array(
						'key'     => $woodmart_prefix . 'product_custom_tab_content_type_5',
						'compare' => 'equals',
						'value'   => 'text',
					),
				),
				'priority' => 200,
			)
		);

		$product_metabox->add_field(
			array(
				'id'           => $woodmart_prefix . 'product_custom_tab_html_block_5',
				'type'         => 'select',
				'section'      => 'tab_options_section',
				'name'         => esc_html__( 'HTML Block', 'woodmart' ),
				'select2'      => true,
				'empty_option' => true,
				'autocomplete' => array(
					'type'   => 'post',
					'value'  => 'cms_block',
					'search' => 'woodmart_get_post_by_query_autocomplete',
					'render' => 'woodmart_get_post_by_ids_autocomplete',
				),
				't_tab'        => array(
					'id'  => 'custom_tabs',
					'tab' => esc_html__( 'Tab [5]', 'woodmart' ),
				),
				'requires'     => array(
					array(
						'key'     => $woodmart_prefix . 'product_custom_tab_content_type_5',
						'compare' => 'equals',
						'value'   => 'html_block',
					),
				),
				'priority'     => 210,
			)
		);

		$woodmart_local_transfer_options = array(
			'product_design',
			'single_product_style',
			'thums_position',
			'product-background',
			'main_layout',
			'sidebar_width',
		);

		$woodmart_transfer_options = array_merge( $woodmart_transfer_options, $woodmart_local_transfer_options );
	}

	add_action( 'init', 'woodmart_register_product_metaboxes', 100 );
}

$product_attribute_metabox = Metaboxes::add_metabox(
	array(
		'id'         => 'xts_product_attribute_metaboxes',
		'title'      => esc_html__( 'Extra options from theme', 'woodmart' ),
		'object'     => 'term',
		'taxonomies' => array( 'product_cat' ),
	)
);

$product_attribute_metabox->add_section(
	array(
		'id'       => 'general',
		'name'     => esc_html__( 'General', 'woodmart' ),
		'icon'     => 'xts-i-footer',
		'priority' => 10,
	)
);

$product_attribute_metabox->add_field(
	array(
		'id'          => 'category_icon_alt',
		'name'        => esc_html__( 'Category icon', 'woodmart' ),
		'hint'        => wp_kses( '<img data-src="' . WOODMART_TOOLTIP_URL . 'image-for-header-menu.jpg" alt="">', true ),
		'description' => esc_html__( 'This icon will be used in areas such as the header menu, mobile menu, sticky menu, and category search results.', 'woodmart' ),
		'type'        => 'upload',
		'section'     => 'general',
		'priority'    => 15,
	)
);

$product_attribute_metabox->add_field(
	array(
		'id'          => 'category_icon',
		'name'        => esc_html__( 'Large category icon', 'woodmart' ),
		'hint'        => wp_kses( '<img data-src="' . WOODMART_TOOLTIP_URL . 'image-for-categories-navigation.jpg" alt="">', true ),
		'description' => esc_html__( 'This icon will be used in areas such as the category menu in shop the page title and in category elements with the “navigation” type selected.', 'woodmart' ),
		'type'        => 'upload',
		'section'     => 'general',
		'priority'    => 20,
	)
);

$product_attribute_metabox->add_field(
	array(
		'id'          => 'title_image',
		'name'        => esc_html__( 'Category page title background', 'woodmart' ),
		'hint'        => wp_kses( '<img data-src="' . WOODMART_TOOLTIP_URL . 'image-for-the-category-page-title.jpg" alt="">', true ),
		'description' => esc_html__( 'This image will be used as the background of the shop page title when viewing this category.', 'woodmart' ),
		'type'        => 'upload',
		'section'     => 'general',
		'priority'    => 30,
	)
);

$product_attribute_metabox->add_field(
	array(
		'id'       => 'category_extra_description_type',
		'name'     => esc_html__( 'Extra description', 'woodmart' ),
		'hint'     => wp_kses( '<img data-src="' . WOODMART_TOOLTIP_URL . 'category-extra-description.jpg" alt="">', true ),
		'type'     => 'buttons',
		'section'  => 'general',
		'options'  => array(
			'text'       => array(
				'name'  => esc_html__( 'Text', 'woodmart' ),
				'value' => 'text',
			),
			'html_block' => array(
				'name'  => esc_html__( 'HTML Block', 'woodmart' ),
				'value' => 'html_block',
			),
		),
		'default'  => 'text',
		'priority' => 40,
		'class'    => 'xts-html-block-switch',
	)
);

$product_attribute_metabox->add_field(
	array(
		'id'           => 'category_extra_description_html_block',
		'type'         => 'select',
		'section'      => 'general',
		'name'         => esc_html__( 'HTML Block', 'woodmart' ),
		'description'  => esc_html__( 'Additional category description that will be displayed after product loop on this category page.', 'woodmart' ),
		'select2'      => true,
		'empty_option' => true,
		'autocomplete' => array(
			'type'   => 'post',
			'value'  => 'cms_block',
			'search' => 'woodmart_get_post_by_query_autocomplete',
			'render' => 'woodmart_get_post_by_ids_autocomplete',
		),
		'requires'     => array(
			array(
				'key'     => 'category_extra_description_type',
				'compare' => 'equals',
				'value'   => 'html_block',
			),
		),
		'priority'     => 50,
	)
);

$product_attribute_metabox->add_field(
	array(
		'id'          => 'category_extra_description_text',
		'name'        => esc_html__( 'Text', 'woodmart' ),
		'description' => esc_html__( 'Additional category description that will be displayed after product loop on this category page.', 'woodmart' ),
		'type'        => 'textarea',
		'wysiwyg'     => true,
		'section'     => 'general',
		'requires'    => array(
			array(
				'key'     => 'category_extra_description_type',
				'compare' => 'equals',
				'value'   => 'text',
			),
		),
		'priority'    => 50,
	)
);
