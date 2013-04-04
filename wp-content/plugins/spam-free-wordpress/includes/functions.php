<?php

/*
* Legacy function for versions prior to 1.7.8
*/
function tl_spam_free_wordpress_comments_form() {
	sfw_comment_form_extra_fields();
}

// Adds password field to comment form and options to filter HTML from comments
function sfw_comment_form_additions() {
	global $spam_free_wordpress_options;

	// Calls the password form for comments.php if the comment_form function is outputting comment form fields
	add_action('comment_form_after_fields', 'sfw_comment_form_extra_fields', 1);
		
	// Strips out html from comment form when enabled
	if ( $spam_free_wordpress_options['toggle_html'] == "enable" ) {
		// Removes all HTML from comments and leaves it only as text
		remove_filter('comment_text', 'make_clickable', 9);
		// line above doesn't make everything unclickable
		add_filter('comment_text', 'wp_filter_nohtml_kses');
		add_filter('comment_text_rss', 'wp_filter_nohtml_kses');
		add_filter('comment_excerpt', 'wp_filter_nohtml_kses');
		// remove tags from below comment form
		//add_filter('comment_form_defaults','sfw_remove_allowed_tags_field');
		// replaced line above to add no html notice
		add_filter('comment_form_defaults','sfw_no_html_notice');
		
		/*-----------------------
		Custom Theme Support
		------------------------*/
		
		$sfw_get_current_theme = get_current_theme();
		
		// Suffusion
		if ( $sfw_get_current_theme == 'Suffusion' ) {
			add_filter('suffusion_comment_form_fields','sfw_no_html_notice');
		}
			
		// Genesis
		if ( $sfw_get_current_theme == 'Genesis/genesis' ) {
			add_action('genesis_after_comment_form','sfw_no_html_notice_action');
		}
			
		// Graphene
		if ( $sfw_get_current_theme == 'Graphene' ) {
			add_filter('graphene_comment_form_args','sfw_no_html_notice');
		}
			
		// Thesis
		if ( $sfw_get_current_theme == 'Thesis' ) {
			add_action('thesis_hook_comment_field', 'sfw_comment_form_extra_fields');
			add_action('thesis_hook_after_comment_box','sfw_no_html_notice_action');
		}
			
		// Thematic
		if ( $sfw_get_current_theme == 'Thematic' ) {
			define('THEMATIC_COMPATIBLE_COMMENT_FORM', true);
			add_filter('thematic_comment_form_args','sfw_no_html_notice');
		}
	
	}

	if ( $spam_free_wordpress_options['remove_author_url_field'] == "enable" ) {
		add_filter('comment_form_field_url', 'sfw_remove_url_field_off');
	}

	if ( $spam_free_wordpress_options['remove_author_url'] == "enable" ) {
		add_filter('get_comment_author_url', 'strip_author_url');
	}
}

/*--------------------------------
Strip HTML out of comments
----------------------------------*/

/* Replaced with html message below
// Remove note after comment box that says which HTML tags can be used in comment
function sfw_remove_allowed_tags_field($no_allowed_tags) {
    unset($no_allowed_tags['comment_notes_after']);
    return $no_allowed_tags;
}
*/

// Friendly no HTML allowed notice under comment form
function sfw_no_html_notice($nohtml) {
	$sfw_tag_msg = __( 'HTML tags are not allowed.', 'spam-free-wordpress' );
	$nohtml['comment_notes_after'] = '<p><b>'. $sfw_tag_msg .'</b></p>';
	return $nohtml;
}

function sfw_no_html_notice_action() {
	$sfw_tag_msg = __( 'HTML tags are not allowed.', 'spam-free-wordpress' );
	echo '<p><b>'. $sfw_tag_msg .'</b></p>';
}

// Remove url field from comment form, but only if the comment form uses the comment_form function
function sfw_remove_url_field_off($no_url) {
    return '';
}

// Remove comment author link
function strip_author_url($content = "") {
  return "";
}

