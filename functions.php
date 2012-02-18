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
