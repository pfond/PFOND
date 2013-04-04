<?php

define ('DISEASE_NAME_PLACEHOLDER', '%disease-name%');
define ('DISEASE_GROUP_URL_PLACEHOLDER', '%group-url%');
define ('MEMBERS_URL_PLACEHOLDER', '%members-url%');
define ('SITE_FEEDBACK_URL_PLACEHOLDER', '%site-feedback-url%');

// This theme uses wp_nav_menu() in one location.
register_nav_menus( array(
	'primary' => __( 'Primary Navigation', 'buddypress' ),
) );

if ( function_exists( 'add_theme_support' ) ) { 
  add_theme_support( 'post-thumbnails' ); 
}

function pfond_get_login_link() {
?>
	<a name="modal-login" class="button" href="#login-window">Sign in</a>	
<?php
}

function pfond_get_terms($post_id, $leading_caption, $taxonomy) {
	echo $leading_caption . ": ";
	$terms = get_the_terms($post_id, $taxonomy);
	if ($terms) {
		$last_element = end($terms);
		foreach ($terms as $term) {
			$loc_link = get_term_link($term->slug, $term->taxonomy);
			?>
			<a href="<?php echo $loc_link ?>"><?php echo $term->name ?></a><?php
			if ($term != $last_element) { echo ", "; }
		}
	} else {
		echo 'none';
	}
}

function get_snippet($text,$length=64,$tail="...") {
    $text = trim($text);
    $txtl = strlen($text);
    if($txtl > $length) {
        for($i=1;$text[$length-$i]!=" ";$i++) {
            if($i == $length) {
                return substr($text,0,$length) . $tail;
            }
        }
        for(;$text[$length-$i]=="," || $text[$length-$i]=="." || $text[$length-$i]==" ";$i++) {;}
        $text = substr($text,0,$length-$i+1) . $tail;
    }
    return $text;
}

//====================================
//	Custom post types
//====================================

function pfond_register_experts_post_type() {
	// create the custom post type, 'Disease Info'
	$post_type_labels = array(
		'name' => __('Experts'),
		'add_new_item' => __('Add New Expert'),
		'edit_item' => __('Edit Expert'),
		'new_item' => __('New Expert'),
		'view_item' => __('View Expert'),
		'search_items' => __('Search Experts'),
		'not_found' => __('No experts found'),
		'not_found_in_trash' => __('No experts found in Trash')
	);
	
	register_post_type('expert', array(
		'labels' => $post_type_labels,
		'description' => __('Researchers or clinicians who specialize in this disease or a related field.'),
		'public' => true,
		'show_in_nav_menus' => false,
		'show_in_menu' => true,
		'supports' => array('title', 'editor', 'comments', 'revisions'),
		'rewrite' => array('slug' => 'experts/list', 'with_front' => false)
	));
	
	// register the taxonomies we will use with this post type
	register_taxonomy('location', 'expert', array(
		'label' => __('Locations'),
		'show_in_nav_menus' => false,
		'show_ui' => true,
		'show_tagcloud' => false,
		'hierarchical' => true,
		'rewrite' => array('slug' => 'experts/location', 'with_front' => false)
	));
	
	register_taxonomy('specialization', 'expert', array(
		'label' => __('Specializations'),
		'show_in_nav_menus' => false,
		'show_ui' => true,
		'show_tagcloud' => true,
		'hierarchical' => false,
		'rewrite' => array('slug' => 'experts/specialization', 'with_front' => false)
	));
}

function pfond_register_info_post_type() {
	// create the custom post type, 'Disease Info'
	$post_type_labels = array(
		'name' => __('Disease Info'),
		'add_new_item' => __('Add New Disease Information'),
		'edit_item' => __('Edit Disease Information'),
		'new_item' => __('New Disease Information'),
		'view_item' => __('View Disease Information'),
		'search_items' => __('Search Disease Information'),
		'not_found' => __('No disease information found'),
		'not_found_in_trash' => __('No disease information found in Trash')
	);
	
	register_post_type('disease_info', array(
		'labels' => $post_type_labels,
		'description' => __('Information related to this disease, including symptoms, diagnoses, treatments and developments.'),
		'public' => true,
		'show_in_nav_menus' => false,
		'show_in_menu' => true,
		'supports' => array('title', 'editor', 'comments', 'revisions'),
		'rewrite' => array('slug' => 'about/all', 'with_front' => false)
	));
	
	// register the taxonomy we will use with this post type
	register_taxonomy('info_category', 'disease_info', array(
		'label' => __('Info Categories'),
		'show_in_nav_menus' => true,
		'show_ui' => true,
		'show_tagcloud' => false,
		'hierarchical' => true,
		'rewrite' => array('slug' => 'about', 'with_front' => false)
	));
}

function pfond_register_custom_post_types() {
	pfond_register_info_post_type();
	pfond_register_experts_post_type();
}
add_action('init', 'pfond_register_custom_post_types');

function pfond_add_custom_meta_boxes() {
	// meta boxes for Disease Info post type
	add_meta_box('info-category-meta', 'Info Category', 'pfond_info_category_meta_box', 'disease_info', 'side');
	add_meta_box('info-ranking-meta', 'Info Ranking', 'pfond_info_ranking_meta_box', 'disease_info', 'side');
	
	// meta boxes for Experts post type
	add_meta_box('expert-link-meta', 'Expert\'s personal or laboratory website', 'pfond_expert_link_meta_box', 'expert', 'normal', 'high');
	add_meta_box('expert-contact-meta', 'Expert\'s e-mail address', 'pfond_expert_contact_meta_box', 'expert', 'normal', 'high');
}
add_action('admin_init', 'pfond_add_custom_meta_boxes');

