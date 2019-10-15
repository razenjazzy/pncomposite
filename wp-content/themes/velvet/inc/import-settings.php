<?php

	defined( 'ABSPATH' ) or die( 'Keep Silent' );

	define( 'HIPPO_CURRENT_IMPORT_URL', untrailingslashit( esc_url( site_url() ) ) );
	define( 'HIPPO_DEVELOPMENT_URL', 'http://velvet.demo' );
	define( 'HIPPO_IMPORTABLE_ATTACHMENT_URL', 'http://www.cloudsoftwaresolution.com/imgstore/repository/products-attachments/wordpress/velvet' );

	$upload_dir = wp_upload_dir();
	define( 'HIPPO_CURRENT_ATTACHMENT_URL', $upload_dir[ 'baseurl' ] );

	//----------------------------------------------------------------------
	// Show instructions after dummy data imported
	//----------------------------------------------------------------------


	function velvet_import_rev_slider_slides() {
		return array(
			'http://www.cloudsoftwaresolution.com/imgstore/repository/products-attachments/wordpress/velvet/Main-slider-1.zip',
		);
	}

	add_filter( 'hippo_import_rev_slider_slides', 'velvet_import_rev_slider_slides' );

	function velvet_envato_setup_customize() {
		?>
		<p>Create Form <strong>MailChimp for WP &rightarrow; Forms</strong> and Use this form code: </p>
		<textarea class="code" readonly="readonly" cols="100" rows="5"><div class="subscribe-widget newsletter">
				<p><input type="email" name="EMAIL" placeholder="YOUR EMAIL ADDRESS" required/></p>
				<p><input type="submit" class="btn btn-lg btn-link" value="SUBSCRIBE"/></p>
			</div></textarea>
		<?php
	}

	add_action( 'hippo_envato_setup_customize', 'velvet_envato_setup_customize' );

	function velvet_envato_setup_customize_features() {
		?>
		<ul>
			<li>Typography: Style, Font Family for your site.</li>
			<li>Color Schemes: Choose or customize website colors.</li>
			<li>Mobile Menu: Left/Right display position, showing effect.</li>
			<li>Blog Layout: Left/Right/None Blog sidebar display options, post navigation display style.</li>
			<li>Page Layout: Left/Right/None Page sidebar display options.</li>
		</ul>
		<?php
	}

	add_action( 'hippo_envato_setup_customize_features', 'velvet_envato_setup_customize_features' );


	//----------------------------------------------------------------------
	// Filter Applied on Theme Options data importing
	//----------------------------------------------------------------------

	if ( ! function_exists( 'velvet_import_process_theme_option_data' ) ) {

		function velvet_import_process_theme_option_data( $data ) {
			$find    = addcslashes( HIPPO_DEVELOPMENT_URL, '/' );
			$replace = addcslashes( HIPPO_CURRENT_IMPORT_URL, '/' );

			return str_ireplace( $find, $replace, $data );
		}

		add_filter( 'hippo_import_process_theme_option_data', 'velvet_import_process_theme_option_data' );
	}


	//----------------------------------------------------------------------
	// Filter Applied on Widget data importing
	//----------------------------------------------------------------------

	if ( ! function_exists( 'velvet_import_process_widget_data' ) ) {
		function velvet_import_process_widget_data( $data ) {
			$find    = addcslashes( HIPPO_DEVELOPMENT_URL, '/' );
			$replace = addcslashes( HIPPO_CURRENT_IMPORT_URL, '/' );

			return str_ireplace( $find, $replace, $data );
		}

		add_filter( 'hippo_import_process_widget_data', 'velvet_import_process_widget_data' );
	}


	//----------------------------------------------------------------------
	// Filter Applied on Sample XML data attachment importing
	//----------------------------------------------------------------------

	if ( ! function_exists( 'velvet_import_process_attachment_remote_url' ) ) {

		function velvet_import_process_attachment_remote_url( $data ) {
			$find    = HIPPO_DEVELOPMENT_URL;
			$replace = HIPPO_IMPORTABLE_ATTACHMENT_URL;

			return str_ireplace( $find, $replace, $data );
		}

		add_filter( 'hippo_import_process_attachment_remote_url', 'velvet_import_process_attachment_remote_url' );
	}

	//----------------------------------------------------------------------
	// Filter Applied on Sample XML data content importing
	//----------------------------------------------------------------------

	if ( ! function_exists( 'velvet_import_process_post_content' ) ) {

		function velvet_import_process_post_content( $data ) {
			$find    = HIPPO_DEVELOPMENT_URL;
			$replace = HIPPO_CURRENT_IMPORT_URL;

			return str_ireplace( $find, $replace, $data );
		}

		add_filter( 'hippo_import_process_post_content', 'velvet_import_process_post_content' );
	}
