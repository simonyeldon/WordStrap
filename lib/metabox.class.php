<?php

class wordstrap_meta_box {

	public function __construct() {
		add_action( "add_meta_boxes", array( &$this, "add" ) );
	}

	public function add() {
		add_meta_box(
			'hero_area_text_meta_box',
			'Hero area text',
			array(&$this, "render_hero_area_text_meta_box"),
			'post',
			'normal',
			'high'
		);
		add_meta_box(
			'hero_area_text_meta_box',
			'Hero area text',
			array(&$this, "render_hero_area_text_meta_box"),
			'page',
			'normal',
			'high'
		);
	} 

	public function render_hero_area_text_meta_box() {
	 // Use nonce for verification
	  wp_nonce_field( plugin_basename( __FILE__ ), 'myplugin_noncename' );

	  // The actual fields for data entry
	  echo '<label for="myplugin_new_field">';
	       _e("Description for this field", 'myplugin_textdomain' );
	  echo '</label> ';
	  echo '<input type="text" id="myplugin_new_field" name="myplugin_new_field" value="whatever" size="25" />';
	}
}
