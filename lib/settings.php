<?php

/**
 * This file handles the management of the theme options
 */

/*
 * Register the options for the theme
 */
function wordstrap_options_init() {
    register_setting('wordstrap_options', 'wordstrap_options', 'wordstrap_options_validate');
}
add_action('admin_init', 'wordstrap_options_init'); 

/*
 * Register the page in the menu
 */
function wordstrap_options_add_page() {
    add_theme_page('WordStrap Theme Options', 'WordStrap Options', 'edit_theme_options', 'CwS-options', 'wordstrap_options_do_page');
}
add_action('admin_menu', 'wordstrap_options_add_page');

/*
 * Do the form for the WordSreap settings
 */
function wordstrap_options_do_page() {
    ?>
	<p>There are no settings yet</p>
    <?php
}

/*
 * Provide validation for the options input.
 */
function wordstrap_options_validate($input) {

	return $input;
}