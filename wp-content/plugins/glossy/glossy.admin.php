<?php
	if (!function_exists('glossy_adminMenu'))
	{
		function glossy_adminMenu()
		{
			add_menu_page('Manage Entries', 'Glossy', 'install_plugins', 'glossy-settings', 'gs_manageEntries');
			add_submenu_page('glossy-settings', 'Add Entry', 'Add Entry', 'install_plugins', 'glossy-add-entry', 'gs_addEntry');
		}
	}
	
	if (!function_exists('gs_addEntry'))
	{
		function gs_addEntry()
		{
			require_once(WP_PLUGIN_DIR . '/glossy/glossy.admin.addEntry.php');
			
			gs_addEntry_panel();
		}
	}
	
	if (!function_exists('gs_manageEntries'))
	{
		function gs_manageEntries()
		{
			require_once(WP_PLUGIN_DIR . '/glossy/glossy.admin.manageEntries.php');
			
			gs_manageEntries_panel();
		}
	}
	
	add_action('admin_menu', 'glossy_adminMenu');
?>