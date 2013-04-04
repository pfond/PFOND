<?php
/*
Plugin Name: Spam Free Wordpress
Plugin URI: http://www.toddlahman.com/spam-free-wordpress/
Description: Comment spam blocking plugin that uses anonymous password authentication to achieve 100% automated spam blocking with zero false positives, plus a few more features.
Version: 1.7.8.6
Author: Todd Lahman, LLC
Author URI: http://www.toddlahman.com/
License: GPLv3

	Intellectual Property rights reserved byTodd Lahman, LLC as allowed by law incude,
	but are not limited to, the working concept, function, and behavior of this plugin,
	the logical code structure and expression as written. All WordPress functions, objects, and
	related items, remain the property of WordPress under GPLv3 license, and any WordPress core
	functions and objects in this plugin operate under the GPLv3 license.
*/


if ( !defined('SFW_VERSION') )
	define( 'SFW_VERSION', '1.7.8.6' );
if ( !defined('SFW_WP_REQUIRED') )
	define( 'SFW_WP_REQUIRED', '3.1' );
if (!defined('SFW_WP_REQUIRED_MSG'))
	define( 'SFW_WP_REQUIRED_MSG', 'Spam Free Wordpress' . __( ' requires at least WordPress 3.1. Sorry! Click back button to continue.', 'spam-free-wordpress' ) );
if (!defined('SFW_URL') )
	define( 'SFW_URL', plugin_dir_url(__FILE__) );
if (!defined('SFW_PATH') )
	define( 'SFW_PATH', plugin_dir_path(__FILE__) );
if (!defined('SFW_BASENAME') )
	define( 'SFW_BASENAME', plugin_basename( __FILE__ ) );
if(!defined( 'SFW_IS_ADMIN' ) )
    define( 'SFW_IS_ADMIN',  is_admin() );

// Ready for translation
load_plugin_textdomain( 'spam-free-wordpress', false, dirname( plugin_basename( __FILE__ ) ) . '/translations' );


require_once( SFW_PATH . '/includes/functions.php' );
require_once( SFW_PATH . '/includes/class-comment-form.php' );
require_once( SFW_PATH . '/includes/upgradedb.php' );

if ( is_admin() ) {
	require_once( SFW_PATH . '/includes/admin.php' );
}

// Update version
if ( !get_option('sfw_version') ) {
	update_option( 'sfw_version', SFW_VERSION );
}

if ( get_option('sfw_version') && version_compare( get_option('sfw_version'), SFW_VERSION, '<' ) ) {
	update_option( 'sfw_version', SFW_VERSION );
}

// Set the default settings if not already set
if( !get_option( 'spam_free_wordpress' ) ) {
	sfw_add_default_data();
}

// Runs add_default_data function above when plugin activated
register_activation_hook( __FILE__, 'sfw_add_default_data' );

// variable used as global to retrieve option array for functions
if( get_option('spam_free_wordpress') ) {
	$spam_free_wordpress_options = get_option('spam_free_wordpress');
	
	if( get_option('sfw_run_once') ) {
		// upgrade ping status
		$sfw_run_once = get_option( 'sfw_run_once' );
	}
		
	if( !isset( $sfw_run_once ) && $spam_free_wordpress_options['blocklist_keys'] && !$spam_free_wordpress_options['remove_author_url_field'] ) {
		sfw_upgrade_ping_status();
	}

	// check for those without a ping status
	if( !$spam_free_wordpress_options['ping_status'] ) {
		sfw_add_default_ping_status();
	}

	// Added version 1.7
	if( !$spam_free_wordpress_options['comment_form'] ) {
		sfw_add_default_comment_form();
	}

	// Added version 1.7.6
	if( !$spam_free_wordpress_options['pwd_style'] ) {
		sfw_add_default_pwd_style();
	}

	// Added version 1.7.8.6
	if( isset( $spam_free_wordpress_options['old_jquery'] ) ) {
		sfw_del_old_jquery();
	}
	
}

// Reminder to turn on Comment Form Spam Stats - added 1.7.8.1
if( get_option( 'sfw_stats_reminder' ) ) {
	$sfw_stats_reminder = get_option( 'sfw_stats_reminder' );
}

if( !isset( $sfw_stats_reminder ) ) {
	global $pagenow;
	
	if ( $pagenow != 'plugins.php' ) {
		$sfw_stats_reminder_msg = '<a href="options-general.php?page=spam-free-wordpress-admin-page">';
		$sfw_stats_reminder_msg .= __( 'TURN ON' , 'spam-free-wordpress' );
		$sfw_stats_reminder_msg .= '</a>';
		$sfw_stats_reminder_msg .= __( ' your ' , 'spam-free-wordpress' );
		$sfw_stats_reminder_msg .= '<a href="options-general.php?page=spam-free-wordpress-admin-page">';
		$sfw_stats_reminder_msg .= __( 'Comment Form Spam Stats' , 'spam-free-wordpress' );
		$sfw_stats_reminder_msg .= '</a>';
		$sfw_stats_reminder_msg .= __( ' to be sure Spam Free Wordpress is working properly.' , 'spam-free-wordpress' );
		echo '<div id="message" class="updated"><p><strong>'. $sfw_stats_reminder_msg .'</strong></p></div>';
		update_option( 'sfw_stats_reminder', true );
	}
}

//Pingbacks and trackbacks are closed automatically, but only this one time
if( get_option( 'sfw_close_pings_once' ) ) {
	$sfw_close_pings_once = get_option( 'sfw_close_pings_once' );
}

