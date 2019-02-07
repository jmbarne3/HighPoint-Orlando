<?php
/**
 * WYSIWYG Override Functions
 */
if ( ! function_exists( 'hpo_add_style_select' ) ) {
    /**
     * Adds the "Formats" button to the WYSIWYG
     * @author Jim Barnes
     * @since 1.0.0
     * @param array $buttons The button array
     * @return array
     */
    function hpo_add_style_select( $buttons ) {
        array_unshift( $buttons, 'styleselect' );
        array_push( $buttons, 'map-embed' );
        array_push( $buttons, 'directions-button' );
        return $buttons;
    }

    add_filter( 'mce_buttons_2', 'hpo_add_style_select', 10, 1 );
}

if ( ! function_exists( 'hpo_custom_styles' ) ) {
    /**
     * Adds custom styles to the "Formats" dropdown
     * @author Jim Barnes
     * @since 1.0.0
     * @param array $init_array The array of options
     * @return array
     */
    function hpo_custom_styles( $init_array ) {
        $style_formats = array(
            // Headings
            array(
                'title' => 'Headings',
                'items' => hpo_get_heading_styles()
            ),
            array(
                'title' => 'Text Utilities',
                'items' => hpo_get_text_utility_styles()
            ),
            array(
                'title' => 'Colors',
                'items' => hpo_get_color_styles()
            ),
            array(
                'title' => 'Buttons',
                'items' => hpo_get_button_styles()
            ),
            array(
                'title' => 'Badges',
                'items' => hpo_get_badge_styles()
            )
        );

        $init_array['style_formats'] = json_encode( $style_formats );

        // Add support for empty spans
        $init_array['extended_valid_elements'] = 'span[class]';

        return $init_array;
    }

    add_filter( 'tiny_mce_before_init', 'hpo_custom_styles', 10, 1 );
}

if ( ! function_exists( 'hpo_get_heading_styles' ) ) {
    /**
     * Returns heading styles
     * @author Jim Barnes
     * @since 1.0.0
     * @return array
     */
    function hpo_get_heading_styles() {
        $retval = array(
            array(
                'title' => 'Heading Styles',
                'items' => array()
            ),
            array(
                'title' => 'Display Styles',
                'items' => array()
            )
        );

        $headings = array(
            'h1' => 'Heading 1',
            'h2' => 'Heading 2',
            'h3' => 'Heading 3',
            'h4' => 'Heading 4',
            'h5' => 'Heading 5',
            'h6' => 'Heading 6'
        );

        $display = array(
            'display-1' => 'Display 1',
            'display-2' => 'Display 2',
            'display-3' => 'Display 3',
            'display-4' => 'Display 4'
        );

        $selectors = implode( ',', array_keys( $headings ) );

        // Heading Styles
        foreach( $headings as $selector => $title ) {
            $retval[0]['items'][] = array(
                'title'    => $title,
                'selector' => $selectors,
                'classes'  => $selector
            );
        }

        // Display Styles
        foreach( $display as $selector => $title ) {
            $retval[1]['items'][] = array(
                'title'    => $title,
                'selector' => $selectors,
                'classes'  => $selector
            );
        }

        return $retval;
    }
}

if ( ! function_exists( 'hpo_get_color_styles' ) ) {
    /**
     * Returns color styles
     * @author Jim Barnes
     * @since 1.0.0
     * @return array
     */
    function hpo_get_color_styles() {
        $colors = array(
            'primary'       => 'Primary',
            'complimentary' => 'Complimentary',
            'secondary'     => 'Secondary',
            'success'       => 'Success',
            'warning'       => 'Warning',
            'danger'        => 'Danger',
            'info'          => 'Info',
            'light'         => 'Light',
            'dark'          => 'Dark'
        );

        $selectors = '*';

        $retval = array(
            array(
                'title' => 'Text Colors',
                'items' => array()
            )
        );

        // Create text color styles
        foreach( $colors as $class => $title ) {
            $retval[0]['items'][] = array(
                'title'    => $title . ' Text',
                'selector' => $selectors,
                'classes'  => 'text-' . $class
            );
        }

        return $retval;
    }
}

