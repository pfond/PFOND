<?php
/*
Plugin Name: Glossary
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: Instantly adds links to your posts and pages based on a glossary of definitions
Version: 0.9
Author: Robinson Duffy
*/

/*  Copyright 2009  Robinson Duffy  (email : robinson.duffy@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

//Add options needed for plugin

	add_option('red_glossaryOnlySingle', 0); //Show on Home and Category Pages or just single post pages?
	if(get_option('red_glossaryOnlySingle') != 0 && get_option('red_glossaryOnlySingle') != 1){
		update_option('red_glossaryOnlySingle', 0);
	}
	add_option('red_glossaryOnPages', 1); //Show on Pages or just posts?
	if(get_option('red_glossaryOnPages') != 0 && get_option('red_glossaryOnPages') != 1){
		update_option('red_glossaryOnPages', 1);
	}
	add_option('red_glossaryID', 0); //The ID of the main Glossary Page


//Function parses through post entries and replaces any found glossary terms with links to glossary term page.

function red_glossary_parse($content){
	$glossaryPageID = get_option('red_glossaryID');
	if (((!is_page() && get_option('red_glossaryOnlySingle') == 0) OR 
	(!is_page() && get_option('red_glossaryOnlySingle') == 1 && is_single()) OR 
	(is_page() && get_option('red_glossaryOnPages') == 1)) AND 
	get_option('red_glossaryID') != 0 AND 
	!is_page(get_option('red_glossaryID'))){
		$glossary_index = get_children(array(
											'post_parent'	=> $glossaryPageID,
											'post_type'		=> 'page',
											'post_status'	=> 'publish',
											));
		if ($glossary_index){
			foreach($glossary_index as $glossary_item){
				$timestamp = time();
				$glossary_search = '/\b'.$glossary_item->post_title.'[A-Za-z]*?\b/i';
				//echo $glossary_search;
				//$glossary_replace = '<a id="$timestamp" class="glossaryLink" href="' . $glossary_item->guid . '" title="Glossary: '. $glossary_item->post_title . '">$0</a>';
				$glossary_replace = '<a'.$timestamp.'>$0</a'.$timestamp.'>';
				$content_temp = preg_replace($glossary_search, $glossary_replace, $content);
				$content_temp = rtrim($content_temp);
				$content_temp = "<glossarycode>".$content_temp."</glossarycode>";
				//echo "~~".$content_temp."~~";
				
				
				//Make sure there are no nested links
				/* PHP 4
				$dom = new DOMDocument($content_temp); 
				//$dom->loadHTML($content_temp);
				//$dom->preserveWhiteSpace = false; 
				$newLink = $dom->get_elements_by_tagname('a'.$timestamp);
				//echo $newLink[0]->tagname;
				foreach ($newLink as $linkcheck){
					$currentNode = $linkcheck->parent_node();
					$endloop = false;
					$nestedlink = false;
					while(!$endloop){
						if ($currentNode->tagname == 'code'){
							$endloop = true;
						}
						if ($currentNode->tagname == 'a'){
							$linkcheck->set_attribute('delete','yes');
							$content_temp = $dom->dump_mem();
							$nestedlink = true;			
						}
						$currentNode = $currentNode->parent_node();
						
					}
					$link_search = '/<a'.$timestamp.'>('.$glossary_item->post_title.'[A-Za-z]*?)<\/a'.$timestamp.'>/i';
					//echo $link_search."<br>";
					$link_replace = '<a class="glossaryLink" href="' . $glossary_item->guid . '" title="Glossary: '. $glossary_item->post_title . '">$1</a>';
					//echo $link_replace."<br>";
					$content_temp = preg_replace($link_search, $link_replace, $content_temp);
					$delete_search = '/<a'.$timestamp.' delete="yes">/i';
					$delete_replace = '';
					$content_temp = preg_replace($delete_search, $delete_replace, $content_temp);
					$delete_search = '/<\/a'.$timestamp.'>/i';
					$delete_replace = '';
					$content_temp = preg_replace($delete_search, $delete_replace, $content_temp);
					$delete_search = '/<code>/i';
					$delete_replace = '';
					$content_temp = preg_replace($delete_search, $delete_replace, $content_temp);
					$delete_search = '/<\/code>/i';
					$delete_replace = '';
					$content_temp = preg_replace($delete_search, $delete_replace, $content_temp);
					$content = $content_temp;
					
				}
				*/
				
				
				// PHP 5
				$dom = new DOMDocument(); 
				$dom->loadXML($content_temp);
				$dom->preserveWhiteSpace = false; 
				$newLink = $dom->getElementsByTagname('a'.$timestamp);
				//echo $newLink->tagname;
				$nodeArray = array();
				for ($i = 0; $i < $newLink->length; ++$i) {
        			$nodeArray[] = $newLink->item($i);
   				 }
				foreach ($nodeArray as $linkcheck){
					//echo $linkcheck->nodeName;
					$currentNode = $linkcheck->parentNode;
					$endloop = false;
					$nestedlink = false;
					while(!$endloop){
						if ($currentNode->nodeName == 'glossarycode'){
							$endloop = true;
						}
						if ($currentNode->nodeName == 'a'){
							$dom->createAttribute('delete');
							$linkcheck->setAttribute('delete', 'yes');
							//$linkcheck->set_attribute('delete','yes');
							$content_temp = $dom->saveHTML();
							$nestedlink = true;	
									
						}
						$currentNode = $currentNode->parentNode;
						
					}
					
					$link_search = '/<a'.$timestamp.'>('.$glossary_item->post_title.'[A-Za-z]*?)<\/a'.$timestamp.'>/i';
					//echo $link_search."<br>";
					$link_replace = '<a class="glossaryLink" href="' . $glossary_item->guid . '" title="Glossary: '. $glossary_item->post_title . '">$1</a>';
					//echo $link_replace."<br>";
					$content_temp = preg_replace($link_search, $link_replace, $content_temp);
					$delete_search = '/<a'.$timestamp.' delete="yes">/i';
					$delete_replace = '';
					$content_temp = preg_replace($delete_search, $delete_replace, $content_temp);
					$delete_search = '/<\/a'.$timestamp.'>/i';
					$delete_replace = '';
					$content_temp = preg_replace($delete_search, $delete_replace, $content_temp);
					$delete_search = '/<code>/i';
					$delete_replace = '';
					$content_temp = preg_replace($delete_search, $delete_replace, $content_temp);
					$delete_search = '/<\/code>/i';
					$delete_replace = '';
					$content_temp = preg_replace($delete_search, $delete_replace, $content_temp);
					$content = $content_temp;
					
				}
				//END PHP 5


								 
				
			}
		}
	}
	return $content;
}