function pfond_info_category_meta_box() {
	global $post;
	$terms = get_terms('info_category', 'orderby=id&hide_empty=0');
	?>
	<p>Choose a category for this information:</p>
	<select name="info-category">
		<?php
		foreach ($terms as $term) {
			?>
			<option value="<?php echo $term->name ?>" <?php if (get_post_meta($post->ID, 'info-category', true) == $term->name): ?>selected="selected"<?php endif; ?>/><?php echo $term->name ?></option>
			<?php
		}
		?>
	</select>
	<br /><br />
	<?php
	foreach ($terms as $term) {
		?>
		<p><em><strong><?php echo $term->name ?>:</strong> <?php echo $term->description ?></em></p>
		<?php
	}
}

function pfond_info_ranking_meta_box() {
	global $post;
	$current_ranking = get_post_meta($post->ID, 'info-ranking', true);
	if ($current_ranking == null) $current_ranking = 0;
	?>
	<p>
		<label>Ranking:&nbsp;</label>
		<input name="info-ranking" value="<?php echo $current_ranking ?>" size="10"/>
	</p>
	<p><em>Rankings determine the order in which information is displayed in the 'About' pages. Lower rankings are displayed first.</em></p>
	<?php
}

function pfond_expert_link_meta_box() {
	global $post;
	$current_link = get_post_meta($post->ID, 'expert-link', true);
	?>
	<p><input name="expert-link" value="<?php echo $current_link ?>" style="width: 95%"/></p>
	<?php
}

function pfond_expert_contact_meta_box() {
	global $post;
	$contact_info = get_post_meta($post->ID, 'expert-contact', true);
	?>
	<p><input name="expert-contact" value="<?php echo $contact_info ?>" style="width: 95%"/></p>
	<?php
}

function plugin_save_custom_meta($post_id) {
	// verify if this is an auto save routine. If it is our form has not been submitted, so we dont want to do anything
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;
	
	$post_type = get_post_type($post_id);
		
	if ($post_type == 'disease_info') {
		// save meta information for Disease Info post type
		$term_selected = get_term_by('name', $_POST['info-category'], 'info_category');
		wp_set_object_terms($post_id, $term_selected->slug, 'info_category');
			
		update_post_meta($post_id, 'info-category', $_POST['info-category']);
		update_post_meta($post_id, 'info-ranking', $_POST['info-ranking']);
	} elseif ($post_type == 'expert') {
		// save meta information for Experts post type
		update_post_meta($post_id, 'expert-link', $_POST['expert-link']);
		update_post_meta($post_id, 'expert-contact', $_POST['expert-contact']);
	}
}
add_action('save_post', 'plugin_save_custom_meta');

function pfond_info_columns($columns) {
	$columns = array(
		"cb" => "<input type=\"checkbox\" />",  
		"title" => "Title",
		"category" => "Category",
		"ranking" => "Ranking",
		"comments" => $columns["comments"],
		"modified" => "Modified"
	);
	return $columns;
}
add_filter('manage_edit-disease_info_columns', 'pfond_info_columns');

function pfond_expert_columns($columns) {
	$columns = array(
		"cb" => "<input type=\"checkbox\" />",  
		"title" => "Name",
		"location" => "Location",
		"specializations" => "Specializations",
		"comments" => $columns["comments"],
		"date" => "Date Published"
	);
	return $columns;
}
add_filter('manage_edit-expert_columns', 'pfond_expert_columns');

function pfond_custom_column_data($column) {
	global $post;
	switch ($column) {
		case 'category':
			echo get_post_meta($post->ID, 'info-category', true);
			break;			
		case 'ranking':
			echo get_post_meta($post->ID, 'info-ranking', true);
			break;
		case 'location':
			$terms = wp_get_object_terms($post->ID, 'location', array(
				'orderby' => 'name',
				'order' => 'ASC',
				'fields' => 'names'
			));
			echo implode(", ", $terms);
			break;
		case 'specializations':
			$terms = wp_get_object_terms($post->ID, 'specialization', array(
				'orderby' => 'name',
				'order' => 'ASC',
				'fields' => 'names'
			));
			echo implode(", ", $terms);
			break;
		case 'modified':
			$modified_time = strtotime($post->post_modified);
			$current_time = current_time('timestamp');
			if (($current_time - $modified_time) > 86400) {
				echo $post->post_modified;
			} else {
				echo human_time_diff($modified_time, $current_time) . ' ago';
			}
			break;
	}
}
add_action('manage_posts_custom_column', 'pfond_custom_column_data');

function pfond_info_column_register_sortable($columns) {
	$columns['category'] = 'category';
	$columns['modified'] = 'modified';
	return $columns;
}
add_filter('manage_edit-disease_info_sortable_columns', 'pfond_info_column_register_sortable');

function pfond_custom_column_orderby($vars) {
	if ( isset( $vars['orderby'] ) ) {
		if ( 'category' == $vars['orderby'] ) {
			$vars = array_merge( $vars, array(
				'meta_key' => 'info-category',
				//'meta_value' => 'overview'
				'orderby' => 'meta_value'
			) );
		}
	}
	return $vars;
}
add_filter('request', 'pfond_custom_column_orderby');

function pfond_admin_css() {
	echo '<style type="text/css">';
	echo '.column-category, .column-location, .column-specializations { width: 15%; }';
	echo '.column-modified { width: 10%; }';
	echo '.column-ranking { width: 8%; }';
	echo '</style>';
}
add_action('admin_head', 'pfond_admin_css');

