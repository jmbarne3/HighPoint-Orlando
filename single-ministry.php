<?php get_header(); the_post(); ?>
<article class="<?php echo $post->post_status; ?> post-list-item">
	<div class="container mt-4 mt-sm-5 mb-5 pb-sm-4">
		<div class="row">
			<div class="col-12 col-md-8">
				<?php the_content(); ?>
			</div>
			<aside class="col-12 col-md-4">
				<?php
				if ( $post->ministry_meeting_times ) :
					echo apply_filters( 'the_content', $post->ministry_meeting_times );
				endif;

				if ( $post->ministry_special_event_tag ) :
				?>
				<h2 class="h3 mb-3 text-complimentary">Upcoming Events</h2>
				<?php
					echo do_shortcode( "[events_list tag='$post->ministry_special_event_tag']" );
				endif;

				if ( $post->ministry_leader ) :
				?>
				<h2 class="h3 mb-3 text-complimentary">Ministry Leader</h2>
				<?php
					echo do_shortcode( "[person id='$post->ministry_leader' layout='thumbnail']" );
				endif;
				?>
			</aside>
		</div>
	</div>
</article>

<?php get_footer(); ?>
