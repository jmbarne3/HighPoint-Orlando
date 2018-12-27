<?php
/**
 * Handles admin functions
 */
function hpo_enqueue_admin_assets() {
    add_editor_style( 'static/css/style.min.css' );
}

add_action( 'admin_init', 'hpo_enqueue_admin_assets' );
