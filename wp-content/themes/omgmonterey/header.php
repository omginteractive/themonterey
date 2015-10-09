<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Omg_Monterey
 * @since Omg Monterey 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<link type="text/css" rel="stylesheet" href="http://fast.fonts.net/cssapi/1ffe251d-0931-4b2d-9979-cc382f4f9f16.css"/>
	<!--[if lt IE 9]>
	<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/html5.js"></script>
	<![endif]-->
	<script>(function(){document.documentElement.className='js'})();</script>

	<?php wp_head(); ?>

	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

	
	<!-- <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri();?>/js/camera/css/camera.css" /> -->

	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri();?>/js/meanMenu-master/meanmenu.css" />

	<!-- <script src="<?php echo get_template_directory_uri();?>/js/camera/scripts/jquery.mobile.customized.min.js"></script>
	<script src="<?php echo get_template_directory_uri();?>/js/camera/scripts/jquery.easing.1.3.js"></script>
	<script src="<?php echo get_template_directory_uri();?>/js/camera/scripts/camera.js"></script> -->
	<!-- <script src="<?php echo get_template_directory_uri();?>/js/camera/scripts/camera.min.js"></script> -->
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri();?>/js/flexslider/flexslider.css" />
	<script src="<?php echo get_template_directory_uri();?>/js/flexslider/jquery.flexslider.js"></script>
	<script src="<?php echo get_template_directory_uri();?>/js/meanMenu-master/jquery.meanmenu.js"></script>

	<script>
		function _uGC(l,n,s){if(!l||l==""||!n||n==""||!s||s=="")return"-";
		var i,i2,i3,c="-";i=l.indexOf(n);i3=n.indexOf("=")+1;
		if(i>-1){i2=l.indexOf(s,i);
			if(i2<0){i2=l.length;}
			c=l.substring((i+i3),i2);}
			return c;
		}

		// new
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){

			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),

			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)

		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	
		ga('create', 'UA-xxxxxxxx-x', 'auto');

		ga('require', 'displayfeatures');

		ga('send', 'pageview');
		// end new
		
		function set_footer () {
			// var window_height = jQuery(window).height();
			// jQuery('#page').css('height', "auto");
			// var page_height = jQuery('#page').height();

			// jQuery('footer').css('margin-top', 20+"px");

			// if(page_height < window_height){
			// 	jQuery('#page').css('height', window_height+"px");

			// 	var footer_top = jQuery('footer').offset().top;
			// 	footer_margin_top = window_height - footer_top - 66;
			// 	jQuery('footer').css('margin-top', footer_margin_top+"px");
			// }
			var window_height = jQuery(window).height();
			jQuery('#page').css('height', "auto");
			var page_height = jQuery('#page').height();

			jQuery('footer').css('margin-top', 20+"px");
			
			if(page_height < window_height){
				var footer_top = jQuery('footer').offset().top;
				footer_margin_top = window_height - footer_top - 66;
				jQuery('footer').css('margin-top', footer_margin_top+"px");
			}

			jQuery('footer').css('visibility', 'visible');
		}
		
		jQuery(document).ready(function(){

			jQuery('html').keydown(function(e){
				if(e.keyCode == 37){
					jQuery('.camera_prev').trigger('click');
				}

				if(e.keyCode == 39){
					jQuery('.camera_next').trigger('click');
				}
			});

			jQuery('header .main-navigation').meanmenu({
				meanScreenWidth: "960"
			});

			jQuery(window).load(function(){
				set_footer();
			});

			jQuery(window).resize(function(){
				set_footer();
			});
		});
	</script>
    

    
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<div class="site_content">
		<header id="masthead" class="site-header" role="banner">
			<?php 
				$logo = get_field('logo', 'options');
			 ?>
			 <a href="<?php echo site_url(); ?>"><img src="<?php echo $logo; ?>"></a>
			 <?php get_sidebar(); ?>
		</header><!-- .site-header -->

	</div><!-- .sidebar -->

	<div class="clearfix"></div>

	<div id="content" class="site-content">
