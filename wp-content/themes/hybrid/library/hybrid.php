<?php
/**
 * Hybrid Core - A WordPress theme development framework.
 *
 * Hybrid Core is a framework for developing WordPress themes.  The framework allows theme developers
 * to quickly build themes without having to handle all of the "logic" behind the theme or having to code 
 * complex functionality for features that are often needed in themes.  The framework does these things 
 * for developers to allow them to get back to what matters the most:  developing and designing themes.  
 * The framework was built to make it easy for developers to include (or not include) specific, pre-coded 
 * features.  Themes handle all the markup, style, and scripts while the framework handles the logic.
 *
 * Hybrid Core is a modular system, which means that developers can pick and choose the features they 
 * want to include within their themes.  Most files are only loaded if the theme registers support for the 
 * feature using the add_theme_support( $feature ) function within their theme.
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU 
 * General Public License version 2, as published by the Free Software Foundation.  You may NOT assume 
 * that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without 
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * You should have received a copy of the GNU General Public License along with this program; if not, write 
 * to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 *
 * @package HybridCore
 * @version 1.1.0
 * @author Justin Tadlock <justin@justintadlock.com>
 * @copyright Copyright (c) 2008 - 2011, Justin Tadlock
 * @link http://themehybrid.com/hybrid-core
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * The Hybrid class launches the framework.  It's the organizational structure behind the entire framework. 
 * This class should be loaded and initialized before anything else within the theme is called to properly use 
 * the framework.  
 *
 * After parent themes call the Hybrid class, they should perform a theme setup function on the 
 * 'after_setup_theme' hook with a priority of 10.  Child themes should add their theme setup function on
 * the 'after_setup_theme' hook with a priority of 11.  This allows the class to load theme-supported features
 * at the appropriate time, which is on the 'after_setup_theme' hook with a priority of 12.
 *
 * @since 0.7.0
 */
class Hybrid {

	/**
	 * PHP4 constructor method.  This simply provides backwards compatibility for users with setups
	 * on older versions of PHP.  Once WordPress no longer supports PHP4, this method will be removed.
	 *
	 * @since 0.9.0
	 */
	function Hybrid() {
		$this->__construct();
	}

	/**
	 * Constructor method for the Hybrid class.  This method adds other methods of the class to 
	 * specific hooks within WordPress.  It controls the load order of the required files for running 
	 * the framework.
	 *
	 * @since 1.0.0
	 */
	function __construct() {

		/* Define framework, parent theme, and child theme constants. */
		add_action( 'after_setup_theme', array( &$this, 'constants' ), 1 );

		/* Load the core functions required by the rest of the framework. */
		add_action( 'after_setup_theme', array( &$this, 'core' ), 2 );

		/* Initialize the framework's default actions and filters. */
		add_action( 'after_setup_theme', array( &$this, 'default_filters' ), 3 );

		/* Language functions and translations setup. */
		add_action( 'after_setup_theme', array( &$this, 'locale' ), 4 );

		/* Load the framework functions. */
		add_action( 'after_setup_theme', array( &$this, 'functions' ), 12 );

		/* Load the framework extensions. */
		add_action( 'after_setup_theme', array( &$this, 'extensions' ), 13 );

		/* Load admin files. */
		add_action( 'wp_loaded', array( &$this, 'admin' ) );
	}

