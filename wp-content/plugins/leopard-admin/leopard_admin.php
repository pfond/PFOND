<?php
/*
Plugin Name: Leopard Admin
Plugin URI: http://www.teddyhwang.com/resources/leopardadmin/
Description: This plugin is a fork of <a href="http://orderedlist.com/">Steve Smith's</a> popular WordPress plugin, Tiger Admin. It styles the WordPress administration panel with a look that's inspired by Apple's Mac OSX Leopard. It's powered entirely by CSS and no hack is necessary. Icon design by <a href="http://jonasraskdesign.com/">Jonas Rask</a>.
Author: Teddy Hwang
Version: 1.02
Author URI: http://www.teddyhwang.com
*/ 

function leopard_admin_css() {
	echo '<link rel="stylesheet" type="text/css" href="' . get_settings('siteurl') . '/wp-content/plugins/leopard-admin/lib/wp-admin.css?version=1.02" />';
}

add_action('admin_head', 'leopard_admin_css');

?>