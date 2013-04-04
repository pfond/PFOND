<?php
/*
Plugin Name: Web Editors CMS
Plugin URI: http://wordpress.org/extend/plugins/web-editors-cms/
Description: A collection of plugins that optimize WordPress to use as a CMS. Includes our custom plugins and some extra's.
Version: 1.7
Author: Alex Morales
Author URI: http://www.webeditors.com/web-editors-cms

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

include('admin_panel.php');

/**
* Features
*/
if(get_option('wecms_page_order')) { include('page_manager/page_manager.php'); } // http://wordpress.org/extend/plugins/page-manager/
if(get_option('wecms_multiple_content')) { include('multiple_content.php'); } // http://wordpress.org/extend/plugins/multiple-content-blocks/
if(get_option('wecms_hide_update')) { include('hide_update_reminder.php'); } // custom
if(get_option('wecms_page_management')) { include('easy_page_management.php'); } // custom
if(get_option('wecms_shortcode')) { include('permalink_shortcode.php'); } // custom
    
/**
* Clean up Dashboard
*/
include('remove_dashboard_widgets.php'); // custom

/**
* CMS Branding
*/
if(get_option('wecms_cms_branding') == 'on') {  include('custom_admin_branding.php'); } // custom
if(get_option('wecms_cms_branding') == 'on') { include('custom_login_logo.php'); } // custom

/**
* Dashboard widget
*/
if(get_option('wecms_dashboard_widget') == 'on') { include('custom_dashboard_widgets.php'); } // custom