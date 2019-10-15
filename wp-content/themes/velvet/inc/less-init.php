<?php

	defined( 'ABSPATH' ) or die( 'Keep Silent' );


	/**
	 * Adding Less
	 */
	// add_action( 'wp_enqueue_scripts', function () {
	// 	wp_enqueue_style( 'style-less', get_stylesheet_directory_uri() . '/less/style.less' );
	// } );

	//----------------------------------------------------------------------
	// Less CSS Variables
	//----------------------------------------------------------------------

	if ( ! function_exists( 'velvet_less_variables' ) ) :

		function velvet_less_variables( $arr ) {

			$preset = velvet_get_preset( '-' );

			$theme_color = velvet_option( $preset . 'theme-color', FALSE, '#f1ac59' );

			$bg_color                = velvet_option( $preset . 'custom-background-color', FALSE, '#ffffff' );
			$bg_image                = velvet_option( $preset . 'custom-background-image', 'url', '' );
			$content_bg_color        = velvet_option( $preset . 'content-background-color', FALSE, '#ffffff' );
			$contents_color          = velvet_option( $preset . 'contents-color', FALSE, '#363636' );
			$menu_color              = velvet_option( $preset . 'menu-color', FALSE, '#000000' );
			$headings_color          = velvet_option( $preset . 'headings-color', FALSE, '#000000' );
			$border_color            = velvet_option( $preset . 'border-color', FALSE, '#e8e8e8' );
			$footer_background_color = velvet_option( $preset . 'footer-background-color', FALSE, '#1b1b1d' );
			$footer_text_color       = velvet_option( $preset . 'footer-text-color', FALSE, '#ffffff' );


			// Heading typography
			$heading_font_family = velvet_option( 'heading-typography', 'font-family', 'Roboto' );
			$heading_font_weight = velvet_option( 'heading-typography', 'font-weight', '700' );
			$heading_font_style  = velvet_option( 'heading-typography', 'font-style' );

			// Body typography
			$font_family = velvet_option( 'body-typography', 'font-family', 'Roboto' );
			$font_weight = velvet_option( 'body-typography', 'font-weight', '400' );
			$font_style  = velvet_option( 'body-typography', 'font-style' );

			$arr[ 'theme-color' ]       = $theme_color;
			$arr[ 'bg-color' ]          = $bg_color;
			$arr[ 'content-bg-color' ]  = $content_bg_color;
			$arr[ 'content-color' ]     = $contents_color;
			$arr[ 'menu-color' ]        = $menu_color;
			$arr[ 'heading-color' ]     = $headings_color;
			$arr[ 'border-color' ]      = $border_color;
			$arr[ 'footer-bg-color' ]   = $footer_background_color;
			$arr[ 'footer-text-color' ] = $footer_text_color;


			// body typography
			$arr[ 'font-family' ] = $font_family;
			$arr[ 'font-weight' ] = $font_weight;
			$arr[ 'font-style' ]  = $font_style;

			// heading typography
			$arr[ 'heading-font-family' ] = $heading_font_family;
			$arr[ 'heading-font-weight' ] = $heading_font_weight;
			$arr[ 'heading-font-style' ]  = $heading_font_style;

			// body style
			$arr[ 'custom-background-color' ] = $bg_color;

			if ( empty( $bg_image ) ) {
				$arr[ 'custom-background-image' ] = '';
			} else {
				$arr[ 'custom-background-image' ] = "url('{$bg_image}')";
			}

			return apply_filters( 'velvet_less_variables', $arr );
		}

		add_filter( 'hippo_plugin_set_less_variables', 'velvet_less_variables', 999 );

	endif;