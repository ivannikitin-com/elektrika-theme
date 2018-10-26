<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package elektrika220-380
 */

?>
			</div><!-- /.container -->
			<!-- Кнопки фиксированного меню -->            
            <div class="cart_butt">
				<a id="cart_butt_footer" href="<?php echo WC()->cart->get_cart_url(); ?>" class="butt_cart" title="Перейти в корзину"><span class="glyphicon glyphicon-shopping-cart"></span><div class="num"><?php echo count( WC()->cart->get_cart() ); ?></div>
					<span class="total"><?php echo WC()->cart->subtotal; ?>&nbsp;<?php echo get_woocommerce_currency_symbol(); ?> </span>
				</a>	
				<?php if ( is_user_logged_in() ) { ?>
				<a href="/my-account/" class="butt_login" title="Выйти"><span class="glyphicon glyphicon-log-out"></span></a>
            	<a href="/my-account/" class="butt_reg" title="Личный кабинет"><span class="glyphicon glyphicon-user"></span></a>
				<?php } else { ?>
                <a href="/my-account/" class="butt_login" title="Авторизоваться"><span class="glyphicon glyphicon-log-in"></span></a>
            	<a href="/my-account/" class="butt_reg" title="Зарегистрироваться"><span class="glyphicon glyphicon-user"></span></a>
				<?php } ?>
                <a href="/compare/" class="butt_compare" title="Перейти к сравнению">
					<div class="num"><span class="compare-count"><?php echo (function_exists('tm_woocompare_get_list'))?count( tm_woocompare_get_list()):''; ?></span></div>
				</a>
            	<a href="/wishlist/" class="butt_favor" title="Перейти в избранное">
					<?php 
					$wishlist_count = 0;
					$wishlist_ids = tm_woowishlist_get_list();
					if ($wishlist_ids) {
						$products = tm_woowishlist_get_products($wishlist_ids);
						if ($products) {
							$wishlist_count = $products->post_count;
						}
					}
					?>
					<div class="num"><span class="wishlist-count"><?php echo (function_exists('tm_woocompare_get_list'))?$wishlist_count:''; ?></div>
				</a>
            </div><!--/.cart_butt-->
		</div><!--/#content-->
	</div><!--/.wrapper_content-->
	<footer class="footer">
    <nav class="navbar navbar-default nav_foo">
            <div class="container">
            	<div class="navbar-header">
                	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar_foo" aria-expanded="false" aria-controls="navbar">
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
								'container_id' => 'navbar_foo',
								'menu_class' => 'menu_foo nav navbar-nav',
				)  );?>	
            </div><!--/.ccontainer-->
        </nav><!--/.nav_foo-->
        <div class="foo_bott">
            <div class="container">
                <div class="row display-table">
                    <div class="col-xs-6 col-md-3 column_f">
                        <div class="logo_foo">
                            <?php if (!is_front_page()) { ?>
								<a class="logo" href="/" title="На Главную"><img src="<?php echo get_theme_mod('logo', ''); ?>" class="img-responsive"></a>
								<?php } else { ?>
                                <!-- Для Главной страницы -->
                                <span class="logo"><img src="<?php echo get_theme_mod('logo', ''); ?>" class="img-responsive"></span>
								<?php } ?>
                        </div><!--/.logo_foo-->
                        <?php if ( is_active_sidebar( 'sidebar-footer' ) ) : ?>
						<?php dynamic_sidebar( 'sidebar-footer' ); ?>
						<?php endif; ?>		
                        <a href="/site-map/" class="map_site" title="Карта сайта">Карта сайта</a>
                    </div>      
                
                    <div class="col-xs-6 col-md-3 column_f">
                        <a href="tel:<?php echo phone_clean(get_theme_mod('phone',''));?>" class="tel ffrc"><?php echo get_theme_mod('phone',''); ?></a>
                        <div><a href="mailto:<?php echo get_theme_mod('email',''); ?>" class="mail"><?php echo get_theme_mod('email',''); ?></a></div>
                        <div><a href="skype:<?php echo get_theme_mod('skype',''); ?>" class="skype"><?php echo get_theme_mod('skype',''); ?></a></div>
                        <div><a href="/contacts/" class="map">Карта проезда</a></div>
                    </div>
                    <div class="col-xs-6 col-md-3 contacts column_f">
						<div class="payment">
						<div class="menu_title ffrc">Принимаем к оплате:</div>
                            <img src="<?php echo get_template_directory_uri(); ?>/img/visa.jpg">
                            <img src="<?php echo get_template_directory_uri(); ?>/img/mastercard.jpg">
                        </div>
                        <div class="socials text-center">
                            <a href="<?php echo get_theme_mod('twitter',''); ?>" class="tw" title="Мы в Twitter"></a>
                            <a href="<?php echo get_theme_mod('vk',''); ?>" class="vk" title="Мы в Вконтакте"></a>
                            <a href="<?php echo get_theme_mod('facebook',''); ?>" class="fb" title="Мы в Facebook"></a>
                            <a href="<?php echo get_theme_mod('livejournal',''); ?>" class="lj" title="livejournal"></a>
                            <a href="<?php echo get_theme_mod('RSS',''); ?>" class="rss" title="RSS"></a>
                            <a href="<?php echo get_theme_mod('mail',''); ?>" class="mail_s" title="Mail"></a>
                            <a href="<?php echo get_theme_mod('email',''); ?>" class="ok" title="Одноклассники"></a>
                        </div>
                        </div>
                        <div class="col-xs-6 col-md-3 column_f">
                            <div class="menu_title ffrc">Задайте нам вопрос!</div>
                            <?php echo do_shortcode('[contact-form-7 id="100" title="Задайте нам вопрос" html_class="f-form"]'); ?>
                        </div>
				</div><!--/.row-->
			</div><!--/.container-->
        
        </div><!--/.foo_bott-->
	</footer>
</div><!--/.wrapper-->

<?php wp_footer(); ?>

</body>
</html>