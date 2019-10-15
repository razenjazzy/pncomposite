<?php

/**
 * The Free Loader Class
 * @package logo-carousel-free
 * @since 3.0
 */
class SPLC_Free_Loader {

	/*
	 * Free Loader constructor
	 */
	function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		require_once( SP_LC_PATH . 'public/views/shortcoderender.php' );
		require_once( SP_LC_PATH . 'public/views/shortcode-deprecated.php' );
		require_once( SP_LC_PATH . 'admin/wpl-mce-button/button.php' );
	}

	/**
	 * Admin Menu
	 */
	function admin_menu() {
		add_submenu_page( 'edit.php?post_type=wpl_logo_carousel', __( 'Logo Carousel Help', 'logo-carousel-free' ), __( 'Help', 'logo-carousel-free' ), 'manage_options', 'lc_help', array( $this, 'help_page_callback' ) );
	}

	/**
	 * Help Page Callback
	 */
	public function help_page_callback() {
		?>
		<div class="wrap about-wrap sp-lc-help">
			<h1><?php _e( 'Welcome to Logo Carousel!', 'logo-carousel-free' ); ?></h1>
			<p class="about-text"><?php _e( 'Thank you for installing Logo Carousel! You\'re now running the most popular Logo Carousel plugin. This video will help you get started with the plugin.', 'logo-carousel-free'); ?></p>
			<div class="wp-badge"></div>
			<hr>

			<div class="headline-feature feature-video">
				<iframe width="560" height="315" src="https://www.youtube.com/embed/nWuTLgmAzd0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
			</div>

			<hr>

			<div class="feature-section three-col">
				<div class="col">
					<div class="sp-lc-feature sp-lc-text-center">
						<i class="sp-lc-font-icon fa fa-life-ring"></i>
						<h3>Need any Assistance?</h3>
						<p>Our Expert Support Team is always ready to help you out promptly.</p>
						<a href="https://shapedplugin.com/support-forum/" target="_blank" class="button button-primary">Contact Support</a>
					</div>
				</div>
				<div class="col">
					<div class="sp-lc-feature sp-lc-text-center">
						<i class="sp-lc-font-icon fa fa-file-text"></i>
						<h3>Looking for Documentation?</h3>
						<p>We have detailed documentation on every aspects of Logo Carousel.</p>
						<a href="https://shapedplugin.com/docs/docs/logo-carousel/" target="_blank" class="button button-primary">Documentation</a>
					</div>
				</div>
				<div class="col">
					<div class="sp-lc-feature sp-lc-text-center">
						<i class="sp-lc-font-icon fa fa-thumbs-up"></i>
						<h3>Like This Plugin?</h3>
						<p>If you like Logo Carousel, please leave us a 5 star rating.</p>
						<a href="https://wordpress.org/support/plugin/logo-carousel-free/reviews/?filter=5#new-post" target="_blank" class="button button-primary">Rate the Plugin</a>
					</div>
				</div>
			</div>

			<hr>

			<div class="sp-lc-pro-features">
				<h2 class="sp-lc-text-center">Upgrade to Logo Carousel Pro!</h2>
				<p class="sp-lc-text-center sp-lc-pro-subtitle">We've added 200+ extra features in our Premium Version of this plugin. Let’s see some amazing features.</p>
				<div class="feature-section three-col">
					<div class="col">
						<div class="sp-lc-feature">
							<h3><span class="dashicons dashicons-yes"></span>Responsive & Touch Ready</h3>
							<p>All layouts are responsive with touch-friendly on any devices, and thoroughly tested & optimized for best performance. Logo Carousel Pro performs speedily on all sites.</p>
						</div>
					</div>
					<div class="col">
						<div class="sp-lc-feature">
							<h3><span class="dashicons dashicons-yes"></span>Compatible with any Themes</h3>
							<p>Guaranteed to work with your any WordPress site including Genesis, Divi, WooThemes, ThemeForest or any theme, in any WordPress single site and multisite network.</p>
						</div>
					</div>
					<div class="col">
						<div class="sp-lc-feature">
							<h3><span class="dashicons dashicons-yes"></span>Advanced Shortcode Generator</h3>
							<p>Logo Carousel Pro comes with a built-in Shortcode Generator to control easily the look and settings of the logo showcase. Save, edit, copy and paste shortcode where you want!</p>
						</div>
					</div>
					<div class="col">
						<div class="sp-lc-feature">
							<h3><span class="dashicons dashicons-yes"></span>Design Without Writing CSS</h3>
							<p>There are unlimited stunning styling options like color, font family, size, alignment etc. to stylize your own way without any limitation. No Coding Skills Needed!</p>
						</div>
					</div>
					<div class="col">
						<div class="sp-lc-feature">
							<h3><span class="dashicons dashicons-yes"></span>5 Logo Layouts (Carousel, Grid, Filter, List, Inline)</h3>
							<p>With Logo Carousel Pro, You can display a set of logo images in 5 beautiful layouts: Carousel Slider, Grid, List, Filter, and Inline. All the layouts are completely customizable.</p>
						</div>
					</div>
					<div class="col">
						<div class="sp-lc-feature">
							<h3><span class="dashicons dashicons-yes"></span>840+ Google Fonts</h3>
							<p>Add your desired font family from 840+ Google Fonts library. Customize the font family, size, transform, letter spacing, color, alignment, and line-height for each logo showcase.</p>
						</div>
					</div>


					<div class="col">
						<div class="sp-lc-feature">
							<h3><span class="dashicons dashicons-yes"></span>Drag & Drop Logo ordering</h3>
							<p>Drag & Drop Logo ordering is one of the amazing features of Logo Carousel Pro. You can order your logos easily by drag & drop feature and also order by date, title, random etc.</p>
						</div>
					</div>
					<div class="col">
						<div class="sp-lc-feature">
							<h3><span class="dashicons dashicons-yes"></span>Group Logo Showcase</h3>
							<p>Manage your logos by grouping into separate categories based on your demand. Create an unlimited category for logos and display logos from particular or selected categories.</p>
						</div>
					</div>
					<div class="col">
						<div class="sp-lc-feature">
							<h3><span class="dashicons dashicons-yes"></span>Internal & External Logo Links</h3>
							<p>You can set URLs to them, they can have links that can open on the same page or on a new page. If you don’t add any URL for the particular logo, the logo will not be linked up.</p>
						</div>
					</div>
					<div class="col">
						<div class="sp-lc-feature">
							<h3><span class="dashicons dashicons-yes"></span>Isotope Filtering by Category</h3>
							<p>Group your logo images by categories and display only a selected category or all of them! This way you can even have a list for clients, other lists for sponsors, and so on!</p>
						</div>
					</div>
					<div class="col">
						<div class="sp-lc-feature">
							<h3><span class="dashicons dashicons-yes"></span>Live Category Filter (Opacity)</h3>
							<p>In the Grid layouts you can also include a live category filter, so your visitors can select which logos to see. An opacity will be on the logo and change opacity you need.</p>
						</div>
					</div>
					<div class="col">
						<div class="sp-lc-feature">
							<h3><span class="dashicons dashicons-yes"></span>Carousel Mode</h3>
							<p>Logo Carousel Pro has three(3) carousel mode: Standard, Ticker (Smooth looping, with no pause), and Center. You can change the carousel mode based on your choice or demand.</p>
						</div>
					</div>
					<div class="col">
						<div class="sp-lc-feature">
							<h3><span class="dashicons dashicons-yes"></span>Vertical and Horizontal Direction</h3>
							<p>The plugin has both Horizontal and Vertical carousel direction. By default Horizontal direction mode is enabled. The Vertical direction is an amazing feature for the plugin.</p>
						</div>
					</div>
					<div class="col">
						<div class="sp-lc-feature">
							<h3><span class="dashicons dashicons-yes"></span>Logo Display Options</h3>
							<p>Showcase your logo images with Tooltips, Title, Description and CTA button (Read more). You can also set easily the logo title and tooltips positions from settings.</p>
						</div>
					</div>
					<div class="col">
						<div class="sp-lc-feature">
							<h3><span class="dashicons dashicons-yes"></span>Popup View for Logo Detail</h3>
							<p>Display logo details like Logo, Title, Description etc. in a Popup view. Make your logo showcase visually appealing popup full view and customize the popup content easily.</p>
						</div>
					</div>
					<div class="col">
						<div class="sp-lc-feature">
							<h3><span class="dashicons dashicons-yes"></span>Logo Effects on Hover</h3>
							<p>We have set different logo image hover effects like, GrayScale, Zoom In, Zoom out, Blur, Opacity etc. that are both edgy and appealing. Try them all. Use the one you like best.</p>
						</div>
					</div>
					<div class="col">
						<div class="sp-lc-feature">
							<h3><span class="dashicons dashicons-yes"></span>Multiple Logo Row</h3>
							<p>With the Premium Version, you can add and slide the unlimited number of rows at a time in carousel layout. We normally set single row by default. Set number of rows based on your choice.</p>
						</div>
					</div>
					<div class="col">
						<div class="sp-lc-feature">
							<h3><span class="dashicons dashicons-yes"></span>Tooltips Settings & Highlight</h3>
							<p>You can choose to display tooltips or not, positions, width, effects, background etc. Simply stylize logo background, border, box-shadow, and display on hover highlight of the image.</p>
						</div>
					</div>
					<div class="col">
						<div class="sp-lc-feature">
							<h3><span class="dashicons dashicons-yes"></span>Custom Logo Re-sizing</h3>
							<p>You can change the default size of your logo images on the settings. Set width or height from settings. New uploaded images will be resized to the specified dimensions.</p>
						</div>
					</div>
					<div class="col">
						<div class="sp-lc-feature">
							<h3><span class="dashicons dashicons-yes"></span>Multilingual Ready</h3>
							<p>Logo Carousel Pro is fully multilingual ready with WPML, Polylang, qTranslate-x, GTranslate, Google Language Translator, WPGlobus etc. popular translation plugins.</p>
						</div>
					</div>
					<div class="col">
						<div class="sp-lc-feature">
							<h3><span class="dashicons dashicons-yes"></span>Multi-site Supported</h3>
							<p>One of the important features of Logo Carousel Pro is Multi-site ready. The Premium version works great in the multi-site network.</p>
						</div>
					</div>
					<div class="col">
						<div class="sp-lc-feature">
							<h3><span class="dashicons dashicons-yes"></span>Widget Ready</h3>
							<p>To include logo carousel or grid inside a widget area is as simple as including any other widget! The plugin is widget ready. Create a shortcode first and use it simply in the widget.</p>
						</div>
					</div>
					<div class="col">
						<div class="sp-lc-feature">
							<h3><span class="dashicons dashicons-yes"></span>Custom CSS to Override Styles</h3>
							<p>Logo Carousel Pro is completely customizable and also added a custom CSS field option to override styles, if necessary without editing the CSS files. It’s easy enough!</p>
						</div>
					</div>
					<div class="col">
						<div class="sp-lc-feature">
							<h3><span class="dashicons dashicons-yes"></span>Enqueue or Dequeue Scripts/CSS</h3>
							<p>We have set advanced options to disable and enable Scripts or CSS files. This advanced settings fields will help you avoid conflicts and loading issue.</p>
						</div>
					</div>
					<div class="col">
						<div class="sp-lc-feature">
							<h3><span class="dashicons dashicons-yes"></span>Fast and Friendly Support</h3>
							<p>A fully dedicated and expert support team is ready to help you instantly whenever you face with any issues to configure or use the plugin. We love helping our customers.</p>
						</div>
					</div>
					<div class="col">
						<div class="sp-lc-feature">
							<h3><span class="dashicons dashicons-yes"></span>Lifetime Automatic Updates</h3>
							<p>Logo Carousel Pro is integrated with automatic updates which allows you to update the plugin through the WordPress dashboard without downloading them manually.</p>
						</div>
					</div>
					<div class="col">
						<div class="sp-lc-feature">
							<h3><span class="dashicons dashicons-yes"></span>Page Builders Ready</h3>
							<p>The plugin is carefully crafted and tested with the popular Page Builders plugins: Gutenberg, WPBakery, Elementor, Divi builder, BeaverBuilder, SiteOrgin etc.</p>
						</div>
					</div>
				</div>
			</div>

			<div class="sp-lc-upgrade-sticky-footer sp-lc-text-center">
				<p><a href="https://shapedplugin.com/demo/logo-carousel-pro" target="_blank" class="button button-primary">Live Demo</a> <a href="https://shapedplugin.com/plugin/logo-carousel-pro/" target="_blank" class="button button-primary">Upgrade Now</a></p>
			</div>

		</div>
		<?php
	}

}

new SPLC_Free_Loader();
