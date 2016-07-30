<?php

/**
 * Theme Setup
 */
function kreme_setup() {

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	add_theme_support( 'title-tag' );

	//add_theme_support( 'post-thumbnails' );
	//set_post_thumbnail_size( 600, 400, true );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
			'primary-left' => __( 'Primary Left',  'kreme' ),
	) );
	register_nav_menus( array(
			'primary-right' => __( 'Primary Right',  'kreme' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array('search-form', 'comment-list', 'gallery', 'caption') );

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	//add_theme_support( 'post-formats', array('video') );

	add_theme_support( 'woocommerce' );

}

/**
 * Theme Scripts
 */
function kreme_scripts() {
	global $wpdb;

	// Load Style
	wp_enqueue_style ( 'bootstrap-css', trailingslashit( get_template_directory_uri() ) . 'assets/css/bootstrap.min.css' );
	wp_enqueue_style ( 'font-awesome-css', trailingslashit( get_template_directory_uri() ) . 'assets/css/font-awesome.min.css' );
	wp_enqueue_style ( 'flickity-css', trailingslashit( get_template_directory_uri() ) . 'assets/css/flickity.min.css' );
	wp_enqueue_style ( 'animate-css', trailingslashit( get_template_directory_uri() ) . 'assets/css/animate.css' );
	wp_enqueue_style ( 'icomoon-css', trailingslashit( get_template_directory_uri() ) . 'assets/css/icomoon.css' );
	
	wp_enqueue_style ( 'main-css', trailingslashit( get_template_directory_uri() ) . 'assets/css/main.css' );
	wp_enqueue_style ( 'responsive-css', trailingslashit( get_template_directory_uri() ) . 'assets/css/responsive.css' );
	wp_enqueue_style ( 'color-css', trailingslashit( get_template_directory_uri() ) . 'assets/css/color/default.css' );

	wp_enqueue_style ( 'mTheme-style', get_stylesheet_uri() );


	// Load Script
	wp_register_script ( 'google-maps-js', 'https://maps.googleapis.com/maps/api/js' );
	wp_register_script ( 'maps-js', trailingslashit( get_template_directory_uri () ) . 'assets/js/maps.js', array (), null, true );

	wp_enqueue_script ( 'modernizr-js', trailingslashit( get_template_directory_uri () ) . 'assets/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js' );
	wp_enqueue_script ( 'imagesloaded-js', trailingslashit( get_template_directory_uri () ) . 'assets/js/vendor/imagesloaded.pkgd.min.js', array (), null, true );
	wp_enqueue_script ( 'bootstrap-js', trailingslashit( get_template_directory_uri () ) . 'assets/js/vendor/bootstrap.min.js', array ('jquery'), null, true );
	wp_enqueue_script ( 'waypoints-js', trailingslashit( get_template_directory_uri () ) . 'assets/js/vendor/jquery.waypoints.min.js', array ('jquery'), null, true );
	wp_enqueue_script ( 'sticky-js', trailingslashit( get_template_directory_uri () ) . 'assets/js/vendor/sticky.min.js', array ('jquery'), null, true );
	wp_enqueue_script ( 'flickity-js', trailingslashit( get_template_directory_uri () ) . 'assets/js/vendor/flickity.pkgd.min.js', array ('jquery'), null, true );
	wp_enqueue_script ( 'main-js', trailingslashit( get_template_directory_uri () ) . 'assets/js/main.js', array ('jquery'), null, true );

	if ( is_singular() ) wp_enqueue_script( "comment-reply" );
}

/**
 * Options default
 * */
function kreme_options_default() {
	global $pagenow;

	if ('themes.php' == $pagenow && isset ( $_GET ['activated'] )) {
		update_option ( 'thumbnail_size_h', 400 );
		update_option ( 'thumbnail_size_w', 900 );
		update_option ( 'medium_size_h', 0 );
		update_option ( 'medium_size_w', 1000 );
		update_option ( 'posts_per_page', 3 );
		//update_option ( 'users_can_register', 1 );
	}
}

/**
 * Extend body classes
 */
function kreme_body_classes($classes) {

	if ( is_front_page() )
		$classes [] = 'loadpage';

		$classes [] = get_theme_mod('main_styles', '');

		return $classes;
}

/**
 * Extend Post classes
 */
function kreme_post_classes($classes) {

	if ( function_exists('is_woocommerce') && is_woocommerce() && !is_product() )
		$classes [] = 'animated fadeInUp';

		return $classes;
}

/**
 * Theme Mods
 */
function kreme_theme_mods() {

	$theme = get_option( 'stylesheet' );

	return "theme_mods_$theme";
}

/**
 * Disable support for comments in page types
 * */
function kreme_disable_comments_page_support() {
	remove_post_type_support ( 'page', 'comments' );
}

/**
 * pre get posts
 * */
function kreme_pre_get_posts() {
	global $wp_query;

	if (is_post_type_archive ( 'mportfolio' )) {

		$posts_per_page = get_theme_mod ( 'portfolio_items', 12 );

		$wp_query->set ( 'posts_per_page', $posts_per_page );
	}
}

function kreme_excerpt_length( $excerpt_length = 55 ) {
	
	$excerpt_length = 20;
	
	return $excerpt_length;
}

 