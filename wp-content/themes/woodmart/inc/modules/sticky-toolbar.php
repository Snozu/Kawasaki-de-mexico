<?php

use XTS\Modules\Layouts\Global_Data;
use XTS\Modules\Layouts\Main as Builder;

if ( ! function_exists( 'woodmart_get_sticky_toolbar_fields' ) ) {
	/**
	 * All available fields for Theme Settings sorter option.
	 *
	 * @since 3.6
	 */
	function woodmart_get_sticky_toolbar_fields( $new = false ) {

		if ( $new ) {
			$options = array(
				'shop' => array(
					'name'  => esc_html__( 'Shop page', 'woodmart' ),
					'value' => 'shop',
				),
				'sidebar' => array(
					'name'  => esc_html__( 'Off canvas sidebar', 'woodmart' ),
					'value' => 'sidebar',
				),
				'wishlist' => array(
					'name'  => esc_html__( 'Wishlist', 'woodmart' ),
					'value' => 'wishlist',
				),
				'cart' => array(
					'name'  => esc_html__( 'Cart', 'woodmart' ),
					'value' => 'cart',
				),
				'account' => array(
					'name'  => esc_html__( 'My account', 'woodmart' ),
					'value' => 'account',
				),
				'mobile' => array(
					'name'  => esc_html__( 'Mobile menu', 'woodmart' ),
					'value' => 'mobile',
				),
				'mobile_categories' => array(
					'name'  => esc_html__( 'Mobile categories menu', 'woodmart' ),
					'value' => 'mobile_categories',
				),
				'home' => array(
					'name'  => esc_html__( 'Home page', 'woodmart' ),
					'value' => 'home',
				),
				'blog' => array(
					'name'  => esc_html__( 'Blog page', 'woodmart' ),
					'value' => 'blog',
				),
				'compare' => array(
					'name'  => esc_html__( 'Compare', 'woodmart' ),
					'value' => 'compare',
				),
				'link_1' => array(
					'name'  => esc_html__( 'Button [1]', 'woodmart' ),
					'value' => 'link_1',
				),
				'link_2' => array(
					'name'  => esc_html__( 'Button [2]', 'woodmart' ),
					'value' => 'link_2',
				),
				'link_3' => array(
					'name'  => esc_html__( 'Button [3]', 'woodmart' ),
					'value' => 'link_3',
				),
				'link_4' => array(
					'name'  => esc_html__( 'Button [4]', 'woodmart' ),
					'value' => 'link_4',
				),
				'link_5' => array(
					'name'  => esc_html__( 'Button [5]', 'woodmart' ),
					'value' => 'link_5',
				),
			);

			if ( apply_filters( 'woodmart_toolbar_search', false ) ) {
				$options['search'] = array(
					'name'  => esc_html__( 'Search', 'woodmart' ),
					'value' => 'search',
				);
			}

			return $options;
		}

		$fields = array(
			'enabled'  => array(
				'shop'     => esc_html__( 'Shop page', 'woodmart' ),
				'sidebar'  => esc_html__( 'Off canvas sidebar', 'woodmart' ),
				'wishlist' => esc_html__( 'Wishlist', 'woodmart' ),
				'cart'     => esc_html__( 'Cart', 'woodmart' ),
				'account'  => esc_html__( 'My account', 'woodmart' ),
			),
			'disabled' => array(
				'mobile'   => esc_html__( 'Mobile menu', 'woodmart' ),
				'home'     => esc_html__( 'Home page', 'woodmart' ),
				'blog'     => esc_html__( 'Blog page', 'woodmart' ),
				'compare'  => esc_html__( 'Compare', 'woodmart' ),
				'link_1'   => esc_html__( 'Button [1]', 'woodmart' ),
				'link_2'   => esc_html__( 'Button [2]', 'woodmart' ),
				'link_3'   => esc_html__( 'Button [3]', 'woodmart' ),
				'link_4'   => esc_html__( 'Button [4]', 'woodmart' ),
				'link_5'   => esc_html__( 'Button [5]', 'woodmart' ),
			),
		);

		if ( apply_filters( 'woodmart_toolbar_search', false ) ) {
			$fields['disabled']['search'] = esc_html__( 'Search', 'woodmart' );
		}

		return $fields;
	}
}

