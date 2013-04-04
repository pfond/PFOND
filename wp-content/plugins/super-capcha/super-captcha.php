<?php
/*
Plugin Name: WPMU Super Captcha
Plugin URI: http://goldsborowebdevelopment.com/product/super-captcha/
Description: WordPress's FIRST EVER 3-D CAPTCHA that stops spam blogs and registrations COLD.
Author: Goldsboro Web Development
Version: 2.4.2
Author URI: http://goldsborowebdevelopment.com
Please do not delete the credit from mlwassociates.com, thanks!
Donate: http://goldsborowebdevelopment.com/product/super-captcha/
*/
session_start();
ob_start();
require('config.php');
$realPath = str_replace(PATH_TO_SCAPTCHA . '/super-captcha.php', '', $_SERVER["SCRIPT_FILENAME"]);
$scaptchaconfinclude = $realPath . '/wp-config.php';
if( file_exists( $scaptchaconfinclude ) && isset( $_REQUEST['img'] ) )
		{
		require($scaptchaconfinclude);
		}
elseif(!file_exists( $scaptchaconfinclude ) && isset( $_REQUEST['img'] ) )
        {
        echo('CANNOT FIND CONFIG FILE AT: '. $scaptchaconfinclude .'... EXITING...');
        exit;
        }
define("SCAPTCHA_VERSN", "2.4.2");
define("SCAPTCHA_TABLE", "scaptcha");
define( "THIS_DIR", WP_PLUGIN_DIR . "/super-capcha" );
// Preparing the image...
require('functions/main.php');
if(isset($_REQUEST['sid']) && isset($_REQUEST['img']) && !isset($_POST['SpamCode']) && getConfigVal('captcha::type') == '3-D')
    {
    add_action('wp_dashboard_setup', 'mlw_db_widget');
    }
define('ERROR_MSG',             '<h2>ERROR</h2> There was an error in aquiring this page.  Please check your plugin installation or licensing of this software.');
define('BAN_LOC',		        getConfigVal('page::userbanned'));
define('CAPTCHA_3DFONT_FILE',   getConfigVal('3dfont::path') . getConfigVal('3dfont::name'));
define('CAPTCHA_3DBACKGROUND_FILE', getConfigVal('3dbackground::name'));
// Start up the plugin...
require_once('classes/render.php');
require_once('classes/3dsimage.php');
// Getting the image

new RandomCaptchaSpam();
?>