/*
function pfond_template_redirect() {
	global $wp, $wp_query;
	if ($wp->query_vars["post_type"] == "disease_info") {
		if (have_posts()) {
			include(TEMPLATEPATH . '/about.php';
			die();
		} else {
			$wp_query->is_404 = true;
		}
	}
}
add_action('template_redirect', 'pfond_template_redirect');
*/

//====================================
//	Filters
//====================================

/**
 * Returns a "Continue Reading" link for excerpts
 */
function pfond_continue_reading_link() {
	global $post;
	
	$is_syndicated_source = get_post_meta($post->ID, 'syndication_source', true); // check if this is a syndicated post

	if ($is_syndicated_source) {
		return ' <a href="'. get_permalink() . '" target="_blank">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>') . '</a>';
	} else {
		return ' <a href="'. get_permalink() . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>') . '</a>';
	}
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and pfond_continue_reading_link().
 */
function pfond_auto_excerpt_more( $more ) {
	return ' &hellip;' . pfond_continue_reading_link();
}
add_filter( 'excerpt_more', 'pfond_auto_excerpt_more' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 */
function pfond_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= pfond_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'pfond_custom_excerpt_more' );

function pfond_filter_page_title( $with_site_name, $without_site_name ) {
	if ( bp_is_blog_page() ) {
		if (is_front_page()) {
			return get_bloginfo('name') . ' | Home';
		} else {
			return get_bloginfo('name') . ' | ' . wp_title('', false);
		}
	} else {
		return $with_site_name;
	}
}
add_filter( 'bp_page_title', 'pfond_filter_page_title', 10, 2 );

//====================================
//	Page action hooks
//====================================

function pfond_sidebar_jump_list_section($topic) {
	?>
	<div class="section">
		<h4><?php echo get_term_by('slug', $topic, 'info_category')->name ?></h4>
		<ul>
		<?php
		$is_alt = false;
		$query = new WP_Query(array(
			'post_type' => 'disease_info',
			'tax_query' => array(
				array(
					'taxonomy' => 'info_category',
					'field' => 'slug',
					'terms' => array($topic)
				)
			),
			'orderby' => 'title',
			'order' => 'ASC',
			'nopaging' => true
		));
		if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
		?>
			<li <?php if ($is_alt): ?>class="alt"<?php endif; ?>><a href="<?php
			if (!is_tax('info_category', $topic)) {
				echo home_url('about/' . $topic . '/#post-' . get_the_ID());
			} else {
				echo '#post-' . get_the_ID();
			}
			?>"><?php the_title(); ?></a></li>
		<?php
		$is_alt = !$is_alt;
		endwhile; endif;
		?>
		</ul>
	</div>
	<?php
}

function pfond_sidebar_jump_list() {
	if (!is_tax('info_category', array('overview', 'treatment', 'research'))) return;
	?>
	
	<div id="jumplist">
	<h3>About the Disease</h3>
	<?php pfond_sidebar_jump_list_section('overview'); ?>
	<?php pfond_sidebar_jump_list_section('treatment'); ?>
	<?php pfond_sidebar_jump_list_section('research'); ?>
	</div>
	
	<?php
}
add_action('bp_inside_before_sidebar', 'pfond_sidebar_jump_list');

function pfond_create_featured_post() {

	global $post;

	$sticky = get_option('sticky_posts');
	$sticky = array_reverse($sticky); // sort the stickies with the newest at the top
	$sticky = array_slice($sticky, 0, 1); // grab only the latest stickied post
	
	$query = new WP_Query(array(
		'category_name' => 'news',
		'post__in' => $sticky,
		"ignore_sticky_posts" => 1)); ?>
		
	<?php if ($sticky[0]) :
	
		if ( $query->have_posts() ) : $query->the_post(); ?>
		
			<div id="banner-wrap">
				<div id="banner">
					<div class="post" id="post-<?php the_ID(); ?>">
					
						<?php $the_source = get_post_meta(get_the_ID(), 'syndication_source', true); ?>
					
						<h2 class="posttitle"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e( 'Permanent Link to', 'buddypress' ) ?> '<?php the_title_attribute(); ?>'" <?php if ($the_source) { echo 'target="_blank"'; } ?>><?php the_title(); ?></a></h2>

						<p class="date"><?php the_time('F j, Y') ?> <?php
							$the_source = get_post_meta(get_the_ID(), 'syndication_source', true);
							if (!$the_source) :
								echo 'by ' . bp_core_get_userlink( $post->post_author );
							else :
								$post_tags = get_the_tags();
								if ($post_tags) {
									foreach ($post_tags as $tag) {
										$tagid = $tag->term_id; // we assume that there is only one tag -- the feed tag
										break;
									}
									echo 'from <a href="' . get_tag_link($tagid) . '">' . $the_source . '</a>';
								} else {
									echo 'from ' . get_post_meta($post->ID, 'syndication_source', true);
								}
							endif; ?>
						</p>

						<div class="entry"><?php the_excerpt(); ?></div>
						
					</div>
				</div>
			</div>
	
		<?php endif;
		
	else :
	
		// do nothing
		
	endif;

}

function pfond_create_banner() {
	
	if (is_page_template('news-page.php')) pfond_create_featured_post();
	
}
add_action('bp_before_container', 'pfond_create_banner');

//====================================
//	Recent Forum Posts Widget
//====================================

class PfondRecentForumPostsWidget extends WP_Widget {

	function PfondRecentForumPostsWidget() {
		$widget_ops = array('description' => 'Recent forum posts');
		parent::WP_Widget(false, $name = 'Recent Forum Posts', $widget_ops);
	}
	
