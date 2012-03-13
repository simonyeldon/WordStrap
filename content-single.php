<?php if( has_post_thumbnail() ): ?>
<?php $thumbnail_path = wp_get_attachment_image_src( get_post_thumbnail_id(), "large"); ?>
<div class="hero-unit wordstrap-featured-image" style="background-image: url(<?php echo $thumbnail_path[0]; ?>);">
	<h1>Hello, world!</h1>
	<p>lakjdlakjhdlakjfh alkjfhadls kjfhdls fksjdhfls kdjfhsldkjfhsdfkl jshfuoywevof weuyvwe ofuyvwe fouwe vf.</p>
</div>
<?php endif; ?>

<article class="row">
	
	<header>
		<div class="span12">
			<h2><?php the_title(); ?></h2> 
			<p><?php echo __("Posted in"); ?> <?php the_category(", "); ?></p>
		</div>
	</header>

	<div class="span12 post-contents">
		<?php the_content(); ?>
	</div>

	<footer>
		<div class="span12">
			<p><?php echo __("Posted by"); ?> <a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>" title="<?php the_author_meta('display_name'); ?>"><?php the_author_meta('display_name'); ?></a></p>
			<p><?php the_tags("Tagged with: "); ?></p>
		</div>
	</footer>
	
</article>
