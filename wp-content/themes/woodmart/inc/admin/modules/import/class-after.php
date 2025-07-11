<?php
/**
 * Import after.
 *
 * @package Woodmart
 */

namespace XTS\Admin\Modules\Import;

use Automattic\WooCommerce\Internal\ProductAttributesLookup\DataRegenerator;
use Elementor\Plugin;
use Elementor\Utils;
use Exception;
use WC_Cache_Helper;
use WP_Query;
use XTS\Singleton;

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

/**
 * Import after.
 */
class After extends Singleton {
	/**
	 * Helpers.
	 *
	 * @var Helpers
	 */
	private $helpers;

	/**
	 * Init.
	 */
	public function init() {
		$this->helpers = Helpers::get_instance();
	}

	/**
	 * Change header on pages
	 */
	public function change_header_on_pages() {
		$header = 'none';
		$pages  = array(
			'about-factory',
			'contact-us',
			'contact-us-2',
			'contact-us-3',
			'contact-us-4',
			'about-us-3',
		);

		$current_version = get_option( 'wd_import_current_version' );
		$file_path       = $this->helpers->get_file_path( 'configs.json', $current_version );
		if ( 'elementor' === $this->helpers->get_page_builder() ) {
			$file_path = $this->helpers->get_file_path( 'configs-elementor.json', $current_version );
		} elseif ( 'gutenberg' === $this->helpers->get_page_builder() ) {
			$file_path = $this->helpers->get_file_path( 'configs-gutenberg.json', $current_version );
		}

		if ( $file_path ) {
			$configs = json_decode( $this->helpers->get_local_file_content( $file_path ), true );
			$header  = $configs['pages_header_1'][0];
		}

		foreach ( $pages as $page_slug ) {
			$page_data = get_page_by_path( $page_slug, ARRAY_A );

			if ( isset( $page_data['ID'] ) ) {
				update_post_meta( $page_data['ID'], '_woodmart_whb_header', $header );
			}
		}
	}

	/**
	 * Remove uncategorized cat.
	 */
	public function wc_remove_uncategorized_cat() {
		$uncategorized = get_term_by( 'id', get_option( 'default_product_cat' ), 'product_cat' );
		$accessories   = get_term_by( 'name', 'Accessories', 'product_cat' );

		if ( ! $uncategorized || ! $accessories ) {
			return;
		}

		update_option( 'default_product_cat', $accessories->term_id );
		wp_delete_term( $uncategorized->term_id, 'product_cat' );
	}

	/**
	 * Set pages sidebar.
	 */
	public function set_pages_sidebar() {
		$pages = apply_filters(
			'woocommerce_create_pages',
			array(
				'cart'      => array(
					'name'    => _x( 'cart', 'Page slug', 'woodmart' ),
					'title'   => _x( 'Cart', 'Page title', 'woodmart' ),
					'content' => '[' . apply_filters( 'woocommerce_cart_shortcode_tag', 'woocommerce_cart' ) . ']',
				),
				'checkout'  => array(
					'name'    => _x( 'checkout', 'Page slug', 'woodmart' ),
					'title'   => _x( 'Checkout', 'Page title', 'woodmart' ),
					'content' => '[' . apply_filters( 'woocommerce_checkout_shortcode_tag', 'woocommerce_checkout' ) . ']',
				),
				'myaccount' => array(
					'name'    => _x( 'my-account', 'Page slug', 'woocommerce' ),
					'title'   => _x( 'My account', 'Page title', 'woocommerce' ),
					'content' => '<!-- wp:shortcode -->[' . apply_filters( 'woocommerce_my_account_shortcode_tag', 'woocommerce_my_account' ) . ']<!-- /wp:shortcode -->',
				),
			)
		);

		foreach ( $pages as $key => $page ) {
			$option  = 'woocommerce_' . $key . '_page_id';
			$page_id = get_option( $option );
			update_post_meta( $page_id, '_woodmart_main_layout', 'full-width' );
		}

		update_option( 'woocommerce_single_image_width', '1200' );
		update_option( 'woocommerce_thumbnail_image_width', '600' );
	}

