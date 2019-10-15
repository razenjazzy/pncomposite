<?php

	defined( 'ABSPATH' ) or die( 'Keep Silent' );

	// =====================================================================================================

	if ( function_exists( 'vc_disable_frontend' ) ):
		vc_disable_frontend();
	endif;

	$_velvet_shortcode_tabs           = array();
	$_velvet_shortcode_home_carousels = 0;
	$_velvet_testimonials_attr        = array();

	// =================================================================
	// Visual Composer Row Wrapper Classes
	// =================================================================

	$_velvet_vc_row_wrapper_css_classes = array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Theme Specific CSS Class', 'velvet' ),
		'param_name'  => 'hippo_theme_css_class',
		'admin_label' => FALSE,
		'value'       => apply_filters( 'velvet_vc_row_wrapper_css_classes',
		                                array(
			                                esc_html__( 'Theme Specific CSS Class', 'velvet' )          => '',
			                                esc_html__( 'Slider Row', 'velvet' )                        => 'slider-row',
			                                esc_html__( 'Section Background Lighten color', 'velvet' )  => 'row-bg-lightencolor',
			                                esc_html__( 'Section Background Theme color', 'velvet' )    => 'row-bg-themecolor',
			                                esc_html__( 'Section Background Gradient color', 'velvet' ) => 'row-bg-gradientcolor',
			                                esc_html__( 'Subscribe Bar', 'velvet' )                     => 'th-btm-newsletter',
			                                esc_html__( 'Section  title', 'velvet' )                    => 'section-title',
			                                esc_html__( 'Contact form', 'velvet' )                      => 'contact-form',
			                                esc_html__( 'Address Section', 'velvet' )                   => 'address-section',
			                                esc_html__( 'Section Features', 'velvet' )                  => 'section-feature',
			                                esc_html__( 'Video Full Width Wrapper', 'velvet' )          => 'video-full-width-wrapper',
			                                esc_html__( 'Video Thumb Wrapper', 'velvet' )               => 'video-thumb-wrapper',
			                                esc_html__( 'Hippo call to action', 'velvet' )              => 'hippo-call-to-action',
			                                esc_html__( 'Services', 'velvet' )                          => 'hippo-services',
		                                ) ),
		'description' => esc_html__( 'Theme Specific css class', 'velvet' ),
		'group'       => sprintf( esc_html__( '%s Theme Specific Class', 'velvet' ), VELVET_THEME_NAME )
	);

	// =================================================================
	// Visual Composer Column Wrapper Classes
	// =================================================================

	$_velvet_vc_column_wrapper_css_classes = array(
		'type'        => 'dropdown',
		'heading'     => esc_html__( 'Theme Specific CSS Class', 'velvet' ),
		'param_name'  => 'hippo_theme_css_class',
		'admin_label' => FALSE,
		'value'       => apply_filters( 'velvet_vc_column_wrapper_css_classes',
		                                array(
			                                esc_html__( 'Theme Specific CSS Class', 'velvet' ) => '',
			                                esc_html__( 'Features  title', 'velvet' )          => 'features-title',
			                                esc_html__( 'Contact Section', 'velvet' )          => 'contact-section',
			                                esc_html__( 'Video Full Width Wrapper', 'velvet' ) => 'video-full-width-wrapper',
			                                esc_html__( 'Video Thumb Wrapper', 'velvet' )      => 'video-thumb-wrapper',
		                                ) ),
		'description' => esc_html__( 'Theme Specific css class', 'velvet' ),
		'group'       => sprintf( esc_html__( '%s Theme Specific Class', 'velvet' ), VELVET_THEME_NAME )
	);

	// =================================================================
	// Visual Composer Admin element stylesheet
	// =================================================================

	if ( ! function_exists( 'velvet_vc_admin_styles' ) ) :
		function velvet_vc_admin_styles() {
			wp_enqueue_style( 'hippo_vc_admin_style', velvet_locate_template_uri( 'visual-composer/assets/css/vc-admin-element-style.css' ), array(), time(), 'all' );
		}

		add_action( 'admin_enqueue_scripts', 'velvet_vc_admin_styles' );
	endif;

	// =================================================================
	// Visual Composer Disable Load Default Templates
	// =================================================================

	add_filter( 'vc_load_default_templates', '__return_empty_array' );

	// =================================================================
	// Fix for twitter bootstrap support remove some param
	// =================================================================

	vc_remove_param( "vc_row", "full_width" );
	vc_remove_param( "vc_row", "full_height" );
	vc_remove_param( "vc_row", "content_placement" );

	// =================================================================
	// Add bootstrap array
	// =================================================================

	$row_attribute = array(
		$_velvet_vc_row_wrapper_css_classes,
		/*array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Row Style', 'velvet' ),
			'param_name'  => 'row_width',
			'value'       => array(
				esc_html__( 'Fixed Width', 'velvet' ) => 'container',
				esc_html__( 'Fluid Width', 'velvet' ) => 'container-fluid',
				//esc_html__( 'Full Width', 'velvet' )  => 'container-full'
			),
			'description' => esc_html__( 'Container width', 'velvet' ),
			'std'         => 'container-fluid'
		)*/
	);

	$row_inner_attribute = array(
		$_velvet_vc_row_wrapper_css_classes
	);

	vc_add_params( 'vc_row', apply_filters( 'hippo-vc_row-attr', $row_attribute ) );
	vc_add_params( 'vc_row_inner', apply_filters( 'hippo-vc_row_inner-attr', $row_inner_attribute ) );


	$column_attributes = array(
		$_velvet_vc_column_wrapper_css_classes,
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Custom column class?', 'velvet' ),
			'param_name'  => 'custom_columns',
			'description' => esc_html__( 'Add class on column like: col-ms-6, hidden-ms', 'velvet' ),
			'group'       => esc_html__( 'Custom column', 'velvet' )
		),
		array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Add Clear fix after this column?', 'velvet' ),
			'param_name'  => 'active_clearfix',
			'description' => esc_html__( 'If checked, a div appended after this column with clearfix class', 'velvet' ),
			'value'       => array( esc_html__( 'Yes', 'velvet' ) => 'yes' ),
			'group'       => esc_html__( 'Clear Columns', 'velvet' )
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Clear fix visibility class(es):', 'velvet' ),
			'param_name'  => 'clear_fix_classes',
			'description' => wp_kses( __( 'Clearfix div activated on this class like: <code>visible-sm-block</code> or <code>visible-xs-inline</code>. <br>Available <code>visible-*-block</code> <code>visible-*-inline-block</code> <code>visible-*-inline</code>). Use multiple with space.', 'velvet' ), array(
				'code' => array(),
				'br'   => array()
			) ),
			'dependency'  => array(
				'element' => 'active_clearfix',
				'value'   => 'yes',
			),
			'group'       => esc_html__( 'Clear Columns', 'velvet' )
		)
	);

	vc_add_params( 'vc_column', apply_filters( 'hippo-vc_column-attr', $column_attributes ) );
	vc_add_params( 'vc_column_inner', apply_filters( 'hippo-vc_column-attr', apply_filters( 'hippo-vc_column_inner-attr', $column_attributes ) ) );

	// =================================================================
	//  Visual Composer Frontend CSS Override
	// =================================================================

	if ( ! function_exists( 'visual_composer_css_override' ) ):

		function visual_composer_css_override() {
			wp_enqueue_style( 'js_composer_front-override', velvet_locate_template_uri( 'css/js_composer-override.css' ), FALSE, '', 'all' );
		}
	endif;

	if ( ! function_exists( 'visual_composer_register_front_css' ) ):

		function visual_composer_register_front_css() {
			add_action( 'wp_enqueue_scripts', 'visual_composer_css_override' );
		}

		add_action( 'vc_base_register_front_css', 'visual_composer_register_front_css' );
	endif;