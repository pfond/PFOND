<?php

/** Sets up the WordPress Environment. */
require( '../../../wp-load.php' );

add_action( 'wp_head', 'signuppageheaders' ) ;

require( '../../../wp-blog-header.php' );

if ( is_array( get_site_option( 'illegal_names' )) && isset( $_GET[ 'new' ] ) && in_array( $_GET[ 'new' ], get_site_option( 'illegal_names' ) ) == true ) {
	wp_redirect( network_home_url() );
	die();
}

function do_signup_header() {
	do_action("signup_header");
}
add_action( 'wp_head', 'do_signup_header' );

function signuppageheaders() {
	echo "<meta name='robots' content='noindex,nofollow' />\n";
}

if ( !is_multisite() ) {
	wp_redirect( site_url('wp-login.php?action=register') );
	die();
}

if ( !is_main_site() ) {
	wp_redirect( network_home_url( 'wp-signup.php' ) );
	die();
}

$current_user = wp_get_current_user();

// if not logged in or not admin, die with message
if (!is_user_logged_in() || !in_array('administrator', $current_user->roles)) {
	wp_die( __('Sorry, you are not allowed to access this part of the site.<br /><br /><a href="' . get_site_url(1) . '">Return to PFOND home.</a>') );
}

// Fix for page title
$wp_query->is_404 = false;

//get_header();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">

	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

	<title><?php bloginfo( 'name' ); ?> | Register a new site</title>

	<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats -->

	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
	
	<?php wp_head(); ?>
	
</head>

<body <?php body_class() ?>>

<div id="main">
<div id="signup-page">
<?php do_action( 'before_signup_form' ); ?>
<div class="mu_register nosidebar">
<?php
function show_blog_form($blogname = '', $blog_title = '', $errors = '') {
	global $current_site;
	
	// Blog name
	if ( !is_subdomain_install() )
		echo '<label for="blogname"><strong>' . __('Site Name:') . '</strong></label>';
	else
		echo '<label for="blogname"><strong>' . __('Site Domain:') . '</strong></label>';

	if ( $errmsg = $errors->get_error_message('blogname') ) { ?>
		<p class="error"><?php echo $errmsg ?></p>
	<?php }

	if ( !is_subdomain_install() )
		echo ' <span class="prefix_address">' . $current_site->domain . $current_site->path . '</span><input name="blogname" type="text" id="blogname" value="'. esc_attr($blogname) .'" maxlength="60" /><br />';
	else
		echo ' <input name="blogname" type="text" id="blogname" value="'.esc_attr($blogname).'" maxlength="60" /><span class="suffix_address">.' . ( $site_domain = preg_replace( '|^www\.|', '', $current_site->domain ) ) . '</span><br />';

	if ( !is_user_logged_in() ) {
		if ( !is_subdomain_install() )
			$site = $current_site->domain . $current_site->path . __( 'sitename' );
		else
			$site = __( 'domain' ) . '.' . $site_domain . $current_site->path;
		echo '<p>(<strong>' . sprintf( __('Your address will be %s.'), $site ) . '</strong>) ' . __( 'Must be at least 4 characters, letters and numbers only. It cannot be changed, so choose carefully!' ) . '</p>';
	}

	// Blog Title
	?>
	<label for="blog_title"><strong><?php _e('Site Title:') ?></strong></label>
	<?php if ( $errmsg = $errors->get_error_message('blog_title') ) { ?>
		<p class="error"><?php echo $errmsg ?></p>
	<?php }
	echo '<input name="blog_title" type="text" id="blog_title" value="'.esc_attr($blog_title).'" />';
	?>

	<!--
	<div id="privacy">
        <p>
            <label for="blog_public_on"><?php _e('Privacy:') ?></label>
            <?php _e('Allow my site to appear in search engines like Google, Technorati, and in public listings around this network.'); ?>
            <br style="clear:both" />
            <label class="checkbox" for="blog_public_on">
                <input type="radio" id="blog_public_on" name="blog_public" value="1" />
                <strong><?php _e( 'Yes' ); ?></strong>
            </label>
            <label class="checkbox" for="blog_public_off">
                <input type="radio" id="blog_public_off" name="blog_public" value="0" checked="checked" />
                <strong><?php _e( 'No' ); ?></strong>
            </label>
        </p>
	</div>
	-->

	<?php
	do_action('signup_blogform', $errors);
}

function validate_blog_form() {
	$user = '';
	if ( is_user_logged_in() )
		$user = wp_get_current_user();

	return wpmu_validate_blog_signup($_POST['blogname'], $_POST['blog_title'], $user);
}

