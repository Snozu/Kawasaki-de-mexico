<?php
/**
 * Admin layouts class file.
 *
 * @package Woodmart
 */

namespace XTS\Modules\Layouts;

use WP_Post;
use WP_Query;
use XTS\Singleton;

/**
 * Admin layouts class.
 */
class Admin extends Singleton {
	/**
	 * Layout types.
	 *
	 * @var array
	 */
	private $layout_types = array();
	/**
	 * Post type.
	 *
	 * @var string
	 */
	private $post_type = 'woodmart_layout';
	/**
	 * Type meta key.
	 *
	 * @var string
	 */
	private $type_meta_key = 'wd_layout_type';
	/**
	 * Conditions meta key.
	 *
	 * @var string
	 */
	private $conditions_meta_key = 'wd_layout_conditions';

	/**
	 * Constructor.
	 */
	public function init() {
		add_action( 'init', array( $this, 'set_layout_types' ) );
		add_filter( 'woodmart_admin_localized_string_array', array( $this, 'add_localized_settings' ) );

		$this->add_actions();
	}

	/**
	 * Set layout type.
	 */
	public function set_layout_types() {
		$woocommerce_types = array(
			'single_product'   => esc_html__( 'Single product', 'woodmart' ),
			'shop_archive'     => esc_html__( 'Products archive', 'woodmart' ),
			'cart'             => esc_html__( 'Cart', 'woodmart' ),
			'empty_cart'       => esc_html__( 'Empty cart', 'woodmart' ),
			'checkout_form'    => esc_html__( 'Checkout form', 'woodmart' ),
			'checkout_content' => esc_html__( 'Checkout top content', 'woodmart' ),
			'thank_you_page'   => esc_html__( 'Thank you page', 'woodmart' ),
		);

		if ( woodmart_woocommerce_installed() ) {
			$this->layout_types += $woocommerce_types;

			if ( 'native' === woodmart_get_opt( 'current_builder' ) ) {
					$this->layout_types['checkout_form'] = esc_html__( 'Checkout', 'woodmart' );
					unset( $this->layout_types['checkout_content'] );
			}
		}

		$this->layout_types += array(
			'single_post'       => esc_html__( 'Single post', 'woodmart' ),
			'blog_archive'      => esc_html__( 'Blog', 'woodmart' ),
			'single_portfolio'  => esc_html__( 'Single project', 'woodmart' ),
			'portfolio_archive' => esc_html__( 'Portfolio', 'woodmart' ),
		);
	}

	/**
	 * Enqueue scripts.
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( 'wd-layout', WOODMART_THEME_DIR . '/inc/modules/layouts/assets/layouts.js', array( 'jquery' ), WOODMART_VERSION, true );
		wp_enqueue_script( 'select2', WOODMART_ASSETS . '/js/libs/select2.full.min.js', array(), WOODMART_VERSION, true );
	}

	/**
	 * Add actions.
	 */
	public function add_actions() {
		add_filter( 'views_edit-woodmart_layout', array( $this, 'print_interface' ) );
		add_filter( 'parse_query', array( $this, 'filter_layouts_by_type' ) );
		add_action(
			'manage_woodmart_layout_posts_columns',
			array(
				$this,
				'admin_columns_titles',
			)
		);
		add_action(
			'manage_woodmart_layout_posts_custom_column',
			array(
				$this,
				'admin_columns_content',
			),
			10,
			2
		);
		add_action( 'add_meta_boxes', array( $this, 'add_conditions_box' ), 10, 2 );
	}

	/**
	 * Add box.
	 *
	 * @param string  $post_type Post type.
	 * @param WP_Post $post      Post object.
	 */
	public function add_conditions_box( $post_type, $post ) {
		if ( 'woodmart_layout' !== $post_type ) {
			return;
		}

		$type = get_post_meta( $post->ID, $this->type_meta_key, true );

		if ( 'cart' === $type || 'empty_cart' === $type || 'checkout_content' === $type || 'checkout_form' === $type || 'thank_you_page' === $type ) {
			return;
		}

		add_meta_box(
			'wd-layout-conditions',
			esc_html__( 'Layout conditions', 'woodmart' ),
			array(
				$this,
				'conditions_box_callback',
			),
			'woodmart_layout',
		);
	}

