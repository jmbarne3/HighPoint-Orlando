<?php
/**
 * Footer Related Functions
 **/

/**
 * Returns markup for the site footer. Will return an empty string if all
 * footer sidebars are empty.
 *
 * @author Jo Dickson
 * @since 1.0.0
 * @return string Footer HTML markup
 **/
if ( !function_exists( 'hpo_get_footer_markup' ) ) {
	function hpo_get_footer_markup() {
		ob_start();

		if (
			is_active_sidebar( 'footer' )
		):
	?>
		<footer class="site-footer bg-inverse pt-4 py-md-5">
			<div class="container mt-4">
				<div class="row">

				<?php if ( is_active_sidebar( 'footer-col-1' ) ): ?>
					<section class="col-12 col-lg">
						<?php dynamic_sidebar( 'footer' ); ?>
					</section>
				<?php endif; ?>

				</div>
			</div>
		</footer>
	<?php
		endif;

		return ob_get_clean();
	}
}
