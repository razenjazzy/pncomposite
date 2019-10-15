<?php

	defined( 'ABSPATH' ) or die( 'Keep Silent' );

	//----------------------------------------------------------------------
	// Get list of available home page templates
	//----------------------------------------------------------------------

	if ( ! function_exists( 'velvet_home_page_templates' ) ):

		function velvet_home_page_templates() {

			// Index for body class and value for real page template file name;
			return apply_filters( 'velvet_home_page_templates', array(
				'template-home' => 'template-home.php'
			) );
		}

	endif;

	//----------------------------------------------------------------------
	// Modify Widget Title
	//----------------------------------------------------------------------

	if ( ! function_exists( 'velvet_widget_title' ) ) :
		function velvet_widget_title( $string ) {
			$re    = "/(\\w+)/";
			$subst = "<span>$1</span>";

			return preg_replace( $re, $subst, $string, 1 );
		}

		add_filter( 'widget_title', 'velvet_widget_title' );
	endif;

	remove_filter( 'widget_title', 'esc_html', 20 );

	//----------------------------------------------------------------------
	// Modify Page Title
	//----------------------------------------------------------------------

	if ( ! function_exists( 'velvet_page_title_text' ) ) :
		function velvet_page_title_text( $string ) {
			$re    = "/(\\w+)/";
			$subst = "<span>$1</span>";

			return preg_replace( $re, $subst, $string, 1 );
		}

		add_filter( 'velvet_title_text', 'velvet_page_title_text' );
	endif;

	//----------------------------------------------------------------------
	// Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
	//----------------------------------------------------------------------

	if ( ! function_exists( 'velvet_page_menu_args' ) ) :

		function velvet_page_menu_args( $args ) {

			$args[ 'show_home' ] = TRUE;

			return apply_filters( 'velvet_page_menu_args', $args );
		}

		add_filter( 'wp_page_menu_args', 'velvet_page_menu_args', 9999 );
	endif;

	//----------------------------------------------------------------------
	// Adds custom classes to the array of body classes.
	//----------------------------------------------------------------------

	if ( ! function_exists( 'velvet_body_classes' ) ) :

		function velvet_body_classes( $classes ) {
			// Adds a class of group-blog to blogs with more than 1 published author.
			if ( is_multi_author() ) {
				$classes[] = 'group-blog';
			}

			$classes[] = velvet_get_preset();

			$current_page_template = basename( get_page_template_slug() );

			foreach ( velvet_home_page_templates() as $class_name => $filename ) :
				if ( trim( $filename ) == $current_page_template ) :
					$classes[] = $class_name;
				endif;
			endforeach;

			// Adds a class of hfeed to non-singular pages.
			if ( ! is_singular() ) :
				$classes[] = 'hfeed';
			endif;

			if ( is_home() or is_archive() or is_search() ) :
				if ( is_active_sidebar( 'velvet-blog-sidebar' ) ):
					$classes[] = 'blog-' . velvet_option( 'blog-layout', FALSE, 'sidebar-right' );
				else:
					$classes[] = 'blog-sidebar-no';
				endif;
			endif;

			if ( is_singular( 'post' ) ) :

				if ( velvet_option( 'velvet-single-post-sidebar', FALSE, TRUE ) ):
					$classes[] = 'blog-' . velvet_option( 'blog-layout', FALSE, 'sidebar-right' );
				else:
					$classes[] = 'blog-sidebar-no';
				endif;

			endif;

			if ( is_page() ) :
				if ( is_active_sidebar( 'velvet-page-sidebar' ) ):
					$classes[] = 'page-' . velvet_option( 'page-layout', FALSE, 'sidebar-right' );
				else:
					$classes[] = 'page-sidebar-no';
				endif;
			endif;


			//$classes[] = velvet_option( 'layout-type', FALSE, 'full-width' );

			return apply_filters( 'velvet_body_classes', $classes );
		}

		add_filter( 'body_class', 'velvet_body_classes', 9999 );
	endif;

	//----------------------------------------------------------------------
	// Adds custom classes to the array of post classes.
	//----------------------------------------------------------------------

	if ( ! function_exists( 'velvet_post_classes' ) ) :

		function velvet_post_classes( $classes ) {

			if ( ! is_home() && ! is_paged() && is_sticky() ) {
				$classes[] = 'sticky';
			}

			if ( velvet_post_thumbnail( TRUE ) or has_post_thumbnail() ) {
				$classes[] = 'has-post-thumbnail';
			}

			return apply_filters( 'velvet_post_classes', $classes );
		}

		add_filter( 'post_class', 'velvet_post_classes', 9999 );
	endif;

	//----------------------------------------------------------------------
	// Sets the authordata global when viewing an author archive.
	// This provides backwards compatibility with
	// http://core.trac.wordpress.org/changeset/25574
	// It removes the need to call the_post() and rewind_posts() in an author
	// template to print information about the author.
	//----------------------------------------------------------------------

	if ( ! function_exists( 'velvet_setup_author' ) ) :
		function velvet_setup_author() {
			global $wp_query;

			if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
				$GLOBALS[ 'authordata' ] = get_userdata( $wp_query->post->post_author );
			}
		}

		add_action( 'wp', 'velvet_setup_author', 9999 );
	endif;

	//-------------------------------------------------------------------------------
	// Add Author Contact
	//-------------------------------------------------------------------------------

	if ( ! function_exists( 'velvet_add_author_contact' ) ) :
		function velvet_add_author_contact( $contactmethods ) {

			$contactmethods[ 'google_profile' ]   = esc_html__( 'Google Plus Profile URL', 'velvet' );
			$contactmethods[ 'twitter_profile' ]  = esc_html__( 'Twitter Profile URL', 'velvet' );
			$contactmethods[ 'facebook_profile' ] = esc_html__( 'Facebook Profile URL', 'velvet' );
			$contactmethods[ 'linkedin_profile' ] = esc_html__( 'Linkedin Profile URL', 'velvet' );
			$contactmethods[ 'github_profile' ]   = esc_html__( 'Github Profile URL', 'velvet' );

			return apply_filters( 'velvet_add_author_contact', $contactmethods );
		}

		add_filter( 'user_contactmethods', 'velvet_add_author_contact', 9999 );
	endif;

	//----------------------------------------------------------------------
	// Display page break button in editor
	//----------------------------------------------------------------------

	if ( ! function_exists( 'velvet_wp_page_paging' ) ) :

		function velvet_wp_page_paging( $mce_buttons ) {
			if ( get_post_type() == 'post' or get_post_type() == 'page' ) {
				$pos = array_search( 'wp_more', $mce_buttons, TRUE );
				if ( $pos !== FALSE ) {
					$buttons     = array_slice( $mce_buttons, 0, $pos + 1 );
					$buttons[]   = 'wp_page';
					$mce_buttons = array_merge( $buttons, array_slice( $mce_buttons, $pos + 1 ) );
				}
			}

			return apply_filters( 'velvet_mce_buttons', $mce_buttons );
		}

		add_filter( 'mce_buttons', 'velvet_wp_page_paging', 9999 );
	endif;

	//----------------------------------------------------------------------
	// Set post view on single page display
	//----------------------------------------------------------------------

	if ( ! function_exists( 'velvet_call_post_views_set_fn' ) ) :

		function velvet_call_post_views_set_fn( $contents ) {
			if ( function_exists( 'velvet_set_post_views' ) and is_single() ) {
				velvet_set_post_views();
			}

			return $contents;
		}

		add_filter( 'the_content', 'velvet_call_post_views_set_fn', 9999 );

	endif;

	//----------------------------------------------------------------------
	// Post excerpt length, Post excerpt more
	//----------------------------------------------------------------------

	if ( ! function_exists( 'velvet_custom_excerpt_length' ) ) :

		function velvet_custom_excerpt_length( $wp_default ) {
			return apply_filters( 'velvet_custom_excerpt_length', 10, $wp_default );
		}

		add_filter( 'excerpt_length', 'velvet_custom_excerpt_length', 9999 );
	endif;

	//----------------------------------------------------------------------
	// Post excerpt more
	//----------------------------------------------------------------------

	if ( ! function_exists( 'velvet_custom_excerpt_more' ) ) :
		function velvet_custom_excerpt_more( $more ) {
			return ' ';
		}

		add_filter( 'excerpt_more', 'velvet_custom_excerpt_more', 9999 );
	endif;

	//----------------------------------------------------------------------
	// Service post AutoComplete
	//----------------------------------------------------------------------

	function servicePostIdAutocompleteSuggester( $query ) {
		global $wpdb;
		$id                 = (int) $query;
		$post_infos_prepare = $wpdb->prepare( "SELECT ID AS id, post_title AS title FROM {$wpdb->posts} WHERE post_type = 'service' AND ( ID = '%d' OR post_title LIKE '%%%s%%' ) LIMIT 0, 10", $id > 0 ? $id : - 1, stripslashes( $query ) );

		$post_infos = $wpdb->get_results( $post_infos_prepare, ARRAY_A );

		$results = array();
		if ( is_array( $post_infos ) && ! empty( $post_infos ) ) :
			foreach ( $post_infos as $value ) :
				$data            = array();
				$data[ 'value' ] = $value[ 'id' ];
				$data[ 'label' ] = esc_html__( 'Id', 'velvet' ) . ': ' . $value[ 'id' ] . ' - ' . esc_html__( 'Title', 'velvet' ) . ': ' . $value[ 'title' ];
				$results[]       = $data;
			endforeach;
		endif;

		return $results;
	}

	function servicePostIdAutocompleteRender( $query ) {

		$value = trim( $query[ 'value' ] ); // get value from requested

		$post = get_post( $value );

		$data            = array();
		$data[ 'value' ] = $post->ID;
		$data[ 'label' ] = esc_html__( 'Id', 'velvet' ) . ': ' . $post->ID . ' - ' . esc_html__( 'Title', 'velvet' ) . ': ' . $post->post_title;

		return $data;
	}

	add_filter( 'vc_autocomplete_hippo_services_service_post_id_callback', 'servicePostIdAutocompleteSuggester', 10, 1 );

	add_filter( 'vc_autocomplete_hippo_services_service_post_id_render', 'servicePostIdAutocompleteRender', 10, 1 );

