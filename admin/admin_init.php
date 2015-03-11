<?php
/*

 * Wordpress Standard Class Admin

 * Main admin file which loads all settings panels and sets up admin menus.

 * @author 		SnapyCode

 * @category 	Admin

 * @package 	snapycode_flake

 */

include_once( 'admin_install.php' );
include_once( 'admin_menu_spcflakes.php' );

function spc_admin_init() {

	global $snapycode_flake;

	wp_enqueue_style('spc_admin_css', $snapycode_flake->plugin_url() . '/assets/css/snapycode_flake_admin.css');
	wp_enqueue_script('spc_admin_js', $snapycode_flake->plugin_url() . '/assets/js/snapycode_flake_admin.js');
		
}


/*

 * Admin Menus

 * Sets up the admin menus in wordpress.

 */

function spc_admin_menu() {

	global $menu, $snapycode_flake;

    $menu1=add_menu_page('Click skins', 'Click skins', 'manage_options', __FILE__, 'spcFlakes', 

	plugins_url('/assets/images/18_icon.png',dirname(__FILE__)));

	$submenu1 = add_submenu_page(__FILE__, 'Audio Settings', ' Audio Settings', 'manage_options', __FILE__ . '_settings', 'spcFlakesSettings');
    add_action('admin_print_styles-' . $menu1, 'spc_admin_init');                                                          
    add_action('admin_print_styles-' . $submenu1, 'spc_admin_init');                                                                                                                    
    add_action('admin_print_styles-' . $submenu2, 'spc_admin_init');   
    add_action('admin_print_scripts-' . $menu1, 'spc_admin_init');                                                          
    add_action('admin_print_scripts-' . $submenu2, 'spc_admin_init');                                                       
    add_action('admin_print_scripts-' . $submenu2, 'spc_admin_init');                                                          
}

add_action('admin_menu', 'spc_admin_menu', 9);