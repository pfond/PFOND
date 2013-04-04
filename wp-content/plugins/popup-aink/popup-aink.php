<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/*
Plugin Name: PopUp Aink
Plugin URI: http://www.classifindo.com/popup-aink/
Description: Show popup and create cookie if click close.
Author: Dannie Herdyawan a.k.a k0z3y
Version: 1.0
Author URI: http://www.classifindo.com/
*/


/*
   _____                                                 ___  ___
  /\  __'\                           __                 /\  \/\  \
  \ \ \/\ \     __      ___     ___ /\_\     __         \ \  \_\  \
   \ \ \ \ \  /'__`\  /' _ `\ /` _ `\/\ \  /'__'\        \ \   __  \
    \ \ \_\ \/\ \L\.\_/\ \/\ \/\ \/\ \ \ \/\  __/    ___  \ \  \ \  \
     \ \____/\ \__/.\_\ \_\ \_\ \_\ \_\ \_\ \____\  /\__\  \ \__\/\__\
      \/___/  \/__/\/_/\/_/\/_/\/_/\/_/\/_/\/____/  \/__/   \/__/\/__/

*/

//////////////////////////////////////////////////////////////////////////////////////////////////////////////// 

global $options, $PopUpAink_path, $PopUpAinkCookieName;
$PopUpAink_path			= get_settings('home').'/wp-content/plugins/'.dirname(plugin_basename(__FILE__));
$PopUpAinkCookieName	= sha1(sha1(base64_encode(md5(sha1(base64_encode(sha1(sha1(base64_encode(md5("bloginfo('url')"))))))))));
$options				= get_option('PopUpAink_option');

/* When plugin is deactivation*/
register_deactivation_hook( __FILE__, 'hapus_PopUpAink' );
function hapus_PopUpAink()
{
	/* Deletes the database field */
	global $options;
	$options = get_option('PopUpAink_option');
	delete_option($options);
}

add_action('admin_menu', 'PopUpAink_admin_menu');
function PopUpAink_admin_menu() {
	global $PopUpAink_path;
	if((current_user_can('manage_options') || is_admin)) {
		add_object_page('PopUp-Aink','PopUp Aink',1,'PopUp-Aink','PopUpAink_page',$PopUpAink_path.'/images/favicon.png');
		add_submenu_page('PopUp-Aink','PopUp Aink Settings','Settings',1,'PopUp-Aink','PopUpAink_page');
	}
}

function PopUpAink_page() {
	if (isset($_POST['save'])) {
		$options['PopUpAink_enable']		= trim($_POST['PopUpAink_enable'],'{}');
		$options['PopUpAink_cookieday']		= trim($_POST['PopUpAink_cookieday'],'{}');
		$options['PopUpAink_width']			= trim($_POST['PopUpAink_width'],'{}');
		$options['PopUpAink_height']		= trim($_POST['PopUpAink_height'],'{}');
		$options['PopUpAink_content']		= trim($_POST['PopUpAink_content'],'{}');
		$options['PopUpAink_link']			= trim($_POST['PopUpAink_link'],'{}');
		update_option('PopUpAink_option', $options);
		// Show a message to say we've done something
		echo '<div class="updated"><p>' . __("Save Changes") . '</p></div>';
	} else {
		$options = get_option('PopUpAink_option');
	}
	echo PopUpAinkSettings();
}

function PopUpAinkSettings() { global $options; $options = get_option('PopUpAink_option'); ?>
<div class="wrap">
<div class="icon32" id="icon-tools"><br/></div>
<h2><?php echo __('PopUp Aink'); ?></h2>

<style type="text/css">
table.PopUpAink label.invalid{
	color:transparent;
	margin:0px;
	padding:0px;
	font-size:0px;
}
</style>

<form method="post" id="mainform" action="">
<table class="widefat fixed PopUpAink" style="margin:25px 0;">
	<thead><tr>
			<th scope="col" width="200px">PopUp Aink Settings</th>
			<th scope="col">&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="titledesc">PopUp Aink Enable:</td>
			<td class="forminp">
				<select name="PopUpAink_enable" id="PopUpAink_enable" style="min-width:100px;">
					<?php if ($options[PopUpAink_enable] == 'yes'){ ?>
						<option value="yes" selected="selected">Yes</option>
						<option value="no">No</option>
					<?php } else if ($options[PopUpAink_enable] == 'no'){ ?>
						<option value="yes">Yes</option>
						<option value="no" selected="selected">No</option>
					<?php } else { ?>
						<option value="yes" selected="selected">Yes</option>
						<option value="no">No</option>
					<?php } ?>
				</select>
				<br /><small>If you do not want to show PopUp Aink on your site, select "No".</small>
			</td>
		</tr><tr>
			<td class="titledesc">PopUp Aink Cookie Day:</td>
			<td class="forminp">
				<input name="PopUpAink_cookieday" id="PopUpAink_cookieday" style="width:55px;" value="<?php echo $options[PopUpAink_cookieday]; ?>" type="text" class="required">
				<br /><small>Set cookie in day. ex: "2" (without quotes), where cookie shall stay in the browser. </small>
			</td>
		</tr><tr>
			<td class="titledesc">PopUp Aink Width:</td>
			<td class="forminp">
				<input name="PopUpAink_width" id="PopUpAink_width" style="width:55px;" value="<?php echo $options[PopUpAink_width]; ?>" type="text">
				<br /><small>Set width for PopUp. ex: "300px" or "25%" (without quotes).</small>
			</td>
		</tr><tr>
			<td class="titledesc">PopUp Aink Height:</td>
			<td class="forminp">
				<input name="PopUpAink_height" id="PopUpAink_height" style="width:55px;" value="<?php echo $options[PopUpAink_height]; ?>" type="text">
				<br /><small>Set height for PopUp. ex: "500px" or "10%" (without quotes).</small>
			</td>
		</tr><tr>
			<td class="titledesc">PopUp Aink Content:</td>
			<td class="forminp">
				<textarea name="PopUpAink_content" id="PopUpAink_content" style="width:550px;height:150px;" class="required" minlength="5"><?php echo esc_attr(stripslashes($options['PopUpAink_content'])); ?></textarea>
				<br><small>HTML is allowed.</small>
			</td>
		</tr><tr>
			<td class="titledesc">PopUp Aink Show Link:</td>
			<td class="forminp">
				<input name="PopUpAink_link" type="checkbox" <?php
				if($options[PopUpAink_link] == 'check') {
					echo 'checked="checked" value="check"';
				} else if($options[PopUpAink_link] != 'check') {
					echo 'value="check"';					
				} else {
					echo 'checked="checked" value="check"';
				}
				?> />
				<br /><small>Show PopUp Aink link.</small>
			</td>
		</tr>
	</tbody>
</table>
<input type="hidden" name="action" value="update" />
<input type="hidden" name="page_options" value="<?php get_option($options) ?>" />
<p class="submit bbot"><input name="save" type="submit" value="<?php esc_attr_e("Save Changes"); ?>" /></p>
</form>
</div>

	<div class="wrap"><hr /></div>

<div class="wrap">
<table class="widefat fixed" style="margin:25px 0;">
	<thead>
		<tr>
			<th scope="col" width="200px">Donate for PopUp Aink</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="forminp">
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="QW987VRNBV68N">
<img alt="" border="0" src="https://www.paypalobjects.com/WEBSCR-640-20110401-1/id_ID/i/scr/pixel.gif" width="1" height="1">
<p class="submit bbot"><input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!"></p>
</form>					
			</td>
		</tr>
	</tbody>
</table>
</div>

<?php }

