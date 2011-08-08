<?php

bpModLoader::load_class( 'bpModAbstractCore' );

/**
 * bpModInstaller
 *
 * installer/upgrader/uninstaller of bp-moderation
 *
 * note: this class must be compatible with both wp&wpmu, don't relay on bp here
 *
 * @author Francesco
 */
class bpModInstaller extends bpModAbstractCore {

	function  __construct(){
		global $wpdb;

		//bp-core-wpabstraction may not be loaded
		if( !isset( $wpdb->base_prefix )) $wpdb->base_prefix = $wpdb->prefix;
		
		parent::__construct();
	}

	/**
	 * Runned on activation
	 */
    function activate(){

		if ( defined('BP_VERSION') && version_compare(BP_VERSION, $this->min_bp_ver,'>=')) {

			if( get_site_option('bp_moderation_db_version') < $this->db_ver )
				$this->install();

		} else {
			if ( ! function_exists ( 'deactivate_plugins' ) )
				include ( ABSPATH . 'wp-admin/includes/plugin.php' );
			deactivate_plugins ( bpModLoader::file() );

			die( $this->compatibility_notice() );

		}
	}

	/**
	 * Runned on deactivation
	 */
	function deactivate(){
		$opts = get_site_option('bp_moderation_options');
		if ( isset($opts['clean_up']) && 'on' == $opts['clean_up'] )
			$this->clean_up();
	}


	function uninstall(){
		//testing if get called correctly
		add_site_option('bp_moderation_uninstaller', 'Im uninstalled');
	}

	/**
	 * Install/upgrade db tables, options...
	 */
	function install(){

		// create/update db tables
		global $wpdb;

		$charset_collate = '';
		if ( ! empty($wpdb->charset) )
			$charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
		if ( ! empty($wpdb->collate) )
			$charset_collate .= " COLLATE $wpdb->collate";

		$sql = array();
		$stati_set = "'".join("','",array_keys($this->content_stati))."'";
		$sql[] = "CREATE TABLE {$this->contents_table} (
			`content_id` BIGINT(20) unsigned NOT NULL auto_increment,
			`item_type` VARCHAR(42) NOT NULL default '',
			`item_id` BIGINT(20) unsigned NOT NULL default 0,
			`item_id2` BIGINT(20) unsigned NOT NULL default 0,
			`item_author` BIGINT(20) unsigned NOT NULL default 0,
			`item_date` DATETIME NOT NULL default '0000-00-00 00:00:00',
			`item_url` VARCHAR(250) NOT NULL default '',
			`status` ENUM($stati_set) NOT NULL default 'new',
			PRIMARY KEY  (content_id),
			KEY item_type (item_type),
			KEY item_id (item_id),
			KEY item_id2 (item_id2),
			KEY item_author (item_author),
			KEY item_date (item_date),
			KEY status (status)
			) {$charset_collate};";
			
		$sql[] = "CREATE TABLE {$this->flags_table} (
			`flag_id` BIGINT(20) unsigned NOT NULL auto_increment,
			`content_id` BIGINT(20) unsigned NOT NULL default 0,
			`reporter_id` BIGINT(20) unsigned NOT NULL default 0,
			`date` DATETIME NOT NULL default '0000-00-00 00:00:00',
			PRIMARY KEY  (flag_id),
			KEY content_id (content_id),
			KEY reporter_id (reporter_id),
			KEY date (date)
			) {$charset_collate};";


		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

		dbDelta($sql);

		// store/update options in a site option
		$options = get_site_option( 'bp_moderation_options');
		// if options didn't exist set it as an empty array
		$options or $options = array();
		
		// activate all types if first install, instead if it is an upgrade leave active_types as before
		if ( !get_site_option('bp_moderation_db_version') ){
			$options['active_types'] = array();

			foreach (array('status_update','activity_comment','blog_post','blog_comment','member','group','forum_post') as $t)
				$options['active_types'][$t] = 'on';
		}


		$def_options = array(
			'unflagged_text'    => __( 'Flag', 'bp-moderation' ),
			'flagged_text'      => __( 'Unflag', 'bp-moderation' ),
			'warning_threshold' => 5,
			'warning_forward' => get_option( 'admin_email' ),
			'warning_message'   => __(
'Several user reported one of your content as inappropriate.
You can see the content in the page: %CONTENTURL%.
You posted this content with the account "%AUTHORNAME%".

A community moderator will soon review and moderate this content if necessary.
--------------------
[%SITENAME%] %SITEURL%', 'bp-moderation'),
			'delete_threshold' => 0,
		);

		$options = array_merge($def_options,$options);

		update_site_option( 'bp_moderation_options', $options );


		// install/update complete, update the db version option
		update_site_option( 'bp_moderation_db_version', $this->db_ver );
	}

	/**
	 * Remove any trace of bp-moderation installation
	 */
	function clean_up() {
		delete_site_option( 'bp_moderation_db_version');

		global $wpdb;		
		$wpdb->query( "DROP TABLE {$this->contents_table}" );
		$wpdb->query( "DROP TABLE {$this->flags_table}" );

		delete_site_option( 'bp_moderation_options');
	}

	/**
	 * Generate error message displayed when trying to activate on non compatible envoriment
	 *
	 * @return string
	 */
	function compatibility_notice() {
		$message = sprintf( __('BuddyPress Moderation require at least BuddyPress %s to work.','bp-moderation'), $this->min_bp_ver );
		if (!defined('BP_VERSION')){
			$message .= __(' Please install <a href="http://buddypress.org/" target="_blank" >Buddypress</a>','bp-moderation');
		}elseif(version_compare(BP_VERSION, $this->min_bp_ver,'<') ){
			$message .= sprintf( __(' Your current version is %s, please upgrade.','bp-moderation'), BP_VERSION );;
		}
		return $message;
	}
}
?>
