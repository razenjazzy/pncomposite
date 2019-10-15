<?php
	defined( 'ABSPATH' ) or die( 'Keep Silent' );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( "blog-post-wrapper blog-post-default" ); ?>>
	<div class="row">
		<?php if ( has_post_thumbnail() || velvet_post_thumbnail( TRUE ) ) : ?>
			<div class="col-md-4 col-sm-12">
				<a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php velvet_post_thumbnail(); ?></a>
			</div>
			<div class="col-md-8 col-sm-12">
				<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
				<div class="entry-content">
					<?php
						if ( ! has_excerpt() ) {
							the_content( '' );
						} else {
							the_excerpt();
						}

						velvet_link_pages();
					?>
				</div>
				<div class="entry-meta">
					<?php velvet_entry_meta() ?>
				</div>
				<!-- .entry-meta -->
			</div>

		<?php else : ?>

			<div class="col-sm-12">
				<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
				<div class="entry-content">
					<?php
						if ( ! has_excerpt() ) {
							the_content( '' );
						} else {
							the_excerpt();
						}
						velvet_link_pages();
					?>
				</div>
				<div class="entry-meta">
					<?php velvet_entry_meta() ?>
				</div>
				<!-- .entry-meta -->
			</div>
		<?php endif; ?>
	</div><!-- .row -->
</article><!-- #post-## -->