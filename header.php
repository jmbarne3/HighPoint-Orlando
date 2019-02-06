<!DOCTYPE html>
<html lang="en-us">
	<head>
		<?php wp_head(); ?>
	</head>
	<body ontouchstart <?php body_class(); ?>>
		<a class="skip-navigation bg-complementary text-inverse box-shadow-soft" href="#content">Skip to main content</a>
		<?php do_action( 'after_body_open' ); ?>

		<header class="site-header<?php echo hpo_get_header_classes(); ?>">
			<?php echo hpo_get_header_markup(); ?>
		</header>

		<main class="site-main">
			<div class="site-content" id="content" tabindex="-1">
