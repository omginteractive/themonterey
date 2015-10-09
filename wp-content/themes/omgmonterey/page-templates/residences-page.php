<?php
/**
 * Template Name: Residences Page
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
			// 	fx: "simpleFade",
			// 	time : 5000,
			// 	transPeriod			: 1000,
			// 	height: '31%'
			// });

			jQuery(window).load(function(){
				// jQuery('#camera_wrap_3').css('position', 'relative');
				// jQuery('#camera_wrap_3').css('left', '0');
			});

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

	<div id="residences_page" class="content-area">
		 <div class="site_content_old">
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

			<div class="camera_wrap camera_caption_wrapper">
				<div>
					<div class="camera_caption fadeFromBottom">
						<div>
							<div>
								<div>
									<?php 
										$slider_header_text = get_field('slider_header_text');
										$slider_text = get_field('slider_text');
									 ?>
									<h1><?php echo $slider_header_text; ?></h1>
									<span><?php echo $slider_text; ?></span>		
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- end slider -->

			<div class="clearfix"></div>

			<?php // echo get_field('residences_description', 'options'); ?>
			<?php 
				$content = "";
				while ( have_posts() ) : the_post();
				$content = get_the_content();
				endwhile; 
				if(!empty($content)){
			?>
					<div class="description_wrapper">
						<span>
							<?php 
								echo $content;
							 ?>
						</span>
					</div>
			<?php
				}
			?>
		 </div>

		 <div class="site_content cards">
		 	<?php 
		 		$attributes = array(
					'post_type'             => 'residences',
					'post_status'           => 'publish',
					'orderby'               => 'menu_order'
					);

				$new_query = new WP_Query( $attributes );
				if ($new_query->have_posts()) :
					while ( $new_query->have_posts() ) : $new_query->the_post();
						$excerpt = get_field('excerpt');
						$thumbnail = get_field('thumbnail');
				?>
						<a href="<?php the_permalink(); ?>">
							<div class="element">
								<img src="<?php echo $thumbnail; ?>">
								<div class="clearfix"></div>
								<span><?php the_title(); ?></span>
								<div class="clearfix"></div>
								<p><?php echo $excerpt; ?></p>
								<div class="clearfix"></div>
								<span class="read_more">Read more...</span>
							</div>
						</a>
				<?php
					endwhile;
				endif;
		 	 ?>
		 </div>
	</div><!-- .content-area -->
<?php get_footer(); ?>