<?php
/**
 * Handles admin functions
 */
function hpo_enqueue_admin_assets( $stylesheets ) {
    //add_editor_style( 'static/css/editor.min.css' );
}

add_action( 'admin_init', 'hpo_enqueue_admin_assets' );
