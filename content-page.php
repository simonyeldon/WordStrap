<?php if( has_post_thumbnail() ): ?>
<div class="hero-unit">
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
