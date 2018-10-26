<?php
function my_function_admin_bar($content) {  
	return ( current_user_can("administrator") ) ? $content : false;
}
add_filter( 'show_admin_bar' , 'my_function_admin_bar');
/**************************/
/*Общие настройки магазина*/
/**************************/
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
add_action('woocommerce_before_main_content', 'my_theme_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'my_theme_wrapper_end', 10);

function my_theme_wrapper_start() { ?>
                <div class="row">
				    <div class="col-md-3 col-sm-4">
					<?php get_sidebar(); ?>
					</div><!--/.col-md-3 col-sm-4-->
					<main id="main" class="site-main col-md-9 col-sm-8" role="main">
					    <!-- Search-->
						<?php include (TEMPLATEPATH . '/searchform.php'); ?>
<?php }

function my_theme_wrapper_end() { 
?>
					</main><!--/#main-->
				</div><!--/.row-->
<?php }

remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
add_action( 'woocommerce_before_main_content', 'elk_woocommerce_breadcrumb', 20, 0 );

function elk_woocommerce_breadcrumb(){
	if ( function_exists('yoast_breadcrumb') ) {
		yoast_breadcrumb('
		<p id="breadcrumbs">','</p>
		');
	}
}

add_filter('woocommerce_currency_symbol', 'change_existing_currency_symbol', 10, 2);
function change_existing_currency_symbol( $currency_symbol, $currency ) {
	switch( $currency ) {
		case 'RUB': $currency_symbol = 'руб.'; 
		break;
	}
return $currency_symbol;
}
function elk_grid_class( $col = '3' ) {
	if ($col==1){
		return apply_filters( 'elk_grid_class', '' );
	}
	$col_class=12/$col;
	return apply_filters( 'elk_grid_class', 'col-md-'.$col_class.' col-sm-6 col-xs-6' );
}
add_filter( 'post_class', 'elk_add_product_entry_classes' , 40, 3 );
function elk_add_product_entry_classes($classes, $class = '', $post_id = ''){
				global $product, $woocommerce_loop;
			if ( $product
				&& ! empty( $woocommerce_loop['columns'] )
				&& is_array( $classes )
				&& in_array( get_post_type( $post_id ), array( 'product', 'product_variation' ) )
				&& in_array( 'elk-woo-entry', $classes )
			) {
				$classes[] = 'col';
				$columns = isset( $woocommerce_loop['columns'] ) ? $woocommerce_loop['columns'] : 3;
				$classes[] = elk_grid_class( $columns );
				$key = array_search( 'elk-woo-entry', $classes );
				unset( $classes[$key] );
			}
			if (!in_array( 'berocket_lgv_list_grid', $classes )){
				$classes[]='berocket_lgv_list_grid';
			}
			return $classes;	
}
add_filter( 'woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment' );
function woocommerce_header_add_to_cart_fragment( $fragments ) {
	ob_start();?>
						<div id="mini_cart">
                                	<a href="" class="cart"><span></span><div class="num"><?php echo count( WC()->cart->get_cart() ); ?></div></a>
                                    <div class="wrap_cart">
                                    	<span class="total">Товар на сумму <b><?php echo WC()->cart->subtotal; ?></b>&nbsp;<?php echo get_woocommerce_currency_symbol(); ?></span>
                                    	<a href="<?php echo WC()->cart->get_cart_url(); ?>" class="to_cart">Перейти в корзину</a>
                                    </div><!--/.wrap_cart-->
                        </div><!--/#mini_cart-->
	<?php	
	$fragments['div#mini_cart'] = ob_get_clean();
	ob_start(); ?>
				<a id="cart_butt_footer" href="<?php echo WC()->cart->get_cart_url(); ?>" class="butt_cart" title="Перейти в корзину"><span class="glyphicon glyphicon-shopping-cart"></span><div class="num"><?php echo count( WC()->cart->get_cart() ); ?></div>
                <span class="total"><?php echo WC()->cart->subtotal; ?>&nbsp;<?php echo get_woocommerce_currency_symbol(); ?> </span>
				</a>
			
	<?php	
	//$fragments['a#cart_butt_footer'] = ob_get_clean();	
	return $fragments;
}
if (class_exists('BeRocket_LGV')) {
add_action ( 'woocommerce_after_shop_loop_item', 'elk_additional_product_data' );
}
function elk_additional_product_data(){
       if ( is_tax('product_tag') || is_tax('product_brand') ) {
            $template = 'additional_product_data';
            BeRocket_LGV::br_get_template_part( apply_filters( 'lgv_product_data_template', $template ) );
        }	
}
/*******************************/
/*Настраиваем страницу каталога*/
/*******************************/
add_filter( 'woocommerce_get_catalog_ordering_args', 'custom_woocommerce_get_catalog_ordering_args' );
function custom_woocommerce_get_catalog_ordering_args( $args ) {
$orderby_value = isset( $_GET['orderby'] ) ? woocommerce_clean( $_GET['orderby'] ) :
apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
if ( 'random_list' == $orderby_value ) {
$args['orderby'] = 'ID';//поле по которому сортируем
$args['order'] = 'ASC';//по возрастанию (ASC) или убыванию (DESC)
$args['meta_key'] = '';//по конкретному совпадению ключа
}
return $args;
}
add_filter( 'woocommerce_default_catalog_orderby_options', 'custom_woocommerce_catalog_orderby' );
add_filter( 'woocommerce_catalog_orderby', 'custom_woocommerce_catalog_orderby' );
function custom_woocommerce_catalog_orderby( $sortby ) {
$sortby['random_list'] = 'Сортировка по умолчанию';//название сортировки в админке и фронт энде
return $sortby;
}
add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 9;' ), 20 );
add_filter('loop_shop_columns', 'woo_product_columns_frontend');
function woo_product_columns_frontend() {
    global $woocommerce;

    $columns = 3;

	//Front page
	if (is_front_page()){
		$columns = 1;
	}
	
    // Product List
    if ( is_product_category()||is_tax('product_brand')||is_tax('product_tag') ) :
        $columns = 2;
    endif;

    //Related Products
    if ( is_product() ) :
        $columns = 3;
    endif;

    //Cross Sells
    if ( is_checkout() ) :
        $columns = 3;
    endif;

    return $columns;
}

add_action( 'woocommerce_before_main_content','elk_archive_content_cols_open',15 );
function elk_archive_content_cols_open() {?>
<?php if ( is_shop() || is_tax('product_cat') || is_tax('product_tag') || is_tax('product_brand') ) : ?>
		<div class="row">
			<div class="col-md-8">
<?php endif; ?>
<?php }
add_action( 'woocommerce_after_main_content','elk_archive_content_cols_close',5 );
function elk_archive_content_cols_close() { ?>
<?php if ( is_shop() || is_tax('product_cat') || is_tax('product_tag') || is_tax('product_brand') ) : ?>
			</div><!--/.col-md-8-->
		<div class="col-md-4">
				
							
								<?php if ( is_active_sidebar('sidebar-right-category') ) : ?>
										<h2>Фильтр</h2>
										<?php dynamic_sidebar('sidebar-right-category'); ?>
								<?php endif; ?>
							<?php elk_brands_list(); ?>
		</div><!--/.конец колонки col-md-4-->
	</div><!--/.row-->	
<?php endif; ?>	
<?php }
remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description',10 );
remove_action( 'woocommerce_archive_description', 'woocommerce_product_archive_description',10 );
add_action( 'woocommerce_after_shop_loop', 'woocommerce_taxonomy_archive_description',15 );
remove_action( 'woocommerce_before_shop_loop','woocommerce_catalog_ordering',30 );
add_action( 'woocommerce_after_shop_loop', 'woocommerce_product_archive_description',15 );
remove_action( 'woocommerce_after_subcategory', 'woocommerce_template_loop_category_link_close',10 );
add_action( 'woocommerce_before_subcategory_title', 'woocommerce_template_loop_category_link_close',15 );

function woocommerce_template_loop_category_title( $category ) {
		?>
		<div class="caption">
			<a href="<?php echo get_term_link( $category, 'product_cat' ); ?>">
			<?php echo $category->name; ?>
			</a>
		</div><!--/.caption-->
		<a href="<?php echo get_term_link( $category, 'product_cat' ); ?>" class="more">Подробнее</a>
		<?php
}

function woocommerce_subcategory_thumbnail( $category ) {
		$small_thumbnail_size  	= apply_filters( 'subcategory_archive_thumbnail_size', 'shop_catalog' );
		$dimensions    			= wc_get_image_size( $small_thumbnail_size );
		$thumbnail_id  			= get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true  );

		if ( $thumbnail_id ) {
			$image = wp_get_attachment_image_src( $thumbnail_id, $small_thumbnail_size  );
			$image = $image[0];
		} else {
			$image = wc_placeholder_img_src();
		}

		if ( $image ) {
			// Prevent esc_url from breaking spaces in urls for image embeds
			// Ref: https://core.trac.wordpress.org/ticket/23605
			$image = str_replace( ' ', '%20', $image );

			echo '<img src="' . esc_url( $image ) . '" alt="' . esc_attr( $category->name ) . '" width="" height="" />';
		}
}

remove_action( 'woocommerce_after_shop_loop','woocommerce_pagination',10 );	
add_action( 'woocommerce_after_shop_loop','elk_woocommerce_pagination',10 );
function elk_woocommerce_pagination() {
	wp_pagenavi();
}

add_action( 'woocommerce_after_shop_loop','elk_testimonials_anounce',20 );
function  elk_testimonials_anounce() { ?>
	                                    <!--  Отзывы -->
									<?php $args=array(
											'post_type'=>'post',
											'category_name'    => 'testimonials',
											'posts_per_page'=>2,
										);
										$posts=new WP_query( $args );
									if ( $posts->have_posts() ) { ?>
                                    <div id="comments" class="clearfix clear">
                                    	<h3>Отзывы наших покупателей</h3>
										<?php while ( $posts->have_posts() ) : $posts->the_post(); ?>
                                    	<div class="comments_item">
                                            <div><b><?php echo get_the_date(); ?></b></div>
                                            <div><b><?php the_title(); ?></b></div>
                                            <div class="text_comm">
                                                <?php the_content(); ?>
                                            </div>
                                        </div><!--/.comments_item-->
										<?php endwhile; // end of the loop. ?>
                                        <a href="<?php echo get_term_link('testimonials', 'category');?>" class="all">Посмотреть все отзывы</a>	
										</div><!--/#comments-->
									<?php } 
}

function  elk_brands_list(){ ?>
	                                    <div class="company ffrc">
                                        <h2>Производители</h2>
										<?php 
										$args = array(
										'taxonomy'      => array( 'product_brand' ),
										'orderby'       => 'id', 
										'order'         => 'ASC',
										'hide_empty'    => true,  
										'number'        => 8, 
										'fields'        => 'all', 
										'count'         => false,
										'slug'          => '', 
										'parent'         => 0,
										'hierarchical'  => true, 
										'child_of'      => 0, 
										'pad_counts'    => false, 
										'name'          => '', // str/arr поле name для получения термина по нему. C 4.2.
										'childless'     => false, // true не получит (пропустит) термины у которых есть дочерние термины. C 4.2.
										'update_term_meta_cache' => true, // подгружать метаданные в кэш
									); 

									$brands = get_terms( $args );
									if ($brands) {
										foreach( $brands as $brand ){ ?>
											<a href="<?php echo get_term_link( $brand ); ?>"><?php echo $brand->name; ?></a>
										<?php }
									}
										?>

                                    </div><!--/.company-->
                                    <a href="/product_brand/" class="all">Посмотреть все</a>
<?php } 

remove_action( 'woocommerce_before_shop_loop','woocommerce_result_count',20 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
add_action( 'woocommerce_shop_loop_item_title', 'elk_template_loop_product_title', 10 );
function elk_template_loop_product_title(){ 
global $product; ?>
	 <div class="caption"><a href="<?php the_permalink(); ?>" title="" class="woocommerce_shop_loop_item_title"><?php the_title(); ?></a></div>
	 <div class="sku"><?php echo ( $sku = $product->get_sku() ) ? esc_html_e( 'SKU:', 'woocommerce' ).' '.$sku : '&nbsp;'; ?></div>
	 <?php 	$brand_terms=get_the_terms( $product->get_ID(), 'product_brand'); ?>
	 <div class="breeder">
	 <?php if ($brand_terms):  ?>
	 <?php $brand_term=$brand_terms[0];
	 $parent_id=get_up_parent_term($brand_term->term_id,'product_brand','id');
	 $parent_name=get_up_parent_term($brand_term->term_id,'product_brand','name')?>
	 <a href="<?php echo ($parent_id)?get_term_link( $parent_id, 'product_brand' ):get_term_link( $brand_term->term_id, 'product_brand' ); ?>"><?php echo $parent_name; ?></a>
	 <?php else : ?>
	 &nbsp;
	 <?php endif;?>
	</div>
<?php }
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close',5 );
add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_close',15 );

add_filter( 'tm_woocompare_button', 'elk_compare_button',1,6 );
function elk_compare_button($html, $classes, $id, $nonce, $text, $preloader){
	/*if (!is_product()){*/
		$html = sprintf( '<button type="button" class="%s button compare_btn" data-id="%s" data-nonce="%s">%s</button>', implode( ' ', $classes ), $id, $nonce, $text . $preloader );
	/*} else {
		
		$classes=array_diff($classes,array('button','btn','btn-default'));
		$classes_str=implode( ' ', $classes );
		$html = sprintf( '<a class="%s" data-id="%s" data-nonce="%s">%s</button>', $classes_str, $id, $nonce,$text . $preloader );
	}*/
	echo $html;
}
add_filter( 'tm_woowishlist_button', 'elk_wishlist_button',1,6 );
function elk_wishlist_button($html, $classes, $id, $nonce, $text, $preloader){
	/*if (!is_product()){*/
		$html = sprintf( '<button type="button" class="%s button wishlist_btn" data-id="%s" data-nonce="%s">%s</button>', implode( ' ', $classes ), $id, $nonce, $text . $preloader );
	/*} else {
		$classes=array_diff($classes,array('button','btn','btn-default'));
		$classes_str=implode( ' ', $classes );
		$html = sprintf( '<a class="%s wishlist_btn" data-id="%s" data-nonce="%s">%s</a>', $classes_str, $id, $nonce,$text. $preloader );
	}*/
	echo $html;
}
/*Кнопки "В корзину", "Сравнение" и "Список желаний" заключаем в общий <div>*/
remove_action( 'woocommerce_after_shop_loop_item', 'tm_woocompare_add_button_loop', 12 );
add_action( 'woocommerce_after_shop_loop_item', 'tm_woocompare_add_button_loop', 14 );
add_filter( 'woocommerce_loop_add_to_cart_link', 'elk_panel_butt_open',1);
add_action( 'woocommerce_after_shop_loop_item','elk_panel_butt_close',15);//на 12 и 14 навешены кнопки compare и wishlist
function elk_panel_butt_open( $text ){
	//if (is_tax('product_cat') || is_tax('product_brand') || is_tax('product_tag') || is_front_page() ) {
	$text = '<div class="panel_butt">'. $text;
	//}
	return $text;
}
function elk_panel_butt_close(){
	//if (is_tax('product_cat') || is_tax('product_brand') || is_tax('product_tag') || is_front_page()) {
	echo '</div>';
	//}
}
/***********************************
Настраиваем карточку товара
**********************************/
remove_action( 'woocommerce_single_product_summary','woocommerce_template_single_title',5 );
add_action( 'woocommerce_before_single_product_summary','woocommerce_template_single_title',5 );
add_action( 'woocommerce_before_single_product_summary','elk_template_single_sku',7 );
function elk_template_single_sku(){
	global $product; ?>
	<div class="sku"><?php _e('SKU', 'woocommerce'); ?> <?php echo $product->get_sku(); ?></div>
<?php }
add_action( 'woocommerce_before_single_product_summary','elk_single_product_cols_open',8 );
function elk_single_product_cols_open(){ ?>
		<div class="row padTop10">
			<div class="col-md-8">	
<?php }
add_action( 'woocommerce_after_single_product_summary','elk_single_product_cols_close',5 );
function elk_single_product_cols_close(){ ?>
			</div><!--/.конец колонки col-md-8-->
			<div class="col-md-4">
			<div class="single-product-right">
	<?php if ( is_active_sidebar('sidebar-right-product') ) :
		dynamic_sidebar('sidebar-right-product');
	endif; ?>
			</div>
			</div><!--/.конец колонки col-md-4-->
		</div><!--/.row-->
<?php }
remove_action( 'woocommerce_before_single_product_summary','woocommerce_show_product_sale_flash', 10 );
add_action( 'woocommerce_single_product_summary','elk_single_product_attributes',8 );
function elk_single_product_attributes(){
	global $product;
	/*wc_display_product_attributes($product); disabled*/
	$brand_terms=get_the_terms( $product->get_ID(), 'product_brand'); 
	 if ($brand_terms):  ?>
	<table class="shop_attributes">
		<tbody><tr class="">
		<th><?php _e('Производитель', 'woocommerce'); ?></th>
			<?php $brand_term=$brand_terms[0]; 
			$parent_id=get_up_parent_term($brand_term->term_id,'product_brand','id');
			$parent_name=get_up_parent_term($brand_term->term_id,'product_brand','name')?>
			<td><a href="<?php echo ($parent_id)?get_term_link( $parent_id, 'product_brand' ):get_term_link( $brand_term->term_id, 'product_brand' ); ?>"><?php echo $parent_name ;?></a></td>
		</tr>
		<tr class="">
			<th><?php _e('Код товара', 'woocommerce'); ?></th>
			<td><?php echo $product->get_id(); ?></td>
		</tr>
	</div></tbody>
	</table>	
<?php endif;
}
remove_action( 'woocommerce_single_product_summary','woocommerce_template_single_meta',40 );
remove_action( 'woocommerce_single_product_summary','woocommerce_template_single_excerpt',20 );
add_action( 'woocommerce_single_product_summary','elk_buy_1_click',40);
function elk_buy_1_click() { ?>

<a href="#By1ClickModal" data-toggle="modal" class="button one-click">Купить в один клик</a>
<div class="modal fade" id="By1ClickModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h3 class="line-bottom line-height-1 mt-0 mt-sm-30">Купить в 1 клик</h3>
								</div>
								<div class="modal-body">
									<?php echo do_shortcode('[contact-form-7 id="219" title="Купить в 1 клик"]'); ?>
								</div>
							</div>
						</div>
					</div>
<?php }
remove_action( 'woocommerce_single_product_summary', 'tm_woowishlist_add_button_single', 35 );
add_action( 'woocommerce_single_product_summary', 'tm_woowishlist_add_button_single', 45 );
remove_action( 'woocommerce_single_product_summary', 'tm_woocompare_add_button_single', 35 );
add_action( 'woocommerce_single_product_summary', 'tm_woocompare_add_button_single', 44 );

add_filter( 'woocommerce_product_tabs', 'elk_edit_product_tabs', 98 );
function elk_edit_product_tabs( $tabs ) {
	$tabs['additional_information']['priority'] = 1;
	//$tabs['description']['priority'] = 10;
	return $tabs;
}
add_filter( 'woocommerce_product_description_heading','elk_tab_heading');
add_filter( 'woocommerce_product_additional_information_heading','elk_tab_heading');
function elk_tab_heading(){
	return '';
}

add_action( 'woocommerce_after_single_product_summary','elk_single_product_share',11 );
function elk_single_product_share(){ ?>
	<h4 class="share">Поделиться товаром в соцсетях:</h4>
	<?php echo do_shortcode('[addtoany]'); 
}
remove_action( 'woocommerce_after_single_product_summary','woocommerce_output_related_products',20 );
add_filter('woocommerce_output_related_products_args', 'elk_output_related_products_args');
function elk_output_related_products_args($args) {
        $args['columns'] = 3;            // количество выводимых колонок, по умолчанию 2
        //$args['orderby'] = 'rand';        // порядок сортировки. по умолчанию случайный 'rand'

        return $args;
    }

add_action( 'woocommerce_after_single_product_summary','elk_output_recently_products',21 );     
function elk_output_recently_products(){
	global $woocommerce_loop;
	$woocommerce_loop['columns']=3;
}

/*Перенос блок выбора способа доставки и оплаты*/
// hook into the fragments in AJAX and add our new table to the group
add_filter('woocommerce_update_order_review_fragments', 'websites_depot_order_fragments_split_shipping', 10, 1);

function websites_depot_order_fragments_split_shipping($order_fragments) {
	// review shipping table fragment
	ob_start();
	websites_depot_woocommerce_order_review_shipping_split();
	$websites_depot_woocommerce_order_review_shipping_split = ob_get_clean();
	$order_fragments['.websites-depot-checkout-review-shipping-table'] = $websites_depot_woocommerce_order_review_shipping_split;
	// shipping options fragment	
	ob_start();
	echo '<div class="woocommerce_shipping_options">';
	do_action('woocommerce_review_order_after_shipping');
	echo '</div>';
	$html=ob_get_clean();
	$order_fragments['.woocommerce_shipping_options'] = $html;
	// place order fragment
	ob_start();
	wc_get_template( 'checkout/place-order.php', array(
			'checkout'           => WC()->checkout(),
			'order_button_text'  => apply_filters( 'woocommerce_order_button_text', __( 'Place order', 'woocommerce' ) ),
		) );
	$place_order = ob_get_clean();	
	$order_fragments['.place-order'] = $place_order;	
	return $order_fragments;

}
// We'll get the template that just has the shipping options that we need for the new table
function websites_depot_woocommerce_order_review_shipping_split( $deprecated = false ) {
	wc_get_template( 'checkout/shipping-order-review.php', array( 'checkout' => WC()->checkout() ) );
}


// Hook the new table in before the customer details - you can move this anywhere you'd like. Dropping the html into the checkout template files should work too.
add_action('woocommerce_checkout_order_review', 'websites_depot_move_new_shipping_table', 12);

function websites_depot_move_new_shipping_table() {
	echo '<h3>Выберите способ доставки:</h3><table class="websites-depot-checkout-review-shipping-table"></table>';
}
if (function_exists('woocommerce_shipping_options')){
add_action('woocommerce_checkout_order_review', 'woocommerce_shipping_options', 15);
}

function woocommerce_shipping_options() {
	echo '<div class="woocommerce_shipping_options">';
	do_action('woocommerce_review_order_after_shipping');
	echo '</div>';
}
add_action('woocommerce_checkout_order_review', 'ship_pay_block_open', 11);
function ship_pay_block_open(){
	echo '<div class="shipping_payment_block">';
}
add_action('woocommerce_checkout_order_review', 'ship_pay_block_close', 21);
function ship_pay_block_close(){
	echo '</div><!--/.shipping_payment_block-->';
}
add_action( 'woocommerce_checkout_after_order_review','elk_place_order_button',10 );
function elk_place_order_button(){
		wc_get_template( 'checkout/place-order.php', array(
			'checkout'           => WC()->checkout(),
			'order_button_text'  => apply_filters( 'woocommerce_order_button_text', __( 'Place order', 'woocommerce' ) ),
		) );	
}
add_filter( 'woocommerce_cart_shipping_method_full_label', 'elk_method_note',10,2 );
function elk_method_note($label, $method) {
	$label = $method->get_label();

//	if ( $method->cost > 0 ) {
		if ( WC()->cart->tax_display_cart == 'excl' ) {
			$label .= ': стоимость ' . wc_price( $method->cost );
			if ( $method->get_shipping_tax() > 0 && WC()->cart->prices_include_tax ) {
				$label .= ' <small class="tax_label">' . WC()->countries->ex_tax_or_vat() . '</small>';
			}
		} else {
			$label .= ': стоимость ' . wc_price( $method->cost + $method->get_shipping_tax() );
			if ( $method->get_shipping_tax() > 0 && ! WC()->cart->prices_include_tax ) {
				$label .= ' <small class="tax_label">' . WC()->countries->inc_tax_or_vat() . '</small>';
			}
		}
//	}
	
	$config = get_option('wooship_options', array());
	if ('wooship'===$method->method_id){
		$id_pos=strpos($method->id,'_')+1;
		$id=substr($method->id,$id_pos);
		$label.='<div class="note">'.$config['shipping_methods'][$id]['note'].'</div>';
	}
	return $label;
}
add_filter( 'tm_compare_default_count', 'elk_compare_refresh_count' );
function elk_compare_refresh_count($fragments){
	$fragments['a.butt_compare > div.num']=$fragments['.menu-compare > a'];
	return $fragments;
}
add_filter( 'tm_wishlist_default_count', 'elk_wishlist_refresh_count' );
function elk_wishlist_refresh_count($fragments){
	$wishlist_count = 0;
	$wishlist_ids = tm_woowishlist_get_list();
	if ($wishlist_ids) {
		$products = tm_woowishlist_get_products($wishlist_ids);
		if ($products) {
			$wishlist_count = $products->post_count;
		}
	}	
	$fragments['a.butt_favor > div.num']=$wishlist_count;
	return $fragments;
}

/*add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );*/

// Our hooked in function - $fields is passed via the filter!
/*function custom_override_checkout_fields( $fields ) {
     $fields['billing']['billing_country']['placeholder'] = 'My new placeholder';
     return $fields;
}*/
// Hook in
add_filter( 'woocommerce_default_address_fields' , 'custom_override_default_address_fields' );

// Our hooked in function - $address_fields is passed via the filter!
function custom_override_default_address_fields( $address_fields ) {
     $address_fields['city']['label'] = 'Город';
	 $address_fields['city']['priority'] = '40';
	 $address_fields['postcode']['label'] = 'Индекс';
	 $address_fields['postcode']['priority'] = '50';
	 $address_fields['address_1']['placeholder'] = 'Улица';
	 $address_fields['address_1']['priority'] = '60';
	 $address_fields['address_2']['placeholder'] = 'Дом, офис';
	 $address_fields['address_2']['priority'] = '70';	 

     return $address_fields;
}
remove_action( 'woocommerce_order_details_after_customer_details', 'wooccm_custom_checkout_details' );
add_action( 'woocommerce_order_details_after_customer_details', 'elk_custom_checkout_details' );
function elk_custom_checkout_details( $order ){

	$shipping = array(
		'country', 
		'first_name', 
		'last_name', 
		'company', 
		'address_1', 
		'address_2', 
		'city', 
		'state', 
		'postcode'
	);
	$billing = array(
		'country', 
		'first_name', 
		'last_name', 
		'company', 
		'address_1', 
		'address_2', 
		'city', 
		'state', 
		'postcode', 
		'email', 
		'phone'
	);

	$names = array(
		'billing',
		'shipping'
	);
	$inc = 3;

	// Check if above WooCommerce 2.3+
	if( defined( 'WOOCOMMERCE_VERSION' ) && version_compare( WOOCOMMERCE_VERSION, '2.3', '>=' ) ) {

		foreach( $names as $name ) {

			$array = ( $name == 'billing' ) ? $billing : $shipping;

			$options = get_option( 'wccs_settings'.$inc );
			if( !empty( $options[$name.'_buttons'] ) ) {
				foreach( $options[$name.'_buttons'] as $btn ) {

					if( !in_array( $btn['cow'], $array ) ) {
						if(
							( get_post_meta( $order->id , '_'.$name.'_'.$btn['cow'], true) !== '' ) && 
							!empty( $btn['label'] ) && 
							empty( $btn['deny_receipt'] ) && 
							$btn['type'] !== 'heading' && 
							$btn['type'] !== 'wooccmupload' && 
							$btn['type'] !== 'multiselect' && 
							$btn['type'] !== 'multicheckbox'
						) {
							echo '
<tr>
	<th>'.wooccm_wpml_string($btn['label']).':</th>
	<td>'.nl2br( get_post_meta( $order->id , '_'.$name.'_'.$btn['cow'], true ) ).'</td>
</tr>';
						} elseif (
							!empty( $btn['label'] ) && 
							empty( $btn['deny_receipt'] ) && 
							$btn['type'] !== 'multiselect' && 
							$btn['type'] !== 'multicheckbox' && 
							$btn['type'] == 'heading'
						) {
							echo '
<tr>
	<th colspan="2">' .wooccm_wpml_string($btn['label']). '</th>
</tr>';
						} elseif (
							( get_post_meta( $order->id , '_'.$name.'_'.$btn['cow'], true) !== '') && 
							$btn['type'] !== 'wooccmupload' && 
							!empty( $btn['label'] ) && 
							empty( $btn['deny_receipt'] ) && 
							$btn['type'] !== 'heading' && 
							(
								( $btn['type'] == 'multiselect' ) || ( $btn['type'] == 'multicheckbox' )
							)
						) {
							$value = get_post_meta( $order->id , '_'.$name.'_'.$btn['cow'], true );
							$strings = maybe_unserialize( $value );
							echo '
<tr>
	<th>'.wooccm_wpml_string($btn['label']).':</th>
	<td data-title="' .wooccm_wpml_string($btn['label']). '">';
							if( !empty( $strings ) ) {
								if( is_array( $strings ) ) {
									foreach( $strings as $key ) {
										echo wooccm_wpml_string( $key ) . ', ';
									}
								} else {
									echo $strings;
								}
							} else {
								echo '-';
							}
									echo '
	</td>
</tr>';
						} elseif( $btn['type'] == 'wooccmupload' ) {
							$info = explode("||", get_post_meta( $order->id , '_'.$name.'_'.$btn['cow'], true));
							$media_ids=explode(",",$info[0]);
							$file_names="";
							foreach ($media_ids as $media_id) {
								if (!empty($media_id)){
									$file_names=$file_names.basename(wp_get_attachment_image_url($media_id)).', ';
								}
							}
							$info[0]=$file_names;
							$btn['label'] = ( !empty( $btn['force_title2'] ) ? $btn['force_title2'] : $btn['label'] );
							if ($file_names){
							echo '
<tr>
	<th>'.wooccm_wpml_string( trim( $btn['label'] ) ).':</th>
	<td>'.$info[0].'</td>
</tr>';
							}
						}
					}

				}
			}
			$inc--;

		}

		$options = get_option( 'wccs_settings' );
		$buttons = ( isset( $options['buttons'] ) ? $options['buttons'] : false );
		if( !empty( $buttons ) ) {
			foreach( $buttons as $btn ) {

				if(
					( get_post_meta( $order->id , $btn['cow'], true ) !== '' ) && 
					!empty( $btn['label'] ) && 
					empty( $btn['deny_receipt'] ) && 
					$btn['type'] !== 'heading' && 
					$btn['type'] !== 'wooccmupload' && 
					$btn['type'] !== 'multiselect' && 
					$btn['type'] !== 'multicheckbox'
				) {
					echo '
<tr>
	<th>'.wooccm_wpml_string($btn['label']).':</th>
	<td data-title="' .wooccm_wpml_string($btn['label']). '">'.nl2br( get_post_meta( $order->id, $btn['cow'], true ) ).'</td>
</tr>';
				} elseif(
					!empty( $btn['label'] ) && 
					empty( $btn['deny_receipt'] ) && 
					$btn['type'] !== 'wooccmupload' && 
					$btn['type'] !== 'multiselect' && 
					$btn['type'] !== 'multicheckbox' && 
					$btn['type'] == 'heading'
				) {
					echo '
<tr>
	<th colspan="2">' .wooccm_wpml_string($btn['label']). '</th>
</tr>';
				} elseif(
					( get_post_meta( $order->id, $btn['cow'], true ) !== '' ) && 
					!empty( $btn['label'] ) && 
					empty( $btn['deny_receipt'] ) && 
					$btn['type'] !== 'heading' && 
					$btn['type'] !== 'wooccmupload' && 
					(
						$btn['type'] == 'multiselect' || $btn['type'] == 'multicheckbox'
					)
				) {
					$value = get_post_meta( $order->id , $btn['cow'], true );
					$strings = maybe_unserialize( $value );
					echo '
<tr>
	<th>'.wooccm_wpml_string($btn['label']).':</th>
	<td data-title="' .wooccm_wpml_string($btn['label']). '">';
					if( !empty( $strings ) ) {
						if( is_array( $strings ) ) {
							foreach( $strings as $key ) {
								echo wooccm_wpml_string($key) . ', ';
							}
						} else {
							echo $strings;
						}
					} else {
						echo '-';
					}
					echo '
	</td>
</tr>';
				} elseif( $btn['type'] == 'wooccmupload' ) {
					$info = explode("||", get_post_meta( $order->id , $btn['cow'], true));
					$media_ids=explode(",",$info[0]);
					$file_names="";
					foreach ($media_ids as $media_id) {
						if (!empty($media_id)){
							$file_names=$file_names.basename(wp_get_attachment_image_url($media_id)).', ';
						}
					}
					$info[0]=$file_names;
					$btn['label'] = ( !empty( $btn['force_title2'] ) ? $btn['force_title2'] : $btn['label'] );
					if ($file_names){
					echo '
<tr>
	<th>'.wooccm_wpml_string( trim( $btn['label'] ) ).':</th>
	<td data-title="' .wooccm_wpml_string( trim( $btn['label'] ) ). '">'.$info[0].'</td>
</tr>';
					}
				}

			}
		}

	}
}
remove_action( 'woocommerce_email_after_order_table', 'wooccm_add_payment_method_to_new_order', 10);
add_action( 'woocommerce_email_after_order_table', 'elk_add_payment_method_to_new_order', 10, 3 );
function elk_add_payment_method_to_new_order( $order, $sent_to_admin, $plain_text = '' ) {

	$shipping = array(
		'country', 
		'first_name', 
		'last_name', 
		'company', 
		'address_1', 
		'address_2', 
		'city', 
		'state', 
		'postcode'
	);
	$billing = array( 
		'country', 
		'first_name', 
		'last_name', 
		'company', 
		'address_1', 
		'address_2', 
		'city', 
		'state', 
		'postcode', 
		'email', 
		'phone'
	);

	$names = array( 'billing', 'shipping' );
	$inc = 3;

 	if( $plain_text ) {

		foreach( $names as $name ) {

			$array = ($name == 'billing') ? $billing : $shipping;

			$options = get_option( 'wccs_settings'.$inc );
			if( !empty( $options[$name.'_buttons'] ) ) {
				foreach( $options[$name.'_buttons'] as $btn ) {

					if( !in_array( $btn['cow'], $array ) ) {
						if(
							( get_post_meta( $order->id , '_'.$name.'_'.$btn['cow'], true ) !== '' ) && 
							!empty( $btn['label'] ) && 
							empty( $btn['deny_receipt'] ) && 
							$btn['type'] !== 'heading' && 
							$btn['type'] !== 'multiselect' && 
							$btn['type'] !== 'wooccmupload' && 
							$btn['type'] !== 'multicheckbox'
						) {
							echo wooccm_wpml_string( $btn['label'] ).': '.nl2br( get_post_meta( $order->id , '_'.$name.'_'.$btn['cow'], true ) );
							echo "\n";
						} elseif (
							!empty( $btn['label'] ) && 
							empty( $btn['deny_receipt'] ) && 
							$btn['type'] == 'heading' && 
							$btn['type'] !== 'multiselect' && 
							$btn['type'] !== 'wooccmupload' && 
							$btn['type'] !== 'multicheckbox'
						) {
							echo wooccm_wpml_string( $btn['label'] );
							echo "\n";
						} elseif(
							( get_post_meta( $order->id , '_'.$name.'_'.$btn['cow'], true ) !== '' ) && 
							!empty( $btn['label'] ) && 
							empty( $btn['deny_receipt'] ) && 
							$btn['type'] !== 'heading' && 
							$btn['type'] !== 'wooccmupload' && 
							(
								$btn['type'] == 'multiselect' || $btn['type'] == 'multicheckbox'
							)
						) {
							$value = get_post_meta( $order->id , '_'.$name.'_'.$btn['cow'], true );
							$strings = maybe_unserialize( $value );
							echo wooccm_wpml_string($btn['label']).': ';
							if( !empty( $strings ) ) {
								if( is_array( $strings ) ) {
									$iww = 0;
									$len = count( $strings );
									foreach( $strings as $key ) {
										if( $iww == $len - 1 ) {
											echo $key;
										} else {
											echo $key.', ';
										}
										$iww++;
									}
								} else {
									echo $strings;
								}
							} else {
								echo '-';
							}
							echo "\n";
						} elseif( $btn['type'] == 'wooccmupload' ) {
							$info = explode( "||", get_post_meta( $order->id , '_'.$name.'_'.$btn['cow'], true));
							$media_ids=explode(",",$info[0]);
							$file_names="";
							foreach ($media_ids as $media_id) {
								if (!empty($media_id)){
									$file_names=$file_names.basename(wp_get_attachment_image_url($media_id)).', ';
								}
							}
							$info[0]=$file_names;							
							$btn['label'] = ( !empty( $btn['force_title2'] ) ? $btn['force_title2'] : $btn['label'] );
							echo wooccm_wpml_string( trim( $btn['label'] ) ).': '.$info[0];
							echo "\n";
						}
					}

				}
			}
			$inc--;

		}

		$options = get_option( 'wccs_settings' );
		if( !empty( $options['buttons'] ) ) {
			foreach( $options['buttons'] as $btn ) {

				if(
					( get_post_meta( $order->id , $btn['cow'], true ) !== '' ) && 
					!empty( $btn['label'] ) && 
					empty( $btn['deny_receipt'] ) && 
					$btn['type'] !== 'heading' && 
					$btn['type'] !== 'multiselect' && 
					$btn['type'] !== 'wooccmupload' && 
					$btn['type'] !== 'multicheckbox'
				) {
					echo wooccm_wpml_string( $btn['label'] ).': '.nl2br( get_post_meta( $order->id , $btn['cow'], true ) );
					echo "\n";
				} elseif(
					!empty( $btn['label'] ) && 
					empty( $btn['deny_receipt'] ) && 
					$btn['type'] == 'heading' && 
					$btn['type'] !== 'multiselect' && 
					$btn['type'] !== 'wooccmupload' && 
					$btn['type'] !== 'multicheckbox'
				) {
					echo wooccm_wpml_string( $btn['label'] );
					echo "\n";
				} elseif(
					( get_post_meta( $order->id, $btn['cow'], true ) !== '' ) && 
					!empty( $btn['label'] ) && 
					empty( $btn['deny_receipt'] ) && 
					$btn['type'] !== 'heading' && 
					$btn['type'] !== 'wooccmupload' && 
					(
						$btn['type'] == 'multiselect' || $btn['type'] == 'multicheckbox'
					)
				) {
					$value = get_post_meta( $order->id , $btn['cow'], true );
					$strings = maybe_unserialize( $value );
					echo wooccm_wpml_string($btn['label']).': ';
					if( !empty( $strings ) ) {
						if( is_array( $strings ) ) {
							$iww = 0;
							$len = count($strings);
							foreach($strings as $key ) {
								if( $iww == $len - 1 ) {
									echo $key;
								} else {
									echo $key.', ';
								}
								$iww++;
							}
						} else {
							echo $strings;
						}
					} else {
						echo '-';
					}
					echo "\n";
				} elseif( $btn['type'] == 'wooccmupload' ) {
					$info = explode( "||", get_post_meta( $order->id, $btn['cow'], true ) );
					$media_ids=explode(",",$info[0]);
					$file_names="";
					foreach ($media_ids as $media_id) {
						if (!empty($media_id)){
							$file_names=$file_names.basename(wp_get_attachment_image_url($media_id)).', ';
						}
					}
					$info[0]=$file_names;
					$btn['label'] = ( !empty( $btn['force_title2'] ) ? $btn['force_title2'] : $btn['label'] );
					echo wooccm_wpml_string( trim( $btn['label'] ) ).': '.$info[0];
					echo "\n";
				}

			}
		}

		if ( !empty( $options['checkness']['set_timezone'] ) ) {
			date_default_timezone_set( $options['checkness']['set_timezone'] );
		}
		$date = ( !empty( $options['checkness']['twenty_hour'] ) ) ? date( "G:i T (P" ).' GMT)' : date( "g:i a" );
		$options['checkness']['time_stamp'] = ( isset( $options['checkness']['time_stamp'] ) ? $options['checkness']['time_stamp'] : false );
		if ( $options['checkness']['time_stamp'] == true ) {
			echo $options['checkness']['time_stamp_title'].' ' . $date . "\n";
		}
		if( $order->payment_method_title && isset( $options['checkness']['payment_method_t'] ) && $options['checkness']['payment_method_t'] == true ) {
			echo $options['checkness']['payment_method_d'].': ' . $order->payment_method_title . "\n";
		}
		if( $order->shipping_method_title && isset( $options['checkness']['shipping_method_t'] ) && $options['checkness']['shipping_method_t'] == true ) {
			echo $options['checkness']['shipping_method_d'].': ' . $order->shipping_method_title . "\n";
		}

		echo "\n";

	} else {

		foreach( $names as $name ) {

			$array = ( $name == 'billing' ) ? $billing : $shipping;

			$options = get_option( 'wccs_settings'.$inc );
			if( !empty( $options[$name.'_buttons'] ) ) {
				foreach( $options[$name.'_buttons'] as $btn ) {

					if( !in_array( $btn['cow'], $array ) ) {
						if(
							( get_post_meta( $order->id , '_'.$name.'_'.$btn['cow'], true ) !== '' ) && 
							!empty( $btn['label'] ) && 
							empty( $btn['deny_receipt'] ) && 
							$btn['type'] !== 'heading' && 
							$btn['type'] !== 'multiselect' && 
							$btn['type'] !== 'wooccmupload' && 
							$btn['type'] !== 'multicheckbox'
						) {
							echo '
<p>
	<strong>'.wooccm_wpml_string($btn['label']).':</strong> '.nl2br( get_post_meta( $order->id , '_'.$name.'_'.$btn['cow'], true ) ).'
</p>';
						} elseif (
							!empty( $btn['label'] ) && 
							empty( $btn['deny_receipt'] ) && 
							$btn['type'] == 'heading' && 
							$btn['type'] !== 'multiselect' && 
							$btn['type'] !== 'wooccmupload' && 
							$btn['type'] !== 'multicheckbox'
						) {
							echo '
<h2>' .wooccm_wpml_string($btn['label']). '</h2>';
						} elseif (
							( get_post_meta( $order->id , '_'.$name.'_'.$btn['cow'], true ) !== '' ) && 
							!empty( $btn['label'] ) && 
							empty( $btn['deny_receipt'] ) && 
							$btn['type'] !== 'heading' && 
							$btn['type'] !== 'wooccmupload' && 
							(
								$btn['type'] == 'multiselect' || $btn['type'] == 'multicheckbox'
							)
						) {
							$value = get_post_meta( $order->id , '_'.$name.'_'.$btn['cow'], true );
							$strings = maybe_unserialize( $value );
							echo '
<p>
	<strong>'.wooccm_wpml_string($btn['label']).':</strong> ';
							if( !empty( $strings ) ) {
								if( is_array( $strings ) ) {
									$iww = 0;
									$len = count( $strings );
									foreach( $strings as $key ) {
										if( $iww == $len - 1 ) {
											echo $key;
										} else {
											echo $key.', ';
										}
										$iww++;
									}
								} else {
									echo $strings;
								}
							} else {
								echo '-';
							}
							echo '
</p>';
						} elseif( $btn['type'] == 'wooccmupload' ) {
							$info = explode( "||", get_post_meta( $order->id , '_'.$name.'_'.$btn['cow'], true ) );
							$media_ids=explode(",",$info[0]);
							$file_names="";
							foreach ($media_ids as $media_id) {
								if (!empty($media_id)){
									$file_names=$file_names.basename(wp_get_attachment_image_url($media_id)).', ';
								}
							}
							$info[0]=$file_names;
							$btn['label'] = ( !empty( $btn['force_title2'] ) ? $btn['force_title2'] : $btn['label'] );
							echo '
<p>
	<strong>'.wooccm_wpml_string( trim( $btn['label'] ) ).':</strong> '.$info[0].'
</p>';
						}
					}

				}
			}
			$inc--;

		}

		$options = get_option( 'wccs_settings' );
		if( !empty( $options['buttons'] ) ) {
			foreach( $options['buttons'] as $btn ) {

				if(
					( get_post_meta( $order->id , $btn['cow'], true ) !== '' ) && 
					!empty( $btn['label'] ) && 
					empty( $btn['deny_receipt'] ) && 
					$btn['type'] !== 'heading' && 
					$btn['type'] !== 'multiselect' && 
					$btn['type'] !== 'wooccmupload' && 
					$btn['type'] !== 'multicheckbox'
				) {
					echo '<p><strong>'.wooccm_wpml_string( $btn['label'] ).':</strong> '.nl2br( get_post_meta( $order->id , $btn['cow'], true ) ).'</p>';
				} elseif ( !empty( $btn['label'] ) && empty($btn['deny_receipt']) && ($btn['type'] == 'heading') && ($btn['type'] !== 'multiselect') && $btn['type'] !== 'wooccmupload' && ($btn['type'] !== 'multicheckbox') ) {
					echo '<h2>'.wooccm_wpml_string($btn['label']).'</h2>';
				} elseif ( ( get_post_meta( $order->id , $btn['cow'], true ) !== '' ) && !empty( $btn['label'] ) && empty($btn['deny_receipt']) && ($btn['type'] !== 'heading') && $btn['type'] !== 'wooccmupload' && (($btn['type'] == 'multiselect') || ($btn['type'] == 'multicheckbox')) ) {
					$value = get_post_meta( $order->id , $btn['cow'], true );
					$strings = maybe_unserialize( $value );
					echo '
<p>
	<strong>'.wooccm_wpml_string($btn['label']).':</strong> ';
					if( !empty( $strings ) ) {
						if( is_array( $strings ) ) {
							$iww = 0;
							$len = count( $strings );
							foreach( $strings as $key ) {
								if( $iww == $len - 1 ) {
									echo $key;
								} else {
									echo $key.', ';
								}
								$iww++;
							}
						} else {
							echo $strings;
						}
					} else {
						echo '-';
					}
					echo '
</p>';
				} elseif( $btn['type'] == 'wooccmupload' ) {
					$info = explode( "||", get_post_meta( $order->id , $btn['cow'], true ) );
					$media_ids=explode(",",$info[0]);
					$file_names="";
					foreach ($media_ids as $media_id) {
						if (!empty($media_id)){
							$file_names=$file_names.basename(wp_get_attachment_image_url($media_id)).', ';
						}
					}
					$info[0]=$file_names;					
					$btn['label'] = ( !empty( $btn['force_title2'] ) ? $btn['force_title2'] : $btn['label'] );
					echo '
<p>
	<strong>'.wooccm_wpml_string( trim( $btn['label'] ) ).':</strong> '.$info[0].'
</p>';
				}

			}
		}

		// @mod - We are not doing any checking for valid TimeZone
		if ( !empty($options['checkness']['set_timezone']) ) {
			date_default_timezone_set( $options['checkness']['set_timezone'] );
		}
		$date = ( !empty($options['checkness']['twenty_hour'])) ? date("G:i T (P").' GMT)' : date("g:i a");
		$options['checkness']['time_stamp'] = ( isset( $options['checkness']['time_stamp'] ) ? $options['checkness']['time_stamp'] : false );
		if( $options['checkness']['time_stamp'] == true ) {
			echo '
<p>
	<strong>'.$options['checkness']['time_stamp_title'].':</strong> ' . $date . '
</p>';
		}
		/*if( $order->payment_method_title && isset( $options['checkness']['payment_method_t'] ) && $options['checkness']['payment_method_t'] == true ) {
			echo '
<p>
	<strong>'.$options['checkness']['payment_method_d'].':</strong> ' . $order->payment_method_title . '
</p>';
		}*/
		/*if( $order->shipping_method_title && $options['checkness']['shipping_method_t'] == true ) {
			echo '
<p>
	<strong>'.$options['checkness']['shipping_method_d'].':</strong> ' . $order->shipping_method_title . '
</p>';
		}*/

	}

}