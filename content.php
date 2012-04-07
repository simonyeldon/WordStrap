<div class="row">

	<article >
	
		<header>
			<div class="<?php wordstrap_main_content_span(); ?>">
				<h2><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
				<p>
					<!-- 
						show the author, date and comment count 
						@todo factor out into function
					-->
					<div class="btn-group">
						<a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>" title="<?php the_author_meta('display_name'); ?>" class="btn btn-small" rel="author"><i class="icon-user"></i> <?php the_author_meta('display_name'); ?></a>
						<a class="btn btn-small"><i class="icon-time"></i> <?php the_date(); ?></a>
						<a href="<?php comments_link() ?>" class="btn btn-small"><i class="icon-comment"></i> <?php comments_number("0", "1", "%"); ?></a>
					</div>
				</p>
			</div>
		</header>

		<div class="post-contents <?php wordstrap_main_content_span(); ?>">
			<?php the_content(); ?>
		</div>

		<footer>
			<div class="<?php wordstrap_main_content_span(); ?>">
					
					<!-- 
						@todo factor out into function
					-->
					<!-- show the categories -->
					<p>
					<div class="btn-group">
						<?php $categories = get_the_category(); ?>
						<?php if($categories) : ?>
						<a class="btn btn-small">
							<i class="icon-folder-open"></i> 
							<?php echo (count($categories) > 1 ? __("Categories") : __("Category")); ?>:
						</a>
						<?php foreach($categories as $category) : ?>
						<a class="btn btn-small" href="<?php echo get_category_link($category->term_id); ?>">
							<?php echo $category->cat_name; ?>
						</a>
						<?php endforeach; ?>
						<?php endif; ?>
					</div>
					</p>
		
					<!-- show the tags -->
					<p>
					<div class="btn-group">
						<a class="btn btn-small"><i class="icon-tags"></i> <?php echo __("Tags"); ?>:</a>
						<?php if(get_the_tags()): foreach(get_the_tags() as $tag) :?>
						<a class="btn btn-small" href="<?php echo get_tag_link($tag->term_id); ?>"><?php echo $tag->name; ?></a>
						<?php endforeach; else : ?>
						<a class="btn disabled"><?php echo __("no tags"); ?></a>
						<?php endif; ?>
					</div>
					</p>
			</div>
		</footer>

	</article>
</div>
