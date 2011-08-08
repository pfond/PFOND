<?php
/*  
	Copyright 2010  Darrell Schauss (email : drale@drale.com)

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

/*
	Yahoo! Answers brand is only mentioned to state what this plugin is for. There is no affiliation of this plugin or its author with Yahoo! Inc.
	Yahoo! Answers is trademark of Yahoo! Inc.
*/

/*
	Plugin Name: YA Widgets
	Plugin URI: http://blog.drale.com/yahoo-answers-wordpress-widgets-plugin/
	Description: Display RSS from Yahoo! Answers with display options that can be toggled
	Author: Darrell Schauss
	Version: 1.0
	Author URI: http://www.drale.com/
*/

//error reporting for development only
//error_reporting(E_ALL);

### Class: YA My Questions Widget
class yawQuestions extends WP_Widget {
	// Constructor
	function yawQuestions() {
		$widget_ops = array('description' => __('Pulls your Yahoo! Answers questions RSS feed.', 'wp-yaq'));
		$this->WP_Widget('yawQuestions', __('YA My Questions'), $widget_ops);
	}
 
	// Display Widget
	function widget($args, $instance) {
		extract($args);
		$title = esc_attr(strip_tags($instance['title']));
		$yaid = esc_attr($instance['yaid']);
		$showstatus = esc_attr($instance['showstatus']);
		$answercount = esc_attr($instance['answercount']);
		$commentcount = esc_attr($instance['commentcount']);
		$numitems = intval($instance['numitems']);
		echo $before_widget.$before_title.$title.$after_title;
		
		require_once(ABSPATH . WPINC . '/rss.php');
		
		$rss = @fetch_rss('http://answers.yahoo.com/rss/userq?kid='.trim($yaid));
		
		if ( isset($rss->items) && 0 != count($rss->items) ) { ?>
		<ul>
		<?php $rss->items = array_slice($rss->items, 0, trim($numitems));
		$liclass='class="even"';
		foreach ($rss->items as $item) {

			//remove status
			if($showstatus != "on"){$item['title'] = preg_replace("/Open Question:|Voting Question:|Resolved Question:/","",$item['title'],1);}
			//remove answer count
			if($answercount != "on"){$item['title'] = preg_replace("/\(Answers: (.*?)\)/","",$item['title'],1);}
			//remove comment count
			if($commentcount != "on"){$item['title'] = preg_replace("/\(Comments: (.*?)\)/","",$item['title'],1);}			
		
			?>
			<li <?php echo $liclass;?>><a href='<?php echo wp_filter_kses($item['link']); ?>' style="color:black;"><?php echo esc_html($item['title']); ?></a></li>
			<?php
			if($liclass == 'class="even"'){$liclass = "";}else{$liclass = 'class="even"';}
		} ?>
		</ul>
		<?php
		}	
		
		echo $after_widget;
	}
 
	// When Widget Control Form Is Posted
	function update($new_instance, $old_instance) {
		if (!isset($new_instance['submit'])) {
			return false;
		}
		$instance = $old_instance;
		$instance['title'] = esc_attr(strip_tags(trim($new_instance['title'])));
		$instance['yaid'] = esc_attr(trim($new_instance['yaid']));
		$instance['showstatus'] = esc_attr(trim($new_instance['showstatus']));
		$instance['answercount'] = esc_attr(trim($new_instance['answercount']));
		$instance['commentcount'] = esc_attr(trim($new_instance['commentcount']));
		$instance['numitems'] = intval($new_instance['numitems']);
		return $instance;
	}
 
	// Display Widget Control Form
	function form($instance) {
		global $wpdb;
		$instance = wp_parse_args((array) $instance, array('title' => __('Yahoo! Answers: Questions', 'wp-yaq'),'yaid'=>'','showstatus'=>'','answercount'=>'','commentcount'=>'','numitems' => 5));
		$title = esc_attr($instance['title']);
		$yaid = esc_attr($instance['yaid']);
		$showstatus = esc_attr($instance['showstatus']);
		$answercount = esc_attr($instance['answercount']);
		$commentcount = esc_attr($instance['commentcount']);
		$numitems = intval($instance['numitems']);
?> 
 
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'wp-yaq'); ?>
<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>

		<p><label for="<?php echo $this->get_field_id('yaid'); ?>"><?php _e('Yahoo! Answers ID', 'wp-yaq'); ?>
<input id="<?php echo $this->get_field_id('yaid'); ?>" name="<?php echo $this->get_field_name('yaid'); ?>" type="text" value="<?php echo $yaid; ?>" /></label></p>

		<p><label for="<?php echo $this->get_field_id('showstatus'); ?>">
		<input id="<?php echo $this->get_field_id('showstatus'); ?>" name="<?php echo $this->get_field_name('showstatus'); ?>" type="checkbox" <?php checked($showstatus,'on');?> /> <?php _e('Show status', 'wp-yaq'); ?></label></p>
		
		<p><label for="<?php echo $this->get_field_id('answercount'); ?>">
		<input id="<?php echo $this->get_field_id('answercount'); ?>" name="<?php echo $this->get_field_name('answercount'); ?>" type="checkbox" <?php checked($answercount,'on');?> /> <?php _e('Show answer count', 'wp-yaq'); ?></label></p>
		
