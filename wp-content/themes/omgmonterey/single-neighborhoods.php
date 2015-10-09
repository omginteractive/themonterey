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
			
			jQuery('#camera_wrap_3').camera({
				pagination: true,
				loader: 'none',
				playPause: false,
				fx: "simpleFade",
				time : 5000,
				transPeriod			: 1000,
				height: '600px'
			});

		});
	</script>

	<div id="residences_page" class="content-area post_single_content">
		 <div class="site_content_old">
		 	<!-- slider -->
			<?php 
				$images = get_field('images', get_the_ID());

				if(sizeof($images) > 1){
			?>
				<div class="camera_wrap camera_emboss" id="camera_wrap_3">
			<?php
				}
			else{
				?>
				<div class="camera_wrap camera_emboss one_slider" id="camera_wrap_3">
				<?php
			}

				if (!empty($images)) :
					foreach ($images as $key => $value) {
						$image = $value['image'];
				?>
					<div data-thumb="<?php echo $image; ?>" data-src="<?php echo $image; ?>" data-target="_blank">
						<!-- <div class="camera_caption fadeFromBottom">
							<h1><?php the_title(); ?></h1>
							<span>30 Park Avenue is the perfect location for your next Park Avenue Address.</span>
						</div> -->
					</div>
				<?php
					};
					if(sizeof($images) == 1){
					?>
							<div data-thumb="<?php echo $image; ?>" data-src="<?php echo $image; ?>" data-target="_blank">
								<!-- <div class="camera_caption fadeFromBottom">
									<h1><?php the_title(); ?></h1>
									<span>30 Park Avenue is the perfect location for your next Park Avenue Address.</span>
								</div> -->
							</div>
					<?php	
						}
					endif;

				 ?>
			</div><!-- #camera_wrap_3 -->
			<div class="camera_wrap camera_caption_wrapper">
				<div>
					<div class="camera_caption fadeFromBottom">
						<div>
							<div>
								<h1><?php the_title(); ?></h1>
								<span>30 Park Avenue is the perfect location for your next Park Avenue Address.</span>
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
							the_content();
						endwhile;
					 ?>
				</p>
			</div>
		 </div>
	</div><!-- .content-area -->
<?php get_footer(); ?>