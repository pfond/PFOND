<?php

// Make sure that we are uninstalling
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit();
}

// Removes all Spam Free Wordpress data from the database
delete_option( 'spam_free_wordpress' );
//delete_option( 'sfw_spam_hits' );
delete_option('sfw_version');
delete_option( 'sfw_close_pings_once' );
delete_option( 'sfw_run_once' );
delete_option( 'sfw_stats_reminder' );

// Delete postmeta meta_key sfw_comment_form_password database entries, since we don't use them anymore
$sfw_allposts = get_posts('numberposts=-1&post_type=post&post_status=any');

foreach( $sfw_allposts as $sfw_postinfo) {
	delete_post_meta($sfw_postinfo->ID, 'sfw_comment_form_password');
}

?>