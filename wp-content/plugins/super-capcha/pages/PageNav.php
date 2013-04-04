<?php
if (!is_super_admin( get_current_user_id() )) header("HTTP/1.1 403 Forbidden")&die('Direct access not allowed!');
?>

			<p>
			<table width="100%" border="0" bgcolor="#FFFFFF">
			  <tbody bgcolor="#FFFFFF">
			    <tr>
				  <td width=40><div id="icon-plugins" class="icon32">&nbsp;</div></td>
				  <td width=75><strong><a href="admin.php?page=super-captcha">sCaptcha</a></strong></td>
				  <td width=5>&nbsp;</td>
				  <td width=40><div id="icon-themes" class="icon32">&nbsp;</div></td>
				  <td width=75><strong><a href="http://goldsborowebdevelopment.com/product/super-captcha/">Donate</a></strong></td>
				  <td width=5>&nbsp;</td>
				  <td width=40><div id="icon-tools" class="icon32">&nbsp;</div></td>
				  <td width=75><strong><a href="admin.php?page=super-captcha/Configure">Configure</a></strong></td>
				  <td width=5>&nbsp;</td>
				  <td width=40><div id="icon-edit-pages" class="icon32">&nbsp;</div></td>
				  <td width=75><strong><a href="admin.php?page=super-captcha/Logs">Logs</a></strong></td>
				  <td width=5>&nbsp;</td>
				  <td width=40><div id="icon-edit-comments" class="icon32">&nbsp;</div></td>
				  <td width=75><strong><a href="admin.php?page=super-captcha&amp;readme=true" title="ReadMe">ReadMe</a></strong></td>
				  <td></td>
				</tr>
			  </tbody>
			</table>
			</p>
			<hr />