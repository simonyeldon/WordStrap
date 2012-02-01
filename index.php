<?php get_header(); ?>

	<div class="container">

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

	<div class="row">
		<div class="span12">
			<h2><?php the_title(); ?></h2>
		</div>
	</div>
	
	<div class="row">
		<div class="span12">
			<?php the_content(); ?>
		</div>
	</div>

<?php endwhile; else: ?>
	<p><?php _e('Sorry, no results were found.'); ?></p>
<?php endif; ?>

	</div>

<?php get_footer(); ?>
