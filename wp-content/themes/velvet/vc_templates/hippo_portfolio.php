<?php

	defined( 'ABSPATH' ) or die( 'Keep Silent' );

	$attributes = vc_map_get_attributes( $this->getShortcode(), $atts );

	ob_start();

	$taxonomy  = 'portfolio-type';
	$tax_terms = get_terms( $taxonomy );

	$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $attributes[ 'css' ], ' ' ), $this->settings[ 'base' ], $atts );

?>

	<div class="portfolio-wrap portfolio-standard <?php echo esc_attr( $attributes[ 'el_class' ] . ' ' . $css_class ); ?>">
		<div class="row <?php echo esc_attr( $attributes[ 'gird_space' ] ); ?>">

				<?php
					$args = array(
						'post_type'      => 'portfolio',
						'posts_per_page' => $attributes[ 'post_limit' ],
						'post_status'    => 'publish',
						'orderby'=>'menu_order',
						'order'=>'ASC'
					);

					$the_query = new WP_Query( $args );
				?>

				<?php if ( $the_query->have_posts() ) : ?>

					<?php while ( $the_query->have_posts() ) : $the_query->the_post();
						$terms = wp_get_post_terms( get_the_ID(), 'portfolio-type' );
						$term  = array();

						foreach ( $terms as $t ) :
							$term[] = '"' . $t->slug . '"';
						endforeach; ?>

						<?php $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'velvet-portfolio' ); ?>
						<div
							class="<?php echo esc_attr( $attributes[ 'grid_column' ] . ' ' . $attributes[ 'gird_space' ] ); ?> col-sm-6 col-xs-12">
							<div class="portfolio-item" data-groups='[<?php echo implode( ',', $term ); ?>]'
							     style="background: url(<?php echo esc_url( $large_image_url[ 0 ] ); ?>) no-repeat ; background-size: cover;">

								<?php if ( has_post_thumbnail() ) : ?>
									<a class="element-link" href="<?php the_permalink(); ?>">
										<div class="content-wrapper">
											<h3><?php the_title(); ?></h3>
											<p>
												<?php
													$words_limit = $attributes[ 'word_limit' ];
													$content     = get_the_content();
													echo wp_trim_words( $content, $words_limit );
												?>
											</p>
										</div>
									</a>
								<?php endif; ?>
							</div> <!-- .portfolio-item -->
						</div>
					<?php endwhile; ?>

					<?php wp_reset_postdata(); ?>

				<?php else : ?>
					<p><?php _e( 'Sorry, no posts matched your criteria.', 'velvet' ); ?></p>
				<?php endif; ?>
		</div> <!-- .row -->
	</div> <!-- /.portfolio-wrap -->
<?php
	echo $this->endBlockComment( $this->getShortcode() );
	echo ob_get_clean();