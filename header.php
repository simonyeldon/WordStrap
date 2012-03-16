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

		<script src="<?php bloginfo('template_directory'); ?>/js/less/less.js"></script>
		<?php wp_enqueue_script("jquery"); ?>
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

								<?php if($wordstrap_options['menu']['branding']): ?>
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
								<h1 id="site-title"><a href="<?php bloginfo('url'); ?>">
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
