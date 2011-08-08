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
			<p class="search-result"><b>Search Results</b></p>
			<?php if (have_posts()) : ?>
				<?php while (have_posts()) : the_post(); ?>
					<div <?php post_class();?> id="post-<?php the_ID(); ?>">
						
							<?php 
								if(strlen($post -> post_title) == 0){ 
							?> 
									<p><a href="<?php the_permalink() ?>">Read more about this..</a></p> 
							<?php 
								}else{
							?>
									<h3 class="title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h3>
							<?php
								}
							?>	
							
							<?php the_excerpt(); ?>
					</div>
				<?php endwhile; ?>

				<div class="navigation">
					<span class="previous-posts"><?php next_posts_link('&laquo; Previous') ?></span> <span class="next-posts"><?php previous_posts_link('Next &raquo;') ?></span>
				</div>

			<?php else : ?>
				<h4>Sorry, nothing found.</h4>
			<?php endif; ?>
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
	</div>
<?php get_footer(); ?>