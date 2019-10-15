<?php

	defined( 'ABSPATH' ) or die( 'Keep Silent' );

	$current_page_template = basename( get_page_template_slug() );

	$background_type_class = "title-background-image";
	$title_background      = "";

	if ( velvet_option( 'title-background-type' ) == TRUE ) :
		$title_background = 'background-image: url(' . esc_url( velvet_title_image( 'http://placehold.it/1140x260' ) ) . '); background-size: cover;';
	else :
		$title_background      = 'background-color: ' . velvet_option( 'title-background-color', FALSE, '#555353' );
		$background_type_class = "title-background-color";
	endif;

	if ( is_page() and ! in_array( $current_page_template, velvet_home_page_templates() ) ) : ?>
		<div class="page-title-section <?php echo esc_attr( $background_type_class ); ?>"
		     style="<?php echo esc_attr( $title_background ); ?>">
			<div class="row">
				<div class="col-md-12">
					<div class="custom-page-header">
						<div class="page-header">
							<h1><?php echo velvet_title_text(); ?></h1>
						</div> <!-- .page-header -->
					</div> <!-- .custom-page-header -->
				</div> <!-- .col-## -->
			</div> <!-- .row -->
		</div> 
	<?php endif; ?>

<?php if ( ! is_page() ) : ?>
	<div class="page-title-section <?php echo esc_attr( $background_type_class ); ?>"
	     style="<?php echo esc_attr( $title_background ); ?>">
		<div class="row">
			<div class="col-md-12">
				<div class="custom-page-header">
					<div class="page-header">
						<h1><?php echo wp_kses( velvet_title_text(), array(
								'strong' => array(),
								'span'   => array()
							) ); ?></h1>
					</div><!-- .page-header -->
				</div><!-- .custom-page-header -->
			</div><!-- .col-## -->
		</div><!-- .row -->
	</div>
<?php endif;