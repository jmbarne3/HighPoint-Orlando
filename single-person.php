<?php get_header(); the_post(); ?>

<article class="<?php echo $post->post_status; ?> post-list-item">
	<div class="container mt-4 mt-sm-5 mb-5 pb-sm-4">
        <div class="row">
            <aside class="col-12 col-sm-4 col-md-3">
                <?php if ( $post->person_portrait ) : ?>
                    <div class="card mb-2">
                        <img src="<?php echo wp_get_attachment_image_src( $post->person_portrait, 'medium' )[0]; ?>" class="card-img-top">
                        <?php if ( $post->person_title ) : ?>
                        <div class="card-body">
                            <p class="card-text text-center"><?php echo $post->person_title; ?></p>
                        </div>
                        <?php endif; ?>
                        <?php if ( $post->person_twitter_profile ) : ?>
                        <div class="card-footer p-1">
                            <a href="<?php echo $post->person_twitter_profile; ?>" target="_blank" class="btn btn-info btn-block">
                                <span class="fa fa-twitter mr-2"></span> Follow on Twitter
                            </a>
                        </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </aside>
            <div class="col-12 col-sm-8 col-md-9">
                <?php the_content(); ?>
            </div>
        </div>
	</div>
</article>

<?php get_footer(); ?>
