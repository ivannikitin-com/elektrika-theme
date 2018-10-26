<?php
/**
 * The template for displaying all pages
 *
 * Template Name: FAQ
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
				the_title( '<h1>', '</h1>' );
				if( have_rows('question-answer') ): ?>
						<div class="faq panel-group" id="accordion" role="tablist" aria-multiselectable="true">
						<?php // loop through the rows of data
						$number=0;
						while ( have_rows('question-answer') ) : the_row(); 
						$question = get_sub_field('question');
						$answer = get_sub_field('answer');
						?>
							<div class="panel">
								<div class="panel-heading" role="tab" id="heading_<?php echo $number; ?>">
									<div class="panel-title">
										<a <?php echo (!$number)?'class=""': 'class="collapsed"'; ?> role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_<?php echo $number; ?>" aria-expanded="true" aria-controls="collapse_<?php echo $number; ?>"><?php echo wp_strip_all_tags($question); ?></a>
									</div>
								</div>
								<div id="collapse_<?php echo $number; ?>" class="panel-collapse collapse <?php echo (!$number)? 'in': ''; ?>" role="tabpanel" aria-labelledby="heading_<?php echo $number; ?>">
									<div class="panel-body">
										<p><?php echo $answer; ?></p>
									</div>
								</div>
							</div><!--/.panel-->

						<?php 
						$number=$number+1;
						endwhile; ?>
						</div>
				<?php endif;

			
			endwhile; // End of the loop.
			?>
					</main>
				</div><!--/.row-->



<?php

get_footer();
