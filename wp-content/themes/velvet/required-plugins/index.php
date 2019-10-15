<?php
	/**
	 * This file represents an example of the code that themes would use to register
	 * the required plugins.
	 *
	 * It is expected that theme authors would copy and paste this code into their
	 * functions.php file, and amend to suit.
	 *
	 * @see        http://tgmpluginactivation.com/configuration/ for detailed documentation.
	 *
	 * @package    TGM-Plugin-Activation
	 * @subpackage Example
	 * @version    2.5.0
	 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
	 * @copyright  Copyright (c) 2011, Thomas Griffin
	 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
	 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
	 */
	/**
	 * Include the TGM_Plugin_Activation class.
	 */
	defined( 'ABSPATH' ) or die( 'Keep Silent' );

	require_once get_template_directory() . "/required-plugins/class-tgm-plugin-activation.php";

	add_action( 'tgmpa_register', 'velvet_theme_register_required_plugins' );
	/**
	 * Register the required plugins for this theme.
	 *
	 * In this example, we register five plugins:
	 * - one included with the TGMPA library
	 * - two from an external source, one from an arbitrary source, one from a GitHub repository
	 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
	 *
	 * The variable passed to tgmpa_register_plugins() should be an array of plugin
	 * arrays.
	 *
	 * This function is hooked into tgmpa_init, which is fired within the
	 * TGM_Plugin_Activation class constructor.
	 */
	function velvet_theme_register_required_plugins() {
		/*
		 * Array of plugin arrays. Required keys are name and slug.
		 * If the source is NOT from the .org repo, then source is also required.
		 */

		$plugins = array(

			// Velvet Theme Plugin
			array(
				'name'     => esc_html__( 'Velvet Theme Plugin', 'velvet' ),
				// The plugin name
				'slug'     => 'hippo-plugin',
				// The plugin slug (typically the folder name)
				'source'   => esc_url( 'http://s3-us-west-2.amazonaws.com/helper-plugins/velvet-theme-plugin.zip' ),
				// The plugin source
				'required' => TRUE,
				// If false, the plugin is only 'recommended' instead of required
				'version'  => '1.0.0'
			),

			// Visual Composer
			array(
				'name'     => esc_html__( 'WPBakery Visual Composer', 'velvet' ),
				// The plugin name
				'slug'     => 'js_composer',
				// The plugin slug (typically the folder name)
				'source'   => esc_url( 'http://s3-us-west-2.amazonaws.com/theme-required-plugins/js_composer.zip' ),
				// The plugin source
				'required' => TRUE,
				// If false, the plugin is only 'recommended' instead of required
				'version'  => '4.11.2.1'
			),

			// Revolution Slider
			array(
				'name'     => esc_html__( 'Revolution Slider', 'velvet' ),
				// The plugin name
				'slug'     => 'revslider',
				// The plugin slug (typically the folder name)
				'source'   => esc_url( 'http://s3-us-west-2.amazonaws.com/theme-required-plugins/revslider.zip' ),
				// The plugin source
				'required' => TRUE,
				'version'  => '5.2.6'
				// If false, the plugin is only 'recommended' instead of required
			),

			// Envato WordPress Toolkit
			array(
				'name'     => esc_html__( 'Envato WordPress Toolkit', 'velvet' ),
				// The plugin name
				'slug'     => 'envato-wordpress-toolkit',
				// The plugin slug (typically the folder name)
				'source'   => esc_url( 'https://github.com/envato/envato-wordpress-toolkit/archive/master.zip' ),
				// The plugin source
				'required' => FALSE,
				// If false, the plugin is only 'recommended' instead of required
			),

			// Contact Form 7
			array(
				'name'     => esc_html__( 'Contact Form 7', 'velvet' ),
				'slug'     => 'contact-form-7',
				'required' => TRUE,
			),

			// Black Studio TinyMCE Widget
			array(
				'name'     => esc_html__( 'Black Studio TinyMCE Widget', 'velvet' ),
				'slug'     => 'black-studio-tinymce-widget',
				'required' => TRUE,
			),

			// Redux Framework
			array(
				'name'     => esc_html__( 'Redux Framework', 'velvet' ),
				'slug'     => 'redux-framework',
				'required' => TRUE,
			),

			// Regenerate Thumbnails
			array(
				'name'     => esc_html__( 'Regenerate Thumbnails', 'velvet' ),
				'slug'     => 'regenerate-thumbnails',
				'required' => FALSE,
			),

			// MailChimp for WordPress
			array(
				'name'     => esc_html__( 'MailChimp for WordPress', 'velvet' ),
				'slug'     => 'mailchimp-for-wp',
				'required' => FALSE,
			),
		);

		/*
		 * Array of configuration settings. Amend each line as needed.
		 *
		 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
		 * strings available, please help us make TGMPA even better by giving us access to these translations or by
		 * sending in a pull-request with .po file(s) with the translations.
		 *
		 * Only uncomment the strings in the config array if you want to customize the strings.
		 */
		$config = array(
			'id'           => 'velvet',                 // Unique ID for hashing notices for multiple instances of TGMPA.
			'default_path' => '',                      // Default absolute path to bundled plugins.
			'menu'         => 'tgmpa-install-plugins', // Menu slug.
			'has_notices'  => TRUE,                    // Show admin notices or not.
			'dismissable'  => TRUE,                    // If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => FALSE,                   // Automatically activate plugins after installation or not.
			'message'      => '',                      // Message to output right before the plugins table.
		);

		tgmpa( $plugins, $config );
	}