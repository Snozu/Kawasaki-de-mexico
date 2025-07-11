<?php
namespace XTS\Modules\Header_Builder\Elements;

use XTS\Modules\Header_Builder\Element;

/**
 * ------------------------------------------------------------------------------------------------
 *  Secondary menu element
 * ------------------------------------------------------------------------------------------------
 */
class Menu extends Element {

	public function __construct() {
		parent::__construct();
		$this->template_name = 'menu';
	}

	public function map() {
		$this->args = array(
			'type'            => 'menu',
			'title'           => esc_html__( 'Menu', 'woodmart' ),
			'text'            => esc_html__( 'Secondary menu', 'woodmart' ),
			'icon'            => 'xts-i-menu',
			'editable'        => true,
			'container'       => false,
			'drg'             => false,
			'drag_target_for' => array(),
			'drag_source'     => 'content_element',
			'edit_on_create'  => true,
			'removable'       => true,
			'addable'         => true,
			'params'          => array(
				'menu_id'        => array(
					'id'          => 'menu_id',
					'title'       => esc_html__( 'Choose menu', 'woodmart' ),
					'type'        => 'select',
					'tab'         => esc_html__( 'General', 'woodmart' ),
					'value'       => '',
					'callback'    => 'get_menu_options_with_empty',
					'description' => esc_html__( 'Choose which menu to display in the header.', 'woodmart' ),
				),
				'menu_style'     => array(
					'id'          => 'menu_style',
					'title'       => esc_html__( 'Style', 'woodmart' ),
					'type'        => 'selector',
					'tab'         => esc_html__( 'Style', 'woodmart' ),
					'group'       => esc_html__( 'Menu', 'woodmart' ),
					'value'       => 'default',
					'options'     => array(
						'default'   => array(
							'value' => 'default',
							'image' => WOODMART_ASSETS_IMAGES . '/header-builder/menu-style/default.jpg',
							'label' => esc_html__( 'Default', 'woodmart' ),
						),
						'underline' => array(
							'value' => 'underline',
							'image' => WOODMART_ASSETS_IMAGES . '/header-builder/menu-style/underline.jpg',
							'label' => esc_html__( 'Underline', 'woodmart' ),
						),
						'bordered'  => array(
							'value' => 'bordered',
							'image' => WOODMART_ASSETS_IMAGES . '/header-builder/menu-style/bordered.jpg',
							'label' => esc_html__( 'Bordered', 'woodmart' ),
						),
						'separated' => array(
							'value' => 'separated',
							'image' => WOODMART_ASSETS_IMAGES . '/header-builder/menu-style/separated.jpg',
							'label' => esc_html__( 'Separated', 'woodmart' ),
						),
						'bg'        => array(
							'value' => 'bg',
							'image' => WOODMART_ASSETS_IMAGES . '/header-builder/menu-style/background.jpg',
							'label' => esc_html__( 'Background', 'woodmart' ),
						),
					),
					'description' => esc_html__( 'You can change menu style in the header.', 'woodmart' ),
				),
				'menu_align'     => array(
					'id'          => 'menu_align',
					'title'       => esc_html__( 'Menu align', 'woodmart' ),
					'type'        => 'selector',
					'tab'         => esc_html__( 'Style', 'woodmart' ),
					'group'       => esc_html__( 'Menu', 'woodmart' ),
					'value'       => 'left',
					'options'     => array(
						'left'   => array(
							'value' => 'left',
							'label' => esc_html__( 'Left', 'woodmart' ),
						),
						'center' => array(
							'value' => 'center',
							'label' => esc_html__( 'Center', 'woodmart' ),
						),
						'right'  => array(
							'value' => 'right',
							'label' => esc_html__( 'Right', 'woodmart' ),
						),
					),
					'description' => esc_html__( 'Set the menu items text align.', 'woodmart' ),
				),
				'items_gap'      => array(
					'id'          => 'items_gap',
					'title'       => esc_html__( 'Items gap', 'woodmart' ),
					'type'        => 'selector',
					'tab'         => esc_html__( 'Style', 'woodmart' ),
					'group'       => esc_html__( 'Menu', 'woodmart' ),
					'value'       => 's',
					'options'     => array(
						's' => array(
							'value' => 's',
							'label' => esc_html__( 'Small', 'woodmart' ),
						),
						'm' => array(
							'value' => 'm',
							'label' => esc_html__( 'Medium', 'woodmart' ),
						),
						'l' => array(
							'value' => 'l',
							'label' => esc_html__( 'Large', 'woodmart' ),
						),
					),
					'description' => esc_html__( 'Set the items gap.', 'woodmart' ),
				),
				'icon_width'     => array(
					'id'          => 'icon_width',
					'title'       => esc_html__( 'Width', 'woodmart' ),
					'hint'        => '<video src="' . WOODMART_TOOLTIP_URL . 'hb_icon_width.mp4" autoplay loop muted></video>',
					'type'        => 'slider',
					'tab'         => esc_html__( 'Style', 'woodmart' ),
					'group'       => esc_html__( 'Menu icon', 'woodmart' ),
					'from'        => 0,
					'to'          => 60,
					'value'       => '',
					'units'       => 'px',
					'selectors'   => array(
						'{{WRAPPER}} > .wd-nav > li > a .wd-nav-img' => array(
							'--nav-img-width: {{VALUE}}px;',
						),
					),
					'extra_class' => 'xts-col-6',
				),
				'icon_height'    => array(
					'id'          => 'icon_height',
					'title'       => esc_html__( 'Height', 'woodmart' ),
					'hint'        => '<video src="' . WOODMART_TOOLTIP_URL . 'hb_icon_height.mp4" autoplay loop muted></video>',
					'type'        => 'slider',
					'tab'         => esc_html__( 'Style', 'woodmart' ),
					'group'       => esc_html__( 'Menu icon', 'woodmart' ),
					'from'        => 0,
					'to'          => 60,
					'value'       => '',
					'units'       => 'px',
					'selectors'   => array(
						'{{WRAPPER}} > .wd-nav > li > a .wd-nav-img' => array(
							'--nav-img-height: {{VALUE}}px;',
						),
					),
					'extra_class' => 'xts-col-6',
				),
				'bg_overlay'     => array(
					'id'          => 'bg_overlay',
					'title'       => esc_html__( 'Background overlay', 'woodmart' ),
					'hint'        => '<video src="' . WOODMART_TOOLTIP_URL . 'hb_bg_overlay.mp4" autoplay loop muted></video>',
					'description' => __( 'Highlight dropdowns by darkening the background behind.', 'woodmart' ),
					'type'        => 'switcher',
					'tab'         => esc_html__( 'Style', 'woodmart' ),
					'group'       => esc_html__( 'Extra', 'woodmart' ),
					'value'       => false,
				),
				'inline'         => array(
					'id'          => 'inline',
					'title'       => esc_html__( 'Display inline', 'woodmart' ),
					'type'        => 'switcher',
					'tab'         => esc_html__( 'Style', 'woodmart' ),
					'group'       => esc_html__( 'Extra', 'woodmart' ),
					'value'       => false,
					'description' => esc_html__( 'The width of the element will depend on its content', 'woodmart' ),
				),
			),
		);
	}
}
