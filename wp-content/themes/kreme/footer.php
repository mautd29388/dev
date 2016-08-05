						</div><!-- End Container -->
					</div><!-- End Inner -->
				</div><!-- End Page Content -->
			</div><!-- End Inner -->
		</div> <!-- End Main Content -->
		
		<?php 
		$sidebar_footer_top 	= get_theme_mod('sidebar_footer_top');
		$sidebar_footer 		= get_theme_mod('sidebar_footer');
		$copyright 				= get_theme_mod('copyright', '');
		$container				= kreme_container();
		?>	
		<!-- Footer -->
		<footer id="footer" class="footer">
		
			<?php if ( isset($sidebar_footer_top) && is_array($sidebar_footer_top) && count($sidebar_footer_top) > 0 ) { ?>
      		<div class="footer-info">
				<div class="<?php echo apply_filters('container', $container); ?>">
					<div class="row">
      				<?php foreach ( $sidebar_footer_top as $sidebar ) { ?>
	      				<?php if ( is_active_sidebar($sidebar['sidebar']) ) { ?>
	      				<div class="col-sm-<?php echo $sidebar['width']; ?> <?php echo apply_filters('sidebar_footer_top_el_class', $sidebar['el_class']); ?>">
	      					<div class="sidebar-inner">
	      						<?php dynamic_sidebar($sidebar['sidebar']); ?>
	      					</div>
	      				</div>
	      				<?php } ?>
      				<?php } ?>
      				</div>
      			</div>
      		</div>
      		<?php } ?>
      		
      		<?php if ( isset($sidebar_footer) && is_array($sidebar_footer) && count($sidebar_footer) > 0 ) { ?>
      		<div class="footer-button">
				<div class="<?php echo apply_filters('container', $container); ?>">
					<div class="row">
      				<?php foreach ( $sidebar_footer as $sidebar ) { ?>
	      				<?php if ( is_active_sidebar($sidebar['sidebar']) ) { ?>
	      				<div class="col-sm-<?php echo $sidebar['width']; ?> <?php echo apply_filters('sidebar_footer_info_el_class', $sidebar['el_class']); ?>">
	      					<div class="sidebar-inner">
	      						<?php dynamic_sidebar($sidebar['sidebar']); ?>
	      					</div>
	      				</div>
	      				<?php } ?>
      				<?php } ?>
      				</div>
      			</div>
      		</div>
      		<?php } ?>
	      	
	      	<div class="copyright">
	      		<div class="<?php echo apply_filters('container', $container); ?>">
					<!-- Row -->
					<div class="row">
						<div class="col-lg-6 col-lg-push-6 visible-lg">
							<div class="navbar-footer">
								<?php 
								wp_nav_menu ( 
									array ( 
										'theme_location' => 'footer-menu',
										'container' => '',
										'menu_class' => 'nav navbar-nav',
										'walker' => new mTheme_nav_walker
									) 
								);?>
							</div>
						</div><!--End Col -->
						<div class="col-lg-6 col-lg-pull-6">
							<div class="copyright-content">
								<?php echo apply_filters('copyright', $copyright); ?>
							</div>
						</div><!--End Col -->
					</div><!-- End Row -->
					
				</div>
			</div>
	    </footer>
			
	</div> <!-- End Wrapt -->

<?php wp_footer(); ?>

</body>
</html>
