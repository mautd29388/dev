<?php
/**
 * Plugin Name: Kreme Plugin
 * Plugin URI: #
 * Description: Plugin accompany the themes of mTheme.
 * Version: 1.0
 * Author: mTheme
 * Author URI: http://themeforest.net/user/mtheme_market
 * License: license purchased
 */

define( 'mTheme_URL', plugin_dir_url( __FILE__ ) );
define( 'mTheme_PATH', plugin_dir_path( __FILE__ ) );

register_activation_hook ( __FILE__, 'mTheme_activate' );
function mTheme_activate() {
	flush_rewrite_rules ();
}

register_deactivation_hook ( __FILE__, 'mTheme_deactivate' );
function mTheme_deactivate() {
	flush_rewrite_rules ();
}

$current_active_theme = wp_get_theme();
if ( $current_active_theme->get('Author') == 'mTheme' ) {
	//require mTheme_PATH . 'inc/custom-post-type.php';
	require mTheme_PATH . 'inc/option-tree/ot-loader.php';
	require mTheme_PATH . 'inc/shortcode/shortcode.php';
	require mTheme_PATH . 'inc/menus/menu.php';
	require mTheme_PATH . 'inc/widgets.php';
}