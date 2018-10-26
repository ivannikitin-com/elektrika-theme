<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<table class="shop_table woocommerce-checkout-review-shipping-table">

	<?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

		<?php wc_cart_totals_shipping_html(); ?>

	<?php //do_action( 'woocommerce_review_order_after_shipping' ); ?>

</table>