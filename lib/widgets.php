<?php
/*
 * Widget definitions
 */

register_sidebar(array(
	'name' => "Sidebar left",
	'id' => "wordstrap_sidebar_left",
	'before_widget' => "<div class=\"well\">",
	'after_widget' => "</div>",
	'before_title' => "<h3>",
	'after_title' => "</h3>",
));
register_sidebar(array(
	'name' => "Sidebar right",
	'id' => "wordstrap_sidebar_right",
	'before_widget' => "<div class=\"well\">",
	'after_widget' => "</div>",
	'before_title' => "<h3>",
	'after_title' => "</h3>",
));
register_sidebar(array(
	'name' => "Footer 1",
	'id' => "wordstrap_footer_widget_area_1",
	'before_widget' => "<div>",
	'after_widget' => "</div>",
	'before_title' => "<div>",
	'after_title' => "</div>",
));
register_sidebar(array(
	'name' => "Footer 2",
	'id' => "wordstrap_footer_widget_area_2",
	'before_widget' => "<div>",
	'after_widget' => "</div>",
	'before_title' => "<div>",
	'after_title' => "</div>",
));
register_sidebar(array(
	'name' => "Footer 3",
	'id' => "wordstrap_footer_widget_area_3",
	'before_widget' => "<div>",
	'after_widget' => "</div>",
	'before_title' => "<div>",
	'after_title' => "</div>",
));