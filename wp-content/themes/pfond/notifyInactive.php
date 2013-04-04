<?php
/*
Template Name: Notify Inactive Editors
*/

/* These notes are mostly for myself.
This PHP file will add the editors that have filled out the progress form to an array.
Further, we will get a list of the active editors. If an editor has not filled out a form. 
We will mail a notification email to that editor. 
*/
?>

<html>
<title>Notify Inactive Users</title>
<h2>PFOND Administration</h2>
<p>Welcome to PFOND's Notification Script.</p>
<p>Proper email formatting will not be shown here, but the correct format will be sent by mail.
Please don't run this script more than once per period.</p> 
<?php

@$mode = $_GET["mode"];




$month = date('M', strtotime('first day next month'));

$to = "pseidkarbasi@gmail.com, kittybobtail@gmail.com";
$subject = "PFOND: Notification";
$txt = "Dear PFOND Editor,

This is an automated message. Our records indicate that we have not received the form http://pfond.cmmt.ubc.ca/progress-form/ from you. If we do not receive this by " . $month . " 1 your PFOND editor status will be marked as inactive. 

Kind Regards,
The PFOND Team";
$headers = "From: noreply@pfond.cmmt.ubc.ca";

if ($mode == "email") {

	$str_monthly = file_get_contents('http://pfond.cmmt.ubc.ca/misc/monthlyProgress.txt');
	$editors_active_array = explode(",", $str_monthly);
	
	//print_r ($editors_active_array);
	mail($to,$subject,$txt,$headers);


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
			array_push($editors_array, $editor->user_login);
			//array_push($editors_display_name_array, $editor->display_name);
		}
	}
	
	//print_r ($editors_array);
	
	$notify_array = array(); 
	
	$count_i = sizeof($editors_array);
	$count_j = sizeof($editors_active_array);
	for($i=0; $i<$count_i; $i++) {
		$flag = false; 
		for($j = 0; $j < $count_j; $j++) {
		
			if($editors_active_array[$j] == $editors_array[$i]) {
				$flag = true; 
			}
		}
		
		// if flag == true then this editor is active do not add to inactive list
		
		if(!$flag) {
			array_push($notify_array, $editors_array[$i]);
		}
	}
	
	//print_r ($notify_array);

	foreach( $notify_array as $editor) {
		$user = get_user_by('login', $editor);
		$to = $user->user_email;
		//mail($to,$subject,$txt,$headers);
		echo $to; 
	}
	/*while(! feof($file)) {
  		$to = trim(fgets($file));
  		echo $to . "<br />";
  		//sleep(5);
  		//mail($to,$subject,$txt,$headers);
  	}*/



	echo "<br /><br /><b>Message was sent.</b>";

} else {
	echo "Message: <br /><br />"; 

	echo $txt . "<br /><br />"; 

	echo '<a href="?mode=email">Send now!</a>';

}
	
	
?>


</html>

