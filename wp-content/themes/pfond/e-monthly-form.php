<?php
/*
Template Name: Monthly Editor Progress Form
*/
?>

<?php 

get_header();

?>

<script type="text/javascript">
function myFunction()
{
<?php echo "hello"; ?>
alert("Your submission was received! You will be redirected back to the homepage.");
}
</script>

<div id="content">
	<div class="padder">
		<div class="page">
		
		<?php
		$flag = false;
		
		
			
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
		
		if (!is_user_logged_in()) {
			echo "<p>You must be logged in to access this form.</p>";
		}	
		if (is_user_logged_in()) {
			global $current_user;
			get_currentuserinfo();
			
			$username = $current_user->user_login; // the username of the user that is logged in
				
			$blogs = $wpdb->get_results("
					SELECT *
					FROM wp_blogs
					WHERE blog_id != 1 && blog_id != 2
					ORDER BY blog_id ASC
					", OBJECT);
					
			$editors_array = array();		
			
			
			foreach ($blogs as $blog) {
				$editors = get_users('blog_id=' . $blog->blog_id . '&role=editor');
				foreach ($editors as $editor) {
					if($editor->user_login === $username) {
						$flag = true; 
					}
				}
			}
		
			if (!$flag) {
				echo "<p>Your account does not have editor access on PFOND.</p>";
			}
			
			// let's check to see if user has submitted the form already
			if($flag) {
				$str = file_get_contents('http://pfond.cmmt.ubc.ca/misc/monthlyProgress.txt');
				$pos = strpos($str, $username);
				if ($pos !== false) { // the string username was found!
					echo "<p>Your submission has been received for this term!</p>";
					do_action('monthly_progress_form_ach'); // when the user gets redirected back we'll give the achievement.
					$flag = false;
				}
			}
		}	
		if (is_user_logged_in() && $flag) {
		

		/*
		$blogs = $wpdb->get_results("
				SELECT *
				FROM wp_blogs
				WHERE blog_id != 1 && blog_id != 2
				ORDER BY blog_id ASC
				", OBJECT);
				
		$editors_array = array();
		
		global $current_user;
		get_currentuserinfo();
		echo 'Username: ' . $current_user->user_login . "\n";
		
		
		
		foreach ($blogs as $blog) {
			$editors = get_users('blog_id=' . $blog->blog_id . '&role=editor');
    		foreach ($editors as $editor) {
    			array_push($editors_array, $editor->user_login);
        		//echo '<li>' . $editor->user_login . '</li>';
    		}
		}
		$editors_unique_array = array_unique($editors_array); 
		//print_r($editors_unique_array);
		
		foreach ($editors_unique_array as $value) {
			echo $value . "<br />";
		}
		
		*/
			
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
		
		
		
		
	
					
			<h1>Monthly Editor Progress Form</h1>
			<p>Please fill out the following form on a monthly basis. We use these forms to supplement our methods of keeping track of editor contributions. The team also looks at these submissions when providing recommendation letters or other incentives.</p>
			Note:<br />
			<ul>
				<li>-Registered editors will receive monthly reminders by email.</li>
				<li>-You will have to be logged into your account to submit this form.</li>
			</ul><br />
			
			<form action="http://pfond.cmmt.ubc.ca/misc/monthlyProgress.php" method="post">
				<fieldset>	
					<p>
						<label for="disorder-name">Disorder Name:</label>
						<input type="text" name="disorder-name" id="disorder-name" />
					</p>
					
					<p>
						<label for="accomplished-last-month">What have you accomplished in the last month?</label><br />
						<input type="text" name="accomplished-last-month" id="accomplished-last-month" />
					</p>
					
					<p>
						<label for="accomplish-this-month">Let us know what you plan to accomplish this month.</label><br />
						<input type="text" name="accomplish-this-month" id="accomplish-this-month" />
					</p>
					<input type="hidden" name="udname" value="<?php echo $current_user->display_name; ?>">
					<input type="hidden" name="uemail" value="<?php echo $current_user->user_email; ?>">
					<input type="hidden" name="uname" value="<?php echo $current_user->user_login; ?>">
					<input type="submit" value="Submit" onclick="myFunction()" />
				</fieldset>
			</form>		
			
<?php } ?>	
		
		</div><!-- end page-->
	</div><!-- end padder-->
</div><!-- end content-->


<?php locate_template( array( 'sidebar.php' ), true ) ?>

<?php get_footer() ?>