<?php
/**
 * Additional layout for persons
 */
if ( ! function_exists( 'hpo_person_thumbnail_layout' ) ) {
    function hpo_person_thumbnail_layout( $output, $person, $args ) {
        $name_element = $args['name_element'];

        ob_start();
    ?>
        <div class="card mb-4">
            <?php if ( $person->person_portrait ) : ?>
                <img class="card-img-top" src="<?php echo wp_get_attachment_image_src( $person->person_portrait, 'medium' )[0]; ?>">
            <?php endif; ?>
            <div class="card-body">
                <<?php echo $name_element; ?> class="card-title"><?php echo $person->post_title; ?></<?php echo $name_element; ?>>
                <p class="text-primary text-uppercase font-family-condensed font-weight-bold"><?php echo $person->person_title; ?></p>
            </div>
            <div class="card-footer">
                <a href="<?php echo get_permalink( $person->ID ); ?>" class="btn btn-complimentary btn-block">Read More</a>
            </div>
        </div>
    <?php
        return ob_get_clean();
    }

    add_filter( 'jmb_display_person_thumbnail', 'hpo_person_thumbnail_layout', 10, 3 );
}