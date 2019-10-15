<?php

	defined( 'ABSPATH' ) or die( 'Keep Silent' );

	if ( ! is_active_sidebar( 'velvet-blog-sidebar' ) ) {
		return;
	}
?>
<div class="col-md-3 col-md-pull-9 col-sm-4 col-sm-pull-8 left-sidebar">
	<div class="primary-sidebar widget-area" role="complementary">
		<?php dynamic_sidebar( 'velvet-blog-sidebar' ); ?>
	</div>
</div>
