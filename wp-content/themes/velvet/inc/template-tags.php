<?php

	defined( 'ABSPATH' ) or die( 'Keep Silent' );

	//----------------------------------------------------------------------
	//  Single Post navigation link. <- Previous post  |   Next Post ->
	//----------------------------------------------------------------------

	if ( ! function_exists( 'velvet_post_navigation' ) ) :

		function velvet_post_navigation() {
			get_template_part( 'template-parts/post', 'navigation' );
		}
	endif;

	//----------------------------------------------------------------------
	//  Single Post related post
	//----------------------------------------------------------------------

	if ( ! function_exists( 'velvet_related_posts' ) ) :

		function velvet_related_posts() {
			get_template_part( 'template-parts/related-posts' );
		}
	endif;

	//----------------------------------------------------------------------
	// Display <!--nextpage--> pagination
	//----------------------------------------------------------------------

	if ( ! function_exists( 'velvet_link_pages' ) ) :

		function velvet_link_pages( $args = array() ) {
			$defaults = array(
				'before'           => '<div class="pagination-wrap clearfix">',
				'after'            => '</div>',
				'link_before'      => '',
				'link_after'       => '',
				'next_or_number'   => 'number',
				'nextpagelink'     => esc_html__( 'Next page', 'velvet' ),
				'previouspagelink' => esc_html__( 'Previous page', 'velvet' ),
				'pagelink'         => '%',
				'echo'             => 1
			);

			$args = apply_filters( 'wp_link_pages_args', wp_parse_args( $args, $defaults ) );

			global $page, $numpages, $multipage, $more, $pagenow;

			$output = '';
			if ( $multipage ) {
				if ( 'number' == $args[ 'next_or_number' ] ) {
					$output .= $args[ 'before' ] . '<ul class="pagination">';
					$laquo = $page == 1 ? 'class="disabled"' : '';
					$output .= '<li ' . $laquo . '>' . _wp_link_page( $page - 1 ) . ' <i class="zmdi zmdi-chevron-left"></i></a></li>';
					for (
						$i = 1;
						$i < ( $numpages + 1 );
						$i = $i + 1
					) {
						$j = str_replace( '%', $i, $args[ 'pagelink' ] );

						if ( ( $i != $page ) || ( ( ! $more ) && ( $page == 1 ) ) ) {
							$output .= '<li>';
							$output .= _wp_link_page( $i );
						} else {
							$output .= '<li class="active">';
							$output .= _wp_link_page( $i );
						}
						$output .= $args[ 'link_before' ] . $j . $args[ 'link_after' ];

						$output .= '</a></li>';
					}
					$raquo = $page == $numpages ? 'class="disabled"' : '';
					$output .= '<li ' . $raquo . '>' . _wp_link_page( $page + 1 ) . ' <i class="zmdi zmdi-chevron-right"></i> </a></li>';
					$output .= '</ul>' . $args[ 'after' ];
				} else {
					if ( $more ) {
						$output .= $args[ 'before' ] . '<ul class="pager">';
						$i = $page - 1;
						if ( $i && $more ) {
							$output .= '<li class="previous">' . _wp_link_page( $i );
							$output .= $args[ 'link_before' ] . $args[ 'previouspagelink' ] . $args[ 'link_after' ] . '</li>';
						}
						$i = $page + 1;
						if ( $i <= $numpages && $more ) {
							$output .= '<li class="next">' . _wp_link_page( $i );
							$output .= $args[ 'link_before' ] . $args[ 'nextpagelink' ] . $args[ 'link_after' ] . '</a></li>';
						}
						$output .= '</ul>' . $args[ 'after' ];
					}
				}
			}

			if ( $args[ 'echo' ] ) {
				echo $output;
			} else {
				return $output;
			}
		}
	endif;

	//----------------------------------------------------------------------
	//  Posts navigation link. <- NEW post  |   OLD Post ->
	//----------------------------------------------------------------------

	if ( ! function_exists( 'velvet_posts_navigation' ) ) :

		function velvet_posts_navigation() {
			if ( $GLOBALS[ 'wp_query' ]->max_num_pages > 1 ) {
				get_template_part( 'template-parts/posts', 'navigation' );
			}
		}
	endif;

	//----------------------------------------------------------------------
	//  Blog Pagination
	//----------------------------------------------------------------------

	if ( ! function_exists( 'velvet_posts_pagination' ) ) :
		function velvet_posts_pagination() {

			if ( $GLOBALS[ 'wp_query' ]->max_num_pages > 1 ) {
				$big   = 999999999; // need an unlikely integer
				$items = paginate_links( apply_filters( 'velvet_posts_pagination_paginate_links', array(
					'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
					'format'    => '?paged=%#%',
					'prev_next' => TRUE,
					'current'   => max( 1, get_query_var( 'paged' ) ),
					'total'     => $GLOBALS[ 'wp_query' ]->max_num_pages,
					'type'      => 'array',
					'prev_text' => '<i class="zmdi zmdi-long-arrow-left"></i> ',
					'next_text' => ' <i class="zmdi zmdi-long-arrow-right"></i>',
					'end_size'  => 1,
					'mid_size'  => 1
				) ) );

				$pagination = "<div class=\"pagination-wrap clearfix\"><ul role=\"navigation\" class=\"pagination navigation\"><li>";
				$pagination .= join( "</li><li>", (array) $items );
				$pagination .= "</li></ul></div>";

				echo apply_filters( 'velvet_posts_pagination', $pagination, $items, $GLOBALS[ 'wp_query' ] );
			}
		}
	endif;

	//------------------------------------------------------------------------------------
	//  Prints HTML with meta information in content meta
	//------------------------------------------------------------------------------------

	if ( ! function_exists( 'velvet_entry_meta' ) ) :

		function velvet_entry_meta( $hide_list = array() ) {
			$GLOBALS[ 'hide_list' ] = $hide_list;
			get_template_part( 'template-parts/post-entry-meta' );
		}
	endif;

	//------------------------------------------------------------------------------------
	//  Prints HTML with meta information in content footer
	//------------------------------------------------------------------------------------

	if ( ! function_exists( 'velvet_entry_footer' ) ) :

		function velvet_entry_footer( $hide_list = array() ) {
			$GLOBALS[ 'hide_list' ] = $hide_list;
			get_template_part( 'template-parts/post-entry-footer' );
		}
	endif;

	//------------------------------------------------------------------------------------
	//  Returns true if a blog has more than 1 category.
	//------------------------------------------------------------------------------------

	if ( ! function_exists( 'velvet_categorized_blog' ) ):

		function velvet_categorized_blog() {

			if ( FALSE === ( $all_the_cool_cats = get_transient( 'velvet_categories' ) ) ) {
				// Create an array of all the categories that are attached to posts.
				$all_the_cool_cats = get_categories( apply_filters( 'velvet_categorized_blog', array(
					'fields'     => 'ids',
					'hide_empty' => 1,
					// We only need to know if there is more than one category.
					'number'     => 2,
				) ) );

				// Count the number of categories that are attached to the posts.
				$all_the_cool_cats = count( $all_the_cool_cats );

				set_transient( 'velvet_categories', $all_the_cool_cats );
			}

			if ( $all_the_cool_cats > 1 ) {
				// This blog has more than 1 category so velvet_categorized_blog should return true.
				return TRUE;
			} else {
				// This blog has only 1 category so velvet_categorized_blog should return false.
				return FALSE;
			}
		}
	endif;

	//------------------------------------------------------------------------------------
	//  Flush out the transients used in velvet_categorized_blog.
	//------------------------------------------------------------------------------------

	if ( ! function_exists( 'velvet_category_transient_flusher' ) ):

		function velvet_category_transient_flusher() {
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}
			// Like, beat it. Dig?
			delete_transient( 'velvet_categories' );
		}

		add_action( 'edit_category', 'velvet_category_transient_flusher' );
		add_action( 'save_post', 'velvet_category_transient_flusher' );

	endif;

	//----------------------------------------------------------------------
	// Read More link
	//----------------------------------------------------------------------

	if ( ! function_exists( 'velvet_blog_more_link' ) ) :

		function velvet_blog_more_link( $link ) {
			$more_link = str_replace( 'more-link', 'more-link read-more', $link );

			return '<div class="read-more">' . $more_link . '</div>';
		}

		// add_filter('the_content_more_link', 'velvet_blog_more_link');

	endif;

	//----------------------------------------------------------------------
	// Display recent post thumbnail.
	//----------------------------------------------------------------------

	if ( ! function_exists( 'velvet_post_thumbnail' ) ) :

		function velvet_post_thumbnail( $placeholder = 'http://placehold.it/1140x600' ) {

			$bool_return = FALSE;

			if ( is_bool( $placeholder ) and $placeholder === TRUE ) {
				$bool_return = TRUE;
			}


			$post_format = get_post_format();
			$post_format = ( FALSE === $post_format ) ? 'standard' : $post_format;
			$has_thumb   = FALSE;
			$post_id     = get_the_ID();


			switch ( $post_format ) :

				case 'standard':
				case 'image':
				case 'chat':
				case 'aside':
					if ( has_post_thumbnail() ) {
						$has_thumb = TRUE;
					}
					break;

				case 'quote':

					$text = wp_kses( trim( get_post_meta( $post_id, 'post_featured_quote_text', TRUE ) ), wp_kses_allowed_html( 'post' ) );

					if ( has_post_thumbnail() ) {
						$has_thumb = TRUE;
					} elseif ( ! empty( $text ) ) {
						$has_thumb = TRUE;
					}

					break;

				case 'link':

					$text = wp_kses( trim( get_post_meta( $post_id, 'post_featured_link_text', TRUE ) ), wp_kses_allowed_html( 'post' ) );

					if ( has_post_thumbnail() ) {
						$has_thumb = TRUE;
					} elseif ( ! empty( $text ) ) {
						$has_thumb = TRUE;
					}

					break;

				case 'status':

					$text = wp_kses( trim( get_post_meta( $post_id, 'post_featured_status_text', TRUE ) ), wp_kses_allowed_html( 'post' ) );

					if ( has_post_thumbnail() ) {
						$has_thumb = TRUE;
					} elseif ( ! empty( $text ) ) {
						$has_thumb = TRUE;
					}

					break;


				case 'video':

					$embed_video = get_post_meta( $post_id, 'post_video_embed', TRUE );
					$embed_webm  = get_post_meta( $post_id, 'post_featured_webm', TRUE );
					$embed_ogv   = get_post_meta( $post_id, 'post_featured_ogv', TRUE );
					$embed_mp4   = get_post_meta( $post_id, 'post_featured_mp4', TRUE );

					if ( has_post_thumbnail() ) {
						$has_thumb = TRUE;
					} elseif ( ! empty( $embed_video ) or ! empty( $embed_webm ) or ! empty( $embed_ogv ) or ! empty( $embed_mp4 ) ) {
						$has_thumb = TRUE;
					}

					break;

				case 'audio':

					$embed_audio = get_post_meta( $post_id, 'post_audio_embed', TRUE );
					$embed_mp3   = get_post_meta( $post_id, 'post_featured_mp3', TRUE );
					$embed_ogg   = get_post_meta( $post_id, 'post_featured_ogg', TRUE );

					if ( has_post_thumbnail() ) {
						$has_thumb = TRUE;
					} elseif ( ! empty( $embed_audio ) or ! empty( $embed_mp3 ) or ! empty( $embed_ogg ) ) {
						$has_thumb = TRUE;
					}

					break;

				case 'gallery':

					$gallery_items = get_post_meta( $post_id, 'post_featured_gallery', TRUE );

					if ( has_post_thumbnail() ) {
						$has_thumb = TRUE;
					} elseif ( ! empty( $gallery_items ) ) {
						$has_thumb = TRUE;
					}
					break;
			endswitch;

			if ( post_password_required() ) {
				$has_thumb = FALSE;
			}

			if ( $bool_return ) {
				return $has_thumb;
			}

			if ( $has_thumb ): ?>
				<div class="entry-thumbnail post-thumbnail element <?php echo esc_attr( $post_format ) ?>">
					<?php
						do_action( 'before_velvet_post_thumbnail', array(
							'post_format' => $post_format,
							'has_thumb'   => $has_thumb,
							'post_id'     => $post_id
						) );

						if ( $post_format == 'standard'
						     || $post_format == 'image'
						     || $post_format == 'chat'
						     || $post_format == 'aside'
						) {

							if ( get_the_post_thumbnail() ) {

								if ( is_single() ) {
									the_post_thumbnail( apply_filters( 'velvet_post_thumbnail_image_size', 'velvet-single-blog-thumbnail' ), array(
										'class' => 'img-responsive',
										'alt'   => wp_kses( get_the_title(), array() )
									) );
								} else {
									the_post_thumbnail( apply_filters( 'velvet_post_thumbnail_image_size', 'velvet-blog-thumbnail' ), array(
										'class' => 'img-responsive',
										'alt'   => wp_kses( get_the_title(), array() )
									) );
								}
							} else {

								if ( is_single() ) {
									echo apply_filters( 'velvet_post_thumbnail_placeholder', '<img src="' . $placeholder . '" class="img-responsive wp-post-image" alt="' . wp_kses( get_the_title(), array() ) . '">' );
								} else {
									echo apply_filters( 'velvet_post_thumbnail_placeholder', '<img src="' . $placeholder . '" class="img-responsive wp-post-image" alt="' . wp_kses( get_the_title(), array() ) . '">' );
								}
							}
						} elseif ( $post_format == 'quote' or $post_format == 'link' or $post_format == 'status' ) {

							if ( empty( $text ) ) {
								if ( get_the_post_thumbnail() ) {

									if ( is_single() ) {
										the_post_thumbnail( apply_filters( 'velvet_post_thumbnail_image_size', 'velvet-single-blog-thumbnail' ), array(
											'class' => 'img-responsive',
											'alt'   => wp_kses( get_the_title(), array() )
										) );
									} else {
										the_post_thumbnail( apply_filters( 'velvet_post_thumbnail_image_size', 'velvet-blog-thumbnail' ), array(
											'class' => 'img-responsive',
											'alt'   => wp_kses( get_the_title(), array() )
										) );
									}
								} else {

									if ( is_single() ) {
										echo apply_filters( 'velvet_post_thumbnail_placeholder', '<img src="' . $placeholder . '" class="img-responsive wp-post-image" alt="' . wp_kses( get_the_title(), array() ) . '">' );
									} else {
										echo apply_filters( 'velvet_post_thumbnail_placeholder', '<img src="' . $placeholder . '" class="img-responsive wp-post-image" alt="' . wp_kses( get_the_title(), array() ) . '">' );
									}
								}
							} else {
								?>
								<div class="featured-text hippo-featured-text">
									<?php echo do_shortcode( $text ); ?>
								</div>
								<?php
							}

						} elseif ( $post_format == 'video' ) {

							if ( $embed_video and ( empty( $embed_webm ) or empty( $embed_ogv ) or empty( $embed_mp4 ) ) ) {
								echo wp_oembed_get( esc_url( $embed_video ) );
							} elseif ( ! empty( $embed_webm ) or ! empty( $embed_ogv ) or ! empty( $embed_mp4 ) ) {
								?>

								<video style="width: 100%" class="featured-video wp-video-shortcode mejs-mejskin"
								       preload="auto" controls="controls">
									<?php if ( ! empty( $embed_webm ) ) { ?>
										<source src="<?php echo esc_url( wp_get_attachment_url( $embed_webm ) ) ?>"
										        type="video/webm"/>
									<?php } ?>
									<?php if ( ! empty( $embed_ogv ) ) { ?>
										<source src="<?php echo esc_url( wp_get_attachment_url( $embed_ogv ) ) ?>"
										        type="video/ogg"/>
									<?php } ?>

									<?php if ( ! empty( $embed_mp4 ) ) { ?>
										<source src="<?php echo esc_url( wp_get_attachment_url( $embed_mp4 ) ) ?>"
										        type="video/mp4"/>
									<?php } ?>
								</video>
								<?php
							}
						} elseif ( $post_format == 'audio' ) {

							if ( $embed_audio and ( empty( $embed_mp3 ) or empty( $embed_ogg ) ) ) {
								echo wp_oembed_get( esc_url( $embed_audio ) );
							} elseif ( ! empty( $embed_mp3 ) or ! empty( $embed_ogg ) ) {
								?>
								<audio style="width: 100%" class="featured-audio wp-audio-shortcode mejs-mejskin"
								       controls="controls" preload="none">
									<?php if ( ! empty( $embed_mp3 ) ) { ?>
										<source src="<?php echo esc_url( wp_get_attachment_url( $embed_mp3 ) ) ?>"
										        type="audio/mpeg"/>
									<?php } ?>
									<?php if ( ! empty( $embed_ogg ) ) { ?>
										<source src="<?php echo esc_url( wp_get_attachment_url( $embed_ogg ) ) ?>"
										        type="audio/ogg"/>
									<?php } ?>
								</audio>
								<?php
							}
						} elseif ( $post_format == 'gallery' ) {

							if ( has_post_thumbnail() ) {
								if ( get_the_post_thumbnail() ) {

									if ( is_single() ) {
										the_post_thumbnail( apply_filters( 'velvet_post_thumbnail_image_size', 'velvet-single-blog-thumbnail' ), array(
											'class' => 'img-responsive',
											'alt'   => wp_kses( get_the_title(), array() )
										) );
									} else {

										the_post_thumbnail( apply_filters( 'velvet_post_thumbnail_image_size', 'velvet-blog-thumbnail' ), array(
											'class' => 'img-responsive',
											'alt'   => wp_kses( get_the_title(), array() )
										) );
									}

								} else {

									if ( is_single() ) {
										echo apply_filters( 'velvet_post_thumbnail_placeholder', '<img src="' . $placeholder . '" class="img-responsive wp-post-image" alt="' . wp_kses( get_the_title(), array() ) . '">' );
									} else {
										echo apply_filters( 'velvet_post_thumbnail_placeholder', '<img src="' . $placeholder . '" class="img-responsive wp-post-image" alt="' . wp_kses( get_the_title(), array() ) . '">' );
									}
								}
							} else {

								if ( is_array( $gallery_items ) ) {

									$GLOBALS[ 'gallery_items' ] = $gallery_items;
									get_template_part( 'template-parts/featured-post-gallery' );
								}
							}
						}

						do_action( 'after_velvet_post_thumbnail', array(
							'post_format' => $post_format,
							'has_thumb'   => $has_thumb,
							'post_id'     => $post_id
						) );
					?>
				</div> <!-- .post-thumbnail -->
				<?php
			else :
				return FALSE;
			endif;
		}
	endif;

	//----------------------------------------------------------------------
	//  Post Password form
	//----------------------------------------------------------------------

	if ( ! function_exists( 'velvet_post_password_form' ) ) :

		function velvet_post_password_form() {

			ob_start();
			get_template_part( 'template-parts/post-password-form' );

			return ob_get_clean();
		}

		add_filter( 'the_password_form', 'velvet_post_password_form' );
	endif;

	//----------------------------------------------------------------------
	// Breadcrumb
	//----------------------------------------------------------------------

	if ( ! function_exists( 'velvet_breadcrumbs' ) ) :

		function velvet_breadcrumbs() {
			$active_class  = apply_filters( 'velvet_breadcrumb_active_class', 'active' );
			$wrapper_class = apply_filters( 'velvet_breadcrumb_wrapper_class', 'breadcrumb' );

			/* === OPTIONS === */
			$text[ 'home' ]     = esc_html__( 'Home', 'velvet' ); // text for the 'Home' link
			$text[ 'category' ] = esc_html__( 'Archive by Category "%s"', 'velvet' ); // text for a category page
			$text[ 'search' ]   = esc_html__( 'Search Results for "%s" Query', 'velvet' ); // text for a search results page
			$text[ 'tag' ]      = esc_html__( 'Posts Tagged "%s"', 'velvet' ); // text for a tag page
			$text[ 'author' ]   = esc_html__( 'Posted by %s', 'velvet' ); // text for an author page
			$text[ '404' ]      = esc_html__( 'Error 404', 'velvet' ); // text for the 404 page

			$show_current   = 1; // 1 - show current post/page/category title in breadcrumbs, 0 - don't show
			$show_on_home   = 1; // 1 - show breadcrumbs on the homepage, 0 - don't show
			$show_home_link = 1; // 1 - show the 'Home' link, 0 - don't show
			$show_title     = 1; // 1 - show the title for the links, 0 - don't show
			$delimiter      = ''; // delimiter between crumbs
			$before         = '<li class="' . $active_class . '">'; // tag before the current crumb
			$after          = '</li>'; // tag after the current crumb
			/* === END OF OPTIONS === */

			global $post;
			$home_link          = esc_url( home_url( '/' ) );
			$link_before        = '<li>';
			$active_link_before = '<li class="' . $active_class . '">';
			$link_after         = '</li>';
			$link_attr          = ' ';
			$active_link        = $active_link_before . '%2$s' . $link_after;
			$link               = $link_before . '<a' . $link_attr . ' href="%1$s">%2$s</a>' . $link_after;
			$parent_id          = $parent_id_2 = isset( $post->post_parent ) ? $post->post_parent : '';
			$frontpage_id       = get_option( 'page_on_front' );
			$query              = get_queried_object();

			do_action( 'velvet_before_breadcrumbs' );

			$breadcrumbs_ld_json_array                      = array();
			$breadcrumbs_ld_json_array[ "@context" ]        = "http://schema.org";
			$breadcrumbs_ld_json_array[ "@type" ]           = "BreadcrumbList";
			$breadcrumbs_ld_json_array[ "itemListElement" ] = array();


			if ( is_home() and ! is_front_page() ) {

				if ( $show_on_home == 1 ) {
					echo '<ul class="' . $wrapper_class . '">';
					printf( $link, $home_link, $text[ 'home' ] );

					// Add Element TO JSON
					$breadcrumbs_ld_json_array[ "itemListElement" ][] = array(
						"@type" => "ListItem",
						'item'  => array(
							"@id"  => $home_link,
							"name" => $text[ 'home' ]
						)
					);

					if ( isset( $query ) ) {
						printf( $active_link, esc_url( get_permalink( $query->ID ) ), esc_attr( $query->post_title ) );

						// Add Element TO JSON

						$breadcrumbs_ld_json_array[ "itemListElement" ][] = array(
							"@type" => "ListItem",
							'item'  => array(
								"@id"  => esc_url( get_permalink( $query->ID ) ),
								"name" => esc_attr( $query->post_title )
							)
						);

					}
					echo '</ul>';
				}
			} elseif ( is_home() || is_front_page() ) {

				if ( $show_on_home == 1 ) {
					echo '<ul class="' . $wrapper_class . '">
                        <li class="' . $active_class . '">
                            <a href="' . $home_link . '">' . $text[ 'home' ] . '</a>
                        </li>
                    </ul>';

					//// Add Element TO JSON
					$breadcrumbs_ld_json_array[ "itemListElement" ][] = array(
						"@type" => "ListItem",
						'item'  => array(
							"@id"  => $home_link,
							"name" => $text[ 'home' ]
						)
					);
				}

			} else {

				echo '<ul class="' . $wrapper_class . '">';
				if ( $show_home_link == 1 ) {
					echo '<li><a href="' . $home_link . '">' . $text[ 'home' ] . '</a></li>';

					//// Add Element TO JSON

					$breadcrumbs_ld_json_array[ "itemListElement" ][] = array(
						"@type" => "ListItem",
						'item'  => array(
							"@id"  => $home_link,
							"name" => $text[ 'home' ]
						)
					);

					if ( $frontpage_id == 0 || $parent_id != $frontpage_id ) {
						echo esc_html( $delimiter );
					}
				}

				// category

				if ( is_category() ) {
					$this_cat = get_category( get_query_var( 'cat' ), FALSE );

					if ( $this_cat->parent != 0 ) {
						$cats = get_category_parents( $this_cat->parent, TRUE, $delimiter );


						if ( $show_current == 0 ) {
							$cats = preg_replace( "#^(.+)$delimiter$#", "$1", $cats );
						}
						$cats = str_replace( '<a', $link_before . '<a' . $link_attr, $cats );
						$cats = str_replace( '</a>', '</a>' . $link_after, $cats );
						if ( $show_title == 0 ) {
							$cats = preg_replace( '/ title="(.*?)"/', '', $cats );
						}
						echo $cats;

						/////// CATEGORY PARENTING
						$links = get_category_parents( $this_cat->parent, TRUE, '###' );

						$links_array  = (array) explode( '###', $links );
						$links_regexp = "@href=\"(?P<link>.+)\"\\s*>(?P<name>.+)<@";

						foreach ( $links_array as $link ) {

							if ( preg_match( $links_regexp, $link, $category ) ) {

								//// Add Element TO JSON

								$breadcrumbs_ld_json_array[ "itemListElement" ][] = array(
									"@type" => "ListItem",
									'item'  => array(
										"@id"  => $category[ 'link' ],
										"name" => $category[ 'name' ]
									)
								);


							}
						}

					}
					if ( $show_current == 1 ) {
						echo $before . sprintf( $text[ 'category' ], apply_filters( 'velvet_breadcrumb_title', single_cat_title( '', FALSE ) ) ) . $after;

						$breadcrumbs_ld_json_array[ "itemListElement" ][] = array(
							"@type" => "ListItem",
							'item'  => array(
								"@id"  => get_category_link( $this_cat->term_id ),
								"name" => single_cat_title( '', FALSE )
							)
						);
					}

				} // search

				elseif ( is_search() ) {
					echo $before . sprintf( $text[ 'search' ], apply_filters( 'velvet_breadcrumb_title', get_search_query() ) ) . $after;

				} // archive - day

				elseif ( is_day() ) {
					echo sprintf( $link, get_year_link( get_the_time( 'Y' ) ), get_the_time( 'Y' ) ) . $delimiter;

					echo sprintf( $link, get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ), get_the_time( 'F' ) ) . $delimiter;

					echo $before . get_the_time( 'd' ) . $after;

					//// Add Element TO JSON


					$breadcrumbs_ld_json_array[ "itemListElement" ][] = array(
						"@type" => "ListItem",
						'item'  => array(
							"@id"  => get_year_link( get_the_time( 'Y' ) ),
							"name" => get_the_time( 'Y' )
						)
					);

					//// Add Element TO JSON


					$breadcrumbs_ld_json_array[ "itemListElement" ][] = array(
						"@type" => "ListItem",
						'item'  => array(
							"@id"  => get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ),
							"name" => get_the_time( 'F' )
						)
					);

					//// Add Element TO JSON
					$breadcrumbs_ld_json_array[ "itemListElement" ][] = array(
						"@type" => "ListItem",
						'item'  => array(
							"@id"  => get_day_link( get_the_time( 'Y' ), get_the_time( 'm' ), get_the_time( 'd' ) ),
							"name" => get_the_time( 'd' )
						)
					);

				} // archive - month

				elseif ( is_month() ) {
					echo sprintf( $link, get_year_link( get_the_time( 'Y' ) ), get_the_time( 'Y' ) ) . $delimiter;
					echo $before . get_the_time( 'F' ) . $after;

					//// Add Element TO JSON

					$breadcrumbs_ld_json_array[ "itemListElement" ][] = array(
						"@type" => "ListItem",
						'item'  => array(
							"@id"  => get_year_link( get_the_time( 'Y' ) ),
							"name" => get_the_time( 'Y' )
						)
					);

					//// Add Element TO JSON
					$breadcrumbs_ld_json_array[ "itemListElement" ][] = array(
						"@type" => "ListItem",
						'item'  => array(
							"@id"  => get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ),
							"name" => get_the_time( 'F' )
						)
					);

				} // archive - year

				elseif ( is_year() ) {
					echo $before . get_the_time( 'Y' ) . $after;

					//// Add Element TO JSON
					$breadcrumbs_ld_json_array[ "itemListElement" ][] = array(
						"@type" => "ListItem",
						'item'  => array(
							"@id"  => get_year_link( get_the_time( 'Y' ) ),
							"name" => get_the_time( 'Y' )
						)
					);

				} // single post

				elseif ( is_single() && ! is_attachment() ) {

					// custom post type

					if ( get_post_type() != 'post' ) {
						$post_type = get_post_type_object( get_post_type() );
						$slug      = $post_type->rewrite;

						if ( $show_current == 1 ) {
							echo $delimiter . $before . apply_filters( 'velvet_breadcrumb_title', wp_kses( get_the_title(), array() ) ) . $after;

							$breadcrumbs_ld_json_array[ "itemListElement" ][] = array(
								"@type" => "ListItem",
								'item'  => array(
									"@id"  => esc_url( get_permalink() ),
									"name" => wp_kses( get_the_title(), array() )
								)
							);
						}
					} else {
						$cat  = get_the_category();
						$cat  = $cat[ 0 ];
						$cats = get_category_parents( $cat, TRUE, $delimiter );

						if ( $show_current == 0 ) {
							$cats = preg_replace( "#^(.+)$delimiter$#", "$1", $cats );
						}
						$cats = str_replace( '<a', $link_before . '<a' . $link_attr, $cats );
						$cats = str_replace( '</a>', '</a>' . $link_after, $cats );
						if ( $show_title == 0 ) {
							$cats = preg_replace( '/ title="(.*?)"/', '', $cats );
						}
						echo $cats;


						/////// CATEGORY PARENTING
						$links = get_category_parents( $cat, TRUE, '###' );

						$links_array  = (array) explode( '###', $links );
						$links_regexp = "@href=\"(?P<link>.+)\"\\s*>(?P<name>.+)<@";

						foreach ( $links_array as $link ) {

							if ( preg_match( $links_regexp, $link, $category ) ) {
								//// Add Element TO JSON
								$breadcrumbs_ld_json_array[ "itemListElement" ][] = array(
									"@type" => "ListItem",
									'item'  => array(
										"@id"  => $category[ 'link' ],
										"name" => $category[ 'name' ]
									)
								);
							}
						}

						if ( $show_current == 1 ) {
							echo $before . apply_filters( 'velvet_breadcrumb_title', wp_kses( get_the_title(), array() ) ) . $after;

							$breadcrumbs_ld_json_array[ "itemListElement" ][] = array(
								"@type" => "ListItem",
								'item'  => array(
									"@id"  => esc_url( get_permalink() ),
									"name" => wp_kses( get_the_title(), array() )
								)
							);
						}
					}

				} elseif ( ! is_single() && ! is_page() && get_post_type() != 'post' && ! is_404() ) {
					$post_type = get_post_type_object( get_post_type() );

					if ( is_singular() ) {

						echo $before . apply_filters( 'velvet_breadcrumb_title', $post_type->labels->name ) . $after;

						$breadcrumbs_ld_json_array[ "itemListElement" ][] = array(
							"@type" => "ListItem",
							'item'  => array(
								"@id"  => esc_url( get_post_type_archive_link( get_post_type() ) ),
								"name" => wp_kses( $post_type->labels->name, array() )
							)
						);

					} else {


						if ( is_object( $post_type ) ) {

							if ( is_tax() ) {

								echo sprintf( $link, esc_url( get_post_type_archive_link( get_post_type() ) ), $post_type->labels->name ) . $delimiter;

								echo $before . apply_filters( 'velvet_breadcrumb_title', $query->name ) . $after;

								$breadcrumbs_ld_json_array[ "itemListElement" ][] = array(
									"@type" => "ListItem",
									'item'  => array(
										"@id"  => esc_url( get_post_type_archive_link( get_post_type() ) ),
										"name" => wp_kses( $post_type->labels->name, array() )
									)
								);

								$breadcrumbs_ld_json_array[ "itemListElement" ][] = array(
									"@type" => "ListItem",
									'item'  => array(
										"@id"  => esc_url( get_term_link( $query->term_id, $query->taxonomy ) ),
										"name" => wp_kses( $query->name, array() )
									)
								);
							} else {

								echo $before . apply_filters( 'velvet_breadcrumb_title', $post_type->labels->name ) . $after;

								$breadcrumbs_ld_json_array[ "itemListElement" ][] = array(
									"@type" => "ListItem",
									'item'  => array(
										"@id"  => esc_url( get_post_type_archive_link( get_post_type() ) ),
										"name" => wp_kses( $post_type->labels->name, array() )
									)
								);
							}
						}
					}


				} elseif ( is_attachment() ) {
					$parent = get_post( $parent_id );
					$cat    = get_the_category( $parent->ID );

					if ( ! empty( $cat ) ) {
						$cat  = $cat[ 0 ];
						$cats = get_category_parents( $cat, TRUE, $delimiter );
						$cats = str_replace( '<a', $link_before . '<a' . $link_attr, $cats );
						$cats = str_replace( '</a>', '</a>' . $link_after, $cats );

						if ( $show_title == 0 ) {
							$cats = preg_replace( '/ title="(.*?)"/', '', $cats );
						}
						echo $cats;
						printf( $link, esc_url( get_permalink( $parent ) ), $parent->post_title );

						//// Add Element TO JSON

						$breadcrumbs_ld_json_array[ "itemListElement" ][] = array(
							"@type" => "ListItem",
							'item'  => array(
								"@id"  => esc_url( get_permalink( $parent ) ),
								"name" => $parent->post_title
							)
						);
					}
					if ( $show_current == 1 ) {
						echo $delimiter . $before . apply_filters( 'velvet_breadcrumb_title', wp_kses( get_the_title(), array() ) ) . $after;

						//// Add Element TO JSON

						$breadcrumbs_ld_json_array[ "itemListElement" ][] = array(
							"@type" => "ListItem",
							'item'  => array(
								"@id"  => esc_url( get_permalink() ),
								"name" => wp_kses( get_the_title(), array() )
							)
						);
					}

				} elseif ( is_page() && ! $parent_id ) {
					if ( $show_current == 1 ) {
						echo $before . apply_filters( 'velvet_breadcrumb_title', wp_kses( get_the_title(), array() ) ) . $after;

						//// Add Element TO JSON
						$breadcrumbs_ld_json_array[ "itemListElement" ][] = array(
							"@type" => "ListItem",
							'item'  => array(
								"@id"  => esc_url( get_permalink() ),
								"name" => wp_kses( get_the_title(), array() )
							)
						);
					}

				} elseif ( is_page() && $parent_id ) {
					if ( $parent_id != $frontpage_id ) {
						$breadcrumbs = array();
						while ( $parent_id ) {
							$page = get_post( $parent_id );
							if ( $parent_id != $frontpage_id ) {
								$breadcrumbs[] = sprintf( $link, esc_url( get_permalink( $page->ID ) ), wp_kses( get_the_title( $page->ID ), array() ) );

								//// Add Element TO JSON

								$breadcrumbs_ld_json_array[ "itemListElement" ][] = array(
									"@type" => "ListItem",
									'item'  => array(
										"@id"  => esc_url( get_permalink( $page->ID ) ),
										"name" => wp_kses( get_the_title( $page->ID ), array() )
									)
								);
							}
							$parent_id = $page->post_parent;
						}
						$breadcrumbs = array_reverse( $breadcrumbs );
						for (
							$i = 0;
							$i < count( $breadcrumbs );
							$i ++
						) {
							echo $breadcrumbs[ $i ];
							if ( $i != count( $breadcrumbs ) - 1 ) {
								echo $delimiter;
							}
						}
					}
					if ( $show_current == 1 ) {
						if ( $show_home_link == 1 || ( $parent_id_2 != 0 && $parent_id_2 != $frontpage_id ) ) {
							echo $delimiter;
						}
						echo $before . apply_filters( 'velvet_breadcrumb_title', wp_kses( get_the_title(), array() ) ) . $after;
						//// Add Element TO JSON

						$breadcrumbs_ld_json_array[ "itemListElement" ][] = array(
							"@type" => "ListItem",
							'item'  => array(
								"@id"  => esc_url( get_permalink() ),
								"name" => wp_kses( get_the_title(), array() )
							)
						);
					}

				} elseif ( is_tag() ) {
					echo $before . sprintf( $text[ 'tag' ], apply_filters( 'velvet_breadcrumb_title', single_tag_title( '', FALSE ) ) ) . $after;

					//// Add Element TO JSON

					$breadcrumbs_ld_json_array[ "itemListElement" ][] = array(
						"@type" => "ListItem",
						'item'  => array(
							"@id"  => esc_url( get_tag_link( $query->term_id ) ),
							"name" => wp_kses( single_tag_title( '', FALSE ), array() )
						)
					);

				} elseif ( is_author() ) {
					global $author;
					$userdata = get_userdata( $author );
					echo $before . sprintf( $text[ 'author' ], apply_filters( 'velvet_breadcrumb_title', $userdata->display_name ) ) . $after;

					//// Add Element TO JSON

					$breadcrumbs_ld_json_array[ "itemListElement" ][] = array(
						"@type" => "ListItem",
						'item'  => array(
							"@id"  => esc_url( get_author_posts_url( $userdata->ID ) ),
							"name" => wp_kses( $userdata->display_name, array() )
						)
					);
				} elseif ( is_404() ) {
					echo $before . $text[ '404' ] . $after;
				}

				if ( get_query_var( 'paged' ) ) {
					if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) {
						//	echo '(';
					}
					echo '<li class="breadcrumb-page-no"> ' . esc_html__( 'Page', 'velvet' ) . ' ' . get_query_var( 'paged' ) . '</li>';
					if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) {
						//	echo ') ';
					}
				}

				echo '</ul><!-- .breadcrumbs -->';
				do_action( 'velvet_after_breadcrumbs' );

			}


			//////

			//print_r( $breadcrumbs_ld_json_array );


			foreach ( $breadcrumbs_ld_json_array[ 'itemListElement' ] as $position => $item ) {
				$breadcrumbs_ld_json_array[ 'itemListElement' ][ $position ][ 'position' ] = $position + 1;
			}
			echo '<script type="application/ld+json">' . json_encode( $breadcrumbs_ld_json_array ) . '</script>';

			/////


		}
	endif;

	//----------------------------------------------------------------------
	// Sub title text
	//----------------------------------------------------------------------

	if ( ! function_exists( 'velvet_title_text' ) ) :

		function velvet_title_text() {

			$query = get_queried_object();

			if ( is_archive() ) {
				if ( is_day() ) {
					$archive_title = get_the_time( 'd F, Y' );
					$title         = sprintf( esc_html__( 'Archive of: %s', 'velvet' ), $archive_title );
				} elseif ( is_month() ) {
					$archive_title = get_the_time( 'F Y' );
					$title         = sprintf( esc_html__( 'Archive of: %s', 'velvet' ), $archive_title );
				} elseif ( is_year() ) {
					$archive_title = get_the_time( 'Y' );
					$title         = sprintf( esc_html__( 'Archive of: %s', 'velvet' ), $archive_title );
				}
			}

			if ( is_404() ) {
				$title = esc_html__( '404 Not Found', 'velvet' );
			}

			if ( is_search() ) {
				$title = sprintf( esc_html__( 'Search result for: "%s"', 'velvet' ), get_search_query() );
			}

			if ( is_category() ) {
				$title = sprintf( esc_html__( 'Category: %s', 'velvet' ), $query->name );
			}

			if ( is_tag() ) {
				$title = sprintf( esc_html__( 'Tag: %s', 'velvet' ), $query->name );
			}

			if ( is_author() ) {
				$title = sprintf( esc_html__( 'Posts of: %s', 'velvet' ), $query->display_name );
			}

			if ( is_page() ) {
				$title = $query->post_title;
			}

			if ( is_home() or is_single() ) {
				$title = esc_html( velvet_option( 'blog-title', FALSE, esc_html__( 'Blog', 'velvet' ) ) );
			}

			if ( is_singular( 'service' ) ) {
				$title = wp_kses( get_the_title(), array() );
			}

			if ( is_singular( 'portfolio' ) ) {
				$title = wp_kses( get_the_title(), array() );
			}

			if ( is_tax( 'portfolio-type' ) ) {
				$title = sprintf( esc_html__( '%s', 'velvet' ), $query->name );
			}

			if ( is_singular( 'team' ) ) {
				$title = wp_kses( get_the_title(), array() );
			}

			if ( is_singular( 'product' ) ) {
				$title = wp_kses( get_the_title(), array() );
			}

			if ( is_post_type_archive( 'product' ) ) {
				$title = wp_kses( post_type_archive_title( '', FALSE ), array() );
			}

			$title = apply_filters( 'velvet_title_text', $title );

			if ( empty( $title ) ) {
				$title = esc_html( get_bloginfo( 'name' ) );
			}

			return $title;
		}
	endif;

	//----------------------------------------------------------------------
	// Sub title text used in Archive, Search, 404,
	//----------------------------------------------------------------------

	if ( ! function_exists( 'velvet_title_image' ) ) :

		function velvet_title_image( $placeholder = 'http://placehold.it/1400x400' ) {
			$query = get_queried_object();

			$image = FALSE;

			if ( is_archive() ) {
				$image = velvet_option( 'title-archive-image', 'url' );
			}


			if ( is_404() ) {
				$image = velvet_option( 'title-404-image', 'url' );
			}

			if ( is_search() ) {
				$image = velvet_option( 'title-search-image', 'url' );
			}

			if ( is_category() ) {
				$image = velvet_option( 'title-category-image', 'url' );
			}

			if ( is_tag() ) {
				$image = velvet_option( 'title-tag-image', 'url' );
			}

			if ( is_author() ) {
				$image = velvet_option( 'title-author-image', 'url' );
			}

			if ( is_page() ) {
				$image            = velvet_option( 'title-page-image', 'url' );
				$indivisual_image = get_post_meta( $query->ID, 'page_header_image', TRUE );
				$indivisual_image = ( $indivisual_image ) ? wp_get_attachment_url( $indivisual_image ) : FALSE;
				if ( $indivisual_image ) {
					$image = $indivisual_image;
				}
			}

			if ( is_single() ) {

				$image            = velvet_option( 'title-single-image', 'url' );
				$indivisual_image = get_post_meta( $query->ID, 'page_header_image', TRUE );
				$indivisual_image = ( $indivisual_image ) ? wp_get_attachment_url( $indivisual_image ) : FALSE;
				if ( $indivisual_image ) {
					$image = $indivisual_image;
				}
			}

			if ( empty ( $indivisual_image ) ) {

				if ( is_singular( 'service' ) ) {
					$image = velvet_option( 'title-service-image', 'url' );
				}

				if ( is_singular( 'portfolio' ) ) {
					$image = velvet_option( 'title-portfolio-image', 'url' );
				}
			}

			if ( is_home() ) {
				$image = velvet_option( 'title-blog-image', 'url' );
			}

			if ( ! $image ) {
				$image = velvet_option( 'title-blog-image', 'url' );
			}

			$link = apply_filters( 'velvet_title_image', $image, $image );

			if ( empty( $link ) ) {
				return apply_filters( 'velvet_title_image_placeholder', $placeholder );
			} else {
				return esc_url( $link );
			}
		}
	endif;

	//----------------------------------------------------------------------
	// Custom Post Type Link
	//----------------------------------------------------------------------

	if ( ! function_exists( 'velvet_get_post_type_link' ) ) :

		function velvet_get_post_type_link( $post_type ) {
			global $wp_rewrite;
			if ( ! $post_type_obj = get_post_type_object( $post_type ) ) {
				return FALSE;
			}

			if ( get_option( 'permalink_structure' ) && is_array( $post_type_obj->rewrite ) ) {

				$struct = $post_type_obj->rewrite[ 'slug' ];
				if ( $post_type_obj->rewrite[ 'with_front' ] ) {
					$struct = $wp_rewrite->front . $struct;
				} else {
					$struct = $wp_rewrite->root . $struct;
				}
				$link = esc_url( home_url( user_trailingslashit( $struct, 'post_type_archive' ) ) );
			} else {
				$link = esc_url( home_url( '?post_type=' . $post_type ) );
			}

			return $link;
		}
	endif;

	//----------------------------------------------------------------------
	// Comment form
	//----------------------------------------------------------------------

	if ( ! function_exists( 'velvet_comment_form' ) ) :

		function velvet_comment_form( $args = array(), $post_id = NULL ) {
			if ( NULL === $post_id ) {
				$post_id = get_the_ID();
			} else {
				$id = $post_id;
			}

			$commenter     = wp_get_current_commenter();
			$user          = wp_get_current_user();
			$user_identity = $user->exists() ? $user->display_name : '';

			if ( ! isset( $args[ 'format' ] ) ) {
				$args[ 'format' ] = current_theme_supports( 'html5', 'comment-form' ) ? 'html5' : 'xhtml';
			}

			$req      = get_option( 'require_name_email' );
			$aria_req = ( $req ? " aria-required='true'" : '' );
			$html5    = 'html5' === $args[ 'format' ];
			$fields   = array(
				'author' => '
                    <div class="row">
                    <div class="col-md-4 comment-form-author">
                        <div class="input-field">
                            <label for="author">' . esc_html__( 'Name *', 'velvet' ) . '</label>
                            <input   class="form-control"  id="author" name="author" type="text"
                            value="' . esc_attr( $commenter[ 'comment_author' ] ) . '" ' . $aria_req . ' />
                        </div>
                    </div>',
				'email'  => '<div class="col-md-4 comment-form-email">
                    <div class="input-field">
                        <label for="email">' . esc_html__( 'Email *', 'velvet' ) . '</label>
                        <input id="email" class="form-control" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . '
                        value="' . esc_attr( $commenter[ 'comment_author_email' ] ) . '" ' . $aria_req . ' />
                    </div>
                </div>',
				'url'    => '<div class="col-md-4 comment-form-url">
                    <div class="input-field">
                        <label for="url">' . esc_html__( 'Website *', 'velvet' ) . '</label>
                        <input  class="form-control" id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter[ 'comment_author_url' ] ) . '"  />
                    </div>
                </div></div>'
			);

			$required_text = sprintf( ' ' . esc_html__( 'Required fields are marked %s', 'velvet' ), '<span class="required">*</span>' );
			$defaults      = array(
				'fields'               => apply_filters( 'comment_form_default_fields', $fields ),
				'comment_field'        => '
                <div class="row comment-form-comment">
                    <div class="col-md-12">
                        <div class="input-field">
                            <label for="comment">' . esc_html__( 'Comment *', 'velvet' ) . '</label>
                            <textarea class="form-control" id="comment" name="comment" rows="8" aria-required="true"></textarea>
                        </div>
                    </div>
                </div>',
				'must_log_in'          => '
                <div class="alert alert-danger must-log-in">' .

				                          sprintf( wp_kses( __( 'You must be <a href="%s">logged in</a> to post a comment.', 'velvet' ), array( 'a' => array( 'href' => array() ) ) ), wp_login_url( apply_filters( 'the_permalink', esc_url( get_permalink( $post_id ) ) ) ) ) . '</div>',
				'logged_in_as'         => '<div class="alert alert-info logged-in-as">' . sprintf( wp_kses( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'velvet' ), array( 'a' => array( 'href' => array() ) ) ), get_edit_user_link(), $user_identity, wp_logout_url( apply_filters( 'the_permalink', esc_url( get_permalink( $post_id ) ) ) ) ) . '</div>',
				'comment_notes_before' => '<div class="alert alert-info comment-notes">' . esc_html__( 'Your email address will not be published.', 'velvet' ) . ( $req ? $required_text : '' ) . '</div>',
				'comment_notes_after'  => '<div class="form-allowed-tags">' . sprintf( wp_kses( __( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s', 'velvet' ), array( 'abbr' => array( 'title' => array() ) ) ), ' <code>' . allowed_tags() . '</code>' ) . '</div>',
				'id_form'              => 'commentform',
				'id_submit'            => 'submit',
				'title_reply'          => esc_html__( 'Leave a Reply', 'velvet' ),
				'title_reply_to'       => esc_html__( 'Leave a Reply to %s', 'velvet' ),
				'cancel_reply_link'    => esc_html__( 'Cancel reply', 'velvet' ),
				'label_submit'         => esc_html__( 'Submit Comment', 'velvet' ),
				'format'               => 'xhtml',
			);

			$args = wp_parse_args( $args, apply_filters( 'comment_form_defaults', $defaults ) );

			if ( comments_open( $post_id ) ) {
				?>
				<?php do_action( 'comment_form_before' ); ?>
				<div id="respond" class="comment-respond">
					<h2 id="reply-title" class="comment-reply-title">
						<?php comment_form_title( $args[ 'title_reply' ], $args[ 'title_reply_to' ] ); ?>
						<small><?php cancel_comment_reply_link( $args[ 'cancel_reply_link' ] ); ?></small>
					</h2>

					<?php if ( get_option( 'comment_registration' ) && ! is_user_logged_in() ) { ?>
						<?php echo $args[ 'must_log_in' ]; ?>
						<?php do_action( 'comment_form_must_log_in_after' ); ?>
					<?php } else { ?>
						<form action="<?php echo esc_url( site_url( '/wp-comments-post.php' ) ); ?>" method="post"
						      id="<?php echo esc_attr( $args[ 'id_form' ] ); ?>"
						      class="form-horizontal comment-form"<?php echo ( $html5 ) ? ' novalidate' : ''; ?>
						      role="form">
							<?php do_action( 'comment_form_top' ); ?>
							<?php if ( is_user_logged_in() ) { ?>
								<?php echo apply_filters( 'comment_form_logged_in', $args[ 'logged_in_as' ], $commenter, $user_identity ); ?>
								<?php do_action( 'comment_form_logged_in_after', $commenter, $user_identity );
								echo apply_filters( 'comment_form_field_comment', $args[ 'comment_field' ] ); ?>
							<?php } else { ?>
								<?php echo $args[ 'comment_notes_before' ]; ?>
								<?php
								do_action( 'comment_form_before_fields' );
								echo apply_filters( 'comment_form_field_comment', $args[ 'comment_field' ] );
								foreach ( (array) $args[ 'fields' ] as $name => $field ) {
									echo apply_filters( "comment_form_field_{$name}", $field ) . "\n";
								}
								do_action( 'comment_form_after_fields' );
							}
								echo $args[ 'comment_notes_after' ]; ?>

							<div class="form-submit">
								<input class="btn btn-primary btn-lg" name="submit" type="submit"
								       id="<?php echo esc_attr( $args[ 'id_submit' ] ); ?>"
								       value="<?php echo esc_attr( $args[ 'label_submit' ] ); ?>"/>
								<?php comment_id_fields( $post_id ); ?>
							</div>
							<?php do_action( 'comment_form', $post_id ); ?>
						</form>
					<?php } ?>
				</div><!-- #respond -->
				<?php do_action( 'comment_form_after' ); ?>
			<?php } else { ?>
				<?php do_action( 'comment_form_comments_closed' ); ?>
			<?php } ?>
			<?php
		}
	endif;

	//----------------------------------------------------------------------
	// Comments list
	//----------------------------------------------------------------------

	if ( ! function_exists( "velvet_comments_list" ) ) :

		function velvet_comments_list( $comment, $args, $depth ) {

			$GLOBALS[ 'comment' ] = $comment;
			switch ( $comment->comment_type ) {

				// Display trackbacks differently than normal comments.
				case 'pingback' :
				case 'trackback' :
					?>

					<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
					<p><?php esc_html_e( 'Pingback:', 'velvet' ); ?><?php comment_author_link(); ?><?php edit_comment_link( esc_html__( '(Edit)', 'velvet' ), '<span class="edit-link">', '</span>' ); ?></p>

					<?php
					break;

				default :
					// Proceed with normal comments.
					global $post;
					?>
				<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
					<div id="comment-<?php comment_ID(); ?>" class="comment media">
						<div class="comment-author clearfix">
							<?php
								$get_avatar = get_avatar( $comment, apply_filters( 'velvet_post_comment_avatar_size', 80 ) );
								$avatar_img = velvet_get_avatar_url( $get_avatar );
								//Comment author avatar
							?>
							<div class="media-left">
								<img class="avatar" src="<?php echo esc_url( $avatar_img ) ?>" alt="">
							</div>
							<div class="media-body">
								<div class="comment-meta media-heading">
									<h4>
                                        <span class="author-name">
                                            <?php echo get_comment_author(); ?>
                                        </span>
									</h4>
									<time datetime="<?php echo get_comment_date(); ?>">
										<span><?php echo get_comment_date(); ?><?php echo get_comment_time(); ?></span>
									</time>
									<div class="comment-meta">
										<?php comment_reply_link( array_merge( $args, array(
											'reply_text' => '<span class="reply">' . esc_html__( 'REPLY', 'velvet' ) . '</span>',
											'depth'      => $depth,
											'max_depth'  => $args[ 'max_depth' ]
										) ) ); ?>

										<?php edit_comment_link( esc_html__( 'Edit', 'velvet' ), '<span class="edit-link">', '</span>' ); //edit link
										?>
									</div>

								</div>

								<?php if ( '0' == $comment->comment_approved ) { //Comment moderation ?>
									<div class="alert alert-info">
										<?php esc_html_e( 'Your comment is awaiting moderation.', 'velvet' ); ?>
									</div>
								<?php } ?>

								<div class="comment-content">
									<?php comment_text(); //Comment text
									?>
								</div>
								<!-- .comment-content -->


							</div>
						</div>
					</div>
					<!-- #comment-## -->
					<?php
					break;
			} // end comment_type check

		}

	endif;

	//----------------------------------------------------------------------
	// Search form
	//----------------------------------------------------------------------

	if ( ! function_exists( 'velvet_blog_search_form' ) ) :

		function velvet_blog_search_form( $form ) {

			$GLOBALS[ 'form' ] = $form;
			ob_start();
			get_template_part( 'template-parts/blog-search-form' );

			return ob_get_clean();
		}

		add_filter( 'get_search_form', 'velvet_blog_search_form' );
	endif;

	//----------------------------------------------------------------------
	// Fetching Avatar URL
	//----------------------------------------------------------------------

	if ( ! function_exists( 'velvet_get_avatar_url' ) ) :

		function velvet_get_avatar_url( $get_avatar ) {
			preg_match( "/src='(.*?)'/i", $get_avatar, $matches );

			return esc_url( $matches[ 1 ] );
		}
	endif;

	//----------------------------------------------------------------------
	// Excerpt support in page
	//----------------------------------------------------------------------

	if ( ! function_exists( 'velvet_custom_excerpt_page' ) ) :

		function velvet_custom_excerpt_page() {
			add_post_type_support( 'page', 'excerpt' );
			add_post_type_support( 'portfolio', 'excerpt' );
		}

		//add_action( 'init', 'velvet_custom_excerpt_page' );
	endif;

	//----------------------------------------------------------------------
	// Previous Item Featured Image
	//----------------------------------------------------------------------

	if ( ! function_exists( 'velvet_get_previous_featured_image' ) ) :

		function velvet_get_previous_featured_image( $size = 'thumbnail' ) {
			$post = get_previous_post();

			if ( ! empty( $post ) ) {
				$id = $post->ID;
				if ( has_post_thumbnail() ) {
					return get_the_post_thumbnail( $id, $size );
				}
			}
		}
	endif;

	//----------------------------------------------------------------------
	// Next Item Featured Image
	//----------------------------------------------------------------------

	if ( ! function_exists( 'velvet_get_next_featured_image' ) ) :
		function velvet_get_next_featured_image( $size = 'thumbnail' ) {
			$post = get_next_post();
			if ( ! empty( $post ) ) {
				$id = $post->ID;
				if ( has_post_thumbnail() ) {
					return get_the_post_thumbnail( $id, $size );
				}
			}
		}
	endif;


	//----------------------------------------------------------------------
	// Get Default Custom Logo
	//----------------------------------------------------------------------

	if ( ! function_exists( 'velvet_get_default_logo' ) ) :

		function velvet_get_default_logo( $html = '' ) {

			if ( empty( $html ) ) :

				$html = sprintf( '<a href="%1$s" class="custom-logo-link" rel="home" itemprop="url">%2$s</a>',
				                 esc_url( home_url( '/' ) ),
				                 '<img class="custom-logo"
							src="' . esc_url( get_template_directory_uri() . '/img/logo.png' ) . '"
							alt="' . esc_attr( get_bloginfo( 'name' ) ) . '"/>'
				);

			endif;

			return $html;

		}

		add_filter( 'get_custom_logo', 'velvet_get_default_logo' );
	endif;

	//----------------------------------------------------------------------
	// Custom Logo Option
	//----------------------------------------------------------------------

	if ( ! function_exists( 'velvet_custom_logo' ) ) :

		function velvet_custom_logo() {
			if ( function_exists( 'the_custom_logo' ) ) :
				the_custom_logo();
			else:
				echo velvet_get_default_logo();
			endif;
		}
	endif;
