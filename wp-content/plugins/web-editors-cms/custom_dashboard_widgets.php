<?php
/**
* Custom dashboard widget with support information.
* 
*/
function WE_custom_dashboard_widgets() {
    global $wp_meta_boxes;
    wp_add_dashboard_widget('custom_help_widget1', get_option('wecms_dashboard_widget_title'), 'WE_custom_dashboard_intro');
}
function WE_custom_dashboard_intro() {
    echo get_option('wecms_dashboard_widget_content');
}
add_action('wp_dashboard_setup', 'WE_custom_dashboard_widgets');