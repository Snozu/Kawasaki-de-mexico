<?php 
	global $product;


	do_action( 'woocommerce_before_shop_loop_item' ); 
?>

<div class="product-wrapper">
	<div class="product-element-top wd-quick-shop">
		<a href="<?php echo esc_url( get_permalink() ); ?>" class="product-image-link" aria-label="<?php echo esc_attr( get_the_title() ); ?>">
			<?php
			/**
			 * Hook woocommerce_before_shop_loop_item_title.
			 *
			 * @hooked woodmart_template_loop_product_thumbnails_gallery - 5
			 * @hooked woocommerce_show_product_loop_sale_flash - 10
			 * @hooked woodmart_template_loop_product_thumbnail - 10
			 */
			do_action( 'woocommerce_before_shop_loop_item_title' );
			?>
		</a>

		<?php
		if ( ! woodmart_loop_prop( 'grid_gallery' ) || ( ! woodmart_get_opt( 'grid_gallery' ) && empty( woodmart_loop_prop( 'grid_gallery_control', 'hover' ) ) && empty( woodmart_loop_prop( 'grid_gallery_enable_arrows', 'none' ) ) ) ) {
			woodmart_hover_image();
		}
		?>

		<div class="wd-buttons wd-pos-r-t<?php echo woodmart_get_old_classes( ' woodmart-buttons' ); ?>">
			<?php woodmart_add_to_compare_loop_btn(); ?>
			<?php woodmart_quick_view_btn( get_the_ID() ); ?>
			<?php do_action( 'woodmart_product_action_buttons' ); ?>
		</div>
	</div>

	<?php if ( woodmart_loop_prop( 'stretch_product_desktop' ) || woodmart_loop_prop( 'stretch_product_tablet' ) || woodmart_loop_prop( 'stretch_product_mobile' ) ) : ?>
	<div class="product-element-bottom">
	<?php endif; ?>
		<div class="wd-product-header">
			<?php
				/**
				 * woocommerce_shop_loop_item_title hook
				 *
				 * @hooked woocommerce_template_loop_product_title - 10
				 */
				do_action( 'woocommerce_shop_loop_item_title' );
			?>
			<?php echo wp_kses_post( woodmart_get_product_rating( 'simple', 1 ) ); ?>
		</div>
		<?php
			woodmart_product_categories();
			woodmart_product_brands_links();
			woodmart_product_sku();
			woodmart_stock_status_after_title();
		?>
		<div class="wrap-price">
			<div class="swap-wrapp">
				<div class="swap-elements">
					<?php
						/**
						 * woocommerce_after_shop_loop_item_title hook
						 *
						 * @hooked woocommerce_template_loop_rating - 5
						 * @hooked woocommerce_template_loop_price - 10
						 */
						do_action( 'woocommerce_after_shop_loop_item_title' );
					?>
					<div class="wd-add-btn<?php echo woodmart_get_old_classes( ' woodmart-add-btn' ); ?>">
						<?php do_action( 'woodmart_add_loop_btn' ); ?>
					</div>
				</div>
			</div>
			<?php 
				echo woodmart_swatches_list();
			?>
		</div>

		<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>

		<?php if ( woodmart_loop_prop( 'progress_bar' ) ): ?>
			<?php woodmart_stock_progress_bar(); ?>
		<?php endif ?>

		<?php if ( woodmart_loop_prop( 'timer' ) ): ?>
			<?php woodmart_product_sale_countdown( array( 'products_hover' => 'alt' ) ); ?>
		<?php endif ?>
	<?php if ( woodmart_loop_prop( 'stretch_product_desktop' ) || woodmart_loop_prop( 'stretch_product_tablet' ) || woodmart_loop_prop( 'stretch_product_mobile' ) ) : ?>
	</div>
	<?php endif; ?>
</div>