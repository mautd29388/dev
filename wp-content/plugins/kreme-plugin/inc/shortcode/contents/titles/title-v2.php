<!-- Section Header  -->
<div class="section-header <?php echo join($parent_class, ' '); ?>">
	<div class="section-subtitle"><?php echo wp_kses($content, array( 'a', 'strong', 'i', 'b', 'span')); ?></div>
	<h2 class="section-title"><span><?php echo esc_html($atts['title']); ?></span></h2>
</div>