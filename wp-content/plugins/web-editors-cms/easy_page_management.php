<?php
/**
* easily edit pages from admin menu
* 
*/
function WE_page_management_dropdown() {
    global $submenu, $wpdb;
    $pages = $wpdb->get_results("SELECT ID, post_title, post_parent FROM $wpdb->posts WHERE post_type = 'page' AND post_status = 'publish' ORDER BY menu_order ASC, post_title ASC");
    $indexed_pages = get_page_hierarchy($pages);
    foreach ($pages as $page)
    {
        $indexed_pages[$page->ID] = $page;
    }
    foreach ($indexed_pages as $page)
    {
        $indent = '';
        $parent = $page->post_parent;
        while ($parent != 0)
        {
            $indent .= '&nbsp; - ';
            $parent = $indexed_pages[$parent]->post_parent;
        }
        $submenu['edit.php?post_type=page'][] = array($indent.$page->post_title, 'edit_pages', 'post.php?action=edit&post='.$page->ID);
    }
}
add_action('admin_menu', 'WE_page_management_dropdown');