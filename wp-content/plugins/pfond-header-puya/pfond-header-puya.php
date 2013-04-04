<?php
/*
Plugin Name: PFOND Header Puya
Description: Modifies headers of PFOND Sites
Author: Puya Seid-Karbasi
Version: 1.0.0
Author URI: http://pfond.cmmt.ubc.ca/
License: GPL2
*/

/*  Copyright 2012 Puya Seid-Karbasi  (email : pseidkarbasi@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


//add_action('wp_head', 'initPuyaHeader');

add_action('bp_header', 'initPuyaHeader');


function initPuyaHeader() {
	$site_url = str_replace('http://', '', get_site_url(1));
	$site_url = "http://".$site_url; 
	$path_parts = split('/', get_blog_details($GLOBALS['blog_id'])->path);
	$blog_slug = $path_parts[count($path_parts) - 2];
	
	$title = get_option('pfond_disease_name');
	if(strlen($title) > 25) {
		$title = "This site";
	}	
	
	$base = 'http://pfond.cmmt.ubc.ca';
	$add = $site_url . '/' . BP_GROUPS_SLUG . '/' . $blog_slug . '/forum/'; //$base.'/groups/'.strtolower($title).'/forum/';
	$stub = $base.'/stub/'; 
	//echo '<center>';
	echo '<p style="color:#CFECEC">Note: '.$title.' is currently a <a href="'.$stub.'">PFOND stub.</a> If you have any suggestions for the editors <a href="'.$add.'">visit here.</a></p>';
	//echo '</center>';





}





?>
