<?php
/**
 * Template Name: Home Page
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

get_header(); ?>

	<script type="text/javascript">
		jQuery(function(){
			// jQuery('#camera_wrap_3').camera({
			// 	pagination: true,
			// 	loader: 'none',
			// 	playPause: false,
			// 	height: '31%',
			// 	fx: "simpleFade",
			// 	time : 3000,
			// 	transPeriod			: 1000
			// });
			
			jQuery('.flexslider_wrap').flexslider({
				controlNav: false,
				prevText: "",
				nextText: "",
				smoothHeight: true,
				init: function() {
					
				}
			});
		});

		jQuery(window).resize(function(){
			var overlay_width = jQuery(window).width() + 188;
			var overlay_height = jQuery(window).width() * 0.31 > 200 ? jQuery(window).width() * 0.31 : 200;

			overlay_height = 500;

			jQuery('.home_slider_overlay_wrapper').css('width', overlay_width + "px");
			jQuery('.home_slider_overlay_wrapper').css('height', overlay_height);
			// jQuery('.home_slider_overlay_wrapper').css('right', '-'+overlay_width + "px");
			
			var img_width = jQuery('.image_wrapper img').width();
			
			var img_left = (jQuery(window).width() - jQuery('.image_wrapper img').width()) / 2;
			jQuery('.image_wrapper img').css('left', img_left + "px");

			var fontsize = jQuery(window).width()*0.038;
			if (fontsize > 30) fontsize = 30;
			if (fontsize < 17) fontsize = 17;
			jQuery('.home_slider_view_availability_wrapper a').css('font-size', fontsize);			
		});

		jQuery(window).load(function(){
			// var overlay_width = jQuery(window).width() + 188;
			// jQuery('.home_slider_overlay_wrapper').css('width', overlay_width + "px");
			// jQuery('.home_slider_overlay_wrapper').css('right', '-'+overlay_width + "px");
			// jQuery('.home_slider_overlay_wrapper').css('display', 'block');
			
			// var img_width = jQuery('.image_wrapper img').width();
			
			// var img_left = (jQuery(window).width() - jQuery('.image_wrapper img').width()) / 2 +188;
			// jQuery('.image_wrapper img').css('left', img_left + "px");

			// setTimeout(function() {
			// 	jQuery( ".home_slider_overlay_wrapper" ).animate({
			// 		right: "0"
			// 	}, 2000, function() {
			// 	});
			// }, 2000);
			
			var overlay_width = jQuery(window).width() + 188;
			var overlay_height = jQuery(window).width() * 0.31 > 200 ? jQuery(window).width() * 0.31 : 200;			
			
			overlay_height = 500;

			jQuery('.home_slider_overlay_wrapper').css('width', overlay_width + "px");
			jQuery('.home_slider_overlay_wrapper').css('height', overlay_height);
			jQuery('.home_slider_overlay_wrapper').css('right', overlay_width + "px");
			jQuery('.home_slider_overlay_wrapper').css('display', 'block');

			jQuery('#home_page .home_slider_overlay_wrapper .left').css('left', jQuery(window).width()+"px");
			jQuery('#home_page .home_slider_overlay_wrapper .right').css('width', jQuery(window).width()+"px");
			
			var img_width = jQuery('.image_wrapper img').width();
			
			// var img_left = (jQuery(window).width() - jQuery('.image_wrapper img').width()) / 2 +188;
			var img_left = (jQuery(window).width() - jQuery('.image_wrapper img').width()) / 2;
			jQuery('.image_wrapper img').css('left', img_left + "px");

			setTimeout(function() {
				jQuery( ".home_slider_overlay_wrapper" ).animate({
					right: "-188px"
				}, 2000, function() {
					setTimeout(function() {
						jQuery('#home_page .home_slider_overlay_wrapper').fadeOut(1000);
					}, 3000);
				});
			}, 500);

			var fontsize = jQuery(window).width()*0.038;
			if (fontsize > 30) fontsize = 30;
			if (fontsize < 17) fontsize = 17;
			jQuery('.home_slider_view_availability_wrapper a').css('font-size', fontsize);
		});
	</script>

	<div id="home_page" class="content-area">
	<!-- <div id="residences_page" class="content-area amenities_page"> -->
		<?php 
			$background_image = get_field('background_image', get_the_ID());
		 ?>

		 <!-- <div id="background_wrapper" style="background: url(<?php echo $background_image; ?>)"></div> -->
		 <div id="background_wrapper">
		 	<!-- slider -->
			 <?php 
				$slider_images = get_field('slide_images');

				if(sizeof($slider_images) > 1){
			?>
				<div class="flexslider_wrap">
			<?php
				}
			else{
				?>
				<div class="flexslider_wrap one_slider_1">
				<?php
			}
				?>
					<ul class="slides">
				<?php
				foreach ($slider_images as $key => $value) {
			 		$image = $value['slide_image'];
			 		?>
			 		<li style="background-image:url(<?php echo $image; ?>)">
		 				
		 			</li>
				<?php
					}

				 if(sizeof($slider_images) == 1){
				?>
					<li style="background-image:url(<?php echo $image; ?>)">
		 				
		 			</li>
				<?php
				}
				 ?>
				</ul>
			</div><!-- #camera_wrap_3 -->

			<div class="home_slider_view_availability_wrapper" style="text-align:center;">
				<?php 
					$availability_url = get_post_permalink(17);
				 ?>
				<a href="<?php echo $availability_url; ?>">View Availability</a>
			</div>

			<div class="home_slider_overlay_wrapper">
				<div>
					<div class="image_wrapper">
						<img src="<?php echo get_template_directory_uri()."/images/home-slider-background-text.png" ?>">	
					</div>
					<div class="left"></div>
					<div class="right"></div>					
				</div>
			</div>

			<!-- <img class="badge" src="<?php echo get_template_directory_uri()."/images/Mont_Park_Badge.png" ?>"> -->
		 </div>

		 <div class="clearfix"></div>

		 <div class="site_content cards amenities_content">
		 	<?php 
		 		$amenities_featured_image = wp_get_attachment_url( get_post_thumbnail_id(11));
		 		$residences_featured_image = wp_get_attachment_url( get_post_thumbnail_id(13));
		 		$neighborhood_featured_image = wp_get_attachment_url( get_post_thumbnail_id(15));

		 		
		 		$amenities_excerpt = get_field('excerpt', 11);
		 		$resicences_excerpt = get_field('excerpt', 13);
		 		$neighborhood_excerpt = get_field('excerpt', 15);

		 		$amenities_url = esc_url(get_permalink(get_page_by_title('Amenities')));
		 		$residences_url = esc_url(get_permalink(get_page_by_title('Residences')));
		 		$neighborhood_url = esc_url(get_permalink(get_page_by_title('Neighborhood')));
		 	 ?>
		 	<a href="<?php echo $amenities_url; ?>">
			 	<div class="element">
			 		<img src="<?php echo $amenities_featured_image; ?>">
			 		<div class="clearfix"></div>
			 		<span>AMENITIES</span>
			 		<div class="clearfix"></div>
			 		<p><?php echo $amenities_excerpt; ?></p>
			 		<div class="clearfix"></div>
			 		<span class="read_more">Read more...</span>
			 	</div>
		 	</a>

			<a href="<?php echo $residences_url; ?>">
			 	<div class="element">
			 		<img src="<?php echo $residences_featured_image; ?>">
			 		<div class="clearfix"></div>
			 		<span>RESIDENCES</span>
			 		<div class="clearfix"></div>
			 		<p><?php echo $resicences_excerpt; ?></p>
			 		<div class="clearfix"></div>
			 		<span class="read_more">Read more...</span>
			 	</div>
			</a>

			<a href="<?php echo $neighborhood_url; ?>">
			 	<div class="element">
			 		<img src="<?php echo $neighborhood_featured_image; ?>">
			 		<div class="clearfix"></div>
			 		<span>NEIGHBORHOOD</span>
			 		<div class="clearfix"></div>
			 		<p><?php echo $neighborhood_excerpt; ?></p>
			 		<div class="clearfix"></div>
			 		<span class="read_more">Read more...</span>
			 	</div>
			</a>
		 </div>
	</div><!-- .content-area -->
<?php get_footer(); ?>