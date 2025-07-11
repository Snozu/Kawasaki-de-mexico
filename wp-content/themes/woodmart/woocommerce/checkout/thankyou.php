<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 8.1.0
 */

defined( 'ABSPATH' ) || exit;

$wrapper_classes = '';

if ( woodmart_get_opt( 'thank_you_page_extra_content' ) ) {
	$wrapper_classes .= ' wd-with-extra-content';
}

?>

<div class="woocommerce-order<?php echo esc_attr( $wrapper_classes ); ?>">

	<?php if ( $order ) : ?>

		<?php do_action( 'woocommerce_before_thankyou', $order->get_id() ); ?>

		<?php if ( $order->has_status( 'failed' ) ) : ?>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?></p>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
				<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php esc_html_e( 'Pay', 'woocommerce' ); ?></a>
				<?php if ( is_user_logged_in() ) : ?>
					<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php esc_html_e( 'My account', 'woocommerce' ); ?></a>
				<?php endif; ?>
			</p>

		<?php else : ?>
			<?php if ( woodmart_get_opt( 'thank_you_page_extra_content' ) || woodmart_get_opt( 'thank_you_page_html_block' ) ) : ?>
				<div class="wd-order-extra-content wd-entry-content">
					<?php if ( 'text' === woodmart_get_opt( 'thank_you_page_content_type', 'text' ) ) : ?>
						<?php echo do_shortcode( woodmart_get_opt( 'thank_you_page_extra_content' ) ); ?>
					<?php else : ?>
						<?php echo woodmart_get_html_block( woodmart_get_opt( 'thank_you_page_html_block' ) ); ?>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<?php if ( woodmart_get_opt( 'thank_you_page_default_content' ) ) : ?>

				<?php wc_get_template( 'checkout/order-received.php', array( 'order' => $order ) ); ?>

				<?php woodmart_order_overview( $order ); ?>
		
			<?php endif; ?>

		<?php endif; ?>

		<?php if ( woodmart_get_opt( 'thank_you_page_default_content' ) ) : ?>
			<?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
			<?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>
		<?php endif; ?>

	<?php else : ?>

		<?php wc_get_template( 'checkout/order-received.php', array( 'order' => false ) ); ?>

	<?php endif; ?>

</div>
