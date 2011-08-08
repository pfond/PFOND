<?php
/*
Template Name: About Page
*/
?>
<?php get_header() ?>

	<div id="content">
		<div class="padder">

		<div class="page" id="about-page">
		
			<?php
			$url_chunks = explode("/", $_SERVER['REQUEST_URI']);
			end($url_chunks);
			$current_term = prev($url_chunks);
			?>
			
			<h1><?php echo get_term_by('slug', $current_term, 'info_category')->name ?></h1>
			
			<?php
			/*
			$querystr = "
				SELECT wposts.*
				FROM $wpdb->posts wposts
				JOIN $wpdb->postmeta m1 ON
					( wposts.ID = m1.post_id AND
					  m1.meta_key = 'info-category' )
				JOIN $wpdb->postmeta m2 ON
					( wposts.ID = m2.post_id AND
					  m2.meta_key = 'info-ranking' )
				WHERE m1.meta_value = '$current_term'
				AND wposts.post_status = 'publish'
				AND wposts.post_type = 'disease_info'
				ORDER BY m2.meta_value ASC, wposts.post_modified DESC
				";
				
			$queried_posts = $wpdb->get_results($querystr, OBJECT);*/			
						
			$params = array(
				'post_type' => 'disease_info',
				'tax_query' => array(
					array(
						'taxonomy' => 'info_category',
						'field' => 'slug',
						'terms' => array($current_term)
					)
				),
				'meta_key' => 'info-ranking',
				'orderby' => 'meta_value_num',
				'order' => 'ASC',
				'nopaging' => true
			);
			query_posts ($params);
			
			if (have_posts()) : while (have_posts()) : the_post();
			//foreach ($queried_posts as $post) : setup_postdata($post);
			?>
			
				<div class="post" id="post-<?php the_ID(); ?>" name="post-<?php the_ID(); ?>">
				
					<h2 class="posttitle"><?php the_title(); ?></h2>
					
					<div class="entry"><?php the_content(); ?></div>
					
				</div>
			
			<?php endwhile; endif; // endforeach; ?>
		
		</div><!-- .page -->
				
		</div><!-- .padder -->
	</div><!-- #content -->
	
	<?php locate_template( array( 'sidebar.php' ), true ) ?>

<?php get_footer(); ?>
