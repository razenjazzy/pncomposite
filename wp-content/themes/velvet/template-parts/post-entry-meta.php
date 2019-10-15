<?php

	defined( 'ABSPATH' ) or die( 'Keep Silent' );

	global $hide_list;

	do_action( 'velvet_before_post_entry_meta' );
?>

	<ul class="list-inline post-entry-meta">

		<li class="posted-on">
			<?php
				$time_string = '<i class="fa fa-clock-o"></i> %5$s <a href="%7$s"><time class="entry-date published updated" datetime="%1$s">%2$s</time></a>';

				if ( ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) ) {
					$time_string = '<i class="fa fa-clock-o"></i> %5$s <a href="%7$s"><time class="entry-date published" datetime="%1$s">%2$s</time></a>';
					//$time_string .= '<strong>%6$s</strong><a href="%7$s"><time class="updated" datetime="%3$s">%4$s</time></a>';
				}

				printf(
					$time_string,
					esc_attr( get_the_date( 'c' ) ),
					( ( get_the_time( 'U' ) + ( 60 * 60 * 24 * 90 ) ) > current_time( 'timestamp' ) ) ? sprintf( '%s ago', esc_html( human_time_diff( get_the_date( 'U' ), current_time( 'timestamp' ) ) ) ) : get_the_date(),
					esc_attr( get_the_modified_date( 'c' ) ),
					sprintf( '%s ago', esc_html( human_time_diff( get_the_modified_date( 'U' ), current_time( 'timestamp' ) ) ) ),
					esc_html__( 'Published on', 'velvet' ),
					esc_html__( 'Updated on', 'velvet' ),
					esc_url( get_permalink() )
				);
			?>
		</li>

		<li class="reading-time">
			<?php echo velvet_get_min_to_read() ?>
		</li>
		<?php if ( velvet_has_post_read_more() ): ?>
			<li class="read-more"><a href="<?php the_permalink() ?>"><?php esc_html_e( 'Read More', 'velvet' ) ?></a>
			</li>
		<?php endif; ?>
		<?php do_action( 'velvet_post_entry_meta' ); ?>
	</ul>

<?php do_action( 'velvet_after_post_entry_meta' );