// Gets the remote IP address even if behind a proxy
function get_remote_ip_address() {
	if(!empty($_SERVER['HTTP_CLIENT_IP'])) {
		$ip_address = $_SERVER['HTTP_CLIENT_IP'];
	} else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else if(!empty($_SERVER['REMOTE_ADDR'])) {
		$ip_address = $_SERVER['REMOTE_ADDR'];
	} else {
		$ip_address = '';
	}
	return $ip_address;
}

// AJAX function to obtain client IP address
function get_remote_ip_address_ajax() {
	if(!empty($_SERVER['HTTP_CLIENT_IP'])) {
		$ip_address = $_SERVER['HTTP_CLIENT_IP'];
	} else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else if(!empty($_SERVER['REMOTE_ADDR'])) {
		$ip_address = $_SERVER['REMOTE_ADDR'];
	} else {
		$ip_address = '';
	}
	echo $ip_address;
	
	die();
}

// Returns Local Blocklist
function sfw_local_blocklist_check( $cip ) {
	global $spam_free_wordpress_options;

	$local_blocklist_keys = trim( $spam_free_wordpress_options['blocklist_keys'] );
	if ( '' == $local_blocklist_keys )
		return false; // If blocklist keys are empty
	$local_key = explode("\n", $local_blocklist_keys );

	foreach ( (array) $local_key as $lkey ) {
		$lkey = trim($lkey);

		// Skip empty lines
		if ( empty($lkey) ) { continue; }

		// Can use '#' to comment out line in blocklist
		$lkey = preg_quote($lkey, '#');

		$pattern = "#$lkey#i";
		if (
			   preg_match($pattern, $cip)
		 )
			return true;
	}
	return false;
}

// Returns Remote Blocklist
function sfw_remote_blocklist_check( $cip ) {
	global $spam_free_wordpress_options;
	
	// Retrieves remote blocklist url from database
	$rbl_url = $spam_free_wordpress_options['remote_blocked_list'];
	// Uses a URL to retrieve a list of IP address in an array
	$get_remote_blocklist = wp_remote_get($rbl_url);
	
	if ( '' == $rbl_url )
		return false; // If blocklist keys are empty or url is not in the database
	$remote_key = explode("\n", $get_remote_blocklist['body'] ); // Turns blocklist array into string and lists each IP address on new line

	foreach ( (array) $remote_key as $rkey ) {
		$rkey = trim($rkey);

		// Skip empty lines
		if ( empty($rkey) ) { continue; }

		// Can use '#' to comment out line in blocklist
		$rkey = preg_quote($rkey, '#');

		$pattern = "#$rkey#i";
		if (
			   preg_match($pattern, $cip)
		 )
			return true;
	}
	return false;
}

// Customizable Affiliate link
function sfw_custom_affiliate_link() {
	$spam_free_wordpress_options = get_option('spam_free_wordpress');

	$default_aff_msg = __( 'Make Your Blog Spam Free', 'spam-free-wordpress' );
	$aff_msg = $spam_free_wordpress_options['affiliate_msg'];
	
	if ($spam_free_wordpress_options['affiliate_msg'] =='') {
		echo "<a href='http://www.toddlahman.com/spam-free-wordpress/'>". $default_aff_msg ."</a>";
	} else {
		echo "<a href='http://www.toddlahman.com/spam-free-wordpress/'>".$aff_msg."</a>";
	}
}

