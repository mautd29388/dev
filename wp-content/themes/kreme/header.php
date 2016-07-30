<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
<?php 
	$boxed							= get_theme_mod('main_boxed', 'off');
	$container 						= kreme_container();
	$style		 					= get_theme_mod('header_styles', 'style-v1');
	$header_top_sidebar				= get_theme_mod('header_top_sidebar');
	$header_middle_sidebar			= get_theme_mod('header_middle_sidebar');
	$header_bottom_sidebar			= get_theme_mod('header_bottom_sidebar');
	$logo							= get_theme_mod('logo', '');
?> 
</head>

<body <?php body_class(); ?>>
	<!--[if lt IE 9]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <?php $wrap = $boxed == 'off' ? '' : 'wrap-boxed'; ?>
	<div id="wrap" class="<?php echo apply_filters('wrap_boxed', $wrap); ?>">

		<!-- Header -->
		<header id="header" class="header <?php echo isset($style) ? $style : ''; ?>">
			<div class="header-inner">
	      		
	      		<!-- Header Top -->
	      		<?php 
	      		if ( isset($header_top_sidebar) && is_array($header_top_sidebar) && count($header_top_sidebar) > 0 ) {
	      			
	      			$i = $j = 0;
      				foreach ( $header_top_sidebar as $sidebar ) {
      					
      					$i++;
	      				if ( is_active_sidebar($sidebar['sidebar']) ) { 
	      					
	      					$j++;
	      					
	      					if ( $j == 1 ) { ?>
		      				<div class="header-top"><div class="header-top-inner"><div class="<?php echo apply_filters('container', $container); ?>"><div class="row">
							<?php } ?>
							
		      					<div class="col-sm-<?php echo esc_attr($sidebar['width']); ?> <?php echo apply_filters('sidebar_header_top_el_class', $sidebar['el_class']); ?>">
		      						<div class="sidebar-inner">
		      							<?php dynamic_sidebar($sidebar['sidebar']); ?>
		      						</div>
		      					</div>
		      			<?php 		
	      				}
	      				if ( $i == count($header_top_sidebar) && $j > 0 ) { ?>
      						</div></div></div></div>
      					<?php }
      				}
	      		} 
	      		?>
	      		
	      		
	      		<!-- Header Middle -->
				<div class="header-middle">
					<div class="header-middle-inner">
						<div class="container">
						
							<!-- Logo -->
							<div id="logo" class="logo">
								<a href="<?php echo esc_url( home_url() ); ?>">
									<?php if ( isset($logo) && !empty($logo) ) { ?>
										<img alt="" src="<?php echo $logo; ?>">
									<?php } else echo bloginfo('name'); ?>
								</a>
							</div>
						
							<!-- Main Menu -->
							<nav id="primary-navigation" class="navbar" role="navigation">
								<div class="navbar-inner">
									<div class="navbar-header">
										<button type="button" class="navbar-toggle collapsed"
											data-toggle="collapse" data-target="#navbar">
											<span class="sr-only">Toggle navigation</span> <span
												class="icon-bar"></span> <span class="icon-bar"></span> <span
												class="icon-bar"></span>
										</button>
										
									</div>
									<div id="navbar" class="navbar-collapse collapse">
									<?php 
									wp_nav_menu ( 
										array ( 
											'theme_location' => 'primary-left',
											'container' => '',
											'menu_class' => 'nav navbar-nav',
											'walker' => new mTheme_nav_walker
										) 
									);
									wp_nav_menu ( 
										array ( 
											'theme_location' => 'primary-right',
											'container' => '',
											'menu_class' => 'nav navbar-nav',
											'walker' => new mTheme_nav_walker
										) 
									);?>
									</div>
									<!--/.navbar-collapse -->
								</div>
							</nav><!-- End Menu -->
							
						</div><!-- End Container -->
					</div>
				</div> <!-- End Header Middle -->
			</div>
			
		</header>
		<!-- End Header -->

		<!-- Main Content -->
		<div id="main-content" class="main-content">
			<div class="main-contents-inner">
			
				<?php if ( !is_front_page() ) { ?>
				<!-- Page Header -->
				<div class="page-header">
					<div class="page-header-inner">
						<div class="page-header-entry">
							<h1 class="page-title"><span><?php echo kreme_the_title(); ?></span></h1>
							<div class="page-breadcrumb">
							<?php 
							Kreme_Breadcrumb::instance(array(
									'wrap_before' => '<div class="breadcrumb">',
									'delimiter' => ' / ',
									'before'      => '<span>',
									'after'       => '</span>',
							));
							?>
							</div>
							
						</div>
					</div>
					<div class="section-radius section-radius-bottom"></div>
				</div><!-- End Page Header -->
				<?php } ?>
				
				<!-- Page Content -->
				<div class="page-content">
					<div class="page-content-inner">
						
						<div class="container">