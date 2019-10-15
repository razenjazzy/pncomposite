<?php

	/**
	 * Theme Settings Config File
	 */

	defined( 'ABSPATH' ) or die( 'Keep Silent' );

	// This is your option name where all the Redux data is stored.
	$redux_opt_name = velvet_option_name();

	//===============================================================================
	// SET ARGUMENTS
	// For full documentation on arguments:
	// Please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
	//===============================================================================

	$theme = wp_get_theme(); // For use with some settings. Not necessary.

	$args = array(
		// TYPICAL -> Change these values as you need/desire
		'opt_name'                  => $redux_opt_name,
		// This is where your data is stored in the database velvet also becomes your global variable name.
		'display_name'              => $theme->get( 'Name' ),
		// Name that appears at the top of your panel
		'display_version'           => $theme->get( 'Version' ),
		// Version that appears at the top of your panel
		'menu_type'                 => 'menu',
		//Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
		'allow_sub_menu'            => TRUE,
		// Show the sections below the admin menu item or not
		'menu_title'                => sprintf( esc_html__( '%s Options', 'velvet' ), $theme->get( 'Name' ) ),
		'page_title'                => sprintf( esc_html__( '%s Theme Options', 'velvet' ), $theme->get( 'Name' ) ),
		// You will need to generate a Google API key to use this feature.
		// Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
		'google_api_key'            => '',
		// Set it you want google fonts to update weekly. A google_api_key value is required.
		'google_update_weekly'      => FALSE,
		// Must be defined to add google fonts to the typography module
		'async_typography'          => FALSE,
		// Use a asynchronous font on the front end or font string
		'disable_google_fonts_link' => FALSE,
		// Disable this in case you want to create your own google fonts loader
		'admin_bar'                 => TRUE,
		// Show the panel pages on the admin bar
		'admin_bar_icon'            => 'dashicons-admin-generic',
		// Choose an icon for the admin bar menu
		'admin_bar_priority'        => 50,
		// Choose an priority for the admin bar menu
		'global_variable'           => '',
		// Set a different name for your global variable other than the opt_name
		'dev_mode'                  => FALSE,
		'forced_dev_mode_off'       => FALSE,
		// Show the time the page took to load, etc
		'update_notice'             => TRUE,
		// If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
		'customizer'                => TRUE,
		// Enable basic customizer support
		//'open_expvelveted'     => true,                    // Allow you to start the panel in an expvelveted way initially.
		//'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

		// OPTIONAL -> Give you extra features
		'page_priority'             => '40',
		// Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
		'page_parent'               => 'themes.php',
		// For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
		'page_permissions'          => 'manage_options',
		// Permissions needed to access the options panel.
		'menu_icon'                 => '',
		// Specify a custom URL to an icon
		'last_tab'                  => '',
		// Force your panel to always open to a specific tab (by id)
		'page_icon'                 => 'icon-themes',
		// Icon displayed in the admin panel next to your menu_title
		'page_slug'                 => '',
		// Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
		'save_defaults'             => TRUE,
		// On load save the defaults to DB before user clicks save or not
		'default_show'              => FALSE,
		// If true, shows the default value next to each field that is not the default value.
		'default_mark'              => '',
		// What to print by the field's title if the value shown is default. Suggested: *
		'show_import_export'        => TRUE,
		// Shows the Import/Export panel when not used as a field.

		// CAREFUL -> These options are for advanced use only
		'transient_time'            => 60 * MINUTE_IN_SECONDS,
		'output'                    => TRUE,
		// Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
		'output_tag'                => TRUE,
		// Allows dynamic CSS to be generated for customizer velvet google fonts, but stops the dynamic CSS from going to the head
		'footer_credit'             => sprintf( esc_html__( '%s Theme Options', 'velvet' ), $theme->get( 'Name' ) ),
		// Disable the footer credit of Redux. Please leave if you can help it.

		// FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
		'database'                  => '',
		// possible: options, theme_mods, theme_mods_expvelveted, transient. Not fully functional, warning!
		'use_cdn'                   => TRUE,
		// If you prefer not to use the CDN for Select2, Ace Editor, velvet others, you may download the Redux Vendor Support plugin yourself velvet run locally or embed it in your code.

		// HINTS
		'hints'                     => array(
			'icon'          => 'el el-question-sign',
			'icon_position' => 'right',
			'icon_color'    => 'lightgray',
			'icon_size'     => 'normal',
			'tip_style'     => array(
				'color'   => 'red',
				'shadow'  => TRUE,
				'rounded' => FALSE,
				'style'   => '',
			),
			'tip_position'  => array(
				'my' => 'top left',
				'at' => 'bottom right',
			),
			'tip_effect'    => array(
				'show' => array(
					'effect'   => 'slide',
					'duration' => '500',
					'event'    => 'mouseover',
				),
				'hide' => array(
					'effect'   => 'slide',
					'duration' => '500',
					'event'    => 'click mouseleave',
				),
			),
		)
	);

	// ADMIN BAR LINKS -> Setup custom links in the admin bar menu as external items.
	$args[ 'admin_bar_links' ][] = array(
		'href'  => esc_url( 'http://goo.gl/rJeXiG' ),
		'title' => sprintf( esc_html__( '%s Theme Documentation', 'velvet' ), $theme->get( 'Name' ) ),
	);

	$args[ 'admin_bar_links' ][] = array(
		'href'  => esc_url( 'https://themehippo.com/tickets/' ),
		'title' => sprintf( esc_html__( '%s Theme Support', 'velvet' ), $theme->get( 'Name' ) ),
	);

	Redux::setArgs( $redux_opt_name, apply_filters( 'hippo_theme_option_args', $args ) );

	//===============================================================================
	//  END ARGUMENTS
	//===============================================================================

	Redux::setSection( $redux_opt_name, array(
		'icon'   => 'el-icon-cogs',
		'title'  => esc_html__( 'General Settings', 'velvet' ),
		'fields' => array(
			array(
				'id'       => 'demo-data-installer',
				'type'     => 'switch',
				'title'    => esc_html__( 'Theme Setup Wizard', 'velvet' ),
				'subtitle' => esc_html__( 'Show or Hide Theme Setup Wizard link on admin bar.', 'velvet' ),
				'on'       => esc_html__( 'Show', 'velvet' ),
				'off'      => esc_html__( 'Hide', 'velvet' ),
				'default'  => TRUE,
			),
			array(
				'id'       => 'show-preloader',
				'type'     => 'switch',
				'title'    => esc_html__( 'Page Preloader', 'velvet' ),
				'subtitle' => esc_html__( 'Show or Hide page preloader.', 'velvet' ),
				'on'       => esc_html__( 'Show', 'velvet' ),
				'off'      => esc_html__( 'Hide', 'velvet' ),
				'default'  => FALSE,
			),
			array(
				'id'       => 'back-to-top',
				'type'     => 'switch',
				'title'    => esc_html__( 'Back To Top', 'velvet' ),
				'subtitle' => esc_html__( 'Show or Hide Back To Top.', 'velvet' ),
				'on'       => esc_html__( 'Show', 'velvet' ),
				'off'      => esc_html__( 'Hide', 'velvet' ),
				'default'  => TRUE,
			),
			array(
				'id'       => 'sticky-menu',
				'type'     => 'switch',
				'title'    => esc_html__( 'Active Sticky Menu?', 'velvet' ),
				'subtitle' => esc_html__( 'You can active or deactive sticky menu from here.', 'velvet' ),
				'on'       => esc_html__( 'Yes', 'velvet' ),
				'off'      => esc_html__( 'No', 'velvet' ),
				'default'  => FALSE,
			),
		)
	) );

	Redux::setSection( $redux_opt_name, array(
		'icon'       => 'el-icon-brush',
		'customizer' => FALSE,
		'title'      => esc_html__( 'Preset Settings', 'velvet' ),
		'id'         => 'hippo_preset_manager',
		'fields'     => array(

			array(
				'id'       => 'less-compiler',
				'type'     => 'switch',
				'title'    => esc_html__( 'LESS Compiler', 'velvet' ),
				'subtitle' => esc_html__( 'Turn on built-in LESS CSS compiler.', 'velvet' ),
				'desc'     => esc_html__( 'You should always turned it off when you are on production / live site. But when you make changes on LESS file / preset / color / typography just turn it on, refresh your home page and turn it off again.', 'velvet' ),
				'on'       => 'Enable',
				'off'      => 'Disable',
				'default'  => FALSE,
			),
			array(
				'id'       => 'compress-less-output',
				'type'     => 'switch',
				'title'    => esc_html__( 'Compress LESS Output', 'velvet' ),
				'subtitle' => esc_html__( 'Compress LESS CSS Output for better page load if LESS compiler is enabled.', 'velvet' ),
				'on'       => 'Yes',
				'off'      => 'No',
				'default'  => FALSE,
				'required' => array( 'less-compiler', '=', '1' ),
			),
			array(
				'id'    => 'preset_change_warning',
				'type'  => 'info',
				'icon'  => 'el-icon-info-sign',
				'title' => esc_html__( 'Remember Please!', 'velvet' ),
				'style' => 'warning',
				'desc'  => esc_html__( 'If you wish to change preset or color settings, please make sure "Less Compiler" is enabled. Other wise no css effect will shown.', 'velvet' )
			),
			'hippo_preset_manager' => array(
				'id'       => 'preset',
				'type'     => 'hippo_preset',
				'title'    => esc_html__( 'Color Presets', 'velvet' ),
				'subtitle' => esc_html__( 'Theme Color Presets', 'velvet' ),
				'default'  => 'preset1',
				'options'  => array(
					'preset1' => esc_html__( 'Preset 1', 'velvet' ),
					'preset2' => esc_html__( 'Preset 2', 'velvet' ),
					'preset3' => esc_html__( 'Preset 3', 'velvet' ),
					'preset4' => esc_html__( 'Preset 4', 'velvet' ),
					'preset5' => esc_html__( 'Preset 5', 'velvet' ),
				),
				'presets'  => array(

					array(
						'id'       => 'custom-background-image',
						'type'     => 'media',
						'preview'  => 'true',
						'title'    => esc_html__( 'Body Background Image.', 'velvet' ),
						'subtitle' => esc_html__( 'Change Body Background Image.', 'velvet' )
					),
					array(
						'id'       => 'custom-background-color',
						'type'     => 'color', // hippo_preset_color
						'title'    => esc_html__( 'Body Background Color', 'velvet' ),
						'subtitle' => esc_html__( 'Change body color', 'velvet' ),
						'default'  => array(
							'preset1' => '#f6f6f6',
							'preset2' => 'Transparent',
							'preset3' => '#2a2335',
							'preset4' => '#001f3f',
							'preset5' => '#f7f7f7'
						)
					),
					array(
						'id'       => 'theme-color',
						'type'     => 'color', // hippo_preset_color
						'title'    => esc_html__( 'Theme Base Color', 'velvet' ),
						'subtitle' => esc_html__( 'Change theme base color', 'velvet' ),
						'default'  => array(
							'preset1' => '#fc534c',
							'preset2' => '#fc534c',
							'preset3' => '#ed4f65',
							'preset4' => '#0da574',
							'preset5' => '#6cd2e6'
						)
					),
					array(
						'id'       => 'content-background-color',
						'type'     => 'color', // hippo_preset_color
						'title'    => esc_html__( 'Content Background Color', 'velvet' ),
						'subtitle' => esc_html__( 'Change Content Background Color', 'velvet' ),
						'default'  => array(
							'preset1' => '#ffffff',
							'preset2' => '#202222',
							'preset3' => '#4b455f',
							'preset4' => '#ffffff',
							'preset5' => '#ffffff'
						)
					),
					array(
						'id'       => 'contents-color',
						'type'     => 'color', // hippo_preset_color
						'title'    => esc_html__( 'Content Color', 'velvet' ),
						'subtitle' => esc_html__( 'Change content color', 'velvet' ),
						'default'  => array(
							'preset1' => '#3d3b3b',
							'preset2' => '#ffffff',
							'preset3' => '#c6c1cf',
							'preset4' => '#5b5b5b',
							'preset5' => '#47555e'
						)
					),
					array(
						'id'       => 'menu-color',
						'type'     => 'color', // hippo_preset_color
						'title'    => esc_html__( 'Menu Color', 'velvet' ),
						'subtitle' => esc_html__( 'Change menu color', 'velvet' ),
						'default'  => array(
							'preset1' => '#ffffff',
							'preset2' => '#ffffff',
							'preset3' => '#ffffff',
							'preset4' => '#ffffff',
							'preset5' => '#ffffff'
						)
					),
					array(
						'id'       => 'headings-color',
						'type'     => 'color', // hippo_preset_color
						'title'    => esc_html__( 'Heading Color', 'velvet' ),
						'subtitle' => esc_html__( 'Change all heading color', 'velvet' ),
						'default'  => array(
							'preset1' => '#000000',
							'preset2' => '#ffffff',
							'preset3' => '#ffffff',
							'preset4' => '#353535',
							'preset5' => '#303841'
						)
					),
					array(
						'id'       => 'border-color',
						'type'     => 'color',
						'title'    => esc_html__( 'Border Color', 'velvet' ),
						'subtitle' => esc_html__( 'Change all border color', 'velvet' ),
						'default'  => array(
							'preset1' => '#e8e8e8',
							'preset2' => '#242828',
							'preset3' => '#504a70',
							'preset4' => '#e8e8e8',
							'preset5' => '#e8e8e8'
						)
					),
					array(
						'id'       => 'footer-background-color',
						'type'     => 'color', // hippo_preset_color
						'title'    => esc_html__( 'Footer Background Color', 'velvet' ),
						'subtitle' => esc_html__( 'Change footer background color', 'velvet' ),
						'default'  => array(
							'preset1' => '#1b1b1d',
							'preset2' => '#131414',
							'preset3' => '#3e3a4f',
							'preset4' => '#083358',
							'preset5' => '#27323a'
						)
					),
					array(
						'id'       => 'footer-text-color',
						'type'     => 'color', // hippo_preset_color
						'title'    => esc_html__( 'Footer Text Color', 'velvet' ),
						'subtitle' => esc_html__( 'Change footer text color', 'velvet' ),
						'default'  => array(
							'preset1' => '#ffffff',
							'preset2' => '#ffffff',
							'preset3' => '#ffffff',
							'preset4' => '#ffffff',
							'preset5' => '#ffffff'
						)
					),
				),
			),
		)
	) );

	Redux::setSection( $redux_opt_name, array(
		'icon'   => 'el-icon-font',
		'title'  => esc_html__( 'Typography Settings', 'velvet' ),
		'fields' => array(
			array(
				'id'          => 'body-typography',
				'type'        => 'typography',
				'title'       => esc_html__( 'Body Typography', 'velvet' ),
				'google'      => TRUE,
				'font-backup' => FALSE,
				'line-height' => FALSE,
				'color'       => FALSE,
				'text-align'  => FALSE,
				//'all_styles'  => TRUE,
				'font-style'  => TRUE,
				'font-size'   => FALSE,
				'subtitle'    => esc_html__( 'Body typography for body font.', 'velvet' ),
				'default'     => array(
					'font-style'  => '400',
					'font-family' => 'Roboto',
					'google'      => TRUE,
				),
			),
			array(
				'id'          => 'heading-typography',
				'type'        => 'typography',
				'title'       => esc_html__( 'Heading Typography', 'velvet' ),
				'google'      => TRUE,
				'font-backup' => FALSE,
				'line-height' => FALSE,
				'color'       => FALSE,
				'text-align'  => FALSE,
				//'all_styles'  => TRUE, // if true all font style called from google on frontend
				'font-style'  => TRUE,
				'font-size'   => FALSE,
				'subtitle'    => esc_html__( 'Heading typography font.', 'velvet' ),
				'default'     => array(
					'font-style'  => '700',
					'font-family' => 'Roboto',
					'google'      => TRUE,
				)
			),
		)
	) );

	Redux::setSection( $redux_opt_name, array(
		'icon'   => 'el-icon-lines',
		'title'  => esc_html__( 'Mobile Menu Settings', 'velvet' ),
		'fields' => array(
			array(
				'id'      => 'offcanvas-menu-position',
				'type'    => 'image_select',
				'title'   => esc_html__( 'Mobile menu position', 'velvet' ),
				'options' => array(
					'left'  => array(
						'alt' => 'Left Side',
						'img' => esc_url( ReduxFramework::$_url . 'assets/img/2cl.png' )
					),
					'right' => array(
						'alt' => 'Right Side',
						'img' => esc_url( ReduxFramework::$_url . 'assets/img/2cr.png' )
					),
				),
				'default' => 'left'
			),
			array(
				'id'      => 'offcanvas-menu-effect',
				'type'    => 'select',
				'title'   => esc_html__( 'Mobile menu effect', 'velvet' ),
				'options' => array(
					'slide-in-on-top' => esc_html__( 'Slide in on top', 'velvet' ),
					'reveal'          => esc_html__( 'Reveal', 'velvet' ),
				),
				'default' => 'reveal',
			),
		)
	) );

	Redux::setSection( $redux_opt_name, array(
		'icon'   => 'el-icon-livejournal',
		'title'  => esc_html__( 'Blog Settings', 'velvet' ),
		'fields' => array(

			array(
				'id'       => 'blog-title',
				'type'     => 'text',
				'title'    => esc_html__( 'Blog Subtitle', 'velvet' ),
				'subtitle' => esc_html__( 'Write blog sub title here.', 'velvet' ),
				'default'  => esc_html__( 'Blog', 'velvet' ),
			),
			array(
				'id'       => 'blog-layout',
				'type'     => 'image_select',
				'title'    => esc_html__( 'Blog Layout', 'velvet' ),
				'subtitle' => esc_html__( 'Blog layout content velvet sidebar alignment. Choose from Fullwidth, Left sidebar or Right sidebar layout.', 'velvet' ),
				'options'  => array(
					'sidebar-no'    => array(
						'alt' => esc_html__( '1 Column', 'velvet' ),
						'img' => esc_url( ReduxFramework::$_url . 'assets/img/1col.png' )
					),
					'sidebar-left'  => array(
						'alt' => esc_html__( '2 Columns Left', 'velvet' ),
						'img' => esc_url( ReduxFramework::$_url . 'assets/img/2cl.png' )
					),
					'sidebar-right' => array(
						'alt' => esc_html__( '2 Columns Right', 'velvet' ),
						'img' => esc_url( ReduxFramework::$_url . 'assets/img/2cr.png' )
					)
				),
				'default'  => 'sidebar-right'
			),
			array(
				'id'       => 'velvet-single-post-sidebar',
				'type'     => 'switch',
				'title'    => esc_html__( 'Single post sidebar', 'velvet' ),
				'subtitle' => esc_html__( 'Show or hide single post sidebar', 'velvet' ),
				'on'       => esc_html__( 'Show', 'velvet' ),
				'off'      => esc_html__( 'Hide', 'velvet' ),
				'default'  => TRUE,
			),
			array(
				'id'       => 'post-navigation',
				'type'     => 'switch',
				'title'    => esc_html__( 'Post navigation', 'velvet' ),
				'subtitle' => esc_html__( 'Blog single post navigation', 'velvet' ),
				'desc'     => esc_html__( '< Previous Article | Next Article >', 'velvet' ),
				'on'       => esc_html__( 'Show', 'velvet' ),
				'off'      => esc_html__( 'Hide', 'velvet' ),
				'default'  => TRUE,
			),
			array(
				'id'       => 'related-post',
				'type'     => 'switch',
				'title'    => esc_html__( 'Related Post', 'velvet' ),
				'subtitle' => esc_html__( 'Display related post on blog single post.', 'velvet' ),
				'on'       => esc_html__( 'Show', 'velvet' ),
				'off'      => esc_html__( 'Hide', 'velvet' ),
				'default'  => TRUE,
			),
			array(
				'id'       => 'related-post-heading',
				'type'     => 'text',
				'required' => array( 'related-post', '=', '1' ),
				'title'    => esc_html__( 'Related Post Heading', 'velvet' ),
				'subtitle' => esc_html__( 'Display related post heading.', 'velvet' ),
				'default'  => 'Related Articles',
			),
			array(
				'id'       => 'blog-page-nav',
				'type'     => 'switch',
				'title'    => esc_html__( 'Blog Pagination or Navigation', 'velvet' ),
				'subtitle' => esc_html__( 'Blog pagination style, posts pagination or newer / older posts', 'velvet' ),
				'desc'     => esc_html__( 'Older Entries | Newer Entries, posts pagination [1 | 2 | 3 ... 8 | 9]', 'velvet' ),
				'on'       => esc_html__( 'Pagination', 'velvet' ),
				'off'      => esc_html__( 'Navigation', 'velvet' ),
				'default'  => TRUE,
			),
		)
	) );

	Redux::setSection( $redux_opt_name, array(
		'icon'   => 'el-icon-file-edit',
		'title'  => esc_html__( 'Page Settings', 'velvet' ),
		'fields' => array(

			array(
				'id'       => 'page-layout',
				'type'     => 'image_select',
				'title'    => esc_html__( 'Page Layout', 'velvet' ),
				'subtitle' => esc_html__( 'Page layout content velvet sidebar alignment. Choose from Fullwidth, Left sidebar or Right sidebar layout.', 'velvet' ),
				'options'  => array(
					'sidebar-no'    => array(
						'alt' => esc_html__( '1 Column', 'velvet' ),
						'img' => esc_url( ReduxFramework::$_url . 'assets/img/1col.png' )
					),
					'sidebar-left'  => array(
						'alt' => esc_html__( '2 Columns Left', 'velvet' ),
						'img' => esc_url( ReduxFramework::$_url . 'assets/img/2cl.png' )
					),
					'sidebar-right' => array(
						'alt' => esc_html__( '2 Columns Right', 'velvet' ),
						'img' => esc_url( ReduxFramework::$_url . 'assets/img/2cr.png' )
					)
				),
				'default'  => 'sidebar-right'
			),
			array(
				'id'       => 'page-comment',
				'type'     => 'switch',
				'title'    => esc_html__( 'Globally enable or disable page comments', 'velvet' ),
				'subtitle' => esc_html__( 'Enable or Disabled Page Comments.', 'velvet' ),
				'on'       => esc_html__( 'Enable', 'velvet' ),
				'off'      => esc_html__( 'Disabled', 'velvet' ),
				'default'  => FALSE,
			),
		)
	) );

	// Page background setting
	Redux::setSection( $redux_opt_name, array(
		'icon'   => 'el-icon-picture',
		'title'  => __( 'Page Title Background', 'velvet' ),
		'fields' => array(

			array(
				'id'       => 'title-background-type',
				'type'     => 'switch',
				'title'    => __( 'Title Background Type', 'velvet' ),
				'subtitle' => __( 'Select header title background type', 'velvet' ),
				'on'       => __( 'Image', 'velvet' ),
				'off'      => __( 'Color', 'velvet' ),
				'default'  => FALSE,
			),
			array(
				'id'       => 'title-background-color',
				'type'     => 'color',
				'required' => array( 'title-background-type', '=', '0' ),
				'title'    => __( 'Header title background', 'velvet' ),
				'subtitle' => __( 'Change header title background color', 'velvet' ),
				'default'  => '#555353'
			),
			array(
				'id'       => 'title-service-image',
				'type'     => 'media',
				'preview'  => 'true',
				'required' => array( 'title-background-type', '=', '1' ),
				'title'    => esc_html__( 'Service Page Title Background.', 'velvet' ),
				'subtitle' => esc_html__( 'Change Service Page Title Header Background, dimension: 1920px &times; 150px', 'velvet' )
			),
			array(
				'id'       => 'title-portfolio-image',
				'type'     => 'media',
				'preview'  => 'true',
				'required' => array( 'title-background-type', '=', '1' ),
				'title'    => esc_html__( 'Portfolio Page Title Background.', 'velvet' ),
				'subtitle' => esc_html__( 'Change Portfolio Page Title Header Background, dimension: 1920px &times; 150px', 'velvet' )
			),
			array(
				'id'       => 'title-blog-image',
				'type'     => 'media',
				'preview'  => 'true',
				'required' => array( 'title-background-type', '=', '1' ),
				'title'    => esc_html__( 'Blog Page Title Background.', 'velvet' ),
				'subtitle' => esc_html__( 'Change Blog Page Title Header Background, dimension: 1920px &times; 150px', 'velvet' )
			),
			array(
				'id'       => 'title-page-image',
				'type'     => 'media',
				'preview'  => 'true',
				'required' => array( 'title-background-type', '=', '1' ),
				'title'    => esc_html__( 'Page Title Background.', 'velvet' ),
				'subtitle' => esc_html__( 'Change Page Title Header Background, dimension: 1920px &times; 150px', 'velvet' )
			),
			array(
				'id'       => 'title-author-image',
				'type'     => 'media',
				'preview'  => 'true',
				'required' => array( 'title-background-type', '=', '1' ),
				'title'    => esc_html__( 'Author Page Title Background.', 'velvet' ),
				'subtitle' => esc_html__( 'Change Author Page Title Header Background, dimension: 1920px &times; 150px', 'velvet' )
			),
			array(
				'id'       => 'title-tag-image',
				'type'     => 'media',
				'preview'  => 'true',
				'required' => array( 'title-background-type', '=', '1' ),
				'title'    => esc_html__( 'Tags Page Title Background.', 'velvet' ),
				'subtitle' => esc_html__( 'Change Tag Page Title Header Background, dimension: 1920px &times; 150px', 'velvet' )
			),
			array(
				'id'       => 'title-category-image',
				'type'     => 'media',
				'preview'  => 'true',
				'required' => array( 'title-background-type', '=', '1' ),
				'title'    => esc_html__( 'Category Page Title Background.', 'velvet' ),
				'subtitle' => esc_html__( 'Change Category Page Title Header Background, dimension: 1920px &times; 150px', 'velvet' )
			),
			array(
				'id'       => 'title-search-image',
				'type'     => 'media',
				'preview'  => 'true',
				'required' => array( 'title-background-type', '=', '1' ),
				'title'    => esc_html__( 'Search Page Title Background.', 'velvet' ),
				'subtitle' => esc_html__( 'Change Search Page Title Header Background, dimension: 1920px &times; 150px', 'velvet' )
			),
			array(
				'id'       => 'title-404-image',
				'type'     => 'media',
				'preview'  => 'true',
				'required' => array( 'title-background-type', '=', '1' ),
				'title'    => esc_html__( '404 Page Title Background.', 'velvet' ),
				'subtitle' => esc_html__( 'Change 404 Page Title Header Background, dimension: 1920px &times; 150px', 'velvet' )
			),
			array(
				'id'       => 'title-archive-image',
				'type'     => 'media',
				'preview'  => 'true',
				'required' => array( 'title-background-type', '=', '1' ),
				'title'    => esc_html__( 'Archive Page Title Background.', 'velvet' ),
				'subtitle' => esc_html__( 'Change Archive Page Title Header Background, dimension: 1920px &times; 150px', 'velvet' )
			)
		)
	) );

	Redux::setSection( $redux_opt_name, array(
		'icon'   => 'el-icon-photo',
		'title'  => esc_html__( 'Footer Settings', 'velvet' ),
		'fields' => array(
			array(
				'id'       => 'social-section-show',
				'type'     => 'switch',
				'title'    => esc_html__( 'Show Social Section', 'velvet' ),
				'subtitle' => esc_html__( 'Show or Hide Social Section in Header.', 'velvet' ),
				'on'       => esc_html__( 'Show', 'velvet' ),
				'off'      => esc_html__( 'Hide', 'velvet' ),
				'default'  => TRUE,
			),
			array(
				'id'       => 'rss-link',
				'type'     => 'switch',
				'required' => array( 'social-section-show', '=', '1' ),
				'title'    => esc_html__( 'Show RSS Link', 'velvet' ),
				'subtitle' => esc_html__( 'Show or Hide RSS Link.', 'velvet' ),
				'on'       => esc_html__( 'Show', 'velvet' ),
				'off'      => esc_html__( 'Hide', 'velvet' ),
				'default'  => TRUE,
			),
			array(
				'id'       => 'facebook-link',
				'type'     => 'text',
				'required' => array( 'social-section-show', '=', '1' ),
				'title'    => esc_html__( 'Facebook Link', 'velvet' ),
				'subtitle' => esc_html__( 'Insert your custom link to show the Facebook icon. Leave blank to hide icon.', 'velvet' ),
				'default'  => "#"
			),
			array(
				'id'       => 'twitter-link',
				'type'     => 'text',
				'required' => array( 'social-section-show', '=', '1' ),
				'title'    => esc_html__( 'Twitter Link', 'velvet' ),
				'subtitle' => esc_html__( 'Insert your custom link to show the Twitter icon. Leave blank to hide icon.', 'velvet' ),
				'default'  => "#"
			),
			array(
				'id'       => 'google-plus-link',
				'type'     => 'text',
				'required' => array( 'social-section-show', '=', '1' ),
				'title'    => esc_html__( 'Google Plus Link', 'velvet' ),
				'subtitle' => esc_html__( 'Insert your custom link to show the Google Plus icon. Leave blank to hide icon.', 'velvet' ),
				'default'  => "#"
			),
			array(
				'id'       => 'youtube-link',
				'type'     => 'text',
				'required' => array( 'social-section-show', '=', '1' ),
				'title'    => esc_html__( 'Youtube Link', 'velvet' ),
				'subtitle' => esc_html__( 'Insert your custom link to show the Youtube icon. Leave blank to hide icon.', 'velvet' ),
			),
			array(
				'id'       => 'skype-link',
				'type'     => 'text',
				'required' => array( 'social-section-show', '=', '1' ),
				'title'    => esc_html__( 'Skype Link', 'velvet' ),
				'subtitle' => esc_html__( 'Insert your custom link to show the Skype icon. Leave blank to hide icon.', 'velvet' ),
			),
			array(
				'id'       => 'pinterest-link',
				'type'     => 'text',
				'required' => array( 'social-section-show', '=', '1' ),
				'title'    => esc_html__( 'Pinterest Link', 'velvet' ),
				'subtitle' => esc_html__( 'Insert your custom link to show the Pinterest icon. Leave blank to hide icon.', 'velvet' ),
				'default'  => "#"
			),
			array(
				'id'       => 'flickr-link',
				'type'     => 'text',
				'required' => array( 'social-section-show', '=', '1' ),
				'title'    => esc_html__( 'Flickr Link', 'velvet' ),
				'subtitle' => esc_html__( 'Insert your custom link to show the Flickr icon. Leave blank to hide icon.', 'velvet' ),
			),
			array(
				'id'       => 'linkedin-link',
				'type'     => 'text',
				'required' => array( 'social-section-show', '=', '1' ),
				'title'    => esc_html__( 'Linkedin Link', 'velvet' ),
				'subtitle' => esc_html__( 'Insert your custom link to show the Linkedin icon. Leave blank to hide icon.', 'velvet' ),
			),
			array(
				'id'       => 'vimeo-link',
				'type'     => 'text',
				'required' => array( 'social-section-show', '=', '1' ),
				'title'    => esc_html__( 'Vimeo Link', 'velvet' ),
				'subtitle' => esc_html__( 'Insert your custom link to show the Vimeo icon. Leave blank to hide icon.', 'velvet' ),
			),
			array(
				'id'       => 'instagram-link',
				'type'     => 'text',
				'required' => array( 'social-section-show', '=', '1' ),
				'title'    => esc_html__( 'Instagram Link', 'velvet' ),
				'subtitle' => esc_html__( 'Insert your custom link to show the Instagram icon. Leave blank to hide icon.', 'velvet' ),
			),
			array(
				'id'       => 'dribbble-link',
				'type'     => 'text',
				'required' => array( 'social-section-show', '=', '1' ),
				'title'    => esc_html__( 'Dribbble Link', 'velvet' ),
				'subtitle' => esc_html__( 'Insert your custom link to show the Dribbble icon. Leave blank to hide icon.', 'velvet' ),
			),
			array(
				'id'       => 'tumblr-link',
				'type'     => 'text',
				'required' => array( 'social-section-show', '=', '1' ),
				'title'    => esc_html__( 'Tumblr Link', 'velvet' ),
				'subtitle' => esc_html__( 'Insert your custom link to show the Tumblr icon. Leave blank to hide icon.', 'velvet' ),
			),
			array(
				'id'       => 'footer-copyright',
				'type'     => 'editor',
				'title'    => esc_html__( 'Footer Copyright Text', 'velvet' ),
				'subtitle' => esc_html__( 'Change footer copyright text', 'velvet' )
			),
		)
	) );

	//   Redux::setSection( $redux_opt_name, array());

	//===============================================================================
	//  END SETTINGS
	//===============================================================================