// Function for comments.php file
function sfw_comment_form_extra_fields() {
	global $post, $spam_free_wordpress_options;
	
	$sfw_comment_form_password_var = get_post_meta( $post->ID, 'sfw_comment_form_password', true );
	
	$sfw_pw_field_size = $spam_free_wordpress_options['pw_field_size'];
	$sfw_tab_index = $spam_free_wordpress_options['tab_index'];

	// If the reader is logged in don't require password for comments.php
	if ( !is_user_logged_in() ) {
		
		// Spam Count
		echo '<!-- ' . number_format_i18n( get_option( 'sfw_spam_hits' ) );
		_e( ' Spam Comments Blocked so far by ', 'spam-free-wordpress' );
		echo 'Spam Free Wordpress';
		_e( ' version ', 'spam-free-wordpress' );
		echo SFW_VERSION;
		_e( ' located at ', 'spam-free-wordpress' );
		echo "http://www.toddlahman.com/spam-free-wordpress/ -->\n";
		
		echo stripslashes( $spam_free_wordpress_options['special_msg'] );
		

		if ( $spam_free_wordpress_options['pwd_style'] == 'invisible_password' ) {
			wp_nonce_field('sfw_nonce','sfw_comment_nonce');
			echo '<p><noscript>JavaScript must be enabled to leave a comment.</noscript></p>';
			echo "<input type='hidden' name='pwdfield' class='pwddefault' value='' />\n";
			echo "<input type='hidden' name='comment_ip' id='comment_ip' value='' />\n";
		
		} elseif ( $spam_free_wordpress_options['pwd_style'] == 'click_password_field' ) {
			wp_nonce_field('sfw_nonce','sfw_comment_nonce');
			echo "\n<p><input type='text' class='pwddefault' name='pwdfield' rel='".__( 'Click for Password', 'spam-free-wordpress' )."' value='' readonly='readonly' size='".$sfw_pw_field_size."' /></p>\n";
			echo '<p><noscript>JavaScript must be enabled to leave a comment.</noscript></p>';
			echo '<p id="comment_ready"></p>'."\n";
			echo "<input type='hidden' name='comment_ip' id='comment_ip' value='' />\n";

		} elseif ( $spam_free_wordpress_options['pwd_style'] == 'click_password_button' ) {
			wp_nonce_field('sfw_nonce','sfw_comment_nonce');
			echo "\n<p><input type='text' id='pwdfield' name='pwdfield' value='' size='".$sfw_pw_field_size."' readonly='readonly' /></p>";
			echo '<p><noscript>JavaScript must be enabled to leave a comment.</noscript></p>';
			echo "\n".'<p><button type="button" id="pwdbtn">';
			_e( 'Click for Password', 'spam-free-wordpress' );
			echo '</button></p>';
			echo '<p id="comment_ready"></p>';
			echo "<input type='hidden' name='comment_ip' id='comment_ip' value='' />\n";
		}
		
		// Shows how many comment spam have been killed on the comment form
		if ($spam_free_wordpress_options['toggle_stats_update'] == "enable") {
				echo '<p>' . number_format_i18n( get_option('sfw_spam_hits' ) );
				_e( ' Spam Comments Blocked so far by ', 'spam-free-wordpress' );
				echo '<a href="http://www.toddlahman.com/spam-free-wordpress/" title="Spam Free Wordpress" target="_blank">Spam Free Wordpress</a></p>'."\n";
		} else {
				echo "";
		}
		
		// Automatically cleanup Post Meta Custom Fields since transients are now used
		delete_post_meta( $post->ID, 'sfw_comment_form_password' );
		
	}
}

