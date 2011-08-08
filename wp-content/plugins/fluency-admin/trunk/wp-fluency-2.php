<?php
/*
Plugin Name: Fluency Admin
Plugin URI: http://deanjrobinson.com/projects/fluency-admin/
Description: Give your WordPress admin the Fluency look, Fluency 2.4 is the latest update and is compatible with WP 3.1.x. You can customize Fluency using the options found under 'Fluency Options' in the 'Settings' menu.
Version: 2.4
License: GPL
Author: Dean Robinson
Author URI: http://deanjrobinson.com/
*/ 

/*
 * iPad Detection for custom styles
 */
if(preg_match('/iPad/',$_SERVER['HTTP_USER_AGENT'])) {
	define("FLUENCY_IPAD",true);
} else {
	define("FLUENCY_IPAD",false);
}

class WP_Fluency_Admin {

	static $instance;
	const fluency_version = '2.4';

	var $fluency_admin_drop_down;
	var $fluency_click_menus;
	var $fluency_login_logo;
	var $fluency_login_style;
	var $fluency_login_link;
	var $fluency_hide_menu;
	var $fluency_custom_color;
	var $fluency_menu_width;
	var $fluency_menu_position;
	var $fluency_menu_icons;
	var $fluency_menu_logo;
	var $fluency_hidden_menu_logo;
	var $fluency_hot_keys;

	var $fluency_warning;

	public function __construct() {
		self::$instance = $this;
		$this->init();
	}

	public function init() {

		isset($_REQUEST['_wp_fluency_nonce']) ? add_action('admin_init',array($this,'wp_fluency_options_save')) : null;

		$this->fluency_vars();

		// Set defaults on activation
		if (isset($_GET['action']) && $_GET['action'] == 'activate' && isset($_GET['plugin']) && $_GET['plugin'] == 'wp-fluency-2/wp-fluency-2.php') {
			if(empty($this->fluency_login_style)) { update_option('fluency_login_style', 'true'); $this->fluency_login_style = get_option('fluency_login_style'); }
			if(empty($this->fluency_login_logo)) { update_option('fluency_login_logo', ''); $this->fluency_login_logo = get_option('fluency_login_logo'); }
			if(empty($this->fluency_login_link)) { update_option('fluency_login_link', ''); $this->fluency_login_link = get_option('fluency_login_link'); }
			if(empty($this->fluency_menu_logo)) { update_option('fluency_menu_logo', ''); $this->fluency_menu_logo = get_option('fluency_menu_logo'); }
			if(empty($this->fluency_hidden_menu_logo)) { update_option('fluency_hidden_menu_logo', ''); $this->fluency_hidden_menu_logo = get_option('fluency_hidden_menu_logo'); }
			if(empty($this->fluency_menu_width)) { update_option('fluency_menu_width', ''); $this->fluency_menu_width = get_option('fluency_menu_width'); }
			if(empty($this->fluency_menu_position)) { update_option('fluency_menu_position', 'true'); $this->fluency_menu_position = get_option('fluency_menu_position'); }
			if(empty($this->fluency_menu_icons)) { update_option('fluency_menu_icons', 'true'); $this->fluency_menu_icons = get_option('fluency_menu_icons'); }
			if(empty($this->fluency_click_menus)) { update_option('fluency_click_menus', 'false'); $this->fluency_click_menus = get_option('fluency_click_menus'); }
			if(empty($this->fluency_hot_keys)) { update_option('fluency_hot_keys', 'true'); $this->fluency_hot_keys = get_option('fluency_hot_keys'); }
			if(empty($this->fluency_custom_color)) { update_option('fluency_custom_color', '0'); $this->fluency_custom_color = get_option('fluency_custom_color'); }
			if(empty($this->fluency_admin_drop_down)) { update_option('fluency_admin_drop_down', '0'); $this->fluency_admin_drop_down = get_option('fluency_admin_drop_down'); }
			if(empty($this->fluency_hide_menu)) { update_option('fluency_hide_menu', ''); $this->fluency_hide_menu = get_option('fluency_hide_menu'); }
		}

		add_action('admin_init',array($this,'wp_fluency_options_help'));
		add_action('admin_init',array($this,'wp_fluency_register_admin_color_schemes'),100);
		add_action('admin_init',array($this,'wp_fluency_textdomain'));

		add_action('admin_print_styles',array($this,'admin_css'));
		if($this->fluency_click_menus=='true' || FLUENCY_IPAD) {
			add_action('admin_print_styles',array($this,'wp_admin_fluency_clickmenus'));
		}
		if(FLUENCY_IPAD) {
			add_action('admin_print_styles',array($this,'wp_admin_fluency_ipadmenus'));
		}
		add_action('admin_print_styles',array($this,'wp_fluency_admin_bar_css'));
		add_action('admin_print_styles-post-new.php',array($this,'just_write_css'));
		add_action('admin_print_styles-post.php',array($this,'just_write_css'));
		add_action('admin_print_styles-settings_page_fluency-options',array($this,'wp_fluency_farbtastic'));

		add_action('wp_print_styles',array($this,'wp_fluency_admin_bar_css'));

		add_action('admin_print_scripts',array($this,'wp_admin_fluency_js'));

		add_action('admin_head-settings_page_fluency-options',array($this,'wp_fluency_farbtastic_init'));
		add_action('admin_head',array($this,'wp_admin_fluency_custom_styles'));
		add_action('admin_head',array($this,'wp_admin_default_init'));

		if($this->fluency_login_style=='true') {
			add_action('login_head',array($this,'wp_login_fluency_css'));
		}
		if($this->fluency_login_logo!='') {
			add_action('login_head',array($this,'wp_login_fluency_custom_logo'));
		}
		add_filter('login_headerurl',array($this,'wp_login_fluency_custom_link'));

		add_action('in_admin_footer',array($this,'admin_footer'),1000);

		add_filter('custom_menu_order',array($this,'wp_fluency_unset_separators'));
		add_action('admin_menu',array($this,'wp_fluency_options_menu'));
		if(function_exists('akismet_init')) {
			add_action('admin_menu',array($this,'comments_akismet_stats_page'));
		}

		if($this->fluency_admin_drop_down == 1 || $this->fluency_admin_drop_down == 2) {
			add_action('add_admin_bar_menus',array($this,'wp_fluency_remove_superfluous_admin_bar_menus'),100);
		}

		if($this->fluency_admin_drop_down == 1) { // before user menu for single menu
			add_action( 'admin_bar_menu', array($this,'single_admin_bar_menu'), 5 );
		} else if($this->fluency_admin_drop_down == 2) { // after user menu for multiple menus
			add_action( 'admin_bar_menu', array($this,'multiple_admin_bar_menu'), 15 );
		}

		if(is_admin() && ($this->fluency_hide_menu=='1' || (isset($_POST['fluency_hide_menu']) && $_POST['fluency_hide_menu']=='1'))) {
			add_action( 'wp_before_admin_bar_render', array($this,'wp_fluency_admin_bar_unhide_menu'),110 );
		}

	}

