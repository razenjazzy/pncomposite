<?php

    function hippo_post_type_services()
    {

        $labels = array(
            'name'               => _x('Services', 'hippo-plugin'),
            'singular_name'      => _x('Service', 'hippo-plugin'),
            'menu_name'          => __('Service', 'hippo-plugin'),
            'parent_item_colon'  => __('Parent Service:', 'hippo-plugin'),
            'all_items'          => __('Services', 'hippo-plugin'),
            'view_item'          => __('View Service', 'hippo-plugin'),
            'add_new_item'       => __('Add New Service', 'hippo-plugin'),
            'add_new'            => __('New Service', 'hippo-plugin'),
            'edit_item'          => __('Edit Service', 'hippo-plugin'),
            'update_item'        => __('Update Service', 'hippo-plugin'),
            'search_items'       => __('Search Service', 'hippo-plugin'),
            'not_found'          => __('No Service Item found', 'hippo-plugin'),
            'not_found_in_trash' => __('No Service Item found in Trash', 'hippo-plugin'),
        );
        $args   = array(
            'description'         => __('Service', 'hippo-plugin'),
            'labels'              => $labels,
            'supports'            => array('title', 'editor', 'page-attributes', 'thumbnail', 'excerpt'),
            'taxonomies'          => array(),
            'hierarchical'        => FALSE,
            'public'              => TRUE,
            'show_ui'             => TRUE,
            'show_in_menu'        => TRUE,
            'show_in_nav_menus'   => TRUE,
            'show_in_admin_bar'   => TRUE,
            'menu_position'       => 6,
            'menu_icon'           => 'dashicons-screenoptions',
            'can_export'          => TRUE,
            'has_archive'         => FALSE,
            'exclude_from_search' => TRUE,
            'publicly_queryable'  => TRUE,
            'capability_type'     => 'post',
        );

        register_post_type('service', $args);
    }

    // Hook into the 'init' action
    add_action('init', 'hippo_post_type_services');

