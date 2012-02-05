<?php

/*
 * This file handles the management of the theme options
 * The theme makes heavy use of the Settings API, and was written with the help of the Chip Bennet 
 * http://www.chipbennett.net/2011/02/17/incorporating-the-settings-api-in-wordpress-themes/
 */

/*
 * Register the settings with Wordpress.
 * Next, depending on which tab it is, depends on which set of fields we want to register.
 */
function wordstrap_register_settings() {
    global $pagenow;
    register_setting("theme_wordstrap_options", "theme_wordstrap_options", "wordstrap_options_validate");

    if ( 'themes.php' == $pagenow && isset( $_GET['page'] ) && 'wordstrap-options' == $_GET['page'] ) {
         if ( isset ( $_GET['tab'] ) ) {
              $tab = $_GET['tab'];
         } else {
              $tab = 'general';
         }
         switch ( $tab ) {
              case 'general' :
                   wordstrap_register_settings_general();
                   break;
              case 'menu' :
                   wordstrap_register_settings_menu();
                   break;
              case 'javascript' :
                   wordstrap_register_settings_javascript();
                   break;
         }
    }
}
add_action("admin_init", "wordstrap_register_settings");

function wordstrap_js_libs() {
    wp_enqueue_script('tiny_mce');
}
add_action("admin_print_scripts", "wordstrap_js_libs");

/*
 * Register only the general settings
 */
function wordstrap_register_settings_general()
{
    add_settings_section('wordstrap_settings_genearl_footer', "Footer", "wordstrap_settings_general_footer_section_text", "wordstrap");   

    add_settings_field("wordstrap_setting_footer_text", "Footer text", "wordstrap_setting_footer_text", "wordstrap", "wordstrap_settings_genearl_footer");
}

/*
 * Register only the menu settings 
 */
function wordstrap_register_settings_menu()
{
    add_settings_section('wordstrap_settings_menu', "Menu settings", "wordstrap_settings_menu_section_text", "wordstrap");
    
    add_settings_field("wordstrap_setting_menu_position_text", "Menu type", "wordstrap_setting_menu_position_text", "wordstrap", "wordstrap_settings_menu"); 
}

/*
 * Register only the javascript settings 
 */
function wordstrap_register_settings_javascript()
{
    add_settings_section('wordstrap_settings_javascript', "Javascript plugins", "wordstrap_settings_javascript_section_text", "wordstrap");

    foreach (wordstrap_get_settings_javascript_files() as $key => $value) {
        add_settings_field("wordstrap_setting_javascript_text_{$key}", ucfirst($key), "wordstrap_setting_javascript_text", "wordstrap", "wordstrap_settings_javascript", array('javascript_file' => $key)); 
    }
}

/*
 * Introduction text for the general footer section
 */
function wordstrap_settings_general_footer_section_text() { ?>
     <p><?php _e( 'Manage Footer options for the Wordstrap Theme. Refer to the contextual help screen for descriptions and help regarding each theme option.', 'wordstrap' ); ?></p>
<?php }

/*
 * Introduction text for the menu section
 */
function wordstrap_settings_menu_section_text() { ?>
     <p><?php _e( 'Manage Menu options for the Wordstrap Theme. Refer to the contextual help screen for descriptions and help regarding each theme option.', 'wordstrap' ); ?></p>
<?php }

/*
 * Introduction text for the Javascript page
 */
function wordstrap_settings_javascript_section_text() { ?>
    <p><?php _e( 'Choose which javascript plugins that you want to enable' ); ?></p>
<?php }

/*
 * Footer text field
 */
function wordstrap_setting_footer_text() {
    wp_tiny_mce( false , // true makes the editor "teeny"
        array(
            "editor_selector" => "wordstrap_tinymce"
        )
    );
     $wordstrap_options = get_option( 'theme_wordstrap_options' );
     ?>
     <textarea class="wordstrap_tinymce" id="footer_text" name="theme_wordstrap_options[footer_text]" style="width: 100%; height: 100px;"><?php echo $wordstrap_options['footer_text']; ?></textarea>
     <span class="description">Enter the text you wish to appear in the footer of your site</span>
<?php }

/*
 * menu position field
 */
function wordstrap_setting_menu_position_text() {
    $wordstrap_options = get_option( 'theme_wordstrap_options' );
    ?>
    <select name="theme_wordstrap_options[header_nav_position]">
        <option <?php selected( "top" == $wordstrap_options['header_nav_position'] ); ?> value="top">top</option>
        <option <?php selected( "fixed" == $wordstrap_options['header_nav_position'] ); ?> value="fixed">fixed</option>
    </select>
    <span class="description">This allows you to change the location of the main navigation menu.</span>
<?php }

/*
 * javascript field
 */