	/*
	 * Set up the Fluency variables
	 */
	public function fluency_vars() {
		$this->fluency_login_style = get_option('fluency_login_style');
		$this->fluency_login_logo = get_option('fluency_login_logo');
		$this->fluency_login_link = get_option('fluency_login_link');
		$this->fluency_menu_logo = get_option('fluency_menu_logo');
		$this->fluency_hidden_menu_logo = get_option('fluency_hidden_menu_logo');
		$this->fluency_menu_width = get_option('fluency_menu_width');
		$this->fluency_menu_position = get_option('fluency_menu_position');
		$this->fluency_menu_icons = get_option('fluency_menu_icons');
		$this->fluency_click_menus = get_option('fluency_click_menus');
		$this->fluency_hot_keys = get_option('fluency_hot_keys');
		$this->fluency_custom_color = get_option('fluency_custom_color');
		$this->fluency_admin_drop_down = get_option('fluency_admin_drop_down');
		$this->fluency_hide_menu = get_option('fluency_hide_menu');
		return;
	}

	/*
	 * Add Fluency Stylesheet to admin head
	 */
	public function admin_css() {
		global $userdata;
		wp_enqueue_style('fluency',plugins_url('', __FILE__ ) . '/resources/wp-admin.css', $deps = array(), $ver = self::fluency_version, $media = 'all' );
		if(!empty($this->fluency_custom_color)) {
			wp_enqueue_style('fluency-custom-colors',plugins_url('', __FILE__ ) . '/resources/custom-colors.css.php?color=' . $this->fluency_custom_color, $deps = array(), $ver = self::fluency_version, $media = 'all' );
		} else {
			$userdata->admin_color == 'classic' ? wp_enqueue_style('fluency-classic-colors',plugins_url('', __FILE__ ) . '/resources/classic-colors.css', $deps = array(), $ver = self::fluency_version, $media = 'all' ) : null;
			if($userdata->admin_color == 'coffee') {
				wp_deregister_style('colors');
				wp_enqueue_style('colors-fresh');
				wp_enqueue_style('fluency-coffee-colors',plugins_url('', __FILE__ ) . '/resources/coffee-colors.css', $deps = array(), $ver = self::fluency_version, $media = 'all' );
			}
			if($userdata->admin_color == 'light') {
				wp_deregister_style('colors');
				wp_enqueue_style('colors-fresh');
				wp_enqueue_style('fluency-light-colors',plugins_url('', __FILE__ ) . '/resources/light-colors.css', $deps = array(), $ver = self::fluency_version, $media = 'all' );
			}
		}
		return;
	}

	/*
	 * Add Stylesheet for 'Just Write', calls action to add Admin Bar button
	 */
	public function just_write_css() {
		global $post_type;
		wp_enqueue_style('just-write',plugins_url('', __FILE__ ) . '/resources/just-write.css', $deps = array(), $ver = self::fluency_version, $media = 'all' );
		if('page' == $post_type) {
			add_action('submitpage_box',array($this,'just_write_button'),90);
		} else {
			add_action('submitpost_box',array($this,'just_write_button'),90);
		}
		return;
	}

	/*
	 * Add 'Just Write' toggle button WP Admin Bar
	 */
	public function just_write_button() {
		echo '<a href="#justwrite" id="wp-fluency-just-write" title="'.__('Just Write','fluency-admin').'">'.__('Just Write','fluency-admin').' <small>'.__('Click to turn on','fluency-admin').'</small></a>';
		return;
	}

	/*
	 * Add Farbtastic styles and scripts for the Fluency Settings page
	 */
	public function wp_fluency_farbtastic(){
		wp_enqueue_script('farbtastic');
		wp_enqueue_style('farbtastic');
		return;
	}