// Function for wp-comments-post.php file located in the root Wordpress directory. The same directory as the wp-config.php file.
function sfw_comment_post_authentication() {
	global $post, $spam_free_wordpress_options;
	
	//$sfw_comment_script = get_post_meta( $post->ID, 'sfw_comment_form_password', true );
	$sfw_comment_script = get_transient( $post->ID. '-' .$_POST['pwdfield'] );
	
	$cip = $_POST['comment_ip'];
	
	// If the reader is logged in don't require password for wp-comments-post.php
	if ( !is_user_logged_in() ) {
		// Nonce check
		if ( empty( $_POST['sfw_comment_nonce'] ) || !wp_verify_nonce( $_POST['sfw_comment_nonce'],'sfw_nonce' ) )
			wp_die( __( 'Spam Free Wordpress rejected your comment because you failed a critical security check.', 'spam-free-wordpress' ) . sfw_spam_counter(), 'Spam Free Wordpress rejected your comment', array( 'response' => 200, 'back_link' => true ) );
		
		// Compares current comment form password with current password for post
		if ( empty( $_POST['pwdfield'] ) || $_POST['pwdfield'] != $sfw_comment_script )
			wp_die( __( 'Spam Free Wordpress rejected your comment because you did not enter the correct password or it was empty.', 'spam-free-wordpress' ) . sfw_spam_counter(), 'Spam Free Wordpress rejected your comment', array( 'response' => 200, 'back_link' => true ) );
		
		// Compares commenter IP address to local blocklist
		if ( $spam_free_wordpress_options['lbl_enable_disable'] == 'enable' ) {
			if ( empty( $_POST['comment_ip'] ) || $_POST['comment_ip'] == sfw_local_blocklist_check( $cip ) )
				wp_die( __( 'Comment blocked by Spam Free Wordpress because your IP address is in the local blocklist, or you forgot to type a comment.', 'spam-free-wordpress' ) . sfw_spam_counter(), 'Spam Blocked by Spam Free Wordpress local blocklist', array( 'response' => 200, 'back_link' => true ) );
		}
		
		// Compares commenter IP address to remote blocklist
		if ( $spam_free_wordpress_options['rbl_enable_disable'] == 'enable' ) {
			if ( empty( $_POST['comment_ip'] ) || $_POST['comment_ip'] == sfw_remote_blocklist_check( $cip ) )
				wp_die( __( 'Comment blocked by Spam Free Wordpress because your IP address is in the remote blocklist, or you forgot to type a comment.', 'spam-free-wordpress' ) . sfw_spam_counter(), 'Spam Blocked by Spam Free Wordpress remote blocklist', array( 'response' => 200, 'back_link' => true ) );
		}
	}
}

// Counts number of comment spam hits and stores in options database table
function sfw_spam_counter() {
	$s_hits = get_option('sfw_spam_hits');
	update_option('sfw_spam_hits', $s_hits+1);
}

/*------------------------------------------------------------------------
Pingbacks and trackbacks are closed automatically if they are open
--------------------------------------------------------------------------*/

function sfw_close_pingbacks() {
	global $wpdb;

	$sql =
		"
		UPDATE $wpdb->posts
		SET ping_status = 'closed'
		WHERE ping_status = 'open'
		";
	
	$sfw_close_ping = $wpdb->query( $wpdb->prepare( $sql ) );

	update_option( 'default_ping_status', 'closed' );
	update_option( 'default_pingback_flag', '' );

}

function sfw_open_pingbacks() {
	global $wpdb;

	$sql =
		"
		UPDATE $wpdb->posts
		SET ping_status = 'open'
		WHERE ping_status = 'closed'
		";
	
	$sfw_open_ping = $wpdb->query( $wpdb->prepare( $sql ) );

	update_option( 'default_ping_status', 'open' );
	update_option( 'default_pingback_flag', '1' );

}

/*-----------------------------------------
Closes user registration security hole
------------------------------------------*/

function sfw_close_auto_user_registration() {
	update_option( 'users_can_register', '0' );
}

// Adds settings link to plugin menu
function sfw_settings_link($links) {
	$links[] = '<a href="'.admin_url('options-general.php?page=spam-free-wordpress-admin-page').'">Settings</a>';
	return $links;
}

/**
* Corrects the Notice: Undefined index: checkbox error when the check box is not checked, and thus sends an empty value. This function gives it a value when using the WordPress checked function.
* Unfortunately a value is not stored in the database when unchecked. This problem can be corrected when using the Settings API which stores a value if checked or unchecked using a Ternary Operator
* http://wordpress.org/support/topic/problem-with-checked-function?replies=6
* Box starts out unchecked
* http://wordpress.stackexchange.com/questions/43752/settings-api-easiest-way-of-validating-checkboxes
* $valid_input[$setting] = ( isset( $input[$setting] ) && true == $input[$setting] ? true : false );
*/
function sfw_unchecked( $checkoption ) {
	$spam_free_wordpress_options = get_option('spam_free_wordpress');
	if ( ! isset( $spam_free_wordpress_options[$checkoption] ) ) {
		$spam_free_wordpress_options[$checkoption] = 'enable';
	}
	echo '<input type="checkbox" name="spam_free_wordpress_options['. $checkoption .']" value="disable"'. checked( $spam_free_wordpress_options[$checkoption], 'disable', false ) .' />';
}


/*-----------------------------------------
* Generates temporary passwords
------------------------------------------*/

