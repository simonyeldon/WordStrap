<?php get_header(); ?>

	<div class="container">
	
		<div class="row">

		<?php if(is_active_sidebar("wordstrap_sidebar_left")) : ?>	
			<div class="span3">
				<?php dynamic_sidebar("wordstrap_sidebar_left"); ?>
			</div>
		<?php endif; ?>

			<div class="<?php wordstrap_main_content_span(); ?>">
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
		<div class="row">
			<div class="<?php wordstrap_main_content_span(); ?>">
				<ul class="pager">
					<li class="previous"><?php next_posts_link("&larr; Older"); ?></li>
					<li class="next"><?php previous_posts_link("Newer &rarr;"); ?></li>
				</ul>
			</div>
		</div>
			</div> <!-- /main content area -->

		<?php if(is_active_sidebar("wordstrap_sidebar_right")) : ?>	
			<div class="span3">
			<?php dynamic_sidebar("wordstrap_sidebar_right"); ?>
			</div>
		<?php endif; ?>

		</div> <!-- /.row -->
	</div> <!-- /.container -->

<?php get_footer(); ?>