	function widget($args, $instance) {
	?>
		<div class="widget">
			<h3>Recent Forum Posts</h3>
			
			<?php
			global $wpdb;
			
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
				AND bbposts.post_time > '" . date('Y-m-d', strtotime('-' . $instance['within_days'] . ' days')) . "'
				ORDER BY bbposts.post_time DESC
				LIMIT " . $instance['num_posts'] . "
				";
				
			$forumposts = $wpdb->get_results($querystr, OBJECT);
			
			if ( $forumposts ) : ?>
				<?php for ($i = 0; $i < count($forumposts); $i++) : $post = $forumposts[$i]; ?>
					<?php $topic_url = get_site_url(1) . '/' . BP_GROUPS_SLUG . '/' . $post->slug . '/forum/topic/' . $post->topic_slug . '/'; ?>
					
					<div class="forum-post">
						<div class="authorbox"><a href="<?php echo bp_core_get_userlink($post->poster_id, false, true) ?>"><?php echo bp_core_fetch_avatar('item_id=' . $post->poster_id) ?></a><?php echo bp_core_get_userlink($post->poster_id) ?> said:</div>
						
						<div class="content"><em><?php echo get_snippet($post->post_text, 75) ?></em> <a href="<?php echo $topic_url ?>">[more]</a></div>
					</div>
				<?php endfor; ?>
			<?php else : ?>
			
				No recent posts =(
			
			<?php endif; ?>
			
		</div>
	<?php
	}
	
	function form($instance) {
	?>
		<p>
			<label for="<?php echo $this->get_field_id('num_posts'); ?>"><?php _e('Number of posts to display'); ?>:&nbsp;</label>
			<select id="<?php echo $this->get_field_id('num_posts'); ?>" name="<?php echo $this->get_field_name('num_posts'); ?>">
				<?php for ($i = 1; $i <= 10; $i++): ?>
					<option value="<?php echo $i ?>" <?php
						if ($i == $instance["num_posts"]) {
							echo 'selected="selected"';
						}
					?>><?php echo $i ?></option>
				<?php endfor; ?>
			</select>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('within_days'); ?>"><?php _e('Show recent posts within '); ?>&nbsp;</label>
			<select id="<?php echo $this->get_field_id('within_days'); ?>" name="<?php echo $this->get_field_name('within_days'); ?>">
				<?php for ($i = 10; $i <= 30; $i = $i + 5): ?>
					<option value="<?php echo $i ?>" <?php
						if ($i == $instance["within_days"]) {
							echo 'selected="selected"';
						}
					?>><?php echo $i ?>&nbsp;days</option>
				<?php endfor; ?>
			</select>
		</p>
	<?php
	}

}
add_action( 'widgets_init', create_function('', 'return register_widget("PfondRecentForumPostsWidget");') );

//====================================
//	New Members Widget
//====================================

class PfondNewMembersWidget extends WP_Widget {

	function PfondNewMembersWidget() {
		$widget_ops = array('description' => 'Members who have recently joined the site');
		parent::WP_Widget(false, $name = 'New Members', $widget_ops);
	}
	
	function widget($args, $instance) {
	?>
		<div class="widget">
			<h3>New Members</h3>
			
			<?php
			global $wpdb;
			
			// query for users registered within the last n days
			$querystr = "SELECT id,display_name,user_registered
				FROM wp_users
				WHERE wp_users.user_status = 0
				AND wp_users.user_registered > '" . date('Y-m-d', strtotime('-' . $instance['within_days'] . ' days')) . "'
				ORDER BY wp_users.user_registered DESC
				LIMIT " . $instance['num_users'] . "
				";
				
			$userquery = $wpdb->get_results($querystr, OBJECT);
			
			if ($userquery) : ?>
				<?php for ($i = 0; $i < count($userquery); $i++) : $user = $userquery[$i]; ?>
					<div class="new-user">
						<a href="<?php echo bp_core_get_userlink($user->id, false, true) ?>"><?php echo bp_core_fetch_avatar('item_id=' . $user->id) ?></a>
						<div class="new-user-info"><?php echo bp_core_get_userlink($user->id) ?> (registered <?php echo human_time_diff(mysql2date('U', $user->user_registered), current_time('timestamp')) ?> ago)</div>
					</div>
				<?php endfor; ?>
			<?php else : ?>
			
				No new members =(
			
			<?php endif; ?>
			
		</div>
	<?php
	}
	
	function form($instance) {
	?>
		<p>
			<label for="<?php echo $this->get_field_id('num_users'); ?>"><?php _e('Number of members to display'); ?>:&nbsp;</label>
			<select id="<?php echo $this->get_field_id('num_users'); ?>" name="<?php echo $this->get_field_name('num_users'); ?>">
				<?php for ($i = 1; $i <= 10; $i++): ?>
					<option value="<?php echo $i ?>" <?php
						if ($i == $instance["num_users"]) {
							echo 'selected="selected"';
						}
					?>><?php echo $i ?></option>
				<?php endfor; ?>
			</select>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('within_days'); ?>"><?php _e('Show new registrations within '); ?>&nbsp;</label>
			<select id="<?php echo $this->get_field_id('within_days'); ?>" name="<?php echo $this->get_field_name('within_days'); ?>">
				<?php for ($i = 10; $i <= 30; $i = $i + 5): ?>
					<option value="<?php echo $i ?>" <?php
						if ($i == $instance["within_days"]) {
							echo 'selected="selected"';
						}
					?>><?php echo $i ?>&nbsp;days</option>
				<?php endfor; ?>
			</select>
		</p>
	<?php
	}

}
add_action( 'widgets_init', create_function('', 'return register_widget("PfondNewMembersWidget");') );

//====================================
//	Recently Featured Widget
//====================================

class PfondFeaturedPostsWidget extends WP_Widget {