	/**
	 * Box callback.
	 *
	 * @param WP_Post $post Post object.
	 */
	public function conditions_box_callback( $post ) {
		$this->enqueue_scripts();
		$this->print_condition_template();
		echo $this->get_edit_conditions_template( $post->ID ); // phpcs:ignore
	}

	/**
	 * Get template.
	 *
	 * @param string $template_name Template name.
	 * @param array  $args          Arguments for template.
	 */
	public function get_template( $template_name, $args = array() ) {
		if ( ! empty( $args ) && is_array( $args ) ) {
			extract( $args ); // phpcs:ignore
		}

		include WOODMART_THEMEROOT . '/inc/modules/layouts/admin/templates/' . $template_name . '.php';
	}

	/**
	 * Is current screen.
	 *
	 * @return bool
	 */
	private function is_current_screen() {
		global $pagenow, $typenow;

		return 'edit.php' === $pagenow && $this->post_type === $typenow;
	}

	/**
	 * Filter layouts by type.
	 *
	 * @param WP_Query $query Query.
	 *
	 * @return void
	 */
	public function filter_layouts_by_type( $query ) {
		if ( ! $this->is_current_screen() || ! isset( $_GET['wd_layout_type_tab'] ) || 'all' === $_GET['wd_layout_type_tab'] ) { // phpcs:ignore
			return;
		}

		$current_tab = sanitize_text_field( $_GET['wd_layout_type_tab'] ); // phpcs:ignore

		if ( 'checkout' === $current_tab ) {
			$current_tab = array( 'checkout_form', 'checkout_content', 'thank_you_page' );
		}

		if ( 'cart' === $current_tab ) {
			$current_tab = array( 'cart', 'empty_cart' );
		}

		if ( 'post' === $current_tab ) {
			$current_tab = array( 'single_post', 'single_portfolio' );
		}

		if ( 'archive' === $current_tab ) {
			$current_tab = array( 'blog_archive', 'portfolio_archive' );
		}

		$query->query_vars['type_meta_key'] = $this->type_meta_key; // phpcs:ignore
		$query->query_vars['meta_value']    = $current_tab; // phpcs:ignore
	}

	/**
	 * Columns content.
	 *
	 * @param string $column_name Column name.
	 * @param int    $post_id     Post id.
	 */
	public function admin_columns_content( $column_name, $post_id ) {
		if ( 'wd_layout_type' === $column_name ) {
			$type = get_post_meta( $post_id, $this->type_meta_key, true );

			if ( 'native' === woodmart_get_opt( 'current_builder' ) && 'checkout_content' === $type ) {
				$type = 'checkout_form';
			}

			$url = add_query_arg(
				array(
					'post_type'          => $this->post_type,
					'wd_layout_type_tab' => $type,
				),
				admin_url( 'edit.php' )
			);

			?>
			<?php if ( $type && isset( $this->layout_types[ $type ] ) ) : ?>
				<a href="<?php echo esc_url( $url ); ?>">
					<?php echo esc_html( $this->layout_types[ $type ] ); ?>
				</a>
			<?php endif; ?>
			<?php
		}

		if ( 'wd_layout_conditions' === $column_name ) {
			echo $this->get_edit_conditions_template( $post_id ); // phpcs:ignore
		}

		if ( 'wd_layout_status' === $column_name ) {
			echo $this->get_status_button_template( $post_id ); // phpcs:ignore
		}
	}

