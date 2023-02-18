<?php
/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 5.2.0
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="shop_table woocommerce-checkout-review-order-table">
	<!-- <thead>
		<tr>
			<th class="product-name"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
			<th class="product-total"><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></th>
		</tr>
	</thead> -->
	<div class="shop_table_body">
		<?php
		do_action( 'woocommerce_review_order_before_cart_contents' );

		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				?>
				<div class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
					<div class="product-name order_review_product_wrap">
						<div class="product_name_wrapper">
							<div class="wrapper_product">
								<?php echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) ) . '&nbsp;'; ?> - <?php echo get_field('pod_size',$_product->id); ?>
							
								<?php echo apply_filters( 'woocommerce_checkout_cart_item_quantity', ' <strong class="product-quantity">' . sprintf( '&times;&nbsp;%s', $cart_item['quantity'] ) . '</strong>', $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								<?php echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</div>
							
							<div class="tool_tips tooltip_product">
								<img src="<?php echo site_url(); ?>/wp-content/uploads/2023/01/majesticons_info-circle-line.svg">
								<div class="tooltip_content tooltip_content_product">
									<?php echo get_field('product_tooltip_content','option'); ?>
								</div>
							</div>
							
						</div>
						

						<p><?php echo get_field('product_short_description','option'); ?></p>
					</div>
					<div class="product-total">
						<?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>
				</div>
				<?php
			}
		}

		do_action( 'woocommerce_review_order_after_cart_contents' );
		?>
		
	</div>
	<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
		<?php if($fee->name == "Insurance") {
			 ?>
			<div class="fee">
				<div class="fees_wrapper_main">
					<div class="fees_wrapper">
						<div class="fee-first-col"><?php echo esc_html( $fee->name ); ?></div>
						<div class="tool_tips tooltip_collection_pice">
							<img src="<?php echo site_url(); ?>/wp-content/uploads/2023/01/majesticons_info-circle-line.svg">
							<div class="tooltip_content tooltip_content_collection">
								<?php echo get_field('insurance_tooltip_content','option'); ?>
							</div>
						</div>
						
					</div>
				</div>	
				<div class="fee-second-col"><?php wc_cart_totals_fee_html( $fee );  ?></div>
			</div>
			<p class="fee_description"><?php _e('At 0.20% of declared value plus IPT Tax','woocommerce');?></p>
		<?php } ?>
	<?php endforeach; ?>
	
	<div class="cart_total_wraps">

		<div class="cart-subtotal">
			<?php $sub_total = WC()->cart->get_cart_subtotal(); 
			//$insurance_fee = wc_cart_totals_fee_html( $fee ); ?>
			<div class="cart-subtotal-first-col"><?php esc_html_e( '4 Weekly (inc VAT)', 'woocommerce' ); ?></div>
			<div class="cart-subtotal-second-col"><?php echo $sub_total;  //wc_cart_totals_subtotal_html(); ?></div>
		</div>

		<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
			<div class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
				<div class="cart-discount-coupon-first-col"><?php wc_cart_totals_coupon_label( $coupon ); ?></div>
				<div class="cart-discount-coupon-second-col"><?php wc_cart_totals_coupon_html( $coupon ); ?></div>
			</div>
		<?php endforeach; ?>

		<?php //if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

			<?php //do_action( 'woocommerce_review_order_before_shipping' ); ?>

			<?php //wc_cart_totals_shipping_html(); ?>

			<?php //do_action( 'woocommerce_review_order_after_shipping' ); ?>

		<?php //endif; ?>

		<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
			<?php if($fee->name == "Collection Services") { ?>
			
				<div class="fee">
				<div class="fees_wrapper_main">
					<div class="fees_wrapper">
						<div class="fee-first-col"><?php echo esc_html( $fee->name ); ?></div>
						<div class="tool_tips tooltip_collection_pice">
							<img src="<?php echo site_url(); ?>/wp-content/uploads/2023/01/majesticons_info-circle-line.svg">
							<div class="tooltip_content tooltip_content_collection">
								<?php echo get_field('collection_price_tooltip_content','option'); ?>
							</div>
						</div>
						
					</div>
					<p class="collection_short_note"><?php _e('Fixed price','woocommerce'); ?></p>
				</div>
				<div class="fee-second-col"><?php wc_cart_totals_fee_html( $fee ); ?></div>
				
			</div>
			<div class="fee-total">
				<div class="fee-first-col"><?php _e('One-off (inc VAT)','woocommerce'); ?></div>
				<div class="fee-second-col"><?php wc_cart_totals_fee_html( $fee ); ?></div>
			</div>
			
			<?php } ?>
		<?php endforeach; ?>
		

		<?php if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) : ?>
			<?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
				<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited ?>
					<div class="tax-rate tax-rate-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
						<div class="tax-rate-first-col"><?php echo esc_html( $tax->label ); ?></div>
						<div class="tax-rate-second-col"><?php echo wp_kses_post( $tax->formatted_amount ); ?></div>
					</div>
				<?php endforeach; ?>
			<?php else : ?>
				<div class="tax-total">
					<div class="tax-total-first-col"><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></div>
					<div class="tax-total-second-col"><?php wc_cart_totals_taxes_total_html(); ?></div>
				</div>
			<?php endif; ?>
		<?php endif; ?>

		<?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

		<div class="order-total">
			<div class="order-total-first-col"><?php esc_html_e( 'Pay today (inc VAT)', 'woocommerce' ); ?></div>
			<div class="order-total-first-col"><?php wc_cart_totals_order_total_html(); ?></div>
		</div>

		<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>

	</div>
</div>
