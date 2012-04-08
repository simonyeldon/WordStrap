<?php 

/**
 * scripts.php
 * This file handles the javascript files for Wordstrap
 */

function wordstrap_enqueue_scripts() {
	wp_register_script("bootstrap-transition", get_template_directory_uri()."/lib/bootstrap/js/bootstrap-transition.js", array(), false, true);
	wp_register_script("bootstrap-alert", get_template_directory_uri()."/lib/bootstrap/js/bootstrap-alert.js", array(), false, true);
	wp_register_script("bootstrap-modal", get_template_directory_uri()."/lib/bootstrap/js/bootstrap-modal.js", array(), false, true);
	wp_register_script("bootstrap-dropdown", get_template_directory_uri()."/lib/bootstrap/js/bootstrap-dropdown.js", array(), false, true);
	wp_register_script("bootstrap-scrollspy", get_template_directory_uri()."/lib/bootstrap/js/bootstrap-scrollspy.js", array(), false, true);
	wp_register_script("bootstrap-tab", get_template_directory_uri()."/lib/bootstrap/js/bootstrap-tab.js", array(), false, true);
	wp_register_script("bootstrap-tooltip", get_template_directory_uri()."/lib/bootstrap/js/bootstrap-tooltip.js", array(), false, true);
	wp_register_script("bootstrap-popover", get_template_directory_uri()."/lib/bootstrap/js/bootstrap-popover.js", array("bootstrap-tooltip"), false, true);
	wp_register_script("bootstrap-button", get_template_directory_uri()."/lib/bootstrap/js/bootstrap-button.js", array(), false, true);
	wp_register_script("bootstrap-collapse", get_template_directory_uri()."/lib/bootstrap/js/bootstrap-collapse.js", array(), false, true);
	wp_register_script("bootstrap-carousel", get_template_directory_uri()."/lib/bootstrap/js/bootstrap-carousel.js", array(), false, true);
	wp_register_script("bootstrap-typeahead", get_template_directory_uri()."/lib/bootstrap/js/bootstrap-typeahead.js", array(), false, true);

	$wordstrap_options = get_option("theme_wordstrap_options");

	wp_enqueue_script("jquery");

	if ($wordstrap_options['js']['transition']) {
		wp_enqueue_script("bootstrap-transition");
	}

	if ($wordstrap_options['js']['alert']) {
		wp_enqueue_script("bootstrap-alert");
	}

	if ($wordstrap_options['js']['modal']) {
		wp_enqueue_script("bootstrap-modal");
	}

	if ($wordstrap_options['js']['dropdown'] || $wordstrap_options['menu']['depth']) {
		wp_enqueue_script("bootstrap-dropdown");
	}

	if ($wordstrap_options['js']['scrollspy']) {
		wp_enqueue_script("bootstrap-scrollspy");
	}

	if ($wordstrap_options['js']['tab']) {
		wp_enqueue_script("bootstrap-tab");
	}

	if ($wordstrap_options['js']['tooltip']) {
		wp_enqueue_script("bootstrap-tooltip");
	}

	if ($wordstrap_options['js']['popover']) {
		wp_enqueue_script("bootstrap-popover");
	}

	if ($wordstrap_options['js']['button']) {
		wp_enqueue_script("bootstrap-button");
	}

	if ($wordstrap_options['js']['collapse'] || $wordstrap_options['responsive']) {
		wp_enqueue_script("bootstrap-collapse");
	}

	if ($wordstrap_options['js']['carousel']) {
		wp_enqueue_script("bootstrap-carousel");
	}

	if ($wordstrap_options['js']['typeahead']) {
		wp_enqueue_script("bootstrap-typeahead");
	}

}
add_action("wp_enqueue_scripts", "wordstrap_enqueue_scripts");
