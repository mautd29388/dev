<?php
class mTheme_Shortcode {
	
	public static $int = 0;
	
	public $vc_column_width_list = array();
	
	public $orderby = array();
	
	public $order = array();
	
	public function __construct() {
		
		// Define shortcodes
		$shortcodes = array (
				'mTheme_titles' 		=> array($this, 'titles'),
				'mTheme_loop_items'	=> array($this, 'loop_items'),
				'mTheme_nutrition_philosophy'	=> array($this, 'nutrition_philosophy'),
				'mTheme_products' 	=> array($this, 'products'),
				'mTheme_posts' 		=> array($this, 'posts'),
				'mTheme_posttypes' 	=> array($this, 'media_library'),
				'mTheme_section_radius' 	=> array($this, 'section_radius'),
				//'mTheme_maps' 	=> array($this, 'maps'),
		);
		
		foreach ( $shortcodes as $shortcode => $function ) {
			add_shortcode ( apply_filters ( "{$shortcode}_shortcode_tag", $shortcode ), $function );
		}
		
		add_filter ( 'the_content', array ( $this, 'shortcode_empty_paragraph_fix' ) );
		add_action ( 'vc_before_init', array ( $this, 'add_shortcodes_to_vc' ) );
		
		
		/**
		 * Posts
		 * */
		//Filters For autocomplete param:
		//For suggestion: vc_autocomplete_[shortcode_name]_[param_name]_callback
		add_filter( 'vc_autocomplete_mTheme_posts_cat_ids_callback', array( $this, 'postsCategoryCategoryAutocompleteSuggester', ), 10, 1 ); // Get suggestion(find). Must return an array
		add_filter( 'vc_autocomplete_mTheme_posts_cat_ids_render', array( $this, 'postsCategoryCategoryRenderByIdExact', ), 10, 1 ); // Render exact category by id. Must return an array (label,value)
		
		//Filters For autocomplete param:
		//For suggestion: vc_autocomplete_[shortcode_name]_[param_name]_callback
		add_filter( 'vc_autocomplete_mTheme_posts_ids_callback', array( $this,'postsIdAutocompleteSuggester',), 10, 1 ); // Get suggestion(find). Must return an array
		add_filter( 'vc_autocomplete_mTheme_posts_ids_render', array( $this, 'postsIdAutocompleteRender', ), 10, 1 ); // Render exact product. Must return an array (label,value)
		// End Posts
		
		
		/**
		 * Products
		 * */
		//Filters For autocomplete param:
		//For suggestion: vc_autocomplete_[shortcode_name]_[param_name]_callback
		add_filter( 'vc_autocomplete_mTheme_products_product_cat_ids_callback', array( 'Vc_Vendor_Woocommerce', 'productCategoryCategoryAutocompleteSuggester', ), 10, 1 ); // Get suggestion(find). Must return an array
		add_filter( 'vc_autocomplete_mTheme_products_product_cat_ids_render', array( 'Vc_Vendor_Woocommerce', 'productCategoryCategoryRenderByIdExact', ), 10, 1 ); // Render exact category by id. Must return an array (label,value)
		
		//Filters For autocomplete param:
		//For suggestion: vc_autocomplete_[shortcode_name]_[param_name]_callback
		add_filter( 'vc_autocomplete_mTheme_products_product_ids_callback', array( 'Vc_Vendor_Woocommerce','productIdAutocompleteSuggester',), 10, 1 ); // Get suggestion(find). Must return an array
		add_filter( 'vc_autocomplete_mTheme_products_product_ids_render', array( 'Vc_Vendor_Woocommerce', 'productIdAutocompleteRender', ), 10, 1 ); // Render exact product. Must return an array (label,value)
		//For param: ID default value filter
		add_filter( 'vc_form_fields_render_field_mTheme_products_product_ids_param_value', array( 'Vc_Vendor_Woocommerce', 'productsIdsDefaultValue', ), 10, 4 ); // Defines default value for param if not provided. Takes from other param value.
		// End Products
	}
	
	/**
	 * Get Template Part
	 * */
	public function mTheme_get_template_part($slug, $name = '') {
		$template_path = untrailingslashit ( plugin_dir_path ( __FILE__ ) );
		
		$template = '';
		
		$name = ( string ) $name;
		if ('' !== $name) {
			$template = $template_path . "/contents/{$slug}-{$name}.php";
		} else
			$template = $template_path . "/contents/{$slug}.php";
		
		return $template;
	}
	
	/**
	 * empty paragraph fix
	 * */
	public function shortcode_empty_paragraph_fix($content) {
		$array = array (
				'<p>[' => '[',
				']</p>' => ']',
				']<br />' => ']' 
		);
		
		$content = strtr ( $content, $array );
		
		return $content;
	}
	
	/**
	 * Shortcode titles
	 * */
	public function titles ($atts, $content){
	
		self::$int++;
		$int = self::$int;
	
		$atts = shortcode_atts ( array (
				'title'		=> '',
				'styles'	=> 'v1',
				'el_class'	=> '',
				'css'		=> ''
		), $atts );
	
		$parent_class = array();
		$parent_class[] = vc_shortcode_custom_css_class( $atts['css']);
		if ( !empty($atts['el_class']) ) {
			$parent_class[] = $atts['el_class'];
		}
		
		ob_start();
	
		$template = self::mTheme_get_template_part ( 'titles/title', $atts['styles'] );
		if ( file_exists("{$template}") ) {
			require "{$template}";
		}
	
		return ob_get_clean ();
	}
	
	/**
	 * Shortcode loop_items
	 * */
	public function loop_items ($atts){
		self::$int++;
		$int = self::$int;
		
		$atts = shortcode_atts ( array (
				'title'		=> '',
				'styles'	=> 'welcome',
				'welcome'	=> '',
				'testimonial' => '',
				'el_class'	=> '',
				'css'		=> '',
				'width'		=> '1/3',
				'offset'	=> ''
		), $atts );
		
		// Get Class
		$parent_class = $item_class = array();
		$parent_class[] = vc_shortcode_custom_css_class( $atts['css']);
		if ( !empty($atts['el_class']) ) {
			$parent_class[] = $atts['el_class'];
		}
	
		$width = '';
		$width = wpb_translateColumnWidthToSpan( $atts['width'] );
		$width = vc_column_offset_class_merge( $atts['offset'], $width );
		$__width = array();
		$__width = explode(' ', $width);
	
		foreach ( $__width as $__item_class ) {
			if ( strpos($__item_class, 'hidden') > 0 ) {
				$parent_class[] = $__item_class;
			} else {
				$item_class[] = $__item_class;
			}
		}
		// End Class
	
		// Get Param Group
		$param_name = $atts['styles'];
		$values = array();
		$values = vc_param_group_parse_atts($atts[$param_name]);
		
		if ( !is_array($values) ) $values = array();
		// End Param Group
		
		ob_start();
		
		$template = self::mTheme_get_template_part ( 'loop-items/loop-item', $atts['styles'] );
		if ( file_exists("{$template}") ) {
			require "{$template}";
		}
		
		return ob_get_clean ();
	}
	
