<?php

/**
 * @example
 * FastForward::Posts()
 *     ->getPosts(0, array('post_type' => 'post'));
 */
class FastForward_Posts {
    /**
     * Get all subpages (tree) with children, grandchildren and so.
     **/
    public function getPages($id = 0, $depth = 0, $echo = true){
        $ancestors = get_post_ancestors($id);
        $parent = empty($ancestors) ? $post->ID : end($ancestors);
        $args = array(
            'child_of'     => $parent,
            // 0 (default) Displays pages at any depth and arranges them hierarchically in nested lists, 
            // -1 Displays pages at any depth and arranges them in a single, flat list
            'depth'        => $depth,
            'echo'         => false,
            'exclude'      => '',
            'include'      => '',
            'link_after'   => '',
            'link_before'  => '',
            'post_type'    => 'page',
            'post_status'  => 'publish',
            'sort_column'  => 'menu_order, post_title',
            'title_li'     => ''
        ); 
        $list = wp_list_pages($args);

        if ($echo) {
            echo $list;
            return true;
        } else {
            return $list;
        }
    }

    /**
     * Get all subpages (children)
     **/
    public function getPosts($parentID = '', $args = array()){
        $args = wp_parse_args($args, array(
            'posts_per_page' => -1,
            'post_type' => 'page',
            'post_parent' => $parentID,
            'orderby' => 'menu_order',
            'order' => 'ASC',
            'post_status' => 'publish'
        )); 
        $pages = get_posts($args);

        return $pages;
    }

    /**
     * Transform array of post IDs to post query.
     * 
     * @param array $ids
     * @param  array $args
     * @return object
     */
    public function mergePosts($ids, $args = array()) {
        $args = wp_parse_args($args, array(
            'posts_per_page' => -1,
            'post_type' => 'page',
            'post__in' => $ids,
            'orderby' => 'menu_order',
            'order' => 'ASC',
            'post_status' => 'publish'
        ));
        $query = new WP_Query($args);

        return $query->get_posts();
    }

    /**
     * Reset query
     */
    public function resetQuery(){
        // Reset query_posts() or $wp_query.
        wp_reset_query();
        // Reset $post.
        wp_reset_postdata();
    }
}
