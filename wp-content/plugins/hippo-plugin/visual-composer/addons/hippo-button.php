<?php
	defined( 'ABSPATH' ) or die( 'Keep Silent' );
	if ( function_exists( 'vc_map' ) ) :
		$hippo_button_array = apply_filters( 'hippo-plugin-vc-hippo_button-map', array(
			"name"        => __( "Button", 'hippo-plugin' ),
			"base"        => "hippo_button",
			"icon"        => "fa fa-align-center",
			'category'    => HIPPO_THEME_NAME . ' ' . __( 'Theme Elements', 'hippo-plugin' ),
			"description" => __( 'Custom style of button', 'hippo-plugin' ),
			"params"      => apply_filters( 'hippo-plugin-vc-hippo_button-params', array(
				array(
					"type"        => "textfield",
					"heading"     => __( "Button text", 'hippo-plugin' ),
					"param_name"  => "button_text",
					"description" => __( "Enter button text", 'hippo-plugin' )
				),
				array(
					"type"        => "vc_link",
					"heading"     => __( "Button link", 'hippo-plugin' ),
					"param_name"  => "button_link",
					"description" => __( "Enter button link", 'hippo-plugin' )
				),
				array(
					"type"        => "dropdown",
					"heading"     => __( "Button style", 'hippo-plugin' ),
					"param_name"  => "button_style",
					"value"       => array(
						__( '-- Select --', 'hippo-plugin' ) => '',
						__( 'Theme Color', 'hippo-plugin' )  => 'btn-link',
						__( 'Primary', 'hippo-plugin' )      => 'btn-primary',
						__( 'Darken', 'hippo-plugin' )       => 'btn-default'
					),
					"description" => __( "Select button position", 'hippo-plugin' )
				),
				array(
					"type"        => "dropdown",
					"heading"     => __( "Button size", 'hippo-plugin' ),
					"param_name"  => "button_size",
					"value"       => array(
						__( '-- Select --', 'hippo-plugin' ) => '',
						__( 'Small', 'hippo-plugin' )        => 'btn-sm',
						__( 'Normal', 'hippo-plugin' )       => 'btn-md',
						__( 'Large', 'hippo-plugin' )        => 'btn-lg'
					),
					"description" => __( "Select button position", 'hippo-plugin' )
				),
				array(
					"type"        => "dropdown",
					"heading"     => __( "Button Alignment", 'hippo-plugin' ),
					"param_name"  => "button_alignment",
					"value"       => array(
						__( 'Left', 'hippo-plugin' )   => 'text-left',
						__( 'Right', 'hippo-plugin' )  => 'text-right',
						__( 'Center', 'hippo-plugin' ) => 'text-center'
					),
					"std"         => "text-left",
					"description" => __( "Select button alignment", 'hippo-plugin' )
				),
				array(
					'type'       => 'css_editor',
					'heading'    => __( 'Css', 'hippo-plugin' ),
					'param_name' => 'css',
					'group'      => __( 'Design options', 'hippo-plugin' ),
				),
				array(
					"type"        => "textfield",
					"heading"     => __( "Extra class name", 'hippo-plugin' ),
					"param_name"  => "el_class",
					"description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'hippo-plugin' )
				)
			) )
		) );

		vc_map( $hippo_button_array );

		if ( class_exists( 'WPBakeryShortCode' ) and ! class_exists( 'WPBakeryShortCode_Hippo_Button' ) ) :
			class WPBakeryShortCode_Hippo_Button extends WPBakeryShortCode {
			}
		endif; //class_exists('WPBakeryShortCode') and ! class_exists('WPBakeryShortCode_Hippo_Button')
	endif; // function_exists( 'vc_map' )
