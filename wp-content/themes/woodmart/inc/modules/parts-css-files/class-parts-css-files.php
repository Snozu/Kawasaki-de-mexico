<?php
/**
 * Page css files.
 *
 * @package xts
 */

namespace XTS\Modules;

use XTS\Singleton;

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

/**
 * Page css files.
 */
class Parts_Css_Files extends Singleton {
	/**
	 * Inline enqueue styles.
	 *
	 * @var array
	 */
	private $inline_enqueue_styles = array();

	/**
	 * Inline enqueue styles.
	 *
	 * @var array
	 */
	private $inline_enqueue_styles_mobile = array();

	/**
	 * Options save.
	 *
	 * @var array
	 */
	private $options_save = array(
		'404',
		'search',
		'date',
		'author',
	);

	/**
	 * Is mobile.
	 *
	 * @var string
	 */
	private $is_mobile;

	/**
	 * Page data.
	 *
	 * @var array
	 */
	private $page_data = array();

	/**
	 * Page css files.
	 *
	 * @var array
	 */
	private $page_css_files = array();

	/**
	 * Hooks.
	 */
	public function init() {
		$this->is_mobile = wp_is_mobile() && woodmart_get_opt( 'mobile_optimization', 0 );

		add_action( 'wp_enqueue_scripts', array( $this, 'register_page_css_files' ), 30 );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_page_css_files' ), 10100 );

		add_action( 'wp_footer', array( $this, 'save_page_css_files' ), 10000 );

		add_action( 'save_post', array( $this, 'delete_post_meta' ), 10 );
		add_action( 'saved_term', array( $this, 'delete_term_meta' ), 10 );
		add_action( 'save_post_cms_block', array( $this, 'delete_all_meta' ), 10 );
		add_action( 'save_post_woodmart_slider', array( $this, 'delete_all_meta' ), 10 );
		add_action( 'save_post_woodmart_layout', array( $this, 'delete_all_meta' ), 10 );
		add_action( 'xts_theme_settings_save', array( $this, 'delete_all_meta' ), 10 );
		add_action( 'activated_plugin', array( $this, 'delete_all_meta' ), 10 );
		add_action( 'deactivated_plugin', array( $this, 'delete_all_meta' ), 10 );

		add_action( 'wp', array( $this, 'set_page_data' ), 10 );
		add_action( 'wp', array( $this, 'set_page_css_files' ), 20 );

		add_action( 'woocommerce_single_product_summary', 'woodmart_page_css_files_disable', 59 );
		add_action( 'woocommerce_single_product_summary', 'woodmart_page_css_files_enable', 61 );
	}

	/**
	 * Set page data.
	 */
	public function set_page_data() {
		$this->page_data = $this->get_page_data();
	}

	/**
	 * Set page data.
	 */
	public function set_page_css_files() {
		$this->page_css_files = $this->get_page_css_files();
	}

	/**
	 * Delete all saved meta.
	 */
	public function delete_all_meta() {
		global $wpdb;

		$wpdb->delete( $wpdb->prefix . 'postmeta', array( 'meta_key' => 'wd_page_css_files' ) ); // phpcs:ignore
		$wpdb->delete( $wpdb->prefix . 'postmeta', array( 'meta_key' => 'wd_page_css_files_mobile' ) ); // phpcs:ignore
		$wpdb->delete( $wpdb->prefix . 'termmeta', array( 'meta_key' => 'wd_page_css_files' ) ); // phpcs:ignore

		foreach ( $this->options_save as $option ) {
			delete_option( 'wd_page_css_files_' . $option );
		}

		wp_cache_flush();
	}

	/**
	 * Delete post meta.
	 *
	 * @param integer $post_id Post id.
	 */
	public function delete_post_meta( $post_id ) {
		delete_post_meta( $post_id, 'wd_page_css_files' );
		delete_post_meta( $post_id, 'wd_page_css_files_mobile' );
	}

	/**
	 * Delete term meta.
	 *
	 * @param integer $term_id Term id.
	 */
	public function delete_term_meta( $term_id ) {
		delete_term_meta( $term_id, 'wd_page_css_files' );
	}