function sfw_get_pwd() {
	$postid = $_POST['post_id'];
	
	$pwd = wp_generate_password(12, false);
	set_transient( $postid. '-' .$pwd, $pwd, 60 * 20 ); // expire password after 20 minutes
	$pwd_key = get_transient( $postid. '-' .$pwd );
	
	echo $pwd_key;
	
	die();
}

/*--------------------------------------------------------------------
* X-Autocomplete Comment Form Fields for Chrome 15 and above
* http://wiki.whatwg.org/wiki/Autocompletetype
* http://googlewebmastercentral.blogspot.com/2012/01/making-form-filling-faster-easier-and.html
---------------------------------------------------------------------*/

function sfw_add_x_autocompletetype( $fields ) {
	$fields['author'] = str_replace( '<input', '<input x-autocompletetype="name-full"', $fields['author'] );
	$fields['email'] = str_replace( '<input', '<input x-autocompletetype="email"', $fields['email'] );
	return $fields;
}

add_filter('comment_form_default_fields','sfw_add_x_autocompletetype');


/*
* Load JavaScript for comment form
* Requires jQuery 1.7 or Above
*/
function sfw_load_pwd() {
	global $spam_free_wordpress_options;

	if ( $spam_free_wordpress_options['pwd_style'] == 'invisible_password' ) {
		$js_path =  SFW_URL . 'js/sfw-ipwd.js';
		wp_enqueue_script( 'sfw_ipwd', $js_path, array( 'jquery' ), SFW_VERSION );
		wp_localize_script( 'sfw_ipwd', 'sfw_ipwd', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
		wp_localize_script( 'sfw_ipwd', 'sfw_client_ip', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
		
	} elseif ( $spam_free_wordpress_options['pwd_style'] == 'click_password_field' ) {
		$js_path =  SFW_URL . 'js/sfw-click-pwd-field.js';
		wp_enqueue_script( 'sfw_pwd_field', $js_path, array( 'jquery' ), SFW_VERSION );
		wp_localize_script( 'sfw_pwd_field', 'sfw_pwd_field', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
		wp_localize_script( 'sfw_pwd_field', 'sfw_client_ip', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
		
	} elseif ( $spam_free_wordpress_options['pwd_style'] == 'click_password_button' ) {
		$js_path =  SFW_URL . 'js/sfw-click-pwd-button.js';
		wp_enqueue_script( 'sfw_click_pwd_button', $js_path, array( 'jquery' ), SFW_VERSION );
		wp_localize_script( 'sfw_click_pwd_button', 'sfw_click_pwd_button', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
		wp_localize_script( 'sfw_click_pwd_button', 'sfw_client_ip', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
		
	}
}

/**
* added 1.7.8.6
 * SFW requires jQuery 1.7 since it uses functions like .on() for events.
 * If, by the time wp_print_scrips is called, jQuery is outdated (i.e not
 * using the version in core) we need to deregister it and register the 
 * core version of the file.
 */
function sfw_check_jquery() {
	global $wp_scripts;
	
	// Enforce minimum version of jQuery
	if ( isset( $wp_scripts->registered['jquery']->ver ) && $wp_scripts->registered['jquery']->ver < '1.7' ) {
		wp_deregister_script( 'jquery' );
		wp_register_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js', array(), '1.7.2' );
		wp_enqueue_script( 'jquery' );
	}
}

// added 1.7.8.6
// removes key from array to remove options from database when options array saved for upgrades where option is removed
function sfw_array_remove_keys($array, $keys) {

	// If array is empty or not an array then return
	if(empty($array) || (! is_array($array))) {
		return $array;
	}
 
	// If $keys is a comma-separated list, convert to an array.
	if(is_string($keys)) {
		$keys = explode(',', $keys);
	}
 
	// At this point if $keys is not an array return
	if(! is_array($keys)) {
		return $array;
	}
 
	// array_diff_key() expected an associative array.
	$assocKeys = array();
	foreach($keys as $key) {
		$assocKeys[$key] = true;
	}
 
	return array_diff_key($array, $assocKeys);
}

?>