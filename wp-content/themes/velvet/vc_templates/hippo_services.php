<?php

	defined( 'ABSPATH' ) or die( 'Keep Silent' );

	$attributes = vc_map_get_attributes( $this->getShortcode(), $atts );

	ob_start();

	$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $attributes[ 'css' ], ' ' ), $this->settings[ 'base' ], $atts );

	$link     = vc_build_link( $attributes[ 'custom_link' ] );
	$a_href   = $link[ 'url' ];
	$a_title  = $link[ 'title' ];
	$a_target = trim( $link[ 'target' ] );

	$target = "";
	$title  = "";

	if ( $a_target ) :
		$target = 'target=' . $a_target . '';
	endif;

	if ( $a_title ) :
		$title = 'title=' . $a_title . '';
	endif;

	// WP_Query arguments
	$args = array(
		'p'           => $attributes[ 'service_post_id' ],
		'post_type'   => 'service',
		'post_status' => 'publish',
	);

	// The Query
	$query = new WP_Query( $args );
	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();

			?>

			<div class="hippo-service-wrapper <?php echo esc_attr( $attributes[ 'el_class' ] . ' ' . $css_class ); ?>">
				<?php if ( has_post_thumbnail() ) :
					if ( $attributes[ 'custom_link_show' ] == 'yes' && $attributes[ 'custom_link' ] ) : ?>
						<a href="<?php echo esc_url( $a_href ); ?>" <?php echo esc_attr( $title ); ?> <?php echo esc_attr( $target ); ?>><?php the_post_thumbnail( 'velvet-service-thumbnail', array(
								'class' => 'img-responsive',
								'alt'   => get_the_title()
							) ); ?></a>
					<?php else : ?>
						<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'velvet-service-thumbnail', array(
								'class' => 'img-responsive',
								'alt'   => get_the_title()
							) ); ?></a>
					<?php endif;
				endif; ?>

				<h3 class="service-title">
					<?php if ( $attributes[ 'custom_link_show' ] == 'yes' && $attributes[ 'custom_link' ] ) { ?>
						<a href="<?php echo esc_url( $a_href ); ?>" <?php echo esc_attr( $title ); ?> <?php echo esc_attr( $target ); ?>><?php the_title(); ?></a>
					<?php } else { ?>
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					<?php } ?>
				</h3>
				<div class="service-content">
					<p><?php
							$words_limit = $attributes[ 'word_limit' ];
							if ( ! has_excerpt() ) {
								$content     = get_the_content();
							} else {
								$content     = get_the_excerpt();
							}
							echo wp_trim_words( $content, $words_limit );?></p>

					<?php if ( $attributes[ 'show_readmore_btn' ] == 'yes' ) { ?>
						<div class="service-btn-wrapper">

							<?php if ( $attributes[ 'custom_link_show' ] == 'yes' && $attributes[ 'custom_link' ] ) { ?>
								<a href="<?php echo esc_url( $a_href ); ?>" <?php echo esc_attr( $title ); ?> <?php echo esc_attr( $target ); ?>> <?php echo esc_html( $attributes[ 'change_readmore' ] ) ?>
									&nbsp; <i class="fa fa-angle-right"></i></a>
							<?php } else { ?>
								<a href="<?php the_permalink(); ?>"> <?php echo esc_html( $attributes[ 'change_readmore' ] ) ?>
									&nbsp; <i class="fa fa-angle-right"></i></a>
							<?php } ?>
						</div>
					<?php } ?>
				</div>
			</div> <!-- .hippo-service-wrapper -->
			<?php
		}
	} else {
		echo '<div class="col-md-12">' . __( 'No Service post found.', 'velvet' ) . '</div>';
	}

	wp_reset_postdata();

	echo $this->endBlockComment( $this->getShortcode() );
	echo ob_get_clean();