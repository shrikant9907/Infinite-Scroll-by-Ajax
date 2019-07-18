<?php
/*
Plugin Name: Infinite Scroll by Ajax in WP
Plugin URI:  http://plugins.hire-expert-developer.com/infinite-scroll-by-ajax-in-wp/
Description: A plugin for adding infinite scroll in posts.
Version:     1.0
Author:      Shrikant Yadav
Author URI:  http://shrikant-y.hire-expert-developer.com/
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
*/


//Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'ISBA_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

// Including files 
require_once ( ISBA_PLUGIN_PATH . 'includes/isba-front-end.php' );
require_once ( ISBA_PLUGIN_PATH . 'includes/isba-settings.php' );
// require_once ( ISBA_PLUGIN_PATH . 'includes/isba-fields.php' );
// require_once ( ISBA_PLUGIN_PATH . 'includes/isba-shortcode.php' );
require_once ( ISBA_PLUGIN_PATH . 'includes/isba-ajax-functions.php' ); 

function isba_wp_enqueue_scripts() {

		// Styles 
 		wp_enqueue_style( 'isba-style', plugins_url( 'css/isba-style.css', __FILE__ ) );

 		// Script 
 		wp_enqueue_script( 'isba-ajax-js', plugins_url( 'js/isba-ajax.js', __FILE__ ), array( 'jquery'), '20160520', true );

		$count_posts = wp_count_posts('post');
		$published_posts = $count_posts->publish;

		$options = get_option('isba_settings_option');
		$auto_load_posts = $options['isba_post_auto_load']; 

		// AjaxURL
		wp_localize_script( 'isba-ajax-js', 'AJAXOBJ', array( 
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'posts_per_page' => get_option('posts_per_page'),
			'published_posts' => $published_posts,
			'auto_load_posts' => $auto_load_posts,
			'isba_security' => wp_create_nonce( 'isba_setting_nonce_action' ),
			 ));
		

 		wp_enqueue_script( 'isba-scripts-js', plugins_url( 'js/isba-scripts.js', __FILE__ ), array( 'jquery'), '20160520', true );

}
add_action( 'wp_enqueue_scripts', 'isba_wp_enqueue_scripts' );


function isba_admin_enqueue_scripts() {

		global $pagenow, $typenow;
		
		// Admin Styles 
 		wp_enqueue_style( 'isba-admin-style', plugins_url( 'css/isba-admin-style.css', __FILE__ ) );
 		
 		// Admin Scripts
 		wp_enqueue_script( 'isba-admin-scripts', plugins_url( 'js/isba-admin-scripts.js', __FILE__ ), array( 'jquery'), '20160520', true );
 		

}
add_action( 'admin_enqueue_scripts', 'isba_wp_enqueue_scripts' );

