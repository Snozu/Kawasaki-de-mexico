<?php
/**
 * Single product options.
 *
 * @package woodmart
 */

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

use XTS\Admin\Modules\Options;

/**
 * Product page
 */

Options::add_field(
	array(
		'id'          => 'single_product_layout',
		'name'        => esc_html__( 'Single product sidebar', 'woodmart' ),
		'description' => esc_html__( 'Select main Tab content and sidebar alignment for single product pages.', 'woodmart' ),
		'group'       => esc_html__( 'Sidebar', 'woodmart' ),
		'type'        => 'buttons',
		'section'     => 'single_product_section',
		'options'     => array(
			'full-width'    => array(
				'name'  => esc_html__( '1 Column', 'woodmart' ),
				'value' => 'full-width',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/sidebar-layout/none.png',
			),
			'sidebar-left'  => array(
				'name'  => esc_html__( '2 Column Left', 'woodmart' ),
				'value' => 'sidebar-left',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/sidebar-layout/left.png',
			),
			'sidebar-right' => array(
				'name'  => esc_html__( '2 Column Right', 'woodmart' ),
				'value' => 'sidebar-right',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/sidebar-layout/right.png',
			),
		),
		'default'     => 'full-width',
		'priority'    => 10,
	)
);

Options::add_field(
	array(
		'id'          => 'full_height_sidebar',
		'name'        => esc_html__( 'Full height sidebar', 'woodmart' ),
		'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'full-height-sidebar.mp4" autoplay loop muted></video>',
		'description' => esc_html__( 'If you have a lot of widgets added to the sidebar your single product page layout may look inconsistent. Try to enable this option in this situation.', 'woodmart' ),
		'group'       => esc_html__( 'Sidebar', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'single_product_section',
		'default'     => false,
		'priority'    => 20,
		'requires'    => array(
			array(
				'key'     => 'single_product_layout',
				'compare' => 'not_equals',
				'value'   => 'full-width',
			),
		),
	)
);


Options::add_field(
	array(
		'id'          => 'single_sidebar_width',
		'name'        => esc_html__( 'Sidebar size', 'woodmart' ),
		'description' => esc_html__( 'You can set different sizes for your single product pages sidebar', 'woodmart' ),
		'group'       => esc_html__( 'Sidebar', 'woodmart' ),
		'type'        => 'buttons',
		'section'     => 'single_product_section',
		'options'     => array(
			2 => array(
				'name'  => esc_html__( 'Small', 'woodmart' ),
				'value' => 2,
			),
			3 => array(
				'name'  => esc_html__( 'Medium', 'woodmart' ),
				'value' => 3,
			),
			4 => array(
				'name'  => esc_html__( 'Large', 'woodmart' ),
				'value' => 4,
			),
		),
		'default'     => 3,
		'requires'    => array(
			array(
				'key'     => 'single_product_layout',
				'compare' => 'not_equals',
				'value'   => 'full-width',
			),
		),
		'priority'    => 30,
		'class'       => 'xts-tooltip-bordered',
	)
);

Options::add_field(
	array(
		'id'          => 'single_product_hide_sidebar',
		'section'     => 'single_product_section',
		'name'        => esc_html__( 'Off canvas sidebar for desktop', 'woodmart' ),
		'description' => esc_html__( 'You can hide the sidebar on desktop and show it nicely with a button click.', 'woodmart' ),
		'group'       => esc_html__( 'Sidebar', 'woodmart' ),
		'type'        => 'switcher',
		'default'     => '0',
		't_tab'       => array(
			'id'       => 'single_product_hide_sidebar_tabs',
			'tab'      => esc_html__( 'Desktop', 'woodmart' ),
			'icon'     => 'xts-i-desktop',
			'style'    => 'devices',
			'requires' => array(
				array(
					'key'     => 'single_product_layout',
					'compare' => 'not_equals',
					'value'   => 'full-width',
				),
			),
		),
		'requires'    => array(
			array(
				'key'     => 'single_product_layout',
				'compare' => 'not_equals',
				'value'   => 'full-width',
			),
		),
		'priority'    => 35,
	)
);

Options::add_field(
	array(
		'id'          => 'single_product_hide_sidebar_tablet',
		'name'        => esc_html__( 'Off canvas sidebar for tablet', 'woodmart' ),
		'description' => esc_html__( 'You can hide the sidebar on tablet and show it nicely with a button click.', 'woodmart' ),
		'group'       => esc_html__( 'Sidebar', 'woodmart' ),
		'section'     => 'single_product_section',
		'type'        => 'switcher',
		'default'     => '1',
		't_tab'       => array(
			'id'   => 'single_product_hide_sidebar_tabs',
			'tab'  => esc_html__( 'Tablet', 'woodmart' ),
			'icon' => 'xts-i-tablet',
		),
		'requires'    => array(
			array(
				'key'     => 'single_product_layout',
				'compare' => 'not_equals',
				'value'   => 'full-width',
			),
		),
		'priority'    => 36,
	)
);

Options::add_field(
	array(
		'id'          => 'single_product_hide_sidebar_mobile',
		'name'        => esc_html__( 'Off canvas sidebar for mobile', 'woodmart' ),
		'description' => esc_html__( 'You can hide the sidebar on mobile devices and show it nicely with a button click.', 'woodmart' ),
		'group'       => esc_html__( 'Sidebar', 'woodmart' ),
		'section'     => 'single_product_section',
		'type'        => 'switcher',
		'default'     => '1',
		't_tab'       => array(
			'id'   => 'single_product_hide_sidebar_tabs',
			'tab'  => esc_html__( 'Mobile', 'woodmart' ),
			'icon' => 'xts-i-phone',
		),
		'requires'    => array(
			array(
				'key'     => 'single_product_layout',
				'compare' => 'not_equals',
				'value'   => 'full-width',
			),
		),
		'priority'    => 37,
	)
);

/**
 * Images.
 */
Options::add_field(
	array(
		'id'          => 'single_product_style',
		'name'        => esc_html__( 'Product page layout', 'woodmart' ),
		'description' => esc_html__( 'You can choose different page layout depending on the product image size you need', 'woodmart' ),
		'group'       => esc_html__( 'Layout', 'woodmart' ),
		'type'        => 'buttons',
		'section'     => 'single_product_section',
		'options'     => array(
			1 => array(
				'name'  => esc_html__( 'Small image', 'woodmart' ),
				'value' => 1,
				'image' => WOODMART_ASSETS_IMAGES . '/settings/single-product-image-width/small.jpg',
			),
			2 => array(
				'name'  => esc_html__( 'Medium', 'woodmart' ),
				'value' => 2,
				'image' => WOODMART_ASSETS_IMAGES . '/settings/single-product-image-width/medium.jpg',
			),
			3 => array(
				'name'  => esc_html__( 'Large', 'woodmart' ),
				'value' => 3,
				'image' => WOODMART_ASSETS_IMAGES . '/settings/single-product-image-width/large.jpg',
			),
			4 => array(
				'name'  => esc_html__( 'Full width (container)', 'woodmart' ),
				'value' => 4,
				'image' => WOODMART_ASSETS_IMAGES . '/settings/single-product-image-width/fw-container.jpg',
			),
			5 => array(
				'name'  => esc_html__( 'Full width (window)', 'woodmart' ),
				'value' => 5,
				'image' => WOODMART_ASSETS_IMAGES . '/settings/single-product-image-width/fw-window.jpg',
			),
		),
		'default'     => 2,
		'priority'    => 40,
	)
);

Options::add_field(
	array(
		'id'          => 'product_design',
		'name'        => esc_html__( 'Product page design', 'woodmart' ),
		'description' => esc_html__( 'Choose between different predefined designs', 'woodmart' ),
		'group'       => esc_html__( 'Layout', 'woodmart' ),
		'type'        => 'buttons',
		'section'     => 'single_product_section',
		'options'     => array(
			'default' => array(
				'name'  => esc_html__( 'Default', 'woodmart' ),
				'value' => 'default',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/product-page/product-page-default.jpg',
			),
			'alt'     => array(
				'name'  => esc_html__( 'Centered', 'woodmart' ),
				'value' => 'default',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/product-page/product-page-alt.jpg',
			),
		),
		'default'     => 'default',
		'priority'    => 45,
	)
);

Options::add_field(
	array(
		'id'          => 'product_sticky',
		'name'        => esc_html__( 'Sticky product', 'woodmart' ),
		'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'sticky-product.mp4" autoplay loop muted></video>',
		'description' => esc_html__( 'If you turn on this option, the section with description will be sticky when you scroll the page. In case when the description is higher than images, the images section will be fixed instead.', 'woodmart' ),
		'group'       => esc_html__( 'Layout', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'single_product_section',
		'default'     => false,
		'priority'    => 50,
	)
);

Options::add_field(
	array(
		'id'          => 'product_summary_shadow',
		'name'        => esc_html__( 'Add shadow to product summary block', 'woodmart' ),
		'hint'        => wp_kses( '<img data-src="' . WOODMART_TOOLTIP_URL . 'add-shadow-to-product-summary-block.jpg" alt="">', true ),
		'description' => esc_html__( 'Useful when you set background color for the single product page to gray for example.', 'woodmart' ),
		'group'       => esc_html__( 'Layout', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'single_product_section',
		'default'     => false,
		'on-text'     => esc_html__( 'Yes', 'woodmart' ),
		'off-text'    => esc_html__( 'No', 'woodmart' ),
		'priority'    => 60,
	)
);

Options::add_field(
	array(
		'id'          => 'single_full_width',
		'name'        => esc_html__( 'Full width product page', 'woodmart' ),
		'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'full-width-product-page.mp4" autoplay loop muted></video>',
		'description' => esc_html__( 'Stretch the single product page content.', 'woodmart' ),
		'group'       => esc_html__( 'Layout', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'single_product_section',
		'default'     => false,
		'priority'    => 70,
	)
);

Options::add_field(
	array(
		'id'          => 'single_product_header',
		'name'        => esc_html__( 'Custom single product header', 'woodmart' ),
		'description' => esc_html__( 'You can use different header for your single product page.', 'woodmart' ),
		'group'       => esc_html__( 'Layout', 'woodmart' ),
		'type'        => 'select',
		'section'     => 'single_product_section',
		'options'     => '',
		'callback'    => 'woodmart_get_theme_settings_headers_array',
		'default'     => 'none',
		'priority'    => 80,
	)
);

Options::add_field(
	array(
		'id'           => 'single_product_builder_post_data',
		'name'         => esc_html__( 'Select preview product for builder', 'woodmart' ),
		'description'  => esc_html__( 'The information from this product will be used as an example while you are working with the product template and Elementor.', 'woodmart' ),
		'group'        => esc_html__( 'Builder', 'woodmart' ),
		'type'         => 'select',
		'section'      => 'single_product_section',
		'select2'      => true,
		'empty_option' => true,
		'autocomplete' => array(
			'type'   => 'post',
			'value'  => 'product',
			'search' => 'woodmart_get_post_by_query_autocomplete',
			'render' => 'woodmart_get_post_by_ids_autocomplete',
		),
		'priority'     => 110,
		'class'        => 'xts-preset-field-disabled',
	)
);

Options::add_field(
	array(
		'id'          => 'image_action',
		'name'        => esc_html__( 'Main image click action', 'woodmart' ),
		'description' => esc_html__( 'Enable/disable zoom option or switch to photoswipe popup.', 'woodmart' ),
		'group'       => esc_html__( 'Main image', 'woodmart' ),
		'type'        => 'buttons',
		'section'     => 'product_images',
		'options'     => array(
			'zoom'  => array(
				'name'  => esc_html__( 'Zoom', 'woodmart' ),
				'hint'  => '<video data-src="' . WOODMART_TOOLTIP_URL . 'main-image-click-action-zoom.mp4" autoplay loop muted></video>',
				'value' => 'zoom',
			),
			'popup' => array(
				'name'  => esc_html__( 'Photoswipe popup', 'woodmart' ),
				'hint'  => '<video data-src="' . WOODMART_TOOLTIP_URL . 'main-image-click-action-photoswipe.mp4" autoplay loop muted></video>',
				'value' => 'popup',
			),
			'none'  => array(
				'name'  => esc_html__( 'None', 'woodmart' ),
				'value' => 'none',
			),
		),
		'default'     => 'zoom',
		'priority'    => 170,
	)
);

Options::add_field(
	array(
		'id'          => 'photoswipe_icon',
		'name'        => esc_html__( 'Show "Click to enlarge" icon', 'woodmart' ),
		'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'show-zoom-image-icon.mp4" autoplay loop muted></video>',
		'description' => esc_html__( 'Click to open image in popup and swipe to zoom', 'woodmart' ),
		'group'       => esc_html__( 'Main image', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'product_images',
		'default'     => '1',
		'on-text'     => esc_html__( 'Yes', 'woodmart' ),
		'off-text'    => esc_html__( 'No', 'woodmart' ),
		'priority'    => 180,
	)
);

Options::add_field(
	array(
		'id'          => 'product_slider_auto_height',
		'name'        => esc_html__( 'Main carousel auto height', 'woodmart' ),
		'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'main-carousel-auto-height.mp4" autoplay loop muted></video>',
		'description' => esc_html__( 'Useful when you have product images with different height.', 'woodmart' ),
		'group'       => esc_html__( 'Main image', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'product_images',
		'default'     => false,
		'priority'    => 190,
	)
);

Options::add_field(
	array(
		'id'       => 'pagination_main_gallery',
		'name'     => esc_html__( 'Main carousel with pagination', 'woodmart' ),
		'hint'     => '<video data-src="' . WOODMART_TOOLTIP_URL . 'pagination-main-gallery.mp4" autoplay loop muted></video>',
		'group'    => esc_html__( 'Main image', 'woodmart' ),
		'type'     => 'switcher',
		'section'  => 'product_images',
		'default'  => false,
		'priority' => 210,
	)
);

Options::add_field(
	array(
		'id'          => 'product_images_captions',
		'name'        => esc_html__( 'Images captions on Photo Swipe lightbox', 'woodmart' ),
		'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'images-captions-on-photo-swipe-lightbox.mp4" autoplay loop muted></video>',
		'description' => esc_html__( 'Display caption texts below images when you open the photoswipe popup. Captions can be added to your images via the Media library.', 'woodmart' ),
		'group'       => esc_html__( 'Main image', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'product_images',
		'default'     => false,
		'priority'    => 220,
	)
);

Options::add_field(
	array(
		'id'       => 'thums_position',
		'name'     => esc_html__( 'Gallery layout', 'woodmart' ),
		'group'    => esc_html__( 'Image gallery', 'woodmart' ),
		'type'     => 'buttons',
		'section'  => 'product_images',
		'options'  => array(
			'left'              => array(
				'name'  => esc_html__( 'Thumbnails left', 'woodmart' ),
				'value' => 'left',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/single-product-image/left.jpg',
			),
			'bottom'            => array(
				'name'  => esc_html__( 'Thumbnails bottom', 'woodmart' ),
				'value' => 'bottom',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/single-product-image/bottom.jpg',
			),
			'without'           => array(
				'name'  => esc_html__( 'Carousel', 'woodmart' ),
				'value' => 'without',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/single-product-image/without.jpg',
			),
			'bottom_column'     => array(
				'name'  => esc_html__( 'Grid', 'woodmart' ),
				'value' => 'left',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/single-product-image/grid.jpg',
			),
			'bottom_grid'       => array(
				'name'  => esc_html__( 'Bottom grid', 'woodmart' ),
				'value' => 'left',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/single-product-image/bottom_grid.jpg',
			),
			'bottom_combined'   => array(
				'name'  => esc_html__( 'Combined grid 1', 'woodmart' ),
				'value' => 'bottom_combined',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/single-product-image/bottom_combined.jpg',
			),
			'bottom_combined_2' => array(
				'name'  => esc_html__( 'Combined grid 2', 'woodmart' ),
				'value' => 'bottom_combined_2',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/single-product-image/bottom_combined_2.jpg',
			),
			'bottom_combined_3' => array(
				'name'  => esc_html__( 'Combined grid 3', 'woodmart' ),
				'value' => 'bottom_combined_3',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/single-product-image/bottom_combined_3.jpg',
			),
		),
		'default'  => 'left',
		'priority' => 60,
		'class'    => 'xts-thumbnails-position',
	)
);

Options::add_field(
	array(
		'id'            => 'single_product_grid_columns_gap',
		'name'          => esc_html__( 'Gallery gap', 'woodmart' ),
		'type'          => 'responsive_range',
		'section'       => 'product_images',
		'group'         => esc_html__( 'Image gallery', 'woodmart' ),
		'hint'          => '<video data-src="' . WOODMART_TOOLTIP_URL . 'single-product-gallery-gap.mp4" autoplay loop muted></video>',
		'selectors'     => array(
			'.woocommerce-product-gallery' => array(
				'--wd-gallery-gap: {{VALUE}}{{UNIT}};',
			),
		),
		'devices'       => array(
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
		'range'         => array(
			'px' => array(
				'min'  => 0,
				'max'  => 50,
				'step' => 1,
			),
		),
		'generate_zero' => true,
		'priority'      => 65,
	)
);

Options::add_field(
	array(
		'id'       => 'single_product_grid_column_desktop',
		'name'     => esc_html__( 'Columns on desktop', 'woodmart' ),
		'group'    => esc_html__( 'Image gallery', 'woodmart' ),
		'type'     => 'buttons',
		'section'  => 'product_images',
		'options'  => array(
			1 => array(
				'name'  => 1,
				'value' => 1,
			),
			2 => array(
				'name'  => 2,
				'value' => 2,
			),
			3 => array(
				'name'  => 3,
				'value' => 3,
			),
			4 => array(
				'name'  => 4,
				'value' => 4,
			),
			5 => array(
				'name'  => 5,
				'value' => 5,
			),
			6 => array(
				'name'  => 6,
				'value' => 6,
			),
		),
		'default'  => '',
		'priority' => 70,
		'requires' => array(
			array(
				'key'     => 'thums_position',
				'compare' => 'equals',
				'value'   => array( 'bottom_column', 'bottom_grid' ),
			),
		),
		't_tab'    => array(
			'id'       => 'single_product_grid_column_tabs',
			'tab'      => esc_html__( 'Desktop', 'woodmart' ),
			'title'    => esc_html__( 'Thumbnails columns', 'woodmart' ),
			'icon'     => 'xts-i-desktop',
			'style'    => 'devices',
			'requires' => array(
				array(
					'key'     => 'thums_position',
					'compare' => 'equals',
					'value'   => array( 'bottom_column', 'bottom_grid' ),
				),
			),
		),
	)
);

Options::add_field(
	array(
		'id'       => 'single_product_grid_column_tablet',
		'name'     => esc_html__( 'Columns on tablet', 'woodmart' ),
		'group'    => esc_html__( 'Image gallery', 'woodmart' ),
		'type'     => 'buttons',
		'section'  => 'product_images',
		'options'  => array(
			1 => array(
				'name'  => 1,
				'value' => 1,
			),
			2 => array(
				'name'  => 2,
				'value' => 2,
			),
			3 => array(
				'name'  => 3,
				'value' => 3,
			),
			4 => array(
				'name'  => 4,
				'value' => 4,
			),
			5 => array(
				'name'  => 5,
				'value' => 5,
			),
			6 => array(
				'name'  => 6,
				'value' => 6,
			),
		),
		'default'  => '',
		'priority' => 71,
		'requires' => array(
			array(
				'key'     => 'thums_position',
				'compare' => 'equals',
				'value'   => array( 'bottom_column', 'bottom_grid' ),
			),
		),
		't_tab'    => array(
			'id'    => 'single_product_grid_column_tabs',
			'icon'  => 'xts-i-tablet',
			'style' => 'devices',
			'tab'   => esc_html__( 'Tablet', 'woodmart' ),
		),
	)
);

Options::add_field(
	array(
		'id'       => 'single_product_grid_column_mobile',
		'name'     => esc_html__( 'Columns on mobile', 'woodmart' ),
		'group'    => esc_html__( 'Image gallery', 'woodmart' ),
		'type'     => 'buttons',
		'section'  => 'product_images',
		'options'  => array(
			1 => array(
				'name'  => 1,
				'value' => 1,
			),
			2 => array(
				'name'  => 2,
				'value' => 2,
			),
			3 => array(
				'name'  => 3,
				'value' => 3,
			),
			4 => array(
				'name'  => 4,
				'value' => 4,
			),
			5 => array(
				'name'  => 5,
				'value' => 5,
			),
			6 => array(
				'name'  => 6,
				'value' => 6,
			),
		),
		'default'  => '',
		'priority' => 72,
		'requires' => array(
			array(
				'key'     => 'thums_position',
				'compare' => 'equals',
				'value'   => array( 'bottom_column', 'bottom_grid' ),
			),
		),
		't_tab'    => array(
			'id'    => 'single_product_grid_column_tabs',
			'icon'  => 'xts-i-phone',
			'style' => 'devices',
			'tab'   => esc_html__( 'Mobile', 'woodmart' ),
		),
	)
);

Options::add_field(
	array(
		'id'       => 'single_product_gallery_column_desktop',
		'name'     => esc_html__( 'Columns on desktop', 'woodmart' ),
		'group'    => esc_html__( 'Image gallery', 'woodmart' ),
		'type'     => 'buttons',
		'section'  => 'product_images',
		'options'  => array(
			1 => array(
				'name'  => 1,
				'value' => 1,
			),
			2 => array(
				'name'  => 2,
				'value' => 2,
			),
			3 => array(
				'name'  => 3,
				'value' => 3,
			),
			4 => array(
				'name'  => 4,
				'value' => 4,
			),
			5 => array(
				'name'  => 5,
				'value' => 5,
			),
			6 => array(
				'name'  => 6,
				'value' => 6,
			),
		),
		'default'  => 1,
		'priority' => 80,
		'requires' => array(
			array(
				'key'     => 'thums_position',
				'compare' => 'equals',
				'value'   => array( 'without' ),
			),
		),
		't_tab'    => array(
			'id'       => 'single_product_gallery_column_tabs',
			'tab'      => esc_html__( 'Desktop', 'woodmart' ),
			'title'    => esc_html__( 'Thumbnails columns', 'woodmart' ),
			'icon'     => 'xts-i-desktop',
			'style'    => 'devices',
			'requires' => array(
				array(
					'key'     => 'thums_position',
					'compare' => 'equals',
					'value'   => array( 'without' ),
				),
			),
		),
	)
);

Options::add_field(
	array(
		'id'         => 'single_product_gallery_column_tablet',
		'name'       => esc_html__( 'Columns on tablet', 'woodmart' ),
		'group'      => esc_html__( 'Image gallery', 'woodmart' ),
		'type'       => 'buttons',
		'section'    => 'product_images',
		'selectors'  => array(
			'[class*="thumbs-grid-bottom"] .woocommerce-product-gallery__wrapper.wd-grid' => array(
				'--wd-col: {{VALUE}};',
			),
		),
		'css_device' => 'tablet',
		'options'    => array(
			1 => array(
				'name'  => 1,
				'value' => 1,
			),
			2 => array(
				'name'  => 2,
				'value' => 2,
			),
			3 => array(
				'name'  => 3,
				'value' => 3,
			),
			4 => array(
				'name'  => 4,
				'value' => 4,
			),
			5 => array(
				'name'  => 5,
				'value' => 5,
			),
			6 => array(
				'name'  => 6,
				'value' => 6,
			),
		),
		'default'    => '',
		'priority'   => 81,
		'requires'   => array(
			array(
				'key'     => 'thums_position',
				'compare' => 'equals',
				'value'   => array( 'without' ),
			),
		),
		't_tab'      => array(
			'id'    => 'single_product_gallery_column_tabs',
			'icon'  => 'xts-i-tablet',
			'style' => 'devices',
			'tab'   => esc_html__( 'Tablet', 'woodmart' ),
		),
	)
);

Options::add_field(
	array(
		'id'         => 'single_product_gallery_column_mobile',
		'name'       => esc_html__( 'Columns on mobile', 'woodmart' ),
		'group'      => esc_html__( 'Image gallery', 'woodmart' ),
		'type'       => 'buttons',
		'section'    => 'product_images',
		'selectors'  => array(
			'[class*="thumbs-grid-bottom"] .woocommerce-product-gallery__wrapper.wd-grid' => array(
				'--wd-col: {{VALUE}};',
			),
		),
		'css_device' => 'mobile',
		'options'    => array(
			1 => array(
				'name'  => 1,
				'value' => 1,
			),
			2 => array(
				'name'  => 2,
				'value' => 2,
			),
			3 => array(
				'name'  => 3,
				'value' => 3,
			),
			4 => array(
				'name'  => 4,
				'value' => 4,
			),
			5 => array(
				'name'  => 5,
				'value' => 5,
			),
			6 => array(
				'name'  => 6,
				'value' => 6,
			),
		),
		'default'    => '',
		'priority'   => 82,
		'requires'   => array(
			array(
				'key'     => 'thums_position',
				'compare' => 'equals',
				'value'   => array( 'without' ),
			),
		),
		't_tab'      => array(
			'id'    => 'single_product_gallery_column_tabs',
			'icon'  => 'xts-i-phone',
			'style' => 'devices',
			'tab'   => esc_html__( 'Mobile', 'woodmart' ),
		),
	)
);

Options::add_field(
	array(
		'id'       => 'single_product_thumbnails_vertical_items',
		'name'     => esc_html__( 'Thumbnails per slide on desktop', 'woodmart' ),
		'hint'     => '<video data-src="' . WOODMART_TOOLTIP_URL . 'single-product-thumbnails-vertical-items.mp4" autoplay loop muted></video>',
		'group'    => esc_html__( 'Image gallery', 'woodmart' ),
		'type'     => 'buttons',
		'section'  => 'product_images',
		'options'  => array(
			'auto' => array(
				'name'  => esc_html__( 'Auto', 'woodmart' ),
				'value' => 'auto',
			),
			2      => array(
				'name'  => 2,
				'value' => 2,
			),
			3      => array(
				'name'  => 3,
				'value' => 3,
			),
			4      => array(
				'name'  => 4,
				'value' => 4,
			),
			5      => array(
				'name'  => 5,
				'value' => 5,
			),
			6      => array(
				'name'  => 6,
				'value' => 6,
			),
		),
		'default'  => 3,
		'priority' => 90,
		'requires' => array(
			array(
				'key'     => 'thums_position',
				'compare' => 'equals',
				'value'   => array( 'left' ),
			),
		),
		't_tab'    => array(
			'id'       => 'single_product_thumbnails_items_tabs',
			'tab'      => esc_html__( 'Desktop', 'woodmart' ),
			'title'    => esc_html__( 'Thumbnails columns', 'woodmart' ),
			'icon'     => 'xts-i-desktop',
			'style'    => 'devices',
			'requires' => array(
				array(
					'key'     => 'thums_position',
					'compare' => 'equals',
					'value'   => array( 'bottom', 'left' ),
				),
			),
		),
	)
);

Options::add_field(
	array(
		'id'       => 'single_product_thumbnails_items_desktop',
		'name'     => esc_html__( 'Thumbnails per slide on desktop', 'woodmart' ),
		'hint'     => '<video data-src="' . WOODMART_TOOLTIP_URL . 'single-product-thumbnails-items-desktop.mp4" autoplay loop muted></video>',
		'group'    => esc_html__( 'Image gallery', 'woodmart' ),
		'type'     => 'buttons',
		'section'  => 'product_images',
		'options'  => array(
			'auto' => array(
				'name'  => esc_html__( 'Auto', 'woodmart' ),
				'value' => 'auto',
			),
			2      => array(
				'name'  => 2,
				'value' => 2,
			),
			3      => array(
				'name'  => 3,
				'value' => 3,
			),
			4      => array(
				'name'  => 4,
				'value' => 4,
			),
			5      => array(
				'name'  => 5,
				'value' => 5,
			),
			6      => array(
				'name'  => 6,
				'value' => 6,
			),
		),
		'default'  => 4,
		'priority' => 91,
		'requires' => array(
			array(
				'key'     => 'thums_position',
				'compare' => 'equals',
				'value'   => array( 'bottom' ),
			),
		),
		't_tab'    => array(
			'id'       => 'single_product_thumbnails_items_tabs',
			'tab'      => esc_html__( 'Desktop', 'woodmart' ),
			'title'    => esc_html__( 'Thumbnails columns', 'woodmart' ),
			'icon'     => 'xts-i-desktop',
			'style'    => 'devices',
			'requires' => array(
				array(
					'key'     => 'thums_position',
					'compare' => 'equals',
					'value'   => array( 'bottom', 'left' ),
				),
			),
		),
	)
);

Options::add_field(
	array(
		'id'       => 'single_product_thumbnails_items_tablet',
		'name'     => esc_html__( 'Thumbnails per slide on tablet', 'woodmart' ),
		'group'    => esc_html__( 'Image gallery', 'woodmart' ),
		'type'     => 'buttons',
		'section'  => 'product_images',
		'options'  => array(
			'auto' => array(
				'name'  => esc_html__( 'Auto', 'woodmart' ),
				'value' => 'auto',
			),
			2      => array(
				'name'  => 2,
				'value' => 2,
			),
			3      => array(
				'name'  => 3,
				'value' => 3,
			),
			4      => array(
				'name'  => 4,
				'value' => 4,
			),
			5      => array(
				'name'  => 5,
				'value' => 5,
			),
			6      => array(
				'name'  => 6,
				'value' => 6,
			),
		),
		'default'  => 4,
		'priority' => 92,
		'requires' => array(
			array(
				'key'     => 'thums_position',
				'compare' => 'equals',
				'value'   => array( 'bottom', 'left' ),
			),
		),
		't_tab'    => array(
			'id'    => 'single_product_thumbnails_items_tabs',
			'icon'  => 'xts-i-tablet',
			'style' => 'devices',
			'tab'   => esc_html__( 'Tablet', 'woodmart' ),
		),
	)
);

Options::add_field(
	array(
		'id'       => 'single_product_thumbnails_items_mobile',
		'name'     => esc_html__( 'Thumbnails per slide on mobile', 'woodmart' ),
		'group'    => esc_html__( 'Image gallery', 'woodmart' ),
		'type'     => 'buttons',
		'section'  => 'product_images',
		'options'  => array(
			'auto' => array(
				'name'  => esc_html__( 'Auto', 'woodmart' ),
				'value' => 'auto',
			),
			2      => array(
				'name'  => 2,
				'value' => 2,
			),
			3      => array(
				'name'  => 3,
				'value' => 3,
			),
			4      => array(
				'name'  => 4,
				'value' => 4,
			),
			5      => array(
				'name'  => 5,
				'value' => 5,
			),
			6      => array(
				'name'  => 6,
				'value' => 6,
			),
		),
		'default'  => 3,
		'priority' => 93,
		'requires' => array(
			array(
				'key'     => 'thums_position',
				'compare' => 'equals',
				'value'   => array( 'bottom', 'left' ),
			),
		),
		't_tab'    => array(
			'id'    => 'single_product_thumbnails_items_tabs',
			'icon'  => 'xts-i-phone',
			'style' => 'devices',
			'tab'   => esc_html__( 'Mobile', 'woodmart' ),
		),
	)
);

Options::add_field(
	array(
		'id'       => 'main_gallery_on_tablet',
		'name'     => esc_html__( 'Carousel on tablet', 'woodmart' ),
		'group'    => esc_html__( 'Image gallery', 'woodmart' ),
		'type'     => 'switcher',
		'section'  => 'product_images',
		'default'  => true,
		'requires' => array(
			array(
				'key'     => 'thums_position',
				'compare' => 'equals',
				'value'   => array( 'bottom_column', 'bottom_grid', 'bottom_combined', 'bottom_combined_2', 'bottom_combined_3' ),
			),
		),
		't_tab'    => array(
			'id'       => 'single_product_carousel_tabs',
			'tab'      => esc_html__( 'Tablet', 'woodmart' ),
			'title'    => esc_html__( 'Thumbnails columns', 'woodmart' ),
			'icon'     => 'xts-i-tablet',
			'style'    => 'devices',
			'requires' => array(
				array(
					'key'     => 'thums_position',
					'compare' => 'equals',
					'value'   => array( 'bottom_column', 'bottom_grid', 'bottom_combined', 'bottom_combined_2', 'bottom_combined_3' ),
				),
			),
		),
		'priority' => 100,
	)
);

Options::add_field(
	array(
		'id'       => 'main_gallery_on_mobile',
		'name'     => esc_html__( 'Carousel on mobile', 'woodmart' ),
		'group'    => esc_html__( 'Image gallery', 'woodmart' ),
		'type'     => 'switcher',
		'section'  => 'product_images',
		'default'  => true,
		'requires' => array(
			array(
				'key'     => 'thums_position',
				'compare' => 'equals',
				'value'   => array( 'bottom_column', 'bottom_grid', 'bottom_combined', 'bottom_combined_2', 'bottom_combined_3' ),
			),
		),
		't_tab'    => array(
			'id'    => 'single_product_carousel_tabs',
			'icon'  => 'xts-i-phone',
			'style' => 'devices',
			'tab'   => esc_html__( 'Mobile', 'woodmart' ),
		),
		'priority' => 101,
	)
);

Options::add_field(
	array(
		'id'       => 'main_gallery_center_mode',
		'name'     => esc_html__( 'Center mode in main gallery', 'woodmart' ),
		'group'    => esc_html__( 'Image gallery', 'woodmart' ),
		'hint'     => '<video data-src="' . WOODMART_TOOLTIP_URL . 'single-product-gallery-center-mode.mp4" autoplay loop muted></video>',
		'type'     => 'switcher',
		'section'  => 'product_images',
		'default'  => false,
		'requires' => array(
			array(
				'key'     => 'thums_position',
				'compare' => 'equals',
				'value'   => array( 'without' ),
			),
		),
		'priority' => 105,
	)
);

Options::add_field(
	array(
		'id'       => 'single_product_thumbnails_wrap_in_mobile_devices',
		'name'     => esc_html__( 'Thumbnails position bottom on mobile devices', 'woodmart' ),
		'group'    => esc_html__( 'Image gallery', 'woodmart' ),
		'hint'     => '<video data-src="' . WOODMART_TOOLTIP_URL . 'single-product-thumbnails-bottom-in-mobile-devices.mp4" autoplay loop muted></video>',
		'type'     => 'switcher',
		'section'  => 'product_images',
		'default'  => true,
		'requires' => array(
			array(
				'key'     => 'thums_position',
				'compare' => 'equals',
				'value'   => array( 'left' ),
			),
		),
		'priority' => 110,
	)
);

Options::add_field(
	array(
		'id'            => 'single_product_thumbnails_gallery_width',
		'name'          => esc_html__( 'Thumbnails gallery width', 'woodmart' ),
		'group'         => esc_html__( 'Image gallery', 'woodmart' ),
		'hint'          => '<video data-src="' . WOODMART_TOOLTIP_URL . 'single-product-thumbnails-gallery-width.mp4" autoplay loop muted></video>',
		'type'          => 'responsive_range',
		'section'       => 'product_images',
		'selectors'     => array(
			'.woocommerce-product-gallery.thumbs-position-left' => array(
				'--wd-thumbs-width: {{VALUE}}{{UNIT}};',
			),
		),
		'generate_zero' => true,
		'devices'       => array(
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
		'range'         => array(
			'px' => array(
				'min'  => 0,
				'max'  => 1000,
				'step' => 1,
			),
			'%'  => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
		),
		'requires'      => array(
			array(
				'key'     => 'thums_position',
				'compare' => 'equals',
				'value'   => array( 'left' ),
			),
		),
		'class'         => 'xts-col-6',
		'priority'      => 140,
	)
);

Options::add_field(
	array(
		'id'            => 'single_product_thumbnails_gallery_height',
		'name'          => esc_html__( 'Thumbnails gallery height', 'woodmart' ),
		'group'         => esc_html__( 'Image gallery', 'woodmart' ),
		'hint'          => '<video data-src="' . WOODMART_TOOLTIP_URL . 'single-product-thumbnails-gallery-height.mp4" autoplay loop muted></video>',
		'type'          => 'responsive_range',
		'section'       => 'product_images',
		'selectors'     => array(
			'.woocommerce-product-gallery.thumbs-position-left' => array(
				'--wd-thumbs-height: {{VALUE}}{{UNIT}};',
			),
		),
		'generate_zero' => true,
		'devices'       => array(
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
		'range'         => array(
			'px' => array(
				'min'  => 0,
				'max'  => 1000,
				'step' => 1,
			),
		),
		'requires'      => array(
			array(
				'key'     => 'thums_position',
				'compare' => 'equals',
				'value'   => array( 'left' ),
			),
		),
		'class'         => 'xts-col-6',
		'priority'      => 150,
	)
);

Options::add_field(
	array(
		'id'          => 'single_product_thumbnails_gallery_image_width',
		'type'        => 'text_input',
		'attributes'  => array(
			'type' => 'number',
		),
		'section'     => 'product_images',
		'name'        => esc_html__( 'Thumbnails image width', 'woodmart' ),
		'description' => __( 'IMPORTANT: You need to regenerate all thumbnails to apply the changes. Use the following <a href="https://wordpress.org/plugins/regenerate-thumbnails/" target="_blank">plugin</a> for this.', 'woodmart' ),
		'group'       => esc_html__( 'Image gallery', 'woodmart' ),
		'default'     => 150,
		'priority'    => 160,
		'requires'    => array(
			array(
				'key'     => 'thums_position',
				'compare' => 'equals',
				'value'   => array( 'bottom', 'left' ),
			),
		),
	)
);

/**
 * Add to cart options.
 */
Options::add_field(
	array(
		'id'          => 'single_ajax_add_to_cart',
		'name'        => esc_html__( 'AJAX Add to cart', 'woodmart' ),
		'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'ajax-add-to-cart.mp4" autoplay loop muted></video>',
		'description' => esc_html__( 'Turn on the AJAX add to cart option on the single product page. Will not work with plugins that add some custom fields to the add to cart form.', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'single_product_add_to_cart_section',
		'default'     => '1',
		'priority'    => 110,
	)
);

Options::add_field(
	array(
		'id'          => 'single_sticky_add_to_cart',
		'name'        => esc_html__( 'Sticky add to cart', 'woodmart' ),
		'hint'        => '<video data-src="' . WOODMART_TOOLTIP_URL . 'sticky-add-to-cart.mp4" autoplay loop muted></video>',
		'description' => esc_html__( 'Add to cart section will be displayed at the bottom of your screen when you scroll down the page.', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'single_product_add_to_cart_section',
		'default'     => false,
		'priority'    => 160,
		'class'       => 'xts-tooltip-bordered',
	)
);

Options::add_field(
	array(
		'id'          => 'mobile_single_sticky_add_to_cart',
		'name'        => esc_html__( 'Sticky add to cart on mobile', 'woodmart' ),
		'description' => esc_html__( 'You can leave this option for desktop only or enable it for all devices sizes.', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'single_product_add_to_cart_section',
		'default'     => false,
		'priority'    => 170,
		'requires'    => array(
			array(
				'key'     => 'single_sticky_add_to_cart',
				'compare' => 'equals',
				'value'   => '1',
			),
		),
	)
);

Options::add_field(
	array(
		'id'        => 'sticky_add_to_cart_height_desktop',
		'type'      => 'range',
		'section'   => 'single_product_add_to_cart_section',
		'name'      => esc_html__( 'Height on desktop', 'woodmart' ),
		'default'   => 95,
		'min'       => 60,
		'max'       => 200,
		'step'      => 1,
		'selectors' => array(
			':root' => array(
				'--wd-sticky-btn-height: {{VALUE}}px;',
			),
		),
		'requires'  => array(
			array(
				'key'     => 'single_sticky_add_to_cart',
				'compare' => 'equals',
				'value'   => '1',
			),
		),
		't_tab'     => array(
			'id'       => 'sticky_add_to_cart_tabs',
			'tab'      => esc_html__( 'Desktop', 'woodmart' ),
			'icon'     => 'xts-i-desktop',
			'style'    => 'devices',
			'requires' => array(
				array(
					'key'     => 'single_sticky_add_to_cart',
					'compare' => 'equals',
					'value'   => '1',
				),
			),
		),
		'priority'  => 180,
		'unit'      => 'px',
	)
);

Options::add_field(
	array(
		'id'         => 'sticky_add_to_cart_height_tablet',
		'type'       => 'range',
		'section'    => 'single_product_add_to_cart_section',
		'name'       => esc_html__( 'Height on tablet', 'woodmart' ),
		'default'    => 95,
		'min'        => 60,
		'max'        => 200,
		'step'       => 1,
		'css_device' => 'tablet',
		'selectors'  => array(
			':root' => array(
				'--wd-sticky-btn-height: {{VALUE}}px;',
			),
		),
		'requires'   => array(
			array(
				'key'     => 'single_sticky_add_to_cart',
				'compare' => 'equals',
				'value'   => '1',
			),
		),
		't_tab'      => array(
			'id'   => 'sticky_add_to_cart_tabs',
			'tab'  => esc_html__( 'Tablet', 'woodmart' ),
			'icon' => 'xts-i-tablet',
		),
		'priority'   => 190,
		'unit'       => 'px',
	)
);

Options::add_field(
	array(
		'id'         => 'sticky_add_to_cart_height_mobile',
		'type'       => 'range',
		'section'    => 'single_product_add_to_cart_section',
		'name'       => esc_html__( 'Height on mobile', 'woodmart' ),
		'default'    => 42,
		'min'        => 40,
		'max'        => 120,
		'step'       => 1,
		'css_device' => 'mobile',
		'selectors'  => array(
			':root' => array(
				'--wd-sticky-btn-height: {{VALUE}}px;',
			),
		),
		'requires'   => array(
			array(
				'key'     => 'single_sticky_add_to_cart',
				'compare' => 'equals',
				'value'   => '1',
			),
		),
		't_tab'      => array(
			'id'   => 'sticky_add_to_cart_tabs',
			'tab'  => esc_html__( 'Mobile', 'woodmart' ),
			'icon' => 'xts-i-phone',
		),
		'priority'   => 200,
		'unit'       => 'px',
	)
);

Options::add_field(
	array(
		'id'       => 'before_add_to_cart_content_type',
		'name'     => esc_html__( 'Before "Add to cart button"', 'woodmart' ),
		'group'    => esc_html__( 'Content', 'woodmart' ),
		'type'     => 'buttons',
		'section'  => 'single_product_add_to_cart_section',
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
		'priority' => 220,
		'class'    => 'xts-html-block-switch',
	)
);

Options::add_field(
	array(
		'id'       => 'content_before_add_to_cart',
		'type'     => 'textarea',
		'wysiwyg'  => true,
		'name'     => esc_html__( 'Text', 'woodmart' ),
		'group'    => esc_html__( 'Content', 'woodmart' ),
		'section'  => 'single_product_add_to_cart_section',
		'requires' => array(
			array(
				'key'     => 'before_add_to_cart_content_type',
				'compare' => 'equals',
				'value'   => 'text',
			),
		),
		'priority' => 230,
	)
);

Options::add_field(
	array(
		'id'           => 'before_add_to_cart_html_block',
		'type'         => 'select',
		'section'      => 'single_product_add_to_cart_section',
		'name'         => esc_html__( 'HTML Block', 'woodmart' ),
		'group'        => esc_html__( 'Content', 'woodmart' ),
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
				'key'     => 'before_add_to_cart_content_type',
				'compare' => 'equals',
				'value'   => 'html_block',
			),
		),
		'priority'     => 240,
	)
);

Options::add_field(
	array(
		'id'       => 'after_add_to_cart_content_type',
		'name'     => esc_html__( 'After "Add to cart button"', 'woodmart' ),
		'group'    => esc_html__( 'Content', 'woodmart' ),
		'type'     => 'buttons',
		'section'  => 'single_product_add_to_cart_section',
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
		'priority' => 250,
		'class'    => 'xts-html-block-switch',
	)
);

Options::add_field(
	array(
		'id'       => 'content_after_add_to_cart',
		'type'     => 'textarea',
		'name'     => esc_html__( 'Text', 'woodmart' ),
		'group'    => esc_html__( 'Content', 'woodmart' ),
		'wysiwyg'  => true,
		'section'  => 'single_product_add_to_cart_section',
		'requires' => array(
			array(
				'key'     => 'after_add_to_cart_content_type',
				'compare' => 'equals',
				'value'   => 'text',
			),
		),
		'priority' => 260,
	)
);

Options::add_field(
	array(
		'id'           => 'after_add_to_cart_html_block',
		'type'         => 'select',
		'name'         => esc_html__( 'HTML Block', 'woodmart' ),
		'group'        => esc_html__( 'Content', 'woodmart' ),
		'section'      => 'single_product_add_to_cart_section',
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
				'key'     => 'after_add_to_cart_content_type',
				'compare' => 'equals',
				'value'   => 'html_block',
			),
		),
		'priority'     => 270,
	)
);

/**
 * Elements.
 */
Options::add_field(
	array(
		'id'          => 'single_breadcrumbs_position',
		'name'        => esc_html__( 'Position', 'woodmart' ),
		'description' => esc_html__( 'Set different position for breadcrumbs section on your product\'s page.', 'woodmart' ),
		'group'       => esc_html__( 'Breadcrumbs & Products navigation', 'woodmart' ),
		'type'        => 'buttons',
		'section'     => 'product_elements',
		'options'     => array(
			'default'      => array(
				'name'  => esc_html__( 'Default', 'woodmart' ),
				'hint'  => wp_kses( '<img data-src="' . WOODMART_TOOLTIP_URL . 'breadcrumbs-product-page-position-default.jpg" alt="">', true ),
				'value' => 'default',
			),
			'below_header' => array(
				'name'  => esc_html__( 'Below header', 'woodmart' ),
				'hint'  => wp_kses( '<img data-src="' . WOODMART_TOOLTIP_URL . 'breadcrumbs-product-page-position-below-header.jpg" alt="">', true ),
				'value' => 'below_header',
			),
			'summary'      => array(
				'name'  => esc_html__( 'Product summary', 'woodmart' ),
				'hint'  => wp_kses( '<img data-src="' . WOODMART_TOOLTIP_URL . 'breadcrumbs-product-page-position-default.jpg" alt="">', true ),
				'value' => 'summary',
			),
		),
		'default'     => 'default',
		'priority'    => 10,
	)
);

Options::add_field(
	array(
		'id'       => 'product_page_breadcrumbs',
		'name'     => esc_html__( 'Breadcrumbs on product page', 'woodmart' ),
		'group'    => esc_html__( 'Breadcrumbs & Products navigation', 'woodmart' ),
		'hint'     => wp_kses( '<img data-src="' . WOODMART_TOOLTIP_URL . 'single-product-breadcrumbs.jpg" alt="">', true ),
		'type'     => 'switcher',
		'section'  => 'product_elements',
		'default'  => '1',
		'priority' => 20,
	)
);

Options::add_field(
	array(
		'id'       => 'products_nav',
		'name'     => esc_html__( 'Products navigation', 'woodmart' ),
		'group'    => esc_html__( 'Breadcrumbs & Products navigation', 'woodmart' ),
		'hint'     => wp_kses( '<img data-src="' . WOODMART_TOOLTIP_URL . 'single-product-products-navigation.jpg" alt="">', true ),
		'type'     => 'switcher',
		'section'  => 'product_elements',
		'default'  => '1',
		'priority' => 30,
	)
);

Options::add_field(
	array(
		'id'          => 'product_short_description',
		'name'        => esc_html__( 'Enable short description', 'woodmart' ),
		'hint'        => wp_kses( '<img data-src="' . WOODMART_TOOLTIP_URL . 'enable-short-description.jpg" alt="">', true ),
		'description' => esc_html__( 'Enable/disable short description text in the product\'s summary block.', 'woodmart' ),
		'group'       => esc_html__( 'Short description', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'product_elements',
		'default'     => '1',
		'on-text'     => esc_html__( 'Yes', 'woodmart' ),
		'off-text'    => esc_html__( 'No', 'woodmart' ),
		'priority'    => 40,
	)
);

Options::add_field(
	array(
		'id'          => 'attr_after_short_desc',
		'name'        => esc_html__( 'Show attributes table after short description', 'woodmart' ),
		'hint'        => wp_kses( '<img data-src="' . WOODMART_TOOLTIP_URL . 'show-attributes-table-after-short-description.jpg" alt="">', true ),
		'description' => esc_html__( 'You can display attributes table after of short description.', 'woodmart' ),
		'group'       => esc_html__( 'Short description', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'product_elements',
		'default'     => false,
		'on-text'     => esc_html__( 'Yes', 'woodmart' ),
		'off-text'    => esc_html__( 'No', 'woodmart' ),
		'priority'    => 50,
	)
);

Options::add_field(
	array(
		'id'       => 'stock_status_design',
		'name'     => esc_html__( 'Stock status design', 'woodmart' ),
		'group'    => esc_html__( 'Stock status', 'woodmart' ),
		'type'     => 'buttons',
		'section'  => 'product_elements',
		'default'  => 'default',
		'options'  => array(
			'default'  => array(
				'name'  => esc_html__( 'Default', 'woodmart' ),
				'value' => 'default',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/stock-status/default.jpg',
			),
			'with-bg'  => array(
				'name'  => esc_html__( 'With background', 'woodmart' ),
				'value' => 'with-bg',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/stock-status/background.jpg',
			),
			'bordered' => array(
				'name'  => esc_html__( 'Bordered', 'woodmart' ),
				'value' => 'bordered',
				'image' => WOODMART_ASSETS_IMAGES . '/settings/stock-status/bordered.jpg',
			),
		),
		'priority' => 60,
		'class'    => 'xts-col-6',
	)
);

Options::add_field(
	array(
		'id'          => 'single_stock_progress_bar',
		'name'        => esc_html__( 'Stock progress bar', 'woodmart' ),
		'hint'        => wp_kses( '<img data-src="' . WOODMART_TOOLTIP_URL . 'stock-progress-bar.jpg" alt="">', true ),
		'description' => esc_html__( 'Display a number of sold and in stock products as a progress bar.', 'woodmart' ),
		'group'       => esc_html__( 'Stock status', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'product_elements',
		'default'     => false,
		'priority'    => 70,
	)
);

Options::add_field(
	array(
		'id'          => 'product_countdown',
		'name'        => esc_html__( 'Countdown timer', 'woodmart' ),
		'hint'        => wp_kses( '<img data-src="' . WOODMART_TOOLTIP_URL . 'countdown-timer.jpg" alt="">', true ),
		'description' => esc_html__( 'Show timer for products that have scheduled date for the sale price', 'woodmart' ),
		'group'       => esc_html__( 'Countdown timer', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'product_elements',
		'default'     => false,
		'priority'    => 80,
	)
);

Options::add_field(
	array(
		'id'          => 'sale_countdown_variable',
		'name'        => esc_html__( 'Countdown for variable products', 'woodmart' ),
		'description' => esc_html__( 'Sale end date will be based on the first variation date of the product.', 'woodmart' ),
		'group'       => esc_html__( 'Countdown timer', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'product_elements',
		'requires'    => array(
			array(
				'key'     => 'product_countdown',
				'compare' => 'equals',
				'value'   => true,
			),
		),
		'default'     => false,
		'priority'    => 90,
	)
);

Options::add_field(
	array(
		'id'          => 'product_show_meta',
		'name'        => esc_html__( 'Show product meta', 'woodmart' ),
		'description' => esc_html__( 'Categories, tags, SKU', 'woodmart' ),
		'group'       => esc_html__( 'Meta', 'woodmart' ),
		'type'        => 'buttons',
		'section'     => 'product_elements',
		'options'     => array(
			'add_to_cart' => array(
				'name'  => esc_html__( 'After "Add to cart" button', 'woodmart' ),
				'hint'  => wp_kses( '<img data-src="' . WOODMART_TOOLTIP_URL . 'show-product-meta-affter-add-to-cart.jpg" alt="">', true ),
				'value' => 'add_to_cart',
			),
			'after_tabs'  => array(
				'name'  => esc_html__( 'After tabs', 'woodmart' ),
				'hint'  => wp_kses( '<img data-src="' . WOODMART_TOOLTIP_URL . 'show-product-meta-affter-tabs.jpg" alt="">', true ),
				'value' => 'after_tabs',
			),
			'hide'        => array(
				'name'  => esc_html__( 'Hide', 'woodmart' ),
				'value' => 'hide',
			),
		),
		'default'     => 'add_to_cart',
		'on-text'     => esc_html__( 'Yes', 'woodmart' ),
		'off-text'    => esc_html__( 'No', 'woodmart' ),
		'priority'    => 100,
	)
);

Options::add_field(
	array(
		'id'       => 'show_product_brand',
		'name'     => esc_html__( 'Show product brands', 'woodmart' ),
		'hint'     => wp_kses( '<img data-src="' . WOODMART_TOOLTIP_URL . 'show-product-brand.jpg" alt="">', true ),
		'group'    => esc_html__( 'Meta', 'woodmart' ),
		'type'     => 'switcher',
		'section'  => 'product_elements',
		'default'  => '0',
		'on-text'  => esc_html__( 'Yes', 'woodmart' ),
		'off-text' => esc_html__( 'No', 'woodmart' ),
		'priority' => 105,
	)
);

Options::add_field(
	array(
		'id'          => 'product_share',
		'name'        => esc_html__( 'Show share buttons', 'woodmart' ),
		'hint'        => wp_kses( '<img data-src="' . WOODMART_TOOLTIP_URL . 'show-share-buttons.jpg" alt="">', true ),
		'description' => esc_html__( 'Display share buttons icons on the single product page.', 'woodmart' ),
		'group'       => esc_html__( 'Share buttons', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'product_elements',
		'default'     => '1',
		'on-text'     => esc_html__( 'Yes', 'woodmart' ),
		'off-text'    => esc_html__( 'No', 'woodmart' ),
		'priority'    => 110,
	)
);

Options::add_field(
	array(
		'id'          => 'product_share_type',
		'name'        => esc_html__( 'Share buttons type', 'woodmart' ),
		'description' => esc_html__( 'You can switch between share and follow buttons on the single product page.', 'woodmart' ),
		'group'       => esc_html__( 'Share buttons', 'woodmart' ),
		'type'        => 'buttons',
		'section'     => 'product_elements',
		'options'     => array(
			'share'  => array(
				'name'  => esc_html__( 'Share', 'woodmart' ),
				'value' => 'share',
			),
			'follow' => array(
				'name'  => esc_html__( 'Follow', 'woodmart' ),
				'value' => 'follow',
			),
		),
		'requires'    => array(
			array(
				'key'     => 'product_share',
				'compare' => 'equals',
				'value'   => '1',
			),
		),
		'default'     => 'share',
		'on-text'     => esc_html__( 'Yes', 'woodmart' ),
		'off-text'    => esc_html__( 'No', 'woodmart' ),
		'priority'    => 120,
	)
);

/**
 * Related section.
 */


Options::add_field(
	array(
		'id'          => 'related_products',
		'name'        => esc_html__( 'Show related products', 'woodmart' ),
		'hint'        => wp_kses( '<img data-src="' . WOODMART_TOOLTIP_URL . 'show-related-products.jpg" alt="">', true ),
		'description' => esc_html__( 'Related products is a section that pulls products from your store that share the same tags or categories as the current product.', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'single_product_related_section',
		'default'     => '1',
		'on-text'     => esc_html__( 'Yes', 'woodmart' ),
		'off-text'    => esc_html__( 'No', 'woodmart' ),
		'priority'    => 10,
	)
);

Options::add_field(
	array(
		'id'          => 'upsells_position',
		'name'        => esc_html__( 'Upsells products position', 'woodmart' ),
		'description' => esc_html__( 'If use "Sidebar" be sure that you have enabled it for the product page layout', 'woodmart' ),
		'type'        => 'buttons',
		'section'     => 'single_product_related_section',
		'options'     => array(
			'standard' => array(
				'name'  => esc_html__( 'Standard', 'woodmart' ),
				'hint'  => wp_kses( '<img data-src="' . WOODMART_TOOLTIP_URL . 'upsells-products-position-standart.jpg" alt="">', true ),
				'value' => 'standard',
			),
			'sidebar'  => array(
				'name'  => esc_html__( 'Sidebar', 'woodmart' ),
				'hint'  => wp_kses( '<img data-src="' . WOODMART_TOOLTIP_URL . 'upsells-products-position-sidebar.jpg" alt="">', true ),
				'value' => 'sidebar',
			),
			'hide'     => array(
				'name'  => esc_html__( 'Hide', 'woodmart' ),
				'value' => 'hide',
			),
		),
		'default'     => 'standard',
		'priority'    => 20,
	)
);

Options::add_field(
	array(
		'id'          => 'related_product_view',
		'name'        => esc_html__( 'Product view', 'woodmart' ),
		'description' => esc_html__( 'You can set different view mode for the related products. These settings will be applied for upsells products as well.', 'woodmart' ),
		'type'        => 'buttons',
		'section'     => 'single_product_related_section',
		'options'     => array(
			'grid'   => array(
				'name'  => esc_html__( 'Grid', 'woodmart' ),
				'value' => 'grid',
			),
			'slider' => array(
				'name'  => esc_html__( 'Carousel', 'woodmart' ),
				'value' => 'slider',
			),
		),
		'default'     => 'slider',
		'priority'    => 30,
	)
);

Options::add_field(
	array(
		'id'          => 'related_product_columns',
		'name'        => esc_html__( 'Product columns', 'woodmart' ),
		'description' => esc_html__( 'How many products you want to show per row.', 'woodmart' ),
		'group'       => esc_html__( 'Layout', 'woodmart' ),
		'type'        => 'buttons',
		'section'     => 'single_product_related_section',
		'options'     => array(
			2 => array(
				'name'  => 2,
				'value' => 2,
			),
			3 => array(
				'name'  => 3,
				'value' => 3,
			),
			4 => array(
				'name'  => 4,
				'value' => 4,
			),
			5 => array(
				'name'  => 5,
				'value' => 5,
			),
			6 => array(
				'name'  => 6,
				'value' => 6,
			),
		),
		't_tab'       => array(
			'id'    => 'related_product_columns_tabs',
			'tab'   => esc_html__( 'Desktop', 'woodmart' ),
			'icon'  => 'xts-i-desktop',
			'style' => 'devices',
		),
		'default'     => 4,
		'priority'    => 40,
	)
);

Options::add_field(
	array(
		'id'          => 'related_product_columns_tablet',
		'name'        => esc_html__( 'Product columns', 'woodmart' ),
		'description' => esc_html__( 'How many products you want to show per row.', 'woodmart' ),
		'group'       => esc_html__( 'Layout', 'woodmart' ),
		'type'        => 'buttons',
		'section'     => 'single_product_related_section',
		'options'     => array(
			'auto' => array(
				'name'  => esc_html__( 'Auto', 'woodmart' ),
				'value' => 'auto',
			),
			2      => array(
				'name'  => 2,
				'value' => 2,
			),
			3      => array(
				'name'  => 3,
				'value' => 3,
			),
			4      => array(
				'name'  => 4,
				'value' => 4,
			),
			5      => array(
				'name'  => 5,
				'value' => 5,
			),
			6      => array(
				'name'  => 6,
				'value' => 6,
			),
		),
		't_tab'       => array(
			'id'   => 'related_product_columns_tabs',
			'icon' => 'xts-i-tablet',
			'tab'  => esc_html__( 'Tablet', 'woodmart' ),
		),
		'default'     => 'auto',
		'priority'    => 41,
	)
);

Options::add_field(
	array(
		'id'          => 'related_product_columns_mobile',
		'name'        => esc_html__( 'Product columns', 'woodmart' ),
		'description' => esc_html__( 'How many products you want to show per row.', 'woodmart' ),
		'group'       => esc_html__( 'Layout', 'woodmart' ),
		'type'        => 'buttons',
		'section'     => 'single_product_related_section',
		'options'     => array(
			'auto' => array(
				'name'  => esc_html__( 'Auto', 'woodmart' ),
				'value' => 'auto',
			),
			2      => array(
				'name'  => 2,
				'value' => 2,
			),
			3      => array(
				'name'  => 3,
				'value' => 3,
			),
			4      => array(
				'name'  => 4,
				'value' => 4,
			),
			5      => array(
				'name'  => 5,
				'value' => 5,
			),
			6      => array(
				'name'  => 6,
				'value' => 6,
			),
		),
		't_tab'       => array(
			'id'   => 'related_product_columns_tabs',
			'icon' => 'xts-i-phone',
			'tab'  => esc_html__( 'Mobile', 'woodmart' ),
		),
		'default'     => 'auto',
		'priority'    => 42,
	)
);

Options::add_field(
	array(
		'id'          => 'related_product_count',
		'name'        => esc_html__( 'Product count', 'woodmart' ),
		'description' => esc_html__( 'The total number of products to display.', 'woodmart' ),
		'group'       => esc_html__( 'Layout', 'woodmart' ),
		'type'        => 'text_input',
		'attributes'  => array(
			'type' => 'number',
		),
		'section'     => 'single_product_related_section',
		'default'     => 8,
		'priority'    => 50,
	)
);

/**
 * Tabs.
 */
Options::add_field(
	array(
		'id'          => 'product_tabs_layout',
		'name'        => esc_html__( 'Tabs layout', 'woodmart' ),
		'description' => esc_html__( 'Select which style for products tabs do you need.', 'woodmart' ),
		'type'        => 'buttons',
		'section'     => 'product_tabs',
		'options'     => array(
			'tabs'      => array(
				'name'  => esc_html__( 'Tabs', 'woodmart' ),
				'hint'  => wp_kses( '<img data-src="' . WOODMART_TOOLTIP_URL . 'tabs-layout-tabs.jpg" alt="">', true ),
				'value' => 'tabs',
			),
			'accordion' => array(
				'name'  => esc_html__( 'Accordion', 'woodmart' ),
				'hint'  => wp_kses( '<img data-src="' . WOODMART_TOOLTIP_URL . 'tabs-layout-accordion.jpg" alt="">', true ),
				'value' => 'accordion',
			),
		),
		'default'     => 'tabs',
		'priority'    => 10,
	)
);

Options::add_field(
	array(
		'id'       => 'product_tabs_location',
		'name'     => esc_html__( 'Tabs location', 'woodmart' ),
		'type'     => 'buttons',
		'section'  => 'product_tabs',
		'options'  => array(
			'standard' => array(
				'name'  => esc_html__( 'Standard', 'woodmart' ),
				'hint'  => wp_kses( '<img data-src="' . WOODMART_TOOLTIP_URL . 'tabs-layout-accordion.jpg" alt="">', true ),
				'value' => 'standard',
			),
			'summary'  => array(
				'name'  => esc_html__( 'After "Add to cart" button', 'woodmart' ),
				'hint'  => wp_kses( '<img data-src="' . WOODMART_TOOLTIP_URL . 'tabs-location-after-dd-to-cart-button.jpg" alt="">', true ),
				'value' => 'summary',
			),
		),
		'default'  => 'standard',
		'priority' => 20,
		'requires' => array(
			array(
				'key'     => 'product_tabs_layout',
				'compare' => 'equals',
				'value'   => 'accordion',
			),
		),
	)
);

Options::add_field(
	array(
		'id'       => 'product_accordion_state',
		'name'     => esc_html__( 'Accordion state', 'woodmart' ),
		'type'     => 'buttons',
		'section'  => 'product_tabs',
		'options'  => array(
			'first'      => array(
				'name'  => esc_html__( 'First opened', 'woodmart' ),
				'hint'  => wp_kses( '<img data-src="' . WOODMART_TOOLTIP_URL . 'tabs-layout-accordion.jpg" alt="">', true ),
				'value' => 'first',
			),
			'all_closed' => array(
				'name'  => esc_html__( 'All closed', 'woodmart' ),
				'hint'  => wp_kses( '<img data-src="' . WOODMART_TOOLTIP_URL . 'tabs-layout-accordion-all-closed.jpg" alt="">', true ),
				'value' => 'all_closed',
			),
		),
		'default'  => 'first',
		'priority' => 30,
		'requires' => array(
			array(
				'key'     => 'product_tabs_layout',
				'compare' => 'equals',
				'value'   => 'accordion',
			),
		),
	)
);

Options::add_field(
	array(
		'id'          => 'hide_tabs_titles',
		'name'        => esc_html__( 'Hide tabs headings', 'woodmart' ),
		'hint'        => wp_kses( '<img data-src="' . WOODMART_TOOLTIP_URL . 'hide-tabs-headings.jpg" alt="">', true ),
		'description' => esc_html__( 'Don\'t show duplicated titles for product tabs.', 'woodmart' ),
		'type'        => 'switcher',
		'section'     => 'product_tabs',
		'default'     => '1',
		'on-text'     => esc_html__( 'Yes', 'woodmart' ),
		'off-text'    => esc_html__( 'No', 'woodmart' ),
		'priority'    => 40,
	)
);

Options::add_field(
	array(
		'id'       => 'enable_description_tab',
		'name'     => esc_html__( 'Enable description tab', 'woodmart' ),
		'group'    => esc_html__( 'Default tabs', 'woodmart' ),
		'type'     => 'switcher',
		'section'  => 'product_tabs',
		'default'  => '1',
		'on-text'  => esc_html__( 'Yes', 'woodmart' ),
		'off-text' => esc_html__( 'No', 'woodmart' ),
		'priority' => 50,
		'class'    => 'xts-col-6',
	)
);

Options::add_field(
	array(
		'id'         => 'description_tab_priority',
		'name'       => esc_html__( 'Description tab priority', 'woodmart' ),
		'group'      => esc_html__( 'Default tabs', 'woodmart' ),
		'type'       => 'text_input',
		'attributes' => array(
			'type'        => 'number',
			'min'         => '1',
			'placeholder' => '10',
		),
		'section'    => 'product_tabs',
		'priority'   => 60,
		'class'      => 'xts-col-6',
	)
);

Options::add_field(
	array(
		'id'       => 'enable_additional_info_tab',
		'name'     => esc_html__( 'Enable additional info tab', 'woodmart' ),
		'group'    => esc_html__( 'Default tabs', 'woodmart' ),
		'type'     => 'switcher',
		'section'  => 'product_tabs',
		'default'  => '1',
		'on-text'  => esc_html__( 'Yes', 'woodmart' ),
		'off-text' => esc_html__( 'No', 'woodmart' ),
		'priority' => 70,
		'class'    => 'xts-col-6',
	)
);

Options::add_field(
	array(
		'id'         => 'additional_info_tab_priority',
		'name'       => esc_html__( 'Additional info tab priority', 'woodmart' ),
		'group'      => esc_html__( 'Default tabs', 'woodmart' ),
		'type'       => 'text_input',
		'attributes' => array(
			'type'        => 'number',
			'min'         => '1',
			'placeholder' => '20',
		),
		'section'    => 'product_tabs',
		'priority'   => 80,
		'class'      => 'xts-col-6',
	)
);

Options::add_field(
	array(
		'id'       => 'enable_reviews_tab',
		'name'     => esc_html__( 'Enable reviews tab', 'woodmart' ),
		'group'    => esc_html__( 'Default tabs', 'woodmart' ),
		'type'     => 'switcher',
		'section'  => 'product_tabs',
		'default'  => '1',
		'on-text'  => esc_html__( 'Yes', 'woodmart' ),
		'off-text' => esc_html__( 'No', 'woodmart' ),
		'priority' => 90,
		'class'    => 'xts-col-6',
	)
);

Options::add_field(
	array(
		'id'         => 'reviews_tab_priority',
		'name'       => esc_html__( 'Reviews tab priority', 'woodmart' ),
		'group'      => esc_html__( 'Default tabs', 'woodmart' ),
		'type'       => 'text_input',
		'attributes' => array(
			'type'        => 'number',
			'min'         => '1',
			'placeholder' => '30',
		),
		'section'    => 'product_tabs',
		'priority'   => 100,
		'class'      => 'xts-col-6',
	)
);

Options::add_field(
	array(
		'id'       => 'legacy_product_tabs_enabled',
		'name'     => esc_html__( 'Legacy tabs', 'woodmart' ),
		'description' => esc_html__( 'Enables three optional product tabs on single product pages, which can be filled with plain text or HTML-blocks. Leave the field empty to disable the tab.', 'woodmart' ),
		'type'     => 'switcher',
		'section'  => 'product_tabs',
		'default'  => '1',
		'on-text'  => esc_html__( 'On', 'woodmart' ),
		'off-text' => esc_html__( 'Off', 'woodmart' ),
		'status'   => 'deprecated',
		'status_description' => esc_html__( 'This option is deprecated. You can now use "Custom tabs" to add an unlimited number of tabs with different display conditions.', 'woodmart' ),
		'priority' => 107,
	)
);

Options::add_field(
	array(
		'id'          => 'additional_tab_title',
		'name'        => esc_html__( 'Tab title', 'woodmart' ),
		'description' => esc_html__( 'Leave empty to disable custom tab', 'woodmart' ),
		'type'        => 'text_input',
		'default'     => 'Shipping & Delivery',
		'section'     => 'product_tabs',
		't_tab'       => array(
			'id'       => 'additional_tabs_control_tabs',
			'tab'      => esc_html__( 'Tab [1]', 'woodmart' ),
			'title'    => esc_html__( 'Legacy tabs (deprecated)', 'woodmart' ),
			'style'    => 'default',
			'requires' => array(
				array(
					'key'     => 'legacy_product_tabs_enabled',
					'compare' => 'equals',
					'value'   => '1',
				),
			),
		),
		'requires'    => array(
			array(
				'key'     => 'legacy_product_tabs_enabled',
				'compare' => 'equals',
				'value'   => '1',
			),
		),
		'priority'    => 110,
		'class'       => 'xts-tab-field xts-col-6',
	)
);

Options::add_field(
	array(
		'id'         => 'additional_tab_priority',
		'name'       => esc_html__( 'Priority', 'woodmart' ),
		'type'       => 'text_input',
		'attributes' => array(
			'type'        => 'number',
			'min'         => '1',
			'placeholder' => '50',
		),
		'section'    => 'product_tabs',
		't_tab'      => array(
			'id'    => 'additional_tabs_control_tabs',
			'tab'   => esc_html__( 'Tab [1]', 'woodmart' ),
			'title' => esc_html__( 'Legacy tabs (deprecated)', 'woodmart' ),
			'style' => 'default',
		),
		'requires'   => array(
			array(
				'key'     => 'legacy_product_tabs_enabled',
				'compare' => 'equals',
				'value'   => '1',
			),
		),
		'priority'   => 120,
		'class'      => 'xts-tab-field xts-col-6',
	)
);

Options::add_field(
	array(
		'id'       => 'additional_tab_content_type',
		'name'     => esc_html__( 'Content type', 'woodmart' ),
		'type'     => 'buttons',
		'section'  => 'product_tabs',
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
		't_tab'    => array(
			'id'  => 'additional_tabs_control_tabs',
			'tab' => esc_html__( 'Tab [1]', 'woodmart' ),
		),
		'requires' => array(
			array(
				'key'     => 'legacy_product_tabs_enabled',
				'compare' => 'equals',
				'value'   => '1',
			),
		),
		'default'  => 'text',
		'priority' => 130,
		'class'    => 'xts-html-block-switch',
	)
);

Options::add_field(
	array(
		'id'       => 'additional_tab_text',
		'type'     => 'textarea',
		'wysiwyg'  => false,
		'name'     => esc_html__( 'Text', 'woodmart' ),
		'default'  => '',
		'section'  => 'product_tabs',
		'requires' => array(
			array(
				'key'     => 'additional_tab_content_type',
				'compare' => 'equals',
				'value'   => 'text',
			),
			array(
				'key'     => 'legacy_product_tabs_enabled',
				'compare' => 'equals',
				'value'   => '1',
			),
		),
		't_tab'    => array(
			'id'  => 'additional_tabs_control_tabs',
			'tab' => esc_html__( 'Tab [1]', 'woodmart' ),
		),
		'priority' => 140,
		'class'    => 'xts-tab-field xts-last-tab-field',
	)
);

Options::add_field(
	array(
		'id'           => 'additional_tab_html_block',
		'type'         => 'select',
		'section'      => 'product_tabs',
		'name'         => esc_html__( 'HTML Block', 'woodmart' ),
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
				'key'     => 'additional_tab_content_type',
				'compare' => 'equals',
				'value'   => 'html_block',
			),
			array(
				'key'     => 'legacy_product_tabs_enabled',
				'compare' => 'equals',
				'value'   => '1',
			),
		),
		't_tab'        => array(
			'id'  => 'additional_tabs_control_tabs',
			'tab' => esc_html__( 'Tab [1]', 'woodmart' ),
		),
		'priority'     => 150,
		'class'        => 'xts-tab-field xts-last-tab-field',
	)
);

Options::add_field(
	array(
		'id'          => 'additional_tab_2_title',
		'name'        => esc_html__( 'Tab title', 'woodmart' ),
		'description' => esc_html__( 'Leave empty to disable custom tab', 'woodmart' ),
		'type'        => 'text_input',
		'section'     => 'product_tabs',
		't_tab'       => array(
			'id'  => 'additional_tabs_control_tabs',
			'tab' => esc_html__( 'Tab [2]', 'woodmart' ),
		),
		'requires'    => array(
			array(
				'key'     => 'legacy_product_tabs_enabled',
				'compare' => 'equals',
				'value'   => '1',
			),
		),
		'priority'    => 160,
		'class'       => 'xts-tab-field xts-col-6',
	)
);

Options::add_field(
	array(
		'id'         => 'additional_tab_2_priority',
		'name'       => esc_html__( 'Priority', 'woodmart' ),
		'type'       => 'text_input',
		'attributes' => array(
			'type'        => 'number',
			'min'         => '1',
			'placeholder' => '60',
		),
		'section'    => 'product_tabs',
		't_tab'      => array(
			'id'  => 'additional_tabs_control_tabs',
			'tab' => esc_html__( 'Tab [2]', 'woodmart' ),
		),
		'requires'   => array(
			array(
				'key'     => 'legacy_product_tabs_enabled',
				'compare' => 'equals',
				'value'   => '1',
			),
		),
		'priority'   => 170,
		'class'      => 'xts-tab-field xts-col-6',
	)
);

Options::add_field(
	array(
		'id'       => 'additional_tab_2_content_type',
		'name'     => esc_html__( 'Content type', 'woodmart' ),
		'type'     => 'buttons',
		'section'  => 'product_tabs',
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
		't_tab'    => array(
			'id'  => 'additional_tabs_control_tabs',
			'tab' => esc_html__( 'Tab [2]', 'woodmart' ),
		),
		'requires' => array(
			array(
				'key'     => 'legacy_product_tabs_enabled',
				'compare' => 'equals',
				'value'   => '1',
			),
		),
		'default'  => 'text',
		'priority' => 180,
		'class'    => 'xts-html-block-switch',
	)
);

Options::add_field(
	array(
		'id'       => 'additional_tab_2_text',
		'type'     => 'textarea',
		'name'     => esc_html__( 'Text', 'woodmart' ),
		'wysiwyg'  => false,
		'default'  => '',
		'section'  => 'product_tabs',
		'requires' => array(
			array(
				'key'     => 'additional_tab_2_content_type',
				'compare' => 'equals',
				'value'   => 'text',
			),
			array(
				'key'     => 'legacy_product_tabs_enabled',
				'compare' => 'equals',
				'value'   => '1',
			),
		),
		't_tab'    => array(
			'id'  => 'additional_tabs_control_tabs',
			'tab' => esc_html__( 'Tab [2]', 'woodmart' ),
		),
		'priority' => 190,
		'class'    => 'xts-tab-field xts-last-tab-field',
	)
);

Options::add_field(
	array(
		'id'           => 'additional_tab_2_html_block',
		'type'         => 'select',
		'section'      => 'product_tabs',
		'name'         => esc_html__( 'HTML Block', 'woodmart' ),
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
				'key'     => 'additional_tab_2_content_type',
				'compare' => 'equals',
				'value'   => 'html_block',
			),
			array(
				'key'     => 'legacy_product_tabs_enabled',
				'compare' => 'equals',
				'value'   => '1',
			),
		),
		't_tab'        => array(
			'id'  => 'additional_tabs_control_tabs',
			'tab' => esc_html__( 'Tab [2]', 'woodmart' ),
		),
		'priority'     => 200,
		'class'        => 'xts-tab-field xts-last-tab-field',
	)
);

Options::add_field(
	array(
		'id'          => 'additional_tab_3_title',
		'name'        => esc_html__( 'Tab title', 'woodmart' ),
		'description' => esc_html__( 'Leave empty to disable custom tab', 'woodmart' ),
		'type'        => 'text_input',
		'section'     => 'product_tabs',
		't_tab'       => array(
			'id'  => 'additional_tabs_control_tabs',
			'tab' => esc_html__( 'Tab [3]', 'woodmart' ),
		),
		'requires'    => array(
			array(
				'key'     => 'legacy_product_tabs_enabled',
				'compare' => 'equals',
				'value'   => '1',
			),
		),
		'priority'    => 210,
		'class'       => 'xts-tab-field xts-col-6',
	)
);

Options::add_field(
	array(
		'id'         => 'additional_tab_3_priority',
		'name'       => esc_html__( 'Priority', 'woodmart' ),
		'type'       => 'text_input',
		'attributes' => array(
			'type'        => 'number',
			'min'         => '1',
			'placeholder' => '70',
		),
		'section'    => 'product_tabs',
		't_tab'      => array(
			'id'  => 'additional_tabs_control_tabs',
			'tab' => esc_html__( 'Tab [3]', 'woodmart' ),
		),
		'requires'   => array(
			array(
				'key'     => 'legacy_product_tabs_enabled',
				'compare' => 'equals',
				'value'   => '1',
			),
		),
		'priority'   => 220,
		'class'      => 'xts-tab-field xts-col-6',
	)
);

Options::add_field(
	array(
		'id'       => 'additional_tab_3_content_type',
		'name'     => esc_html__( 'Content type', 'woodmart' ),
		'type'     => 'buttons',
		'section'  => 'product_tabs',
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
		't_tab'    => array(
			'id'  => 'additional_tabs_control_tabs',
			'tab' => esc_html__( 'Tab [3]', 'woodmart' ),
		),
		'requires' => array(
			array(
				'key'     => 'legacy_product_tabs_enabled',
				'compare' => 'equals',
				'value'   => '1',
			),
		),
		'default'  => 'text',
		'priority' => 230,
		'class'    => 'xts-html-block-switch',
	)
);

Options::add_field(
	array(
		'id'       => 'additional_tab_3_text',
		'type'     => 'textarea',
		'wysiwyg'  => false,
		'default'  => '',
		'name'     => esc_html__( 'Text', 'woodmart' ),
		'section'  => 'product_tabs',
		'requires' => array(
			array(
				'key'     => 'additional_tab_3_content_type',
				'compare' => 'equals',
				'value'   => 'text',
			),
			array(
				'key'     => 'legacy_product_tabs_enabled',
				'compare' => 'equals',
				'value'   => '1',
			),
		),
		't_tab'    => array(
			'id'  => 'additional_tabs_control_tabs',
			'tab' => esc_html__( 'Tab [3]', 'woodmart' ),
		),
		'priority' => 240,
		'class'    => 'xts-tab-field xts-last-tab-field',
	)
);

Options::add_field(
	array(
		'id'           => 'additional_tab_3_html_block',
		'type'         => 'select',
		'section'      => 'product_tabs',
		'name'         => esc_html__( 'HTML Block', 'woodmart' ),
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
				'key'     => 'additional_tab_3_content_type',
				'compare' => 'equals',
				'value'   => 'html_block',
			),
			array(
				'key'     => 'legacy_product_tabs_enabled',
				'compare' => 'equals',
				'value'   => '1',
			),
		),
		't_tab'        => array(
			'id'  => 'additional_tabs_control_tabs',
			'tab' => esc_html__( 'Tab [3]', 'woodmart' ),
		),
		'priority'     => 250,
		'class'        => 'xts-tab-field xts-last-tab-field',
	)
);
