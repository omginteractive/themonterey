<script src="http://ajax.microsoft.com/ajax/jquery.validate/1.5.5/jquery.validate.min.js" type="text/javascript"></script>

<script>
	jQuery(document).ready(function(){
		// menu activate
		var google_doc_submit_menu = jQuery('#adminmenuwrap #adminmenu li a[href="admin.php?page=gform_google_doc_submit"]');

		google_doc_submit_menu.addClass('current');
		google_doc_submit_menu.parent().addClass('current');
		google_doc_submit_menu.parent().parent().parent().addClass('wp-has-current-submenu');google_doc_submit_menu.parent().parent().parent().find('>a:first-child').addClass('wp-has-current-submenu');
		// end menu activate

		// form validator
		var validator = jQuery("#gf_google_doc_submit_edit_form").validate({
			errorLabelContainer: jQuery('#errorContainer'),
			errorClass: 'error',
			rules: {
				google_doc_url: "required"
			},
			messages: {
				google_doc_url: "<br>Please enter Google Doc URL<br>"
			}
		});
		// end form validator
	});
</script>

<?php 
	$form_id = $_GET['gform_id'];
	$form_title = '';
	$google_doc_url = '';

	if(!empty($_POST['action']) && $_POST['action'] == 'submit'){
		$google_doc_url = $_POST['google_doc_url'];

		$gf_submit_google_lists = get_option('gf_submit_google_lists');
	
		if(!empty($gf_submit_google_lists)){
			for ($i=0; $i < sizeof($gf_submit_google_lists); $i++) { 
				if($gf_submit_google_lists[$i]['gf_form_id'] == $form_id){

					$gf_submit_google_lists[$i]['google_doc_url'] = $google_doc_url;
				}				
			}
		}

		update_option( 'gf_submit_google_lists', $gf_submit_google_lists);
	}	

	$gf_submit_google_lists = get_option('gf_submit_google_lists');

	if(!empty($gf_submit_google_lists)){
		foreach ($gf_submit_google_lists as $key => $value) {
			if($value['gf_form_id'] == $form_id){
				$form_title = $value['gf_form_title'];
				$google_doc_url = $value['google_doc_url'];
			}
		}
	}
 ?>

<div class="wrap">
	<div class="title widefat">
		<h2>Edit</h2>
	</div>
	<div class="clearfix"></div>

	<form action="" method="POST" id="gf_google_doc_submit_edit_form">
		<input type="hidden" name="action" value="submit">
		<div>
			<div class="element">
				<label for="form_id">Form ID: </label>
				<input type="text" value="<?php echo $form_id; ?>" readonly>			
			</div>

			<div class="clearfix"></div>

			<div class="element">
				<label for="form_id">Form Title: </label>
				<input type="text" value="<?php echo $form_title; ?>" readonly>			
			</div>

			<div class="clearfix"></div>

			<div class="element">
				<label for="form_id">Google Doc URL: </label>
				<input name="google_doc_url" type="text" value="<?php echo $google_doc_url; ?>">	
			</div>
		</div>
		<div class="clearfix"></div>
		<input class="right button button-large button-primary" type="submit" tabindex="9002" value="Add">
	</form>
</div>