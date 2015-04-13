<?php
/*

 * Wordpress Standard Class Install

 * Plugin install script which adds default pages, taxonomies, and database tables

 * @author 		SnapyCode

 * @category 	Admin

 * @package 	snapycode_flake

 * Activate 

 */

function spc_ghostskin_activate() {

	spc_ghostskin_install();        

	// Update installed variable

	update_option( "snapycode_flake_installed", 1 );
	//update_user_meta( get_current_user_id(), 'licence_activate', '0' );

}

/* 

* Install snapycode_flake. DB creation done here. 

*/

function spc_ghostskin_install() {

	global $wpdb, $snapycode_flake;

	
	$snapycodeFlake_table = $wpdb->prefix.'spc_flakes';

	$snapycodeFlake_sql = "CREATE TABLE IF NOT EXISTS `{$snapycodeFlake_table}` (

				 `id` int(11) NOT NULL AUTO_INCREMENT,
				  `flake_text` varchar(255) NOT NULL,
				  `flake_image` varchar(255) NOT NULL,
				  `flake_link` varchar(255) NOT NULL,
				  `flake_selector` varchar(100) NOT NULL,
				  `flake_active_area` varchar(255) NOT NULL,
				  `flake_active_page` varchar(255) NOT NULL,
				  `flake_mode` varchar(10) NOT NULL,
				  `flake_link_enable` int(11) NOT NULL,
				  `flake_music_enable` int(11) NOT NULL,
				  `flake_show_enable` int(11) NOT NULL,
				  `flake_direction` varchar(50) NOT NULL,
				  `flake_num` int(10) NOT NULL,
				  `flake_speed` varchar(50) NOT NULL,
				  `flake_frequency` int(11) NOT NULL,
				  `flake_opacity` varchar(50) NOT NULL,
				  `flake_width` varchar(50) NOT NULL,
				  `flake_height` varchar(50) NOT NULL,
				  `flake_color` varchar(50) NOT NULL,

				  PRIMARY KEY (`id`)

				) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";

			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        	dbDelta( $snapycodeFlake_sql );

}

function spc_ghostskin_deactivate() {
	global $wpdb;
	
	//settings table
	$f_table = $wpdb->prefix.'spc_flakes';
	
	//Drop Settings table SQL
	$drop_settings_table_sql = "DROP TABLE IF EXISTS `{$f_table}`";
	
	$wpdb->query($drop_settings_table_sql);
}