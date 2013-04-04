<?php

class Elastic_Upgrader extends WP_Upgrader {
	
	function run( $name, $source, $files = array(), $install = true) {
		//Connect to the Filesystem first.
		$res = $this->fs_connect( array($source, WP_CONTENT_DIR . '/themes') );
		if ( ! $res ) //Mainly for non-connected filesystem.
			return false;

		if ( is_wp_error($res) ) {
			$this->skin->error($res);
			return $res;
		}

		$this->skin->header();
		$this->skin->before();
		
		$result = $this->install_theme( $name, $source, $files, $install );
		$this->skin->set_result($result);
		
		if ( is_wp_error( $result ) ) {
			$this->skin->error($result);
			$this->skin->feedback('process_failed');
		} else {
			//Install Suceeded
			$this->skin->feedback('process_success');
		}
		
		$this->skin->after();
		$this->skin->footer();
		
		return $result;
	}
	
	function install_theme( $name, $source, $files, $install ) {
		global $wp_filesystem;
		
		$source = trailingslashit( $source );
		
		$destination = trailingslashit( $wp_filesystem->wp_themes_dir() );
		$destination = trailingslashit( $destination . $name );
		
		// Check if theme should be installed
		if ( $install ) {
			//Create destination if needed
			if ( ! $wp_filesystem->is_dir($destination) )
				if ( !$wp_filesystem->mkdir($destination, FS_CHMOD_DIR) )
					return new WP_Error('mkdir_failed', $this->strings['mkdir_failed'], $destination);

			// Copy new version of theme into place.
			$result = copy_dir($source, $destination);
			if ( is_wp_error($result) ) {
				return $result;
			}
		} else { // Files will only be updated
			//If destination doesn't exist, bail.
			if ( ! $wp_filesystem->is_dir($destination) )
				return new WP_Error('fs_no_folder', sprintf($strings['fs_no_folder'], $destination));
		}
		
		// Update theme files
		foreach($files as $file => $contents) {
			$file_path = $destination . $file; // Create file path
			$result = $wp_filesystem->put_contents($file_path, $contents, FS_CHMOD_FILE); // Add file
			
			// Check for errors
			if ( ! $result )
				return new WP_Error('could_not_create_theme', sprintf(__('Could not fully create the theme %s'), $files) );
		}
		
		return true;
	}
}

?>