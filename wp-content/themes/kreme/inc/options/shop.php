<?php

add_filter( 'kreme_init_options_settings', 'kreme_init_options_shop');

function kreme_init_options_shop($custom_settings){
	
	$sections = $custom_settings['sections'];
	$settings = $custom_settings['settings'];
	
	$sections[] = array (
							'id' => 'shop',
							'title' => __ ( 'Shop', 'kreme' )
					);
	
	$settings[] = array(
							'id'          => 'shop_background_title',
							'label'       => __( 'Background for Title', 'kreme' ),
							'desc'        => __ ( 'Background used for Title', 'kreme' ),
							'std'         => '',
							'type'        => 'background',
							'section'     => 'shop',
					);
					/*
	$settings[] = array(
							'id'          => 'shop_sidebar_top',
							'label'       => __( 'Sidebar for Top Content', 'kreme' ),
							'std'         => '',
							'type'        => 'sidebar-select',
							'section'     => 'shop',
					);*/
					
	$settings[] = array(
							'id'          => 'shop_layout',
							'label'          => 'Shop Layout',
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
							'section' => 'shop'
					);
	$settings[] = array(
							'id'          => 'shop_sidebar',
							'label'       => __( 'Sidebar Select', 'kreme' ),
							'std'         => '',
							'type'        => 'sidebar-select',
							'condition'   => 'shop_layout:not(full-width)',
							'section' => 'shop'
					);
	$settings[] = array(
							'id'          => 'shop_sidebar_width',
							'label'       => __( 'Sidebar Width', 'kreme' ),
							'desc'        => __( 'The width of the sidebar determined by <code>%</code> of <code>12</code>.', 'kreme' ),
							'type'        => 'numeric-slider',
							'min_max_step'=> '1,12,1',
							'condition'   => 'shop_layout:not(full-width)',
							'section' => 'shop'
					);
	$settings[] = array(
							'id'          => 'shop_sidebar_el_class',
							'label'       => __( 'Extra class name for Sidebar', 'kreme' ),
							'desc'        => __( 'Style particular content element differently - add a class name and refer to it in custom CSS..', 'kreme' ),
							'type'        => 'text',
							'condition'   => 'shop_layout:not(full-width)',
							'section' => 'shop'
					);
	$settings[] = array(
							'id'          => 'shop_items',
							'label'       => __( 'Per page', 'kreme' ),
							'desc'        => __( 'The "per_page" shortcode determines how many products to show on the page.', 'kreme' ),
							'std'         => '12',
							'type'        => 'text',
							'section'     => 'shop',
					);
					/*
	$settings[] = array(
							'id'          => 'shop_columns',
							'label'       => __( 'Columns', 'kreme' ),
							'desc'        => __( 'The columns attribute controls how many columns wide the products should be before wrapping.', 'kreme' ),
							'std'         => '4',
							'type'        => 'text',
							'section'     => 'shop',
					);*/
	$settings[] = array(
							'id'          => 'shop_single_layout',
							'label'          => 'Single Layout',
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
							'section' => 'shop'
					);
	$settings[] = array(
							'id'          => 'shop_single_sidebar',
							'label'       => __( 'Single Sidebar Select', 'kreme' ),
							'std'         => '',
							'type'        => 'sidebar-select',
							'condition'   => 'shop_single_layout:not(full-width)',
							'section' => 'shop'
					);
	$settings[] = array(
							'id'          => 'shop_single_sidebar_width',
							'label'       => __( 'Single Sidebar Width', 'kreme' ),
							'desc'        => __( 'The width of the sidebar determined by <code>%</code> of <code>12</code>.', 'kreme' ),
							'type'        => 'numeric-slider',
							'min_max_step'=> '1,12,1',
							'condition'   => 'shop_single_layout:not(full-width)',
							'section' => 'shop'
					);
	$settings[] = array(
							'id'          => 'shop_single_sidebar_el_class',
							'label'       => __( 'Single Extra class name for Sidebar', 'kreme' ),
							'desc'        => __( 'Style particular content element differently - add a class name and refer to it in custom CSS..', 'kreme' ),
							'type'        => 'text',
							'condition'   => 'shop_single_layout:not(full-width)',
							'section' => 'shop'
					);
	
	
	$custom_settings['sections'] = $sections;
	$custom_settings['settings'] = $settings;
	
	return $custom_settings;
}