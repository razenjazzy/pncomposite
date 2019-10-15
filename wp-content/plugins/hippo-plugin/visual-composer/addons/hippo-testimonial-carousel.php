<?php

	defined( 'ABSPATH' ) or die( 'Keep Silent' );

	if ( function_exists( 'vc_map' ) ) :

		$hippo_testimonial_carousel_array = apply_filters( 'hippo-plugin-vc-hippo_testimonial_carousel-map', array(
			"name"                    => __( "Testimonial Carousel", 'hippo-plugin' ),
			"base"                    => "hippo_testimonial_carousel",
			"icon"                    => "testimonial-icon",
			'category'                => HIPPO_THEME_NAME . ' ' . __( 'Theme Elements', 'hippo-plugin' ),
			"description"             => __( 'Display testimonial', 'hippo-plugin' ),
			"params"                  => apply_filters( 'hippo-plugin-vc-hippo_testimonial_carousel-params', array(
				// params group
				array(
					'type' => 'param_group',
					'heading' => __('Testimonial', 'hippo-plugin'),
					'param_name' => 'testimonial',
					'description' => __('Enter testimonial - details.', 'hippo-plugin'),
					'params' => array(
						array(
							'type'        => 'attach_image',
							'heading'     => __( 'Image', 'hippo-plugin' ),
							'param_name'  => 'image',
							'description' => __( 'Select image from media library', 'hippo-plugin' )
						),
						array(
							"type"        => "textarea",
							"heading"     => __( "Quote", 'hippo-plugin' ),
							"param_name"  => "quote_content",
							"description" => __( "The Testimonial Quote", 'hippo-plugin' )
						),
						array(
							"type"        => "textfield",
							"heading"     => __( "Client Name", 'hippo-plugin' ),
							"param_name"  => "client_name",
							"holder"      => "h3",
							"description" => __( "Enter Client Name", 'hippo-plugin' )
						),
						array(
							"type"        => "textfield",
							"heading"     => __( "Client Designation", 'hippo-plugin' ),
							"param_name"  => "client_designation",
							"description" => __( "Enter Client Designation.", 'hippo-plugin' )
						),
					),
				),
				array(
					"type"        => "textfield",
					"heading"     => __( "Extra class name", 'hippo-plugin' ),
					"param_name"  => "el_class",
					"description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'hippo-plugin' )
				)
			) )
		) );

		vc_map( $hippo_testimonial_carousel_array );

		if ( class_exists( 'WPBakeryShortCode' ) and ! class_exists( 'WPBakeryShortCode_Hippo_Testimonial_Carousel' ) ) :
			class WPBakeryShortCode_Hippo_Testimonial_Carousel extends WPBakeryShortCode {

			}
		endif;
	endif; // function_exists( 'vc_map' )