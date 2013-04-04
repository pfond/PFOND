<?php
/**
 * A Selection is an anonymous Group meant for manipulating modules. 
 *
 * @package Elastic
 * @author Daryl Koopersmith
 */
class Selection extends Group {
	
	function __construct( $children ) {
		parent::__construct( NULL, $children );
	}
	
	/**
	 * Override run. Selections cannot be rendered.
	 *
	 * @return void
	 * @author Daryl Koopersmith
	 */
	function run() {
		die("Selections cannot be rendered.");
	}
}

?>