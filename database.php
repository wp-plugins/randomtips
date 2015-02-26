<?php

function rtip_getTips_($group) {
	rtip_setVar();
	global $wpdb;
	global $rt_tablename;
	global $rt_results;
	global $rt_rownum;
	
	$table_name = $wpdb->prefix . $rt_tablename;	
	$rt_results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $table_name where team='%s';", $group ) );
	//$rt_results = $wpdb->get_results ( "SELECT * FROM $table_name where team='$group';", OBJECT );
	
	$rt_rownum = $wpdb->num_rows;
}
//
function rtip_getTips() {
	rtip_setVar();
	global $wpdb;
	global $rt_tablename;
	global $rt_results;
	global $rt_rownum;

	$table_name = $wpdb->prefix . $rt_tablename;
	//$rt_results = $wpdb->get_results ( "SELECT * FROM $table_name;", OBJECT );
	$rt_results = $wpdb->get_results( "SELECT * FROM $table_name;");
	
	$rt_rownum = $wpdb->num_rows;

}
//
/*
 * Procedura di installazione database.
 */
function rtip_installDB(){
	rtip_setVar();
	global $wpdb;
	global $rt_tablename;
	
	$table_name = $wpdb->prefix . $rt_tablename;
	
	$charset_collate = $wpdb->get_charset_collate ();
	
	$sql = "CREATE TABLE $table_name (
	id mediumint(9) NOT NULL AUTO_INCREMENT,
	text text NOT NULL,
	team text NOT NULL,
	UNIQUE KEY id (id)
	) $charset_collate;";
	
	require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta ( $sql );
}

function rtip_jal_install_data() {
	global $wpdb;
	global $rt_tablename;
	$welcome_name = 'Mr. WordPress';
	$welcome_text = 'Congratulations, you just completed the installation!';

	$table_name = $wpdb->prefix . $rt_tablename;

	$wpdb->insert(
			$table_name,
			array(					
					'text' => $welcome_name . " " .$welcome_text,
					'team' => "default"
			)
	);
}

function rtip_insert_tip ( $testo, $gruppo ) {
	rtip_setVar();
	global $wpdb;
	global $rt_tablename;

	$table_name = $wpdb->prefix . $rt_tablename;
	$wpdb->insert(
			$table_name,
			array(
					'text' => $testo,
					'team' => $gruppo
			)
	);
}

function rtip_delete_tip($todeletert)  {
	rtip_setVar();
	global $wpdb;
	global $rt_tablename;
	$table_name = $wpdb->prefix . $rt_tablename;
	$wpdb->delete( $table_name, array( 'id' => $todeletert ) );
	rtip_getTips();
}
