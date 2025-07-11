<?php
/**
 * Portfolio templates functions
 *
 * @package Woodmart
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_set_projects_per_page' ) ) {
	/**
	 * Portfolio projects per page.
	 *
	 * @since 1.0.0
	 *
	 * @param object $query Query.
	 */
	function woodmart_set_projects_per_page( $query ) {
		if ( is_admin() || ! $query->is_main_query() ) {
			return;
		}

		if ( $query->is_post_type_archive( 'portfolio' ) || $query->is_tax( 'project-cat' ) ) {
			$query->set( 'posts_per_page', (int) woodmart_get_opt( 'portoflio_per_page' ) );
			$query->set( 'orderby', woodmart_get_opt( 'portoflio_orderby' ) );
			$query->set( 'order', woodmart_get_opt( 'portoflio_order' ) );
		}
	}

	add_action( 'pre_get_posts', 'woodmart_set_projects_per_page' );
}

if ( ! function_exists( 'woodmart_get_portfolio_main_loop' ) ) {
	/**
	 * Main portfolio loop
	 *
	 * @since 1.0.0
	 *
	 * @param boolean $fragments Fragments.
	 */
	function woodmart_get_portfolio_main_loop( $fragments = false, $settings = array() ) {
		global $paged, $wp_query;

		$output           = '';
		$max_page         = $wp_query->max_num_pages;
		$encoded_settings = $settings ? wp_json_encode( $settings ) : '';
		$attributes       = 'data-source="main_loop" data-source="shortcode" data-paged="1"';

		if ( $encoded_settings ) {
			$attributes .= ' data-atts="' . esc_attr( $encoded_settings ) . '"';
		}

		if ( $fragments && ! empty( $_GET['atts'] ) ) { //phpcs:ignore.
			$atts = woodmart_clean( $_GET['atts'] ); //phpcs:ignore.
			foreach ( $atts as $key => $value ) {
				if ( 'inherit' !== $value ) {
					woodmart_set_loop_prop( $key, $value );
				}
			}
		}

		$style      = woodmart_loop_prop( 'portfolio_style' );
		$pagination = woodmart_loop_prop( 'portfolio_pagination' );

		wp_enqueue_script( 'imagesloaded' );
		woodmart_enqueue_js_library( 'isotope-bundle' );
		woodmart_enqueue_js_script( 'masonry-layout' );

		if ( 'parallax' === $style ) {
			woodmart_enqueue_js_library( 'panr-parallax-bundle' );
			woodmart_enqueue_js_script( 'portfolio-effect' );
		}

		if ( is_search() ) {
			$pagination = 'pagination';
		}

		if ( $fragments && isset( $_GET['loop'] ) ) { // phpcs:ignore
			woodmart_set_loop_prop( 'portfolio_loop', (int) sanitize_text_field( $_GET['loop'] ) ); // phpcs:ignore
		}

		$style_attrs = woodmart_get_grid_attrs(
			array(
				'columns'        => woodmart_loop_prop( 'portfolio_column' ),
				'columns_tablet' => woodmart_loop_prop( 'portfolio_columns_tablet' ),
				'columns_mobile' => woodmart_loop_prop( 'portfolio_columns_mobile' ),
				'spacing'        => woodmart_loop_prop( 'portfolio_spacing' ),
				'spacing_tablet' => woodmart_loop_prop( 'portfolio_spacing_tablet', '' ),
				'spacing_mobile' => woodmart_loop_prop( 'portfolio_spacing_mobile', '' ),
			)
		);

		if ( $fragments ) {
			ob_start();
		}

		woodmart_enqueue_js_library( 'photoswipe-bundle' );
		woodmart_enqueue_inline_style( 'photoswipe' );
		woodmart_enqueue_js_script( 'portfolio-photoswipe' );

		woodmart_enqueue_portfolio_loop_styles( $style );
		$attributes .= ' style="' . esc_attr( $style_attrs ) . '"';

		?>

		<?php if ( woodmart_loop_prop( 'ajax_portfolio' ) && ! $fragments ) : ?>
			<?php woodmart_sticky_loader( ' wd-content-loader' ); ?>
		<?php endif; ?>

		<?php if ( ! $fragments ) : ?>
			<div class="wd-projects wd-masonry wd-grid-f-col" <?php echo wp_kses( $attributes, true ); ?>>
		<?php endif ?>

		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>
			<?php get_template_part( 'content', 'portfolio' ); ?>
		<?php endwhile; ?>

		<?php if ( ! $fragments ) : ?>
			</div>
		<?php endif ?>

		<?php if ( $max_page > 1 && ! $fragments ) : ?>
			<?php wp_enqueue_script( 'imagesloaded' ); ?>
			<?php woodmart_enqueue_js_script( 'portfolio-load-more' ); ?>
			<?php woodmart_enqueue_js_library( 'waypoints' ); ?>
			<div class="wd-loop-footer portfolio-footer">
				<?php if ( get_next_posts_link() && ( 'infinit' === $pagination || 'load_more' === $pagination ) ) : ?>
					<?php woodmart_enqueue_inline_style( 'load-more-button' ); ?>
					<a href="<?php echo esc_url( add_query_arg( 'woo_ajax', '1', next_posts( $max_page, false ) ) ); ?>" rel="nofollow noopener" class="btn wd-load-more wd-portfolio-load-more load-on-<?php echo 'load_more' === $pagination ? 'click' : 'scroll'; ?>">
						<?php esc_html_e( 'Load more projects', 'woodmart' ); ?>
					</a>
					<div class="btn wd-load-more wd-load-more-loader">
						<span class="load-more-loading">
							<?php esc_html_e( 'Loading...', 'woodmart' ); ?>
						</span>
					</div>
				<?php elseif ( 'pagination' === $pagination ) : ?>
					<?php query_pagination( $max_page ); ?>
				<?php endif ?>
			</div>
		<?php endif; ?>

		<?php if ( $fragments ) : ?>
			<?php $output = ob_get_clean(); ?>
		<?php endif; ?>

		<?php
		if ( $fragments ) {
			wp_send_json(
				array(
					'items'       => $output,
					'status'      => ( $max_page > $paged ) ? 'have-posts' : 'no-more-posts',
					'nextPage'    => add_query_arg( 'woo_ajax', '1', next_posts( $max_page, false ) ),
					'currentPage' => strtok( woodmart_get_current_url(), '?' ),
				)
			);
		}
	}
}

