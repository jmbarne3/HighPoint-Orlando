<?php
/**
 * Handle all theme configuration here
 **/

define( 'HPO_THEME_URL', get_template_directory_uri() );
define( 'HPO_THEME_STATIC_URL', HPO_THEME_URL . '/static' );
define( 'HPO_THEME_CSS_URL', HPO_THEME_STATIC_URL . '/css' );
define( 'HPO_THEME_JS_URL', HPO_THEME_STATIC_URL . '/js' );
define( 'HPO_THEME_IMG_URL', HPO_THEME_STATIC_URL . '/img' );
define( 'HPO_THEME_CUSTOMIZER_PREFIX', 'HPO_' );
define( 'HPO_THEME_CUSTOMIZER_DEFAULTS', serialize( array(
	'person_thumbnail' => HPO_THEME_STATIC_URL . '/img/person-no-photo.png'
) ) );


/**
 * Initialization functions to be fired early when WordPress loads the theme.
 */
function hpo_init() {
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
	add_theme_support( 'title-tag' );

	add_image_size( 'header-img', 575, 575, true );
	add_image_size( 'header-img-sm', 767, 500, true );
	add_image_size( 'header-img-md', 991, 500, true );
	add_image_size( 'header-img-lg', 1199, 500, true );
	add_image_size( 'header-img-xl', 1600, 500, true );
	add_image_size( 'bg-img', 575, 2000, true );
	add_image_size( 'bg-img-sm', 767, 2000, true );
	add_image_size( 'bg-img-md', 991, 2000, true );
	add_image_size( 'bg-img-lg', 1199, 2000, true );
	add_image_size( 'bg-img-xl', 1600, 2000, true );

	register_nav_menu( 'header-menu', __( 'Header Menu' ) );

	register_sidebar( array(
		'name'          => __( 'Footer - Column 1' ),
		'id'            => 'footer-col-1',
		'description'   => 'First column in the site footer, on the bottom of pages.',
		'before_widget' => '<div id="%1$s" class="widget mb-5 %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="h6 heading-underline letter-spacing-3">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer - Column 2' ),
		'id'            => 'footer-col-2',
		'description'   => 'Second column in the site footer, on the bottom of pages.',
		'before_widget' => '<div id="%1$s" class="widget mb-5 %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="h6 heading-underline letter-spacing-3">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer - Column 3' ),
		'id'            => 'footer-col-3',
		'description'   => 'Third column in the site footer, on the bottom of pages.',
		'before_widget' => '<div id="%1$s" class="widget mb-5 %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="h6 heading-underline letter-spacing-3">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer - Column 4' ),
		'id'            => 'footer-col-4',
		'description'   => 'Last column in the site footer, on the bottom of pages.',
		'before_widget' => '<div id="%1$s" class="widget mb-5 %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="h6 heading-underline letter-spacing-3">',
		'after_title'   => '</h2>',
	) );
}

add_action( 'after_setup_theme', 'hpo_init' );


/**
 * Defines sections used in the WordPress Customizer.
 */
function hpo_define_customizer_sections( $wp_customize ) {
	$wp_customize->add_section(
		HPO_THEME_CUSTOMIZER_PREFIX . 'nav_settings',
		array(
			'title' => 'Navigation Settings',
			'panel' => 'nav_menus'
		)
	);

	$wp_customize->add_section(
		HPO_THEME_CUSTOMIZER_PREFIX . 'webfonts',
		array(
			'title' => 'Web Fonts'
		)
	);

	$wp_customize->add_section(
		HPO_THEME_CUSTOMIZER_PREFIX . 'analytics',
		array(
			'title' => 'Analytics'
		)
	);

	$wp_customize->add_section(
		HPO_THEME_CUSTOMIZER_PREFIX . 'social',
		array(
			'title' => 'Social'
		)
	);
}

add_action( 'customize_register', 'hpo_define_customizer_sections' );


/**
 * Defines settings and controls used in the WordPress Customizer.
 */
