<?php
/*
Template Name: Site List
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">

	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

	<title><?php bp_page_title() ?></title>

	<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats -->

	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
	
	<?php wp_head(); ?>
	
</head>

<body <?php body_class() ?>>

<div id="main">

	<div id="landing-page">

		<div id="about">
			<h1>PFOND</h1>
			<p>Developed by the <a href="http://www.cmmt.ubc.ca/research/investigators/wasserman/lab" target="_blank">Wasserman Laboratory</a> at UBC, the Portal for Families Overcoming Neurodevelopmental Disorders (PFOND) is a web-based service to promote the sharing of information about research, treatment and resources.</p>
		</div>

		<div id="sitelist">
		
			<?php
			// move the SQL queries off the page??
			$blogs = $wpdb->get_results("
				SELECT *
				FROM wp_blogs
				WHERE blog_id != 1 && blog_id != 2
				ORDER BY blog_id ASC
				", OBJECT);
			
			$num_blogs = count($blogs);
			?>
		
			<p>There are currently <span class="larger"><?php echo $num_blogs; ?></span> site(s) on the PFOND network:</p>
			
			<ul>
			<?php
			// list all subsites
			foreach ($blogs as $blog) {
				$blogname = $wpdb->get_row("
					SELECT *
					FROM wp_" . $blog->blog_id . "_options
					WHERE option_name = 'blogname'
					", OBJECT);
				echo '<li><a href="http://' . $blog->domain . $blog->path . '">' . $blogname->option_value . '</a></li>';
			}
			?>
			</ul>
		</div>
	
	</div>
		
	<?php wp_footer(); ?>
		
</div>

</body>

</html>
		