	/*
	 * Add Farbtastic Init script fort he Fluency Settings page
	 */
	public function wp_fluency_farbtastic_init(){
		?><script>(function($){$(document).ready(function(){fluencyFarbtastic.init();});})(jQuery);</script><?php
		return;
	}

	/*
	 * Add Style overrides for custom menu width/positioning
	 */
	public function wp_admin_fluency_custom_styles() {
		$o = '<style>';
		if(!FLUENCY_IPAD && !empty($this->fluency_menu_width) && $this->fluency_menu_width>=140){
			$o .= '#wpwrap,#footer {border-left-width:'.$this->fluency_menu_width.'px;}';
			$o .= '#wpwrap #footer {margin-left:-'.$this->fluency_menu_width.'px;}';
			$o .= '#adminmenu,#adminmenu li.wp-has-submenu {width:'.$this->fluency_menu_width.'px;}';
			$o .= '#adminmenu a.menu-top {min-width:'.($this->fluency_menu_width-30).'px;}';
			$o .= '#adminmenu li.wp-has-submenu.hover {width:'.($this->fluency_menu_width+8).'px;}';
			$o .= '#adminmenu li div.wp-submenu {left:'.($this->fluency_menu_width+8).'px;}';
			$o .= '#adminmenu .menu-top-last a.menu-top,#adminmenu li a.wp-has-submenu,#adminmenu li.menu-top-first a.wp-has-submenu,#adminmenu li a.menu-top,#adminmenu li.wp-has-current-submenu a.wp-has-current-submenu,#adminmenu li.menu-top > a.current,#adminmenu li.wp-first-item.current,#adminmenu li.wp-has-current-submenu,#adminmenu li.menu-top:hover, #adminmenu li.menu-top.hover {background-position:'.($this->fluency_menu_width-280).'px bottom;}';
			$o .= '#adminmenu li.menu-top-last a, #adminmenu li.menu-top-last a:hover, #adminmenu li.menu-top .current, #adminmenu li.menu-top .current:hover {background-position:'.($this->fluency_menu_width-14).'px -112px;}';
			$o .= '#admin-bar-logo {margin-left:'.($this->fluency_menu_width+10).'px;}';
		}
		if($this->fluency_menu_position=='false') $o .= '#adminmenu{position:absolute;}';
		if($this->fluency_menu_icons=='false') $o .= '#adminmenu li div.wp-menu-image{display:none;}.hiddenMenu #adminmenu li div.wp-menu-image{display:block;}#adminmenu > li > a > #awaiting-mod{right:25px;left:auto;}#adminmenu > li.hover > a > #awaiting-mod{right:33px;left:auto;}';
		if($this->fluency_menu_logo!='') $o .= '#adminmenu { background-image:url("'.$this->fluency_menu_logo.'");}';
		if($this->fluency_hidden_menu_logo!='') $o .= '.hiddenMenu #adminmenu { background-image:url("'.$this->fluency_hidden_menu_logo.'");}';
		if($this->fluency_hide_menu=='1') {
			$o .= 'body.admin_menu_hidden #adminmenu { display:none; } body.admin_menu_hidden #wpwrap,body.admin_menu_hidden #footer { border-width:0px; }';
			add_filter('admin_body_class',array($this,'wp_fluency_admin_body_class'));
		}
		$o .= '</style>';
		echo $o;
		return;
	}

	/*
	 * Filter to add class to body element when Admin Menu is completely hidden (Used in 'wp_admin_fluency_custom_styles')
	 */
	public function wp_fluency_admin_body_class($x){
		return $x.' admin_menu_hidden';
	}

	/*
	 * Add Styles for click-to-open menus
	 */
	public function wp_admin_fluency_clickmenus() {
		global $userdata;
		if(!empty($this->fluency_custom_color)) {
			wp_enqueue_style('fluency-clickmenus',plugins_url('', __FILE__ ) . '/resources/click-menus.css.php?color='.$this->fluency_custom_color, $deps = array(), $ver = self::fluency_version, $media = 'all' );
		} else {
			wp_enqueue_style('fluency-clickmenus',plugins_url('', __FILE__ ) . '/resources/click-menus.css.php'.($userdata->admin_color == 'classic' ? '?classic=true' : ''), $deps = array(), $ver = self::fluency_version, $media = 'all' );
		}
		return;
	}

	/*
	 * Add Styles for iPad 'optimised' menus
	 */
	public function wp_admin_fluency_ipadmenus() {
		wp_enqueue_style('fluency-ipadmenus',plugins_url('', __FILE__ ) . '/resources/ipad-menus.css', $deps = array(), $ver = self::fluency_version, $media = 'all' );
		return;
	}

	/*
	 * Default script init for Fluency Menus
	 */
	public function wp_admin_default_init() {
		?><script>(function($){$(document).ready(function(){adminMenu={init:function(){}};<?php if($this->fluency_click_menus=='true' || FLUENCY_IPAD) { ?>fluencyClickMenu.init();<?php } else { ?>fluencyHoverMenu.init();<?php if($this->fluency_hot_keys=='true') { ?>fluencyKeys.init();<?php } } ?>});})(jQuery);</script><?php
		return;
	}

	/*
	 * Add Fluency Javascript to admin footer
	 */
	public function wp_admin_fluency_js() {
		wp_enqueue_script('fluency',plugins_url('', __FILE__ ) . '/resources/fluency.min.js', $deps = array('jquery'), $ver = self::fluency_version, $in_footer = true );
		return;
	}

