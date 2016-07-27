<?php

add_filter( 'kreme_init_options_settings', 'kreme_init_options_blog');

function kreme_init_options_blog($custom_settings){
	
	$sections = $custom_settings['sections'];
	$settings = $custom_settings['settings'];
	
	$sections[] = array (
							'id' => 'blog',
							'title' => __ ( 'Blog', 'kreme' )
					);
	
	$settings[] = array(
							'id'          => 'blog_background_title',
							'label'       => __( 'Background for Title', 'kreme' ),
							'desc'        => __ ( 'Background used for Title', 'kreme' ),
							'std'         => '',
							'type'        => 'background',
							'section'     => 'blog',
					);
	$settings[] = array(
							'id'          => 'blog_layout',
							'label'          => 'Blog Layout',
							'desc'        => __( '', 'kreme' ),
							'type'        => 'radio-image',
							'std'			=> 'full-width',
							'choices'     => array(
									array(
											'value'   => 'left-sidebar',
											'label'   => 'Left Sidebar',
											'src'     => OT_URL . '/assets/images/layout/left-sidebar.png'
									),
									array(
											'value'   => 'right-sidebar',
											'label'   => 'Right Sidebar',
											'src'     => OT_URL . '/assets/images/layout/right-sidebar.png'
									),
									array(
											'value'   => 'full-width',
											'label'   => 'Full Width (no sidebar)',
											'src'     => OT_URL . '/assets/images/layout/full-width.png'
									),
							),
							'section' => 'blog'
					);
	$settings[] = array(
							'id'          => 'blog_sidebar',
							'label'       => __( 'Sidebar Select', 'kreme' ),
							'std'         => '',
							'type'        => 'sidebar-select',
							'condition'   => 'blog_layout:not(full-width)',
							'section' => 'blog'
					);
	$settings[] = array(
							'id'          => 'blog_sidebar_width',
							'label'       => __( 'Sidebar Width', 'kreme' ),
							'desc'        => __( 'The width of the sidebar determined by <code>%</code> of <code>12</code>.', 'kreme' ),
							'type'        => 'numeric-slider',
							'min_max_step'=> '1,12,1',
							'condition'   => 'blog_layout:not(full-width)',
							'section' => 'blog'
					);
	$settings[] = array(
							'id'          => 'blog_sidebar_el_class',
							'label'       => __( 'Extra class name for Sidebar', 'kreme' ),
							'desc'        => __( 'Style particular content element differently - add a class name and refer to it in custom CSS..', 'kreme' ),
							'type'        => 'text',
							'condition'   => 'blog_layout:not(full-width)',
							'section' => 'blog'
					);
	
	
	$custom_settings['sections'] = $sections;
	$custom_settings['settings'] = $settings;
	
	return $custom_settings;
}