if ( !isset( $sfw_close_pings_once ) ) {	
	if ( $pagenow == 'options-discussion.php' || $pagenow == 'edit.php' || $pagenow == 'post.php' ) {
		sfw_close_pingbacks();
		update_option( 'sfw_close_pings_once', true );
		$sfw_pingback_msg = __( 'Pingbacks were closed this one time to stop pingback and trackback spam. To reopen go to Settings >> Spam Free Wordpress' , 'spam-free-wordpress' );
		echo '<div id="message" class="error"><p><strong>'. $sfw_pingback_msg .'</strong></p></div>';
	}
}

// settings action link
add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'sfw_settings_link', 10, 1);
// "network_admin_plugin_action_links_{$plugin_file}"

// plugin row links
add_filter('plugin_row_meta', 'sfw_donate_link', 10, 2);

function sfw_donate_link($links, $file) {
	if ($file == plugin_basename(__FILE__)) {
		$links[] = '<a href="'.admin_url('options-general.php?page=spam-free-wordpress-admin-page').'">'.__('Settings', 'spam-free-wordpress').'</a>';
		$links[] = '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=SFVH6PCCC6TLG">'.__('Donate', 'spam-free-wordpress').'</a>';
	}
	return $links;
}

// For testing only
function sfw_delete() {
	delete_option( 'spam_free_wordpress' );
	delete_option( 'sfw_close_pings_once' );
}

//register_deactivation_hook( __FILE__, 'sfw_delete' );


/*-----------------------------------------------------------------------------------------------------------------------
* Before the comment form can be automatically generated, make sure JetPack Comments module is not active
-------------------------------------------------------------------------------------------------------------------------*/
// Added 1.7.3
if ( class_exists( 'Jetpack' ) ) {
	if ( in_array( 'comments', Jetpack::get_active_modules() ) ) {
		Jetpack::deactivate_module( 'comments' );
	}
}

/**
* added 1.7.8.6
 * SFW requires jQuery 1.7 since it uses functions like .on() for events.
 * If, by the time wp_print_scrips is called, jQuery is outdated (i.e not
 * using the version in core) we need to deregister it and register the 
 * core version of the file.
 */
add_action( 'wp_print_scripts', 'sfw_check_jquery', 25 );

/**
* Load SFW authentication AJAX JavaScript. Requires jQuery 1.7 or above since it uses .on()
*/
add_action('wp_enqueue_scripts', 'sfw_load_pwd');


// Actions for password AJAX
if ( $spam_free_wordpress_options['pwd_style'] == 'invisible_password' ) {
		add_action( 'wp_ajax_nopriv_sfw_i_pwd', 'sfw_get_pwd' );
		add_action( 'wp_ajax_sfw_i_pwd', 'sfw_get_pwd' );

		add_action( 'wp_ajax_nopriv_sfw_cip', 'get_remote_ip_address_ajax' );
		add_action( 'wp_ajax_sfw_cip', 'get_remote_ip_address_ajax' );
		
} elseif ( $spam_free_wordpress_options['pwd_style'] == 'click_password_field' ) {
		add_action( 'wp_ajax_nopriv_sfw_cpf', 'sfw_get_pwd' );
		add_action( 'wp_ajax_sfw_cpf', 'sfw_get_pwd' );

		add_action( 'wp_ajax_nopriv_sfw_cip', 'get_remote_ip_address_ajax' );
		add_action( 'wp_ajax_sfw_cip', 'get_remote_ip_address_ajax' );
		
} elseif ( $spam_free_wordpress_options['pwd_style'] == 'click_password_button' ) {
		add_action( 'wp_ajax_nopriv_sfw_cpb', 'sfw_get_pwd' );
		add_action( 'wp_ajax_sfw_cpb', 'sfw_get_pwd' );

		add_action( 'wp_ajax_nopriv_sfw_cip', 'get_remote_ip_address_ajax' );
		add_action( 'wp_ajax_sfw_cip', 'get_remote_ip_address_ajax' );
}

// automatically generate comment form - fixed in 1.7.8.1
function sfw_comment_form_init() {
	return dirname(__FILE__) . '/comments.php';
}

if ( $spam_free_wordpress_options['comment_form'] == 'on' ) {
	add_filter( 'comments_template', 'sfw_comment_form_init' );
}

// Calls the comment security, messages, and features
add_action('after_setup_theme', 'sfw_comment_form_additions', 1);

// Calls the wp-comments-post.php authentication
add_action('pre_comment_on_post', 'sfw_comment_post_authentication', 1);


/*
// Censor comments
// use preg_match or preg_match_all to match profanity in submitted comment and replacing the word before saving in database.
// then replaced word is a read only from the database
// user chooses their own list of words to replace, and the censored version of the word to replace it with
function sfw_censor_comments($content) {
    $profanities = array('badword','alsobad','...'); // make array within options array, multidimensional array
    $content=str_ireplace($profanities,'{censored}',$content);
    return $content;
}
add_filter('comment_text','sfw_censor_comments');
// Can use this line to get comment data to run through filter, match words in the censor list, then write it to the database with the new censored words
$comment_content      = ( isset($_POST['comment']) ) ? trim($_POST['comment']) : null;
*/
// Match word from $comment to key in database, and replace with key => value before saving in database.
// Use form similar to editing tags to list and allow each word to be clicked to edit word to filter, and replacement censor word wit example like bitch replaced by b!tch or b*tch
// If no matching censored word exists use something the user chooses as the default like {censored}

?>