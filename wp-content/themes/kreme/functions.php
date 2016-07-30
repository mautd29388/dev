<?php

if ( ! isset( $content_width ) ) $content_width = 1920;

/**
 * Theme Setup
 * */
add_action( 'after_setup_theme', 'kreme_setup' );

add_action ( 'wp_enqueue_scripts', 'kreme_scripts' );

add_action ( 'load-themes.php', 'kreme_options_default' );

add_action ( 'init', 'kreme_disable_comments_page_support' );

add_filter ( 'widget_text', 'do_shortcode');

//add_action ( 'pre_get_posts', 'kreme_pre_get_posts' );

add_filter ( 'excerpt_length', 'kreme_excerpt_length' );

add_filter ( 'body_class', 'kreme_body_classes' );

add_filter ( 'post_class', 'kreme_post_classes' );

add_action ( 'wp_head', 'kreme_style' );


/**
 * Theme Options
 */
add_filter ( 'ot_child_theme_mode', '__return_false' );

add_filter ( 'ot_show_options_ui', '__return_false' );

add_filter ( 'ot_show_new_layout', '__return_false' );

add_filter ( 'ot_use_theme_options', '__return_true' );

add_filter ( 'ot_meta_boxes', '__return_true' );

add_filter ( 'ot_post_formats', '__return_true' );

add_filter ( 'ot_options_id', 'kreme_theme_mods' );

add_action ( 'init', 'kreme_options' );


/**
 * TGM-Plugin-Activation
 */
require_once (trailingslashit ( get_template_directory () ) . 'inc/addons/TGM-Plugin-Activation/load.php');

/**
 * Theme Option
 * */
require (trailingslashit ( get_template_directory () ) . 'inc/options.php');

/**
 * Meta Box
 * */
require (trailingslashit ( get_template_directory () ) . 'inc/meta-boxes.php');

/**
 * Function
 * */
require (trailingslashit ( get_template_directory () ) . 'inc/init.php');

/**
 * Function
 * */
require (trailingslashit ( get_template_directory () ) . 'inc/utility.php');

/**
 * Function
 * */
require (trailingslashit ( get_template_directory () ) . 'inc/breadcrumb.php');

/**
 * Widget and Sidebar
 * */
require (trailingslashit ( get_template_directory () ) . 'inc/widgets.php');

/**
 * Funtion for Woocommerce
 * */
require (trailingslashit ( get_template_directory () ) . 'inc/woocommerce.php');

/**
 * Custom css
 * */
require (trailingslashit ( get_template_directory () ) . 'inc/css.php');


