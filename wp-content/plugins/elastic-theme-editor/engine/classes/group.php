<?php
/**
 * Groups contain multiple modules, and render only those modules.
 * A group's views cannot be set.
 * 
 * @package Elastic
 * @author Daryl Koopersmith
 * 
 * @todo add children manipulation functions
 */
class Group extends Module {
	var $children;
	
	function __construct($id, $children = null) {
		parent::__construct( $id );
		$this->children = $children;
		
		parent::set_view( '', array($this,'_view') );
	}
	
	/**
	 * The only group view: run all of its children.
	 *
	 * @return void
	 * @author Daryl Koopersmith
	 */
	function _view() {
		foreach($this->children as $child) {
			$child->run();
		}
	}
	
	/**
	 * Override set_view. Groups have only one view.
	 *
	 * @return void
	 * @author Daryl Koopersmith
	 * 
	 * @todo Modify set_view so groups can be disabled
	 */
	function set_view() {}
	
	
	/**
	 * Override remove_view. Groups have only one view.
	 *
	 * @return void
	 * @author Daryl Koopersmith
	 * 
	 * @todo Re-introduce remove view--how can a group be disabled?
	 */
	function remove_view() {}
}

?>