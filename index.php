<?php get_header(); ?>

	<div class="container">

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

	<?php get_template_part( 'content', get_post_format() ); ?>

<?php endwhile; else: ?>
	<p><?php _e('Sorry, no results were found.'); ?></p>
<?php endif; ?>

	</div>

<?php get_footer(); ?>
