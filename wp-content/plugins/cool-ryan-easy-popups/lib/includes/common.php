<?php
/**
 * Common Front End Functions
 * @package Easy Popups
 * @since 1.0
 */

/**
 * Enqueues The appropriate Javascript for the Dialog Box To Work
 * @name CREP Enqueue JS
 * @since 1.0
 */
 function crepEnqueueJS() {
 	wp_enqueue_script('jquery');
 	wp_enqueue_script('jquery-ui-core', '', array('jquery'), '', false);
 	wp_enqueue_script('jquery-ui-sortable', '', array('jquery-ui-core'), '', false);
 	wp_enqueue_script('jquery-ui-draggable', '', array('jquery-ui-core'), '', false);
 	wp_enqueue_script('jquery-ui-droppable', '', array('jquery-ui-core'), '', false);
 	wp_enqueue_script('jquery-ui-selectable', '', array('jquery-ui-core'), '', false);
 	wp_enqueue_script('jquery-ui-resizable', '', array('jquery-ui-core'), '', false);
 	wp_register_script('jquery-ui-effects', '/' . CREP_JS_URL . '/jquery-ui-effects.js');
 	wp_enqueue_script('jquery-ui-effects', '', array('jquery-ui-core'), '', false);
 	wp_enqueue_script('jquery-ui-dialog', '', array('jquery-ui-core'), '', false);
 }
 
 /**
  * Enqueues the style sheets for the Dialog Box
  * @name CREP Enqueue CSS
  * @since 1.0
  */
 function crepEnqueueCSS() {
 	$styleURL = get_option('crep_style');
 	wp_register_style('crep_style', '/' . CREP_CSS_URL . '/' . $styleURL . '/custom.css');
 	wp_enqueue_style('crep_style');
 }
 
 /**
  * HTML to display the popup box
  * @name CReP Popup HTML
  * @since 1.0
  */
 function crepPopupHTML() {
 	$text = stripcslashes(get_option('crep_text'));
 	$code = stripcslashes(get_option('crep_code'));
 	$html = <<<HTML
 	<div id="crep-popup-box">
 		$text
 		$code	
 	</div>
HTML;

 echo $html;
 }
 
 /**
  * Initialization Function
  * @name CREP Init
  * @since 1.0
  */
 function crepInit() {
 	crepCookie();
 	crepEnqueueJS();
 	crepEnqueueCSS();
 }
 
 /**
  * Javascript to display the popup box
  * @name CReP Popup JS
  * @since 1.0
  */
 function crepPopupJS() {
 	$title = get_option('crep_title');
 	$width = get_option('crep_width');
 	$height = get_option('crep_height');
 	$modal = get_option('crep_modal');
 	$show = get_option('crep_open_animation');
 	$hide = get_option('crep_close_animation');
 	$js = <<<JS
 	<script type="text/javascript">
 	jQuery(document).ready(function($) {
 		$( "#crep-popup-box" ).dialog({ 
 			modal: $modal,
 			title: '$title',
 			width: $width,
 			height: $height,
 			show: '$show',
 			hide: '$hide'
 		});
	});
	</script>
JS;

 	echo $js;
 }
 
 /**
  * Creates the Popup box
  * @name CREP Popup
  * @since 1.0
  */
 function crepPopup() {
 	$runBox = false;
 	$is_front_page = get_option('crep_home_page');
 	$is_page = get_option('crep_pages');
 	$is_post = get_option('crep_posts');
 	$expires = get_option('crep_cookie_frequency');
 	
 	if(!isset($_COOKIE['crep'])) {
	 	if(is_home()) {
	 		if($is_front_page == 'yes') {
	 			$runBox = true;
	 		}
	 	}
	 	elseif(is_page()) {
	 		if($is_page == 'yes') {
	 			$runBox = true;
	 		}
	 	}
	 	elseif(is_single()) {
	 		if($is_post == 'yes') {
	 			$runBox = true;
	 		}
	 	}
 	}
 	
 	if($runBox) {
 		add_action('wp_footer', 'crepPopupHTML');
 		add_action('wp_head', 'crepPopupJS');
 	}
 	
 }
 
 /**
  * Sets the Cookie
  * @name CREP Set Cookie
  * @since 1.0
  */
 function crepCookie() {
 	$expires = get_option('crep_cookie_frequency');
 	// Do not set a cookie if set to 0
 	if($expires != 0) {
 	// Find out if www is in the domain
 	$domain = get_bloginfo('url');
 	$www = 'www';
 	$is_www_in_it = stripos($domain, $www);
 	if($is_www_in_it === false) {
 		$cookie_domain = str_ireplace('http://', '.', $domain);
 	}
 	else {
 		$cookie_domain = str_ireplace('http://www', '', $domain);
 	}
 		$cookie = setcookie('crep', 'show', time()+60*60*24*$expires, '/', $cookie_domain);
 	}
 }
 ?>