<?php

	defined( 'ABSPATH' ) or die( 'Keep Silent' );

	$attributes = vc_map_get_attributes( $this->getShortcode(), $atts );

	ob_start();
?>

	<div class="testimonial-carousel <?php echo esc_attr( $attributes[ 'el_class' ] ); ?>">
		<div class="testimonial-items">
			<?php
				$values = (array) vc_param_group_parse_atts( $attributes[ 'testimonial' ] );

				foreach ( $values as $data ) :
					$new_testimoinial                         = $data;
					$new_testimoinial[ 'image' ]              = isset( $data[ 'image' ] ) ? $data[ 'image' ] : '';
					$new_testimoinial[ 'quote_content' ]      = isset( $data[ 'quote_content' ] ) ? $data[ 'quote_content' ] : '';
					$new_testimoinial[ 'client_name' ]        = isset( $data[ 'client_name' ] ) ? $data[ 'client_name' ] : '';
					$new_testimoinial[ 'client_designation' ] = isset( $data[ 'client_designation' ] ) ? $data[ 'client_designation' ] : '';

					if ( isset( $data[ 'title_color' ] ) ) {
						$new_list[ 'title_color' ] = 'color: ' . $data[ 'title_color' ] . ';';
					}

					$testimonial_items[] = $new_testimoinial;

				endforeach;
			?>

			<?php foreach ( $testimonial_items as $testimonial_item ) : ?>
				<div class="item">
					<div class="testimonial-content">
						<?php if ( $testimonial_item[ 'image' ] ) : ?>

							<div class="client-thumb-wrapper">
								<?php $image_attributes = wp_get_attachment_image_src( $testimonial_item[ 'image' ], 'velvet-client-thumbnail' ); ?>
								<img src="<?php echo esc_url( $image_attributes[ 0 ] ); ?>"
								     alt="<?php echo esc_attr( $testimonial_item[ 'client_name' ] ); ?>"/>
							</div><!-- /.client-thumb -->

						<?php endif; ?>

						<div class="quote-wrapper">
							<p><?php
									echo wp_kses( $testimonial_item[ 'quote_content' ], array(
										'strong' => array(),
										'br'     => array(),
										'a'      => array(),
										'b'      => array()
									) );
								?></p>

							<div class="client-info">
							<span
								class="client-name"><?php echo esc_html( $testimonial_item[ 'client_name' ] ); ?></span>
							<span
								class="client-designation"><?php echo esc_html( $testimonial_item[ 'client_designation' ] ); ?></span>
							</div>
						</div>
					</div> <!-- .testimonial-content -->
				</div> <!-- .item -->
			<?php endforeach ?>
		</div>
	</div>
<?php
	echo $this->endBlockComment( $this->getShortcode() );
	echo ob_get_clean();