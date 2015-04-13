<?php

/*

Plugin Name: Click skins

Plugin URI: http://reavey.com

description: Clicks Skin Ads – website enhancements and an alternatve to banner ads

Version: 1.0.1

Author: reavey

Author URI: http://reavey.com

*/


/*

* Plugin basic init functionality. 

*/

add_action('init', 'spc_do_init');

function spc_do_init() {

	ob_start();
}

/*

* Include wordpress list class for all listing operation. 

*/

if( ! class_exists( 'WP_List_Table' ) ) {

    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );

}

/*

* Include Base class having all common methodes. All class extends this class. 

*/
if(!class_exists('SnapycodeFlake')){
	include_once( 'classes/base.class.php' );
}
/*

 * Init base class

*/

global $snapycode_flake;

$snapycode_flake = new SnapycodeFlake();

/*

 Admin init + activation hooks.

*/

if ( is_admin() ) :

	require_once( 'admin/admin_init.php' );

	register_activation_hook( __FILE__, 'spc_ghostskin_activate' );
	register_deactivation_hook( __FILE__, 'spc_ghostskin_deactivate' );

endif;

function load_wp_media_files() {

  wp_enqueue_media();

}

add_action( 'admin_enqueue_scripts', 'load_wp_media_files' );

/*
 Function for editor style
*/

function spc_editor_style( $url ) {

global $snapycode_flake;	

if ( !empty($url) )

    $url .= ',';

  // Change the path here if using sub-directory

  $url .= $snapycode_flake->plugin_url() . '/assets/css/editor-style.css';

  return $url;

}

add_filter( 'mce_css', 'spc_editor_style' );

//Action hook for frontend

if( ! is_admin() ){ add_action( 'init', 'spcFrontFlake' ); }

function spcFrontFlake(){

	global $snapycode_flake;

	$plugin_url =  $snapycode_flake->plugin_url;

	if( $snapycode_flake->getFlakeMusic(true) == true ){
		wp_enqueue_script( 'spcbgplay_1', $plugin_url . '/assets/bgplay/soundmanager2.js', array(), '1.0.0', true );
		wp_enqueue_script( 'spcbgplay_2', $plugin_url . '/assets/bgplay/page-player.js', array(), '1.0.0', true );
		wp_enqueue_style( 'spcbgplay_style', $plugin_url . '/assets/bgplay/switch.css', array(), '1.0.0', 'all' );
	}
		wp_enqueue_script( 'spcflake', $plugin_url . '/assets/js/spc.gravity.js', array(), '1.0.0', true );
		wp_enqueue_style( 'spcflakestyle', $plugin_url . '/assets/css/click-layout.css', array(), '1.0.0' );

}

function spcFlakeScript() {

  global $snapycode_flake;	

  $plugin_url =  $snapycode_flake->plugin_url;  

  $script     = $snapycode_flake->getFlakeScript();	
  $bg_music   = $snapycode_flake->getFlakeMusic();	
  
  if( $script && '' != trim($script) )	{

	  echo $script;
	  echo $bg_music;

	}

}
add_action( 'wp_footer', 'spcFlakeScript', 100);