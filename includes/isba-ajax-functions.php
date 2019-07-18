<?php 
//Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
* Function for load more posts on ajax call
*/
function isba_load_more_posts() {

$post_type = 'post';

$post_per_page = $_POST['posts_per_page']; 
	$args = array( 
		'post_type'=> $post_type,
		'posts_per_page' => $post_per_page
		);

	$args = apply_filters( 'isba_query_posts_args', $args ); 
	query_posts($args);
  	 while(have_posts()): the_post(); 
  	 	
  	 	echo isba_post_content(); 
 
	 endwhile; wp_reset_query(); 

	wp_die(); 
}

add_action('wp_ajax_isba_load_more_posts', 'isba_load_more_posts');
add_action( 'wp_ajax_nopriv_isba_load_more_posts', 'isba_load_more_posts' );