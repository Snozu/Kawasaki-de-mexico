<?php

namespace XTS\Modules\Layouts;

use WC_Query;
use WP_Query;

class Shop_Archive extends Layout_Type {
	/**
	 * Switched data.
	 *
	 * @var array Switched data.
	 */
	private static $original_post = array();

	/**
	 * Check.
	 *
	 * @param  array  $condition  Condition.
	 * @param  string $type  Layout type.
	 */
	public function check( $condition, $type = '' ) {
		$is_active = false;

		switch ( $condition['condition_type'] ) {
			case 'all':
				$is_active = woodmart_is_shop_archive();
				break;
			case 'shop_page':
				$is_active = is_shop();
				break;
			case 'product_search':
				$is_active = is_search() && 'product' === get_query_var( 'post_type' );
				break;
			case 'product_term':
				$object      = get_queried_object();
				$taxonomy_id = is_object( $object ) && property_exists(
					$object,
					'term_id'
				) ? $object->term_id : false;

				$is_active = (int) $taxonomy_id === (int) $condition['condition_query'] && ! is_search();
				break;
			case 'product_cat_children':
				$object        = get_queried_object();
				$taxonomy_id   = is_object( $object ) && property_exists(
					$object,
					'term_id'
				) ? $object->term_id : false;
				$term_children = get_term_children( $condition['condition_query'], 'product_cat' );

				$is_active = in_array( $taxonomy_id, $term_children, false ); // phpcs:ignore
				break;
			case 'product_cats':
				$is_active = is_product_category();
				break;
			case 'product_tags':
				$is_active = is_product_tag();
				break;
			case 'product_brands':
				$is_active = is_tax( 'product_brand' );
				break;
			case 'product_attr':
				$object   = get_queried_object();
				$taxonomy = is_object( $object ) && property_exists(
					$object,
					'taxonomy'
				) ? $object->taxonomy : false;

				$is_active = $taxonomy === $condition['condition_query'];
				break;
			case 'filtered_product_term':
				$condition_filter = sanitize_title( str_replace( 'pa_', '', $condition['condition_query'] ) );

				$is_active = isset( $_GET[ 'filter_' . $condition_filter ] ); // phpcs:ignore
				break;
			case 'filtered_product_by_term':
				$chosen_attributes = WC_Query::get_layered_nav_chosen_attributes();

				foreach ( $chosen_attributes as $taxonomy => $data ) {
					if ( ! empty( $data['terms'] ) ) {
						foreach ( $data['terms'] as $term_slug ) {
							$term = get_term_by( 'slug', $term_slug, $taxonomy );

							if ( $term && $term->term_id === (int) $condition['condition_query'] ) {
								$is_active = true;

								break;
							}
						}
					}

					if ( $is_active ) {
						break;
					}
				}
				break;
			case 'filtered_product_term_any':
				$chosen_attributes = WC_Query::get_layered_nav_chosen_attributes();

				foreach ( $chosen_attributes as $taxonomy => $data ) {
					$filter_name = 'filter_' . wc_attribute_taxonomy_slug( $taxonomy );
					$is_active   = isset( $_GET[ $filter_name ] ); // phpcs:ignore
				}
				break;
			case 'filtered_product_stock_status':
				$is_active = isset( $_GET['stock_status'] ) && false !== strpos( $_GET['stock_status'], $condition['condition_query'] ); // phpcs:ignore
				break;
		}

		if ( 'fragments' === woodmart_is_woo_ajax() ) {
			$is_active = false;
		}

		return $is_active;
	}

	/**
	 * Override templates.
	 *
	 * @param  string $template  Template.
	 *
	 * @return bool|string
	 */
	public function override_template( $template ) {
		if ( woodmart_woocommerce_installed() && ( is_shop() || is_product_taxonomy() ) && Main::get_instance()->has_custom_layout( 'shop_archive' ) && ( ! function_exists( 'wcfm_is_store_page' ) || ! wcfm_is_store_page() ) ) {
			$this->display_template();

			return false;
		}

		return $template;
	}

	/**
	 * Display custom template on the shop page.
	 */
	protected function display_template() {
		parent::display_template();
		$this->before_template_content();
		$this->template_content( 'shop_archive' );
		$this->after_template_content();
	}

	/**
	 * Before template content.
	 */
	public function before_template_content() {
		if ( ! woodmart_is_woo_ajax() ) {
			get_header();
		} else {
			woodmart_page_top_part();
		}

		do_action( 'woocommerce_before_main_content' );

		woodmart_enqueue_inline_style( 'woo-shop-builder' );
	}

	/**
	 * Before template content.
	 */
	public function after_template_content() {
		do_action( 'woocommerce_after_main_content' );

		if ( ! woodmart_is_woo_ajax() ) {
			get_footer();
		} else {
			woodmart_page_bottom_part();
		}
	}

	/**
	 * Switch to preview query.
	 *
	 * @param  array $new_query  New query variables.
	 */
	public static function switch_to_preview_query( $new_query ) {
		global $post;

		if ( ! is_singular( 'woodmart_layout' ) && ! wp_doing_ajax() && ( ! wp_is_serving_rest_request() || 'woodmart_layout' !== $post->post_type ) ) {
			return;
		}

		global $wp_query;
		$current_query_vars = $wp_query->query;

		// If is already switched, or is the same query, return.
		if ( $current_query_vars === $new_query ) {
			self::$original_post = false;

			return;
		}

		$new_query = new WP_Query( $new_query );

		$original_post = array(
			'switched' => $new_query,
			'original' => $wp_query,
		);

		if ( ! empty( $GLOBALS['post'] ) ) {
			$original_post['post'] = $GLOBALS['post'];
		}

		self::$original_post = $original_post;

		$wp_query = $new_query; // phpcs:ignore

		// Ensure the global post is set only if needed.
		unset( $GLOBALS['post'] );

		WC()->query->product_query( $new_query );
		wc_set_loop_prop( 'total', 20 );
	}

	/**
	 * Restore default query.
	 *
	 * @return void
	 */
	public static function restore_current_query() {
		$data = self::$original_post;

		// If not switched, return.
		if ( ! $data ) {
			wc_reset_loop();

			return;
		}

		global $wp_query;

		$wp_query = $data['original']; // phpcs:ignore

		// Ensure the global post/authordata is set only if needed.
		unset( $GLOBALS['post'] );

		if ( ! empty( $data['post'] ) ) {
			$GLOBALS['post'] = $data['post']; // phpcs:ignore
			setup_postdata( $GLOBALS['post'] );
		}

		WC()->query->product_query( $wp_query );
		wc_reset_loop();
	}
}

Shop_Archive::get_instance();
