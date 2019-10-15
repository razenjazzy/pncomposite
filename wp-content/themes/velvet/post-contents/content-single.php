<?php
	defined( 'ABSPATH' ) or die( 'Keep Silent' );
?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'blog-post-wrapper blog-post-default' ); ?>>

		<header class="entry-header">
			<h2 class="entry-title"><?php the_title(); ?></h2>
			<ul class="list-inline single-entry-meta">
				<?php if ( is_single() and get_the_category_list() ) : ?>
					<li class="post-categories">
						<?php printf( get_the_category_list( esc_html__( ', ', 'velvet' ) ) ); ?>
					</li>
				<?php endif; ?>
				<li class="posted-on">
					<?php
						$time_string = '<a href="%6$s"><time class="entry-date published updated" datetime="%1$s">%2$s</time></a>';

						if ( ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) ) {
							$time_string = '<a href="%6$s"><time class="entry-date published" datetime="%1$s">%2$s</time></a>';
						}

						printf(
							$time_string,
							esc_attr( get_the_date( 'c' ) ),
							( ( get_the_time( 'U' ) + ( 60 * 60 * 24 * 90 ) ) > current_time( 'timestamp' ) ) ? sprintf( '%s ago', esc_html( human_time_diff( get_the_date( 'U' ), current_time( 'timestamp' ) ) ) ) : get_the_date(),
							esc_attr( get_the_modified_date( 'c' ) ),
							sprintf( '%s ago', esc_html( human_time_diff( get_the_modified_date( 'U' ), current_time( 'timestamp' ) ) ) ),
							esc_html__( 'Updated on', 'velvet' ),
							esc_url( get_permalink() )
						);
					?>
				</li>
			</ul>
			<?php if ( has_post_thumbnail() || velvet_post_thumbnail( true ) ) : ?>
				<?php velvet_post_thumbnail(); ?>
			<?php endif; ?>
		</header>
		<!-- .entry-header -->

		<div class="entry-content">
			<?php
				the_content( '<span class="btn btn-default btn-primary readmore">' . esc_html__( 'Read More', 'velvet' ) . '</span>' );
				velvet_link_pages();
			?>
		</div>
		<!-- .entry-content -->
	</article> <!-- #post-## -->
	<div class="clearfix"></div>

<?php if ( get_the_tag_list( '', ' ' ) ) :
	?>
	<div class="single-tagcloud">
		<?php echo get_the_tag_list( '', ' ' ); ?>
	</div>
<?php endif; // End if  ?>

<?php if ( is_single() ) :

	if ( velvet_option( 'post-navigation', false, true ) ) :
		velvet_post_navigation();
	endif;

	if ( get_the_author_meta( 'description' ) ) :
		get_template_part( 'author-bio' );
	endif;

	if ( velvet_option( 'related-post', false, true ) ) :
		velvet_related_posts();
	endif;

endif;