function hpo_define_customizer_fields( $wp_customize ) {
	// Menus
	$wp_customize->add_setting(
		'navbar_brand_logo'
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'navbar_brand_logo',
			array(
				'label'       => 'Navbar Brand Logo',
				'description' => 'Image that appears in the header navbar.',
				'section'     => HPO_THEME_CUSTOMIZER_PREFIX . 'nav_settings'
			)
		)
	);

	// Analytics
	$wp_customize->add_setting(
		'gw_verify'
	);

	$wp_customize->add_control(
		'gw_verify',
		array(
			'type'        => 'text',
			'label'       => 'Google WebMaster Verification',
			'description' => 'Example: <em>9Wsa3fspoaoRE8zx8COo48-GCMdi5Kd-1qFpQTTXSIw</em>',
			'section'     => HPO_THEME_CUSTOMIZER_PREFIX . 'analytics'
		)
	);

	$wp_customize->add_setting(
		'gtm_id'
	);

	$wp_customize->add_control(
		'gtm_id',
		array(
			'type'        => 'text',
			'label'       => 'Google Tag Manager Container ID',
			'description' => 'Example: <em>GTM-XXXX</em>.<br>Takes precedence over a Google Analytics Account value below if both are provided (assumes Google Analytics is included as a tag in your Google Tag Manager container).',
			'section'     => HPO_THEME_CUSTOMIZER_PREFIX . 'analytics'
		)
	);

	$wp_customize->add_setting(
		'ga_account'
	);

	$wp_customize->add_control(
		'ga_account',
		array(
			'type'        => 'text',
			'label'       => 'Google Analytics Account',
			'description' => 'Example: <em>UA-9876543-21</em>.<br>Leave blank for development, or if you\'ve provided a Google Tag Manager Container ID and include Google Analytics via Google Tag Manager.',
			'section'     => HPO_THEME_CUSTOMIZER_PREFIX . 'analytics'
		)
	);

	$wp_customize->add_setting(
		'chartbeat_uid'
	);

	$wp_customize->add_control(
		'chartbeat_uid',
		array(
			'type'        => 'text',
			'label'       => 'Chartbeat UID',
			'description' => 'Example: <em>1842</em>',
			'section'     => HPO_THEME_CUSTOMIZER_PREFIX . 'analytics'
		)
	);

	$wp_customize->add_setting(
		'chartbeat_domain'
	);

	$wp_customize->add_control(
		'chartbeat_domain',
		array(
			'type'        => 'text',
			'label'       => 'Chartbeat Domain',
			'description' => 'Example: <em>some.domain.com</em>',
			'section'     => HPO_THEME_CUSTOMIZER_PREFIX . 'analytics'
		)
	);

	/**
	 * Social settings and controls
	 */
	$wp_customize->add_setting(
		'twitter_url'
	);

	$wp_customize->add_control(
		'twitter_url',
		array(
			'type'        => 'url',
			'label'       => 'Twitter URL',
			'description' => 'The URL to a Twitter profile. Used in the navbar.',
			'section'     => HPO_THEME_CUSTOMIZER_PREFIX . 'social'
		)
	);

	$wp_customize->add_setting(
		'facebook_url'
	);

	$wp_customize->add_control(
		'facebook_url',
		array(
			'type'        => 'url',
			'label'       => 'Facebook URL',
			'description' => 'The URL to a Facebook profile. Used in the navbar.',
			'section'     => HPO_THEME_CUSTOMIZER_PREFIX . 'social'
		)
	);

	$wp_customize->add_setting(
		'youtube_url'
	);

	$wp_customize->add_control(
		'youtube_url',
		array(
			'type'        => 'url',
			'label'       => 'YouTube URL',
			'description' => 'The URL to a YouTube profile. Used in the navbar.',
			'section'     => HPO_THEME_CUSTOMIZER_PREFIX . 'social'
		)
	);
}

add_action( 'customize_register', 'hpo_define_customizer_fields' );


/**
 * Allow extra file types to be uploaded to the media library.
 **/
function hpo_custom_mimes( $mimes ) {
	$mimes['svg'] = 'image/svg+xml';
	$mimes['json'] = 'application/json';

	return $mimes;
}

add_filter( 'upload_mimes', 'hpo_custom_mimes' );


/**
 * Enable TinyMCE formatting options in the Athena Shortcodes plugin.
 **/
if ( function_exists( 'athena_sc_tinymce_init' ) ) {
	add_filter( 'athena_sc_enable_tinymce_formatting', '__return_true' );
}


