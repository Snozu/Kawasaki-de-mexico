<?php
/**
 * CSS files.
 *
 * @version 1.0
 * @package xts
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

return array(
	'style-base' => array(
		array(
			'title' => esc_html__( 'Base style', 'woodmart' ),
			'name'  => 'style-base',
			'file'  => '/css/parts/base',
			'rtl'   => true,
		),
	),
	// Single product.
	'woo-single-prod-opt-review-images'                         => array(
		array(
			'title' => esc_html__( 'Single product review images', 'woodmart' ),
			'name'  => 'woo-single-prod-opt-review-images',
			'file'  => '/css/parts/woo-single-prod-opt-review-images',
		),
	),
	'woo-single-prod-opt-review-likes'                          => array(
		array(
			'title' => esc_html__( 'Single product review likes', 'woodmart' ),
			'name'  => 'woo-single-prod-opt-review-likes',
			'file'  => '/css/parts/woo-single-prod-opt-review-likes',
		),
	),
	'woo-single-prod-opt-rating-summary'                        => array(
		array(
			'title' => esc_html__( 'Single product review summary', 'woodmart' ),
			'name'  => 'woo-single-prod-opt-rating-summary',
			'file'  => '/css/parts/woo-single-prod-opt-rating-summary',
		),
	),
	'woo-single-prod-el-reviews'                                => array(
		array(
			'title' => esc_html__( 'Single product reviews', 'woodmart' ),
			'name'  => 'woo-single-prod-el-reviews',
			'file'  => '/css/parts/woo-single-prod-el-reviews',
		),
	),
	'woo-single-prod-el-reviews-style-1'                        => array(
		array(
			'title' => esc_html__( 'Single product reviews style 1', 'woodmart' ),
			'name'  => 'woo-single-prod-el-reviews-style-1',
			'file'  => '/css/parts/woo-single-prod-el-reviews-style-1',
		),
	),
	'woo-single-prod-el-reviews-style-2'                        => array(
		array(
			'title' => esc_html__( 'Single product reviews style 2', 'woodmart' ),
			'name'  => 'woo-single-prod-el-reviews-style-2',
			'file'  => '/css/parts/woo-single-prod-el-reviews-style-2',
		),
	),
	'woo-single-prod-el-base'                                   => array(
		array(
			'title' => esc_html__( 'Single product elements base', 'woodmart' ),
			'name'  => 'woo-single-prod-el-base',
			'file'  => '/css/parts/woo-single-prod-el-base',
		),
	),
	'woo-single-prod-el-gallery'                                => array(
		array(
			'title' => esc_html__( 'Single product gallery', 'woodmart' ),
			'name'  => 'woo-single-prod-el-gallery',
			'file'  => '/css/parts/woo-single-prod-el-gallery',
		),
	),
	'woo-single-prod-el-gallery-opt-thumb-left'                 => array(
		array(
			'title' => esc_html__( 'Single product gallery left', 'woodmart' ),
			'name'  => 'woo-single-prod-el-gallery-opt-thumb-left',
			'file'  => '/css/parts/woo-single-prod-el-gallery-opt-thumb-left',
		),
	),
	'woo-single-prod-el-gallery-opt-thumb-left-desktop'                 => array(
		array(
			'title' => esc_html__( 'Single product gallery left only on desktop', 'woodmart' ),
			'name'  => 'woo-single-prod-el-gallery-opt-thumb-left-desktop',
			'file'  => '/css/parts/woo-single-prod-el-gallery-opt-thumb-left-desktop',
		),
	),
	'woo-single-prod-el-gallery-opt-thumb-grid'              => array(
		array(
			'title' => esc_html__( 'Single product gallery columns', 'woodmart' ),
			'name'  => 'woo-single-prod-el-gallery-opt-thumb-grid',
			'file'  => '/css/parts/woo-single-prod-el-gallery-opt-thumb-grid',
		),
	),
	'woo-single-prod-el-gallery-opt-thumb-grid-lg'              => array(
		array(
			'title' => esc_html__( 'Single product gallery columns for desktop', 'woodmart' ),
			'name'  => 'woo-single-prod-el-gallery-opt-thumb-grid-lg',
			'file'  => '/css/parts/woo-single-prod-el-gallery-opt-thumb-grid',
			'media' => '(min-width: 1025px)',
		),
	),
	'woo-single-prod-el-gallery-opt-thumb-grid-md'              => array(
		array(
			'title' => esc_html__( 'Single product gallery columns for tablet', 'woodmart' ),
			'name'  => 'woo-single-prod-el-gallery-opt-thumb-grid-md',
			'file'  => '/css/parts/woo-single-prod-el-gallery-opt-thumb-grid',
			'media' => '(min-width: 769px)',
		),
	),
	'woo-single-prod-el-gallery-opt-thumb-grid-sm'              => array(
		array(
			'title' => esc_html__( 'Single product gallery columns for desktop and mobile', 'woodmart' ),
			'name'  => 'woo-single-prod-el-gallery-opt-thumb-grid-sm',
			'file'  => '/css/parts/woo-single-prod-el-gallery-opt-thumb-grid',
			'media' => '(min-width: 1025px), (max-width: 768px)',
		),
	),
	'woo-single-prod-el-navigation'                             => array(
		array(
			'title' => esc_html__( 'Single product navigation', 'woodmart' ),
			'name'  => 'woo-single-prod-el-navigation',
			'file'  => '/css/parts/woo-single-prod-el-navigation',
			'rtl'   => true,
		),
	),
	'woo-single-prod-el-tabs-opt-layout-tabs'                   => array(
		array(
			'title' => esc_html__( 'Single product tabs', 'woodmart' ),
			'name'  => 'woo-single-prod-el-tabs-opt-layout-tabs',
			'file'  => '/css/parts/woo-single-prod-el-tabs-opt-layout-tabs',
		),
	),
	'woo-single-prod-el-tabs-opt-layout-all-open'               => array(
		array(
			'title' => esc_html__( 'Single product tabs all-open', 'woodmart' ),
			'name'  => 'woo-single-prod-el-tabs-opt-layout-all-open',
			'file'  => '/css/parts/woo-single-prod-el-tabs-opt-layout-all-open',
		),
	),
	'woo-single-prod-el-tabs-opt-layout-side-hidden'               => array(
		array(
			'title' => esc_html__( 'Single product tabs side hidden', 'woodmart' ),
			'name'  => 'woo-single-prod-el-tabs-opt-layout-side-hidden',
			'file'  => '/css/parts/woo-single-prod-el-tabs-opt-layout-side-hidden',
			'rtl'   => true,
		),
	),
	'woo-single-prod-el-grouped'                                => array(
		array(
			'title' => esc_html__( 'Single grouped product', 'woodmart' ),
			'name'  => 'woo-single-prod-el-grouped',
			'file'  => '/css/parts/woo-single-prod-el-grouped',
		),
	),
	'woo-single-prod-opt-gallery-full-width'                    => array(
		array(
			'title' => esc_html__( 'Single product gallery full width', 'woodmart' ),
			'name'  => 'woo-single-prod-opt-gallery-full-width',
			'file'  => '/css/parts/woo-single-prod-opt-gallery-full-width',
		),
	),
	'woo-single-prod-opt-base'                                  => array(
		array(
			'title' => esc_html__( 'Single product base options', 'woodmart' ),
			'name'  => 'woo-single-prod-opt-base',
			'file'  => '/css/parts/woo-single-prod-opt-base',
		),
	),
	'woo-single-prod-design-centered'                           => array(
		array(
			'title' => esc_html__( 'Single product design centered', 'woodmart' ),
			'name'  => 'woo-single-prod-design-centered',
			'file'  => '/css/parts/woo-single-prod-design-centered',
		),
	),
	'woo-mod-shop-attributes'                                   => array(
		array(
			'title' => esc_html__( 'Single product shop attributes mod', 'woodmart' ),
			'name'  => 'woo-mod-shop-attributes',
			'file'  => '/css/parts/woo-mod-shop-attributes',
		),
	),
	'woo-mod-shop-loop-head'                                    => array(
		array(
			'title' => esc_html__( 'Shop loop head mod', 'woodmart' ),
			'name'  => 'woo-mod-shop-loop-head',
			'file'  => '/css/parts/woo-mod-shop-loop-head',
			'rtl'   => true,
		),
	),
	'woo-mod-checkout-steps'                                    => array(
		array(
			'title' => esc_html__( 'WooCommerce mod checkout steps', 'woodmart' ),
			'name'  => 'woo-mod-checkout-steps',
			'file'  => '/css/parts/woo-mod-checkout-steps',
			'rtl'   => true,
		),
	),
	'woo-mod-progress-bar'                                      => array(
		array(
			'title' => esc_html__( 'WooCommerce mod stock progress bar', 'woodmart' ),
			'name'  => 'woo-mod-progress-bar',
			'file'  => '/css/parts/woo-mod-progress-bar',
		),
	),
	'woo-mod-product-info'                                      => array(
		array(
			'title' => esc_html__( 'WooCommerce mod product info', 'woodmart' ),
			'name'  => 'woo-mod-product-info',
			'file'  => '/css/parts/woo-mod-product-info',
		),
	),
	'woo-mod-variation-form'                                    => array(
		array(
			'title' => esc_html__( 'WooCommerce mod variation form', 'woodmart' ),
			'name'  => 'woo-mod-variation-form',
			'file'  => '/css/parts/woo-mod-variation-form',
			'rtl'   => true,
		),
	),
	'woo-mod-variation-form-single'                             => array(
		array(
			'title' => esc_html__( 'WooCommerce mod variation form single', 'woodmart' ),
			'name'  => 'woo-mod-variation-form-single',
			'file'  => '/css/parts/woo-mod-variation-form-single',
			'rtl'   => true,
		),
	),
	'woo-mod-stock-status'                                      => array(
		array(
			'title' => esc_html__( 'WooCommerce mod stock status', 'woodmart' ),
			'name'  => 'woo-mod-stock-status',
			'file'  => '/css/parts/woo-mod-stock-status',
		),
	),
	'woo-mod-shop-table'                                        => array(
		array(
			'title' => esc_html__( 'WooCommerce mod shop table', 'woodmart' ),
			'name'  => 'woo-mod-shop-table',
			'file'  => '/css/parts/woo-mod-shop-table',
		),
	),
	'woo-mod-quantity'                                          => array(
		array(
			'title' => esc_html__( 'WooCommerce mod quantity', 'woodmart' ),
			'name'  => 'woo-mod-quantity',
			'file'  => '/css/parts/woo-mod-quantity',
		),
	),
	'woo-mod-quantity-overlap'                                  => array(
		array(
			'title' => esc_html__( 'WooCommerce mod quantity overlap', 'woodmart' ),
			'name'  => 'woo-mod-quantity-overlap',
			'file'  => '/css/parts/woo-mod-quantity-overlap',
		),
	),
	'woo-mod-grid'                                              => array(
		array(
			'title' => esc_html__( 'WooCommerce mod grid', 'woodmart' ),
			'name'  => 'woo-mod-grid',
			'file'  => '/css/parts/woo-mod-grid',
			'rtl'   => true,
		),
	),
	'woo-mod-swatches-base'                                     => array(
		array(
			'title' => esc_html__( 'WooCommerce mod swatches', 'woodmart' ),
			'name'  => 'woo-mod-swatches-base',
			'file'  => '/css/parts/woo-mod-swatches-base',
		),
	),
	'woo-mod-swatches-dis-1'                                    => array(
		array(
			'title' => esc_html__( 'WooCommerce mod disables swatches style 1', 'woodmart' ),
			'name'  => 'woo-mod-swatches-dis-1',
			'file'  => '/css/parts/woo-mod-swatches-dis-style-1',
		),
	),
	'woo-mod-swatches-dis-2'                                    => array(
		array(
			'title' => esc_html__( 'WooCommerce mod disables swatches style 2', 'woodmart' ),
			'name'  => 'woo-mod-swatches-dis-2',
			'file'  => '/css/parts/woo-mod-swatches-dis-style-2',
		),
	),
	'woo-mod-swatches-dis-3'                                    => array(
		array(
			'title' => esc_html__( 'WooCommerce mod disables swatches style 3', 'woodmart' ),
			'name'  => 'woo-mod-swatches-dis-3',
			'file'  => '/css/parts/woo-mod-swatches-dis-style-3',
		),
	),
	'woo-mod-swatches-style-1'                                  => array(
		array(
			'title' => esc_html__( 'WooCommerce mod swatches style 1', 'woodmart' ),
			'name'  => 'woo-mod-swatches-style-1',
			'file'  => '/css/parts/woo-mod-swatches-style-1',
		),
	),
	'woo-mod-swatches-style-2'                                  => array(
		array(
			'title' => esc_html__( 'WooCommerce mod swatches style 2', 'woodmart' ),
			'name'  => 'woo-mod-swatches-style-2',
			'file'  => '/css/parts/woo-mod-swatches-style-2',
		),
	),
	'woo-mod-swatches-style-3'                                  => array(
		array(
			'title' => esc_html__( 'WooCommerce mod swatches style 3', 'woodmart' ),
			'name'  => 'woo-mod-swatches-style-3',
			'file'  => '/css/parts/woo-mod-swatches-style-3',
		),
	),
	'woo-mod-swatches-style-4'                                  => array(
		array(
			'title' => esc_html__( 'WooCommerce mod swatches style 4', 'woodmart' ),
			'name'  => 'woo-mod-swatches-style-4',
			'file'  => '/css/parts/woo-mod-swatches-style-4',
		),
	),
	'woo-mod-swatches-filter'                                   => array(
		array(
			'title' => esc_html__( 'WooCommerce mod swatches filter', 'woodmart' ),
			'name'  => 'woo-mod-swatches-filter',
			'file'  => '/css/parts/woo-mod-swatches-filter',
		),
	),
	'woo-mod-widget-checkboxes'                                 => array(
		array(
			'title' => esc_html__( 'WooCommerce mod widget checkboxes', 'woodmart' ),
			'name'  => 'woo-mod-widget-checkboxes',
			'file'  => '/css/parts/woo-mod-widget-checkboxes',
		),
	),
	'woo-mod-widget-dropdown-form'                                 => array(
		array(
			'title' => esc_html__( 'WooCommerce mod widget dropdown form', 'woodmart' ),
			'name'  => 'woo-mod-widget-dropdown-form',
			'file'  => '/css/parts/woo-mod-widget-dropdown-form',
		),
	),
	'woo-opt-limit-swatches'                                    => array(
		array(
			'title' => esc_html__( 'Limit swatches', 'woodmart' ),
			'name'  => 'woo-opt-limit-swatches',
			'file'  => '/css/parts/woo-opt-limit-swatches',
		),
	),
	'mod-more-description'                                      => array(
		array(
			'title' => esc_html__( 'Mod more description', 'woodmart' ),
			'name'  => 'mod-more-description',
			'file'  => '/css/parts/mod-more-description',
		),
	),
	'mod-nav-vertical'                                          => array(
		array(
			'title' => esc_html__( 'Mod navigation vertical', 'woodmart' ),
			'name'  => 'mod-nav-vertical',
			'file'  => '/css/parts/mod-nav-vertical',
			'rtl'   => true,
		),
	),
	'mod-nav-vertical-design-default'                          => array(
		array(
			'title' => esc_html__( 'Mod navigation vertical design default', 'woodmart' ),
			'name'  => 'mod-nav-vertical-design-default',
			'file'  => '/css/parts/mod-nav-vertical-design-default',
		),
	),
	'mod-nav-vertical-design-with-bg'                          => array(
		array(
			'title' => esc_html__( 'Mod navigation vertical design with background', 'woodmart' ),
			'name'  => 'mod-nav-vertical-design-with-bg',
			'file'  => '/css/parts/mod-nav-vertical-design-with-bg',
		),
	),
	'mod-nav-vertical-design-simple'                          => array(
		array(
			'title' => esc_html__( 'Mod navigation vertical design default', 'woodmart' ),
			'name'  => 'mod-nav-vertical-design-simple',
			'file'  => '/css/parts/mod-nav-vertical-design-simple',
		),
	),
	'mod-nav-menu-label'                                        => array(
		array(
			'title' => esc_html__( 'Mod nav menu label', 'woodmart' ),
			'name'  => 'mod-nav-menu-label',
			'file'  => '/css/parts/mod-nav-menu-label',
		),
	),
	// Widgets.
	'widget-calendar'                                           => array(
		array(
			'title' => esc_html__( 'Widget calendar', 'woodmart' ),
			'name'  => 'widget-calendar',
			'file'  => '/css/parts/widget-calendar',
		),
	),
	'widget-rss'                                                => array(
		array(
			'title' => esc_html__( 'Widget rss', 'woodmart' ),
			'name'  => 'widget-rss',
			'file'  => '/css/parts/widget-rss',
		),
	),
	'widget-tag-cloud'                                          => array(
		array(
			'title' => esc_html__( 'Widget tag cloud', 'woodmart' ),
			'name'  => 'widget-tag-cloud',
			'file'  => '/css/parts/widget-tag-cloud',
		),
	),
	'widget-recent-post-comments'                               => array(
		array(
			'title' => esc_html__( 'Widget recent post or comments', 'woodmart' ),
			'name'  => 'widget-recent-post-comments',
			'file'  => '/css/parts/widget-recent-post-comments',
		),
	),
	'widget-media-gallery'                               => array(
		array(
			'title' => esc_html__( 'Widget media gallery', 'woodmart' ),
			'name'  => 'widget-media-gallery',
			'file'  => '/css/parts/widget-media-gallery',
		),
	),
	'widget-wd-recent-posts'                                    => array(
		array(
			'title' => esc_html__( '[Woodmart] Widget recent post', 'woodmart' ),
			'name'  => 'widget-wd-recent-posts',
			'file'  => '/css/parts/widget-wd-recent-posts',
		),
	),
	'widget-nav'                                                => array(
		array(
			'title' => esc_html__( '[Woodmart] Widget navigation', 'woodmart' ),
			'name'  => 'widget-nav',
			'file'  => '/css/parts/widget-nav',
		),
	),
	'widget-wd-layered-nav'                                     => array(
		array(
			'title' => esc_html__( '[Woodmart] Widget layered navigation', 'woodmart' ),
			'name'  => 'widget-wd-layered-nav',
			'file'  => '/css/parts/woo-widget-wd-layered-nav',
		),
	),
	'widget-product-cat'                                        => array(
		array(
			'title' => esc_html__( '[Woodmart] Widget product categories', 'woodmart' ),
			'name'  => 'widget-product-cat',
			'file'  => '/css/parts/woo-widget-product-cat',
		),
	),
	'widget-layered-nav-stock-status'                           => array(
		array(
			'title' => esc_html__( 'Widget layered navigation & stock status', 'woodmart' ),
			'name'  => 'widget-layered-nav-stock-status',
			'file'  => '/css/parts/woo-widget-layered-nav-stock-status',
		),
	),
	'widget-active-filters'                                     => array(
		array(
			'title' => esc_html__( 'Widget active filters', 'woodmart' ),
			'name'  => 'widget-active-filters',
			'file'  => '/css/parts/woo-widget-active-filters',
		),
	),
	'widget-price-filter'                                       => array(
		array(
			'title' => esc_html__( '[Woodmart] Widget price filter', 'woodmart' ),
			'name'  => 'widget-price-filter',
			'file'  => '/css/parts/woo-widget-price-filter',
		),
	),
	'widget-product-list'                                       => array(
		array(
			'title' => esc_html__( 'Widget products', 'woodmart' ),
			'name'  => 'widget-product-list',
			'file'  => '/css/parts/woo-widget-product-list',
		),
	),
	'widget-product-upsells'                                    => array(
		array(
			'title' => esc_html__( 'Widget products upsells', 'woodmart' ),
			'name'  => 'widget-product-upsells',
			'file'  => '/css/parts/woo-widget-upsells',
		),
	),
	'widget-shopping-cart'                                      => array(
		array(
			'title' => esc_html__( 'Widget shopping cart', 'woodmart' ),
			'name'  => 'widget-shopping-cart',
			'file'  => '/css/parts/woo-widget-shopping-cart',
		),
	),
	'widget-slider-price-filter'                                => array(
		array(
			'title' => esc_html__( 'Widget price filter slider', 'woodmart' ),
			'name'  => 'widget-slider-price-filter',
			'file'  => '/css/parts/woo-widget-slider-price-filter',
		),
	),
	'widget-user-panel'                                         => array(
		array(
			'title' => esc_html__( 'Widget user panel', 'woodmart' ),
			'name'  => 'widget-user-panel',
			'file'  => '/css/parts/woo-widget-user-panel',
		),
	),
	'widget-brand-thumbnails'                                         => array(
		array(
			'title' => esc_html__( 'Widget brand thumbnails', 'woodmart' ),
			'name'  => 'widget-brand-thumbnails',
			'file'  => '/css/parts/woo-widget-brand-thumbnails',
		),
	),
	'widget-woo-other'                                          => array(
		array(
			'title' => esc_html__( 'Widget woocommerce other', 'woodmart' ),
			'name'  => 'widget-woo-other',
			'file'  => '/css/parts/woo-widget-other',
		),
	),
	'post-types-mod-predefined'                                  => array(
		array(
			'title' => esc_html__( 'Post types general style', 'woodmart' ),
			'name'  => 'post-types-mod-predefined',
			'file'  => '/css/parts/post-types-mod-predefined',
		),
	),
	'post-types-mod-categories-style-bg'                                  => array(
		array(
			'title' => esc_html__( 'Post types module categories', 'woodmart' ),
			'name'  => 'post-types-mod-categories-style-bg',
			'file'  => '/css/parts/post-types-mod-categories-style-bg',
		),
	),
	'post-types-mod-date-style-bg'                                  => array(
		array(
			'title' => esc_html__( 'Post types module date with background', 'woodmart' ),
			'name'  => 'post-types-mod-date-style-bg',
			'file'  => '/css/parts/post-types-mod-date-style-bg',
		),
	),
	'post-types-mod-comments'                                              => array(
		array(
			'title' => esc_html__( 'Post types module comments', 'woodmart' ),
			'name'  => 'post-types-mod-comments',
			'file'  => '/css/parts/post-types-mod-comments',
		),
	),
	'post-types-mod-password'                                              => array(
		array(
			'title' => esc_html__( 'Password protection form', 'woodmart' ),
			'name'  => 'post-types-mod-password',
			'file'  => '/css/parts/post-types-mod-password',
		),
	),
	'post-types-mod-pagination'                                              => array(
		array(
			'title' => esc_html__( 'Post pagination', 'woodmart' ),
			'name'  => 'post-types-mod-pagination',
			'file'  => '/css/parts/post-types-mod-pagination',
		),
	),
	'post-types-el-page-navigation'                                           => array(
		array(
			'title' => esc_html__( 'Post types module navigation', 'woodmart' ),
			'name'  => 'post-types-el-page-navigation',
			'file'  => '/css/parts/post-types-el-page-navigation',
		),
	),
	// Blog.
	'blog-mod-author'                                  => array(
		array(
			'title' => esc_html__( 'Blog module author', 'woodmart' ),
			'name'  => 'blog-mod-author',
			'file'  => '/css/parts/blog-mod-author',
		),
	),
	'blog-mod-comments-button'                                  => array(
		array(
			'title' => esc_html__( 'Blog module commetns button', 'woodmart' ),
			'name'  => 'blog-mod-comments-button',
			'file'  => '/css/parts/blog-mod-comments-button',
		),
	),
	'blog-mod-gallery'                                  => array(
		array(
			'title' => esc_html__( 'Blog module gallery', 'woodmart' ),
			'name'  => 'blog-mod-gallery',
			'file'  => '/css/parts/blog-mod-gallery',
		),
	),
	'blog-el-author-bio'                                  => array(
		array(
			'title' => esc_html__( 'Blog element author bio', 'woodmart' ),
			'name'  => 'blog-el-author-bio',
			'file'  => '/css/parts/blog-el-author-bio',
		),
	),
	'blog-loop-base'                                            => array(
		array(
			'title' => esc_html__( 'Blog loop base', 'woodmart' ),
			'name'  => 'blog-loop-base',
			'file'  => '/css/parts/blog-loop-base',
		),
	),
	// 'blog-loop-base-old'                                        => array(
	// 	array(
	// 		'title' => esc_html__( 'Blog loop base old', 'woodmart' ),
	// 		'name'  => 'blog-loop-base-old',
	// 		'file'  => '/css/parts/blog-loop-base-old',
	// 		'rtl'   => true,
	// 	),
	// ),
	'blog-loop-design-meta-image'                               => array(
		array(
			'title' => esc_html__( 'Blog loop design meta image', 'woodmart' ),
			'name'  => 'blog-loop-design-meta-image',
			'file'  => '/css/parts/blog-loop-design-meta-image',
		),
	),
	'blog-loop-design-default'                                  => array(
		array(
			'title' => esc_html__( 'Blog loop design default', 'woodmart' ),
			'name'  => 'blog-loop-design-default',
			'file'  => '/css/parts/blog-loop-design-default',
		),
	),
	'blog-loop-design-default-alt'                              => array(
		array(
			'title' => esc_html__( 'Blog loop design default alternative', 'woodmart' ),
			'name'  => 'blog-loop-design-default-alt',
			'file'  => '/css/parts/blog-loop-design-default-alt',
		),
	),
	'blog-loop-design-small-img-chess'                          => array(
		array(
			'title' => esc_html__( 'Blog loop design small images & chess', 'woodmart' ),
			'name'  => 'blog-loop-design-small-img-chess',
			'file'  => '/css/parts/blog-loop-design-smallimg-chess',
		),
	),
	'blog-loop-design-small'                                    => array(
		array(
			'title' => esc_html__( 'Blog loop design small', 'woodmart' ),
			'name'  => 'blog-loop-design-small',
			'file'  => '/css/parts/blog-loop-design-small',
		),
	),
	'blog-loop-design-mask'                                     => array(
		array(
			'title' => esc_html__( 'Blog loop design mask', 'woodmart' ),
			'name'  => 'blog-loop-design-mask',
			'file'  => '/css/parts/blog-loop-design-mask',
		),
	),
	'blog-loop-design-masonry'                                  => array(
		array(
			'title' => esc_html__( 'Blog loop design masonry', 'woodmart' ),
			'name'  => 'blog-loop-design-masonry',
			'file'  => '/css/parts/blog-loop-design-masonry',
		),
	),
	'blog-loop-design-list'                                  => array(
		array(
			'title' => esc_html__( 'Blog loop design list', 'woodmart' ),
			'name'  => 'blog-loop-design-list',
			'file'  => '/css/parts/blog-loop-design-list',
		),
	),
	'blog-single-predefined'                                          => array(
		array(
			'title' => esc_html__( 'Blog post predefined', 'woodmart' ),
			'name'  => 'blog-single-predefined',
			'file'  => '/css/parts/blog-single-predefined',
		),
	),
	'post-design-large-image'                                          => array(
		array(
			'title' => esc_html__( 'Blog design Large image', 'woodmart' ),
			'name'  => 'post-design-large-image',
			'file'  => '/css/parts/post-design-large-image',
		),
	),
	'single-post-el-tags'                                   => array(
		array(
			'title' => esc_html__( 'Blog post element tags', 'woodmart' ),
			'name'  => 'single-post-el-tags',
			'file'  => '/css/parts/single-post-el-tags',
		),
	),
	'single-post-el-comments'                                   => array(
		array(
			'title' => esc_html__( 'Blog post element comments', 'woodmart' ),
			'name'  => 'single-post-el-comments',
			'file'  => '/css/parts/single-post-el-comments',
		),
	),
	'blog-loop-format-quote'                                          => array(
		array(
			'title' => esc_html__( 'Blog loop format quote', 'woodmart' ),
			'name'  => 'blog-loop-format-quote',
			'file'  => '/css/parts/blog-loop-format-quote',
		),
	),
	// Modules.
	'animations'                                                => array(
		array(
			'title' => esc_html__( 'Animations module', 'woodmart' ),
			'name'  => 'animations',
			'file'  => '/css/parts/mod-animations-transform',
		),
	),
	'notices-fixed'                                             => array(
		array(
			'title' => esc_html__( 'Sticky notifications old module (Deprecated)', 'woodmart' ),
			'name'  => 'notices-fixed',
			'file'  => '/css/parts/woo-opt-sticky-notices-old',
		),
	),
	'woocommerce-block-notices'                              => array(
		array(
			'title' => esc_html__( 'WooCommerce block notices', 'woodmart' ),
			'name'  => 'woocommerce-block-notices',
			'file'  => '/css/parts/woo-mod-block-notices',
			'rtl'   => true,
		),
	),
	'load-more-button'                                          => array(
		array(
			'title' => esc_html__( 'Load more button', 'woodmart' ),
			'name'  => 'load-more-button',
			'file'  => '/css/parts/mod-load-more-button',
		),
	),
	'sticky-loader'                                             => array(
		array(
			'title' => esc_html__( 'Sticky loader', 'woodmart' ),
			'name'  => 'sticky-loader',
			'file'  => '/css/parts/mod-sticky-loader',
		),
	),
	// Footer.
	'footer-base'                                               => array(
		array(
			'title' => esc_html__( 'Footer base', 'woodmart' ),
			'name'  => 'footer-base',
			'file'  => '/css/parts/footer-base',
		),
	),
	// Header.
	'header-base'                                               => array(
		array(
			'title' => esc_html__( 'Header base', 'woodmart' ),
			'name'  => 'header-base',
			'file'  => '/css/parts/header-base',
			'rtl'   => true,
		),
	),
	'header-boxed'                                              => array(
		array(
			'title' => esc_html__( 'Header boxed', 'woodmart' ),
			'name'  => 'header-boxed',
			'file'  => '/css/parts/header-boxed',
		),
	),
	'header-elements-base'                                      => array(
		array(
			'title' => esc_html__( 'Header base elements', 'woodmart' ),
			'name'  => 'header-elements-base',
			'file'  => '/css/parts/header-el-base',
			'rtl'   => true,
		),
	),
	'header-fullscreen-menu'                                    => array(
		array(
			'title' => esc_html__( 'Header fullscreen menu', 'woodmart' ),
			'name'  => 'header-fullscreen-menu',
			'file'  => '/css/parts/header-el-fullscreen-menu',
			'rtl'   => true,
		),
	),
	'header-categories-nav'                                     => array(
		array(
			'title' => esc_html__( 'Header category navigation', 'woodmart' ),
			'name'  => 'header-categories-nav',
			'file'  => '/css/parts/header-el-category-nav',
		),
	),
	'header-mobile-nav-drilldown'                                     => array(
		array(
			'title' => esc_html__( 'Header mobile navigation drilldown', 'woodmart' ),
			'name'  => 'header-mobile-nav-drilldown',
			'file'  => '/css/parts/header-el-mobile-nav-drilldown',
			'rtl'   => true,
		),
	),
	'header-mobile-nav-drilldown-fade-in'                                     => array(
		array(
			'title' => esc_html__( 'Header mobile navigation drilldown fade in', 'woodmart' ),
			'name'  => 'header-mobile-nav-drilldown-fade-in',
			'file'  => '/css/parts/header-el-mobile-nav-drilldown-fade-in',
		),
	),
	'header-mobile-nav-drilldown-slide'                                     => array(
		array(
			'title' => esc_html__( 'Header mobile navigation drilldown slide', 'woodmart' ),
			'name'  => 'header-mobile-nav-drilldown-slide',
			'file'  => '/css/parts/header-el-mobile-nav-drilldown-slide',
			'rtl'   => true,
		),
	),
	'header-mobile-nav-dropdown'                                     => array(
		array(
			'title' => esc_html__( 'Header mobile navigation dropdown', 'woodmart' ),
			'name'  => 'header-mobile-nav-dropdown',
			'file'  => '/css/parts/header-el-mobile-nav-dropdown',
		),
	),
	'header-my-account'                                         => array(
		array(
			'title' => esc_html__( 'Header my account', 'woodmart' ),
			'name'  => 'header-my-account',
			'file'  => '/css/parts/header-el-my-account',
			'rtl'   => true,
		),
	),
	'header-my-account-dropdown'                                => array(
		array(
			'title' => esc_html__( 'Header my account dropdown', 'woodmart' ),
			'name'  => 'header-my-account-dropdown',
			'file'  => '/css/parts/header-el-my-account-dropdown',
			'rtl'   => true,
		),
	),
	'header-my-account-sidebar'                                 => array(
		array(
			'title' => esc_html__( 'Header my account sidebar', 'woodmart' ),
			'name'  => 'header-my-account-sidebar',
			'file'  => '/css/parts/header-el-my-account-sidebar',
		),
	),
	'header-search'                                             => array(
		array(
			'title' => esc_html__( 'Header search', 'woodmart' ),
			'name'  => 'header-search',
			'file'  => '/css/parts/header-el-search',
			'rtl'   => true,
		),
	),
	'header-search-form'                                        => array(
		array(
			'title' => esc_html__( 'Header search form', 'woodmart' ),
			'name'  => 'header-search-form',
			'file'  => '/css/parts/header-el-search-form',
			'rtl'   => true,
		),
	),
	'header-search-fullscreen'                                  => array(
		array(
			'title' => esc_html__( 'Header search fullscreen', 'woodmart' ),
			'name'  => 'header-search-fullscreen',
			'file'  => '/css/parts/header-el-search-fullscreen-general',
		),
	),
	'header-search-fullscreen-1'                                => array(
		array(
			'title' => esc_html__( 'Header search fullscreen 1', 'woodmart' ),
			'name'  => 'header-search-fullscreen-1',
			'file'  => '/css/parts/header-el-search-fullscreen-1',
		),
	),
	'header-search-fullscreen-2'                                => array(
		array(
			'title' => esc_html__( 'Header search fullscreen 2', 'woodmart' ),
			'name'  => 'header-search-fullscreen-2',
			'file'  => '/css/parts/header-el-search-fullscreen-2',
		),
	),
	'wd-search-form'                                            => array(
		array(
			'title' => esc_html__( 'Search form', 'woodmart' ),
			'name'  => 'wd-search-form',
			'file'  => '/css/parts/wd-search-form',
		),
	),
	'wd-search-cat'                                             => array(
		array(
			'title' => esc_html__( 'Search form with categories', 'woodmart' ),
			'name'  => 'wd-search-cat',
			'file'  => '/css/parts/wd-search-cat',
			'rtl'   => true,
		),
	),
	'wd-search-dropdown'                                             => array(
		array(
			'title' => esc_html__( 'Search form results dropdown', 'woodmart' ),
			'name'  => 'wd-search-dropdown',
			'file'  => '/css/parts/wd-search-dropdown',
			'rtl'   => true,
		),
	),
	'wd-search-results'                                         => array(
		array(
			'title' => esc_html__( 'Search form with ajax', 'woodmart' ),
			'name'  => 'wd-search-results',
			'file'  => '/css/parts/wd-search-results',
		),
	),
	'header-cart'                                               => array(
		array(
			'title' => esc_html__( 'Header cart', 'woodmart' ),
			'name'  => 'header-cart',
			'file'  => '/css/parts/header-el-cart',
			'rtl'   => true,
		),
	),
	'header-cart-design-3'                                      => array(
		array(
			'title' => esc_html__( 'Header cart design 3', 'woodmart' ),
			'name'  => 'header-cart-design-3',
			'file'  => '/css/parts/header-el-cart-design-3',
			'rtl'   => true,
		),
	),
	'header-cart-side'                                          => array(
		array(
			'title' => esc_html__( 'Header cart-side', 'woodmart' ),
			'name'  => 'header-cart-side',
			'file'  => '/css/parts/header-el-cart-side',
		),
	),
	'header-el-category-more-btn'                               => array(
		array(
			'title' => esc_html__( 'Header element category more button', 'woodmart' ),
			'name'  => 'header-el-category-more-btn',
			'file'  => '/css/parts/header-el-category-more-btn',
		),
	),
	'mod-tools-design-8'                                        => array(
		array(
			'title' => esc_html__( 'Module tools design 8', 'woodmart' ),
			'name'  => 'mod-tools-design-8',
			'file'  => '/css/parts/mod-tools-design-8',
		),
	),
	// Layouts.
	'layout-wrapper-boxed'                                      => array(
		array(
			'title' => esc_html__( 'Layout wrapper boxed', 'woodmart' ),
			'name'  => 'layout-wrapper-boxed',
			'file'  => '/css/parts/layout-wrapper-boxed',
			'rtl'   => true,
		),
	),
	// Woocommerce options.
	'woo-opt-free-progress-bar'                                 => array(
		array(
			'title' => esc_html__( 'Free shipping progress bar', 'woodmart' ),
			'name'  => 'woo-opt-free-progress-bar',
			'file'  => '/css/parts/woo-opt-free-progress-bar',
		),
	),
	'woo-opt-visits-count'                                      => array(
		array(
			'title' => esc_html__( 'Count product visits', 'woodmart' ),
			'name'  => 'woo-opt-visits-count',
			'file'  => '/css/parts/woo-opt-visits-count',
		),
	),
	'woo-opt-sold-count'                                        => array(
		array(
			'title' => esc_html__( 'Product sold count', 'woodmart' ),
			'name'  => 'woo-opt-sold-count',
			'file'  => '/css/parts/woo-opt-sold-count',
		),
	),
	'woo-opt-est-del'                                        => array(
		array(
			'title' => esc_html__( 'Product estimate delivery', 'woodmart' ),
			'name'  => 'woo-opt-est-del',
			'file'  => '/css/parts/woo-opt-est-del',
		),
	),
	'int-woo-page-orders'                                        => array(
		array(
			'title' => esc_html__( 'Product estimate delivery on admin panel', 'woodmart' ),
			'name'  => 'int-woo-page-orders',
			'file'  => '/css/parts/int-woo-page-orders',
		),
	),
	'woo-single-prod-opt-gallery-video'                         => array(
		array(
			'title' => esc_html__( 'Video thumbnail', 'woodmart' ),
			'name'  => 'woo-single-prod-opt-gallery-video',
			'file'  => '/css/parts/woo-single-prod-opt-gallery-video',
		),
	),
	'woo-single-prod-opt-gallery-video-pswp'                    => array(
		array(
			'title' => esc_html__( 'Video thumbnail Photoswipe', 'woodmart' ),
			'name'  => 'woo-single-prod-opt-gallery-video-pswp',
			'file'  => '/css/parts/woo-single-prod-opt-gallery-video-pswp',
		),
	),
	'woo-opt-grid-gallery'                                      => array(
		array(
			'title' => esc_html__( 'Product grid gallery', 'woodmart' ),
			'name'  => 'woo-opt-grid-gallery',
			'file'  => '/css/parts/woo-opt-grid-gallery',
			'rtl'   => true,
		),
	),
	'woo-opt-stretch-cont'                                      => array(
		array(
			'title' => esc_html__( 'Product stretch content', 'woodmart' ),
			'name'  => 'woo-opt-stretch-cont',
			'file'  => '/css/parts/woo-opt-stretch-cont',
		),
	),
	'bordered-product'                                          => array(
		array(
			'title' => esc_html__( 'Bordered product', 'woodmart' ),
			'name'  => 'bordered-product',
			'file'  => '/css/parts/woo-opt-bordered-product',
			'rtl'   => true,
		),
	),
	'products-divider'                                          => array(
		array(
			'title' => esc_html__( 'Products divider', 'woodmart' ),
			'name'  => 'products-divider',
			'file'  => '/css/parts/woo-opt-products-small-divider',
		),
	),
	'woo-opt-fbt'                                               => array(
		array(
			'title' => esc_html__( 'Frequently bought together products', 'woodmart' ),
			'name'  => 'woo-opt-fbt',
			'file'  => '/css/parts/woo-opt-fbt',
		),
	),
	'woo-opt-fbt-cart'                                          => array(
		array(
			'title' => esc_html__( 'Frequently bought together products cart', 'woodmart' ),
			'name'  => 'woo-opt-fbt-cart',
			'file'  => '/css/parts/woo-opt-fbt-cart',
		),
	),
	'woo-opt-dynamic-discounts'                                               => array(
		array(
			'title' => esc_html__( 'Dynamic discounts', 'woodmart' ),
			'name'  => 'woo-opt-dynamic-discounts',
			'file'  => '/css/parts/woo-opt-dynamic-discounts',
		),
	),
	'woo-opt-fg'                                               => array(
		array(
			'title' => esc_html__( 'Free gifts', 'woodmart' ),
			'name'  => 'woo-opt-fg',
			'file'  => '/css/parts/woo-opt-fg',
		),
	),
	'woo-opt-wtl'                                               => array(
		array(
			'title' => esc_html__( 'Waitlists', 'woodmart' ),
			'name'  => 'woo-opt-wtl',
			'file'  => '/css/parts/woo-opt-wtl',
		),
	),
	'woo-page-wtl'                                               => array(
		array(
			'title' => esc_html__( 'Waitlists on My account', 'woodmart' ),
			'name'  => 'woo-page-wtl',
			'file'  => '/css/parts/woo-page-wtl',
		),
	),
	'shop-filter-area'                                          => array(
		array(
			'title' => esc_html__( 'Shop filter area', 'woodmart' ),
			'name'  => 'shop-filter-area',
			'file'  => '/css/parts/woo-shop-el-filters-area',
		),
	),
	'shop-title-categories'                                     => array(
		array(
			'title' => esc_html__( 'Shop page title categories', 'woodmart' ),
			'name'  => 'shop-title-categories',
			'file'  => '/css/parts/woo-categories-loop-nav',
		),
	),
	'woo-categories-loop-nav-mobile-accordion'                  => array(
		array(
			'title' => esc_html__( 'Shop mobile accordion categories', 'woodmart' ),
			'name'  => 'woo-categories-loop-nav-mobile-accordion',
			'file'  => '/css/parts/woo-categories-loop-nav-mobile-accordion',
		),
	),
	'woo-categories-loop-nav-mobile-side-hidden'                  => array(
		array(
			'title' => esc_html__( 'Shop mobile hidden sidebar categories', 'woodmart' ),
			'name'  => 'woo-categories-loop-nav-mobile-side-hidden',
			'file'  => '/css/parts/woo-categories-loop-nav-mobile-side-hidden',
		),
	),
	'woo-opt-manage-checkout-prod'                              => array(
		array(
			'title' => esc_html__( 'Manage products on checkout', 'woodmart' ),
			'name'  => 'woo-opt-manage-checkout-prod',
			'file'  => '/css/parts/woo-opt-manage-checkout-prod',
		),
	),
	'woo-opt-products-bg'                                       => array(
		array(
			'title' => esc_html__( 'Products background', 'woodmart' ),
			'name'  => 'woo-opt-products-bg',
			'file'  => '/css/parts/woo-opt-products-bg',
		),
	),
	'woo-opt-products-shadow'                                   => array(
		array(
			'title' => esc_html__( 'Products shadow', 'woodmart' ),
			'name'  => 'woo-opt-products-shadow',
			'file'  => '/css/parts/woo-opt-products-shadow',
		),
	),
	// Woocommerce.
	'colorbox-popup'                                            => array(
		array(
			'title' => esc_html__( 'Color box popup library', 'woodmart' ),
			'name'  => 'colorbox-popup',
			'file'  => '/css/parts/woo-lib-colorbox-popup',
		),
	),
	'woocommerce-base'                                          => array(
		array(
			'title' => esc_html__( 'WooCommerce base', 'woodmart' ),
			'name'  => 'woocommerce-base',
			'file'  => '/css/parts/woocommerce-base',
			'rtl'   => true,
		),
	),
	'brands'                                                    => array(
		array(
			'title' => esc_html__( 'Brands element', 'woodmart' ),
			'name'  => 'brands',
			'file'  => '/css/parts/el-brand',
		),
	),
	'brands-style-bordered'                                                    => array(
		array(
			'title' => esc_html__( 'Brands style bordered', 'woodmart' ),
			'name'  => 'brands-style-bordered',
			'file'  => '/css/parts/el-brand-style-bordered',
			'rtl'   => true,
		),
	),
	'product-tabs'                                              => array(
		array(
			'title' => esc_html__( 'Product tabs element', 'woodmart' ),
			'name'  => 'product-tabs',
			'file'  => '/css/parts/el-product-tabs',
			'rtl'   => true,
		),
	),
	'add-to-cart-popup'                                         => array(
		array(
			'title' => esc_html__( 'Add to cart popup option', 'woodmart' ),
			'name'  => 'add-to-cart-popup',
			'file'  => '/css/parts/woo-opt-add-to-cart-popup',
		),
	),
	'size-guide'                                                => array(
		array(
			'title' => esc_html__( 'Size guide', 'woodmart' ),
			'name'  => 'size-guide',
			'file'  => '/css/parts/woo-opt-size-guide',
		),
	),
	'sticky-add-to-cart'                                        => array(
		array(
			'title' => esc_html__( 'Sticky add to cart', 'woodmart' ),
			'name'  => 'sticky-add-to-cart',
			'file'  => '/css/parts/woo-opt-sticky-add-to-cart',
		),
	),
	'page-cart'                                                 => array(
		array(
			'title' => esc_html__( 'Cart page', 'woodmart' ),
			'name'  => 'page-cart',
			'file'  => '/css/parts/woo-page-cart',
			'rtl'   => true,
		),
	),
	'woo-page-cart-predefined'                                  => array(
		array(
			'title' => esc_html__( 'Cart page predefined', 'woodmart' ),
			'name'  => 'woo-page-cart-predefined',
			'file'  => '/css/parts/woo-page-cart-predefined',
		),
	),
	'woo-page-cart-builder'                                     => array(
		array(
			'title' => esc_html__( 'Cart page builder', 'woodmart' ),
			'name'  => 'woo-page-cart-builder',
			'file'  => '/css/parts/woo-page-cart-builder',
		),
	),
	'woo-page-cart-el-cart-totals-layout-2'                                     => array(
		array(
			'title' => esc_html__( 'Cart totals layout 2', 'woodmart' ),
			'name'  => 'woo-page-cart-el-cart-totals-layout-2',
			'file'  => '/css/parts/woo-page-cart-el-cart-totals-layout-2',
		),
	),
	'wp-blocks-cart-checkout'                                     => array(
		array(
			'title' => esc_html__( 'Cart & Checkout blocks', 'woodmart' ),
			'name'  => 'wp-blocks-cart-checkout',
			'file'  => '/css/parts/wp-blocks-cart-checkout',
		),
	),
	'page-checkout'                                             => array(
		array(
			'title' => esc_html__( 'Checkout page', 'woodmart' ),
			'name'  => 'page-checkout',
			'file'  => '/css/parts/woo-page-checkout',
			'rtl'   => true,
		),
	),
	'page-checkout-payment-methods'                             => array(
		array(
			'title' => esc_html__( 'Payment Methods on checkout page', 'woodmart' ),
			'name'  => 'page-checkout-payment-methods',
			'file'  => '/css/parts/woo-page-checkout-el-payment-methods',
		),
	),
	'woo-page-checkout-predefined'                              => array(
		array(
			'title' => esc_html__( 'Checkout predefined page', 'woodmart' ),
			'name'  => 'woo-page-checkout-predefined',
			'file'  => '/css/parts/woo-page-checkout-predefined',
		),
	),
	'woo-page-checkout-builder'                                 => array(
		array(
			'title' => esc_html__( 'Checkout builder page', 'woodmart' ),
			'name'  => 'woo-page-checkout-builder',
			'file'  => '/css/parts/woo-page-checkout-builder',
		),
	),
	'woo-thank-you-page'                                   => array(
		array(
			'title' => esc_html__( 'Order complete page', 'woodmart' ),
			'name'  => 'woo-thank-you-page',
			'file'  => '/css/parts/woo-thank-you-page',
		),
	),
	'woo-thank-you-page-predefined'                                   => array(
		array(
			'title' => esc_html__( 'Thank you page predefined', 'woodmart' ),
			'name'  => 'woo-thank-you-page-predefined',
			'file'  => '/css/parts/woo-thank-you-page-predefined',
		),
	),
	'woo-page-empty-page'                                       => array(
		array(
			'title' => esc_html__( 'WooCommerce page empty page', 'woodmart' ),
			'name'  => 'woo-page-empty-page',
			'file'  => '/css/parts/woo-page-empty-page',
		),
	),
	'woo-page-lost-password'                                    => array(
		array(
			'title' => esc_html__( 'WooCommerce page lost password', 'woodmart' ),
			'name'  => 'woo-page-lost-password',
			'file'  => '/css/parts/woo-page-lost-password',
		),
	),
	'woo-el-track-order'                                        => array(
		array(
			'title' => esc_html__( 'WooCommerce element track order', 'woodmart' ),
			'name'  => 'woo-el-track-order',
			'file'  => '/css/parts/woo-el-track-order',
		),
	),
	'woo-mod-order-details'                                     => array(
		array(
			'title' => esc_html__( 'WooCommerce order details mod', 'woodmart' ),
			'name'  => 'woo-mod-order-details',
			'file'  => '/css/parts/woo-mod-order-details',
		),
	),
	'page-compare'                                              => array(
		array(
			'title' => esc_html__( 'Compare page', 'woodmart' ),
			'name'  => 'page-compare',
			'file'  => '/css/parts/woo-page-compare',
		),
	),
	'page-compare-by-category'                                  => array(
		array(
			'title' => esc_html__( 'Compare page by category', 'woodmart' ),
			'name'  => 'page-compare-by-category',
			'file'  => '/css/parts/woo-page-compare-category',
		),
	),
	'page-wishlist'                                             => array(
		array(
			'title' => esc_html__( 'Wishlist page', 'woodmart' ),
			'name'  => 'page-wishlist',
			'file'  => '/css/parts/woo-page-wishlist',
		),
	),
	'page-wishlists'                                            => array(
		array(
			'title' => esc_html__( 'Wishlists page in admin panel', 'woodmart' ),
			'name'  => 'page-wishlists',
			'file'  => 'inc/admin/assets/css/parts/page-wishlists',
		),
	),
	'page-wishlist-group'                                       => array(
		array(
			'title' => esc_html__( 'Wishlist page', 'woodmart' ),
			'name'  => 'page-wishlist-group',
			'file'  => '/css/parts/woo-page-wishlist-group',
		),
	),
	'page-wishlist-bulk'                                        => array(
		array(
			'title' => esc_html__( 'Wishlist bulk action', 'woodmart' ),
			'name'  => 'page-wishlist-bulk',
			'file'  => '/css/parts/woo-page-wishlist-bulk',
		),
	),
	'page-wishlist-popup'                                       => array(
		array(
			'title' => esc_html__( 'Wishlist popup', 'woodmart' ),
			'name'  => 'page-wishlist-popup',
			'file'  => '/css/parts/woo-page-wishlist-popup',
		),
	),
	'page-my-account'                                           => array(
		array(
			'title' => esc_html__( 'My account page', 'woodmart' ),
			'name'  => 'page-my-account',
			'file'  => '/css/parts/woo-page-my-account',
			'rtl'   => true,
		),
	),
	'woo-shop-builder'                                          => array(
		array(
			'title' => esc_html__( 'Shop builder', 'woodmart' ),
			'name'  => 'woo-shop-builder',
			'file'  => '/css/parts/woo-shop-builder',
		),
	),
	'woo-shop-predefined'                                       => array(
		array(
			'title' => esc_html__( 'Shop predefined', 'woodmart' ),
			'name'  => 'woo-shop-predefined',
			'file'  => '/css/parts/woo-shop-predefined',
		),
	),
	'woo-shop-el-active-filters'                                => array(
		array(
			'title' => esc_html__( 'Shop active filters element', 'woodmart' ),
			'name'  => 'woo-shop-el-active-filters',
			'file'  => '/css/parts/woo-shop-el-active-filters',
		),
	),
	'woo-shop-el-order-by'                                      => array(
		array(
			'title' => esc_html__( 'Shop order by element', 'woodmart' ),
			'name'  => 'woo-shop-el-order-by',
			'file'  => '/css/parts/woo-shop-el-order-by',
			'rtl'   => true,
		),
	),
	'woo-shop-el-products-per-page'                             => array(
		array(
			'title' => esc_html__( 'Shop products per page element', 'woodmart' ),
			'name'  => 'woo-shop-el-products-per-page',
			'file'  => '/css/parts/woo-shop-el-products-per-page',
		),
	),
	'woo-shop-el-products-view'                                 => array(
		array(
			'title' => esc_html__( 'Shop products view element', 'woodmart' ),
			'name'  => 'woo-shop-el-products-view',
			'file'  => '/css/parts/woo-shop-el-products-view',
		),
	),
	'woo-shop-page-title'                                       => array(
		array(
			'title' => esc_html__( 'Shop products page title element', 'woodmart' ),
			'name'  => 'woo-shop-page-title',
			'file'  => '/css/parts/woo-shop-page-title',
			'rtl'   => true,
		),
	),
	'woo-shop-opt-without-title'                                => array(
		array(
			'title' => esc_html__( 'Shop opt without title', 'woodmart' ),
			'name'  => 'woo-shop-opt-without-title',
			'file'  => '/css/parts/woo-shop-opt-without-title',
		),
	),
	'product-loop'                                              => array(
		array(
			'title' => esc_html__( 'Product loop', 'woodmart' ),
			'name'  => 'product-loop',
			'file'  => '/css/parts/woo-product-loop',
			'rtl'   => true,
		),
	),
	'woo-prod-loop-small'                                       => array(
		array(
			'title' => esc_html__( 'Product hover small', 'woodmart' ),
			'name'  => 'woo-prod-loop-small',
			'file'  => '/css/parts/woo-prod-loop-small',
		),
	),
	'product-loop-button-info-alt'                              => array(
		array(
			'title' => esc_html__( 'Product loop "Standard button" & "Full info on hover"', 'woodmart' ),
			'name'  => 'product-loop-button-info-alt',
			'file'  => '/css/parts/woo-product-loop-button-info-alt',
		),
	),
	'product-loop-buttons-on-hover'                                         => array(
		array(
			'title' => esc_html__( 'Product loop "Buttons on hover"', 'woodmart' ),
			'name'  => 'product-loop-buttons-on-hover',
			'file'  => '/css/parts/woo-product-loop-buttons-on-hover',
		),
	),
	'product-loop-info'                                         => array(
		array(
			'title' => esc_html__( 'Product loop "Full info on image"', 'woodmart' ),
			'name'  => 'product-loop-info',
			'file'  => '/css/parts/woo-product-loop-info',
		),
	),
	'product-loop-alt'                                          => array(
		array(
			'title' => esc_html__( 'Product loop "Icons and add to cart on hover"', 'woodmart' ),
			'name'  => 'product-loop-alt',
			'file'  => '/css/parts/woo-product-loop-alt',
		),
	),
	'product-loop-icons'                                        => array(
		array(
			'title' => esc_html__( 'Product loop "Icons on hover"', 'woodmart' ),
			'name'  => 'product-loop-icons',
			'file'  => '/css/parts/woo-product-loop-icons',
		),
	),
	'product-loop-quick'                                        => array(
		array(
			'title' => esc_html__( 'Product loop "Quick"', 'woodmart' ),
			'name'  => 'product-loop-quick',
			'file'  => '/css/parts/woo-product-loop-quick',
		),
	),
	'product-loop-base'                                         => array(
		array(
			'title' => esc_html__( 'Product loop "Show summary on hover"', 'woodmart' ),
			'name'  => 'product-loop-base',
			'file'  => '/css/parts/woo-product-loop-base',
		),
	),
	'product-loop-standard'                                     => array(
		array(
			'title' => esc_html__( 'Product loop "Standard button"', 'woodmart' ),
			'name'  => 'product-loop-standard',
			'file'  => '/css/parts/woo-product-loop-standard',
		),
	),
	'product-loop-tiled'                                        => array(
		array(
			'title' => esc_html__( 'Product loop "Tiled"', 'woodmart' ),
			'name'  => 'product-loop-tiled',
			'file'  => '/css/parts/woo-product-loop-tiled',
		),
	),
	'product-loop-fw-button'                                    => array(
		array(
			'title' => esc_html__( 'Product loop "Full width button"', 'woodmart' ),
			'name'  => 'product-loop-fw-button',
			'file'  => '/css/parts/woo-prod-loop-fw-button',
		),
	),
	'product-loop-list'                                         => array(
		array(
			'title' => esc_html__( 'Product loop "List"', 'woodmart' ),
			'name'  => 'product-loop-list',
			'file'  => '/css/parts/woo-product-loop-list',
		),
	),
	'select2'                                                   => array(
		array(
			'title' => esc_html__( 'Select2 library', 'woodmart' ),
			'name'  => 'select2',
			'file'  => '/css/parts/woo-lib-select2',
			'rtl'   => true,
		),
	),
	'woo-categories-loop'                                       => array(
		array(
			'title' => esc_html__( 'WooCommerce categories loop', 'woodmart' ),
			'name'  => 'woo-categories-loop',
			'file'  => '/css/parts/woo-categories-loop',
		),
	),
	'categories-loop-mask-subcat'                           => array(
		array(
			'title' => esc_html__( 'Categories design mask', 'woodmart' ),
			'name'  => 'categories-loop-mask-subcat',
			'file'  => '/css/parts/woo-categories-loop-mask-subcat',
		),
	),
	'categories-loop-zoom-out'                           => array(
		array(
			'title' => esc_html__( 'Categories design zoom out', 'woodmart' ),
			'name'  => 'categories-loop-zoom-out',
			'file'  => '/css/parts/woo-categories-loop-zoom-out',
		),
	),
	'categories-loop-side'                           => array(
		array(
			'title' => esc_html__( 'Categories design side', 'woodmart' ),
			'name'  => 'categories-loop-side',
			'file'  => '/css/parts/woo-categories-loop-side',
		),
	),
	'woo-categories-loop-layout-masonry'                        => array(
		array(
			'title' => esc_html__( 'Categories layout masonry or carousel', 'woodmart' ),
			'name'  => 'woo-categories-loop-layout-masonry',
			'file'  => '/css/parts/woo-categories-loop-layout-masonry',
		),
	),
	'categories-loop'                                           => array(
		array(
			'title' => esc_html__( 'Categories loop', 'woodmart' ),
			'name'  => 'categories-loop',
			'file'  => '/css/parts/woo-categories-loop-old',
		),
	),
	'categories-loop-default'                                   => array(
		array(
			'title' => esc_html__( 'Categories loop default', 'woodmart' ),
			'name'  => 'categories-loop-default',
			'file'  => '/css/parts/woo-categories-loop-default-old',
		),
	),
	'categories-loop-default-scheme-light'                             => array(
		array(
			'title' => esc_html__( 'Categories loop default with color scheme light', 'woodmart' ),
			'name'  => 'categories-loop-default-scheme-light',
			'file'  => '/css/parts/woo-categories-loop-default-old-scheme-light',
		),
	),
	'categories-loop-center'                                    => array(
		array(
			'title' => esc_html__( 'Categories loop center title', 'woodmart' ),
			'name'  => 'categories-loop-center',
			'file'  => '/css/parts/woo-categories-loop-center-old',
		),
	),
	'categories-loop-replace-title'                             => array(
		array(
			'title' => esc_html__( 'Categories loop replace title', 'woodmart' ),
			'name'  => 'categories-loop-replace-title',
			'file'  => '/css/parts/woo-categories-loop-replace-title-old',
		),
	),
	'woo-opt-title-limit'                                       => array(
		array(
			'title' => esc_html__( 'WooCommerce title limit', 'woodmart' ),
			'name'  => 'woo-opt-title-limit',
			'file'  => '/css/parts/woo-opt-title-limit',
		),
	),
	'woo-opt-quick-shop'                                        => array(
		array(
			'title' => esc_html__( 'WooCommerce quick shop', 'woodmart' ),
			'name'  => 'woo-opt-quick-shop',
			'file'  => '/css/parts/woo-opt-quick-shop',
		),
	),
	'woo-opt-quick-shop-2'                                      => array(
		array(
			'title' => esc_html__( 'WooCommerce quick shop 2', 'woodmart' ),
			'name'  => 'woo-opt-quick-shop-2',
			'file'  => '/css/parts/woo-opt-quick-shop-2',
		),
	),
	'woo-opt-quick-view'                                        => array(
		array(
			'title' => esc_html__( 'WooCommerce quick view', 'woodmart' ),
			'name'  => 'woo-opt-quick-view',
			'file'  => '/css/parts/woo-opt-quick-view',
		),
	),
	'woo-opt-demo-store'                                        => array(
		array(
			'title' => esc_html__( 'WooCommerce opt demo store', 'woodmart' ),
			'name'  => 'woo-opt-demo-store',
			'file'  => '/css/parts/woo-opt-demo-store',
		),
	),
	'woo-opt-coming-soon'                                    => array(
		array(
			'title' => esc_html__( 'WooCommerce opt coming soon', 'woodmart' ),
			'name'  => 'woo-opt-coming-soon',
			'file'  => '/css/parts/woo-opt-coming-soon',
		),
	),
	'woo-mod-add-btn-replace'                                   => array(
		array(
			'title' => esc_html__( 'WooCommerce add to cart button replace', 'woodmart' ),
			'name'  => 'woo-mod-add-btn-replace',
			'file'  => '/css/parts/woo-mod-add-btn-replace',
		),
	),
	'woo-mod-product-labels'                                    => array(
		array(
			'title' => esc_html__( 'WooCommerce product labels', 'woodmart' ),
			'name'  => 'woo-mod-product-labels',
			'file'  => '/css/parts/woo-mod-product-labels',
		),
	),
	'woo-mod-product-labels-rect'                               => array(
		array(
			'title' => esc_html__( 'WooCommerce product labels rect', 'woodmart' ),
			'name'  => 'woo-mod-product-labels-rect',
			'file'  => '/css/parts/woo-mod-product-labels-rect',
		),
	),
	'woo-mod-product-labels-round'                              => array(
		array(
			'title' => esc_html__( 'WooCommerce product labels round', 'woodmart' ),
			'name'  => 'woo-mod-product-labels-round',
			'file'  => '/css/parts/woo-mod-product-labels-round',
		),
	),
	'woo-mod-cart-labels'                                    => array(
		array(
			'title' => esc_html__( 'WooCommerce cart labels', 'woodmart' ),
			'name'  => 'woo-mod-cart-labels',
			'file'  => '/css/parts/woo-mod-cart-labels',
		),
	),
	'woo-mod-login-form'                                        => array(
		array(
			'title' => esc_html__( 'WooCommerce mod login form', 'woodmart' ),
			'name'  => 'woo-mod-login-form',
			'file'  => '/css/parts/woo-mod-login-form',
		),
	),
	'woo-page-login-register'                                   => array(
		array(
			'title' => esc_html__( 'WooCommerce page login register', 'woodmart' ),
			'name'  => 'woo-page-login-register',
			'file'  => '/css/parts/woo-page-login-register'
		),
	),
	'woo-opt-social-login'                                      => array(
		array(
			'title' => esc_html__( 'WooCommerce opt social login', 'woodmart' ),
			'name'  => 'woo-opt-social-login',
			'file'  => '/css/parts/woo-opt-social-login',
		),
	),
	'mod-star-rating'                                           => array(
		array(
			'title' => esc_html__( 'WooCommerce star rating mod', 'woodmart' ),
			'name'  => 'mod-star-rating',
			'file'  => '/css/parts/mod-star-rating',
		),
	),
	'mod-star-rating-style-simple'                              => array(
		array(
			'title' => esc_html__( 'WooCommerce star rating simple style mod', 'woodmart' ),
			'name'  => 'mod-star-rating-style-simple',
			'file'  => '/css/parts/mod-star-rating-style-simple',
		),
	),
	'woo-opt-hide-larger-price'                                 => array(
		array(
			'title' => esc_html__( 'WooCommerce hide larger price', 'woodmart' ),
			'name'  => 'woo-opt-hide-larger-price',
			'file'  => '/css/parts/woo-opt-hide-larger-price',
		),
	),
	'woo-single-prod-predefined'                                => array(
		array(
			'title' => esc_html__( 'WooCommerce single product predefined', 'woodmart' ),
			'name'  => 'woo-single-prod-predefined',
			'file'  => '/css/parts/woo-single-prod-predefined',
			'rtl'   => true,
		),
	),
	'woo-single-prod-and-quick-view-predefined'                 => array(
		array(
			'title' => esc_html__( 'WooCommerce single product predefined', 'woodmart' ),
			'name'  => 'woo-single-prod-and-quick-view-predefined',
			'file'  => '/css/parts/woo-single-prod-and-quick-view-predefined',
			'rtl'   => true,
		),
	),
	'woo-single-prod-el-tabs-predefined'                        => array(
		array(
			'title' => esc_html__( 'WooCommerce single product tabs predefined', 'woodmart' ),
			'name'  => 'woo-single-prod-el-tabs-predefined',
			'file'  => '/css/parts/woo-single-prod-el-tabs-predefined',
		),
	),
	'woo-single-prod-builder'                                   => array(
		array(
			'title' => esc_html__( 'WooCommerce single product builder', 'woodmart' ),
			'name'  => 'woo-single-prod-builder',
			'file'  => '/css/parts/woo-single-prod-builder',
		),
	),
	'woo-single-prod-el-add-to-cart-opt-design-justify-builder' => array(
		array(
			'title' => esc_html__( 'WooCommerce single product inline add to cart', 'woodmart' ),
			'name'  => 'woo-single-prod-el-add-to-cart-opt-design-justify-builder',
			'file'  => '/css/parts/woo-single-prod-el-add-to-cart-opt-design-justify-builder',
		),
	),
	'opt-carousel-disable'                                           => array(
		array(
			'title' => esc_html__( 'WooCommerce disable owl', 'woodmart' ),
			'name'  => 'opt-carousel-disable',
			'file'  => '/css/parts/opt-carousel-disable',
			'rtl'   => true,
		),
	),
	'woo-el-breadcrumbs-builder'                                        => array(
		array(
			'title' => esc_html__( 'WooCommerce breadcrumbs', 'woodmart' ),
			'name'  => 'woo-el-breadcrumbs-builder',
			'file'  => '/css/parts/woo-el-breadcrumbs-builder',
			'rtl'   => true,
		),
	),
	// Base.
	'page-title'                                                => array(
		array(
			'title' => esc_html__( 'Page title', 'woodmart' ),
			'name'  => 'page-title',
			'file'  => '/css/parts/page-title',
		),
	),
	// 'blog-base'                                                 => array(
	// 	array(
	// 		'title' => esc_html__( 'Blog base', 'woodmart' ),
	// 		'name'  => 'blog-base',
	// 		'file'  => '/css/parts/blog-base',
	// 		'rtl'   => true,
	// 	),
	// ),
	'portfolio-base'                                            => array(
		array(
			'title' => esc_html__( 'Portfolio base', 'woodmart' ),
			'name'  => 'portfolio-base',
			'file'  => '/css/parts/portfolio-base',
			'rtl'   => true,
		),
	),
	'page-404'                                                  => array(
		array(
			'title' => esc_html__( 'Page 404', 'woodmart' ),
			'name'  => 'page-404',
			'file'  => '/css/parts/page-404',
		),
	),
	'page-search-results'                                       => array(
		array(
			'title' => esc_html__( 'Search page', 'woodmart' ),
			'name'  => 'page-search-results',
			'file'  => '/css/parts/page-search-results',
			'rtl'   => true,
		),
	),
	// Options.
	'collapsible-content'                                       => array(
		array(
			'title'    => esc_html__( 'Collapsible content', 'woodmart' ),
			'name'     => 'collapsible-content',
			'file'     => '/css/parts/elem-opt-collapsible-content',
			'wpb_file' => '/css/parts/wpb-opt-collapsible-content',
		),
	),
	'age-verify'                                                => array(
		array(
			'title' => esc_html__( 'Age verify option', 'woodmart' ),
			'name'  => 'age-verify',
			'file'  => '/css/parts/opt-age-verify',
		),
	),
	'bottom-toolbar'                                            => array(
		array(
			'title' => esc_html__( 'Button navbar option', 'woodmart' ),
			'name'  => 'bottom-toolbar',
			'file'  => '/css/parts/opt-bottom-toolbar',
			'rtl'   => true,
		),
	),
	'mod-tools'                                                => array(
		array(
			'title' => esc_html__( 'Module tools', 'woodmart' ),
			'name'  => 'mod-tools',
			'file'  => '/css/parts/mod-tools',
		),
	),
	'cookies-popup'                                             => array(
		array(
			'title' => esc_html__( 'Cookies popup option', 'woodmart' ),
			'name'  => 'cookies-popup',
			'file'  => '/css/parts/opt-cookies',
		),
	),
	'header-banner'                                             => array(
		array(
			'title' => esc_html__( 'Header banner option', 'woodmart' ),
			'name'  => 'header-banner',
			'file'  => '/css/parts/opt-header-banner',
		),
	),
	'lazy-loading'                                              => array(
		array(
			'title' => esc_html__( 'Lazy loading option', 'woodmart' ),
			'name'  => 'lazy-loading',
			'file'  => '/css/parts/opt-lazy-load',
		),
	),
	'off-canvas-sidebar'                                        => array(
		array(
			'title' => esc_html__( 'Off canvas sidebar option', 'woodmart' ),
			'name'  => 'off-canvas-sidebar',
			'file'  => '/css/parts/opt-off-canvas-sidebar',
		),
	),
	'shop-off-canvas-sidebar'                                        => array(
		array(
			'title' => esc_html__( 'Off canvas sidebar on shop page option', 'woodmart' ),
			'name'  => 'shop-off-canvas-sidebar',
			'file'  => '/css/parts/opt-shop-off-canvas-sidebar',
		),
	),
	'helpers-wpb-elem'                                                => array(
		array(
			'title' => esc_html__( 'Helper classes for WPB and Elementor builders', 'woodmart' ),
			'name'  => 'helpers-wpb-elem',
			'file'  => '/css/parts/helpers-wpb-elem',
		),
	),
	'scroll-top'                                                => array(
		array(
			'title' => esc_html__( 'Scroll to top option', 'woodmart' ),
			'name'  => 'scroll-top',
			'file'  => '/css/parts/opt-scrolltotop',
			'rtl'   => true,
		),
	),
	'sticky-social-buttons'                                     => array(
		array(
			'title' => esc_html__( 'Sticky social buttons option', 'woodmart' ),
			'name'  => 'sticky-social-buttons',
			'file'  => '/css/parts/opt-sticky-social',
			'rtl'   => true,
		),
	),
	'opt-form-underline'                                        => array(
		array(
			'title' => esc_html__( 'Form underline option', 'woodmart' ),
			'name'  => 'opt-form-underline',
			'file'  => '/css/parts/opt-form-underline',
		),
	),
	'project-text-hover'                                        => array(
		array(
			'title' => esc_html__( 'Portfolio style option text hover', 'woodmart' ),
			'name'  => 'project-text-hover',
			'file'  => '/css/parts/project-text-hover',
		),
	),
	'project-alt'                                               => array(
		array(
			'title' => esc_html__( 'Portfolio style option alternative', 'woodmart' ),
			'name'  => 'project-alt',
			'file'  => '/css/parts/project-alt',
		),
	),
	'project-under'                                             => array(
		array(
			'title' => esc_html__( 'Portfolio style option text under image', 'woodmart' ),
			'name'  => 'project-under',
			'file'  => '/css/parts/project-under',
		),
	),
	'project-parallax'                                          => array(
		array(
			'title' => esc_html__( 'Portfolio style option parallax', 'woodmart' ),
			'name'  => 'project-parallax',
			'file'  => '/css/parts/project-parallax',
		),
	),
	// Libraries.
	'justified'                                                 => array(
		array(
			'title' => esc_html__( 'Justified gallery library', 'woodmart' ),
			'name'  => 'justified',
			'file'  => '/css/parts/lib-justified-gallery',
			'rtl'   => true,
		),
	),
	'mfp-popup'                                                 => array(
		array(
			'title' => esc_html__( 'Magnific popup library', 'woodmart' ),
			'name'  => 'mfp-popup',
			'file'  => '/css/parts/lib-magnific-popup',
			'rtl'   => true,
		),
	),
	'swiper'                                              => array(
		array(
			'title' => esc_html__( 'Swiper carousel library', 'woodmart' ),
			'name'  => 'swiper',
			'file'  => '/css/parts/lib-swiper',
			'rtl'   => true,
		),
	),
	'swiper-arrows'                                              => array(
		array(
			'title' => esc_html__( 'Carousel arrows style', 'woodmart' ),
			'name'  => 'swiper-arrows',
			'file'  => '/css/parts/lib-swiper-arrows',
			'rtl'   => true,
		),
	),
	'swiper-pagin'                                              => array(
		array(
			'title' => esc_html__( 'Carousel pagination', 'woodmart' ),
			'name'  => 'swiper-pagin',
			'file'  => '/css/parts/lib-swiper-pagin',
		),
	),
	'swiper-scrollbar'                                      => array(
		array(
			'title' => esc_html__( 'Carousel scrollbar', 'woodmart' ),
			'name'  => 'swiper-scrollbar',
			'file'  => '/css/parts/lib-swiper-scrollbar',
		),
	),
	'photoswipe'                                                => array(
		array(
			'title' => esc_html__( 'Photoswipe library', 'woodmart' ),
			'name'  => 'photoswipe',
			'file'  => '/css/parts/lib-photoswipe',
			'rtl'   => true,
		),
	),
	// Integrations.
	'wpbakery-base'                                             => array(
		array(
			'title' => esc_html__( 'WPBakery integration', 'woodmart' ),
			'name'  => 'wpbakery-base',
			'file'  => '/css/parts/int-wpb-base',
			'rtl'   => true,
		),
	),
	'wpbakery-base-deprecated'                                  => array(
		array(
			'title' => esc_html__( 'WPBakery integration (deprecated styles', 'woodmart' ),
			'name'  => 'wpbakery-base-deprecated',
			'file'  => '/css/parts/int-wpb-base-deprecated',
		),
	),
	'base-deprecated'                                           => array(
		array(
			'title' => esc_html__( 'Base (deprecated styles)', 'woodmart' ),
			'name'  => 'base-deprecated',
			'file'  => '/css/parts/base-deprecated',
		),
	),
	'elementor-base'                                            => array(
		array(
			'title' => esc_html__( 'Elementor integration', 'woodmart' ),
			'name'  => 'elementor-base',
			'file'  => '/css/parts/int-elem-base',
			'rtl'   => true,
		),
	),
	'elementor-pro-base'                                        => array(
		array(
			'title' => esc_html__( 'Elementor Pro integration', 'woodmart' ),
			'name'  => 'elementor-pro-base',
			'file'  => '/css/parts/int-elementor-pro',
			'rtl'   => true,
		),
	),
	'advanced-nocaptcha'                                        => array(
		array(
			'title' => esc_html__( 'Advanced Nocaptcha integration', 'woodmart' ),
			'name'  => 'advanced-nocaptcha',
			'file'  => '/css/parts/int-advanced-nocaptcha',
		),
	),
	'bbpress'                                                   => array(
		array(
			'title' => esc_html__( 'BBPress integration', 'woodmart' ),
			'name'  => 'bbpress',
			'file'  => '/css/parts/int-bbpress',
		),
	),
	'amelia'                                                   => array(
		array(
			'title' => esc_html__( 'Amelia integration', 'woodmart' ),
			'name'  => 'amelia',
			'file'  => '/css/parts/int-amelia',
		),
	),
	'wpcf7'                                                     => array(
		array(
			'title' => esc_html__( 'Contacts form 7 integration', 'woodmart' ),
			'name'  => 'wpcf7',
			'file'  => '/css/parts/int-wpcf7',
		),
	),
	'woo-curr-switch'                                           => array(
		array(
			'title' => esc_html__( 'WC currency switcher integration', 'woodmart' ),
			'name'  => 'woo-curr-switch',
			'file'  => '/css/parts/int-woo-curr-switch',
		),
	),
	'woo-dokan-vend'                                            => array(
		array(
			'title' => esc_html__( 'Dokan integration', 'woodmart' ),
			'name'  => 'woo-dokan-vend',
			'file'  => '/css/parts/int-woo-dokan-vend',
		),
	),
	'woo-extra-prod-opt'                                        => array(
		array(
			'title' => esc_html__( 'Extra product options For WooCommerce integration', 'woodmart' ),
			'name'  => 'woo-extra-prod-opt',
			'file'  => '/css/parts/int-woo-extra-prod-opt',
		),
	),
	'woo-germanized'                                            => array(
		array(
			'title' => esc_html__( 'Germanized integration', 'woodmart' ),
			'name'  => 'woo-germanized',
			'file'  => '/css/parts/int-woo-germanized',
		),
	),
	'mc4wp'                                                     => array(
		array(
			'title' => esc_html__( 'Mailchimp for wordpress integration', 'woodmart' ),
			'name'  => 'mc4wp',
			'file'  => '/css/parts/int-mc4wp',
		),
	),
	'mc4wp-deprecated'                                          => array(
		array(
			'title' => esc_html__( 'Mailchimp for wordpress integration (deprecated styles)', 'woodmart' ),
			'name'  => 'mc4wp-deprecated',
			'file'  => '/css/parts/int-mc4wp-deprecated',
		),
	),
	'revolution-slider'                                         => array(
		array(
			'title' => esc_html__( 'Slider Revolution integration', 'woodmart' ),
			'name'  => 'revolution-slider',
			'file'  => '/css/parts/int-rev-slider',
		),
	),
	'woo-stripe'                                                => array(
		array(
			'title' => esc_html__( 'Stripe integration', 'woodmart' ),
			'name'  => 'woo-stripe',
			'file'  => '/css/parts/int-woo-stripe',
			'rtl'   => true,
		),
	),
	'woo-klarna'                                                => array(
		array(
			'title' => esc_html__( 'Klarna integration', 'woodmart' ),
			'name'  => 'woo-klarna',
			'file'  => '/css/parts/int-woo-klarna',
		),
	),
	'int-woo-subscriptions'                                              => array(
		array(
			'title' => esc_html__( 'WooCommerce Subscription integration', 'woodmart' ),
			'name'  => 'int-woo-subscriptions',
			'file'  => '/css/parts/int-woo-subscriptions',
		),
	),
	'woo-payments'                                              => array(
		array(
			'title' => esc_html__( 'WooCommerce Payments integration', 'woodmart' ),
			'name'  => 'woo-payments',
			'file'  => '/css/parts/int-woo-payments',
			'rtl'   => true,
		),
	),
	'woo-paypal-payments'                                       => array(
		array(
			'title' => esc_html__( 'Paypal Payments integration', 'woodmart' ),
			'name'  => 'woo-paypal-payments',
			'file'  => '/css/parts/int-woo-paypal-payments',
		),
	),
	'woo-payment-plugin-stripe'                                                => array(
		array(
			'title' => esc_html__( 'Payment plugins for stripe integration', 'woodmart' ),
			'name'  => 'woo-payment-plugin-stripe',
			'file'  => '/css/parts/int-woo-payment-plugin-stripe',
		),
	),
	'woo-payment-plugin-paypal'                                                => array(
		array(
			'title' => esc_html__( 'Payment plugins for paypal integration', 'woodmart' ),
			'name'  => 'woo-payment-plugin-paypal',
			'file'  => '/css/parts/int-woo-payment-plugin-paypal',
		),
	),
	'woo-wcfm-fm'                                               => array(
		array(
			'title' => esc_html__( 'WCFM – Frontend Manager integration', 'woodmart' ),
			'name'  => 'woo-wcfm-fm',
			'file'  => '/css/parts/int-woo-wcfm-vend',
		),
	),
	'woo-multivendorx'                                          => array(
		array(
			'title' => esc_html__( 'Multivendorx integration', 'woodmart' ),
			'name'  => 'woo-multivendorx',
			'file'  => '/css/parts/int-woo-multivendorx-vend',
		),
	),
	'woo-wc-vendors'                                            => array(
		array(
			'title' => esc_html__( 'WC Vendors integration', 'woodmart' ),
			'name'  => 'woo-wc-vendors',
			'file'  => '/css/parts/int-woo-wc-vend',
		),
	),
	'wpml'                                                      => array(
		array(
			'title' => esc_html__( 'WPML integration', 'woodmart' ),
			'name'  => 'wpml',
			'file'  => '/css/parts/int-wpml',
			'rtl'   => true,
		),
	),
	'int-woo-fpd'                                                      => array(
		array(
			'title' => esc_html__( 'Fancy Product Designer integration', 'woodmart' ),
			'name'  => 'int-woo-fpd',
			'file'  => '/css/parts/int-woo-fpd',
		),
	),
	'int-wordfence'                                                      => array(
		array(
			'title' => esc_html__( 'Wordfence integration', 'woodmart' ),
			'name'  => 'int-wordfence',
			'file'  => '/css/parts/int-wordfence',
		),
	),
	'woo-yith-compare'                                          => array(
		array(
			'title' => esc_html__( 'YITH Compare integration', 'woodmart' ),
			'name'  => 'woo-yith-compare',
			'file'  => '/css/parts/int-woo-yith-compare',
		),
	),
	'woo-yith-vendor'                                           => array(
		array(
			'title' => esc_html__( 'YITH Vendor integration', 'woodmart' ),
			'name'  => 'woo-yith-vendor',
			'file'  => '/css/parts/int-woo-yith-vend',
		),
	),
	'woo-yith-req-quote'                                        => array(
		array(
			'title' => esc_html__( 'YITH Request Quote integration', 'woodmart' ),
			'name'  => 'woo-yith-req-quote',
			'file'  => '/css/parts/int-woo-yith-request-quote',
		),
	),
	'woo-yith-wishlist'                                         => array(
		array(
			'title' => esc_html__( 'YITH Wishlist integration', 'woodmart' ),
			'name'  => 'woo-yith-wishlist',
			'file'  => '/css/parts/int-woo-yith-wishlist',
		),
	),
	'int-woo-cartflows-checkout'                                => array(
		array(
			'title' => esc_html__( 'Cartflows integration', 'woodmart' ),
			'name'  => 'int-woo-cartflows-checkout',
			'file'  => '/css/parts/int-woo-cartflows-checkout',
		),
	),
	// Elements options.
	'product-arrows'                                            => array(
		array(
			'title' => esc_html__( 'Product arrows', 'woodmart' ),
			'name'  => 'product-arrows',
			'file'  => '/css/parts/el-opt-product-arrows',
		),
	),
	'highlighted-product'                                       => array(
		array(
			'title' => esc_html__( 'Highlighted product', 'woodmart' ),
			'name'  => 'highlighted-product',
			'file'  => '/css/parts/el-opt-highlight-product',
			'rtl'   => true,
		),
	),
	'mod-animations-keyframes'                                   => array(
		array(
			'title'    => esc_html__( 'Element animations', 'woodmart' ),
			'name'     => 'mod-animations-keyframes',
			'file'     => '/css/parts/mod-animations-keyframes',
			'wpb_file' => '/css/parts/int-wbp-el-animations',
		),
	),
	'mod-highlighted-text'                                      => array(
		array(
			'title' => esc_html__( 'Element highlighted text', 'woodmart' ),
			'name'  => 'mod-highlighted-text',
			'file'  => '/css/parts/mod-highlighted-text',
		),
	),
	'int-elem-opt-off-canvas-column'                            => array(
		array(
			'title' => esc_html__( 'Element option off canvas column (Elementor)', 'woodmart' ),
			'name'  => 'int-elem-opt-off-canvas-column',
			'file'  => '/css/parts/int-elem-opt-off-canvas-column',
		),
	),
	'int-elem-opt-sticky-column'                                              => array(
		array(
			'title' => esc_html__( 'Element option sticky column (Elementor)', 'woodmart' ),
			'name'  => 'int-elem-opt-sticky-column',
			'file'  => '/css/parts/int-elem-opt-sticky-column',
		),
	),
	'int-wpb-opt-off-canvas-column'                             => array(
		array(
			'title' => esc_html__( 'Element option off canvas column (WPBakery)', 'woodmart' ),
			'name'  => 'int-wpb-opt-off-canvas-column',
			'file'  => '/css/parts/int-wpb-opt-off-canvas-column',
		),
	),
	'el-off-canvas-column-btn'                                  => array(
		array(
			'title' => esc_html__( 'Off canvas column btn', 'woodmart' ),
			'name'  => 'el-off-canvas-column-btn',
			'file'  => '/css/parts/el-off-canvas-column-btn',
		),
	),
	'mod-sticky-sidebar-opener'                                 => array(
		array(
			'title' => esc_html__( 'Off canvas column btn mod sticky sidebar opener', 'woodmart' ),
			'name'  => 'mod-sticky-sidebar-opener',
			'file'  => '/css/parts/mod-sticky-sidebar-opener',
		),
	),
	// Elements.
	'el-subtitle-style'                                                      => array(
		array(
			'title' => esc_html__( 'Element subtitle style', 'woodmart' ),
			'name'  => 'el-subtitle-style',
			'file'  => '/css/parts/el-subtitle-style',
		),
	),
	'tabs'                                                      => array(
		array(
			'title' => esc_html__( 'Tabs general', 'woodmart' ),
			'name'  => 'tabs',
			'file'  => '/css/parts/el-tabs',
			'rtl'   => true,
		),
	),
	'accordion'                                                 => array(
		array(
			'title' => esc_html__( 'Accordion general', 'woodmart' ),
			'name'  => 'accordion',
			'file'  => '/css/parts/el-accordion',
		),
	),
	'accordion-elem-wpb'                                                 => array(
		array(
			'title' => esc_html__( 'Accordion element', 'woodmart' ),
			'name'  => 'accordion-elem-wpb',
			'file'  => '/css/parts/el-accordion-wpb-elem',
			'rtl'   => true,
		),
	),
	'block-accordion'                                                 => array(
		array(
			'title' => esc_html__( 'Accordion block', 'woodmart' ),
			'name'  => 'block-accordion',
			'file'  => '/css/parts/el-accordion-block',
		),
	),
	'el-compare-img'                                             => array(
		array(
			'title' => esc_html__( 'Compare images', 'woodmart' ),
			'name'  => 'el-compare-img',
			'file'  => '/css/parts/el-compare-img',
		),
	),
	'360degree'                                                 => array(
		array(
			'title' => esc_html__( '360 element', 'woodmart' ),
			'name'  => '360degree',
			'file'  => '/css/parts/el-360deg',
			'rtl'   => true,
		),
	),
	'banner'                                                    => array(
		array(
			'title'    => esc_html__( 'Banner element', 'woodmart' ),
			'name'     => 'banner',
			'file'     => '/css/parts/el-banner',
			'wpb_file' => '/css/parts/wpb-el-banner',
		),
	),
	'banner-hover-bg-and-border'                                => array(
		array(
			'title' => esc_html__( 'Banner element with border and background hover effect', 'woodmart' ),
			'name'  => 'banner-hover-bg-and-border',
			'file'  => '/css/parts/el-banner-hover-bg-and-border',
		),
	),
	'banner-hover-zoom'                                         => array(
		array(
			'title' => esc_html__( 'Banner element with hover effect', 'woodmart' ),
			'name'  => 'banner-hover-zoom',
			'file'  => '/css/parts/el-banner-hover-zoom',
		),
	),
	'banner-style-mask-and-shadow'                              => array(
		array(
			'title' => esc_html__( 'Banner element with style color mask and mask with shadow', 'woodmart' ),
			'name'  => 'banner-style-mask-and-shadow',
			'file'  => '/css/parts/el-banner-style-mask-and-shadow',
		),
	),
	'banner-style-bg-and-border'                                => array(
		array(
			'title'    => esc_html__( 'Banner element with style bordered and bordered background', 'woodmart' ),
			'name'     => 'banner-style-bg-and-border',
			'file'     => '/css/parts/el-banner-style-bg-and-border',
		),
	),
	'banner-style-bg-cont'                                      => array(
		array(
			'title' => esc_html__( 'Banner element with style content background', 'woodmart' ),
			'name'  => 'banner-style-bg-cont',
			'file'  => '/css/parts/el-banner-style-bg-cont',
		),
	),
	'banner-btn-hover'                                          => array(
		array(
			'title' => esc_html__( 'Banner element with button position show on hover', 'woodmart' ),
			'name'  => 'banner-btn-hover',
			'file'  => '/css/parts/el-banner-btn-hover',
		),
	),
	'countdown'                                                 => array(
		array(
			'title' => esc_html__( 'Countdown element', 'woodmart' ),
			'name'  => 'countdown',
			'file'  => '/css/parts/el-countdown-timer',
			'rtl'   => true,
		),
	),
	'button'                                                   => array(
		array(
			'title' => esc_html__( 'Button element', 'woodmart' ),
			'name'  => 'button',
			'file'  => '/css/parts/el-button',
		),
	),
	'counter'                                                   => array(
		array(
			'title' => esc_html__( 'Counter element', 'woodmart' ),
			'name'  => 'counter',
			'file'  => '/css/parts/el-counter',
		),
	),
	'image-gallery'                                             => array(
		array(
			'title' => esc_html__( 'Image gallery element', 'woodmart' ),
			'name'  => 'image-gallery',
			'file'  => '/css/parts/el-gallery',
		),
	),
	'image-hotspot'                                             => array(
		array(
			'title' => esc_html__( 'Image hotspot element', 'woodmart' ),
			'name'  => 'image-hotspot',
			'file'  => '/css/parts/el-hotspot',
		),
	),
	'info-box'                                                  => array(
		array(
			'title' => esc_html__( 'Info box element', 'woodmart' ),
			'name'  => 'info-box',
			'file'  => '/css/parts/el-info-box',
			'rtl'   => true,
		),
	),
	'info-box-btn-hover'                                        => array(
		array(
			'title' => esc_html__( 'Info box element with button position "Show on hover"', 'woodmart' ),
			'name'  => 'info-box-btn-hover',
			'file'  => '/css/parts/el-info-box-btn-hover',
		),
	),
	'info-box-style-brd'                                        => array(
		array(
			'title' => esc_html__( 'Info box element with style "Bordered"', 'woodmart' ),
			'name'  => 'info-box-style-brd',
			'file'  => '/css/parts/el-info-box-style-brd',
		),
	),
	'info-box-style-shadow-and-bg-hover'                        => array(
		array(
			'title' => esc_html__( 'Info box element with style "Shadow", "Background on hover"', 'woodmart' ),
			'name'  => 'info-box-style-shadow-and-bg-hover',
			'file'  => '/css/parts/el-info-box-style-shadow-and-bg-hover',
		),
	),
	'el-menu'                                      => array(
		array(
			'title' => esc_html__( 'Menu element', 'woodmart' ),
			'name'  => 'el-menu',
			'file'  => '/css/parts/el-menu',
		),
	),
	'el-menu-wpb-elem'                                      => array(
		array(
			'title' => esc_html__( 'Menu element for WPB or Elementor page builder', 'woodmart' ),
			'name'  => 'el-menu-wpb-elem',
			'file'  => '/css/parts/el-menu-wpb-elem',
		),
	),
	'instagram'                                                 => array(
		array(
			'title' => esc_html__( 'Instagram element', 'woodmart' ),
			'name'  => 'instagram',
			'file'  => '/css/parts/el-instagram',
		),
	),
	'list'                                                      => array(
		array(
			'title' => esc_html__( 'List general', 'woodmart' ),
			'name'  => 'list',
			'file'  => '/css/parts/el-list',
			'rtl'   => true,
		),
	),
	'el-list'                                                 => array(
		array(
			'title' => esc_html__( 'List element', 'woodmart' ),
			'name'  => 'el-list',
			'file'  => '/css/parts/el-list-wpb-elem',
		),
	),
	'map'                                                       => array(
		array(
			'title' => esc_html__( 'Google maps element', 'woodmart' ),
			'name'  => 'map',
			'file'  => '/css/parts/el-map',
		),
	),
	'el-google-map'                                             => array(
		array(
			'title' => esc_html__( 'Google map element', 'woodmart' ),
			'name'  => 'el-google-map',
			'file'  => '/css/parts/el-google-map',
		),
	),
	'el-open-street-map'                                        => array(
		array(
			'title' => esc_html__( 'Open street map element', 'woodmart' ),
			'name'  => 'el-open-street-map',
			'file'  => '/css/parts/el-open-street-map',
		),
	),
	'menu-price'                                                => array(
		array(
			'title' => esc_html__( 'Menu price element', 'woodmart' ),
			'name'  => 'menu-price',
			'file'  => '/css/parts/el-menu-price',
		),
	),
	'pricing-table'                                             => array(
		array(
			'title' => esc_html__( 'Pricing table element', 'woodmart' ),
			'name'  => 'pricing-table',
			'file'  => '/css/parts/el-pricing-table',
			'rtl'   => true,
		),
	),
	'el-page-title-builder'                                     => array(
		array(
			'title' => esc_html__( 'Element page title builder', 'woodmart' ),
			'name'  => 'el-page-title-builder',
			'file'  => '/css/parts/el-page-title-builder',
		),
	),
	'responsive-text'                                           => array(
		array(
			'title' => esc_html__( 'Responsive text element', 'woodmart' ),
			'name'  => 'responsive-text',
			'file'  => '/css/parts/el-responsive-text',
		),
	),
	'text-block'                                                => array(
		array(
			'title' => esc_html__( 'Text block element', 'woodmart' ),
			'name'  => 'text-block',
			'file'  => '/css/parts/el-text-block',
		),
	),
	'dividers'                                                  => array(
		array(
			'title' => esc_html__( 'Dividers element', 'woodmart' ),
			'name'  => 'dividers',
			'file'  => '/css/parts/el-row-divider',
		),
	),
	'section-title'                                             => array(
		array(
			'title' => esc_html__( 'Section title element', 'woodmart' ),
			'name'  => 'section-title',
			'file'  => '/css/parts/el-section-title',
			'rtl'   => true,
		),
	),
	'section-title-style-simple-and-brd'                        => array(
		array(
			'title' => esc_html__( 'Section title element with style: "Simple", "Bordered"', 'woodmart' ),
			'name'  => 'section-title-style-simple-and-brd',
			'file'  => '/css/parts/el-section-title-style-simple-and-brd',
			'rtl'   => true,
		),
	),
	'section-title-style-under-and-over'                        => array(
		array(
			'title' => esc_html__( 'Section title element with style: "Underline", "Underline 2", "Overline"', 'woodmart' ),
			'name'  => 'section-title-style-under-and-over',
			'file'  => '/css/parts/el-section-title-style-under-and-over',
		),
	),
	'slider'                                                    => array(
		array(
			'title' => esc_html__( 'Slider element', 'woodmart' ),
			'name'  => 'slider',
			'file'  => '/css/parts/el-slider',
		),
	),
	'block-slider'                                                    => array(
		array(
			'title' => esc_html__( 'Slider block', 'woodmart' ),
			'name'  => 'block-slider',
			'file'  => '/css/parts/el-slider-block',
			'rtl'   => true,
		),
	),
	'slider-arrows'                                             => array(
		array(
			'title' => esc_html__( 'Slider element with arrows', 'woodmart' ),
			'name'  => 'slider-arrows',
			'file'  => '/css/parts/el-slider-arrows',
			'rtl'   => true,
		),
	),
	'slider-dots-style-2'                                              => array(
		array(
			'title' => esc_html__( 'Slider element with pagination style 2', 'woodmart' ),
			'name'  => 'slider-dots-style-2',
			'file'  => '/css/parts/el-slider-dots-style-2',
		),
	),
	'slider-dots-style-3'                                       => array(
		array(
			'title' => esc_html__( 'Slider element with pagination style 3', 'woodmart' ),
			'name'  => 'slider-dots-style-3',
			'file'  => '/css/parts/el-slider-dots-style-3',
		),
	),
	'slider-anim-distortion'                                    => array(
		array(
			'title' => esc_html__( 'Slider element with slide animation: "Distortion"', 'woodmart' ),
			'name'  => 'slider-anim-distortion',
			'file'  => '/css/parts/el-slider-anim-distortion',
		),
	),
	'social-icons'                                              => array(
		array(
			'title' => esc_html__( 'Social icons element', 'woodmart' ),
			'name'  => 'social-icons',
			'file'  => '/css/parts/el-social-icons',
		),
	),
	'social-icons-styles'                                              => array(
		array(
			'title' => esc_html__( 'Social icons styles', 'woodmart' ),
			'name'  => 'social-icons-styles',
			'file'  => '/css/parts/el-social-styles',
		),
	),
	'marquee'                                                   => array(
		array(
			'title' => esc_html__( 'Marquee', 'woodmart' ),
			'name'  => 'marquee',
			'file'  => '/css/parts/el-marquee',
			'rtl'   => true,
		),
	),
	'team-member'                                               => array(
		array(
			'title' => esc_html__( 'Team member element', 'woodmart' ),
			'name'  => 'team-member',
			'file'  => '/css/parts/el-team-member',
		),
	),
	'testimonial'                                               => array(
		array(
			'title' => esc_html__( 'Testimonial element', 'woodmart' ),
			'name'  => 'testimonial',
			'file'  => '/css/parts/el-testimonial',
			'rtl'   => true,
		),
	),
	'testimonial-old'                                           => array(
		array(
			'title' => esc_html__( 'Testimonial old element', 'woodmart' ),
			'name'  => 'testimonial-old',
			'file'  => '/css/parts/el-testimonial-old',
			'rtl'   => true,
		),
	),
	'timeline'                                                  => array(
		array(
			'title' => esc_html__( 'Timeline element', 'woodmart' ),
			'name'  => 'timeline',
			'file'  => '/css/parts/el-timeline',
			'rtl'   => true,
		),
	),
	'twitter'                                                   => array(
		array(
			'title' => esc_html__( 'X (Twitter) element', 'woodmart' ),
			'name'  => 'twitter',
			'file'  => '/css/parts/el-twitter',
		),
	),
	'el-product-filters'                                        => array(
		array(
			'title' => esc_html__( 'Product filters element', 'woodmart' ),
			'name'  => 'el-product-filters',
			'file'  => '/css/parts/el-product-filters',
		),
	),
	'el-table'                                                  => array(
		array(
			'title' => esc_html__( 'Table element', 'woodmart' ),
			'name'  => 'el-table',
			'file'  => '/css/parts/el-table',
		),
	),
	'el-video'                                                  => array(
		array(
			'title' => esc_html__( 'Video element', 'woodmart' ),
			'name'  => 'el-video',
			'file'  => '/css/parts/el-video',
		),
	),
	'el-toggle'                                                  => array(
		array(
			'title' => esc_html__( 'Toggle element', 'woodmart' ),
			'name'  => 'el-toggle',
			'file'  => '/css/parts/el-toggle',
			'wpb_file' => '/css/parts/wpb-el-toggle',
			'rtl'   => true,
		),
	),
	'widget-collapse'                                           => array(
		array(
			'title' => esc_html__( 'Widget collapse', 'woodmart' ),
			'name'  => 'widget-collapse',
			'file'  => '/css/parts/opt-widget-collapse',
		),
	),
	'filter-search'                                             => array(
		array(
			'title' => esc_html__( 'Filters search', 'woodmart' ),
			'name'  => 'filter-search',
			'file'  => '/css/parts/mod-filter-search',
			'rtl'   => true,
		),
	),
	'popular-requests'                                          => array(
		array(
			'title' => esc_html__( 'Search popular requests', 'woodmart' ),
			'name'  => 'popular-requests',
			'file'  => '/css/parts/opt-popular-requests',
		),
	),
	'search-history'                                         => array(
		array(
			'title' => esc_html__( 'Search history', 'woodmart' ),
			'name'  => 'opt-search-history',
			'file'  => '/css/parts/opt-search-history',
		),
	),
	'dropdown-aside'                                            => array(
		array(
			'title' => esc_html__( 'Dropdown aside', 'woodmart' ),
			'name'  => 'dropdown-aside',
			'file'  => '/css/parts/mod-dropdown-aside',
			'rtl'   => true,
		),
	),
	'dropdown-full-height'                                      => array(
		array(
			'title' => esc_html__( 'Dropdown full-height', 'woodmart' ),
			'name'  => 'dropdown-full-height',
			'file'  => '/css/parts/mod-dropdown-full-height',
		),
	),
	'header-mod-content-calc'                                   => array(
		array(
			'title' => esc_html__( 'Content calculation', 'woodmart' ),
			'name'  => 'header-mod-content-calc',
			'file'  => '/css/parts/header-mod-content-calc',
		),
	),
	'sticky-nav'                                                => array(
		array(
			'title' => esc_html__( 'Sticky navigation', 'woodmart' ),
			'name'  => 'sticky-nav',
			'file'  => '/css/parts/opt-sticky-nav',
			'rtl'   => true,
		),
	),
	'wp-blocks'                                                => array(
		array(
			'title' => esc_html__( 'Default wordpress blocks style', 'woodmart' ),
			'name'  => 'wp-blocks',
			'file'  => '/css/parts/wp-blocks',
		),
	),
	'block-animation'                                                => array(
		array(
			'title' => esc_html__( 'Block animation option', 'woodmart' ),
			'name'  => 'block-animation',
			'file'  => '/css/parts/block-opt-animation',
		),
	),
	'block-opt-sticky'                                                => array(
		array(
			'title' => esc_html__( 'Block sticky option', 'woodmart' ),
			'name'  => 'block-opt-sticky',
			'file'  => '/css/parts/block-opt-sticky',
		),
	),
	'block-transform'                                                => array(
		array(
			'title' => esc_html__( 'Block transform option', 'woodmart' ),
			'name'  => 'block-transform',
			'file'  => '/css/parts/block-opt-transform',
		),
	),
	'block-shape-divider'                                                => array(
		array(
			'title' => esc_html__( 'Block shape divider option', 'woodmart' ),
			'name'  => 'block-shape-divider',
			'file'  => '/css/parts/block-opt-shape-divider',
		),
	),
	'block-background'                                                => array(
		array(
			'title' => esc_html__( 'Block background option', 'woodmart' ),
			'name'  => 'block-background',
			'file'  => '/css/parts/block-opt-background',
		),
	),
	'block-layout'                                                => array(
		array(
			'title' => esc_html__( 'Row and column block', 'woodmart' ),
			'name'  => 'block-layout',
			'file'  => '/css/parts/block-layout',
		),
	),
	'block-title'                                                => array(
		array(
			'title' => esc_html__( 'Title block', 'woodmart' ),
			'name'  => 'block-title',
			'file'  => '/css/parts/block-title',
		),
	),
	'block-title-style'                                          => array(
		array(
			'title' => esc_html__( 'Block title style', 'woodmart' ),
			'name'  => 'block-title-style',
			'file'  => '/css/parts/block-title-styles',
		),
	),
	'block-paragraph'                                                => array(
		array(
			'title' => esc_html__( 'Paragraph block', 'woodmart' ),
			'name'  => 'block-paragraph',
			'file'  => '/css/parts/block-paragraph',
		),
	),
	'block-icon'                                                => array(
		array(
			'title' => esc_html__( 'Icon block', 'woodmart' ),
			'name'  => 'block-icon',
			'file'  => '/css/parts/block-icon',
		),
	),
	'block-button'                                                => array(
		array(
			'title' => esc_html__( 'Button block', 'woodmart' ),
			'name'  => 'block-button',
			'file'  => '/css/parts/block-button',
		),
	),
	'block-carousel'                                                => array(
		array(
			'title' => esc_html__( 'Carousel block', 'woodmart' ),
			'name'  => 'block-carousel',
			'file'  => '/css/parts/block-carousel',
		),
	),
	'block-container'                                                => array(
		array(
			'title' => esc_html__( 'Container block', 'woodmart' ),
			'name'  => 'block-container',
			'file'  => '/css/parts/block-container',
		),
	),
	'block-infobox'                                                => array(
		array(
			'title' => esc_html__( 'Infobox block', 'woodmart' ),
			'name'  => 'block-infobox',
			'file'  => '/css/parts/block-infobox',
		),
	),
	'block-fw-section'                                                => array(
		array(
			'title' => esc_html__( 'Full width section block', 'woodmart' ),
			'name'  => 'block-fw-section',
			'file'  => '/css/parts/block-fw-section',
			'rtl'   => true,
		),
	),
	'block-banner'                                                => array(
		array(
			'title' => esc_html__( 'Banner block', 'woodmart' ),
			'name'  => 'block-banner',
			'file'  => '/css/parts/block-banner',
		),
	),
	'block-anchor'                                                => array(
		array(
			'title' => esc_html__( 'Anchor block', 'woodmart' ),
			'name'  => 'block-anchor',
			'file'  => '/css/parts/block-anchor',
		),
	),
	'block-off-canvas-layout'                                                => array(
		array(
			'title' => esc_html__( 'Off-canvas layout block', 'woodmart' ),
			'name'  => 'block-off-canvas-layout',
			'file'  => '/css/parts/block-off-canvas-layout',
		),
	),
	'block-star-rating'                                                => array(
		array(
			'title' => esc_html__( 'Star rating block', 'woodmart' ),
			'name'  => 'block-star-rating',
			'file'  => '/css/parts/block-star-rating',
		),
	),
	'block-team-member'                                                => array(
		array(
			'title' => esc_html__( 'Team member block', 'woodmart' ),
			'name'  => 'block-team-member',
			'file'  => '/css/parts/block-team-member',
		),
	),
	'block-table'                                                => array(
		array(
			'title' => esc_html__( 'Table block', 'woodmart' ),
			'name'  => 'block-table',
			'file'  => '/css/parts/block-table',
		),
	),
	'block-testimonial'                                                => array(
		array(
			'title' => esc_html__( 'Testimonial block', 'woodmart' ),
			'name'  => 'block-testimonial',
			'file'  => '/css/parts/block-testimonial',
		),
	),
	'block-image'                                                => array(
		array(
			'title' => esc_html__( 'Image block', 'woodmart' ),
			'name'  => 'block-image',
			'file'  => '/css/parts/block-image',
		),
	),
	'block-gallery'                                                => array(
		array(
			'title' => esc_html__( 'Gallery block', 'woodmart' ),
			'name'  => 'block-gallery',
			'file'  => '/css/parts/block-gallery',
		),
	),
	'block-counter'                                                => array(
		array(
			'title' => esc_html__( 'Animated counter block', 'woodmart' ),
			'name'  => 'block-counter',
			'file'  => '/css/parts/block-counter',
		),
	),
	'block-popup'                                                => array(
		array(
			'title' => esc_html__( 'Popup block', 'woodmart' ),
			'name'  => 'block-popup',
			'file'  => '/css/parts/block-popup',
		),
	),
	'block-hotspots'                                                => array(
		array(
			'title' => esc_html__( 'Hotspots block', 'woodmart' ),
			'name'  => 'block-hotspots',
			'file'  => '/css/parts/block-hotspots',
		),
	),
	'block-hotspots-product'                                                => array(
		array(
			'title' => esc_html__( 'Hotspots product block', 'woodmart' ),
			'name'  => 'block-hotspots-product',
			'file'  => '/css/parts/block-hotspots-product',
		),
	),
	'block-timeline'                                                => array(
		array(
			'title' => esc_html__( 'Timeline block', 'woodmart' ),
			'name'  => 'block-timeline',
			'file'  => '/css/parts/block-timeline',
		),
	),
	'block-menu-list'                                                => array(
		array(
			'title' => esc_html__( 'Menu list block', 'woodmart' ),
			'name'  => 'block-menu-list',
			'file'  => '/css/parts/block-menu-list',
		),
	),
	'block-menu-price'                                                => array(
		array(
			'title' => esc_html__( 'Menu price block', 'woodmart' ),
			'name'  => 'block-menu-price',
			'file'  => '/css/parts/block-menu-price',
		),
	),
	'block-divider'                                                => array(
		array(
			'title' => esc_html__( 'Divider block', 'woodmart' ),
			'name'  => 'block-divider',
			'file'  => '/css/parts/block-divider',
		),
	),
	'block-divider-inner'                                                => array(
		array(
			'title' => esc_html__( 'Divider with inner block', 'woodmart' ),
			'name'  => 'block-divider-inner',
			'file'  => '/css/parts/block-divider-inner',
		),
	),
	'block-collapsible'                                          => array(
		array(
			'title' => esc_html__( 'Block collapsible content', 'woodmart' ),
			'name'  => 'block-collapsible',
			'file'  => '/css/parts/block-collapsible',
		),
	),
	'block-toggle'                                          => array(
		array(
			'title' => esc_html__( 'Block toggle', 'woodmart' ),
			'name'  => 'block-toggle',
			'file'  => '/css/parts/block-toggle',
			'rtl'   => true,
		),
	),
);
