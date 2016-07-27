<?php
/**
 * Less
 */
//add_action( 'init', 'kreme_include_less_dev' );
function kreme_include_less_dev(){

	if ( is_admin() )
		return false;

		kreme_include_less();
}

//add_filter('ot_before_page_messages', 'kreme_ot_before_page_messages');
function kreme_ot_before_page_messages($before) {

	$action = isset( $_REQUEST['action'] ) ? $_REQUEST['action'] : '';
	$message = isset( $_REQUEST['message'] ) ? $_REQUEST['message'] : '';

	if ( $action == 'import-data' && $message == 'success' ) {
		kreme_include_less();
	}

	return $before;
}

//add_action( 'ot_after_theme_options_save', 'kreme_ot_after_theme_options_save' );
function kreme_ot_after_theme_options_save() {
	global $wpdb;

	$cookie_name = $wpdb->prefix . 'featured_color';
	$featured_color = kreme_get_options( 'featured_color' );

	if ( !isset($featured_color) || empty($featured_color) || ( isset($_COOKIE[$cookie_name]) && $_COOKIE[$cookie_name] == $featured_color ) ) {
		return false;
			
	} else{
		setcookie($cookie_name, $featured_color, time() + (86400 * 30), "/");
	}

	kreme_include_less();
}

function kreme_include_less() {
	global $wpdb;

	$featured_color = kreme_get_options( 'featured_color' );

	require_once ('less/Less.php');

	try{

		$options = array(
				//'compress'			=> true,
				//'cache_dir'				=> get_template_directory () . "/assets/less/cache",
				'sourceMap' 			=> true,
				//'sourceMapWriteTo'  	=> get_template_directory () . '/assets/less/stylesheets.map',
				//'sourceMapURL'      	=> get_template_directory_uri() . '/assets/less/stylesheets.map',
		);


		$parser = new Less_Parser( $options );

		$parser->parseFile( get_template_directory () . "/assets/less/stylesheets.less", '../' );

		$parser->ModifyVars( array('font-size-base'=>'16.5px', 'brand-primary' => $featured_color) );

		$css = $parser->getCss();

		global $wp_filesystem;

		if (empty($wp_filesystem)) {
			require_once (ABSPATH . '/wp-admin/includes/file.php');
			WP_Filesystem();
		}

		if ( ! $wp_filesystem->put_contents(  get_template_directory () . "/assets/css/". $wpdb->prefix ."main.css", $css, FS_CHMOD_FILE) ) {
			wp_die("error saving file css!");
		}

	} catch(Exception $e){
		$error_message = $e->getMessage();
	}

}