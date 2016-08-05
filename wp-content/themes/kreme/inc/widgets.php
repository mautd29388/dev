<?php

function kreme_widgets_init() {
	register_sidebar( array(
			'name' => __ ( 'Widget Area', 'kreme' ),
			'id' => 'widget-area',
			'description' => __ ( '', 'kreme' ),
			//'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="widget-inner">',
			'before_widget' => "<aside id='' class='widget'><div class='widget-inner'>",
			'after_widget' => '</div></aside>',
			'before_title' => '<h3 class="title">',
			'after_title' => '</h3>' 
	) );
	
	$sidebar = get_theme_mod('sidebar');
	
	if ( isset($sidebar) && is_array($sidebar) && count($sidebar) > 0 ) {
		foreach ( $sidebar as $side ) {
			
			register_sidebar( array(
					'name' => $side['name'],
					'id' => sanitize_title($side['name']),
					'description' => __ ( '', 'kreme' ),
					'before_widget' => '<aside id="%1$s" class="widget %2$s"><div class="widget-inner">',
					'after_widget' => '</div></aside>',
					'before_title' => '<h3 class="widget-title">',
					'after_title' => '</h3>'
			) );
		}
	}
}
add_action( 'widgets_init', 'kreme_widgets_init' );


/**
 * Register Widget
 */ 
function kreme_register_widget() {
	register_widget( 'kreme_Logo_Widget' );
	register_widget( 'kreme_Menu_Widget' );
	register_widget( 'kreme_MiniCart_Widget' );
}
add_action( 'widgets_init', 'kreme_register_widget' );


/**
 * mTheme Logo Widget.
 */
class kreme_Logo_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		$widget_ops = array( 'classname' => 'mTheme-logo', 'description' => __( 'Show Logo', 'kreme' ) );
		$control_ops = array();
		parent::__construct('mTheme-logo', __( 'mTheme Logo', 'kreme' ), $widget_ops, $control_ops);

	}

	public function widget( $args, $instance ) {
		
		$logo		= get_theme_mod('logo');
		
		echo $args['before_widget'];
		?>
		<!-- Logo -->
		<div class="logo">
			<a href="<?php echo esc_url( home_url() ); ?>">
				<?php if ( isset($logo) && !empty($logo) ) { ?>
					<img alt="" src="<?php echo $logo; ?>">
				<?php } else echo bloginfo('name'); ?>
			</a>
		</div>
		<?php 
		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$title		= ! empty( $instance['title'] ) ? $instance['title'] : __( 'mTheme Logo', 'kreme' );
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'kreme' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php 
	}

	
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}

}


/**
 * mTheme Menu Widget.
 */
class kreme_Menu_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		$widget_ops = array( 'classname' => 'mTheme-menu', 'description' => __( 'Show Menu', 'kreme' ) );
		$control_ops = array();
		parent::__construct('mTheme-menu', __( 'mTheme Menu', 'kreme' ), $widget_ops, $control_ops);

	}

	public function widget( $args, $instance ) {

		$location	= ! empty( $instance['location'] ) ? $instance['location'] : '';

		if ( empty($location) )
			return false;
		
		echo $args['before_widget'];
		?>
		<!-- Main Menu -->
		<nav class="navbar" role="navigation">
			<div class="navbar-inner">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed"
						data-toggle="collapse" data-target="#navbar">
						<span class="sr-only">Toggle navigation</span> <span
							class="icon-bar"></span> <span class="icon-bar"></span> <span
							class="icon-bar"></span>
					</button>
					<h3 class="navbar-brand">Menu</h3>
				</div>
				<div id="navbar" class="navbar-collapse collapse">
					<?php 
					wp_nav_menu ( 
						array ( 
							'theme_location' => $location,
							'container' => '',
							'menu_class' => 'nav navbar-nav',
							'walker' => new mTheme_nav_walker
						) 
					); ?>
				</div>
				<!--/.navbar-collapse -->
			</div>
		</nav>
		<?php 
		echo $args['after_widget'];
	}

	public function form( $instance ) {
		global $_wp_registered_nav_menus;
		
		$locations = $_wp_registered_nav_menus;
		
		
		$title		= ! empty( $instance['title'] ) ? $instance['title'] : __( 'mTheme Menu', 'kreme' );
		$location	= ! empty( $instance['location'] ) ? $instance['location'] : '';
		
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'kreme' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		
		<p><label for="<?php echo $this->get_field_id( 'location' ); ?>"><?php echo __( 'Theme locations:', 'kreme' ); ?></label>
		<select class="widefat" id="<?php echo $this->get_field_id( 'location' ); ?>" name="<?php echo $this->get_field_name( 'location' ); ?>">
			<?php 
			if ( is_array($locations) && count($locations) > 0 ) {
				foreach ( $locations as $key => $val ) {
					echo "<option value='". $key ."' ". selected($key, $location, false) ." >$val</option>";
				}
			}
			?>
		</select></p>
		<?php 
	}

	
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] 		= ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['location'] 	= ( ! empty( $new_instance['location'] ) ) ? strip_tags( $new_instance['location'] ) : '';

		return $instance;
	}

}


/**
 * mTheme MiniCart Widget.
 */
class kreme_MiniCart_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		$widget_ops = array( 'classname' => 'mTheme-minicart', 'description' => __( 'Show Mini Cart', 'kreme' ) );
		$control_ops = array();
		parent::__construct('mTheme-minicart', __( 'mTheme Cart', 'kreme' ), $widget_ops, $control_ops);

	}

	public function widget( $args, $instance ) {

		echo $args['before_widget'];
		
		echo kreme_minicart();
		
		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$title		= ! empty( $instance['title'] ) ? $instance['title'] : __( 'mTheme Cart', 'kreme' );
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'kreme' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php 
	}

	
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}

}

