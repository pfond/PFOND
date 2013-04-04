<?php
/* Nothing harmfull here. Just inserting the IP to the whitelist of First Visit Message */
include('main.php');

if($_GET['do'] == 'db') {
	$query = 'INSERT INTO ' . $table . ' (ip, datetime) VALUES ("' . $ip . '", NOW())';
	mysql_query($query);

}elseif($_GET['do'] == 'cookie') {
	setcookie("firstvisit", "Visited", time()+604800, "/");
}
