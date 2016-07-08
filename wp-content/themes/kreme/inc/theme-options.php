<?php
/**
 * Initialize the custom Theme Options.
 */
add_action ( 'init', 'kreme_options' );

/**
 * Build the custom settings & update OptionTree.
 *
 * @return void
 * @since 2.3.0
 */
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
			
			'sections' => array (
					array (
							'id' => 'general',
							'title' => __ ( 'General', 'kreme' )
					),
					array (
							'id' => 'header',
							'title' => __ ( 'Header', 'kreme' )
					),
					array (
							'id' => 'shop',
							'title' => __ ( 'Shop', 'kreme' )
					),
					array (
							'id' => 'blog',
							'title' => __ ( 'Blog', 'kreme' )
					),
					array (
							'id' => 'footer',
							'title' => __ ( 'Footer', 'kreme' )
					),
					array (
							'id' => 'typography',
							'title' => __ ( 'Typography', 'kreme' )
					),
			),
			'settings' => array (
					
					/**
					 * General
					 */ 
					array (
							'id' => 'logo',
							'label' => __ ( 'Logo', 'kreme' ),
							'desc' => __ ( 'Select an image file for your logo.', 'kreme' ),
							'std' => trailingslashit(get_template_directory_uri()) . 'assets/imgs/logo.png',
							'type' => 'upload',
							'section' => 'general',
					),
					/*
					array(
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
					),*/
					array(
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
					),
					array(
							'id'          => 'main_sidebar',
							'label'          => 'Sidebar Select',
							'type'        => 'sidebar-select',
							'section' => 'general',
							'condition'   => 'main_layout:not(full-width)'
					),
					array(
							'id'          => 'main_width',
							'label'       => __( 'Sidebar Width', 'kreme' ),
							'desc'        => __( 'The width of the sidebar determined by <code>%</code> of <code>12</code>.', 'kreme' ),
							'type'        => 'numeric-slider',
							'min_max_step'=> '1,12,1',
							'section' => 'general',
							'condition'   => 'main_layout:not(full-width)'
					),
					array(
							'id'          => 'main_el_class',
							'label'       => __( 'Extra class name for Sidebar', 'kreme' ),
							'desc'        => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'kreme' ),
							'type'        => 'text',
							'section' => 'general',
							'condition'   => 'main_layout:not(full-width)'
					),
					array(
							'id'          => 'main_boxed',
							'label'          => 'Boxed',
							'desc'        => __( 'Check this box to use Boxed. If left unchecked then full width is used.', 'kreme' ),
							'type'        => 'on-off',
							'std'			=> 'off',
							'section' => 'general'
					),
					array(
							'id'          => 'background_body',
							'label'       => __( 'Background for Body', 'kreme' ),
							'desc'        => __ ( 'Background used for the Body', 'kreme' ),
							'std'         => '',
							'type'        => 'background',
							'section'     => 'general',
					),
					array(
							'id'          => 'background_boxed',
							'label'       => __( 'Background for Boxed', 'kreme' ),
							'desc'        => __ ( 'Background used for the Boxed', 'kreme' ),
							'std'         => '',
							'type'        => 'background',
							'section'     => 'general',
							'condition'   => 'main_boxed:is(on)',
					),
					array(
							'id'          => 'background_main',
							'label'       => __( 'Background for Main Content', 'kreme' ),
							'desc'        => __ ( 'Background used for the Main Content', 'kreme' ),
							'std'         => '',
							'type'        => 'background',
							'section'     => 'general',
					),
					array(
							'id'          => 'main_container',
							'label'          => 'Containers',
							'desc'        => __( 'Use <code>.container-fluid</code> for a full width container, spanning the entire width of your viewport. If left unchecked then use <code>.container</code> for a responsive fixed width container.', 'kreme' ),
							'type'        => 'on-off',
							'std'			=> 'off',
							'section' => 'general'
					),
					array (
							'label' => __ ( 'Add Sidebar', 'kreme' ),
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
					),
					array(
					        'id'          => 'custom_css',
					        'label'       => __( 'Custom CSS', 'kreme' ),
							'desc'        => __( 'Paste your CSS code, do not include any tags or HTML in the field. Any custom CSS entered here will override the theme CSS. In some cases, the !important tag may be needed.', 'kreme' ),
					        'std'         => '',
					        'type'        => 'css',
							'rows'        => '20',
					        'section'     => 'general',
					),//End General
					
					
					/**
					 * Header 
					 */
					array(
							'id'          => 'background_header',
							'label'       => __( 'Background for Header', 'kreme' ),
							'desc'        => __ ( 'Background used for Page Header', 'kreme' ),
							'std'         => '',
							'type'        => 'background',
							'section'     => 'header',
					),
					array(
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
									array(
											'value'       => 'style-v2',
											'label'       => __( 'Style v2', 'kreme' ),
									),
									array(
											'value'       => 'style-v3',
											'label'       => __( 'Style v3', 'kreme' ),
									),
									array(
											'value'       => 'style-v4',
											'label'       => __( 'Style v4', 'kreme' ),
									),
									array(
											'value'       => 'style-v5',
											'label'       => __( 'Style v5', 'kreme' ),
									),
									array(
											'value'       => 'style-v6',
											'label'       => __( 'Style v6', 'kreme' ),
									),
									array(
											'value'       => 'style-v7',
											'label'       => __( 'Style v7', 'kreme' ),
									),
							)
					),
					array(
							'id'          => 'background_header_top',
							'label'       => __( 'Background for Header Top', 'kreme' ),
							'std'         => '',
							'type'        => 'background',
							'section'     => 'header',
					),
					array(
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
					),
					array(
							'id'          => 'background_header_middle',
							'label'       => __( 'Background for Header Middle', 'kreme' ),
							'std'         => '',
							'type'        => 'background',
							'section'     => 'header',
					),
					array(
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
					),
					array(
							'id'          => 'background_header_bottom',
							'label'       => __( 'Background for Header Bottom', 'kreme' ),
							'std'         => '',
							'type'        => 'background',
							'section'     => 'header',
					),
					array(
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
					),
					// End Header
					
					
					/**
					 * Shop
					 */
					array(
							'id'          => 'shop_background_title',
							'label'       => __( 'Background for Title', 'kreme' ),
							'desc'        => __ ( 'Background used for Title', 'kreme' ),
							'std'         => '',
							'type'        => 'background',
							'section'     => 'shop',
					),
					/*
					array(
							'id'          => 'shop_sidebar_top',
							'label'       => __( 'Sidebar for Top Content', 'kreme' ),
							'std'         => '',
							'type'        => 'sidebar-select',
							'section'     => 'shop',
					),*/
					
					array(
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
					),
					array(
							'id'          => 'shop_sidebar',
							'label'       => __( 'Sidebar Select', 'kreme' ),
							'std'         => '',
							'type'        => 'sidebar-select',
							'condition'   => 'shop_layout:not(full-width)',
							'section' => 'shop'
					),
					array(
							'id'          => 'shop_sidebar_width',
							'label'       => __( 'Sidebar Width', 'kreme' ),
							'desc'        => __( 'The width of the sidebar determined by <code>%</code> of <code>12</code>.', 'kreme' ),
							'type'        => 'numeric-slider',
							'min_max_step'=> '1,12,1',
							'condition'   => 'shop_layout:not(full-width)',
							'section' => 'shop'
					),
					array(
							'id'          => 'shop_sidebar_el_class',
							'label'       => __( 'Extra class name for Sidebar', 'kreme' ),
							'desc'        => __( 'Style particular content element differently - add a class name and refer to it in custom CSS..', 'kreme' ),
							'type'        => 'text',
							'condition'   => 'shop_layout:not(full-width)',
							'section' => 'shop'
					),
					array(
							'id'          => 'shop_items',
							'label'       => __( 'Per page', 'kreme' ),
							'desc'        => __( 'The "per_page" shortcode determines how many products to show on the page.', 'kreme' ),
							'std'         => '12',
							'type'        => 'text',
							'section'     => 'shop',
					),
					/*
					array(
							'id'          => 'shop_columns',
							'label'       => __( 'Columns', 'kreme' ),
							'desc'        => __( 'The columns attribute controls how many columns wide the products should be before wrapping.', 'kreme' ),
							'std'         => '4',
							'type'        => 'text',
							'section'     => 'shop',
					),*/
					array(
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
					),
					array(
							'id'          => 'shop_single_sidebar',
							'label'       => __( 'Single Sidebar Select', 'kreme' ),
							'std'         => '',
							'type'        => 'sidebar-select',
							'condition'   => 'shop_single_layout:not(full-width)',
							'section' => 'shop'
					),
					array(
							'id'          => 'shop_single_sidebar_width',
							'label'       => __( 'Single Sidebar Width', 'kreme' ),
							'desc'        => __( 'The width of the sidebar determined by <code>%</code> of <code>12</code>.', 'kreme' ),
							'type'        => 'numeric-slider',
							'min_max_step'=> '1,12,1',
							'condition'   => 'shop_single_layout:not(full-width)',
							'section' => 'shop'
					),
					array(
							'id'          => 'shop_single_sidebar_el_class',
							'label'       => __( 'Single Extra class name for Sidebar', 'kreme' ),
							'desc'        => __( 'Style particular content element differently - add a class name and refer to it in custom CSS..', 'kreme' ),
							'type'        => 'text',
							'condition'   => 'shop_single_layout:not(full-width)',
							'section' => 'shop'
					),
					// End Shop
					
					
					/**
					 * Blog
					 */
					array(
							'id'          => 'blog_background_title',
							'label'       => __( 'Background for Title', 'kreme' ),
							'desc'        => __ ( 'Background used for Title', 'kreme' ),
							'std'         => '',
							'type'        => 'background',
							'section'     => 'blog',
					),
					array(
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
					),
					array(
							'id'          => 'blog_sidebar',
							'label'       => __( 'Sidebar Select', 'kreme' ),
							'std'         => '',
							'type'        => 'sidebar-select',
							'condition'   => 'blog_layout:not(full-width)',
							'section' => 'blog'
					),
					array(
							'id'          => 'blog_sidebar_width',
							'label'       => __( 'Sidebar Width', 'kreme' ),
							'desc'        => __( 'The width of the sidebar determined by <code>%</code> of <code>12</code>.', 'kreme' ),
							'type'        => 'numeric-slider',
							'min_max_step'=> '1,12,1',
							'condition'   => 'blog_layout:not(full-width)',
							'section' => 'blog'
					),
					array(
							'id'          => 'blog_sidebar_el_class',
							'label'       => __( 'Extra class name for Sidebar', 'kreme' ),
							'desc'        => __( 'Style particular content element differently - add a class name and refer to it in custom CSS..', 'kreme' ),
							'type'        => 'text',
							'condition'   => 'blog_layout:not(full-width)',
							'section' => 'blog'
					),
					// End Blog
					
					/**
					 * Footer 
					 */
					array(
							'id'          => 'background_footer',
							'label'       => __( 'Background for Footer', 'kreme' ),
							'type'        => 'background',
							'section'     => 'footer',
					),
					array(
							'id'          => 'background_footer_top',
							'label'       => __( 'Background for Footer Top', 'kreme' ),
							'type'        => 'background',
							'section'     => 'footer',
					),
					array(
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
					),
					array(
							'id'          => 'background_footer_middle',
							'label'       => __( 'Background for Footer Middle', 'kreme' ),
							'type'        => 'background',
							'section'     => 'footer',
					),
					array(
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
					),
					array (
							'id' => 'copyright',
							'label' => __ ( 'Copyright', 'kreme' ),
							'desc' => __ ( 'Enter the text that displays in the copyright bar. HTML markup can be used.', 'kreme' ),
							'type' => 'textarea',
							'section' => 'footer',
							'rows' => '10',
					),
					/* End Footer */
					
					/**
					 * Typography
					 */
					array (
							'id' => 'google_fonts',
							'label' => __ ( 'Google Fonts', 'kreme' ),
							'desc' => sprintf ( __ ( 'The Google Fonts option type will dynamically enqueue any number of Google Web Fonts into the document %1$s. As well, once the option has been saved each font family will automatically be inserted into the %2$s array for the Typography option type. You can further modify the font stack by using the %3$s filter, which is passed the %4$s, %5$s, and %6$s parameters. The %6$s parameter is being passed from %7$s, so it will be the ID of a Typography option type. This will allow you to add additional web safe fonts to individual font families on an as-need basis.', 'kreme' ), '<code>HEAD</code>', '<code>font-family</code>', '<code>ot_google_font_stack</code>', '<code>$font_stack</code>', '<code>$family</code>', '<code>$field_id</code>', '<code>ot_recognized_font_families</code>' ),
							'std' => '',
							'type' => 'google-fonts',
							'section' => 'typography',
							'operator' => 'and'
					),
					array (
							'id' => 'typography_body',
							'label' => __ ( 'Typography Body', 'kreme' ),
							'desc' => __ ( 'These options will be added to <code>body</code>', 'kreme' ),
							'std' => '',
							'type' => 'typography',
							'section' => 'typography',
							'operator' => 'and'
					),
					array (
							'id' => 'typography_heading',
							'label' => __ ( 'Typography Heading', 'kreme' ),
							'desc' => __ ( 'These options will be added to <code>H1, H2, H3, H4, H5, H6</code>', 'kreme' ),
							'std' => '',
							'type' => 'typography',
							'section' => 'typography',
							'operator' => 'and'
					),
					array (
							'id' => 'featured_color',
							'label' => __ ( 'Featured Color', 'kreme' ),
							'desc' => __ ( 'Choose featured color for the theme.', 'kreme' ),
							'std' => '',
							'type' => 'colorpicker',
							'section' => 'typography',
							'operator' => 'and'
					)
					/* End Typography */
			) 
	);
	
	/* allow settings to be filtered before saving */
	$custom_settings = apply_filters ( ot_settings_id () . '_args', $custom_settings );
	
	/* settings are not the same update the DB */
	if ($saved_settings !== $custom_settings) {
		update_option ( ot_settings_id (), $custom_settings );
	}
	
	/* Lets OptionTree know the UI Builder is being overridden */
	global $ot_has_customTheme_options;
	$ot_has_customTheme_options = true;
}