	/**
	 * Defines the constant paths for use within the core framework, parent theme, and
	 * child theme.  Constants prefixed with 'HYBRID_' are for use only within the core
	 * framework and don't reference other areas of the parent or child theme.
	 *
	 * @since 0.7.0
	 */
	function constants() {

		/* Sets the path to the parent theme directory. */
		define( 'THEME_DIR', get_template_directory() );

		/* Sets the path to the parent theme directory URI. */
		define( 'THEME_URI', get_template_directory_uri() );

		/* Sets the path to the child theme directory. */
		define( 'CHILD_THEME_DIR', get_stylesheet_directory() );

		/* Sets the path to the child theme directory URI. */
		define( 'CHILD_THEME_URI', get_stylesheet_directory_uri() );

		/* Sets the path to the core framework directory. */
		define( 'HYBRID_DIR', trailingslashit( THEME_DIR ) . basename( dirname( __FILE__ ) ) );

		/* Sets the path to the core framework directory URI. */
		define( 'HYBRID_URI', trailingslashit( THEME_URI ) . basename( dirname( __FILE__ ) ) );

		/* Sets the path to the core framework admin directory. */
		define( 'HYBRID_ADMIN', trailingslashit( HYBRID_DIR ) . 'admin' );

		/* Sets the path to the core framework classes directory. */
		define( 'HYBRID_CLASSES', trailingslashit( HYBRID_DIR ) . 'classes' );

		/* Sets the path to the core framework extensions directory. */
		define( 'HYBRID_EXTENSIONS', trailingslashit( HYBRID_DIR ) . 'extensions' );

		/* Sets the path to the core framework functions directory. */
		define( 'HYBRID_FUNCTIONS', trailingslashit( HYBRID_DIR ) . 'functions' );

		/* Sets the path to the core framework images directory URI. */
		define( 'HYBRID_IMAGES', trailingslashit( HYBRID_URI ) . 'images' );

		/* Sets the path to the core framework CSS directory URI. */
		define( 'HYBRID_CSS', trailingslashit( HYBRID_URI ) . 'css' );

		/* Sets the path to the core framework JavaScript directory URI. */
		define( 'HYBRID_JS', trailingslashit( HYBRID_URI ) . 'js' );
	}

	/**
	 * Loads the core framework functions.  These files are needed before loading anything else in the 
	 * framework because they have required functions for use.
	 *
	 * @since 1.0.0
	 */
	function core() {

		/* Load the core framework functions. */
		require_once( trailingslashit( HYBRID_FUNCTIONS ) . 'core.php' );

		/* Load the context-based functions. */
		require_once( trailingslashit( HYBRID_FUNCTIONS ) . 'context.php' );
	}

	/**
	 * Handles the locale functions file and translations.
	 *
	 * @since 1.0.0
	 */
	function locale() {

		/* Load theme textdomain. */
		load_theme_textdomain( hybrid_get_textdomain() );

		/* Get the user's locale. */
		$locale = get_locale();

		/* Locate a locale-specific functions file. */
		$locale_functions = locate_template( array( "languages/{$locale}.php", "{$locale}.php" ) );

		/* If the locale file exists and is readable, load it. */
		if ( !empty( $locale_functions ) && is_readable( $locale_functions ) )
			require_once( $locale_functions );
	}

	/**
	 * Loads the framework functions.  Many of these functions are needed to properly run the 
	 * framework.  Some components are only loaded if the theme supports them.
	 *
	 * @since 0.7.0
	 */
	function functions() {

		/* Load the comments functions. */
		require_once( trailingslashit( HYBRID_FUNCTIONS ) . 'comments.php' );

		/* Load media-related functions. */
		require_once( trailingslashit( HYBRID_FUNCTIONS ) . 'media.php' );

		/* Load the utility functions. */
		require_once( trailingslashit( HYBRID_FUNCTIONS ) . 'utility.php' );

		/* Load the menus functions if supported. */
		require_if_theme_supports( 'hybrid-core-menus', trailingslashit( HYBRID_FUNCTIONS ) . 'menus.php' );

		/* Load the core SEO component. */
		require_if_theme_supports( 'hybrid-core-seo', trailingslashit( HYBRID_FUNCTIONS ) . 'core-seo.php' );

		/* Load the shortcodes if supported. */
		require_if_theme_supports( 'hybrid-core-shortcodes', trailingslashit( HYBRID_FUNCTIONS ) . 'shortcodes.php' );

		/* Load the sidebars if supported. */
		require_if_theme_supports( 'hybrid-core-sidebars', trailingslashit( HYBRID_FUNCTIONS ) . 'sidebars.php' );

		/* Load the widgets if supported. */
		require_if_theme_supports( 'hybrid-core-widgets', trailingslashit( HYBRID_FUNCTIONS ) . 'widgets.php' );

		/* Load the template hierarchy if supported. */
		require_if_theme_supports( 'hybrid-core-template-hierarchy', trailingslashit( HYBRID_FUNCTIONS ) . 'template-hierarchy.php' );

		/* Load the deprecated functions if supported. */
		require_if_theme_supports( 'hybrid-core-deprecated', trailingslashit( HYBRID_FUNCTIONS ) . 'deprecated.php' );
	}

