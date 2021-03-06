<?php if( has_post_thumbnail() ): ?>
	<header>
	<div class="hero-unit wordstrap-featured-image">
		<h1><?php the_title(); ?></h1>
		<?php echo get_post_meta($post->ID, "wordstrap_hero_area_text", true); ?>
	</div>
	</header>
<?php endif; ?>

<article class="row">
	
	<div class="<?php wordstrap_main_content_span(); ?>">
		<?php if(!has_post_thumbnail()): ?>
			<header>
				<h2><?php the_title(); ?></h2>
			</header>
		<?php endif; ?>
		<div class="post-contents">
			<?php the_content(); ?>
		</div>
	</div>
	
</article>
