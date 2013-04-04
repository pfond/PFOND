<?php
/*
Plugin Name: WordPress Tooltip
Description: WordPress tooltip lets you add tooltips to content on your posts and pages.
Author: Muhammad Haris - <a href='http://twitter.com/mharis'>@mharis</a>
Version: 1.0.1
Author URI: http://mharis.net
License: GPL2
*/

/*  Copyright 2011 Muhammad Haris  (email : isharis@gmail.com)

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


	function dpa_handle_action_puya_tooltip() {
    $func_get_args = func_get_args();
    dpa_handle_action( 'puya_tooltip', $func_get_args );
	}
	
	 
	function myplugin_set_action_blog_puya_tooltip( $category_name, $category ) 
	{
    		if ( __( 'Other', 'dpa' ) == $category_name && 'blog' == $category )
        		return __( "BuddyPress skeleton component", 'blog' );
    		else
        		return $category_name;
	}


	function puya_tooltips_catch($post_id) {
		// get the post from the post_id
		$post = get_post($post_id);

		//find out if the post contains the [tooltip] shortcode
		if (stripos($post->post_content, '[/tooltip]') !== false) {
            // we have found a post with the short code
            
            
            //if so, AND this is the first time the post has been published, then
			//call do_action, otherwise don't do anything
			//if (true) {
				do_action('puya_tooltip');
			//}
		
		}
		
	}
	

		

class WPTooltip {

	protected $pluginPath;
	protected $pluginUrl;
	
	

	
	
	public function __construct()
	{
		// Set Plugin Path
		$this->pluginPath = dirname(__FILE__);
	
		// Set Plugin URL
		$this->pluginUrl = plugins_url('', __FILE__);
		
		//add_action('publish_post', 'puya_tooltips_catch', 10, 1); //added
		add_action('draft_to_publish', 'puya_tooltips_catch', 10, 1); //added
		
		
		add_action('init', array($this, 'init'));
		add_shortcode('tooltip', array($this, 'shortcode'));
		//add_filter( 'dpa_get_addedit_action_descriptions_blog_puya_tooltip', 'myplugin_set_action_blog_puya_tooltip', 10,2); //added.
		add_filter( 'dpa_get_addedit_action_descriptions_category_name', 'myplugin_set_action_blog_puya_tooltip', 10,2); //added.
		//add_filter( 'dpa_handle_action_user_id', 'dpa_filter_draft_to_publish_action_userid', 10, 3 ); //added custom post types

	}	
	
	public function init()
	{
		wp_enqueue_script('jquery.tipTip', $this->pluginUrl . '/js/jquery.tipTip.minified.js', array('jquery'), '1.3');
		wp_enqueue_script('wp-tooltip', $this->pluginUrl . '/js/wp-tooltip.js', array('jquery'), '1.0.0');

		wp_enqueue_style('jquery.tipTip', $this->pluginUrl . '/js/tipTip.css', '', '1.3');
		wp_enqueue_style('wp-tooltip', $this->pluginUrl . '/wp-tooltip.css', '', '1.0.0');
		
		add_filter('mce_buttons_3', array($this, 'mce_buttons'));
		add_filter('mce_external_plugins', array($this, 'mce_plugins'));
	}
	
	public function mce_buttons($mce_buttons)
	{
		array_push($mce_buttons, 'wp_tooltip');
		return $mce_buttons;
	}
	
	public function mce_plugins($mce_plugins)
	{
		$mce_plugins['wp_tooltip'] = $this->pluginUrl . '/js/shortcode.js';
		return $mce_plugins;
	}
	
	public function shortcode($atts, $content = null)
	{
		
		if($atts['url']) {
			$html .= '<a class="wp-tooltip" href="' . $atts['url'] . '" title="' . $atts['content'] . '">';
			$html .= $content;
			$html .= '</a>';
		} else {
			$html .= '<span class="wp-tooltip" title="' . $atts['content'] . '">';
			$html .= $content;
			$html .= '</span>';
		}
		
		return $html;
	}
	
}

$wpt = new WPTooltip();
