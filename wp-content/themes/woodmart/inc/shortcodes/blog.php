<?php use XTS\Modules\Layouts\Main;

if ( ! defined( 'WOODMART_THEME_DIR' ) ) exit( 'No direct script access allowed' );

/**
* ------------------------------------------------------------------------------------------------
* Blog shortcode
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_shortcode_blog' ) ) {
	function woodmart_shortcode_blog( $atts ) {
	    $parsed_atts = shortcode_atts(
			array_merge(
				woodmart_get_carousel_atts(),
				array(
					'post_type'  => 'post',
					'include'  => '',
					'custom_query'  => '',
					'taxonomies'  => '',
					'pagination'  => '',
					'parts_media' => true,
					'parts_title' => true,
					'parts_meta'  => true,
					'parts_text'  => true,
					'parts_btn'   => true,
					'parts_published_date' => true,
					'items_per_page'  => 12,
					'offset'  => '',
					'orderby'  => 'date',
					'order'  => 'DESC',
					'meta_key'  => '',
					'exclude'  => '',
					'class'  => '',
					'ajax_page' => '',
					'img_size' => 'medium',
					'img_size_custom' => array(),
					'blog_design'  => 'default',
					'blog_masonry'  => false,
					'blog_carousel_design' => 'masonry',
					'blog_columns'  => 3,
					'blog_columns_tablet' => 'auto',
					'blog_columns_mobile' => 'auto',
					'blog_spacing'  => woodmart_get_opt( 'blog_spacing' ),
					'blog_spacing_tablet'  => '',
					'blog_spacing_mobile'  => '',
					'speed' => '5000',
					'slides_per_view' => '3',
					'slides_per_view_tablet' => 'auto',
					'slides_per_view_mobile' => 'auto',
					'wrap' => '',
					'autoplay' => 'no',
					'hide_pagination_control' => '',
					'hide_prev_next_buttons' => '',
					'lazy_loading' => 'no',
					'scroll_carousel_init' => 'no',
					'scroll_per_page' => 'yes',
					'search' => '',
					'css' => '',
					'woodmart_css_id' => '',
					'element_title' => '',
					'element_title_tag' => 'h3',
					'inner_content' => '',
					'el_id' => 'wd-' . uniqid(),
					'el_class' => '',
					'wrapper_classes' => '',
				)
			),
			$atts
		);

	    extract( $parsed_atts );

	    $encoded_atts = json_encode( $parsed_atts );

		$is_ajax = ( defined( 'DOING_AJAX' ) && DOING_AJAX && isset( $_POST['action'] ) && $_POST['action'] !== 'woodmart_load_html_dropdowns' );

	    $output = '';

		$wrapper_classes .= apply_filters( 'vc_shortcodes_css_class', '', '', $parsed_atts );

		if ( function_exists( 'vc_shortcode_custom_css_class' ) && $css ) {
			$wrapper_classes .= ' ' . vc_shortcode_custom_css_class( $css );
		}

		if ( 'wpb' === woodmart_get_current_page_builder() ) {
			$parsed_atts['wrapper_classes'] = ' wd-wpb';
			$wrapper_classes               .= ' wd-wpb';
		}

		if ( $el_class ) {
			$wrapper_classes .= ' ' . $el_class;
		}

		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

		if ( ! empty( $el_id ) ) {
			$id = $el_id;
		} else {
			$id = uniqid();
		}

		if( $ajax_page > 1 ) $paged = $ajax_page;

	    $args = array(
	    	'post_type' => 'post',
	    	'post_status' => 'publish',
	    	'paged' => $paged,
	    	'posts_per_page' => $items_per_page
		);

		if( $post_type == 'ids' && $include != '' ) {
			$args['post__in']            = array_map('trim', explode(',', $include) );
			$args['ignore_sticky_posts'] = true;
		}

		if( ! empty( $exclude ) ) {
			$args['post__not_in'] = array_map('trim', explode(',', $exclude) );
		}

		if( ! empty( $taxonomies ) ) {
			$taxonomy_names = get_object_taxonomies( 'post' );
			$terms = get_terms( $taxonomy_names, array(
				'orderby'    => 'name',
				'include'    => $taxonomies,
				'hide_empty' => apply_filters( 'woodmart_blog_shortcode_hide_empty_terms', true )
			) );

			if( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
				$args['tax_query'] = array( 'relation' => 'OR' );
				foreach ( $terms as $key => $term ) {
					$args['tax_query'][] = array(
				        'taxonomy' => $term->taxonomy,
				        'field' => 'slug',
				        'terms' => array( $term->slug ),
				        'include_children' => true,
				        'operator' => 'IN'
					);
				}
			}
		}

		if( ! empty( $order ) ) {
			$args['order'] = $order;
		}

		if( ! empty( $offset ) ) {
			$args['offset'] = $offset;
		}

		if( ! empty( $meta_key ) ) {
			$args['meta_key'] = $meta_key;
		}

		if( ! empty( $orderby ) ) {
			$args['orderby'] = $orderby;
		}
		
		if ( ! empty( $search ) ) {
			$args['s'] = sanitize_text_field( $search );
		}

		if ( 'related_posts' === $post_type ) {
			Main::setup_preview();
			$args = array_merge( $args, woodmart_get_related_posts_args( get_the_ID() ) );
			unset( $args['showposts'] );
			Main::restore_preview();
		}

	    $blog_query = new WP_Query( $args );
		
		ob_start();

		woodmart_set_loop_prop( 'blog_type', 'shortcode' );
		woodmart_set_loop_prop( 'blog_design', $blog_design );
		woodmart_set_loop_prop( 'img_size', $img_size );
		woodmart_set_loop_prop( 'blog_columns', $blog_columns );
		woodmart_set_loop_prop( 'blog_columns_tablet', $blog_columns_tablet );
		woodmart_set_loop_prop( 'blog_columns_mobile', $blog_columns_mobile );
		woodmart_set_loop_prop( 'woodmart_loop', 0 );
		woodmart_set_loop_prop( 'parts_title', $parts_title );
		woodmart_set_loop_prop( 'parts_meta', $parts_meta );
		woodmart_set_loop_prop( 'parts_text', $parts_text );
		woodmart_set_loop_prop( 'parts_btn', $parts_btn );
		woodmart_set_loop_prop( 'parts_published_date', $parts_published_date );
		woodmart_set_loop_prop( 'parts_media', $parts_media );

		if ( 'custom' === $img_size && ! empty( $img_size_custom ) ) {
			woodmart_set_loop_prop( 'img_size_custom', $img_size_custom );
		}

		$parsed_atts['custom_sizes'] = apply_filters( 'woodmart_blog_shortcode_custom_sizes', false );

		if ( '' === $parsed_atts['blog_spacing'] ) {
			$parsed_atts['blog_spacing'] = woodmart_get_opt( 'blog_spacing' );

			if ( $parsed_atts['blog_spacing_tablet'] ) {
				$parsed_atts['blog_spacing_tablet'] = woodmart_get_opt( 'blog_spacing_tablet' );
			}
			if ( $parsed_atts['blog_spacing_mobile'] ) {
				$parsed_atts['blog_spacing_mobile'] = woodmart_get_opt( 'blog_spacing_mobile' );
			}
		}

//	    if( ! $parts_btn ) woodmart_set_loop_prop( 'parts_btn', false );

		$true_blog_design = $blog_design;
		if ( 'carousel' === $true_blog_design ) {
			$true_blog_design = $blog_carousel_design;
		}

		woodmart_enqueue_inline_style( 'blog-loop-base' );
		woodmart_enqueue_inline_style( 'post-types-mod-predefined' );

		if ( 'small-images' === $true_blog_design || 'chess' === $true_blog_design ) {
			woodmart_enqueue_inline_style( 'blog-loop-design-small-img-chess' );
		} else {
			woodmart_enqueue_inline_style( 'blog-loop-design-' . $true_blog_design );
		}

		if ( 'carousel' === $blog_design ) {
			woodmart_set_loop_prop( 'blog_design', $blog_carousel_design );
			woodmart_set_loop_prop( 'blog_layout', 'carousel' );

			if ( ( 'auto' !== $slides_per_view_tablet && ! empty( $slides_per_view_tablet ) ) || ( 'auto' !== $slides_per_view_mobile && ! empty( $slides_per_view_mobile ) ) ) {
				$parsed_atts['custom_sizes'] = array(
					'desktop' => $slides_per_view,
					'tablet'  => $slides_per_view_tablet,
					'mobile'  => $slides_per_view_mobile,
				);
			}

			$parsed_atts['spacing']        = $parsed_atts['blog_spacing'];
			$parsed_atts['spacing_tablet'] = $parsed_atts['blog_spacing_tablet'];
			$parsed_atts['spacing_mobile'] = $parsed_atts['blog_spacing_mobile'];

			return ob_get_clean() . woodmart_generate_posts_slider( $parsed_atts, $blog_query );
		} else {
			$attributes = '';

			if ( $lazy_loading == 'yes' ) {
				woodmart_lazy_loading_init( true );
				woodmart_enqueue_inline_style( 'lazy-loading' );
			}

			if ( in_array( $blog_design, array( 'masonry', 'mask', 'meta-image' ), true ) ) {
				if ( $blog_masonry && 'meta-image' !== $blog_design ) {
					$class .= ' wd-masonry wd-grid-f-col';

					wp_enqueue_script( 'imagesloaded' );
					woodmart_enqueue_js_library( 'isotope-bundle' );
					woodmart_enqueue_js_script( 'masonry-layout' );
				}

				$attributes .= ' style="' . woodmart_get_grid_attrs(
					array(
						'columns'        => woodmart_loop_prop( 'blog_columns' ),
						'columns_tablet' => woodmart_loop_prop( 'blog_columns_tablet' ),
						'columns_mobile' => woodmart_loop_prop( 'blog_columns_mobile' ),
						'spacing'        => $parsed_atts['blog_spacing'],
						'spacing_tablet' => $parsed_atts['blog_spacing_tablet'],
						'spacing_mobile' => $parsed_atts['blog_spacing_mobile'],
					)
				) . '"';
			}

			if ( ! $blog_masonry || ! in_array( $blog_design, array( 'masonry', 'mask' ), true ) ) {
				$class .= ' wd-grid-g';
			}

			if ( ! $is_ajax ) {
				if ( ! empty( $parsed_atts['inner_content'] ) ) {
					echo do_shortcode( $parsed_atts['inner_content'] );
				}

				echo '<div id="' . esc_attr( $id ) . '" class="wd-blog-element' . esc_attr( $wrapper_classes ) . '">';
				if ( $element_title ) {
					printf( '<%1$s class="wd-el-title title element-title">%2$s</%1$s>', esc_attr( $element_title_tag ), esc_html( $element_title ) );
				}
				echo '<div class="wd-posts wd-blog-holder' . esc_attr( $class ) . '" data-paged="1" data-atts="' . esc_attr( $encoded_atts ) . '" data-source="shortcode"' . $attributes . '>';
			}

			while ( $blog_query->have_posts() ) {
				$blog_query->the_post();

				get_template_part( 'templates/content', woodmart_get_blog_design_name( $blog_design ) );
			}

			if ( ! $is_ajax ) {
				echo '</div>';
			};

			if ( $blog_query->max_num_pages > 1 && ! $is_ajax && $pagination ) {
				?>
			    	<div class="wd-loop-footer blog-footer">
			    		<?php if ( $pagination == 'infinit' || $pagination == 'more-btn' ): ?>
						    <?php wp_enqueue_script( 'imagesloaded' ); ?>
						    <?php woodmart_enqueue_js_script( 'blog-load-more' ); ?>
						    <?php if ( 'infinit' === $pagination ) : ?>
								<?php woodmart_enqueue_js_library( 'waypoints' ); ?>
						    <?php endif; ?>
						    <?php woodmart_enqueue_inline_style( 'load-more-button' ); ?>
							<a href="#" data-holder-id="<?php echo esc_attr( $id ); ?>" rel="nofollow noopener" class="btn wd-load-more wd-blog-load-more load-on-<?php echo 'more-btn' === $pagination ? 'click' : 'scroll'; ?>"><span class="load-more-label"><?php esc_html_e( 'Load more posts', 'woodmart' ); ?></span></a>
							<div class="btn wd-load-more wd-load-more-loader"><span class="load-more-loading"><?php esc_html_e('Loading...', 'woodmart'); ?></span></div>
		    			<?php else: ?>
			    			<?php query_pagination( $blog_query->max_num_pages ); ?>
			    		<?php endif ?>
			    	</div>
			    <?php
			}

			if ( ! $is_ajax ) {
				echo '</div>';
			};
	    }

	    wp_reset_postdata();

		woodmart_reset_loop();

		if ( $lazy_loading == 'yes' ) {
			woodmart_lazy_loading_deinit();
		}
		
	    $output .= ob_get_clean();

	    if( $is_ajax ) {
	    	$output =  array(
	    		'items' => $output,
	    		'status' => ( $blog_query->max_num_pages > $paged ) ? 'have-posts' : 'no-more-posts'
	    	);
	    }

	    return $output;

	}
}
