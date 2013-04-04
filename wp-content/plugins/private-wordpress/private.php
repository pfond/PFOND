<?php
/*
Plugin Name: Private WordPress
Plugin URI: http://jiehan.org/archives/119
Description: Manage the access rights of your WordPress blog easily.
Version: 1.3.4
Author: Jiehan Zheng
Author URI: http://jiehan.org

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.

*/

function pwp_add_textdomain() {
	load_plugin_textdomain('private-wordpress', 'wp-content/plugins/private-wordpress');
}

add_action('init', 'pwp_add_textdomain');

$enable = get_option('pwp_enable') == 0 ? false : true;
$method = (get_option('pwp_method') == 2 || $method = get_option('pwp_method') == 3) ? get_option('pwp_method') : 1;
$info = get_option('pwp_info') == '' ? __('<p class="message">Sorry, please login to view this blog.</p>', 'private-wordpress') : get_option('pwp_info');
$self_url = WP_PLUGIN_URL . '/private-wordpress/';
$feed_protect = get_option('pwp_feed') == 0 ? false : true;

if(!$enable) {
	function pwp_warning() {
		?><div class="updated fade">
	<strong>
		<p>
			<a href="options-general.php?page=private-wordpress/private.php">Private WordPress</a><?php _e(' is actived, but the protection function is currently disabled, your blog may be visible to everyone on the web.', 'private-wordpress'); ?>
		</p>
	</strong>
</div><?php
	}
	add_action('admin_notices', 'pwp_warning');
}
else {
	function pwp_rightnow() {
?><p><?php printf(__('The blog is currently under the protection of <a href="%s">Private WordPress</a>.', 'private-wordpress'), 'options-general.php?page=private-wordpress/private.php'); ?></p><?php
	}
	add_action('rightnow_end', 'pwp_rightnow');
}

function pwp_inner() {
	echo '<a href="options-general.php?page=private-wordpress/private.php">' . __('Modify more privacy options by going to Private WordPress plugin settings page.', 'private-wordpress') . '</a>';
}

function pwp_inner_add() {
	add_settings_section('pwp_inner', __('Additional Options', 'private-wordpress'), 'pwp_inner', 'privacy');}

function pwp_menu() {
	if(current_user_can('manage_options'))
		add_options_page('Private WordPress', 'Private WP', 9, __FILE__, 'pwp_page');
}