	function PfondFeaturedPostsWidget() {
		$widget_ops = array('description' => 'Recently featured news posts');
		parent::WP_Widget(false, $name = 'Recently Featured', $widget_ops);
	}

	function widget($args, $instance) {
		global $post;
		$post_old = $post; // Save the post object.
		
		extract( $args );
		
		// If not title, use the name of the category.
		if( !$instance["title"] ) {
			$category_info = get_category($instance["cat"]);
			$instance["title"] = $category_info->name;
		}
	  
		$sticky = get_option('sticky_posts');
		$sticky = array_reverse($sticky); // sort the stickies with the newest at the top
		$sticky = array_slice($sticky, 1, $instance["num"] + 1); // grab everything except the latest stickied post
	
		$query = new WP_Query(array(
			'cat' => $instance["cat"],
			'post__in' => $sticky,
			"ignore_sticky_posts" => 1)); ?>
		
		<div class="widget">
		
			<h3>Recently Featured</h3>
			
			<?php if ( count($sticky) > 0 ) : ?>
			
				<ul>
				<?php while ( $query->have_posts() ) : $query->the_post(); ?>
				
				<li>
					<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e( 'Permanent Link to', 'buddypress' ) ?> '<?php the_title_attribute(); ?>'" <?php if ($the_source) { echo 'target="_blank"'; } ?>><?php the_title(); ?></a> - 
										
					<?php if ( $instance['date'] ) :
						the_time("j M Y");
					endif; ?>
					
					<?php if ( $instance['comment_num'] ) :
						echo '('; comments_number(); echo ')';
					endif; ?>
				</li>
				
				<?php endwhile; ?>
				</ul>
				
			<?php else: ?>
			
				No recently featured posts.
		
			<?php endif;
		
			$post = $post_old; // Restore the post object. ?>
		
		</div>
	<?php
	}
	
	function form($instance) {
	?>
		<p>
			<label for="<?php echo $this->get_field_id("title"); ?>">
				<?php _e( 'Title' ); ?>:
				<input class="widefat" id="<?php echo $this->get_field_id("title"); ?>" name="<?php echo $this->get_field_name("title"); ?>" type="text" value="<?php echo esc_attr($instance["title"]); ?>" />
			</label>
		</p>
		
		<p>
			<label>
				<?php _e( 'Category' ); ?>:
				<?php wp_dropdown_categories( array( 'name' => $this->get_field_name("cat"), 'selected' => $instance["cat"] ) ); ?>
			</label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id("num"); ?>">
				<?php _e('Number of posts to show'); ?>:
				<input style="text-align: center;" id="<?php echo $this->get_field_id("num"); ?>" name="<?php echo $this->get_field_name("num"); ?>" type="text" value="<?php echo absint($instance["num"]); ?>" size='3' />
			</label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id("comment_num"); ?>">
				<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("comment_num"); ?>" name="<?php echo $this->get_field_name("comment_num"); ?>"<?php checked( (bool) $instance["comment_num"], true ); ?> />
				<?php _e( 'Show number of comments' ); ?>
			</label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id("date"); ?>">
				<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("date"); ?>" name="<?php echo $this->get_field_name("date"); ?>"<?php checked( (bool) $instance["date"], true ); ?> />
				<?php _e( 'Show post date' ); ?>
			</label>
		</p>
	<?php
	}

}
add_action( 'widgets_init', create_function('', 'return register_widget("PfondFeaturedPostsWidget");') );

//====================================
//	Links Widget
//====================================

class PfondLinksWidget extends WP_Widget {
	
	function PfondLinksWidget() {
		$widget_ops = array('description' => 'Editor-curated links to related websites');
		parent::WP_Widget(false, $name = 'Latest Links', $widget_ops);
	}
	
	function widget($args, $instance) {
		$bookmarks = get_bookmarks(array(
			'orderby' => 'updated',
			'order' => 'DESC',
			'limit' => $instance["num_links"],
			'category_name' => 'Helpful Links',
			'categorize' => 0
		));
		
		$more_link = get_page_link(get_page_by_title('Helpful Links')->ID);
		?>

		<div class="widget">
		
		<h3>Latest Links</h3>
		
		<?php
		foreach ($bookmarks as $bm) {
		?>
			<div class="bookmark" id="link-<?php echo $bm->link_id ?>">
				<a class="mini" href="<?php echo $bm->link_url ?>" title="<?php echo $bm->link_description ?>" target="_blank"><?php echo $bm->link_name ?></a>
			</div>
		<?php
		}
		?>
		
		<a href="<?php echo $more_link ?>" style="position: absolute; top: 0; right: 0">[See more]</a>
		
		</div>
		<?php
	}
	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		
		$instance['num_links'] = $new_instance['num_links'];
		
		return $instance;
	}
	
	function form($instance) {
	?>
		<p>
			<label for="<?php echo $this->get_field_id('num_links'); ?>"><?php _e('Number of links to display'); ?>:&nbsp;</label>
			<select id="<?php echo $this->get_field_id('num_links'); ?>" name="<?php echo $this->get_field_name('num_links'); ?>">
				<?php for ($i = 1; $i <= 10; $i++): ?>
					<option value="<?php echo $i ?>" <?php
						if ($i == $instance["num_links"]) {
							echo 'selected="selected"';
						}
					?>><?php echo $i ?></option>
				<?php endfor; ?>
			</select>
		</p>
	<?php
	}
}
add_action('widgets_init', create_function('', 'return register_widget("PfondLinksWidget");'));

//====================================
//	Experts Widget
//====================================

class PfondExpertFiltersWidget extends WP_Widget {
	