		<p><label for="<?php echo $this->get_field_id('commentcount'); ?>">
		<input id="<?php echo $this->get_field_id('commentcount'); ?>" name="<?php echo $this->get_field_name('commentcount'); ?>" type="checkbox" <?php checked($commentcount,'on');?> /> <?php _e('Show comment count', 'wp-yaq'); ?></label></p>

		<p><label for="<?php echo $this->get_field_id('numitems'); ?>"><?php _e('# of items', 'wp-yaq'); ?>
<input id="<?php echo $this->get_field_id('numitems'); ?>" name="<?php echo $this->get_field_name('numitems'); ?>" type="text" value="<?php echo $numitems; ?>" /></label></p>
 
<input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
<?php
	}
}

### Class: YA My Favorites Widget
class yawFavorites extends WP_Widget {
	// Constructor
	function yawFavorites() {
		$widget_ops = array('description' => __('Pulls your Yahoo! Answers starred questions RSS feed.', 'wp-yaf'));
		$this->WP_Widget('yawFavorites', __('YA My Favorites'), $widget_ops);
	}
 
	// Display Widget
	function widget($args, $instance) {
		extract($args);
		$title = esc_attr(strip_tags($instance['title']));
		$yaid = esc_attr($instance['yaid']);
		$showstatus = esc_attr($instance['showstatus']);
		$showcat = esc_attr($instance['showcat']);
		$numitems = intval($instance['numitems']);
		echo $before_widget.$before_title.$title.$after_title;
		
		require_once(ABSPATH . WPINC . '/rss.php');
		
		$rss = @fetch_rss('http://answers.yahoo.com/rss/userstarredlist?kid='.trim($yaid));
		
		if ( isset($rss->items) && 0 != count($rss->items) ) { ?>
		<ul>
		<?php $rss->items = array_slice($rss->items, 0, trim($numitems));
		$liclass='class="even"';
		foreach ($rss->items as $item) {

			//remove status
			if($showstatus != "on"){$item['title'] = preg_replace("/Open Question:|Voting Question:|Resolved Question:/","",$item['title'],1);}			
			//remove category
			if($showcat != "on"){$item['title'] = preg_replace("/\[(.*?)\]/","",$item['title'],1);}
		
			?>
			<li <?php echo $liclass;?>><a href='<?php echo wp_filter_kses($item['link']); ?>' style="color:black;"><?php echo esc_html($item['title']); ?></a></li>
			<?php
			if($liclass == 'class="even"'){$liclass = "";}else{$liclass = 'class="even"';}
		} ?>
		</ul>
		<?php
		}	
		
		echo $after_widget;
	}
 
	// When Widget Control Form Is Posted
	function update($new_instance, $old_instance) {
		if (!isset($new_instance['submit'])) {
			return false;
		}
		$instance = $old_instance;
		$instance['title'] = esc_attr(strip_tags(trim($new_instance['title'])));
		$instance['yaid'] = esc_attr(trim($new_instance['yaid']));
		$instance['showstatus'] = esc_attr(trim($new_instance['showstatus']));
		$instance['showcat'] = esc_attr(trim($new_instance['showcat']));
		$instance['numitems'] = intval($new_instance['numitems']);
		return $instance;
	}
 
	// Display Widget Control Form
	function form($instance) {
		global $wpdb;
		$instance = wp_parse_args((array) $instance, array('title' => __('Yahoo! Answers: Favorites', 'wp-yaf'),'yaid'=>'','showstatus'=>'','showcat'=>'','numitems' => 5));
		$title = esc_attr($instance['title']);
		$yaid = esc_attr($instance['yaid']);
		$showstatus = esc_attr($instance['showstatus']);
		$showcat = esc_attr($instance['showcat']);
		$numitems = intval($instance['numitems']);
?> 
 
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'wp-yaf'); ?>
<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>

		<p><label for="<?php echo $this->get_field_id('yaid'); ?>"><?php _e('Yahoo! Answers ID', 'wp-yaf'); ?>
<input id="<?php echo $this->get_field_id('yaid'); ?>" name="<?php echo $this->get_field_name('yaid'); ?>" type="text" value="<?php echo $yaid; ?>" /></label></p>

		<p><label for="<?php echo $this->get_field_id('showstatus'); ?>">
		<input id="<?php echo $this->get_field_id('showstatus'); ?>" name="<?php echo $this->get_field_name('showstatus'); ?>" type="checkbox" <?php checked($showstatus,'on');?> /> <?php _e('Show status', 'wp-yaf'); ?></label></p>
		
		<p><label for="<?php echo $this->get_field_id('showcat'); ?>">
		<input id="<?php echo $this->get_field_id('showcat'); ?>" name="<?php echo $this->get_field_name('showcat'); ?>" type="checkbox" <?php checked($showcat,'on');?> /> <?php _e('Show category', 'wp-yaf'); ?></label></p>

		<p><label for="<?php echo $this->get_field_id('numitems'); ?>"><?php _e('# of items', 'wp-yaf'); ?>
<input id="<?php echo $this->get_field_id('numitems'); ?>" name="<?php echo $this->get_field_name('numitems'); ?>" type="text" value="<?php echo $numitems; ?>" /></label></p>
 
<input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
<?php
	}
}
 
### Function: Init Widget
function widget_yaw_init() {
	register_widget('yawQuestions');
	register_widget('yawFavorites');
}
add_action('widgets_init', 'widget_yaw_init');
?>