<?php

use XTS\Modules\Layouts\Global_Data;

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );}

/**
* ------------------------------------------------------------------------------------------------
* Product filters
* ------------------------------------------------------------------------------------------------
*/

if ( ! function_exists( 'woodmart_product_filters_shortcode' ) ) {
	function woodmart_product_filters_shortcode( $atts, $content ) {
		global $wp;

		$wrapper_classes = apply_filters( 'vc_shortcodes_css_class', '', '', $atts );

		$atts = shortcode_atts(
			array(
				'woodmart_css_id'          => '',
				'woodmart_color_scheme'    => '',
				'css'                      => '',
				'el_class'                 => '',
				'el_id'                    => '',
				'submit_form_on'           => 'click',
				'show_selected_values'     => 'yes',
				'show_dropdown_on'         => 'click',
				'style'                    => 'form',
				'display_grid'             => 'stretch',
				'display_grid_col'         => '',
				'display_grid_col_desktop' => '',
				'display_grid_col_tablet'  => '',
				'display_grid_col_mobile'  => '',
				'space_between'            => '10',
				'space_between_tablet'     => '',
				'space_between_mobile'     => '',
				'is_wpb'                   => true,
			),
			$atts
		);

		if ( $atts['is_wpb'] && 'wpb' === woodmart_get_current_page_builder() ) {
			$wrapper_classes .= ' wd-wpb';

			if ( ! empty( $atts['space_between'] ) ) {
				$atts['space_between_tablet'] = woodmart_vc_get_control_data( $atts['space_between'], 'tablet' );
				$atts['space_between_mobile'] = woodmart_vc_get_control_data( $atts['space_between'], 'mobile' );
				$atts['space_between']        = woodmart_vc_get_control_data( $atts['space_between'], 'desktop' );
			}

			$atts['display_grid_col_desktop'] = woodmart_vc_get_control_data( $atts['display_grid_col'], 'desktop' );
			$atts['display_grid_col_tablet']  = woodmart_vc_get_control_data( $atts['display_grid_col'], 'tablet' );
			$atts['display_grid_col_mobile']  = woodmart_vc_get_control_data( $atts['display_grid_col'], 'mobile' );
		}

		Global_Data::get_instance()->set_data( 'woodmart_product_filters_attr', $atts );

		extract( $atts );

		if ( function_exists( 'vc_shortcode_custom_css_class' ) ) {
			$wrapper_classes .= ' ' . vc_shortcode_custom_css_class( $css );
		}

		$classes     = '';
		$style_attrs = '';

		if ( 'number' === $atts['display_grid'] ) {
			$classes .= ' wd-grid-g';

			$style_attrs .= woodmart_get_grid_attrs(
				array(
					'columns'        => $display_grid_col_desktop,
					'columns_tablet' => $display_grid_col_tablet,
					'columns_mobile' => $display_grid_col_mobile,
				)
			);
		} elseif ( 'inline' === $atts['display_grid'] ) {
			$classes .= ' wd-grid-f-inline';
		} else {
			$classes .= ' wd-grid-f-stretch';
		}

		$style_attrs .= '--wd-gap-lg:' . $space_between . 'px;';

		if ( '' !== $space_between_tablet && $space_between_tablet !== $space_between ) {
			$style_attrs .= '--wd-gap-md:' . $space_between_tablet . 'px;';
		}
		if ( '' !== $space_between_mobile && $space_between_mobile !== $space_between_tablet ) {
			$style_attrs .= '--wd-gap-sm:' . $space_between_mobile . 'px;';
		}

		if ( ! empty( $woodmart_color_scheme ) ) {
			$classes .= ' color-scheme-' . $woodmart_color_scheme;
		}

		$classes .= ( $el_class ) ? ' ' . $el_class : '';

		$form_action = wc_get_page_permalink( 'shop' );

		if ( woodmart_is_shop_archive() && apply_filters( 'woodmart_filters_form_action_without_cat_widget', true ) ) {
			if ( '' === get_option( 'permalink_structure' ) ) {
				$form_action = remove_query_arg( array( 'page', 'paged', 'product-page' ), add_query_arg( $wp->query_string, '', home_url( $wp->request ) ) );
			} else {
				if ( is_search() ) {
					$home_url = add_query_arg( $wp->query_vars, home_url() );
				} else {
					$home_url = home_url( trailingslashit( $wp->request ) );
				}

				$form_action = preg_replace( '%\/page/[0-9]+%', '', $home_url );
			}
		}

		if ( woodmart_is_shop_archive() ) {
			$classes .= ' with-ajax';
		}

		$classes .= ' wd-style-' . $style;

		$classes .= woodmart_get_old_classes( ' woodmart-product-filters' );

		woodmart_enqueue_js_script( 'product-filters' );

		ob_start();

		woodmart_enqueue_inline_style( 'el-product-filters' );
		woodmart_enqueue_inline_style( 'woo-mod-swatches-base' );
		woodmart_enqueue_inline_style( 'woo-mod-swatches-filter' );
		?>
		<?php if ( $atts['is_wpb'] ) : ?>
			<div class="wd-product-filters-wrapp wd-wpb<?php echo esc_attr( $wrapper_classes ); ?>">
		<?php endif; ?>

		<form
		<?php if ( $el_id ) : ?>
		id="<?php echo esc_attr( $el_id ); ?>"
		<?php endif; ?>
		action="<?php echo esc_url( $form_action ); ?>" class="wd-product-filters<?php echo esc_attr( $classes ); ?>" method="GET" style="<?php echo esc_attr( $style_attrs ); ?>">
			<?php echo do_shortcode( $content ); ?>

			<?php if ( $is_wpb && 'click' === $submit_form_on ) : ?>
				<div class="wd-pf-btn wd-col">
					<button type="submit">
						<?php echo esc_html__( 'Filter', 'woodmart' ); ?>
					</button>
				</div>
			<?php endif; ?>
		</form>

		<?php if ( $atts['is_wpb'] ) : ?>
			</div>
		<?php endif; ?>
		<?php
		$output = ob_get_clean();

		if ( class_exists( 'WD_WPBakeryShortCodeFix' ) ) {
			$output = apply_filters( 'vc_shortcode_output', $output, new WD_WPBakeryShortCodeFix(), $atts, 'woodmart_info_box' );
		}

		return $output;
	}
}

