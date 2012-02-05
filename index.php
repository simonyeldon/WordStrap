<?php get_header(); ?>

	<div class="container">
	

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	
	<?php 
	if( is_page() ) {
		get_template_part( 'content', 'page' );
	} elseif ( is_single() ) {
		get_template_part( 'content', 'single' );
	} else {
		get_template_part( 'content' );
	} 
	?>

<?php endwhile; else: ?>
	<p><?php _e('Sorry, no results were found.'); ?></p>
<?php endif; ?>


		<div class="span12">
			<ul class="pager">
				<li class="previous"><?php next_posts_link("&larr; Older"); ?></li>
				<li class="next"><?php previous_posts_link("Newer &rarr;"); ?></li>
			</ul>
		</div>

	</div> <!-- /.container -->

<?php get_footer(); ?>
