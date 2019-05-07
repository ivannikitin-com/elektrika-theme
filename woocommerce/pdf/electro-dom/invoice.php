<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php do_action( 'wpo_wcpdf_before_document', $this->type, $this->order ); ?>

<table class="head container">
	<tr>
		<td class="header">
		<?php
		if( $this->has_header_logo() ) {
			$this->header_logo();
		} else {
			echo $this->get_title();
		}
		?>
		</td>
		<td class="shop-info">
		</td>
	</tr>
</table>

<h1 class="document-type-label">
<?php if( $this->has_header_logo() ) echo $this->get_title(); ?> № <?php $this->invoice_number(); ?> от <?php $this->invoice_date(); ?>
</h1>

<?php do_action( 'wpo_wcpdf_after_document_label', $this->type, $this->order ); ?>
<table class="order-data-addresses">
<tr class="top-border">
<td>Поставщик:</td><th><?php $this->shop_name(); ?>, <?php $this->shop_address(); ?></th>
</tr>
<tr>
<td>Покупатель:</td><th><?php $this->billing_address(); ?> <?php echo (isset($this->settings['display_email'])?', '.$this->billing_email():''); ?><?php echo (isset($this->settings['display_phone'])?', '.$this->billing_phone():''); ?></th>
</tr>
</table>

<?php do_action( 'wpo_wcpdf_before_order_details', $this->type, $this->order ); ?>

<table class="order-details">
	<thead>
		<tr>
			<th class="product">№</th>
			<th class="product"><?php _e('Product', 'woocommerce-pdf-invoices-packing-slips' ); ?></th>
			<th class="quantity"><?php _e('Quantity', 'woocommerce-pdf-invoices-packing-slips' ); ?></th>
			<th class="price">Цена</th>
			<th class="price">Сумма</th>
		</tr>
	</thead>
	<tbody>
		<?php $items = $this->get_order_items(); 
		$i=0;
		if( sizeof( $items ) > 0 ) : foreach( $items as $item_id => $item ) : ?>
		<tr class="<?php echo apply_filters( 'wpo_wcpdf_item_row_class', $item_id, $this->type, $this->order, $item_id ); ?>">
			<td class="product"><?php echo $i=$i+1; ?></td>
			<td class="product">
				<?php $description_label = __( 'Description', 'woocommerce-pdf-invoices-packing-slips' ); // registering alternate label translation ?>
				<span class="item-name"><?php echo $item['name']; ?></span>
				<?php do_action( 'wpo_wcpdf_before_item_meta', $this->type, $item, $this->order  ); ?>
				<span class="item-meta"><?php echo $item['meta']; ?></span>
				<dl class="meta">
					<?php $description_label = __( 'SKU', 'woocommerce-pdf-invoices-packing-slips' ); // registering alternate label translation ?>
					<?php if( !empty( $item['sku'] ) ) : ?><dt class="sku"><?php _e( 'SKU:', 'woocommerce-pdf-invoices-packing-slips' ); ?></dt><dd class="sku"><?php echo $item['sku']; ?></dd><?php endif; ?>
					<?php if( !empty( $item['weight'] ) ) : ?><dt class="weight"><?php _e( 'Weight:', 'woocommerce-pdf-invoices-packing-slips' ); ?></dt><dd class="weight"><?php echo $item['weight']; ?><?php echo get_option('woocommerce_weight_unit'); ?></dd><?php endif; ?>
				</dl>
				<?php do_action( 'wpo_wcpdf_after_item_meta', $this->type, $item, $this->order  ); ?>
			</td>
			<td class="quantity"><?php echo $item['quantity']; ?></td>
			<td class="price"><?php echo $item['single_price']; ?></td>
			<td class="price"><?php echo $item['order_price']; ?></td>
		</tr>
		<?php endforeach; endif; ?>
	</tbody>
	<tfoot>
		<?php $totals_array = $this->get_woocommerce_totals(); ?>
		<?php foreach( $this->get_woocommerce_totals() as $key => $total ) : ?>
		<?php if ( ($total['value'] == 'Не определена') || ($key == 'payment_method') ) continue; ?>
		<?php if ( ($key == 'cart_subtotal') && ($totals_array['cart_subtotal']['value'] == $totals_array['order_total']['value'] )) continue; ?>
		<tr class="<?php echo $key; ?>">
			<td></td>
			<td></td>
			<td></td>
			<th class="description"><?php echo $total['label']; ?></th>
			<td class="price"><span class="totals-price"><?php echo $total['value']; ?></span></td>
		</tr>
		<?php endforeach; ?>
		<tr class="<?php echo $key; ?>">
			<td></td>
			<td></td>
			<td></td>
			<th class="description">В том числе НДС</th>
			<?php $nds=$this->order->get_total()-$this->order->get_total()/1.18; 
			$nds=round($nds,2);
			$nds=wc_price($nds);
			?>
			<td class="price"><span class="totals-price"><?php echo $nds; ?></span></td>
		</tr>
	</tfoot>
</table>

<p>Всего наименований <?php echo $i; ?> на сумму <?php echo wc_price($this->order->get_total()); ?></p>
<p class="total-str"><b><?php echo num2str($this->order->get_total()); ?></b></p>

<table class="order-data-addresses">
<tr class="top-border">
<th>Отпустил:</th><td>________________________________________</td>
<th>Получил:</th><td>________________________________________</td>
</tr>
</table>

<?php do_action( 'wpo_wcpdf_after_order_details', $this->type, $this->order ); ?>

<?php if ( $this->get_footer() ): ?>
<div id="footer">
	<?php $this->footer(); ?>
</div><!-- #letter-footer -->
<?php endif; ?>
<?php do_action( 'wpo_wcpdf_after_document', $this->type, $this->order ); ?>
