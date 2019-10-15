<?php

	defined( 'ABSPATH' ) or die( 'Keep Silent' );

	//----------------------------------------------------------------------
	// Row Session
	//----------------------------------------------------------------------

	if ( ! function_exists( 'velvet_start_session' ) ):
		function velvet_start_session() {

			if ( function_exists( 'hippo_plugin_start_session' ) ) {
				return;
			}

			if ( function_exists( 'session_start' ) && function_exists( 'session_id' ) && ! session_id() ) {
				session_start();
			}
		}

		add_action( 'init', 'velvet_start_session', 1 );
	endif;

	if ( ! function_exists( 'velvet_set_session' ) ):
		function velvet_set_session( $name, $value ) {

			if ( function_exists( 'hippo_plugin_set_session' ) ) {
				return hippo_plugin_set_session( $name, $value );
			}

			if ( ! function_exists( 'session_start' ) || ! function_exists( 'session_id' ) ) {
				return $value;
			}

			if ( ! isset( $_SESSION ) ) {
				return $value;
			}

			$_SESSION[ $name ] = $value;

			return $value;
		}
	endif;

	if ( ! function_exists( 'velvet_get_session' ) ):
		function velvet_get_session( $name ) {

			if ( function_exists( 'hippo_plugin_get_session' ) ) {
				return hippo_plugin_get_session( $name );
			}

			if ( ! isset( $_SESSION ) || ! isset( $_SESSION[ $name ] ) ) {
				return FALSE;
			}

			return ! empty( $_SESSION[ $name ] ) ? trim( $_SESSION[ $name ] ) : FALSE;
		}
	endif;

	if ( ! function_exists( 'velvet_delete_session' ) ):
		function velvet_delete_session( $name ) {

			if ( function_exists( 'hippo_plugin_delete_session' ) ) {
				return hippo_plugin_delete_session( $name );
			}

			if ( ! isset( $_SESSION ) ) {
				return TRUE;
			}

			unset( $_SESSION[ $name ] );

			return TRUE;
		}
	endif;

	//----------------------------------------------------------------------
	// Cookie
	//----------------------------------------------------------------------

	if ( ! function_exists( 'velvet_set_cookie' ) ):
		function velvet_set_cookie( $name, $value, $expire = FALSE, $secure = FALSE ) {

			if ( function_exists( 'hippo_plugin_set_cookie' ) ) {
				return hippo_plugin_set_cookie( $name, $value, $expire, $secure );
			}

			if ( empty( $expire ) ) {
				$expire = time() + HOUR_IN_SECONDS;
			}

			if ( ! headers_sent() ) {
				setcookie( $name, $value, $expire, COOKIEPATH ? COOKIEPATH : '/', COOKIE_DOMAIN, $secure );

			} elseif ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
				headers_sent( $file, $line );
				trigger_error( "{$name} session cannot be set - headers already sent by {$file} on line {$line}", E_USER_NOTICE );
			}

			return $value;
		}
	endif;

	if ( ! function_exists( 'velvet_get_cookie' ) ):
		function velvet_get_cookie( $name ) {

			if ( function_exists( 'hippo_plugin_get_cookie' ) ) {
				return hippo_plugin_get_cookie( $name );
			}

			return ! empty( $_COOKIE[ $name ] ) ? trim( $_COOKIE[ $name ] ) : FALSE;
		}
	endif;

	if ( ! function_exists( 'velvet_delete_cookie' ) ):
		function velvet_delete_cookie( $name ) {

			if ( function_exists( 'hippo_plugin_delete_cookie' ) ) {
				return hippo_plugin_delete_cookie( $name );
			}

			unset( $_COOKIE[ $name ] );
			velvet_set_cookie( $name, NULL, time() - YEAR_IN_SECONDS );

			return TRUE;
		}
	endif;

	//----------------------------------------------------------------------
	// WooCommerce Session, use init / wp_loaded hook
	//----------------------------------------------------------------------

	if ( ! function_exists( 'velvet_set_wc_session' ) ):
		function velvet_set_wc_session( $name, $value ) {

			if ( function_exists( 'hippo_plugin_set_wc_session' ) ) {
				hippo_plugin_set_wc_session( $name, $value );

				return;
			}

			if ( ! did_action( 'woocommerce_init' ) ) {
				_doing_it_wrong( __FUNCTION__, __( 'This function should not be called before woocommerce_init.', 'velvet' ), '2.6' );

				return;
			}

			if ( ! isset( WC()->session ) ) {
				return;
			}

			WC()->session->set( $name, $value );

		}
	endif;

	if ( ! function_exists( 'velvet_get_wc_session' ) ):
		function velvet_get_wc_session( $name ) {

			if ( function_exists( 'hippo_plugin_get_wc_session' ) ) {
				return hippo_plugin_get_wc_session( $name );
			}

			if ( ! did_action( 'woocommerce_init' ) ) {
				_doing_it_wrong( __FUNCTION__, __( 'This function should not be called before woocommerce_init.', 'velvet' ), '2.3' );

				return '';
			}

			if ( ! isset( WC()->session ) ) {
				return '';
			}

			return WC()->session->get( $name, '' );
		}
	endif;

	if ( ! function_exists( 'velvet_delete_wc_session' ) ):
		function velvet_delete_wc_session( $name ) {

			if ( function_exists( 'hippo_delete_wc_session' ) ) {
				return hippo_plugin_delete_wc_session( $name );
			}

			if ( ! did_action( 'woocommerce_init' ) ) {
				_doing_it_wrong( __FUNCTION__, __( 'This function should not be called before woocommerce_init.', 'velvet' ), '2.3' );

				return '';
			}

			if ( ! isset( WC()->session ) ) {
				return '';
			}

			WC()->session->set( $name, NULL );
		}
	endif;

	//----------------------------------------------------------------------
	// Theme Option Name
	//----------------------------------------------------------------------

	if ( ! function_exists( 'velvet_option_name' ) ):
		function velvet_option_name() {

			if ( function_exists( 'hippo_plugin_theme_option_name' ) ) {
				return hippo_plugin_theme_option_name();
			}

			return apply_filters( 'hippo_theme_option_name', 'hippo_theme_option' );
		}
	endif;

	//----------------------------------------------------------------------
	// Getting Theme Option data
	//----------------------------------------------------------------------

	if ( ! function_exists( 'velvet_option' ) ):
		function velvet_option( $index = FALSE, $index2 = FALSE, $default = NULL ) {

			if ( function_exists( 'hippo_plugin_theme_option' ) ) {
				return hippo_plugin_theme_option( $index, $index2, $default );
			}

			$velvet_theme_option_name = velvet_option_name();

			if ( ! isset( $GLOBALS[ $velvet_theme_option_name ] ) ) {
				return $default;
			}

			$velvet_theme_option = $GLOBALS[ $velvet_theme_option_name ];

			if ( empty( $index ) ) {
				return $velvet_theme_option;
			}

			if ( $index2 ) {
				$result = ( isset( $velvet_theme_option[ $index ] ) and isset( $velvet_theme_option[ $index ][ $index2 ] ) ) ? $velvet_theme_option[ $index ][ $index2 ] : $default;
			} else {
				$result = isset( $velvet_theme_option[ $index ] ) ? $velvet_theme_option[ $index ] : $default;
			}

			if ( $result == '1' or $result == '0' ) {
				return $result;
			}

			if ( is_string( $result ) and empty( $result ) ) {
				return $default;
			}

			return $result;
		}
	endif;

	//----------------------------------------------------------------------
	// Associative array to html attribute conversion
	//----------------------------------------------------------------------

	if ( ! function_exists( 'velvet_array2attributes' ) ):

		function velvet_array2attributes( $attributes, $filter_name = '' ) {

			if ( function_exists( 'hippo_plugin_array2attributes' ) ) {
				return hippo_plugin_array2attributes( $attributes, $filter_name );
			}

			$attributes = wp_parse_args( $attributes, array() );
			if ( $filter_name ) {
				$attributes = apply_filters( $filter_name, $attributes );
			}

			$attributes_array = array();

			foreach ( $attributes as $key => $value ) {

				if ( is_bool( $attributes[ $key ] ) and $attributes[ $key ] === TRUE ) {
					return $attributes[ $key ] ? $key : '';
				} elseif ( is_bool( $attributes[ $key ] ) and $attributes[ $key ] === FALSE ) {
					$attributes_array[] = '';
				} else {
					$attributes_array[] = $key . '="' . $value . '"';
				}
			}

			return implode( ' ', $attributes_array );
		}
	endif;

	//----------------------------------------------------------------------
	// OffCanvas Inner Pusher Styles
	//----------------------------------------------------------------------

	if ( ! function_exists( 'offCanvas_On_InnerPusher' ) ):
		function offCanvas_On_InnerPusher( $animation_style ) {

			$inner_pusher_list = apply_filters( 'velvet_off_canvas_inner_pusher_animation_name', array(
				'push-down',
				'rotate-pusher',
				'three-d-rotate-in',
				'three-d-rotate-out',
				'delayed-three-d-rotate'
			) );

			return in_array( $animation_style, $inner_pusher_list );
		}
	endif;

	//----------------------------------------------------------------------
	// Convert hexdec color string to rgb(a) string
	//----------------------------------------------------------------------

	if ( ! function_exists( 'velvet_hex2rgba' ) ):
		function velvet_hex2rgba( $color, $opacity = FALSE ) {

			if ( function_exists( 'hippo_plugin_hex2rgba' ) ) {
				return hippo_plugin_hex2rgba( $color, $opacity );
			}

			$default = 'rgb(0,0,0)';

			//Return default if no color provided
			if ( empty( $color ) ) {
				return $default;
			}

			//Sanitize $color if "#" is provided
			if ( $color[ 0 ] == '#' ) {
				$color = substr( $color, 1 );
			}

			//Check if color has 6 or 3 characters and get values
			if ( strlen( $color ) == 6 ) {
				$hex = array( $color[ 0 ] . $color[ 1 ], $color[ 2 ] . $color[ 3 ], $color[ 4 ] . $color[ 5 ] );
			} elseif ( strlen( $color ) == 3 ) {
				$hex = array( $color[ 0 ] . $color[ 0 ], $color[ 1 ] . $color[ 1 ], $color[ 2 ] . $color[ 2 ] );
			} else {
				return $default;
			}

			//Convert hexadec to rgb
			$rgb = array_map( 'hexdec', $hex );

			//Check if opacity is set(rgba or rgb)
			if ( $opacity ) {
				if ( abs( $opacity ) > 1 ) {
					$opacity = 1.0;
				}
				$output = 'rgba(' . implode( ",", $rgb ) . ',' . $opacity . ')';
			} else {
				$output = 'rgb(' . implode( ",", $rgb ) . ')';
			}

			return $output;
		}
	endif;

	//----------------------------------------------------------------------
	// Check And return File URI
	//----------------------------------------------------------------------

	if ( ! function_exists( 'velvet_locate_template_uri' ) ):
		function velvet_locate_template_uri( $template_names ) {

			if ( function_exists( 'hippo_plugin_locate_template_uri' ) ) {
				return hippo_plugin_locate_template_uri( $template_names );
			}

			$located = '';
			foreach ( (array) $template_names as $template_name ) {
				if ( ! $template_name ) {
					continue;
				}
				if ( file_exists( trailingslashit( get_stylesheet_directory() ) . $template_name ) ) {
					$located = trailingslashit( get_stylesheet_directory_uri() ) . $template_name;
					break;
				} elseif ( file_exists( trailingslashit( get_template_directory() ) . $template_name ) ) {
					$located = trailingslashit( get_template_directory_uri() ) . $template_name;
					break;
				}
			}

			return $located;
		}
	endif;

	//----------------------------------------------------------------------
	// Get Theme Preset
	//----------------------------------------------------------------------

	if ( ! function_exists( 'velvet_get_preset' ) ):
		function velvet_get_preset( $suffix = '' ) {

			if ( function_exists( 'hippo_plugin_theme_option_get_preset' ) ) {
				return hippo_plugin_theme_option_get_preset( $suffix );
			}

			$valid_list = apply_filters( 'hippo_available_preset', array(
				'preset1',
				'preset2',
				'preset3',
				'preset4',
				'preset5'
			) );

			$preset = velvet_option( 'preset', FALSE, 'preset1' );

			if ( ! function_exists( 'session_start' ) or ! function_exists( 'velvet_set_session' ) ) {
				return apply_filters( 'hippo_preset', $preset ) . $suffix;
			}

			if ( ! apply_filters( 'hippo_can_change_preset_on_fly', '__return_true' ) ) {

				return apply_filters( 'hippo_preset', $preset ) . $suffix;
			}

			$session_name   = '_hippo_preset';
			$require_preset = isset( $_GET[ 'hippo-preset' ] ) ? wp_kses( trim( $_GET[ 'hippo-preset' ] ), array() ) : '';

			// Reset Current Preset
			if ( isset( $_GET[ 'reset-hippo-preset' ] ) ) {
				velvet_delete_session( $session_name );

				return apply_filters( 'hippo_preset', $preset ) . $suffix;
			}

			// Reset for Invalid
			if ( ! empty( $require_preset ) and ! in_array( $require_preset, $valid_list ) ) {
				velvet_delete_session( $session_name );

				return apply_filters( 'hippo_preset', $preset ) . $suffix;
			}

			// Check current on-fly preset and return it
			if ( ! empty( $require_preset ) ) {
				$current = $require_preset;
				velvet_set_session( $session_name, $require_preset );
			} elseif ( empty( $require_preset ) and velvet_get_session( $session_name ) ) {
				// Check current on-fly preset on session and return session value.
				$current = velvet_get_session( $session_name );
			} else {
				// just return default preset.
				$current = $preset;
			}

			return apply_filters( 'hippo_preset', $current ) . $suffix;
		}
	endif;

	//----------------------------------------------------------------------
	// Get Named Image Size Array
	//----------------------------------------------------------------------

	if ( ! function_exists( 'velvet_get_image_size' ) ):
		function velvet_get_image_size( $name ) {

			if ( function_exists( 'hippo_plugin_get_image_size' ) ) {
				return hippo_plugin_get_image_size( $name );
			}

			global $_wp_additional_image_sizes;

			return $_wp_additional_image_sizes[ $name ];
		}
	endif;

	//----------------------------------------------------------------------
	// Estimate time to Read
	//----------------------------------------------------------------------

	if ( ! function_exists( 'velvet_get_min_to_read' ) ):
		function velvet_get_min_to_read( $args = array() ) {

			if ( function_exists( 'hippo_plugin_get_min_to_read' ) ) {
				return hippo_plugin_get_min_to_read( $args );
			}

			$args = wp_parse_args( $args, apply_filters( 'hippo_get_min_to_read_args', array(
				'minute' => _n_noop( '%s minute read', '%s minutes read', 'velvet' ),
				'second' => _n_noop( '%s second read', '%s seconds read', 'velvet' )
			) ) );

			// Why ob_start? if someone want to use short codes on post
			ob_start();
			the_content();
			$contents = ob_get_clean();
			$words    = str_word_count( strip_tags( $contents ) );

			$human_word_read_per_min = (int) apply_filters( 'hippo_min_to_read_word_limit', 150 );

			$minutes = floor( $words / $human_word_read_per_min );
			$seconds = floor( $words % $human_word_read_per_min / ( $human_word_read_per_min / 60 ) );

			if ( 1 <= $minutes ) {
				$estimated_time = sprintf( translate_nooped_plural( $args[ 'minute' ], $minutes, 'velvet' ), $minutes );
				//$estimated_time .= ', ' . sprintf( translate_nooped_plural( $message[ 'minute' ], $minutes, 'velvet' ), $minutes );
			} else {
				$estimated_time = sprintf( translate_nooped_plural( $args[ 'second' ], $seconds, 'velvet' ), $seconds );
			}

			return apply_filters( 'hippo_get_min_to_read', $estimated_time, $minutes, $seconds );
		}
	endif;

	//----------------------------------------------------------------------
	// Has Read More
	//----------------------------------------------------------------------

	if ( ! function_exists( 'velvet_has_post_read_more' ) ):

		function velvet_has_post_read_more() {

			global $post;

			if ( ! $post ) {
				_doing_it_wrong( __FUNCTION__, esc_html__( 'You cannot use it before or after loop or specific post.', 'velvet' ), sprintf( esc_html__( '(This message was added in %s theme version %s.)', 'velvet' ), HIPPO_THEME_NAME, '1.0' ) );
			}

			$content_arr = get_extended( $post->post_content );

			return ! empty( $content_arr[ 'extended' ] );

		}
	endif;

	//----------------------------------------------------------------------
	// Remove Redux NewsFlash
	//----------------------------------------------------------------------

	if ( ! class_exists( 'reduxNewsflash' ) ):
		class reduxNewsflash {
			public function __construct( $parent, $params ) {

			}
		}
	endif;

	//----------------------------------------------------------------------
	// Remove Redux Ads
	//----------------------------------------------------------------------

	add_filter( 'redux/' . velvet_option_name() . '/aURL_filter', '__return_empty_string' );