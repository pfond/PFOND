<?php
/**
 * Frontend Initializatoin
 * @package Easy Popups
 * @since 1.0
 */

/** Include Functions */
include_once CREP_INC_URL . '/common.php';

/** Add Hooks */
add_action('init', 'crepInit');
add_action('wp', 'crepPopup');