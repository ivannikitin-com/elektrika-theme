<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package elektrika220-380
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

		<?php
		while ( have_posts() ) : the_post();

			get_template_part( 'template-parts/content', get_post_format() );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

					</main>
				</div><!--/.row-->


<?php
get_footer();
