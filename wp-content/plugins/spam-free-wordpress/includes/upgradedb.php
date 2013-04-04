<?php

// Add default database settings on plugin activation
function sfw_add_default_data() {

	if( !get_option( 'spam_free_wordpress' ) ) {
		if ( version_compare( get_bloginfo( 'version' ), SFW_WP_REQUIRED, '<' ) ) {
			deactivate_plugins( basename( __FILE__ ) );
			wp_die( SFW_WP_REQUIRED_MSG );
		} else {
			$sfw_options = array(
			'blocklist_keys' => '',
			'lbl_enable_disable' => 'disable',
			'remote_blocked_list' => '',
			'rbl_enable_disable' => 'disable',
			'pw_field_size' => '20',
			'tab_index' => '',
			'affiliate_msg' => '',
			'toggle_stats_update' => 'disable',
			'toggle_html' => 'disable',
			'remove_author_url_field' => 'disable',
			'remove_author_url' => 'disable',
			'ping_status' => 'closed',
			'comment_form' => 'on',
			'special_msg' => '',
			'pwd_style' => 'invisible_password'
			);
			update_option( 'spam_free_wordpress', $sfw_options );
		
			// Close pingback default settings
			update_option( 'default_ping_status', 'closed' );
			update_option( 'default_pingback_flag', '' );
		}
		
		if( !get_option( 'sfw_spam_hits' ) ) {
			update_option( 'sfw_spam_hits', '1' );
		}
	}
}

function sfw_upgrade_ping_status() {

	if ( version_compare( get_bloginfo( 'version' ), SFW_WP_REQUIRED, '<' ) ) {
		deactivate_plugins( basename( __FILE__ ) );
		wp_die( SFW_WP_REQUIRED_MSG );
	} else {
		$spam_free_wordpress_options = get_option('spam_free_wordpress');
	
		$oldver = $spam_free_wordpress_options;
		$newver = array(
			'remove_author_url_field' => 'disable',
			'remove_author_url' => 'disable',
			'ping_status' => 'closed'
			);
		$mergever = array_merge( $oldver, $newver );
	
		update_option( 'spam_free_wordpress', $mergever );
		
		update_option('sfw_run_once',true);
		
		// Close pingback default settings
		update_option( 'default_ping_status', 'closed' );
		update_option( 'default_pingback_flag', '' );
	}
}


function sfw_add_default_ping_status() {

	if ( version_compare( get_bloginfo( 'version' ), SFW_WP_REQUIRED, '<' ) ) {
		deactivate_plugins( basename( __FILE__ ) );
		wp_die( SFW_WP_REQUIRED_MSG );
	} else {
		$spam_free_wordpress_options = get_option('spam_free_wordpress');
	
		$oldver = $spam_free_wordpress_options;
		$newver = array(
			'ping_status' => 'closed'
			);
		$mergever = array_merge( $oldver, $newver );
	
		update_option( 'spam_free_wordpress', $mergever );
	}
}

// Added version 1.7
function sfw_add_default_comment_form() {

	if ( version_compare( get_bloginfo( 'version' ), SFW_WP_REQUIRED, '<' ) ) {
		deactivate_plugins( basename( __FILE__ ) );
		wp_die( SFW_WP_REQUIRED_MSG );
	} else {
		$spam_free_wordpress_options = get_option('spam_free_wordpress');
	
		$oldver = $spam_free_wordpress_options;
		$newver = array(
			'comment_form' => 'on',
			'special_msg' => ''
			);
		$mergever = array_merge( $oldver, $newver );
	
		update_option( 'spam_free_wordpress', $mergever );
		
	}
}

// Added version 1.7.6
function sfw_add_default_pwd_style() {

	if ( version_compare( get_bloginfo( 'version' ), SFW_WP_REQUIRED, '<' ) ) {
		deactivate_plugins( basename( __FILE__ ) );
		wp_die( SFW_WP_REQUIRED_MSG );
	} else {
		$spam_free_wordpress_options = get_option('spam_free_wordpress');
	
		$oldver = $spam_free_wordpress_options;
		$newver = array(
			'pwd_style' => 'invisible_password'
			);
		$mergever = array_merge( $oldver, $newver );
	
		update_option( 'spam_free_wordpress', $mergever );
		
	}
}


// added version 1.7.8.6
function sfw_del_old_jquery() {
	if ( version_compare( get_bloginfo( 'version' ), SFW_WP_REQUIRED, '<' ) ) {
		deactivate_plugins( basename( __FILE__ ) );
		wp_die( SFW_WP_REQUIRED_MSG );
	} else {
		$sfw_options = get_option('spam_free_wordpress');

		$new_options = sfw_array_remove_keys( $sfw_options, array( 'old_jquery' ) );
		
		update_option( 'spam_free_wordpress', $new_options );	
		
	}
}

?>