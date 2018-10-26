<?php
/**
 * The template for displaying all pages
 *
 * Template Name: Производители
 */

get_header(); ?>

		<?php if (get_theme_mod('header_banner_text','')) { ?>	
            <!-- Текстовый баннер -->   
            <div class="info_txt">    
            	<div class="ffrc"><?php echo get_theme_mod('header_banner_text',''); ?></div>
            </div><!--/.info_txt-->
		<?php } ?>
            
                <div class="row">
				    <div class="col-md-3 col-sm-4">
					<?php get_sidebar(); ?>
					</div>
					<main id="main" class="site-main col-md-9 col-sm-8" role="main">
					    <!-- Search-->
						<?php include (TEMPLATEPATH . '/searchform.php'); ?>
						<!--/ Хлебные крошки -->
                        <?php
						if ( function_exists('yoast_breadcrumb') ) {
						yoast_breadcrumb('
						<p id="breadcrumbs">','</p>
						');
						}
						?> 
			<?php while ( have_posts() ) : the_post(); ?>
			<?php the_title( '<h1>', '</h1>' ); ?>						
			<?php $args = array(
				'taxonomy' =>  'product_brand',
				'hide_empty' => false,
				'parent'       => 0,
			);
			$brands = get_terms( $args );
			if ($brands) { ?>
			<div class="row">
				<?php foreach( $brands as $brand ){ ?>
				<div class="col-md-4 col-sm-6 col-xs-6">
					<div class="thumbnail">
						<div class="brand_img">
						<?php $brand_logo=get_field('brand_logo', 'product_brand_'.$brand->term_id); 
						if ($brand_logo) { ?>
						<a href="<?php echo get_term_link( $brand->term_id, 'product_brand' ); ?>" class="logo_img">
							<?php echo wp_get_attachment_image( $brand_logo, 'medium'); ?>
						</a>
						</div>
						<?php } ?>
						<div class="brand_lnk">
						<a href="<?php echo get_term_link( $brand->term_id, 'product_brand' ); ?>"><?php echo $brand->name; ?></a>
						</div>
					</div>
					
				</div><!-- /.col- -->
				<?php }?>
			</div><!-- /.row -->
			<?php } ?>
			<article class="txt clearfix clear">
			<?php the_content(); ?>
			</article>
			<?php endwhile; ?>

					</main>
				</div><!--/.row-->

<?php

get_footer();
