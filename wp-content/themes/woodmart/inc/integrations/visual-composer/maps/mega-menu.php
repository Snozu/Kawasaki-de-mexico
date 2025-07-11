<?php

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

if ( ! function_exists( 'woodmart_get_vc_map_mega_menu' ) ) {
	function woodmart_get_vc_map_mega_menu() {
		$item_typography = woodmart_get_typography_map(
			array(
				'title'    => esc_html__( 'Typography', 'woodmart' ),
				'key'      => 'item_typography',
				'selector' => '{{WRAPPER}} .wd-nav > .menu-item > a',
			)
		);

		return array(
			'name'        => esc_html__( 'Mega Menu widget', 'woodmart' ),
			'base'        => 'woodmart_mega_menu',
			'category'    => woodmart_get_tab_title_category_for_wpb( esc_html__( 'Theme elements', 'woodmart' ) ),
			'description' => esc_html__( 'Categories mega menu widget', 'woodmart' ),
			'icon'        => WOODMART_ASSETS . '/images/vc-icon/mega-menu-widget.svg',
			'params'      => array(
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'General options', 'woodmart' ),
					'param_name' => 'general_divider',
				),
				array(
					'type'       => 'woodmart_css_id',
					'param_name' => 'woodmart_css_id',
				),
				array(
					'type'             => 'textfield',
					'heading'          => esc_html__( 'Title', 'woodmart' ),
					'param_name'       => 'title',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
					'dependency'       => array(
						'element' => 'design',
						'value'   => array( 'vertical' ),
					),
				),
				array(
					'type'             => 'woodmart_dropdown',
					'heading'          => esc_html__( 'Choose Menu', 'woodmart' ),
					'param_name'       => 'nav_menu',
					'callback'         => 'woodmart_get_menus_array',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'Orientation', 'woodmart' ),
					'param_name'       => 'design',
					'value'            => array(
						esc_html__( 'Vertical', 'woodmart' ) => 'vertical',
						esc_html__( 'Horizontal', 'woodmart' ) => 'horizontal',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'Design', 'woodmart' ),
					'param_name'       => 'dropdown_design',
					'value'            => array(
						esc_html__( 'Default', 'woodmart' ) => 'default',
						esc_html__( 'With background', 'woodmart' ) => 'with-bg',
						esc_html__( 'Simple', 'woodmart' ) => 'simple',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
					'dependency'       => array(
						'element' => 'design',
						'value'   => array( 'vertical' ),
					),
				),
				array(
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'Items gap', 'woodmart' ),
					'param_name'       => 'vertical_items_gap',
					'value'            => array(
						esc_html__( 'Small', 'woodmart' )  => 's',
						esc_html__( 'Medium', 'woodmart' ) => 'm',
						esc_html__( 'Large', 'woodmart' )  => 'l',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
					'dependency'       => array(
						'element' => 'dropdown_design',
						'value'   => array( 'simple' ),
					),
					'wd_dependency'    => array(
						'element' => 'design',
						'value'   => array( 'vertical' ),
					),
				),
				array(
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'Style', 'woodmart' ),
					'param_name'       => 'style',
					'value'            => array(
						esc_html__( 'Default', 'woodmart' )    => 'default',
						esc_html__( 'Underline', 'woodmart' )  => 'underline',
						esc_html__( 'Bordered', 'woodmart' )   => 'bordered',
						esc_html__( 'Separated', 'woodmart' )  => 'separated',
						esc_html__( 'Background', 'woodmart' ) => 'bg',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
					'dependency'       => array(
						'element' => 'design',
						'value'   => array( 'horizontal' ),
					),
				),
				array(
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'Items gap', 'woodmart' ),
					'param_name'       => 'items_gap',
					'value'            => array(
						esc_html__( 'Small', 'woodmart' )  => 's',
						esc_html__( 'Medium', 'woodmart' ) => 'm',
						esc_html__( 'Large', 'woodmart' )  => 'l',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
					'dependency'       => array(
						'element' => 'design',
						'value'   => array( 'horizontal' ),
					),
				),
				array(
					'type'             => 'woodmart_image_select',
					'heading'          => esc_html__( 'Alignment', 'woodmart' ),
					'param_name'       => 'alignment',
					'value'            => array(
						esc_html__( 'Left', 'woodmart' )  => 'left',
						esc_html__( 'Center', 'woodmart' ) => 'center',
						esc_html__( 'Right', 'woodmart' ) => 'right',
					),
					'images_value'     => array(
						'center' => WOODMART_ASSETS_IMAGES . '/settings/align/center.jpg',
						'left'   => WOODMART_ASSETS_IMAGES . '/settings/align/left.jpg',
						'right'  => WOODMART_ASSETS_IMAGES . '/settings/align/right.jpg',
					),
					'wood_tooltip'     => true,
					'dependency'       => array(
						'element' => 'design',
						'value'   => array( 'horizontal' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column title-align',
				),
				$item_typography['font_family'],
				$item_typography['font_size'],
				$item_typography['font_weight'],
				$item_typography['text_transform'],
				$item_typography['font_style'],
				$item_typography['line_height'],
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Title options', 'woodmart' ),
					'param_name' => 'title_divider',
					'dependency' => array(
						'element' => 'design',
						'value'   => array( 'vertical' ),
					),
				),
				array(
					'type'             => 'woodmart_button_set',
					'heading'          => esc_html__( 'Color Scheme', 'woodmart' ),
					'param_name'       => 'woodmart_color_scheme',
					'value'            => array(
						esc_html__( 'Inherit', 'woodmart' ) => '',
						esc_html__( 'Light', 'woodmart' )   => 'light',
						esc_html__( 'Dark', 'woodmart' )    => 'dark',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'woodmart_colorpicker',
					'heading'          => esc_html__( 'Title background color', 'woodmart' ),
					'param_name'       => 'color',
					'css_args'         => array(
						'background-color' => array(
							' .widget-title',
						),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Menu icon options', 'woodmart' ),
					'param_name' => 'icon_divider',
				),
				array(
					'type'       => 'dropdown',
					'heading'    => esc_html__( 'Alignment', 'woodmart' ),
					'param_name' => 'icon_alignment',
					'value'      => array(
						esc_html__( 'Default', 'woodmart' ) => 'inherit',
						esc_html__( 'Left', 'woodmart' )  => 'left',
						esc_html__( 'Right', 'woodmart' ) => 'right',
					),
				),
				array(
					'type'             => 'wd_slider',
					'heading'          => esc_html__( 'Height', 'woodmart' ),
					'param_name'       => 'icon_height',
					'selectors'        => array(
						'{{WRAPPER}} > ul > li > a .wd-nav-img' => array(
							'--nav-img-height: {{VALUE}}{{UNIT}};',
						),
					),
					'devices'          => array(
						'desktop' => array(
							'value' => '',
							'unit'  => 'px',
						),
						'tablet'  => array(
							'value' => '',
							'unit'  => 'px',
						),
						'mobile'  => array(
							'value' => '',
							'unit'  => 'px',
						),
					),
					'range'            => array(
						'px' => array(
							'min'  => 0,
							'max'  => 50,
							'step' => 1,
						),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'wd_slider',
					'heading'          => esc_html__( 'Width', 'woodmart' ),
					'param_name'       => 'icon_width',
					'selectors'        => array(
						'{{WRAPPER}} > ul > li > a .wd-nav-img' => array(
							'--nav-img-width: {{VALUE}}{{UNIT}};',
						),
					),
					'devices'          => array(
						'desktop' => array(
							'value' => '',
							'unit'  => 'px',
						),
						'tablet'  => array(
							'value' => '',
							'unit'  => 'px',
						),
						'mobile'  => array(
							'value' => '',
							'unit'  => 'px',
						),
					),
					'range'            => array(
						'px' => array(
							'min'  => 0,
							'max'  => 50,
							'step' => 1,
						),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Extra options', 'woodmart' ),
					'param_name' => 'extra_divider',
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Extra class name', 'woodmart' ),
					'param_name' => 'el_class',
					'hint'       => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' ),
				),
				array(
					'type'       => 'css_editor',
					'heading'    => esc_html__( 'CSS box', 'woodmart' ),
					'param_name' => 'css',
					'group'      => esc_html__( 'Design Options', 'js_composer' ),
				),
				woodmart_get_vc_responsive_spacing_map(),
				/**
				 * Advanced
				 */

				// Width option (with dependency Columns option, responsive).
				woodmart_get_responsive_dependency_width_map( 'responsive_tabs' ),
				woodmart_get_responsive_dependency_width_map( 'width_desktop' ),
				woodmart_get_responsive_dependency_width_map( 'custom_width_desktop' ),
				woodmart_get_responsive_dependency_width_map( 'width_tablet' ),
				woodmart_get_responsive_dependency_width_map( 'custom_width_tablet' ),
				woodmart_get_responsive_dependency_width_map( 'width_mobile' ),
				woodmart_get_responsive_dependency_width_map( 'custom_width_mobile' ),
			),
		);
	}
}
