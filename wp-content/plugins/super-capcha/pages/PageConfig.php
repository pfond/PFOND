<?php 
if (!is_super_admin( get_current_user_id() )) header("HTTP/1.1 403 Forbidden")&die('Direct access not allowed!');
include_once('PageNav.php'); 
?>
			<h2>Configuration</h2>			<div style="display: inline; float: right; margin-right:10px; width: 256px;">			<strong>Live View</strong><br />
			<?php
			if( getConfigVal( 'sef::URL' ) == 'true' )
				{
           			?> <img src="/scaptcha/<?php echo md5(uniqid(time())); ?>/1/" alt="Visual Verification" style="vertical-align:top;" /> <?php
				} else {
				?> <img src="<?php echo(getPluginURL()); ?>/super-captcha.php?sid=<?php echo md5(uniqid(time())); ?>&img=1" alt="Visual Verification" style="vertical-align:top;" /> <?php
				} ?><br />WARNING: If you see no image above, or you see no words on the image above, uncheck or DO NOT CHECK the "Login Page" option or you will risk being locked out of your wordpress system.</div>            <div style="position:relative; float: left;">
			<form action="" method="post">			<table>
				<tr>
					<td>
						<input type="submit" class="button-primary" name="Save" value="Save Changes" />
					</td>
					<td>
						<input type="submit" class="button-secondary" name="Default" value="Restore Defaults" />
					</td>
				</tr>
			</table>			<table width="100%">			  <tbody>				<tr>				  <td width="150" valign="top">					<strong>Display:</strong>				  </td>				  <td width="100" valign="top">					&nbsp;				  </td>				  <td>				  				  </td>				</tr>				<tr>				  <td valign="top">					<em> &nbsp; Copyright:</em>				  </td>				  <td valign="top">					<input type="checkbox" name="display::copyright" <?php echo(checkIt('display::copyright')); ?> />				  </td>				  <td>				  				  </td>				</tr>				<tr>				  <td valign="top">					<em> &nbsp; Login Page:</em>				  </td>				  <td valign="top">					<input type="checkbox" name="display::login" <?php echo(checkIt('display::login')); ?> /> Note: Ensure image to the right is visible.				  </td>				  <td>				  				  </td>				</tr>				<tr>				  <td valign="top">					<em> &nbsp; Registration Page:</em>				  </td>				  <td valign="top">					<input type="checkbox" name="display::sgup" <?php echo(checkIt('display::sgup')); ?> />				  </td>				  <td>				  				  </td>				</tr>				<tr>				  <td valign="top">					<em> &nbsp; Blog Creation Page:</em>				  </td>				  <td valign="top">					<input type="checkbox" name="display::blog" <?php echo(checkIt('display::blog')); ?> /><br /><strong>Buddypress Only</strong> Ensures each blog creation is done so manually; else someone can manually create an account and have a bot to use that account to create spam blogs.
				  </td>
				  <td>
                  </td>				</tr>				<tr>				  <td width="150" valign="top">					&nbsp;			  </td>				  <td width="100" valign="top">					&nbsp;				  </td>				  <td>				  				  </td>				</tr>				<tr>				  <td width="150" valign="top">					<em> &nbsp; Font Path:</em>				  </td>				  <td width="100" valign="top">					<input type="text" name="3dfont::path" value="<?php echo(getConfigVal('3dfont::path')); ?>" /><br />					<em>This is the detected font path and may varry system to system.  Generally this value should be:</em><pre>/home/yourusername/public_html/wp-content/plugins/super-capcha/includes/</pre>				  </td>				  <td>				  				  </td>				</tr>				<tr>				  <td width="150" valign="top">					&nbsp;			  </td>				  <td width="100" valign="top">					&nbsp;				  </td>				  <td>				  				  </td>				</tr>				<tr>				  <td width="150" valign="top">					<em> &nbsp; Font Name:</em>				  </td>				  <td width="100" valign="top">					<select name="3dfont::name">                      <?php echo(GetfontList(getConfigVal('3dfont::path'))); ?>					</select><br />					<em>Choose a font face. Don't see anything listed here? Your Font Path above is WRONG. Double check it.</em>				  </td>				  <td>				  				  </td>				</tr>				<tr>				  <td width="150" valign="top">					&nbsp;			  </td>				  <td width="100" valign="top">					&nbsp;				  </td>				  <td>				  				  </td>				</tr>				<tr>				  <td width="150" valign="top">					<em> &nbsp; Background Type:</em>				  </td>				  <td width="100" valign="top">					<select name="3dbackground::name">                      <?php echo(GetBGList(getConfigVal('3dfont::path'))); ?>					</select><br />					<em>Don't see anything listed here? Your Font Path above is WRONG. Double check it.</em><br />                    <?php echo(GetBGThumbs(getConfigVal('3dfont::path'))); ?>				  </td>				  <td>				  				  </td>				</tr>				<tr>				  <td valign="top">					<em> &nbsp; BG Distortion:</em>				  </td>				  <td valign="top">					<input type="checkbox" name="3dbackground::distort" <?php echo(checkIt('3dbackground::distort')); ?> />				  </td>				  <td>				  				  </td>				</tr>				<tr>				  <td width="150" valign="top">					&nbsp;			  </td>				  <td width="100" valign="top">					&nbsp;				  </td>				  <td>				  				  </td>				</tr>
			<tr>				  <td width="150" valign="top">					<strong>SEF Image:</strong>				  </td>				  <td width="100" valign="top">                   
				<select name="sef::URL">					  <option value="true"<?php echo(selectIt('sef::URL','true')); ?>>On</option>					  <option value="false"<?php echo(selectIt('sef::URL','false')); ?>>Off</option>					</select><br /><em>This is still buggy with multi-sites.  If an image does not show when turned on, turn it off to prevent lockout.</em>				  </td>
			</tr>
			<tr>				  <td width="150" valign="top">					&nbsp;				  </td>				  <td width="100" valign="top">					&nbsp;				  </td>				  <td>				  				  </td>				</tr>
			<tr>				  <td width="150" valign="top">					<strong>CAPTCHA Type:</strong>				  </td>				  <td width="100" valign="top">                   <input type="hidden" value="3-D" name="captcha::type" />
                   <em>Standard 2-D CAPTCHA no longer supported.  See Super CAPTCHA v2.2.0 for 2-D Support.</em>				  </td>
			</tr>
			<tr>
				<td colspan="2">
					<table>
						<tr>
							<td>
								<input type="submit" class="button-primary" name="Save" value="Save Changes" />
							</td>
							<td>
								<input type="submit" class="button-secondary" name="Default" value="Restore Defaults" />
							</td>
						</tr>
					</table>
					</td>
			</tr>
			<tr>				  <td width="150" valign="top">					&nbsp;				  </td>				  <td width="100" valign="top">					&nbsp;				  </td>				  <td>				  				  </td>				</tr>                                
