<div id="profile-details-section" class="register-section">    <h4>Anti-Bot Verification</h4>
    <?php
			if(!empty($_POST) && $_SESSION['capcha'] == 'fail')
				{
				?>
				
				<div class="error">Empty or Incorrect Code!</div>
				<?php
                }
				?>
        <span id="randomantispam"><?php
			if( getConfigVal( 'sef::URL' ) == 'true' )
				{
           			?> <img src="/scaptcha/<?php echo md5(uniqid(time())); ?>/1/" alt="Visual Verification" style="vertical-align:top;" /> <?php
				} else {
				?> <img src="<?php echo(getPluginURL()); ?>/super-captcha.php?sid=<?php echo md5(uniqid(time())); ?>&img=1" alt="Visual Verification" style="vertical-align:top;" /> <?php
				} ?></span>
    <div class="editfield">
            <label for="SpamCode">Type the word above</label>
			<input type="text" name="SpamCode" id="user_name" class="input" size="10" tabindex="50" />
</div>