if ( ! function_exists( 'woodmart_sticky_toolbar_template' ) ) {
	/**
	 * Sticky toolbar template
	 *
	 * @since 3.6
	 */
	function woodmart_sticky_toolbar_template() {
		if ( woodmart_is_maintenance_active() ) {
			return;
		}

		$fields  = woodmart_get_opt( 'sticky_toolbar_fields' );
		$classes = '';

		if ( is_array( $fields ) ) {
			$fields = array_filter( $fields );
		}

		if ( isset( $fields['enabled']['placebo'] ) ) {
			unset( $fields['enabled']['placebo'] );
		}

		$enabled_fields = class_exists( 'XTS\Admin\Modules\Options' ) ? $fields : $fields['enabled'];

		if ( ! woodmart_get_opt( 'sticky_toolbar' ) || ! $enabled_fields || is_admin() || defined( 'IFRAME_REQUEST' ) ) {
			return;
		}

		if ( woodmart_get_opt( 'sticky_toolbar_label' ) ) {
			$classes .= ' wd-toolbar-label-show';
			$classes .= woodmart_get_old_classes( ' woodmart-toolbar-label-show' );
		}

		woodmart_enqueue_inline_style( 'bottom-toolbar' );
		woodmart_enqueue_inline_style( 'mod-tools' );
		woodmart_enqueue_inline_style( 'header-elements-base' );

		$classes .= woodmart_get_old_classes( ' woodmart-toolbar' );

		?>
		<div class="wd-toolbar<?php echo esc_attr( $classes ); ?>">
			<?php
			foreach ( $enabled_fields as $key => $value ) {
				$key = class_exists( 'XTS\Admin\Modules\Options' ) ? $value : $key;
				switch ( $key ) {
					case 'wishlist':
						woodmart_sticky_toolbar_wishlist_template();
						break;
					case 'cart':
						woodmart_sticky_toolbar_cart_template();
						break;
					case 'compare':
						woodmart_sticky_toolbar_compare_template();
						break;
					case 'search':
						woodmart_sticky_toolbar_search_template();
						break;
					case 'account':
						woodmart_sticky_toolbar_account_template();
						break;
					case 'mobile':
						woodmart_sticky_toolbar_mobile_menu_template();
						break;
					case 'mobile_categories':
						woodmart_sticky_toolbar_mobile_categories_menu_template();
						break;
					case 'sidebar':
						woodmart_sticky_sidebar_button( false, true );
						break;
					case 'link_1';
					case 'link_2';
					case 'link_3';
					case 'link_4';
					case 'link_5';
						woodmart_sticky_toolbar_custom_link_template( $key );
						break;
					case 'home';
					case 'blog';
					case 'shop':
						woodmart_sticky_toolbar_page_link_template( $key );
						break;
				}
			}
			?>
		</div>
		<?php

	}

	add_action( 'wp_footer', 'woodmart_sticky_toolbar_template' );
}

