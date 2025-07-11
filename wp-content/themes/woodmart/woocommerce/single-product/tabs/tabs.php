<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.8.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */
$product_tabs     = apply_filters( 'woocommerce_product_tabs', array() );
$tabs_layout      = woodmart_get_opt( 'product_tabs_layout' );
$accordion_state  = woodmart_get_opt( 'product_accordion_state', 'first' );
$content_count    = 0;
$tab_count        = 0;
$wrapper_classes  = ' tabs-layout-' . $tabs_layout;
$wrapper_classes .= ' wd-opener-pos-right';
$wrapper_classes .= ' wd-opener-style-arrow';

if ( 'tabs' === $tabs_layout ) {
	$accordion_state = 'first';
}

if ( 'accordion' === $tabs_layout ) {
	$wrapper_classes .= ' wd-accordion wd-style-default';
} else {
	woodmart_enqueue_inline_style( 'tabs' );
	woodmart_enqueue_inline_style( 'woo-single-prod-el-tabs-opt-layout-tabs' );
}

woodmart_enqueue_js_script( 'single-product-tabs-accordion' );
woodmart_enqueue_inline_style( 'accordion' );
woodmart_enqueue_inline_style( 'accordion-elem-wpb' );
woodmart_enqueue_js_script( 'accordion-element' );

if ( comments_open() ) {
	if ( woodmart_get_opt( 'reviews_rating_summary' ) && function_exists( 'wc_review_ratings_enabled' ) && wc_review_ratings_enabled() ) {
		woodmart_enqueue_inline_style( 'woo-single-prod-opt-rating-summary' );
	}

	woodmart_enqueue_inline_style( 'woo-single-prod-el-reviews' );
	woodmart_enqueue_inline_style( 'woo-single-prod-el-reviews-' . woodmart_get_opt( 'reviews_style', 'style-1' ) );
	woodmart_enqueue_js_script( 'woocommerce-comments' );
}

$nav_tabs_wrapper_classes = '';

if ( woodmart_get_opt( 'dark_version' ) ) {
	$nav_tabs_wrapper_classes .= ' color-scheme-light';
}
?>
<?php if ( ! empty( $product_tabs ) ) : ?>
<div class="woocommerce-tabs wc-tabs-wrapper<?php echo esc_attr( $wrapper_classes ); ?>" data-state="<?php echo esc_attr( $accordion_state ); ?>" data-layout="<?php echo esc_attr( $tabs_layout ); ?>">
		<?php if ( 'tabs' === $tabs_layout ) : ?>
			<div class="wd-nav-wrapper wd-nav-tabs-wrapper text-center<?php echo esc_attr( $nav_tabs_wrapper_classes ); ?>">
				<ul class="wd-nav wd-nav-tabs tabs wc-tabs wd-style-underline-reverse" role="tablist">
					<?php foreach ( $product_tabs as $key => $product_tab ) : ?>
						<?php
						$li_classes = $key . '_tab';

						if ( 0 === $tab_count ) {
							$li_classes .= ' active';
						}
						?>
						<li class="<?php echo esc_attr( $li_classes ); ?>" id="tab-title-<?php echo esc_attr( $key ); ?>" role="presentation">
							<a class="wd-nav-link" href="#tab-<?php echo esc_attr( $key ); ?>" aria-controls="tab-<?php echo esc_attr( $key ); ?>" role="tab">
								<?php if ( isset( $product_tab['title'] ) ) : ?>
									<span class="nav-link-text wd-tabs-title">
										<?php echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) ); ?>
									</span>
								<?php endif; ?>
							</a>
						</li>

						<?php $tab_count++; ?>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endif; ?>

		<?php foreach ( $product_tabs as $key => $product_tab ) : ?>
			<?php
			$item_wrapper_classes             = woodmart_get_old_classes( ' woodmart-tab-wrapper' );
			$accordion_title_wrapper_classes  = woodmart_get_old_classes( ' woodmart-accordion-title' );
			$accordion_title_wrapper_classes .= ' tab-title-' . $key;
			$content_classes                  = ' woocommerce-Tabs-panel woocommerce-Tabs-panel--' . $key;
			$content_inner_classes            = '';

			if ( 0 === $content_count && 'first' === $accordion_state ) {
				$accordion_title_wrapper_classes .= ' wd-active';
				$content_classes                 .= ' wd-active';
			}

			if ( 'accordion' === $tabs_layout ) {
				$content_classes       .= ' wd-scroll wd-accordion-content';
				$content_inner_classes .= ' wd-scroll-content';
			} else {
				$content_classes     .= ' panel wc-tab';
				$item_wrapper_classes = woodmart_get_old_classes( ' wd-tab-wrapper woodmart-tab-wrapper' );
			}

			if ( isset( $product_tab['callback'] ) && 'woocommerce_product_additional_information_tab' === $product_tab['callback'] ) {
				$content_classes .= ' wd-single-attrs wd-style-table';
			}

			if ( isset( $product_tab['callback'] ) && 'comments_template' === $product_tab['callback'] ) {
				woodmart_enqueue_inline_style( 'post-types-mod-comments' );

				$content_classes .= ' wd-single-reviews';

				$content_classes .= ' wd-layout-' . woodmart_get_opt( 'reviews_section_columns', 'two-column' );
				$content_classes .= ' wd-form-pos-' . woodmart_get_opt( 'reviews_form_location', 'after' );
			}
			?>
			<div class="wd-accordion-item<?php echo esc_attr( $item_wrapper_classes ); ?>">
				<div id="tab-item-title-<?php echo esc_attr( $key ); ?>" class="wd-accordion-title<?php echo esc_attr( $accordion_title_wrapper_classes ); ?>" data-accordion-index="<?php echo esc_attr( $key ); ?>">
					<div class="wd-accordion-title-text">
						<?php if ( isset( $product_tab['title'] ) ) : ?>
							<span>
								<?php echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) ); ?>
							</span>
						<?php endif; ?>
					</div>

					<span class="wd-accordion-opener"></span>
				</div>

				<div class="entry-content<?php echo esc_attr( $content_classes ); ?>" id="tab-<?php echo esc_attr( $key ); ?>" role="tabpanel" aria-labelledby="tab-title-<?php echo esc_attr( $key ); ?>" data-accordion-index="<?php echo esc_attr( $key ); ?>">
					<div class="wc-tab-inner wd-entry-content<?php echo esc_attr( $content_inner_classes ); ?>">
						<?php if ( isset( $product_tab['callback'] ) ) : ?>
							<?php call_user_func( $product_tab['callback'], $key, $product_tab ); ?>
						<?php endif; ?>
					</div>
				</div>
			</div>

			<?php $content_count++; ?>
		<?php endforeach; ?>

		<?php do_action( 'woocommerce_product_after_tabs' ); ?>
	</div>
<?php endif; ?>
