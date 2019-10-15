<?php

defined('ABSPATH') or die('Keep Silent');

if (function_exists('vc_map')) :

    $hippo_services_array = apply_filters('hippo-plugin-vc-hippo_services-map', array(
        "name"        => __( "Services", 'hippo-plugin' ),
        "base"        => "hippo_services",
        "icon"        => "fa fa-cogs",
        'category'    => HIPPO_THEME_NAME . ' ' . __( 'Theme Elements', 'hippo-plugin' ),
        "description" => __( 'Display service post', 'hippo-plugin' ),
        "params"      => apply_filters('hippo-plugin-vc-hippo_services-params', array(
            array(
                "type"        => "autocomplete",
                "admin_label" => TRUE,
                "heading"     => __( "Select Post", 'hippo-plugin' ),
                "param_name"  => "service_post_id",
                "description" => __( "Select service that would you like to display", 'hippo-plugin' )
            ),
            array(
                "type"        => "textfield",
                "heading"     => __( "Word Limit", 'hippo-plugin' ),
                "param_name"  => "word_limit",
                "value"       => 15,
                "description" => __( "How many word would you like to show per post? ", 'hippo-plugin' )
            ),
            array(
                "type"        => "dropdown",
                "heading"     => __( "Show readmore button?", 'hippo-plugin' ),
                "param_name"  => "show_readmore_btn",
                "value" => array(
                    __("Yes", 'hippo-plugin') => "yes",
                    __("No", 'hippo-plugin')  => "no",
                ),
                "std"         => "yes",
                "description" => __( "If you do not like to show readmore link then select no", 'hippo-plugin' )
            ),
            array(
                "type"        => "textfield",
                "heading"     => __( "Change readmore text", 'hippo-plugin' ),
                "param_name"  => "change_readmore",
                "value"       => "Learn More",
                "description" => __( "You can change Read More text here.", 'hippo-plugin' ),
                "dependency"  => Array(
                    'element' => "show_readmore_btn",
                    'value'   => array( 'yes' )
                )
            ),
            array(
                "type"        => "dropdown",
                "heading"     => __( "Set custom link?", 'hippo-plugin' ),
                "param_name"  => "custom_link_show",
                "value" => array(
                    __("No", 'hippo-plugin') => "no",
                    __("Yes", 'hippo-plugin') => "yes"
                ),
                "std"         => "no",
                "description" => __( "If you do not like to show readmore link then select no", 'hippo-plugin' ),
                "dependency"  => Array(
                    'element' => "show_readmore_btn",
                    'value'   => array( 'yes' )
                )
            ),
            array(
                "type"        => "vc_link",
                "heading"     => __( "Custom link", 'hippo-plugin' ),
                "param_name"  => "custom_link",
                "description" => __( "If you like to set your own custom link then select custom link here, leave blank for default post link", 'hippo-plugin' ),
                "dependency"  => Array(
                    'element' => "custom_link_show",
                    'value'   => array( 'yes' )
                )
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


vc_map($hippo_services_array);

    if (class_exists('WPBakeryShortCode') and ! class_exists('WPBakeryShortCode_Hippo_Services')) :
        class WPBakeryShortCode_Hippo_Services extends WPBakeryShortCode {
        }
    endif; // if (class_exists('WPBakeryShortCode')
endif;  // if (function_exists('vc_map'))

