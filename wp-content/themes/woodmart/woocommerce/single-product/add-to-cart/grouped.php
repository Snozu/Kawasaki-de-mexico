<?php
/**
 * Grouped product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/grouped.php.
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

use XTS\Modules\Layouts\Main as Builder;

defined( 'ABSPATH' ) || exit;

global $product, $post;

do_action( 'woocommerce_before_add_to_cart_form' );

woodmart_enqueue_inline_style( 'woo-single-prod-el-grouped' );
woodmart_enqueue_inline_style( 'woo-mod-shop-table' );
?>

<form class="cart grouped_form" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>
	<table cellspacing="0" class="woocommerce-grouped-product-list group_table shop_table_responsive shop-table-with-img">
		<tbody>
			<?php
				$quantites_required      = false;
				$previous_post           = $post;
				// Woodmart not replace 'thumbnail'.
				$grouped_product_columns = apply_filters(
					'woocommerce_grouped_product_columns',
					array(
						'thumbnail',
						'name',
						'quantity',
						'price',
					),
					$product
				);

				$show_add_to_cart_button = false;

				do_action( 'woocommerce_grouped_product_list_before', $grouped_product_columns, $quantites_required, $product );

				foreach ( $grouped_products as $grouped_product_child ) {
					$post_object        = get_post( $grouped_product_child->get_id() );
					$quantites_required = $quantites_required || ( $grouped_product_child->is_purchasable() && ! $grouped_product_child->has_options() );

					$post               = $post_object; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
					setup_postdata( $post );

					if ( $grouped_product_child->is_in_stock() ) {
						$show_add_to_cart_button = true;
					}
					
					echo '<tr id="product-' . esc_attr( $grouped_product_child->get_id() ) . '" class="woocommerce-grouped-product-list-item ' . esc_attr( implode( ' ', wc_get_product_class( '', $grouped_product_child ) ) ) . '">';

					// Output columns for each product.
					foreach ( $grouped_product_columns as $column_id ) {
						do_action( 'woocommerce_grouped_product_list_before_' . $column_id, $grouped_product_child );

						switch ( $column_id ) {
							case 'thumbnail':
								$attachment_id = get_post_meta( $grouped_product_child->get_id(), '_thumbnail_id', true );

								$value = wp_get_attachment_image( $attachment_id, 'woocommerce_thumbnail' );
								break;
							case 'name':
								$value  = '<label for="product-' . esc_attr( $grouped_product_child->get_id() ) . '">';
								$value .= $grouped_product_child->is_visible() ? '<a href="' . esc_url( apply_filters( 'woocommerce_grouped_product_list_link', $grouped_product_child->get_permalink(), $grouped_product_child->get_id() ) ) . '">' . $grouped_product_child->get_name() . '</a>' : $grouped_product_child->get_name();
								$value .= '</label>';
								break;
							case 'quantity':
								ob_start();

								if ( ! $grouped_product_child->is_purchasable() || $grouped_product_child->has_options() || ! $grouped_product_child->is_in_stock() ) {
									woocommerce_template_loop_add_to_cart();
								} elseif ( $grouped_product_child->is_sold_individually() ) {
									echo '<input type="checkbox" name="' . esc_attr( 'quantity[' . $grouped_product_child->get_id() . ']' ) . '" value="1" class="wc-grouped-product-add-to-cart-checkbox" />';
									echo '<label for="' . esc_attr( 'quantity-' . $grouped_product_child->get_id() ) . '" class="screen-reader-text">';
									if ( $grouped_product_child->is_on_sale() ) {
										printf(
										/* translators: %1$s: Product name. %2$s: Sale price. %3$s: Regular price */
											esc_html__( 'Buy one of %1$s on sale for %2$s, original price was %3$s', 'woocommerce' ),
											esc_html( $grouped_product_child->get_name() ),
											esc_html( wp_strip_all_tags( wc_price( $grouped_product_child->get_price() ) ) ),
											esc_html( wp_strip_all_tags( wc_price( $grouped_product_child->get_regular_price() ) ) )
										);
									} else {
										printf(
										/* translators: %1$s: Product name. %2$s: Product price */
											esc_html__( 'Buy one of %1$s for %2$s', 'woocommerce' ),
											esc_html( $grouped_product_child->get_name() ),
											esc_html( wp_strip_all_tags( wc_price( $grouped_product_child->get_price() ) ) )
										);
									}
									echo '</label>';
								} else {
									do_action( 'woocommerce_before_add_to_cart_quantity' );

									woocommerce_quantity_input(
										array(
											'input_name'  => 'quantity[' . $grouped_product_child->get_id() . ']',
											'input_value' => isset( $_POST['quantity'][ $grouped_product_child->get_id() ] ) ? wc_stock_amount( wc_clean( wp_unslash( $_POST['quantity'][ $grouped_product_child->get_id() ] ) ) ) : '', // phpcs:ignore WordPress.Security.NonceVerification.Missing
											'min_value'   => apply_filters( 'woocommerce_quantity_input_min', 0, $grouped_product_child ),
											'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $grouped_product_child->get_max_purchase_quantity(), $grouped_product_child ),
											'placeholder' => '0',
										)
									);

									do_action( 'woocommerce_after_add_to_cart_quantity' );
								}

								$value = ob_get_clean();
								break;
							case 'price':
    							$value  = '<div class="price">';
                                $value .= $grouped_product_child->get_price_html() . wc_get_stock_html( $grouped_product_child );
                                $value .= '</div>';
								break;
							default:
								$value = '';
								break;
						}

						echo '<td class="woocommerce-grouped-product-list-item__' . esc_attr( $column_id ) . ' product-' . esc_attr( $column_id ) . '">' . apply_filters( 'woocommerce_grouped_product_list_column_' . $column_id, $value, $grouped_product_child ) . '</td>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

						do_action( 'woocommerce_grouped_product_list_after_' . $column_id, $grouped_product_child );
					}

					echo '</tr>';
				}
				$post = $previous_post; // WPCS: override ok.
				setup_postdata( $post );
			
				do_action( 'woocommerce_grouped_product_list_after', $grouped_product_columns, $quantites_required, $product );
			?>
		</tbody>
	</table>

	<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" />

	<?php if ( $quantites_required && $show_add_to_cart_button ) : ?>

		<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

		<button type="submit" class="single_add_to_cart_button button alt<?php echo esc_attr( function_exists( 'wc_wp_theme_get_element_class_name') && wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>

		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

	<?php endif; ?>
</form>

<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