/**
* ------------------------------------------------------------------------------------------------
* Categories widget
* ------------------------------------------------------------------------------------------------
*/
if ( ! function_exists( 'woodmart_filters_categories_shortcode' ) ) {
	function woodmart_filters_categories_shortcode( $atts, $content ) {
		global $wp_query, $post;

		$woodmart_product_filters_attr = (array) Global_Data::get_instance()->get_data( 'woodmart_product_filters_attr' );
		$classes                       = '';

		if ( isset( $atts['show_dropdown_on'] ) ) {
			$woodmart_product_filters_attr = array_merge( $woodmart_product_filters_attr, $atts );
		}

		extract(
			shortcode_atts(
				array(
					'title'                     => esc_html__( 'Categories', 'woodmart' ),
					'hierarchical'              => 1,
					'order_by'                  => 'name',
					'hide_empty'                => '',
					'show_categories_ancestors' => '',
					'el_class'                  => '',
					'el_id'                     => 'wd-' . uniqid(),
				),
				$atts
			)
		);

		$classes .= ( $el_class ) ? ' ' . $el_class : '';

		$list_args = array(
			'hierarchical'       => $hierarchical,
			'taxonomy'           => 'product_cat',
			'hide_empty'         => $hide_empty,
			'title_li'           => false,
			'walker'             => new WOODMART_Custom_Walker_Category(),
			'use_desc_for_title' => false,
			'orderby'            => $order_by,
			'echo'               => true,
		);

		if ( 'order' === $order_by ) {
			$list_args['orderby']  = 'meta_value_num';
			$list_args['meta_key'] = 'order';
		}

		$cat_ancestors = array();

		if ( is_tax( 'product_cat' ) ) {
			$current_cat   = $wp_query->queried_object;
			$cat_ancestors = get_ancestors( $current_cat->term_id, 'product_cat' );
		}

		$list_args['current_category']           = ( isset( $current_cat ) ) ? $current_cat->term_id : '';
		$list_args['current_category_ancestors'] = $cat_ancestors;
		$list_args['active_filter_url']          = woodmart_filters_get_page_base_url();

		if ( $show_categories_ancestors && isset( $current_cat ) ) {
			$is_cat_has_children = get_term_children( $current_cat->term_id, 'product_cat' );
			if ( $is_cat_has_children ) {
				$list_args['child_of'] = $current_cat->term_id;
			} elseif ( $current_cat->parent != 0 ) {
				$list_args['child_of'] = $current_cat->parent;
			}
			$list_args['depth'] = 1;
		}

		ob_start();
		?>
			<div id="<?php echo esc_attr( $el_id ); ?>" class="wd-pf-checkboxes wd-col wd-pf-categories wd-event-<?php echo esc_attr( $woodmart_product_filters_attr['show_dropdown_on'] ); ?><?php echo esc_attr( $classes ); ?>">
			<div class="wd-pf-title">
				<span class="title-text">
					<?php echo esc_html( $title ); ?>
				</span>
				<?php if ( 'yes' === $woodmart_product_filters_attr['show_selected_values'] ) : ?>
					<ul class="wd-pf-results">
						<?php if ( isset( $current_cat ) && ! is_null( $current_cat ) ) : ?>
							<li class="selected-value" data-title="<?php echo esc_attr( $current_cat->slug ); ?>">
								<?php echo esc_attr( $current_cat->name ); ?>
							</li>
						<?php endif; ?>
					</ul>
				<?php endif; ?>
			</div>

			<div class="wd-pf-dropdown wd-dropdown">
				<div class="wd-scroll">
					<ul class="wd-scroll-content">
					<?php if ( $show_categories_ancestors && isset( $current_cat ) && $is_cat_has_children ) : ?>
						<li style="display:none;" class="wd-active cat-item cat-item-<?php echo esc_attr( $current_cat->term_id ); ?>">
							<a class="pf-value" href="<?php echo esc_url( get_category_link( $current_cat->term_id ) ); ?>" data-val="<?php echo esc_attr( $current_cat->slug ); ?>" data-title="<?php echo esc_attr( $current_cat->name ); ?>">
								<?php echo esc_html( $current_cat->name ); ?>
							</a>
						</li>
					<?php endif; ?>
					<?php wp_list_categories( $list_args ); ?>
					</ul>
				</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

if ( ! function_exists( 'woodmart_stock_status_shortcode' ) ) {
	function woodmart_stock_status_shortcode( $atts ) {
		$woodmart_product_filters_attr = (array) Global_Data::get_instance()->get_data( 'woodmart_product_filters_attr' );
		$filter_name                   = 'stock_status';
		$current_filter                = isset( $_GET[ $filter_name ] ) ? explode( ',', $_GET[ $filter_name ] ) : array();
		$result_value                  = isset( $_GET[ $filter_name ] ) ? $_GET[ $filter_name ]: '';
		$link                          = woodmart_filters_get_page_base_url();
		$options                       = array(
			'onsale'      => esc_html__( 'On sale', 'woodmart' ),
			'instock'     => esc_html__( 'In stock', 'woodmart' ),
			'onbackorder' => esc_html__( 'On backorder', 'woodmart' ),
		);

		foreach ( $options as $key => $value ) {
			if ( empty( $atts[ $key ] ) ) {
				unset( $options[ $key ] );
			}
		}

		if ( isset( $atts['show_dropdown_on'] ) ) {
			$woodmart_product_filters_attr = array_merge( $woodmart_product_filters_attr, $atts );
		}

		extract(
			shortcode_atts(
				array(
					'title'       => esc_html__( 'Stock status', 'woodmart' ),
					'instock'     => 1,
					'onsale'      => 1,
					'onbackorder' => 1,
					'el_class'    => '',
					'el_id'       => '',
				),
				$atts
			)
		);

		ob_start();
		?>
			<div
			<?php if ( $el_id ) : ?>
			id="<?php echo esc_attr( $el_id ); ?>"
			<?php endif; ?>
			class="wd-pf-checkboxes wd-col wd-pf-stock multi_select wd-event-<?php echo esc_attr( $woodmart_product_filters_attr['show_dropdown_on'] ); ?><?php echo esc_attr( $el_class ); ?>">
				<input type="hidden" class="result-input" name="stock_status" value="<?php echo esc_attr( $result_value ); ?>">
				<div class="wd-pf-title">
					<span class="title-text"><?php echo esc_html( $title ); ?></span>
					<?php if ( 'yes' === $woodmart_product_filters_attr['show_selected_values'] ) : ?>
						<ul class="wd-pf-results">
							<?php if ( isset( $current_filter ) && ! empty( $current_filter ) ) : ?>
								<?php foreach ( $current_filter as $filter ) : ?>
									<?php if ( isset( $options[ $filter ] ) ) : ?>
										<li class="selected-value" data-title="<?php echo esc_attr( $filter ); ?>">
											<?php echo esc_attr( $options[ $filter ] ); ?>
										</li>
									<?php endif; ?>
								<?php endforeach; ?>
							<?php endif; ?>
						</ul>
					<?php endif; ?>
				</div>

				<div class="wd-pf-dropdown wd-dropdown">
					<div class="wd-scroll">
						<ul class="wd-scroll-content">
						<?php foreach ( $options as $slug => $name ) : ?>
							<?php
							$current_filter   = ! empty( $_GET[ $filter_name ] ) ? explode( ',', $_GET[ $filter_name ] ) : array();
							$is_active_filter = in_array( $slug, $current_filter, true );
							$link             = remove_query_arg( $filter_name, $link );

							if ( $is_active_filter ) {
								$remove_key = array_search( $slug, $current_filter, true );
								unset( $current_filter[ $remove_key ] );
							} else {
								$current_filter[] = $slug;
							}

							if ( ! empty( $current_filter ) ) {
								$link = add_query_arg(
									array(
										$filter_name => implode( ',', $current_filter ),
									),
									$link
								);
							}

							$link = str_replace( '%2C', ',', $link );
							?>

							<li class="<?php echo $is_active_filter ? esc_attr( 'wd-active' ) : ''; ?>">
								<a href="<?php echo esc_url( $link ); ?>" rel="nofollow noopener" class="pf-value" data-val="<?php echo esc_attr( $slug ); ?>" data-title="<?php echo esc_attr( $name ); ?>">
									<?php echo esc_html( $name ); ?>
								</a>
							</li>
						<?php endforeach; ?>
						</ul>
					</div>
				</div>
			</div>
		<?php

		return ob_get_clean();
	}
}

if ( ! function_exists( 'woodmart_filters_attribute_shortcode' ) ) {
	function woodmart_filters_attribute_shortcode( $atts, $content ) {
		$woodmart_product_filters_attr = (array) Global_Data::get_instance()->get_data( 'woodmart_product_filters_attr' );

		if ( isset( $atts['show_dropdown_on'] ) ) {
			$woodmart_product_filters_attr = array_merge( $woodmart_product_filters_attr, $atts );
		}

		extract(
			shortcode_atts(
				array(
					'title'        => esc_html__( 'Filter by', 'woodmart' ),
					'attribute'    => '',
					'categories'   => '',
					'query_type'   => 'and',
					'size'         => 'normal',
					'shape'        => 'inherit',
					'swatch_style' => 'inherit',
					'display'      => 'list',
					'labels'       => 1,
					'el_class'     => '',
					'el_id'        => '',
				),
				$atts
			)
		);

		if ( isset( $categories ) ) {
			$categories = explode( ',', $categories );
			$categories = array_map( 'trim', $categories );
		} else {
			$categories = array();
		}

		ob_start();

		the_widget(
			'WOODMART_Widget_Layered_Nav',
			array(
				'template'             => 'filter-element',
				'attribute'            => $attribute,
				'query_type'           => $query_type,
				'size'                 => $size,
				'style'                => $swatch_style,
				'shape'                => $shape,
				'labels'               => $labels,
				'filter-title'         => $title,
				'display'              => $display,
				'categories'           => $categories,
				'show_selected_values' => isset( $woodmart_product_filters_attr['show_selected_values'] ) ? $woodmart_product_filters_attr['show_selected_values'] : 'yes',
				'show_dropdown_on'     => isset( $woodmart_product_filters_attr['show_dropdown_on'] ) ? $woodmart_product_filters_attr['show_dropdown_on'] : 'yes',
				'wrapper_class'        => ' ' . $el_class,
				'el_id'                => $el_id,
			),
			array(
				'before_widget' => '',
				'after_widget'  => '',
			)
		);

		return ob_get_clean();

	}
}

/**
* ------------------------------------------------------------------------------------------------
* Price slider widget
* ------------------------------------------------------------------------------------------------
*/
if ( ! function_exists( 'woodmart_filters_price_slider_shortcode' ) ) {
	function woodmart_filters_price_slider_shortcode( $atts, $content ) {
		global $wpdb;

		$woodmart_product_filters_attr = (array) Global_Data::get_instance()->get_data( 'woodmart_product_filters_attr' );
		$classes                       = '';

		if ( isset( $atts['show_dropdown_on'] ) ) {
			$woodmart_product_filters_attr = array_merge( $woodmart_product_filters_attr, $atts );
		}

		extract(
			shortcode_atts(
				array(
					'title'    => esc_html__( 'Filter by price', 'woodmart' ),
					'el_class' => '',
					'el_id'    => 'wd-' . uniqid(),
				),
				$atts
			)
		);

		$classes .= ( $el_class ) ? ' ' . $el_class : '';

		wp_localize_script(
			'woodmart-theme',
			'woocommerce_price_slider_params',
			array(
				'currency_format_num_decimals' => 0,
				'currency_format_symbol'       => get_woocommerce_currency_symbol(),
				'currency_format_decimal_sep'  => esc_attr( wc_get_price_decimal_separator() ),
				'currency_format_thousand_sep' => esc_attr( wc_get_price_thousand_separator() ),
				'currency_format'              => esc_attr( str_replace( array( '%1$s', '%2$s' ), array( '%s', '%v' ), get_woocommerce_price_format() ) ),
			)
		);
		wp_enqueue_script( 'jquery-ui-slider' );
		wp_enqueue_script( 'wc-jquery-ui-touchpunch' );
		wp_enqueue_script( 'accounting' );

		$link = woodmart_filters_get_page_base_url();

		ob_start();

		woodmart_enqueue_inline_style( 'widget-slider-price-filter' );

		// WC 3.6.0
		if ( function_exists( 'WC' ) && version_compare( WC()->version, '3.6.0', '<' ) ) {
			$prices = woodmart_get_filtered_price();
		} else {
			$prices = woodmart_get_filtered_price_new();
		}

		$min_price = isset( $prices->min_price ) ? $prices->min_price : 0;
		$max_price = isset( $prices->max_price ) ? $prices->max_price : 0;

		// Check to see if we should add taxes to the prices if store are excl tax but display incl.
		if ( wc_tax_enabled() && ! wc_prices_include_tax() && 'incl' === get_option( 'woocommerce_tax_display_shop' ) ) {
			$tax_class = apply_filters( 'woocommerce_price_filter_widget_tax_class', '' ); // Uses standard tax class.
			$tax_rates = WC_Tax::get_rates( $tax_class );

			if ( $tax_rates ) {
				$min_price += WC_Tax::get_tax_total( WC_Tax::calc_exclusive_tax( $min_price, $tax_rates ) );
				$max_price += WC_Tax::get_tax_total( WC_Tax::calc_exclusive_tax( $max_price, $tax_rates ) );
			}
		}

		$min = apply_filters( 'woocommerce_price_filter_widget_min_amount', floor( $min_price ) );
		$max = apply_filters( 'woocommerce_price_filter_widget_max_amount', ceil( $max_price ) );

		if ( $min === $max || ( ( is_shop() || is_product_taxonomy() ) && ! wc()->query->get_main_query()->post_count && ! $max ) ) {
			return ob_get_clean();
		}

		$min_price = isset( $_GET['min_price'] ) ? wc_clean( wp_unslash( $_GET['min_price'] ) ) : $min;
		$max_price = isset( $_GET['max_price'] ) ? wc_clean( wp_unslash( $_GET['max_price'] ) ) : $max;

		?>
		<div
		<?php if ( $el_id ) : ?>
		id="<?php echo esc_attr( $el_id ); ?>"
		<?php endif; ?>
		class="wd-pf-checkboxes wd-col wd-pf-price-range multi_select widget_price_filter wd-event-<?php echo esc_attr( $woodmart_product_filters_attr['show_dropdown_on'] ); ?><?php echo esc_attr( $classes ); ?>">
			<div class="wd-pf-title">
				<span class="title-text">
					<?php echo esc_html( $title ); ?>
				</span>
				<?php if ( 'yes' === $woodmart_product_filters_attr['show_selected_values'] ) : ?>
					<ul class="wd-pf-results"></ul>
				<?php endif; ?>
			</div>
			<div class="wd-pf-dropdown wd-dropdown">
				<div class="price_slider_wrapper">
					<div class="price_slider_widget" style="display:none;"></div>

					<div class="filter_price_slider_amount">
						<input type="hidden" class="min_price" name="min_price" value="<?php echo esc_attr( $min_price ); ?>" data-min="<?php echo esc_attr( $min ); ?>">
						<input type="hidden" class="max_price" name="max_price" value="<?php echo esc_attr( $max_price ); ?>" data-max="<?php echo esc_attr( $max ); ?>">

						<?php if ( 'select' === $woodmart_product_filters_attr['submit_form_on'] ) : ?>
							<a href="<?php echo esc_url( $link ); ?>" class="button pf-value"><?php echo esc_html__( 'Filter', 'woodmart' ); ?></a>
						<?php endif; ?>

						<div class="price_label" style="display:none;"><span class="from"></span><span class="to"></span></div>
					</div>
				</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}

if ( ! function_exists( 'woodmart_get_filtered_price' ) ) {
	function woodmart_get_filtered_price() {
		global $wpdb;

		if ( ! is_shop() && ! is_product_taxonomy() ) {
			$sql = "SELECT min( FLOOR( price_meta.meta_value ) ) as min_price, max( CEILING( price_meta.meta_value ) ) as max_price FROM {$wpdb->posts} LEFT JOIN {$wpdb->postmeta} as price_meta ON {$wpdb->posts}.ID = price_meta.post_id WHERE {$wpdb->posts}.post_type = 'product' AND {$wpdb->posts}.post_status = 'publish' AND price_meta.meta_key = '_price'";

			return $wpdb->get_row( $sql );
		}

		$args       = wc()->query->get_main_query()->query_vars;
		$tax_query  = isset( $args['tax_query'] ) ? $args['tax_query'] : array();
		$meta_query = isset( $args['meta_query'] ) ? $args['meta_query'] : array();

		if ( ! is_post_type_archive( 'product' ) && ! empty( $args['taxonomy'] ) && ! empty( $args['term'] ) ) {
			$tax_query[] = array(
				'taxonomy' => $args['taxonomy'],
				'terms'    => array( $args['term'] ),
				'field'    => 'slug',
			);
		}

		foreach ( $meta_query + $tax_query as $key => $query ) {
			if ( ! empty( $query['price_filter'] ) || ! empty( $query['rating_filter'] ) ) {
				unset( $meta_query[ $key ] );
			}
		}

		$meta_query = new WP_Meta_Query( $meta_query );
		$tax_query  = new WP_Tax_Query( $tax_query );

		$meta_query_sql = $meta_query->get_sql( 'post', $wpdb->posts, 'ID' );
		$tax_query_sql  = $tax_query->get_sql( $wpdb->posts, 'ID' );

		$sql  = "SELECT min( FLOOR( price_meta.meta_value ) ) as min_price, max( CEILING( price_meta.meta_value ) ) as max_price FROM {$wpdb->posts} ";
		$sql .= " LEFT JOIN {$wpdb->postmeta} as price_meta ON {$wpdb->posts}.ID = price_meta.post_id " . $tax_query_sql['join'] . $meta_query_sql['join'];
		$sql .= " 	WHERE {$wpdb->posts}.post_type IN ('" . implode( "','", array_map( 'esc_sql', apply_filters( 'woocommerce_price_filter_post_type', array( 'product' ) ) ) ) . "')
			AND {$wpdb->posts}.post_status = 'publish'
			AND price_meta.meta_key IN ('" . implode( "','", array_map( 'esc_sql', apply_filters( 'woocommerce_price_filter_meta_keys', array( '_price' ) ) ) ) . "')
			AND price_meta.meta_value > '' ";
		$sql .= $tax_query_sql['where'] . $meta_query_sql['where'];

		$search = WC_Query::get_main_search_query_sql();
		if ( $search ) {
			$sql .= ' AND ' . $search;
		}

		return $wpdb->get_row( $sql );
	}
}

if ( ! function_exists( 'woodmart_orderby_filter_template' ) ) {
	function woodmart_orderby_filter_template( $atts ) {
		$woodmart_product_filters_attr = (array) Global_Data::get_instance()->get_data( 'woodmart_product_filters_attr' );
		$current_filter                = isset( $_GET['orderby'] ) ? $_GET['orderby'] : '';
		$el_class                      = ! empty( $atts['el_class'] ) ? ' ' . $atts['el_class'] : '';
		$el_id                         = ! empty( $atts['el_id'] ) ? $atts['el_id'] : '';
		$title                         = ! empty( $atts['title'] ) ? $atts['title'] : esc_html__( 'Sort by', 'woodmart' );
		$link                          = woodmart_filters_get_page_base_url();

		if ( isset( $atts['show_dropdown_on'] ) ) {
			$woodmart_product_filters_attr = array_merge( $woodmart_product_filters_attr, $atts );
		}

		$options = apply_filters(
			'woocommerce_catalog_orderby',
			array(
				'menu_order' => esc_html__( 'Default sorting', 'woocommerce' ),
				'popularity' => esc_html__( 'Sort by popularity', 'woocommerce' ),
				'rating'     => esc_html__( 'Sort by average rating', 'woocommerce' ),
				'date'       => esc_html__( 'Sort by latest', 'woocommerce' ),
				'price'      => esc_html__( 'Sort by price: low to high', 'woocommerce' ),
				'price-desc' => esc_html__( 'Sort by price: high to low', 'woocommerce' ),
			)
		);

		ob_start();
		?>
		<div
		<?php if ( $el_id ) : ?>
		id="<?php echo esc_attr( $el_id ); ?>"
		<?php endif; ?>
		class="wd-pf-checkboxes wd-col wd-pf-sortby wd-event-<?php echo esc_attr( $woodmart_product_filters_attr['show_dropdown_on'] ); ?><?php echo esc_attr( $el_class ); ?>">
			<input type="hidden" class="result-input" name="orderby" value="<?php echo ! empty( $current_filter ) ? esc_attr( $current_filter ) : ''; ?>">

			<div class="wd-pf-title">
				<span class="title-text">
					<?php echo esc_html( $title ); ?>
				</span>

				<?php if ( 'yes' === $woodmart_product_filters_attr['show_selected_values'] ) : ?>
					<ul class="wd-pf-results">
						<?php if ( ! empty( $current_filter ) && array_key_exists( $current_filter, $options ) ) : ?>
							<li class="selected-value" data-title="<?php echo esc_attr( $current_filter ); ?>">
								<?php echo esc_attr( $options[ $current_filter ] ); ?>
							</li>
						<?php endif; ?>
					</ul>
				<?php endif; ?>
			</div>

			<div class="wd-pf-dropdown wd-dropdown">
				<div class="wd-scroll">
					<ul class="wd-scroll-content">
						<?php foreach ( $options as $key => $value ) : ?>
							<?php
							$is_active_filter = $key === $current_filter;
							$link             = add_query_arg(
								array(
									'orderby' => $key,
								),
								$link
							);

							if ( $is_active_filter ) {
								$link = remove_query_arg(
									'orderby',
									$link
								);
							}
							?>

							<li class="<?php echo $is_active_filter ? esc_attr( 'wd-active' ) : ''; ?>">
								<a href="<?php echo esc_url( $link ); ?>" rel="nofollow noopener" class="pf-value" data-val="<?php echo esc_attr( $key ); ?>" data-title="<?php echo esc_attr( $value ); ?>">
									<?php echo esc_html( $value ); ?>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
		</div>
		<?php

		return ob_get_clean();
	}
}