	/**
	 * Load extensions (external projects).  Extensions are projects that are included within the 
	 * framework but are not a part of it.  They are external projects developed outside of the 
	 * framework.  Themes must use add_theme_support( $extension ) to use a specific extension 
	 * within the theme.  This should be declared on 'after_setup_theme' no later than a priority of 11.
	 *
	 * @since 0.7.0
	 */
	function extensions() {

		/* Load the Breadcrumb Trail extension if supported. */
		require_if_theme_supports( 'breadcrumb-trail', trailingslashit( HYBRID_EXTENSIONS ) . 'breadcrumb-trail.php' );

		/* Load the Cleaner Gallery extension if supported and the plugin isn't active. */
		if ( !function_exists( 'cleaner_gallery' ) )
			require_if_theme_supports( 'cleaner-gallery', trailingslashit( HYBRID_EXTENSIONS ) . 'cleaner-gallery.php' );

		/* Load the Custom Field Series extension if supported. */
		require_if_theme_supports( 'custom-field-series', trailingslashit( HYBRID_EXTENSIONS ) . 'custom-field-series.php' );

		/* Load the Get the Image extension if supported. */
		require_if_theme_supports( 'get-the-image', trailingslashit( HYBRID_EXTENSIONS ) . 'get-the-image.php' );

		/* Load the Loop Pagination extension if supported. */
		require_if_theme_supports( 'loop-pagination', trailingslashit( HYBRID_EXTENSIONS ) . 'loop-pagination.php' );

		/* Load the Entry Views extension if supported. */
		require_if_theme_supports( 'entry-views', trailingslashit( HYBRID_EXTENSIONS ) . 'entry-views.php' );

		/* Load the Theme Layouts extension if supported. */
		require_if_theme_supports( 'theme-layouts', trailingslashit( HYBRID_EXTENSIONS ) . 'theme-layouts.php' );

		/* Load the Post Stylesheets extension if supported. */
		require_if_theme_supports( 'post-stylesheets', trailingslashit( HYBRID_EXTENSIONS ) . 'post-stylesheets.php' );
	}

	/**
	 * Load admin files for the framework.
	 *
	 * @since 0.7.0
	 */
	function admin() {

		/* Check if in the WordPress admin. */
		if ( is_admin() ) {

			/* Load the main admin file. */
			require_once( trailingslashit( HYBRID_ADMIN ) . 'admin.php' );

			/* Load the theme settings feature if supported. */
			require_if_theme_supports( 'hybrid-core-theme-settings', trailingslashit( HYBRID_ADMIN ) . 'theme-settings.php' );

			/* Load the post meta box if supported. */
			require_if_theme_supports( 'hybrid-core-post-meta-box', trailingslashit( HYBRID_ADMIN ) . 'post-meta-box.php' );
		}
	}

	/**
	 * Adds the default framework actions and filters.
	 *
	 * @since 1.0.0
	 */
	function default_filters() {

		/* Move the WordPress generator to a better priority. */
		remove_action( 'wp_head', 'wp_generator' );
		add_action( 'wp_head', 'wp_generator', 1 );

		/* Add the theme info to the header (lets theme developers give better support). */
		add_action( 'wp_head', 'hybrid_meta_template', 1 );

		/* Filter the textdomain mofile to allow child themes to load the parent theme translation. */
		add_filter( 'load_textdomain_mofile', 'hybrid_load_textdomain', 10, 2 );

		/* Filter textdomain for extensions. */
		add_filter( 'breadcrumb_trail_textdomain', 'hybrid_get_textdomain' );
		add_filter( 'theme_layouts_textdomain', 'hybrid_get_textdomain' );
		add_filter( 'custom_field_series_textdomain', 'hybrid_get_textdomain' );

		/* Make text widgets and term descriptions shortcode aware. */
		add_filter( 'widget_text', 'do_shortcode' );
		add_filter( 'term_description', 'do_shortcode' );
	}
}

?>