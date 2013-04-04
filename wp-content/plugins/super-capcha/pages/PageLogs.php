<div class="wrap" style="position: relative;">
	<div class="wrap">
<?php 
if (!is_super_admin( get_current_user_id() )) header("HTTP/1.1 403 Forbidden")&die('Direct access not allowed!');
include_once('PageNav.php'); 
?>
	<h2>Super CAPTCHA Logs</h2>
	<?php
		if(!empty($_REQUEST['clrLog']) && $_REQUEST['clrLog'] == '1')
			{
			clearLogTable();
			}
		if( mysql_num_rows( mysql_query("SHOW TABLES LIKE '". sCaptcha_dbtable() ."_logs'")))
			{
			
			} else {
			$sql = 		("DROP TABLE IF EXISTS " . sCaptcha_dbtable() . "_logs;
						
						CREATE TABLE " . sCaptcha_dbtable() . "_logs (
						log_id mediumint(9) NOT NULL AUTO_INCREMENT,
						log_user VARCHAR(255),
						log_ip VARCHAR(255),
						log_time INT(30),
						log_host TEXT,
						log_browser TEXT,
						log_form TEXT,
						UNIQUE KEY log_id (log_id)
						);
			");
			mysql_query($sql);
			echo('<h3>Your Logs table didn\'t exist, we just added it for you!</h3>');
			}
	?>
	<p>Here you can view those that have been blocked for failing to pass the CAPTCHA system.  This is mainly for diagnostics or for those that slip past the safeguard and you need to ban.</p>
	<hr />
	<strong><a href="admin.php?page=super-captcha/Logs&clrLog=1">Clear Logs</a></strong><br />
	<?php
		if(empty($_REQUEST['showNUM']) && empty($_SESSION['showNUM']))
			{
			$shownumber = 50;
			}
		elseif(!empty($_REQUEST['showNUM']))
			{
			$_SESSION['showNUM'] = $_REQUEST['showNUM'];
			$shownumber = $_REQUEST['showNUM'];
			} else {
			$shownumber = $_SESSION['showNUM'];
			}
			
		if(empty($_REQUEST['pageNUM']))
			{
			$pagenumber = 1;
			} else {
			$pagenumber = $_REQUEST['pageNUM'];
			}
			
		if(empty($_REQUEST['viewTYPE']) && empty($_SESSION['viewTYPE']))
			{
			$showtype = ' GROUP BY `log_ip`';
			}
		elseif($_REQUEST['viewTYPE'] == 'expand')
			{
			$_SESSION['viewTYPE'] = NULL;
			$showtype = NULL;
			}
		elseif($_REQUEST['viewTYPE'] == 'collapse')
			{
			$_SESSION['viewTYPE'] = ' GROUP BY `log_ip`';
			$showtype = ' GROUP BY `log_ip`';
			} else {
			$showtype = $_SESSION['viewTYPE'];
			}
		
		if(empty($_SESSION['viewTYPE']))
			{
			$colexp = ('<a href="admin.php?page=super-captcha/Logs&viewTYPE=collapse">Collapse</a>');
			} else {
			$colexp = ('<a href="admin.php?page=super-captcha/Logs&viewTYPE=expand">Expand</a>');
			}
		if(!empty($_REQUEST['orderIT']))
			{
			$orderit = $_REQUEST['orderIT'];
			} else {
			$orderit = 'log_time';
			}
			
		if(!empty($_REQUEST['orderIN']))
			{
			$orderin = $_REQUEST['orderIN'];
			} else {
			$orderin = 'DESC';
			}
		$sqls = ("SELECT * FROM `". sCaptcha_dbtable() ."_logs`". $showtype);
		$query = mysql_query( $sqls );
		if(mysql_num_rows($query) < $shownumber)
			{
			$pages = 1;
			} else {
			$pages = mysql_num_rows($query)/$shownumber;
			}
		//echo('There are '. $pages .' pages.');
	?>
	Page <?php
	for($i=1;$i<=$pages;$i++)
		{
		if( $i == 1 )
			{
			?>
			<a href="admin.php?page=super-captcha/Logs&pageNUM=1">1</a><?php
			} else {
			?>, <a href="admin.php?page=super-captcha/Logs&pageNUM=<?php echo($i); ?>"><?php echo($i); ?></a>
			<?php
			}
		}
	?> | <?php echo($colexp); ?><br />
	<small>Show <a href="admin.php?page=super-captcha/Logs&showNUM=25">25</a>, <a href="admin.php?page=super-captcha/Logs&showNUM=50">50</a>, or <a href="admin.php?page=super-captcha/Logs&showNUM=100">100</a> per page.</small>
<br class="clear">
</div>

<div class="clear"></div>

<table class="widefat page fixed" cellspacing="0">
  <thead>
  <tr>
	<th scope="col" id="cb" class="manage-column column-cb check-column" style="">#</th>
	<th scope="col" id="title" class="manage-column column-title" style="">IP Address (<a href="admin.php?page=super-captcha/Logs&orderIT=log_ip&orderIN=DESC">&uArr;</a>/<a href="admin.php?page=super-captcha/Logs&orderIT=log_ip&orderIN=ASC">&dArr;</a>)</th>
	<th scope="col" id="author" class="manage-column column-author" style="">Referrer (<a href="admin.php?page=super-captcha/Logs&orderIT=log_browser&orderIN=DESC">&uArr;</a>/<a href="admin.php?page=super-captcha/Logs&orderIT=log_browser&orderIN=ASC">&dArr;</a>)</th>
	<th scope="col" id="date" class="manage-column column-date" style="">Date (<a href="admin.php?page=super-captcha/Logs&orderIT=log_time&orderIN=DESC">&uArr;</a>/<a href="admin.php?page=super-captcha/Logs&orderIT=log_time&orderIN=ASC">&dArr;</a>)</th>
  </tr>
  </thead>

  <tfoot>
  <tr>

	<th scope="col" class="manage-column column-cb check-column" style="">#</th>
	<th scope="col" class="manage-column column-title" style="">IP Address</th>
	<th scope="col" class="manage-column column-author" style="">Referrer</th>
	<th scope="col" class="manage-column column-date" style="">Date</th>
  </tr>
  </tfoot>

  <tbody>
		<?php
		if(isset($_REQUEST['markspam']))
			{
			global $wpdb;
			$UIDs = explode(',', mysql_real_escape_string($_REQUEST['markspam']));
			echo('<h2>Accounts Flagged</h2>');
			for($i=0;$i<count($UIDs);$i++)
				{
				mysql_query("UPDATE `". $wpdb->users ."` SET `spam`='1' WHERE `ID`='". $UIDs[$i] ."'");
				mysql_query("UPDATE `". $wpdb->users ."` SET `user_status`='1' WHERE `ID`='". $UIDs[$i] ."'");
				echo('<em>USER ID: '. $UIDs[$i] .' marked as spammer.</em><br />');
				}
			}
		if(isset($_REQUEST['unmarkspam']))
			{
			global $wpdb;
			$UIDs = explode(',', mysql_real_escape_string($_REQUEST['unmarkspam']));
			echo('<h2>Accounts UnFlagged</h2>');
			for($i=0;$i<count($UIDs);$i++)
				{
				mysql_query("UPDATE `". $wpdb->users ."` SET `spam`='0' WHERE `ID`='". $UIDs[$i] ."'");
				mysql_query("UPDATE `". $wpdb->users ."` SET `user_status`='0' WHERE `ID`='". $UIDs[$i] ."'");
				echo('<em>USER ID: '. $UIDs[$i] .' marked as spammer.</em><br />');
				}
			}
		$precheck = (($pagenumber)*$shownumber)-$shownumber;
		$query_builder = ('LIMIT '. $precheck .', '. ($shownumber+$precheck));
		$sql = ("SELECT * FROM `". sCaptcha_dbtable() ."_logs`". $showtype ." ORDER BY `". $orderit ."` ". $orderin ." ". $query_builder);
		// echo('<br />Query 1: "'. $sqls .'"<br />'); // Debug Line
		// echo('<br />Query 1: "'. $sql .'"<br />'); // Debug Line
		$query = mysql_query( $sql );
		while( $rows = mysql_fetch_array( $query ) )
			{
			$thisquery = mysql_query("SELECT `log_ip` FROM `". sCaptcha_dbtable() ."_logs` WHERE `log_ip`='". $rows['log_ip'] ."'");
			$forms = explode('|', $rows['log_form']);
			if(!empty($forms[5]) || !empty($forms[4]))
				{
				$blogsoutput = ('
						Blog: '. $forms[5] .' <br />
						Domain: '. $forms[4] .'');
				}
			$ipalert = NULL;
			$count = 0;
			$sqlst = ("SELECT * FROM `". get_users_table('meta') ."` WHERE `meta_value`='". $rows['log_ip'] ."' AND `meta_key`='logged_ip'");
			$thisqueries = mysql_query( $sqlst );
			$links = NULL;
			$userIDs = NULL;
			while($resit = mysql_fetch_array($thisqueries))
				{
				$sqluser = ("SELECT * FROM `". get_users_table('user') ."` WHERE `ID`='". $resit['user_id'] ."'");
				$resultuser = mysql_fetch_array( mysql_query( $sqluser ) );
				$count++;
				if($count == 1)
					{
					$links .= ('<a href="user-edit.php?user_id='. $resit['user_id'] .'&wp_http_referer=%2Fwp-admin%2Fadmin.php">'. $resultuser['user_login'] .'</a>');
					$theaccounts = ('account');
					$userIDs .= $resit['user_id'];
					} else {
					$links .= (', <a href="user-edit.php?user_id='. $resit['user_id'] .'&wp_http_referer=%2Fwp-admin%2Fadmin.php">'. $resultuser['user_login'] .'</a>');
					$theaccounts = ('accounts');
					$userIDs .= ',' . $resit['user_id'];
					}
				$ipalert = ('<span style="background-color:#FFFFE1; padding:4px; margin: 0 auto; border:1px broken #990000;">This IP is associated with '. $links .' '. $theaccounts .'! [<a href="admin.php?page=super-captcha/Logs&markspam='. $userIDs .'">Spam All</a> | <a href="admin.php?page=super-captcha/Logs&unmarkspam='. $userIDs .'">UnSpam All</a>]</span>');
				$prealrt = ('<span style="background-color:#FFFFE1; padding:4px; margin: 0 auto; border:1px broken #990000;">');
				$postalr = ('</span>');
				}
			if($count == 0)
				{
				$ipalert = NULL;
				$prealrt = NULL;
				$postalr = NULL;
				}
			$content = ('
				<tr id="'. $rows['log_ip'] .'" class="alternate iedit">
					<th scope="row" class="check-column">#</th>
					<td class="post-title page-title column-title">
						<strong>'. $prealrt .'<a href="http://www.ipchecking.com/?ip='. $rows['log_ip'] .'&amp;TB_iframe=true&width=1040&height=534" class="thickbox onclick" title="Lookup IP: '. $rows['log_ip'] .'">'. $rows['log_host'] .'</a>'. $postalr .'</strong>
						<div class="row-actions"><span class="edit"><a href="http://www.who.is/whois-ip/ip-address/'. $rows['log_ip'] .'/&amp;TB_iframe=true&width=1040&height=534" class="thickbox onclick" title="WhoIs: '. $rows['log_ip'] .'">'. $rows['log_ip'] .'</a> | </span><span class="inline">User: '. $forms[2] .' | </span><span class="trash"><a class="submitdelete" title="Email: '. $forms[3] .'" href="#">Email: '. $forms[3] .'</a></span><br />
						<span class="view">'. $rows['log_browser'] .'</span><br />'. $ipalert .'</div>
					</td>
					<td class="author column-author">
						'. $forms[0] .'<br />'.$blogsoutput.'					
					</td>
					<td class="date column-date">
						<abbr title="'. date("M d, Y H:i:s", $rows['log_time']) .'">'. date("M d, Y H:i:s", $rows['log_time']) .'</abbr><br />Logged '. mysql_num_rows($thisquery) .' attempts
					</td>
				</tr>
			');
			echo($content);
			}
		?>
	  </tbody>
</table>
	</div>
</div>		