	/**
	 * Shortcode nutrition_philosophy
	 * */
	public function nutrition_philosophy ($atts){
		self::$int++;
		$int = self::$int;
	
		$atts = shortcode_atts ( array (
				'title'		=> '',
				'banner'	=> '',
				'box_left'	=> '',
				'box_right'	=> '',
				'el_class'	=> '',
				'css'		=> '',
		), $atts );
	
		// Get Class
		$parent_class = $item_class = array();
		$parent_class[] = vc_shortcode_custom_css_class( $atts['css']);
		if ( !empty($atts['el_class']) ) {
			$parent_class[] = $atts['el_class'];
		}
		// End Class
	
		// Get Param Group
		$box_left = $box_right = array();
		$box_left = vc_param_group_parse_atts($atts['box_left']);
		$box_right = vc_param_group_parse_atts($atts['box_right']);
	
		if ( !is_array($box_left) ) $box_left = array();
		if ( !is_array($box_right) ) $box_right = array();
		// End Param Group
	
		ob_start();
	
		$template = self::mTheme_get_template_part ( 'nutrition-philosophy/nutrition-philosophy' );
		if ( file_exists("{$template}") ) {
			require "{$template}";
		}
	
		return ob_get_clean ();
	}
	
	function section_radius($atts) {
		
		self::$int++;
		$int = self::$int;
		
		$atts = shortcode_atts ( array (
				'styles' 			=> '',
				'el_class' 			=> '',
		), $atts );
		
		return '<div class="'. $atts['styles'] .' section-radius '. $atts['el_class'] .'"></div>';
	}
	
	public function media_library($atts) {
		
		self::$int++;
		$int = self::$int;
		
		$atts = shortcode_atts ( array (
				'title' 			=> '',
				'images' 			=> '',
				'layout' 			=> '',
				'after_content' 	=> '',
				'before_content' 	=> '',
				'img_size' 			=> 'thumbnail',
				'el_class' 			=> '',
				'css' 				=> '',
				'width' 			=> '1/3',
				'offset' 			=> ''
		), $atts );
		
		ob_start();
		
		$template = self::mTheme_get_template_part ( 'content-media_library', $atts['layout'] );
		if ( file_exists("{$template}") ) {
			require "{$template}";
		}
		
		return ob_get_clean ();
	}
	
	public function posts ($atts, $contents){
	
		self::$int++;
		$int = self::$int;
	
		$atts = shortcode_atts ( array (
				'title' 			=> '',
				'layout' 			=> '',
				//'styles' 			=> '',
				'group'				=> 'recent',
				'cat_ids'			=> '',
				'ids'				=> '',
				'orderby'			=> 'date',
				'order'				=> 'DESC',
				'after_content' 	=> '',
				'before_content' 	=> '',
				'max_items' 		=> '10',
				'img_size' 			=> 'thumbnail',
				'el_class' 			=> '',
				'css' 				=> '',
				'width' 			=> '1/3',
				'offset' 			=> ''
		), $atts );
	
		// Add Class
		$width = $css = '';
		$width = wpb_translateColumnWidthToSpan( $atts['width'] );
		$width = vc_column_offset_class_merge( $atts['offset'], $width );
		$__width = array();
		$__width = explode(' ', $width);
		$parent_class = array();
		$item_class = array();
		if ( is_array($__width) ) {
			foreach ( $__width as $__class ) {
				if ( strpos($__class, 'hidden') > 0 ) {
					$parent_class[] = $__class;
				} else {
					$item_class[] = $__class;
				}
			}
	
			//$width = implode($item_class, ' ');
		}
	
		$parent_class[] = vc_shortcode_custom_css_class( $atts['css']);
		$parent_class[] = $atts['styles'];
	
		if ( !empty($atts['el_class']) ) {
			$parent_class[] = $atts['el_class'];
		}
	
		$layout = '';
		if ( $atts['layout'] == 'tab' ) {
			$parent_class[] = 'mTheme-posts-tab';
		} else{
			$layout = $atts['layout'];
		}
	
		$columns = kreme_translateColumnWidthVC($atts['width']);
	
		// Query
		$args = array(
				'post_type'           => 'post',
				'post_status'         => 'publish',
				'posts_per_page'      => $atts['max_items'],
				'ignore_sticky_posts' => 1,
		);
			
		if ( $atts['group'] == 'categories' ) {
			$cat_ids = '';
			if ( ! empty( $atts['cat_ids'] ) ) {
				$cat_ids = array_map( 'trim', explode( ',', $atts['cat_ids'] ) );
			}
			
			$args = array_merge($args, array(
					'orderby'           => $atts['orderby'],
					'order'             => $atts['order'],
					'category__in'		=> $cat_ids
			));
			
		} elseif ( $atts['group'] == 'posts' ) {
			$post__in = '';
			if ( ! empty( $atts['ids'] ) ) {
				$post__in = array_map( 'trim', explode( ',', $atts['ids'] ) );
			}
			
			$args = array_merge($args, array(
					'post__in'				=> 	$post__in
			));
			
		} else {
			$args = array_merge($args, array(
					'orderby'             => $atts['orderby'],
					'order'               => $atts['order'],
			));
		}
		
		$query = new WP_Query( $args );
	
	
		ob_start();
	
		echo '<div id="mtheme-posts-'. $int .'" class="mtheme-posts '. join($parent_class, ' ') .'">';
	
		if ( !empty($atts['title']) )
			echo wpb_widget_title( array( 'title' => $atts['title'], 'extraclass' => 'wpb_singleimage_heading' ) );
	
		if ( !empty($atts['before_content']) )
			echo '<div class="before-content">'. $atts['before_content'] .'</div>';
	
		echo '<div class="mtheme-posts-inner">';
	
		$template = self::mTheme_get_template_part ( 'content-posts', $layout ); 
		if ( file_exists("{$template}") ) {
	
			if ( $query->have_posts () ) {
				require "{$template}";
			} else
				echo __ ( 'Not empty', 'mTheme' );
		}
			
		echo '</div>';
	
		if ( !empty($contents) )
			echo '<div class="after-content">'. $contents .'</div>';
	
		echo "</div>";
	
		wp_reset_postdata();
	
		return ob_get_clean ();
	}
	
