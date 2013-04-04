<?php
/*
Plugin Name: ThumbSniper
Plugin URI: http://www.mynakedgirlfriend.de/wordpress/thumbsniper/
Description: This plugin dynamically shows preview screenshots of hyperlinks as tooltips on your WordPress site.
Author: Thomas Schulte
Version: 0.9.9
Author URI: http://www.mynakedgirlfriend.de

Copyright (C) 2011 Thomas Schulte

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

$thumbsniper_current_version = "0.9.9";

$thumbsniper_version = get_option('thumbsniper_version');
if($thumbsniper_version == '' || $thumbsniper_version != $thumbsniper_current_version) {
	update_option('thumbsniper_version', $thumbsniper_current_version, 'Version of the plugin ThumbSniper', 'yes');
	update_option('thumbsniper_showfooter','yes');
}

$thumbsniper_preview = get_option('thumbsniper_preview');
if($thumbsniper_preview == '') {
	update_option('thumbsniper_preview','all');
}

$thumbsniper_showfooter = get_option('thumbsniper_showfooter');
if($thumbsniper_showfooter == '') {
	update_option('thumbsniper_showfooter','yes');
}

$thumbsniper_scaling = get_option('thumbsniper_scaling');
if($thumbsniper_scaling == '') {
	update_option('thumbsniper_scaling','4');
}

$thumbsniper_opacity = get_option('thumbsniper_opacity'); 
if($thumbsniper_opacity == '') {
	update_option('thumbsniper_opacity','0.9');
}

$thumbsniper_code_placement = get_option('thumbsniper_code_placement');
if($thumbsniper_code_placement == '') {
	update_option('thumbsniper_code_placement','footer');
}

$thumbsniper_excluded_urls = get_option('thumbsniper_excluded_urls');
if($thumbsniper_excluded_urls == '') {
	update_option('thumbsniper_excluded_urls','');
}

$thumbsniper_bgcolor = get_option('thumbsniper_bgcolor');
if($thumbsniper_bgcolor == '') {
	update_option('thumbsniper_bgcolor','jtools');
}


/* actions */
add_action( 'admin_menu', 'thumbsniper_options_page' ); // add option page
add_action('plugins_loaded', 'thumbsniper_add_plugin');


function thumbsniper_add_plugin() {

	// Source: http://www.wprecipes.com/how-to-use-jquery-1-4-by-default-on-your-wordpress-blog
	if(!is_admin()){
		wp_deregister_script('jquery');
		wp_register_script('jquery', (plugins_url("jquery/jquery-1.6.4.min.js", __FILE__)), false, '');
	}

	// Source: http://digwp.com/2009/06/including-jquery-in-wordpress-the-right-way/
	wp_enqueue_script('jquery');
	wp_enqueue_script('qtip', plugins_url('qtip/jquery.qtip.min.js', __FILE__), array('jquery'), false, true);

	add_action('wp_head', 'thumbsniper_styles');

	$code_placement = get_option('thumbsniper_code_placement');

	if($code_placement == "head") {
		add_action('wp_head', 'thumbsniper_scripts');
	}else {
		add_action('wp_footer', 'thumbsniper_scripts');
	}
	if(get_option('thumbsniper_showfooter') == 'yes') {
		add_action('wp_footer', 'thumbsniper_about');
	}
}

  
/* add option page */
function thumbsniper_options_page() {
	if(function_exists('add_options_page')){
		add_options_page('ThumbSniper','ThumbSniper',8,'thumbsniper','thumbsniper_options');
	}
}


