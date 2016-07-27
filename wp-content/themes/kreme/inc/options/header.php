<?php

add_filter( 'kreme_init_options_settings', 'kreme_init_options_header');

function kreme_init_options_header($custom_settings){
	
	$sections = $custom_settings['sections'];
	$settings = $custom_settings['settings'];
	
	$sections[] = array (
						'id' => 'header',
						'title' => __ ( 'Header', 'kreme' )
				);
	
	$settings[] = array(
							'id'          => 'background_header',
							'label'       => __( 'Background for Header', 'kreme' ),
							'desc'        => __ ( 'Background used for Page Header', 'kreme' ),
							'std'         => '',
							'type'        => 'background',
							'section'     => 'header',
					);
	$settings[] = 	array(
							'id'          => 'header_styles',
							'label'       => __( 'Select a style for Header', 'kreme' ),
							'desc'        => __( '', 'kreme' ),
							'std'         => 'style-v1',
							'type'        => 'select',
							'section'     => 'header',
							'choices'     => array(
									array(
											'value'       => '',
											'label'       => __( '-- Choose One --', 'kreme' ),
									),
									array(
											'value'       => 'style-v1',
											'label'       => __( 'Style v1', 'kreme' ),
									),
							)
					);
	/* $settings[] = array(
							'id'          => 'background_header_top',
							'label'       => __( 'Background for Header Top', 'kreme' ),
							'std'         => '',
							'type'        => 'background',
							'section'     => 'header',
					); */
	$settings[] = array(
							'id'          => 'header_top_sidebar',
							'label'       => __( 'Add Sidebar for Header Top', 'kreme' ),
							'std'         => '',
							'type'        => 'list-item',
							'section'     => 'header',
							'settings'    => array(
									array(
											'id'          => 'sidebar',
											'label'       => __( 'Sidebar Select', 'kreme' ),
											'std'         => '',
											'type'        => 'sidebar-select',
									),
									array(
											'id'          => 'width',
											'label'       => __( 'Sidebar Width', 'kreme' ),
											'desc'        => __( 'The width of the sidebar determined by <code>%</code> of <code>12</code>.', 'kreme' ),
											'type'        => 'numeric-slider',
											'min_max_step'=> '1,12,1',
									),
									array(
											'id'          => 'el_class',
											'label'       => __( 'Extra class name', 'kreme' ),
											'desc'        => __( 'Style particular content element differently - add a class name and refer to it in custom CSS..', 'kreme' ),
											'type'        => 'text',
									)
							)
					);
	/* $settings[] = array(
							'id'          => 'background_header_middle',
							'label'       => __( 'Background for Header Middle', 'kreme' ),
							'std'         => '',
							'type'        => 'background',
							'section'     => 'header',
					); */
	/* $settings[] = array(
							'id'          => 'header_middle_sidebar',
							'label'       => __( 'Add Sidebar for Header Middle', 'kreme' ),
							'desc'        => __( '', 'kreme' ),
							'std'         => '',
							'type'        => 'list-item',
							'section'     => 'header',
							'settings'    => array(
									array(
											'id'          => 'sidebar',
											'label'       => __( 'Sidebar Select', 'kreme' ),
											'std'         => '',
											'type'        => 'sidebar-select',
									),
									array(
											'id'          => 'width',
											'label'       => __( 'Sidebar Width', 'kreme' ),
											'desc'        => __( 'The width of the sidebar determined by <code>%</code> of <code>12</code>.', 'kreme' ),
											'type'        => 'numeric-slider',
											'min_max_step'=> '1,12,1',
									),
									array(
											'id'          => 'el_class',
											'label'       => __( 'Extra class name', 'kreme' ),
											'desc'        => __( 'Style particular content element differently - add a class name and refer to it in custom CSS..', 'kreme' ),
											'type'        => 'text',
									)
							)
					); */
	/* $settings[] = array(
							'id'          => 'background_header_bottom',
							'label'       => __( 'Background for Header Bottom', 'kreme' ),
							'std'         => '',
							'type'        => 'background',
							'section'     => 'header',
					);
	$settings[] = array(
							'id'          => 'header_bottom_sidebar',
							'label'       => __( 'Add Sidebar for Header Bottom', 'kreme' ),
							'desc'        => __( '', 'kreme' ),
							'std'         => '',
							'type'        => 'list-item',
							'section'     => 'header',
							'settings'    => array(
									array(
											'id'          => 'sidebar',
											'label'       => __( 'Sidebar Select', 'kreme' ),
											'std'         => '',
											'type'        => 'sidebar-select',
									),
									array(
											'id'          => 'width',
											'label'       => __( 'Sidebar Width', 'kreme' ),
											'desc'        => __( 'The width of the sidebar determined by <code>%</code> of <code>12</code>.', 'kreme' ),
											'type'        => 'numeric-slider',
											'min_max_step'=> '1,12,1',
									),
									array(
											'id'          => 'el_class',
											'label'       => __( 'Extra class name', 'kreme' ),
											'desc'        => __( 'Style particular content element differently - add a class name and refer to it in custom CSS..', 'kreme' ),
											'type'        => 'text',
									)
							)
					); */
	
	
	$custom_settings['sections'] = $sections;
	$custom_settings['settings'] = $settings;
	
	return $custom_settings;
}