<?php
/**
* Custom Admin Panel
*/
function WE_add_cms_adminpanel() {
    add_submenu_page('options-general.php', "Web Editors CMS", "Web Editors CMS", 'level_9', "web-editors-cms-settings.php","WE_show_settings");
}
add_action('admin_menu', 'WE_add_cms_adminpanel');

function WE_show_settings() {
    global $current_user;
    get_currentuserinfo();
?>
<div class="wrap">
<div style="padding:12px;">
    <h2>Web Editors CMS</h2>
<p>
Thank you for using this open source plugin! If you are satisfied with the results, isn't it worth at least a few dollar? Donations help us to continue support and development of this free software!
</p>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
<input type="hidden" name="cmd" value="_s-xclick" />
<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----" />
<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!" />
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1" />
</form>

<form id="wecms" method="post" enctype="multipart/form-data">
    <div style="float:left">
        <h3>CMS Features</h3>
        <p><label for="wecms_page_order"><input type="checkbox" name="wecms_page_order" id="wecms_page_order" <?php if(get_option('wecms_page_order')) { echo 'checked'; } ?> /> Enable Page Manager - <a href="http://wordpress.org/extend/plugins/page-manager/" target="_blank">(info)</a></label></p>
        <p><label for="wecms_multiple_content"><input type="checkbox" name="wecms_multiple_content" id="wecms_multiple_content" <?php if(get_option('wecms_multiple_content')) { echo 'checked'; } ?> /> Be able to add multiple content blocks as a developer (<a href="http://plugins.trendwerk.nl/documentation/multiple-content-blocks/" target="_blank">documentation</a>)</label></p>
        <p><label for="wecms_hide_update"><input type="checkbox" name="wecms_hide_update" id="wecms_hide_update" <?php if(get_option('wecms_hide_update')) { echo 'checked'; } ?> /> Hide update reminders for users under the Administrative role</label></p>
        <p><label for="wecms_page_management"><input type="checkbox" name="wecms_page_management" id="wecms_page_management" <?php if(get_option('wecms_page_management')) { echo 'checked'; } ?> /> Easily edit pages from admin menu - Adds all pages in drop down of admin pages menu</label></p>
        <p><label for="wecms_shortcode"><input type="checkbox" name="wecms_shortcode" id="wecms_shortcode" <?php if(get_option('wecms_shortcode')) { echo 'checked'; } ?> /> Add Permalink shortcodes into CMS</label></p>
    </div>
    <div style="float:left; padding-left:48px;">
        <h3 style="margin-bottom:0px;">Cleanup Dashboard</h3>
        <div style="float:left;">
        <p><label for="wecms_yoast_db_widget"><input type="checkbox" name="wecms_yoast_db_widget" id="wecms_yoast_db_widget" <?php if(get_option('wecms_yoast_db_widget')) { echo 'checked'; } ?> /> Hide Yoast</label></p>
        <p><label for="wecms_dashboard_right_now"><input type="checkbox" name="wecms_dashboard_right_now" id="wecms_dashboard_right_now" <?php if(get_option('wecms_dashboard_right_now')) { echo 'checked'; } ?> /> Hide Right now</label></p>
        <p><label for="wecms_dashboard_recent_comments"><input type="checkbox" name="wecms_dashboard_recent_comments" id="wecms_dashboard_recent_comments" <?php if(get_option('wecms_dashboard_recent_comments')) { echo 'checked'; } ?> /> Hide Recent Comment</label></p>
        <p><label for="wecms_dashboard_incoming_links"><input type="checkbox" name="wecms_dashboard_incoming_links" id="wecms_dashboard_incoming_links" <?php if(get_option('wecms_dashboard_incoming_links')) { echo 'checked'; } ?> /> Hide Incoming Links</label></p>
        <p><label for="wecms_dashboard_plugins"><input type="checkbox" name="wecms_dashboard_plugins" id="wecms_dashboard_plugins" <?php if(get_option('wecms_dashboard_plugins')) { echo 'checked'; } ?> /> Hide Plugins</label></p>
        </div>
        <div style="float:left; padding-left:48px;">
        <p><label for="wecms_dashboard_quick_press"><input type="checkbox" name="wecms_dashboard_quick_press" id="wecms_dashboard_quick_press" <?php if(get_option('wecms_dashboard_quick_press')) { echo 'checked'; } ?> /> Hide Quick Press</label></p>
        <p><label for="wecms_dashboard_recent_drafts"><input type="checkbox" name="wecms_dashboard_recent_drafts" id="wecms_dashboard_recent_drafts" <?php if(get_option('wecms_dashboard_recent_drafts')) { echo 'checked'; } ?> /> Hide Recent Drafts</label></p>
        <p><label for="wecms_dashboard_primary"><input type="checkbox" name="wecms_dashboard_primary" id="wecms_dashboard_primary" <?php if(get_option('wecms_dashboard_primary')) { echo 'checked'; } ?> /> Hide Blog News</label></p>
        <p><label for="wecms_dashboard_secondary"><input type="checkbox" name="wecms_dashboard_secondary" id="wecms_dashboard_secondary" <?php if(get_option('wecms_dashboard_secondary')) { echo 'checked'; } ?> /> Hide Other News</label></p>
        </div>
    </div>
    <div style="clear:both;">
    <?php $we_plugin_dir =  WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)); ?>

        <p>&nbsp;</p>
        <h3><label for="wecms_cms_branding"><input type="checkbox" name="wecms_cms_branding" id="wecms_cms_branding" <?php if(get_option('wecms_cms_branding')) { echo 'checked'; } ?> /> Enable CMS Branding</label></h3>
        <b>Admin Screen</b>
        <p><label for="wecms_admin_logo"><input style="width:500px;" type="text" name="wecms_admin_logo" id="wecms_admin_logo" value="<?php echo get_option('wecms_admin_logo', "$we_plugin_dir" . 'images/wecms_mini_logo.png') ?>" /> Path to your admin panel icon/Logo - height = 31px</label></p>
        <p><label for="wecms_admin_logo_width"><input style="width:36px;" type="text" name="wecms_admin_logo_width" id="wecms_admin_logo_width" value="<?php echo get_option('wecms_admin_logo_width', '16') ?>" /> Width of admin panel icon/Logo (digits only)</label></p>
        <p><label for="wecms_hide_link"><input type="checkbox" name="wecms_hide_link" id="wecms_hide_link" <?php if(get_option('wecms_hide_link')) { echo 'checked'; } ?> /> Remove link to website in header?</label></p>
        <p><label for="wecms_footer_info"><textarea style="width:500px;" rows="3" name="wecms_footer_info" id="wecms_footer_info"><?php echo stripslashes(get_option('wecms_footer_info', 'Thank you for creating with <a href="http://www.webeditors.com/">Web Editors</a>.</span>')); ?></textarea> Bottom Left Admin Footer Info (<span style="color:red">no single quotes!</span>)</label></p>
        <b>Login Screen</b>
        <p><label for="wecms_login_logo"><input style="width:500px;" type="text" name="wecms_login_logo" id="wecms_login_logo" value="<?php echo get_option('wecms_login_logo', "$we_plugin_dir" . 'images/wecms_logo.gif') ?>" /> Path to your login logo - 312 x 79</label></p>
        <p><label for="wecms_login_replace"><input style="width:500px;" type="text" name="wecms_login_replace" id="wecms_login_replace" value="<?php echo get_option('wecms_login_replace', 'Powered by Web Editors') ?>" /> Replace Powered by Wordpress with? (<span style="color:red">no double quotes!</span>)</label></p>
        <p><label for="wecms_url_replace"><input style="width:500px;" type="text" name="wecms_url_replace" id="wecms_url_replace" value="<?php echo get_option('wecms_url_replace', 'www.webeditors.com') ?>" /> Replace wordpress.org with? (ie: www.webeditors.com)</label></p>
    
        <p>&nbsp;</p>
        <h3><label for="wecms_dashboard_widget"><input type="checkbox" name="wecms_dashboard_widget" id="wecms_dashboard_widget" <?php if(get_option('wecms_dashboard_widget')) { echo 'checked'; } ?> /> Enable Custom Dashboard Widget - Great for customer support</label></h3>
        <p><label for="wecms_dashboard_widget_title"><input style="width:500px;" type="text" name="wecms_dashboard_widget_title" id="wecms_dashboard_widget_title" value="<?php echo get_option('wecms_dashboard_widget_title', 'Web Editors CMS') ?>" /> Widget Title</label></p>
        <p><label for="wecms_dashboard_widget_content"><textarea style="width:500px;" rows="5" name="wecms_dashboard_widget_content" id="wecms_dashboard_widget_content"><?php echo stripslashes(get_option('wecms_dashboard_widget_content', '<p>Web Editors enables you to make web site updates easily so you can keep your site fresh and up to date in a matter of minutes. To begin, select an item to manage from any of the menus available.</p><p>In considering the need for easy to use and effective services, we have implemented quality and prompt customer support systems to help you make the most of your Online needs with an experienced support staff.</p><p><a href="http://www.webeditors.com/contact-us/contact-form" target="_blank">Click here to contact us</a></p>')); ?></textarea> Widget Content (<span style="color:red">no single quotes!</span>)</label></p>
        
        <p>&nbsp;</p>
        <p><input type="submit" class="button-primary" name="cms_settings_save" value="Save changes" /></p>
    </div>