	/*
	 * Add Fluency Login Stylesheet to login head
	 */
	public function wp_login_fluency_css() {
		$this->wp_admin_fluency_enqueue_style('fluency-login',plugins_url('', __FILE__ ) . '/resources/wp-login.css', $deps = array(), $ver = self::fluency_version, $media = 'all' );
		return;
	}

	/*
	 * Add Custom Logo to Login page to override WordPress logo
	 */
	public function wp_login_fluency_custom_logo() {
		?><style type="text/css">#login h1 a { background-image:url("<?php echo get_option('fluency_login_logo'); ?>") !important; }</style><?php
	}

	/*
	 * Add Custom Link to Logo on Login page
	 */
	public function wp_login_fluency_custom_link($link) {
		return get_option('fluency_login_link')!='' ? get_option('fluency_login_link') : $link;
	}

	/*
	 * Function that mimics the core wp_enqueue_style function which doesn't appear to work on the login page
	 */
	public function wp_admin_fluency_enqueue_style($handle='',$file='', $deps = array(), $ver = self::fluency_version, $media = 'all') {
		echo '<link rel="stylesheet" id="' . $handle . '-css" href="' . $file . '?version=' . $ver .'" type="text/css" media="' . $media . '" />'."\n";
		return;
	}

	/*
	 * Adds Fluency information to wp-admin footer
	 */
	public function admin_footer(){
		echo '<span id="fluency-footer"><a href="http://deanjrobinson.com/projects/fluency-admin/">Fluency Admin '.self::fluency_version.'</a> '.__('is a plugin by', 'fluency-admin').' <a href="http://deanjrobinson.com">Dean Robinson</a> - <a href="http://deanjrobinson.com/donate/">'.__('Donate', 'fluency-admin').'</a></span><br/>';
		return;
	}

	/*
	 * Adds Akismet Link to the Comments menu in addtion to the item under Dashboard
	 */
	public function comments_akismet_stats_page() {
		add_submenu_page('edit-comments.php', __('Akismet Stats', 'fluency-admin'), __('Akismet Stats', 'fluency-admin'), 'manage_options', 'akismet-stats-display', 'akismet_stats_display');
		return;
	}

	/*
	 * Add Contextual Help to Fluency Admin Options Page
	 */
	public function wp_fluency_options_help() {
		add_contextual_help('settings_page_fluency-options',
		'<p>' . __('If you find any bugs, or any conflicts with other plugins please report them via one of the links below.', 'fluency-admin') . '</p>' .
		'<p>' . __('If you have any feature requests, please send them via one of the support links below.', 'fluency-admin') . '</p>' .
		'<p><strong>' . __('For support:', 'fluency-admin') . '</strong></p>' .
		'<p><a href="http://wordpress.org/tags/fluency-admin?forum_id=10" target="_blank">' . __('Fluency support on the WordPress.org support forums', 'fluency-admin') . '</a></p>' .
		'<p><a href="http://help.deanjrobinson.com/groups/fluency-admin/" target="_blank">' . __('Fluency support on help.deanjrobinson.com', 'fluency-admin') . '</a></p>' .
		'<p><strong>' . __('For more information:', 'fluency-admin') . '</strong></p>' .
		'<p><a href="http://wordpress.org/extend/plugins/fluency-admin/" target="_blank">' . __('Fluency Admin on WordPress.org', 'fluency-admin') . '</a></p>' .
		'<p><a href="http://deanjrobinson.com/projects/fluency-admin/" target="_blank">' . __('Homepage for Fluency Admin', 'fluency-admin') . '</a></p>'
		);
		return;
	}

	/*
	 * Registers Additional Fluency Admin color schemes
	 */
	public function wp_fluency_register_admin_color_schemes() {
		wp_admin_css_color('coffee', __('Coffee', 'fluency-admin'), plugins_url('', __FILE__ ) . '/resources/coffee-colors.css', array('#301E0F', '#907E6F', '#FCEADB', '#ECDACB'));
		wp_admin_css_color('light', __('Light', 'fluency-admin'), plugins_url('',__FILE__) . '/resources/light-colors.css', array('#C6C6C6', '#D3D3D3', '#F1F1F1', '#DFDFDF'));
		return;
	}

	/*
	 * Load TextDomain for translations
	 */
	public function wp_fluency_textdomain() { // l10n
		load_plugin_textdomain( 'fluency-admin', 'wp-content/plugins/' . plugin_basename(dirname(__FILE__)) . '/languages', '' . plugin_basename(dirname(__FILE__)) . '/languages' );
		return;
	}

	/*
	 * Load Fluency style overrides for the WP Admin Bar.
	 */
	public function wp_fluency_admin_bar_css() {
		global $show_admin_bar;
		if ( !$show_admin_bar )
			return;
		wp_enqueue_style('fluency-admin-bar',plugins_url('', __FILE__ ) . '/resources/wp-admin-bar.css', $deps = array(), $ver = self::fluency_version, $media = 'all' );
		return;
	}

