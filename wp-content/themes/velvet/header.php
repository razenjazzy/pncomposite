<?php

defined( 'ABSPATH' ) or die( 'Keep Silent' );

?><!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php echo esc_url( get_bloginfo( 'pingback_url' ) ); ?>">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div class="wrapper" id="wrapper">
	<?php do_action( 'hippo_theme_before_inner_wrapper' ); ?>
	<?php do_action( 'velvet_theme_before_inner_wrapper' ); ?>

	<div class="inner-wrapper pusher">

		<?php do_action( 'hippo_theme_start_inner_wrapper' ); ?>
		<?php do_action( 'velvet_theme_start_inner_wrapper' ); ?>

		<?php if ( velvet_option( 'show-preloader', FALSE, FALSE ) ): ?>
			<div id="page-pre-loader" class="page-pre-loader-wrapper">
				<div class="page-pre-loader">
					<svg width="50" height="50" class="circular" viewBox="0 0 50 50">
						<circle class="path" cx="25" cy="25" r="20"></circle>
					</svg>
				</div>
			</div> <!-- #page-pre-loader -->
		<?php endif; ?>

		<div class="container-wrapper">
			<div class="container">
				<div class="contents">
<?php
	get_header( 'default' );
	get_header( 'page' );