if ( ! function_exists( 'woodmart_sticky_toolbar_wishlist_template' ) ) {
	/**
	 * Sticky toolbar wishlist template
	 *
	 * @since 3.6
	 */
	function woodmart_sticky_toolbar_wishlist_template() {
		if ( ! woodmart_woocommerce_installed() || ! woodmart_get_opt( 'wishlist', 1 ) || ( woodmart_get_opt( 'wishlist_logged' ) && ! is_user_logged_in() ) ) {
			return;
		}

		$settings      = whb_get_settings();
		$product_count = false;
		$classes       = '';

		if ( isset( $settings['wishlist']['hide_product_count'] ) ) {
			$product_count = ! $settings['wishlist']['hide_product_count'];
		}

		if ( ! $product_count ) {
			$classes .= ' without-product-count';
		}

		woodmart_enqueue_js_script( 'wishlist' );

		?>
		<div class="wd-header-wishlist wd-tools-element wd-design-5<?php echo esc_attr( $classes ); ?>" title="<?php echo esc_attr__( 'My wishlist', 'woodmart' ); ?>">
			<a href="<?php echo esc_url( woodmart_get_wishlist_page_url() ); ?>">
				<span class="wd-tools-icon">
					<?php if ( $product_count ) : ?>
						<span class="wd-tools-count">
							<?php echo esc_html( woodmart_get_wishlist_count() ); ?>
						</span>
					<?php endif; ?>
				</span>
				<span class="wd-toolbar-label">
					<?php echo esc_html_x( 'Wishlist', 'toolbar', 'woodmart' ); ?>
				</span>
			</a>
		</div>
		<?php
	}
}

if ( ! function_exists( 'woodmart_sticky_toolbar_cart_template' ) ) {
	/**
	 * Sticky toolbar cart template
	 *
	 * @since 3.6
	 */
	function woodmart_sticky_toolbar_cart_template() {
		if ( ! woodmart_woocommerce_installed() || ( ! is_user_logged_in() && woodmart_get_opt( 'login_prices' ) ) ) {
			return;
		}

		$settings     = whb_get_settings();
		$opener       = false;
		$classes      = '';
		$icon_classes = ' wd-icon-alt';

		if ( isset( $settings['cart']['position'] ) ) {
			$opener = $settings['cart']['position'] == 'side';
		}

		if ( ! empty( $settings['cart']['icon_type'] ) && 'cart' === $settings['cart']['icon_type'] ) {
			$icon_classes = '';
		}

		if ( $opener ) {
			woodmart_enqueue_inline_style( 'header-cart-side' );

			$classes .= ' cart-widget-opener';
		}

		woodmart_enqueue_inline_style( 'header-cart' );

		$classes .= woodmart_get_old_classes( ' woodmart-shopping-cart' );

		?>
		<div class="wd-header-cart wd-tools-element wd-design-5<?php echo esc_attr( $classes ); ?>" title="<?php echo esc_attr__( 'My cart', 'woodmart' ); ?>">
			<a href="<?php echo esc_url( wc_get_cart_url() ); ?>">
				<span class="wd-tools-icon<?php echo esc_attr( $icon_classes ); ?>">
					<?php woodmart_cart_count(); ?>
				</span>
				<span class="wd-toolbar-label">
					<?php esc_html_e( 'Cart', 'woodmart' ); ?>
				</span>
			</a>
		</div>
		<?php
	}
}


if ( ! function_exists( 'woodmart_sticky_toolbar_compare_template' ) ) {
	/**
	 * Sticky toolbar compare template
	 *
	 * @since 3.6
	 */
	function woodmart_sticky_toolbar_compare_template() {
		if ( ! woodmart_woocommerce_installed() || ! woodmart_get_opt( 'compare' ) ) {
			return;
		}

		$settings      = whb_get_settings();
		$product_count = false;
		$classes       = '';

		if ( isset( $settings['compare']['hide_product_count'] ) ) {
			$product_count = ! $settings['compare']['hide_product_count'];
		}

		if ( ! $product_count ) {
			$classes .= ' without-product-count';
		}

		?>
		<div class="wd-header-compare wd-tools-element wd-design-5<?php echo esc_attr( $classes ); ?>" title="<?php echo esc_attr__( 'Compare products', 'woodmart' ); ?>">
			<a href="<?php echo esc_url( woodmart_get_compare_page_url() ); ?>">
				<span class="wd-tools-icon">
					<?php if ( $product_count ) : ?>
						<span class="wd-tools-count"><?php echo woodmart_get_compare_count(); ?></span>
					<?php endif; ?>
				</span>
				<span class="wd-toolbar-label">
					<?php esc_html_e( 'Compare', 'woodmart' ); ?>
				</span>
			</a>
		</div>
		<?php
	}
}

