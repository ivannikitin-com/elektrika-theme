<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package elektrika220-380
 */

?>

<!--<article id="post-<?php //the_ID(); ?>" <?php //post_class(); ?>>-->
		<?php
		if ( is_single() ) :
			the_title( '<h1>', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;
		?>
	<div class="entry-content clearfix">
		<?php echo get_the_post_thumbnail(null,'post-thumbnail',array('class' => 'alignleft')); ?>
		<?php the_content(); ?>
	</div><!-- .entry-content -->
	<h4 class="share">Поделиться в соцсетях:</h4>
	<?php echo do_shortcode('[addtoany]'); ?>
<!--</article><!-- #post-## -->
