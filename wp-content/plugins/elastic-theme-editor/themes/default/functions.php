<?php

// Load $elastic object and functions.
do_action('load_elastic_engine');

// Warn users Elastic isn't installed.
if( ! has_action('load_elastic_engine') ) {
	add_thickbox();
	add_action('admin_notices','elastic_install_message');
}

function elastic_install_message() {
	echo '<div id="message" class="error"><p><strong>Warning:</strong> The current theme requires the Elastic Theme Editor plugin to operate correctly. <strong><a href="./plugin-install.php?tab=plugin-information&plugin=elastic-theme-editor&TB_iframe=true&width=640&height=694" class="thickbox onclick" alt="Install now">Install now</a></strong> or <a href="http://wordpress.org/extend/plugins/elastic-theme-editor/" alt="Elastic Theme Editor on WordPress Extend">download here</a>.</p></div>';
};

// Include Elastic CSS reset
elastic_set('include_css_reset', true);

?>