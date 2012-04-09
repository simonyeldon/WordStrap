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
		wp_enqueue_script("farbtastic");
		wp_enqueue_style("farbtastic");
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
			$safe = wp_kses( $_POST['wordstrap_hero_area_text'], $allowed );
			if( !update_post_meta( $post_id, 'wordstrap_hero_area_text', $safe) ) {
				add_post_meta( $post_id, 'wordstrap_hero_area_text', $safe, true );
			}
		}
	}

	public function render_hero_area_text_meta_box($post) {
		// Use nonce for verification
		wp_nonce_field( 'wordstrap_hero_area_text_nonce', 'wordstrap_hero_area_text_nonce' );

		//load the post meta
		$values = get_post_custom($post->ID);

		//colour field
		?>
		<div class="colourpicker">
			<div class="colour"></div>
			<input name="wordstrap_hero_area_colour" id="wordstrap_hero_area_colour" placeholder="Colour" value="<?php echo $values["wordstrap_hero_area_colour"][0]; ?>" />
		</div>

		<?php

		$tinyMCE_settings = array(
			"teeny" => true,
			"media_buttons" => false,
			"wpautop" => true,
			"textarea_rows" => 5,
			"quicktags" => array(
				"buttons" => "em,strong,link"
			),
			"tinymce" => false
		);
		wp_editor( $value, "wordstrap_hero_area_text", $tinyMCE_settings );
	}
}
