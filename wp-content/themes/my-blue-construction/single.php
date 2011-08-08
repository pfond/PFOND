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
			<?php if (have_posts()) : ?>
				<?php while (have_posts()) : the_post(); ?>
					<?php the_post_thumbnail('thumbnail'); ?>
					<!-- start post -->
					<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
					
						<!-- title of post -->
						<?php 
							if(strlen($post -> post_title) > 0){ 
						?>  
							<h2 class="title">
								<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a>
							</h2>
						<?php 
							}
						?>
						
						<!-- header-->
						<div class="meta">
							<span class="meta-info meta-text meta-link">Posted on <?php the_time('jS F Y') ?> in <?php the_category(', ') ?></span>
						</div>	
						
						<!-- content  -->								
						<div class="entry">									
							<?php if(strlen($post -> post_title) == 0){ ?> <p><a href="<?php the_permalink() ?>">Read more about this..</a></p> <?php }?>
							<?php the_content('Click here to read more.. &raquo;'); ?>
							<?php wp_link_pages( array( 'before' => '<p><div class="navigation"><div id="previous-posts">' . __( 'Pages:', '' ), 'after' => '</div></div></p>' ) ); ?>
						</div>
						
						<!-- footer-->
						<div class="meta meta-bottom">
							<span class="meta-utility meta-text meta-link">comments: 
								<?php if ('open' == $post->comment_status) : ?> 
									<?php comments_popup_link(' 0 &#187;', ' 1 &#187;', ' % &#187;'); ?>
								<?php else : // comments are closed ?>
									Closed
								<?php endif; ?>
							</span>	
							
							<span class="meta-utility meta-text meta-link">
									<?php edit_post_link('Edit', '', ''); ?>
							</span>
							
							
							<span class="meta-tags meta-text meta-link">	
								<?php the_tags('tags: ',', ',''); ?>
							</span>	
						</div>
					</div><!-- end post -->
					
					
					<!-- navigation -->
					<div class="navigation">
						<span class="previous-posts"><?php previous_post_link( '%link', '&laquo; %title' ); ?></span>
						<span class="next-posts"><?php next_post_link( '%link', '%title &raquo;' ); ?></span>
					</div> <!-- end navigation -->

					<?php comments_template(); ?>
				
				<?php endwhile; else : ?>
					<p>Sorry, no posts matched your criteria.</p>
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

