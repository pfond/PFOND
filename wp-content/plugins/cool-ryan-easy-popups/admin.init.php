<?php
/**
 * Administration Initialization
 * @package Easy Popups
 * @subpackage Admin
 * @since 1.0
 */


/** Include Functions */
include_once CREP_INC_URL . '/admin.common.php'; // Common Functions


/** Initialize The Admin Hooks */
add_action('admin_init', 'crepAdminJS');
add_action('admin_menu', 'crepRegisterOptionsPage');
add_action('admin_footer', 'crepToggleEditorJS');
?>
