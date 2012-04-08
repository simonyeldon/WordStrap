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
		case 'stylesheet':
			if(isset($_GET['compile']) && $_GET['compile']) {
				wordstrap_compile_stylesheets();
				exit;
			}
			wordstrap_register_settings_stylesheets();
			break;
         }
    }
}
add_action("admin_init", "wordstrap_register_settings");

function wordstrap_js_libs() {
    wp_enqueue_script('tiny_mce');
    wp_enqueue_script('farbtastic');
    wp_enqueue_style('farbtastic');
}
add_action("admin_print_scripts", "wordstrap_js_libs");

/*
 * Register only the general settings
 */
function wordstrap_register_settings_general()
{
    add_settings_section('wordstrap_settings_genearl_footer', "Footer", "wordstrap_settings_general_footer_section_text", "wordstrap");   

    add_settings_field("wordstrap_setting_footer_text", "Footer text", "wordstrap_setting_footer_text", "wordstrap", "wordstrap_settings_genearl_footer");
    add_settings_field("wordstrap_setting_general_responsive_text", "Responsive layout", "wordstrap_setting_general_responsive_text", "wordstrap", "wordstrap_settings_genearl_footer");
}

/*
 * Register only the menu settings 
 */
function wordstrap_register_settings_menu()
{
    add_settings_section('wordstrap_settings_menu', "Menu settings", "wordstrap_settings_menu_section_text", "wordstrap");
    
    add_settings_field("wordstrap_setting_menu_type_text", "Menu type", "wordstrap_setting_menu_type_text", "wordstrap", "wordstrap_settings_menu"); 
    add_settings_field("wordstrap_setting_menu_branding_text", "Include blog name", "wordstrap_setting_menu_branding_text", "wordstrap", "wordstrap_settings_menu");
    add_settings_field("wordstrap_setting_menu_search_text", "Show search box", "wordstrap_setting_menu_search_text", "wordstrap", "wordstrap_settings_menu");
    add_settings_field("wordstrap_setting_menu_depth_text", "Enable dropdowns", "wordstrap_setting_menu_depth_text", "wordstrap", "wordstrap_settings_menu");
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
 * Register only the stylesheet settings 
 */
function wordstrap_register_settings_stylesheets()
{
	add_settings_section('wordstrap_settings_stylesheets', "Stylesheet settings", "wordstrap_settings_stylesheets_section_text", "wordstrap");

	add_settings_field("wordstrap_setting_stylesheet_compile", "Recompile stylesheet", "wordstrap_setting_stylesheet_compile", "wordstrap", "wordstrap_settings_stylesheets");

	foreach(wordstrap_get_settings_bootstrap_defaults() as $key => $value) {
		add_settings_field("wordstrap_setting_stylesheet_bootstrap_text_{$key}", "@{$key}", "wordstrap_setting_stylesheet_bootstrap_text", "wordstrap", "wordstrap_settings_stylesheets", array('bootstrap_setting' => $key));
		//echo "<p>{$key}: {$value}</p>";
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
 * Introduction text for the Stylesheets page
 */
function wordstrap_settings_stylesheets_section_text() { ?>
    <p><?php _e( 'Here you can change your stylesheet variables and recompile the stylesheets.' ); ?></p>
<?php }
/*=================================*
 * GENERAL TAB FIELDS              *
 *=================================*/

/*
 * navigation bar search box
 */
function wordstrap_setting_general_responsive_text() {
    $wordstrap_options = get_option( 'theme_wordstrap_options' );
    ?>
    <input type="checkbox" value="1" name="theme_wordstrap_options[responsive]" <?php checked( 1, $wordstrap_options['responsive'] ); ?>>
    <span class="description">If checked the theme will include the responvive layout components.</span>
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


/*=================================*
 * MENU TAB FIELDS                 *
 *=================================*/

/*
 * menu type field
 */
function wordstrap_setting_menu_type_text() {
    $wordstrap_options = get_option( 'theme_wordstrap_options' );
    ?>
    <select name="theme_wordstrap_options[menu][type]">
        <option <?php selected( "static" == $wordstrap_options['menu']['type'] ); ?> value="static">static</option>
        <option <?php selected( "fixed" == $wordstrap_options['menu']['type'] ); ?> value="fixed">fixed</option>
    </select>
    <span class="description">This allows you to change the type of the main navigation menu.</span>
<?php }

/*
 * navigation bar branding
 */
function wordstrap_setting_menu_branding_text() {
    $wordstrap_options = get_option( 'theme_wordstrap_options' );
    ?>
    <input type="checkbox" value="1" name="theme_wordstrap_options[menu][branding]" <?php checked( 1, $wordstrap_options['menu']['branding'] ); ?>>
    <span class="description">If checked the blog name will appear inside the navigation bar.</span>
<?php }

/*
 * navigation bar search box
 */
function wordstrap_setting_menu_search_text() {
    $wordstrap_options = get_option( 'theme_wordstrap_options' );
    ?>
    <input type="checkbox" value="1" name="theme_wordstrap_options[menu][search]" <?php checked( 1, $wordstrap_options['menu']['search'] ); ?>>
    <span class="description">If checked a search box will appear inside the navigation bar.</span>
<?php }

/*
 * navigation bar dropdowns
 */
function wordstrap_setting_menu_depth_text() {
    $wordstrap_options = get_option( 'theme_wordstrap_options' );
    ?>
    <input type="checkbox" value="1" name="theme_wordstrap_options[menu][depth]" <?php checked( 1, $wordstrap_options['menu']['depth'] ); ?>>
    <span class="description">Enable dropdowns in the navigation bar.</span>
<?php }



/*=================================*
 * JAVASCRIPT TAB FIELDS           *
 *=================================*/

/*
 * javascript field
 */
function wordstrap_setting_javascript_text($args) {
    $wordstrap_options = get_option( 'theme_wordstrap_options' );
    ?>
    <input type="checkbox" value="1" name="theme_wordstrap_options[js][<?php echo $args['javascript_file']; ?>]" <?php checked( 1, $wordstrap_options['js'][$args['javascript_file']] ); ?>>
<?php }


/*=================================*
 * STYLESHEET TAB FIELDS           *
 *=================================*/
function wordstrap_setting_stylesheet_compile() { ?>

	<a href="<?php echo $_SERVER['REQUEST_URI']; ?>&compile=1">Compile</a>

<?php
}

function wordstrap_setting_stylesheet_bootstrap_text($args) {
    $wordstrap_options = get_option( 'theme_wordstrap_options' );
    if( in_array($args['bootstrap_setting'], wordstrap_get_bootstrap_colour_settings()) ) {
	$colour = true;
    } 
    ?>
    <?php if($colour): ?>
	<div class="bootstrap_colour">
		<div class="colourpicker"></div>
    <?php endif; ?>
    <input type="text" value="<?php echo $wordstrap_options['bootstrap'][$args['bootstrap_setting']]; ?>" name="theme_wordstrap_options[bootstrap][<?php echo $args['bootstrap_setting']; ?>]" >
     <?php if($colour): ?>
	</div>
     <?php endif; ?>
    <?php 
}
/*
 * Validate the user input
 */
function wordstrap_options_valid_hex_color($hex) {
    return preg_match('/^#[a-f0-9]{6}$/i', $hex);
}
function wordstrap_options_validate($input) {
    $wordstrap_options = get_option("theme_wordstrap_options");
    $valid_input = $wordstrap_options;
    
    $submit_general = (!empty( $input['submit-general'] ) ? true : false );   
    $submit_menu = (!empty( $input['submit-menu'] ) ? true : false );  
    $submit_javascript = (!empty( $input['submit-javascript'] ) ? true : false );
    $submit_stylesheet = (!empty( $input['submit-stylesheet'] ) ? true : false );  
    
    if ($submit_general) {
        $valid_input['responsive'] = ( $input['responsive'] ? "1" : "0" );
        $valid_input['footer_text'] = wp_kses_post($input['footer_text']); //allow some HTML
    } elseif ($submit_menu) {
        $valid_input['menu']['type'] = ( "fixed" === $input['menu']['type'] ? "fixed" : "static" );
        $valid_input['menu']['branding'] = ( "1" === $input['menu']['branding'] ? "1" : "0" );
        $valid_input['menu']['search'] = ( $input['menu']['search'] ? "1" : "0" );
        $valid_input['menu']['depth'] = ( $input['menu']['depth'] ? "1" : "0" );
    } elseif ($submit_javascript) {
        $valid_input['js'] = wordstrap_get_settings_javascript_files();
        if( !empty($input['js']) ) {
            foreach ($input['js'] as $file => $value) {
                $valid_input['js'][$file] = ( "1" === $value ? "1" : "0" );
            }
        }
    } elseif($submit_stylesheet) {
        $bootstrap_defaults = wordstrap_get_settings_bootstrap_defaults();
		$valid_input['bootstrap']['linkColor'] =  ( wordstrap_options_valid_hex_color($input['bootstrap']['linkColor']) ? $input['bootstrap']['linkColor'] : $bootstrap_defaults['linkColor'] );
		$valid_input['bootstrap']['linkColorHover']	= ( !empty($input['bootstrap']['linkColorHover']) ? $input['bootstrap']['linkColorHover'] : $bootstrap_defaults['linkColorHover'] );
        $valid_input['bootstrap']['blue'] =  ( wordstrap_options_valid_hex_color($input['bootstrap']['blue']) ? $input['bootstrap']['blue'] : $bootstrap_defaults['blue'] );
        $valid_input['bootstrap']['green'] =  ( wordstrap_options_valid_hex_color($input['bootstrap']['green']) ? $input['bootstrap']['green'] : $bootstrap_defaults['green'] );
        $valid_input['bootstrap']['red'] =  ( wordstrap_options_valid_hex_color($input['bootstrap']['red']) ? $input['bootstrap']['red'] : $bootstrap_defaults['red'] );
        $valid_input['bootstrap']['yellow'] =  ( wordstrap_options_valid_hex_color($input['bootstrap']['yellow']) ? $input['bootstrap']['yellow'] : $bootstrap_defaults['yellow'] );
        $valid_input['bootstrap']['orange'] =  ( wordstrap_options_valid_hex_color($input['bootstrap']['orange']) ? $input['bootstrap']['orange'] : $bootstrap_defaults['orange'] );
        $valid_input['bootstrap']['pink'] =  ( wordstrap_options_valid_hex_color($input['bootstrap']['pink']) ? $input['bootstrap']['pink'] : $bootstrap_defaults['pink'] );
        $valid_input['bootstrap']['purple'] =  ( wordstrap_options_valid_hex_color($input['bootstrap']['purple']) ? $input['bootstrap']['purple'] : $bootstrap_defaults['purple'] );
		$valid_input['bootstrap']['gridColumns'] = ( absint($input['bootstrap']['gridColumns']) ? $input['bootstrap']['gridColumns'] : $bootstrap_defaults['gridColumns'] );
        $valid_input['bootstrap']['gridColumnWidth'] = ( !empty($input['bootstrap']['gridColumnWidth']) ? $input['bootstrap']['gridColumnWidth'] : $bootstrap_defaults['gridColumnWidth'] );
        $valid_input['bootstrap']['gridGutterWidth'] = ( !empty($input['bootstrap']['gridGutterWidth']) ? $input['bootstrap']['gridGutterWidth'] : $bootstrap_defaults['gridGutterWidth'] );
        $valid_input['bootstrap']['fluidGridColumnWidth'] = ( !empty($input['bootstrap']['fluidGridColumnWidth']) ? $input['bootstrap']['fluidGridColumnWidth'] : $bootstrap_defaults['fluidGridColumnWidth'] );
        $valid_input['bootstrap']['fluidGridGutterWidth'] = ( !empty($input['bootstrap']['fluidGridGutterWidth']) ? $input['bootstrap']['fluidGridGutterWidth'] : $bootstrap_defaults['fluidGridGutterWidth'] );
        $valid_input['bootstrap']['baseFontSize'] = ( !empty($input['bootstrap']['baseFontSize']) ? $input['bootstrap']['baseFontSize'] : $bootstrap_defaults['baseFontSize'] );
        $valid_input['bootstrap']['baseFontFamily'] = ( !empty($input['bootstrap']['baseFontFamily']) ? $input['bootstrap']['baseFontFamily'] : $bootstrap_defaults['baseFontFamily'] );
        $valid_input['bootstrap']['baseLineHeight'] = ( !empty($input['bootstrap']['baseLineHeight']) ? $input['bootstrap']['baseLineHeight'] : $bootstrap_defaults['baseLineHeight'] );
        $valid_input['bootstrap']['primaryButtonColor'] = ( !empty($input['bootstrap']['primaryButtonColor']) ? $input['bootstrap']['primaryButtonColor'] : $bootstrap_defaults['primaryButtonColor'] );
        $valid_input['bootstrap']['placeholderText'] = ( !empty($input['bootstrap']['placeholderText']) ? $input['bootstrap']['placeholderText'] : $bootstrap_defaults['placeholderText'] );
        $valid_input['bootstrap']['navbarHeight'] = ( !empty($input['bootstrap']['navbarHeight']) ? $input['bootstrap']['navbarHeight'] : $bootstrap_defaults['navbarHeight'] );
        $valid_input['bootstrap']['navbarBackground'] = ( !empty($input['bootstrap']['navbarBackground']) ? $input['bootstrap']['navbarBackground'] : $bootstrap_defaults['navbarBackground'] );
        $valid_input['bootstrap']['navbarBackgroundHighlight'] = ( !empty($input['bootstrap']['navbarBackgroundHighlight']) ? $input['bootstrap']['navbarBackgroundHighlight'] : $bootstrap_defaults['navbarBackgroundHighlight'] );
        $valid_input['bootstrap']['navbarText'] = ( !empty($input['bootstrap']['navbarText']) ? $input['bootstrap']['navbarText'] : $bootstrap_defaults['navbarText'] );
        $valid_input['bootstrap']['navbarLinkColor'] = ( !empty($input['bootstrap']['navbarLinkColor']) ? $input['bootstrap']['navbarLinkColor'] : $bootstrap_defaults['navbarLinkColor'] );
        $valid_input['bootstrap']['navbarLinkColorHover'] = ( !empty($input['bootstrap']['navbarLinkColorHover']) ? $input['bootstrap']['navbarLinkColorHover'] : $bootstrap_defaults['navbarLinkColorHover'] );
        $valid_input['bootstrap']['warningText'] =  ( wordstrap_options_valid_hex_color($input['bootstrap']['warningText']) ? $input['bootstrap']['warningText'] : $bootstrap_defaults['warningText'] );
        $valid_input['bootstrap']['warningBackground'] =  ( wordstrap_options_valid_hex_color($input['bootstrap']['warningBackground']) ? $input['bootstrap']['warningBackground'] : $bootstrap_defaults['warningBackground'] );
        $valid_input['bootstrap']['errorText'] =  ( wordstrap_options_valid_hex_color($input['bootstrap']['errorText']) ? $input['bootstrap']['errorText'] : $bootstrap_defaults['errorText'] );
        $valid_input['bootstrap']['errorBackground'] =  ( wordstrap_options_valid_hex_color($input['bootstrap']['errorBackground']) ? $input['bootstrap']['errorBackground'] : $bootstrap_defaults['errorBackground'] );
        $valid_input['bootstrap']['successText'] =  ( wordstrap_options_valid_hex_color($input['bootstrap']['successText']) ? $input['bootstrap']['successText'] : $bootstrap_defaults['successText'] );
        $valid_input['bootstrap']['successBackground'] =  ( wordstrap_options_valid_hex_color($input['bootstrap']['successBackground']) ? $input['bootstrap']['successBackground'] : $bootstrap_defaults['successBackground'] );
        $valid_input['bootstrap']['infoText'] =  ( wordstrap_options_valid_hex_color($input['bootstrap']['infoText']) ? $input['bootstrap']['infoText'] : $bootstrap_defaults['infoText'] );
        $valid_input['bootstrap']['infoBackground'] =  ( wordstrap_options_valid_hex_color($input['bootstrap']['infoBackground']) ? $input['bootstrap']['infoBackground'] : $bootstrap_defaults['infoBackground'] );
	}
   
    return $valid_input;
}

/*
 * Default settings
 */
function wordstrap_get_default_options() {
    $options = array(
        'menu' => array(
            'type' => 'static',
            'search' => 1,
            'branding' => 0,
            'location' => 'below',
            'depth' => 1
        ),
        'footer_text' => 'Theme created by <a href="http://ghosty.co.uk">Ghosty</a>, styling by Bootsrap',
        'responsive' => 1,
        'js' => wordstrap_get_settings_javascript_files(),
	'bootstrap' => wordstrap_get_settings_bootstrap_defaults()
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
        'javascript' => "Javascript",
	'stylesheet' => "Stylesheets"
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
 * Bootstrap default helper
 */
function wordstrap_get_settings_bootstrap_defaults() {
	$bootstrap = array(
		'linkColor'	=> "#0088cc",
		'linkColorHover' => "darken(@linkColor, 15%)",
		'blue' => "#049cdb",
		'green' => "#46a546",
		'red' => "#9d261d",
		'yellow' => "#ffc40d",
		'orange' => "#f89406",
		'pink' => "#c3325f",
		'purple' => "#7a43b6",
		'gridColumns' => "12",
		'gridColumnWidth' => "60px",
		'gridGutterWidth' => "12px",
		'fluidGridColumnWidth' => "6.382978723%",
		'fluidGridGutterWidth' => "2.127659574%",
		'baseFontSize' => "13px",
		'baseFontFamily' => "'Helvetica Neue', Helvetice, Arial, sans-serif",
		'baseLineHeight' => "18px",
		'primaryButtonColor' => "@blue",
		'placeholderText' => "@grayLight",
		'navbarHeight' => "40px",
		'navbarBackground' => "@grayDarker",
		'navbarBackgroundHighlight' => "@grayDark",
		'navbarText' => "@grayLight",
		'navbarLinkColor' => "@grayLight",
		'navbarLinkColorHover' => "@white",
		'warningText' => "#c09853",
		'warningBackground' => "#fcf8e3",
		'errorText'	 => "#b94a48",
		'errorBackground' => "#f2dede",
		'successText' => "#468847",
		'successBackground' => "#dff0f8",
		'infoText' => "#3a87ad",
		'infoBackground' => "#d9edf7"
	);
	return $bootstrap;
}
function wordstrap_get_bootstrap_colour_settings() {
	$bootstrap_colours = array(
		"infoBackground",
		"infoText",
		"successBackground",
		"successText",
		"errorBackground",
		"errorText",
		"warningBackground",
		"warningText",
		"navbarLinkColorHover",
		"navbarBackground",
		"navbarBackgroundHighlight",
		"navbarText",
		"placeholderText",
		"primaryButtonColor",
		"linkColor",
		"linkColorHover",
		"blue",
		"green",
		"red",
		"yellow",
		"orange",
		"pink",
		"purple"
	);
	return $bootstrap_colours;
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
<?php settings_errors(); ?>
<?php if(isset($_GET['error']) && !empty($_GET['error'])) : ?>
	<div class="error"><p><?php echo $_GET['error']; ?></p></div>
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
