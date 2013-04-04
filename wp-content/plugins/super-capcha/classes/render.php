<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////
////                                                                                                    ////
////    WARNING: SOME OR ALL OF THE CODE HEREIN MAY BE PRIVLAGED AND COPYWRITEN TO MLW & ASSOCIATES!    ////
////                                                                                                    ////
////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////
	class RandomCaptchaSpam
		{
		var $adminOptionsName = "scaptcha_options";
		var $db_table_name = '';
		function scaptcha(){$this->RandomCaptchaSpam();} // Backwards compatability...
		function RandomCaptchaSpam()
			{ // This is the main construct...
			global $wpdb;
			$this->db_table_name = getTablePrefix() . SCAPTCHA_TABLE;
			$this->adminOptions = $this->getAdminOptions();
			register_activation_hook(THIS_DIR . '/super-captcha.php',			            array(&$this,"install_on_activation"));
			if( getConfigVal( 'sef::URL' ) == 'true' )
				{
           			add_action( "init",                                     				array(&$this,"rewrite_img"));
				}
			if(getConfigVal('config::version') != SCAPTCHA_VERSN)
				{ // If it is an upgrade or new install, admins will get a notice to upgrade/fix the tables.
				add_action("network_admin_notices", 				                        array(&$this,"scaptcha_upgrade_notice"));
				}
			elseif($this->sanity_check() == true)
				{ // displays a message if the system detects errors in configruation.
				add_action("network_admin_notices", 				                        array(&$this,"scaptcha_sainity_notice"));
				}
				add_action("edit_user_profile", 						                    array(&$this,"my_show_extra_profile_fields"));
				add_action("edit_user_profile_update", 					                    array(&$this,"my_save_extra_profile_fields"));
			add_action("admin_init", 								                        array(&$this,"get_thickbox"));
			if ( is_multisite() ) // This set displays stats properly between muti-site and single-site configs.
				{
				add_action("network_admin_menu", 					                        array(&$this,"configure_pages"));
				add_action("mu_activity_box_end", 					                        array(&$this,"sCaptcha_stats"));
				} else {
				add_action("activity_box_end", 						                        array(&$this,"sCaptcha_stats"));
				add_action("admin_menu", 							                        array(&$this,"configure_pages"));
				}
			// silently "catches" failed signups and records them in the stats.
			add_action("wp_footer", 								                        array(&$this,"capsure_user"));
			add_action("admin_footer", 								                        array(&$this,"capsure_user"));
			add_action("wp_footer", 								                        array(&$this,"copyright_credits")); 
            // REMOVAL OF THIS LINE OF CODE WILL RESULT IN COPYRIGHT VIOLATIONS -- AS YOU ARE ALLOWED TO RETAIN A COPY OF THIS SOFTWARE FROM THE AUTHOR WHILE THIS IS IN TACT.  REMOVAL WILL REVOLK THAT PRIVLAGE.
			// Carries out actions based on the configurations.
			if(getConfigVal('display::sgup') == 'true')
				{
				if(function_exists('bp_include'))
					{
					add_action('bp_before_registration_submit_buttons',                     array( &$this, 'signup_bpform' ));
					add_action('bp_signup_validate', 				                        array( &$this, 'signup_bppost'));
					}
				elseif(function_exists('signup_extra_fields'))
					{
					add_action('signup_extra_fields', 				                        array( &$this, 'signup_form' ));    // add image and input field to signup form
					add_filter('wpmu_validate_user_signup', 		                        array( &$this, 'signup_mupost'));    // add post signup post security code check
					} else {
					add_action('register_form', 					                        array( &$this, 'signup_form' ));    // add image and input field to signup form
					add_filter('registration_errors', 				                        array( &$this, 'signup_post'));    // add post signup post security code check
					}
				}
			if(getConfigVal('display::blog') == 'true')
				{
				add_filter('wpmu_validate_blog_signup',	 		                            array(&$this,'filter_new_signup_criterias'));
				add_action('signup_blogform',					                            array(&$this,'buddypress_new_blog_creation'));		
				}
			if(getConfigVal('display::login') == 'true')
				{
				add_action('login_form', 							                        array( &$this, 'wpmulogin_form' ) ); //add captcha into login form
				add_filter('wp_authenticate', 						                        array( &$this, 'wpmulogin_authenticate')); // add post login security code check
				}
			}
		// Error and admin upgrade notices.
        function rewrite_img()
            {
            add_rewrite_rule('^scaptcha/([^/]*)/([^/]*)/?', THIS_DIR . '/super-captcha.php?sid=$matches[1]&img=$matches[2]','top');
            }
		function scaptcha_upgrade_notice()
			{
			echo '<div class="error fade" style="background-color:red;"><p><strong>Your Super CAPTCHA tables aren\'t up-to-date. 
			<a href="admin.php?page=super-captcha/Configure&upgrade=1">Upgrade Now</a>.
			Installed version: Database version: v' . getConfigVal('config::version') . '; Software version: v' . SCAPTCHA_VERSN . '.
			</strong></p></div>';
			}
		function scaptcha_sainity_notice()
			{
			echo '<div class="error fade" style="background-color:red;"><p><strong>Your Super CAPTCHA installation seems to be in disarray.
			Attempt to "<a href="admin.php?page=super-captcha/Configure&upgrade=2">Auto-Fix</a>" now?</strong></p></div>';
			}
		function sanity_check()
			{
			global $wpdb;
			$main_table_name = (getTablePrefix() . SCAPTCHA_TABLE);
			$logs_table_name = (getTablePrefix() . SCAPTCHA_TABLE . '_logs');
			$mainq = ("SHOW TABLES LIKE '" . getTablePrefix() . SCAPTCHA_TABLE . "'");
			$logq = ("SHOW TABLES LIKE '" . getTablePrefix() . SCAPTCHA_TABLE . "_logs'");
			if($wpdb->get_var($mainq) != $main_table_name || $wpdb->get_var($logq) != $logs_table_name)
				{
				return true;
				}
			$confs = conf_array();
			foreach($confs as $key => $val)
				{
				$sql = ("SELECT * FROM `" . getTablePrefix() . SCAPTCHA_TABLE . "` WHERE `conf_key`='". $key ."'");
				$query = mysql_fetch_array(mysql_query($sql));
				if($query['conf_key'] != $key)
					{
					return true;
					}
				}
			}
		function SCfixAll()
			{
			global $wpdb;
			$main_table_name = (getTablePrefix() . SCAPTCHA_TABLE);
			$logs_table_name = (getTablePrefix() . SCAPTCHA_TABLE . '_logs');
			$mainq = ("SHOW TABLES LIKE '" . getTablePrefix() . SCAPTCHA_TABLE . "'");
			$logq = ("SHOW TABLES LIKE '" . getTablePrefix() . SCAPTCHA_TABLE . "_logs'");
			if($wpdb->get_var($mainq) != $main_table_name)
				{
				$sql = ("CREATE TABLE " . getTablePrefix() . SCAPTCHA_TABLE . " (
						conf_id mediumint(9) NOT NULL AUTO_INCREMENT,
						conf_key VARCHAR(255),
						conf_val VARCHAR(255),
						UNIQUE KEY conf_id (conf_id),
						UNIQUE KEY conf_key (conf_key)
						);");
				$ret .= ('<h2>Resotring Main Table</h2>');
				$ret .= mysql_query($sql);
				$ret .= ('Done!');
				$ret .= ('<h2>Resotring Defaults</h2>');
				$ret .= restoreDefaults();
				$ret .= ('Done!');
				} else {
				$ret .= upgradeDB();
				}
			if($wpdb->get_var($logq) != $logs_table_name)
				{
				$sql2 = ("CREATE TABLE " . getTablePrefix() . SCAPTCHA_TABLE . "_logs (
						log_id mediumint(9) NOT NULL AUTO_INCREMENT,
						log_user VARCHAR(255),
						log_ip VARCHAR(255),
						log_time INT(30),
						log_host TEXT,
						log_browser TEXT,
						log_form TEXT,
						UNIQUE KEY log_id (log_id)
						);");
				$ret .= ('<h2>Resotring Log Table</h2>');
				$ret .= mysql_query($sql2);
				$ret .= ('Done!');
				}
			return $ret;
			}
		function configure_pages()
			{
			add_menu_page('sCAPTCHA', 'sCAPTCHA', 10, "super-captcha", array(&$this,"configure_page_1"));
			add_submenu_page("super-captcha", "Configure", "Configure", 10, "super-captcha/Configure", array(&$this,"configure_page_4"));
			add_submenu_page("super-captcha", "Logs", "Logs", 10, "super-captcha/Logs", array(&$this,"configure_page_9"));
			add_submenu_page("super-captcha", "Help Me!", "Help Me!", 10, "super-captcha/Help", array(&$this,"help_page"));
			}
		function getAdminOptions()
			{ // This is just for testing right now...
			$adminOptions = array("optionName" => "Value",
			"optionName2" => "Value",
			"optionName3" => "Value");
			$savedOptions = get_option($this->adminOptionsName);
			if (!empty($savedOptions))
				{
				foreach ($savedOptions as $key => $option)
					{
					$adminOptions[$key] = $option;
					}
				}
			update_option($this->adminOptionsName, $adminOptions);
			return $adminOptions;
			}
		function configure_page_1()
			{ // Welcome Page.
			if(getPage('PageHome') != TRUE)
				{
				echo(ERROR_MSG);
				}
			}
		function help_page()
			{
			if(getPage('PageSpamHelp') != TRUE)
				{
				echo(ERROR_MSG);
				}
			}
		function configure_page_4()
			{
			if(isset($_POST['Save']))
				{
				echo(runUpdates());
				?>
				<h1>Settings Saved!</h1>
				<?php
				}
			elseif(isset($_POST['Default']))
				{
				restoreDefaults();
				// Restore the words.txt file.			
				?>
				<h1>Defaults Restored!</h1>
				<?php
				}
			// The Main Configuration Page.
			if(!empty($_REQUEST['upgrade']) && $_REQUEST['upgrade'] == 1)
				{
				echo(upgradeDB());
				}
			elseif(!empty($_REQUEST['upgrade']) && $_REQUEST['upgrade'] == 2)
				{
				echo($this->SCfixAll());
				}
			if(getPage('PageConfig') != TRUE)
				{
				echo(ERROR_MSG);
				}
			}
		///////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// NEW FUNCTIONS
		///////////////////////////////////////////////////////////////////////////////////////////////////////////////
		function my_show_extra_profile_fields( $user )
			{
			global $wpdb;
			$sql = ("SELECT * FROM `". $wpdb->users ."` WHERE `ID`='". $user->ID ."'");
			$result = mysql_fetch_array( mysql_query( $sql ) );
			if($result['spam'] == '1')
				{
				$spamText = (' checked="yes"');
				} else {
				$spamText = NULL;
				}
			?>
			<h3>Administrative</h3>
				<table class="form-table">
					<tr>
						<th><label for="Spamer">Spamer</label></th>
						<td>
							<input type="checkbox" name="Spamer" id="Spamer"<?php echo($spamText); ?> />
							<span class="description">Mark user as spammer.</span>
						</td>
					</tr>
					<tr>
						<th><label for="Credits">Super Captcha</label></th>
						<td>
							This section is created by the Super-Captcha plugin.  Setting someone as a spammer can be undone, however while they are set as a spammer they will be unable to create new blogs, logged in or NOT!
						</td>
					</tr>

				</table>
			<?php
			}
		function my_save_extra_profile_fields( $user_id )
			{
			global $wpdb;
			$sql = ("SELECT * FROM `". $wpdb->users ."` WHERE `ID`='". $user_id ."'");
			$result = mysql_fetch_array( mysql_query( $sql ) );
			if ( !current_user_can( 'edit_user', $user_id ) )
				return false;
			//update_usermeta( $user_id, 'twitter', $_POST['twitter'] );
			if(isset($_POST['Spamer']))
				{
				$posted = 1;
				} else {
				$posted = 0;
				}
			mysql_query("UPDATE `". $wpdb->users ."` SET `spam`='". $posted ."' WHERE `ID`='". $user_id ."'");
			mysql_query("UPDATE `". $wpdb->users ."` SET `user_status`='". $posted ."' WHERE `ID`='". $user_id ."'");
			}
		function filter_new_signup_criterias( $errors )
			{
			global $bp, $wpdb;
			if($this->check_ip_ban(0) == TRUE)
				{
				updateHack_Counts('bots::signup');
				echo('<font color="	#FF0000"><strong>Your account is associated with an account that has been banned.</strong><br />Provide
				this to admins should you wish to dispute the decision:<br />
				<em>' . $this->check_ip_ban(1) . '</em></font><br />');
				$errors['errors']->add('captcha', __('BANNED NOTICE: Your account is associated with an account that has been banned.'));
				}
			$valid = $this->check_3dimg($_POST['SpamCode'], $_SESSION['3DCaptchaText']);
			if(!empty($_POST['SpamCode']) && $valid == true)
				{
				unset( $_POST['SpamCode'] );
                unset( $_SESSION['3DCaptchaText'] );
				}
			elseif(!empty($_POST['SpamCode']) && $valid != true)
				{
				updateHack_Counts('bots::signup');
				echo('<font color="	#FF0000"><strong>ERROR:</strong> The security verification code you entered did not match the image.</font><br />');
				$errors['errors']->add('captcha', __('Please enter correct verification.'));
				$_SESSION['capcha'] = 'fail';
                unset( $_SESSION['3DCaptchaText'] );
				}
			elseif(empty($_POST['SpamCode']))
				{
				updateHack_Counts('bots::signup');
				echo('<font color="	#FF0000"><strong>ERROR:</strong> You did not enter a security verification code. Cannot see the code? Try allowing cookies.</font><br />');
				$errors['errors']->add('captcha', __('Please enter correct verification.'));
				$_SESSION['capcha'] = 'fail';
                unset( $_SESSION['3DCaptchaText'] );
				} else {
				echo('<font color="	#FF0000"><strong>ERROR:</strong> Your browser is blocking cookies.</font><br />');
				$errors['errors']->add('captcha', __('Cookie Error -- your Browser is blocking cookies.'));
				updateHack_Counts('bots::signup');
				$_SESSION['capcha'] = 'fail';
                unset( $_SESSION['3DCaptchaText'] );                
				}
			return( $errors );
			}
		function buddypress_new_blog_creation()
			{
			?>
			<script language='JavaScript' type='text/javascript'>
				<!--
				function RegenAntiSpam(){var A=document.getElementById("randomantispam");A.innerHTML='<img src="<?php echo(getPluginURL()); ?>/super-captcha.php?sid=<?php echo md5(uniqid(time())); ?>&img=1" alt="Visual Verification"  style="vertical-align:top;" />'}
				//-->
			</script>
			<?php
			if(getPage('PageSignup') != TRUE)
				{
				echo(ERROR_MSG);
				}
			}
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// END NEW FUNCTIONS
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
		function configure_page_2()
			{ // Readme Page for those that install from Wordpress site without reading first.
			if(getPage('PageReadMe') != TRUE)
				{
				echo(ERROR_MSG);
				}
			}
		function configure_page_9()
			{ // Readme Page for those that install from Wordpress site without reading first.
			if(getPage('PageLogs') != TRUE)
				{
				echo(ERROR_MSG);
				}
			}
		function configure_page_3()
			{ // License Agreement.
			if(getPage('PageLicense') != TRUE)
				{
				echo(ERROR_MSG);
				}
			}
		function capsure_user()
			{
			if ( is_user_logged_in() )
				{
				global $current_user, $wpdb;
				get_currentuserinfo();
				$sql = ("SELECT * FROM `". $wpdb->usermeta ."` WHERE `user_id`='". $current_user->ID ."' AND `meta_key`='logged_ip'");
				//echo($sql);
				$result = mysql_fetch_array( mysql_query( $sql ) );
				if( !empty( $result['meta_value'] ) )
					{
					if($result['meta_value'] != $_SERVER['REMOTE_ADDR'])
						{
						mysql_query("UPDATE `". $wpdb->usermeta ."` SET `meta_value`='". $_SERVER['REMOTE_ADDR'] ."' WHERE `umeta_id`='". $result['umeta_id'] ."'");
						}
					} else {
					mysql_query("INSERT INTO `". $wpdb->usermeta ."` (`user_id`, `meta_key`, `meta_value`) VALUES ('". $current_user->ID ."', 'logged_ip', '". $_SERVER['REMOTE_ADDR'] ."')");
					}
				}
			}
		function copyright_credits()
			{ // DO NOT MODIFY ANYTHING IN THIS FUNCTION!
			// display:none;
			if(getConfigVal('display::copyright') == FALSE)
				{
				$cssBeg = ('<span style="display:none;">');
				$cssEnd = ('</span>');
				} else {
				$cssBeg = NULL;
				$cssEnd = NULL;
				}
			?>
			<p style="text-align:center;"><img src="<?php echo(getPluginURL()); ?>/includes/images/secure_icon.png" alt="Secured for spam by MLW and Associates, LLP's Super CAPTCHA" border="0" />Secured by <strong><a rel="follow" href="http://goldsborowebdevelopment.com/product/super-captcha/">Super-CAPTCHA</a></strong><?php echo($cssBeg); ?> Developed by <a rel="follow" href="http://goldsborowebdevelopment.com">Goldsboro Web Development</a>.<?php echo($cssEnd); ?>.</p>
			<?php
			} // DO NOT MODIFY ANYTHING IN THE ABOVE FUNCTION!
		function sCaptcha_stats()
			{
			$totals = (getConfigVal('bots::signup') + getConfigVal('bots::login'));
			if(getConfigVal('bots::signup') > 0 && getConfigVal('bots::login') > 0)
				{
				$conjunction = (' and ');
				} else {
				$conjunction = NULL;
				}
			if(getConfigVal('bots::signup') == 1)
				{
				$signup_text = ('<strong><a href="admin.php?page=super-captcha/Logs">' . getConfigVal('bots::signup') . '</a></strong> sign-up');
				}
			elseif(getConfigVal('bots::signup') > 1)
				{
				$signup_text = ('<strong><a href="admin.php?page=super-captcha/Logs">' . getConfigVal('bots::signup') . '</a></strong> sign-ups');
				} else {
				$signup_text = NULL;
				}
			if(getConfigVal('bots::login') == 1)
				{
				$login_text = ('<strong><a href="admin.php?page=super-captcha/Logs">' . getConfigVal('bots::login') . '</a></strong> login');
				}
			elseif(getConfigVal('bots::login') > 1)
				{
				$login_text = ('<strong><a href="admin.php?page=super-captcha/Logs">' . getConfigVal('bots::login') . '</a></strong> logins');
				} else {
				$login_text = NULL;
				}
			if ($totals < 1)
				{
				echo('<p><strong><a href="./admin.php?page=super-capcha">Super CAPTCHA</a></strong> has not detected any spam attempts yet.</p>');
				} else {
				echo('<p><strong><a href="./admin.php?page=super-capcha">Super CAPTCHA</a></strong> has blocked ' . $signup_text . $conjunction . $login_text . '.</p>');
				}
			}
		function wpmulogin_form()
			{
			if(getPage('PageLogin') != TRUE)
				{
				echo(ERROR_MSG);
				}
			}
		function get_thickbox()
			{
			//wp_enqueue_script('jquery');
			//wp_enqueue_script('thickbox');
			}
		function wpmulogin_authenticate( $errors )
			{
			if(getConfigVal('captcha::type') == '3-D')
				{
				$valid = $this->check_3dimg($_POST['SpamCode'], $_SESSION['3DCaptchaText']);
				} else {
				$img = new Securimage();
				$valid = $img->check($_POST['SpamCode']);
				}
			if(isset($_POST['SpamCode']))
				{
				if($valid == true)
					{
					unset( $_POST['SpamCode'] );
					} else {
					$errors['login_captcha'] = __('<strong>ERROR</strong>: Please enter correct verification.');
					updateHack_Counts('bots::login');
					}
				}
			elseif(!isset($_POST['SpamCode']) && isset($_POST['log']))
				{
				$errors['login_captcha'] = __('<strong>ERROR</strong>: The verification field is empty.');
				updateHack_Counts('bots::login');
				}
			return $errors;
			}
		function signup_bpform()
			{
			if($this->check_ip_ban(0) == TRUE)
				{
				updateHack_Counts('bots::signup');
				header('Location: ' . getConfigVal('page::userbanned'));
				die();
				}
			?>
			<script language='JavaScript' type='text/javascript'>
				<!--
				function RegenAntiSpam(){var A=document.getElementById("randomantispam");A.innerHTML='<img src="<?php echo(getPluginURL()); ?>/super-captcha.php?sid=<?php echo md5(uniqid(time())); ?>&img=1" alt="Visual Verification"  style="vertical-align:top;" />'}
				//-->
			</script>
			<?php
			if(getPage('PageBPsignup') != TRUE)
				{
				
				}
			}
		function signup_form( $errors )
			{
			// global $errors;
			// $error = $errors->get_error_message('captcha');
			if($this->check_ip_ban(0) == TRUE)
				{
				updateHack_Counts('bots::signup');
				header('Location:' . getConfigVal('page::userbanned'));
				die();
				}
            unset( $_SESSION['3DCaptchaText'] );
			?>
			<script language='JavaScript' type='text/javascript'>
				<!--
				function RegenAntiSpam(){var A=document.getElementById("randomantispam");A.innerHTML='<img src="<?php echo(getPluginURL()); ?>/super-captcha.php?sid=<?php echo md5(uniqid(time())); ?>&img=1" alt="Visual Verification"  style="vertical-align:top;" />'}
				//-->
			</script>
			<?php
			if(getPage('PageSignup') != TRUE)
				{
				echo(ERROR_MSG);
				}
			}
		function signup_bppost()
			{
            $_SESSION['sess_debug'] = $_SESSION['3DCaptchaText'];
			if($this->check_ip_ban(0) == TRUE)
				{
				updateHack_Counts('bots::signup');
				$bp->signup->errors['captcha'] = ('BANNED NOTICE: Your account is associated with an account that has been banned.');
				}
			global $bp;
			$valid = $this->check_3dimg($_POST['SpamCode'], $_SESSION['3DCaptchaText']);
			if(!empty($_POST['SpamCode']) && $valid == true)
				{
                $_SESSION['capcha'] = 'pass';
                unset( $_SESSION['3DCaptchaText'] );
				}
			elseif(!empty($_POST['SpamCode']) && $valid != true)
				{
				updateHack_Counts('bots::signup');
				$bp->signup->errors['captcha'] = ('Please enter correct verification code.'); 
				$_SESSION['capcha'] = 'fail';
                unset( $_SESSION['3DCaptchaText'] );
				}
			elseif(empty($_POST['SpamCode']))
				{
				updateHack_Counts('bots::signup');
				$bp->signup->errors['captcha'] = ('Please enter verification code.');
				$_SESSION['capcha'] = 'fail';
                unset( $_SESSION['3DCaptchaText'] );
				} else {
				$bp->signup->errors['captcha'] = ('Your browser is blocking cookies.  Please enable cookies on this site and try again.');
				updateHack_Counts('bots::signup');
				$_SESSION['capcha'] = 'fail';
                unset( $_SESSION['3DCaptchaText'] );
				}
			return;
			}
		function signup_mupost( $errors )
			{
			if($this->check_ip_ban(0) == TRUE)
				{
				updateHack_Counts('bots::signup');
				$errors['errors']->add('captcha', __('BANNED NOTICE: Your account is associated with an account that has been banned.'));
				}
			if(!isset($_SESSION['capcha']))
				{
				$_SESSION['capcha'] = 'fail';
				}
			elseif(!empty($_POST['SpamCode']))
				{
                $valid = $this->check_3dimg($_POST['SpamCode'], $_SESSION['3DCaptchaText']);
				if($valid == true)
					{
                    unset( $_SESSION['3DCaptchaText'] );
					$_SESSION['capcha'] = 'pass';
					} else {
                    unset( $_SESSION['3DCaptchaText'] );
					updateHack_Counts('bots::signup');
					$errors['errors']->add('captcha', __('Please enter correct verification.'));
					$_SESSION['capcha'] = 'fail';
					}
				}
			elseif(empty($_POST['SpamCode']))
				{
				updateHack_Counts('bots::signup');
				$errors['errors']->add('captcha', __('Please enter verification.'));
				$_SESSION['capcha'] = 'fail';
                unset( $_SESSION['3DCaptchaText'] );
				}
			return( $errors );
			}
		function check_3dimg($val, $val2 = false)
			{
			if($val == $val2)
				{
				return true;
				} else {
				return false;
				}
			}
		function signup_post( $errors )
			{
			if($this->check_ip_ban(0) == TRUE)
				{
				updateHack_Counts('bots::signup');
				$errors['errors']->add('captcha', __('BANNED NOTICE: Your account is associated with an account that has been banned.'));
				}
			if(!isset($_SESSION['capcha']))
				{
				$_SESSION['capcha'] = 'fail';
				}
			elseif(!empty($_POST['SpamCode']))
				{
                $valid = $this->check_3dimg($_POST['SpamCode'], $_SESSION['3DCaptchaText']);
				if($valid == true)
					{
                    unset( $_SESSION['3DCaptchaText'] );
					unset( $_POST['SpamCode'] );
					$_SESSION['capcha'] = 'pass';
					} else {
                    unset( $_SESSION['3DCaptchaText'] );
					updateHack_Counts('bots::signup');
					$errors->add('captcha', __('Please enter correct verification.'));
					$_SESSION['capcha'] = 'fail';
					}
				}
			elseif(empty($_POST['SpamCode']))
				{
                unset( $_SESSION['3DCaptchaText'] );
				updateHack_Counts('bots::signup');
				$errors->add('captcha', __('Please enter verification.'));
				$_SESSION['capcha'] = 'fail';
				}
			return( $errors );
			}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// NEW FUNCTION                                                                                           //      
		////////////////////////////////////////////////////////////////////////////////////////////////////////////
		function check_ip_ban($val)
			{
			global $wpdb;
			$sql = ("SELECT * FROM `". $wpdb->usermeta ."` WHERE `meta_value`='". $_SERVER['REMOTE_ADDR'] ."' AND `meta_key`='logged_ip'");
			$sqlQ = mysql_query( $sql );
			while( $result = mysql_fetch_array($sqlQ) )
				{
				$sql2 = ("SELECT * FROM `". $wpdb->users ."` WHERE `ID`='". $result['user_id'] ."'");
				$sql2Q = mysql_query( $sql2 );
				while( $result2 = mysql_fetch_array($sql2Q) )
					{
					if($result2['spam'] == 1 || $result2['deleted'] == 1)
						{
						$spam = NULL;
						$deleted = NULL;
						if($result2['spam'] == 1)
							{
							$spam .= (' spam');
							}
						if($result2['deleted'] == 1)
							{
							$spam .= (' deleted');
							}
						$diag .= ('<strong>'. $result2['user_login'] .'</strong> marked as:'. $spam .' and associated with '. $_SERVER['REMOTE_ADDR'] .'.<br />');
						if(!isset($ret))
							{
							$ret = 1;
							}
						}
					}
				}
			if(!isset($ret) & $val != 1)
				{
				return FALSE;
				} 
			elseif(isset($ret) & $val != 1)
				{
				return TRUE;
				}
			elseif(isset($ret) & $val == 1)
				{
				return $diag;
				}
			}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// END NEW FUNCTION                                                                                       //      
		////////////////////////////////////////////////////////////////////////////////////////////////////////////
		function install_on_activation()
			{
			chmod(THIS_DIR, 0755);
			chmod(THIS_DIR . '/super-captcha.php', 0755);
			chmod(THIS_DIR . '/includes', 0755);
			chmod(THIS_DIR . '/includes/elephant.ttf', 0755);
			chmod(THIS_DIR . '/includes/images', 0755);
			chmod(THIS_DIR . '/includes/images/audio_icon.gif', 0755);
			chmod(THIS_DIR . '/includes/images/refresh.gif', 0755);
			chmod(THIS_DIR . '/includes/words/words.txt', 0755);
			$plugin_db_version = SCAPTCHA_VERSN;
			$installed_ver = SCAPTCHA_DBV;
			if ($installed_ver === false || $installed_ver != $plugin_db_version)
			// this statement was hosed on the upgrade.  Its been fixed!
				{
				$sql = "DROP TABLE IF EXISTS " . $this->db_table_name . ";
				
				CREATE TABLE " . $this->db_table_name . " (
				conf_id mediumint(9) NOT NULL AUTO_INCREMENT,
				conf_key VARCHAR(255),
				conf_val VARCHAR(255),
				UNIQUE KEY conf_id (conf_id),
				UNIQUE KEY conf_key (conf_key)
				);
				
				DROP TABLE IF EXISTS " . $this->db_table_name . "_logs;
				
				CREATE TABLE " . $this->db_table_name . "_logs (
				log_id mediumint(9) NOT NULL AUTO_INCREMENT,
				log_user VARCHAR(255),
				log_ip VARCHAR(255),
				log_time INT(30),
				log_host TEXT,
				log_browser TEXT,
				log_form TEXT,
				UNIQUE KEY log_id (log_id)
				);
				
				";
				require_once(ABSPATH . "wp-admin/upgrade-functions.php");
				dbDelta($sql);
				echo(installDB());
				echo(updateConfigs('config::version',$plugin_db_version));
				}
			}
		}
?>