/**
 * Allow special tags in post bodies that would get stripped otherwise for most users.
 * Modifies $allowedposttags defined in wp-includes/kses.php
 *
 * http://wordpress.org/support/topic/div-ids-being-stripped-out
 * http://wpquicktips.wordpress.com/2010/03/12/how-to-change-the-allowed-html-tags-for-wordpress/
 **/
$allowedposttags['input'] = array(
	'type' => array(),
	'value' => array(),
	'id' => array(),
	'name' => array(),
	'class' => array()
);
$allowedposttags['select'] = array(
	'id' => array(),
	'name' => array()
);
$allowedposttags['option'] = array(
	'id' => array(),
	'name' => array(),
	'value' => array()
);
$allowedposttags['iframe'] = array(
	'type' => array(),
	'value' => array(),
	'id' => array(),
	'name' => array(),
	'class' => array(),
	'src' => array(),
	'height' => array(),
	'width' => array(),
	'allowfullscreen' => array(),
	'frameborder' => array()
);
$allowedposttags['object'] = array(
	'height' => array(),
	'width' => array()
);

$allowedposttags['param'] = array(
	'name' => array(),
	'value' => array()
);

$allowedposttags['embed'] = array(
	'src' => array(),
	'type' => array(),
	'allowfullscreen' => array(),
	'allowscriptaccess' => array(),
	'height' => array(),
	'width' => array()
);
// Most of these attributes aren't actually valid for some of
// the tags they're assigned to, but whatever:
$allowedposttags['div'] =
$allowedposttags['a'] =
$allowedposttags['button'] = array(
	'id' => array(),
	'class' => array(),
	'style' => array(),
	'width' => array(),
	'height' => array(),

	'align' => array(),
	'aria-hidden' => array(),
	'aria-labelledby' => array(),
	'autofocus' => array(),
	'dir' => array(),
	'disabled' => array(),
	'form' => array(),
	'formaction' => array(),
	'formenctype' => array(),
	'formmethod' => array(),
	'formonvalidate' => array(),
	'formtarget' => array(),
	'hidden' => array(),
	'href' => array(),
	'name' => array(),
	'rel' => array(),
	'rev' => array(),
	'role' => array(),
	'target' => array(),
	'type' => array(),
	'title' => array(),
	'value' => array(),

	// Bootstrap JS stuff:
	'data-dismiss' => array(),
	'data-toggle' => array(),
	'data-target' => array(),
	'data-backdrop' => array(),
	'data-spy' => array(),
	'data-offset' => array(),
	'data-animation' => array(),
	'data-html' => array(),
	'data-placement' => array(),
	'data-selector' => array(),
	'data-title' => array(),
	'data-trigger' => array(),
	'data-delay' => array(),
	'data-content' => array(),
	'data-offset' => array(),
	'data-offset-top' => array(),
	'data-loading-text' => array(),
	'data-complete-text' => array(),
	'autocomplete' => array(),
	'data-parent' => array(),
);


/**
 * Remove paragraph tag from excerpts
 **/
remove_filter( 'the_excerpt', 'wpautop' );


/**
 * Kill attachment pages, author pages, daily archive pages, search, and feeds.
 *
 * http://betterwp.net/wordpress-tips/disable-some-wordpress-pages/
 **/
function hpo_kill_unused_templates() {
	global $wp_query, $post;

	if ( is_author() || is_attachment() || is_date() || is_search() || is_feed() ) {
		wp_redirect( home_url() );
		exit();
	}
}

add_action( 'template_redirect', 'hpo_kill_unused_templates' );


/**
 * Disable widgets that aren't supported by this theme.
 */
function hpo_kill_unused_widgets() {
	unregister_widget( 'WP_Widget_Archives' );
	unregister_widget( 'WP_Widget_Meta' );
	unregister_widget( 'WP_Widget_Tag_Cloud' );
	unregister_widget( 'WP_Widget_Recent_Comments' );
	unregister_widget( 'WP_Widget_Search' );
	unregister_widget( 'WP_Widget_Calendar' );
	unregister_widget( 'WP_Widget_Media_Gallery' );
}

add_action( 'widgets_init', 'hpo_kill_unused_widgets' );
