<?php
/*
Plugin Name: auto tooltip
Plugin URI: http://www.yonadi.com
Description: add tooltip on your blog.
Version: 3.1
Author: abdolmajed shah bakhsh ( ijbari ) and mostafa soufi
Author URI: http://www.yonadi.com/
*/
function auto_tooltip () {
	$home = get_option("home");
	echo "<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js'></script>\n";
	echo "<script src='$home/wp-content/plugins/auto-tooltip/tooltip.js'></script>";

}

add_action('wp_head', 'auto_tooltip');

?>
<?php
// create custom plugin settings menu
add_action('admin_menu','auto_tooltip_create_menu');

function auto_tooltip_create_menu() {

	//create new top-level menu
	add_options_page(__('Auto Toltip', 'auto_tooltip'), __('Auto Toltip', 'auto_tooltip'), 'administrator', 'auto_tooltip', 'auto_tooltip_settings_page');

	//call register settings function
	add_action( 'admin_init', 'auto_tooltip_register_mysettings' );
}
add_action ('wp_head', 'addHeaderCode') ;

function addHeaderCode() {
		$auto_tooltip_users = get_option('user');
		$auto_tooltip_userArray = explode(",", $auto_tooltip_users);
		echo "\n".'<!-- Start auto tooltip -->'."\n";
		echo '<style type="text/css">' . "\n";
		echo 'div#qTip {border:1px solid #A5C5D0;
		z-index: 3000;
			background:#F4FCFF;
	min-width:40px;
	min-height:14px;
	text-direction:rtl;
	text-align:center;
	padding:2px 5px;
	filter:alpha(opacity=75);
	opacity:0.7;
	-moz-border-radius: 4px;
	-webkit-border-radius: 4px;
	color:#000000;
	shadow:5px 5px 0 #FFF;
	font-size:8pt;
	font-family: tahoma;
	text-shadow:1px 0px 1px #565656;
	display:none;
	-moz-box-shadow: 0px 0px 4px #fff;
	position:absolute;
	margin-top:12px;
	margin-left:5px;
	max-width: 200px;
	background-color: ' . get_option('color_code') . ' !important; color: ' . get_option('color_code2') . ' ;}' . "\n";
		for($i = 0; $i < count($auto_tooltip_userArray); $i++){
	echo '.comment-author-' . $auto_tooltip_userArray[$i] . ' {background-color: ' . get_option('user_color_code') . ' !important; color: ' . get_option('user_color_code2') . ' ;}' . "\n";
}
		echo '</style>'."\n";
		echo '<!-- Stop auto_tooltip -->'."\n";
}

if ( function_exists('register_uninstall_hook') )
	register_uninstall_hook(__FILE__, 'auto_tooltip_deinstall');
 
 /**
 * Delete options in database
 */
function auto_tooltip_deinstall() {
 
	delete_option('color_code');
	delete_option('color_code2');
	delete_option('user_color_code');
	delete_option('user_color_code2');
	delete_option('user');
}

function auto_tooltip_register_mysettings() {
	//register  settings
	register_setting( 'auto_tooltip-settings-group', 'color_code' );
	register_setting( 'auto_tooltip-settings-group', 'color_code2' );
	register_setting( 'auto_tooltip-settings-group', 'user_color_code' );
	register_setting( 'auto_tooltip-settings-group', 'user_color_code2' );
	register_setting( 'auto_tooltip-settings-group', 'user' );
}

function auto_tooltip_settings_page() {
?>
<div class="wrap">
<h2><?php _e('auto tooltip - Settings'); ?></h2>
<br/>
<form method="post" action="options.php">
    <?php settings_fields( 'auto_tooltip-settings-group' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row"><?php _e('Enter the highlight color'); ?></th>
        <td><input type="text" name="color_code" value="<?php echo get_option('color_code'); ?>" /> <i><?php _e('For example: #b6bdf6 Leave blank for themes default'); ?></i><br/></td>
        </tr>
		<tr valign="top">
		<th scope="row"><?php _e('Enter the text color'); ?></th>
		<td><input type="text" name="color_code2" value="<?php echo get_option('color_code2'); ?>" /> <i><?php _e('For example: #ffffff Leave blank for themes default'); ?></i></td>
		</tr>
	<h2>admin panel tooltip</h2>
	<input type="checkbox" name="admin_panel" value="1" <?php if (get_option('admin_panel')) echo ' checked="checked"'; ?> />
	</table>
	 <p class="submit">
    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
	</p>
</form>
<?php } ?>