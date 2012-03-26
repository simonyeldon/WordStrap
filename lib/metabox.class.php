<?php

class wordstrap_meta_box {

	public function __construct() {
		add_action( "add_meta_boxes", array( &$this, "add" ) );
		add_action( "save_post", array( &$this, "save" ) );
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

	public function save( $post_id ) {
		// Bail if we're doing an auto save
		if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		//validate nonce
		if( !isset( $_POST['wordstrap_hero_area_text_nonce'] ) || !wp_verify_nonce( $_POST['wordstrap_hero_area_text_nonce'], 'wordstrap_hero_area_text_nonce' ) ) { 
			return;
		}

		//is the current user allowed to save posts?
		if( !current_user_can( 'edit_post' ) ) {
			return;
		}

		$allowed = array(
			'a' => array('href' => array()),
			'p' => array()
		);
		if( isset( $_POST['wordstrap_hero_area_text'] ) ) {
			add_post_meta( $post_id, 'wordstrap_hero_area_text', wp_kses( $_POST['wordstrap_hero_area_text'], $allowed ), true );
		}

		
	}

	public function render_hero_area_text_meta_box($post) {
	 // Use nonce for verification
	  wp_nonce_field( 'wordstrap_hero_area_text_nonce', 'wordstrap_hero_area_text_nonce' );

		//load the post meta
		$value = get_post_meta($post->ID, "wordstrap_hero_area_text", true);

	  // The actual fields for data entry
	  echo '<label for="wordstrap_hero_area_text">';
	  echo '</label> ';
	  echo '<textarea id="wordstrap_hero_area_text" name="wordstrap_hero_area_text">'.$value.'</textarea>';
	}
}