	/**
	 * Columns header.
	 *
	 * @param array $posts_columns Columns.
	 *
	 * @return array
	 */
	public function admin_columns_titles( $posts_columns ) {
		$offset = 2;

		return array_slice( $posts_columns, 0, $offset, true ) + array(
			'wd_layout_type'       => esc_html__( 'Type', 'elementor' ),
			'wd_layout_conditions' => esc_html__( 'Conditions', 'elementor' ),
			'wd_layout_status'     => esc_html__( 'Active', 'elementor' ),
		) + array_slice( $posts_columns, $offset, null, true );
	}

	/**
	 * Get edit conditions template.
	 *
	 * @param int $post_id Post id.
	 *
	 * @return string
	 */
	public function get_status_button_template( $post_id ) {
		ob_start();

		$this->get_template(
			'status-button',
			array(
				'post_id' => $post_id,
				'status'  => get_post_status( $post_id ),
			)
		);

		return ob_get_clean();
	}

	/**
	 * Get edit conditions template.
	 *
	 * @param int $post_id Post id.
	 *
	 * @return string
	 */
	public function get_edit_conditions_template( $post_id ) {
		ob_start();

		$conditions = get_post_meta( $post_id, $this->conditions_meta_key, true );
		$type       = get_post_meta( $post_id, $this->type_meta_key, true );

		if ( 'cart' === $type || 'empty_cart' === $type || 'checkout_content' === $type || 'checkout_form' === $type || 'thank_you_page' === $type ) {
			return ob_get_clean();
		}

		if ( $conditions ) {
			foreach ( $conditions as $key => $condition ) {
				if ( ! empty( $condition['condition_query'] ) ) {
					if ( in_array( $condition['condition_type'], array( 'product', 'post_id', 'project_id' ), true ) ) {
						$post = get_post( $condition['condition_query'] );

						$conditions[ $key ]['condition_query_text'] = $post->post_title . ' (ID: ' . $post->ID . ')';
					} elseif ( 'post_format' === $condition['condition_type'] ) {
						$post_formats = get_post_format_strings();
						if ( isset( $post_formats[ $condition['condition_query'] ] ) ) {
							$conditions[ $key ]['condition_query_text'] = $post_formats[ $condition['condition_query'] ];
						}
					} elseif ( 'product_attr' === $condition['condition_type'] || 'filtered_product_term' === $condition['condition_type'] ) {
						$taxonomy = get_taxonomy( $condition['condition_query'] );

						if ( $taxonomy ) {
							$conditions[ $key ]['condition_query_text'] = $taxonomy->labels->singular_name . ' (Tax: ' . $taxonomy->name . ')';
						} else {
							$conditions[ $key ]['condition_query_text'] = '';
						}
					} elseif ( 'product_type' === $condition['condition_type'] ) {
						$conditions[ $key ]['condition_query_text'] = wc_get_product_types()[ $condition['condition_query'] ];
					} else {
						$term = get_term( $condition['condition_query'] );

						if ( $term ) {
							$conditions[ $key ]['condition_query_text'] = $term->name . ' (ID: ' . $term->term_id . ')';
						} else {
							$conditions[ $key ]['condition_query_text'] = '';
						}
					}
				}
			}
		}

		$this->get_template(
			'edit-conditions',
			array(
				'admin'      => $this,
				'conditions' => $conditions,
				'type'       => $type,
				'post_id'    => $post_id,
			)
		);

		return ob_get_clean();
	}

	/**
	 * Interface.
	 *
	 * @param mixed $views Default views.
	 *
	 * @return mixed
	 */
	public function print_interface( $views ) {
		$this->enqueue_scripts();

		$this->get_template( 'interface', array( 'admin' => $this ) );

		return $views;
	}

