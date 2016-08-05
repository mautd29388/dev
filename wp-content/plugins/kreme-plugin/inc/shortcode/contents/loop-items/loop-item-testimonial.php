<!-- Slider -->
<div class="testimonials-slider <?php echo join($parent_class, ' '); ?>">
	<div class="row">
		<div class="slider-flickity">
			<?php foreach ( $values as $value ) { ?>
			<!-- Item -->
			<div class="testimonial <?php echo join($item_class, ' '); ?>">
				<!-- Entry -->
				<div class="entry">
					<?php if ( isset($value['image']) ) { ?>
					<figure class="entry-thumbnail">
						<?php echo wp_get_attachment_image($value['image'], 'fullsize'); ?>
					</figure>
					<?php } ?>
					<div class="entry-body">
						<?php if ( isset($value['name']) ) { ?>
						<h4 class="entry-title">
							<span class="entry-name"><?php echo esc_html($value['name']); ?></span>
							<?php if ( isset($value['skills']) ) { ?>
							<span class="entry-skill"><?php echo esc_html($value['skills']); ?></span>
							<?php } ?>
						</h4>
						<?php } ?>
						
						<?php if ( isset($value['content']) ) { ?>
						<div class="entry-content"><?php echo apply_filters('mtheme_loop_item_content', $value['content']); ?></div>
						<?php } ?>
					</div>
				</div><!-- End Entry -->
			</div><!-- End Item -->
			<?php } ?>
		</div>
	</div>
</div>
