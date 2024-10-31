<?php
/*
  Plugin Name: Professional Opt-in
  Plugin URI: http://kenmorico.com/professional-opt-in
  Description: An opt-in plugin for professional sites.
  Version: 1.0
  Author: Ken Morico
  Author URI: http://kenmorico.com
  License: GPL2
 */

/*  Copyright 2013  Ken Morico  email : blog@kenmorico.com Twitter : @KenMorico

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

// ACTIVATION-----------------------------------

define("PSOI_CURRENT_VERSION",    1.0);

function professional_opt_in_setup_defaults(){

} 


function professional_opt_in_activate() {
     // check if this is first activation
    $options = get_option('professional_opt_in_options');
    
    if(isset($options['prior_activation'])) return;
        else {
            $options['prior_activation'] = 'true';
            update_option('professional_opt_in_options', $options);
        }
    professional_opt_in_setup_defaults();

}
register_activation_hook( __FILE__,  'professional_opt_in_activate' );


function professional_opt_in_deactivate() {

}
register_deactivation_hook( __FILE__, 'professional_opt_in_deactivate' );

function professional_opt_in_uninstall() {
    //delete_option('professional_opt_in_options');
}

register_uninstall_hook(__FILE__, 'professional_opt_in_uninstall' );



// Adding WordPress plugin meta links
 
add_filter( 'plugin_row_meta', 'professional_opt_in_plugin_meta_links', 10, 2 );
function professional_opt_in_plugin_meta_links( $links, $file ) {
 
	$plugin = plugin_basename(__FILE__);
 
	// create link
	if ( $file == $plugin ) {
		return array_merge(
			$links,
			array( '<a href="options-general.php?page=professional_opt_in.php">Settings</a>' ,'<a href="http://kenmorico.com/professional-opt-in">Donate</a>' )
		);
	}
	return $links;
 
}



// ADMIN OPTIONS FORM-----------------------------------
// add the admin options page
add_action('admin_menu', 'professional_opt_in_admin_add_page');

function professional_opt_in_admin_add_page() {
    add_options_page('Professional Opt-in Page', 'Professional Opt-in', 'manage_options', 'professional_opt_in', 'professional_opt_in_options_page');
}

// display the admin options page
function professional_opt_in_options_page() {
    ?>
    <div>
        <h2>Professional Opt-in Plugin</h2>
        <p>Configure options below. For details and tips on these options, visit the <a href="http://kenmorico.com/professional-opt-in" target="_blank">plugin homepage</a>.</p>
        <form action="options.php" method="post">
            <?php settings_fields('professional_opt_in_options'); ?>
    <?php do_settings_sections('professional_opt_in'); ?>

            <input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
        </form></div>
    <?php
}

// add the admin settings and such
add_action('admin_init', 'professional_opt_in_admin_init');

function professional_opt_in_admin_init() {
    //set version num
   $options = get_option('professional_opt_in_options'); 
   $options['version'] = PSOI_CURRENT_VERSION;
    update_option('professional_opt_in_options', $options);
    
    register_setting('professional_opt_in_options', 'professional_opt_in_options', 'professional_opt_in_options_validate');
    
    add_settings_section('professional_opt_in_settings', 'Popup Settings', 'professional_opt_in_settings_section_text', 'professional_opt_in');
    add_settings_field('professional_opt_in_p1_promotext', 'Promo Text', 'professional_opt_in_p1_promotext_setting', 'professional_opt_in', 'professional_opt_in_settings');
    add_settings_field('professional_opt_in_p1_ctatext', 'CTA Text', 'professional_opt_in_p1_ctatext_setting', 'professional_opt_in', 'professional_opt_in_settings');
    add_settings_field('professional_opt_in_p1_ctaurl', 'CTA URL', 'professional_opt_in_p1_ctaurl_setting', 'professional_opt_in', 'professional_opt_in_settings');
    
    add_settings_field('professional_opt_in_p1_showhome', 'Only Homepage / front page?', 'professional_opt_in_p1_showhome_setting', 'professional_opt_in', 'professional_opt_in_settings');
    add_settings_field('professional_opt_in_p1_showposts', 'Only Posts?', 'professional_opt_in_p1_showposts_setting', 'professional_opt_in', 'professional_opt_in_settings');
    add_settings_field('professional_opt_in_p1_showpages', 'Only Pages?', 'professional_opt_in_p1_showpages_setting', 'professional_opt_in', 'professional_opt_in_settings');
    add_settings_field('professional_opt_in_p1_showarchives', 'Only Archive Pages (Category,tag, etc.)?', 'professional_opt_in_p1_showarchives_setting', 'professional_opt_in', 'professional_opt_in_settings');
    
    add_settings_field('professional_opt_in_p1_active', '<strong>Pop-up active?</strong>', 'professional_opt_in_p1_active_setting', 'professional_opt_in', 'professional_opt_in_settings');
    
  
}

function professional_opt_in_settings_section_text() {
    echo '<p>Enter pop-up info here. Plugin defaults to show on all pages unless WordPress sections below are checked.</p>';
}

function professional_opt_in_p1_promotext_setting() {
    $options = get_option('professional_opt_in_options');
    echo "<input id='professional_opt_in_p1_promotext' name='professional_opt_in_options[p1_promotext]' size='42' maxlength='47' type='text' value='{$options['p1_promotext']}' /> ";
}


function professional_opt_in_p1_ctatext_setting() {
    $options = get_option('professional_opt_in_options');
    echo "<input id='professional_opt_in_p1_ctatext' name='professional_opt_in_options[p1_ctatext]' size='12' maxlength='14' type='text' value='{$options['p1_ctatext']}' /> ";
}

function professional_opt_in_p1_ctaurl_setting() {
    $options = get_option('professional_opt_in_options');
    echo "<input id='professional_opt_in_p1_ctaurl' name='professional_opt_in_options[p1_ctaurl]' size='40' type='text' value='{$options['p1_ctaurl']}' /> ";
}

function professional_opt_in_p1_showhome_setting() {
    $options = get_option('professional_opt_in_options');
    echo "<input type='checkbox' id='professional_opt_in_p1_showhome' name='professional_opt_in_options[p1_showhome]' value='1' ";
    checked( 1 == $options['p1_showhome'] );
    echo "  />";
}

function professional_opt_in_p1_showposts_setting() {
    $options = get_option('professional_opt_in_options');
    echo "<input type='checkbox' id='professional_opt_in_p1_showposts' name='professional_opt_in_options[p1_showposts]' value='1' ";
    checked( 1 == $options['p1_showposts'] );
    echo "  />";
}

function professional_opt_in_p1_showpages_setting() {
    $options = get_option('professional_opt_in_options');
    echo "<input type='checkbox' id='professional_opt_in_p1_showpages' name='professional_opt_in_options[p1_showpages]' value='1' ";
    checked( 1 == $options['p1_showpages'] );
    echo "  />";
}

function professional_opt_in_p1_showarchives_setting() {
    $options = get_option('professional_opt_in_options');
    echo "<input type='checkbox' id='professional_opt_in_p1_showarchives' name='professional_opt_in_options[p1_showarchives]' value='1' ";
    checked( 1 == $options['p1_showarchives'] );
    echo "  />";
}

function professional_opt_in_p1_active_setting() {
    $options = get_option('professional_opt_in_options');
    echo "<input type='checkbox' id='professional_opt_in_p1_active' name='professional_opt_in_options[p1_active]' value='1' ";
    checked( 1 == $options['p1_active'] );
    echo "  />";
}


// validate our options
function professional_opt_in_options_validate($input) {
    /* $newinput['text_string'] = trim($input['text_string']);
      if(!preg_match('/^[a-z0-9]{32}$/i', $newinput['text_string'])) {
      $newinput['text_string'] = '';
      }
      return $newinput; */
    return $input;
}

