<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>
<div class="thumbnail">
	<a href="<?php echo get_permalink( $product->get_ID() ); ?>"><?php echo woocommerce_get_product_thumbnail(); ?></a>
    <div class="caption">
		<a href="<?php echo get_permalink( $product->get_ID() ); ?>" title=""><?php echo get_the_title($product->get_ID()); ?></a>      						
    </div>
	<?php woocommerce_template_loop_price(); ?>
    <a href="<?php echo get_permalink( $product->get_ID() ); ?>" class="more">Подробнее</a>
	<?php woocommerce_template_loop_add_to_cart(); ?>
</div><!--/.thumbnail-->