	/**
	 * Print predefined layouts.
	 */
	public function get_predefined_layouts() {
		$layouts = array(
			'shop_archive'     => array(
				'layout-1'  => array(
					'url' => WOODMART_DEMO_URL . 'shop/?opts=product_archive_layout_1',
				),
				'layout-2'  => array(
					'url' => WOODMART_DEMO_URL . 'shop/?opts=product_archive_layout_2',
				),
				'layout-3'  => array(
					'url' => WOODMART_DEMO_URL . 'shop/?opts=product_archive_layout_3',
				),
				'layout-4'  => array(
					'url' => WOODMART_DEMO_URL . 'shop/?opts=product_archive_layout_4',
				),
				'layout-5'  => array(
					'url' => WOODMART_DEMO_URL . 'shop/',
				),
				'layout-6'  => array(
					'url' => WOODMART_DEMO_URL . 'shop/?opts=product_archive_layout_5',
				),
				'layout-7'  => array(
					'url' => WOODMART_DEMO_URL . 'shop/?opts=product_archive_layout_6',
				),
				// Megamarket.
				'layout-8'  => array(
					'url' => WOODMART_DEMO_URL . 'megamarket/all-products/',
				),
				'layout-9'  => array(
					'url' => WOODMART_DEMO_URL . 'megamarket/product-category/flooring/',
				),
				'layout-10' => array(
					'url' => WOODMART_DEMO_URL . 'megamarket/product-category/tools/',
				),
				// Accessories.
				'layout-11' => array(
					'url' => WOODMART_DEMO_URL . 'accessories/product-category/cases/',
				),
				'layout-12' => array(
					'url' => WOODMART_DEMO_URL . 'accessories/shop/?filter_brand=anker',
				),
				'layout-13' => array(
					'url' => WOODMART_DEMO_URL . 'accessories/shop/',
				),
				// Mega-electronics.
				'layout-14' => array(
					'url' => WOODMART_DEMO_URL . 'mega-electronics/product-category/hardware-components/',
				),
			),
			'single_product'   => array(
				'layout-1'  => array(
					'url' => WOODMART_DEMO_URL . 'shop/lighting/bolla-gervasoni/?opts=single_product_layout_5',
				),
				'layout-2'  => array(
					'url' => WOODMART_DEMO_URL . 'shop/furniture/vivant-janus-charles/?opts=single_product_layout_1',
				),
				'layout-3'  => array(
					'url' => WOODMART_DEMO_URL . 'shop/furniture/sculptures-jeux/?opts=single_product_layout_2',
				),
				'layout-4'  => array(
					'url' => WOODMART_DEMO_URL . 'shop/furniture/slat-bench/?opts=single_product_layout_3',
				),
				'layout-5'  => array(
					'url' => WOODMART_DEMO_URL . 'shop/furniture/feelgood-designs/?opts=single_product_layout_4',
				),
				'layout-6'  => array(
					'url' => WOODMART_DEMO_URL . 'shop/toys/augue-adipiscing-euismod/?opts=single_product_layout_6',
				),
				'layout-7'  => array(
					'url' => WOODMART_DEMO_URL . 'shop/furniture/reflect-chest-of-drawers/?opts=single_product_layout_7',
				),
				'layout-8'  => array(
					'url' => WOODMART_DEMO_URL . 'shop/furniture/char-with-love/?opts=single_product_layout_8',
				),
				'layout-9'  => array(
					'url' => WOODMART_DEMO_URL . 'shop/furniture/euismod-aliquam-parturient/?opts=single_product_layout_9',
				),
				// Megamarket.
				'layout-10' => array(
					'url' => WOODMART_DEMO_URL . 'megamarket/product/rectangular-sink/',
				),
				// Accessories.
				'layout-11' => array(
					'url' => WOODMART_DEMO_URL . 'accessories/product/iphone-12-pro-moment-case-blue/',
				),
				// Mega-electronics.
				'layout-12' => array(
					'url' => WOODMART_DEMO_URL . 'mega-electronics/product/apple-macbook-pro-16-m1-pro-2/',
				),
			),
			'cart'             => array(
				'layout-1' => array(),
				'layout-3' => array(),
			),
			'checkout_form'    => array(
				'layout-1' => array(),
				'layout-2' => array(),
				// Megamarket.
				'layout-3' => array(),
				// Accessories.
				'layout-4' => array(),
			),
			'checkout_content' => array(
				'layout-2' => array(),
				// Accessories.
				'layout-3' => array(),
			),
			'thank_you_page' => array(
				'layout-1' => array(),
			),
			'blog_archive' => array(
				'layout-1' => array(),
				'layout-2' => array(),
			),
			'portfolio_archive' => array(
				'layout-1' => array(),
				'layout-2' => array(),
			),
			'single_post' => array(
				'layout-1' => array(),
				'layout-2' => array(),
			),
			'single_portfolio' => array(
				'layout-1' => array(),
			),
		);

		$this->get_template(
			'predefined-layouts',
			array(
				'layouts' => $layouts,
			)
		);
	}

