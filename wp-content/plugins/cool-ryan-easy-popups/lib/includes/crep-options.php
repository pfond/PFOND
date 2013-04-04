<?php 
include_once CREP_INC_URL . '/admin.options.php';

/** Save Options */
crepUpdateOptions();

/** Call Tiny MCE */
crepTinyMCE();
?>

<div class="wrap">
  <h2>Cool Ryan Easy Popups</h2>
  <a href="http://www.coolryan.com/plugins/cool-ryan-easy-popups/" target="_blank">Plugin Site</a> | 
  <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=XBV6RBTVKWWMQ" target="_blank">Donate</a>
  <?php crepDisplayMessage();?>
    <form action="<?php echo $_SERVER['REQUEST_URI'];?>" method="POST">
    <table class="form-table">
      <tr valign="top">
        <td colspan="2"><h3>Popup Display</h3></td>
      </tr>
      <tr valign="top">
        <th scope="row">Title</th>
        <td><input type="text" name="crep_title" size="60" value="<?php echo get_option('crep_title');?>" /></td>
      </tr>
      <tr valign="top">
	    <th scope="row">Text</th>
        <td>
        <p align="left">
		  <a class="button toggleVisual">Visual</a>
		  <a class="button toggleHTML">HTML</a>
		</p>
          <textarea class="crep_text" id="crep_text" name="crep_text" style="width:50%;height:250px;"><?php echo stripcslashes(get_option('crep_text'));?></textarea>
        </td>
      </tr>
            <tr valign="top">
	    <th scope="row">Extra Code</th>
        <td>
          <textarea class="crep_code" id="crep_code" name="crep_code" style="width:50%;height:250px;"><?php echo stripcslashes(get_option('crep_code'));?></textarea>
        </td>
      </tr>
      <tr valign="top">
        <td colspan="2"><h3>Display Options</h3></td>
      </tr>
      <tr valign="top">
	    <th scope="row">Show On Home Page?</th>
        <td>
          <input type="radio" name="crep_home_page" value="yes" <?php echo _r(get_option('crep_home_page'), 'yes');?>/>Yes
          <input type="radio" name="crep_home_page" value="no" <?php echo _r(get_option('crep_home_page'), 'no');?>/>No
        </td>
      </tr>
      <tr valign="top">
	    <th scope="row">Show On Pages?</th>
        <td>
          <input type="radio" name="crep_pages" value="yes" <?php echo _r(get_option('crep_pages'), 'yes');?>/>Yes
          <input type="radio" name="crep_pages" value="no" <?php echo _r(get_option('crep_pages'), 'no');?>/>No
        </td>
      </tr>
      <tr valign="top">
	    <th scope="row">Show On Posts?</th>
        <td>
          <input type="radio" name="crep_posts" value="yes" <?php echo _r(get_option('crep_posts'), 'yes');?>/>Yes
          <input type="radio" name="crep_posts" value="no" <?php echo _r(get_option('crep_posts'), 'no');?>/>No
        </td>
      </tr>
      <tr valign="top">
	    <th scope="row">Frequency</th>
        <td>
          Every <input type="text" name="crep_cookie_frequency" size="3" value="<?php echo get_option('crep_cookie_frequency');?>" /> Days
        </td>
      </tr>
      <tr valign="top">
        <td colspan="2"><h3>Style Options</h3></td>
      </tr>
      <tr valign="top">
	    <th scope="row">Popup Style</th>
        <td>
         <?php echo crepStylesDropdown(get_option('crep_style'));?>
        </td>
      </tr>
      <tr valign="top">
	    <th scope="row">Open Animation</th>
        <td>
         <?php echo crepAnimationDropdown(get_option('crep_open_animation'), 'crep_open_animation');?>
        </td>
      </tr>
      <tr valign="top">
	    <th scope="row">Close Animation</th>
        <td>
         <?php echo crepAnimationDropdown(get_option('crep_close_animation'), 'crep_close_animation');?>
        </td>
      </tr>
      <tr valign="top">
	    <th scope="row">Blur Background?</th>
        <td>
          <input type="radio" name="crep_modal" value="true" <?php echo _r(get_option('crep_modal'), 'true');?>/>Yes
          <input type="radio" name="crep_modal" value="false" <?php echo _r(get_option('crep_modal'), 'false');?>/>No
        </td>
      </tr>
      <tr valign="top">
	    <th scope="row">Width</th>
        <td>
          <input type="text" name="crep_width" size="3" value="<?php echo get_option('crep_width');?>" />
        </td>
      </tr>
      <tr valign="top">
	    <th scope="row">Height</th>
        <td>
          <input type="text" name="crep_height" size="3" value="<?php echo get_option('crep_height');?>" />
        </td>
      </tr>
    </table>
    <p class="submit">
	  <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
	</p>
	<input type="hidden" name="submitted" value="crep_update_options" />
  </form>
</div>
