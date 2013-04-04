<?php
/*
Plugin Name: Cool Ryan Easy Popups
Plugin URI: http://coolryan.com/plugins/cool-ryan-easy-popups/
Description: Add Descriptive Popups to entice your readers with messages, opt-ins, and more!
Version: 1.0
Author: Cool Ryan
Author URI: http://coolryan.com
*/

//error_reporting ( E_ALL ); // On for debugging, off for main distribution
//ini_set ( 'display_errors', 1 ); // On for debugging, off for main distribution

/** Constants */

if (is_admin ()) {
	define ( 'CREP_PLUGIN_URL', '../' . PLUGINDIR . '/cool-ryan-easy-popups' ); // Plugin Folder
} else {
	define ( 'CREP_PLUGIN_URL', PLUGINDIR . '/cool-ryan-easy-popups' ); // Plugin Folder
}

define('CREP_LIB_URL', CREP_PLUGIN_URL. '/lib'); //Library Folder
define('CREP_INC_URL', CREP_LIB_URL . '/includes'); // Includes Folder
define('CREP_CSS_URL', CREP_LIB_URL . '/css'); // CSS Folder
define('CREP_JS_URL', CREP_LIB_URL . '/js'); // JavaScript Folder

/** Bootstrap Plugin */
include_once 'crep-load.php';

/** Installation */
register_activation_hook ( CREP_INC_URL . '/admin.install.php', 'crepInstallation' );
?>