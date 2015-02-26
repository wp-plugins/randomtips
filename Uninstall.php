<?php
rtip_pluginUninstall();
function rtip_pluginUninstall() {
  global $rt_tablename;
  $rt_tablename='list_tips';
  global $wpdb;
  global $rt_tablename;
  $thetable = $wpdb->prefix . $rt_tablename;
  $wpdb->query("DROP TABLE IF EXISTS $thetable");
}