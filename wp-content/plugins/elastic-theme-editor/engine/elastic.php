<?php
/**
 * Elastic API: Access to atomic hook functions, context, paths, and Elastic data (prefixes, theme data).
 *
 * @package Elastic
 * @author Daryl Koopersmith
 */
/**
 * Handles internal framework operation. Do not access directly. Instead, use {@link elastic_get()} and {@link elastic_set()}.
 *
 * @author Daryl Koopersmith
 */
class Elastic {
	var $layout;
	/**
	 * An array containing the context of a page.
	 * 
	 * Set through {}
	 *
	 * @var array
	 */
	var $context;
	/**
	 * Contains the prefix used for most Elastic hooks and ids. Default 'elastic_'.
	 * Can be overridden through filter 'elastic_prefix'.
	 * 
	 * Warning: Override with care! The names other filters will change when Elastic::$prefix is overridden.
	 *
	 * @var string
	 */
	var $prefix;
	/**
	 * Contains the prefix used for all Modules. Default 'module_'.
	 * Can be overridden through filter 'elastic_module_prefix'.
	 *
	 * @var string
	 */
	var $module_prefix;
	/**
	 * An array of theme data obtained through {@link get_theme_data()}.
	 * Filtered hook: 'elastic_theme_data'.
	 *
	 * @var array
	 */
	var $theme_data;
	/**
	 * An array of child theme data obtained through {@link get_theme_data()}.
	 * Filtered hook: 'elastic_child_data'.
	 *
	 * @var array
	 */
	var $child_data;
	/**
	 * Are we running a child theme?
	 *
	 * @var boolean
	 */
	var $has_child;
	/**
	 * An array of module names.
	 *
	 * @var array
	 * @deprecated
	 * @todo Double check if Elastic::module_types is used anywhere.
	 */
	var $module_types = array( 'header', 'content', 'sidebar' );
	
	/**
	 * Contains an array of relative paths. Access paths through {@link elastic_get_path()}.
	 *
	 * @var array
	 */
	var $path = array();
	
	/**
	 * Determines whether to include a CSS reset file. Default false.
	 *
	 * @var boolean
	 */
	var $include_css_reset = false;
	
	/**
	 * Initializes and sets hooks for the Elastic framework
	 *
	 * @access private
	 * @return void
	 * @author Daryl Koopersmith
	 */
	function init() {
		$this->has_child = ( STYLESHEETPATH !== TEMPLATEPATH );
		
		// Set paths
		$this->path['engine'] = '';
		$this->path['classes'] = 'classes';
		$this->path['lib-css'] = 'css';
		$this->path['fallback-views'] = 'fallback-views';
				
		// Load classes
		require_once( elastic_get_path('classes') . '/object.php');
		require_once( elastic_get_path('classes') . '/module.php');
		require_once( elastic_get_path('classes') . '/group.php');
		require_once( elastic_get_path('classes') . '/selection.php');
		require_once( elastic_get_path('classes') . '/sidebar.php');
		require_once( elastic_get_path('classes') . '/header.php');
		require_once( elastic_get_path('classes') . '/content.php');
		
		// Set prefix for all hooks and ids.
		$this->prefix = apply_filters('elastic_prefix','elastic_');
		$this->module_prefix = apply_filters( $this->prefix . 'module_prefix','module_');
		
		// Get theme and child theme data
		$this->theme_data = apply_filters($this->prefix . 'theme_data', get_theme_data(TEMPLATEPATH . '/style.css') );
		$this->child_data = apply_filters($this->prefix . 'child_data', get_theme_data(STYLESHEETPATH . '/style.css') );
		
		
		// Get layout
		// Load parent's layout.php. Required.
		require_once( TEMPLATEPATH . '/layout.php' );

		// Load child's layout.php. Optional.
		$child_layout_file = STYLESHEETPATH . '/layout.php';
		if( $this->has_child && file_exists( $child_layout_file ) )
			require_once( $child_layout_file );
		
		// Set layout
		$this->layout = $layout;
		
		// Load styles
		add_action('template_redirect', array(&$this, 'load_styles') );
		
		// Get context (once it's set)
		add_action('template_redirect', array(&$this, 'get_context') );
		// Get context now, for admin pages
		/**
		 * @todo Worth putting an is_admin() check here?
		 **/
		$this->context = $this->get_context();
		
		// Register sidebars
		/**
		 * @todo Can 'admin_init' section be replaced with a direct call? We've already reached 'init'
		 **/
		if( is_admin() ) // Sidebars must be registered during admin_init, which is before template_redirect
			add_action('admin_init', array(&$this, 'register_sidebars') );
		else // Sidebars are registered on template_redirect to ensure context has loaded
			add_action('template_redirect', array(&$this, 'register_sidebars') );
			
		
		// Load theme
		add_action('template_redirect', array(&$this, 'load_theme'), 100 );
	}

