<?php
/**
 * Plugin specific filters defined here
 */

if ( ! function_exists( 'hpo_btn_colors' ) ) {
    function hpo_btn_colors( $colors ) {
        if ( ! in_array( 'complimentary', $colors ) ) {
            $colors[] = 'complimentary';
        }

        return $colors;
    }

    add_filter( 'wpbssc_btn_colors', 'hpo_btn_colors', 10, 1 );
}