function wordstrap_setting_javascript_text($args) {
    $wordstrap_options = get_option( 'theme_wordstrap_options' );
    ?>
    <input type="checkbox" value="1" name="theme_wordstrap_options[js][<?php echo $args['javascript_file']; ?>]" <?php checked( 1, $wordstrap_options['js'][$args['javascript_file']] ); ?>>
<?php }

/*
 * Validate the user input
 */
function wordstrap_options_validate($input) {
    $wordstrap_options = get_option("theme_wordstrap_options");
    $valid_input = $wordstrap_options;
    
    $submit_general = (!empty( $input['submit-general'] ) ? true : false );   
    $submit_menu = (!empty( $input['submit-menu'] ) ? true : false );  
    $submit_javascript = (!empty( $input['submit-javascript'] ) ? true : false );
    
    if ($submit_general) {
        $valid_input['footer_text'] = wp_kses_post($input['footer_text']);
    } elseif ($submit_menu) {
        $valid_input['header_nav_position'] = ( "top" === $input['header_nav_position'] ? "top" : "fixed" );
    } elseif ($submit_javascript) {
        foreach ($input['js'] as $file => $value) {
            $valid_input['js'][$file] = ( "1" === $value ? "1" : "0" );
        }
    }
   
    return $valid_input;
}

/*
 * Default settings
 */
function wordstrap_get_default_options() {
    $options = array(
        'header_nav_position' => 'fixed', 
        'header_nav_menu_depth' => 1,
        'footer_text' => "Theme created by Ghosty, styling by Bootsrap",
        'js' => wordstrap_get_settings_javascript_files()
    );
    return $options;
}

/*
 * init the settings in the database
 */
function wordstrap_options_init() {
    global $wordstrap_options;
    $wordstrap_options = get_option('theme_wordstrap_options');
    if ( false === $wordstrap_options ) {
        $wordstrap_options = wordstrap_get_default_options();
    }
    update_option('theme_wordstrap_options', $wordstrap_options);
}
add_action('after_setup_theme', 'wordstrap_options_init', 9);

/*
 * Tab helper
 */
function wordstrap_get_settings_page_tabs() {
    $tabs = array(
        'general' => "General",
        'menu' => "Menu",
        'javascript' => "Javascript"
    );
    return $tabs;
}

/*
 * Javascript helper
 */
function wordstrap_get_settings_javascript_files() {
    $js = array(
        'alert' => 0,
        'button' => 0,
        'carousel' => 0,
        'collapse' => 0,
        'dropdown' => 0,
        'modal' => 0,
        'popover' => 0,
        'scrollspy' => 0,
        'tab' => 0,
        'tooltip' => 0,
        'transition' => 0,
        'typeahead' => 0
    );
    return $js;
}

/*
 * Add to the admin menu interface
 */
function wordstrap_menu_options() {
    add_theme_page("WordStrap Options", "WordStrap Options", 'edit_theme_options', 'wordstrap-options', 'wordstrap_admin_options_page');
}
add_action('admin_menu', 'wordstrap_menu_options');



/*
 * Output the HTML page
 */
function wordstrap_admin_options_page() {
    ?>

<div class="wrap">

<?php wordstrap_admin_options_page_tabs(); ?>

<?php if ( isset( $_GET['settings-updated'] ) ) : ?>
<div class="updated"><p>Theme settings updated successfully.</p></div>
<?php endif; ?>

<form action="options.php" method="post">
<?php
settings_fields('theme_wordstrap_options');
do_settings_sections('wordstrap');

$tab = ( isset( $_GET['tab'] ) ? $_GET['tab'] : 'general' ); ?>

<p><input name="theme_wordstrap_options[submit-<?php echo $tab; ?>]" type="submit" class="button-primary" value="<?php esc_attr_e('Save Settings', 'wordstrap'); ?>" /></p>

</form>

</div>

    <?php    
}

/*
 * Helper to generate the markup for the tabs
 */
function wordstrap_admin_options_page_tabs($current = 'general') {
    if (isset($_GET['tab'])) {
        $current = $_GET['tab'];
    } else {
        $current = 'general';
    }

    $tabs = wordstrap_get_settings_page_tabs();
    $links = array();
    foreach ($tabs as $tab => $name) {
        if ($tab == $current) {
            $links[] = "<a class=\"nav-tab nav-tab-active\" href=\"?page=wordstrap-options&tab={$tab}\">{$name}</a>";
        } else {
            $links[] = "<a class=\"nav-tab\" href=\"?page=wordstrap-options&tab={$tab}\">{$name}</a>";
        }
    }
    echo "<div id=\"icon-themes\" class=\"icon32\"><br /></div>";
    echo "<h2 class=\"nav-tab-wrapper\">";
    foreach ($links as $link) {
        echo $link; 
    }
    echo "</h2>";
}