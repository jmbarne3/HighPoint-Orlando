<?php
/**
 * Header Related Functions
 **/

/**
 * Gets the header image for pages and taxonomy terms that have page header
 * images enabled.
 *
 * @author Jo Dickson
 * @since 1.0.0
 * @param object $obj A WP_Post or WP_Term object
 * @return array A set of Attachment IDs, one sized for use on -sm+ screens, and another for -xs
 **/
function hpo_get_header_images( $obj ) {
	$obj_id = hpo_get_object_id( $obj );
	$field_id = hpo_get_object_field_id( $obj );

	$retval = array(
		'header_image'    => '',
		'header_image_xs' => ''
	);

	$retval = (array) apply_filters( 'hpo_get_header_images_before', $retval, $obj );

	if ( $obj_header_image = get_field( 'page_header_image', $field_id ) ) {
		$retval['header_image'] = $obj_header_image;
	}
	if ( $obj_header_image_xs = get_field( 'page_header_image_xs', $field_id ) ) {
		$retval['header_image_xs'] = $obj_header_image_xs;
	}

	$retval = (array) apply_filters( 'hpo_get_header_images_after', $retval, $obj );

	if ( isset( $retval['header_image'] ) && $retval['header_image'] ) {
		return $retval;
	}
	return false;
}


/**
 * Returns texturized title text for use in the page header.
 *
 * @author Jo Dickson
 * @since 1.0.0
 * @param object $obj A WP_Post or WP_Term object
 * @return string Header title text
 **/
 function hpo_get_header_title( $obj ) {
	$field_id = hpo_get_object_field_id( $obj );
	$title = '';

	$title = (string) apply_filters( 'hpo_get_header_title_before', $title, $obj );

	if ( ! $obj ) {
		// We intentionally don't add a fallback title for 404s here;
		// this allows us to add a custom h1 to the default 404 template
		if ( ! is_404() ) {
			$title = get_bloginfo( 'name', 'display' );
		}
	}
	else if ( is_tax() || is_category() || is_tag() ) {
		$title = single_term_title( '', false );
	}
	else if ( $obj instanceof WP_Post ) {
		$title = $obj->post_title;
	}

	// Apply custom header title override, if available
	if ( $custom_header_title = get_field( 'page_header_title', $field_id ) ) {
		$title = do_shortcode( $custom_header_title );
	}

	$title = (string) apply_filters( 'hpo_get_header_title_after', $title, $obj );

	return wptexturize( $title );
}

/**
 * Returns HTML markup for the primary site navigation.  Falls back to the
 * ucf.edu primary navigation if a header menu is not set.
 *
 * @author Jo Dickson
 * @since 1.0.0
 * @param bool $image Whether or not a media background is present in the page header.
 * @return string Nav HTML
 **/
if ( !function_exists( 'hpo_get_nav_markup' ) ) {
	function hpo_get_nav_markup( $image=true ) {
		$title_elem = ( is_home() || is_front_page() ) ? 'h1' : 'span';
		$title = get_brand_heading();

		ob_start();

		if ( has_nav_menu( 'header-menu' ) ) {
	?>
		<nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light" role="navigation">
			<div class="container">
				<<?php echo $title_elem; ?> class="navbar-brand mb-0">
					<a class="navbar-brand" href="<?php echo get_home_url(); ?>"><?php echo $title; ?></a>
				</<?php echo $title_elem; ?>>
				<button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#header-menu" aria-controls="header-menu" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-text">Navigation</span>
					<span class="navbar-toggler-icon"></span>
				</button>
				<?php

				$container_class = '';

				wp_nav_menu( array(
					'container'       => 'div',
					'container_class' => 'collapse navbar-collapse',
					'container_id'    => 'header-menu',
					'depth'           => 2,
					'fallback_cb'     => 'bs4Navwalker::fallback',
					'menu_class'      => 'navbar-nav ml-auto mr-5',
					'theme_location'  => 'header-menu',
					'walker'          => new bs4Navwalker(),
					'items_wrap'      => custom_items_wrap()
				) );
				?>
			</div>
		</nav>
	<?php
		}

		return ob_get_clean();
	}
}