	function PfondExpertFiltersWidget() {
		$widget_ops = array('description' => 'List of specializations/locations to filter experts');
		parent::WP_Widget(false, $name = 'Expert Filters', $widget_ops);
	}
	
	function widget($args, $instance) {
	?>
		<div class="widget" id="expertfilter">
	
			<h3>Find Experts</h3>

			<h4>By specialization:</h4>	
			
			<div class="filter"><?php wp_tag_cloud(array('taxonomy' => 'specialization')); ?></div>
			
			<h4>By location:</h4>
			
			<div class="filter">
				<?php $terms = get_terms('location', 'orderby=id&hide_empty=0'); ?>
				<ul>
				<?php foreach ($terms as $term) {
				$loc_link = get_term_link($term->slug, $term->taxonomy); ?>
					<li><a href="<?php echo $loc_link ?>" title="<?php echo $term->count ?> expert<?php if ($term->count > 1) echo 's' ?>"><?php echo $term->name ?></a></li>
				<?php } ?>
				</ul>
			</div>
		
		</div>
	<?php
	}
	
	function form($instance) {
	?>
		<p>Nothing to configure!</p>
	<?php
	}
}
add_action('widgets_init', create_function('', 'return register_widget("PfondExpertFiltersWidget");'));

//====================================
//	Site Updates Widget
//====================================

class PfondSiteAdditionsWidget extends WP_Widget {
	
	function PfondSiteAdditionsWidget() {
		$widget_ops = array('description' => 'Site additions (currently only includes additions to \'About\' pages)');
		parent::WP_Widget(false, $name = 'Site Additions', $widget_ops);
	}
	
	function widget($args, $instance) {
	?>
		<div class="widget">
		
			<h3>Site Additions</h3>

			<?php
			global $wpdb;
			
			// get all updates made within the last X days
			$querystr = "
				SELECT wposts.*
				FROM $wpdb->posts wposts
				WHERE wposts.post_date > '" . date('Y-m-d', strtotime('-' . $instance['within_days'] . ' days')) . "'
				AND wposts.post_status = 'publish'
				AND wposts.post_type = 'disease_info'
				ORDER BY wposts.post_date DESC
				LIMIT " . $instance['num_updates'] . "
				";
				
			$pageposts = $wpdb->get_results($querystr, OBJECT);
			
			if ($pageposts):
				global $post; ?>
				
				<ul>
				<?php foreach ($pageposts as $post): setup_postdata($post); ?>
					<li><a href="<?php echo home_url('about/' . $topic . '/#post-' . get_the_ID()); ?>"><?php the_title(); ?></a> - Added <?php
						$modified_time = strtotime($post->post_date);
						$current_time = current_time('timestamp');
						if (($current_time - $modified_time) > 86400) {
							echo get_the_time('M j', get_the_ID());
						} else {
							echo human_time_diff($modified_time, $current_time) . ' ago';
						}
					?></li>
				<?php endforeach; ?>
				</ul>
			<?php else: ?>
			
				No recent additions!
			
			<?php endif; ?>
		
		</div>
	<?php
	}
	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		
		$instance['num_updates'] = $new_instance['num_updates'];
		$instance['within_days'] = $new_instance['within_days'];
		
		return $instance;
	}
	
	function form($instance) {
	?>
		<p>
			<label for="<?php echo $this->get_field_id('num_updates'); ?>"><?php _e('Number of updates to display'); ?>:&nbsp;</label>
			<select id="<?php echo $this->get_field_id('num_updates'); ?>" name="<?php echo $this->get_field_name('num_updates'); ?>">
				<?php for ($i = 1; $i <= 10; $i++): ?>
					<option value="<?php echo $i ?>" <?php
						if ($i == $instance["num_updates"]) {
							echo 'selected="selected"';
						}
					?>><?php echo $i ?></option>
				<?php endfor; ?>
			</select>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('within_days'); ?>"><?php _e('Show new posts within '); ?>&nbsp;</label>
			<select id="<?php echo $this->get_field_id('within_days'); ?>" name="<?php echo $this->get_field_name('within_days'); ?>">
				<?php for ($i = 10; $i <= 30; $i = $i + 5): ?>
					<option value="<?php echo $i ?>" <?php
						if ($i == $instance["within_days"]) {
							echo 'selected="selected"';
						}
					?>><?php echo $i ?>&nbsp;days</option>
				<?php endfor; ?>
			</select>
		</p>
	<?php
	}
}
add_action('widgets_init', create_function('', 'return register_widget("PfondSiteAdditionsWidget");'));

//====================================
//	Custom Settings
//====================================

function pfond_settings_init() {
	// add a section to the site's general settings
	add_settings_section('pfond_site_settings',
		'Site Settings',
		'pfond_disease_site_settings_callback',
		'general'
	);
	
	// add a 'site title' field & register it
	add_settings_field('pfond_site_title',
		'Custom Site Title',
		'pfond_site_title_callback',
		'general',
		'pfond_site_settings'
	);
	
	register_setting('general',
		'pfond_site_title',
		'pfond_site_title_sanitize_callback'
	);
	
	// add a 'disease name' field & register it
	add_settings_field('pfond_disease_name',
		'Disease Name',
		'pfond_disease_name_callback',
		'general',
		'pfond_site_settings'
	);
	
	register_setting('general',
		'pfond_disease_name',
		'pfond_disease_name_sanitize_callback'
	);
}
add_action('admin_init', 'pfond_settings_init');

function pfond_disease_site_settings_callback() {
	echo '<p>Custom settings for this PFOND site.</p>';
}