<?php
if(getConfigVal('captcha::type') == '3-D')
	{
?>

<?php
	} else {
?>
<?php
	}
?>
				<tr>
				  <td valign="top">
					<strong>IP Filtering</strong>
				  </td>
				  <td valign="top">
				  </td>
				  <td>
				  
				  </td>
				<tr>
				  <td valign="top">
					<em>Enable IP Filter:</em>
				  </td>
				  <td valign="top">                    <input type="checkbox" name="page::userbanned::status" <?php echo(checkIt('page::userbanned::status')); ?> /><br />					<em>If enabled, this feature will re-direct anyone attempting to create a blog or a new account that					has had their IP address associated with an account whom has been flagged as a spammer.</em>                    <STRONG>WARNING: DO NOT TURN THIS ON IF YOU ARE USING CLOUD SERVICES LIKE CLOUDFLARE</STRONG>
				  </td>
				  <td>
				  
				  </td>
				</tr>
				<tr>
				  <td width="150" valign="top">
					<em>Banned Message:</em>
				  </td>
				  <td width="100" valign="top">
					<input type="text" name="page::userbanned" value="<?php echo(getConfigVal('page::userbanned')); ?>" /><br />
					Full URL to your page.
				  </td>
				  <td>
				  
				  </td>
				</tr>
			  </tbody>
			</table>
			<table><tr><td><input type="submit" class="button-primary" name="Save" value="Save Changes" /></td><td><input type="submit" class="button-secondary" name="Default" value="Restore Defaults" /></td></tr></table>
			</form>
			</div>