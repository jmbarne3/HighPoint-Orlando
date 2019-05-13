<?php
get_header();
the_post();

$sidebar = new HPO_Post_Sidebar( $post->ID );

?>

<div class="container mt-4 mt-sm-5 mb-5 pb-sm-4">
    <div class="row">
        <div class="col-12 col-sm-7 col-md-8 col-lg-9">
            <article class="<?php echo $post->post_status; ?> post-list-item">
                <?php the_content(); ?>
            </article>
        </div>
        <div class="col-12 col-sm-5 col-md-4 col-lg-3">
            <aside>
                <!-- Author -->
                <?php if ( $sidebar->author ) : ?>
                <h2 class="h6 text-uppercase">About the Author</h2>
                <?php echo do_shortcode( "[person id='$sidebar->author' layout='thumbnail']" ); ?>
                <?php endif; ?>
                <!-- End Author -->
                <!-- Dynamic Sidebar -->
                <?php if ( is_active_sidebar( 'post_sidebar' ) ) : ?>
                <?php dynamic_sidebar( 'post_sidebar' ); ?>
                <?php endif; ?>
                <!-- End Dynamic Sidebar -->
                <!-- Related Posts -->
                <h2 class="h5 text-uppercase">Related Posts</h2>
                <?php if ( ! empty( $sidebar->related_posts ) ) : ?>
                <ul class="list-unstyled">
                <?php foreach( $sidebar->related_posts as $related_post ) : ?>
                    <li class="list-item">
                        <a href="<?php echo get_permalink( $related_post->ID ); ?>">
                            <?php echo $related_post->post_title; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
                </ul>
                <?php else: ?>
                    <p>There are no related posts to display.</p>
                <?php endif; ?>
                <!-- End Related Posts -->
            </aside>
        </div>
    </div>
</div>

<?php get_footer(); ?>
