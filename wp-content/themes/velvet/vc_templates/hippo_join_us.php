<?php

	defined( 'ABSPATH' ) or die( 'Keep Silent' );

	$attributes = vc_map_get_attributes( $this->getShortcode(), $atts );

	$items = (array) vc_param_group_parse_atts( $attributes[ 'items' ] );


	ob_start();
?>
	<div class="hippo-join-us-wrapper <?php echo esc_attr( $attributes[ 'el_class' ] ); ?>">

		<?php if ( wpb_js_remove_wpautop( $content ) ) : ?>
			<div class="info-content"><?php echo wpb_js_remove_wpautop( $content, true ); ?></div>
		<?php endif; ?>

		<ul class="list-inline">
			<?php foreach ( $items as $item ): ?>
				<li class="hippo-join-us-links">
					<a target="_blank" href="<?php echo esc_url( $item[ 'link' ] ) ?>"
					   style="background-color: <?php echo esc_attr( $item[ 'icon_bg_color' ] ); ?>"><i
							class="<?php echo esc_attr( $item[ 'icon' ] ) ?>"></i></a>
				</li>
			<?php endforeach; ?>
		</ul>
		<span class="clearfix"></span>
	</div>
<?php
	echo $this->endBlockComment( $this->getShortcode() );
	echo ob_get_clean();