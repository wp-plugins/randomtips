<?php
/*
 * Plugin Name: Random Tips
 * Plugin URI: http://www.aliceintheartland.com/softcreepers/randomtips
 * Description: This is a plugin that help on creating a random set of daily tips and sentence to visualize using shortcode.
 * You can use this plugin into your post or into widget that can include shortcode. 
 * Version: 1.0
 * Author: Softcreepers
 * Author URI: http://www.aliceintheartland.com/softcreepers
 */
register_activation_hook ( __FILE__, 'rtip_jal_install' );
register_activation_hook ( __FILE__, 'rtip_jal_install_data' );


 $rt_tablename;
 $rt_rownum=0;
 $rt_results;
 
 
 include("database.php");
 include("utility.php");
 include("administration.php");
 
//
function rtip_setVar() {
	global $rt_tablename;
	$rt_tablename='list_tips';
}
// modified to enable the insert into a post.
function rtip_shortcode($atts) {
	global $wpdb;
	global $rt_results;
	global $rt_rownum;
	ob_start();
	$a = shortcode_atts( array(
    'group' => 'default'
	), $atts );

	rtip_getTips_($a['group']);
	$num = rand(1, $rt_rownum);
	if($rt_rownum>0){
		echo $rt_results[$num -1]->text;
	} else {
		echo _e('no data', 'randomtips' );
	}
	$output_string=ob_get_contents();
	ob_end_clean();
	return $output_string;
}

add_shortcode ( 'randomtips', 'rtip_shortcode' );
//
function rtip_jal_install() {
	rtip_installDB();	
}


// aggiungo la funzione di menu
/**
 * Step 2 (from text above).
 */
add_action ( 'admin_menu', 'rtip_menu' );

/**
 * Step 1.
 */
function rtip_menu() {
	add_options_page ( 'Random Tips Options', 'Random Tips', 'manage_options', 'randomtips', 'rtip_options' );
}


