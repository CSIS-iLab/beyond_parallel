<?php
	/*-----------------------------------------------------------------------------------*/
	/* This template will be called by all other template files to finish 
	/* rendering the page and display the footer area/content
	/*-----------------------------------------------------------------------------------*/
?>

</div><!-- / end page container, begun in the header -->

<footer class="site-footer" role="contentinfo">
	<div class="site-info container" style="padding-top:27px;">

<center><img src="/wp-content/uploads/2016/04/csis_white.png">

<form method="get" style="padding-top: 30px;" id="searchform" action="<?php bloginfo('home') ; ?>/">
<div><input type="text" size="18" value="<?php echo wp_specialchars($s, 1); ?>" name="s" id="s" />
<button type="submit" style="border:none;background:none;"><i style="color:white !important;font-size:1em !important;" class="fa fa-search"></i></button>
</center>
</div>
</form>

		
	</div><!-- .site-info -->
</footer><!-- #colophon .site-footer -->

<?php wp_footer(); 
// This fxn allows plugins to insert themselves/scripts/css/files (right here) into the footer of your website. 
// Removing this fxn call will disable all kinds of plugins. 
// Move it if you like, but keep it around.
?>

</body>
</html>