if ( ! function_exists( 'hpo_get_component_styles' ) ) {
    /**
     * Adds button styles
     * @author Jim Barnes
     * @since 1.0.0
     * @return array
     */
    function hpo_get_button_styles() {
        // Define the Sections that will be returned
        $retval = array(
            array(
                'title' => 'Solid Buttons',
                'items' => array()
            ),
            array(
                'title' => 'Outline Buttons',
                'items' => array()
            ),
            array(
                'title' => 'Button Sizes',
                'items' => array()
            ),
        );

        $colors = array(
            'primary'       => 'Primary',
            'complimentary' => 'Complimentary',
            'secondary'     => 'Secondary',
            'success'       => 'Success',
            'warning'       => 'Warning',
            'danger'        => 'Danger',
            'info'          => 'Info',
            'light'         => 'Light',
            'dark'          => 'Dark'
        );

        $sizes = array(
            'sm' => 'Small',
            'md' => 'Medium',
            'lg' => 'Large'
        );

        foreach( $colors as $class => $title ) {
            // Add solid button for this color
            $retval[0]['items'][] = array(
                'title'    => 'Solid ' . $title . ' Button',
                'selector' => 'a,button',
                'classes'  => 'btn btn-' . $class
            );

            // Add outline button for this color
            $retval[1]['items'][] = array(
                'title'    => 'Outline ' . $title . ' Button',
                'selector' => 'a,button',
                'classes'  => 'btn btn-outline-' . $class
            );
        }

        foreach( $sizes as $class => $title ) {
            $retval[2]['items'][] = array(
                'title'    => $title . ' Button',
                'selector' => 'a,button',
                'classes'  => 'btn-' . $class
            );
        }

        return $retval;
    }
}

if ( ! function_exists( 'hpo_get_badge_styles' ) ) {
    /**
     * Adds badge styles
     * @author Jim Barnes
     * @since 1.0.0
     * @return array
     */
    function hpo_get_badge_styles() {
        $retval = array(
            array(
                'title' => 'Badges',
                'items' => array()
            ),
            array(
                'title' => 'Pill Badges',
                'items' => array()
            )
        );

        $colors = array(
            'primary'       => 'Primary',
            'complimentary' => 'Complimentary',
            'secondary'     => 'Secondary',
            'success'       => 'Success',
            'warning'       => 'Warning',
            'danger'        => 'Danger',
            'info'          => 'Info',
            'light'         => 'Light',
            'dark'          => 'Dark'
        );

        $selectors = 'p,a,span';

        foreach( $colors as $class => $title ) {
            $retval[0]['items'][] = array(
                'title'    => $title . ' Badge',
                'inline'   => 'span',
                'selector' => $selectors,
                'classes'  => 'badge badge-' . $class,
                'wrapper'  => false
            );

            $retval[1]['items'][] = array(
                'title'    => $title . ' Pill Badge',
                'inline'   => 'span',
                'selector' => $selectors,
                'classes'  => 'badge badge-pill badge-' . $class,
                'wrapper'  => false
            );
        }

        return $retval;
    }
}

if ( ! function_exists( 'hpo_get_text_utility_styles' ) ) {
    function hpo_get_text_utility_styles() {
        $retval = array(
            array(
                'title' => 'Text Appearance',
                'items' => array()
            ),
            array(
                'title' => 'Font Weight',
                'items' => array()
            ),
            array(
                'title' => 'Font Families',
                'items' => array()
            )
        );

        $appearances = array(
            'text-lowercase'  => 'text lowecase',
            'text-uppercase'  => 'TEXT UPPERCASE',
            'text-capitalize' => 'Text Capitalize'
        );

        $weights = array(
            'font-weight-bold'   => 'Font Bold',
            'font-weight-normal' => 'Font Normal',
            'font-weight-light'  => 'Font Light',
            'font-italic'        => 'Font Italic'
        );

        $families = array(
            'font-family-sans-serif'       => 'Font Sans Serif',
            'font-family-sans-serif-round' => 'Font Sans Serif Round',
            'font-family-condensed'        => 'Font Condensed'
        );

        $selector = '*';

        // Text Appearances
        foreach( $appearances as $class => $title ) {
            $retval[0]['items'][] = array(
                'title'    => $title,
                'selector' => $selector,
                'classes'  => $class
            );
        }

        // Font weights
        foreach( $weights as $class => $title ) {
            $retval[1]['items'][] = array(
                'title'    => $title,
                'selector' => $selector,
                'classes'  => $class
            );
        }

        // Font families
        foreach( $families as $class => $title ) {
            $retval[2]['items'][] = array(
                'title'    => $title,
                'selector' => $selector,
                'classes'  => $class
            );
        }

        return $retval;
    }
}
