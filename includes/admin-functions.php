<?php
/**
 * Handles admin functions
 */
function hpo_enqueue_editor_assets() {
    add_editor_style( 'static/css/hpo-editor.min.css' );
    add_editor_style( 'https://fonts.googleapis.com/css?family=Montserrat|Open+Sans+Condensed:300|Oswald' );
}

add_action( 'admin_init', 'hpo_enqueue_editor_assets' );

function hpo_enqueue_admin_assets() {
    wp_register_style( 'hpo-tinymce-buttons', get_template_directory_uri() . '/static/css/admin.min.css', false );
    wp_enqueue_style( 'hpo-tinymce-buttons' );
}

add_action( 'admin_enqueue_scripts', 'hpo_enqueue_admin_assets' );

function localize_tinymce_plugins() {
    $google_maps_api_key = get_theme_mod( 'google_maps_key' );
    if ( $google_maps_api_key ) :
?>
    <script type="text/javascript">
    var HPO_CONSTANTS = {
        'google_maps_api_key': '<?php echo $google_maps_api_key; ?>'
    };
    </script>
<?php
    endif;
}

add_action( 'admin_head-post.php', 'localize_tinymce_plugins' );
add_action( 'admin_head-post-new.php', 'localize_tinymce_plugins' );

/**
 * Adds the help screen.
 */
add_action( 'admin_menu', 'add_hpo_theme_help' );

function add_hpo_theme_help() {
    global $hpo_theme_help;
    $hpo_theme_help = add_menu_page( 'Theme Help', 'Theme Help', 'edit_posts', 'hpo-theme-help', 'theme_help', 'dashicons-editor-help', 81 );
}

/**
 * Provides the HTML for the theme help
 */
function theme_help() {
?>
    <h1>HighPoint Orlando Theme Help</h1>
    <dl>
        <dt><a href="https://github.com/jmbarne3/HighPoint-Orlando/wiki/" target="_blank">Theme Documentation</a></dt>
        <dd style="margin-left: .5em;">Documentation specifically written for this theme and site. This is a good starting place, and will include the links below throughout various pages of the documentation.</dd>
        <dt><a href="https://getbootstrap.com/docs/4.0/getting-started/introduction/" target="_blank">Bootstrap 4 Documentation</a></dt>
        <dd style="margin-left: .5em;">This theme uses Bootstrap 4 as its underlying CSS framework, so the Bootstrap 4 documentation is very helpful for finding custom components and layout methods.</dd>
        <dt><a href="https://fontawesome.com/v4.7.0/icons/" target="_blank">Font Awesome Icons</a></dt>
        <dd style="margin-left: .5em;">This theme uses Font-Awesome 5 for icons. An icon can be added to any page by adding the icon shortcode. The full list of icons can be found at the link above.</dd>
        <dt><a href="http://wp-events-plugin.com/documentation/" target="_blank">Events Manager Documentation</a></dt>
        <dd style="margin-left: .5em;">The events content type used on this site is provided by the Events Manager plugin. Full documentation can be found at the link above.</dd>
        <dt><a href="https://contactform7.com/docs/" target="_blank">Contact Form 7 Documentation</a></dt>
        <dd style="margin-left: .5em;">The "Contact Us" form is provided for by the Contact Form 7 plugin. Full documentation can be found at the link above.</dd>
        <dt><a href="https://docs.fooplugins.com/collection/8-foogallery" target="_blank">Foo Galery</a></dt>
        <dd style="margin-left: .5em;">The carousel and gallery functionality is provided by the Foo Gallery plugin. Full documentation can be found at the link above.</dd>
    </dl>
<?php
}

function add_custom_tinymce_plugins( $plugins ) {
    $google_maps_api_key = get_theme_mod( 'google_maps_key' );

    $theme_uri = get_template_directory_uri();
    $plugins['directions-button'] = "$theme_uri/static/js/directions-button.min.js";

    if ( $google_maps_api_key ) {
        $plugins['map-embed'] = "$theme_uri/static/js/map-embed.min.js";
    }

    return $plugins;
}

add_filter( 'mce_external_plugins', 'add_custom_tinymce_plugins' );
