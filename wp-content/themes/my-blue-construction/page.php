<?php get_header(); ?>
	<div id="container">
		<?php
			if(my_sidebar_position() == 'left'){
		?>	
				<div id="sidebar">
					<?php get_sidebar(); ?>
				</div>
		<?php		
			}
		?>
		<div id="content">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
					<h2 class="title"><?php the_title(); ?></h2> 
					<?php if(function_exists('the_views')) { the_views(); } ?>
					<div class="entry">	
						<?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>
						<?php wp_link_pages('<p><strong>Pages:</strong> ', '</p>', 'number'); ?>
					</div>
				</div>
				<br /><br />
				<?php comments_template(); ?>
				
			<?php endwhile; endif; ?>
		</div>
		<?php
			if(my_sidebar_position() == 'right'){
		?>	
				<div id="sidebar">
					<?php get_sidebar(); ?>
				</div>
		<?php		
			}
		?>
  </div><!--/content -->
<?php get_footer(); ?>