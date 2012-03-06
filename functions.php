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

	$bootstrapLess =  $parser->parseFile(__DIR__."/bootstrap/less/bootstrap.less")->getCss();
	$responsiveLess =  $parser->parseFile(__DIR__."/bootstrap/less/responsive.less")->getCss();

	//time to save to file
	$bootstrapHandle = @fopen(dirname(__FILE__)."/cache/bootstrap.css", "w");
	$responsiveHandle = @fopen(dirname(__FILE__)."/cache/responsive.css", "w");
	if(!$bootstrapHandle || !$responsiveHandle) {
		header("Location: {$_SERVER['PHP_SELF']}?page=wordstrap-options&tab=stylesheet&error=401");
		exit;
	}

	$bootstrapWritten = fwrite($bootstrapHandle, $bootstrapLess);
	$responsiveWritten = fwrite($responsiveHandle, $responsiveLess);

	if(!$bootstrapWritten || !$responsiveWritten) {
		header("Location: {$_SERVER['PHP_SELF']}?page=wordstrap-options&tab=stylesheet&error=402");
		exit;	
	}

	fclose($bootstrapHandle);
	fclose($responsiveHandle);

	header("Location: {$_SERVER['PHP_SELF']}?page=wordstrap-options&tab=stylesheet&settings-updated=true");
	exit;	
	
}