/* the real option page */
function thumbsniper_options(){
	if(isset($_POST['thumbsniper_options_update'])) {
		$preview = $_POST['preview'];
    		$showfooter = $_POST['showfooter'];
		$scaling = $_POST['scaling'];
		$opacity = $_POST['opacity'];
		$code_placement = $_POST['code_placement'];
		$include_pages = $_POST['include_pages'];
		$excluded_urls = $_POST['excluded_urls'];
		$bgcolor = $_POST['bgcolor'];

		if($preview == 'all') {
			update_option('thumbsniper_preview','all');
		}elseif($preview == 'marked') {
			update_option('thumbsniper_preview','marked');
		}elseif($preview == 'external') {
			update_option('thumbsniper_preview','external');
		}

		if($showfooter == 'yes') {
			update_option('thumbsniper_showfooter','yes');
		}else {
			update_option('thumbsniper_showfooter','no');
		}

		if(in_array($scaling, array("2", "3", "4", "5", "6", "7", "8"))) {
			update_option('thumbsniper_scaling',$scaling);
		}

		if(is_numeric($opacity)) {
			update_option('thumbsniper_opacity',$opacity);
		}

		if(in_array($code_placement, array("head", "footer"))) {
			update_option('thumbsniper_code_placement',$code_placement);
		}

		//FIXME: validation missing; overwrite even if empty
		update_option('thumbsniper_include_pages',$include_pages);

		//FIXME: validation missing
		update_option('thumbsniper_excluded_urls',$excluded_urls);

		if(in_array($bgcolor, array("blue", "red", "green", "light", "dark", "cream", "youtube", "jtools", "cluetip", "tipped", "tipsy"))) {
			update_option('thumbsniper_bgcolor',$bgcolor);
		}

		echo('<div id="message" class="updated fade"><p><strong>Your options were saved.</strong></p></div>');
	}

	$preview = get_option('thumbsniper_preview');
	$showfooter = get_option('thumbsniper_showfooter');
	$scaling = get_option('thumbsniper_scaling');
	$opacity = get_option('thumbsniper_opacity');
	$code_placement = get_option('thumbsniper_code_placement');
	$include_pages = get_option('thumbsniper_include_pages');
	$excluded_urls = get_option('thumbsniper_excluded_urls');
	$bgcolor = get_option('thumbsniper_bgcolor');
  
	echo('<div class="wrap">');
	echo('<form method="post" accept-charset="utf-8">');
    
	echo('<h2>ThumbSniper Options</h2>');
	echo('<ol>');
	echo('<li>Tooltips can be used for three types of hyperlinks. "All" just means all links that exist on a page and "external" hides the thumbshots for internal links.</li>');
	echo('<li>Using the option value "marked" means, that the tooltip-thumbshots are only shown if a link has a style class named "thumbsniper".</li>');
	echo('<li>You may additionally use the CSS class "nothumbsniper" to explicitly disable the preview tooltip for single hyperlinks when using the preview types "all" or "external".</li>');
	echo('<li>The opacity may be set according your needs. I prefer using "0.1", "0.2"... up to "1" to adjust the opacity.</li>');
	echo('<li>The option "code placement" defines the place where the plugin javascript is integrated. The default is "footer" but it\'s also possible to put the code in the HTML header section of your page by choosing "head"</li>');
	echo('<li>While in "external" or "all" mode, you can limit the plugin to explicitly defined pages with the option "include pages". Just leave it empty to ignore this feature.</li>');
	echo('<li>Use the "excluded URLs" option to define (yes, you guessed it already) excluded URLs. These URLs have to be separated by semicolons and must be used full-qualified, so you have to start each URL with "http://". Hyperlink-exclude-matching is done from left to right, which means that the excluded URL "http://www.google" matches all "http://www.google*" URLs. "http://www.google.com/useless-stuff/" matches "http://www.google.com/useless-stuff/*" and so on. This is - at the moment - a very rough implementation and works only with the preview types "all" or "external". Please tell me about your results with this.</li>');
	echo('</ol>');
	echo('<p>Your feedback should go here: <a href="http://www.mynakedgirlfriend.de/wordpress/thumbsniper/">http://www.mynakedgirlfriend.de/wordpress/thumbsniper/</a></p>');
	echo('<br>');
	echo('
		<h3>Settings</h3>
		<table>
			<tr>
				<td>tooltip preview type:&nbsp;</td>
				<td>
					<select name="preview" id="preview">
						<option value="all" label="all"'); if ($preview == 'all') echo(' selected=selected'); echo('>all</option>
						<option value="external" label="external"'); if ($preview == 'external') echo(' selected=selected'); echo('>external</option>
						<option value="marked" label="marked"'); if ($preview == 'marked') echo(' selected=selected'); echo('>marked</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>tooltip preview size:&nbsp;</td>
				<td>
					<select name="scaling" id="scaling">
						<option value="2"'); if ($scaling == '2') echo(' selected=selected'); echo('>365 x 461</option>
						<option value="3"'); if ($scaling == '3') echo(' selected=selected'); echo('>242 x 306</option>
						<option value="4"'); if ($scaling == '4') echo(' selected=selected'); echo('>182 x 230</option>
						<option value="5"'); if ($scaling == '5') echo(' selected=selected'); echo('>146 x 184</option>
						<option value="6"'); if ($scaling == '6') echo(' selected=selected'); echo('>121 x 153</option>
						<option value="7"'); if ($scaling == '7') echo(' selected=selected'); echo('>104 x 131</option>
						<option value="8"'); if ($scaling == '8') echo(' selected=selected'); echo('>91 x 115</option>
					</select> Pixel
				</td>
			</tr>
			<tr>
				<td>tooltip opacity:&nbsp;</td>
				<td>
					<input type="text" size="3" maxlength="3" name="opacity" value="' . $opacity . '">
				</td>
			</tr>
			<tr>
				<td>code placement:&nbsp;</td>
				<td>
					<select name="code_placement" id="code_placement">
						<option value="head" label="head"'); if ($code_placement == 'head') echo(' selected=selected'); echo('>head</option>
						<option value="footer" label="footer"'); if ($code_placement == 'footer') echo(' selected=selected'); echo('>footer</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>include page ID\'s:&nbsp;</td>
				<td>
					<input type="text" size="20" name="include_pages" value ="' . $include_pages . '"> (separate with whitespaces - keep field empty to include all)
				</td>
			</tr>
			<tr>
				<td>excluded URL\'s:&nbsp;</td>
				<td>
					<input type="text" size="50" name="excluded_urls" value ="' . $excluded_urls . '"> (separate with semicolons - keep field empty to skip this functionality)
				</td>
			</tr>
			<tr>
				<td>Background style:&nbsp;</td>
				<td>
					<select name="bgcolor" id="bgcolor">
						<option value="blue" label="blue"'); if ($bgcolor == 'blue') echo(' selected=selected'); echo('>blue</option>
						<option value="red" label="red"'); if ($bgcolor == 'red') echo(' selected=selected'); echo('>red</option>
						<option value="green" label="green"'); if ($bgcolor == 'green') echo(' selected=selected'); echo('>green</option>
						<option value="light" label="light"'); if ($bgcolor == 'light') echo(' selected=selected'); echo('>light</option>
						<option value="dark" label="dark"'); if ($bgcolor == 'dark') echo(' selected=selected'); echo('>dark</option>
						<option value="cream" label="cream"'); if ($bgcolor == 'cream') echo(' selected=selected'); echo('>cream</option>

						<option value="youtube" label="youtube"'); if ($bgcolor == 'youtube') echo(' selected=selected'); echo('>youtube</option>
						<option value="jtools" label="jtools"'); if ($bgcolor == 'jtools') echo(' selected=selected'); echo('>jtools</option>
						<option value="cluetip" label="cluetip"'); if ($bgcolor == 'cluetip') echo(' selected=selected'); echo('>cluetip</option>
						<option value="tipped" label="tipped"'); if ($bgcolor == 'tipped') echo(' selected=selected'); echo('>tipped</option>
						<option value="tipsy" label="tipsy"'); if ($bgcolor == 'tipsy') echo(' selected=selected'); echo('>tipsy</option>
					</select>
				</td>
			</tr>
		</table>');  
 
        echo('<br><p>Providing you and your visitors with the freshest thumbnails takes a lot of server resources which isn\'t free of charge for me. I\'m providing these resources at no cost, because that\'s my hobby and I like running servers at a high load. Instead of demanding a fee, I would be glad if you would spend me a backlink on your site. You may either use the automatic footer link or place a hyperlink somewhere else on your site which should be like that:<br><pre><code>&lt;a href="http://www.mynakedgirlfriend.de" target="_blank"&gt;Thomas Schulte&lt;/a&gt;</code></pre></p><p>Thank you very much!</p>');
 
	echo('<table>
                       <tr>
                                <td>show plugin info in footer:&nbsp;</td>
                                <td>
                                        <select name="showfooter" id="showfooter">
                                                <option value="yes" label="yes"'); if ($showfooter == 'yes') echo(' selected=selected'); echo('>yes</option>
                                                <option value="no" label="no"'); if ($showfooter == 'no') echo(' selected=selected'); echo('>no</option>
                                        </select>
                                </td>
                        </tr>
		</table>');

	echo('
		<p class="submit">
			<input type="hidden" name="action" value="update" />
			<input type="submit" name="thumbsniper_options_update" value="Update Options &raquo;" />
		</p>');

	echo('</form>');
	echo('</div>');
}



function thumbsniper_get_include_pages() {
	$keywords = NULL;
	$include_pages = get_option('thumbsniper_include_pages');
	if($include_pages != "") {
		$keywords = preg_split("/[\s,]+/", $include_pages);
	}
	return $keywords;
}


function thumbsniper_styles() {
	if((get_option('thumbsniper_preview') == "all" || get_option('thumbsniper_preview') == "external") && sizeof(thumbsniper_get_include_pages()) > 0) {
		global $post;
		if(!in_array($post->ID, thumbsniper_get_include_pages())) {
			return;
		}
	}

	 $header.= '<link rel="stylesheet" href="' . plugins_url('qtip/jquery.qtip.min.css', __FILE__) . '" />' . "\n";
	 $header.= '<link rel="stylesheet" href="' . plugins_url('thumbsniper.css', __FILE__) . '" />' . "\n";

	print $header;
}



function thumbsniper_scripts() {
	if((get_option('thumbsniper_preview') == "all" || get_option('thumbsniper_preview') == "external") && sizeof(thumbsniper_get_include_pages()) > 0) {
		global $post;
		if(!in_array($post->ID, thumbsniper_get_include_pages())) {
			return;
		}
	}

	$header.= '
	        <script type="text/javascript">
			var ThumbSniper = jQuery.noConflict();

	                ThumbSniper(document).ready(function(){
	                       	ThumbSniper(function() {';

					$thumbsniper_preview = get_option('thumbsniper_preview');

	                                if($thumbsniper_preview == 'all' || $thumbsniper_preview == 'external') {

	                                        $header.= 'for (var i = 0; i < document.links.length; ++i) {
	                                                var link = document.links[i];
	                                                var blogurl = "' . get_option("siteurl") . '";
	                                                var linkurl = String(link.href).substring(0, blogurl.length);
	                                                var linkproto = String(link.href).substring(0, 4);

	                                                if(linkproto == "http") {';

							$excluded_urls = get_option('thumbsniper_excluded_urls');

							if(strlen($excluded_urls) > 0) {
								$excludes = preg_split("/;/", $excluded_urls);

								foreach($excludes as $exclude) {
									$header.= '
										var excludeurl = "' . $exclude .'";
										if(String(link.href).substring(0, excludeurl.length) == excludeurl) 
											link.className=link.className + " nothumbsniper";';
								}
							}
								
							$header.= 'if(link.className.indexOf("nothumbsniper") == -1) {';
								

	                                                if($thumbsniper_preview == 'external') {
	                                                        $header.= 'if(blogurl != linkurl) {
	                                                                link.className=link.className + " thumbsniper";
	                                                        }';
	                                                }else {
	                                                        $header.= 'link.className=link.className + " thumbsniper";';
	                                                }
							$header.= '}';
	                                        $header.= '}';
						$header.= '};';

	                                }

					$header.= 'ThumbSniper(".thumbsniper").live("mouseover", function(event) {
						var ThumbSniperVersion = "' . get_option("thumbsniper_version") . '";
						var ThumbSniperScaling = ' . get_option("thumbsniper_scaling") . ';
						var PreviewType = "' . get_option("thumbsniper_preview") . '";
						var tooltipImageUrl = "http://www.thumbsniper.de/shoot.php?size=" + ThumbSniperScaling + "&url=" + ThumbSniper(this).attr("href") + "&time=" + new Date().getTime();

						//jQuery.support.cors = true;

	                                        ThumbSniper(this).qtip({
							overwrite: true,
	                                                content: {
								text: "<img src=\"' . plugins_url('wait.gif', __FILE__) . '\">",
                                                                ajax: {
                                                                        loading: true,
                                                                        url: "http://www.thumbsniper.de/shoot.php",
                                                                        type: "GET",
                                                                        dataType: "jsonp",
                                                                        data: {
                                                                                url: ThumbSniper(this).attr("href"),
                                                                                size: ' . get_option("thumbsniper_scaling") . '
                                                                        },
                                                                        success: function(data, status, jqXHR) {
										if(data.url == "wait") {
										}else {
	                                                                                this.set("content.text", "<img src=\"" + data.url + "\">");
										}
                                                                        }
                                                                }
							},
	                                                show: {
								event: event.type,
								ready: true,
								solo: true
	                                                },
	                                                tip: {
	                                                        corner: true,
	                                                        border: 3,
	                                                        width: 16,
	                                                        height: 24
	                                                },
							position: {
								my: "top center",
								at: "bottom center",
								adjust: {
									method: "flip flip"
								},
								viewport: ThumbSniper(window)
							},
	                                                style: {
								classes: "ui-tooltip-' . get_option('thumbsniper_bgcolor') . ' ui-tooltip-shadow ui-tooltip-rounded",
	                                                        padding: 20,';

	                                switch(get_option('thumbsniper_scaling')) {
	                                        case 2:
	                                                $header.= 'width: 420';
	                                                break;
	                                        case 3:
	                                                $header.= 'width: 280';
	                                                break;
	                                        case 4:
	                                                $header.= 'width: 230';
	                                                break;
	                                        case 5:
	                                                $header.= 'width: 180';
	                                                break;
	                                        case 6:
	                                                $header.= 'width: 160';
	                                                break;
	                                        case 7:
	                                                $header.= 'width: 140';
	                                                break;
	                                        case 8:
	                                                $header.= 'width: 130';
	                                                break;
	                                };

	                                $header.=       '}
	                                        }).removeAttr("alt").removeAttr("title");
	                                });
	                        });
	                });
	        </script>';

	print($header);
}


function thumbsniper_about() {
	$footer.= '<div style="text-align:center; font-size: xx-small;">ThumbSniper-Plugin by <a href="http://www.mynakedgirlfriend.de">Thomas Schulte</a></div>';
	print($footer);
}

?>
