<?php
	defined( 'ABSPATH' ) or die( 'Keep Silent' );
?>

<?php $post_tag = wp_get_object_terms( get_the_ID(), 'post_tag', array( 'fields' => 'ids' ) );

	// arguments
	$args         = array(
		'post_type'      => 'post',
		'post_status'    => 'publish',
		'posts_per_page' => 3,
		'tax_query'      => array(
			array(
				'taxonomy' => 'post_tag',
				'field'    => 'id',
				'terms'    => $post_tag
			)
		),
		'post__not_in'   => array( get_the_ID() ),
		'meta_query'     => array(
			array( 'key' => '_thumbnail_id' )
		)
	);
	$related_post = new WP_Query( $args ); ?>

<?php if ( $related_post->have_posts() ) : ?>
	<div class="related-post-wrap clearfix">

		<?php if ( velvet_option( 'related-post-heading' ) ) : ?>
			<h3><?php echo velvet_option( 'related-post-heading' ); ?></h3>
		<?php endif; ?> <!-- related-post-heading -->

		<div class="row">
			<?php while ( $related_post->have_posts() ) : $related_post->the_post(); ?>
				<div class="col-sm-4">
					<div class="related-post">
						<?php if ( has_post_thumbnail() ) : ?>
							<a href="<?php the_permalink(); ?>">
								<?php if ( get_the_post_thumbnail() ) : ?>
									<?php echo get_the_post_thumbnail( get_the_ID(), 'velvet-related-post-thumbnail', array(
										'class' => 'img-responsive',
										'alt'   => get_the_title()
									) );
									?>
								<?php else :
									$placeholder = 'http://placehold.it/1140x600';
									echo '<img src="' . $placeholder . '" class="img-responsive wp-post-image" alt="' . wp_kses( get_the_title(), array() ) . '">';

								endif; ?>
							</a>
						<?php endif; ?>
						<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
					</div>
				</div>
			<?php endwhile; ?>
		</div> <!-- .row -->
	</div> <!-- .related-post-wrap -->
<?php endif; ?>
<?php wp_reset_postdata(); ?>
<!-- .blog-pagination -->