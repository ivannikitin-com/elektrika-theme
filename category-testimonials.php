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
		<h1><?php single_term_title(); ?></h1>						
		<?php
		if ( have_posts() ) : ?>
				<?php the_archive_description( '<div class="archive-description">', '</div>' ); ?>

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post(); ?>
			
						<?php if ( 'post' === get_post_type()&&is_category('testimonials') ) : ?>
						<div class="entry-content clearfix">
							<div class="comments_item">
								<div><b><?php echo get_the_date(); ?></b></div>
								<div><b><?php the_title(); ?></b></div>
								<div class="text_comm">
									<?php the_content(); ?>
								</div>
							</div><!--/.comments_item-->
						<?php endif; ?>
						</div>

			<?php endwhile;
			wp_pagenavi();
		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

					</main>
				</div><!--/.row-->



<?php

get_footer();