	/**
	 * Loads user stylesheets (both parent and child theme) and base CSS reset.
	 * 
	 * CSS reset is a customized version of Tripoli.
	 *
	 * @access private
	 * @return void
	 * @author Daryl Koopersmith
	 */
	function load_styles() {
		global $wp_styles;
		
		if( elastic_get('include_css_reset') ) {
			wp_enqueue_style( $this->prefix . 'tripoli', elastic_get_path('lib-css', 'uri') . '/tripoli.css', false, '0.0.3');
			wp_enqueue_style( $this->prefix . 'tripoli-ie', elastic_get_path('lib-css', 'uri') . '/tripoli.ie.css', false, '0.0.3');
			$wp_styles->add_data( $this->prefix . 'tripoli-ie', 'conditional', 'gte IE 5');
		}
		
		$stylesheet_deps = apply_filters( $this->prefix . 'stylesheet_deps', false);
		
		wp_enqueue_style( $this->prefix . 'style', get_template_directory_uri() . '/style.css', $stylesheet_deps, '0.0.3');
		if( elastic_get('has_child') )
			wp_enqueue_style( $this->prefix . 'style', get_stylesheet_directory_uri() . '/style.css', $stylesheet_deps, '0.0.3');
	}
	
	/**
	 * Registers all sidebar modules.
	 *
	 * @access private
	 * @return void
	 * @author Daryl Koopersmith
	 */
	function register_sidebars() {
		$sidebars = elastic_get('layout');
		$sidebars = $sidebars->get_modules_by_type('sidebar');
		
		if( ! $sidebars )
			return;
		
		foreach( $sidebars as $sidebar ) {
			$settings = $sidebar->apply_atomic( '_register_sidebars', array(
				'name'          => $sidebar->id,
				'id'            => $sidebar->id,
				'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
				'after_widget'  => "</li>",
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
				), elastic_get('module_prefix') );
			register_sidebar( $settings );
		}
	}
	
	/**
	 * Retrieve the context of the current page.
	 *
	 * @access private
	 * @todo Potentially make this function public, and take in an optional $wp_query variable?
	 * @return array $context
	 * @author Chris Jean, Ptah Dunbar, Daryl Koopersmith
	 */
	function get_context() {
		global $wp_query;

		$context = array( 'global' => '', 'abstract' => null, 'general' => null, 'specific' => null );
		
		if( is_admin() ) {
			$context['global'] = 'admin';
			return $this->context = $context;
		}
		
		$id = $wp_query->get_queried_object_id();

		if ( is_front_page() )
			$context['general'] = 'home';
		else if ( is_singular() ) {
			$context['abstract'] = 'singular';

			if ( is_attachment() ) {
				$context['general'] = 'attachment';
				$context['specific'] = 'attachment-'. $id;
			}
			else if ( is_single() ) {
				$context['general'] = 'single';
				$context['specific'] = 'single-'. $id;
			}
			else if ( is_page() ) {
				$context['general'] = 'page';
				$context['specific'] = 'page-'. $id;
			}
		}
		else if ( is_archive() ) {
			$context['abstract'] = 'archive';

			if ( is_category() ) {
				$context['general'] = 'category';
				$context['specific'] = 'category-'. $id;
			}
			else if ( is_tag() ) {
				$context['general'] = 'tag';
				$context['specific'] = 'tag-'. $id;
			}
			else if ( is_date() ) {
				$context['general'] = 'date';

				if ( is_month() )
					$context['specific'] = 'month-'. $id;
				else if ( is_year() )
					$context['specific'] = 'year-'. $id;
				else if ( is_day() )
					$context['specific'] = 'day-'. $id;
				else if ( is_time() )
					$context['specific'] = 'time-' . $id;
			}
			else if ( is_author() ) {
				$context['general'] = 'author';
				$context['specific'] = 'author-'. $id;
			}
			else if ( is_tax() ) {
				$context['general'] = 'tax';
				$context['specific'] = 'tax-'. $id;
			}
		}
		else if ( is_search() )
			$context['general'] = 'search';
		else if ( is_404() )
			$context['general'] = 'error404';


		return $this->context = $context;
	}
	
	/**
	 * Loads the theme.
	 *
	 * @access private
	 * @return void
	 * @author Daryl Koopersmith
	 */
	function load_theme() {
		get_header();

		$elastic_layout = elastic_get('layout');
		$elastic_layout->run();

		get_footer();
		
		exit(); // Stop wp-includes/template-loader.php from executing.
	}
}

// Make elastic object
global $elastic;
$elastic = new Elastic();
$elastic->init();

/**
 * Gets data within the global  {@link Elastic} instance ($elastic).
 *
 * @param string $var
 * @global Elastic $elastic
 * @return mixed Requested variable ($elastic->var), or false.
 * @author Daryl Koopersmith
 */
function elastic_get($var) {
    global $elastic;

    if( isset($elastic->$var) ) {
        return $elastic->$var;
    }

    return false;
}

/**
 * Sets data within the global {@link Elastic} instance ($elastic).
 *
 * @param string $var Variable name to set.
 * @param string $value Value to be set.
 * @global Elastic $elastic
 * @return void
 * @author Daryl Koopersmith
 */
function elastic_set($var, $value) {
	global $elastic;
	
	$elastic->$var = $value;
}

