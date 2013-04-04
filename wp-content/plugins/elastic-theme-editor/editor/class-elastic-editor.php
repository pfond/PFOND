<?php

class Elastic_Editor {
	function init() {
		// Dependencies
		require_once(ABSPATH . WPINC . '/compat.php'); // Includes necessary JSON functions.
		
		require_once(ABSPATH . 'wp-admin/includes/class-wp-upgrader.php');

		require_once('class-elastic-customizer.php');
		require_once('class-elastic-upgrader.php');
		
		// Actions
		add_action('admin_menu', array('Elastic_Editor', 'plugin_menu') );
		add_action('wp_ajax_process_theme', array('Elastic_Editor', 'process_theme') );
		add_action('wp_ajax_elastic_load_state', array('Elastic_Editor', 'elastic_load_state') );
		
	}
	
	function get_folder() {
		return plugin_dir_url( __FILE__ );
	}
	
	function process_theme() {
		$settings = json_decode( stripslashes( $_POST["settings"] ) );
		
		$customizer = new Elastic_Customizer;
		$files = $customizer->run();
		
		$upgrader = new Elastic_Upgrader();
		$source = dirname( plugin_dir_path( __FILE__ ) ) . '/themes/default';
		$upgrader->run($settings->path, $source, $files, $settings->install);
	}
	
	function plugin_menu() {
		$page = add_theme_page('Elastic Theme Editor', 'Elastic Editor', 8, 'elastic-editor', array('Elastic_Editor', 'editor_view') );
		add_action( "admin_print_styles-$page", array('Elastic_Editor', 'init_styles') );
		add_action( "admin_print_scripts-$page", array('Elastic_Editor', 'init_scripts') );
	}

	function editor_view() {
		include('editor_view.php');
	}

	function init_styles() {
		$plugin = Elastic_Editor::get_folder();
		
		wp_enqueue_style('jquery-ui-all-styles',
			$plugin . 'jquery/ui/css/custom-theme/jquery-ui-1.7.2.custom.css',
			'1.7.2',
			'screen'
			);

		wp_enqueue_style('elastic-styles',
			$plugin . 'styles.css',
			'0.0.3',
			'screen'
			);

	}

	function init_scripts() {
		global $current_user;
		
		$plugin = Elastic_Editor::get_folder();
		
		wp_enqueue_script('jquery');
		wp_enqueue_script('json2');
		wp_enqueue_script('jquery-ui-all',
			$plugin . 'jquery/ui/js/jquery-ui-1.7.2.custom.min.js',
			array('jquery'),
			'1.7.2');

		wp_enqueue_script('jquery-qtip',
			$plugin . 'jquery/jquery.qtip-1.0.min.js',
			array('jquery'),
			'1.0-r27');

		wp_enqueue_script('elastic-lib',
			$plugin . 'lib.js',
			array('jquery', 'jquery-ui-all', 'jquery-qtip', 'json2'),
			'0.0.3');

		// Load current theme state.	
		$state_path = trailingslashit( TEMPLATEPATH ) . 'state.php';
		if( file_exists( $state_path ) )
				$state = file_get_contents( $state_path );


		wp_get_current_user();
		$user = $current_user->display_name;
		
		wp_localize_script('elastic-lib', 'input', array(
				'state' => ( isset($state) ) ? $state : false,
				'themes' => json_encode( Elastic_Editor::list_themes() ),
				'user' => $user
			));

	}
	
	function list_themes() {
		$themes = get_themes();
		$theme_list = array();
		
		foreach($themes as $theme) {
			$file = trailingslashit( $theme['Stylesheet Dir'] ) . 'state.php';
			$info = array(
				'name' => $theme['Name'],
				'path' => $theme['Stylesheet']
			);
			$info['compatible'] = ( array_search( $file, $theme['Template Files'] ) !== false ) ? true : false ;
			$theme_list[] = $info;
		}
		
		return $theme_list;
	}
	
	function elastic_load_state() {
		global $wp_db_version;
		
		$name = $_POST["name"];
		$themes = get_themes();
		
		foreach($themes as $theme) {
			if ( $theme['Name'] === $name ) {
				if ( version_compare( $wp_db_version, 12023 ) === 1 ) {
					// In 2.9, stylesheet dir is changed to include WP_CONTENT_DIR
					echo file_get_contents( trailingslashit( $theme['Stylesheet Dir'] ) . 'state.php' );	
				} else {
					// In 2.8, stylesheet dir does not include WP_CONTENT_DIR
					echo file_get_contents( WP_CONTENT_DIR . trailingslashit( $theme['Stylesheet Dir'] ) . 'state.php' );
				}
				break;
			}
		}
		die;
	}
}
?>