function pfond_site_title_callback() {
?>
	<input id="site-title" name="pfond_site_title" type="text" value="<?php echo get_option('pfond_site_title'); ?>" class="regular-text"/> <span class="description">Custom text to be displayed in the header. Defaults to 'Site Title' (above) if blank.</span>
<?php
}

function pfond_site_title_sanitize_callback($input) {
	return strtolower(trim($input));
}

function pfond_disease_name_callback() {
?>
	<input id="disease-name" name="pfond_disease_name" type="text" value="<?php echo get_option('pfond_disease_name'); ?>" class="regular-text"/> <span class="description">The name of this disease, e.g. 'Aniridia', for use across the site. Note: if this value is changed after site creation, the <strong>group settings</strong> for this disease may also have to be changed. Visit the Admin section of your group (see the <a href="<?php echo get_site_url(1) . '/' . BP_GROUPS_SLUG . '/' ?>">groups directory</a>).</span>
<?php
}

function pfond_disease_name_sanitize_callback($input) {
	$input = trim($input);
	$parts = split(' ', $input);
	if (count($parts) > 0) {
		$output = ucfirst(strtolower($parts[0]));
		for ($i = 1; $i < count($parts); $i++) {
			$output = $output . ' ' . ucfirst(strtolower($parts[$i]));
		}
	}
	return $output;
}

//====================================
//	New blog creation
//====================================

function pfond_create_group($blog_slug, $disease_name) {
	// create the group
	$group_id = groups_create_group(array(
		'name' => $disease_name,
		'description' => 'Discussions related to ' . strtolower($disease_name) . '.',
		'slug' => $blog_slug,
		'status' => 'public',
		'enable_forum' => 1,
		'date_created' => current_time('mysql')
	));
	
	// create the group forum
	$forum_id = bp_forums_new_forum(array(
		'forum_name' => $disease_name,
		'forum_desc' => 'Discussions related to ' . strtolower($disease_name) . '.'
	));
	
	// update groups metadata (so it shows up in the directory)
	groups_update_groupmeta( $group_id, 'total_member_count', 1 );
	groups_update_groupmeta( $group_id, 'last_activity', bp_core_current_time() );
	groups_update_groupmeta( $group_id, 'forum_id', $forum_id );
}

function pfond_new_blog($new_blog_id) {
	global $path;
	$path_parts = split('/', $path);
	$blog_slug = $path_parts[count($path_parts) - 2];
	
	// build disease name from either input or slug
	if (isset($_POST['disease_name']) && trim($_POST['disease_name']) != '') {
		// sanitize input
		$name_parts = split(' ', trim($_POST['disease_name']));
		$disease_name = ucfirst(strtolower($name_parts[0]));
		for ($i = 1; $i < count($name_parts); $i++) {
			$disease_name = $disease_name . ' ' . ucfirst(strtolower($name_parts[$i]));
		}
	} else {
		$disease_name = ucfirst($blog_slug);
	}
	
	// set the disease name setting
	switch_to_blog( $new_blog_id );
	
	delete_option('pfond_disease_name');
	add_option('pfond_disease_name', $disease_name);
	
	restore_current_blog();
	
	// create new Buddypress group for this blog
	pfond_create_group($blog_slug, $disease_name);
}
add_action( 'wpmu_new_blog', 'pfond_new_blog', 20 );

function pfond_signup_form() {
?>
	<label for="disease_name">Disease Name:</label>
	<input type="text" id="disease_name" name="disease_name" />
<?php
}
add_action( 'signup_blogform', 'pfond_signup_form', 5 );

/*
function pfond_after_signup() {
}
add_action( 'signup_finished', 'pfond_after_signup' );*/

//====================================
//	Other actions
//====================================

// redirects subscribers to the site homepage (rather than the dashboard, which is disabled for them)
function pfond_redirect( $redirect_to, $requested_redirect_to, $user ) {
	$interim_login = isset( $_REQUEST['interim-login'] );
	$reauth = empty( $_REQUEST['reauth'] ) ? false : true;
	
	if ( !is_wp_error( $user ) && !$reauth && !$interim_login && !empty( $login_redirect_url ) && in_array('subscriber', $user->roles) ) {
		$redirect_to = site_url();
	}

	return $redirect_to;
}
add_filter( 'login_redirect', 'pfond_redirect', 10, 3 );

// removes the 'author' role to clear confusion
function pfond_remove_unused_roles() {
	remove_role('author');
}
add_action( 'admin_init', 'pfond_remove_unused_roles' );

// restrict the wp-admin backend to admins and editors ONLY
// subscribers can edit their profiles using BP's frontend
function pfond_restrict_admin() {
	global $current_user;
	get_currentuserinfo();

	// if not admin, die with message
	if (!in_array('administrator', $current_user->roles) &&
		!in_array('editor', $current_user->roles)) {
		wp_die( __('Sorry, you are not allowed to access this part of the site.<br /><br /><a href="' . get_site_url(1) . '">Return to PFOND home.</a>') );
	}
}
add_action( 'admin_init', 'pfond_restrict_admin', 1 );

