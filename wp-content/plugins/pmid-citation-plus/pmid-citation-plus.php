<?php
/*
Plugin Name: PMID Citation Plus
Plugin URI: http://www.mdpatrick.com/pmidcitationplus/
Version: 1.0
Author: Dan Patrick
Description: This plugin makes citing scientific studies in an aesthetically pleasing manner much more easy. It allows you to simply enter in Pubmed IDs and have a references list automatically built for you. At the moment it only supports PMIDs, but in the future will also support citation via DOI.
*/

// Grabs pubmed page from URL, pulls into string, parses out an array with: title, journal, issue, authors, institution.

function scrape_pmid_abstract($pubmedid) {
	$pubmedpage = file_get_contents('http://www.ncbi.nlm.nih.gov/pubmed/' . $pubmedid);
	preg_match('/<div class="cit">(?P<journal>.*?)<\/a>(?P<issue>.*?\.).*?<\/div><h1>(?P<title>.+)<\/h1><div class="auths">(?P<authors>.+)<\/div><div class="aff"><h3.*Source<\/h3><p>(?P<institution>.*?)<\/p>/', $pubmedpage, $matches);
	$abstract = array(
			'authors' => strip_tags($matches['authors']), 
			'title' => $matches['title'], 
			'institution' => $matches['institution'], 
			'journal' => strip_tags($matches['journal']), 
			'issue' => trim($matches['issue']), 
			'pmid' => $pubmedid, 
			'url' => 'http://www.ncbi.nlm.nih.gov/pubmed/'.$pubmedid
			);
	return $abstract;
}

// Takes a comma separated list, like the one constructed from build_simple_pmid_string, and creates a multi-dimensional array of all of the information produced by the scrape_pmid_abstract.
function process_pmid_input($fieldinput) {
	$pmidarray = preg_split("/[\s,]+/", $fieldinput, null, PREG_SPLIT_NO_EMPTY);
	foreach($pmidarray as &$pmid) {
		$pmid = scrape_pmid_abstract($pmid);
	}
	return $pmidarray;
}

// Takes the processed input -- an array -- and builds a comma separated listed of PMIDs from it.
function build_simple_pmid_string($processedarray) {
    if(is_array($processedarray)) { 
        foreach($processedarray as &$citation) {
            $citation = $citation['pmid'];
            }
        $processedarray = implode(", ", $processedarray);
        return $processedarray;
        }
    else {
        return false;
    }
}

// Takes an array, like that built from process_pmid_input, and returns it as a string.
function build_references_html($processedarray) {
	ob_start();
        ?>
	<div class="pmidcitationplus">
	<h1>References</h1>
	<ul>
	<?php
	foreach($processedarray as $singlecitation) {
		echo "<li>";
		echo "{$singlecitation['authors']} {$singlecitation['title']} {$singlecitation['journal']} {$singlecitation['issue']} ".'PMID: '.'<a href="'.$singlecitation['url'].'">'.$singlecitation['pmid'].'</a>.';
		echo "</li>";
	}
	?></ul></div>
	<?php
        return ob_get_clean();
}
// Called to fill the new meta box about to be created.
function pmidplus_input_fields() {
	global $post;
        wp_nonce_field( plugin_basename(__FILE__), 'pmidplus_nonce' );
	//var_dump(get_post_meta($post->ID, '_pcp_article_sources', true));echo "<br /><br />";
	// The actual fields for data entry
	echo '<label for="pmidinput">Comma separated list of PMIDs</label>';
	echo '<input type="text" id="pmidinput" name="pmidinput" value="' . build_simple_pmid_string(get_post_meta($post->ID, '_pcp_article_sources', true)) . '" size="45" />';
}

//SYNTAX: add_meta_box( $id, $title, $callback, $page, $context, $priority, $callback_args ); 
function pmidplus_add_meta() {
	add_meta_box("pmidplusmeta", "PMID Citation Plus", "pmidplus_input_fields", "post", "side", "high", $post);
	add_meta_box("pmidplusmeta", "PMID Citation Plus", "pmidplus_input_fields", "page", "side", "high", $post);
}
add_action('admin_init', 'pmidplus_add_meta');


function pmidplus_save_postdata( $post_id ) {

  // Make sure save is intentional, not just autosave. 
  if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
      return $post_id;

  // Verify this came from the our screen and with proper authorization
  if ( !wp_verify_nonce( $_POST['pmidplus_nonce'], plugin_basename(__FILE__) ) )
      return $post_id;
  
  // Check permissions
  if ( 'page' == $_POST['post_type'] ) 
  {
    if ( !current_user_can( 'edit_page', $post_id ) )
        return $post_id;
  }
  else
  {
    if ( !current_user_can( 'edit_post', $post_id ) )
        return $post_id;
  }
	   
// So far so good. Now we need to save the data. Only do it if the field doesn't match.
	if (empty($_POST['pmidinput'])) {
		delete_post_meta($post_id, '_pcp_article_sources');
		}
	elseif (build_simple_pmid_string(get_post_meta($post_id, '_pcp_article_sources', true)) != $_POST['pmidinput'] && $_POST['wp-preview'] != 'dopreview') {
	// Take the form input, scrape the info from the pubmed pages, output multidimensional array, and save update.
		$neverusedbefore = process_pmid_input($_POST['pmidinput']);
		if(!update_post_meta($post_id, '_pcp_article_sources', $neverusedbefore)) {
			die('Unable to post pmid citation plus update to meta.');
		}
	}
} 

// Execute save function on save.
add_action('save_post', 'pmidplus_save_postdata');

// Adds references to the bottom of posts
function addsometext($contentofpost) {
	global $post;
	if(get_post_meta($post->ID, '_pcp_article_sources', true))
		$contentofpost .= build_references_html(get_post_meta($post->ID, '_pcp_article_sources', true));
	return $contentofpost;
}
add_filter('the_content', 'addsometext', 9);

// Future shortcode implementation in the works
/*
function shortcode_citation( $atts ) {
	if(array_key_exists('pmid', $atts)) {
		$pmids = explode(",", $atts['pmid']);
		}
			
		$intext	= "[HI]"; 
	}
	else {
		return "ELSE FALSE ". print_r($atts);
	}
}
add_shortcode( 'pmidplus', 'shortcode_cite' );
*/
// [pmiudplus pmid="815460, 817050"]
?>
