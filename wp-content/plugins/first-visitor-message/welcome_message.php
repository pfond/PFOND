<?php
/*
Plugin Name: First Visit Message
Plugin URI: http://www.thijmenstavenuiter.nl/
Description: Shows a message for new visitors
Version: 0.6.4
Author: Thijmen Stavenuiter
Author URI: http://www.thijmenstavenuiter.nl/
License: GPL2
*/

global $firstvisit_version;
$firstvisit_version = "0.6.4";

$installed_ver = get_option( "firstvisit_version" );




if( $installed_ver != $firstvisit_version ) {

	// Go-go gadget updatescript!
	if  (in_array  ('curl', get_loaded_extensions())) {
		$curl_handle=curl_init();
		curl_setopt($curl_handle,CURLOPT_URL,'http://www.thijmenstavenuiter.nl/plugin/doRegister.php?version=' . $firstvisit_version);
		curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,2);
		curl_exec($curl_handle);
		if(function_exists('url_close')) {
			url_close($curl_handle);
		}
	}
      update_option( "firstvisit_version", $firstvisit_version );
  }

/* Function to make the tables, stuff and things */
function firstvisit_install () {

	global $wpdb;
	global $firstvisit_version;
	$table_name = $wpdb->prefix . "firstvisit_ip";
	if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {	}
	
	
	/* Create the tables which are required for First Visit Message */
	$sql = "CREATE TABLE " . $table_name . " (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`ip` varchar(255) NOT NULL,
	`datetime` varchar(255) NOT NULL,
	PRIMARY KEY (`id`)
	) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
	
	
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);

	add_option("firstvisit_version", $firstvisit_version);


}
 
/* Making sure the installer will be run after activating the plugin */

@@register_activation_hook(__FILE__,'firstvisit_install');
 
 
 

/* All sparky! Now we can setup the Admin Settings Page! */


function firstvisit_admin_actions() {
	add_options_page("First Visit Settings", "First Visit Settings", 1, "firstvisitsettings", "firstvisit_admin");
}

function firstvisit_add2header() {

	$url = get_bloginfo('url');
	echo '<script src="http://jqueryjs.googlecode.com/files/jquery-1.2.6.min.js" type="text/javascript"></script>';
	if(get_option('firstvisit_dbcookie') == 'db') {
		echo '<script src="' . $url . '/wp-content/plugins/first-visitor-message/popup.php" type="text/javascript"></script>';
	}elseif(get_option('firstvisit_dbcookie') == 'cookie') {
		echo '<script src="' . $url . '/wp-content/plugins/first-visitor-message/popup_cookie.php" type="text/javascript"></script>';
	}
	echo '<link rel="stylesheet" href="' . $url . '/wp-content/plugins/first-visitor-message/css/firstvisit.css" type="text/css" media="screen" /> ' ;
}

add_action('wp_head', 'firstvisit_add2header');
add_action('admin_menu', 'firstvisit_admin_actions');
	
function firstvisit_admin() {
	include('admin_page.php');
}

function firstvisit_message() {
	
	if(get_option('firstvisit_enabled') == "yes"){
		
		if(get_option('firstvisit_dbcookie') == 'db'){
			$sql = mysql_query("SELECT * FROM wp_firstvisit_ip WHERE ip = '" . $_SERVER['REMOTE_ADDR'] . "'");
			if(mysql_num_rows($sql) == 0){
				echo '	<div id="popupContact"> 
					<a id="popupContactClose">x</a> 
					<h1>' . get_option('firstvisit_title'). '</h1> 
					<p id="contactArea"> 
						' . get_option('firstvisit_message'). '
					</p> 
					<p><button onClick="noShow()">' . get_option('firstvisit_notagain'). '</button></p>
					<p id="theMessage"><span class="success">' . get_option('firstvisit_successmessage') . '</span></p>
				</div> 
				
				<div id="backgroundPopup"></div> ';
			}
		}elseif(get_option('firstvisit_dbcookie') == 'cookie') { // Go-go gadget Cookie!
			if(!isset($_COOKIE['firstvisit'])) { // Show the message!
				echo '<div id="popupContact"> 
					<a id="popupContactClose">x</a> 
					<h1>' . get_option('firstvisit_title'). '</h1> 
					<p id="contactArea"> 
						' . get_option('firstvisit_message'). '
					</p> 
					<p><button onClick="noShow()">' . get_option('firstvisit_notagain'). '</button></p>
					<p id="theMessage"><span class="success">' . get_option('firstvisit_successmessage') . '</span></p>
				</div> 
				
				<div id="backgroundPopup"></div> ';
			}
		}
	}
}
add_action('wp_footer', 'firstvisit_message');
add_action('admin_menu', 'firstvisit_admin_actions');
	

 ?>
