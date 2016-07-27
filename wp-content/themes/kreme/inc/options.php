<?php

require( trailingslashit( get_template_directory() ) . 'inc/options/general.php' );
require( trailingslashit( get_template_directory() ) . 'inc/options/header.php' );
require( trailingslashit( get_template_directory() ) . 'inc/options/blog.php' );
require( trailingslashit( get_template_directory() ) . 'inc/options/shop.php' );
require( trailingslashit( get_template_directory() ) . 'inc/options/footer.php' );
require( trailingslashit( get_template_directory() ) . 'inc/options/typography.php' );


function kreme_options() {
	
	/* OptionTree is not loaded yet, or this is not an admin request */
	if (! function_exists ( 'ot_settings_id' ) || ! is_admin ())
		return false;
	
	/**
	 * Get a copy of the saved settings array.
	 */
	$saved_settings = get_option ( ot_settings_id (), array () );
	
	/**
	 * Custom settings array that will eventually be
	 * passes to the OptionTree Settings API Class.
	 */
	$custom_settings = array (
			
			'sections' => array (),
			'settings' => array () 
	);
	
	/* allow settings to be filtered before saving */
	$custom_settings = apply_filters ( 'kreme_init_options_settings', $custom_settings );
	
	/* settings are not the same update the DB */
	if ($saved_settings !== $custom_settings) {
		update_option ( ot_settings_id (), $custom_settings );
	}
	
	/* Lets OptionTree know the UI Builder is being overridden */
	global $ot_has_customTheme_options;
	$ot_has_customTheme_options = true;
}