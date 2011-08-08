<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">

	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

	<title><?php bp_page_title() ?></title>

	<?php do_action( 'bp_head' ) ?>

	<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats -->

	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
	
	<link rel="stylesheet" type="text/css" href="<?php bloginfo("stylesheet_directory") ?>/_includes/libraries/fancybox/jquery.fancybox-1.3.4.css" media="screen" />

	<?php if ( function_exists( 'bp_sitewide_activity_feed_link' ) ) : ?>
		<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> | <?php _e('Site Wide Activity RSS Feed', 'buddypress' ) ?>" href="<?php bp_sitewide_activity_feed_link() ?>" />
	<?php endif; ?>

	<?php if ( function_exists( 'bp_member_activity_feed_link' ) && bp_is_member() ) : ?>
		<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> | <?php bp_displayed_user_fullname() ?> | <?php _e( 'Activity RSS Feed', 'buddypress' ) ?>" href="<?php bp_member_activity_feed_link() ?>" />
	<?php endif; ?>

	<?php if ( function_exists( 'bp_group_activity_feed_link' ) && bp_is_group() ) : ?>
		<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> | <?php bp_current_group_name() ?> | <?php _e( 'Group Activity RSS Feed', 'buddypress' ) ?>" href="<?php bp_group_activity_feed_link() ?>" />
	<?php endif; ?>

	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> <?php _e( 'Blog Posts RSS Feed', 'buddypress' ) ?>" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> <?php _e( 'Blog Posts Atom Feed', 'buddypress' ) ?>" href="<?php bloginfo('atom_url'); ?>" />

	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
		
	<?php wp_head(); ?>
	
	<script type="text/javascript" src="<?php bloginfo("stylesheet_directory") ?>/_includes/libraries/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	
	<script type="text/javascript" src="<?php bloginfo("stylesheet_directory") ?>/_includes/scripts/login.js"></script>

</head>

<body <?php body_class() ?> id="bp-default">

<div id="main">
	
	<?php do_action( 'bp_before_header' ) ?>
	
	<!-- login form -->
	<div class="mask">
		<div id="login-window">
			<div class="title">Please log in.</div>
			
			<form id="login-form" action="<?php echo site_url('/wp-login.php', 'login_post') ?>" method="post">
				<p class="user_login">
					<label for="user_login">Username</label>
					<input type="text" id="user_login" name="log" value="<?php echo esc_attr(stripslashes($user_login)); ?>" tabindex="1" />
				</p>
				
				<p class="user_pass">
					<label for="user_pass">Password</label>
					<input type="password" id="user_pass" name="pwd" value="" tabindex="2" />
				</p>

				<p class="rememberme">
					<input type="checkbox" id="rememberme" name="rememberme" value="forever" tabindex="3" />
					<label for="rememberme" class="remember">Remember me on this computer</label>
				</p>
				
				<?php do_action( 'bp_sidebar_login_form' ) ?>
				<input type="submit" name="wp-submit" id="wp-submit" value="Log In" tabindex="4" />
				<input type="hidden" name="testcookie" value="1" />
				
				<!--<input type="button" id="close" value="Cancel" />-->
			</form>
			
			<p><a href="<?php echo wp_lostpassword_url(); ?>">Lost your password?</a></p>
			
			<p><a href="<?php echo site_url('/wp-login.php?action=register') ?>" >Create an account</a></p>
		</div>
	</div>

	<div id="header-wrap">
		<div id="header">
			<div id="sitetitle"><a href="<?php echo site_url() ?>"/><?php
				$site_title = get_option('pfond_site_title');
				
				if (!$site_title) {
					$site_title = get_bloginfo('name');
				}
				
				$title_parts = split(' ', $site_title);
				$alt = false;
				foreach ($title_parts as $part) {
					if ($alt) {
						echo '<span class="blue">' . strtolower($part) . '</span>';
					} else {
						echo strtolower($part);
					}
					$alt = !$alt;
				}
			?><a></div>
			
			<div id="home-link"><a href="<?php echo get_site_url(1) ?>"/><img src="<?php bloginfo('stylesheet_directory') ?>/_includes/images/home.png" width="18px" height="18px" style="vertical-align: text-bottom"/> <?php echo get_blog_details(1)->blogname ?> Home</a><?php
			$current_user = wp_get_current_user();
			if (in_array('administrator', $current_user->roles) ||
				in_array('editor', $current_user->roles)) : ?>
				| <img src="<?php bloginfo('stylesheet_directory') ?>/_includes/images/settings.png" width="18px" height="18px" style="vertical-align: text-bottom"/> <a href="<?php echo site_url() ?>/wp-admin/">Admin Panel</a>
			<?php endif; ?></div>
			
			<div id="search-bar">
				<div class="padder">

				<form action="<?php echo bp_search_form_action() ?>" method="post" id="search-form">
					<input type="text" id="mssearch" name="mssearch" value="" />
					<input type="submit" id="search-submit" name="search-submit" value="<?php //_e( 'Search', 'buddypress' ) ?>" />
					<?php wp_nonce_field( 'bp_search_form' ) ?>
				</form><!-- #search-form -->

				<?php do_action( 'bp_search_login_bar' ) ?>

				</div>
			</div>

			<?php do_action( 'bp_header' ) ?>
			
			<div class="clear"></div>
		</div>
	</div>
	
	<div id="access-wrap">
		<div id="access">
		
			<div class="menu">
				<?php /* Our navigation menu.  If one isn't filled out, wp_nav_menu falls back to wp_page_menu.  The menu assiged to the primary position is the one used.  If none is assigned, the menu with the lowest ID is used. */
				$menu = wp_nav_menu( array( /*'menu' => 'default',*/ 'container' => false, 'echo' => false ) );
				
				$site_url = str_replace('http://', '', get_site_url(1));
				$path_parts = split('/', get_blog_details($GLOBALS['blog_id'])->path);
				$blog_slug = $path_parts[count($path_parts) - 2];
				
				$menu = str_replace(DISEASE_NAME_PLACEHOLDER, get_option('pfond_disease_name'), $menu);
				$menu = str_replace(DISEASE_GROUP_URL_PLACEHOLDER, $site_url . '/' . BP_GROUPS_SLUG . '/' . $blog_slug . '/forum/', $menu);
				$menu = str_replace(MEMBERS_URL_PLACEHOLDER, $site_url . '/members/', $menu);
				$menu = str_replace(SITE_FEEDBACK_URL_PLACEHOLDER, $site_url . '/' . BP_GROUPS_SLUG . '/site-feedback/forum/', $menu);
				
				echo $menu;
				?>
			</div>
			
			<div id="login-status">			
				<?php if ( is_user_logged_in() ) : ?>
					
					<p>
					Welcome, <?php echo bp_core_get_userlink( bp_loggedin_user_id() ); ?>&nbsp;
					<a class="button" href="<?php echo wp_logout_url( site_url() ) ?>"><?php _e( 'Log Out', 'buddypress' ) ?></a>
					</p>
					
				<?php else : ?>
				
					Have an account? <?php pfond_get_login_link(); ?>
					
				<?php endif; ?>
			</div>
			
		</div>
	</div>

	<?php do_action( 'bp_after_header' ) ?>
	<?php do_action( 'bp_before_container' ) ?>
	
	<div id="container">
	