function pfond_add_custom_header_support() {
	// Set the defaults for the custom header image
	define( 'NO_HEADER_TEXT', true );
	define( 'HEADER_TEXTCOLOR', '' );
	define( 'HEADER_IMAGE', get_bloginfo('stylesheet_directory') . '/_includes/images/default_header.jpg' ); // %s is theme dir uri
	define( 'HEADER_IMAGE_WIDTH', 930 );
	define( 'HEADER_IMAGE_HEIGHT', 250 );

	function header_style() { ?>
		<style type="text/css">
			#frontpage-logo {
				position: relative;
				background: url(<?php header_image() ?>);
				width: 930px; height: 250px;
				box-shadow: 0px 0px 10px rgba(0,0,0,0.4);
				-moz-box-shadow: 0px 0px 10px rgba(0,0,0,0.4);
				-webkit-box-shadow: 0px 0px 10px rgba(0,0,0,0.4);
			}
		</style>
	<?php
	}

	function admin_header_style() { ?>
		<style type="text/css">
			#headimg {
				background: url(<?php header_image() ?>);
			}
		</style>
	<?php
	}
	
	add_custom_image_header( 'header_style', 'admin_header_style' );
}
add_action( 'init', 'pfond_add_custom_header_support' );

//====================================
//	Anysearch functionality
//====================================

// Remove Buddypress search drowpdown for selecting members etc
add_filter("bp_search_form_type_select", "bpmag_remove_search_dropdown"  );
function bpmag_remove_search_dropdown($select_html) {
    return '';
}

remove_action( 'init', 'bp_core_action_search_site', 5 ); // force buddypress to not process the search/redirect
add_action( 'init', 'bp_buddydev_search', 10 ); // custom handler for the search

function bp_buddydev_search() {
	global $bp;
	if ( $bp->current_component == BP_SEARCH_SLUG )// if this is search page
		bp_core_load_template( apply_filters( 'bp_core_template_search_template', 'search-single' ) ); // load the single search template
}
add_action("advance-search","bpmag_show_search_results",1); // highest priority

// we just need to filter the query and change search_term=The search text
function bpmag_show_search_results() {
    // filter the ajaxquerystring
	add_filter("bp_ajax_querystring","bpmag_global_search_qs",100,2);
}

//show the search results for member
function bpmag_show_member_search() {
?>
	<div class="members-search-result search-result">
		<h3 class="content-title"><?php _e("Members Results","bpmag");?></h3>
		<?php locate_template( array( 'members/members-loop.php' ), true ) ;  ?>
		<?php global $members_template;
		if($members_template->total_member_count>1):?>
			<a href="<?php echo bp_get_root_domain().'/'.BP_MEMBERS_SLUG.'/?s='.$_REQUEST['mssearch']?>" ><?php _e(sprintf("View all %d matched Members",$members_template->total_member_count),"bpmag");?></a>
		<?php endif; ?>
	</div>
<?php
}

// Hook Member results to search page
add_action("advance-search","bpmag_show_member_search",10); // the priority defines where in page this result will show up(the order of member search in other searchs)

function bpmag_show_groups_search() {
?>
	<div class="groups-search-result search-result">
		<h3 class="content-title"><?php _e("Group Results","bpmag");?></h3>
		<?php locate_template( array('groups/groups-loop.php' ), true ) ;  ?>
		
		<a href="<?php echo bp_get_root_domain().'/'.BP_GROUPS_SLUG.'/?s='.$_REQUEST['mssearch']?>" ><?php _e("View All matched Groups","bpmag");?></a>
	</div>
<?php
}

// Hook Groups results to search page
if(bp_is_active('groups'))
    add_action("advance-search","bpmag_show_groups_search",10);

/*
// Show blog posts in search
function bpmag_show_site_blog_search() {
?>
	<div class="blog-search-result search-result">	 
		<h3 class="content-title"><?php _e("Post Results","bpmag");?></h3>
		<?php locate_template( array( 'search-loop.php' ), true ) ;  ?>
		<a href="<?php echo bp_get_root_domain().'/?s='.$_REQUEST['mssearch']?>" ><?php _e("View All matched Posts","bpmag");?></a>
	</div>
<?php
}

// Hook Blog Post results to search page
add_action("advance-search","bpmag_show_site_blog_search", 10);
*/

//show forums search
function bpmag_show_forums_search(){
?>
	<div class="forums-search-result search-result">
		<h3 class="content-title"><?php _e("Forums Search","bpmag");?></h3>
		<?php locate_template( array( 'forums/forums-loop.php' ), true ) ;  ?>
		<a href="<?php echo bp_get_root_domain().'/'.BP_FORUMS_SLUG.'/?s='.$_REQUEST['mssearch']?>" ><?php _e("View All matched forum posts","bpmag");?></a>
	</div>
<?php
}

// Hook Forums results to search page
if ( bp_is_active( 'forums' ) && bp_is_active( 'groups' ) && ( function_exists( 'bp_forums_is_installed_correctly' ) && !(int) bp_get_option( 'bp-disable-forum-directory' ) ) && bp_forums_is_installed_correctly() )
	add_action("advance-search","bpmag_show_forums_search",20);
	
/*!(int) bp_get_option( 'bp-disable-forum-directory' ) ) &&*/ 

//show blogs search result
function bpmag_show_blogs_search() {
?>
	<div class="blogs-search-result search-result">
		<h3 class="content-title"><?php _e("Blog Results","bpmag");?></h3>
		<?php locate_template( array( 'blogs/blogs-loop.php' ), true ) ;  ?>
		<a href="<?php echo bp_get_root_domain().'/'.BP_BLOGS_SLUG.'/?s='.$_REQUEST['mssearch']?>" ><?php _e("View All matched Blogs","bpmag");?></a>
	</div>
<?php
}

// Hook Blogs results to search page if blogs comonent is active
if(bp_is_active( 'blogs' ))
    add_action("advance-search","bpmag_show_blogs_search", 10);

// modify the query string with the search term
function bpmag_global_search_qs() {
	return "search_terms=".$_REQUEST['mssearch'];
}

function bpmag_is_advance_search() {
	global $bp;
	if($bp->current_component == BP_SEARCH_SLUG)
		return true;
	return false;
}

?>