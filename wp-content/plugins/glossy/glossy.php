<?php
	/*
	Plugin Name: Glossy
	Plugin URI: http://croberts.me/glossy/
	Makes it easy to create site-wide glossary or dictionary entries which pop up using the Tippy plugin
	Version: 1.0.1
	Author: Chris Roberts
	Author URI: http://croberts.me/
	*/
	
	/*  Copyright 2011 Chris Roberts (email : columcille@gmail.com)
	
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
	    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
	*/
	
	if (!function_exists('gs_tippy_check'))
	{
		function gs_tippy_check()
		{
			// Check for the presence of Tippy
			if (!function_exists('tippy_formatLink'))
			{
				echo '<div id="message" class="error">The Tippy plugin appears to be missing but is required by the Glossy plugin.</div>';
			}
		}
	}
	
	if (!function_exists('gs_get_entry'))
	{
		// gs_get_entry($entryName) returns an array with the entry data
		function gs_get_entry($entryName)
		{
			global $wpdb;
			$gs_tableName = $wpdb->prefix ."gs_store";
			
			$query = $wpdb->prepare("SELECT * from ". $gs_tableName ." WHERE gs_name = '%s';", $entryName);
			$gs_data_arr = $wpdb->get_results($query);
			$gs_data_obj = $gs_data_arr[0];
			
			$gs_data['name'] = $entryName;
			$gs_data['title'] = $gs_data_obj->gs_title;
			$gs_data['link'] = $gs_data_obj->gs_link;
			$gs_data['dimensions'] = $gs_data_obj->gs_dimensions;
			$gs_data['contents'] = $gs_data_obj->gs_contents;
			
			return $gs_data;
		}
	}
	
	if (!function_exists('gs_scanContent'))
	{
		function gs_scanContent($content)
		{
			preg_match_all('/\[gs ([^\]]+)\]/', $content, $glossyMatches);
			
			$glossySet = $glossyMatches[0];
			$glossyFound = $glossyMatches[1];
			
			foreach ($glossyFound as $gs_index => $gs_name)
			{
				$gs_tippy = gs_display($gs_name);
				
				$content = str_replace($glossySet[$gs_index], $gs_tippy, $content);
			}
			
			return $content;
		}
	}
	
	if (!function_exists('gs_display'))
	{
		function gs_display($gs_name)
		{
			$gs_data = gs_get_entry($gs_name);
			
			if (empty($gs_data['title']))
			{
				$tippyTitle = $gs_name;
			} else {
				$tippyTitle = $gs_data['title'];
			}
			
			// Check width and height values
			$gs_dimensions = gs_get_dimensions($gs_data['dimensions']);
			
			$tippyLink = tippy_formatLink("on", $tippyTitle, $gs_data['link'], tippy_format_text($gs_data['contents']), "glossy_tip", "glossy", $gs_dimensions['width'], $gs_dimensions['height']);
			
			return $tippyLink;
		}
	}
	
	if (!function_exists('gs_get_dimensions'))
	{
		function gs_get_dimensions($gs_dimensions)
		{
			$gs_dimensions_arr['width'] = 0;
			$gs_dimensions_arr['height'] = 0;
			
			// Validate the dimensions
			if (!empty($gs_dimensions))
			{
				// Make sure to get the right case for the X
				$gs_dimensions = strtolower($gs_dimensions);
				
				$dimensions = explode("x", $gs_dimensions);
				
				// Clean up possible spaces
				$gs_dimensions_arr['width'] = trim($dimensions[0]);
				
				if (!empty($dimensions[1]))
				{
					$gs_dimensions_arr['height'] = trim($dimensions[1]);
				}
			}
			
			return $gs_dimensions_arr;
		}
	}
	
	if (!function_exists('gs_activatePlugin'))
	{
		function gs_activatePlugin()
		{
			global $wpdb;
			$gs_tableName = $wpdb->prefix ."gs_store";
			
			/*
			 *
			 * Glossy entries will need to be stored in a new database table, gs_store.
			 *
			 * Table structure:
			 * gs_name varchar(255) not null primary key; unique name which serves as the unique identifier
			 * gs_title tinytext; title to display for Tippy. Optional. If blank, use gs_name
			 * gs_link tinytext; url to link Tippy title to. Optional. If blank, title will not be a link
			 * gs_dimensions varchar[12]; optional width X height setting to pass to Tippy. When only one value present, use for width.
			 * gs_contents medium text not null; contains the tooltip contents
			 *
			 */
			$query = "CREATE TABLE " . $gs_tableName . " (
					  gs_name varchar(255) NOT NULL,
					  gs_title tinytext,
					  gs_link tinytext,
					  gs_dimensions varchar(12),
					  gs_contents mediumtext NOT NULL,
					  PRIMARY KEY (gs_name)
					  );";
					  
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($query);
		}
	}
	
	register_activation_hook(WP_PLUGIN_DIR . '/glossy/glossy.php', 'gs_activatePlugin');
	add_filter('the_content', 'gs_scanContent', 4);
	
	wp_register_style('gs_style', plugins_url() .'/glossy/glossy.css');
	wp_enqueue_style('gs_style');
	
	if (is_admin())
	{
		require_once(WP_PLUGIN_DIR . '/glossy/glossy.admin.php');
	}
?>