	public function products ($atts, $contents){
	
		self::$int++;
		$int = self::$int;
	
		if ( !class_exists( 'WooCommerce' ) )
			return false;
		
		$atts = shortcode_atts ( array (
				'title' 				=> '',
				'product_layout' 		=> '',
				//'product_styles' 		=> '',
				'product_banner'		=> '',
				'product_banner_align' 	=> 'center',
				'product_group'			=> 'products_categories',
				'product_cat_ids'		=> '',
				'product_ids'			=> '',
				'product_skus'			=> '',
				'product_orderby'		=> 'date',
				'product_order'			=> 'DESC',
				'after_content' 		=> '',
				'before_content' 		=> '',
				'max_items' 			=> '10',
				'img_size' 				=> 'shop_catalog_image_size',
				'el_class' 				=> '',
				'css' 					=> '',
				'width' 				=> '1/3',
				'offset' 				=> ''
		), $atts );
	
		// Add Class
		$width = $css = '';
		$width = wpb_translateColumnWidthToSpan( $atts['width'] );
		$width = vc_column_offset_class_merge( $atts['offset'], $width );
		$__width = array();
		$__width = explode(' ', $width);
		$parent_class = array();
		$item_class = array();
		if ( is_array($__width) ) {
			foreach ( $__width as $__class ) {
				if ( strpos($__class, 'hidden') > 0 ) {
					$parent_class[] = $__class;
				} else {
					$item_class[] = $__class;
				}
			}
		
			//$width = implode($item_class, ' ');
		}
		
		$parent_class[] = vc_shortcode_custom_css_class( $atts['css']);
		$parent_class[] = $atts['product_styles'];
		$parent_class[] = 'woocommerce';
		
		if ( !empty($atts['el_class']) ) {
			$parent_class[] = $atts['el_class'];
		}
		
		$layout = '';
		if ( $atts['product_layout'] == 'tab' ) {
			$parent_class[] = 'mTheme-products-tab';
		} else{
			$layout = $atts['product_layout'];
		}
		
		$columns = kreme_translateColumnWidthVC($atts['width']);
		
		//$css_classes = array(
				//'wpb_column',
				//'vc_column_container',
				//$width
		//);
		
		// Query
		$args = array(
				'post_type'           => 'product',
				'post_status'         => 'publish',
				'posts_per_page'      => $atts['max_items'],
		);
			
		if ( $atts['product_group'] == 'recent_products' ) {
		
			$args = array_merge($args, array(
					'ignore_sticky_posts' => 1,
					'orderby'             => $atts['product_orderby'],
					'order'               => $atts['product_order'],
					'meta_query'          => WC()->query->get_meta_query()
			));
		
		} elseif ( $atts['product_group'] == 'featured_products' ) {
		
			$meta_query   = WC()->query->get_meta_query();
			$meta_query[] = array(
					'key'   => '_featured',
					'value' => 'yes'
			);
		
			$args = array_merge($args, array(
					'ignore_sticky_posts' => 1,
					'orderby'             => $atts['product_orderby'],
					'order'               => $atts['product_order'],
					'meta_query'          => $meta_query
			));
		
		} elseif ( $atts['product_group'] == 'sale_products' ) {
		
			$args = array_merge($args, array(
					'no_found_rows' 	=> 1,
					'orderby'           => $atts['product_orderby'],
					'order'             => $atts['product_order'],
					'meta_query'        => WC()->query->get_meta_query(),
					'post__in'			=> array_merge( array( 0 ), wc_get_product_ids_on_sale() )
			));
		
		} elseif ( $atts['product_group'] == 'best_selling_products' ) {
		
			$args = array_merge($args, array(
					'ignore_sticky_posts' => 1,
					'meta_key'            => 'total_sales',
					'orderby'             => 'meta_value_num',
					'meta_query'          => WC()->query->get_meta_query()
			));
		
		} elseif ( $atts['product_group'] == 'top_rated_products' ) {
		
			$args = array_merge($args, array(
					'ignore_sticky_posts' => 1,
					'orderby'             => $atts['product_orderby'],
					'order'               => $atts['product_order'],
					'meta_query'          => WC()->query->get_meta_query(),
			));
		
			add_filter( 'posts_clauses', array( 'WC_Shortcodes', 'order_by_rating_post_clauses' ) );
		
		}  elseif ( $atts['product_group'] == 'products_categories' ) {
		
			if ( isset( $atts['product_cat_ids'] ) ) {
				$term_ids = explode( ',', $atts['product_cat_ids'] );
				$term_ids = array_map( 'trim', $term_ids );
			} else {
				$term_ids = array();
			}
		
			$args = array_merge($args, array(
					'ignore_sticky_posts' => 1,
					'orderby'             => $atts['product_orderby'],
					'order'               => $atts['product_order'],
					'meta_query'          => WC()->query->get_meta_query(),
					'tax_query' 			=> array(
							array(
									'taxonomy' 		=> 'product_cat',
									'terms' 		=> $term_ids,
									'field' 		=> 'term_id',
							)
					)
			));
		
		} else {
		
			$post__in = '';
			if ( ! empty( $atts['product_ids'] ) ) {
				$post__in = array_map( 'trim', explode( ',', $atts['product_ids'] ) );
			}
		
			$args = array_merge($args, array(
					'ignore_sticky_posts' 	=> 1,
					'meta_query'          	=> WC()->query->get_meta_query(),
					'post__in'				=> 	$post__in
			));
		
			if ( ! empty( $atts['product_skus'] ) ) {
				$args['meta_query'][] = array(
						'key'     => '_sku',
						'value'   => array_map( 'trim', explode( ',', $atts['product_skus'] ) ),
						'compare' => 'IN'
				);
			}
		}
			
		$query = new WP_Query( $args );
		
		
		ob_start();
		
		echo '<div id="mtheme-products-'. $int .'" class="mtheme-products '. join($parent_class, ' ') .'">';
		
		if ( !empty($atts['title']) || !empty($atts['before_content']) ) {
			echo '<div class="mtheme-title">';
			if ( !empty($atts['title']) )
				echo wpb_widget_title( array( 'title' => $atts['title'], 'extraclass' => 'wpb_singleimage_heading' ) );
			
			if ( !empty($atts['before_content']) )
				echo '<div class="before-content">'. $atts['before_content'] .'</div>';
			
			echo '</div>';
		}
		
		echo '<div class="mtheme-products-inner">';
		
			$template = self::mTheme_get_template_part ( 'content-products', $layout );
			if ( file_exists("{$template}") ) {
				
				if ( $query->have_posts () ) {
					require "{$template}";
				} else
					echo __ ( 'Not empty', 'mTheme' );
			}
			
		echo '</div>';
				
		if ( !empty($contents) )
			echo '<div class="after-content">'. $contents .'</div>';
		
		echo "</div>";
		
		if ( $atts['product_group'] == 'top_rated_products' )
			remove_filter( 'posts_clauses', array( 'WC_Shortcodes', 'order_by_rating_post_clauses' ) );
			
		
		wp_reset_postdata();
		
		return ob_get_clean ();
	}
	
	public function maps($atts, $content = '') {
		$atts = shortcode_atts ( array (
				'LatLng' => '51.5042389, -0.1061977',
				'zoom' => 13,
				'icon' => trailingslashit( get_template_directory_uri () ) . 'assets/imgs/icon-map.png',
				'class_name' => '',
		), $atts );
		
		if ( !empty($content) )
			$content = '<p>Email: noreply@gmail.com<br>Phone: +800 - 568 - 8989<br>96 Isabella ST, London, SE 1 8DD</p>';
		
		wp_enqueue_script('google-maps-js');
		wp_enqueue_script('maps-js');
		
		$mtheme_maps = array();
		$mtheme_maps['LatLng'] = $atts['LatLng'];
		$mtheme_maps['desc_contact'] = $content;
		$mtheme_maps['zoom'] = $atts['zoom'];
		$mtheme_maps['icon'] = $atts['icon'];
		
		wp_localize_script ( 'maps-js', 'mtheme_maps', $mtheme_maps );
		
		ob_start();
		
		echo '<div class="maps '. $atts['class_name'] .'"><div id="map-canvas"></div></div>';
		
		return ob_get_clean ();
	}
	

