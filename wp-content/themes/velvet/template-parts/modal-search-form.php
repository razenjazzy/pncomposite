<?php
	defined( 'ABSPATH' ) or die( 'Keep Silent' );
?>
<!-- Modal Search Form -->
<i class="icon-close zmdi zmdi-close zmdi-hc-fw"></i>

<div class="header-search-form" itemscope itemtype="http://schema.org/WebSite">
	<meta itemprop="url" content="<?php echo esc_url( home_url( '/' ) ); ?>"/>

	<form itemprop="potentialAction" itemscope itemtype="http://schema.org/SearchAction" method="get"
	      class="search-box-form"
	      action="<?php echo esc_url( home_url( '/' ) ); ?>">

		<div class="form-row">
			<div class="input-field">
				<input required itemprop="query-input" tabindex="-1" autofocus="" type="search" id="topSearch"
				       class="form-control" placeholder="<?php esc_html_e( 'Search post', 'velvet' ) ?>"
				       value="<?php echo get_search_query(); ?>" name="s"/>
				<button class="button" type="submit"><i class="zmdi zmdi-search zmdi-hc-fw"></i></button>
				<meta itemprop="target"
				      content="<?php echo esc_url( home_url( '/' ) ); ?>?s={s}&amp;post_type=post"/>
				<input type="hidden" name="post_type" value="page"/>
			</div>
		</div>
	</form>
</div>
