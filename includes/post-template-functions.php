<?php
/**
 * Functions for the post template
 */
if ( ! class_exists( 'HPO_Post_Sidebar' ) ) {
    /**
     * Class that handles outputting sidebar content.
     */
    class HPO_Post_Sidebar {
        #region Private Field Region
        private
            $post_id,
            $posts_per_page,
            $category_ids,
            $tag_ids;

#endregion

        #region Public Field Region

        public
            $author,
            $is_user = false,
            $related_posts;

        #endregion

        #region Constructor Region

        /**
         * Instantiates the HPO_Post_Sidebar object
         * @author Jim Barnes
         * @since 1.0.4
         * @param int $post_id The id of the post
         */
        public function __construct( $post_id, $posts_per_page = 5 ) {
            $this->post_id        = $post_id;
            $this->posts_per_page = $posts_per_page;
            $this->author         = $this->get_author_id();
            $this->related_posts  = $this->get_related_posts();
        }

        #endregion

        #region Helper Functions

        /**
         * Returns author of the post
         * @author Jim Barnes
         * @since 1.0.4
         * @return int The author ID.
         */
        private function get_author_id() {
            $retval = get_field( 'post_author', $this->post_id );

            if ( $retval ) {
                return $retval;
            }

            $this->is_user = true;

            return get_post_field( 'post_author', $this->post_id );
        }

        /**
         * Returns the ids of the categories the post is assigned to
         * @author Jim Barnes
         * @since 1.0.4
         * @return array An array of category ids
         */
        private function get_category_ids() {
            $retval = array();

            $categories = get_the_category( $this->post_id );

            if ( $categories ) {
                foreach( $categories as $category ) {
                    $retval[] = $category->term_id;
                }
            }

            return $retval;
        }

        /**
         * Returns the ids of the tags the post is assigned to
         * @author Jim Barnes
         * @since 1.0.4
         * @param int $post_id The post ID.
         * @return array An array of tag ids
         */
        private function get_tag_ids() {
            $retval = array();

            $tags = get_the_tags( $this->post_id );

            if ( $tags ) {
                foreach( $tags as $tag ) {
                    $retval[] = $tag->term_id;
                }
            }

            return $retval;
        }

        /**
         * Gets related posts
         * @author Jim Barnes
         * @since 1.0.4
         * @return array An array of posts
         */
        private function get_related_posts() {
            $retval = array();

            $this->category_ids = $this->get_category_ids();
            $this->tag_ids      = $this->get_tag_ids();

            $args = array(
                'post_type'      => 'post',
                'post__not_in'   => array( $this->post_id ),
                'posts_per_page' => $this->posts_per_page
            );

            if ( ! empty( $this->category_ids ) ) {
                if ( ! isset( $args['tax_query'] ) ) {
                    $args['tax_query'] = array();
                }

                $args['tax_query'][] = array(
                    'taxonomy' => 'category',
                    'field'    => 'term_id',
                    'terms'    => $this->category_ids,
                    'operator' => 'IN'
                );
            }

            if ( ! empty( $this->tag_ids ) ) {
                if ( ! isset( $args['tax_query'] ) ) {
                    $args['tax_query'] = array();
                }

                $args['tax_query'][] = array(
                    'taxonomy' => 'post_tag',
                    'field'    => 'term_id',
                    'terms'    => $this->tag_ids,
                    'operator' => 'IN'
                );
            }

            if ( count( $args['tax_query'] ) > 0 ) {
                $args['tax_query']['relation'] = 'OR';
            }

            $posts = get_posts( $args );

            if ( ! empty ( $posts ) ) {
                $retval = $posts;
            }

            return $retval;
        }

        #endregion
    }
}