/**
 * Returns a path within the Elastic framework.
 * Arguments specify whether a path is absolute or a url.
 * 
 * @param string $name The name of the path requested. A common value is 'editor'.
 * @param boolean $url Optional. Default false (absolute path). Whether the path returned is a url.
 * @return string Requested path, or false.
 * @author Daryl Koopersmith
 */
function elastic_get_path( $name, $url = false ) {
	$path = elastic_get('path');
	
	if( ! isset($path[ $name ]) )
		return false;
	
	if( $url )
		return plugin_dir_url( __FILE__ ) . $path[ $name ];
	else
		return plugin_dir_path( __FILE__ ) . $path[ $name ];
}

/**
 * Calls {@link do_action()} at all context levels.
 * Actions are run in the order: global, abstract, general, specific.
 * Actions are not run for null contexts.
 * 
 * @param string $id The id of the hook.
 * @todo Document how the hooks API can handle any number of variables.
 * @return void
 * @author Daryl Koopersmith
 */
function elastic_do_atomic( $id, $prefix = NULL ) {
	foreach(elastic_get('context') as $view) {
		if( isset($view)) {
			$args = func_get_args();
			array_splice( $args, 0, 2, $view );
			do_action_ref_array( elastic_format_hook($id, $view, $prefix), $args );
		}
	}
}

/**
 * Calls {@link do_action()} at the most specific atomic level with a registered action.
 * 
 * For example, if actions were registered at the 'global' and 'general' levels,
 * only the 'general' action would be called.
 *
 * @param string $id The id of the hook.
 * @param string $prefix Optional. Defaults to {@link Elastic::$prefix}.
 * @return void
 * @author Daryl Koopersmith
 */
function elastic_do_atomic_specific( $id, $prefix = NULL ) {
	foreach( array_reverse( elastic_get('context') ) as $view ) {
		if( isset($view)) {
			$hook = elastic_format_hook( $id, $view, $prefix );
			if( has_action($hook) ) {
				$args = func_get_args();
				array_splice( $args, 0, 2, $view );
				do_action_ref_array( $hook, $args );
				break;
			}
		}
	}
}

/**
 * Calls {@link apply_filters()} at all context levels.
 * Filters are applied in the order: global, abstract, general, specific.
 * Filters are not applied to null contexts.
 * 
 * $value is updated every time {@link apply_filters()} is run.
 * (i.e. {@link apply_filters()} at the 'specific' level receives any changes made at the 'global' level).
 * 
 * @param string $id The id of the hook.
 * @param mixed $value The value to be filtered.
 * @param string $prefix Optional. Defaults to {@link Elastic::$prefix}.
 * @return void
 * @author Daryl Koopersmith
 */
function elastic_apply_atomic( $id, $value, $prefix = NULL ) {
	$preset_args = 3;
	
	foreach(elastic_get('context') as $view) {
		if( isset($view)) {
			$output_args = array( elastic_format_hook($id, $view, $prefix), $value );
			if( func_num_args() > $preset_args ) {
				$args = func_get_args();
				array_splice( $args, 0, $preset_args, $output_args );
				$value = call_user_func_array('apply_filters', $args);
			} else {
				$value = apply_filters( $output_args[0], $output_args[1] );
			}
		}
	}
	return $value;
}

/**
 * Calls {@link apply_filters()} at the most specific atomic level with a registered action.
 *
 * For example, if filters were registered at the 'global' and 'general' levels,
 * only the 'general' filter would be called.
 * 
 * @param string $id The id of the hook.
 * @param mixed $value The value to be filtered.
 * @param string $prefix Optional. Defaults to {@link Elastic::$prefix}.
 * @return void
 * @author Daryl Koopersmith
 */
function elastic_apply_atomic_specific( $id, $value, $prefix = NULL ) {
	$preset_args = 3;
	
	foreach( array_reverse( elastic_get('context') ) as $view ) {
		if( isset($view)) {
			$hook = elastic_format_hook( $id, $view, $prefix );
			if( has_filter($hook) ) {
				$output_args = array( $hook, $value );
				if( func_num_args() > $preset_args ) {
					$args = func_get_args();
					array_splice( $args, 0, $preset_args, $output_args );
					return call_user_func_array('apply_filters', $args);
				} else {
					return apply_filters( $output_args[0], $output_args[1] );
				}
			}
		}
	}
}

/**
 * Returns a formatted hook title.
 *
 * @param string $id
 * @param string $view
 * @param string $prefix Optional. Defaults to {@link Elastic::$prefix}.
 * @return string Formatted hook title
 * @author Daryl Koopersmith
 */
function elastic_format_hook( $id, $view = '', $prefix = NULL ) {
	if( ! isset($prefix) )
		$prefix = elastic_get('prefix');
	// If $view is empty (i.e. context['global']), don't add an extra underscore
	return $prefix . (( ! empty($view) ) ? $view . "_" : '' ) . $id;
}

/**
 * Returns a formatted hook title with the module prefix.
 *
 * @param string $id
 * @param string $view
 * @return string Formatted hook title
 * @author Daryl Koopersmith
 */
function elastic_module_format_hook( $id, $view = '' ) {
	return elastic_format_hook( $id, $view, elastic_get('module_prefix') );
}

?>