</form>
<?php
if($current_user->user_level == 10)
{
    $we_show_alerts = null;
    if ( ! function_exists('ure_optionsPage'))
    {
        $we_show_alerts .= 'You should enable <a href="plugin-install.php?tab=search&type=term&s=user-role-editor">User Role Editor</a><br />';
    }
    if ( ! class_exists('WPMenuEditor'))
    {
        $we_show_alerts .= 'You should enable <a href="plugin-install.php?tab=search&type=term&s=admin-menu-editor">Admin Menu Editor</a><br />';
    }
    if ( ! function_exists('aioseop_get_version') )
    {
        $we_show_alerts .= 'You should enable <a href="plugin-install.php?tab=search&type=term&s=all-in-one-seo-pack">All in One SEO Pack</a><br />';
    }
    if ( ! function_exists('cms_dashboard_widget_function'))
    {
        $we_show_alerts .= 'You may need to install or enable <a href="plugin-install.php?tab=search&type=term&s=content-management-system-dashboard">CMS Dashboard</a><br />';
    }
    if ( ! function_exists('cms_tpv_admin_init'))
    {
        $we_show_alerts .= 'You should enable <a href="plugin-install.php?tab=search&type=term&s=cms-tree-page-view">CMS Tree Page View</a><br />';
    }
    if ( ! function_exists('ep_exclude_pages'))
    {
        $we_show_alerts .= 'You should enable <a href="plugin-install.php?tab=search&type=term&s=exclude-pages">Exclude Pages</a><br />';
    }
    if ( ! class_exists('im8_box_hide'))
    {
        $we_show_alerts .= 'You should enable <a href="plugin-install.php?tab=search&type=term&s=im8-box-hide">IM8 Box Hide</a><br />';
    }
    if ( ! function_exists('wp_ozh_adminmenu'))
    {
        $we_show_alerts .= 'You should enable <a href="plugin-install.php?tab=search&type=term&s=ozh-admin-drop-down-menu">Ozh\' Admin Drop Down Menu</a><br />';
    }
    if ( ! function_exists('multiedit'))
    {
        $we_show_alerts .= 'You should enable <a href="plugin-install.php?tab=search&type=term&s=pagely-multiedit">Page.ly MultiEdit</a><br />';
    }
    if ( ! class_exists('Redirection_Plugin'))
    {
        $we_show_alerts .= 'You should enable <a href="plugin-install.php?tab=search&type=term&s=redirection">Redirection</a><br />';
    }
        if ( ! class_exists('SEOLinks'))
    {
        $we_show_alerts .= 'You should enable <a href="plugin-install.php?tab=search&type=term&s=seo-automatic-links">SEO Smart Links</a><br />';
    }
    if ( ! function_exists('shuffle_back_link'))
    {
        $we_show_alerts .= 'You should enable <a href="plugin-install.php?tab=search&type=term&s=shuffle">Shuffle</a><br />';
    }
    if( ! function_exists('eacs_init'))
    {
        $we_show_alerts .= 'You should enable <a href="plugin-install.php?tab=search&type=term&s=easy-admin-color-schemes">Easy Admin Color Schemes</a><br />';
    }
    if ( ! function_exists('th23_media_columns'))
    {
        $we_show_alerts .= 'You should enable <a href="plugin-install.php?tab=search&type=term&s=th23-media-library-extension">th23 Media Library Extension</a><br />';
    }
    if ( ! class_exists('PHP_Code_Widget'))
    {
        $we_show_alerts .= 'You should enable <a href="plugin-install.php?tab=search&type=term&s=php-code-widget">PHP Code Widget</a><br />';
    }
    if ( ! class_exists( 'GA_Admin'))
    {
        $we_show_alerts .= 'You should enable <a href="plugin-install.php?tab=search&type=term&s=google-analytics-for-wordpress">Google Analytics for WordPress</a><br />';
    }
    if ( ! class_exists( 'GoogleSitemapGeneratorLoader'))
    {
        $we_show_alerts .= 'You should enable <a href="plugin-install.php?tab=search&type=term&s=google-sitemap-generator">Google XML Sitemaps</a><br />';
    }
    if ( ! function_exists('tadv_admin_head'))
    {
        $we_show_alerts .= 'You should enable <a href="plugin-install.php?tab=search&type=term&s=tinymce-advanced">TinyMCE Advanced</a><br />';
    }
    if( ! function_exists('editor_admin_register_head_editor_37'))
    {
        $we_show_alerts .= 'You should enable <a href="plugin-install.php?tab=search&type=term&s=editor-tabs">Editor Tabs</a><br />';
    }
    
    
    
    if ( ! function_exists('pods_content'))
    {
        $we_show_alerts .= 'You may need to install or enable <a href="plugin-install.php?tab=search&type=term&s=pods">Pods CMS</a><br />';
    }
    if ( ! function_exists('pods_ui_manage'))
    {
        $we_show_alerts .= 'You may need to install or enable <a href="plugin-install.php?tab=search&type=term&s=pods-ui">Pods UI</a> (highly sugessted if using pods)<br />';
    }
    if ( ! class_exists('W3_Plugin_TotalCache'))
    {
        $we_show_alerts .= 'You may need to install or enable <a href="plugin-install.php?tab=search&type=term&s=w3-total-cache">W3 Total Cache</a><br />';
    }
    if ( ! function_exists('dbmanager_menu'))
    {
        $we_show_alerts .= 'You may need to install or enable <a href="plugin-install.php?tab=search&type=term&s=wp-dbmanager">WP-DBManager</a><br />';
    }
    if ( ! class_exists('Reusables'))
    {
        $we_show_alerts .= 'You may need to install or enable <a href="plugin-install.php?tab=search&type=term&s=reusables">WordPress Reusables</a><br />';
    }
    
    
    
    if($we_show_alerts)
    {
        echo '<br /><div class="updated fade">' . $we_show_alerts . '</div>';
    }
}
?>
    </div>
