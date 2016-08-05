<div class="nutrition-philosophy-items <?php echo join($parent_class, ' '); ?>">
	<!-- Row -->
	<div class="row">
		<div class="col-md-6 col-lg-4">
			<ul class="box-left">
				<?php foreach ( $box_left as $value ) { ?>
				<li class="nutrition-philosophy-item">
					<!-- Entry -->
					<div class="entry">
						<?php if ( isset($value['image']) ) { ?>
						<div class="entry-thumbnail">
							<div class="np-icon">
								<?php echo wp_get_attachment_image($value['image'], 'fullsize'); ?>
							</div>
						</div>
						<?php } ?>
						<div class="entry-body">
							<?php if ( isset($value['title']) ) { ?>
							<h4 class="entry-title"><?php echo esc_attr($value['title']); ?> </h4>
							<?php } ?>
							
							<?php if ( isset($value['content']) ) { ?>
							<div class="entry-content"><?php echo apply_filters('mTheme_nutrition_philosophy_content', $value['content']); ?></div>
							<?php } ?>
						</div>
					</div><!-- End Entry -->
				</li>
				<?php } ?>
			</ul>
		</div><!--End Col -->
		<div class="col-md-6 col-lg-4 col-lg-push-4">
			<ul class="box-right">
				<?php foreach ( $box_right as $value ) { ?>
				<li class="nutrition-philosophy-item">
					<!-- Entry -->
					<div class="entry">
						<?php if ( isset($value['image']) ) { ?>
						<div class="entry-thumbnail">
							<div class="np-icon">
								<?php echo wp_get_attachment_image($value['image'], 'fullsize'); ?>
							</div>
						</div>
						<?php } ?>
						<div class="entry-body">
							<?php if ( isset($value['title']) ) { ?>
							<h4 class="entry-title"><?php echo esc_attr($value['title']); ?> </h4>
							<?php } ?>
							
							<?php if ( isset($value['content']) ) { ?>
							<div class="entry-content"><?php echo apply_filters('mTheme_nutrition_philosophy_content', $value['content']); ?></div>
							<?php } ?>
						</div>
					</div><!-- End Entry -->
				</li>
				<?php } ?>
			</ul>
		</div><!--End Col -->
		<div class="col-lg-4 col-lg-pull-4">
			<figure class="box-image">
				<?php echo wp_get_attachment_image($atts['banner'], 'fullsize'); ?>
			</figure>
		</div><!--End Col -->
	</div><!-- End Row -->
</div>
