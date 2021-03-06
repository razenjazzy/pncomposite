<?php

	defined( 'ABSPATH' ) or die( 'Keep Silent' );


	/** Display verbose errors */

	define( 'HIPPO_IMPORT_DEBUG', FALSE );

	// Load Importer API
	require_once ABSPATH . 'wp-admin/includes/import.php';

	if ( ! class_exists( 'WP_Importer' ) ) {
		$class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
		if ( file_exists( $class_wp_importer ) ) {
			require $class_wp_importer;
		}
	}

	// include WXR file parsers
	require dirname( __FILE__ ) . '/xml-parsers.php';

	/**
	 * WordPress Importer class for managing the import process of a WXR file
	 *
	 * @package    WordPress
	 * @subpackage Importer
	 */
	if ( class_exists( 'WP_Importer' ) ) {

		function hippo_importer_init() {

			$hippo_content = new Hippo_Content_Import();
			register_importer( 'hippodemodata',
			                   'Hippo Dummy data',
			                   __( 'Install dummy data for hippo theme' ),
			                   array( $hippo_content, 'dispatch' ) );
		}

		//add_action( 'admin_init', 'hippo_importer_init' );


		class Hippo_Content_Import extends WP_Importer {
			public $max_wxr_version = 1.2; // max. supported WXR version

			public $id; // WXR attachment ID

			// information to import from WXR file
			public $version;
			public $authors    = array();
			public $posts      = array();
			public $terms      = array();
			public $categories = array();
			public $tags       = array();
			public $base_url   = '';

			// mappings from old information to new
			public $processed_authors    = array();
			public $author_mapping       = array();
			public $processed_terms      = array();
			public $processed_posts      = array();
			public $post_orphans         = array();
			public $processed_menu_items = array();
			public $menu_item_orphans    = array();
			public $missing_menu_items   = array();

			public $fetch_attachments = TRUE;
			public $url_remap         = array();
			public $featured_images   = array();

			public $already_stored_attachments = array();

			function __construct( $file ) {
				@set_time_limit( 0 );
				$this->import( $file );
			}


			/**
			 * Registered callback function for the WordPress Importer
			 *
			 * Manages the three separate stages of the WXR import process
			 */
			function dispatch() {


				$this->header();

				$step = empty( $_GET[ 'step' ] ) ? 'ready' : $_GET[ 'step' ];

				do_action( 'hippo_before_import_demo_data' );

				switch ( $step ) {
					case 'ready':
						$this->hippo_import_options();
						break;

					case 'start':
						$this->hippo_start_process();
						break;
				}

				do_action( 'hippo_after_import_demo_data' );

				$this->footer();


			}

			// Display import page title
			function header() {
				echo '<div class="wrap">';
				echo '<h2>' . __( 'Import Demo Data for &#8220;' . HIPPO_THEME_NAME . '&#8221; theme', 'hippo-plugin' ) . '</h2>';


			}

			// Close div.wrap
			function footer() {
				echo '</div>';
			}

			function hippo_import_options() {
				?>

				<div class="narrow error below-h2">
					<p>Import demo data will import attachment media elements from demo server.</p>

					<p>Please be patient until complete this process.</p>
				</div>

				<form id="hippo-import-form-submit"
				      action="<?php echo admin_url( 'admin.php?import=hippodemodata&amp;step=start' ); ?>"
				      method="post">

					<?php do_action( 'hippo_import_form_start' ) ?>

					<?php if ( class_exists( 'RevSlider' ) ) { ?>

						<!--<p>
							<input type="checkbox" checked value="1" name="import_slider_data"
							       id="import_slider_data"/>
							<label
								for="import_slider_data"><?php /*_e( 'Import slider data', 'hippo-plugin' ); */ ?></label>
						</p>-->

					<?php } ?>

					<p>
						<input type="checkbox" checked value="1" name="import_theme_options"
						       id="import_theme_options"/>
						<label
							for="import_theme_options"><?php _e( 'Import theme options', 'hippo-plugin' ); ?></label>
					</p>

					<p>
						<input type="checkbox" checked value="1" name="import_widget_data"
						       id="import_widget_data"/>
						<label
							for="import_widget_data"><?php _e( 'Import widget data', 'hippo-plugin' ); ?></label>
					</p>

					<p>
						<input type="checkbox" checked value="1" name="import_demo_data" id="import_demo_data"/>
						<label
							for="import_demo_data"><?php _e( 'Import demo data', 'hippo-plugin' ); ?></label>
					</p>

					<p>
						<input type="checkbox" checked value="1" name="import_attachments"
						       id="import_attachments"/>
						<label
							for="import_attachments"><?php _e( 'Download and import file attachments. <small><i>This process may take few minutes</i></small>', 'hippo-plugin' ); ?></label>
					</p>

					<?php do_action( 'hippo_import_form_end' ) ?>

					<p class="submit">
						<input type="submit" id="hippo-import-form-submit-btn" class="button button-primary button-hero"
						       value="<?php esc_attr_e( 'Start Importing', 'hippo-plugin' ); ?>"/>
					</p>
				</form>
				<script>
					jQuery(function ($) {
						$('#hippo-import-form-submit').on('submit', function (e) {
							$('#hippo-import-form-submit-btn').prop('disabled', 'disabled').val('Please wait...');
						})
					});
				</script>

				<?php

			}

			function hippo_flush_buffer() {
				//wp_ob_end_flush_all();
				//@ob_flush();
				//flush();
			}

			function hippo_output_messages( $message, $type = 'updated' ) {
				//echo '<div class="narrow ' . $type . ' below-h2"><p>';
				//echo $message;
				//echo '</p></div>';
			}

			function hippo_start_process() {

				if ( isset( $_POST[ 'import_attachments' ] ) and ! empty( $_POST[ 'import_attachments' ] ) ) {
					$this->fetch_attachments = TRUE;
				}

				do_action( 'hippo_on_import_process_start_message' );

				if ( isset( $_POST[ 'import_theme_options' ] ) and ! empty( $_POST[ 'import_theme_options' ] ) ) {
					/**
					 * Redux Theme Option Import
					 */


					$redux_theme_option = get_template_directory() . '/demo-data/theme-options.json';

					if ( file_exists( $redux_theme_option ) ) {
						new Hippo_RedixThemeOption_Import( $redux_theme_option );
						$this->hippo_flush_buffer();
					}
				}

				if ( isset( $_POST[ 'import_widget_data' ] ) and ! empty( $_POST[ 'import_widget_data' ] ) ) {
					/**
					 * Widget data import option
					 * exported widget by http://wordpress.org/plugins/widget-settings-importexport/
					 *
					 */
					// admin.php?import=hippodemodata

					$widgets = get_template_directory() . '/demo-data/widget_data.json'; //
					if ( file_exists( $widgets ) ) {
						new Hippo_Widget_Import( $widgets );
						$this->hippo_flush_buffer();
					}

				}

				if ( isset( $_POST[ 'import_demo_data' ] ) and ! empty( $_POST[ 'import_demo_data' ] ) ) {

					/**
					 * Demo data importing
					 */
					$contents = get_template_directory() . '/demo-data/sample-data.xml';

					if ( ! file_exists( $contents ) ) {
						return;
					}

					set_time_limit( 0 );
					//echo '<div class="narrow updated below-h2"><p>';
					$this->import( $contents );
					//echo '</p></div>';
				}

				//////////
				if ( isset( $_POST[ 'import_slider_data' ] ) and ! empty( $_POST[ 'import_slider_data' ] ) ) {

					if ( class_exists( 'RevSlider' ) ) {

						$revolution_slider_data_path = get_template_directory() . '/demo-data/';
						$revolution_slider_datas     = apply_filters( 'hippo_import_rev_slider_data', array() );

						if ( ! empty( $revolution_slider_datas ) and is_array( $revolution_slider_datas ) ) {

							foreach ( $revolution_slider_datas as $data ) {
								$slider_path = $revolution_slider_data_path . $data;
								$slider      = new RevSlider();
								$slider->importSliderFromPost( TRUE, TRUE, $slider_path );
								unset( $slider );
							}
							echo '<div class="narrow updated below-h2"><p>';
							echo 'Revolution slider data imported successfully.';
							echo '</p></div>';
						}
					}
				}

				////////////

				if ( ! isset( $_POST[ 'import_theme_options' ] )
				     and ! isset( $_POST[ 'import_widget_data' ] )
				         and ! isset( $_POST[ 'import_demo_data' ] )
				) {
					?>
					<div class="narrow error below-h2">
						<p><?php _e( 'Nothing imported.' ) ?></p>
					</div>
					<?php
				}

				do_action( 'hippo_on_import_process_end_message' );

			}


			function import( $file ) {
				add_filter( 'import_post_meta_key', array( $this, 'is_valid_meta_key' ) );
				add_filter( 'http_request_timeout', array( $this, 'bump_request_timeout' ) );

				$this->import_start( $file );

				wp_suspend_cache_invalidation( TRUE );
				$this->process_categories();
				$this->process_tags();
				$this->process_terms();
				$this->process_posts();
				wp_suspend_cache_invalidation( FALSE );

				// update incorrect/missing information in the DB
				$this->backfill_parents();
				$this->backfill_attachment_urls();
				$this->remap_featured_images();

				$this->import_end();
			}

			/**
			 * Parses the WXR file and prepares us for the task of processing parsed data
			 *
			 * @param string $file Path to the WXR file for importing
			 */
			function import_start( $file ) {
				if ( ! is_file( $file ) ) {
					echo '<p><strong>' . __( 'Sorry, there has been an error.', 'hippo-plugin' ) . '</strong><br />';
					echo __( 'The file does not exist, please try again.', 'hippo-plugin' ) . '</p>';
					$this->footer();
					die();
				}

				$import_data = $this->parse( $file );

				if ( is_wp_error( $import_data ) ) {
					echo '<p><strong>' . __( 'Sorry, there has been an error.', 'hippo-plugin' ) . '</strong><br />';
					echo esc_html( $import_data->get_error_message() ) . '</p>';
					$this->footer();
					die();
				}

				$this->version = $import_data[ 'version' ];
				$this->get_authors_from_import( $import_data );
				$this->posts      = $import_data[ 'posts' ];
				$this->terms      = $import_data[ 'terms' ];
				$this->categories = $import_data[ 'categories' ];
				$this->tags       = $import_data[ 'tags' ];
				$this->base_url   = esc_url( $import_data[ 'base_url' ] );

				wp_defer_term_counting( TRUE );
				wp_defer_comment_counting( TRUE );

				do_action( 'import_start' );
			}

			/**
			 * Performs post-import cleanup of files and the cache
			 */
			function import_end() {
				wp_import_cleanup( $this->id );

				wp_cache_flush();
				foreach ( get_taxonomies() as $tax ) {
					delete_option( "{$tax}_children" );
					_get_term_hierarchy( $tax );
				}

				wp_defer_term_counting( FALSE );
				wp_defer_comment_counting( FALSE );


				$message = __( '<strong>Demo Data Imported successfully.</strong>', 'hippo-plugin' );
				$this->hippo_output_messages( $message );
				do_action( 'import_end' );
				do_action( 'hippo_import_end' );
			}


			/**
			 * Retrieve authors from parsed WXR data
			 *
			 * Uses the provided author information from WXR 1.1 files
			 * or extracts info from each post for WXR 1.0 files
			 *
			 * @param array $import_data Data returned by a WXR parser
			 */
			function get_authors_from_import( $import_data ) {
				if ( ! empty( $import_data[ 'authors' ] ) ) {
					$this->authors = $import_data[ 'authors' ];
					// no author information, grab it from the posts
				} else {
					foreach ( $import_data[ 'posts' ] as $post ) {
						$login = sanitize_user( $post[ 'post_author' ], TRUE );
						if ( empty( $login ) ) {
							printf( __( 'Failed to import author %s. Their posts will be attributed to the current user.', 'hippo-plugin' ), esc_html( $post[ 'post_author' ] ) );
							echo '<br />';
							continue;
						}

						if ( ! isset( $this->authors[ $login ] ) ) {
							$this->authors[ $login ] = array(
								'author_login'        => $login,
								'author_display_name' => $post[ 'post_author' ]
							);
						}
					}
				}
			}


			/**
			 * Create new categories based on import information
			 *
			 * Doesn't create a new category if its slug already exists
			 */
			function process_categories() {
				$this->categories = apply_filters( 'wp_import_categories', $this->categories );

				if ( empty( $this->categories ) ) {
					return;
				}

				foreach ( $this->categories as $cat ) {
					// if the category already exists leave it alone
					$term_id = term_exists( $cat[ 'category_nicename' ], 'category' );
					if ( $term_id ) {
						if ( is_array( $term_id ) ) {
							$term_id = $term_id[ 'term_id' ];
						}
						if ( isset( $cat[ 'term_id' ] ) ) {
							$this->processed_terms[ intval( $cat[ 'term_id' ] ) ] = (int) $term_id;
						}
						continue;
					}

					$category_parent      = empty( $cat[ 'category_parent' ] ) ? 0 : category_exists( $cat[ 'category_parent' ] );
					$category_description = isset( $cat[ 'category_description' ] ) ? $cat[ 'category_description' ] : '';
					$catarr               = array(
						'category_nicename'    => $cat[ 'category_nicename' ],
						'category_parent'      => $category_parent,
						'cat_name'             => $cat[ 'cat_name' ],
						'category_description' => $category_description
					);

					$id = wp_insert_category( $catarr );
					if ( ! is_wp_error( $id ) ) {
						if ( isset( $cat[ 'term_id' ] ) ) {
							$this->processed_terms[ intval( $cat[ 'term_id' ] ) ] = $id;
							$message                                              = sprintf( __( 'Category &#8220;%s&#8221; imported.', 'hippo-plugin' ), esc_html( $cat[ 'category_nicename' ] ) );
							$message_type                                         = 'updated';
						}
					} else {
						$message      = sprintf( __( 'Failed to import category &#8220;%s&#8221;', 'hippo-plugin' ), esc_html( $cat[ 'category_nicename' ] ) );
						$message_type = 'error';
						if ( defined( 'HIPPO_IMPORT_DEBUG' ) && HIPPO_IMPORT_DEBUG ) {
							echo ': ' . $id->get_error_message();
						}
						echo '<br />';

						$this->hippo_output_messages( $message, $message_type );
						$this->hippo_flush_buffer();

						continue;
					}

					$this->hippo_output_messages( $message, $message_type );
					$this->hippo_flush_buffer();
				}

				unset( $this->categories );
			}

			/**
			 * Create new post tags based on import information
			 *
			 * Doesn't create a tag if its slug already exists
			 */
			function process_tags() {
				$this->tags = apply_filters( 'wp_import_tags', $this->tags );

				if ( empty( $this->tags ) ) {
					return;
				}

				foreach ( $this->tags as $tag ) {
					// if the tag already exists leave it alone
					$term_id = term_exists( $tag[ 'tag_slug' ], 'post_tag' );
					if ( $term_id ) {
						if ( is_array( $term_id ) ) {
							$term_id = $term_id[ 'term_id' ];
						}
						if ( isset( $tag[ 'term_id' ] ) ) {
							$this->processed_terms[ intval( $tag[ 'term_id' ] ) ] = (int) $term_id;
						}
						continue;
					}

					$tag_desc = isset( $tag[ 'tag_description' ] ) ? $tag[ 'tag_description' ] : '';
					$tagarr   = array( 'slug' => $tag[ 'tag_slug' ], 'description' => $tag_desc );

					$id = wp_insert_term( $tag[ 'tag_name' ], 'post_tag', $tagarr );
					if ( ! is_wp_error( $id ) ) {
						if ( isset( $tag[ 'term_id' ] ) ) {
							$this->processed_terms[ intval( $tag[ 'term_id' ] ) ] = $id[ 'term_id' ];
							$message                                              = sprintf( __( 'Post tag &#8220;%s&#8221; imported', 'hippo-plugin' ), esc_html( $tag[ 'tag_name' ] ) );
							$message_type                                         = 'updated';
						}
					} else {
						$message      = sprintf( __( 'Failed to import post tag &#8220;%s&#8221;', 'hippo-plugin' ), esc_html( $tag[ 'tag_name' ] ) );
						$message_type = 'error';

						if ( defined( 'HIPPO_IMPORT_DEBUG' ) && HIPPO_IMPORT_DEBUG ) {
							echo ': ' . $id->get_error_message();
						}
						echo '<br />';


						$this->hippo_output_messages( $message, $message_type );
						$this->hippo_flush_buffer();

						continue;
					}

					$this->hippo_output_messages( $message, $message_type );
					$this->hippo_flush_buffer();
				}

				unset( $this->tags );
			}

			/**
			 * Create new terms based on import information
			 *
			 * Doesn't create a term its slug already exists
			 */
			function process_terms() {
				$this->terms = apply_filters( 'wp_import_terms', $this->terms );

				if ( empty( $this->terms ) ) {
					return;
				}

				foreach ( $this->terms as $term ) {
					// if the term already exists in the correct taxonomy leave it alone
					$term_id = term_exists( $term[ 'slug' ], $term[ 'term_taxonomy' ] );
					if ( $term_id ) {
						if ( is_array( $term_id ) ) {
							$term_id = $term_id[ 'term_id' ];
						}
						if ( isset( $term[ 'term_id' ] ) ) {
							$this->processed_terms[ intval( $term[ 'term_id' ] ) ] = (int) $term_id;
						}
						continue;
					}

					if ( empty( $term[ 'term_parent' ] ) ) {
						$parent = 0;
					} else {
						$parent = term_exists( $term[ 'term_parent' ], $term[ 'term_taxonomy' ] );
						if ( is_array( $parent ) ) {
							$parent = $parent[ 'term_id' ];
						}
					}
					$description = isset( $term[ 'term_description' ] ) ? $term[ 'term_description' ] : '';
					$termarr     = array(
						'slug'        => $term[ 'slug' ],
						'description' => $description,
						'parent'      => intval( $parent )
					);

					$id = wp_insert_term( $term[ 'term_name' ], $term[ 'term_taxonomy' ], $termarr );
					if ( ! is_wp_error( $id ) ) {
						if ( isset( $term[ 'term_id' ] ) ) {
							$this->processed_terms[ intval( $term[ 'term_id' ] ) ] = $id[ 'term_id' ];
							//$message = sprintf(__('&#8220;%2$s&#8221; imported on Taxonomy &#8220;%1$s&#8221;.', 'hippo-plugin'), esc_html($term[ 'term_taxonomy' ]), esc_html($term[ 'term_name' ]));
							//$message = sprintf(__('&#8220;%2$s&#8221; imported successfully.', 'hippo-plugin'), esc_html($term[ 'term_taxonomy' ]), esc_html($term[ 'term_name' ]));
							//$message_type = 'updated';
						}
					} else {
						$message      = sprintf( __( 'Failed to import &#8220;%2$s&#8221; in &#8220;%1$s&#8221;', 'hippo-plugin' ), esc_html( $term[ 'term_taxonomy' ] ), esc_html( $term[ 'term_name' ] ) );
						$message_type = 'error';
						if ( defined( 'HIPPO_IMPORT_DEBUG' ) && HIPPO_IMPORT_DEBUG ) {
							echo ': ' . $id->get_error_message();
						}
						echo '<br />';

						$this->hippo_output_messages( $message, $message_type );
						$this->hippo_flush_buffer();

						continue;
					}

					//$this->hippo_output_messages($message, $message_type);
					//$this->hippo_flush_buffer();
				}

				unset( $this->terms );
			}

			/**
			 * Create new posts based on import information
			 *
			 * Posts marked as having a parent which doesn't exist will become top level items.
			 * Doesn't create a new post if: the post type doesn't exist, the given post ID
			 * is already noted as imported or a post with the same title and date already exists.
			 * Note that new/updated terms, comments and meta are imported for the last of the above.
			 */


			function process_posts() {

				global $wpdb;
				$this->posts = apply_filters( 'wp_import_posts', $this->posts );

				foreach ( $this->posts as $post ) {
					$post = apply_filters( 'wp_import_post_data_raw', $post );

					if ( ! post_type_exists( $post[ 'post_type' ] ) ) {
						printf( __( 'Failed to import &#8220;%s&#8221;: Invalid post type %s', 'hippo-plugin' ),
						        esc_html( $post[ 'post_title' ] ), esc_html( $post[ 'post_type' ] ) );
						echo '<br />';
						do_action( 'wp_import_post_exists', $post );
						continue;
					}

					if ( isset( $this->processed_posts[ $post[ 'post_id' ] ] ) && ! empty( $post[ 'post_id' ] ) ) {
						continue;
					}

					if ( $post[ 'status' ] == 'auto-draft' ) {
						continue;
					}

					if ( $post[ 'status' ] == 'trash' ) {
						continue;
					}

					if ( 'nav_menu_item' == $post[ 'post_type' ] ) {
						$this->process_menu_item( $post );
						continue;
					}


					$post_type_object = get_post_type_object( $post[ 'post_type' ] );

					$post_exists = post_exists( $post[ 'post_title' ], '', $post[ 'post_date' ] );
					if ( $post_exists && get_post_type( $post_exists ) == $post[ 'post_type' ] ) {
						$message         = sprintf( __( '%s &#8220;%s&#8221; already exists.', 'hippo-plugin' ), $post_type_object->labels->singular_name, esc_html( $post[ 'post_title' ] ) );
						$message_type    = 'error';
						$comment_post_ID = $post_id = $post_exists;
						$this->hippo_output_messages( $message, $message_type );
						$this->hippo_flush_buffer();
					} else {
						$post_parent = (int) $post[ 'post_parent' ];
						if ( $post_parent ) {
							// if we already know the parent, map it to the new local ID
							if ( isset( $this->processed_posts[ $post_parent ] ) ) {
								$post_parent = $this->processed_posts[ $post_parent ];
								// otherwise record the parent for later
							} else {
								$this->post_orphans[ intval( $post[ 'post_id' ] ) ] = $post_parent;
								$post_parent                                        = 0;
							}
						}

						// map the post author
						$author = sanitize_user( $post[ 'post_author' ], TRUE );
						if ( isset( $this->author_mapping[ $author ] ) ) {
							$author = $this->author_mapping[ $author ];
						} else {
							$author = (int) get_current_user_id();
						}

						$postdata = array(
							'import_id'      => $post[ 'post_id' ],
							'post_author'    => $author,
							'post_date'      => $post[ 'post_date' ],
							'post_date_gmt'  => $post[ 'post_date_gmt' ],
							'post_content'   => trim( apply_filters( 'hippo_import_process_post_content', $post[ 'post_content' ], $post ) ),
							'post_excerpt'   => $post[ 'post_excerpt' ],
							'post_title'     => $post[ 'post_title' ],
							'post_status'    => $post[ 'status' ],
							'post_name'      => $post[ 'post_name' ],
							'comment_status' => $post[ 'comment_status' ],
							'ping_status'    => $post[ 'ping_status' ],
							'guid'           => $post[ 'guid' ],
							'post_parent'    => $post_parent,
							'menu_order'     => $post[ 'menu_order' ],
							'post_type'      => $post[ 'post_type' ],
							'post_password'  => $post[ 'post_password' ]
						);

						$original_post_ID = $post[ 'post_id' ];
						$postdata         = apply_filters( 'wp_import_post_data_processed', $postdata, $post );

						if ( 'attachment' == $postdata[ 'post_type' ] ) {
							$remote_url = ! empty( $post[ 'attachment_url' ] ) ? $post[ 'attachment_url' ] : $post[ 'guid' ];

							$remote_url = trim( apply_filters( 'hippo_import_process_attachment_remote_url', $remote_url ) );

							if ( in_array( $remote_url, $this->already_stored_attachments ) ) {

								continue;

							}


							$message      = 'Importing Attachment : &#8220;' . $remote_url . '&#8221;';
							$message_type = 'updated';


							// try to use _wp_attached file for upload folder placement to ensure the same location as the export site
							// e.g. location is 2003/05/image.jpg but the attachment post_date is 2010/09, see media_handle_upload()
							$postdata[ 'upload_date' ] = $post[ 'post_date' ];
							if ( isset( $post[ 'postmeta' ] ) ) {
								foreach ( $post[ 'postmeta' ] as $meta ) {
									if ( $meta[ 'key' ] == '_wp_attached_file' ) {
										if ( preg_match( '%^[0-9]{4}/[0-9]{2}%', $meta[ 'value' ], $matches ) ) {
											$postdata[ 'upload_date' ] = $matches[ 0 ];
										}
										break;
									}
								}
							}

							$comment_post_ID = $post_id = $this->process_attachment( $postdata, $remote_url );
							$this->hippo_output_messages( $message, $message_type );
							$this->hippo_flush_buffer();
						} else {
							$comment_post_ID = $post_id = wp_insert_post( $postdata, TRUE );
							do_action( 'wp_import_insert_post', $post_id, $original_post_ID, $postdata, $post );
							$message      = sprintf( __( 'Post &#8220;%s&#8221; imported.', 'hippo-plugin' ), esc_html( $postdata[ 'post_title' ] ) );
							$message_type = 'updated';
						}

						if ( is_wp_error( $post_id ) ) {


							// $this->_hippo_failed_attachments[ ] = array('data' => $postdata, 'url' => $remote_url);

							$message      = sprintf( __( 'Failed to import %s &#8220;%s&#8221; from %s', 'hippo-plugin' ),
							                         $post_type_object->labels->singular_name, esc_html( $post[ 'post_title' ] ), "<a target='_blank' href='{$remote_url}'>" . $remote_url . "</a>" );
							$message_type = 'error';
							/*echo '<br />';
							echo " From: <a target='_blank' href='{$remote_url}'>" . $remote_url . "</a>";
							echo '<br />';*/
							if ( defined( 'HIPPO_IMPORT_DEBUG' ) && HIPPO_IMPORT_DEBUG ) {
								echo ': ' . $post_id->get_error_message();
							}
							//echo '<br />';

							$this->hippo_output_messages( $message, $message_type );
							$this->hippo_flush_buffer();

							continue;
						}

						if ( $post[ 'is_sticky' ] == 1 ) {
							stick_post( $post_id );
						}
					}

					// map pre-import ID to local ID
					$this->processed_posts[ intval( $post[ 'post_id' ] ) ] = (int) $post_id;

					if ( ! isset( $post[ 'terms' ] ) ) {
						$post[ 'terms' ] = array();
					}

					$post[ 'terms' ] = apply_filters( 'wp_import_post_terms', $post[ 'terms' ], $post_id, $post );

					// add categories, tags and other terms
					if ( ! empty( $post[ 'terms' ] ) ) {
						$terms_to_set = array();

						foreach ( $post[ 'terms' ] as $term ) {
							// back compat with WXR 1.0 map 'tag' to 'post_tag'
							$taxonomy    = ( 'tag' == $term[ 'domain' ] ) ? 'post_tag' : $term[ 'domain' ];
							$term_exists = term_exists( $term[ 'slug' ], $taxonomy );
							$term_id     = is_array( $term_exists ) ? $term_exists[ 'term_id' ] : $term_exists;
							if ( ! $term_id ) {
								$t = wp_insert_term( $term[ 'name' ], $taxonomy, array( 'slug' => $term[ 'slug' ] ) );
								if ( ! is_wp_error( $t ) ) {
									$term_id = $t[ 'term_id' ];
									do_action( 'wp_import_insert_term', $t, $term, $post_id, $post );
								} else {
									printf( __( 'Failed to import %s %s', 'hippo-plugin' ), esc_html( $taxonomy ), esc_html( $term[ 'name' ] ) );
									if ( defined( 'HIPPO_IMPORT_DEBUG' ) && HIPPO_IMPORT_DEBUG ) {
										echo ': ' . $t->get_error_message();
									}
									echo '<br />';
									do_action( 'wp_import_insert_term_failed', $t, $term, $post_id, $post );
									continue;
								}
							}
							$terms_to_set[ $taxonomy ][] = intval( $term_id );
						}

						foreach ( $terms_to_set as $tax => $ids ) {
							$tt_ids = wp_set_post_terms( $post_id, $ids, $tax );
							do_action( 'wp_import_set_post_terms', $tt_ids, $ids, $tax, $post_id, $post );
						}
						unset( $post[ 'terms' ], $terms_to_set );
					}

					if ( ! isset( $post[ 'comments' ] ) ) {
						$post[ 'comments' ] = array();
					}

					$post[ 'comments' ] = apply_filters( 'wp_import_post_comments', $post[ 'comments' ], $post_id, $post );

					// add/update comments
					if ( ! empty( $post[ 'comments' ] ) ) {
						$num_comments      = 0;
						$inserted_comments = array();
						foreach ( $post[ 'comments' ] as $comment ) {
							$comment_id                                           = $comment[ 'comment_id' ];
							$newcomments[ $comment_id ][ 'comment_post_ID' ]      = $comment_post_ID;
							$newcomments[ $comment_id ][ 'comment_author' ]       = $comment[ 'comment_author' ];
							$newcomments[ $comment_id ][ 'comment_author_email' ] = $comment[ 'comment_author_email' ];
							$newcomments[ $comment_id ][ 'comment_author_IP' ]    = $comment[ 'comment_author_IP' ];
							$newcomments[ $comment_id ][ 'comment_author_url' ]   = $comment[ 'comment_author_url' ];
							$newcomments[ $comment_id ][ 'comment_date' ]         = $comment[ 'comment_date' ];
							$newcomments[ $comment_id ][ 'comment_date_gmt' ]     = $comment[ 'comment_date_gmt' ];
							$newcomments[ $comment_id ][ 'comment_content' ]      = $comment[ 'comment_content' ];
							$newcomments[ $comment_id ][ 'comment_approved' ]     = $comment[ 'comment_approved' ];
							$newcomments[ $comment_id ][ 'comment_type' ]         = $comment[ 'comment_type' ];
							$newcomments[ $comment_id ][ 'comment_parent' ]       = $comment[ 'comment_parent' ];
							$newcomments[ $comment_id ][ 'commentmeta' ]          = isset( $comment[ 'commentmeta' ] ) ? $comment[ 'commentmeta' ] : array();
							if ( isset( $this->processed_authors[ $comment[ 'comment_user_id' ] ] ) ) {
								$newcomments[ $comment_id ][ 'user_id' ] = $this->processed_authors[ $comment[ 'comment_user_id' ] ];
							}
						}
						ksort( $newcomments );

						foreach ( $newcomments as $key => $comment ) {
							// if this is a new post we can skip the comment_exists() check
							if ( ! $post_exists || ! comment_exists( $comment[ 'comment_author' ], $comment[ 'comment_date' ] ) ) {
								if ( isset( $inserted_comments[ $comment[ 'comment_parent' ] ] ) ) {
									$comment[ 'comment_parent' ] = $inserted_comments[ $comment[ 'comment_parent' ] ];
								}
								$comment                   = wp_filter_comment( $comment );
								$inserted_comments[ $key ] = wp_insert_comment( $comment );
								do_action( 'wp_import_insert_comment', $inserted_comments[ $key ], $comment, $comment_post_ID, $post );

								foreach ( $comment[ 'commentmeta' ] as $meta ) {
									$value = maybe_unserialize( $meta[ 'value' ] );
									add_comment_meta( $inserted_comments[ $key ], $meta[ 'key' ], $value );
								}

								$num_comments ++;
							}
						}
						unset( $newcomments, $inserted_comments, $post[ 'comments' ] );
					}

					if ( ! isset( $post[ 'postmeta' ] ) ) {
						$post[ 'postmeta' ] = array();
					}

					$post[ 'postmeta' ] = apply_filters( 'wp_import_post_meta', $post[ 'postmeta' ], $post_id, $post );

					// add/update post meta
					if ( ! empty( $post[ 'postmeta' ] ) ) {
						foreach ( $post[ 'postmeta' ] as $meta ) {
							$key   = apply_filters( 'import_post_meta_key', $meta[ 'key' ], $post_id, $post );
							$value = FALSE;

							if ( '_edit_last' == $key ) {
								if ( isset( $this->processed_authors[ intval( $meta[ 'value' ] ) ] ) ) {
									$value = $this->processed_authors[ intval( $meta[ 'value' ] ) ];
								} else {
									$key = FALSE;
								}
							}

							if ( $key ) {
								// export gets meta straight from the DB so could have a serialized string
								if ( ! $value ) {
									$value = maybe_unserialize( $meta[ 'value' ] );
								}

								add_post_meta( $post_id, $key, apply_filters( 'hippo_import_process_post_content', $value, $post ) );
								do_action( 'import_post_meta', $post_id, $key, $value );

								// if the post has a featured image, take note of this in case of remap
								if ( '_thumbnail_id' == $key ) {
									$this->featured_images[ $post_id ] = (int) $value;
								}
							}
						}
					}

					//$this->hippo_output_messages($message, $message_type);
					//$this->hippo_flush_buffer();
				}

				unset( $this->posts );
			}

			/**
			 * Attempt to create a new menu item from import data
			 *
			 * Fails for draft, orphaned menu items and those without an associated nav_menu
			 * or an invalid nav_menu term. If the post type or term object which the menu item
			 * represents doesn't exist then the menu item will not be imported (waits until the
			 * end of the import to retry again before discarding).
			 *
			 * @param array $item Menu item details from WXR file
			 */
			function process_menu_item( $item ) {
				// skip draft, orphaned menu items
				if ( 'draft' == $item[ 'status' ] ) {
					return;
				}

				$menu_slug = FALSE;
				if ( isset( $item[ 'terms' ] ) ) {
					// loop through terms, assume first nav_menu term is correct menu
					foreach ( $item[ 'terms' ] as $term ) {
						if ( 'nav_menu' == $term[ 'domain' ] ) {
							$menu_slug = $term[ 'slug' ];
							break;
						}
					}
				}

				// no nav_menu term associated with this menu item
				if ( ! $menu_slug ) {
					$message = 'Menu item skipped due to missing menu slug';
					$this->hippo_output_messages( $message, 'error' );

					return;
				}

				$menu_id = term_exists( $menu_slug, 'nav_menu' );
				if ( ! $menu_id ) {
					$message = sprintf( __( 'Menu item skipped due to invalid menu slug: &#8220;%s&#8221;', 'hippo-plugin' ), esc_html( $menu_slug ) );
					$this->hippo_output_messages( $message, 'error' );

					return;
				} else {
					$menu_id = is_array( $menu_id ) ? $menu_id[ 'term_id' ] : $menu_id;
				}

				foreach ( $item[ 'postmeta' ] as $meta ) {
					$$meta[ 'key' ] = $meta[ 'value' ];
				}

				if ( 'taxonomy' == $_menu_item_type && isset( $this->processed_terms[ intval( $_menu_item_object_id ) ] ) ) {
					$_menu_item_object_id = $this->processed_terms[ intval( $_menu_item_object_id ) ];
				} else {
					if ( 'post_type' == $_menu_item_type && isset( $this->processed_posts[ intval( $_menu_item_object_id ) ] ) ) {
						$_menu_item_object_id = $this->processed_posts[ intval( $_menu_item_object_id ) ];
					} else {
						if ( 'custom' != $_menu_item_type ) {
							// associated object is missing or not imported yet, we'll retry later
							$this->missing_menu_items[] = $item;

							return;
						}
					}
				}

				if ( isset( $this->processed_menu_items[ intval( $_menu_item_menu_item_parent ) ] ) ) {
					$_menu_item_menu_item_parent = $this->processed_menu_items[ intval( $_menu_item_menu_item_parent ) ];
				} else {
					if ( $_menu_item_menu_item_parent ) {
						$this->menu_item_orphans[ intval( $item[ 'post_id' ] ) ] = (int) $_menu_item_menu_item_parent;
						$_menu_item_menu_item_parent                             = 0;
					}
				}

				// wp_update_nav_menu_item expects CSS classes as a space separated string
				$_menu_item_classes = maybe_unserialize( $_menu_item_classes );
				if ( is_array( $_menu_item_classes ) ) {
					$_menu_item_classes = implode( ' ', $_menu_item_classes );
				}

				// $hippo_menu_meta_widgets, $hippo_menu_meta_menucolumnclass

				$args = array(
					'menu-item-object-id'   => $_menu_item_object_id,
					'menu-item-object'      => $_menu_item_object,
					'menu-item-parent-id'   => $_menu_item_menu_item_parent,
					'menu-item-position'    => intval( $item[ 'menu_order' ] ),
					'menu-item-type'        => $_menu_item_type,
					'menu-item-title'       => $item[ 'post_title' ],
					'menu-item-url'         => trim( apply_filters( 'hippo_import_process_post_content', $_menu_item_url ) ),
					'menu-item-description' => $item[ 'post_content' ],
					'menu-item-attr-title'  => $item[ 'post_excerpt' ],
					'menu-item-target'      => $_menu_item_target,
					'menu-item-classes'     => $_menu_item_classes,
					'menu-item-xfn'         => $_menu_item_xfn,
					'menu-item-status'      => $item[ 'status' ]
				);


				$menu_metas = apply_filters( 'hippo_nav_menu_item_meta', array() );

				foreach ( $menu_metas as $meta_index => $meta_values ) {
					$var = 'hippo_menu_meta_' . $meta_index;
					if ( isset( $$var ) ) {
						$args[ "hippo_menu_meta_{$meta_index}" ] = $$var;
					}
				}

				/*if( isset($hippo_menu_meta_widgets) ){
					$args['hippo_menu_meta_widgets'] = $hippo_menu_meta_widgets;
				}
				if( isset($hippo_menu_meta_menucolumnclass) ){
					$args['hippo_menu_meta_menucolumnclass'] = $hippo_menu_meta_menucolumnclass;
				}*/

				add_action( 'wp_update_nav_menu_item', array( $this, 'hippo_save_menu_custom_attrs' ), 10, 3 );

				$id = wp_update_nav_menu_item( $menu_id, 0, $args );
				if ( $id && ! is_wp_error( $id ) ) {
					$this->processed_menu_items[ intval( $item[ 'post_id' ] ) ] = (int) $id;

					if ( ! empty( $item[ 'post_title' ] ) ) {
						$this->hippo_output_messages( 'Menu &#8220;' . $item[ 'post_title' ] . '&#8221; imported successfully.' );
						$this->hippo_flush_buffer();
					}
				}


			}

			/**
			 * To save megamenu items
			 *
			 * @param $menu_id
			 * @param $menu_item_db_id
			 * @param $args
			 */

			function hippo_save_menu_custom_attrs( $menu_id, $menu_item_db_id, $args ) {

				$menu_metas = apply_filters( 'hippo_nav_menu_item_meta', array() );
				foreach ( $menu_metas as $meta_index => $meta_values ) {
					if ( isset( $args[ "hippo_menu_meta_{$meta_index}" ] ) ) {
						update_post_meta( $menu_item_db_id, "hippo_menu_meta_{$meta_index}", $args[ "hippo_menu_meta_{$meta_index}" ] );
					}
				}
			}

			/**
			 * If fetching attachments is enabled then attempt to create a new attachment
			 *
			 * @param array  $post Attachment post details from WXR
			 * @param string $url  URL to fetch attachment from
			 *
			 * @return int|WP_Error Post ID on success, WP_Error otherwise
			 */
			function process_attachment( $post, $url ) {
				if ( ! $this->fetch_attachments ) {
					return new WP_Error( 'attachment_processing_error',
					                     __( 'Fetching attachments is not enabled', 'hippo-plugin' ) );
				}


				// if the URL is absolute, but does not contain address, then upload it assuming base_site_url
				if ( preg_match( '|^/[\w\W]+$|', $url ) ) {
					$url = rtrim( $this->base_url, '/' ) . $url;
				}

				$upload = $this->fetch_remote_file( $url, $post );
				if ( is_wp_error( $upload ) ) {
					return $upload;
				}

				if ( $info = wp_check_filetype( $upload[ 'file' ] ) ) {
					$post[ 'post_mime_type' ] = $info[ 'type' ];
				} else {
					return new WP_Error( 'attachment_processing_error', __( 'Invalid file type', 'hippo-plugin' ) );
				}

				$post[ 'guid' ] = $upload[ 'url' ];

				// as per wp-admin/includes/upload.php
				$post_id = wp_insert_attachment( $post, $upload[ 'file' ] );
				wp_update_attachment_metadata( $post_id, wp_generate_attachment_metadata( $post_id, $upload[ 'file' ] ) );

				// remap resized image URLs, works by stripping the extension and remapping the URL stub.
				if ( preg_match( '!^image/!', $info[ 'type' ] ) ) {
					$parts = pathinfo( $url );
					$name  = basename( $parts[ 'basename' ], ".{$parts['extension']}" ); // PATHINFO_FILENAME in PHP 5.2

					$parts_new = pathinfo( $upload[ 'url' ] );
					$name_new  = basename( $parts_new[ 'basename' ], ".{$parts_new['extension']}" );

					$this->url_remap[ $parts[ 'dirname' ] . '/' . $name ] = $parts_new[ 'dirname' ] . '/' . $name_new;
				}

				return $post_id;
			}


			/**
			 * Attempt to download a remote file attachment
			 *
			 * @param string $url  URL of item to fetch
			 * @param array  $post Attachment details
			 *
			 * @return array|WP_Error Local file location details on success, WP_Error otherwise
			 */
			function fetch_remote_file( $url, $post ) {
				// extract the file name and extension from the url

				$file_name = basename( $url );

				// get placeholder file in the upload dir with a unique, sanitized filename
				$upload = wp_upload_bits( $file_name, 0, '', $post[ 'upload_date' ] );


				if ( $upload[ 'error' ] ) {
					return new WP_Error( 'upload_dir_error', $upload[ 'error' ] );
				}

				// fetch the remote url and write it to the placeholder file
				//$headers = wp_get_http($url, $upload[ 'file' ]);


				$output = $this->hippo_get_server_attachment( $url, $upload[ 'file' ] );


				if ( $output === FALSE ) {
					@unlink( $upload[ 'file' ] );

					return new WP_Error( 'import_file_error', __( 'Cannot fetch file from server and put on your server.', 'hippo-plugin' ) );
				}


				// request failed
				/*if (!$headers) {
					@unlink($upload[ 'file' ]);
					return new WP_Error('import_file_error', __('Remote server did not respond', 'hippo-plugin'));
				}

				// make sure the fetch was successful
				if ($headers[ 'response' ] != '200') {
					@unlink($upload[ 'file' ]);
					return new WP_Error('import_file_error', sprintf(__('Remote server returned error response %1$d %2$s', 'hippo-plugin'), esc_html($headers[ 'response' ]), get_status_header_desc($headers[ 'response' ])));
				}

				$filesize = filesize($upload[ 'file' ]);

				if (isset($headers[ 'content-length' ]) && $filesize != $headers[ 'content-length' ]) {
					@unlink($upload[ 'file' ]);
					return new WP_Error('import_file_error', __('Remote file is incorrect size', 'hippo-plugin'));
				}

				if (0 == $filesize) {
					@unlink($upload[ 'file' ]);
					return new WP_Error('import_file_error', __('Zero size file downloaded', 'hippo-plugin'));
				}

				$max_size = (int) $this->max_attachment_size();
				if (!empty($max_size) && $filesize > $max_size) {
					@unlink($upload[ 'file' ]);
					return new WP_Error('import_file_error', sprintf(__('Remote file is too large, limit is %s', 'hippo-plugin'), size_format($max_size)));
				}*/

				// keep track of the old and new urls so we can substitute them later
				$this->url_remap[ $url ]            = $upload[ 'url' ];
				$this->url_remap[ $post[ 'guid' ] ] = $upload[ 'url' ]; // r13735, really needed?
				// keep track of the destination if the remote url is redirected somewhere else
				//if (isset($headers[ 'x-final-location' ]) && $headers[ 'x-final-location' ] != $url)
				//    $this->url_remap[ $headers[ 'x-final-location' ] ] = $upload[ 'url' ];

				return $upload;
			}


			function hippo_get_server_attachment( $remote_url, $local_url ) {
				$remore_data = @file_get_contents( $remote_url );

				if ( $remore_data ) {

					$this->already_stored_attachments[] = $remote_url;

					return file_put_contents( $local_url, $remore_data );
				}

				return FALSE;
			}

			/**
			 * Attempt to associate posts and menu items with previously missing parents
			 *
			 * An imported post's parent may not have been imported when it was first created
			 * so try again. Similarly for child menu items and menu items which were missing
			 * the object (e.g. post) they represent in the menu
			 */
			function backfill_parents() {
				global $wpdb;

				// find parents for post orphans
				foreach ( $this->post_orphans as $child_id => $parent_id ) {
					$local_child_id = $local_parent_id = FALSE;
					if ( isset( $this->processed_posts[ $child_id ] ) ) {
						$local_child_id = $this->processed_posts[ $child_id ];
					}
					if ( isset( $this->processed_posts[ $parent_id ] ) ) {
						$local_parent_id = $this->processed_posts[ $parent_id ];
					}

					if ( $local_child_id && $local_parent_id ) {
						$wpdb->update( $wpdb->posts, array( 'post_parent' => $local_parent_id ), array( 'ID' => $local_child_id ), '%d', '%d' );
					}
				}

				// all other posts/terms are imported, retry menu items with missing associated object
				$missing_menu_items = $this->missing_menu_items;
				foreach ( $missing_menu_items as $item ) {
					$this->process_menu_item( $item );
				}

				// find parents for menu item orphans
				foreach ( $this->menu_item_orphans as $child_id => $parent_id ) {
					$local_child_id = $local_parent_id = 0;
					if ( isset( $this->processed_menu_items[ $child_id ] ) ) {
						$local_child_id = $this->processed_menu_items[ $child_id ];
					}
					if ( isset( $this->processed_menu_items[ $parent_id ] ) ) {
						$local_parent_id = $this->processed_menu_items[ $parent_id ];
					}

					if ( $local_child_id && $local_parent_id ) {
						update_post_meta( $local_child_id, '_menu_item_menu_item_parent', (int) $local_parent_id );
					}
				}
			}

			/**
			 * Use stored mapping information to update old attachment URLs
			 */
			function backfill_attachment_urls() {
				global $wpdb;
				// make sure we do the longest urls first, in case one is a substring of another
				uksort( $this->url_remap, array( &$this, 'cmpr_strlen' ) );

				foreach ( $this->url_remap as $from_url => $to_url ) {
					// remap urls in post_content
					$wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->posts} SET post_content = REPLACE(post_content, %s, %s)", $from_url, $to_url ) );
					// remap enclosure urls
					$result = $wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->postmeta} SET meta_value = REPLACE(meta_value, %s, %s) WHERE meta_key='enclosure'", $from_url, $to_url ) );
				}
			}

			/**
			 * Update _thumbnail_id meta to new, imported attachment IDs
			 */
			function remap_featured_images() {
				// cycle through posts that have a featured image
				foreach ( $this->featured_images as $post_id => $value ) {
					if ( isset( $this->processed_posts[ $value ] ) ) {
						$new_id = $this->processed_posts[ $value ];
						// only update if there's a difference
						if ( $new_id != $value ) {
							update_post_meta( $post_id, '_thumbnail_id', $new_id );
						}
					}
				}
			}

			/**
			 * Parse a WXR file
			 *
			 * @param string $file Path to WXR file for parsing
			 *
			 * @return array Information gathered from the WXR file
			 */
			function parse( $file ) {
				$parser        = new Hippo_WXR_Parser();
				$replaced_data = $parser->parse( $file );

				return $replaced_data;
			}


			/**
			 * Decide if the given meta key maps to information we will want to import
			 *
			 * @param string $key The meta key to check
			 *
			 * @return string|bool The key if we do want to import, false if not
			 */
			function is_valid_meta_key( $key ) {
				// skip attachment metadata since we'll regenerate it from scratch
				// skip _edit_lock as not relevant for import
				if ( in_array( $key, array( '_wp_attached_file', '_wp_attachment_metadata', '_edit_lock' ) ) ) {
					return FALSE;
				}

				return $key;
			}


			/**
			 * Added to http_request_timeout filter to force timeout at 60 seconds during import
			 * @return int 60
			 */
			function bump_request_timeout( $val = 120 ) {
				return $val;
			}

			// return the difference in length between two strings
			function cmpr_strlen( $a, $b ) {
				return strlen( $b ) - strlen( $a );
			}
		}

	}


