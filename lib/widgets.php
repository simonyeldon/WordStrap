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
	'before_title' => "<h4>",
	'after_title' => "</h4>",
));
register_sidebar(array(
	'name' => "Footer 2",
	'id' => "wordstrap_footer_widget_area_2",
	'before_widget' => "<div>",
	'after_widget' => "</div>",
	'before_title' => "<h4>",
	'after_title' => "</h4>",
));
register_sidebar(array(
	'name' => "Footer 3",
	'id' => "wordstrap_footer_widget_area_3",
	'before_widget' => "<div>",
	'after_widget' => "</div>",
	'before_title' => "<h4>",
	'after_title' => "</h4>",
));
register_sidebar(array(
	'name' => "Footer 4",
	'id' => "wordstrap_footer_widget_area_4",
	'before_widget' => "<div>",
	'after_widget' => "</div>",
	'before_title' => "<h4>",
	'after_title' => "</h4>",
));

function wordstrap_footer_widgets_span($echo = true) {
	$span = 12;
	$widgets = 0;

	if(is_active_sidebar("wordstrap_footer_widget_area_1")) {
		$widgets++;
	}

	if(is_active_sidebar("wordstrap_footer_widget_area_2")) {
		$widgets++;
	}

	if(is_active_sidebar("wordstrap_footer_widget_area_3")) {
		$widgets++;
	}

	if(is_active_sidebar("wordstrap_footer_widget_area_4")) {
		$widgets++;
	}

	if($widgets > 0) {
		if($echo) {
			echo "span".$span/$widgets;
		} else {
			return "span".$span/$widgets;
		}
	}
	
	return;
}

function wordstrap_footer_widgets($area = 1) {
	if(is_active_sidebar("wordstrap_footer_widget_area_".$area)) : ?>
		<div class="<?php wordstrap_footer_widgets_span(); ?>">
			<?php dynamic_sidebar("wordstrap_footer_widget_area_".$area); ?>
		</div>
	<?php endif; 					
}
