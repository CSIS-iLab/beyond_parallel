<?php
/**
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Beyond_Parallel
 */


?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<script src="https://use.typekit.net/ith5zhm.js"></script>
	<script>try{Typekit.load({ async: true });}catch(e){}</script>

	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-80051375-1', 'auto');
		ga('send', 'pageview');

	</script>


	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<div id="page" class="site">

		<div id="toggle">
			<input type="checkbox" id="drawer-toggle" name="drawer-toggle"/>
			<label for="drawer-toggle" id="drawer-toggle-label">
				<div id="nav-icon4">
					<span></span>
					<span></span>
					<span></span>
				</div>
			</label>
			<div class="overlay"></div>

			<div id="popout">
				<nav class="site-navigation mobile-navigation">
			
					<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); // Display the user-defined menu in Appearance > Menus ?>

					<div class="secondary-nav">
						<form role="search" method="get" class="search-form" action="<?php echo home_url('/'); ?>">
							<div class="search-icon">
								
								<img src="<?php echo get_template_directory_uri(); ?>/assets/images/search-icon.svg" height="30px"><span>Search</span>
							</div><!--/search-icon -->
							<div class="search-input">
								
								<input type="search" 
								class="search-field" 
								placeholder=""  
								value="" name="s" 
								title="Search:">
								
								<input type="image" src="<?php echo get_template_directory_uri(); ?>/assets/images/gray-arrow.svg" height="30px" class="search-submit" alt="">
							</div><!--/search-input -->
						</form>
						
						<div class="social-media">
							<div class="social">
								<a href="https://www.facebook.com/csiskoreachair/" alt="CSIS Korea Chair Facebook">
									<div class="facebook-icon"></div>
									<div class="social-info">CSIS Korea Chair</div>
								</a>
								
								<div class="clearfix"></div>
								
								<a href="https://twitter.com/beyondcsiskorea?lang=en" alt="Beyond Parallel Twitter">
									<div class="twitter-icon"></div>
									<div class="social-info">@BeyondCSISKorea</div>
								</a>
								
								<div class="clearfix"></div>
								
								<a href="mailto:KoreaChair@csis.org?Subject=" alt="Email Beyond Parallel">	<div class="email-icon"></div>
									<div class="social-info">KoreaChair@csis.org</div>
								</a>
							</div><!--/social -->
						</div><!--/spcial-media -->
				</nav> 

			</div> <!--/popout -->
		</div> <!--/toggle -->

			
		<header id="masthead" class="site-header" role="banner">
			<div class="mainNav">	
				<div class="container">
					<div style="text-align: center;">
						<div class="header-info">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
								<img src="<?php echo get_bloginfo('template_url') ?>/assets/images/beyond-parallel-logo.svg" class="header-logo">
							</a>

							<p class="mission">Bringing <span style="color:#ffc624;">TRANSPARENCY</span> and <span style="color:#ffc624;">UNDERSTANDING</span> to Korean Unification</p>
						</div><!--/header-info-->
					</div>
				</div><!--/container -->

				<div id="nav-bar">
					<div class="container">
						<nav role="navigation" class="site-navigation main-navigation">
							<div id="main-menu-container">
								<?php wp_nav_menu( array( 'theme_location' => 'primary',  'menu_class' => 'nav-menu') ); // Display the user-defined menu in Appearance > Menus 

								?>
							</div><!--/main-menu-container -->

							<div class="secondary-nav">
								<form role="search" method="get" class="search-form" action="<?php echo home_url('/'); ?>">
									<div class="search-icon">
										<img src="<?php echo get_template_directory_uri(); ?>/assets/images/search-icon.svg" height="30px"><span>SEARCH</span>
									</div><!--/search-icon -->

									<div class="search-input">
										<input type="search" class="search-field" placeholder="" value="" name="s" title="Search:">
										<input type="image" src="<?php echo get_template_directory_uri(); ?>/assets/images/gray-arrow.svg" height="30px" class="search-submit" height="30px" alt="">
									</div><!--/search-input -->
								</form>
							
								<div class="social-media">
									<div class="social">
										<a href="https://www.facebook.com/csiskoreachair/" alt="CSIS Korea Chair Facebook">
											<div class="facebook-icon"></div>
										</a>
										
										<a href="https://twitter.com/beyondcsiskorea?lang=en" alt="Beyond Parallel Twitter">
											<div class="twitter-icon"></div>
										</a>
										
										<a href="mailto:KoreaChair@csis.org?Subject=" alt="Email Beyond Parallel">
											<div class="email-icon"></div>
										</a>
									</div><!--/social -->
								</div><!--/social-media -->
							</div><!--/secondary-nav -->
						</nav>
					</div><!--/container -->

				</div> <!--/nav-bar -->

			</div><!-- /mainNav -->

	<div class="clear"></div>
	</div><!--/container -->

</header><!-- #masthead .site-header -->