	/**
	 * Update product lookup tables.
	 */
	public function update_product_lookup_tables() {
		if ( 'yes' === get_option( 'woocommerce_attribute_lookup_regeneration_in_progress', null ) ) {
			return;
		}

		if ( apply_filters( 'woodmart_import_run_initiate_regeneration', false ) ) {
			$data_regenerator = wc_get_container()->get( DataRegenerator::class );
			$data_regenerator->initiate_regeneration();
		}

		delete_transient( 'wc_count_comments' );
		delete_transient( 'as_comment_count' );
		wc_delete_shop_order_transients();
		wc_delete_product_transients();

		$attributes = wc_get_attribute_taxonomies();
		if ( $attributes ) {
			foreach ( $attributes as $attribute ) {
				delete_transient( 'wc_layered_nav_counts_pa_' . $attribute->attribute_name );
			}
		}

		WC_Cache_Helper::get_transient_version( 'shipping', true );
		wc_clear_template_cache();
		wc_delete_expired_transients();

		if ( ! wc_update_product_lookup_tables_is_running() ) {
			wc_update_product_lookup_tables();
		}
	}

	/**
	 * Set menu locations.
	 */
	public function set_menu_locations() {
		global $wpdb;

		$location        = 'main-menu';
		$mobile_location = 'mobile-menu';
		$table_name      = $wpdb->prefix . 'terms';

		// @codingStandardsIgnoreStart
		$menu_ids = $wpdb->get_results( 'SELECT `term_id`, `name` FROM ' . $table_name . "  WHERE name IN ('Main navigation', 'Mobile navigation') ORDER BY name ASC" );
		// @codingStandardsIgnoreEnd

		$locations = get_theme_mod( 'nav_menu_locations' );

		foreach ( $menu_ids as $menu ) {
			if ( 'Main navigation' === $menu->name ) {
				$locations[ $location ] = $menu->term_id;
			}

			if ( 'Mobile navigation' === $menu->name ) {
				$locations[ $mobile_location ] = $menu->term_id;
			}
		}

		set_theme_mod( 'nav_menu_locations', $locations );
	}

	/**
	 * Set blog page.
	 */
	public function set_blog_page() {
		$blog_page_title = 'Blog';
		$query           = new WP_Query(
			array(
				'post_type'              => 'page',
				'title'                  => $blog_page_title,
				'posts_per_page'         => 1,
				'no_found_rows'          => true,
				'ignore_sticky_posts'    => true,
				'update_post_term_cache' => false,
				'update_post_meta_cache' => false,
			)
		);
		$blog_page       = ! empty( $query->post ) ? $query->post : null;

		if ( ! is_null( $blog_page ) ) {
			update_option( 'page_for_posts', $blog_page->ID );
			update_option( 'show_on_front', 'page' );
		}

		if ( get_the_title( 1 ) !== 'Default Kit' ) {
			wp_trash_post( 1 );
		}

		if ( get_the_title( 2 ) !== 'Default Kit' ) {
			wp_trash_post( 1 );
		}
	}

	/**
	 * Enable wpb on custom post types.
	 */
	public function enable_wpb_on_custom_post_types() {
		if ( ! function_exists( 'vc_path_dir' ) ) {
			return;
		}

		$file = vc_path_dir( 'SETTINGS_DIR', 'class-vc-roles.php' );

		if ( ! file_exists( $file ) ) {
			return;
		}

		require_once $file;

		if ( ! class_exists( 'Vc_Roles' ) ) {
			return;
		}

		$vc_roles = new \Vc_Roles();

		$vc_roles->save(
			array(
				'administrator' => json_decode( '{"post_types":{"_state":"custom","post":"1","page":"1","woodmart_slide":"1","woodmart_layout":"1","woodmart_size_guide":"1","cms_block":"1","woodmart_sidebar":"0","portfolio":"1","product":"1","woodmart_woo_lv":"0", "wd_product_tabs":"1"},"backend_editor":{"_state":"1","disabled_ce_editor":"0"},"frontend_editor":{"_state":"1"},"post_settings":{"_state":"1"},"settings":{"_state":"1"},"templates":{"_state":"1"},"shortcodes":{"_state":"1"},"grid_builder":{"_state":"1"},"presets":{"_state":"1"}}' ),
			)
		);
	}

