<?php
/*
Template Name: Home Page
*/
?>
<?php get_header() ?>

	<div id="content">
		<div class="padder" style="margin-right: 0px">
		
			<div id="frontpage-logo">
				<?php
				// get the latest notification modified within the last 15 days
				$querystr = "
					SELECT wposts.*
					FROM $wpdb->posts wposts
					JOIN $wpdb->term_relationships wterm ON
						( wposts.ID = wterm.object_id )
					JOIN $wpdb->terms cat ON
						( wterm.term_taxonomy_id = cat.term_id AND
						  cat.name = 'notifications' )
					WHERE wposts.post_modified > '" . date('Y-m-d', strtotime('-15 days')) . "'
					AND wposts.post_status = 'publish'
					AND wposts.post_type = 'post'
					ORDER BY wposts.post_modified DESC
					LIMIT 1
					";
					
				$pageposts = $wpdb->get_results($querystr, OBJECT);
				
				if ($pageposts):
					global $post;
					foreach ($pageposts as $post): setup_postdata($post); ?>
						<div id="announcement">
							Special:&nbsp;<a href="<?php the_permalink() ?>"><?php the_title() ?></a>
						</div>
					<?php endforeach;
				endif; ?>
			</div>
			
			<div id="bannerbox">
				<?php
				$sticky = get_option('sticky_posts');
				$sticky = array_reverse($sticky); // sort the stickies with the newest at the top
				$sticky = array_slice($sticky, 0, 1); // grab only the latest stickied post
				
				$query = new WP_Query(array(
					'category_name' => 'news',
					'post__in' => $sticky,
					"ignore_sticky_posts" => 1)); ?>
					
				<?php if ($sticky[0]) : if ( $query->have_posts() ) : $query->the_post(); ?>
					<?php $the_source = get_post_meta(get_the_ID(), 'syndication_source', true); ?>
					<div class="module" id="featured">
						<strong><em>Featured:</em></strong> <span style="font-size: 18px"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e( 'Permanent Link to', 'buddypress' ) ?> '<?php the_title_attribute(); ?>'" <?php if ($the_source) { echo 'target="_blank"'; } ?>><?php the_title(); ?></a></span>
						<?php the_excerpt(); ?>
					</div>
				<?php endif; endif; ?>
			
				<?php if ( !is_user_logged_in() ) : ?>
					<div id="join-us">
						<h3>Join us today!</h3>
						<p>We're a fast growing community for individuals and families with rare genetic diseases. Come and be encouraged by others with stories like your own. 
							If you would like to join us as a volunteer editor and help keep our pages up to date please navigate to our <a href="<?php echo get_site_url(1) . '/volunteer-application/' ?>">volunteer page</a>.
						</p>
						
						<a class="button" href="<?php echo get_site_url(1) . '/register' ?>">Register</a>
					</div>
				<?php endif; ?>
			</div>
			
			<div class="module" id="news">
				<h3 class="module-header">Recent News Articles</h3>
				<?php
				$sticky = get_option('sticky_posts');
				$sticky = array_reverse($sticky); // sort the stickies with the newest at the top
				$post_to_skip = $sticky[0];
				
				$params = array( // grab all news posts sorted by descending date
					'category_name' => 'news',
					'orderby' => 'date',
					'order' => 'DESC',
					'posts_per_page' => 6 );
				$pageposts = get_posts($params);
				
				if ($pageposts):
					$counter = 0;
					foreach ($pageposts as $post): setup_postdata($post);
						if (get_the_ID() == $post_to_skip) { continue; }
						if (++$counter > 5) { continue; }
						$the_source = get_post_meta(get_the_ID(), 'syndication_source', true); ?>
						
						<div class="frontpage-entry">
							<p><a href="<?php the_permalink() ?>" rel="bookmark" <?php if ($the_source) { echo 'target="_blank"'; } ?>><?php the_title(); ?></a><span class="meta"> - <?php the_time('F j, Y') ?></span></p>
						</div>
					<?php endforeach;
				endif; ?>
			</div>
			
			<div class="module" id="forumtopics">
				<h3 class="module-header">Recent Forum Activity</h3>
				
				<?php
				$disease_name = get_option('pfond_disease_name');			
				// query for posts made within the last 15 days
				$querystr = "
					SELECT *
					FROM wp_bb_posts bbposts
					JOIN wp_bb_topics bbtopics ON
						( bbposts.topic_id = bbtopics.topic_id )
					JOIN wp_bp_groups_groupmeta bpgroupsmeta ON
						( bpgroupsmeta.meta_key = 'forum_id' AND
						  bpgroupsmeta.meta_value = bbposts.forum_id )
				    JOIN wp_bp_groups bpgroups ON
						( bpgroups.id = bpgroupsmeta.group_id )
					WHERE bbtopics.topic_status = 0
					AND bpgroups.name = '" . trim($disease_name) . "'
					ORDER BY bbposts.post_time DESC
					LIMIT 5
					";
				// AND bpgroups.name = '" . trim($disease_name) . "' )
					
				$forumposts = $wpdb->get_results($querystr, OBJECT);
				
				if ( $forumposts ) : ?>
					<?php for ($i = 0; $i < count($forumposts); $i++) : $post = $forumposts[$i]; ?>
						<?php $topic_url = get_site_url(1) . '/' . BP_GROUPS_SLUG . '/' . $post->slug . '/forum/topic/' . $post->topic_slug . '/'; ?>
						<div class="frontpage-entry">
							<a href="<?php echo bp_core_get_userlink($post->poster_id, false, true) ?>"><?php echo bp_core_fetch_avatar('item_id=' . $post->poster_id) ?></a>
							<div class="content">
							<?php if ($post->topic_start_time == $post->post_time) :?>
								<p><?php echo bp_core_get_userlink($post->poster_id) . " started the forum topic <a href='" . $topic_url . "'>'" . $post->topic_title . "'</a> (" . human_time_diff(mysql2date('U', $post->post_time), current_time('timestamp')) . " ago)"; ?></p>
							<?php else : ?>
								<p><?php echo bp_core_get_userlink($post->poster_id) . " posted <em>'" . get_snippet($post->post_text, 50) . "'</em> in the forum topic <a href='" . $topic_url . "'>'" . $post->topic_title . "'</a> (" . human_time_diff(mysql2date('U', $post->post_time), current_time('timestamp')) . " ago)"; ?></p>
							<?php endif; ?>
							</div>
						</div>
					<?php endfor; ?>
				<?php endif; ?>
			</div>
			
			<div id="updates">
				<?php dynamic_sidebar('sidebar') ?>
			</div>
		
		</div><!-- .padder -->
	</div><!-- #content -->

<?php get_footer(); ?>