function pwp_page() {
	global $enable;
	global $method;
	global $info;
	global $feed_protect;
	if(!current_user_can('manage_options'))
		wp_die('You cheater!', 'Hey!');
	?><div class="wrap">
	
	<h2>Private WordPress</h2>
	
	<form method="post" action="options.php">
		<p><strong><?php _e('Note that the plugin may not capatable with cache plugins like WP Super Cache, be careful if cache plugins are currently enabled. I will look into this. :)', 'private-wordpress'); ?></strong></p>
	
		<?php wp_nonce_field('update-options'); ?>
		
		<h3><?php _e('Global Status', 'private-wordpress'); ?></h3>
		
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e('Protection', 'private-wordpress'); ?></th>
				<td>
					<label>
						<input type="radio" name="pwp_enable" value="1"<?php
						if($enable) echo ' checked="checked"';
						?> />
						<?php _e('Enable', 'private-wordpress'); ?>
					</label>
					<br />
					<label>
						<input type="radio" name="pwp_enable" value="0"<?php
						if(!$enable) echo ' checked="checked"';
						?> />
						<?php _e('Disable', 'private-wordpress'); ?>
					</label>
					<br />
					<p class="setting-description" style="font-style: italic;"><?php _e('Enable this options means start redirecting all guests to login page <strong>from now on</strong>.', 'private-wordpress'); ?></p>
				</td>
			</tr>
		</table>
		
		<h3><?php _e('When a guest comes ...', 'private-wordpress'); ?></h3>
		
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e('Method', 'private-wordpress'); ?></th>
				<td>
					<label>
						<input type="radio" name="pwp_method" value="1"<?php
						if($method == 1) echo ' checked="checked"';
						?> />
						<?php _e('Redirect to login page use function <code>auth_redirect</code>', 'private-wordpress'); ?>
					</label>
					 - <span class="setting-description" style="font-style: italic;"><?php _e('Recommend.', 'private-wordpress'); ?></span>
					<br />
					<label>
						<input type="radio" name="pwp_method" value="3"<?php
						if($method == 3) echo ' checked="checked"';
						?> />
						<?php _e('Show a image/page', 'private-wordpress'); ?>
					</label>
					 - <span class="setting-description" style="font-style: italic;"><?php _e('Replace the default image <code>sorry.png</code> / default page <code>sorry.html</code> in the plugin directory. The default image & page is prepared for the <a href="http://www.reuters.com/article/rbssITServicesConsulting/idUSPEK37237320090622">Internet boycott in China on Jul/1/2009</a>.', 'private-wordpress'); ?></span>
					<br />
					<label>
						<input type="radio" name="pwp_method" value="2"<?php
						if($method == 2) echo ' checked="checked"';
						?> />
						<?php _e('Redirect to login page use function <code>wp_redirect</code>', 'private-wordpress'); ?>
					</label>
					 - <span class="setting-description" style="font-style: italic;"><?php _e('Choose this if you encoraged problems using the normal method.', 'private-wordpress'); ?></span>
				</td>
			</tr>
		</table>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e('RSS & Atom feed', 'private-wordpress'); ?></th>
				<td>
					<label>
						<input type="radio" name="pwp_feed" value="0"<?php
						if(!$feed_protect) echo ' checked="checked"';
						?> />
						<?php _e('Allow all feed access', 'private-wordpress'); ?>
					</label>
					 - <span class="setting-description" style="font-style: italic;"><?php _e('Guests may continue read your blog via feed readers.', 'private-wordpress'); ?></span>
					<br />
					<label>
						<input type="radio" name="pwp_feed" value="1"<?php
						if($feed_protect) echo ' checked="checked"';
						?> />
						<?php _e('Deny all guests\' feed access', 'private-wordpress'); ?>
					</label>
					 - <span class="setting-description" style="font-style: italic;"><?php _e('No one besides you are able to access the feed.', 'private-wordpress'); ?></span>
				</td>
			</tr>
		</table>
		
		<h3><?php _e('Tell something to your guests ...', 'private-wordpress'); ?></h3>
		
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><?php _e('Login message', 'private-wordpress'); ?></th>
				<td>
					<textarea rows="3" style="width: 99%;" name="pwp_info"><?php echo $info ?></textarea>
					<p class="setting-description" style="font-style: italic;"><?php _e('This message will be shown to visitors who haven\'t logged in already. HTML tags are allowed.', 'private-wordpress'); _e(' To apply WordPress\'s default style, use <code>&lt;p class="message"&gt;</code> and <code>&lt;/p&gt;</code> to wrap your own message.', 'private-wordpress'); ?></p>
				</td>
			</tr>
		</table>
		
		
		<input type="hidden" name="action" value="update" />
		<input type="hidden" name="page_options" value="pwp_enable,pwp_method,pwp_info,pwp_feed" />
		
		
		<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
		</p>
	</form>
</div>
<?php
}

add_action('admin_init', 'pwp_inner_add');
add_action('admin_menu', 'pwp_menu');

function private_wp() {
	global $method;
	global $self_url;
	if(!is_user_logged_in()) {
		if($method == 3) {
			wp_redirect($self_url . 'sorry.html');
		}
		
		if($method == 1 && function_exists('auth_redirect')) {
			auth_redirect();
		}
		else if($method != 3) {
			wp_redirect(get_option('siteurl') . '/wp-login.php');
			update_option('pwp_method', 2);
		}
	}
}

function pwp_login_meta() {
	$siteurl = get_option('siteurl');
	echo "<link rel=\"pingback\" href=\"$siteurl/xmlrpc.php\" />
	<link rel=\"EditURI\" type=\"application/rsd+xml\" title=\"RSD\" href=\"$siteurl/xmlrpc.php?rsd\" /> 
	<link rel=\"wlwmanifest\" type=\"application/wlwmanifest+xml\" href=\"$siteurl/wp-includes/wlwmanifest.xml\" />
	";
}

function pwp_login_message($message) {
	global $info;
	return $info . $message;
}

if($enable) {
	add_action('login_head', pwp_login_meta);
	add_filter('login_message', pwp_login_message);
	add_action('get_header', private_wp, 9);
	if($feed_protect) {
		add_action('do_feed_rss2', private_wp, 0);
		add_action('do_feed_rss', private_wp, 0);
		add_action('do_feed_atom', private_wp, 0);
		add_action('do_feed_rdf', private_wp, 0);
		add_action('do_feed_comments_rss2', private_wp, 0);
	}
}

?>