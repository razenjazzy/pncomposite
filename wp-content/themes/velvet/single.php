<?php

	defined( 'ABSPATH' ) or die( 'Keep Silent' );

	get_header(); ?>
	<section id="content" class="site-content blog-section single-section">
		<div class="row">
			<?php
				if ( velvet_option( 'velvet-single-post-sidebar', false, true ) ) :

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
					endif; // $layout == 'sidebar-right'

				else :
					$grid_class = 'col-md-12';
				endif; // velvet_option( 'velvet-single-post-sidebar', FALSE, TRUE )

			?>

			<div id="primary" class="content-area <?php echo esc_attr( $grid_class ); ?>">
				<main id="main" class="site-main" role="main">
					<?php
						if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

							<?php get_template_part( 'post-contents/content', 'single' ); ?>

							<?php
							// If comments are open or we have at least one comment, load up the comment template
							if ( comments_open() || get_comments_number() ) :
								comments_template();
							endif;
							?>

						<?php endwhile; // end of the loop. ?>

						<?php else : ?>

							<?php get_template_part( 'post-contents/content', 'none' ); ?>

						<?php endif; ?>
				</main> <!-- #main -->
			</div> <!-- .col -->
			<?php if ( velvet_option( 'velvet-single-post-sidebar', false, true ) ) :
				get_sidebar();
			endif; ?>
		</div><!-- .row -->
	</section><!-- section -->
<?php get_footer();