<?php
if ( ! class_exists( 'mTheme_Term_Meta' ) ) {
	
	class mTheme_Term_Meta {
		
		private $meta_box;
		
		public function __construct( $meta_box ) {
			if ( ! is_admin() )
				return;
		
				global $ot_meta_boxes;
		
				if ( ! isset( $ot_meta_boxes ) ) {
					$ot_meta_boxes = array();
				}
		
				$ot_meta_boxes[] = $meta_box;
		
				$this->meta_box = $meta_box;
		
				$this->add_meta_boxes();
		
		}
		
		public function add_meta_boxes() {
			foreach ( (array) $this->meta_box['pages'] as $page ) {
				add_action( $page.'_add_form_fields', array( $this, 'output_new_form' ), 10, 2 );
				add_action( $page.'_edit_form_fields',array( $this, 'output_edit_form' ), 10, 2);
				
				add_action( 'created_' . $page, array($this, 'created_term_meta'), 10, 2 );
				add_action( 'edited_'.$page, array($this, 'edited_term_meta'), 10, 2 );
			}
		}
		
		public function output_new_form( $taxonomy ) {
			echo '<div class="form-field">';
			
			/* Use nonce for verification */
			echo '<input type="hidden" name="' . $this->meta_box['id'] . '_nonce" value="' . wp_create_nonce( $this->meta_box['id'] ) . '" />';
			
			/* loop through meta box fields */ 
			foreach ( $this->meta_box['fields'] as $field ) {
			
				/* get current post meta data */
				$field_value = '';
			
				/* set standard value */
				if ( isset( $field['std'] ) ) {
					$field_value = ot_filter_std_value( $field_value, $field['std'] );
				}
				
				$conditions = '';
				
				/* setup the conditions */
				if ( isset( $field['condition'] ) && ! empty( $field['condition'] ) ) {
						
					$conditions = ' data-condition="' . $field['condition'] . '"';
					$conditions.= isset( $field['operator'] ) && in_array( $field['operator'], array( 'and', 'AND', 'or', 'OR' ) ) ? ' data-operator="' . $field['operator'] . '"' : '';
						
				}
				
				/* only allow simple textarea due to DOM issues with wp_editor() */
				if ( apply_filters( 'ot_override_forced_textarea_simple', false, $field['id'] ) == false && $field['type'] == 'textarea' )
					$field['type'] = 'textarea-simple';
						
				// Build the setting CSS class
				if ( isset($field['class']) && ! empty( $field['class']['field_class'] ) ) {
						
					$classes = explode( ' ', $field['class']['field_class'] );
						
					foreach( $classes as $key => $value ) {
			
						$classes[$key] = $value . '-wrap';
			
					}
						
					$class = 'format-settings ' . implode( ' ', $classes );
						
				} else {
						
					$class = 'format-settings';
						
				}
			
				/* option label */
				echo '<div id="setting_' . $field['id'] . '" class="' . $class . '"' . $conditions . '>';
					
				echo '<label for="' . $field['id'] . '" class="label">' . $field['label'] . '</label>';
				$this->build_meta_box($field, $field_value);
				
				echo '</div>';
			}
			
			echo '</div>';
		}
		
		public function output_edit_form($term, $taxonomy) {
			
			/* Use nonce for verification */
			echo '<input type="hidden" name="' . $this->meta_box['id'] . '_nonce" value="' . wp_create_nonce( $this->meta_box['id'] ) . '" />';
			
			/* loop through meta box fields */
			foreach ( $this->meta_box['fields'] as $field ) {
			
				/* get current post meta data */
				$field_value = get_term_meta( $term->term_id, $field['id'], true );
			
				/* set standard value */
				if ( isset( $field['std'] ) ) {
					$field_value = ot_filter_std_value( $field_value, $field['std'] );
				}
				
				$conditions = '';
				
				/* setup the conditions */
				if ( isset( $field['condition'] ) && ! empty( $field['condition'] ) ) {
						
					$conditions = ' data-condition="' . $field['condition'] . '"';
					$conditions.= isset( $field['operator'] ) && in_array( $field['operator'], array( 'and', 'AND', 'or', 'OR' ) ) ? ' data-operator="' . $field['operator'] . '"' : '';
						
				}
				
				/* only allow simple textarea due to DOM issues with wp_editor() */
				if ( apply_filters( 'ot_override_forced_textarea_simple', false, $field['id'] ) == false && $field['type'] == 'textarea' )
					$field['type'] = 'textarea-simple';
						
				// Build the setting CSS class
				if ( isset($field['class']) && ! empty( $field['class']['field_class'] ) ) {
						
					$classes = explode( ' ', $field['class']['field_class'] );
						
					foreach( $classes as $key => $value ) {
			
						$classes[$key] = $value . '-wrap';
			
					}
						
					$class = 'format-settings ' . implode( ' ', $classes );
						
				} else {
						
					$class = 'format-settings';
						
				}
			
				echo '<tr id="setting_' . $field['id'] . '" class="form-field term-group-wrap ' . $class . '"' . $conditions . '>';
				echo '<th scope="row"><label for="' . $field['id'] . '" class="label">' . $field['label'] . '</label></th>';
				echo '<td>';
				$this->build_meta_box($field, $field_value);
				echo '</td>';
				echo '</tr>';
				
			}
			
		}
		public function build_meta_box( $field, $field_value = '' ) {
		
			/* build the arguments array */
			$_args = array(
					'type'              => $field['type'],
					'field_id'          => $field['id'],
					'field_name'        => $field['id'],
					'field_value'       => $field_value,
					'field_desc'        => isset( $field['desc'] ) ? $field['desc'] : '',
					'field_std'         => isset( $field['std'] ) ? $field['std'] : '',
					'field_rows'        => isset( $field['rows'] ) && ! empty( $field['rows'] ) ? $field['rows'] : 10,
					'field_post_type'   => isset( $field['post_type'] ) && ! empty( $field['post_type'] ) ? $field['post_type'] : 'post',
					'field_taxonomy'    => isset( $field['taxonomy'] ) && ! empty( $field['taxonomy'] ) ? $field['taxonomy'] : 'category',
					'field_min_max_step'=> isset( $field['min_max_step'] ) && ! empty( $field['min_max_step'] ) ? $field['min_max_step'] : '0,100,1',
					'field_class'       => isset( $field['class'] ) ? $field['class'] : '',
					'field_condition'   => isset( $field['condition'] ) ? $field['condition'] : '',
					'field_operator'    => isset( $field['operator'] ) ? $field['operator'] : 'and',
					'field_choices'     => isset( $field['choices'] ) ? $field['choices'] : array(),
					'field_settings'    => isset( $field['settings'] ) && ! empty( $field['settings'] ) ? $field['settings'] : array(),
					'post_id'           => $field['id'],
					'meta'              => true
			);
				
			echo '<div class="format-setting-wrap">';
				
			/* get the option HTML */
			echo ot_display_by_type( $_args );
				
			echo '</div>';
		
		}
		
		public function created_term_meta( $term_id, $tt_id ){
		
			$metabox = $this->meta_box;
		
			/* don't save if $_POST is empty */
			if ( empty( $_POST ) )
				return $term_id;
		
			/* don't save during autosave */
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
				return $term_id;
	
			/* verify nonce */
			if ( ! isset( $_POST[ $metabox['id'] . '_nonce'] ) || ! wp_verify_nonce( $_POST[ $metabox['id'] . '_nonce'], $metabox['id'] ) )
				return $term_id;

			foreach ( $metabox['fields'] as $value ) {
				if( isset( $_POST[$value['id']] ) && '' !== $_POST[$value['id']] ){

					// Get the option name
					$option_value = null;

					if ( isset( $_POST[ $value['id'] ] ) ) {
						$option_value = $_POST[ $value['id'] ];
					}

					if ( ! is_null( $option_value ) ) {
						add_term_meta( $term_id, $value['id'], $option_value, true );
					}
				}
			}
			return true;
		}
		
		public function edited_term_meta( $term_id, $tt_id ){
			$metabox = $this->meta_box;
		
			/* don't save if $_POST is empty */
			if ( empty( $_POST ) )
				return $term_id;
		
			/* don't save during autosave */
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
				return $term_id;
	
				/* verify nonce */
				if ( ! isset( $_POST[ $metabox['id'] . '_nonce'] ) || ! wp_verify_nonce( $_POST[ $metabox['id'] . '_nonce'], $metabox['id'] ) )
					return $term_id;
	
					foreach ( $metabox['fields'] as $value ) {
						// Get the option name
						$option_value = null;
	
						if ( isset( $_POST[ $value['id'] ] ) ) {
							$option_value = $_POST[ $value['id'] ];
						}
	
						if ( ! is_null( $option_value ) ) {
							update_term_meta( $term_id, $value['id'], $option_value );
						}
					}
					return true;
		}
	}
	
}

if ( ! function_exists( 'mTheme_register_term_meta' ) ) {

	function mTheme_register_term_meta( $args ) {
		if ( ! $args )
			return;

			$mTheme_term_meta = new mTheme_Term_Meta( $args );
	}

}

/* add scripts for metaboxes to post-new.php & post.php */
add_action( 'admin_print_scripts-edit-tags.php', 'ot_admin_scripts', 11 );
add_action( 'admin_print_scripts-term.php', 'ot_admin_scripts', 11 );

/* add styles for metaboxes to post-new.php & post.php */
add_action( 'admin_print_styles-edit-tags.php', 'ot_admin_styles', 11 );
add_action( 'admin_print_styles-term.php', 'ot_admin_styles', 11 );
