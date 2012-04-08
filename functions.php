<?php
require_once "lib/walker.class.php";
require_once "lib/settings.php";
require_once "lib/metabox.class.php";
require_once "lib/widgets.php";
require_once "lib/scripts.php";

function wordstrap_register_menus() {
	register_nav_menus(
		array(
			'primary' => __( 'Primary menu')
		)
	);
}
add_action( 'init', 'wordstrap_register_menus' );

// call the metabox class
function wordstrap_load_meta_boxClass() {
	return new wordstrap_meta_box();
}
if( is_admin() ) {
	add_action( 'load-post.php', 'wordstrap_load_meta_boxClass' );
}

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

function wordstrap_main_content_span($echo = true) {
	$span = 12;
	if(is_active_sidebar("wordstrap_sidebar_left")) {
		$span -= 3;
	}
	if(is_active_sidebar("wordstrap_sidebar_right")) {
		$span -= 3;
	}

	$span = "span".$span;
	
	if($echo) {
		echo $span;
	} else {
		return $echo;
	}
}


function wordstrap_compile_stylesheets() {
	$css_folder = __DIR__."/lib/bootstrap/css";

	//parse the variables from the database.
	$bootstrap_options = "";
	$wordstrap_options = get_option("theme_wordstrap_options");
	
	//open variables file and read it line by line
	$variables_handle = fopen(__DIR__."/lib/bootstrap/less/variables.less", "r+");
	$variables_content = "";
	if($variables_handle) {
		while( ($line = fgets($variables_handle)) !== FALSE ) {
			if(preg_match('/^@([a-zA-Z]+):(.*);/', $line, $matches)) {
				if(array_key_exists($matches[1], $wordstrap_options['bootstrap'])) {
					$variables_content .= "@{$matches[1]}: {$wordstrap_options['bootstrap'][$matches[1]]};".PHP_EOL;
				} else {
					$variables_content .= $line;
				}
			} else {
				$variables_content .= $line;
			}
		}
	} else {
		//unable to find the variables file
		add_settings_error('error', 'settings_updated', __('Unable to locate Bootstrap, please make sure that it is installed properly..'), 'error');
		set_transient('settings_errors', get_settings_errors(), 30);
		wp_redirect("{$_SERVER['PHP_SELF']}?page=wordstrap-options&tab=stylesheet&settings-updated=true");
		exit;
	}
	//write the new variables file
	if( fwrite($variables_handle, $variables_content) === FALSE ) {
		//unable to write file
		add_settings_error('error', 'settings_updated', __('Unable to write to the variables file, please make sure that the filesystem is writeable.'), 'error');
		set_transient('settings_errors', get_settings_errors(), 30);
		wp_redirect("{$_SERVER['PHP_SELF']}?page=wordstrap-options&tab=stylesheet&settings-updated=true");
		exit;
	}

	//does the bootstrap css folder exist, if not create it.
	if( !is_dir($css_folder) && !is_file($css_folder) ) {
		$dir_made = mkdir($css_folder);
		if(!$dir_made) {
			add_settings_error('error', 'settings_updated', __('Unable to create stylesheets folder, please make sure that the filesystem is writeable.'), 'error');
			set_transient('settings_errors', get_settings_errors(), 30);
			wp_redirect("{$_SERVER['PHP_SELF']}?page=wordstrap-options&tab=stylesheet&settings-updated=true");
			exit;
		}
	}

	$lessLibraryPath = __DIR__."/lib/less.php/lib/";
	
	// Register an autoload function
	spl_autoload_register(function($className) use ($lessLibraryPath) {
	    $fileName = $lessLibraryPath.str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';
	    if (file_exists($fileName)) {
		require_once $fileName;
	    }
	});
	
	$bootstrap_parser = new \Less\Parser();
	$bootstrap_parser->getEnvironment()->setCompress(false);

	$responsive_parser = new \Less\Parser();
	$responsive_parser->getEnvironment()->setCompress(false);

	//$parser->parse($bootstrap_options); //Options not working yet

	try {
		$bootstrapLess =  $bootstrap_parser->parseFile(__DIR__."/lib/bootstrap/less/bootstrap.less"); //, true);
		$responsiveLess =  $responsive_parser->parseFile(__DIR__."/lib/bootstrap/less/responsive.less"); //, true);
	} catch (Exception $e) {
		add_settings_error('error', 'settings_updated', __('Unable to parse stylesheets. Message returned was: ').$e->getMessage(), 'error');
		set_transient('settings_errors', get_settings_errors(), 30);
		wp_redirect("{$_SERVER['PHP_SELF']}?page=wordstrap-options&tab=stylesheet&settings-updated=true");
		exit;
	}

	//parse the variables from the database.
	$wordstrap_options = get_option("theme_wordstrap_options");
	foreach($wordstrap_options['bootstrap'] as $key => $value) {
		//$bootstrapLess->parse("@{$key}: {$value};");
		//$responsiveLess->parse("@{$key}: {$value};");
	}

	$bootstrapCss = $bootstrapLess->getCss();
	$responsiveCss = $responsiveLess->getCss();

	//time to save to file
	$bootstrapHandle = @fopen(__DIR__."/lib/bootstrap/css/bootstrap.css", "w");
	$responsiveHandle = @fopen(__DIR__."/lib/bootstrap/css/responsive.css", "w");
	if(!$bootstrapHandle || !$responsiveHandle) {
		add_settings_error('error', 'settings_updated', __('Unable to open stylesheets, please make sure that the files are writeable.'), 'error');
		set_transient('settings_errors', get_settings_errors(), 30);
		wp_redirect("{$_SERVER['PHP_SELF']}?page=wordstrap-options&tab=stylesheet&settings-updated=true");
		exit;
	}

	$bootstrapWritten = fwrite($bootstrapHandle, $bootstrapCss);
	$responsiveWritten = fwrite($responsiveHandle, $responsiveCss);

	if(!$bootstrapWritten || !$responsiveWritten) {
		add_settings_error('error', 'settings_updated', __('Unable to save stylesheets, please make sure that the files are writeable.'), 'error');
		set_transient('settings_errors', get_settings_errors(), 30);
		wp_redirect("{$_SERVER['PHP_SELF']}?page=wordstrap-options&tab=stylesheet&settings-updated=true");
		exit;	
	}

	fclose($bootstrapHandle);
	fclose($responsiveHandle);

	add_settings_error('general', 'settings_updated', __('Stylesheets compiled.'), 'updated');
	set_transient('settings_errors', get_settings_errors(), 30);

	wp_redirect("{$_SERVER['PHP_SELF']}?page=wordstrap-options&tab=stylesheet&settings-updated=true");
	exit;	
	
}
