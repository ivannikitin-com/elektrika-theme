<?php 
global $wp_query, $product;
$options = get_option('br_lgv_liststyle_option'); 
?>
<div class="berocket_lgv_additional_data">
	<div class="thumbnail clearfix">
		<div class="col-md-4 col-sm-4 col-xs-12">
			<a class="<?php echo ( ( @ $options['button']['lgv_link_simple']['custom_class'] ) ? $options['button']['lgv_link_simple']['custom_class'] : 'lgv_link lgv_link_simple' ) ?>" href="<?php the_permalink(); ?>">
			<?php woocommerce_template_loop_product_thumbnail(); ?>
			</a>
		</div>
		<div class="col-md-4 col-sm-4 col-xs-12"> 
			<div class="caption <?php echo ( ( @ $options['button']['lgv_link_simple']['custom_class'] ) ? $options['button']['lgv_link_simple']['custom_class'] : 'lgv_link lgv_link_simple' ) ?>"><a href="<?php the_permalink(); ?>" title="" class="woocommerce_shop_loop_item_title"><?php the_title(); ?></a></div>
				 <div class="sku"><?php echo ( $sku = $product->get_sku() ) ? esc_html_e( 'SKU:', 'woocommerce' ).' '.$sku : '&nbsp;'; ?></div>
				 <div class="breeder">
				 <?php $brand_terms=get_the_terms( $product->get_ID(), 'product_brand'); 
				 if ($brand_terms){
					$brand_term=$brand_terms[0];?>
				 <a href="<?php echo get_term_link( (int)$brand_term->term_id, $brand_term->taxonomy ); ?>">
				 <?php 
					echo get_up_parent_term($brand_term->term_id,'product_brand');
				 ?>
				 </a>
				 <?php } ?>
			</div>
		</div>
		<div class="col-md-4 col-sm-4 col-xs-12">
			<div class="<?php echo ( ( @ $options['button']['lgv_price_simple']['custom_class'] ) ? $options['button']['lgv_price_simple']['custom_class'] : 'lgv_price lgv_price_simple' ) ?>">
				<?php
				woocommerce_template_loop_price();
				woocommerce_template_loop_add_to_cart();
				tm_woowishlist_add_button_loop('');
				tm_woocompare_add_button_loop('');
				elk_panel_butt_close();
				?>
				
			</div>
		</div>
		<script>
			jQuery(document).ready( function () {
				br_lgv_style_set();
			});
		</script>
	</div><!--/.row-->
</div>