if ($options['PopUpAink_enable'] == 'yes')
{
	add_action("plugins_loaded", "PopUpAink");
	add_action("wp_head", "PopUpAink_head");
}

function PopUpAink_head()
{
	global $options, $PopUpAink_path, $PopUpAinkCookieName;
	$options = get_option('PopUpAink_option');

	if($_COOKIE[$PopUpAinkCookieName] == NULL) {

	echo '
		<!-- PopUp Aink -->

			<link type="text/css" rel="stylesheet" href="'.$PopUpAink_path.'/css/popup-aink.css" />
			<style type="text/css">
				@font-face{
					font-family:Angelina;
					src:url("http://www.classifindo.com/fonts/Angelina.ttf");
				}
			</style>
			<script type="text/javascript" language="javascript" src="'.$PopUpAink_path.'/js/popup-aink.js"></script>
			<script type="text/javascript" language="JavaScript">
				$(document).ready(function(){
					$("div#PopUpAink").bPopup({
						opacity:0.8,
						modalClose:false
					});
				});
				var DaysToLive = "'.$options['PopUpAink_cookieday'].'";
				var CookieName = "'.$PopUpAinkCookieName.'";
				DaysToLive = parseInt(DaysToLive);
				var Value = "Created by PopUp Aink [www.classifindo.com]";
				function GetCookie() {
				var cookiecontent = "";
				if(document.cookie.length > 0) {
					var cookiename = CookieName + "=";
					var cookiebegin = document.cookie.indexOf(cookiename);
					var cookieend = 0;
					if(cookiebegin > -1) {
						cookiebegin += cookiename.length;
						cookieend = document.cookie.indexOf(";",cookiebegin);
						if(cookieend < cookiebegin) { cookieend = document.cookie.length; }
						cookiecontent = document.cookie.substring(cookiebegin,cookieend);
						}
					}
				if(cookiecontent.length > 0) { return true; }
				return false;
				}
				function SetCookie() {
				var exp = "";
				if(DaysToLive > 0) {
					var now = new Date();
					then = now.getTime() + (DaysToLive * 24 * 60 * 60 * 1000);
					now.setTime(then);
					exp = "; expires=" + now.toGMTString();
					cookiePath = "; path=/";
					}
				document.cookie = CookieName + "=" + Value + cookiePath + exp;
				return true;
				}
			</script>

		<!-- PopUp Aink -->';
	}
}

function PopUpAink() { global $options, $PopUpAinkCookieName; ?>
	<?php $options = get_option('PopUpAink_option'); ?>
	<?php if($_COOKIE[$PopUpAinkCookieName] == NULL) : ?>
	<div id="PopUpAink" style="display:none;">
		<div class="icon" align="right">
			<a class="bClose" onclick="SetCookie()" title="Close" style="cursor:pointer"></a>
			<?php if($options['PopUpAink_link'] == 'check'): ?>
				<a class="callbicon" title="PopUp Aink" href="http://www.classifindo.com/popup-aink/" target="_blank"></a>
			<?php endif; ?>
		</div>
		<div class="PopUpContent">
			<div class="Content" style="<?php if($options['PopUpAink_width'] != ''):?>width:<?php echo $options['PopUpAink_width'];?>;<?php endif;?><?php if($options['PopUpAink_height'] != ''):?>height:<?php echo $options['PopUpAink_height']; ?>;<?php endif ?>">
				<div style="display:block;"><?php echo stripslashes($options['PopUpAink_content']); ?></div>
			</div>
		</div>
		<?php if($options['PopUpAink_link'] == 'check'): ?>
		<div align="right" class="callb">
			<small><a href="http://www.classifindo.com/popup-aink/" target="_blank">PopUp Aink</a></small>
		</div>
		<?php endif; ?>
	</div>
<?php endif; } ?>