if ( ! function_exists( 'woodmart_portfolio_filters' ) ) {
	/**
	 * Generate portfolio filters
	 *
	 * @since 1.0.0
	 *
	 * @param string $category Parent category.
	 * @param string $type     Filters type.
	 * @param string $wrapper_classes  Wrapper classes.
	 * @param string $el_id  ID attribute.
	 */
	function woodmart_portfolio_filters( $category, $type, $wrapper_classes = '', $el_id = '' ) {
		if ( woodmart_loop_prop( 'ajax_portfolio' ) && woodmart_is_portfolio_archive() ) {
			woodmart_enqueue_js_library( 'pjax' );
			woodmart_enqueue_js_script( 'ajax-portfolio' );
		}

		$args = array( 'parent' => $category );

		if ( is_array( $category ) ) {
			$args = array( 'include' => $category );
		}

		$categories = get_terms( 'project-cat', $args );

		if ( is_wp_error( $categories ) || ! $categories ) {
			return;
		}

		$all_link_classes = '';
		$wrapper_classes .= ' wd-type-' . $type;

		if ( 'masonry' === $type ) {
			woodmart_enqueue_js_script( 'portfolio-wd-nav-portfolios' );

			$all_link_url      = '#';
			$all_link_classes .= ' wd-active';
		} else {
			$all_link_url = get_post_type_archive_link( 'portfolio' );

			if ( is_post_type_archive( 'portfolio' ) || ! is_tax( 'project-cat' ) ) {
				$all_link_classes .= ' wd-active';
			}
		}

		?>
		<div 
			<?php if ( $el_id ) : ?>
			id="<?php echo esc_attr( $el_id ); ?>"
			<?php endif; ?> 
			class="portfolio-filter wd-nav-wrapper wd-mb-action-swipe<?php echo esc_attr( $wrapper_classes ); ?>">
			<ul class="wd-nav-portfolio wd-nav wd-gap-m wd-style-underline<?php echo woodmart_get_old_classes( ' masonry-filter' ); ?>">
				<li data-filter="*" class="<?php echo esc_attr( $all_link_classes ); ?>">
					<a href="<?php echo esc_url( $all_link_url ); ?>">
						<span class="nav-link-text"><?php esc_html_e( 'All', 'woodmart' ); ?></span>
					</a>
				</li>

				<?php foreach ( $categories as $category ) : ?>
					<?php
					$link_classes = '';
					$current_tax  = get_queried_object();

					if ( 'masonry' === $type ) {
						$link_url = '#';
					} else {
						$link_url = get_term_link( $category->term_id );

						if ( is_tax( 'project-cat' ) && $category->term_id === $current_tax->term_id ) {
							$link_classes .= ' wd-active';
						}
					}

					?>
					<li data-filter=".proj-cat-<?php echo esc_attr( $category->slug ); ?>" class="<?php echo esc_attr( trim( $link_classes ) ); ?>">
						<a href="<?php echo esc_url( $link_url ); ?>">
							<span class="nav-link-text"><?php echo esc_html( $category->name ); ?></span>
						</a>
					</li>
				<?php endforeach ?>
			</ul>
		</div>
		<?php
	}
}

if ( ! function_exists( 'woodmart_nav_menu_portfolio_item_classes' ) ) {
	/**
	 * Fix active class in nav for portfolio page.
	 *
	 * @param array $menu_items Menu items.
	 *
	 * @return array
	 */
	function woodmart_nav_menu_portfolio_item_classes( $menu_items ) {
		if ( ! woodmart_get_opt( 'portfolio', '1' ) ) {
			return $menu_items;
		}

		$portfolio_page = intval( woodmart_get_portfolio_page_id() );

		if ( ! empty( $menu_items ) && is_array( $menu_items ) ) {
			foreach ( $menu_items as $key => $menu_item ) {
				$classes = $menu_item->classes;
				$menu_id = intval( $menu_item->object_id );

				if ( is_post_type_archive( 'portfolio' ) && $portfolio_page === $menu_id && 'page' === $menu_item->object ) {
					$menu_items[ $key ]->current = true;
					$classes[]                   = 'current-menu-item';
					$classes[]                   = 'current_page_item';
				} elseif ( is_singular( 'portfolio' ) && $portfolio_page === $menu_id ) {
					$classes[] = 'current_page_parent';
				}

				$menu_items[ $key ]->classes = array_unique( $classes );
			}
		}

		return $menu_items;
	}

	add_filter( 'wp_nav_menu_objects', 'woodmart_nav_menu_portfolio_item_classes', 20 );
}