if ( ! function_exists( 'get_brand_heading' ) ) {
	function get_brand_heading() {
		$header_img = get_theme_mod( 'navbar_brand_logo', null );
		$header_img_xs = get_theme_mod( 'navbar_brand_logo_xs', null );

		ob_start();

		if ( $header_img_xs && $header_img ) :
?>
		<picture>
			<source srcset="<?php echo $header_img; ?>" media="(min-width: 576px)">
			<img class="header-logo" src="<?php echo $header_img_xs; ?>" alt="<?php echo bloginfo( 'name' ); ?>">
		</picture>
<?php
		elseif ( $header_img ) :
?>
		<img class="header-logo" src="<?php echo $header_img; ?>" alt="<?php echo bloginfo( 'name' ); ?>">
<?php
		else : echo bloginfo( 'name' );
		endif;

		return ob_get_clean();
	}
}

function custom_items_wrap() {
	ob_start();
?>
	<ul id="%1$s" class="%2$s">%3$s</ul>
	<div class="text-inline">
		<?php echo display_social(); ?>
	</div>
<?php
	return ob_get_clean();
}

function display_social() {
	$twitter_url  = get_theme_mod( 'twitter_url', null );
	$facebook_url = get_theme_mod( 'facebook_url', null );
	$youtube_url  = get_theme_mod( 'youtube_url', null );

	ob_start();
?>
	<ul class="list-inline list-unstyled mb-0">
	<?php if ( $twitter_url ) : ?>
		<li class="social-icon list-inline-item">
			<a href="<?php echo $twitter_url; ?>" target="_blank"><span class="fa fa-twitter"></span> <span class="sr-only">Click to visit our Twitter profile</span></a>
		</li>
	<?php endif; ?>
	<?php if ( $facebook_url ) : ?>
		<li class="social-icon list-inline-item">
			<a href="<?php echo $facebook_url; ?>" target="_blank"><span class="fa fa-facebook"></span> <span class="sr-only">Click to visit our Facebook profile</span></a>
		</li>
	<?php endif; ?>
	<?php if ( $youtube_url ) : ?>
		<li class="social-icon list-inline-item">
			<a href="<?php echo $youtube_url; ?>" target="_blank"><span class="fa fa-youtube"></span> <span class="sr-only">Click to visit our YouTube page</span></a>
		</li>
	<?php endif; ?>
	</ul>
<?php
	return ob_get_clean();
}

/**
 * Returns markup for page header title + subtitles within headers that use a
 * media background.
 *
 * @author Jo Dickson
 * @since 1.0.0
 * @param object $obj A WP_Post or WP_Term object
 * @return string HTML for the page title + subtitle
 **/
if ( !function_exists( 'hpo_get_header_content_title_subtitle' ) ) {
	function hpo_get_header_content_title_subtitle( $obj ) {
		$title         = hpo_get_header_title( $obj );
		$h1_elem       = ( is_home() || is_front_page() ) ? 'h2' : 'h1'; // name is misleading but we need to override this elem on the homepage

		ob_start();

		if ( $title ):
	?>
		<div class="header-content-inner align-self-end pt-4 pt-sm-0 align-self-sm-end">
			<div class="container">
				<div class="d-inline-block float-right">
					<h1 class="header-title"><?php echo $title; ?></h1>
				</div>
			</div>
		</div>
	<?php
		endif;

		return ob_get_clean();
	}
}


/**
 * Returns markup for page header custom content.
 *
 * @author Jo Dickson
 * @since 1.0.0
 * @param object $obj A WP_Post or WP_Term object
 * @return string HTML for the custom page header contents
 **/
if ( !function_exists( 'hpo_get_header_content_custom' ) ) {
	function hpo_get_header_content_custom( $obj ) {
		$field_id = hpo_get_object_field_id( $obj );
		$content = get_field( 'page_header_content', $field_id );

		ob_start();
	?>
		<div class="header-content-inner">
	<?php
		if ( $content ) {
			echo $content;
		}
	?>
		</div>
	<?php
		return ob_get_clean();
	}
}


/**
 * Returns an array of src's for a page header's media background
 * <picture> <source>s, by breakpoint.  Will return a unique set of src's
 * depending on the page's header height.
 *
 * @author Jo Dickson
 * @since 1.0.0
 * @param string $header_height Name of the header's height
 * @param array $images Assoc. array of image size names and attachment IDs (expects a return value from hpo_get_header_images())
 * @return array Assoc. array of breakpoint names and image URLs (see hpo_get_media_background_picture_srcs())
 */
