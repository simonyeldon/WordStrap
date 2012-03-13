<?php if( has_post_thumbnail() ): ?>
<?php $thumbnail_path = wp_get_attachment_image_src( get_post_thumbnail_id(), "large"); ?>
<div class="hero-unit wordstrap-featured-image" style="background-image: url(<?php echo $thumbnail_path[0]; ?>);">
	<h1>Hello, world!</h1>
	<p>lakjdlakjhdlakjfh alkjfhadls kjfhdls fksjdhfls kdjfhsldkjfhsdfkl jshfuoywevof weuyvwe ofuyvwe fouwe vf.</p>
</div>
<?php endif; ?>

<article class="row">
	
	<div class="span12">
		<header>
			<h2><?php the_title(); ?></h2>
		</header>
		<div class="post-contents">
			<?php the_content(); ?>
		</div>
	</div>
	
</article>
