<?php

add_filter( 'kreme_init_options_settings', 'kreme_init_options_general');

function kreme_init_options_general($custom_settings){
	
	$sections = $custom_settings['sections'];
	$settings = $custom_settings['settings'];
	
	$sections[] = array (
						'id' => 'general',
						'title' => __ ( 'General', 'kreme' )
				);
	
	$settings[] = array (
							'id' => 'logo',
							'label' => __ ( 'Logo', 'kreme' ),
							'desc' => __ ( 'Select an image file for your logo.', 'kreme' ),
							'std' => trailingslashit(get_template_directory_uri()) . 'assets/imgs/logo.png',
							'type' => 'upload',
							'section' => 'general',
					);
	/* $settings[] = array(
							'id'          => 'main_styles',
							'label'       => __( 'Select a style for Theme ', 'kreme' ),
							'desc'        => __( '', 'kreme' ),
							'std'         => 'style-v1',
							'type'        => 'select',
							'section'     => 'general',
							'choices'     => array(
									array(
											'value'       => '',
											'label'       => __( '-- Choose One --', 'kreme' ),
									),
									array(
											'value'       => 'style-v1',
											'label'       => __( 'Style v1', 'kreme' ),
									),
									array(
											'value'       => 'style-v2',
											'label'       => __( 'Style v2', 'kreme' ),
									),
							)
					); */
	/* $settings[] = array(
							'id'          => 'main_layout',
							'label'          => 'Layout',
							'desc'        => __( 'Select a layout for your theme', 'kreme' ),
							'type'        => 'radio-image',
							'std'			=> 'full-width',
							'choices'     => array(
									array(
											'value'   => 'full-width',
											'label'   => 'Full Width (no sidebar)',
											'src'     => trailingslashit(get_template_directory_uri()) . 'assets/imgs/layout/full-width.png'
									),
									array(
											'value'   => 'left-sidebar',
											'label'   => 'Left Sidebar',
											'src'     => trailingslashit(get_template_directory_uri()) . 'assets/imgs/layout/left-sidebar.png'
									),
									array(
											'value'   => 'right-sidebar',
											'label'   => 'Right Sidebar',
											'src'     => trailingslashit(get_template_directory_uri()) . 'assets/imgs/layout/right-sidebar.png'
									)
							),
							'section' => 'general'
					); */
	/* $settings[] = array(
							'id'          => 'main_sidebar',
							'label'          => 'Sidebar Select',
							'type'        => 'sidebar-select',
							'section' => 'general',
							'condition'   => 'main_layout:not(full-width)'
					);
	$settings[] = array(
							'id'          => 'main_width',
							'label'       => __( 'Sidebar Width', 'kreme' ),
							'desc'        => __( 'The width of the sidebar determined by <code>%</code> of <code>12</code>.', 'kreme' ),
							'type'        => 'numeric-slider',
							'min_max_step'=> '1,12,1',
							'section' => 'general',
							'condition'   => 'main_layout:not(full-width)'
					);
	$settings[] = array(
							'id'          => 'main_el_class',
							'label'       => __( 'Extra class name for Sidebar', 'kreme' ),
							'desc'        => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'kreme' ),
							'type'        => 'text',
							'section' 	  => 'general',
							'condition'   => 'main_layout:not(full-width)'
					); */
	/* $settings[] = array(
							'id'          => 'main_boxed',
							'label'       => 'Boxed',
							'desc'        => __( 'Check this box to use Boxed. If left unchecked then full width is used.', 'kreme' ),
							'type'        => 'on-off',
							'std'		  => 'off',
							'section'     => 'general'
					); */
	$settings[] = array(
							'id'          => 'background_body',
							'label'       => __( 'Background for Body', 'kreme' ),
							'desc'        => __ ( 'Background used for the Body', 'kreme' ),
							'std'         => '',
							'type'        => 'background',
							'section'     => 'general',
					);
	/* $settings[] = array(
							'id'          => 'background_boxed',
							'label'       => __( 'Background for Boxed', 'kreme' ),
							'desc'        => __ ( 'Background used for the Boxed', 'kreme' ),
							'std'         => '',
							'type'        => 'background',
							'section'     => 'general',
							'condition'   => 'main_boxed:is(on)',
					); */
	/* $settings[] = array(
							'id'          => 'background_main',
							'label'       => __( 'Background for Main Content', 'kreme' ),
							'desc'        => __ ( 'Background used for the Main Content', 'kreme' ),
							'std'         => '',
							'type'        => 'background',
							'section'     => 'general',
					);
	$settings[] = array(
							'id'          => 'main_container',
							'label'		  => 'Container Full',
							'desc'        => __( 'Use <code>.container-fluid</code> for a full width container, spanning the entire width of your viewport. If left unchecked then use <code>.container</code> for a responsive fixed width container.', 'kreme' ),
							'type'        => 'on-off',
							'std'		  => 'off',
							'section'     => 'general'
					); */
	$settings[] = array (
							'label' 	=> __ ( 'Add Sidebar', 'kreme' ),
							'id' => 'sidebar',
							'type' => 'list-item',
							'desc' => '',
							'settings' => array (
									array (
											'label' => 'Sidebar Name',
											'id' => 'name',
											'type' => 'text',
											'desc' => '',
									)
							),
							'std' => '',
							'section' => 'general'
					);
	$settings[] = array(
					        'id'          => 'custom_css',
					        'label'       => __( 'Custom CSS', 'kreme' ),
							'desc'        => __( 'Paste your CSS code, do not include any tags or HTML in the field. Any custom CSS entered here will override the theme CSS. In some cases, the !important tag may be needed.', 'kreme' ),
					        'std'         => '',
					        'type'        => 'css',
							'rows'        => '20',
					        'section'     => 'general',
					);
	
	
	$custom_settings['sections'] = $sections;
	$custom_settings['settings'] = $settings;
	
	return $custom_settings;
}