if ( ! function_exists( 'hpo_get_header_media_picture_srcs' ) ) {
	function hpo_get_header_media_picture_srcs( $header_height, $images ) {
		$bg_image_srcs = array();

		switch ( $header_height ) {
			case 'header-media-fullscreen':
				$bg_image_srcs = hpo_get_media_background_picture_srcs( null, $images['header_image'], 'bg-img' );
				$bg_image_src_xs = hpo_get_media_background_picture_srcs( $images['header_image_xs'], null, 'header-img' );

				if ( isset( $bg_image_src_xs['xs'] ) ) {
					$bg_image_srcs['xs'] = $bg_image_src_xs['xs'];
				}

				break;
			default:
				$bg_image_srcs = hpo_get_media_background_picture_srcs( $images['header_image_xs'], $images['header_image'], 'header-img' );
				break;
		}

		return $bg_image_srcs;
	}
}


/**
 * Returns the markup for page headers with media backgrounds.
 *
 * @author Jo Dickson
 * @since 1.0.0
 * @param object $obj A WP_Post or WP_Term object
 * @param array $videos Assoc. array of video Attachment IDs for use in page header media background
 * @param array $images Assoc. array of image Attachment IDs for use in page header media background
 * @return string HTML for the page header
 **/
if ( !function_exists( 'hpo_get_header_media_markup' ) ) {

	function hpo_get_header_media_markup( $obj, $images ) {
		$field_id            = hpo_get_object_field_id( $obj );
		$images              = $images ?: hpo_get_header_images( $obj );
		$header_content_type = get_field( 'page_header_content_type', $field_id );
		$header_height       = get_field( 'page_header_height', $field_id );

		ob_start();
	?>
		<div class="header-media <?php echo $header_height; ?> mb-0 d-flex flex-column">
			<div class="header-media-background-wrap">
				<div class="header-media-background media-background-container">
					<?php
					// Display the media background (video + picture)
					if ( $images ) {
						$bg_image_srcs = hpo_get_header_media_picture_srcs( $header_height, $images );
						echo hpo_get_media_background_picture( $bg_image_srcs );
					}
					?>
				</div>
			</div>

			<?php
			// Display the site nav
				echo hpo_get_nav_markup();
			?>

			<?php
			// Display the inner header contents
			?>
			<div class="header-content">
				<div class="header-content-flexfix">
					<?php
					if ( $header_content_type === 'custom' ) {
						echo hpo_get_header_content_custom( $obj );
					}
					else {
						echo hpo_get_header_content_title_subtitle( $obj );
					}
					?>
				</div>
			</div>
		</div>
	<?php
		return ob_get_clean();
	}
}


/**
 * Returns the default markup for page headers without a media background.
 *
 * @author Jo Dickson
 * @since 1.0.0
 * @param object $obj A WP_Post or WP_Term object
 * @return string HTML for the page header
 **/
if ( !function_exists( 'hpo_get_header_default_markup' ) ) {

	function hpo_get_header_default_markup( $obj ) {
		$title               = hpo_get_header_title( $obj );
		$field_id            = hpo_get_object_field_id( $obj );
		$header_content_type = get_field( 'page_header_content_type', $field_id );
		$exclude_nav         = get_field( 'page_header_exclude_nav', $field_id );
		$h1_elem             = ( is_home() || is_front_page() ) ? 'h2' : 'h1'; // name is misleading but we need to override this elem on the homepage

		$title_classes = 'h1 d-block mt-3 mt-sm-4 mt-md-5 mb-2 mb-md-3';
		$subtitle_classes = 'lead mb-2 mb-md-3';

		ob_start();
	?>
		<?php if ( !$exclude_nav ) { echo hpo_get_nav_markup( false ); } ?>

		<?php
		if ( $header_content_type === 'custom' ):
			echo hpo_get_header_content_custom( $obj );
		elseif ( $title ):
		?>
		<div class="container">
			<h1 class="<?php echo $title_classes; ?>">
				<?php echo $title; ?>
			</h1>
		</div>
		<?php endif; ?>
	<?php
		return ob_get_clean();
	}
}


/**
 * Returns header markup for the current post or term.
 *
 * @author Jo Dickson
 * @since 1.0.0
 * @return string HTML for the page header
 **/
if ( !function_exists( 'hpo_get_header_markup' ) ) {
	function hpo_get_header_markup() {
		$obj = get_queried_object();

		if ( !$obj && is_404() ) {
			$page = get_page_by_title( '404' );
			if ( $page && $page->post_status === 'publish' ) {
				$obj = $page;
			}
		}

		$images = hpo_get_header_images( $obj );

		if ( $videos || $images ) {
			echo hpo_get_header_media_markup( $obj, $images );
		}
		else {
			echo hpo_get_header_default_markup( $obj );
		}
	}
}

