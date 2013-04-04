<?php
/* Main Code for adding visitors to the database e.g. */
include("../../../wp-config.php");

mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
mysql_select_db(DB_NAME);

$ip = $_SERVER['REMOTE_ADDR'];
$table = $table_prefix . 'firstvisit_ip';
function get_url() {
	include("../../../wp-config.php");
	
	$query = 'SELECT option_value FROM ' . $table_prefix . 'options WHERE option_name = "siteurl"';
	$query1 = mysql_query($query) or die(mysql_error());
	$query2 = mysql_fetch_array($query1);
	echo $query2['option_value'];
}