function signup_another_blog($blogname = '', $blog_title = '', $errors = '') {
	global $current_site;
	$current_user = wp_get_current_user();

	if ( ! is_wp_error($errors) ) {
		$errors = new WP_Error();
	}

	// allow definition of default variables
	$filtered_results = apply_filters('signup_another_blog_init', array('blogname' => $blogname, 'blog_title' => $blog_title, 'errors' => $errors ));
	$blogname = $filtered_results['blogname'];
	$blog_title = $filtered_results['blog_title'];
	$errors = $filtered_results['errors'];

	echo '<h1>' . __( 'Register a new site' ) . '</h1>';

	if ( $errors->get_error_code() ) {
		echo '<p>' . __( 'There was a problem, please correct the form below and try again.' ) . '</p>';
	}
	?>
	<p><?php printf( __( 'Hi, %s! Please fill out the form below to register a new site on the <strong>%s</strong> network.' ), $current_user->display_name, $current_site->site_name ) ?></p>

	<?php
	$blogs = get_blogs_of_user($current_user->ID);
	if ( !empty($blogs) ) { ?>
			<p><?php _e( 'You are already a member of the following sites:' ) ?></p>
			<ul class="bulleted">
				<?php foreach ( $blogs as $blog ) {
					$home_url = get_home_url( $blog->userblog_id );
					echo '<li><a href="' . esc_url( $home_url ) . '">' . $home_url . '</a></li>';
				} ?>
			</ul>
	<?php } ?>
	
	<form id="setupform" method="post" action="wp-signup.php">
		<input type="hidden" name="stage" value="gimmeanotherblog" />
		<?php do_action( "signup_hidden_fields" ); ?>
		<?php show_blog_form($blogname, $blog_title, $errors); ?>
		<p class="submit"><input type="submit" name="submit" class="submit" value="<?php esc_attr_e( 'Create Site' ) ?>" /></p>
	</form>
	<?php
}

function validate_another_blog_signup() {
	global $wpdb, $blogname, $blog_title, $errors, $domain, $path;
	$current_user = wp_get_current_user();
	if ( !is_user_logged_in() )
		die();

	$result = validate_blog_form();
	extract($result);

	if ( $errors->get_error_code() ) {
		signup_another_blog($blogname, $blog_title, $errors);
		return false;
	}

	$public = 0; // hard-coded private (int) $_POST['blog_public'];
	$meta = apply_filters( 'signup_create_blog_meta', array( 'lang_id' => 1, 'public' => $public ) ); // deprecated
	$meta = apply_filters( 'add_signup_meta', $meta );

	wpmu_create_blog( $domain, $path, $blog_title, $current_user->id, $meta, $wpdb->siteid );
	confirm_another_blog_signup($domain, $path, $blog_title, $current_user->user_login, $current_user->user_email, $meta);
	return true;
}

function confirm_another_blog_signup($domain, $path, $blog_title, $user_name, $user_email = '', $meta = '') {
	?>
	<h2><?php printf( __( 'The site %s is yours.' ), "<a href='http://{$domain}{$path}'>{$blog_title}</a>" ) ?></h2>
	<p>
		<?php printf( __( '<a href="http://%1$s">http://%2$s</a> is your new site.  <a href="%3$s">Log in</a> as &#8220;%4$s&#8221; using your existing password.' ), $domain.$path, $domain.$path, "http://" . $domain.$path . "wp-login.php", $user_name ) ?>
	</p>
	<?php
	do_action( 'signup_finished' );
}

function signup_blog($user_name = '', $user_email = '', $blogname = '', $blog_title = '', $errors = '') {
	if ( !is_wp_error($errors) )
		$errors = new WP_Error();

	// allow definition of default variables
	$filtered_results = apply_filters('signup_blog_init', array('user_name' => $user_name, 'user_email' => $user_email, 'blogname' => $blogname, 'blog_title' => $blog_title, 'errors' => $errors ));
	$user_name = $filtered_results['user_name'];
	$user_email = $filtered_results['user_email'];
	$blogname = $filtered_results['blogname'];
	$blog_title = $filtered_results['blog_title'];
	$errors = $filtered_results['errors'];

	if ( empty($blogname) )
		$blogname = $user_name;
	?>
	<form id="setupform" method="post" action="wp-signup.php">
		<input type="hidden" name="stage" value="validate-blog-signup" />
		<input type="hidden" name="user_name" value="<?php echo esc_attr($user_name) ?>" />
		<input type="hidden" name="user_email" value="<?php echo esc_attr($user_email) ?>" />
		<?php do_action( "signup_hidden_fields" ); ?>
		<?php show_blog_form($blogname, $blog_title, $errors); ?>
		<p class="submit"><input type="submit" name="submit" class="submit" value="<?php esc_attr_e('Signup') ?>" /></p>
	</form>
	<?php
}

