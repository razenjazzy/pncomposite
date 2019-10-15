<?php

	defined( 'ABSPATH' ) or die( 'Keep Silent' );

	/**
	 * Jetpack setup function.
	 *
	 * See: https://jetpack.me/support/infinite-scroll/
	 */

	if ( ! function_exists( 'velvet_jetpack_setup' ) ):

		function velvet_jetpack_setup() {
			// Add theme support for Infinite Scroll.
			add_theme_support( 'infinite-scroll', array(
				'container' => 'main',  // while loop wrapper is #main  ID
				'render'    => 'velvet_infinite_scroll_render',
				'footer'    => 'wrapper',  // Footer Wrapper is #wrapper ID
			) );
		} // end function velvet_jetpack_setup
		add_action( 'after_setup_theme', 'velvet_jetpack_setup' );
	endif;

	/**
	 * Custom render function for Infinite Scroll.
	 */

	if ( ! function_exists( 'velvet_infinite_scroll_render' ) ):
		function velvet_infinite_scroll_render() {
			while ( have_posts() ) :
				the_post();
				get_template_part( 'post-contents/content', get_post_format() );
			endwhile;
		} // end function velvet_infinite_scroll_render
	endif;