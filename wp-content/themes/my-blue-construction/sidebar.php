<ul>

  <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>

    <?php
    global $notfound;
    if (is_page() and ($notfound != '1')) {
        $current_page = $post->ID;
        while($current_page) {
            $page_query = $wpdb->get_row("SELECT ID, post_title, post_status, post_parent FROM $wpdb->posts WHERE ID = '$current_page'");
            $current_page = $page_query->post_parent;
        }
        $parent_id = $page_query->ID;
        $parent_title = $page_query->post_title;
	?>
	
	
	<?php
        // if ($wpdb->get_results("SELECT * FROM $wpdb->posts WHERE post_parent = '$parent_id' AND post_status != 'attachment'")) {
        if ($wpdb->get_results("SELECT * FROM $wpdb->posts WHERE post_parent = '$parent_id' AND post_type != 'attachment'")) {
    ?>

    <?php } } ?>
	
	<li  style="border:none; margin:0px 0px 20px 0px">
      <ul class="search-form">
		<li>
        <?php get_search_form(); ?>
		</li>
      </ul>
    </li>
		<?php wp_list_categories('sort_column=name&optioncount=1&hierarchical=0&title_li=<h2 class="sidebartitle">' . __('Categories') . '</h2>'); ?>
    <li class="widget">
      <h2 class="sidebartitle"><?php _e('Archives'); ?></h2>
      <ul class="list-archives">
        <?php wp_get_archives('type=monthly'); ?>
      </ul>
    </li>
    <li class="widget">
      <h2 class="sidebartitle"><?php _e('Links'); ?></h2>
      <ul class="list-blogroll">
        <?php 
			$links = get_bookmarks('orderby=name&order=ASC&limit=-1'); 
			foreach($links as $link){
				echo '<li><a href="'.$link -> link_url.'">'.$link -> link_name.'</a></li>';
			}
		?>
      </ul>
    </li>
	<li class="widget">
      <h2 class="sidebartitle">Meta</h2>
      <ul class="list-meta">
		<li><a href="<?php bloginfo('rss2_url'); ?>" title="<?php _e('Syndicate this site using RSS'); ?>"><?php _e('<abbr title="Really Simple Syndication">RSS</abbr>'); ?></a></li>
		<li><a href="<?php bloginfo('comments_rss2_url'); ?>" title="<?php _e('The latest comments to all posts in RSS'); ?>"><?php _e('Comments <abbr title="Really Simple Syndication">RSS</abbr>'); ?></a></li>
		<li><a href="http://mythem.es/" title="mythem.es">My Themes</a></li>
		<?php wp_meta(); ?>
      </ul>
    </li>

  <?php endif; ?>
  
 </ul>
<!--/sidebar -->