	/**
	 * Add Shortcodes to Visual Composer
	 */
	public function add_shortcodes_to_vc() {
		
		$this->vc_column_width_list = array(
				__( '1 column - 1/12', 'mTheme' ) => '1/12',
				__( '2 columns - 1/6', 'mTheme' ) => '1/6',
				__( '3 columns - 1/4', 'mTheme' ) => '1/4',
				__( '4 columns - 1/3', 'mTheme' ) => '1/3',
				__( '5 columns - 5/12', 'mTheme' ) => '5/12',
				__( '6 columns - 1/2', 'mTheme' ) => '1/2',
				__( '7 columns - 7/12', 'mTheme' ) => '7/12',
				__( '8 columns - 2/3', 'mTheme' ) => '2/3',
				__( '9 columns - 3/4', 'mTheme' ) => '3/4',
				__( '10 columns - 5/6', 'mTheme' ) => '5/6',
				__( '11 columns - 11/12', 'mTheme' ) => '11/12',
				__( '12 columns - 1/1', 'mTheme' ) => '1/1',
		);
		
		$this->orderby = array(
				__( 'Date', 'mTheme' ) => 'date',
				__( 'ID', 'mTheme' ) => 'ID',
				__( 'Author', 'mTheme' ) => 'author',
				__( 'Title', 'mTheme' ) => 'title',
				__( 'Modified', 'mTheme' ) => 'modified',
				__( 'Random', 'mTheme' ) => 'rand',
				__( 'Comment count', 'mTheme' ) => 'comment_count',
				__( 'Menu order', 'mTheme' ) => 'menu_order',
		);
		
		$this->order = array(
				__( 'Descending', 'mTheme' ) => 'DESC',
				__( 'Ascending', 'mTheme' ) => 'ASC',
		);
		
		
		/**
		 * Title
		 * */
		vc_map ( $this->add_shortcodes_to_vc_titles()); // Title
		
		/**
		 * loop items
		 * */
		vc_map($this->add_shortcodes_to_vc_loop_items());
		
		/**
		 * Nutrition philosophy
		 * */
		vc_map($this->add_shortcodes_to_vc_nutrition_philosophy());
		
		vc_map($this->add_shortcodes_to_vc_section_radius());
		
		/**
		 * Media Library
		 * */
		vc_map ( $this->add_shortcodes_to_vc_media() ); // Media Library
		
		
		/**
		 * Posts
		 * */
		vc_map ( $this->add_shortcodes_to_vc_posts() ); // Posts
		
		
		/**
		 * Products
		 * */
		if ( class_exists( 'WooCommerce' ) ) {
			vc_map ( $this->add_shortcodes_to_vc_products() );
		} // Products
		
	}

	
	/**
	 * Title
	 * */
	public function add_shortcodes_to_vc_titles() {
	
		return array (
				'name' => __ ( 'mTheme Titles', 'crater' ),
				'base' => 'mTheme_titles',
				'category' => __ ( 'mTheme', 'crater' ),
				'icon' => 'vc_element-icon icon-wpb-atm',
				"params" => array(
						array(
								'type' 			=> 'textfield',
								'heading' 		=> __( 'Title', 'crater' ),
								'param_name' 	=> 'title',
								'admin_label' => true,
						),
						array(
								'type' 			=> 'dropdown',
								'heading' 		=> __( 'Styles', 'crater' ),
								'param_name' 	=> 'styles',
								'value' 		=> array(
										__( 'Style v1', 'crater' ) 	=> 'v1',
										__( 'Style v2', 'crater' ) 	=> 'v2',
								),
						),
						array(
								'type' => 'textarea',
								'heading' => __( 'Sub Title', 'crater' ),
								'param_name' => 'content',
								'value' => '',
						),
						array(
								'type' => 'textfield',
								'heading' => __( 'Extra class name', 'crater' ),
								'param_name' => 'el_class',
								'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'crater' )
						),
						array(
								'type' => 'css_editor',
								'heading' => __( 'CSS box', 'mTheme' ),
								'param_name' => 'css',
								'group' => __( 'Design Options', 'mTheme' )
						),
				),
		);
	}
	
	/**
	 * loop_items
	 * */
	public function add_shortcodes_to_vc_loop_items() {
	
		$vc_column_width_list 	= $this->vc_column_width_list;
		
		return array(
				'name' => __( 'mTheme Loop Items', 'js_composer' ),
				'base' => 'mTheme_loop_items',
				'icon' => 'vc_element-icon icon-wpb-atm',
				'category' => __( 'mTheme', 'js_composer' ),
				'params' => array(
						array(
								'type' => 'textfield',
								'heading' => __( 'Title', 'js_composer' ),
								'param_name' => 'title',
								'admin_label' => true,
						),
						array(
								'type' 			=> 'dropdown',
								'heading' 		=> __( 'Styles', 'crater' ),
								'param_name' 	=> 'styles',
								'value' 		=> array(
										__( 'Welcome', 'crater' ) 		=> 'welcome',
										__( 'Testimonials', 'crater' ) 	=> 'testimonial',
								),
						),
						array(
								'type' => 'param_group',
								'heading' => __( 'Values', 'js_composer' ),
								'param_name' => 'welcome',
								'description' => __( 'Enter values for graph - value, title and color.', 'js_composer' ),
								'params' => array(
										array(
												'type' => 'textfield',
												'heading' => __( 'Title', 'js_composer' ),
												'param_name' => 'title',
												'admin_label' => true,
										),
										array(
												'type' => 'attach_image',
												'heading' => __( 'Image', 'js_composer' ),
												'param_name' => 'image',
										),
										array(
												'type' => 'textarea',
												'heading' => __( 'Content', 'js_composer' ),
												'param_name' => 'content',
										),
								),
								'dependency' => array(
										'element' => 'styles',
										'value'	  => array('welcome'),
								)
						),
						array(
								'type' => 'param_group',
								'heading' => __( 'Values', 'js_composer' ),
								'param_name' => 'testimonial',
								'description' => __( 'Enter values for graph - value, title and color.', 'js_composer' ),
								'params' => array(
										array(
												'type' => 'textfield',
												'heading' => __( 'Title', 'js_composer' ),
												'param_name' => 'title',
												'admin_label' => true,
										),
										array(
												'type' => 'textfield',
												'heading' => __( 'Name', 'js_composer' ),
												'param_name' => 'name',
												'admin_label' => true,
										),
										array(
												'type' => 'textfield',
												'heading' => __( 'Skills', 'js_composer' ),
												'param_name' => 'skills',
												'admin_label' => true,
										),
										array(
												'type' => 'attach_image',
												'heading' => __( 'Avatar', 'js_composer' ),
												'param_name' => 'image',
										),
										array(
												'type' => 'textarea',
												'heading' => __( 'Content', 'js_composer' ),
												'param_name' => 'content',
										),
								),
								'dependency' => array(
										'element' => 'styles',
										'value'	  => array( 'testimonial' ),
								)
						),
						array(
								'type' => 'textfield',
								'heading' => __( 'Extra class name', 'js_composer' ),
								'param_name' => 'el_class',
								'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'js_composer' ),
						),
						array(
								'type' => 'css_editor',
								'heading' => __( 'CSS box', 'mTheme' ),
								'param_name' => 'css',
								'group' => __( 'Design Options', 'mTheme' )
						),
						array(
								'type' => 'dropdown',
								'heading' => __( 'Width', 'mTheme' ),
								'param_name' => 'width',
								'value' => $vc_column_width_list,
								'std' => '1/3',
								'group' => __( 'Width Item', 'mTheme' ),
								'description' => __( 'Select column width.', 'mTheme' ),
						),
						array(
								'type' => 'column_offset',
								'heading' => __( 'Responsiveness', 'mTheme' ),
								'param_name' => 'offset',
								'group' => __( 'Width Item', 'mTheme' ),
								'description' => __( 'Adjust column for different screen sizes. Control width, offset and visibility settings.', 'mTheme' ),
						)
				),
		);
	}
	
