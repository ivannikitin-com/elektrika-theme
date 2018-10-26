<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package elektrika220-380
 */
?>
                		<aside id="secondary" class="widget-area clearfix">
                            <div class="col_bg">
								<section class="widget">
                                    <h2 class="widget-title title-catalog">Каталог товаров</h2>
									<nav class="navbar" id="navigation-menu" role="navigation">
														<div class="container-menu">
															<div class="navbar-header">
																<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#elk-wc-categories">
																	<span class="sr-only">Открыть навигацию</span>
																	<span class="icon-bar"></span>
																	<span class="icon-bar"></span>
																	<span class="icon-bar"></span>
																</button>
															</div>	
															<div id="elk-wc-categories" class="collapse navbar-collapse">
															<?php 
															if (is_active_sidebar('sidebar-1')){
																dynamic_sidebar('sidebar-1'); 
															}?>
															</div>
															<?php /*wp_nav_menu( array( 
																'theme_location' => 'sidebar-1',
																'menu' => 'Left Menu',
																'container' => 'div',
																'container_class' => 'menu-catalog collapse navbar-collapse',
																'container_id' => 'accordion_menu',
																'menu_class' => 'nav level_1',
																'menu_id' => 'accordion',																
																'walker'  => new Acc_Nav_Walker(),
															)); */?>
														</div>
									</nav>									
								</section>
                            </div><!--/.col_bg-->
                		</aside>