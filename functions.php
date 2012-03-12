<?php
require_once "lib/walker.class.php";
require_once "lib/settings.php";

function wordstrap_register_menus() {
	register_nav_menus(
		array(
			'primary' => __( 'Primary menu')
		)
	);
}
add_action( 'init', 'wordstrap_register_menus' );

function wordstrap_after_setup_theme() {
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'hero-unit-xlarge', 1170, 9999 );
	add_image_size( 'hero-unit-large', 940, 9999 );
	add_image_size( 'hero-unit-medium', 724, 9999 );
	add_image_size( 'hero-unit-small', 360, 9999 );
}
add_action( 'after_setup_theme', 'wordstrap_after_setup_theme' );

function wordstrap_body_classes( $classes ) {
	global $wp_query;

	$wordstrap_options = get_option( 'theme_wordstrap_options' );

	if( is_page() ) {
		$classes[] = "page-slug-{$wp_query->post->post_name}";
	}

	if( "fixed" === $wordstrap_options['menu']['type'] ) {
		$classes[] = "fixed-nav-bar";
	}

	return $classes;
}
add_filter( 'body_class', 'wordstrap_body_classes' );

function wordstrap_compile_stylesheets() {
	$lessLibraryPath = __DIR__."/lib/less.php/lib/";
	
	// Register an autoload function
	spl_autoload_register(function($className) use ($lessLibraryPath) {
	    $fileName = $lessLibraryPath.str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';
	    if (file_exists($fileName)) {
		require_once $fileName;
	    }
	});
	//require_once "lib/less.php/lib/Less/Parser.php";
	//require_once "lib/less.php/lib/Less/Environment.php";
	
	$parser = new \Less\Parser();
	$parser->getEnvironment()->setCompress(false);

	//parse the variables from the database.
	$bootstrap_options = "";
	$wordstrap_options = get_option("theme_wordstrap_options");
	foreach($wordstrap_options['bootstrap'] as $key => $value) {
		$bootstrap_options .= "@{$key}: {$value}; ";
	}

	$parser->parse($bootstrap_options);

	$bootstrapLess =  $parser->parseFile(__DIR__."/lib/bootstrap/less/bootstrap.less", true);
	$responsiveLess =  $parser->parseFile(__DIR__."/lib/bootstrap/less/responsive.less", true);

	//parse the variables from the database.
	$wordstrap_options = get_option("theme_wordstrap_options");
	foreach($wordstrap_options['bootstrap'] as $key => $value) {
		//$bootstrapLess->parse("@{$key}: {$value};");
		//$responsiveLess->parse("@{$key}: {$value};");
	}

	$bootstrapCss = $bootstrapLess->getCss();
	$responsiveCss = $responsiveLess->getCss();

	//time to save to file
	$bootstrapHandle = @fopen(dirname(__FILE__)."/cache/bootstrap.css", "w");
	$responsiveHandle = @fopen(dirname(__FILE__)."/cache/responsive.css", "w");
	if(!$bootstrapHandle || !$responsiveHandle) {
		header("Location: {$_SERVER['PHP_SELF']}?page=wordstrap-options&tab=stylesheet&error=401");
		exit;
	}

	$bootstrapWritten = fwrite($bootstrapHandle, $bootstrapCss);
	$responsiveWritten = fwrite($responsiveHandle, $responsiveCss);

	if(!$bootstrapWritten || !$responsiveWritten) {
		header("Location: {$_SERVER['PHP_SELF']}?page=wordstrap-options&tab=stylesheet&error=402");
		exit;	
	}

	fclose($bootstrapHandle);
	fclose($responsiveHandle);

	header("Location: {$_SERVER['PHP_SELF']}?page=wordstrap-options&tab=stylesheet&settings-updated=true");
	exit;	
	
}
