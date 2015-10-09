<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "site-content" div and all content after.
 *
 * @package WordPress
 * @subpackage Omg_Monterey
 * @since Omg Monterey 1.0
 */
?>

	</div><!-- .site-content -->

	<div class="clearfix"></div>

	<footer id="colophon" role="contentinfo">
		<div class="site-info site_content">
			<?php 
				$footer_text_1 = get_field('footer_text_1', 'options');
				$footer_text_2 = get_field('footer_text_2', 'options');
				$footer_text_3 = get_field('footer_text_3', 'options');
				$footer_text_4 = get_field('footer_text_4', 'options');
				$footer_text_5 = get_field('footer_text_5', 'options');
				$footer_text_6 = get_field('footer_text_6', 'options');
				$footer_text_7 = get_field('footer_text_7', 'options');
				$footer_text_8 = get_field('footer_text_8', 'options');
				$footer_text_9 = get_field('footer_text_9', 'options');
				$footer_text_10 = get_field('footer_text_10', 'options');
				$footer_apply_link = get_field('footer_apply_link', 'options');
				$footer_resident_link = get_field('footer_resident_link', 'options');
				$footer_monterey = get_field('footer_monterey', 'options');

				$privacy_url = esc_url(get_permalink(get_page_by_title('privacy')));
				$terms_url = esc_url(get_permalink(get_page_by_title('terms')));
			 ?>
			<div id="footer_logo" style="float: left;"><a href="#"><img src="<?php echo content_url()?>/uploads/2015/05/footer_logo.png" /></a></div>
			 <div class="left" id="footer_text">
                	
                <span><?php echo $footer_text_1; ?></span>
			 	<span class="dot first_hidden">&sdot;</span>
			 	<div class="clearfix first_splited_clear"></div>
			 	<span><?php echo $footer_text_2; ?></span>
			 	<span class="first_hidden">,</span>
			 	<div class="clearfix first_splited_clear"></div>
			 	<span><?php echo $footer_text_3; ?></span>
			 	<span>,</span>
			 	<span><?php echo $footer_text_4; ?></span>
			 	<span> </span>
			 	<div class="clearfix first_splited_clear"></div>
			 	<span><script type="text/JavaScript" src="https://secure.ifbyphone.com/js/keyword_replacement.js"></script></span>
			 	<div class="clearfix"></div>
			 	<span><a href="<?php echo $footer_resident_link; ?>" target="_blank"><?php echo $footer_text_6; ?></a></span>
			 	<span class="dot second_hidden">&sdot;</span>
			 	<div class="clearfix second_splited_clear"></div>
			 	<span><a href="<?php echo $footer_apply_link; ?>" target="_blank"><?php echo $footer_text_7; ?></a></span>
			 	<span class="dot second_hidden">&sdot;</span>
			 	<div class="clearfix second_splited_clear"></div>
			 	<span><a href="<?php echo $privacy_url; ?>"><?php echo $footer_text_8; ?></a>
			 	<!--  / <a href="<?php echo $terms_url; ?>"><?php echo $footer_text_9; ?></a></span> -->
			 	<!-- <span class="dot second_hidden">&sdot;</span>
			 	<div class="clearfix second_splited_clear"></div>
			 	<a href="/availability" class="footer_red">
					<span><?php echo $footer_text_10; ?></span>			 		
			 	</a> -->
			 </div>
			 <div class="right">
			 	<?php 
			 		$footer_twitter = get_field('footer_twitter', 'options');
			 		$footer_facebook = get_field('footer_facebook', 'options');
					
			 	 ?>
                 
			 	 <a href="https://twitter.com/montereyatpark" target="_blank"><img src="<?php echo $footer_twitter ?>" /></a>
			 	 <a href="https://www.facebook.com/pages/The-Monterey-at-Park/1567708496819441?fref=ts" target="_blank"><img src="<?php echo $footer_facebook ?>" /></a>
                 
			 </div>
			<?php
				/**
				 * Fires before the Omg Monterey footer text for footer customization.
				 *
				 * @since Omg Monterey 1.0
				 */
				do_action( 'omgmonterey_credits' );
			?>
		</div><!-- .site-info -->
	</footer><!-- .site-footer -->

</div><!-- .site -->


<!--  Quantcast Tag -->
<script>
  qcdata = {} || qcdata;
       (function(){
       var elem = document.createElement('script');
       elem.src = (document.location.protocol == "https:" ? "https://secure" : "http://pixel") + ".quantserve.com/aquant.js?a=p-V3dBEBcmp6_5F";
       elem.async = true;
       elem.type = "text/javascript";
       var scpt = document.getElementsByTagName('script')[0];
       scpt.parentNode.insertBefore(elem,scpt);
     }());


   var qcdata = {qacct: 'p-V3dBEBcmp6_5F',
                        orderid: '',
                        revenue: ''
                        };
</script>
  <noscript>
    <img src="//pixel.quantserve.com/pixel/p-V3dBEBcmp6_5F.gif?labels=_fp.event.Default" style="display: none;" border="0" height="1" width="1" alt="Quantcast"/>
  </noscript>
<!-- End Quantcast Tag -->

<!-- Google Code for Remarketing Tag -->
<!--------------------------------------------------
Remarketing tags may not be associated with personally identifiable information or placed on pages related to sensitive categories. See more information and instructions on how to setup the tag on: http://google.com/ads/remarketingsetup
--------------------------------------------------->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 947277438;
var google_custom_params = window.google_tag_params;
var google_remarketing_only = true;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/947277438/?value=0&amp;guid=ON&amp;script=0"/>
</div>
</noscript>

<?php wp_footer(); ?>

</body>
</html>
