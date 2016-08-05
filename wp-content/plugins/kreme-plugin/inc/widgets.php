<?php

/**
 * mTheme Display Widget
 * */
class mTheme_Widget_Callback{
	
	public $pages = array();
	
	public $post_types = array();
	
	public $categories = array();
	
	public $taxonomy = array();
	
	
	public function __construct(){
		
		add_action('init', array($this, 'set_data'));
		
		//Add input fields(priority 5, 3 parameters)
		add_action('widget_display_callback', array($this, 'widget_display_callback'),5,3);
		
		//Add input fields(priority 5, 3 parameters)
		add_action('in_widget_form', array($this, 'in_widget_form_callback'),5,3);
		
		//Callback function for options update (prioritat 5, 3 parameters)
		add_filter('widget_update_callback', array($this, 'widget_update_callback'),5,3);
		
		//add Params (default priority, one parameter)
		add_filter('dynamic_sidebar_params', array($this, 'dynamic_sidebar_params'));
		
		// Filter widget
		add_filter('sidebars_widgets', array($this, 'sidebars_widgets'), 10);
		
		add_action( 'admin_enqueue_scripts', array($this, 'admin_enqueue_scripts') );

	}
	
	public function set_data() {
		
		if ( !is_admin() )
			return false;
			
		$pages = $_pages = $_categories = $post_types = $categories = $taxonomy = array();
		$pages		= get_pages();
		$categories = get_categories();
		$taxonomy 	= get_taxonomies();
		$post_types = get_post_types();
		
		foreach ( $pages as $page ) {
			$_pages[$page->ID] = $page->post_title;
		}
		
		foreach ( $categories as $category ) {
			$_categories[$category->term_id] = $category->name;
		}
		
		$keys_posttype = array('page', 'revision', 'nav_menu_item');
		$keys_taxonomy = array('category', 'nav_menu', 'link_category', 'post_format');
		
		foreach ( $keys_posttype as $key ) {
			if ( array_key_exists( $key, $post_types) ) {
				unset($post_types[$key]);
			}
		}
		foreach ( $keys_taxonomy as $key ) {
			if ( array_key_exists( $key, $taxonomy) ) {
				unset($taxonomy[$key]);
			}
		}
		
		$this->pages		= $_pages;
		$this->categories 	= $_categories;
		$this->post_types 	= $post_types;
		$this->taxonomy		= $taxonomy;		
	}
	
	public function admin_enqueue_scripts( $hook ) {
		
		if( 'widgets.php' != $hook )
			return;
		
		wp_enqueue_script('mtheme-widget-script', mTheme_URL . 'assets/js/admin-widget.js' );
		wp_enqueue_style('mtheme-widget-style', mTheme_URL . 'assets/css/admin-widget.css' );
	
	}
	
	/**
	 * Widget Callback
	 * */
	public function widget_display_callback( $instance, $_this, $args ) {
		
		// Custom Title
		if ( !isset($instance['show_title']) || $instance['show_title'] != "true" ) {
			$instance['title'] 	= '';
		
		} elseif ( isset($instance['custom_title']) && !empty($instance['custom_title']) ) {
			$instance['title'] = $instance['custom_title'];
		}
	
		return $instance;
	}
	
