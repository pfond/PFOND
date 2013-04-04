<?php
/**
 * Installation Functions for Plugin
 * @package Easy Popups
 * @since 1.0
 */

/**
 * Main installation function
 * @name CREP Installation
 * @since 1.0
 */
function crepInstallation() {
	// Check to see if it has already been installed
	if(get_option('crep-installed') != '1') {
		crepInsertDefaultOptions();
	}
}

/**
 * Insert Default Options
 * @name CREP Insert Default Options
 * @since 1.0
 */
function crepInsertDefaultOptions() {
	$defaults = array(
	'crep_installed' => '1',
	'crep_title' => 'Here is your popup title!',
	'crep_text' => 'Here is some text that will be displayed in your popup!',
	'crep_code' => 'any supplemental code should go here...',
	'crep_home_page' => 'yes',
	'crep_pages' => 'no',
	'crep_posts' => 'yes',
	'crep_cookie_frequency' => '14',
	'crep_style' => 'ui-lightness',
	'crep_open_animation' => 'none',
	'crep_close_animation' => 'none',
	'crep_modal' => 'yes',
	'crep_width' => '',
	'crep_height' => '');
	
	foreach($defaults as $key=>$value) {
		add_option($key, $value, ' ', 'no');
	}
}