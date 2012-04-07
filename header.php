<?php $wordstrap_options = get_option( 'theme_wordstrap_options' ); ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">

		<title><?php wp_title('|', true, 'right'); bloginfo('blog_title'); ?></title>

		<!-- HTML5 shim, for IE6-8 support of HTML elements -->
		<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/lib/bootstrap/css/bootstrap.css">
		<?php if($wordstrap_options['responsive']): ?>
		<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/lib/bootstrap/css/responsive.css">
		<?php endif; ?>
		<link rel="stylesheet/less" href="<?php bloginfo('template_directory'); ?>/less/style.less">
		<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>">

		<?php wp_enqueue_script("jquery"); ?>
		<?php if( ( is_single() || is_page() ) && has_post_thumbnail() ): ?>
			<?php 
				$thumbnail = array( 
					"xlarge" => wp_get_attachment_image_src( get_post_thumbnail_id(), array(1170, 9999)),
					"large" => wp_get_attachment_image_src( get_post_thumbnail_id(), array(852, 9999)),
					"medium" => wp_get_attachment_image_src( get_post_thumbnail_id(), array(724, 9999)),
					"small" => wp_get_attachment_image_src( get_post_thumbnail_id(), array(440, 9999)),
					"normal" => wp_get_attachment_image_src( get_post_thumbnail_id(), array(852, 9999)),
				);
			?>
			<style>
				.wordstrap-featured-image {
					background-image: url(<?php echo $thumbnail['normal'][0]; ?>);
				}
				<?php if($wordstrap_options['responsive']): ?>
				@media (max-width: 480px) {
					.wordstrap-featured-image {
						background-image: url(<?php echo $thumbnail['small'][0]; ?>);
					}
				}
				@media (max-width: 767px) {
					.wordstrap-featured-image {
						background-image: url(<?php echo $thumbnail['medium'][0]; ?>);
					}
				}
				@media (max-width: 979px) and (min-width: 768px) {
					.wordstrap-featured-image {
						background-image: url(<?php echo $thumbnail['medium'][0]; ?>);
					}
				}
				@media (min-width: 1200px) {	
					.wordstrap-featured-image {
						background-image: url(<?php echo $thumbnail['xlarge'][0]; ?>);
					}
				}
				<?php endif; ?>
			</style>
		<?php endif; ?>
		<!-- <?php echo $post->ID; ?> -->
		<?php wp_head(); ?>
	</head>

		<body <?php body_class(); ?>>

			<header>

				<?php if ( "fixed" === $wordstrap_options['menu']['type']) :	?>
				<nav id="primary-menu">
					<div class="navbar navbar-fixed-top">
						<div class="navbar-inner">
							<div class="container">
								<?php if($wordstrap_options['responsive']): ?>
								<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
								</a>
								<?php endif; ?>

								<?php if($wordstrap_options['menu']['branding'] || $wordstrap_options['responsive']): ?>
								<a href="<?php bloginfo('url'); ?>" class="brand<?php if(!$wordstrap_options['menu']['branding']) { echo " hidden-desktop"; } ?>"><?php bloginfo('blog_title'); ?></a>
								<?php endif; ?>
								<?php if($wordstrap_options['responsive']): ?>
								<div class="nav-collapse"> 
								<?php endif; ?>
									<?php 
									wp_nav_menu( 
										array(
											'theme_location' => 'primary', 
											'container' => false, 
											'menu_class' => 'nav',
											'depth' => $wordstrap_options['menu']['depth']+1,
											'walker' => new Wordstrap_Menu_Walker()
										) 
									);  
									if($wordstrap_options['menu']['search']) {
										get_search_form();	
									}
									?>
								<?php if($wordstrap_options['responsive']): ?>
								</div> 
								<?php endif; ?>
							</div>
						</div>
					</div>
				</nav>
				<?php endif; ?>

				<div class="container">

					
					<div class="row" id="branding">

						<div class="span12">
							<?php if(!$wordstrap_options['menu']['branding']): ?>
							<hgroup>
								<h1 id="site-title"><a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('blog_title'); ?>">
									<span><?php bloginfo('blog_title'); ?></span>
								</a></h1>
								<p id="site-description">
									<?php bloginfo('description'); ?>
								</p>
							</hgroup>
							<?php endif; ?>
						</div>
			
					</div> <!-- /branding -->

					<?php if ( "static" === $wordstrap_options['menu']['type']) :	?>
					<nav id="primary-menu">
						<div class="navbar navbar-static">
							<div class="navbar-inner">
								<div class="container" style="width:auto;">
								<?php if($wordstrap_options['responsive']): ?>
									<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
										<span class="icon-bar"></span>
										<span class="icon-bar"></span>
										<span class="icon-bar"></span>
									</a>
								<?php endif; ?>
									<?php if( $wordstrap_options['menu']['branding']): ?>
									<a href="<?php bloginfo('url'); ?>" class="brand"><?php bloginfo('blog_title'); ?></a>
									<?php endif; ?>
								<?php if($wordstrap_options['responsive']): ?>
									<div class="nav-collapse">
								<?php endif; ?> 
										<?php 
										wp_nav_menu( 
											array(
												'theme_location' => 'primary', 
												'container' => false, 
												'menu_class' => 'nav',
												'walker' => new Wordstrap_Menu_Walker(),
												'depth' => $wordstrap_options['menu']['depth']
											) 
										);  
										if($wordstrap_options['menu']['search']) {
											get_search_form();	
										}
										?>
								<?php if($wordstrap_options['responsive']): ?>
									</div> 
								<?php endif; ?>
								</div>
							</div>
						</div>
					</nav> 
					<?php endif; ?>

				</div> <!-- /.container -->

			</header>
