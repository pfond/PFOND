<?php
/**
* added permalinks shortcode into our WordPress 
* 
*/
function WE_permalink_shortcode($atts) {
    extract(shortcode_atts(array(
        'id' => 1,
        'text' => ""  // default value if none supplied
    ), $atts));
 
    if ($text) {
        $url = get_permalink($id);
        return "<a href='$url'>$text</a>";
    } else {
       return get_permalink($id);
    }
}
add_shortcode('permalink', 'WE_permalink_shortcode');