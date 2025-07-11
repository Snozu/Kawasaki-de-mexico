<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );}
/**
* ------------------------------------------------------------------------------------------------
*  Button element map
* ------------------------------------------------------------------------------------------------
*/

if ( ! function_exists( 'woodmart_get_woodmart_button_shortcode_args' ) ) {
	function woodmart_get_woodmart_button_shortcode_args() {
		return array(
			'name'        => esc_html__( 'Button', 'woodmart' ),
			'base'        => 'woodmart_button',
			'category'    => function_exists( 'woodmart_get_tab_title_category_for_wpb' ) ? woodmart_get_tab_title_category_for_wpb( esc_html__( 'Theme elements', 'woodmart' ) ) : esc_html__( 'Theme elements', 'woodmart' ),
			'description' => esc_html__( 'Simple button in different theme styles', 'woodmart' ),
			'icon'        => WOODMART_ASSETS . '/images/vc-icon/button.svg',
			'params'      => woodmart_get_button_shortcode_params(),
		);
	}
}

if ( ! function_exists( 'woodmart_get_button_shortcode_params' ) ) {
	function woodmart_get_button_shortcode_params() {
		$typography = woodmart_get_typography_map(
			array(
				'key'      => 'typography',
				'group'    => esc_html__( 'Style', 'woodmart' ),
				'selector' => '{{WRAPPER}} .btn',
			)
		);

		return apply_filters(
			'woodmart_get_button_shortcode_params',
			array(
				array(
					'type'       => 'woodmart_css_id',
					'param_name' => 'woodmart_css_id',
				),
				/**
				* Button
				*/
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Button', 'woodmart' ),
					'param_name' => 'button_divider',
				),
				array(
					'type'             => 'textfield',
					'heading'          => esc_html__( 'Title', 'woodmart' ),
					'param_name'       => 'title',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'vc_link',
					'heading'          => esc_html__( 'Link', 'woodmart' ),
					'param_name'       => 'link',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'textfield',
					'heading'          => esc_html__( 'Custom attributes', 'woodmart' ),
					'param_name'       => 'custom_attributes',
					'hint'             => esc_html__( 'Set custom attributes for the link element. Separate attribute keys from values using the | (pipe) character. Separate key-value pairs with a comma.', 'woodmart' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				/**
				 * Smooth scroll
				 */
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Smooth scroll', 'woodmart' ),
					'param_name' => 'smooth_divider',
				),
				array(
					'type'             => 'woodmart_switch',
					'heading'          => esc_html__( 'Smooth scroll', 'woodmart' ),
					'hint'             => esc_html__( 'When you turn on this option you need to specify this button link with a hash symbol. For example #section-id Then you need to have a section with an ID of "section-id" and this button click will smoothly scroll the page to that section.', 'woodmart' ),
					'param_name'       => 'button_smooth_scroll',
					'true_state'       => 'yes',
					'false_state'      => 'no',
					'default'          => 'no',
					'edit_field_class' => 'vc_col-sm-12 vc_column',
				),
				array(
					'type'             => 'textfield',
					'heading'          => esc_html__( 'Smooth scroll time (ms)', 'woodmart' ),
					'param_name'       => 'button_smooth_scroll_time',
					'dependency'       => array(
						'element'            => 'button_smooth_scroll',
						'value_not_equal_to' => array( 'no' ),
					),
					'std'              => '100',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'textfield',
					'heading'          => esc_html__( 'Smooth scroll offset (px)', 'woodmart' ),
					'param_name'       => 'button_smooth_scroll_offset',
					'dependency'       => array(
						'element'            => 'button_smooth_scroll',
						'value_not_equal_to' => array( 'no' ),
					),
					'std'              => '100',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				/**
				 * Collapsible content.
				 */
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Collapsible content', 'woodmart' ),
					'param_name' => 'collapsible_content_divider',
				),
				array(
					'type'             => 'woodmart_switch',
					'param_name'       => 'wd_button_collapsible_content',
					'hint'             => esc_html__( 'Limit the column height and add the "Read more" button. IMPORTANT: you need to add our "Button" element to the end of this column and enable an appropriate option there as well.', 'woodmart' ),
					'heading'          => esc_html__( 'Enable collapsible content', 'woodmart' ),
					'true_state'       => 'yes',
					'false_state'      => 'no',
					'default'          => 'no',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				/**
				* Extra
				*/
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Extra options', 'woodmart' ),
					'param_name' => 'extra_divider',
				),
				( function_exists( 'vc_map_add_css_animation' ) ) ? vc_map_add_css_animation( true ) : '',

				function_exists( 'woodmart_get_vc_animation_map' ) ? woodmart_get_vc_animation_map( 'wd_animation' ) : '',
				function_exists( 'woodmart_get_vc_animation_map' ) ? woodmart_get_vc_animation_map( 'wd_animation_delay' ) : '',
				function_exists( 'woodmart_get_vc_animation_map' ) ? woodmart_get_vc_animation_map( 'wd_animation_duration' ) : '',

				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Extra class name', 'woodmart' ),
					'param_name' => 'el_class',
					'hint'       => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' ),
				),

				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'General', 'woodmart' ),
					'group'      => esc_html__( 'Style', 'woodmart' ),
					'param_name' => 'general_divider',
				),
				array(
					'type'             => 'woodmart_image_select',
					'heading'          => esc_html__( 'Button style', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'param_name'       => 'style',
					'value'            => array(
						esc_html__( 'Flat', 'woodmart' ) => 'default',
						esc_html__( 'Bordered', 'woodmart' ) => 'bordered',
						esc_html__( 'Link button', 'woodmart' ) => 'link',
						esc_html__( '3D', 'woodmart' )   => '3d',
					),
					'images_value'     => array(
						'default'  => WOODMART_ASSETS_IMAGES . '/settings/buttons/style/default.png',
						'bordered' => WOODMART_ASSETS_IMAGES . '/settings/buttons/style/bordered.png',
						'link'     => WOODMART_ASSETS_IMAGES . '/settings/buttons/style/link.png',
						'3d'       => WOODMART_ASSETS_IMAGES . '/settings/buttons/style/3d.png',
					),
					'title'            => false,
					'std'              => 'default',
					'edit_field_class' => 'vc_col-xs-12 vc_column button-style',
				),
				array(
					'type'             => 'woodmart_image_select',
					'heading'          => esc_html__( 'Button shape', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'param_name'       => 'shape',
					'value'            => array(
						esc_html__( 'Rectangle', 'woodmart' ) => 'rectangle',
						esc_html__( 'Circle', 'woodmart' ) => 'round',
						esc_html__( 'Round', 'woodmart' )  => 'semi-round',
					),
					'images_value'     => array(
						'rectangle'  => WOODMART_ASSETS_IMAGES . '/settings/buttons/shape/rectangle.jpeg',
						'round'      => WOODMART_ASSETS_IMAGES . '/settings/buttons/shape/circle.jpeg',
						'semi-round' => WOODMART_ASSETS_IMAGES . '/settings/buttons/shape/round.jpeg',
					),
					'dependency'       => array(
						'element'            => 'style',
						'value_not_equal_to' => array( 'round', 'link' ),
					),
					'title'            => false,
					'std'              => 'rectangle',
					'edit_field_class' => 'vc_col-xs-12 vc_column button-shape',
				),
				array(
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'Button size', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'param_name'       => 'size',
					'value'            => array(
						esc_html__( 'Default', 'woodmart' ) => 'default',
						esc_html__( 'Extra Small', 'woodmart' ) => 'extra-small',
						esc_html__( 'Small', 'woodmart' ) => 'small',
						esc_html__( 'Large', 'woodmart' ) => 'large',
						esc_html__( 'Extra Large', 'woodmart' ) => 'extra-large',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'woodmart_dropdown',
					'heading'          => esc_html__( 'Predefined button color', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'param_name'       => 'color',
					'value'            => array(
						esc_html__( 'None', 'woodmart' )  => 'default',
						esc_html__( 'Primary color', 'woodmart' ) => 'primary',
						esc_html__( 'Alternative color', 'woodmart' ) => 'alt',
						esc_html__( 'White', 'woodmart' ) => 'white',
						esc_html__( 'Black', 'woodmart' ) => 'black',
					),
					'style'            => array(
						'default' => '#f3f3f3',
						'primary' => woodmart_get_color_value( 'primary-color', '#7eb934' ),
						'alt'     => woodmart_get_color_value( 'secondary-color', '#fbbc34' ),
						'black'   => '#212121',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'woodmart_colorpicker',
					'heading'          => esc_html__( 'Idle background color', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'param_name'       => 'bg_color',
					'css_args'         => array(
						'background-color' => array(
							' a',
						),
						'border-color'     => array(
							' a',
						),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'woodmart_button_set',
					'heading'          => esc_html__( 'Idle text color scheme', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'param_name'       => 'color_scheme',
					'value'            => array(
						esc_html__( 'Light', 'woodmart' )  => 'light',
						esc_html__( 'Dark', 'woodmart' )   => 'dark',
						esc_html__( 'Custom', 'woodmart' ) => 'custom',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'heading'    => esc_html__( 'Custom text color', 'woodmart' ),
					'group'      => esc_html__( 'Style', 'woodmart' ),
					'type'       => 'wd_colorpicker',
					'param_name' => 'custom_color_scheme',
					'selectors'  => array(
						'{{WRAPPER}}.wd-button-wrapper a' => array(
							'color: {{VALUE}};',
						),
					),
					'dependency' => array(
						'element' => 'color_scheme',
						'value'   => 'custom',
					),
				),

				array(
					'type'             => 'woodmart_colorpicker',
					'heading'          => esc_html__( 'Background color on hover', 'woodmart' ),
					'param_name'       => 'bg_color_hover',
					'css_args'         => array(
						'background-color' => array(
							' a:hover',
						),
						'border-color'     => array(
							' a:hover',
						),
					),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'woodmart_button_set',
					'heading'          => esc_html__( 'Text color scheme on hover', 'woodmart' ),
					'param_name'       => 'color_scheme_hover',
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'value'            => array(
						esc_html__( 'Light', 'woodmart' )  => 'light',
						esc_html__( 'Dark', 'woodmart' )   => 'dark',
						esc_html__( 'Custom', 'woodmart' ) => 'custom',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'heading'    => esc_html__( 'Custom text color on hover', 'woodmart' ),
					'group'      => esc_html__( 'Style', 'woodmart' ),
					'type'       => 'wd_colorpicker',
					'param_name' => 'custom_color_scheme_hover',
					'selectors'  => array(
						'{{WRAPPER}}.wd-button-wrapper a:hover' => array(
							'color: {{VALUE}};',
						),
					),
					'dependency' => array(
						'element' => 'color_scheme_hover',
						'value'   => 'custom',
					),
				),

				$typography['font_family'],
				$typography['font_size'],
				$typography['font_weight'],
				$typography['text_transform'],
				$typography['font_style'],
				$typography['line_height'],

				/**
				 * Layout.
				 */
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Layout', 'woodmart' ),
					'group'      => esc_html__( 'Style', 'woodmart' ),
					'param_name' => 'layout_divider',
				),
				array(
					'type'             => 'woodmart_image_select',
					'heading'          => esc_html__( 'Align', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'param_name'       => 'align',
					'value'            => array(
						esc_html__( 'Left', 'woodmart' )   => 'left',
						esc_html__( 'Center', 'woodmart' ) => 'center',
						esc_html__( 'Right', 'woodmart' )  => 'right',
					),
					'images_value'     => array(
						'center' => WOODMART_ASSETS_IMAGES . '/settings/align/center.jpg',
						'left'   => WOODMART_ASSETS_IMAGES . '/settings/align/left.jpg',
						'right'  => WOODMART_ASSETS_IMAGES . '/settings/align/right.jpg',
					),
					'dependency'       => array(
						'element'            => 'button_inline',
						'value_not_equal_to' => array( 'yes' ),
					),
					'std'              => 'center',
					'wood_tooltip'     => true,
					'edit_field_class' => 'vc_col-sm-6 vc_column title-align',
				),

				array(
					'type'             => 'woodmart_switch',
					'heading'          => esc_html__( 'Full width', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'param_name'       => 'full_width',
					'true_state'       => 'yes',
					'false_state'      => 'no',
					'default'          => 'no',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'        => 'woodmart_switch',
					'heading'     => esc_html__( 'Button inline', 'woodmart' ),
					'group'       => esc_html__( 'Style', 'woodmart' ),
					'param_name'  => 'button_inline',
					'true_state'  => 'yes',
					'false_state' => 'no',
					'default'     => 'no',
				),

				/**
				 * Icon
				 */
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Icon', 'woodmart' ),
					'group'      => esc_html__( 'Style', 'woodmart' ),
					'param_name' => 'icon_divider',
				),
				array(
					'type'       => 'woodmart_button_set',
					'heading'    => esc_html__( 'Type', 'woodmart' ),
					'group'      => esc_html__( 'Style', 'woodmart' ),
					'param_name' => 'icon_type',
					'value'      => array(
						esc_html__( 'Icon', 'woodmart' )  => 'icon',
						esc_html__( 'Image', 'woodmart' ) => 'image',
					),
					'default'    => 'icon',
				),
				array(
					'type'             => 'attach_image',
					'heading'          => esc_html__( 'Image', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'param_name'       => 'image',
					'value'            => '',
					'dependency'       => array(
						'element' => 'icon_type',
						'value'   => 'image',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'textfield',
					'heading'          => esc_html__( 'Image size', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'param_name'       => 'img_size',
					'description'      => esc_html__( 'Example: \'thumbnail\', \'medium\', \'large\', \'full\' or enter image size in pixels: \'200x100\'.', 'woodmart' ),
					'dependency'       => array(
						'element' => 'icon_type',
						'value'   => 'image',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'       => 'dropdown',
					'heading'    => esc_html__( 'Icon library', 'woodmart' ),
					'group'      => esc_html__( 'Style', 'woodmart' ),
					'value'      => array(
						esc_html__( 'Font Awesome', 'woodmart' ) => 'fontawesome',
						esc_html__( 'Open Iconic', 'woodmart' ) => 'openiconic',
						esc_html__( 'Typicons', 'woodmart' ) => 'typicons',
						esc_html__( 'Entypo', 'woodmart' ) => 'entypo',
						esc_html__( 'Linecons', 'woodmart' ) => 'linecons',
						esc_html__( 'Mono Social', 'woodmart' ) => 'monosocial',
						esc_html__( 'Material', 'woodmart' ) => 'material',
					),
					'param_name' => 'icon_library',
					'hint'       => esc_html__( 'Select icon library.', 'woodmart' ),
					'dependency' => array(
						'element' => 'icon_type',
						'value'   => 'icon',
					),
				),
				array(
					'type'       => 'iconpicker',
					'heading'    => esc_html__( 'Icon', 'woodmart' ),
					'group'      => esc_html__( 'Style', 'woodmart' ),
					'param_name' => 'icon_fontawesome',
					'value'      => '',
					'settings'   => array(
						'emptyIcon'    => true,
						'iconsPerPage' => 4000,
					),
					'dependency' => array(
						'element' => 'icon_library',
						'value'   => array( 'fontawesome' ),
					),
					'hint'       => esc_html__( 'Select icon from library.', 'woodmart' ),
				),
				array(
					'type'       => 'iconpicker',
					'heading'    => esc_html__( 'Icon', 'woodmart' ),
					'group'      => esc_html__( 'Style', 'woodmart' ),
					'param_name' => 'icon_openiconic',
					'settings'   => array(
						'emptyIcon'    => true,
						'type'         => 'openiconic',
						'iconsPerPage' => 4000,
					),
					'dependency' => array(
						'element' => 'icon_library',
						'value'   => array( 'openiconic' ),
					),
					'hint'       => esc_html__( 'Select icon from library.', 'woodmart' ),
				),
				array(
					'type'       => 'iconpicker',
					'heading'    => esc_html__( 'Icon', 'woodmart' ),
					'group'      => esc_html__( 'Style', 'woodmart' ),
					'param_name' => 'icon_typicons',
					'settings'   => array(
						'emptyIcon'    => true,
						'type'         => 'typicons',
						'iconsPerPage' => 4000,
					),
					'dependency' => array(
						'element' => 'icon_library',
						'value'   => array( 'typicons' ),
					),
					'hint'       => esc_html__( 'Select icon from library.', 'woodmart' ),
				),
				array(
					'type'       => 'iconpicker',
					'heading'    => esc_html__( 'Icon', 'woodmart' ),
					'group'      => esc_html__( 'Style', 'woodmart' ),
					'param_name' => 'icon_entypo',
					'settings'   => array(
						'emptyIcon'    => true,
						'type'         => 'entypo',
						'iconsPerPage' => 4000,
					),
					'dependency' => array(
						'element' => 'icon_library',
						'value'   => array( 'entypo' ),
					),
				),
				array(
					'type'       => 'iconpicker',
					'heading'    => esc_html__( 'Icon', 'woodmart' ),
					'group'      => esc_html__( 'Style', 'woodmart' ),
					'param_name' => 'icon_linecons',
					'settings'   => array(
						'emptyIcon'    => true,
						'type'         => 'linecons',
						'iconsPerPage' => 4000,
					),
					'dependency' => array(
						'element' => 'icon_library',
						'value'   => array( 'linecons' ),
					),
					'hint'       => esc_html__( 'Select icon from library.', 'woodmart' ),
				),
				array(
					'type'       => 'iconpicker',
					'heading'    => esc_html__( 'Icon', 'woodmart' ),
					'group'      => esc_html__( 'Style', 'woodmart' ),
					'param_name' => 'icon_monosocial',
					'settings'   => array(
						'emptyIcon'    => true,
						'type'         => 'monosocial',
						'iconsPerPage' => 4000,
					),
					'dependency' => array(
						'element' => 'icon_library',
						'value'   => array( 'monosocial' ),
					),
					'hint'       => esc_html__( 'Select icon from library.', 'woodmart' ),
				),
				array(
					'type'       => 'iconpicker',
					'heading'    => esc_html__( 'Icon', 'woodmart' ),
					'group'      => esc_html__( 'Style', 'woodmart' ),
					'param_name' => 'icon_material',
					'settings'   => array(
						'emptyIcon'    => true,
						'type'         => 'material',
						'iconsPerPage' => 4000,
					),
					'dependency' => array(
						'element' => 'icon_library',
						'value'   => array( 'material' ),
					),
					'hint'       => esc_html__( 'Select icon from library.', 'woodmart' ),
				),
				array(
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'Button icon position', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'param_name'       => 'icon_position',
					'value'            => array(
						esc_html__( 'Left', 'woodmart' )  => 'left',
						esc_html__( 'Right', 'woodmart' ) => 'right',
					),
					'std'              => 'right',
					'edit_field_class' => 'vc_col-xs-12 vc_column button-style',
				),

				// Design Options tab.
				array(
					'type'       => 'css_editor',
					'heading'    => esc_html__( 'CSS box', 'woodmart' ),
					'param_name' => 'css',
					'group'      => esc_html__( 'Design Options', 'js_composer' ),
				),
				function_exists( 'woodmart_get_vc_responsive_spacing_map' ) ? woodmart_get_vc_responsive_spacing_map() : '',

				/**
				 * Advanced Tab.
				 */
				woodmart_get_vc_responsive_visible_map( 'responsive_tabs_hide' ),
				woodmart_get_vc_responsive_visible_map( 'wd_hide_on_desktop' ),
				woodmart_get_vc_responsive_visible_map( 'wd_hide_on_tablet' ),
				woodmart_get_vc_responsive_visible_map( 'wd_hide_on_mobile' ),
			)
		);
	}
}
