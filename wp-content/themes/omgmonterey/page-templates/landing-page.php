<?php
/**
 * Template Name: Landing Page
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

get_header(); ?>
	<input type="hidden" value="<?php echo $layout ?>" id="layout">

	<div id="contact_page" class="content-area landing_site_content">
		<?php 
			$featured_image_id = get_post_thumbnail_id(get_the_ID());
			$featured_image_meta = wp_get_attachment_image_src($featured_image_id, '32' );
			$featured_img_url = $featured_image_meta[0];
			$background_text = get_field('background_text');
		 ?>
		 <div id="background_wrapper" style="background: url(<?php echo $featured_img_url; ?>)">
		 	<img src="<?php echo $background_text; ?>">
		 </div>

		 <div class="clearfix"></div>

		 <div class="site_content">
		 	<?php 
		 		while ( have_posts() ) : the_post();
			 ?>
			 		<div id="description"><?php the_content(); ?></div>
			 <?php
		 		endwhile;
		 	 ?>
		 </div>
	</div><!-- .content-area -->
<?php get_footer(); ?>