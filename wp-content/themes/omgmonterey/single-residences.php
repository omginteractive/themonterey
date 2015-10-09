<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package WordPress
 * @subpackage Omg_Monterey
 * @since Omg Monterey 1.0
 */

get_header(); ?>

	<script type="text/javascript">
		jQuery(function(){
			
			// jQuery('#camera_wrap_3').camera({
			// 	pagination: true,
			// 	loader: 'none',
			// 	playPause: false,
			// 	fx: "simpleFade",
			// 	time : 5000,
			// 	transPeriod			: 1000,
			// 	height: '600px'
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
	</script>

	<div id="residences_page" class="content-area post_single_content">
		 <div class="site_content_old">
		 	<!-- slider -->
			<?php 
			$slider_images = get_field('images', get_the_ID());

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
							$image = $value['image'];
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
			<div class="camera_wrap camera_caption_wrapper">
				<div>
					<div class="camera_caption fadeFromBottom">
						<div>
							<div>
								<?php 
									$slider_title = get_field('slider_title');
									$slider_excerpt = get_field('slider_excerpt');
								 ?>
								<h1><?php echo $slider_title; ?></h1>
								<span><?php echo $slider_excerpt; ?></span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- end slider -->

			<div class="clearfix"></div>

			<div class="description_wrapper">
				<p>
					<?php 
						while ( have_posts() ) : the_post();
					?>
							<div class="breadcrumb_wrapper">
								<a href="/residences">Residences</a> > <?php the_title(); ?>		
							</div>
					<?php
							the_content();
						endwhile;
					 ?>
				</p>
			</div>
		 </div>
	</div><!-- .content-area -->
<?php get_footer(); ?>