if ( ! function_exists( 'woodmart_sticky_toolbar_search_template' ) ) {
	/**
	 * Sticky toolbar search template
	 *
	 * @since 3.6
	 */
	function woodmart_sticky_toolbar_search_template() {
		woodmart_enqueue_js_script( 'mobile-search' );
		?>
		<div class="wd-header-search wd-header-search-mobile<?php echo woodmart_get_old_classes( ' mobile-search-icon search-button' ); ?>">
			<a href="#" rel="nofollow" aria-label="<?php esc_attr_e( 'Search', 'woodmart' ); ?>">
				<span class="wd-tools-icon<?php echo woodmart_get_old_classes( ' search-button-icon' ); ?>"></span>
				<span class="wd-toolbar-label">
					<?php esc_html_e( 'Search', 'woodmart' ); ?>
				</span>
			</a>
		</div>
		<?php
	}
}

if ( ! function_exists( 'woodmart_sticky_toolbar_account_template' ) ) {
	/**
	 * Sticky toolbar account template
	 *
	 * @since 3.6
	 */
	function woodmart_sticky_toolbar_account_template() {
		if ( ! woodmart_woocommerce_installed() ) {
			return;
		}

		$settings = whb_get_settings();
		$is_side  = isset( $settings['account'] ) && 'side' === $settings['account']['form_display'] && $settings['account']['login_dropdown'];
		$classes  = '';

		if ( ! is_user_logged_in() && $is_side ) {
			woodmart_enqueue_js_script( 'login-sidebar' );
			$classes .= ' login-side-opener';
		}

		woodmart_enqueue_inline_style( 'header-my-account' );

		?>
		<div class="wd-header-my-account wd-tools-element wd-style-icon <?php echo esc_attr( $classes ); ?>">
			<a href="<?php echo esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ); ?>">
				<span class="wd-tools-icon"></span>
				<span class="wd-toolbar-label">
					<?php echo esc_html_x( 'My account', 'toolbar', 'woodmart' ); ?>
				</span>
			</a>
		</div>
		<?php
	}
}

if ( ! function_exists( 'woodmart_sticky_toolbar_page_link_template' ) ) {
	/**
	 * Sticky toolbar page link template
	 *
	 * @since 3.6
	 */
	function woodmart_sticky_toolbar_page_link_template( $key ) {
		$url = '';

		switch ( $key ) {
			case 'blog':
				$url  = get_permalink( get_option( 'page_for_posts' ) );
				$text = esc_html__( 'Blog', 'woodmart' );
				break;
			case 'home':
				$url  = get_home_url();
				$text = esc_html__( 'Home', 'woodmart' );
				break;
			case 'shop':
				$url  = woodmart_woocommerce_installed() ? get_permalink( wc_get_page_id( 'shop' ) ) : get_home_url();
				$text = esc_html__( 'Shop', 'woodmart' );
				break;
		}

		$classes = '';

		$classes .= woodmart_get_old_classes( ' woodmart-toolbar-' . $key );
		$classes .= woodmart_get_old_classes( ' woodmart-toolbar-item' );

		?>
		<div class="wd-toolbar-<?php echo esc_attr( $key ); ?> wd-toolbar-item wd-tools-element<?php echo esc_attr( $classes ); ?>">
			<a href="<?php echo esc_url( $url ); ?>">
				<span class="wd-tools-icon"></span>
				<span class="wd-toolbar-label">
					<?php echo $text; ?>
				</span>
			</a>
		</div>
		<?php
	}
}

