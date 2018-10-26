<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package elektrika220-380
 */

?>

	<?php the_title( '<h1>', '</h1>' ); ?>

	<div class="entry-content clearfix">
		<?php
			the_content();
		?>
	</div><!-- .entry-content -->
