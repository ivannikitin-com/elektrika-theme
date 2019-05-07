<?php
/*
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package elektrika220-380
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="author" content="">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<div class="wrapper">
    
    <div class="wrapper_content">	

	<header id="masthead" class="site-header" role="banner">
		<nav class="navbar navbar-default nav_top">
      		<div class="container">
            	<div class="navbar-header">
                	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    	<span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div><!--/.navbar-header-->
            	<div class="row">
                	<div class="col-sm-12 col-md-7 col-lg-6">
						<?php wp_nav_menu( array( 
								'theme_location' => 'Primary',
								'menu' => 'Primary Menu',
								'container' => 'div',
								'container_class' => 'navbar-collapse collapse',
								'container_id' => 'navbar',
								'menu_class' => 'nav navbar-nav',
						)  );?>								
                	</div>				
                    <div class="col-sm-12 col-md-5 col-lg-6 st_1">
                    	<div class="row h_right">                            
                        	<div class="col-xs-6 col-sm-6 col-md-5 col-lg-6"><a href="/my-account/" class="account">Личный кабинет</a></div>
                        	<div class="col-xs-6 col-sm-6 col-md-7 col-lg-6">
                                <div id="mini_cart">
                                	<a href="" class="cart"><span></span><div class="num"><?php echo WC()->cart->get_cart_contents_count(); ?></div></a>
                                    <div class="wrap_cart">
                                    	<span class="total">Товар на сумму <b><?php echo WC()->cart->subtotal; ?></b>&nbsp;<?php echo get_woocommerce_currency_symbol(); ?></span>
                                    	<a href="<?php echo WC()->cart->get_cart_url(); ?>" class="to_cart">Перейти в корзину</a>
                                    </div><!--/.wrap_cart-->
                                </div><!--/#mini_cart-->
                            </div>
                        </div><!--/.row-->
                	</div>
                </div><!--/.row-->
        	</div><!--/.container-->
		</nav>
			
            <!-- HEADER_MIDDLE-->
            <div id="header_middle">
            	<div class="container">
                	<div class="row display-table">
                        <div class="col-xs-6 col-md-3 column_h">
                            <div class="logo_h">
                            	<?php if (!is_front_page()) { ?>
								<a class="logo" href="/" title="На Главную"><img src="<?php echo get_theme_mod('logo_header', ''); ?>" class="img-responsive"></a>
								<?php } else { ?>
                                <!-- Для Главной страницы -->
                                <span class="logo"><img src="<?php echo get_theme_mod('logo_header', ''); ?>" class="img-responsive" alt="logo"></span>
								<?php } ?>
                            </div><!--/.logo_h-->
                        </div>
                        
                        <div class="col-xs-6 col-md-3 column_h">
                        	<div class="media">
                                <div class="media-left">
                                    <span class="media-object icon_tel"></span>
                                </div>
                                <div class="media-body">
                               		<a href="tel:<?php echo phone_clean(get_theme_mod('phone',''));?>" class="title_h_m"><?php echo get_theme_mod('phone',''); ?></a>
                                    <span class="text-uppercase sub_title_h_m"><?php echo get_theme_mod('work_hours',''); ?></span>
                               		<a href="#backcall" title="Заказать звонок" class="action" data-toggle="modal" >Заказать звонок</a>
                               	</div>
                    		</div><!--/.media-->
                        </div>
                        
                        <div class="col-xs-6 col-md-3 column_h">
                        	<div class="media">
                                <div class="media-left">
                                    <span class="media-object icon_order"></span>
                                </div>
                                <div class="media-body">
                               		<span class="title_h_m"><?php echo get_theme_mod('middle_text_1',''); ?></span>
                                    <span class="text-uppercase sub_title_h_"><?php echo get_theme_mod('middle_text_2',''); ?></span>
                               		<a href="#product-list" title="Отправьте смету" class="action" data-toggle="modal" >Отправьте смету</a>
                               	</div>
                    		</div><!--/.media-->
                        </div>
                        <div class="col-xs-6 col-md-3 column_h">
                        	<div class="media">
                                <div class="media-left">
                                    <span class="media-object icon_review"></span>
                                </div>
                                <div class="media-body">
                               		<span class="title_h_m">Отзывы клиентов</span>
                                    <span class="text-uppercase sub_title_h_">Нам доверяют</span>
                               		<a href="<?php echo get_term_link('testimonials', 'category');?>" title="Отзывы клиентов" class="action">Показать</a>
                               	</div>
                    		</div><!--/.media-->
                        </div>
                        
                    </div><!--/.row-->
					  
						<div id="backcall" class="modal fade">
							<div class="modal-dialog modal-sm">
							<div class="modal-content">
							<div class="modal-header">Мы перезвоним Вам!<button class="close" type="button" data-dismiss="modal">×</button>
							</div>
							<div class="modal-body"><?php echo do_shortcode('[contact-form-7 id="86" title="Обратный звонок"]'); ?></div>
							</div>
							</div>
						</div>
                        <div id="product-list" class="modal fade">
							<div class="modal-dialog modal-sm">
							<div class="modal-content">
							<div class="modal-header">Отправить смету<button class="close" type="button" data-dismiss="modal">×</button>
							</div>
							<div class="modal-body"><?php echo do_shortcode('[contact-form-7 id="93" title="Отправить смету"]'); ?></div>
							</div>
							</div>
						</div>
						
            	</div><!--/.container-->
            </div><!--/#header_middle-->
            
            <!-- HEADER_BOTTOM-->
        	<!-- Fixed navbar -->
            <div id="header_bott" class="clearfix">
            	<nav class="navbar navbar-default">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar_main" aria-expanded="false" aria-controls="navbar">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        
                    </div>
					<?php wp_nav_menu( array( 
								'theme_location' => 'Secondary',
								'menu' => 'Secondary Menu',
								'container' => 'div',
								'container_class' => 'navbar-collapse collapse',
								'container_id' => 'navbar_main',
								'menu_class' => 'nav navbar-nav',
					)  );?>					
                </div><!--/.container-->
            </nav>
            </div>
            
            <!-- Fixed navbar -->
            
        </header>	

	<div id="content" class="site-content clearfix">
		<div class="container">
		<?php if (is_page()|| is_product()) {
		$banner_text=get_field('banner_text');
		}
		if (is_shop()) {
			$banner_text=get_field('banner_text',12);
		}
		if (is_tax( 'product_cat' )) {
				$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
				$banner_text=get_field('banner_text','product_cat_'.$term->term_id); 
		}
		if (is_category()) {
				//$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
				$term=get_queried_object();
				$banner_text=get_field('banner_text','category_'.$term->term_id); 
		}
		
		if (isset($banner_text)&&$banner_text)  { ?>
            <!-- Текстовый баннер -->   
            <div class="info_txt">    
            	<div class="ffrc"><?php echo $banner_text; ?></div>
            </div><!--/.info_txt-->
		<?php }?>