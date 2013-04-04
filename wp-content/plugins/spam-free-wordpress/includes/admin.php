<?php

// Add Admin Options Page
add_action('admin_menu', 'register_spam_free_wordpress_options_page');

// Register Admin Options Page
function register_spam_free_wordpress_options_page() {
	add_options_page(
		'Spam Free Wordpress Configuration',
		'Spam Free Wordpress',
		'manage_options',
		'spam-free-wordpress-admin-page',
		'spam_free_wordpress_options_page'
		);
}

// Admin Settings Options Page function
function spam_free_wordpress_options_page() {

	// Check to see if user has adequate permission to access this page
	if (!current_user_can('manage_options')){
      wp_die( __( 'You do not have sufficient permissions to access this page.', 'spam-free-wordpress' ) );
    }

	global $spam_free_wordpress_version;

?>
<div class="wrap">
	<?php screen_icon( 'edit-comments' );?>
    <h2>Spam Free Wordpress <?php echo SFW_VERSION; ?> <?php _e( 'Settings', 'spam-free-wordpress' ); ?></h2>

	<form method="POST" action="">
<?php
		if (isset( $_POST['options'] ) ) {
			update_option('spam_free_wordpress', $_POST['spam_free_wordpress_options']);
			// Display saved message when options are updated.
			$spam_free_wordpress_options = get_option( 'spam_free_wordpress' );
			if( $spam_free_wordpress_options['ping_status'] == 'open' ) {
				sfw_open_pingbacks();
			} elseif( $spam_free_wordpress_options['ping_status'] == 'closed' ) {
				sfw_close_pingbacks();
			}

			$sfw_update_msg = __( 'Settings updated', 'spam-free-wordpress' );

			if ( function_exists( 'w3tc_pgcache_flush' ) ) {
				w3tc_pgcache_flush();
				$sfw_update_msg .= ' &amp; ';
				$sfw_update_msg .= __( 'W3 Total Cache Page Cache flushed', 'spam-free-wordpress' );
			} elseif( function_exists( 'wp_cache_clear_cache' ) ) {
				wp_cache_clear_cache();
				$sfw_update_msg .= ' &amp; ';
				$sfw_update_msg .= __( 'WP Super Cache flushed', 'spam-free-wordpress' );
			}
			
			echo '<div id="message" class="updated"><p>'. $sfw_update_msg .'.</p></div>';
		}
		
		$spam_free_wordpress_options = get_option( 'spam_free_wordpress' );
		$sfw_save_changes = __( 'Save Changes', 'spam-free-wordpress' );
?>

<table class="form-table">
	<tr>
		<td colspan="2" valign="top">
			<h3><span style="border-bottom: 2px solid #99ccff; padding: 3px;"><?php _e( 'Comment Form Spam Stats', 'spam-free-wordpress' ); ?></span></h3>
			<p><h3><?php _e( 'Turn on your stats to say thank you.', 'spam-free-wordpress' ); ?></h3> <?php _e( 'This will also display a link to the plugin page on your comment form.', 'spam-free-wordpress' ); ?></p>
			<fieldset>
				<p>On <input type="radio" name="spam_free_wordpress_options[toggle_stats_update]" <?php echo (($spam_free_wordpress_options['toggle_stats_update'] == "enable") ? 'checked="checked"' : '') ;  ?> value="enable" />&nbsp;&nbsp; Off <input type="radio" name="spam_free_wordpress_options[toggle_stats_update]" <?php echo (($spam_free_wordpress_options['toggle_stats_update'] == "disable") ? 'checked="checked"' : '') ;  ?> value="disable" /></p>
			</fieldset>
			
			<h3><span style="border-bottom: 2px solid #99ccff; padding: 3px;"><?php _e( 'Password Style', 'spam-free-wordpress' ); ?></span></h3>
			<p><?php _e( 'Turn on Comment Form Spam Stats above to make sure the invisible password is working.', 'spam-free-wordpress' ); ?></p>
			<p><?php _e( 'If you cannot see the Spam Stats, and you cannot leave a comment, it is not working, which means you need help customizing your comment form.', 'spam-free-wordpress' ); ?></p>
			<fieldset>
				<select name="spam_free_wordpress_options[pwd_style]">
					<option value="invisible_password" <?php selected( $spam_free_wordpress_options['pwd_style'], 'invisible_password' ); ?>>Invisible Password</option>
					<option value="click_password_field" <?php selected( $spam_free_wordpress_options['pwd_style'], 'click_password_field' ); ?>>Click Password Field</option>
					<option value="click_password_button" <?php selected( $spam_free_wordpress_options['pwd_style'], 'click_password_button' ); ?>>Click Password Button</option>
				</select>
			</fieldset>
			
			<h3><span style="border-bottom: 2px solid #99ccff; padding: 3px;"><?php _e( 'Automatically Generate Comment Form', 'spam-free-wordpress' ); ?></span></h3>
				<p><?php _e( 'Will automatically generate the comment form.', 'spam-free-wordpress' ); ?></p>
				<fieldset>
					<p>On <input type="radio" name="spam_free_wordpress_options[comment_form]" <?php echo (($spam_free_wordpress_options['comment_form'] == "on") ? 'checked="checked"' : '') ;  ?> value="on" />&nbsp;&nbsp; Off <input type="radio" name="spam_free_wordpress_options[comment_form]" <?php echo (($spam_free_wordpress_options['comment_form'] == "off") ? 'checked="checked"' : '') ;  ?> value="off" /></p>
				</fieldset>
			
			<h3><span style="border-bottom: 2px solid #99ccff; padding: 3px;"><?php _e( 'Remove HTML from Comments', 'spam-free-wordpress' ); ?></span></h3>
			<p><?php _e( 'Strips the HTML from comments to render spam links as plain text. Also removes the allowed HTML tags message from below the comment box.', 'spam-free-wordpress' ); ?></p>			
				<fieldset>
					<p>On <input type="radio" name="spam_free_wordpress_options[toggle_html]" <?php echo (($spam_free_wordpress_options['toggle_html'] == "enable") ? 'checked="checked"' : '') ;  ?> value="enable" />&nbsp;&nbsp; Off <input type="radio" name="spam_free_wordpress_options[toggle_html]" <?php echo (($spam_free_wordpress_options['toggle_html'] == "disable") ? 'checked="checked"' : '') ;  ?> value="disable" /></p>
				</fieldset>
				
			<h3><span style="border-bottom: 2px solid #99ccff; padding: 3px;"><?php _e( 'Remove URL Form Field', 'spam-free-wordpress' ); ?></span></h3>
			<p><?php _e( 'Removes the URL (web site address) comment form field, so it cannot be used as a spam link.', 'spam-free-wordpress' ); ?></p>			
				<fieldset>
					<p>On <input type="radio" name="spam_free_wordpress_options[remove_author_url_field]" <?php echo (($spam_free_wordpress_options['remove_author_url_field'] == "enable") ? 'checked="checked"' : '') ;  ?> value="enable" />&nbsp;&nbsp; Off <input type="radio" name="spam_free_wordpress_options[remove_author_url_field]" <?php echo (($spam_free_wordpress_options['remove_author_url_field'] == "disable") ? 'checked="checked"' : '') ;  ?> value="disable" /></p>
				</fieldset>
				
			<h3><span style="border-bottom: 2px solid #99ccff; padding: 3px;"><?php _e( 'Remove Comment Author Clickable Link', 'spam-free-wordpress' ); ?></span></h3>
			<p><?php _e( 'Disables the comment author clickable link if the comment author fills in the URL (web site) comment form field.', 'spam-free-wordpress' ); ?></p>			
				<fieldset>
					<p>On <input type="radio" name="spam_free_wordpress_options[remove_author_url]" <?php echo (($spam_free_wordpress_options['remove_author_url'] == "enable") ? 'checked="checked"' : '') ;  ?> value="enable" />&nbsp;&nbsp; Off <input type="radio" name="spam_free_wordpress_options[remove_author_url]" <?php echo (($spam_free_wordpress_options['remove_author_url'] == "disable") ? 'checked="checked"' : '') ;  ?> value="disable" /></p>
				</fieldset>
				
			<h3><span style="border-bottom: 2px solid #99ccff; padding: 3px;"><?php _e( 'Password Form Customization', 'spam-free-wordpress' ); ?></span></h3>
				<fieldset>
					<p>
					<input type="text" name="spam_free_wordpress_options[pw_field_size]" size="2" value="<?php echo $spam_free_wordpress_options['pw_field_size']; ?>" style="color: #000000; background-color: #fffbcc" />&nbsp;&nbsp;<?php _e( ' Password Field Size.', 'spam-free-wordpress' ); ?>
					&nbsp;&nbsp;&nbsp;<input type="text" name="spam_free_wordpress_options[tab_index]" size="2" value="<?php echo $spam_free_wordpress_options['tab_index']; ?>" style="color: #000000; background-color: #fffbcc" />&nbsp;&nbsp;<?php _e( ' Tab Index', 'spam-free-wordpress' ); ?>
					</p>
				</fieldset>

			<h3><span style="border-bottom: 2px solid #99ccff; padding: 3px;"><?php _e( 'Remote Comment Blocklist', 'spam-free-wordpress' ); ?></span></h3>
			<p><?php _e( 'The Remote Comment Blocklist accesses a text file list of IP addresses on a remote server to block comment spam. This allows a global IP address blocklist to be shared with multiple blogs. The Remote Comment Blocklist and the Local Comment Blocklist can be used at the same time. The Remote Comment Blocklist works exactly the same way as the Local Comment Blocklist, except it is on a remote server. The URL to the remote text file could be for example: <code>http://www.example.com/mybl/bl.txt</code>', 'spam-free-wordpress' ); ?></p>
			<p><code>#</code><?php _e( ' can be used to comment out an IP address.', 'spam-free-wordpress' ); ?></p>
				<fieldset>
					<p>On <input type="radio" name="spam_free_wordpress_options[rbl_enable_disable]" <?php echo (($spam_free_wordpress_options['rbl_enable_disable'] == "enable") ? 'checked="checked"' : '') ;  ?> value="enable" />&nbsp;&nbsp; Off <input type="radio" name="spam_free_wordpress_options[rbl_enable_disable]" <?php echo (($spam_free_wordpress_options['rbl_enable_disable'] == "disable") ? 'checked="checked"' : '') ;  ?> value="disable" />
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="60" name="spam_free_wordpress_options[remote_blocked_list]" value="<?php echo esc_url($spam_free_wordpress_options['remote_blocked_list']); ?>" style="color: #000000; background-color: #fffbcc" />&nbsp;&nbsp;<?php _e( ' Enter URL to remote text file.', 'spam-free-wordpress' ); ?></p>
				</fieldset>
				
			<h3><span style="border-bottom: 2px solid #99ccff; padding: 3px;"><?php _e( 'Share Link Custom Message', 'spam-free-wordpress' ); ?></span></h3>
			<p><?php _e( 'Customize a URL link to the ', 'spam-free-wordpress' ); ?>Spam Free Wordpress<?php _e( ' plugin page below if you want to share it with others somewhere else on your blog other than the comment form.', 'spam-free-wordpress' ); ?></p>
				<fieldset>
					<p><?php _e( 'Link Message ', 'spam-free-wordpress' ); ?>&nbsp;&nbsp;<input type="text" size="60" name="spam_free_wordpress_options[affiliate_msg]" value="<?php echo $spam_free_wordpress_options['affiliate_msg']; ?>" style="color: #000000; background-color: #fffbcc" /> &nbsp;&nbsp;<?php if(function_exists('sfw_custom_affiliate_link')) { sfw_custom_affiliate_link(); } ?></p>
				</fieldset>
			<p><?php _e( 'Copy and paste the line of code below into a template file to display the custom share link.', 'spam-free-wordpress' ); ?></p>
			<code>&lt;?php if(function_exists('sfw_custom_affiliate_link')) { sfw_custom_affiliate_link(); } ?&gt;</code>
			
			<h3><span style="border-bottom: 2px solid #99ccff; padding: 3px;"><?php _e( 'Pingbacks and Trackbacks', 'spam-free-wordpress' ); ?></span></h3>
			<p><strong><?php _e( 'It is highly recommended to keep pingbacks CLOSED to eliminate that form of spam entirely.', 'spam-free-wordpress' ); ?></strong></p>
			<p><?php _e( 'Pingbacks can cause a downgrade in SEO ranking, and are almost entirely spam. Pingbacks are not worth the trouble they bring, but if you still want them it is your choice.', 'spam-free-wordpress' ); ?></p>
				<fieldset>
					<p><?php _e( 'Open ', 'spam-free-wordpress' ); ?><input type="radio" name="spam_free_wordpress_options[ping_status]" <?php echo (($spam_free_wordpress_options['ping_status'] == "open") ? 'checked="checked"' : '') ;  ?> value="open" />&nbsp;&nbsp;<?php _e( ' Closed ', 'spam-free-wordpress' ); ?><input type="radio" name="spam_free_wordpress_options[ping_status]" <?php echo (($spam_free_wordpress_options['ping_status'] == "closed") ? 'checked="checked"' : '') ;  ?> value="closed" /></p>
				</fieldset>
				
			<h3><span style="border-bottom: 2px solid #99ccff; padding: 3px;"><?php _e( 'Message Above Comment Text Area', 'spam-free-wordpress' ); ?></span></h3>
				<fieldset>
					<textarea name="spam_free_wordpress_options[special_msg]" cols='100' rows='9' style="color: #000000; background-color: #fffbcc"><?php echo stripslashes( $spam_free_wordpress_options['special_msg'] ); ?></textarea>
				</fieldset>
			
			<td valign="top">
				<div align="center"><h3><span style="border-bottom: 2px solid #99ccff; padding: 3px;"><?php _e( 'Blocked Spam Comments', 'spam-free-wordpress' ); ?></span></h3>
				</div>
					<p align="center"><b><span style="font-size:200%;"><?php echo number_format_i18n(get_option('sfw_spam_hits')); ?></span></big></b></p>
				<div align="center" style="margin-left:5px;">
					<iframe width="355" height="900" frameborder="0" src="http://www.toddlahman.com/plugin-news/sfw/spw-plugin-news.php"></iframe>
				</div>
			</td>
		</td>
			
	<tr>
		<td valign="middle">		
			<h3><span style="border-bottom: 2px solid #99ccff; padding: 3px;"><?php _e( 'Local Comment Blocklist', 'spam-free-wordpress' ); ?></span></h3>
			<p><?php _e( 'The Local Blocklist is a list of blocked IP addresses stored in the blog database. When a comment comes from an IP address matching the Blocklist it will be blocked, which means you will never see it as waiting for approval or marked as spam. Blocked commenters will be able to view your blog, but any comments they submit will be blocked, which means not saved to the database, and they will see the message ', 'spam-free-wordpress' ); ?>&#8220;<?php _e( 'Spam Blocked.', 'spam-free-wordpress' ); ?>&#8221;</p>
			<p><?php _e( 'Enter one IP address per line. Wildcards like 192.168.1.* will not work.', 'spam-free-wordpress' ); ?></p>
			<p><code>#</code><?php _e( ' can be used to comment out an IP address.', 'spam-free-wordpress' ); ?></p>
				<fieldset>
					<p>On <input type="radio" name="spam_free_wordpress_options[lbl_enable_disable]" <?php echo (($spam_free_wordpress_options['lbl_enable_disable'] == "enable") ? 'checked="checked"' : '') ;  ?> value="enable" />&nbsp;&nbsp; Off <input type="radio" name="spam_free_wordpress_options[lbl_enable_disable]" <?php echo (($spam_free_wordpress_options['lbl_enable_disable'] == "disable") ? 'checked="checked"' : '') ;  ?> value="disable" />
				</fieldset>
		</td>
		<td valign="middle">
					<p align="center"><strong><?php _e( 'IP Addresses Go Here', 'spam-free-wordpress' ); ?></strong></p>
				<fieldset>
					<textarea name="spam_free_wordpress_options[blocklist_keys]" cols='20' rows='9' style="color: #000000; background-color: #fffbcc"><?php echo esc_textarea($spam_free_wordpress_options['blocklist_keys']); ?></textarea>
				</fieldset>
		</td>
	</tr>
	<tr>
		<td colspan="2" valign="top">
			
			<?php submit_button( $sfw_save_changes, 'primary', 'options' ); ?>
			
		</td>
	</tr>
	</tr>
</table>
</form>
</div>

<?php

}

?>