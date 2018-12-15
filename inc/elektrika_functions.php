<?php
add_filter('body_class','elk_body_classes');
function elk_body_classes( $classes ) {
	// добавим класс 'woocommerce' в массив классов $classes для страниц "Избранное" и "Сравнение"
	if( is_page(182) || is_page(184) )
		$classes[] = 'woocommerce';

	return $classes;
}
function phone_clean($phone){
	$phone= str_replace([' ', '(', ')', '-'], '', $phone);
	return $phone;
}
add_filter('body_class','my_class_names');
function my_class_names( $classes ) {
	// добавим класс 'class-name' в массив классов $classes
	if( is_front_page() )
		$classes[] = 'woocommerce-page';

	return $classes;
}
/*add_filter( 'widget_nav_menu_args', 'elk_widget_nav_menu',10, 4 );
function elk_widget_nav_menu( $nav_menu_args, $nav_menu, $args, $instance ){
	$nav_menu_args['items_wrap'] = '<ul class="panel list-group">%3$s</ul>'; 
	$nav_menu_args['container_id'] = 'accordion'; 
	return $nav_menu_args;
}*/
add_filter( 'gettext', 'theme_change_comment_field_names', 20, 3 );
function theme_change_comment_field_names( $translated_text, $text, $domain ) {

        switch ( $text ) {

            case 'Add to cart' :
				$translated_text = 'В корзину';
                break;
			case 'Product' :
				$translated_text = 'Название товара';
                break;	
			case 'Price' :
				$translated_text = 'Цена (/шт.)';
                break;	
			case 'Total' :
				$translated_text = 'Итого';
                break;
			case 'Subtotal' :
				$translated_text = 'Товаров на сумму';
                break;
			case 'Your order' :
				$translated_text = 'Ваш заказ:';
                break;
			case 'Upload Files' :
				$translated_text = 'Загрузить';
                break;
			case 'Billing address' :
				$translated_text = 'Данные для оплаты';
                break;
			case 'Shipping address' :
				$translated_text = 'Данные доставки';
                break;	
			case 'Addresses' :
				$translated_text = 'Данные покупателя';
                break;				
			case 'The following addresses will be used on the checkout page by default.' :
				$translated_text = 'Следующие данные будут использованы при оформлении заказов по-умолчанию.';
                break;		
			case 'Hello %1$s (not %1$s? <a href="%2$s">Log out</a>)':
				$translated_text = 'Привет %1$s (не %1$s? <a href="%2$s">Выйти</a>)';
                break;	
			case 'Save address' :
				$translated_text = 'Сохранить';
                break;
			case 'Additional Details' :
				$translated_text = 'Дополнительные сведения';
                break;	
			case 'Additional information' :
				$translated_text = 'Характеристики';
                break;				
			case 'Order Uploaded Files' :
				$translated_text = 'Прикрепленные к заказу файлы';
                break;
			case 'No products added to wishlist.' :
				$translated_text = 'Список избранного пуст.';
                break;				
				
				
		}
	if (is_checkout()){
		switch ( $text ) {
			case 'Zoom' :
				$translated_text = 'Увеличить';
                break;
			case 'Edit' :
				$translated_text = 'Редактировать';
                break;
			case 'Delete' :
				$translated_text = 'Удалить';
                break;
		}
	}

    return $translated_text;
}
function get_up_parent_term($term_id,$tax_name,$result='name'){

while( $parent_id = wp_get_term_taxonomy_parent_id( $term_id, $tax_name ) ){
	$term_id = $parent_id;
}

if( $term_id == $parent_id ){
	return '';
} else { 
	$term=get_term_by('id',$term_id,'product_brand');
	if ($result=='id'){
		return $term->term_id;
	} else {
		return $term->name;
	}

}
}
/*function wpcf7_do_something ($WPCF7_ContactForm) {
	$submission = WPCF7_Submission::get_instance();
	if($submission) {
		$posted_data = $submission->get_posted_data();
		$client_email = $posted_data['your-email'];
		$WPCF7_ContactForm->mail['sender']=$client_email;
	}
	return $WPCF7_ContactForm;
}*/
//add_action("wpcf7_before_send_mail", "wpcf7_do_something");
function set_correct_sender_email($components, $form, $object) {
  if ($form->id() == 100){
	  $submission = WPCF7_Submission::get_instance();
	  if($submission) {
			$posted_data = $submission->get_posted_data();
			if ($posted_data) {
			  $sender_email=$posted_data['your-email'];
				if ($sender_email) {
				  // Set the sender
				  $components['sender'] = $sender_email;
				}
			}
	  }
  }
  // Return the modified array (not sure if needed)
  return $components;
}
add_filter('wpcf7_mail_components', 'set_correct_sender_email', 10, 3);
/*add_action( 'wp_ajax_float_compare_button','elk_float_compare_button' );
add_action( 'wp_ajax_nopriv_float_compare_button', 'elk_float_compare_button' );
function elk_float_compare_button(){ 
	ob_start();?>
				<?php if (function_exists('tm_woocompare_get_list')) { ?>
					<div class="num"><?php echo count(tm_woocompare_get_list()); ?></div>
				<?php } ?>
	<?php 
	$html=ob_get_clean();
	echo $html;
	wp_die();
}*/
/*add_action( 'wp_ajax_float_wishlist_button','elk_float_wishlist_button' );
add_action( 'wp_ajax_nopriv_float_wishlist_button', 'elk_float_wishlist_button' );
function elk_float_wishlist_button(){ 
	ob_start();?>
				<?php if (function_exists('tm_woowishlist_get_list')) { ?>
					<div class="num"><?php echo count(tm_woowishlist_get_list()); ?></div>
				<?php } ?>
	<?php 
	$html=ob_get_clean();
	echo $html;
	wp_die();
}*/
