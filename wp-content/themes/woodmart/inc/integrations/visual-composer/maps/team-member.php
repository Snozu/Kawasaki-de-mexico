<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}
/**
* ------------------------------------------------------------------------------------------------
* Team Member element map
* ------------------------------------------------------------------------------------------------
*/

if ( ! function_exists( 'woodmart_get_vc_map_team_member' ) ) {
	/**
	 * Team member element map.
	 *
	 * @return array
	 */
	function woodmart_get_vc_map_team_member() {
		$name_typography = woodmart_get_typography_map(
			array(
				'title'    => esc_html__( 'Name typography', 'woodmart' ),
				'key'      => 'name_typography',
				'selector' => '{{WRAPPER}}.team-member .member-name',
			)
		);

		$position_typography = woodmart_get_typography_map(
			array(
				'title'    => esc_html__( 'Position typography', 'woodmart' ),
				'key'      => 'position_typography',
				'selector' => '{{WRAPPER}}.team-member .member-position',
			)
		);

		return array(
			'name'        => esc_html__( 'Team Member', 'woodmart' ),
			'base'        => 'team_member',
			'category'    => woodmart_get_tab_title_category_for_wpb( esc_html__( 'Theme elements', 'woodmart' ) ),
			'description' => esc_html__( 'Display information about some person', 'woodmart' ),
			'icon'        => WOODMART_ASSETS . '/images/vc-icon/team-member.svg',
			'params'      => array(
				array(
					'type'       => 'woodmart_css_id',
					'param_name' => 'woodmart_css_id',
				),
				/**
				 * Image
				 */
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Image', 'woodmart' ),
					'param_name' => 'image_divider',
				),
				array(
					'type'             => 'attach_image',
					'heading'          => esc_html__( 'User Avatar', 'woodmart' ),
					'param_name'       => 'image',
					'value'            => '',
					'hint'             => esc_html__( 'Select image from media library.', 'woodmart' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'textfield',
					'heading'          => esc_html__( 'Image size', 'woodmart' ),
					'param_name'       => 'img_size',
					'hint'             => esc_html__( 'Enter image size. Example: \'thumbnail\', \'medium\', \'large\', \'full\' or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use \'thumbnail\' size.', 'woodmart' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				/**
				 * Content
				 */
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Content', 'woodmart' ),
					'param_name' => 'content_divider',
				),
				array(
					'type'             => 'textfield',
					'heading'          => esc_html__( 'Name', 'woodmart' ),
					'param_name'       => 'name',
					'value'            => '',
					'hint'             => esc_html__( 'Enter the person’s name.', 'woodmart' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				$name_typography['font_family'],
				$name_typography['font_size'],
				$name_typography['font_weight'],
				$name_typography['text_transform'],
				$name_typography['font_style'],
				$name_typography['line_height'],
				array(
					'type'             => 'textfield',
					'heading'          => esc_html__( 'Position', 'woodmart' ),
					'param_name'       => 'position',
					'value'            => '',
					'hint'             => esc_html__( 'Enter the person’s title or job position. For example: CEO or Senior Developer.', 'woodmart' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				$position_typography['font_family'],
				$position_typography['font_size'],
				$position_typography['font_weight'],
				$position_typography['text_transform'],
				$position_typography['font_style'],
				$position_typography['line_height'],
				array(
					'type'       => 'textarea_html',
					'heading'    => esc_html__( 'Text', 'woodmart' ),
					'param_name' => 'content',
					'hint'       => esc_html__( 'You can add some member bio here.', 'woodmart' ),
				),
				/**
				 * Layout
				 */
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Layout', 'woodmart' ),
					'param_name' => 'layout_divider',
				),
				array(
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'Layout', 'woodmart' ),
					'param_name'       => 'layout',
					'value'            => array(
						esc_html__( 'Default', 'woodmart' ) => 'default',
						esc_html__( 'With hover', 'woodmart' ) => 'hover',
					),
					'hint'             => esc_html__( 'You can use different design for your team member styled for the theme', 'woodmart' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'woodmart_image_select',
					'heading'          => esc_html__( 'Align', 'woodmart' ),
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
					'std'              => 'left',
					'wood_tooltip'     => true,
					'edit_field_class' => 'vc_col-sm-6 vc_column title-align',
				),
				/**
				 * Social links
				 */
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Social links', 'woodmart' ),
					'param_name' => 'links_divider',
				),
				array(
					'type'             => 'textfield',
					'heading'          => esc_html__( 'Facebook link', 'woodmart' ),
					'param_name'       => 'facebook',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'textfield',
					'heading'          => esc_html__( 'X link', 'woodmart' ),
					'param_name'       => 'twitter',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'textfield',
					'heading'          => esc_html__( 'Linkedin link', 'woodmart' ),
					'param_name'       => 'linkedin',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'textfield',
					'heading'          => esc_html__( 'Instagram link', 'woodmart' ),
					'param_name'       => 'instagram',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				/**
				 * Buttons
				 */
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Buttons', 'woodmart' ),
					'param_name' => 'buttons_divider',
				),
				array(
					'type'             => 'woodmart_image_select',
					'heading'          => esc_html__( 'Social button style', 'woodmart' ),
					'param_name'       => 'style',
					'value'            => array(
						esc_html__( 'Default', 'woodmart' ) => '',
						esc_html__( 'Simple', 'woodmart' ) => 'simple',
						esc_html__( 'Colored', 'woodmart' ) => 'colored',
						esc_html__( 'Colored alternative', 'woodmart' ) => 'colored-alt',
						esc_html__( 'Bordered', 'woodmart' ) => 'bordered',
						esc_html__( 'Primary color', 'woodmart' ) => 'primary',
					),
					'images_value'     => array(
						''            => WOODMART_ASSETS_IMAGES . '/settings/social-buttons/style/default.png',
						'simple'      => WOODMART_ASSETS_IMAGES . '/settings/social-buttons/style/simple.png',
						'colored'     => WOODMART_ASSETS_IMAGES . '/settings/social-buttons/style/colored.png',
						'colored-alt' => WOODMART_ASSETS_IMAGES . '/settings/social-buttons/style/colored-alt.png',
						'bordered'    => WOODMART_ASSETS_IMAGES . '/settings/social-buttons/style/bordered.png',
						'primary'     => WOODMART_ASSETS_IMAGES . '/settings/social-buttons/style/primary.png',
					),
					'wood_tooltip'     => true,
					'std'              => 'default',
					'edit_field_class' => 'vc_col-xs-12 vc_column social-style',
				),
				array(
					'type'             => 'woodmart_image_select',
					'heading'          => esc_html__( 'Social button form', 'woodmart' ),
					'param_name'       => 'form',
					'value'            => array(
						esc_html__( 'Circle', 'woodmart' ) => 'circle',
						esc_html__( 'Square', 'woodmart' ) => 'square',
						esc_html__( 'Rounded', 'woodmart' ) => 'rounded',
					),
					'images_value'     => array(
						'circle' => WOODMART_ASSETS_IMAGES . '/settings/social-buttons/shape/circle.png',
						'square' => WOODMART_ASSETS_IMAGES . '/settings/social-buttons/shape/square.png',
						'rounded' => WOODMART_ASSETS_IMAGES . '/settings/social-buttons/shape/rounded.png',
					),
					'wood_tooltip'     => true,
					'std'              => 'default',
					'edit_field_class' => 'vc_col-xs-12 vc_column social-form',
				),
				array(
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'Buttons size', 'woodmart' ),
					'param_name'       => 'size',
					'value'            => array(
						esc_html__( 'Default', 'woodmart' ) => '',
						esc_html__( 'Small', 'woodmart' ) => 'small',
						esc_html__( 'Large', 'woodmart' ) => 'large',
					),
					'group'            => esc_html__( 'Style', 'js_composer' ),
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
				array(
					'type'       => 'woodmart_button_set',
					'heading'    => esc_html__( 'Color Scheme', 'woodmart' ),
					'param_name' => 'woodmart_color_scheme',
					'value'      => array(
						esc_html__( 'Inherit', 'woodmart' ) => '',
						esc_html__( 'Light', 'woodmart' ) => 'light',
						esc_html__( 'Dark', 'woodmart' )  => 'dark',
					),
				),
				( function_exists( 'vc_map_add_css_animation' ) ) ? vc_map_add_css_animation( true ) : '',
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Extra class name', 'woodmart' ),
					'param_name' => 'el_class',
					'hint'       => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' ),
				),
				/**
				 * Design options
				 */
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
