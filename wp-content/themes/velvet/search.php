<?php

	defined( 'ABSPATH' ) or die( 'Keep Silent' );

	get_header(); ?>

	<section id="content" class="site-content blog-section search-section">
		<div class="row">
			<?php
				$layout = velvet_option( 'blog-layout', false, 'sidebar-right' );

				$grid_class = 'col-md-12';

				if ( $layout == 'sidebar-right' ) :

					$grid_class = ( is_active_sidebar( 'velvet-blog-sidebar' ) )
						? 'col-md-9 col-sm-8'
						: $grid_class;

				elseif ( $layout == 'sidebar-left' ) :
					$grid_class = ( is_active_sidebar( 'velvet-blog-sidebar' ) )
						? 'col-md-9 col-md-push-3 col-sm-8 col-sm-push-4'
						: $grid_class;
				endif;
			?>

			<div id="primary" class="content-area <?php echo esc_attr( $grid_class ); ?>">

				<main id="main" class="site-main" role="main">

					<?php if ( have_posts() ) : ?>

						<?php /* Start the Loop */ ?>
						<?php while ( have_posts() ) : the_post(); ?>

							<?php
							/* Include the Post-Format-specific template for the content.
							 * If you want to override this in a child theme, then include a file
							 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
							 */
							get_template_part( 'post-contents/content', get_post_format() );
							?>

						<?php endwhile; ?>

						<?php
						// Posts Pagination
						if ( velvet_option( 'blog-page-nav', false, true ) ) :
							velvet_posts_pagination();
						else :
							velvet_posts_navigation();
						endif;
						?>

					<?php else : ?>

						<?php get_template_part( 'post-contents/content', 'none' ); ?>

					<?php endif; ?>
				</main> <!-- #main -->
			</div> <!-- .col -->
			<?php get_sidebar(); ?>
		</div> <!-- .row -->
	</section> <!-- .blog-section -->

<?php get_footer();