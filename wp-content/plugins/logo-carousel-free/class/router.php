<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
/**
 * Logo Carousel - route class
 * @since 3.0
 */
class SPLC_Router {

	/**
	 * @var SPLC_Router single instance of the class
	 *
	 * @since 3.0
	 */
	protected static $_instance = null;


	/**
	 * Main SPLC Instance
	 *
	 * @since 3.0
	 * @static
	 * @return self Main instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Include the required files
	 *
	 * @since 3.0
	 * @return void
	 */
	function includes() {
		if ( splc_is_pro() ) {
			include_once SP_LC_PATH . '/inc/pro/loader.php';
		} else {
			include_once SP_LC_PATH . '/inc/free/loader.php';
		}
	}

	/**
	 * SPLC function
	 *
	 * @since 3.0
	 * @return void
	 */
	function splc_function() {
		include_once SP_LC_PATH . '/inc/functions.php';
	}
}
