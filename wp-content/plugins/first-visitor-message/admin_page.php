	<?php
	
		if(isset($_POST['reset_data'])) {
		
		
		global $wpdb;
		$tabel = $wpdb->prefix . "firstvisit_ip";
		$wpdb->query('TRUNCATE TABLE ' . $tabel);
		
		echo '<div class="updated"><p><strong>All records deleted.</strong></p></div>';
		
		}
		
		if(isset($_POST['retreive'])){
		global $wpdb;
		$tabel = $wpdb->prefix . "firstvisit_ip";
		$results = $wpdb->get_results("SELECT * FROM " . $tabel);
		echo '<table class="form-table">
		<tbody>
		<tr><th scope="row" valign="top">IP</th><td>Date</td></tr>
		' ;
		if($wpdb->num_rows)
			{
			foreach ($results as $result)
			{
			
			echo '<tr><th scope="row" valign="top">';
			echo $result->ip;
			echo '</th><td>';
			echo $result->datetime;
			echo '</td></tr>';
			}
			}
		
		echo '</tbody></table><div class="updated"><p><strong>Retreived.</strong></p></div>';
		
		}
		if($_POST['firstvisit_hidden'] == 'Y') {
	
	
			$enabled = $_POST['firstvisit_enabled'];
			update_option('firstvisit_enabled', $enabled);

			$title = $_POST['firstvisit_title'];
			update_option('firstvisit_title', $title);
			
			$message = $_POST['firstvisit_message'];
			update_option('firstvisit_message',$message);
			
			$notagain = $_POST['firstvisit_notagain'];
			update_option('firstvisit_notagain', $notagain);
	
			$successmessage = $_POST['firstvisit_successmessage'];
			update_option('firstvisit_successmessage', $successmessage);

			$dbcookie = $_POST['firstvisit_dbcookie'];
			update_option('firstvisit_dbcookie', $dbcookie);
	
	?>
	<div class="updated"><p><strong><?php _e('Options saved.' ); ?></strong></p></div>
	<?php
		} else {
		
			
			$enabled = get_option('firstvisit_enabled');
			$title = get_option('firstvisit_title');
			$message = get_option('firstvisit_message');
			$notagain = get_option('firstvisit_notagain');
			$successmessage = get_option('firstvisit_successmessage');
			
			
		
		}
		
		function firstvisit_checked($option){
			$enabled = get_option('firstvisit_enabled');
			if($enabled == $option){
				echo 'checked';
			}
		}
		function firstvisit_dbcookie($option){
			$enabled = get_option('firstvisit_dbcookie');
			if($enabled == $option){
				echo 'checked';
			}
		}
	?>
	
	
		<div class="wrap">
			<?php    echo "<h2>" . __( 'First Visit Settings', 'firstvisit_trdom' ) . "</h2>"; ?>

			<form name="firstvisit_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
			

				<input type="hidden" name="firstvisit_hidden" value="Y">
				<?php    echo "<h4>" . __( 'First Visit General Settings', 'firstvisit_trdom' ) . "</h4>"; ?>
				
		<table class="form-table">
		<tbody>
		
				<tr><th scope="row" valign="top"><?php _e("Enabled: " ); ?></th><td><input type="radio" name="firstvisit_enabled" value="yes" <?php firstvisit_checked('yes'); ?>>&nbsp;Yes &nbsp;&nbsp;<input type="radio" name="firstvisit_enabled" value="no" <?php firstvisit_checked('no'); ?>>&nbsp;No</td></tr>
				<tr><th scope="row" valign="top"><?php _e("DB/Cookies: ");?></th><td><input type="radio" name="firstvisit_dbcookie" value="db" <?php firstvisit_dbcookie('db');?>>&nbsp;Database &nbsp;&nbsp;<input type="radio" name="firstvisit_dbcookie" value="cookie" <?php firstvisit_dbcookie('cookie');?>>&nbsp; Cookies</td></tr>
				<tr><th scope="row" valign="top"><?php _e("Title: " ); ?></th><td><input type="text" name="firstvisit_title" size="80" value="<?php echo $title;?>"/></td></tr>
				<tr><th scope="row" valign="top"><?php _e("Message: " ); ?></th><td><textarea cols="50" rows="5" name="firstvisit_message"><?php echo $message;?></textarea></td></tr>
				<tr><th scope="row" valign="top"><?php _e("Don't show again text: "); ?></th><td><input type="text" size="80" name="firstvisit_notagain" value="<?php echo $notagain;?>"/></td></tr>
				<tr><th scope="row" valign="top"><?php _e("Success Message: "); ?></th><td><input type="text" size="80" name="firstvisit_successmessage" value="<?php echo $successmessage; ?>" /></td></tr>
				</tbody></table>
				<hr />
				
				<p class="submit">
				<input type="submit" name="Submit" value="<?php _e('Update Options', 'firstvisit_trdom' ) ?>" />
				</p>
			</form>
			
			<form name="firstvisit_reset" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
				<input type="hidden" name="firstvisit_goreset" value="Y">
				<?php echo "<h4>" . __('Reset the data!', 'firstvisit_trdom') . "</h4>"; ?>
				<table class="form-table">
				<tbody>
				
				<tr><th scope="row" valign="top">Reset all data</th><td><p class="submit"><input type="submit" name="reset_data" value="<?php _e('Go!', 'firstvisit_trdom' ) ?> "/></p></td></tr>
				<tr><th scope="row" valign="top">Retreive IP list</th><td><p class="submit"><input type="submit" name="retreive" value="<?php _e('Go!', 'firstvisit_trdom' ) ?> " /></p></td></tr>
				</tbody></table>
				
				</form>
				
				
				
				
		</div>
	
