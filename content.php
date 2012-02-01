<article class="row">
	
	<header>
		<div class="span12">
			<h2><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
			<p><?php echo __("Posted in"); ?> <?php the_category(","); ?></p>
		</div>
	</header>

	<div class="span12 post-contents">
		<?php the_content(); ?>
	</div>

	<footer>
		<div class="span12">
			<p><?php echo __("Posted by"); ?> <a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>" title="<?php the_author_meta('display_name'); ?>"><?php the_author_meta('display_name'); ?></a></p>
		</div>
	</footer>
	
</article>