	/**
	 * Get current page data.
	 *
	 * @return array|string[]
	 */
	private function get_page_data() {
		$data = array(
			'type' => '',
			'id'   => '',
		);

		$queried_object = get_queried_object();

		if ( get_the_ID() ) {
			$data = array(
				'type' => 'post',
				'id'   => get_the_ID(),
			);
		}
		if ( is_singular() ) {
			$data = array(
				'type' => 'post',
				'id'   => get_queried_object_id(),
			);
		}
		if ( $queried_object && ( is_tag() || is_category() ) ) {
			$data = array(
				'type' => 'taxonomy',
				'id'   => $queried_object->term_id,
			);
		}
		if ( woodmart_woocommerce_installed() && $queried_object && ( is_product_tag() || is_product_category() || is_tax( 'product_brand' ) || woodmart_is_product_attribute_archive() ) ) {
			$data = array(
				'type' => 'taxonomy',
				'id'   => $queried_object->term_id,
			);
		}
		if ( is_archive() && 'portfolio' === get_post_type() ) {
			$data = array(
				'type' => 'post',
				'id'   => woodmart_get_portfolio_page_id(),
			);
		}
		if ( woodmart_woocommerce_installed() && is_shop() ) {
			$data = array(
				'type' => 'post',
				'id'   => get_option( 'woocommerce_shop_page_id' ),
			);
		}
		if ( is_home() ) {
			$data = array(
				'type' => 'post',
				'id'   => get_option( 'page_for_posts' ),
			);
		}
		if ( is_page() ) {
			$data = array(
				'type' => 'post',
				'id'   => get_queried_object_id(),
			);
		}
		if ( is_search() ) {
			$data = array(
				'type' => 'search',
				'id'   => '',
			);
		}
		if ( is_404() ) {
			$data = array(
				'type' => '404',
				'id'   => '',
			);
		}
		if ( is_date() ) {
			$data = array(
				'type' => 'date',
				'id'   => '',
			);
		}
		if ( is_author() ) {
			$data = array(
				'type' => 'author',
				'id'   => '',
			);
		}

		return $data;
	}

	/**
	 * Get page css files.
	 *
	 * @return array|false|mixed|void
	 */
	private function get_page_css_files() {
		$data = $this->page_data;

		if ( woodmart_is_woo_ajax() ) {
			return array();
		}

		if ( get_option( 'wd_page_css_files_theme_version' ) !== WOODMART_VERSION ) {
			$this->delete_all_meta();
		}

		$files = array();

		if ( 'post' === $data['type'] ) {
			if ( $this->is_mobile && get_post_meta( $data['id'], '_woodmart_mobile_content', true ) ) {
				$meta = get_post_meta( $data['id'], 'wd_page_css_files_mobile', true );
			} else {
				$meta = get_post_meta( $data['id'], 'wd_page_css_files', true );
			}
		} elseif ( 'taxonomy' === $data['type'] ) {
			$meta = get_term_meta( $data['id'], 'wd_page_css_files', true );
		} elseif ( in_array( $data['type'], array( 'search', '404', 'date', 'author' ), true ) ) {
			$files = get_option( 'wd_page_css_files_' . $data['type'], array() );
		}

		if ( isset( $meta ) && $meta ) {
			$files = $meta;
		}

		return $files;
	}

	/**
	 * Register page css files.
	 *
	 * @return void
	 */
	public function register_page_css_files() {
		$config = woodmart_get_config( 'css-files' );

		foreach ( $config as $value ) {
			foreach ( $value as $file ) {
				if ( isset( $file['wpb_file'] ) && 'wpb' === woodmart_get_current_page_builder() ) {
					$file['file'] = $file['wpb_file'];
				}

				if ( is_rtl() && isset( $file['rtl'] ) ) {
					$file['file'] = $file['file'] . '-rtl';
				}

				if ( ! empty( $file['media'] ) ) {
					$media = $file['media'];
				} else {
					$media = 'all';
				}

				wp_register_style( 'wd-' . $file['name'], WOODMART_THEME_DIR . $file['file'] . '.min.css', array(), WOODMART_VERSION, $media );
			}
		}
	}

	/**
	 * Enqueue page css files.
	 */
	public function enqueue_page_css_files() {
		$config     = woodmart_get_config( 'css-files' );
		$page_files = $this->page_css_files;
		$localize   = array();

		if ( woodmart_is_combined_needed( 'combined_css' ) || ! $page_files ) {
			if ( ! woodmart_is_combined_needed( 'combined_css' ) ) {
				if ( $this->is_mobile ) {
					$inline_enqueue_styles = $this->inline_enqueue_styles_mobile;
				} else {
					$inline_enqueue_styles = $this->inline_enqueue_styles;
				}

				if ( $inline_enqueue_styles ) {
					foreach ( $inline_enqueue_styles as $slug ) {
						if ( ! isset( $config[ $slug ] ) ) {
							continue;
						}

						foreach ( $config[ $slug ] as $file ) {
							if ( isset( $file['wpb_file'] ) && 'wpb' === woodmart_get_current_page_builder() ) {
								$file['file'] = $file['wpb_file'];
							}

							if ( is_rtl() && isset( $file['rtl'] ) ) {
								$file['file'] = $file['file'] . '-rtl';
							}

							$localize[ 'wd-' . $file['name'] . '-css' ] = WOODMART_THEME_DIR . $file['file'] . '.min.css';
						}
					}
				}
			}

			wp_localize_script( 'woodmart-theme', 'woodmart_page_css', $localize );

			return;
		}

		foreach ( $page_files as $slug ) {
			if ( ! isset( $config[ $slug ] ) ) {
				continue;
			}

			foreach ( $config[ $slug ] as $file ) {
				if ( isset( $file['wpb_file'] ) && 'wpb' === woodmart_get_current_page_builder() ) {
					$file['file'] = $file['wpb_file'];
				}

				if ( is_rtl() && isset( $file['rtl'] ) ) {
					$file['file'] = $file['file'] . '-rtl';
				}

				$src = WOODMART_THEME_DIR . $file['file'] . '.min.css';

				$localize[ 'wd-' . $file['name'] . '-css' ] = $src;

				wp_enqueue_style( 'wd-' . $file['name'] );
			}
		}

		wp_localize_script( 'woodmart-theme', 'woodmart_page_css', $localize );
	}