	/*
	 * Add Single Admin dropdown to WP Admin Bar
	 */
	public function single_admin_bar_menu() {

		global $wp_admin_bar, $current_user, $menu, $submenu, $wp_taxonomies;

		if ( !is_object( $wp_admin_bar ) )
			return false;

		if(!is_admin()){
			include_once('wp-admin/includes/update.php');
			include_once('wp-admin/includes/plugin.php');
			include_once('wp-admin/menu.php');
		}

		$icon = '<img src="' . esc_url(plugins_url('', __FILE__ ) . '/resources/images/wp-icon.png') . '" alt="' . __( 'WP Admin' , 'fluency-admin' ) . '" width="16" height="16" class="fl-icon"/>';
		$wp_admin_bar->add_menu( array( 'id' => 'wp-fluency-admin-menu', 'title' => $icon, 'href' => admin_url().$menu[2][2] ) );

		foreach($menu as $m){
			if($m[4]=='wp-menu-separator') continue;
			if(substr($m[2],-4)!='.php' && $m[1]=='manage_options'){
				$wp_admin_bar->add_menu( array( 'parent' => 'wp-fluency-admin-menu', 'title' => $m[0], 'id' => 'wpf-'.$m[5], 'href' => admin_url().'options-general.php?page='.$m[2] ) );
			} else {
				$wp_admin_bar->add_menu( array( 'parent' => 'wp-fluency-admin-menu', 'title' => $m[0], 'id' => 'wpf-'.$m[5], 'href' => admin_url().$m[2] ) );
			}
			$pm = $m[5];
			if(!empty($submenu[$m[2]])){
				foreach($submenu[$m[2]] as $sv=>$sm){
					if(substr($sm[2],-4)!='.php' && $sm[1]=='manage_options'){
						$sm[2] = 'options-general.php?page='.$sm[2];
					} else if(substr($sm[2],-4)!='.php' && $sm[1]=='edit_theme_options'){
						$sm[2] = 'themes.php?page='.$sm[2];
					}
					$wp_admin_bar->add_menu( array( 'parent' => 'wpf-'.$pm, 'title' => $sm[0], 'id' => 'wpf-'.$sv.'-'.$sm[1], 'href' => admin_url().$sm[2] ) );
				}
			}
		}

	}

	/*
	 * Add Multiple Admin dropdowns to WP Admin Bar
	 */
	public function multiple_admin_bar_menu() {

		global $wp_admin_bar, $current_user, $menu, $submenu, $wp_taxonomies;

		if ( !is_object( $wp_admin_bar ) )
			return false;

		if(!is_admin()){
			include_once('wp-admin/includes/update.php');
			include_once('wp-admin/includes/plugin.php');
			include_once('wp-admin/menu.php');
		}

		foreach($menu as $m){
			if($m[4]=='wp-menu-separator') continue;
			$wp_admin_bar->add_menu( array( 'title' => '<div class="wp-menu-image">'.$m[0].'</div>', 'id' => 'wpf-'.$m[5], 'href' => admin_url().$m[2], 'meta' => array('class'=>$m[4].' wpf-menu') ) );
			$pm = $m[5];
			if(!empty($submenu[$m[2]])){
				foreach($submenu[$m[2]] as $sv=>$sm){
					if(substr($sm[2],-4)!='.php' && $sm[1]=='manage_options'){
						$sm[2] = 'options-general.php?page='.$sm[2];
					} else if(substr($sm[2],-4)!='.php' && $sm[1]=='edit_theme_options'){
						$sm[2] = 'themes.php?page='.$sm[2];
					}
					$wp_admin_bar->add_menu( array( 'parent' => 'wpf-'.$pm, 'title' => $sm[0], 'id' => 'wpf-'.$sv.'-'.$sm[1], 'href' => admin_url().''.$sm[2] ) );
				}
			}
		}

	}

	/*
	 * == Make this an option ==
	 * Removes extra menus from admin bar that aren't needed when full menu is enabled
	 */
	public function wp_fluency_remove_superfluous_admin_bar_menus() {
		if ( !is_network_admin() && !is_user_admin() ) {
			remove_action( 'admin_bar_menu', 'wp_admin_bar_new_content_menu', 40 );
			remove_action( 'admin_bar_menu', 'wp_admin_bar_comments_menu', 50 );
			remove_action( 'admin_bar_menu', 'wp_admin_bar_appearance_menu', 60 );
		}
	}

	/*
	 * == look at always showing this ==
	 * Add Unhide/Hide Menu Button Admin Bar
	 */
	public function wp_fluency_admin_bar_unhide_menu() {
		global $wp_admin_bar, $menu;
		$wp_admin_bar->add_menu( array( 'id' => 'wp-fluency-unhide-menu', 'title' => __('Unhide Menu','fluency-admin'), 'href' => '#unhidemenu' ) );
	}

	/*
	 * Remove un-used separators from menu
	 */
	public function wp_fluency_unset_separators(){
		global $menu;
		foreach ( $menu as $id => $data ) {
			if ( 0 == strcmp('wp-menu-separator', $data[4] ) || 0 == strcmp('wp-menu-separator-last', $data[4] ) ) {
				unset($menu[$id]);
			}
		}
		$menu[999] = array( __('Hide Menu', 'fluency-admin'), 'read', 'separator', '', 'wp-menu-separator', 'menu-separator');
		return $menu;
	}

