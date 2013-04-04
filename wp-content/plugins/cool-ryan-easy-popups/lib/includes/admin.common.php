<?php
/**
 * Common Admin Functions Including Main Handler Function CREP
 * @package Easy Popups
 * @subpackage Admin
 * @since 1.0
 */


/**
 * Register The Options Page
 * @name CREP Register Options Page
 * @since 1.0
 */
function crepRegisterOptionsPage() {
	add_options_page( 'Cool Ryan Easy Popups Options', 'Easy Popups', 'manage_options', 'easy-popups', 'crepIncludeOptionsPage'); 
}

/**
 * Include the file for the options page
 * @name CREP Include Options Page
 * @since 1.0
 */
function crepIncludeOptionsPage() {
	include CREP_INC_URL . '/crep-options.php';
}


/**
 * Adds Appropriate Admin Javascript
 * @name CREP JS
 * @since 1.0
 */
function crepAdminJS() {
	wp_enqueue_script('tiny_mce'); // Tiny MCE
	wp_enqueue_script('jquery'); // JQuery
}

/**
 * Javascript that toggles Tiny MCE Editor
 * @name CREP Toggle Editor JS
 * @since 1.0
 */
function crepToggleEditorJS() {
	$js = <<<JS
	<script type="text/javascript">
	jQuery(document).ready(function($) {

	var id = 'crep_text';

	$('a.toggleVisual').click(
		function() {
			tinyMCE.execCommand('mceAddControl', false, id);
		}
	);

	$('a.toggleHTML').click(
		function() {
			tinyMCE.execCommand('mceRemoveControl', false, id);
		}
	);

});
</script>
JS;

	echo $js;
}

?>