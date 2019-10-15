<?php

    defined( 'ABSPATH' ) or die( 'Keep Silent' );

    if( function_exists('vc_map') ) :

        $hippo_portfolio_grid_array = apply_filters('hippo-plugin-vc-hippo_portfolio-map', array(
            "name"        => __( "Portfolio grid style", 'hippo-plugin' ),
            "base"        => "hippo_portfolio",
            "icon"        => "fa fa-th",
            'category'    => HIPPO_THEME_NAME . ' ' . __( 'Theme Elements', 'hippo-plugin' ),
            "description" => __( 'Show off portfolio grid style', 'hippo-plugin' ),
            "params"      => apply_filters('hippo-plugin-vc-hippo_portfolio-params', array(
                

                array(
                    "type" => "textfield",
                    "heading"     => __("Post Limit", 'hippo-plugin'),
                    "param_name"  => "post_limit",
                    "admin_label" => true,
                    "value"       => '-1',
                    "description" => __("Put the number of posts to show, -1 for no limit", 'hippo-plugin'),
                ),

                array(
                    "type" => "textfield",
                    "heading"     => __("Word Limit", 'hippo-plugin'),
                    "param_name"  => "word_limit",
                    "admin_label" => true,
                    "value"       => 5,
                    "description" => __("Put the number of word to show", 'hippo-plugin'),
                    "dependency"  => array(
                        'element' => "portfolio_options",
                        'value'   => array( 'portfolio-overlay-three', 'title-content-under-thumbnail-with-overlay', 'title-category-content-under-thumbnail' )
                    )
                ),

                array(
                    "type"        => "dropdown",
                    "heading"     => __( "Post column grid", 'hippo-plugin' ),
                    "param_name"  => "grid_column",
                    "value"       => array(
                        __('Select column', 'hippo-plugin') => "",
                        __('2 Columns', 'hippo-plugin') => "col-md-6",
                        __('3 Columns', 'hippo-plugin') => "col-md-4",
                        __('4 Columns', 'hippo-plugin') => "col-md-3",
                        __('5 Columns', 'hippo-plugin') => "column-md-5",
                        __('6 Columns', 'hippo-plugin') => "col-md-2"
                    ),
                    "admin_label" => true,
                    "description" => __( "Select post grid column", 'hippo-plugin' ),
                ),

                array(
                    "type"        => "dropdown",
                    "heading"     => __( "Grid spacing", 'hippo-plugin' ),
                    "param_name"  => "gird_space",
                    "value"       => array(
                        __('Yes', 'hippo-plugin') => '',
                        __('No', 'hippo-plugin')  =>'no-space'
                    ),
                    "admin_label" => true,
                    "description" => __( "If select no then row margin and grid padding will zero", 'hippo-plugin' )
                ),

                array(
                    'type'        => 'css_editor',
                    'heading'     => __('Css', 'hippo-plugin'),
                    'param_name'  => 'css',
                    'group'       => __('Design options', 'hippo-plugin'),
                ),

                array(
                    "type"        => "textfield",
                    "heading"     => __( "Extra class name", 'hippo-plugin' ),
                    "param_name"  => "el_class",
                    "description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'hippo-plugin' )
                )
            ))

        ));
        vc_map( $hippo_portfolio_grid_array );

        if ( class_exists( 'WPBakeryShortCode' ) and ! class_exists('WPBakeryShortCode_Hippo_Portfolio')) :
            class WPBakeryShortCode_Hippo_Portfolio extends WPBakeryShortCode {
            }

        endif;
endif; // function_exists( 'vc_map' )