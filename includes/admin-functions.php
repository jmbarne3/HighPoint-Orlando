<?php
/**
 * Handles admin functions
 */
function hpo_enqueue_admin_assets( $stylesheets ) {
    //add_editor_style( 'static/css/editor.min.css' );
}

add_action( 'admin_init', 'hpo_enqueue_admin_assets' );

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
        <dt><a href="https://fontawesome.com/icons" target="_blank">Font Awesome Icons</a></dt>
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
