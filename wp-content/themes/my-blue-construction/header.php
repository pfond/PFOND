<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> &raquo; Blog Archive <?php } ?> <?php wp_title(); ?></title>
<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats -->
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="all" />
<link href='http://fonts.googleapis.com/css?family=Cuprum&subset=latin' rel='stylesheet' type='text/css'>
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php if ( is_singular() ) wp_enqueue_script( "comment-reply" ); ?>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<div id="header">	
						
		<div id="social">
			
			<!-- social -->
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
		
		<!-- blog info section -->
		<div id="blog-info">
			<h1><a href="<?php echo home_url(); ?>/"><?php bloginfo('name'); ?></a></h1>
			<p class="description"><?php bloginfo('description'); ?></p>
		</div>

		
		<!-- menu section -->		
		<div class="menu" id="my-header-menu">
			<?php mythemes_menu(); ?>
		</div>
	</div>