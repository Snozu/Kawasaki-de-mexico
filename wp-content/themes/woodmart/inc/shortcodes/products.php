<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );}

/**
 * ------------------------------------------------------------------------------------------------
 * Shortcode function to display posts as a slider or as a grid
 * ------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'woodmart_shortcode_products' ) ) {

	function woodmart_shortcode_products( $atts, $content = '' ) {
		global $product;

		$default_settings = woodmart_get_default_product_shortcode_atts();
		$parsed_atts      = shortcode_atts( $default_settings, $atts );

		extract( $parsed_atts );

		$encoded_atts = wp_json_encode(
			array_merge(
				array_map(
					'unserialize',
					array_diff_assoc(
						array_map( 'serialize', $parsed_atts ),
						array_map( 'serialize', $default_settings )
					)
				),
				array(
					'force_not_ajax' => 'no',

				)
			)
		);

		$is_ajax = ( defined( 'DOING_AJAX' ) && DOING_AJAX && $force_not_ajax !== 'yes' && isset( $_POST['action'] ) && $_POST['action'] !== 'woodmart_load_html_dropdowns' );

		$parsed_atts['force_not_ajax'] = 'no'; // :)

		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

		if ( isset( $_GET['product-page'] ) ) {
			$paged = wc_clean( wp_unslash( $_GET['product-page'] ) );
		}

		if ( $ajax_page > 1 ) {
			$paged = $ajax_page;
		}

		if ( 'recently_viewed' === $post_type ) {
			$orderby = 'menu_order';
		}

		$ordering_args = WC()->query->get_catalog_ordering_args( $orderby, $order );

		$meta_query = WC()->query->get_meta_query();

		$tax_query = WC()->query->get_tax_query();

		$products_element_classes = apply_filters( 'vc_shortcodes_css_class', '', '', $parsed_atts );
		$products_element_classes .= $el_class ? ' ' . $el_class : '';

		if ( $parsed_atts['css'] ) {
			$products_element_classes .= ' ' . vc_shortcode_custom_css_class( $parsed_atts['css'] );
		}

		if ( 'wpb' === woodmart_get_current_page_builder() ) {
			$products_element_classes .= ' wd-wpb';
		}

		ob_start();

		if ( $orderby == 'post__in' ) {
			$ordering_args['orderby'] = $orderby;
		}

		$args = array(
			'post_type'           => $query_post_type,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => 1,
			'paged'               => $paged,
			'orderby'             => $ordering_args['orderby'],
			'order'               => $ordering_args['order'],
			'posts_per_page'      => $items_per_page,
			'meta_query'          => $meta_query,
			'tax_query'           => $tax_query,
		);

		if ( $post_type == 'new' ) {
			$days = woodmart_get_opt( 'new_label_days_after_create' );
			if ( $days ) {
				$args['date_query'] = array(
					'after' => date( 'Y-m-d', strtotime( '-' . $days . ' days' ) ),
				);
			} else {
				$args['meta_query'][] = array(
					'relation' => 'OR',
					array(
						'key'     => '_woodmart_new_label',
						'value'   => 'on',
						'compare' => 'IN',
					),
					array(
						'key'     => '_woodmart_new_label_date',
						'value'   => date( 'Y-m-d' ),
						'compare' => '>',
						'type'    => 'DATE',
					),
				);
			}
		}

		if ( ! empty( $ordering_args['meta_key'] ) ) {
			$args['meta_key'] = $ordering_args['meta_key'];
		}

		if ( ! empty( $meta_key ) ) {
			$args['meta_key'] = $meta_key;
		}

		if ( $post_type == 'ids' && $include != '' ) {
			$args['post__in'] = array_map( 'trim', explode( ',', $include ) );
		}

		if ( ! empty( $exclude ) ) {
			$args['post__not_in'] = array_map( 'trim', explode( ',', $exclude ) );
		}

		if ( ! empty( $taxonomies ) ) {
			$taxonomy_names = get_object_taxonomies( 'product' );
			$terms          = get_terms(
				$taxonomy_names,
				array(
					'orderby'    => 'name',
					'include'    => $taxonomies,
					'hide_empty' => false,
				)
			);

			if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
				if ( $post_type == 'featured' ) $args['tax_query'] = array( 'relation' => 'AND' );

				$relation = $query_type ? $query_type : 'OR';
				if ( count( $terms ) > 1 ) $args['tax_query']['categories'] = array( 'relation' => $relation );

				foreach ( $terms as $term ) {
					$args['tax_query']['categories'][] = array(
						'taxonomy'         => $term->taxonomy,
						'field'            => 'slug',
						'terms'            => array( $term->slug ),
						'include_children' => true,
						'operator'         => 'IN',
					);
				}
			}
		}

		if ( $post_type == 'featured' ) {
			$args['tax_query'][] = array(
				'taxonomy'         => 'product_visibility',
				'field'            => 'name',
				'terms'            => 'featured',
				'operator'         => 'IN',
				'include_children' => false,
			);
		}

		if ( 'yes' === $hide_out_of_stock || apply_filters( 'woodmart_hide_out_of_stock_items', false ) && 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) && empty( $is_wishlist ) ) {
			$args['meta_query'][] = array( 'key' => '_stock_status', 'value' => 'outofstock', 'compare' => 'NOT IN' );
		}

		if ( ! empty( $order ) ) {
			$args['order'] = $order;
		}

		if ( ! empty( $offset ) ) {
			$args['offset'] = $offset;
		}

		if ( $post_type == 'sale' ) {
			$args['post__in'] = array_merge( array( 0 ), wc_get_product_ids_on_sale() );
		}

		if ( $post_type == 'bestselling' ) {
			$args['orderby']  = 'meta_value_num';
			$args['meta_key'] = 'total_sales';
			$args['order']    = 'DESC';
		}

		if ( empty( $product_hover ) || 'inherit' === $product_hover ) {
			$product_hover           = woodmart_get_opt( 'products_hover' );
			$stretch_product_desktop = woodmart_get_opt( 'stretch_product_desktop' );
			$stretch_product_tablet  = woodmart_get_opt( 'stretch_product_tablet' );
			$stretch_product_mobile  = woodmart_get_opt( 'stretch_product_mobile' );
		}

		if ( ! empty( $product_hover ) && 'small' === $product_hover ) {
			woodmart_enqueue_inline_style( 'woo-prod-loop-small' );
		}

		woodmart_set_loop_prop( 'timer', $sale_countdown );
		woodmart_set_loop_prop( 'stretch_product_desktop', $stretch_product_desktop );
		woodmart_set_loop_prop( 'stretch_product_tablet', $stretch_product_tablet );
		woodmart_set_loop_prop( 'stretch_product_mobile', $stretch_product_mobile );
		woodmart_set_loop_prop( 'progress_bar', $stock_progress_bar );
		woodmart_set_loop_prop( 'product_hover', $product_hover );
		woodmart_set_loop_prop( 'products_view', $layout );
		woodmart_set_loop_prop( 'is_shortcode', true );
		woodmart_set_loop_prop( 'img_size', $img_size );
		woodmart_set_loop_prop( 'products_columns', $columns );
		woodmart_set_loop_prop( 'products_columns_tablet', $columns_tablet );
		woodmart_set_loop_prop( 'products_columns_mobile', $columns_mobile );
		woodmart_set_loop_prop( 'products_color_scheme', $products_color_scheme );

		if ( 'custom' === $img_size && ! empty( $img_size_custom ) ) {
			woodmart_set_loop_prop( 'img_size_custom', $img_size_custom );
		}

		if ( ! empty( $grid_gallery ) ) {
			woodmart_set_loop_prop( 'grid_gallery', $grid_gallery );
		}

		if ( ! empty( $grid_gallery_enable_arrows ) ) {
			woodmart_set_loop_prop( 'grid_gallery_enable_arrows', $grid_gallery_enable_arrows );
		}

		if ( ! empty( $grid_gallery_control ) ) {
			woodmart_set_loop_prop( 'grid_gallery_control', $grid_gallery_control );
		}

		if ( $products_masonry ) {
			woodmart_set_loop_prop( 'products_masonry', 'enable' === $products_masonry );
		}
		if ( $product_quantity ) {
			woodmart_set_loop_prop( 'product_quantity', 'enable' === $product_quantity );
		}
		if ( $products_different_sizes ) {
			woodmart_set_loop_prop( 'products_different_sizes', 'enable' === $products_different_sizes );
		}
		if ( ! empty( $grid_items_different_sizes ) ) {
			woodmart_set_loop_prop( 'grid_items_different_sizes', explode( ',', $grid_items_different_sizes ) );
		}

		if ( isset( $_GET['orderby'] ) && 'yes' === $shop_tools ) { // phpcs:ignore
			$element_orderby = wc_clean( wp_unslash( $_GET['orderby'] ) ); // phpcs:ignore

			if ( 'date' === $element_orderby ) {
				$args['orderby'] = 'date';
				$args['order']   = 'DESC';
			} elseif ( 'price-desc' === $element_orderby ) {
				$args['orderby'] = 'price';
				$args['order']   = 'DESC';
			} else {
				$args['orderby'] = $element_orderby;
				$args['order']   = 'ASC';
			}
		}

		if ( 'price' === $args['orderby'] ) {
			$args['orderby']  = 'meta_value_num';
			$args['meta_key'] = '_price'; // phpcs:ignore
		}

		if ( isset( $_GET['per_page'] ) && 'yes' === $shop_tools ) { // phpcs:ignore
			$args['posts_per_page'] = wc_clean( wp_unslash( $_GET['per_page'] ) ); // phpcs:ignore
		}

		if ( isset( $_GET['shop_view'] ) && 'yes' === $shop_tools ) { // phpcs:ignore
			woodmart_set_loop_prop( 'products_view', wc_clean( wp_unslash( $_GET['shop_view'] ) ) ); // phpcs:ignore
		}

		if ( isset( $_GET['per_row'] ) && 'yes' === $shop_tools ) { // phpcs:ignore
			woodmart_set_loop_prop( 'products_columns', wc_clean( wp_unslash( $_GET['per_row'] ) ) ); // phpcs:ignore
			$columns = wc_clean( wp_unslash( $_GET['per_row'] ) ); // phpcs:ignore
		}

		if ( 'upsells' === $post_type && $product ) {
			$args['post__in']  = array_merge( array( 0 ), $product->get_upsell_ids() );
			$args['post_type'] = array( 'product', 'product_variation' );
		}

		if ( 'related' === $post_type && $product ) {
			$args['post__in']  = wc_get_related_products( $product->get_id(), (int) $args['posts_per_page'], $product->get_upsell_ids() );
			$args['post_type'] = array( 'product', 'product_variation' );
		}

		if ( 'cross-sells' === $post_type && is_object( WC()->cart ) ) {
			$cross_sells = WC()->cart->get_cross_sells();

			$args['post_type'] = array( 'product', 'product_variation' );
			$args['post__in']  = array_merge( array( 0 ), $cross_sells );
		}

		if ( 'recently_viewed' === $post_type ) {
			if ( 'yes' === $ajax_recently_viewed ) {
				woodmart_enqueue_js_script( 'product-recently-viewed' );
			}

			$viewed_products = ! empty( $_COOKIE['woodmart_recently_viewed_products'] ) ? explode( '|', wp_unslash( $_COOKIE['woodmart_recently_viewed_products'] ) ) : array();

			if ( ! $viewed_products && 'grid' === $layout && in_array( $product_hover, array( 'inherit', 'base', 'fw-button' ), true ) ) {
				woodmart_enqueue_js_script( 'product-hover' );
				woodmart_enqueue_js_script( 'product-more-description' );
			}

			$args['post__in'] = array_merge( array( 0 ), $viewed_products );
			$args['orderby']  = 'post__in';

			if ( woodmart_get_opt( 'show_single_variation' ) && woodmart_get_opt( 'hide_variation_parent' ) ) {
				$args['wd_show_variable_products'] = true;
			}
		}

		if ( 'top_rated_products' === $post_type ) {
			add_filter( 'posts_clauses', 'woodmart_order_by_rating_post_clauses' );
			$products = new WP_Query( apply_filters( 'woodmart_product_element_query_args', $args ) );
			remove_filter( 'posts_clauses', 'woodmart_order_by_rating_post_clauses' );
		} else {
			$products = new WP_Query( apply_filters( 'woodmart_product_element_query_args', $args ) );
		}

		wc_set_loop_prop( 'total', $products->found_posts );
		wc_set_loop_prop( 'total_pages', $products->max_num_pages );
		wc_set_loop_prop( 'current_page', $products->query['paged'] );
		wc_set_loop_prop( 'is_shortcode', true );

		WC()->query->remove_ordering_args();

		$parsed_atts['custom_sizes'] = apply_filters( 'woodmart_products_shortcode_custom_sizes', false );

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

		if ( '' === $spacing ) {
			$spacing = woodmart_get_opt( 'products_spacing' );

			if ( '' === $spacing_tablet ) {
				$spacing_tablet = woodmart_get_opt( 'products_spacing_tablet' );
			}
			if ( '' === $spacing_mobile ) {
				$spacing_mobile = woodmart_get_opt( 'products_spacing_mobile' );
			}
		}

		// Simple products carousel.
		if ( 'carousel' === $layout ) {
			if ( ( 'auto' !== $slides_per_view_tablet && ! empty( $slides_per_view_tablet ) ) || ( 'auto' !== $slides_per_view_mobile && ! empty( $slides_per_view_mobile ) ) ) {
				$parsed_atts['custom_sizes'] = array(
					'desktop' => $slides_per_view,
					'tablet'  => $slides_per_view_tablet,
					'mobile'  => $slides_per_view_mobile,
				);
			}

			if ( 'wpb' === woodmart_get_current_page_builder() ) {
				$parsed_atts['wrapper_classes'] .= ' wd-wpb';
			}

			woodmart_enqueue_product_loop_styles( $product_hover );

			echo woodmart_generate_posts_slider( //phpcs:ignore
				wp_parse_args(
					array(
						'spacing'        => ! $highlighted_products ? $spacing : '',
						'spacing_tablet' => ! $highlighted_products ? $spacing_tablet : '',
						'spacing_mobile' => ! $highlighted_products ? $spacing_mobile : '',
						'inner_content'  => $content,
					),
					$parsed_atts
				),
				$products
			);

			$output = ob_get_clean();

			if ( $is_ajax ) {
				$output = array(
					'items'  => $output,
					'status' => ( $products->max_num_pages > $paged ) ? 'have-posts' : 'no-more-posts',
				);
			}

			return $output;
		}

		if ( empty( $items_per_page ) ) {
			$items_per_page = 12;
		}

		if ( $pagination != 'arrows' ) {
			woodmart_set_loop_prop( 'woocommerce_loop', $items_per_page * ( $paged - 1 ) );
		}

		if ( 'list' === $layout ) {
			$product_hover = 'list';
			$class        .= ' elements-list';

			$style_attrs = woodmart_get_grid_attrs(
				array(
					'columns'        => 1,
					'columns_tablet' => 1,
					'columns_mobile' => 1,
				)
			);
		} else {
			$style_attrs = woodmart_get_grid_attrs(
				array(
					'columns'        => woodmart_loop_prop( 'products_columns' ),
					'columns_tablet' => woodmart_loop_prop( 'products_columns_tablet' ),
					'columns_mobile' => woodmart_loop_prop( 'products_columns_mobile' ),
					'spacing'        => ! $highlighted_products ? $spacing : '',
					'spacing_tablet' => ! $highlighted_products ? $spacing_tablet : '',
					'spacing_mobile' => ! $highlighted_products ? $spacing_mobile : '',
					'post_type'      => 'product',
				)
			);

			$class .= ' grid-columns-' . $columns;
			$class .= ' elements-grid';
		}

		if ( $pagination ) {
			$class .= ' pagination-' . $pagination;
		}

		if ( 'yes' === $shop_tools ) {
			woodmart_enqueue_inline_style( 'woo-shop-el-order-by' );
			woodmart_enqueue_inline_style( 'woo-shop-el-products-per-page' );
			woodmart_enqueue_inline_style( 'woo-shop-el-products-view' );
			woodmart_enqueue_inline_style( 'woo-mod-shop-loop-head' );
		}

		if ( woodmart_loop_prop( 'products_masonry' ) ) {
			$class .= ' grid-masonry';
			wp_enqueue_script( 'imagesloaded' );
			woodmart_enqueue_js_library( 'isotope-bundle' );
			woodmart_enqueue_js_script( 'shop-masonry' );
		}

		if ( woodmart_loop_prop( 'products_masonry' ) || woodmart_loop_prop( 'products_different_sizes' ) ) {
			$class .= ' wd-grid-f-col';
		} else {
			$class .= ' wd-grid-g';
		}

		$products_element_classes .= $highlighted_products ? ' wd-highlighted-products' : '';
		$products_element_classes .= $highlighted_products ? woodmart_get_old_classes( ' woodmart-highlighted-products' ) : '';
		if ( $highlighted_products ) {
			woodmart_enqueue_inline_style( 'highlighted-product' );
		}
		$products_element_classes .= ( $element_title ) ? ' with-title' : '';
		$products_element_classes .= $el_class ? ' ' . $el_class : '';
		$products_element_classes .= ! empty( $wrapper_classes ) ? $wrapper_classes : '';
		$products_element_classes .= ! $products->have_posts() ? ' wd-hide' : '';

		if ( $products_bordered_grid && ! $highlighted_products ) {
			woodmart_enqueue_inline_style( 'bordered-product' );

			if ( 'outside' === $products_bordered_grid_style ) {
				$class .= ' products-bordered-grid';
			} elseif ( 'inside' === $products_bordered_grid_style ) {
				$class .= ' products-bordered-grid-ins';
			}
		}

		if ( ! empty( $products_divider ) && 'small' === $product_hover && $layout !== 'list' ) {
			woodmart_enqueue_inline_style( 'products-divider' );

			$class .= ' wd-with-divider';
		}

		if ( woodmart_loop_prop( 'product_quantity' ) ) {
			$class .= ' wd-quantity-enabled';
		}

		if ( 'none' !== woodmart_get_opt( 'product_title_lines_limit' ) && $layout !== 'list' ) {
			woodmart_enqueue_inline_style( 'woo-opt-title-limit' );
			$class .= ' title-line-' . woodmart_get_opt( 'product_title_lines_limit' );
		}

		if ( $lazy_loading == 'yes' ) {
			woodmart_lazy_loading_init( true );
			woodmart_enqueue_inline_style( 'lazy-loading' );
		}

		if ( ( woodmart_loop_prop( 'stretch_product_desktop' ) || woodmart_loop_prop( 'stretch_product_tablet' ) || woodmart_loop_prop( 'stretch_product_mobile' ) ) && in_array( $product_hover,
		array( 'icons', 'alt', 'button', 'standard', 'tiled', 'quick', 'base', 'fw-button', 'buttons-on-hover' ) ) ) {
			woodmart_enqueue_inline_style( 'woo-opt-stretch-cont' );
			if ( woodmart_loop_prop( 'stretch_product_desktop' ) ) {
				$class .= ' wd-stretch-cont-lg';
			}
			if ( woodmart_loop_prop( 'stretch_product_tablet' ) ) {
				$class .= ' wd-stretch-cont-md';
			}
			if ( woodmart_loop_prop( 'stretch_product_mobile' ) ) {
				$class .= ' wd-stretch-cont-sm';
			}
		}

		if ( 'default' !== $products_color_scheme && ( $products_bordered_grid || 'enable' === $products_bordered_grid ) && 'disable' !== $products_bordered_grid && 'outside' === $products_bordered_grid_style ) {
			$class .= ' wd-bordered-' . $products_color_scheme;
		}

		if ( $products_with_background ) {
			woodmart_enqueue_inline_style( 'woo-opt-products-bg' );

			$class .= ' wd-products-with-bg';
		}

		if ( $products_shadow ) {
			woodmart_enqueue_inline_style( 'woo-opt-products-shadow' );

			$class .= ' wd-products-with-shadow';
		}

		if ( ! $is_ajax ) {
			?>
			<div id="<?php echo esc_attr( $el_id ); ?>" class="wd-products-element<?php echo esc_attr( $products_element_classes ); ?>">
			<?php

			echo do_shortcode( $content );
		}

		// Element title.
		if ( ! $is_ajax && $element_title ) {
			printf(
				'<%1$s class="wd-el-title title element-title">%2$s</%1$s>',
				esc_attr( apply_filters( 'woodmart_products_title_tag', $element_title_tag ) ),
				esc_html( $element_title )
			);
		}

		if ( ! $is_ajax && $pagination == 'arrows' ) {
			woodmart_enqueue_inline_style( 'product-arrows' );
			woodmart_sticky_loader();
		}

		?>

		<?php if ( ! $is_ajax && 'yes' === $shop_tools ) : ?>
			<div class="shop-loop-head">
				<div class="wd-shop-tools">
					<?php woodmart_products_per_page_select( true ); ?>
					<?php woodmart_products_view_select( true ); ?>
					<?php woocommerce_catalog_ordering(); ?>
				</div>
			</div>
		<?php endif; ?>

		<?php

		woodmart_enqueue_product_loop_styles( $product_hover );

		if ( ! $is_ajax && ( $products->have_posts() || 'yes' === $ajax_recently_viewed ) ) {
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
			<div class="products wd-products <?php echo esc_attr( $class ); ?>" data-paged="<?php echo esc_attr( $paged ); ?>" data-atts="<?php echo esc_attr( $encoded_atts ); ?>" data-source="shortcode" data-columns="<?php echo esc_attr( $columns ); ?>" data-grid-gallery="<?php echo isset( $data_grid_gallery_atts ) ? esc_attr( $data_grid_gallery_atts ) : ''; ?>" style="<?php echo esc_attr( $style_attrs ); ?>">
			<?php
		}

		if ( $products->have_posts() ) :
			while ( $products->have_posts() ) :
				$products->the_post();
				wc_get_template_part( 'content', 'product' );
			endwhile;
		endif;

		woodmart_set_loop_prop( 'shop_pagination', $pagination );

		if ( ! $is_ajax ) {
			?>
			</div>
			<?php
		};

		if ( $lazy_loading == 'yes' ) {
			woodmart_lazy_loading_deinit();
		}

		if ( $products->max_num_pages > 1 && ! $is_ajax && $pagination ) {
			?>
			<?php wp_enqueue_script( 'imagesloaded' ); ?>
			<?php woodmart_enqueue_js_script( 'products-load-more' ); ?>
			<?php if ( 'infinit' === $pagination ) : ?>
				<?php woodmart_enqueue_js_library( 'waypoints' ); ?>
			<?php endif; ?>
			<?php if ( 'more-btn' === $pagination || 'infinit' === $pagination ) : ?>
				<div class="wd-loop-footer products-footer">
					<?php woodmart_enqueue_inline_style( 'load-more-button' ); ?>
					<a href="#" rel="nofollow noopener" class="btn wd-load-more wd-products-load-more load-on-<?php echo 'more-btn' === $pagination ? 'click' : 'scroll'; ?>"><span class="load-more-label"><?php esc_html_e( 'Load more products', 'woodmart' ); ?></span></a>
					<div class="btn wd-load-more wd-load-more-loader"><span class="load-more-loading"><?php esc_html_e( 'Loading...', 'woodmart' ); ?></span></div>
				</div>
			<?php endif; ?>
			<?php if ( 'arrows' === $pagination ) : ?>
				<?php
				$arrows_classes = ' wd-ajax-arrows';

				if ( $highlighted_products ) {
					$arrows_classes .= ' wd-custom-style';
				} else {
					$arrows_hover_style = woodmart_get_opt( 'carousel_arrows_hover_style', '1' );

					if ( 'disable' !== $arrows_hover_style ) {
						$arrows_classes .= ' wd-hover-' . $arrows_hover_style;
					}
				}

				if ( ! empty( $pagination_arrows_position ) ) {
					$arrows_classes .= ' wd-pos-' . $pagination_arrows_position;
				} elseif ( $highlighted_products ) {
					if ( $element_title ) {
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
			<?php if ( 'links' === $pagination ) : ?>
				<?php woocommerce_pagination(); ?>
			<?php endif ?>
			<?php
		}

		wc_reset_loop();
		wp_reset_postdata();
		woodmart_reset_loop();

		if ( ! $is_ajax && $products->have_posts() || 'yes' === $ajax_recently_viewed ) {
			echo '</div>';
		}

		$output = ob_get_clean();

		if ( $is_ajax ) {
			$output = array(
				'items'  => $output,
				'status' => ( $products->max_num_pages > $paged ) ? 'have-posts' : 'no-more-posts',
			);
		}

		return $output;

	}
}

if ( ! function_exists( 'woodmart_order_by_rating_post_clauses' ) ) {
	function woodmart_order_by_rating_post_clauses( $args ) {
		global $wpdb;

		$args['where']  .= " AND $wpdb->commentmeta.meta_key = 'rating' ";
		$args['join']   .= "LEFT JOIN $wpdb->comments ON($wpdb->posts.ID = $wpdb->comments.comment_post_ID) LEFT JOIN $wpdb->commentmeta ON($wpdb->comments.comment_ID = $wpdb->commentmeta.comment_id)";
		$args['orderby'] = "$wpdb->commentmeta.meta_value DESC";
		$args['groupby'] = "$wpdb->posts.ID";

		return $args;
	}
}

if ( ! function_exists( 'woodmart_get_default_product_shortcode_atts' ) ) {
	function woodmart_get_default_product_shortcode_atts() {
		return array_merge(
			woodmart_get_carousel_atts(),
			array(
				'element_title'                => '',
				'element_title_tag'            => 'h4',
				'post_type'                    => 'product',
				'layout'                       => 'grid',
				'include'                      => '',
				'custom_query'                 => '',
				'taxonomies'                   => '',
				'pagination'                   => '',
				'items_per_page'               => 12,
				'product_hover'                => 'inherit',
				'spacing'                      => '',
				'spacing_tablet'               => '',
				'spacing_mobile'               => '',
				'columns'                      => 4,
				'columns_tablet'               => 'auto',
				'columns_mobile'               => 'auto',
				'sale_countdown'               => 0,
				'stretch_product_desktop'      => 0,
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
				'product_quantity'             => 0,
				'grid_gallery'                 => '',
				'grid_gallery_control'         => '',
				'grid_gallery_enable_arrows'   => '',
				'offset'                       => '',
				'orderby'                      => '',
				'query_type'                   => 'OR',
				'order'                        => '',
				'meta_key'                     => '',
				'exclude'                      => '',
				'class'                        => '',
				'ajax_page'                    => '',
				'img_size'                     => 'woocommerce_thumbnail',
				'img_size_custom'              => array(),
				'force_not_ajax'               => 'no',
				'products_masonry'             => woodmart_get_opt( 'products_masonry' ),
				'products_different_sizes'     => woodmart_get_opt( 'products_different_sizes' ),
				'grid_items_different_sizes'   => '',
				'lazy_loading'                 => 'no',
				'el_class'                     => '',
				'shop_tools'                   => 'no',
				'query_post_type'              => 'product',
				'hide_out_of_stock'            => 'no',
				'css'                          => '',
				'woodmart_css_id'              => '',
				'ajax_recently_viewed'         => 'no',
				'pagination_arrows_position'   => '',
				'is_wishlist'                  => '',
				'wrapper_classes'              => '',
				'el_id'                        => '',
				'inner_content'                => '',
			)
		);
	}
}
