<?php
	defined( 'ABSPATH' ) or die( 'Keep Silent' );
?>
	<header class="header header-style-default clearfix">

		<div class="navbar navbar-horizontal">

			<div class="navbar-header">
				<div class="site-logo">
					<?php velvet_custom_logo() ?>
				</div>
			</div>
			<!-- .navbar-header -->
			<div class="header-right-content">
				<div class="search-btn">
					<div class="control" tabindex="1">
						<i class="zmdi zmdi-search zmdi-hc-fw"></i>
					</div>
				</div>

				<div class="mobile-menu-trigger visible-xs-inline-block visible-sm-inline-block pull-right">
					<a class="navbar-toggle" href="#mobile_menu"><i class="zmdi zmdi-menu"></i></a>
				</div>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse">
				<?php wp_nav_menu( apply_filters( 'velvet_wp_nav_menu_header_default', array(
					                   'container'      => FALSE,
					                   'theme_location' => 'primary',
					                   'items_wrap'     => '<ul id="%1$s" class="%2$s nav navbar-nav">%3$s</ul>',
					                   'walker'         => new Velvet_Menu_Walker(),
					                   'fallback_cb'    => 'Velvet_Menu_Walker::fallback'
				                   ) )
				);
				?>
			</div> <!-- .navbar-collapse -->
		</div> <!-- .navbar -->
	</header>

	<!-- Modal Search Form -->
<?php get_template_part( 'template-parts/modal', 'search-form' );