	public function add_shortcodes_to_vc_section_radius() {
		
		return array(
				'name' => __( 'mTheme Section Radius', 'js_composer' ),
				'base' => 'mTheme_section_radius',
				'icon' => 'vc_element-icon icon-wpb-atm',
				'category' => __( 'mTheme', 'js_composer' ),
				'params' => array(
						array(
								'type' 			=> 'dropdown',
								'heading' 		=> __( 'Styles', 'crater' ),
								'param_name' 	=> 'styles',
								'admin_label' => true,
								'value' 		=> array(
										__( 'Top', 'crater' ) 		=> '',
										__( 'Button', 'crater' )	=> 'section-radius-bottom',
								),
						),
						array(
								'type' => 'textfield',
								'heading' => __( 'Extra class name', 'js_composer' ),
								'param_name' => 'el_class',
								'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'js_composer' ),
						),
				),
		);
	}
	
	/**
	 * Nutrition philosophy
	 * */
	public function add_shortcodes_to_vc_nutrition_philosophy() {
	
		$vc_column_width_list 	= $this->vc_column_width_list;
	
		return array(
				'name' => __( 'mTheme Nutrition Philosophy', 'js_composer' ),
				'base' => 'mTheme_nutrition_philosophy',
				'icon' => 'vc_element-icon icon-wpb-atm',
				'category' => __( 'mTheme', 'js_composer' ),
				'params' => array(
						array(
								'type' => 'textfield',
								'heading' => __( 'Title', 'js_composer' ),
								'param_name' => 'title',
								'admin_label' => true,
						),
						array(
								'type' => 'attach_image',
								'heading' => __( 'Banner', 'js_composer' ),
								'param_name' => 'banner',
						),
						array(
								'type' => 'param_group',
								'heading' => __( 'Box Left', 'js_composer' ),
								'param_name' => 'box_left',
								'description' => __( 'Enter values for graph - value, title and color.', 'js_composer' ),
								'params' => array(
										array(
												'type' => 'textfield',
												'heading' => __( 'Title', 'js_composer' ),
												'param_name' => 'title',
												'admin_label' => true,
										),
										array(
												'type' => 'attach_image',
												'heading' => __( 'Image', 'js_composer' ),
												'param_name' => 'image',
										),
										array(
												'type' => 'textarea',
												'heading' => __( 'Content', 'js_composer' ),
												'param_name' => 'content',
										),
								),
						),
						array(
								'type' => 'param_group',
								'heading' => __( 'Box Right', 'js_composer' ),
								'param_name' => 'box_right',
								'description' => __( 'Enter values for graph - value, title and color.', 'js_composer' ),
								'params' => array(
										array(
												'type' => 'textfield',
												'heading' => __( 'Title', 'js_composer' ),
												'param_name' => 'title',
												'admin_label' => true,
										),
										array(
												'type' => 'attach_image',
												'heading' => __( 'Image', 'js_composer' ),
												'param_name' => 'image',
										),
										array(
												'type' => 'textarea',
												'heading' => __( 'Content', 'js_composer' ),
												'param_name' => 'content',
										),
								),
						),
						array(
								'type' => 'textfield',
								'heading' => __( 'Extra class name', 'js_composer' ),
								'param_name' => 'el_class',
								'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'js_composer' ),
						),
						array(
								'type' => 'css_editor',
								'heading' => __( 'CSS box', 'mTheme' ),
								'param_name' => 'css',
								'group' => __( 'Design Options', 'mTheme' )
						),
				),
		);
	}
	
	/**
	 * Media Library
	 * */
	public function add_shortcodes_to_vc_media() {
	
		$vc_column_width_list = $this->vc_column_width_list;
	
		return array (
				'name' => __ ( 'mTheme Media Library', 'mTheme' ),
				'base' => 'mTheme_media_library',
				'category' => __ ( 'mTheme', 'mTheme' ),
				'icon' => 'vc_element-icon icon-wpb-atm',
				"params" => array(
						array(
								'type' 			=> 'textfield',
								'heading' 		=> __( 'Widget title', 'mTheme' ),
								'param_name' 	=> 'title',
								'description' 	=> __( 'Enter text used as widget title (Note: located above content element).', 'mTheme' ),
								'admin_label' => true,
						),
						array(
								'type'			=> 'attach_images',
								'heading' 		=> __( 'Images', 'mTheme' ),
								'param_name' 	=> 'images',
								'value' 		=> '',
								'description' 	=> __( 'Select images from media library.', 'mTheme' ),
						),/*
						array(
								'type' 			=> 'dropdown',
								'heading' 		=> __( 'Layout', 'mTheme' ),
								'param_name' 	=> 'layout',
								'value' 		=> array(
										__( 'Basic', 'mTheme' ) 	=> '',
										__( 'Banner', 'mTheme' ) 	=> 'banner',
										__( 'Carousel', 'mTheme' )	=> 'carousel',
								)
						),*/
	
						array(
								'type' => 'textfield',
								'heading' => __( 'Images size', 'mTheme' ),
								'param_name' => 'img_size',
								'value' => 'shop_catalog_image_size',
								'description' => __( 'Enter image size (Example: "post-thumbnail", "thumbnail", "medium", "large", "full" or "shop_catalog_image_size", "shop_single_image_size", "shop_thumbnail_image_size" for Woocommerce or other sizes defined by theme). Leave parameter empty to use "thumbnail" by default.', 'mTheme' )
						),
						array(
								'type' => 'textarea',
								'heading' => __( 'Before Content', 'mTheme' ),
								'param_name' => 'before_content',
								'value' => '',
								'description' => __( 'Content is added before the Content', 'mTheme' )
						),
						array(
								'type' => 'textarea_html',
								'heading' => __( 'After Content', 'mTheme' ),
								'param_name' => 'content',
								'value' => '',
								'description' => __( 'Content is added after the Content', 'mTheme' )
						),
						array(
								'type' => 'textfield',
								'heading' => __( 'Extra class name', 'mTheme' ),
								'param_name' => 'el_class',
								'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'mTheme' )
						),
						array(
								'type' => 'css_editor',
								'heading' => __( 'CSS box', 'mTheme' ),
								'param_name' => 'css',
								'group' => __( 'Design Options', 'mTheme' )
						),
						array(
								'type' => 'dropdown',
								'heading' => __( 'Width', 'mTheme' ),
								'param_name' => 'width',
								'value' => $vc_column_width_list,
								'std' => '1/3',
								'group' => __( 'Responsive Options', 'mTheme' ),
								'description' => __( 'Select column width.', 'mTheme' ),
						),
						array(
								'type' => 'column_offset',
								'heading' => __( 'Responsiveness', 'mTheme' ),
								'param_name' => 'offset',
								'group' => __( 'Responsive Options', 'mTheme' ),
								'description' => __( 'Adjust column for different screen sizes. Control width, offset and visibility settings.', 'mTheme' ),
						)
				),
		);
	}
	
