			<script language='JavaScript' type='text/javascript'>
				<!--
				function RegenAntiSpam(){var A=document.getElementById("randomantispam");A.innerHTML='<img src="<?php echo(getPluginURL()); ?>/super-captcha.php?sid=<?php echo md5(uniqid(time())); ?>&img=1" alt="Visual Verification" style="vertical-align:top;" />'}
				//-->
			</script>
			<p><label>Anti-Bot Verification<br /><input type="text" name="SpamCode" id="user_login" size="10" tabindex="50" /></label>
			<label><span id="randomantispam"><?php
			if( getConfigVal( 'sef::URL' ) == 'true' )
				{
           			?> <img src="/scaptcha/<?php echo md5(uniqid(time())); ?>/1/" alt="Visual Verification" style="vertical-align:top;" /> <?php
				} else {
				?> <img src="<?php echo(getPluginURL()); ?>/super-captcha.php?sid=<?php echo md5(uniqid(time())); ?>&img=1" alt="Visual Verification" style="vertical-align:top;" /> <?php
				} ?></span>
			<a href="<?php echo(getPluginURL()); ?>/super-captcha.php?audio=1" style="font-size: 13px"><img src="<?php echo(getPluginURL()); ?>/includes/images/audio_icon.png" alt="Audible CAPTCHA" border="0" /></a> 
			<a href="#regenantispam" title="Click here to refresh code" onclick="RegenAntiSpam();"><img src="<?php echo(getPluginURL()); ?>/includes/images/refresh.png" alt="Reload CAPTCHA" border="0" /></a></label></p><br />