<?php
//Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

 /*
 * Function for replace the default blog template
 */
 function isba_blog_posts($original_template) {

		if ( is_home() ) {

			if ( file_exists( get_stylesheet_directory(). '/isba_tamplates/blog.php' ) ) {
                     $new_template = get_stylesheet_directory() . '/isba_tamplates/blog.php';
               } else {
                      $new_template = ISBA_PLUGIN_PATH . 'templates/blog.php';
               }
			
			return  $new_template;
		}

	 return $original_template;       

 }
 add_filter('template_include','isba_blog_posts');

/*
* Function for posts content
*/
 function isba_post_content() {

 		$isba_settings_option = get_option('isba_settings_option');
		$template = $isba_settings_option['isba_blog_template'];
		// Variables 
		$isba_post_container = 'isba_post_container'.' template_'.$template; 
		$isba_title = 'isba-title';
		$isba_excerpt = 'isba-excerpt';
		$isba_readmore = 'isba-readmore';
		$imgwr = 'isba-image';
		$isba_content_wr = 'isba-content-wr';
		$words_length = $isba_settings_option['isba_post_excerpt_size'];
		if(!isset($words_length)) {
			$words_length = 40;
		} else {
			$words_length = $isba_settings_option['isba_post_excerpt_size'];
		}
		$isba_post = ""; 

 		$isba_post .= '<div class="'.$isba_post_container.'">'; 
		$isba_post .= '<div class="'.$imgwr.'"><img src="'.wp_get_attachment_url(get_post_thumbnail_id(get_the_id())).'" alt="" /></div>';
		$isba_post .= '<div class="'.$isba_content_wr.'">';
		$isba_post .= '<h2 class="'.$isba_title.'">'.get_the_title().'</h2>';
		$isba_post .= '<div class="'.$isba_excerpt.'">'.wp_trim_words(get_the_content(),$words_length).'</div>';
		$isba_post .= '<div class="'.$isba_readmore.'"><a href="'.get_the_permalink().'">Read More</a></div>';
		$isba_post .= '</div>';
		$isba_post .= '</div>'; 

		$isba_post = apply_filters( 'isba_post_content', $isba_post );

		return $isba_post;

} 

/* 
* Function for show posts on template with ajax load
*/
function template_show_post_load() {
$isba_post = ""; 

$options = get_option('isba_settings_option');
$show_more_label = $options['isba_load_more_button_label'];
if($show_more_label =='') {
	$show_more_label = 'Show More';
}

$isba_post .= '<div id="isba_container" class="isba_container">';
	
	  if(have_posts()): while(have_posts()): the_post(); 

	  $isba_post .= isba_post_content(); 

	 endwhile; endif;  

$isba_post .= '</div>';
$isba_post .= '<div class="isba_load_more_wr"><a href="javascript:void(0);">'.$show_more_label.'</a></div>';

return $isba_post;
}
 