	/**
	 * Posts
	 * */
	public function add_shortcodes_to_vc_posts() {
	
		$vc_column_width_list 	= $this->vc_column_width_list;
		$orderby 				= $this->orderby;
		$order 					= $this->order;
	
		return array (
				'name' => __ ( 'mTheme Posts', 'mTheme' ),
				'base' => 'mTheme_posts',
				'category' => __ ( 'mTheme', 'mTheme' ),
				'icon' => 'vc_element-icon icon-wpb-atm',
				"params" => array(
						array(
								'type' 			=> 'textfield',
								'heading' 		=> __( 'Widget title', 'mTheme' ),
								'param_name' 	=> 'title',
								'description' 	=> __( 'Enter text used as widget title (Note: located above content element).', 'mTheme' ),
								'admin_label' => true,
						),
						array(
								'type' 			=> 'dropdown',
								'heading' 		=> __( 'Layout', 'mTheme' ),
								'param_name' 	=> 'layout',
								'value' 		=> array(
										__( 'Basic', 'mTheme' ) 	=> '',
										//__( 'Tab', 'mTheme' ) 		=> 'tab',
										//__( 'Carousel', 'mTheme' )	=> 'carousel',
								)
						),
						/*
						 array(
						 		'type' 			=> 'dropdown',
						 		'heading' 		=> __( 'Styles', 'mTheme' ),
						 		'param_name' 	=> 'styles',
						 		'value' 		=> array(
						 				__( 'Style v1', 'mTheme' ) 	=> '',
						 				__( 'Style v2', 'mTheme' ) 	=> 'style-v2',
						 				__( 'Style v3', 'mTheme' ) 	=> 'style-v3',
						 		),
						 		'dependency' 	=> array(
						 				'element' 	=> 'layout',
						 				'value' 	=> 'banner'
						 		),
						 ),*/
						array(
								'type' 				=> 'dropdown',
								'heading' 			=> __( 'Group Posts', 'mTheme' ),
								'param_name' 		=> 'group',
								'description' 		=> __( '', 'mTheme' ),
								'value' 			=> array(
										__( 'Recent', 'mTheme' ) 		=> 'recent',
										__( 'Categories', 'mTheme' ) 	=> 'categories',
										__( 'Posts', 'mTheme' ) 		=> 'posts',
								)
						),
						array(
								'type' 				=> 'autocomplete',
								'heading' 			=> __( 'Categories', 'mTheme' ),
								'param_name' 		=> 'cat_ids',
								'dependency' 		=> array(
										'element'	=> 'group',
										'value' 	=> 'categories'
								),
								'settings' 			=> array(
										'multiple' => true,
										'sortable' => true,
								),
								'save_always' 		=> true,
								'description' 		=> __( 'List of product categories', 'mTheme' ),
						),
						array(
								'type' 				=> 'autocomplete',
								'heading' 			=> __( 'Products', 'mTheme' ),
								'param_name' 		=> 'ids',
								'dependency' 		=> array(
										'element'	=> 'group',
										'value' 	=> 'posts'
								),
								'settings' 			=> array(
										'multiple' => true,
										'sortable' => true,
										'unique_values' => true,
										// In UI show results except selected. NB! You should manually check values in backend
								),
								'save_always' 		=> true,
								'description' 		=> __( 'Enter List of Products', 'mTheme' ),
						),
						/*
						array(
								'type' 				=> 'dropdown',
								'heading' 			=> __( 'Order by', 'mTheme' ),
								'param_name' 		=> 'orderby',
								'value' 			=> $orderby,
								'save_always' 		=> true,
								'description'		=> sprintf( __( 'Select how to sort retrieved products. More at %s.', 'mTheme' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
						),
						array(
								'type' 				=> 'dropdown',
								'heading' 			=> __( 'Sort order', 'mTheme' ),
								'param_name' 		=> 'order',
								'value' 			=> $order,
								'save_always' 		=> true,
								'description' 		=> sprintf( __( 'Designates the ascending or descending order. More at %s.', 'mTheme' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
						),*/
						array(
								'type' 				=> 'textfield',
								'heading' 			=> __( 'Total items', 'mTheme' ),
								'param_name' 		=> 'max_items',
								'std'				=> '10',
								'description' 		=> __( 'Set max limit for items in grid or enter -1 to display all.', 'mTheme' )
						),
						array(
								'type' => 'textfield',
								'heading' => __( 'Images size', 'mTheme' ),
								'param_name' => 'img_size',
								'value' => 'thumbnail',
								'description' => __( 'Enter image size (Example: "post-thumbnail", "thumbnail", "medium", "large", "full" or "shop_catalog_image_size", "shop_single_image_size", "shop_thumbnail_image_size" for Woocommerce or other sizes defined by theme). Leave parameter empty to use "thumbnail" by default.', 'mTheme' )
						),
						array(
								'type' => 'textarea',
								'heading' => __( 'Before Content', 'mTheme' ),
								'param_name' => 'before_content',
								'value' => '',
								'description' => __( 'Content is added before the Content', 'mTheme' )
						),
						array(
								'type' => 'textarea_html',
								'heading' => __( 'After Content', 'mTheme' ),
								'param_name' => 'content',
								'value' => '',
								'description' => __( 'Content is added after the Content', 'mTheme' )
						),
						array(
								'type' => 'textfield',
								'heading' => __( 'Extra class name', 'mTheme' ),
								'param_name' => 'el_class',
								'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'mTheme' )
						),
						array(
								'type' => 'css_editor',
								'heading' => __( 'CSS box', 'mTheme' ),
								'param_name' => 'css',
								'group' => __( 'Design Options', 'mTheme' )
						),
						array(
								'type' => 'dropdown',
								'heading' => __( 'Width', 'mTheme' ),
								'param_name' => 'width',
								'value' => $vc_column_width_list,
								'std' => '1/3',
								'group' => __( 'Responsive Options', 'mTheme' ),
								'description' => __( 'Select column width.', 'mTheme' ),
						),
						array(
								'type' => 'column_offset',
								'heading' => __( 'Responsiveness', 'mTheme' ),
								'param_name' => 'offset',
								'group' => __( 'Responsive Options', 'mTheme' ),
								'description' => __( 'Adjust column for different screen sizes. Control width, offset and visibility settings.', 'mTheme' ),
						)
				),
		);
	}
	
