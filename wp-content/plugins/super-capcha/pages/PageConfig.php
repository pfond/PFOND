<?php 
if (!is_super_admin( get_current_user_id() )) header("HTTP/1.1 403 Forbidden")&die('Direct access not allowed!');
include_once('PageNav.php'); 
?>
			<h2>Configuration</h2>
			<?php
			if( getConfigVal( 'sef::URL' ) == 'true' )
				{
           			?> <img src="/scaptcha/<?php echo md5(uniqid(time())); ?>/1/" alt="Visual Verification" style="vertical-align:top;" /> <?php
				} else {
				?> <img src="<?php echo(getPluginURL()); ?>/super-captcha.php?sid=<?php echo md5(uniqid(time())); ?>&img=1" alt="Visual Verification" style="vertical-align:top;" /> <?php
				} ?><br />WARNING: If you see no image above, or you see no words on the image above, uncheck or DO NOT CHECK the "Login Page" option or you will risk being locked out of your wordpress system.</div>
			<form action="" method="post">
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
				  <td>
                  </td>
			<tr>
				<select name="sef::URL">
			</tr>
			<tr>
			<tr>
                   <em>Standard 2-D CAPTCHA no longer supported.  See Super CAPTCHA v2.2.0 for 2-D Support.</em>
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
			<tr>
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
				  <td valign="top">
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