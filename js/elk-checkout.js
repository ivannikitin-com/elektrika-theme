/*jQuery(document).ready(function() {
			  
});*/
jQuery('#checkout_type_field input[name="checkout_type"]:radio').click(function() {
			if (jQuery('#checkout_type_field input[name="checkout_type"]:checked').val() !== 'Стандартный заказ')  {
				
	          	jQuery("div.woocommerce-account-fields").css('display','none');   
				jQuery("div.woocommerce-billing-fields .standart").css('display','none'); 
				jQuery("#order_review_heading").css('display','none');
				jQuery("#order_review").css('display','none');
				jQuery("#shipping_payment_block").css('display','none');	
				jQuery(".woocommerce-additional-fields").css('display','none');	
				
          	}
          	else{
	          	jQuery("div.woocommerce-account-fields").css('display','block');    
				jQuery("div.woocommerce-billing-fields .standart").css('display','block');
				jQuery("#order_review_heading").css('display','block');
				jQuery("#order_review").css('display','block');
				jQuery("#shipping_payment_block	").css('display','block');
				jQuery(".woocommerce-additional-fields").css('display','block');	 				
          	}
});