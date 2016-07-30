<?php 

/**
 * Check Ajax
 * @return boolean
 */
function kreme_is_ajax() {
	if (! empty ( $_SERVER ['HTTP_X_REQUESTED_WITH'] ) && strtolower ( $_SERVER ['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest') {
		return true;
	}

	return false;
}

/**
 * Get Font google
 * */
function kreme_ot_google_font_stack($families, $field_id) {
	$ot_google_fonts = get_theme_mod ( 'ot_google_fonts', array () );
	$ot_set_google_fonts = get_theme_mod ( 'ot_set_google_fonts', array () );

	if (! empty ( $ot_set_google_fonts )) {
		foreach ( $ot_set_google_fonts as $id => $sets ) {
			foreach ( $sets as $value ) {
				$family = isset ( $value ['family'] ) ? $value ['family'] : '';
				if ($family && isset ( $ot_google_fonts [$family] )) {
					$spaces = explode ( ' ', $ot_google_fonts [$family] ['family'] );
					$font_stack = count ( $spaces ) > 1 ? '"' . $ot_google_fonts [$family] ['family'] . '"' : $ot_google_fonts [$family] ['family'];
					$families [$family] = apply_filters ( 'ot_google_font_stack', $font_stack, $family, $field_id );
				}
			}
		}
	}

	return $families;
}

/**
 * mTheme Trim
 * */
function kreme_trim( $text, $excerpt_length = 55){

	$excerpt_more = apply_filters( 'excerpt_more', '...' );
	$text = wp_trim_words( $text, $excerpt_length, $excerpt_more );

	return $text;
}

/**
 * Container
 * */
function kreme_container(){
	$container = get_theme_mod('main_container', 'off');

	if ( $container == 'off' ) {
		return 'container';
	}

	return 'container-fluid';
}

/**
 * Get link post_type and page number
 */
function kreme_get_post_type_archive_pagenum_link($post_type, $max_page, $pagenum) {
	global $wp_rewrite;

	$pagenum = ( int ) $pagenum;
	$max_page = ( int ) $max_page;

	if ($max_page < $pagenum)
		return false;

		if (! $post_type_obj = get_post_type_object ( $post_type ))
			return false;

			if (! $post_type_obj->has_archive)
				return false;

				if (get_option ( 'permalink_structure' ) && is_array ( $post_type_obj->rewrite )) {
					$struct = (true === $post_type_obj->has_archive) ? $post_type_obj->rewrite ['slug'] : $post_type_obj->has_archive;
					if ($post_type_obj->rewrite ['with_front'])
						$struct = $wp_rewrite->front . $struct;
						else
							$struct = $wp_rewrite->root . $struct;

							$request = user_trailingslashit ( $struct, 'post_type_archive' );
				} else {
					$request = '?post_type=' . $post_type;
				}

				$home_root = parse_url ( home_url () );
				$home_root = (isset ( $home_root ['path'] )) ? $home_root ['path'] : '';
				$home_root = preg_quote ( $home_root, '|' );

				$request = preg_replace ( '|^' . $home_root . '|i', '', $request );
				$request = preg_replace ( '|^/+|', '', $request );

				if (! $wp_rewrite->using_permalinks () || is_admin ()) {
					$base = trailingslashit ( home_url () );

					if ($pagenum > 1) {
						$result = add_query_arg ( 'paged', $pagenum, $base . $request );
					} else {
						$result = $base . $request;
					}
				} else {
					$qs_regex = '|\?.*?$|';
					preg_match ( $qs_regex, $request, $qs_match );

					if (! empty ( $qs_match [0] )) {
						$query_string = $qs_match [0];
						$request = preg_replace ( $qs_regex, '', $request );
					} else {
						$query_string = '';
					}

					$request = preg_replace ( "|$wp_rewrite->pagination_base/\d+/?$|", '', $request );
					$request = preg_replace ( '|^' . preg_quote ( $wp_rewrite->index, '|' ) . '|i', '', $request );
					$request = ltrim ( $request, '/' );

					$base = trailingslashit ( home_url () );

					if ($wp_rewrite->using_index_permalinks () && ($pagenum > 1 || '' != $request))
						$base .= $wp_rewrite->index . '/';

						if ($pagenum > 1) {
							$request = ((! empty ( $request )) ? trailingslashit ( $request ) : $request) . user_trailingslashit ( $wp_rewrite->pagination_base . "/" . $pagenum, 'paged' );
						}

						$result = $base . $request . $query_string;
				}

				/**
				 * Filter the page number link for the current request.
				 *
				 * @since 2.5.0
				 *
				 * @param string $result
				 *        	The page number link.
				 */
				$result = apply_filters ( 'get_pagenum_link', $result );

				if ($escape)
					return esc_url ( $result );
				else
					return esc_url_raw ( $result );
}

/**
 * Themes Template Part
 * */
function kreme_get_template_part($slug, $name = '') {
	$template_path = untrailingslashit ( get_template_directory() );

	$template = '';

	$name = ( string ) $name;
	if ('' !== $name) {
		$template = $template_path . "/contents/{$slug}-{$name}.php";
	} else
		$template = $template_path . "/contents/{$slug}.php";

		return $template;
}

/**
 * Social Share
 * */
function kreme_social_share_title(){
	$title = str_replace(' ', '%20', get_the_title());
	$title  = str_replace('{', '%7B', $title);
	$title = str_replace('}', '%7D', $title);
	return strip_tags($title);
}

function kreme_social_shares(){

	$social = get_theme_mod('blog_social',
			array(
					array(
							'title' => 'Facebook',
							'icons' => 'fa-facebook',
					),
					array(
							'title' => 'Twitter',
							'icons' => 'fa-twitter',
					),
					array(
							'title' => 'Google',
							'icons' => 'fa-google-plus',
					)
			)
			);

	if ( isset($social) && is_array($social) ) {

		$currentUrl = $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
		if( !empty($_SERVER['HTTPS']) ){
			$currentUrl = "https://" . $currentUrl;
		}else{
			$currentUrl = "http://" . $currentUrl;
		}

		echo '<div class="social-shares">';
		echo '<ul>';

		foreach ($social as $sl) {
			if( $sl['icons'] == 'fa-facebook' ){
				?>
				<li>
					<a href="http://www.facebook.com/share.php?u=<?php echo $currentUrl;?>" target="_blank"><i class="fa <?php echo esc_attr($sl['icons']); ?>"></i></a>
				</li>
				<?php
			}
			if( $sl['icons'] == 'fa-twitter' ){		
				?>
				<li>
					<a href="http://twitter.com/share?url=<?php echo $currentUrl;?>" target="_blank"><i class="fa <?php echo esc_attr($sl['icons']); ?>"></i></a>
				</li>
				<?php
			}
			if( $sl['icons'] == 'fa-stumbleupon' ){		
				?>
				<li>
					<a href="http://www.stumbleupon.com/submit?url=<?php echo $currentUrl;?>&#038;title=<?php echo kreme_social_share_title();?>" target="_blank"><i class="fa <?php echo esc_attr($sl['icons']); ?>"></i></a>
				</li>
				<?php
			}
			if( $sl['icons'] == 'fa-linkedin' ){		
				?>
				<li>
					<a href="http://www.linkedin.com/shareArticle?mini=true&#038;url=<?php echo $currentUrl;?>&#038;title=<?php echo kreme_social_share_title(); ?>" target="_blank"><i class="fa <?php echo esc_attr($sl['icons']); ?>"></i></a>
				</li>
				<?php
			}
			
			if( $sl['icons'] == 'fa-google-plus' ){		
				?>
				<li>		
					<a href="https://plus.google.com/share?url=<?php echo $currentUrl;?>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"><i class="fa <?php echo esc_attr($sl['icons']); ?>"></i></a>					
				</li>
				<?php
			}
			if( $sl['icons'] == 'fa-pinterest'){	
					$thumbnail_id = get_post_thumbnail_id( get_the_ID() );
					$thumbnail = wp_get_attachment_image_src( $thumbnail_id , 'full' );
				?>
				<li>
					<a href="http://pinterest.com/pin/create/button/?url=<?php echo $currentUrl;?>&media=<?php echo $thumbnail[0]; ?>" class="pin-it-button" count-layout="horizontal" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"><i class="fa <?php echo esc_attr($sl['icons']); ?>"></i></a>	
				</li>
				<?php
			}		
		}
		
		echo '</ul>';
		echo '</div>';
	}
}

/**
 * Custom Comment
 * @param unknown $comment
 * @param unknown $args
 * @param unknown $depth
 */
function kreme_comment($comment, $args, $depth) {
	$GLOBALS ['comment'] = $comment;
	extract ( $args, EXTR_SKIP );

	if ('div' == $args ['style']) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}
	?>
		<<?php echo $tag ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
			<article class="comment-body">
				<div class="comment-avatar">
					<?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
				</div>
				<div class="comment-main">
					<h5 class="title"><?php echo get_comment_author_link(); ?></h5>
					<div class="comment-date">Posted: <?php echo get_comment_date(); ?>, <?php echo get_comment_date(get_option('time_format')); ?></div>
					<div class="comment-content">
						<?php comment_text(); ?>
					</div>
					<div class="comment-reply">
						<?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
					</div>
				</div>
			</article>
<?php
}

/**
 * Custom typography fields
 * */
add_filter( 'ot_recognized_typography_fields', 'kreme_ot_recognized_typography_fields', 1, 2);
function kreme_ot_recognized_typography_fields( $default, $field_id ) {

	if ( $field_id == 'typography_heading' )
		return array(
				'font-family',
				'font-style',
				'font-weight'
		);

		return $default;
}

/**
 * Display navigation to next/previous set of posts when applicable.
 * */
 function kreme_pagination() {
 	
 	global $wp_query;
 	
 	if ( $wp_query->max_num_pages <= 1 ) {
 		return;
 	}
 	
 	$args = array();
 	
 	if ( function_exists('is_woocommerce') && is_woocommerce() ) {
 		$args = array(
					'base'         	=> esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) ),
	 				'prev_text'		=> __( 'Previous', 'kreme' ),
	 				'next_text'		=> __( 'Next', 'kreme' ),
 					'type'         	=> 'list',
				);
 		
 	} else {
 		$args = array(
		 			'prev_text'		=> __( 'Previous', 'kreme' ),
					'next_text'		=> __( 'Next', 'kreme' ),
		 			'type'         	=> 'list',
 				);
 	}
 	?>
 	<nav class="navigation paging-navigation" role="navigation">
 		<div class="pagination loop-pagination">
 		<?php
 			echo paginate_links( $args );
 		?>
 		</div>
 	</nav>
 	<?php 
 }
 
 function kreme_the_title() {
 	$title = __( 'Custom Title', 'kreme' );
 	
 	if ( is_404() ){
 		$title = __( 'Oops! That page can&rsquo;t be found.', 'kreme' );
 	
	} elseif ( is_search() ){
 		$title = __( 'Search Results for:', 'kreme' ) . '<span>' . esc_html( get_search_query() ) . '</span>';
 				
 	} elseif ( is_home() && !is_front_page() ){
 		$title = __( 'Latest Posts', 'kreme' );
 				
 	} elseif ( is_category() ) {
 		$title = single_cat_title( '', false );

 	} else if ( function_exists('is_woocommerce') && is_woocommerce() ) {
 		$title = woocommerce_page_title(false);
 		
 	} elseif ( is_archive() ){
 		$title = get_the_archive_title();
 				
 	} elseif ( is_singular() ) {
 		$title = get_the_title();
 	
 	} 
 
 	return $title;
 }