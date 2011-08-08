<?php get_header() ?>

	<div id="content">
		<div class="padder">

		<div class="page" id="news-page">

			<?php
			$sticky = get_option('sticky_posts');
			$sticky = array_reverse($sticky); // sort the stickies with the newest at the top
			$post_to_skip = $sticky[0];			
			
			$page = get_query_var('page') ? get_query_var('page') : 1;
			$params = array( // grab all news posts sorted by descending date
				'category_name' => 'news',
				'orderby' => 'date',
				'order' => 'DESC',
				'paged' => $page );
			query_posts($params);
			
			if ( have_posts() ) :
			
				while ( have_posts() ) : the_post();
				
					if (get_the_ID() != $post_to_skip) : // omit the featured post ?>
				
					<div class="post" id="post-<?php the_ID(); ?>">
						<h2 class="posttitle"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e( 'Permanent Link to', 'buddypress' ) ?> '<?php the_title_attribute(); ?>'" target="_blank"><?php the_title(); ?></a></h2>

						<p class="date"><?php the_time('F j, Y') ?> <?php
							$the_source = get_post_meta(get_the_ID(), 'syndication_source', true);
							if (!$the_source) :
								echo 'by ' . bp_core_get_userlink( get_the_author() );
							else :
								$post_tags = get_the_tags();
								foreach ($post_tags as $tag) {
									$tagid = $tag->term_id; // we assume that there is only one tag -- the feed tag
									break;
								}
								echo 'from <a href="' . get_tag_link($tagid) . '">' . $the_source . '</a>';
							endif; ?>
						</p>
						
						<div class="entry">
							<?php if (!$the_source) :
								the_excerpt();
							else :
								echo '<p>' . trim(get_the_excerpt()) . ' <a href="' . get_permalink() . '" rel="bookmark" title="Permanent Link to \'' . the_title_attribute('echo=0') . '\'" target="_blank">[Read more]</a></p>';
							endif; ?>
						</div>
					</div><!-- .post -->
					
					<?php endif;
				
				endwhile;
				?>

				<?php if (function_exists('wp_paginate')) {
					wp_paginate();
				}
				?>
				
			<?php else : ?>

				<h2 class="center"><?php _e( 'Not Found', 'buddypress' ) ?></h2>
				<p class="center"><?php _e( 'Sorry, but you are looking for something that isn\'t here.', 'buddypress' ) ?></p>

				<?php locate_template( array( 'searchform.php' ), true ) ?>

			<?php endif; ?>

		</div><!-- .page -->
				
		</div><!-- .padder -->
	</div><!-- #content -->
	
	<?php locate_template( array( 'sidebar.php' ), true ) ?>

<?php get_footer(); ?>
