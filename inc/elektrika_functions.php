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
			case 'Invoice' :
				$translated_text = 'Накладная';
                break;
			case 'Reset invoice number yearly' :
				$translated_text = 'Сбрасывать номер накладной ежегодно';
                break;	
			case 'Set invoice number & date' :
				$translated_text = 'Установить номер счета и дату';
                break;
			case 'Display invoice number' :
				$translated_text = 'Отображать номер накладной';
                break;
			case 'Next invoice number (without prefix/suffix etc.)' :
				$translated_text = 'Следующий номер накладной (без префикса/суффикса и т.д.)';
                break;
			case 'Enable invoice number column in the orders list' :
				$translated_text = 'Показывать номер накладной в списке заказов';
                break;				
			case 'Disable automatic creation/attachment when only free products are ordered' :
				$translated_text = 'Отключить автоматическое создание/присоединение накладных при заказе только бесплатных товаров';
                break;				
			case 'Only when an invoice is already created/emailed' :
				$translated_text = 'Только когда накладная уже создана/отправлена по emailв';
                break;
			case 'PDF Invoices' :
				$translated_text = 'PDF Накладные';
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
function num2str($L){ 
global $_1_2, $_1_19, $des, $hang, $namerub, $nametho, $namemil, $namemrd, $kopeek; 

$s=" "; 
$s1=" "; 
$s2=" "; 
$kop=intval( ( $L*100 - intval( $L )*100 )); 
$L=intval($L); 
if($L>=1000000000){ 
$many=0; 
semantic(intval($L / 1000000000),$s1,$many,3); 
$s.=$s1.$namemrd[$many]; 
$L%=1000000000; 
} 

if($L >= 1000000){ 
$many=0; 
semantic(intval($L / 1000000),$s1,$many,2); 
$s.=$s1.$namemil[$many]; 
$L%=1000000; 
if($L==0){ 
$s.="рублей "; 
} 
} 

if($L >= 1000){ 
$many=0; 
semantic(intval($L / 1000),$s1,$many,1); 
$s.=$s1.$nametho[$many]; 
$L%=1000; 
if($L==0){ 
$s.="рублей "; 
} 
} 

if($L != 0){ 
$many=0; 
semantic($L,$s1,$many,0); 
$s.=$s1.$namerub[$many]; 
} 

if($kop > 0){ 
$many=0; 
semantic($kop,$s1,$many,1); 
$s.=$s1.$kopeek[$many]; 
} 
else { 
$s.=" 00 копеек"; 
} 

$s_arr=explode(' ',$s);
if ($s_arr) {
	$s_arr[1] = '<span class = "first_cap">'.$s_arr[1].'</span>';
}
$s = implode(' ',$s_arr);

return mb_ucfirst($s); 
}
function semantic($i,&$words,&$fem,$f){ 
global $_1_2, $_1_19, $des, $hang, $namerub, $nametho, $namemil, $namemrd; 
$words=""; 
$fl=0; 
if($i >= 100){ 
$jkl = intval($i / 100); 
$words.=$hang[$jkl]; 
$i%=100; 
} 
if($i >= 20){ 
$jkl = intval($i / 10); 
$words.=$des[$jkl]; 
$i%=10; 
$fl=1; 
} 
switch($i){ 
case 1: $fem=1; break; 
case 2: 
case 3: 
case 4: $fem=2; break; 
default: $fem=3; break; 
} 
if( $i ){ 
if( $i < 3 && $f > 0 ){ 
if ( $f >= 2 ) { 
$words.=$_1_19[$i]; 
} 
else { 
$words.=$_1_2[$i]; 
} 
} 
else { 
$words.=$_1_19[$i]; 
} 
} 
} 

function mb_ucfirst($word, $charset = "utf-8") {

		return mb_strtoupper(mb_substr($word, 0, 1, $charset), $charset).mb_substr($word, 1, mb_strlen($word, $charset)-1, $charset);

}

$_1_2[1]="одна "; 
$_1_2[2]="две "; 

$_1_19[1]="один "; 
$_1_19[2]="два "; 
$_1_19[3]="три "; 
$_1_19[4]="четыре "; 
$_1_19[5]="пять "; 
$_1_19[6]="шесть "; 
$_1_19[7]="семь "; 
$_1_19[8]="восемь "; 
$_1_19[9]="девять "; 
$_1_19[10]="десять "; 

$_1_19[11]="одиннацать "; 
$_1_19[12]="двенадцать "; 
$_1_19[13]="тринадцать "; 
$_1_19[14]="четырнадцать "; 
$_1_19[15]="пятнадцать "; 
$_1_19[16]="шестнадцать "; 
$_1_19[17]="семнадцать "; 
$_1_19[18]="восемнадцать "; 
$_1_19[19]="девятнадцать "; 

$des[2]="двадцать "; 
$des[3]="тридцать "; 
$des[4]="сорок "; 
$des[5]="пятьдесят "; 
$des[6]="шестьдесят "; 
$des[7]="семьдесят "; 
$des[8]="восемдесят "; 
$des[9]="девяносто "; 

$hang[1]="сто "; 
$hang[2]="двести "; 
$hang[3]="триста "; 
$hang[4]="четыреста "; 
$hang[5]="пятьсот "; 
$hang[6]="шестьсот "; 
$hang[7]="семьсот "; 
$hang[8]="восемьсот "; 
$hang[9]="девятьсот "; 

$namerub[1]="рубль "; 
$namerub[2]="рубля "; 
$namerub[3]="рублей "; 

$nametho[1]="тысяча "; 
$nametho[2]="тысячи "; 
$nametho[3]="тысяч "; 

$namemil[1]="миллион "; 
$namemil[2]="миллиона "; 
$namemil[3]="миллионов "; 

$namemrd[1]="миллиард "; 
$namemrd[2]="миллиарда "; 
$namemrd[3]="миллиардов "; 

$kopeek[1]="копейка "; 
$kopeek[2]="копейки "; 
$kopeek[3]="копеек "; 