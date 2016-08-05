
<div class="welcome-info <?php echo join($parent_class, ' '); ?>">
	<?php foreach ( $values as $value ) { ?>		
	<?php if ( isset($value['image']) ) { ?>
	<div class="welcome-info-item">
		<!-- Entry -->
		<div class="entry">
			<figure class="entry-thumbnail">
				<?php echo wp_get_attachment_image($value['image'], 'fullsize'); ?>
			</figure>
			<div class="entry-body">
				<h3 class="entry-title"><?php echo esc_attr($value['title']); ?></h3>
				<div class="entry-content"><?php echo apply_filters('mtheme_loop_item_content', $value['content']); ?></div>
			</div>
		</div><!-- End Entry -->
	</div><!-- End Item -->
	<?php } ?>
	<?php } ?>
</div>