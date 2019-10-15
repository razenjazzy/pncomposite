<?php

	defined( 'ABSPATH' ) or die( 'Keep Silent' );

	get_header(); ?>
	<section id="content" class="site-content blog-section single-section">
		<div class="row">
			<div id="primary" class="content-area col-md-9 col-md-push-3 col-sm-8 col-sm-push-4">
				<main id="main" class="site-main" role="main">
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<?php
							if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

								<?php if ( has_post_thumbnail() || velvet_post_thumbnail( true ) ) : ?>
									<?php velvet_post_thumbnail(); ?>
								<?php endif; ?>
								<div class="service-content">
									<?php the_content( esc_html__( "Read More", 'velvet' ) ); ?>
								</div>

								<?php wp_link_pages( array(
									                     'before'      => '<div class="pagination"><span class="page-links-title">' . esc_html__( 'Pages:', 'velvet' ) . '</span>',
									                     'after'       => '</div>',
									                     'link_before' => '<span>',
									                     'link_after'  => '</span>',
								                     ) ); ?>

							<?php endwhile; // end of the loop. ?>
							<?php else : ?>
								<p><?php echo esc_html_e( 'Post not found !', 'velvet' ); ?></p>
							<?php endif; ?>
					</article> <!-- #post-## -->
				</main><!-- #main -->
			</div><!-- .col -->
			<div class="col-md-3 col-md-pull-9 col-sm-4 col-sm-pull-8 left-sidebar">
				<div class="primary-sidebar widget-area" role="complementary">
					<?php if ( is_active_sidebar( 'velvet-service-sidebar' ) ) :
						dynamic_sidebar( 'velvet-service-sidebar' );
					else:
						dynamic_sidebar( 'velvet-page-sidebar' );
					endif; ?>
				</div>
			</div>
		</div><!-- .row -->
	</section><!-- section -->
<?php get_footer();