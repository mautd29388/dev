
<!-- Slider -->
<div class="testimonial-slider <?php echo join($parent_class, ' '); ?>">
	<div class="slider-flickity">
		<?php foreach ( $values as $value ) { ?>
			<!-- Item -->
			<div class="gallery-cell <?php echo join($item_class, ' '); ?>">
				<?php if ( isset($value['image']) ) { ?>
				<figure><?php echo wp_get_attachment_image($value['image'], 'fullsize'); ?></figure>
				<?php } ?>
				<aside class="testimonial-entry">
					<?php if ( isset($value['content'])) { ?>
					<p class="testimonial-content">
						<?php echo apply_filters('mTheme_testimonial_content', $value['content']); ?>
					</p>
					<?php } ?>
					<?php if ( isset($value['name']) ) { ?>
						<h4 class="testimonial-name">
							<?php echo esc_attr($value['name']); ?> 
							<?php if ( isset($value['skills']) ) { ?>
							, <small><?php echo $value['skills']; ?></small>
							<?php } ?>
						</h4>
					<?php } ?>
				</aside>
			</div><!-- End Item -->
		<?php } ?>
	</div>
</div><!-- End Slider -->
