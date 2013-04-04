<?php
/**
 * Object
 * 
 * PHP4 COMPATIBLE
 * 		Makes extending classes able to use __construct as their constructor
 * 
 * Object class from CakePHP
 * Found:	http://abing.gotdns.com/posts/2006/php4-tricks-the-singleton-pattern-part-i/
 * 
 * @package Elastic Framework
 */
class Object {
	/**
	 * Object
	 * 
	 * If called, passes all arguments to $this->__construct($args), the constructor in PHP5
	 *
	 */
	function Object() {
		$args = func_get_args();
		if (method_exists($this, '__destruct')) {
			register_shutdown_function(array(&$this, '__destruct'));
		}
		call_user_func_array(array(&$this, '__construct'), $args);
	}

	function __construct() {
	}
}
?>