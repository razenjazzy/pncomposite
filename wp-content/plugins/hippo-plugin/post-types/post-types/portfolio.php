<?php


    function hippo_post_type_portfolio()
    {

        $labels = array(
            'name'               => _x('Portfolio', 'hippo-plugin'),
            'singular_name'      => _x('Portfolio', 'hippo-plugin'),
            'menu_name'          => __('Portfolio', 'hippo-plugin'),
            'parent_item_colon'  => __('Parent Portfolio:', 'hippo-plugin'),
            'all_items'          => __('Portfolios', 'hippo-plugin'),
            'view_item'          => __('View Portfolio', 'hippo-plugin'),
            'add_new_item'       => __('Add New Portfolio', 'hippo-plugin'),
            'add_new'            => __('New Portfolio', 'hippo-plugin'),
            'edit_item'          => __('Edit Portfolio', 'hippo-plugin'),
            'update_item'        => __('Update Portfolio', 'hippo-plugin'),
            'search_items'       => __('Search Portfolio', 'hippo-plugin'),
            'not_found'          => __('No Portfolio Item found', 'hippo-plugin'),
            'not_found_in_trash' => __('No Portfolio Item found in Trash', 'hippo-plugin'),
        );
        $args   = array(
            'description'         => __('Portfolio', 'hippo-plugin'),
            'labels'              => $labels,
            'supports'            => array('title', 'editor', 'page-attributes','thumbnail', 'comments'),
            'taxonomies'          => array('portfolio-type'),
            'hierarchical'        => FALSE,
            'public'              => TRUE,
            'show_ui'             => TRUE,
            'show_in_menu'        => TRUE,
            'show_in_nav_menus'   => TRUE,
            'show_in_admin_bar'   => TRUE,
            'menu_position'       => 6,
            'menu_icon'           => 'dashicons-images-alt',
            'can_export'          => TRUE,
            'has_archive'         => FALSE,
            'exclude_from_search' => TRUE,
            'publicly_queryable'  => TRUE,
            'capability_type'     => 'post',
        );


        register_post_type('portfolio', $args);


    }

    // Hook into the 'init' action
    add_action('init', 'hippo_post_type_portfolio');
    // Register portfolio type

    function register_taxonomy_portfolio_type() {

        $labels = array(
            'name' => _x( 'Category', 'type' ),
            'singular_name' => _x( 'Category', 'type' ),
            'search_items' => _x( 'Search Category', 'type' ),
            'popular_items' => _x( 'Popular Category', 'type' ),
            'all_items' => _x( 'All Category', 'type' ),
            'parent_item' => _x( 'Parent Category', 'type' ),
            'parent_item_colon' => _x( 'Parent Category:', 'type' ),
            'edit_item' => _x( 'Edit Category', 'type' ),
            'update_item' => _x( 'Update Category', 'type' ),
            'add_new_item' => _x( 'Add New Category', 'type' ),
            'new_item_name' => _x( 'New Category', 'type' ),
            'separate_items_with_commas' => _x( 'Separate categories with commas', 'type' ),
            'add_or_remove_items' => _x( 'Add or remove categories', 'type' ),
            'choose_from_most_used' => _x( 'Choose from most used categories', 'type' ),
            'menu_name' => _x( 'Categories', 'type' ),
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'show_in_nav_menus' => false,
            'show_ui' => true,
            'show_tagcloud' => false,
            'show_admin_column' => true,
            'hierarchical' => true,
            'rewrite' => true,
            'query_var' => true
        );

        register_taxonomy( 'portfolio-type', array('portfolio'), $args );
    }

    add_action( 'init', 'register_taxonomy_portfolio_type' );



    // Register portfolio tag

    function register_taxonomy_portfolio_tag() {

        $labels = array(
            'name' => _x( 'Tags', 'tag' ),
            'singular_name' => _x( 'Tag', 'tag' ),
            'search_items' => _x( 'Search Tag', 'tag' ),
            'popular_items' => _x( 'Popular Tag', 'tag' ),
            'all_items' => _x( 'All Tag', 'tag' ),
            'parent_item' => _x( 'Parent Tag', 'tag' ),
            'parent_item_colon' => _x( 'Parent Tag:', 'tag' ),
            'edit_item' => _x( 'Edit Tag', 'tag' ),
            'update_item' => _x( 'Update Tag', 'tag' ),
            'add_new_item' => _x( 'Add New Tag', 'tag' ),
            'new_item_name' => _x( 'New Tag', 'tag' ),
            'separate_items_with_commas' => _x( 'Separate tags with commas', 'tag' ),
            'add_or_remove_items' => _x( 'Add or remove tags', 'tag' ),
            'choose_from_most_used' => _x( 'Choose from most used tags', 'tag' ),
            'menu_name' => _x( 'Tags', 'tag' ),
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'show_in_nav_menus' => false,
            'show_ui' => true,
            'show_tagcloud' => true,
            'show_admin_column' => true,
            'hierarchical' => true,
            'rewrite' => true,
            'query_var' => true
        );

        register_taxonomy( 'portfolio-tag', array('portfolio'), $args );
    }

    add_action( 'init', 'register_taxonomy_portfolio_tag' );

