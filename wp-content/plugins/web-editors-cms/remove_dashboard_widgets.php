<?php
/**
* Remove unwanted dashboard widgets 
*/
function WE_remove_dashboard_widgets() {
    global $wp_meta_boxes;
    if(get_option('wecms_yoast_db_widget')) { unset($wp_meta_boxes['dashboard']['normal']['core']['yoast_db_widget']); }
    if(get_option('wecms_dashboard_right_now')) { unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']); }
    if(get_option('wecms_dashboard_recent_comments')) { unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']); }
    if(get_option('wecms_dashboard_incoming_links')) { unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']); }
    if(get_option('wecms_dashboard_plugins')) { unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']); }
    if(get_option('wecms_dashboard_quick_press')) { unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']); }
    if(get_option('wecms_dashboard_recent_drafts')) { unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']); }
    if(get_option('wecms_dashboard_primary')) { unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']); }
    if(get_option('wecms_dashboard_secondary')) { unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']); }
    // unkown?? SAVE
    //unset($wp_meta_boxes['dashboard']['normal']['core']['blogplay_db_widget']); // ???
    // unset($wp_meta_boxes['dashboard']['normal']['core']['yst_db_widget']); // yoast news?
}
add_action('wp_dashboard_setup', 'WE_remove_dashboard_widgets' );