if ( ! function_exists( 'woodmart_sticky_toolbar_custom_link_template' ) ) {
	/**
	 * Sticky toolbar custom link template
	 *
	 * @since 3.6
	 *
	 * @param string $key Key.
	 */
	function woodmart_sticky_toolbar_custom_link_template( $key ) {
		woodmart_lazy_loading_deinit( true );

		$wrapper_classes = '';
		$url             = woodmart_get_opt( $key . '_url' );
		$text            = woodmart_get_opt( $key . '_text' );
		$icon            = woodmart_get_opt( $key . '_icon' );

		$wrapper_classes .= isset( $icon['id'] ) && $icon['id'] ? ' wd-tools-custom-icon' : '';

		$wrapper_classes .= woodmart_get_old_classes( ' woodmart-toolbar-item woodmart-toolbar-link' );

		?>
		<?php if ( $url && $text ) : ?>
			<div class="wd-toolbar-link wd-tools-element wd-toolbar-item<?php echo esc_attr( $wrapper_classes ); ?>">
				<a href="<?php echo wp_kses( $url, true ); ?>">
					<span class="wd-toolbar-icon wd-tools-icon wd-icon wd-custom-icon">
						<?php if ( isset( $icon['id'] ) && $icon['id'] ) : ?>
							<?php echo wp_get_attachment_image( $icon['id'] ); ?>
						<?php endif; ?>
					</span>

					<span class="wd-toolbar-label">
						<?php echo esc_html( $text ); ?>
					</span>
				</a>
			</div>
		<?php endif; ?>
		<?php

		woodmart_lazy_loading_init();
	}
}

if ( ! function_exists( 'woodmart_sticky_toolbar_mobile_menu_template' ) ) {
	/**
	 * Sticky toolbar mobile menu template
	 *
	 * @since 3.6
	 */
	function woodmart_sticky_toolbar_mobile_menu_template() {
		?>
		<div class="wd-header-mobile-nav whb-wd-header-mobile-nav mobile-style-icon wd-tools-element<?php echo woodmart_get_old_classes( ' woodmart-burger-icon' ); ?>">
			<a href="#" rel="nofollow">
				<span class="wd-tools-icon<?php echo woodmart_get_old_classes( ' woodmart-burger' ); ?>"></span>
				<span class="wd-toolbar-label">
					<?php esc_html_e( 'Menu', 'woodmart' ); ?>
				</span>
			</a>
		</div>
		<?php
	}
}

if ( ! function_exists( 'woodmart_sticky_toolbar_mobile_categories_menu_template' ) ) {
	/**
	 * Sticky toolbar mobile categories menu template.
	 */
	function woodmart_sticky_toolbar_mobile_categories_menu_template() {
		$is_side_hidden_layout     = Global_Data::get_instance()->get_data( 'mobile_categories_is_side_hidden' ) ? Global_Data::get_instance()->get_data( 'mobile_categories_is_side_hidden' ) : 'side-hidden' === woodmart_get_opt( 'mobile_categories_layout', 'accordion' );
		$shop_categories_ancestors = Global_Data::get_instance()->get_data( 'shop_categories_ancestors' ) ? Global_Data::get_instance()->get_data( 'shop_categories_ancestors' ) : woodmart_get_opt( 'shop_categories_ancestors' );

		if ( in_array( $is_side_hidden_layout, array( 'no', false ), true ) ) {
			return '';
		}

		$classes       = '';
		$data_settings = '';

		if ( in_array( $shop_categories_ancestors, array( 'yes', '1', true ), true ) ) {
			$data_settings = array(
				'shop_categories_ancestors' => $shop_categories_ancestors,
			);

			if ( Global_Data::get_instance()->get_data( 'mobile_categories_is_empty' ) ) {
				$classes = 'wd-hide';
			}
		}

		if ( ! empty( $data_settings ) ) {
			$data_settings = sprintf(
				'data-settings=%s',
				wp_json_encode( $data_settings )
			);
		}

		?>
		<div class="wd-toolbar-shop-cat wd-tools-element <?php echo esc_attr( $classes ); ?>" <?php echo esc_attr( $data_settings ); ?>>
			<a href="#" rel="nofollow">
				<span class="wd-tools-icon"></span>
				<span class="wd-toolbar-label">
					<?php esc_html_e( 'Categories', 'woodmart' ); ?>
				</span>
			</a>
		</div>
		<?php
	}
}
