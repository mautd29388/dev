<?php
/**
 * Initialize the custom Meta Boxes. 
 */

add_action ( 'admin_init', 'kreme_meta_boxes' );
function kreme_meta_boxes() {
	
	if ( !function_exists ( 'ot_register_meta_box' ) ) {
		
		return false;	
	}
	
	/**
	 * Create a custom meta boxes array that we pass to
	 * the OptionTree Meta Box API Class.
	 */
	$my_meta_box = array (
			
			/**
			 * Page
			 * */
			array (
					'id' => 'background-metabox',
					'title' => __ ( 'Background Title', 'kreme' ),
					'desc' => __ ( '', 'kreme' ),
					'pages' => array (
							'page'
					),
					'context' => 'normal',
					'priority' => 'high',
					'fields' => array (
							array(
									'id'          => '__background_title',
									'label'       => __( '', 'kreme' ),
									'desc'        => __ ( 'Background used for Page Header', 'kreme' ),
									'std'         => '',
									'type'        => 'background',
							),
					)
			),
			array (
					'id' => 'layout-metabox',
					'title' => __ ( 'Layout', 'kreme' ),
					'desc' => __ ( 'Select a layout for main contents of Page.', 'kreme' ),
					'pages' => array (
							'page'
					),
					'context' => 'normal',
					'priority' => 'high',
					'fields' => array (
							
							array(
									'id'          => '__layout',
									'label'          => '',
									'type'        => 'radio-image',
									'std'			=> 'full-width',
									'choices'     => array(
											array(
													'value'   => 'full-width',
													'label'   => 'Full Width (no sidebar)',
													'src'     => OT_URL . '/assets/images/layout/full-width.png'
											),
											array(
													'value'   => 'left-sidebar',
													'label'   => 'Left Sidebar',
													'src'     => OT_URL . '/assets/images/layout/left-sidebar.png'
											),
											array(
													'value'   => 'right-sidebar',
													'label'   => 'Right Sidebar',
													'src'     => OT_URL . '/assets/images/layout/right-sidebar.png'
											)
									),
							),
							array(
									'id'          => '__sidebar',
									'label'          => __( 'Sidebar Select', 'kreme' ),
									'type'        => 'sidebar-select',
									'condition'   => '__layout:not(full-width)'
							),
							array(
									'id'          => '__width',
									'label'       => __( 'Sidebar Width', 'kreme' ),
									'desc'        => __( 'The width of the sidebar determined by <code>%</code> of <code>12</code>.', 'kreme' ),
									'type'        => 'numeric-slider',
									'min_max_step'=> '1,12,1',
									'condition'   => '__layout:not(full-width)'
							),
							array(
									'id'          => '__el_class',
									'label'       => __( 'Extra class name', 'kreme' ),
									'desc'        => __( 'Style particular content element differently - add a class name and refer to it in custom CSS..', 'kreme' ),
									'type'        => 'text',
									'condition'   => '__layout:not(full-width)'
							)
					)
			),
			
	)
	;
	
	/**
	 * Register our meta boxes using the
	 * ot_register_meta_box() function.
	 */
	foreach ( $my_meta_box as $meta_box ) {
		ot_register_meta_box ( $meta_box );
	}
}

/**
 * Script Metabox
 */
function kreme_admin_scripts_metabox($hook) {
	$metaboxes = array (
			'image-banner-metabox' => 'default',
	);
	
	if ('post.php' != $hook && 'post-new.php' != $hook) {
		return;
	}
	
	$formats = $ids = array ();
	foreach ( $metaboxes as $id => $value ) {
		$formats [$value] = $id;
		array_push ( $ids, "#" . $id );
	}
	
	wp_register_script ( 'mTheme-admin-script', get_template_directory_uri () . '/assets/js/admin.js', array (
			'jquery' 
	), '20140616', true );
	
	$translation_array = array (
			'formats' => $formats,
			'ids' => implode ( ',', $ids ) 
	);
	wp_localize_script ( 'mTheme-admin-script', 'custom_metabox', $translation_array );
	
	wp_enqueue_script ( 'mTheme-admin-script' );
}
//add_action ( 'admin_enqueue_scripts', 'kreme_admin_scripts_metabox' );