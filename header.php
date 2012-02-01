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

		<link rel="stylesheet/less" href="<?php bloginfo('template_directory'); ?>/bootstrap/less/bootstrap.less">
		<link rel="stylesheet/less" href="<?php bloginfo('template_directory'); ?>/bootstrap/less/responsive.less">
		<link rel="stylesheet/less" href="<?php bloginfo('template_directory'); ?>/less/style.less">
		<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>">

		<script src="<?php bloginfo('template_directory'); ?>/js/less/less-1.1.5.js"></script>
		<?php wp_enqueue_script("jquery"); ?>
		<?php wp_head(); ?>
	</head>

		<body <?php body_class(); ?>>

			<header>

				<div class="container">

					<div class="row" id="branding">

						<div class="span12">
							<hgroup>
								<h1 id="site-title"><a href="<?php bloginfo('url'); ?>">
									<span><?php bloginfo('blog_title'); ?></span>
								</a></h1>
								<h2 id="site-description">
									<?php bloginfo('description'); ?>
								</h2>
							</hgroup>
						</div>
			
					</div> <!-- /branding -->

					<nav id="primary-menu">
						<div class="navbar navbar-static">
							<div class="navbar-inner">
								<div class="container" style="width:auto;">
									<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
										<span class="icon-bar"></span>
										<span class="icon-bar"></span>
										<span class="icon-bar"></span>
									</a>
									<div class="nav-collapse"> 
										<?php 
										wp_nav_menu( 
											array(
												'theme_location' => 'primary', 
												'container' => false, 
												'menu_class' => 'nav',
												'walker' => new Wordstrap_Menu_Walker()
											) 
										);  
										get_search_form();
										?>
									</div> 
								</div>
							</div>
						</div>
					</nav> 

				</div> <!-- /.container -->

			</header>
