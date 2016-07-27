<?php

add_filter( 'kreme_init_options_settings', 'kreme_init_options_footer');

function kreme_init_options_footer($custom_settings){
	
	$sections = $custom_settings['sections'];
	$settings = $custom_settings['settings'];
	
	$sections[] = array (
							'id' => 'footer',
							'title' => __ ( 'Footer', 'kreme' )
					);
	
	$settings[] = array(
							'id'          => 'background_footer',
							'label'       => __( 'Background for Footer', 'kreme' ),
							'type'        => 'background',
							'section'     => 'footer',
					);
	$settings[] = array(
							'id'          => 'background_footer_top',
							'label'       => __( 'Background for Footer Top', 'kreme' ),
							'type'        => 'background',
							'section'     => 'footer',
					);
	$settings[] = array(
							'id'          => 'sidebar_footer_top',
							'label'       => __( 'Add Sidebar for Footer Top', 'kreme' ),
							'desc'        => __( '', 'kreme' ),
							'type'        => 'list-item',
							'section'     => 'footer',
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
	$settings[] = array(
							'id'          => 'background_footer_middle',
							'label'       => __( 'Background for Footer Middle', 'kreme' ),
							'type'        => 'background',
							'section'     => 'footer',
					);
	$settings[] = array(
							'id'          => 'sidebar_footer',
							'label'       => __( 'Add Sidebar for Footer Middle', 'kreme' ),
							'desc'        => __( '', 'kreme' ),
							'type'        => 'list-item',
							'section'     => 'footer',
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
	$settings[] = array (
							'id' => 'copyright',
							'label' => __ ( 'Copyright', 'kreme' ),
							'desc' => __ ( 'Enter the text that displays in the copyright bar. HTML markup can be used.', 'kreme' ),
							'type' => 'textarea',
							'section' => 'footer',
							'rows' => '10',
					);
	
	
	$custom_settings['sections'] = $sections;
	$custom_settings['settings'] = $settings;
	
	return $custom_settings;
}