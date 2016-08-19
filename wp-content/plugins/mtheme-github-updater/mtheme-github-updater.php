<?php
/**
 * Plugin Name: mTheme Github Updater
 * Plugin URI: #
 * Description: Plugin accompany the themes of mTheme.
 * Version: 1.0.0
 * Author: mTheme
 * Author URI: http://themeforest.net/user/mtheme_market
 * License: license purchased
 */

if ( !class_exists('mTheme_Github_Updater') ) {
	require_once( 'class-mtheme-github-updater.php' );
}
if ( class_exists('mTheme_Github_Updater') ) {
	
	$pluginFile = WP_PLUGIN_DIR . '/plugin-auto-update';
	
	if ( is_admin() ) {
	    new mTheme_Github_Updater( $pluginFile, 'mautd29388', "plugin-auto-update" );
	}
}
?>