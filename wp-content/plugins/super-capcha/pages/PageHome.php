<?php
			include_once('PageNav.php');
			if (!is_super_admin( get_current_user_id() )) header("HTTP/1.1 403 Forbidden")&die('Direct access not allowed!');
			if(function_exists('curl_init') && !$_REQUEST['readme'])
				{
				?>
				<h2>Super-CAPTCHA Dashboard</h2>
				<h3>INSTALLED VERSION: <?php echo(SCAPTCHA_VERSN); ?><br />
				<?php
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, "http://www.mlwassociates.com/txts/scaptcha.html");
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_exec($ch);
				curl_close($ch);
				echo($chtml);
				}
			elseif(!function_exists('curl_init') && !$_REQUEST['readme'])
				{
				?>
				<h2>Super-CAPTCHA Dashboard</h2>
				<strong>ERROR: Your PHP enabled web-server does not support "<a href="http://php.net/manual/en/book.curl.php" target="_blank">cURL</a>". You can not see this dynamic page!</strong>
				<?php
				} else {
				?>
				<h2>Super-CAPTCHA README</h2>
				<form><textarea cols=90 rows=25><?php include_once(THIS_DIR . '/README.txt'); ?></textarea></form>
				<?php
				}
				?>
				<h3>Quick Diagnostic</h3>
				<p><strong>Session Support:</strong> <?php
				if(function_exists('session_start') && function_exists('ob_start'))
					{
					?><span style="color:#006600;">PASS</span>
					<?php
					} else {
					?><span style="color:#990000;">FAIL</span>
					<?php
					}
				?><br />
				
				<strong>PHP GD Support:</strong> <?php
				if(function_exists('imagecreate'))
					{
					?><span style="color:#006600;">PASS</span>
					<?php
					} else {
					?><span style="color:#990000;">FAIL</span>
					<?php
					}
				?><br />
				
				<strong>PHP GD PNG Support:</strong> <?php
				if(function_exists('imagepng'))
					{
					?><span style="color:#006600;">PASS</span>
					<?php
					} else {
					?><span style="color:#990000;">FAIL</span>
					<?php
					}
				?></p>