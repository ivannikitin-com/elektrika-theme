<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package elektrika220-380
 */

get_header(); ?>
           
                <div class="row">
                	<div class="col-md-3 col-sm-4">
					<?php get_sidebar(); ?>
                	</div>
					<main id="main" class="site-main col-md-9 col-sm-8" role="main">                                   
                        
                        <!-- Слайдер -->
						<?php echo do_shortcode('[rev_slider alias="main"]'); ?>
                        
                        <!-- Search-->
						<?php include (TEMPLATEPATH . '/searchform.php'); ?>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="h2">Популярные категории товаров</div>
                                    <div class="section_products clearfix">
									<?php $popular_cats=get_field('popular_cats'); 
									if ($popular_cats) {
										echo $popular_cats;
									} ?>
                                    </div>
									
									<!-- Акции -->
									<a href="#" class="action_bann clearfix">
										<?php if( get_field('action_banner_img') ): ?>
											<div class="col-img">
												<img src="<?php the_field('action_banner_img'); ?>" alt="" class="img-responsive" />
											</div><!--/.col-img-->
										<?php endif; ?>
										<?php if( get_field('action_text') ): ?>
											<div class="col-txt">
												<div class="action-txt"><?php the_field('action_text');?></div>
											</div><!--/.col-txt-->
										<?php endif; ?>
									</a><!--/.action_bann-->
                             </div><!-- /конец колонки -->                               
                             <div class="woocommerce col-md-4">
										<?php $args=array(
											'post_type'=>'product',
											'posts_per_page'=>3,
											'product_tag'=>'hit',
										);
										$products=new WP_query( $args );
										$class[]='owl-carousel';
										$class[]='products';
										$class[]='full-layout';
										?>
										<?php if ( $products->have_posts() ) { ?>
										<div id="bestsellers">
                                        <div class="h2">Хиты продаж</div>
										
										<?php //woocommerce_product_loop_start(); ?>
										<div class="<?php echo esc_attr( implode(' ', $class) );?>">
													
														<?php while ( $products->have_posts() ) : $products->the_post(); ?>
														
															<?php wc_get_template_part( 'content', 'product' ); ?>
														
														<?php endwhile; // end of the loop. ?>
														<?php wp_reset_postdata(); ?>	
										</div>
										<?php //woocommerce_product_loop_end(); ?>
										<?php } ?>
                                            <a href="<?php echo get_tag_link(16); ?>" class="all">Посмотреть все</a>
                                    </div><!--/#bestsellers-->
                            </div><!--/.конец колонки-->                                   
                        </div><!--/.row-->
                            
                        <div class="row">
                            	<div class="col-md-4 col-md-push-8">
									<?php elk_brands_list(); ?>
                                </div><!--/.конец колонки-->
                                
                            	<div class="col-md-8 col-md-pull-4">
								<?php while ( have_posts() ) : the_post(); ?>
								<article class="txt clearfix clear">
									<h1><?php the_title(); ?></h1>
									<?php the_content(); ?>
								</article>
								<?php endwhile; ?>
								<?php /*Отзывы отключены по пожеланию Заказчика*/
								//elk_testimonials_anounce(); ?>
                                </div><!--/.конец колонки-->
                                
                    	</div><!--/.row-->
                                          
					</main><!--/#main-->
                
                </div><!--/.row-->

<?php
get_footer();