//Make sure parser runs before the post or page content is outputted
add_filter('the_content', 'red_glossary_parse');

//create the actual glossary

function red_glossary_createList($content){
	$glossaryPageID = get_option('red_glossaryID');
	if (is_page($glossaryPageID)){
		$glossary_index = get_children(array(
											'post_parent'	=> $glossaryPageID,
											'post_type'		=> 'page',
											'post_status'	=> 'publish',
											));
		if ($glossary_index){
			$content .= '<div id="glossaryList">';
			foreach($glossary_index as $glossary_item){
				$content .= '<p><a href="' . $glossary_item->guid . '">'. $glossary_item->post_title . '</a></p>';
			}
			$content .= '</div>';
		}
	}
	return $content;
}

add_filter('the_content', 'red_glossary_createList');


//admin page user interface
add_action('admin_menu', 'glossary_menu');

function glossary_menu() {
  add_options_page('Glossary Options', 'Glossary', 8, __FILE__, 'glossary_options');
}

function glossary_options() {
	?>
  	<div class="wrap">
	<h2>Glossary</h2>

	<form method="post" action="options.php">
	<?php wp_nonce_field('update-options'); ?>

	<table class="form-table">
	
		<tr valign="top">
		<th scope="row">ID of Main Glossary Page</th>
		<td><input type="text" name="red_glossaryID" value="<?php echo get_option('red_glossaryID'); ?>" /></td>
		</tr>
		
	<tr valign="top">
	<th scope="row">Only show glossary on single pages (0=No | 1=Yes)</th>
	<td><input type="text" name="red_glossaryOnlySingle" value="<?php echo get_option('red_glossaryOnlySingle'); ?>" /></td>
	</tr>
	
	<tr valign="top">
	<th scope="row">Show on Pages? (0=No | 1=Yes)</th>
	<td><input type="text" name="red_glossaryOnPages" value="<?php echo get_option('red_glossaryOnPages'); ?>" /></td>
	</tr>

	</table>

	<input type="hidden" name="action" value="update" />
	<input type="hidden" name="page_options" value="red_glossaryID,red_glossaryOnlySingle,red_glossaryOnPages" />

	<p class="submit">
	<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
	</p>

	</form>
	</div>
	<?php 
}
?>