	/**
	 * Form Callback
	 * */
	public function in_widget_form_callback( $_this, $return, $instance ) {
		$t = $_this;
		
		$show_title		= isset( $instance['show_title'] ) ? $instance['show_title'] : 'true';
		$custom_title	= isset($instance['custom_title']) ? $instance['custom_title'] : '';
		$classes 		= isset($instance['classes']) ? $instance['classes'] : '';
		$widget_logic 	= isset( $instance['widget_logic'] ) ? $instance['widget_logic'] : array();
	
		$pages 		= $this->pages;
		$categories = $this->categories;
		$post_types = $this->post_types; 
		$taxonomy 	= $this->taxonomy;
		
		$logic = array(  
					'is_front_page'			=> 'Frontpage',
					'is_page'				=> array(
												'title' => 'Page',
												'value'	=> $pages
											),
					'is_category'			=> array(
												'title'	=> 'Category',
												'value'	=> $categories,
											),
					'is_post_type_archive'	=> array(
												'title' => 'Archive',
												'value'	=> $post_types,
											),
					'is_singular'			=> array(
												'title' => 'Singular',
												'value'	=> $post_types,
											),
					'is_tax'				=> array(
												'title'	=> 'Taxonomy',
												'value'	=> $taxonomy,
											),
					);
		
		?>
		<p><input class="checkbox" type="checkbox" <?php checked( "true", $show_title ); ?> id="<?php echo $t->get_field_id( 'show_title' ); ?>" name="<?php echo $t->get_field_name( 'show_title' ); ?>" value="true"/>
			<label for="<?php echo $t->get_field_id( 'show_title' ); ?>"><?php _e( 'Show Title' ); ?></label></p>
			
		<p>
	    	<label for="<?php echo $t->get_field_id('custom_title'); ?>"><?php _e('Custom Title:'); ?></label>
	        <textarea rows="1" class="widefat" name="<?php echo $t->get_field_name('custom_title'); ?>" id="<?php echo $t->get_field_id('custom_title'); ?>"><?php echo $custom_title; ?></textarea>
	    </p>
	    
	    <p>
	    	<label for="<?php echo $t->get_field_id('classes'); ?>"><?php _e('Wrap Classes:'); ?></label>
	        <input type="text" class="widefat" name="<?php echo $t->get_field_name('classes'); ?>" id="<?php echo $t->get_field_id('classes'); ?>" value="<?php echo $classes; ?>"  />
	    </p>
	    
	    <ul class="widget-logic-box">
	    <?php 
	    if ( isset($logic) && is_array($logic) && count($logic) > 0 ) { 
	    	foreach ( $logic as $key => $value ) {
	    		if ( is_array($value) ) {
	    			?>
	    			<li class="<?php echo isset($widget_logic[$key][0]) && $widget_logic[$key][0] == $key ? 'active' : ''; ?>">
	    				<label for="<?php echo $t->get_field_id( 'widget_logic[' . $key . '][0]' ); ?>">
	    					<input class="checkbox checkbox-parent" type="checkbox"<?php checked( $key, isset($widget_logic[$key][0]) ? $widget_logic[$key][0] : '' ); ?> id="<?php echo $t->get_field_id( 'widget_logic[' . $key . '][0]' ); ?>" name="<?php echo $t->get_field_name( 'widget_logic[' . $key . '][0]' ); ?>" value="<?php echo $key; ?>"/>
	    					<?php _e( $value['title'] ); ?>
	    				</label>
	    				<ul class="widget-logic-children">
	    				<?php 
	    				if ( isset($value['value']) && is_array($value['value']) && count($value['value']) > 0 ) {
	    					foreach ( $value['value'] as $k => $v ) {
	    						?>
	    						<li>
		    						<label for="<?php echo $t->get_field_id( 'widget_logic[' . $key . '][' . $k . ']' ); ?>">
		    							<input class="checkbox" type="checkbox"<?php checked( $k, isset($widget_logic[$key][$k]) ? $widget_logic[$key][$k] : '' ); ?> id="<?php echo $t->get_field_id( 'widget_logic[' . $key . '][' . $k . ']' ); ?>" name="<?php echo $t->get_field_name( 'widget_logic[' . $key . '][' . $k . ']' ); ?>" value="<?php echo $k; ?>"/>
		    							<?php _e( $v ); ?>
		    						</label>
								</li>
	    						<?php 
	    					}
	    				}
	    				?>
	    				</ul>
    				</li>
    				<?php 
    				
	    		} else {
	    			?>
	    			<li>
		    			<label for="<?php echo $t->get_field_id( 'widget_logic[' . $key . ']' ); ?>">
		    				<input class="checkbox" type="checkbox"<?php checked( $key, isset($widget_logic[$key]) ? $widget_logic[$key] : '' ); ?> id="<?php echo $t->get_field_id( 'widget_logic[' . $key . ']' ); ?>" name="<?php echo $t->get_field_name( 'widget_logic[' . $key . ']' ); ?>" value="<?php echo $key; ?>"/>
							<?php _e( $value ); ?>
						</label>
					</li>
	    			<?php 
	    		}
	    	}
	    ?>
	    </ul> 
	    
	    <?php } ?>
	    
	    <?php
	    
	    $retrun = null;
	    
	    return array( $t, $return, $instance );
	 }
	 
