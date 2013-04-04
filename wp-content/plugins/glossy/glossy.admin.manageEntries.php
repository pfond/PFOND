<?php
	if (!function_exists('gs_addEntry_panel'))
	{
		function gs_manageEntries_panel()
		{
			global $wpdb;
			$gs_tableName = $wpdb->prefix ."gs_store";
			
			// Load list of entries in alphabetical order
			$query = "SELECT gs_name FROM ". $gs_tableName ." ORDER BY gs_name;";
			$gs_entry_list = $wpdb->get_results($query);

?>
<div class="wrap">
	<h2>Manage Glossy Entries</h2>
	<?php gs_tippy_check(); ?>
	<form method="post">

	<div style="margin-left: 30px;">
		<ol>
			<?php
				if (sizeof($gs_entry_list) == 0)
				{
					echo '<div id="message" class="updated">No Glossy entries found. You may want to <a href="admin.php?page=glossy-add-entry">add an entry</a>.</div>';
				} else {
					foreach($gs_entry_list as $gs_name_arr)
					{
						$gs_name = $gs_name_arr->gs_name;
						
						echo '<li><a href="admin.php?page=glossy-add-entry&gs_edit_entry='. urlencode($gs_name) .'">'. $gs_name .'</a><br />Preview: '. gs_display($gs_name) .'<br /></li>';
					}
				}
			?>
		</ol>
	</div>
</div>
<?php
		}
	}
?>