	/**
	 * Enqueue page css files.
	 *
	 * @param string $key             File slug.
	 */
	public function enqueue_style( $key, $ignore_combined = false ) {
		$config         = woodmart_get_config( 'css-files' );
		$styles_not_use = woodmart_get_opt( 'styles_not_use' );

		if ( woodmart_is_combined_needed( 'combined_css' ) && ! $ignore_combined || ! isset( $config[ $key ] ) ) {
			return;
		}

		foreach ( $config[ $key ] as $file ) {
			if ( is_array( $styles_not_use ) && in_array( $file['name'], $styles_not_use ) ) {
				continue;
			}

			if ( $this->is_mobile ) {
				$this->inline_enqueue_styles_mobile[] = $file['name'];
			} else {
				$this->inline_enqueue_styles[] = $file['name'];
			}

			wp_enqueue_style( 'wd-' . $file['name'] );
		}
	}

	/**
	 * Save page css files.
	 */
	public function save_page_css_files() {
		$data = $this->page_data;

		if ( $this->page_css_files || ! $this->inline_enqueue_styles ) {
			return;
		}

		if ( isset( $data['type'] ) && 'post' === $data['type'] ) {
			if ( $this->is_mobile && get_post_meta( $data['id'], '_woodmart_mobile_content', true ) ) {
				update_post_meta( $data['id'], 'wd_page_css_files_mobile', $this->inline_enqueue_styles_mobile );
			} else {
				update_post_meta( $data['id'], 'wd_page_css_files', $this->inline_enqueue_styles );
			}
		} elseif ( isset( $data['type'] ) && 'taxonomy' === $data['type'] ) {
			update_term_meta( $data['id'], 'wd_page_css_files', $this->inline_enqueue_styles );
		} elseif ( isset( $data['type'] ) && in_array(
			$data['type'],
			array(
				'search',
				'404',
				'date',
				'author',
			),
			true
		) ) {
			update_option( 'wd_page_css_files_' . $data['type'], $this->inline_enqueue_styles );
		}

		update_option( 'wd_page_css_files_theme_version', WOODMART_VERSION );
	}

	/**
	 * Enqueue inline style by key.
	 *
	 * @param string $key File slug.
	 * @param bool   $ignore_combined Enqueue style file with ignore combined file enqueue.
	 */
	public function enqueue_inline_style( $key, $ignore_combined = false ) {
		$config         = woodmart_get_config( 'css-files' );
		$page_files     = $this->page_css_files;
		$styles_not_use = woodmart_get_opt( 'styles_not_use' );

		if ( ! isset( $config[ $key ] ) || in_array( $key, $page_files, true ) || ( woodmart_is_combined_needed( 'combined_css' ) && ! $ignore_combined ) || isset( $GLOBALS['wd_page_css_ignore'] ) ) {
			return;
		}

		foreach ( $config[ $key ] as $data ) {
			if ( $this->is_mobile ) {
				if ( is_array( $this->inline_enqueue_styles_mobile ) && in_array( $data['name'], $this->inline_enqueue_styles_mobile ) ) { // phpcs:ignore
					continue;
				}
			} else {
				if ( is_array( $this->inline_enqueue_styles ) && in_array( $data['name'], $this->inline_enqueue_styles ) ) { // phpcs:ignore
					continue;
				}
			}

			if ( is_array( $styles_not_use ) && in_array( $data['name'], $styles_not_use, true ) ) {
				continue;
			}

			if ( isset( $data['wpb_file'] ) && 'wpb' === woodmart_get_current_page_builder() ) {
				$data['file'] = $data['wpb_file'];
			}

			if ( is_rtl() && isset( $data['rtl'] ) ) {
				$data['file'] = $data['file'] . '-rtl';
			}

			if ( ! empty( $data['media'] ) ) {
				$media = $data['media'];
			} else {
				$media = 'all';
			}

			$src = WOODMART_THEME_DIR . $data['file'] . '.min.css';

			if ( $this->is_mobile ) {
				$this->inline_enqueue_styles_mobile[] = $data['name'];
			} else {
				$this->inline_enqueue_styles[] = $data['name'];
			}

			?>
			<link rel="stylesheet" id="<?php echo esc_attr( 'wd-' . $data['name'] ); ?>-css" href="<?php echo esc_attr( $src ); ?>?ver=<?php echo esc_attr( WOODMART_VERSION ); ?>" type="text/css" media="<?php echo esc_attr( $media ); ?>" /> <?php // phpcs:ignore ?>
			<?php
		}
	}

	/**
	 * Reset styles configs.
	 *
	 * @return void
	 */
	public function reset_styles_configs() {
		$this->inline_enqueue_styles_mobile = array();
		$this->inline_enqueue_styles        = array();
	}
}

Parts_Css_Files::get_instance();
