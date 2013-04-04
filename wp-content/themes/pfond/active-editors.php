<?php
/*
Template Name: Active Editors
*/
?>

<?php 

get_header();

?>

<div id="content">
	<div class="padder">
		<div class="page">
		
			<h1>Active Editors on PFOND</h1>
			<p>Below we have included our current list of active editors. These editors are currently working on sites on PFOND.</p>
			
			<table border="1" cellspacing="0" cellpadding="0">
			<tbody>
			<tr>
			<td width="148" valign="top"><strong>Name</strong></td>
			<td width="200" valign="top"><strong>Username</strong></td>
			<td width="200" valign="top"><strong>Disorder</strong></td>
			</tr>
	
			


		<?php
		
		
			
		/*	
		$editors = get_users('blog_id=1&role=editor');
    	foreach ($editors as $editor) {
        	echo '<li>' . $editor->user_email . '</li>';
    	}
    
    	*/
		/*$editors = getUsersWithRole('editor');
		foreach($editors as $editor){
    		 //$editor now holds the user ID of an editor
			$user_info = get_userdata(1);
			echo 'Username: ' . $user_info->user_login . "\n";
			echo 'User level: ' . $user_info->user_level . "\n";
			echo 'User ID: ' . $user_info->ID . "\n";
		}
		*/
		
		
		$blogs = $wpdb->get_results("
				SELECT *
				FROM wp_blogs
				WHERE blog_id != 1 && blog_id != 2
				ORDER BY blog_id ASC
				", OBJECT);
				
		$editors_array = array();
		$editors_display_name_array = array(); 		
		
		foreach ($blogs as $blog) {
			$editors = get_users('blog_id=' . $blog->blog_id . '&role=editor');
    		foreach ($editors as $editor) {
    			$blogname = $wpdb->get_row("
					SELECT *
					FROM wp_" . $blog->blog_id . "_options
					WHERE option_name = 'blogname'
					", OBJECT);
    			$txt = '
    			<tr>
				<td width="148" valign="top">' . $editor->display_name . '</td>
				<td width="200" valign="top"><a href="http://pfond.cmmt.ubc.ca/members/'. $editor->user_login .'/">' . $editor->user_login . '</a></td>
				<td width="200" valign="top">' . '<a href="http://' . $blog->domain . $blog->path . '">' . $blogname->option_value . '</a>' .'</td>
				</tr>';
    			array_push($editors_array, $txt);
    			//array_push($editors_array, $editor->user_login);
    			//array_push($editors_display_name_array, $editor->display_name);
    		}
		}
		$editors_unique_array = array_unique($editors_array); 
		//$editors_unique_display_name_array = array_unique($editors_display_name_array); 
		//print_r($editors_unique_array);
		
		foreach ($editors_unique_array as $value) { 
			echo $value; 
		}
		
		/*	
		$editors = get_users('blog_id=1&role=editor');
    	foreach ($editors as $editor) {
        	echo '<li>' . $editor->user_email . '</li>';
    	}
    
    	*/
		/*$editors = getUsersWithRole('editor');
		foreach($editors as $editor){
    		 //$editor now holds the user ID of an editor
			$user_info = get_userdata(1);
			echo 'Username: ' . $user_info->user_login . "\n";
			echo 'User level: ' . $user_info->user_level . "\n";
			echo 'User ID: ' . $user_info->ID . "\n";
		}
		*/
		?>
		
		
		
			</tbody>
				</table>
				<span style="font-size: small;"><span style="line-height: normal;">
				</span></span>
		</div><!-- end page-->
	</div><!-- end padder-->
</div><!-- end content-->


<?php locate_template( array( 'sidebar.php' ), true ) ?>

<?php get_footer() ?>