</div>
<?php
}
function WE_process_cms_adjustments() {
    if($_POST['cms_settings_save'])
    {
        $wecms_page_order = ($_POST['wecms_page_order'] == 'on') ? update_option('wecms_page_order','1') : update_option('wecms_page_order','0');
        $wecms_multiple_content = ($_POST['wecms_multiple_content'] == 'on') ? update_option('wecms_multiple_content','1') : update_option('wecms_multiple_content','0');
        $wecms_page_management = ($_POST['wecms_page_management'] == 'on') ? update_option('wecms_page_management','1') : update_option('wecms_page_management','0');
        $wecms_hide_update = ($_POST['wecms_hide_update'] == 'on') ? update_option('wecms_hide_update','1') : update_option('wecms_hide_update','0');
        $wecms_shortcode = ($_POST['wecms_shortcode'] == 'on') ? update_option('wecms_shortcode','1') : update_option('wecms_shortcode','0');
        
        // dashboard stuff
        $wecms_yoast_db_widget  = ($_POST['wecms_yoast_db_widget'] == 'on') ? update_option('wecms_yoast_db_widget','1') : update_option('wecms_yoast_db_widget','0');
        $wecms_dashboard_right_now  = ($_POST['wecms_dashboard_right_now'] == 'on') ? update_option('wecms_dashboard_right_now','1') : update_option('wecms_dashboard_right_now','0');
        $wecms_dashboard_recent_comments  = ($_POST['wecms_dashboard_recent_comments'] == 'on') ? update_option('wecms_dashboard_recent_comments','1') : update_option('wecms_dashboard_recent_comments','0');
        $wecms_dashboard_incoming_links  = ($_POST['wecms_dashboard_incoming_links'] == 'on') ? update_option('wecms_dashboard_incoming_links','1') : update_option('wecms_dashboard_incoming_links','0');
        $wecms_dashboard_plugins  = ($_POST['wecms_dashboard_plugins'] == 'on') ? update_option('wecms_dashboard_plugins','1') : update_option('wecms_dashboard_plugins','0');
        $wecms_dashboard_quick_press  = ($_POST['wecms_dashboard_quick_press'] == 'on') ? update_option('wecms_dashboard_quick_press','1') : update_option('wecms_dashboard_quick_press','0');
        $wecms_dashboard_recent_drafts  = ($_POST['wecms_dashboard_recent_drafts'] == 'on') ? update_option('wecms_dashboard_recent_drafts','1') : update_option('wecms_dashboard_recent_drafts','0');
        $wecms_dashboard_primary  = ($_POST['wecms_dashboard_primary'] == 'on') ? update_option('wecms_dashboard_primary','1') : update_option('wecms_dashboard_primary','0');
        $wecms_dashboard_secondary  = ($_POST['wecms_dashboard_secondary'] == 'on') ? update_option('wecms_dashboard_secondary','1') : update_option('wecms_dashboard_secondary','0');
        
        // branding
        update_option('wecms_cms_branding', $_POST['wecms_cms_branding'] );
        if($_POST['wecms_cms_branding'] == 'on')
        {
            update_option('wecms_hide_link', $_POST['wecms_hide_link'] );
            update_option('wecms_admin_logo', $_POST['wecms_admin_logo'] );
            update_option('wecms_admin_logo_width', $_POST['wecms_admin_logo_width'] );
            update_option('wecms_footer_info', $_POST['wecms_footer_info'] );
            update_option('wecms_login_logo', $_POST['wecms_login_logo'] );
            update_option('wecms_login_replace', $_POST['wecms_login_replace'] );
            update_option('wecms_url_replace', $_POST['wecms_url_replace'] );
        }
        
        // dashboard widget
        update_option('wecms_dashboard_widget', $_POST['wecms_dashboard_widget'] );
        if($_POST['wecms_dashboard_widget'] == 'on')
        {
            update_option('wecms_dashboard_widget_title', $_POST['wecms_dashboard_widget_title'] );
            update_option('wecms_dashboard_widget_content', $_POST['wecms_dashboard_widget_content'] );
        }
    }
}
add_action('admin_menu', 'WE_process_cms_adjustments');
