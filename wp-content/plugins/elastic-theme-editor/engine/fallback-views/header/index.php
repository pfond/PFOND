<div id="masthead">

	<div id="branding">
		<h1 id="blog-title"><span><a href="<?php bloginfo( 'url' ) ?>/" title="<?php bloginfo( 'name' ) ?>" rel="home"><?php bloginfo( 'name' ) ?></a></span></h1>
<?php if ( is_home() || is_front_page() ) { ?>
    		<h2 id="blog-description"><?php bloginfo( 'description' ) ?></h2>
<?php } else { ?>	
    		<div id="blog-description"><?php bloginfo( 'description' ) ?></div>
<?php } ?>
	</div><!-- #branding -->
</div><!-- #masthead -->