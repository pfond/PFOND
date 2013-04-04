<?php
/**
 * Functions for the Options page
 * @package Easy Popup
 * @subpackage Admin
 * @since 1.0
 */


/**
 * Sorts and puts the data into the options table
 * @name CREP Update Options
 * @uses update_option
 * @since 1.0
 */
function crepUpdateOptions() {
	if(isset($_POST['submitted'])) {
		if($_POST['submitted'] == 'crep_update_options') {
			
			
			/** Insert into the database */
			update_option('crep_title', $_POST['crep_title']);
			update_option('crep_text', $_POST['crep_text']);
			update_option('crep_code', $_POST['crep_code']);
			update_option('crep_home_page', $_POST['crep_home_page']);
			update_option('crep_pages', $_POST['crep_pages']);
			update_option('crep_posts', $_POST['crep_posts']);
			update_option('crep_cookie_frequency', $_POST['crep_cookie_frequency']);
			update_option('crep_style', $_POST['crep_style']);
			update_option('crep_open_animation', $_POST['crep_open_animation']);
			update_option('crep_close_animation', $_POST['crep_close_animation']);
			update_option('crep_modal', $_POST['crep_modal']);
			update_option('crep_width', $_POST['crep_width']);
			update_option('crep_height', $_POST['crep_height']);
		}
	}
}


/**
 * Dropdown box for styles
 * @name CREP Styles Dropdown
 * @param string $selected is the item you want selected on page load
 * @since 1.0
 */
 function crepStylesDropdown($selected = null) {
 	$styles = array(
 				'Black Tie' => 'black-tie',
 				'Blitzer' => 'blitzer',
 				'Cupertino' => 'cupertino',
 				'Dark Hive' => 'dark-hive',
 				'Dot Luv' => 'dot-luv',
 				'Eggplant' => 'eggplant',
 				'Excite Bike' => 'excite-bike',
 				'Flick' => 'flick',
 				'Hot Sneaks' => 'hot-sneaks',
 				'Humanity' => 'humanity',
 				'Le Frog' => 'le-frog',
 				'Mint Choc' => 'mint-choc',
 				'Overcast' => 'overcast',
 				'Pepper Grinder' => 'pepper-grinder',
 				'Redmond' => 'redmond',
 				'Smoothness' => 'smoothness',
 				'South Street' => 'south-street',
 				'Start' => 'start',
 				'Sunny' => 'sunny',
 				'Swanky Purse' => 'swanky-purse',
 				'Trontastic' => 'trontastic',
 				'UI Lightness' => 'ui-lightness',
 				'UI Darkness' => 'ui-darkness',
 				'Vader' => 'vader');
 	$dropdown = '<select name="crep_style">';
 	
 	foreach ($styles as $key=>$value) {
 		$dropdown .= '<option value="'.$value.'">'.$key.'</option>';
 		$dropdown .= "\r\n";
 	}
 	$dropdown .= "</select>\r\n";
 	$dropdown = str_ireplace('option value="'.$selected.'">', 'option value="'.$selected.'" SELECTED>', $dropdown);
 	return $dropdown;
 }
 
 /**
  * Dropdown box for Animations
  * @name CREP Animation Dropdown
  * @param string $selected is the item you want selected on page load
  * @param string $name is the name of the select box
  * @since 1.0
  */
 function crepAnimationDropdown($selected = null, $name = null) {
 $styles = array(
 			'None' => '',
 			'Blind' => 'blind',
 			'Bounce' => 'bounce',
 			'Clip' => 'clip',
 			'Drop' => 'drop',
 			'Explode' => 'explode',
 			'Fold' => 'fold',
 			'Puff' => 'puff',
 			'Scale' => 'scale',
 			'Slide' => 'slide'
 			);
 	$dropdown = '<select name="'.$name.'">';
 	
 	foreach ($styles as $key=>$value) {
 		$dropdown .= '<option value="'.$value.'">'.$key.'</option>';
 		$dropdown .= "\r\n";
 	}
 	$dropdown .= "</select>\r\n";
 	$dropdown = str_ireplace('option value="'.$selected.'">', 'option value="'.$selected.'" SELECTED>', $dropdown);
 	return $dropdown;
 }
 

/**
 * Triggers Tiny MCE On Textara
 * @name CREP Tiny MCE
 * @since 1.0
 */
function crepTinyMCE() {
wp_tiny_mce( false , // true makes the editor "teeny"
	array(
		"editor_selector" => "crep_text",
		"width" => '50%',
		"height" => '250'
	)
);

/**
 * Displays the checked value if a radio value is the given value
 * @name is Seleced (Radio)
 * @param string $str the value to be checked
 * @param string $desired the desired result
 * @return string checked="checked"
 * @since 1.0
 */
function _r($str, $desired) {
	if($str == $desired) {
		return 'checked="checked"';
	}
}

/**
 * Displays success message if options are saved
 * @name CREP Display Message
 * @since 1.0
 */
function crepDisplayMessage() {
	if(isset($_POST['submitted'])) {
		echo '<div class="updated fad">Options updated successfully!</div>';
	}
}

}