<?php
/**
 * dynwid_admin.php - Startpage for admin
 *
 * @version $Id: dynwid_admin.php 426716 2011-08-21 14:48:48Z qurl $
 * @copyright 2011 Jacco Drabbe
 */
?>

<form id="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
">
</form>

<div class="wrap">
<div class="icon32" id="icon-themes"><br></div>
<h2>
	<?php _e('Dynamic Widgets', DW_L10N_DOMAIN); ?>
	<input type="image" style="vertical-align: middle;" title="Donate for this plugin via PayPal" alt="Donate" name="submit" src="https://www.paypal.com/en_US/i/btn/x-click-but04.gif" onclick="jQuery('#paypal').submit()">
</h2>
<?php
	if ( DW_CLASSFILE == 'dynwid_class_php4.php' ) {
		$mbox = new DWMessageBox();
		$mbox->create('WARNING', 'Your server is running PHP4. Future versions of Dynamic Widgets will not work. See the <a href="' . DW_URL . '/dynamic-widgets/faq/" target="_blank">FAQ</a>.');	
	}
	
	if ( $DW->enabled ) {
		if ( dynwid_sql_mode() ) {
			echo '<div class="error" id="message"><p>';
			_e('<b>WARNING</b> STRICT sql mode in effect. Dynamic Widgets might not work correctly. Please disable STRICT sql mode.', DW_L10N_DOMAIN);
			echo '</p></div>';
		}

		// Actions
		if ( isset($_GET['action']) && $_GET['action'] == 'edit' ) {
			$dw_admin_script = '/dynwid_admin_edit.php';
		} else {
			$dw_admin_script = '/dynwid_admin_overview.php';

			// Do some housekeeping
			$lastrun = get_option('dynwid_housekeeping_lastrun');
			if ( time() - $lastrun > DW_TIME_LIMIT ) {
				$DW->housekeeping();
				update_option('dynwid_housekeeping_lastrun', time());
			}
		}
		require_once(dirname(__FILE__) . $dw_admin_script);
	} else {
		echo '<div class="error" id="message"><p>';
		_e('Oops! Something went terrible wrong. Please reinstall Dynamic Widgets.', DW_L10N_DOMAIN);
		echo '</p></div>';
	}
?>

<!-- Footer //-->
<div class="clear"><br /><br /></div>
<div><small>
  <a href="<?php echo DW_URL; ?>/dynamic-widgets/" target="_blank">Dynamic Widgets</a> v<?php echo DW_VERSION; ?> (<?php echo ( DW_CLASSFILE == 'dynwid_class_php4.php' ? 'PHP4' : 'PHP5' ) . ', ' . ( DW_OLD_METHOD ? __('OLD', DW_L10N_DOMAIN)  : __('FILTER', DW_L10N_DOMAIN) ); ?>)
</small></div>

</div> <!-- /wrap //-->