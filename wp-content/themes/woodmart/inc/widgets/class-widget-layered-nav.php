<?php use Automattic\WooCommerce\Internal\ProductAttributesLookup\Filterer;

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

/**
 * Color filter widget
 */

if ( ! class_exists( 'WOODMART_Widget_Layered_Nav' ) ) {
	class WOODMART_Widget_Layered_Nav extends WPH_Widget {
		function __construct() {
			if ( ! woodmart_woocommerce_installed() || ! function_exists( 'wc_get_attribute_taxonomies' ) ) {
				return;
			}

			// Configure widget array
			$args = array(
				// Widget Backend label
				'label'       => esc_html__( 'WOODMART WooCommerce Layered Nav', 'woodmart' ),
				// Widget Backend Description
				'description' => esc_html__( 'Shows a custom attribute in a widget which lets you narrow down the list of products when viewing product categories.', 'woodmart' ),
				'slug'        => 'woodmart-woocommerce-layered-nav',
			);

			// Configure the widget fields

			// fields array
			$args['fields'] = array(
				array(
					'id'   => 'title',
					'type' => 'text',
					'std'  => esc_html__( 'Filter by', 'woodmart' ),
					'name' => esc_html__( 'Title', 'woodmart' ),
				),
				array(
					'id'     => 'attribute',
					'type'   => 'dropdown',
					'std'    => '',
					'name'   => esc_html__( 'Attribute', 'woodmart' ),
					'callback' => 'get_layered_get_attributes_options',
				),
				array(
					'id'      => 'category',
					'type'    => 'select2',
					'default' => array( 'all' ),
					'name'    => esc_html__( 'Show on category', 'woodmart' ),
					'callback'  => 'get_layered_get_categories_options',
					'fields' => array(),
				),
				array(
					'id'     => 'query_type',
					'type'   => 'dropdown',
					'std'    => 'and',
					'name'   => esc_html__( 'Query type', 'woodmart' ),
					'fields' => array(
						esc_html__( 'AND', 'woodmart' ) => 'and',
						esc_html__( 'OR', 'woodmart' )  => 'or',
					),
				),
				array(
					'id'         => 'display',
					'param_name' => 'display',
					'type'       => 'dropdown',
					'std'        => 'list',
					'name'       => esc_html__( 'Layout', 'woodmart' ),
					'fields'     => array(
						esc_html__( 'List', 'woodmart' ) => 'list',
						esc_html__( '2 columns', 'woodmart' ) => 'double',
						esc_html__( 'Inline', 'woodmart' ) => 'inline',
						esc_html__( 'Dropdown', 'woodmart' ) => 'dropdown'
					)
				),
				array(
					'id'     => 'size',
					'type'   => 'dropdown',
					'std'    => 'normal',
					'name'   => esc_html__( 'Swatches size', 'woodmart' ),
					'fields' => array(
						esc_html__( 'Small', 'woodmart' )  => 'small',
						esc_html__( 'Medium', 'woodmart' ) => 'normal',
						esc_html__( 'Large', 'woodmart' )  => 'large',
					)
				),
				array(
					'id'     => 'style',
					'type'   => 'dropdown',
					'std'    => 'inherit',
					'name'   => esc_html__( 'Swatch style', 'woodmart' ),
					'fields' => array(
						esc_html__( 'Inherit', 'woodmart' ) => 'inherit',
						esc_html__( 'Style 1', 'woodmart' ) => '1',
						esc_html__( 'Style 2', 'woodmart' ) => '2',
						esc_html__( 'Style 3', 'woodmart' ) => '3',
						esc_html__( 'Style 4', 'woodmart' ) => '4',
					),
				),
				array(
					'id'     => 'shape',
					'type'   => 'dropdown',
					'std'    => 'round',
					'name'   => esc_html__( 'Swatches shape', 'woodmart' ),
					'fields' => array(
						esc_html__( 'Inherit', 'woodmart' ) => 'inherit',
						esc_html__( 'Round', 'woodmart' )  => 'round',
						esc_html__( 'Rounded', 'woodmart' ) => 'rounded',
						esc_html__( 'Square', 'woodmart' ) => 'square',
					),
				),
				array(
					'id'     => 'labels',
					'type'   => 'dropdown',
					'std'    => 'on',
					'name'   => esc_html__( 'Show labels', 'woodmart' ),
					'fields' => array(
						esc_html__( 'ON', 'woodmart' )  => 'on',
						esc_html__( 'OFF', 'woodmart' ) => 'off',
					),
				),
				array(
					'id'     => 'tooltips',
					'type'   => 'dropdown',
					'std'    => 'on',
					'name'   => esc_html__( 'Show tooltips', 'woodmart' ),
					'fields' => array(
						esc_html__( 'OFF', 'woodmart' ) => 'off',
						esc_html__( 'ON', 'woodmart' )  => 'on',
					),
				),
				array(
					'id'     => 'checkboxes',
					'type'   => 'dropdown',
					'std'    => 'off',
					'name'   => esc_html__( 'Show checkboxes', 'woodmart' ),
					'fields' => array(
						esc_html__( 'OFF', 'woodmart' ) => 'off',
						esc_html__( 'ON', 'woodmart' )  => 'on',
					),
				),
				array(
					'id'         => 'search_by_filters',
					'type'       => 'checkbox',
					'name'       => esc_html__( 'Show search input for this attribute', 'woodmart' ),
					'dependency' => array(
						'element'            => 'display',
						'value_not_equal_to' => array( 'dropdown' ),
					),
				),
			);

			// create widget
			$this->create_widget( $args );
		}

		// Output function
		// Based on woo widget @version  2.3.0
		function widget( $args, $instance ) {
			$_chosen_attributes = $this->get_chosen_attributes();
			$taxonomy           = isset( $instance['attribute'] ) ? wc_attribute_taxonomy_name( $instance['attribute'] ) : '';
			$category           = isset( $instance['category'] ) ? $instance['category'] : array( 'all' );
			$query_type         = isset( $instance['query_type'] ) ? $instance['query_type'] : 'and';
			$display            = isset( $instance['display'] ) ? $instance['display'] : 'list';
			$template           = isset( $instance['template'] ) ? $instance['template'] : 'default';
			$wrapper_classes    = '';

			if ( ! $this->is_widget_preview() && ! is_shop() && ! is_product_taxonomy() && $template == 'default' ) {
				return;
			}

			$current_cat = get_queried_object();

			if ( ! is_array( $category ) ) {
				$category = explode( ',', $category );
			}

			if ( ! is_tax() && ! in_array( 'all', $category ) ) {
				return;
			}

			if ( ! in_array( 'all', $category ) && property_exists( $current_cat, 'term_id' ) && ! in_array( $current_cat->term_id, $category ) && ! in_array( $current_cat->parent, $category ) ) {
				return;
			}

			if ( isset( $instance['attribute'] ) && 'product_brand' === $instance['attribute'] && taxonomy_exists( 'product_brand' ) ) {
				$taxonomy = 'product_brand';
			}

			if ( ! taxonomy_exists( $taxonomy ) ) {
				return;
			}

			$get_terms_args = array( 'hide_empty' => '1' );

			$orderby = wc_attribute_orderby( $taxonomy );

			switch ( $orderby ) {
				case 'name':
					$get_terms_args['orderby']    = 'name';
					$get_terms_args['menu_order'] = false;
					break;
				case 'id':
					$get_terms_args['orderby']    = 'id';
					$get_terms_args['order']      = 'ASC';
					$get_terms_args['menu_order'] = false;
					break;
				case 'menu_order':
					$get_terms_args['menu_order'] = 'ASC';
					break;
			}

			$terms = get_terms( $taxonomy, $get_terms_args );

			if ( 0 === count( $terms ) ) {
				return;
			}

			if ( 'layered-nav' === woodmart_get_opt( 'shop_widgets_collapse' ) ) {
				$wrapper_classes .= ' wd-widget-collapse';
			}

			if ( 'disable' !== woodmart_get_opt( 'shop_widgets_collapse', 'disable' ) && is_array( $_chosen_attributes ) && array_key_exists( $taxonomy, $_chosen_attributes ) ) {
				$wrapper_classes .= ' wd-opened-initially wd-opened';
			}

			if ( $wrapper_classes ) {
				$args['before_widget'] = str_replace( 'class="', 'class="' . $wrapper_classes . ' ', $args['before_widget'] );
			}

			if ( isset( $instance['search_by_filters'] ) && $instance['search_by_filters'] ) {
				woodmart_enqueue_inline_style( 'filter-search' );
				woodmart_enqueue_js_script( 'search-by-filters' );
			}

			ob_start();

			echo wp_kses_post( $args['before_widget'] );

			if ( $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance ) ) {
				echo wp_kses_post( $args['before_title'] ) . $title . wp_kses_post( $args['after_title'] );
			}
			if ( $template == 'default' ) {
				if ( 'dropdown' === $display ) {
					wp_enqueue_script( 'selectWoo' );
					wp_enqueue_style( 'select2' );
					woodmart_enqueue_inline_style( 'woo-mod-widget-dropdown-form' );

					$found = $this->layered_nav_dropdown( $terms, $taxonomy, $query_type );
				} else {
					$found = $this->layered_nav_list( $terms, $taxonomy, $query_type, $instance );
				}
			} else {
				$found = $this->layered_nav_checkbox_list( $terms, $taxonomy, $query_type, $instance );
			}

			echo wp_kses_post( $args['after_widget'] );

			// Force found when option is selected - do not force found on taxonomy attributes
			if ( ! is_tax() && is_array( $_chosen_attributes ) && array_key_exists( $taxonomy, $_chosen_attributes ) ) {
				$found = true;
			}

			if ( ! $found ) {
				ob_end_clean();
			} else {
				echo ob_get_clean();
			}
		}

		/**
		 * Return the currently viewed taxonomy name.
		 *
		 * @return string
		 */
		protected function get_current_taxonomy() {
			return is_tax() ? get_queried_object()->taxonomy : '';
		}

		/**
		 * Return the currently viewed term ID.
		 *
		 * @return int
		 */
		protected function get_current_term_id() {
			return absint( is_tax() ? get_queried_object()->term_id : 0 );
		}

		/**
		 * Return the currently viewed term slug.
		 *
		 * @return int
		 */
		protected function get_current_term_slug() {
			return absint( is_tax() ? get_queried_object()->slug : 0 );
		}

		/**
		 * Show dropdown layered nav.
		 *
		 * @param  array  $terms Terms.
		 * @param  string $taxonomy Taxonomy.
		 * @param  string $query_type Query Type.
		 * @return bool Will nav display?
		 */
		protected function layered_nav_dropdown( $terms, $taxonomy, $query_type ) {
			global $wp;
			$found = false;

			if ( $taxonomy !== $this->get_current_taxonomy() ) {
				$term_counts          = $this->get_filtered_term_product_counts( wp_list_pluck( $terms, 'term_id' ), $taxonomy, $query_type );
				$_chosen_attributes   = $this->get_chosen_attributes();
				$taxonomy_filter_name = str_replace( 'pa_', '', $taxonomy );
				$taxonomy_label       = wc_attribute_label( $taxonomy );

				if ( 'product_brand' === $taxonomy ) {
					$current_taxonomy = get_taxonomy( $taxonomy );
					$taxonomy_label   = $current_taxonomy->labels->singular_name;
				}

				/* translators: %s: taxonomy name */
				$any_label      = apply_filters( 'woocommerce_layered_nav_any_label', sprintf( __( 'Any %s', 'woodmart' ), $taxonomy_label ), $taxonomy_label, $taxonomy );
				$multiple       = 'or' === $query_type;
				$current_values = isset( $_chosen_attributes[ $taxonomy ]['terms'] ) ? $_chosen_attributes[ $taxonomy ]['terms'] : array();

				if ( '' === get_option( 'permalink_structure' ) ) {
					$form_action = remove_query_arg( array( 'page', 'paged' ), add_query_arg( $wp->query_string, '', home_url( $wp->request ) ) );
				} else {
					$form_action = preg_replace( '%\/page/[0-9]+%', '', home_url( trailingslashit( $wp->request ) ) );
				}

				woodmart_enqueue_js_script( 'filter-dropdowns' );

				echo '<form method="get" action="' . esc_url( $form_action ) . '" class="wd-widget-layered-nav-dropdown-form wd-filter-form">';
				echo '<select class="wd-widget-layered-nav-dropdown woodmart_dropdown_layered_nav_' . esc_attr( $taxonomy_filter_name ) . '"' . ( $multiple ? 'multiple="multiple"' : '' ) . ' data-placeholder="' . esc_attr( $any_label ) . '" data-noResults="' . esc_html__( 'No matches found', 'woodmart' ) . '" data-slug="' . esc_attr( $taxonomy_filter_name ) . '">';
				echo '<option value="">' . esc_html( $any_label ) . '</option>';

				foreach ( $terms as $term ) {

					// If on a term page, skip that term in widget list.
					if ( $term->term_id === $this->get_current_term_id() ) {
						continue;
					}

					// Get count based on current view.
					$option_is_set = in_array( $term->slug, $current_values, true ) || in_array( $term->term_id, $current_values );
					$count         = isset( $term_counts[ $term->term_id ] ) ? $term_counts[ $term->term_id ] : 0;

					// Only show options with count > 0.
					if ( 0 < $count ) {
						$found = true;
					} elseif ( 0 === $count && ! $option_is_set ) {
						continue;
					}

					$term_value = 'product_brand' === $taxonomy ? $term->term_id : $term->slug;

					echo '<option value="' . esc_attr( urldecode( $term_value ) ) . '" ' . selected( $option_is_set, true, false ) . '>' . esc_html( $term->name ) . '</option>';
				}

				echo '</select>';

				if ( $multiple ) {
					echo '<button class="wd-widget-layered-nav-dropdown__submit" type="submit" value="' . esc_attr__( 'Apply', 'woodmart' ) . '">' . esc_html__( 'Apply', 'woodmart' ) . '</button>';
				}

				if ( 'or' === $query_type ) {
					echo '<input type="hidden" name="query_type_' . esc_attr( $taxonomy_filter_name ) . '" value="or" />';
				}

				echo '<input type="hidden" name="filter_' . esc_attr( $taxonomy_filter_name ) . '" value="' . esc_attr( implode( ',', $current_values ) ) . '" />';
				echo wc_query_string_form_fields( null, array( 'filter_' . $taxonomy_filter_name, 'query_type_' . $taxonomy_filter_name ), '', true ); // @codingStandardsIgnoreLine
				echo '</form>';
			}

			return $found;
		}

		/**
		 * Count products within certain terms, taking the main WP query into consideration.
		 *
		 * This query allows counts to be generated based on the viewed products, not all products.
		 *
		 * @param  array  $term_ids Term IDs.
		 * @param  string $taxonomy Taxonomy.
		 * @param  string $query_type Query Type.
		 * @return array
		 */
		protected function get_filtered_term_product_counts( $term_ids, $taxonomy, $query_type ) {
			if ( ( function_exists( 'WC' ) && version_compare( WC()->version, '5.5.0', '<' ) ) || 'product_brand' === $taxonomy ) {
				global $wpdb;

				$tax_query  = WC_Query::get_main_tax_query();
				$meta_query = WC_Query::get_main_meta_query();
				if ( 'or' === $query_type ) {
					foreach ( $tax_query as $key => $query ) {
						if ( is_array( $query ) && $taxonomy === $query['taxonomy'] ) {
							unset( $tax_query[ $key ] );
						}
					}
				}

				$meta_query     = new WP_Meta_Query( $meta_query );
				$tax_query      = new WP_Tax_Query( $tax_query );
				$meta_query_sql = $meta_query->get_sql( 'post', $wpdb->posts, 'ID' );
				$tax_query_sql  = $tax_query->get_sql( $wpdb->posts, 'ID' );

				// Generate query
				$query           = array();
				$query['select'] = "SELECT COUNT( DISTINCT {$wpdb->posts}.ID ) as term_count, terms.term_id as term_count_id";
				$query['from']   = "FROM {$wpdb->posts}";
				$query['join']   = "
				INNER JOIN {$wpdb->term_relationships} AS term_relationships ON {$wpdb->posts}.ID = term_relationships.object_id
				INNER JOIN {$wpdb->term_taxonomy} AS term_taxonomy USING( term_taxonomy_id )
				INNER JOIN {$wpdb->terms} AS terms USING( term_id )
				" . $tax_query_sql['join'] . $meta_query_sql['join'];

				$query['where'] = "
				WHERE {$wpdb->posts}.post_type IN ( 'product' )
				AND {$wpdb->posts}.post_status = 'publish'
				" . $tax_query_sql['where'] . $meta_query_sql['where'] . '
				AND terms.term_id IN (' . implode( ',', array_map( 'absint', $term_ids ) ) . ')
			';

				if ( $search = WC_Query::get_main_search_query_sql() ) {

					$query['where'] .= ' AND ' . $search;

					if ( woodmart_get_opt( 'search_by_sku' ) ) {
						// search for variations with a matching sku and return the parent.
						$sku_to_parent_id = $wpdb->get_col( $wpdb->prepare( "SELECT p.post_parent as post_id FROM {$wpdb->posts} as p join {$wpdb->wc_product_meta_lookup} ml on p.ID = ml.product_id and ml.sku LIKE '%%%s%%' where p.post_parent <> 0 group by p.post_parent", wc_clean( $_GET['s'] ) ) );

						// Search for a regular product that matches the sku.
						$sku_to_id = $wpdb->get_col( $wpdb->prepare( "SELECT product_id FROM {$wpdb->wc_product_meta_lookup} WHERE sku LIKE '%%%s%%';", wc_clean( $_GET['s'] ) ) );

						$search_ids = array_merge( $sku_to_id, $sku_to_parent_id );

						$search_ids = array_filter( array_map( 'absint', $search_ids ) );

						if ( sizeof( $search_ids ) > 0 ) {
							$query['where'] = str_replace( '))', ") OR ({$wpdb->posts}.ID IN (" . implode( ',', $search_ids ) . ')))', $query['where'] );
						}
					}
				}

				$query['group_by'] = 'GROUP BY terms.term_id';
				$query             = apply_filters( 'woocommerce_get_filtered_term_product_counts_query', $query );
				$query             = implode( ' ', $query );

				// We have a query - let's see if cached results of this query already exist.
				$query_hash = md5( $query );

				// Maybe store a transient of the count values.
				$cache = apply_filters( 'woocommerce_layered_nav_count_maybe_cache', true );
				if ( true === $cache ) {
					$cached_counts = (array) get_transient( 'wc_layered_nav_counts_' . sanitize_title( $taxonomy ) );
				} else {
					$cached_counts = array();
				}

				if ( ! isset( $cached_counts[ $query_hash ] ) ) {
					$results                      = $wpdb->get_results( $query, ARRAY_A ); // @codingStandardsIgnoreLine
					$counts                       = array_map( 'absint', wp_list_pluck( $results, 'term_count', 'term_count_id' ) );
					$cached_counts[ $query_hash ] = $counts;
					if ( true === $cache ) {
						set_transient( 'wc_layered_nav_counts_' . sanitize_title( $taxonomy ), $cached_counts, DAY_IN_SECONDS );
					}
				}

				return array_map( 'absint', (array) $cached_counts[ $query_hash ] );
			} else {
				return wc_get_container()->get( Filterer::class )->get_filtered_term_product_counts( $term_ids, $taxonomy, $query_type );
			}
		}

		/**
		 * Show list based layered nav.
		 *
		 * @param  array  $terms
		 * @param  string $taxonomy
		 * @param  string $query_type
		 * @return bool Will nav display?
		 */
		protected function layered_nav_list( $terms, $taxonomy, $query_type, $instance ) {
			$labels            = isset( $instance['labels'] ) ? $instance['labels'] : 'on';
			$tooltips          = isset( $instance['tooltips'] ) ? $instance['tooltips'] : 'off';
			$checkboxes        = isset( $instance['checkboxes'] ) ? $instance['checkboxes'] : 'off';
			$size              = isset( $instance['size'] ) ? $instance['size'] : 'normal';
			$style             = isset( $instance['style'] ) ? $instance['style'] : 'inherit';
			$shape             = isset( $instance['shape'] ) ? $instance['shape'] : 'round';
			$display           = isset( $instance['display'] ) ? $instance['display'] : 'list';
			$search_by_filters = isset( $instance['search_by_filters'] ) ? $instance['search_by_filters'] : 0;
			$scroll_for_widget = woodmart_get_opt( 'widgets_scroll' );

			$is_brand = woodmart_get_opt( 'brands_attribute') == $taxonomy || 'product_brand' === $taxonomy;

			if ( 'inherit' === $style ) {
				$style = woodmart_wc_get_attribute_term( $taxonomy, 'swatch_style' );
			}
			if ( 'inherit' === $shape ) {
				$shape = woodmart_wc_get_attribute_term( $taxonomy, 'swatch_shape' );

				if ( ! $shape ) {
					$shape = 'round';
				}
			}

			$class  = 'wd-labels-' . $labels;
			$class .= ' wd-size-' . $size;
			$class .= ' wd-layout-' . $display;

			if ( $style ) {
				$class .= ' wd-text-style-' . $style;

				woodmart_enqueue_inline_style( 'woo-mod-swatches-style-' . $style );
			} else {
				$class .= ' wd-text-style-1';

				woodmart_enqueue_inline_style( 'woo-mod-swatches-style-1' );
			}

			if ( $is_brand ) {
				$class .= ' wd-swatches-brands';
			} else {
				if ( $style ) {
					$class .= ' wd-bg-style-' . $style;
				} else {
					$class .= ' wd-bg-style-4';

					woodmart_enqueue_inline_style( 'woo-mod-swatches-style-4' );
				}

				$class .= ' wd-shape-' . $shape;
			}

			if ( in_array( $size, array( 'small', 'normal', 'large' ), true ) ) {
				$class .= woodmart_get_old_classes( ' swatches-' . $size );
			}

			if ( 'on' === $checkboxes ) {
				woodmart_enqueue_inline_style( 'woo-mod-widget-checkboxes' );

				$class .= ' wd-checkboxes-on';
			}

			if ( $search_by_filters ) {
				$taxonomy_object = get_taxonomy( $taxonomy );

				if ( isset( $taxonomy_object->labels->singular_name ) ) {
					$label = $taxonomy_object->labels->singular_name;
				} else {
					$label = str_replace( 'pa_', ' ', $taxonomy );
				}

				$placeholder = sprintf( esc_html__( 'Find a %s', 'woodmart' ), $label );

				?>
				<div class="wd-filter-wrapper">
					<div class="wd-filter-search wd-search">
						<input type="text" placeholder="<?php echo esc_attr( $placeholder ); ?>" aria-label="<?php echo esc_attr( $placeholder ); ?>">
						<span class="wd-filter-search-clear wd-action-btn wd-style-icon wd-cross-icon">
							<a href="#" aria-label="<?php esc_attr__( 'Clear search', 'woodmart' ); ?>"></a>
						</span>
					</div>
				<?php
			}

			// List display
			if ( $scroll_for_widget ) {
				echo '<div class="wd-scroll">';
				$class .= ' wd-scroll-content';
			}
			echo '<ul class="wd-swatches-filter wd-filter-list ' . esc_attr( $class ) . '">';

			$term_counts = $this->get_filtered_term_product_counts( wp_list_pluck( $terms, 'term_id' ), $taxonomy, $query_type );

			$_chosen_attributes = $this->get_chosen_attributes();
			$found              = false;

			foreach ( $terms as $term ) {
				$current_values = isset( $_chosen_attributes[ $taxonomy ]['terms'] ) ? $_chosen_attributes[ $taxonomy ]['terms'] : array();
				$option_is_set  = in_array( $term->slug, $current_values ) || in_array( $term->term_id, $current_values );
				$count          = isset( $term_counts[ $term->term_id ] ) ? $term_counts[ $term->term_id ] : 0;

				// skip the term for the current archive
				if ( $this->get_current_term_id() === $term->term_id ) {
					continue;
				}

				// Only show options with count > 0
				if ( 0 < $count ) {
					$found = true;
				} elseif ( 0 === $count && ! $option_is_set ) {
					continue;
				}

				$filter_name    = 'product_brand' === $taxonomy ? 'filter_product_brand' : 'filter_' . wc_attribute_taxonomy_slug( $taxonomy );
				$current_filter = isset( $_GET[ $filter_name ] ) ? explode( ',', wc_clean( $_GET[ $filter_name ] ) ) : array();
				$current_filter = array_map( 'sanitize_title', $current_filter );

				if ( 'product_brand' === $taxonomy && ! in_array( $term->term_id, $current_filter ) ) {
					$current_filter[] = $term->term_id;
				} elseif ( ! in_array( $term->slug, $current_filter ) ) {
					$current_filter[] = $term->slug;
				}

				$base_link = apply_filters( 'woocommerce_widget_get_current_page_url', woodmart_filters_get_page_base_url(), $this );
				$link      = remove_query_arg( $filter_name, $base_link );

				// Add current filters to URL.
				foreach ( $current_filter as $key => $value ) {
					// Exclude query arg for current term archive term.
					if ( $value === $this->get_current_term_slug() || 'product_brand' === $taxonomy && (int) $value === $this->get_current_term_id() ) {
						unset( $current_filter[ $key ] );
					}

					// Exclude self so filter can be unset on click.
					if ( $option_is_set && ( $value === $term->slug || 'product_brand' === $taxonomy && (int) $value === $term->term_id ) ) {
						unset( $current_filter[ $key ] );
					}
				}

				if ( ! empty( $current_filter ) ) {
					asort( $current_filter );
					$link = add_query_arg( $filter_name, implode( ',', $current_filter ), $link );

					// Add Query type Arg to URL.
					if ( 'or' === $query_type && ! ( 1 === count( $current_filter ) && $option_is_set ) ) {
						$link = add_query_arg( 'query_type_' . wc_attribute_taxonomy_slug( $taxonomy ), 'or', $link );
					}
					$link = str_replace( '%2C', ',', $link );
				}

				// Add swatches block
				$swatch_style = '';
				$swatch_color = get_term_meta( $term->term_id, 'color', true );
				$swatch_image = get_term_meta( $term->term_id, 'image', true );
				$swatch_text  = get_term_meta( $term->term_id, 'not_dropdown', true );

				if ( $is_brand && ! $swatch_image ) {
					$thumbnail_id = get_term_meta( $term->term_id, 'thumbnail_id', true );

					if ( $thumbnail_id ) {
						$swatch_image = array( 'id' => $thumbnail_id );
					}
				}

				$class          = $option_is_set ? ' wd-active' : '';
				$filter_classes = woodmart_get_old_classes( ' filter-swatch' );

				if ( $swatch_color || $swatch_image || $swatch_text ) {
					$class .= ' wd-swatch-wrap';
				}

				if ( ! empty( $swatch_color ) ) {
					$filter_classes .= woodmart_get_old_classes( ' with-bg' );
					$filter_classes .= ' wd-bg';
					$swatch_style    = 'background-color: ' . $swatch_color . ';';
				}

				if ( ( ! empty( $swatch_image ) && ! is_array( $swatch_image ) ) || ( is_array( $swatch_image ) && ! empty( $swatch_image['id'] ) ) ) {
					$filter_classes .= woodmart_get_old_classes( ' with-bg' );
					$filter_classes .= ' wd-bg';
				}

				if ( is_array( $swatch_image ) ) {
					$swatch_image = wp_get_attachment_image( $swatch_image['id'], 'full' );
				} elseif ( $swatch_image ) {
					$swatch_image = apply_filters( 'woodmart_image', '<img src="' . $swatch_image . '" alt="' . esc_attr__( 'Swatch image', 'woodmart' ) . '">' );
				}

				if ( ! empty( $swatch_text ) && ! $swatch_style && ! $swatch_image ) {
					$filter_classes .= woodmart_get_old_classes( ' with-text' );
					$filter_classes .= ' wd-text';
				}

				if ( $tooltips == 'on' ) {
					$filter_classes .= ' wd-tooltip';
				}

				// END swatches customization

				echo '<li class="wc-layered-nav-term' . esc_attr( $class ) . '">';

				echo ( true == $option_is_set || $count > 0 ) ? '<a rel="nofollow noopener" href="' . esc_url( apply_filters( 'woocommerce_layered_nav_link', $link ) ) . '" class="layered-nav-link">' : '<span>';

				if ( $swatch_style || $swatch_text || $swatch_image ) {
					echo '<span class="wd-swatch' . esc_attr( $filter_classes ) . '">';

					if ( $swatch_style || $swatch_image ) {
						echo '<span class="wd-swatch-bg" style="'. $swatch_style .'">';

						if ( $swatch_image ) {
							echo $swatch_image;
						}

						echo '</span>';
					}

					echo '<span class="wd-swatch-text">'. esc_html( $term->name ) . '</span>';
					echo '</span>';
				}

				echo '<span class="wd-filter-lable layer-term-lable">' . esc_html( $term->name ) . '</span>';

				echo ( true == $option_is_set || $count > 0 ) ? '</a>' : '</span>';

				echo ' <span class="count">' . absint( $count ) . '</span></li>';
			}

			echo '</ul>';
			if ( $scroll_for_widget ) {
				echo '</div>';
			}

			if ( $search_by_filters ) {
				echo '</div>';
			}

			return $found;
		}

		protected function layered_nav_checkbox_list( $terms, $taxonomy, $query_type, $instance ) {
			$query_type           = isset( $instance['query_type'] ) ? $instance['query_type'] : 'and';
			$title                = isset( $instance['filter-title'] ) ? $instance['filter-title'] : esc_html__( 'Filter by', 'woodmart' );
			$labels               = $instance['labels'] ? 'on' : 'off';
			$display              = isset( $instance['display'] ) ? $instance['display'] : 'list';
			$size                 = isset( $instance['size'] ) ? $instance['size'] : 'normal';
			$style                = isset( $instance['style'] ) ? $instance['style'] : 'inherit';
			$shape                = isset( $instance['shape'] ) ? $instance['shape'] : 'round';
			$categories           = isset( $instance['categories'] ) ? $instance['categories'] : array();
			$show_selected_values = isset( $instance['show_selected_values'] ) ? $instance['show_selected_values'] : 'yes';
			$show_dropdown_on     = isset( $instance['show_dropdown_on'] ) ? $instance['show_dropdown_on'] : 'click';
			$wrapper_classes      = isset( $instance['wrapper_class'] ) ? $instance['wrapper_class'] : '';
			$el_id               = isset( $instance['el_id'] ) ? $instance['el_id'] : '';
			$is_on_shop           = is_shop() || is_product_taxonomy();
			$current_cat          = get_queried_object();

			if ( isset( $categories[0] ) && $categories[0] && ! in_array( $current_cat->term_id, $categories ) && $is_on_shop ) {
				return;
			}

			$is_brand = ( woodmart_get_opt( 'brands_attribute' ) == $taxonomy || 'product_brand' === $taxonomy );

			if ( 'inherit' === $style ) {
				$style = woodmart_wc_get_attribute_term( $taxonomy, 'swatch_style' );
			}
			if ( 'inherit' === $shape ) {
				$shape = woodmart_wc_get_attribute_term( $taxonomy, 'swatch_shape' );

				if ( ! $shape ) {
					$shape = 'round';
				}
			}

			$classes  = ' wd-labels-' . $labels;
			$classes .= ' wd-layout-' . $display;
			$classes .= ' wd-size-' . $size;

			if ( $style ) {
				$classes .= ' wd-text-style-' . $style;

				woodmart_enqueue_inline_style( 'woo-mod-swatches-style-' . $style );
			} else {
				$classes .= ' wd-text-style-1';

				woodmart_enqueue_inline_style( 'woo-mod-swatches-style-1' );
			}

			if ( $is_brand ) {
				$classes .= ' wd-swatches-brands';
			} else {
				if ( $style ) {
					$classes .= ' wd-bg-style-' . $style;
				} else {
					$classes .= ' wd-bg-style-4';

					woodmart_enqueue_inline_style( 'woo-mod-swatches-style-4' );
				}

				$classes .= ' wd-shape-' . $shape;
			}

			if ( in_array( $size, array( 'small', 'normal', 'large' ), true ) ) {
				$classes .= woodmart_get_old_classes( ' swatches-' . $size );
			}

			if ( 'or' === $query_type ) {
				$wrapper_classes = ' multi_select';
			}

			$wrapper_classes .= ' wd-event-' . $show_dropdown_on;

			$taxonomy_filter_name = str_replace( 'pa_', '', $taxonomy );
			$filter_name          = 'filter_' . esc_attr( $taxonomy_filter_name );
			$current_value        = isset( $_GET[ $filter_name ] ) ? sanitize_text_field( $_GET[ $filter_name ] ) : '';

			if ( $is_on_shop ) {
				$term_counts = $this->get_filtered_term_product_counts( wp_list_pluck( $terms, 'term_id' ), $taxonomy, $query_type );
			}

			$_chosen_attributes = $this->get_chosen_attributes();
			$found              = false;

			echo '<div id="' . esc_attr( $el_id ) . '" class="wd-pf-checkboxes wd-pf-attributes wd-col' . esc_attr( $wrapper_classes ) . '">';
				echo '<input class="result-input" name="filter_' . esc_attr( $taxonomy_filter_name ) . '" type="hidden" value="' . esc_attr( $current_value ) . '">';
			if ( 'or' === $query_type ) {
				echo '<input name="query_type_' . esc_attr( $taxonomy_filter_name ) . '" type="hidden" value="' . esc_attr( $query_type ) . '">';
			}

			echo '<div class="wd-pf-title"><span class="title-text">' . esc_html( $title ) . '</span>';

			if ( 'yes' === $show_selected_values ) {
				echo '<ul class="wd-pf-results">';

				if ( ! empty( $current_value ) ) {
					$current_values_list = explode( ',', $current_value );

					foreach ( $current_values_list as $current_value_slug ) {
						$current_term = get_term_by( 'slug', $current_value_slug, $taxonomy );

						if ( ! $current_term ) {
							continue;
						}

						echo '<li class="selected-value" data-title="' . esc_attr( $current_value_slug ) . '">';
							echo esc_attr( $current_term->name );
						echo '</li>';
					}
				}
				echo '</ul>';
			}

			echo '</div>';

				echo '<div class="wd-pf-dropdown wd-dropdown">';
					echo '<div class="wd-scroll">';
						echo '<ul class="wd-swatches-filter wd-scroll-content' . esc_attr( $classes ) . '">';
							foreach ( $terms as $term ) {
								$current_values = isset( $_chosen_attributes[ $taxonomy ]['terms'] ) ? $_chosen_attributes[ $taxonomy ]['terms'] : array();
								$option_is_set  = in_array( $term->slug, $current_values ) || in_array( $term->term_id, $current_values );
								$count          = isset( $term_counts[ $term->term_id ] ) ? $term_counts[ $term->term_id ] : 0;

								// Only show options with count > 0
								if ( $is_on_shop ) {
									if ( 0 < $count ) {
										$found = true;
									} elseif ( 0 === $count && ! $option_is_set ) {
										continue;
									}
								}

								// Add swatches block
								$swatch_style = '';
								$swatch_color = get_term_meta( $term->term_id, 'color', true );
								$swatch_image = get_term_meta( $term->term_id, 'image', true );
								$swatch_text = get_term_meta( $term->term_id, 'not_dropdown', true );

								if ( $is_brand && ! $swatch_image ) {
									$thumbnail_id = get_term_meta( $term->term_id, 'thumbnail_id', true );

									if ( $thumbnail_id ) {
										$swatch_image = array(
											'id' => $thumbnail_id,
										);
									}
								}

								$class = $option_is_set ? ' wd-active' : '';
								$filter_classes = woodmart_get_old_classes( ' filter-swatch' );

								if ( $swatch_color || $swatch_image || $swatch_text ) {
									$class .= ' wd-swatch-wrap';
								}

								if( ! empty( $swatch_color ) ) {
									$filter_classes .= ' wd-bg';
									$filter_classes .= woodmart_get_old_classes( ' with-bg' );
									$swatch_style    = 'background-color: ' . $swatch_color .';';
								}

								if ( ( ! empty( $swatch_image ) && ! is_array( $swatch_image ) ) || ( is_array( $swatch_image ) && ! empty( $swatch_image['id'] ) ) ) {
									$filter_classes .= ' wd-bg';
									$filter_classes .= woodmart_get_old_classes( ' with-bg' );
								}

								if ( is_array( $swatch_image ) ) {
									$swatch_image = wp_get_attachment_image( $swatch_image['id'], 'full' );
								} elseif ( $swatch_image ) {
									$swatch_image = apply_filters( 'woodmart_image', '<img src="' . $swatch_image . '" alt="' . esc_attr__( 'Swatch image', 'woodmart' ) . '">' );
								}

								if ( ! empty( $swatch_text ) && ! $swatch_style && ! $swatch_image ) {
									$filter_classes .= ' wd-text';
									$filter_classes .= woodmart_get_old_classes( ' with-text' );
								}

								if ( $labels == 'off' ) {
									$filter_classes .= ' wd-tooltip';
								}

								// END swatches customization

								$current_filter = array();

								if ( 'or' === $query_type ) {
									$current_filter = isset( $_GET[ $filter_name ] ) ? explode( ',', wc_clean( $_GET[ $filter_name ] ) ) : array();
									$current_filter = array_map( 'sanitize_title', $current_filter );
								}

								if ( 'product_brand' === $taxonomy && ! in_array( $term->term_id, $current_filter ) ) {
									$current_filter[] = $term->term_id;
								} elseif ( ! in_array( $term->slug, $current_filter ) ) {
									$current_filter[] = $term->slug;
								}

								$base_link = apply_filters( 'woocommerce_widget_get_current_page_url', woodmart_filters_get_page_base_url(), $this );
								$link      = remove_query_arg( $filter_name, $base_link );

								// Add current filters to URL.
								foreach ( $current_filter as $key => $value ) {
									// Exclude query arg for current term archive term.
									if ( 'product_brand' === $taxonomy && $value === $this->get_current_term_id() || $value === $this->get_current_term_slug() ) {
										unset( $current_filter[ $key ] );
									}

									// Exclude self so filter can be unset on click.
									if ( $option_is_set && ( $value === $term->slug || 'product_brand' === $taxonomy && $value === $term->term_id ) ) {
										unset( $current_filter[ $key ] );
									}
								}

								if ( ! empty( $current_filter ) ) {
									asort( $current_filter );
									$link = add_query_arg( $filter_name, implode( ',', $current_filter ), $link );

									// Add Query type Arg to URL.
									if ( 'or' === $query_type && ! ( 1 === count( $current_filter ) && $option_is_set ) ) {
										$link = add_query_arg( 'query_type_' . wc_attribute_taxonomy_slug( $taxonomy ), 'or', $link );
									}
									$link = str_replace( '%2C', ',', $link );
								}

								echo '<li class="wd-pf-' . esc_attr( $term->slug ) . esc_attr( $class ) . '">';
								echo '<a rel="nofollow noopener" href="' . esc_url( apply_filters( 'woocommerce_layered_nav_link', $link ) ) .'" class="pf-value" data-val="' . esc_attr( 'product_brand' === $taxonomy ? $term->term_id : $term->slug ) . '" data-title="' . esc_attr( $term->name ) . '">';
									if ( $swatch_style || $swatch_text || $swatch_image ) {
										echo '<span class="wd-swatch' . esc_attr( $filter_classes ) . '">';

										if ( $swatch_style || $swatch_image ) {
											echo '<span class="wd-swatch-bg" style="' . $swatch_style . '">';

											if ( $swatch_image ) {
												echo $swatch_image;
											}

											echo '</span>';
										}

										echo '<span class="wd-swatch-text">' . esc_html( $term->name ) . '</span>';
										echo '</span>';
									}
									echo '<span class="wd-filter-lable layer-term-lable">' . esc_html( $term->name ) . '</span>';
									echo '</a>';
								echo '</li>';
							}
						echo '</ul>';
					echo '</div>';
				echo '</div>';
			echo '</div>';

			if ( ! $is_on_shop ) {
				$found = true;
			}

			return $found;
		}

		/**
		 * Get chosen attributes.
		 *
		 * @return array
		 */
		public function get_chosen_attributes() {
			$_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes();

			if ( ! empty( $_GET['filter_product_brand'] ) ) {
				$filter_product_brand = wc_clean( wp_unslash( $_GET['filter_product_brand'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended

				$_chosen_attributes['product_brand']['terms']      = array_map( 'sanitize_title', explode( ',', $filter_product_brand ) );
				$_chosen_attributes['product_brand']['query_type'] = ! empty( $_GET['query_type_product_brand'] ) && in_array( $_GET[ 'query_type_product_brand' ], array( 'and', 'or' ), true ) ? wc_clean( wp_unslash( $_GET['query_type_product_brand'] ) ) : apply_filters( 'woocommerce_layered_nav_default_query_type', 'and' );
			}

			return $_chosen_attributes;
		}

		function form( $instance ) {
			parent::form( $instance );
		}

	}
}
