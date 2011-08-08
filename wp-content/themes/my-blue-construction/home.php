<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> &raquo; Blog Archive <?php } ?> <?php wp_title(); ?></title>
<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats -->
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="all" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

	<div id="home-header"><!-- blank --></div>
	<div id="home-page"><!-- blank --></div>
	<div id="home-main"><!-- blank --></div>
	<div id="home-content">

		<div id="home-social">	
			
			<?php 
				if(strlen(get_option('myfs_facebook')) > 0){ 
					echo '<a href="http://facebook.com/'; my_social_facebook_out(); echo '" class ="facebook" title="facebook account : '; my_social_facebook_out(); echo '"><img src="resource/images/facebook-hover.png" width="1" height="1" alt="" /></a>';
				}
				
				if(strlen(get_option('myfs_twitter')) > 0){ 
					echo '<a href="http://twitter.com/'; my_social_twitter_out(); echo '" class ="twitter" title="twitter account : '; my_social_twitter_out(); echo '"><img src="resource/images/twitter-hover.png" width="1" height="1" alt="" /></a>';
				}
			?>
			
			<a href="<?php bloginfo('rss2_url'); ?>" class="rss" title="RSS Feed"><img src="resource/images/rss-hover.png" width="1" height="1" alt="" /></a>
			
		</div>
		
		<?php
			if(my_is_active_mail_feed()) {
		?>
			<div id="home-subscribe">
					<form action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=<?php my_mail_feed_out(); ?>', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true">
					<input type="text" class="text" name="email" value="your email for subscription" onfocus="if(this.value=='your email for subscription') { this.value = '' }" onblur="if(this.value=='') { this.value = 'your email for subscription' }">
					<input type="hidden" value="bloqro" name="uri">
					<input type="hidden" name="loc" value="en_US">
					<input type="submit" class="submit" value="">
				</form>
			</div>
		<?php
			}
		?>	
		<div id="home-blog-info">
			<h1 class="home"><?php bloginfo('name'); ?></h1>
			<h3 class="home"><?php if(strlen(get_option('myfs_title')) > 0){ my_home_title_out(); }else{ echo _TITLE_; }?></h3>
			<p class="home-description"><?php if(strlen(get_option('myfs_content')) > 0){ my_home_content_out(); }else{ echo _CONTENT_; }?></p>
		</div>

							
	</div>	
	<div id="home-footer">
		<p class="home-footer"> Powered by <a class="home" href="http://wordpress.org"  target="_blank">WordPress</a>. &copy; designed by <a  class="home" href="http://mythem.es" title="mythem.es" target="_blank">mythem.es</a></p>
		<?php wp_footer(); ?>
	</div>

</body>
</html>