	/*
	 * Fluency Admin Options Save
	 */
	public function wp_fluency_options_save() {
		if(wp_verify_nonce($_REQUEST['_wp_fluency_nonce'],'fluency-admin')) {
			if ( isset($_POST['submit']) ) {
				( function_exists('current_user_can') && !current_user_can('manage_options') ) ? die(__('Cheatin&#8217; uh?', 'fluency-admin')) : null;
				isset($_POST['fluency_login_style']) ? update_option('fluency_login_style', 'true') : update_option('fluency_login_style', 'false');
				isset($_POST['fluency_login_logo']) ? update_option('fluency_login_logo', strip_tags($_POST['fluency_login_logo'])) : update_option('fluency_login_logo', '');
				isset($_POST['fluency_login_link']) ? update_option('fluency_login_link', strip_tags($_POST['fluency_login_link'])) : update_option('fluency_login_link', '');
				isset($_POST['fluency_menu_logo']) ? update_option('fluency_menu_logo', strip_tags($_POST['fluency_menu_logo'])) : update_option('fluency_menu_logo', '');
				isset($_POST['fluency_hidden_menu_logo']) ? update_option('fluency_hidden_menu_logo', strip_tags($_POST['fluency_hidden_menu_logo'])) : update_option('fluency_hidden_menu_logo', '');
				isset($_POST['fluency_menu_width']) ? update_option('fluency_menu_width', strip_tags($_POST['fluency_menu_width'])) : update_option('fluency_menu_width', '');
				isset($_POST['fluency_menu_position']) ? update_option('fluency_menu_position', 'true') : update_option('fluency_menu_position', 'false');
				isset($_POST['fluency_menu_icons']) ? update_option('fluency_menu_icons', 'true') : update_option('fluency_menu_icons', 'false');
				isset($_POST['fluency_click_menus']) ? update_option('fluency_click_menus', 'false') : update_option('fluency_click_menus', 'true');
				isset($_POST['fluency_hot_keys']) ? update_option('fluency_hot_keys', 'true') : update_option('fluency_hot_keys', 'false');
				isset($_POST['fluency_custom_color']) ? update_option('fluency_custom_color', substr(strip_tags($_POST['fluency_custom_color']),1)) : update_option('fluency_custom_color', '');
				isset($_POST['fluency_admin_drop_down']) ? update_option('fluency_admin_drop_down', strip_tags($_POST['fluency_admin_drop_down'])) : update_option('fluency_admin_drop_down', '0');

				if(isset($_POST['fluency_hide_menu']) && $_POST['fluency_hide_menu']=='1') {
					global $wp_admin_bar;
					if((isset($_POST['fluency_admin_drop_down']) && ($_POST['fluency_admin_drop_down']=='1' || $_POST['fluency_admin_drop_down']=='2')) && is_object( $wp_admin_bar ) ) { //  && (isset($_POST['fluency_admin_bar']) && $_POST['fluency_admin_bar']=='2')
						update_option('fluency_hide_menu', strip_tags($_POST['fluency_hide_menu']));
					} else {
						update_option('fluency_hide_menu', '0');
						$this->fluency_warning = __('<strong>Admin menu was not hidden</strong><br/>Make sure you\'ve still go the Admin Bar enabled and have selected one of the Admin Bar drop down options (otherwise you won\'t have any admin menu at all... and that won\'t be good)','fluency-admin');
					}
				} else {
					update_option('fluency_hide_menu', '0');
				}

				$this->fluency_vars();
			}
		}
	}