// -----------------------------------
// PLUGIN FUNCTIONALITY

function init_professional_opt_in(){
wp_enqueue_script("professional-opt-in-js", plugins_url('/js/professional-opt-in.js', __FILE__)); 
wp_enqueue_style("professional-opt-in-style", plugins_url('/css/style.css', __FILE__)); 
}



// setup pop-up----------------------

function createPopup($cpu = "p1") {
    $popup = "";
    $options = get_option('professional_opt_in_options');
// PopUp ----------------------------------------------------------

 
$popup .= '<script>
    jQuery(function($) {
    $(document).ready(function () {
        triggerPopup();
    })
    });
</script>
<div class="po-spacer" style="clear:both; height:70px; background-color:transparent;"></div>
<div class="ui-popup">
<div class="ui-popup-content">
<h3>'. $options[$cpu.'_promotext'].'</h3>
<a href="'.$options[$cpu.'_ctaurl'].'" class="CTA"><span class="CTABtn">'.$options[$cpu.'_ctatext'].'</span></a>
</div>
</div>';
// End PopUp ----------------------------------------------------------

    return $popup;
}

function print_popup($content) {
    $cpu = "p1";
    $options = get_option('professional_opt_in_options');
    if(!isset($options[$cpu.'_active']))  return $content;
    
    if (!isset($options[$cpu.'_showhome']) && !isset($options[$cpu.'_showposts'])  && !isset($options[$cpu.'_showpages']) && !isset($options[$cpu.'_showarchives'])        ) {
        //show on all pages
        $newContent = "";
        $popup = createPopup($cpu);        
        $newContent = $content . $popup;        
        echo $newContent;
        return;
    }
    
     if ( (is_home() || is_front_page()) && isset($options[$cpu.'_showhome'])) {
        $newContent = "";
        $popup = createPopup($cpu);        
        $newContent = $content . $popup;        
        echo $newContent;
    }
    
    if (is_single() && isset($options[$cpu.'_showposts'])) {
        $newContent = "";
        $popup = createPopup($cpu);        
        $newContent = $content . $popup;        
        echo $newContent;
    }
    
       if (is_page() && !(is_home() || is_front_page()) && isset($options[$cpu.'_showpages'])) {
        $newContent = "";
        $popup = createPopup($cpu);        
        $newContent = $content . $popup;        
        echo $newContent;
    }
    
     if (is_archive() && isset($options[$cpu.'_showarchives'])) {
        $newContent = "";
        $popup = createPopup($cpu);        
        $newContent = $content . $popup;        
        echo $newContent;
    }
 
}




add_action('wp_head', 'init_professional_opt_in',5);// enqueue css and js,

add_action('wp_footer', 'print_popup',20);

?>