	 /**
	  * Update Callback
	  * */
	 public function widget_update_callback($instance, $new_instance, $old_instance){
	 	
	 	$instance['show_title'] 	= isset( $new_instance['show_title'] ) ? $new_instance['show_title'] : 'false';
	 	$instance['custom_title'] 	= isset( $new_instance['custom_title'] ) ? $new_instance['custom_title'] : '';
	 	$instance['classes'] 		= strip_tags($new_instance['classes']);
	 	$instance['widget_logic'] 	= isset( $new_instance['widget_logic'] ) ? $new_instance['widget_logic'] : array();
	 	return $instance;
	 }
	 
	 /**
	  * Custom Sidebar Params
	  * */
	 public function dynamic_sidebar_params($params){
	 	global $wp_registered_widgets;
	 	$widget_id = $params[0]['widget_id'];
	 	$widget_obj = $wp_registered_widgets[$widget_id];
	 	$widget_opt = get_option($widget_obj['callback'][0]->option_name);
	 	$widget_num = $widget_obj['params'][0]['number'];
	 	
	 	// Custom Title
	 	if ( !isset( $widget_opt[$widget_num]['title'] ) || empty($widget_opt[$widget_num]['title']) || !isset($widget_opt[$widget_num]['show_title']) || $widget_opt[$widget_num]['show_title'] != "true" ) {
	 		$params[0]['before_title'] = '';
	 		$params[0]['after_title'] = '';
	 	}
	 	
	 	
	 	// Custom Classes Widget
	 	if ( isset( $widget_opt[$widget_num]['classes'] ) ) {
	 		$classes 	= 'class="' . $widget_opt[$widget_num]['classes'] . ' ';
	 		$__classes 	= "class='" . $widget_opt[$widget_num]['classes'] . " ";
	 		
	 		$params[0]['before_widget'] = preg_replace('/class="/', $classes, $params[0]['before_widget'], 1);
	 		$params[0]['before_widget'] = preg_replace("/class='/", $__classes, $params[0]['before_widget'], 1);
	 	}
	 	
	 	return $params;
	 }
	 
	 /**
	  * Filter Widget
	  * */
	 public function sidebars_widgets($sidebars_widgets){
	 	global $wp_registered_sidebars, $wp_registered_widgets;
	 	
	 	$_sidebars_widgets = $sidebars_widgets;
	 	
	 	if ( !is_admin() ) {
	 		
	 		foreach ( $sidebars_widgets as $sidebar_id => $widgets ) {
	 			
	 			if ( empty( $wp_registered_sidebars[$sidebar_id] ) ) continue;
	 			
	 			$sidebar = $wp_registered_sidebars[$sidebar_id];
	 			
	 			foreach ( $widgets as $key => $widget_id ) {
	 				
	 				if ( !isset($wp_registered_widgets[$widget_id]) ) continue;
	 				
	 				$widget_obj = $wp_registered_widgets[$widget_id];
	 				$widget_opt = get_option($widget_obj['callback'][0]->option_name);
	 				$widget_num = $widget_obj['params'][0]['number'];
	 				
	 				if ( isset( $widget_opt[$widget_num]['widget_logic'] ) ) {
	 					
	 					$widget_logic = $widget_opt[$widget_num]['widget_logic'];
	 					
	 					if ( isset($widget_logic) && is_array($widget_logic) && count($widget_logic) > 0 ) {
	 						
	 						$check = false;
	 						foreach ( $widget_logic as $ks => $values ) {
	 							
	 							if ( is_array($values) ) {
	 								
	 								if ( count($values) == 1 ) {
	 									if ( call_user_func($ks) ) {
	 										$check = true;
	 										break;
	 									}
	 									
	 								} else {
	 									unset($values[0]);
	 									
	 									foreach ( $values as $k => $value ) {
	 										if ( call_user_func($ks, $k) ) {
	 											$check = true;
	 											break;
	 										}
	 									}
	 								}
	 							
	 							} else {
	 								if ( call_user_func($ks) ) {
	 									$check = true;
	 									break;
	 								}
	 							}
	 							
		 						if ( $check ) {
		 							break;
		 						}
	 						}
	 						
	 						if ( !$check ) {
	 							unset($_sidebars_widgets[$sidebar_id][$key]);
	 						}
	 						
	 					}
	 				}
	 			}
	 			
	 			if ( count($sidebars_widgets[$sidebar_id]) < 1 )  unset($_sidebars_widgets[$sidebar_id]);
	 		}
	 	}
	 	
	 	return $_sidebars_widgets;
	 }
}

new mTheme_Widget_Callback();
