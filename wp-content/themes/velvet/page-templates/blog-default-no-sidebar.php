<?php
	/*
	Template Name: Blog Default No Sidebar
	*/

	defined( 'ABSPATH' ) or die( 'Keep Silent' );

	get_header();

	$paged    = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
	$args     = array(
		'posts_per_page' => get_option( 'posts_per_page' ),
		'post_type'      => 'post',
		'post_status'    => 'publish',
		'paged'          => $paged
	);
	$wp_query = new WP_Query( $args );
?>

	<section id="content" class="site-content blog-section blog-no-sidebar">

		<div class="row">
				<div id="primary" class="content-area col-md-12">
					<main id="main" class="site-main" role="main">
						<?php if ( $wp_query->have_posts() ) : ?>
							<?php /* Start the Loop */ ?>
							<?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
								<?php
								/* Include the Post-Format-specific template for the content.
								 * If you want to override this in a child theme, then include a file
								 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
								 */
								get_template_part( 'post-contents/content', get_post_format() );
								?>
							<?php endwhile; ?>
							<div class="pagination-wrap clearfix">
								<?php
									// Posts Pagination
									if ( velvet_option( 'blog-page-nav', FALSE, TRUE ) ) :
										velvet_posts_pagination();
									else :
										velvet_posts_navigation();
									endif; ?>
							</div>
						<?php else : ?>
							<?php get_template_part( 'post-contents/content', 'none' ); ?>
							<?php
						endif;
							wp_reset_postdata();
						?>
					</main>
					<!-- #main -->
				</div>
				<!-- #primary -->
		</div>
		<!-- .row -->

	</section><!-- .blog-section -->
<?php get_footer();