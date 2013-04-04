<?php
/**
 * Bootstrap File
 * @package Easy Popups
 * @since 1.0
 */

if(is_admin()) {
	include_once 'admin.init.php';
}
else {
	include_once 'init.php';
}

?>