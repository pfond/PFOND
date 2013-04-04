<?php
/*
Plugin Name: Elastic Theme Engine and Editor
Plugin URI: http://wordpress.org/extend/plugins/elastic-theme-editor/
Description: A theme editor for the Elastic framework.
Version: 0.0.3
Author: Daryl Koopersmith
Author URI: http://gsoc2009wp.wordpress.com/tag/elastic/

    Copyright 2009  Daryl Koopersmith  (email : dkoopersmith@gmail.com)

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

// Check for Elastic engine
add_action('load_elastic_engine', 'start_your_engines');

function start_your_engines() {
	// Load $elastic object and functions.
	require_once('engine/elastic.php');
}

// Load editor
require_once('editor/class-elastic-editor.php');
Elastic_Editor::init();

?>