	/**
	 * Enable elementor on custom post types.
	 */
	public function enable_elementor_on_custom_post_types() {
		$post_types   = get_option( 'elementor_cpt_support', array( 'page', 'post' ) );
		$post_types[] = 'product';
		$post_types[] = 'portfolio';
		$post_types[] = 'cms_block';
		$post_types[] = 'woodmart_slide';
		$post_types[] = 'woodmart_layout';
		$post_types[] = 'wd_product_tabs';

		update_option( 'elementor_cpt_support', $post_types );
		update_option( 'elementor_disable_color_schemes', 'yes' );
		update_option( 'elementor_disable_typography_schemes', 'yes' );
	}

	/**
	 * Show all fields menu.
	 */
	public function show_all_fields_menu() {
		$user_id = 1;
		update_user_meta( $user_id, 'managenav-menuscolumnshidden', array() );
		update_user_meta( $user_id, 'metaboxhidden_nav-menus', array() );
	}

	/**
	 * Enable register.
	 */
	public function enable_myaccount_registration() {
		update_option( 'woocommerce_enable_myaccount_registration', 'yes' );
	}

	/**
	 * Replace URL.
	 */
	public function replace_db_urls() {
		$links = $this->helpers->links;

		foreach ( $links as $key => $value ) {
			if ( 'uploads' === $key ) {
				foreach ( $value as $link ) {
					$url_data = wp_upload_dir();
					if ( 'elementor' === $this->helpers->get_page_builder() && woodmart_is_elementor_installed() ) {
						Utils::replace_urls( $link, $url_data['baseurl'] . '/' );
					} elseif ( 'gutenberg' === $this->helpers->get_page_builder() ) {
						$this->gutenberg_replace_urls( $link, $url_data['baseurl'] . '/' );
					} else {
						$this->wpb_replace_urls( $link, $url_data['baseurl'] . '/' );
					}

					$this->replace_urls_menu_items( $link, $url_data['baseurl'] . '/' );
				}
			}

			if ( 'simple' === $key ) {
				foreach ( $value as $link ) {
					if ( 'elementor' === $this->helpers->get_page_builder() && woodmart_is_elementor_installed() ) {
						Utils::replace_urls( $link, get_home_url() . '/' );
					} elseif ( 'gutenberg' === $this->helpers->get_page_builder() ) {
						$this->gutenberg_replace_urls( $link, get_home_url() . '/' );
					} else {
						$this->wpb_replace_urls( $link, get_home_url() . '/' );
					}

					$this->replace_urls_menu_items( $link, get_home_url() . '/' );
				}
			}
		}
	}

	/**
	 * Replace URLs.
	 *
	 * Replace old URLs to new URLs. This method also updates all the Elementor data.
	 *
	 * @param string $from From url.
	 * @param string $to   To url.
	 *
	 * @throws Exception Exception.
	 */
	public function replace_urls_menu_items( $from, $to ) {
		$from = trim( $from );
		$to   = trim( $to );

		global $wpdb;

		// @codingStandardsIgnoreStart
		$wpdb->query( "UPDATE {$wpdb->postmeta} SET `meta_value` = REPLACE(`meta_value`, '{$from}', '{$to}') WHERE `meta_key` = '_menu_item_url'" );
		// @codingStandardsIgnoreEnd
	}