	/*
	 * Fluency Admin Options Page
	 */
	public function wp_fluency_options_page() {
		if ( !empty($_POST) ) { ?>
			<div id="message" class="updated fade"><p><strong><?php _e('Options saved.', 'fluency-admin') ?></strong></p></div>
			<?php if (!empty($this->fluency_warning)) { ?>
				<div id="error" class="error fade"><p><?php echo $this->fluency_warning ?></p></div>
			<?php } ?>
		<?php } ?>
		<div class="wrap">
			<?php screen_icon(); ?>
			<h2><?php _e('Fluency Admin Options', 'fluency-admin'); ?></h2>
			<form action="" method="post" id="fluency-options">
				<h3><?php _e('Login/Register Screen Customizations','fluency-admin'); ?></h3>
				<table class="form-table">
					<tbody>
						<tr>
							<th scope="row"><?php _e('Fluency Login Style', 'fluency-admin'); ?></th>
							<td><label><input name="fluency_login_style" id="fluency_login_style" value="true" type="checkbox" <?php if ( get_option('fluency_login_style') == 'true' ) echo ' checked="checked" '; ?> /> <?php _e('Style the WordPress login to match the rest of the Fluency Admin theme.', 'fluency-admin'); ?></label></td>
						</tr>
						<tr>
							<th scope="row"><label for="fluency_login_logo"><?php _e('Login screen custom logo', 'fluency-admin'); ?></label></th>
							<td>
								<input type="text" class="regular-text" value="<?php if ( get_option('fluency_login_logo') != '' ) echo get_option('fluency_login_logo'); ?>" id="fluency_login_logo" name="fluency_login_logo"/>
								<div class="description"><?php _e('Specify the full URL for your chosen image, for best results use an image that is <strong>250px wide</strong>, and <strong>50px high</strong>.', 'fluency-admin'); ?></div>
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="fluency_login_link"><?php _e('Login screen custom link', 'fluency-admin'); ?></label></th>
							<td>
								<input type="text" class="regular-text" value="<?php if ( get_option('fluency_login_link') != '' ) echo get_option('fluency_login_link'); ?>" id="fluency_login_link" name="fluency_login_link"/>
								<div class="description"><?php _e('Specify the URL that your custom logo will link through to.', 'fluency-admin'); ?></div>
							</td>
						</tr>
					</tbody>
				</table>
				<h3><?php _e('Logo Customizations','fluency-admin'); ?></h3>
				<table class="form-table">
					<tbody>
						<tr>
							<th scope="row"><label for="fluency_menu_logo"><?php _e('Custom logo (top of menu)', 'fluency-admin'); ?></label></th>
							<td>
								<input type="text" class="regular-text" value="<?php if ( get_option('fluency_menu_logo') != '' ) echo get_option('fluency_menu_logo'); ?>" id="fluency_menu_logo" name="fluency_menu_logo"/>
								<?php $c_width = ( get_option('fluency_menu_width') != '' ) ? get_option('fluency_menu_width') : '140'; ?>
								<div class="description"><?php vprintf( __('Specify the full URL for your chosen image, for best results use an image that is <strong>%spx wide</strong>, and <strong>50px high</strong>.', 'fluency-admin'), $c_width ); ?></div>
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="fluency_hidden_menu_logo"><?php _e('Custom logo (for collapsed menu)', 'fluency-admin'); ?></label></th>
							<td>
								<input type="text" class="regular-text" value="<?php if ( get_option('fluency_hidden_menu_logo') != '' ) echo get_option('fluency_hidden_menu_logo'); ?>" id="fluency_hidden_menu_logo" name="fluency_hidden_menu_logo"/>
								<div class="description"><?php _e("Specify the full URL for your chosen image, for best results use an image that is <strong>34px wide</strong>, and <strong>50px high</strong>.", 'fluency-admin'); ?></div>
							</td>
						</tr>
					</tbody>
				</table>
				<h3><?php _e('Menu Customizations','fluency-admin'); ?></h3>
				<table class="form-table">
					<tbody>
						<tr>
							<th scope="row"><label for="fluency_menu_width"><?php _e('Custom menu width', 'fluency-admin'); ?></label></th>
							<td>
								<input type="text" class="small-text" maxlength="3" value="<?php if ( get_option('fluency_menu_width') != '' ) echo get_option('fluency_menu_width'); ?>" id="fluency_menu_width" name="fluency_menu_width"/> px
								<div class="description"><?php _e('If you find that some menu items are wrapping across multiple lines you can increase the width of the menu.<br/>Default is 140px. <strong>Leave empty to reset.</strong>', 'fluency-admin'); ?></div>
							</td>
						</tr>
						<tr>
							<th scope="row"><?php _e('Fixed position menu', 'fluency-admin'); ?></th>
							<td><label><input name="fluency_menu_position" id="fluency_menu_position" value="true" type="checkbox" <?php if ( get_option('fluency_menu_position') != 'false' ) echo ' checked="checked" '; ?> /> <?php _e('Disable if you have lots of plugins that add menu items, or a small screen.', 'fluency-admin'); ?></label></td>
						</tr>
						<tr>
							<th scope="row"><?php _e('Menu item icons', 'fluency-admin'); ?></th>
							<td><label><input name="fluency_menu_icons" id="fluency_menu_icons" value="true" type="checkbox" <?php if ( get_option('fluency_menu_icons') != 'false' ) echo ' checked="checked" '; ?> /> <?php _e('Disable to hide icons from expanded menu.', 'fluency-admin'); ?></label></td>
						</tr>
						<tr>
							<th scope="row"><?php _e('Hover menus', 'fluency-admin'); ?></th>
							<td><label><input name="fluency_click_menus" id="fluency_click_menus" value="true" type="checkbox" <?php if ( get_option('fluency_click_menus') != 'true' ) echo ' checked="checked" '; ?> /> <?php _e('Disable to switch back to the click-to-open style menus while retaining the Fluency look.', 'fluency-admin'); ?></label></td>
						</tr>
						<tr>
							<th scope="row"><?php _e('Menu Hot Keys', 'fluency-admin'); ?></th>
							<td><label><input name="fluency_hot_keys" id="fluency_hot_keys" value="true" type="checkbox" <?php if ( get_option('fluency_hot_keys') != 'false' ) echo ' checked="checked" '; ?> /> <?php _e('Disable if you encounter a conflict with another plugin, or if you just need them.', 'fluency-admin'); ?></label></td>
						</tr>
						<tr>
							<th scope="row"><?php _e('iPad \'friendly\' menus', 'fluency-admin'); ?></th>
							<td><?php _e('Tada! No setting needed for this, just visit your wp-admin on your iPad and you\'ll get the \'finger-friendly\' menus instantly.<br/>Note: Hover menus are auto-disabled on the iPad... because you can\'t, um, hover.', 'fluency-admin'); ?></td>
						</tr>
					</tbody>
				</table>
				<h3><?php _e('Admin Menu Configurations','fluency-admin'); ?></h3>
				<table class="form-table">
					<tbody>
						<?php
						global $show_admin_bar;
						?>
						<tr>
							<th scope="row"><?php _e('WP Admin Bar', 'fluency-admin'); ?></th>
							<td>
								<div class="description"><?php _e('The WP Admin Bar can be enabled/disabled (for when viewing your blog and/or accessing the admin area) via your ', 'fluency-admin'); ?><a href="profile.php" title="<?php _e('profile page', 'fluency-admin'); ?>"><?php _e('profile page', 'fluency-admin'); ?></a>.</div>
							</td>
						</tr>
						<tr>
							<th scope="row"><?php _e('Admin bar drop-down menus', 'fluency-admin'); ?></th>
							<td>
								<label><input name="fluency_admin_drop_down" id="fluency_admin_drop_down_off" value="0" type="radio" <?php if ( $this->fluency_admin_drop_down == '0' ) echo ' checked="checked" '; ?> /> <?php _e('Disable the Admin drop-down menus in the WP Admin Bar (Default).', 'fluency-admin'); ?></label><br/> <!-- if ( $fluency_admin_bar == '0' ) echo ' disabled="true" '; -->
								<label><input name="fluency_admin_drop_down" id="fluency_admin_drop_down_single" value="1" type="radio" <?php if ( $this->fluency_admin_drop_down == '1' ) echo ' checked="checked" '; ?> /> <?php _e('Enable single drop-down menu with access to all wp-admin areas.', 'fluency-admin'); ?></label><br/> <!-- if ( $fluency_admin_bar == '0' ) echo ' disabled="true" '; -->
								<label><input name="fluency_admin_drop_down" id="fluency_admin_drop_down_multiple" value="2" type="radio" <?php if ( $this->fluency_admin_drop_down == '2' ) echo ' checked="checked" '; ?> /> <?php _e('Enable multiple drop-down menus, one for each main wp-admin area.', 'fluency-admin'); ?></label> <!--  if ( $fluency_admin_bar == '0' ) echo ' disabled="true" '; -->
								<div class="description"><?php _e("Drop-down menus won't be visible if you've disabled the WP Admin Bar completely.", 'fluency-admin'); ?></div>
							</td>
						</tr>
						<!-- this option is not always disabling like it should when the options page loads -->
						<?php if ( $show_admin_bar ) { ?>
						<tr>
							<th scope="row"><?php _e('Hide Admin Menu', 'fluency-admin'); ?></th>
							<td>
								<label><input name="fluency_hide_menu" id="fluency_hide_menu_off" value="0" type="radio" <?php if ( $this->fluency_hide_menu == '0' ) echo ' checked="checked" '; if ( $fluency_admin_drop_down == '0') echo ' disabled="true" '; ?> /> <?php _e('Show the admin menu. (Default)', 'fluency-admin'); ?></label><br/>
								<label><input name="fluency_hide_menu" id="fluency_hide_menu_on" value="1" type="radio" <?php if ( $this->fluency_hide_menu == '1' ) echo ' checked="checked" '; if ( $fluency_admin_drop_down == '0') echo ' disabled="true" '; ?> /> <?php _e('Hide the admin menu.', 'fluency-admin'); ?></label><br/>
								<div class="description"><?php _e("This will hide the 'standard' admin menu (the one on the left), can only be used if you've enabled one of the Admin Bar drop down options and have not disabled the Admin Bar completely.", 'fluency-admin'); ?></div>
							</td>
						</tr>
						<?php } else { ?>
						<tr>
							<th>Hide Admin Menu</th>
							<td>
								<label><input name="fluency_hide_menu" id="fluency_hide_menu_off" value="0" type="hidden" /></label>
								<div class="description"><?php _e("When you have the WP Admin Bar plus one of the above drop-down menu options enabled you can choose to hide the 'standard' admin menu on the left.", 'fluency-admin'); ?><br/><?php _e('You can turn the Admin Bar on/off on your ', 'fluency-admin'); ?><a href="profile.php" title="<?php _e('profile page', 'fluency-admin'); ?>"><?php _e('profile page', 'fluency-admin'); ?></a>.</div>
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
				<h3><?php _e('Color Customizations','fluency-admin'); ?></h3>
				<table class="form-table">
					<tbody>
						<tr>
							<th scope="row"><label for="fluency_custom_color"><?php _e('Menu Background Color', 'fluency-admin'); ?></label></th>
							<td>
								<div id="fluency_color_sample" style="float:left;width:23px;height:23px;margin:1px 3px 0 0;-moz-border-radius:4px;-webkit-border-radius:4px;border:1px solid rgba(0,0,0,0.1);background:#222;">&nbsp;</div><input type="text" class="regular-text" style="width:70px;" maxlength="7" value="#<?php if ( get_option('fluency_custom_color') != '' ) echo get_option('fluency_custom_color'); ?>" id="fluency_custom_color" name="fluency_custom_color"/> <div id="fluency_colorPickerDiv" style="z-index: 100; background:#eee; border:1px solid #ccc; position:absolute; display:none;"></div><!-- <a class="hide-if-no-js" href="#" id="fluency_pickcolor"><?php _e('Select a Color','fluency-admin'); ?></a>--> <a class="hide-if-no-js" href="#" id="fluency_resetcolor"><?php _e('Reset','fluency-admin'); ?></a>
								<div class="description"><?php _e('Pick a color to use as the background color for the admin menu. <strong>Darkish colours work best.</strong><br/>The rest of the admin area will use the \'grey\' color scheme when a custom menu color is selected, regardless of a user\'s profile setting.', 'fluency-admin'); ?></div>
							</td>
						</tr>
					</tbody>
				</table>
				<p class="submit">
					<?php wp_nonce_field('fluency-admin','_wp_fluency_nonce'); ?>
					<?php submit_button( __('Save Changes', 'fluency-admin'), 'button-primary', 'submit', false ); ?>
				</p>
			</form>
		</div>
	<?php
	}

	/*
	 * Add Fluency Admin Options Page to Settings menu
	 */
	public function wp_fluency_options_menu() {
		if(function_exists('add_submenu_page')) {
			add_options_page(__('Fluency Options', 'fluency-admin'), __('Fluency Options', 'fluency-admin'), 'manage_options', 'fluency-options', array($this,'wp_fluency_options_page'));
		}
	}

}

new WP_Fluency_Admin;

?>