	/**
	 * Products
	 * */
	public function add_shortcodes_to_vc_products() {
	
		$vc_column_width_list 	= $this->vc_column_width_list;
		$orderby 				= $this->orderby;
		$order 					= $this->order;
	
		return array (
				'name' 				=> __ ( 'mTheme Products', 'mTheme' ),
				'base' 				=> 'mTheme_products',
				'category' 			=> __ ( 'mTheme', 'mTheme' ),
				'icon' 				=> 'vc_element-icon icon-wpb-atm',
				'content_element' 	=> class_exists( 'WooCommerce' ),
				"params" 			=> array(
											array(
													'type' 			=> 'textfield',
													'heading' 		=> __( 'Widget title', 'mTheme' ),
													'param_name' 	=> 'title',
													'description' 	=> __( 'Enter text used as widget title (Note: located above content element).', 'mTheme' ),
													'admin_label' => true,
											),
											array(
													'type' 			=> 'dropdown',
													'heading' 		=> __( 'Layout', 'mTheme' ),
													'param_name' 	=> 'product_layout',
													'value' 		=> array(
															__( 'Basic', 'mTheme' ) 	=> '',
															__( 'Tab', 'mTheme' ) 		=> 'tab',
															//__( 'Carousel', 'mTheme' )	=> 'carousel',
													)
											),
											/*
												array(
														'type' 			=> 'dropdown',
														'heading' 		=> __( 'Styles', 'mTheme' ),
														'param_name' 	=> 'product_styles',
														'value' 		=> array(
																__( 'Style v1', 'mTheme' ) 	=> '',
																__( 'Style v2', 'mTheme' ) 	=> 'style-v2',
																__( 'Style v3', 'mTheme' ) 	=> 'style-v3',
														),
														'dependency' 	=> array(
																'element' 	=> 'product_layout',
																'value' 	=> 'banner'
														),
												),*/
											array(
													'type'			=> 'attach_image',
													'heading' 		=> __( 'Featured image', 'mTheme' ),
													'param_name' 	=> 'product_banner',
													'value' 		=> '',
													'description' 	=> __( 'Select images from media library.', 'mTheme' ),
											),
											array(
													'type' 			=> 'dropdown',
													'heading' 		=> __( 'Featured image alignment', 'mTheme' ),
													'param_name' 	=> 'product_banner_align',
													'value' 		=> array(
															__( 'Left', 'mTheme' ) => 'left',
															__( 'Center', 'mTheme' ) => 'center',
															__( 'Right', 'mTheme' ) => 'right'
													),
													'std' 			=> 'center',
													'dependency' 	=> array(
															'element' 	=> 'product_banner',
															'not_empty' => true
													),
													'description' 	=> __( 'Select Product Banner alignment.', 'mTheme' )
											),
											array(
													'type' 				=> 'dropdown',
													'heading' 			=> __( 'Group Products', 'mTheme' ),
													'param_name' 		=> 'product_group',
													'description' 		=> __( '', 'mTheme' ),
													'value' 			=> array(
															__( 'Products Categories', 'mTheme' ) 	=> 'products_categories',
															__( 'Recent Products', 'mTheme' ) 		=> 'recent_products',
															__( 'Featured Products', 'mTheme' ) 	=> 'featured_products',
															__( 'Sale Products', 'mTheme' ) 		=> 'sale_products',
															__( 'Best Selling Products', 'mTheme' )	=> 'best_selling_products',
															__( 'Top Rated Products', 'mTheme' ) 	=> 'top_rated_products',
															__( 'Custom Products', 'mTheme' ) 		=> 'custom_products',
													)
											),
											array(
													'type' 				=> 'autocomplete',
													'heading' 			=> __( 'Categories', 'mTheme' ),
													'param_name' 		=> 'product_cat_ids',
													'dependency' 		=> array(
															'element'	=> 'product_group',
															'value' 	=> 'products_categories'
													),
													'settings' 			=> array(
															'multiple' => true,
															'sortable' => true,
													),
													'save_always' 		=> true,
													'description' 		=> __( 'List of product categories', 'mTheme' ),
											),
											array(
													'type' 				=> 'autocomplete',
													'heading' 			=> __( 'Products', 'mTheme' ),
													'param_name' 		=> 'product_ids',
													'dependency' 		=> array(
															'element'	=> 'product_group',
															'value' 	=> 'custom_products'
													),
													'settings' 			=> array(
															'multiple' => true,
															'sortable' => true,
															'unique_values' => true,
															// In UI show results except selected. NB! You should manually check values in backend
													),
													'save_always' 		=> true,
													'description' 		=> __( 'Enter List of Products', 'mTheme' ),
											),
											array(
													'type' 				=> 'hidden',
													'param_name' 		=> 'product_skus',
											),
											array(
													'type' 				=> 'dropdown',
													'heading' 			=> __( 'Order by', 'mTheme' ),
													'param_name' 		=> 'product_orderby',
													'value' 			=> $orderby,
													'dependency' 		=> array(
															'element'	=> 'product_group',
															'value' 	=> array('products_categories', 'recent_products', 'featured_products', 'sale_products', 'top_rated_products')
													),
													'save_always' 		=> true,
													'description'		=> sprintf( __( 'Select how to sort retrieved products. More at %s.', 'mTheme' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
											),
											array(
													'type' 				=> 'dropdown',
													'heading' 			=> __( 'Sort order', 'mTheme' ),
													'param_name' 		=> 'product_order',
													'value' 			=> $order,
													'dependency' 		=> array(
															'element'	=> 'product_group',
															'value' 	=> array('products_categories', 'recent_products', 'featured_products', 'sale_products', 'top_rated_products')
													),
													'save_always' 		=> true,
													'description' 		=> sprintf( __( 'Designates the ascending or descending order. More at %s.', 'mTheme' ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
											),
											array(
													'type' 				=> 'textfield',
													'heading' 			=> __( 'Total items', 'mTheme' ),
													'param_name' 		=> 'max_items',
													'description' 		=> __( 'Set max limit for items in grid or enter -1 to display all.', 'mTheme' )
											),
											array(
													'type' => 'textfield',
													'heading' => __( 'Images size', 'mTheme' ),
													'param_name' => 'img_size',
													'value' => 'shop_catalog_image_size',
													'description' => __( 'Enter image size (Example: "post-thumbnail", "thumbnail", "medium", "large", "full" or "shop_catalog_image_size", "shop_single_image_size", "shop_thumbnail_image_size" for Woocommerce or other sizes defined by theme). Leave parameter empty to use "thumbnail" by default.', 'mTheme' )
											),
											array(
													'type' => 'textarea',
													'heading' => __( 'Before Content', 'mTheme' ),
													'param_name' => 'before_content',
													'value' => '',
													'description' => __( 'Content is added before the Content', 'mTheme' )
											),
											array(
													'type' => 'textarea_html',
													'heading' => __( 'After Content', 'mTheme' ),
													'param_name' => 'content',
													'value' => '',
													'description' => __( 'Content is added after the Content', 'mTheme' )
											),
											array(
													'type' => 'textfield',
													'heading' => __( 'Extra class name', 'mTheme' ),
													'param_name' => 'el_class',
													'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'mTheme' )
											),
											array(
													'type' => 'css_editor',
													'heading' => __( 'CSS box', 'mTheme' ),
													'param_name' => 'css',
													'group' => __( 'Design Options', 'mTheme' )
											),
											array(
													'type' => 'dropdown',
													'heading' => __( 'Width', 'mTheme' ),
													'param_name' => 'width',
													'value' => $vc_column_width_list,
													'std' => '1/3',
													'group' => __( 'Responsive Options', 'mTheme' ),
													'description' => __( 'Select column width.', 'mTheme' ),
											),
											array(
													'type' => 'column_offset',
													'heading' => __( 'Responsiveness', 'mTheme' ),
													'param_name' => 'offset',
													'group' => __( 'Responsive Options', 'mTheme' ),
													'description' => __( 'Adjust column for different screen sizes. Control width, offset and visibility settings.', 'mTheme' ),
											)
									),
		);
	}
	
	
	
	/**
	 * Suggester for autocomplete by id/name/title
	 * @since 4.4
	 *
	 * @param $query
	 *
	 * @return array - id's from Posts with title
	 */
	public function postsIdAutocompleteSuggester( $query ) {
		global $wpdb;
		$post_id = (int) $query;
		$post_meta_infos = $wpdb->get_results(
				$wpdb->prepare( "SELECT a.ID AS id, a.post_title AS title
						FROM {$wpdb->posts} AS a
						WHERE a.post_type = 'post' AND ( a.ID = '%d' OR a.post_title LIKE '%%%s%%' )",
						$post_id > 0 ? $post_id : - 1, stripslashes( $query ), stripslashes( $query ) ), ARRAY_A
		);
	
		$results = array();
		if ( is_array( $post_meta_infos ) && ! empty( $post_meta_infos ) ) {
			foreach ( $post_meta_infos as $value ) {
				$data = array();
				$data['value'] = $value['id'];
				$data['label'] = __( 'Id', 'js_composer' ) . ': ' .
						$value['id'] .
						( ( strlen( $value['title'] ) > 0 ) ? ' - ' . __( 'Title', 'js_composer' ) . ': ' .
								$value['title'] : '' );
				$results[] = $data;
			}
		}
		
		return $results;
	}
	
	/**
	 * Find post by id
	 * @since 4.4
	 *
	 * @param $query
	 *
	 * @return bool|array
	 */
	public function postsIdAutocompleteRender( $query ) {
		
		$query = trim( $query['value'] ); // get value from requested
		
		if ( ! empty( $query ) ) {
			// get post
			$post_object = get_post( (int) $query );
			if ( is_object( $post_object ) ) {
				$post_title = $post_object->post_title;
				$post_id = $post_object->ID;
	
				$post_title_display = '';
				if ( ! empty( $post_title ) ) {
					$post_title_display = ' - ' . __( 'Title', 'js_composer' ) . ': ' . $post_title;
				}
	
				$post_id_display = __( 'Id', 'js_composer' ) . ': ' . $post_id;
	
				$data = array();
				$data['value'] = $post_id;
				$data['label'] = $post_id_display . $post_title_display ;
	
				return ! empty( $data ) ? $data : false;
			}
	
			return false;
		}
	
		return false;
	}
	
	/**
	 * Autocomplete suggester to search post category by name/slug or id.
	 * @since 4.4
	 *
	 * @param $query
	 * @param bool $slug - determines what output is needed
	 *      default false - return id of post category
	 *      true - return slug of post category
	 *
	 * @return array
	 */
	public function postsCategoryCategoryAutocompleteSuggester( $query, $slug = false ) {
		global $wpdb;
		$cat_id = (int) $query;
		$query = trim( $query );
		$post_meta_infos = $wpdb->get_results(
				$wpdb->prepare( "SELECT a.term_id AS id, b.name as name, b.slug AS slug
						FROM {$wpdb->term_taxonomy} AS a
						INNER JOIN {$wpdb->terms} AS b ON b.term_id = a.term_id
						WHERE a.taxonomy = 'category' AND (a.term_id = '%d' OR b.slug LIKE '%%%s%%' OR b.name LIKE '%%%s%%' )",
						$cat_id > 0 ? $cat_id : - 1, stripslashes( $query ), stripslashes( $query ) ), ARRAY_A
		);
	
		$result = array();
		if ( is_array( $post_meta_infos ) && ! empty( $post_meta_infos ) ) {
			foreach ( $post_meta_infos as $value ) {
				$data = array();
				$data['value'] = $slug ? $value['slug'] : $value['id'];
				$data['label'] = __( 'Id', 'js_composer' ) . ': ' .
						$value['id'] .
						( ( strlen( $value['name'] ) > 0 ) ? ' - ' . __( 'Name', 'js_composer' ) . ': ' .
								$value['name'] : '' ) .
								( ( strlen( $value['slug'] ) > 0 ) ? ' - ' . __( 'Slug', 'js_composer' ) . ': ' .
										$value['slug'] : '' );
				$result[] = $data;
			}
		}
	
		return $result;
	}
	
	/**
	 * Search post category by id
	 * @since 4.4
	 *
	 * @param $query
	 *
	 * @return bool|array
	 */
	public function postsCategoryCategoryRenderByIdExact( $query ) {
		$query = $query['value'];
		$cat_id = (int) $query;
		$term = get_term( $cat_id, 'category' );
	
		$term_slug = $term->slug;
		$term_title = $term->name;
		$term_id = $term->term_id;
	
		$term_slug_display = '';
		if ( ! empty( $term_slug ) ) {
			$term_slug_display = ' - ' . __( 'Slug', 'js_composer' ) . ': ' . $term_slug;
		}
	
		$term_title_display = '';
		if ( ! empty( $term_title ) ) {
			$term_title_display = ' - ' . __( 'Title', 'js_composer' ) . ': ' . $term_title;
		}
	
		$term_id_display = __( 'Id', 'js_composer' ) . ': ' . $term_id;
	
		$data = array();
		$data['value'] = $term_id;
		$data['label'] = $term_id_display . $term_title_display . $term_slug_display;
	
		return ! empty( $data ) ? $data : false;
	}
}

new mTheme_Shortcode ();