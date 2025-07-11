<?php
/**
 * Products template function
 *
 * @package xts
 */

use XTS\Modules\Layouts\Main;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_get_elementor_products_config' ) ) {
	/**
	 * Products element config
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	function woodmart_get_elementor_products_config() {
		return array_merge(
			woodmart_get_carousel_atts(),
			array(
				// General.
				'element_title'                => '',
				'element_title_tag'            => 'h4',

				// Query.
				'query_post_type'              => 'product',
				'post_type'                    => 'product',
				'include'                      => '',
				'taxonomies'                   => '',
				'offset'                       => '',
				'orderby'                      => '',
				'query_type'                   => 'OR',
				'order'                        => '',
				'meta_key'                     => '', // phpcs:ignore
				'exclude'                      => '',
				'shop_tools'                   => '0',
				'hide_out_of_stock'            => 'no',
				'ajax_recently_viewed'         => 'no',

				// Layout.
				'layout'                       => 'grid',
				'pagination'                   => '',
				'pagination_arrows_position'   => '',
				'items_per_page'               => 12,
				'spacing'                      => woodmart_get_opt( 'products_spacing' ),
				'spacing_tablet'               => woodmart_get_opt( 'products_spacing_tablet', '' ),
				'spacing_mobile'               => woodmart_get_opt( 'products_spacing_mobile', '' ),
				'columns'                      => array( 'size' => 4 ),
				'columns_tablet'               => array( 'size' => '' ),
				'columns_mobile'               => array( 'size' => '' ),
				'products_masonry'             => woodmart_get_opt( 'products_masonry' ),
				'products_different_sizes'     => woodmart_get_opt( 'products_different_sizes' ),
				'product_quantity'             => woodmart_get_opt( 'product_quantity' ),

				// Design.
				'product_hover'                => 'inherit',
				'sale_countdown'               => 0,
				'stretch_product'              => 0,
				'stretch_product_tablet'       => 0,
				'stretch_product_mobile'       => 0,
				'stock_progress_bar'           => 0,
				'highlighted_products'         => 0,
				'products_divider'             => 0,
				'products_bordered_grid'       => 0,
				'products_bordered_grid_style' => 'outside',
				'products_with_background'     => 0,
				'products_shadow'              => 0,
				'products_color_scheme'        => 'default',
				'img_size'                     => 'woocommerce_thumbnail',
				'img_size_custom'              => '',
				'grid_gallery'                 => '',
				'grid_gallery_control'         => '',
				'grid_gallery_enable_arrows'   => '',

				// Extra.
				'elementor'                    => true,
				'ajax_page'                    => '',
				'force_not_ajax'               => 'no',
				'lazy_loading'                 => 'no',
				'scroll_carousel_init'         => 'no',
				'custom_sizes'                 => apply_filters( 'woodmart_products_shortcode_custom_sizes', false ),
				'wrapper_classes'              => '',
			)
		);
	}
}

if ( ! function_exists( 'woodmart_elementor_products_template' ) ) {
	function woodmart_elementor_products_template( $settings ) {
		if ( ! woodmart_woocommerce_installed() ) {
			return '';
		}
		global $product;

		$default_settings = woodmart_get_elementor_products_config();
		$settings         = wp_parse_args( $settings, $default_settings );

		$encoded_settings = wp_json_encode(
			array_merge(
				array_map(
					'unserialize',
					array_diff_assoc(
						array_map( 'serialize', array_intersect_key( $settings, $default_settings ) ),
						array_map( 'serialize', $default_settings ),
					)
				),
				array(
					'elementor'      => true,
					'force_not_ajax' => 'no',
				)
			)
		);

		$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
		if ( isset( $_GET['product-page'] ) ) { // phpcs:ignore
			$paged = wc_clean( wp_unslash( $_GET['product-page'] ) ); // phpcs:ignore
		}

		$is_ajax                    = woodmart_is_woo_ajax() && 'yes' !== $settings['force_not_ajax'] && isset( $_POST['action'] ) && $_POST['action'] !== 'woodmart_load_html_dropdowns';
		$settings['force_not_ajax'] = 'no';
		$wrapper_classes            = '';
		$products_element_classes   = '';
		$style_attrs                = '';

		if ( $settings['ajax_page'] > 1 ) {
			$paged = $settings['ajax_page'];
		}

		if ( 'recently_viewed' === $settings['post_type'] ) {
			$settings['orderby'] = 'menu_order';
		}

		// Query settings.
		$ordering_args = WC()->query->get_catalog_ordering_args( $settings['orderby'], $settings['order'] );

		$query_args = array(
			'post_type'           => $settings['query_post_type'],
			'post_status'         => 'publish',
			'ignore_sticky_posts' => 1,
			'paged'               => $paged,
			'orderby'             => $ordering_args['orderby'],
			'order'               => $ordering_args['order'],
			'posts_per_page'      => $settings['items_per_page'],
			'meta_query'          => WC()->query->get_meta_query(), // phpcs:ignore
			'tax_query'           => WC()->query->get_tax_query(), // phpcs:ignore
		);

		if ( 'new' === $settings['post_type'] ) {
			$days = woodmart_get_opt( 'new_label_days_after_create' );
			if ( $days ) {
				$query_args['date_query'] = array(
					'after' => date( 'Y-m-d', strtotime( '-' . $days . ' days' ) ),
				);
			} else {
				$query_args['meta_query'][] = array(
					'relation' => 'OR',
					array(
						'key'     => '_woodmart_new_label',
						'value'   => 'on',
						'compare' => 'IN',
					),
					array(
						'key'     => '_woodmart_new_label_date',
						'value'   => date( 'Y-m-d' ), // phpcs:ignore
						'compare' => '>',
						'type'    => 'DATE',
					),
				);
			}
		}

		if ( $ordering_args['meta_key'] ) {
			$query_args['meta_key'] = $ordering_args['meta_key']; // phpcs:ignore
		}
		if ( $settings['meta_key'] ) {
			$query_args['meta_key'] = $settings['meta_key']; // phpcs:ignore
		}
		if ( 'ids' === $settings['post_type'] && $settings['include'] ) {
			$query_args['post__in'] = $settings['include'];
		}
		if ( $settings['exclude'] ) {
			$query_args['post__not_in'] = $settings['exclude'];
		}
		if ( $settings['taxonomies'] ) {
			$taxonomy_names = get_object_taxonomies( 'product' );
			$terms          = get_terms(
				$taxonomy_names,
				array(
					'orderby'    => 'name',
					'include'    => $settings['taxonomies'],
					'hide_empty' => false,
				)
			);

			if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
				if ( 'featured' === $settings['post_type'] ) {
					$query_args['tax_query'] = [ 'relation' => 'AND' ]; // phpcs:ignore
				}

				$relation = $settings['query_type'] ? $settings['query_type'] : 'OR';
				if ( count( $terms ) > 1 ) {
					$query_args['tax_query']['categories'] = array( 'relation' => $relation );
				}

				foreach ( $terms as $term ) {
					$query_args['tax_query']['categories'][] = array(
						'taxonomy'         => $term->taxonomy,
						'field'            => 'slug',
						'terms'            => array( $term->slug ),
						'include_children' => true,
						'operator'         => 'IN',
					);
				}
			}
		}
		if ( 'featured' === $settings['post_type'] ) {
			$query_args['tax_query'][] = array(
				'taxonomy'         => 'product_visibility',
				'field'            => 'name',
				'terms'            => 'featured',
				'operator'         => 'IN',
				'include_children' => false,
			);
		}
		if ( 'yes' === $settings['hide_out_of_stock'] || apply_filters( 'woodmart_hide_out_of_stock_items', false ) && 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) ) {
			$query_args['meta_query'][] = array(
				'key'     => '_stock_status',
				'value'   => 'outofstock',
				'compare' => 'NOT IN',
			);
		}
		if ( $settings['order'] ) {
			$query_args['order'] = $settings['order'];
		}
		if ( $settings['offset'] ) {
			$query_args['offset'] = $settings['offset'];
		}
		if ( 'sale' === $settings['post_type'] ) {
			$query_args['post__in'] = array_merge( array( 0 ), wc_get_product_ids_on_sale() );
		}
		if ( 'bestselling' === $settings['post_type'] ) {
			$query_args['orderby']  = 'meta_value_num';
			$query_args['meta_key'] = 'total_sales'; // phpcs:ignore
			$query_args['order']    = 'DESC';
		}

		WC()->query->remove_ordering_args();

		if ( isset( $_GET['orderby'] ) && $settings['shop_tools'] ) { // phpcs:ignore
			$element_orderby = wc_clean( wp_unslash( $_GET['orderby'] ) ); // phpcs:ignore

			if ( 'date' === $element_orderby ) {
				$query_args['orderby'] = 'date';
				$query_args['order']   = 'DESC';
			} elseif ( 'price-desc' === $element_orderby ) {
				$query_args['orderby'] = 'price';
				$query_args['order']   = 'DESC';
			} else {
				$query_args['orderby'] = $element_orderby;
				$query_args['order']   = 'ASC';
			}
		}

		if ( 'price' === $query_args['orderby'] ) {
			$query_args['orderby']  = 'meta_value_num';
			$query_args['meta_key'] = '_price'; // phpcs:ignore
		}

		if ( isset( $_GET['per_page'] ) && $settings['shop_tools'] ) { // phpcs:ignore
			$query_args['posts_per_page'] = wc_clean( wp_unslash( $_GET['per_page'] ) ); // phpcs:ignore
		}

		if ( 'upsells' === $settings['post_type'] ) {
			if ( $product && is_object( $product ) ) {
				$query_args['post__in']  = array_merge( array( 0 ), $product->get_upsell_ids() );
				$query_args['post_type'] = array( 'product', 'product_variation' );

				if ( ! isset( $query_args['post__in'][1] ) && 0 === $query_args['post__in'][0] ) {
					return false;
				}
			}
		}

		if ( 'related' === $settings['post_type'] ) {
			if ( $product && is_object( $product ) ) {
				$query_args['post__in']  = array_merge( array( 0 ), wc_get_related_products( $product->get_id(), (int) $query_args['posts_per_page'], $product->get_upsell_ids() ) );
				$query_args['post_type'] = array( 'product', 'product_variation' );

				if ( ! isset( $query_args['post__in'][1] ) && 0 === $query_args['post__in'][0] ) {
					return false;
				}
			}
		}

		if ( 'cross-sells' === $settings['post_type'] ) {
			if ( is_object( WC()->cart )  ) {
				$cross_sells = WC()->cart->get_cross_sells();

				if ( ! $cross_sells ) {
					return false;
				}

				if ( $cross_sells ) {
					$query_args['post__in'] = array_merge( array( 0 ), $cross_sells );
				}
			} else {
				return false;
			}
		}

		if ( 'recently_viewed' === $settings['post_type'] ) {
			$viewed_products = ! empty( $_COOKIE['woodmart_recently_viewed_products'] ) ? explode( '|', wp_unslash( $_COOKIE['woodmart_recently_viewed_products'] ) ) : array();

			if ( ! $viewed_products ) {
				$products_element_classes .= ' wd-hide';
			}

			if ( 'yes' === $settings['ajax_recently_viewed'] ) {
				woodmart_enqueue_js_script( 'product-recently-viewed' );

				if ( ! $viewed_products && 'grid' === $settings['layout'] && ( 'inherit' === $settings['product_hover'] || 'base' === $settings['product_hover'] || 'fw-button' === $settings['product_hover'] ) ) {
					woodmart_enqueue_js_script( 'product-hover' );
					woodmart_enqueue_js_script( 'product-more-description' );
				}
			}

			$query_args['post__in'] = array_merge( array( 0 ), $viewed_products );
			$query_args['orderby']  = 'post__in';

			if ( woodmart_get_opt( 'show_single_variation' ) && woodmart_get_opt( 'hide_variation_parent' ) ) {
				$query_args['wd_show_variable_products'] = true;
			}
		}

		if ( 'top_rated_products' === $settings['post_type'] ) {
			add_filter( 'posts_clauses', 'woodmart_order_by_rating_post_clauses' );
			$products = new WP_Query( apply_filters( 'woodmart_product_element_query_args', $query_args ) );
			remove_filter( 'posts_clauses', 'woodmart_order_by_rating_post_clauses' );
		} else {
			$products = new WP_Query( apply_filters( 'woodmart_product_element_query_args', $query_args ) );
		}

		// Element settings.
		if ( 'inherit' === $settings['product_hover'] ) {
			$settings['product_hover'] = woodmart_get_opt( 'products_hover' );
			$settings['stretch_product'] = woodmart_get_opt( 'stretch_product_desktop' );
			$settings['stretch_product_tablet'] = woodmart_get_opt( 'stretch_product_tablet' );
			$settings['stretch_product_mobile'] = woodmart_get_opt( 'stretch_product_mobile' );
		}

		// Loop settings.
		woodmart_set_loop_prop( 'timer', $settings['sale_countdown'] );
		woodmart_set_loop_prop( 'progress_bar', $settings['stock_progress_bar'] );
		woodmart_set_loop_prop( 'stretch_product_desktop', $settings['stretch_product'] );
		woodmart_set_loop_prop( 'stretch_product_tablet', $settings['stretch_product_tablet'] );
		woodmart_set_loop_prop( 'stretch_product_mobile', $settings['stretch_product_mobile'] );
		woodmart_set_loop_prop( 'product_hover', $settings['product_hover'] );
		woodmart_set_loop_prop( 'products_view', $settings['layout'] );
		woodmart_set_loop_prop( 'is_shortcode', true );
		woodmart_set_loop_prop( 'img_size', $settings['img_size'] );

		if ( ! empty( $settings['grid_gallery'] ) ) {
			woodmart_set_loop_prop( 'grid_gallery', $settings['grid_gallery'] );

			if ( ! empty( $settings['grid_gallery_control'] ) ) {
				woodmart_set_loop_prop( 'grid_gallery_control', $settings['grid_gallery_control'] );
			}
			if ( ! empty( $settings['grid_gallery_enable_arrows'] ) ) {
				woodmart_set_loop_prop( 'grid_gallery_enable_arrows', $settings['grid_gallery_enable_arrows'] );
			}
		}
		if ( ! empty( $settings['img_size_custom'] ) ) {
			woodmart_set_loop_prop( 'img_size_custom', $settings['img_size_custom'] );
		}
		if ( isset( $settings['columns']['size'] ) ) {
			woodmart_set_loop_prop( 'products_columns', $settings['columns']['size'] );
			woodmart_set_loop_prop( 'products_columns_tablet', $settings['columns_tablet']['size'] );
			woodmart_set_loop_prop( 'products_columns_mobile', $settings['columns_mobile']['size'] );
		}
		if ( $settings['products_masonry'] ) {
			woodmart_set_loop_prop( 'products_masonry', 'enable' === $settings['products_masonry'] );
		}
		if ( $settings['products_different_sizes'] ) {
			woodmart_set_loop_prop( 'products_different_sizes', 'enable' === $settings['products_different_sizes'] );
		}
		if ( $settings['product_quantity'] ) {
			woodmart_set_loop_prop( 'product_quantity', 'enable' === $settings['product_quantity'] );
		}
		if ( 'arrows' !== $settings['pagination'] && $settings['items_per_page'] ) {
			woodmart_set_loop_prop( 'woocommerce_loop', $settings['items_per_page'] * ( $paged - 1 ) );
		}
		if ( isset( $_GET['shop_view'] ) && $settings['shop_tools'] ) { // phpcs:ignore
			woodmart_set_loop_prop( 'products_view', wc_clean( wp_unslash( $_GET['shop_view'] ) ) ); // phpcs:ignore
		}

		if ( isset( $_GET['per_row'] ) && $settings['shop_tools'] ) { // phpcs:ignore
			woodmart_set_loop_prop( 'products_columns', wc_clean( wp_unslash( $_GET['per_row'] ) ) ); // phpcs:ignore
			$settings['columns']['size'] = wc_clean( wp_unslash( $_GET['per_row'] ) ); // phpcs:ignore
		}

		if ( '' === $settings['spacing'] ) {
			$settings['spacing'] = woodmart_get_opt( 'products_spacing' );

			if ( '' === $settings['spacing_tablet'] ) {
				$settings['spacing_tablet'] = woodmart_get_opt( 'products_spacing_tablet' );
			}
			if ( '' === $settings['spacing_mobile'] ) {
				$settings['spacing_mobile'] = woodmart_get_opt( 'products_spacing_mobile' );
			}
		}

		woodmart_set_loop_prop( 'products_color_scheme', $settings['products_color_scheme'] );

		if ( $is_ajax ) {
			ob_start();
		}

		if ( 'small' === $settings['product_hover'] ) {
			woodmart_enqueue_inline_style( 'woo-prod-loop-small' );
		}

		if ( woodmart_get_opt( 'quick_shop_variable' ) ) {
			if ( 'variation_form' === woodmart_get_opt( 'quick_shop_variable_type', 'select_options' ) ) {
				woodmart_enqueue_js_script( 'quick-shop-with-form' );
			} else {
				woodmart_enqueue_js_script( 'quick-shop' );
				woodmart_enqueue_js_script( 'swatches-variations' );
			}

			woodmart_enqueue_js_script( 'add-to-cart-all-types' );
			wp_enqueue_script( 'wc-add-to-cart-variation' );
		}

		if ( 'carousel' === $settings['layout'] ) {
			if ( is_array( $settings['slides_per_view'] ) ) {
				$settings['slides_per_view'] = $settings['slides_per_view']['size'];
			}

			woodmart_enqueue_product_loop_styles( $settings['product_hover'] );

			if ( ( isset( $settings['slides_per_view_tablet']['size'] ) && ! empty( $settings['slides_per_view_tablet']['size'] ) ) || ( isset( $settings['slides_per_view_mobile']['size'] ) && ! empty( $settings['slides_per_view_mobile']['size'] ) ) ) {
				$settings['custom_sizes'] = array(
					'desktop' => $settings['slides_per_view'],
					'tablet'  => $settings['slides_per_view_tablet']['size'],
					'mobile'  => $settings['slides_per_view_mobile']['size'],
				);
			}

			echo woodmart_generate_posts_slider(
				wp_parse_args(
					array(
						'spacing'        => ! $settings['highlighted_products'] ? $settings['spacing'] : '',
						'spacing_tablet' => ! $settings['highlighted_products'] ? $settings['spacing_tablet'] : '',
						'spacing_mobile' => ! $settings['highlighted_products'] ? $settings['spacing_mobile'] : '',
					),
					$settings,
				),
				$products
			);

			if ( $is_ajax ) {
				return array(
					'items'  => ob_get_clean(),
					'status' => ( $products->max_num_pages > $paged ) ? 'have-posts' : 'no-more-posts'
				);
			}

			return;
		}

		if ( $settings['shop_tools'] ) {
			woodmart_enqueue_inline_style( 'woo-shop-el-order-by' );
			woodmart_enqueue_inline_style( 'woo-shop-el-products-per-page' );
			woodmart_enqueue_inline_style( 'woo-shop-el-products-view' );
			woodmart_enqueue_inline_style( 'woo-mod-shop-loop-head' );
		}

		// Classes.
		if ( $settings['pagination'] ) {
			$wrapper_classes .= ' pagination-' . $settings['pagination'];
		}

		if ( 'list' === $settings['layout'] ) {
			$settings['product_hover'] = 'list';

			$style_attrs .= woodmart_get_grid_attrs(
				array(
					'columns'        => 1,
					'columns_tablet' => 1,
					'columns_mobile' => 1,
				)
			);

			$wrapper_classes .= ' elements-list';
		} else {
			$style_attrs .= woodmart_get_grid_attrs(
				array(
					'columns'        => woodmart_loop_prop( 'products_columns' ),
					'columns_tablet' => woodmart_loop_prop( 'products_columns_tablet' ),
					'columns_mobile' => woodmart_loop_prop( 'products_columns_mobile' ),
					'spacing'        => ! $settings['highlighted_products'] ? $settings['spacing'] : '',
					'spacing_tablet' => ! $settings['highlighted_products'] ? $settings['spacing_tablet'] : '',
					'spacing_mobile' => ! $settings['highlighted_products'] ? $settings['spacing_mobile'] : '',
					'post_type'      => 'product',
				)
			);

			$wrapper_classes .= ' grid-columns-' . $settings['columns']['size'];
			$wrapper_classes .= ' elements-grid';
		}
		if ( $settings['products_bordered_grid'] && ! $settings['highlighted_products'] ) {
			woodmart_enqueue_inline_style( 'bordered-product' );

			if ( 'outside' === $settings['products_bordered_grid_style'] ) {
				$wrapper_classes .= ' products-bordered-grid';
			} elseif ( 'inside' === $settings['products_bordered_grid_style'] ) {
				$wrapper_classes .= ' products-bordered-grid-ins';
			}
		}

		if ( $settings['products_divider'] && 'small' === $settings['product_hover'] && 'list' !== $settings['layout'] ) {
			woodmart_enqueue_inline_style( 'products-divider' );

			$wrapper_classes .= ' wd-with-divider';
		}

		if ( woodmart_loop_prop( 'product_quantity' ) ) {
			$wrapper_classes .= ' wd-quantity-enabled';
		}
		if ( 'none' !== woodmart_get_opt( 'product_title_lines_limit' ) && 'list' !== $settings['layout'] ) {
			woodmart_enqueue_inline_style( 'woo-opt-title-limit' );
			$wrapper_classes .= ' title-line-' . woodmart_get_opt( 'product_title_lines_limit' );
		}
		if ( woodmart_loop_prop( 'products_masonry' ) ) {
			$wrapper_classes .= ' grid-masonry';
			wp_enqueue_script( 'imagesloaded' );
			woodmart_enqueue_js_library( 'isotope-bundle' );
			woodmart_enqueue_js_script( 'shop-masonry' );
		}

		if ( woodmart_loop_prop( 'products_masonry' ) || woodmart_loop_prop( 'products_different_sizes' ) ) {
			$wrapper_classes .= ' wd-grid-f-col';
		} else {
			$wrapper_classes .= ' wd-grid-g';
		}

		if ( $settings['highlighted_products'] ) {
			woodmart_enqueue_inline_style( 'highlighted-product' );
		}

		$products_element_classes .= $settings['highlighted_products'] ? ' wd-highlighted-products' : '';
		$products_element_classes .= $settings['highlighted_products'] ? woodmart_get_old_classes( ' woodmart-highlighted-products' ) : '';
		$products_element_classes .= $settings['element_title'] ? ' with-title' : '';
		$products_element_classes .= $settings['wrapper_classes'] ? $settings['wrapper_classes'] : '';

		wc_set_loop_prop( 'total', $products->found_posts );
		wc_set_loop_prop( 'total_pages', $products->max_num_pages );
		wc_set_loop_prop( 'current_page', $products->query['paged'] );
		wc_set_loop_prop( 'is_shortcode', true );

		if ( $products->have_posts() ) {
			woodmart_enqueue_product_loop_styles( $settings['product_hover'] );
		}

		// Lazy loading.
		if ( 'yes' === $settings['lazy_loading'] ) {
			woodmart_lazy_loading_init( true );
			woodmart_enqueue_inline_style( 'lazy-loading' );
		}

		if ( ( woodmart_loop_prop( 'stretch_product_desktop' ) || woodmart_loop_prop( 'stretch_product_tablet' ) || woodmart_loop_prop( 'stretch_product_mobile' ) ) && in_array( $settings['product_hover'],
				array( 'icons', 'alt', 'button', 'standard', 'tiled', 'quick', 'base', 'fw-button', 'buttons-on-hover' ), true ) ) {
			woodmart_enqueue_inline_style( 'woo-opt-stretch-cont' );
			if ( woodmart_loop_prop( 'stretch_product_desktop' ) ) {
				$wrapper_classes .= ' wd-stretch-cont-lg';
			}
			if ( woodmart_loop_prop( 'stretch_product_tablet' ) ) {
				$wrapper_classes .= ' wd-stretch-cont-md';
			}
			if ( woodmart_loop_prop( 'stretch_product_mobile' ) ) {
				$wrapper_classes .= ' wd-stretch-cont-sm';
			}
		}

		if ( 'default' !== $settings['products_color_scheme'] && ( $settings['products_bordered_grid'] || 'enable' === $settings['products_bordered_grid'] ) && 'disable' !== $settings['products_bordered_grid'] && 'outside' === $settings['products_bordered_grid_style'] ) {
			$wrapper_classes .= ' wd-bordered-' . $settings['products_color_scheme'];
		}

		if ( $settings['products_with_background'] ) {
			woodmart_enqueue_inline_style( 'woo-opt-products-bg' );

			$wrapper_classes .= ' wd-products-with-bg';
		}

		if ( $settings['products_shadow'] ) {
			woodmart_enqueue_inline_style( 'woo-opt-products-shadow' );

			$wrapper_classes .= ' wd-products-with-shadow';
		}

		?>
		<?php if ( ! $is_ajax ) : ?>
			<div class="wd-products-element<?php echo esc_attr( $products_element_classes ); ?>">

			<?php if ( $settings['element_title'] ) : ?>
				<?php
				printf(
					'<%1$s class="wd-el-title title element-title">%2$s</%1$s>',
					esc_attr( apply_filters( 'woodmart_products_title_tag', $settings['element_title_tag'] ) ),
					esc_html( $settings['element_title'] )
				);
				?>
			<?php endif; ?>

			<?php if ( 'arrows' === $settings['pagination'] ) : ?>
				<?php woodmart_enqueue_inline_style( 'product-arrows' ); ?>
				<?php woodmart_sticky_loader(); ?>
			<?php endif; ?>

			<?php if ( $settings['shop_tools'] ) : ?>
				<div class="shop-loop-head">
					<div class="wd-shop-tools">
						<?php woodmart_products_per_page_select( true ); ?>
						<?php woodmart_products_view_select( true ); ?>
						<?php woocommerce_catalog_ordering(); ?>
					</div>
				</div>
			<?php endif; ?>

			<?php
				if ( 'no' !== woodmart_loop_prop( 'grid_gallery' ) && woodmart_loop_prop( 'grid_gallery' ) ) {
					$data_grid_gallery_atts = wp_json_encode(
						array(
							'grid_gallery'               => woodmart_loop_prop( 'grid_gallery' ),
							'grid_gallery_control'       => woodmart_loop_prop( 'grid_gallery_control' ),
							'grid_gallery_enable_arrows' => woodmart_loop_prop( 'grid_gallery_enable_arrows' ),
						)
					);
				}
			?>

			<div class="products wd-products<?php echo esc_attr( $wrapper_classes ); ?>" data-paged="1" data-atts="<?php echo esc_attr( $encoded_settings ); ?>" data-source="shortcode" data-columns="<?php echo isset( $settings['columns']['size'] ) ? esc_attr( $settings['columns']['size'] ) : ''; ?>" data-grid-gallery="<?php echo isset( $data_grid_gallery_atts ) ? esc_attr( $data_grid_gallery_atts ) : ''; ?>" style="<?php echo esc_attr( $style_attrs ); ?>">
		<?php endif; ?>

		<?php while ( $products->have_posts() ) : ?>
			<?php $products->the_post(); ?>
			<?php wc_get_template_part( 'content', 'product' ); ?>
		<?php endwhile; ?>

		<?php if ( ! $is_ajax ) : ?>
		</div>
	<?php endif; ?>

		<?php woodmart_set_loop_prop( 'shop_pagination', $settings['pagination'] ); ?>

		<?php if ( $products->max_num_pages > 1 && ! $is_ajax && $settings['pagination'] ) : ?>
			<?php wp_enqueue_script( 'imagesloaded' ); ?>
			<?php woodmart_enqueue_js_script( 'products-load-more' ); ?>
			<?php if ( 'infinit' === $settings['pagination'] ) : ?>
				<?php woodmart_enqueue_js_library( 'waypoints' ); ?>
			<?php endif; ?>
			<?php if ( 'more-btn' === $settings['pagination'] || 'infinit' === $settings['pagination'] ) : ?>
				<div class="wd-loop-footer products-footer">
					<?php woodmart_enqueue_inline_style( 'load-more-button' ); ?>
					<a href="#" rel="nofollow noopener" class="btn wd-load-more wd-products-load-more load-on-<?php echo 'more-btn' === $settings['pagination'] ? 'click' : 'scroll'; ?>"><span class="load-more-label"><?php esc_html_e( 'Load more products', 'woodmart' ); ?></span></a>
					<div class="btn wd-load-more wd-load-more-loader"><span class="load-more-loading"><?php esc_html_e( 'Loading...', 'woodmart' ); ?></span></div>
				</div>
			<?php endif; ?>
			<?php if ( 'arrows' === $settings['pagination'] ) : ?>
				<?php
				$arrows_classes = ' wd-ajax-arrows';

				if ( $settings['highlighted_products'] ) {
					$arrows_classes .= ' wd-custom-style';
				} else {
					$arrows_hover_style = woodmart_get_opt( 'carousel_arrows_hover_style', '1' );

					if ( 'disable' !== $arrows_hover_style ) {
						$arrows_classes .= ' wd-hover-' . $arrows_hover_style;
					}
				}

				if ( ! empty( $settings['pagination_arrows_position'] ) ) {
					$arrows_classes .= ' wd-pos-' . $settings['pagination_arrows_position'];
				} elseif ( $settings['highlighted_products'] ) {
					if ( $settings['element_title'] ) {
						$arrows_classes .= ' wd-pos-together';
					} else {
						$arrows_classes .= ' wd-pos-sep';
					}
				} else {
					$arrows_classes .= ' wd-pos-' . woodmart_get_opt( 'carousel_arrows_position', 'sep' );
				}

				woodmart_enqueue_inline_style( 'product-arrows' );
				woodmart_get_carousel_nav_template( $arrows_classes );
				?>
			<?php endif; ?>
			<?php if ( 'links' === $settings['pagination'] ) : ?>
				<?php woocommerce_pagination(); ?>
			<?php endif; ?>
		<?php endif; ?>

		<?php if ( ! $is_ajax || isset( $viewed_products ) ) : ?>
			</div>
		<?php endif; ?>

		<?php

		wc_reset_loop();
		wp_reset_postdata();
		woodmart_reset_loop();

		// Lazy loading.
		if ( 'yes' === $settings['lazy_loading'] ) {
			woodmart_lazy_loading_deinit();
		}

		if ( $is_ajax ) {
			return array(
				'items'  => ob_get_clean(),
				'status' => $products->max_num_pages > $paged ? 'have-posts' : 'no-more-posts',
			);
		}
	}
}