	/**
	 * Print condition template.
	 */
	public function print_condition_template() {
		$this->get_template( 'condition' );
	}

	/**
	 * Print layout form.
	 */
	public function get_form() {
		ob_start();

		$this->get_template(
			'create-form',
			array(
				'layout_types' => $this->layout_types,
				'admin'        => $this,
			)
		);

		return ob_get_clean();
	}

	/**
	 * Print layout tabs.
	 */
	public function print_tabs() {
		$tabs = array(
			'all' => esc_html__( 'All', 'woodmart' ),
		) + $this->layout_types;

		if ( woodmart_woocommerce_installed() ) {
			$tabs = array_slice( $tabs, 0, 4, true ) +
				array( 'checkout' => esc_html__( 'Checkout', 'woodmart' ) ) +
				array_slice( $tabs, 4, null, true );

			unset( $tabs['checkout_content'] );
			unset( $tabs['checkout_form'] );
			unset( $tabs['thank_you_page'] );
			unset( $tabs['empty_cart'] );
		}

		$tabs['post'] = esc_html__( 'Single post', 'woodmart' );
		unset( $tabs['single_post'] );
		unset( $tabs['single_portfolio'] );

		$tabs['archive'] = esc_html__( 'Posts archive', 'woodmart' );
		unset( $tabs['blog_archive'] );
		unset( $tabs['portfolio_archive'] );

		$current_tab = 'all';

		if ( ! empty( $_GET['wd_layout_type_tab'] ) ) { // phpcs:ignore
			$current_tab = $_GET['wd_layout_type_tab']; // phpcs:ignore
		}

		if ( woodmart_woocommerce_installed() && ( 'checkout_content' === $current_tab || 'checkout_form' === $current_tab || 'thank_you_page' === $current_tab ) ) {
			$current_tab = 'checkout';
		}

		if ( woodmart_woocommerce_installed() && 'empty_cart' === $current_tab ) {
			$current_tab = 'cart';
		}

		if ( 'post' === $current_tab ) {
			$current_tab = 'post';
		}

		if ( 'archive' === $current_tab ) {
			$current_tab = 'archive';
		}

		$base_url = add_query_arg(
			array(
				'post_type' => $this->post_type,
			),
			admin_url( 'edit.php' )
		);

		$this->get_template(
			'tabs',
			array(
				'tabs'        => $tabs,
				'current_tab' => $current_tab,
				'base_url'    => $base_url,
			)
		);
	}

	/**
	 * Add localized settings.
	 *
	 * @param array $settings Settings.
	 * @return array
	 */
	public function add_localized_settings( $settings ) {
		return array_merge(
			$settings,
			array(
				'creation_error' => esc_html__( 'Something went wrong with the creation of the layout!', 'woodmart' ),
				'editing_error'  => esc_html__( 'Something went wrong with editing the layout!', 'woodmart' ),
				'success_save'   => esc_html__( 'Conditions has been successfully saved', 'woodmart' ),
			)
		);
	}
}

Admin::get_instance();
