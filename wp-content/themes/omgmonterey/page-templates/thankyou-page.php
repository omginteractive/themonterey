<?php
/**
 * Template Name: Thank You Page
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

get_header('thankyou'); ?>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.3.1/jquery.maskedinput.js"></script>

	<script type="text/javascript">

		function set_select_color(){
			if(jQuery('#input_1_5').val() && jQuery('#input_1_5').val() != ""){
				jQuery('#input_1_5').css('color', '#000');
			}
			else{
				jQuery('#input_1_5').css('color', '#b3002b');	
			}

			if(jQuery('#input_1_8').val() && jQuery('#input_1_8').val() != ""){
				jQuery('#input_1_8').css('color', '#000');
			}
			else{
				jQuery('#input_1_8').css('color', '#b3002b');	
			}
		}

		jQuery(document).ready(function(){
			jQuery( ".date_available input" ).datepicker();
			jQuery('.date_available input').mask("99/99/9999");

			set_select_color();
			jQuery('#input_1_5 option:first-child').attr('disabled', 'disabled');
			jQuery('#input_1_8 option:first-child').attr('disabled', 'disabled');

			jQuery('#input_1_5').live('change', function(){
				set_select_color();
			});

			jQuery('#input_1_8').live('change', function(){
				set_select_color();
			});

			jQuery(document).bind('gform_post_render', function(){
				var form_content = jQuery(this).contents().find('#gform_wrapper_1');
				form_content.find('.gfield_error').removeClass('gfield_error');

				form_content.find('.validation_message').each(function(){
					jQuery(this).parent().find('.ginput_container').find('input').css('border', '1px solid #b3002b');
				});
				set_select_color();
			});

			var layout = jQuery('#layout').val();
			if(layout != -1){
				jQuery('.layout select').val(layout);
			}
			
			// jQuery('#gform_ajax_frame_1').load( function(){
			// 	var form_content = jQuery(this).contents().find('#gform_wrapper_1');
			// 	form_content.find('.gfield_error').removeClass('gfield_error');

			// 	form_content.find('.validation_message').each(function(){
			// 		jQuery(this).parent().find('.ginput_container').find('input').css('border', '1px solid red');
			// 	});
			// 	set_select_color();
			// });
		});
	</script>

	<?php 
		gf_google_doc_submit(1);
		$layout = !empty($_GET['layout']) ? $_GET['layout'] : "-1";
	 ?>

	 <input type="hidden" value="<?php echo $layout ?>" id="layout">

	<div id="contact_page" class="content-area">
		<?php 
			$background_image = get_field('background_image', get_the_ID());

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
			 		<div id="contact_description"><?php the_content(); ?></div>
			 <?php
		 		endwhile;
		 	 ?>

		 	 
		 </div>
         <META http-equiv="refresh" content="5;URL=http://montereyatpark.com/contact/"> 
	</div><!-- .content-area -->
<?php get_footer(); ?>