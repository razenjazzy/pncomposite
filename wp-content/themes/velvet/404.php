<?php

	defined( 'ABSPATH' ) or die( 'Keep Silent' );

	get_header(); ?>
	<div id="content" class="site-content">
		<div class="row">
			<div class="col-md-12">
				<div id="primary" class="content-area">
					<main id="main" class="site-main" role="main">
						<div class="error-404 not-found">

							<h1><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'velvet' ); ?></h1>


							<div class="page-content">
								<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'velvet' ); ?></p>

								<?php get_search_form(); ?>

								<p><?php esc_html_e( 'Try using the button below to go to main page of the site', 'velvet' ); ?></p>

								<div class="home-link clearfix">
									<a href="<?php echo esc_url( home_url( '/' ) ); ?>"
									   class="btn btn-primary"><?php esc_html_e( 'Go Back to Home', 'velvet' ); ?></a>
								</div>
							</div>
						</div><!-- .page-notfound -->
					</main><!-- main -->
				</div><!-- #primary -->
			</div><!-- .col-* -->
		</div><!-- .row -->
	</div> <!-- .site-content -->
<?php get_footer();