	/**
	 * Replace URLs.
	 *
	 * Replace old URLs to new URLs. This method also updates all the Elementor data.
	 *
	 * @param string $from From url.
	 * @param string $to   To url.
	 *
	 * @throws Exception Exception.
	 */
	public function wpb_replace_urls( $from, $to ) {
		$from = trim( $from );
		$to   = trim( $to );

		global $wpdb;

		// @codingStandardsIgnoreStart
		$wpdb->query( "UPDATE {$wpdb->postmeta} SET `meta_value` = REPLACE(`meta_value`, '{$from}', '{$to}') WHERE `meta_key` = '_wpb_shortcodes_custom_css'" );

		$encoded_from = urlencode( $from );
		$encoded_to   = urlencode( $to );

		$wpdb->query( "UPDATE {$wpdb->posts} SET `post_content` = REPLACE(`post_content`, '{$encoded_from}', '{$encoded_to}')" );
		// @codingStandardsIgnoreEnd
	}

	/**
	 * Replace URLs.
	 *
	 * Replace old URLs to new URLs. This method also updates all the Elementor data.
	 *
	 * @param string $from From url.
	 * @param string $to   To url.
	 *
	 * @throws Exception Exception.
	 */
	public function gutenberg_replace_urls( $from, $to ) {
		$from = trim( $from );
		$to   = trim( $to );

		global $wpdb;

		// @codingStandardsIgnoreStart
		$wpdb->query( "UPDATE {$wpdb->posts} SET `post_content` = REPLACE(`post_content`, '{$from}', '{$to}')" );
	}

	/**
	 * Set shop page.
	 */
	public function set_shop_page() {
		$query     = new WP_Query(
			array(
				'post_type'              => 'page',
				'title'                  => 'Shop',
				'posts_per_page'         => 1,
				'no_found_rows'          => true,
				'ignore_sticky_posts'    => true,
				'update_post_term_cache' => false,
				'update_post_meta_cache' => false,
			)
		);
		$shop_page = ! empty( $query->post ) ? $query->post : null;

		if ( ! is_null( $shop_page ) ) {
			update_option( 'woocommerce_shop_page_id', $shop_page->ID );
		} else {
			wc_create_page(
				esc_sql( _x( 'shop', 'Page slug', 'woocommerce' ) ),
				'woocommerce_shop_page_id',
				_x( 'Shop', 'Page title', 'woocommerce' )
			);
		}
	}

	/**
	 * Set site settings page.
	 */
	public function set_site_settings() {
		if ( ! class_exists( 'Elementor\Plugin' ) ) {
			return;
		}

		if ( ! Plugin::$instance->kits_manager->get_active_kit()->get_id() ) {
			$created_default_kit = Plugin::$instance->kits_manager->create_default_kit();

			if ( ! $created_default_kit ) {
				return;
			}
		}

		$settings = array(
			'container_padding'        => array(
				'unit'     => 'px',
				'top'      => '0',
				'right'    => '0',
				'bottom'   => '0',
				'left'     => '0',
				'isLinked' => '1',
			),
			'container_padding_tablet' => array(
				'unit'     => 'px',
				'top'      => '',
				'right'    => '',
				'bottom'   => '',
				'left'     => '',
				'isLinked' => '1',
			),
			'container_padding_mobile' => array(
				'unit'     => 'px',
				'top'      => '',
				'right'    => '',
				'bottom'   => '',
				'left'     => '',
				'isLinked' => '1',
			),
			'viewport_mobile'          => '768.98',
		);

		foreach ( $settings as $key => $setting ) {
			Plugin::$instance->kits_manager->update_kit_settings_based_on_option( $key, $setting );
		}

		$current_settings = Plugin::$instance->kits_manager->get_current_settings();
		$system_typography = ! empty( $current_settings['system_typography'] ) ? $current_settings['system_typography'] : array();

		if ( $system_typography ) {
			foreach ( $system_typography as $key => $setting ) {
				if ( isset( $setting['typography_font_family'] ) ) {
					unset( $system_typography[ $key ]['typography_font_family'] );
				}
			}

			Plugin::$instance->kits_manager->update_kit_settings_based_on_option( 'system_typography', $system_typography );
		}
	}
}