function validate_blog_signup() {
	// Re-validate user info.
	$result = wpmu_validate_user_signup($_POST['user_name'], $_POST['user_email']);
	extract($result);

	if ( $errors->get_error_code() ) {
		signup_user($user_name, $user_email, $errors);
		return false;
	}

	$result = wpmu_validate_blog_signup($_POST['blogname'], $_POST['blog_title']);
	extract($result);

	if ( $errors->get_error_code() ) {
		signup_blog($user_name, $user_email, $blogname, $blog_title, $errors);
		return false;
	}

	$public = 0; // hard-coded private (int) $_POST['blog_public'];
	$meta = array ('lang_id' => 1, 'public' => $public);
	$meta = apply_filters( "add_signup_meta", $meta );

	wpmu_signup_blog($domain, $path, $blog_title, $user_name, $user_email, $meta);
	confirm_blog_signup($domain, $path, $blog_title, $user_name, $user_email, $meta);
	return true;
}

function confirm_blog_signup($domain, $path, $blog_title, $user_name = '', $user_email = '', $meta) {
	?>
	<h2><?php printf( __( 'Congratulations! Your new site, %s, is almost ready.' ), "<a href='http://{$domain}{$path}'>{$blog_title}</a>" ) ?></h2>

	<p><?php _e( 'But, before you can start using your site, <strong>you must activate it</strong>.' ) ?></p>
	<p><?php printf( __( 'Check your inbox at <strong>%s</strong> and click the link given.' ),  $user_email) ?></p>
	<p><?php _e( 'If you do not activate your site within two days, you will have to sign up again.' ); ?></p>
	<h2><?php _e( 'Still waiting for your email?' ); ?></h2>
	<p>
		<?php _e( 'If you haven&#8217;t received your email yet, there are a number of things you can do:' ) ?>
		<ul id="noemail-tips">
			<li><p><strong><?php _e( 'Wait a little longer. Sometimes delivery of email can be delayed by processes outside of our control.' ) ?></strong></p></li>
			<li><p><?php _e( 'Check the junk or spam folder of your email client. Sometime emails wind up there by mistake.' ) ?></p></li>
			<li><?php printf( __( 'Have you entered your email correctly?  You have entered %s, if it&#8217;s incorrect, you will not receive your email.' ), $user_email ) ?></li>
		</ul>
	</p>
	<?php
	do_action( 'signup_finished' );
}

// Main
$active_signup = get_site_option( 'registration' );
if ( !$active_signup )
	$active_signup = 'all';

$active_signup = apply_filters( 'wpmu_active_signup', $active_signup ); // return "all", "none", "blog" or "user"

// Make the signup type translatable.
$i18n_signup['all'] = _x('all', 'Multisite active signup type');
$i18n_signup['none'] = _x('none', 'Multisite active signup type');
$i18n_signup['blog'] = _x('blog', 'Multisite active signup type');
$i18n_signup['user'] = _x('user', 'Multisite active signup type');

echo '<p><a href="javascript:history.back(-1)">&larr; Go back</a> | <a href="' . network_home_url() . '">PFOND Home</a></p>';

if ( is_super_admin() )
	echo '<div class="mu_alert">' . sprintf( __( 'Greetings Site Administrator! You are currently allowing &#8220;%s&#8221; registrations. To change or disable registration go to your <a href="%s">Options page</a>.' ), $i18n_signup[$active_signup], esc_url( network_admin_url( 'settings.php' ) ) ) . '</div>';

$newblogname = isset($_GET['new']) ? strtolower(preg_replace('/^-|-$|[^-a-zA-Z0-9]/', '', $_GET['new'])) : null;

if ( $active_signup != "all" && $active_signup != "blog" ) {
	_e( 'Site registration has been disabled. Contact your Site Administrator(s) for details.' );
} else {
	$stage = isset( $_POST['stage'] ) ?  $_POST['stage'] : 'default';
	switch ( $stage ) {
		case 'validate-blog-signup':
			if ( $active_signup == 'all' || $active_signup == 'blog' )
				validate_blog_signup();
			else
				_e( 'Site registration has been disabled.' );
			break;
		case 'gimmeanotherblog':
			validate_another_blog_signup();
			break;
		case 'default':
		default :
			$user_email = isset( $_POST[ 'user_email' ] ) ? $_POST[ 'user_email' ] : '';
			do_action( "preprocess_signup_form" ); // populate the form from invites, elsewhere?
			
			if ( is_user_logged_in() && ( $active_signup == 'all' || $active_signup == 'blog' ) )
				signup_another_blog($newblogname);

			if ( $newblogname ) {
				$newblog = get_blogaddress_by_name( $newblogname );

				if ( $active_signup == 'blog' || $active_signup == 'all' )
					printf( __( '<p><em>The site you were looking for, <strong>%s</strong> does not exist, but you can create it now!</em></p>' ), $newblog );
				else
					printf( __( '<p><em>The site you were looking for, <strong>%s</strong>, does not exist.</em></p>' ), $newblog );
			}
			break;
	}
}
?>
</div>
</div>
<?php do_action( 'after_signup_form' ); ?>

<?php wp_footer(); ?>
		
</div>
</div>

</body>

</html>
