<?php
/*
Template Name: Delete Inactive Editors
*/


/* These notes are mostly for myself.
This PHP file will add the editors that have filled out the progress form to an array.
Further, we will get a list of the active editors. If an editor has not filled out a form. 
We will REMOVE that editor from a PFOND site that user may have access to, along with an
email informing them. 
*/

@$file = fopen("http://". $blog->domain . "/misc/monthlyProgress.txt","r");
	
$editors_active_array = array(); 

while(! feof($file)) {
	$editor = trim(fgets($file));
	if($editor != "") {
		array_push($editors_active_array, $editor);
	}
}
print_r ($editors_active_array);

// now that we have a list of the editors that 
// have submitted the forum let's get the list of all editors



?>