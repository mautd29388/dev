<?php

add_filter( 'kreme_init_options_settings', 'kreme_init_options_typography');

function kreme_init_options_typography($custom_settings){
	
	$sections = $custom_settings['sections'];
	$settings = $custom_settings['settings'];
	
	$sections[] = array (
							'id' => 'typography',
							'title' => __ ( 'Typography', 'kreme' )
					);
	
	$settings[] = array (
							'id' => 'google_fonts',
							'label' => __ ( 'Google Fonts', 'kreme' ),
							'desc' => sprintf ( __ ( 'The Google Fonts option type will dynamically enqueue any number of Google Web Fonts into the document %1$s. As well, once the option has been saved each font family will automatically be inserted into the %2$s array for the Typography option type. You can further modify the font stack by using the %3$s filter, which is passed the %4$s, %5$s, and %6$s parameters. The %6$s parameter is being passed from %7$s, so it will be the ID of a Typography option type. This will allow you to add additional web safe fonts to individual font families on an as-need basis.', 'kreme' ), '<code>HEAD</code>', '<code>font-family</code>', '<code>ot_google_font_stack</code>', '<code>$font_stack</code>', '<code>$family</code>', '<code>$field_id</code>', '<code>ot_recognized_font_families</code>' ),
							'std' => '',
							'type' => 'google-fonts',
							'section' => 'typography',
							'operator' => 'and'
					);
	$settings[] = array (
							'id' => 'typography_body',
							'label' => __ ( 'Typography Body', 'kreme' ),
							'desc' => __ ( 'These options will be added to <code>body</code>', 'kreme' ),
							'std' => '',
							'type' => 'typography',
							'section' => 'typography',
							'operator' => 'and'
					);
	$settings[] = array (
							'id' => 'typography_heading',
							'label' => __ ( 'Typography Heading', 'kreme' ),
							'desc' => __ ( 'These options will be added to <code>H1, H2, H3, H4, H5, H6</code>', 'kreme' ),
							'std' => '',
							'type' => 'typography',
							'section' => 'typography',
							'operator' => 'and'
					);
	$settings[] = array (
							'id' => 'featured_color',
							'label' => __ ( 'Featured Color', 'kreme' ),
							'desc' => __ ( 'Choose featured color for the theme.', 'kreme' ),
							'std' => '',
							'type' => 'colorpicker',
							'section' => 'typography',
							'operator' => 'and'
					);
	
	
	$custom_settings['sections'] = $sections;
	$custom_settings['settings'] = $settings;
	
	return $custom_settings;
}