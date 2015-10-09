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
		var validator = jQuery("#gf_google_doc_submit_add_form").validate({
			errorLabelContainer: jQuery('#errorContainer'),
			errorClass: 'error',
			rules: {
				gravity_form: "required",
				google_doc_url: "required"
			},
			messages: {
				gravity_form: "<br>Please Select Gravity Form<br>",
				google_doc_url: "<br>Please enter Google Doc URL<br>"
			}
		});
		// end form validator
	});
</script>

<?php 
//delete_option('gf_submit_google_lists');
// $gf_submit_google_lists = get_option('gf_submit_google_lists');
// print_r($gf_submit_google_lists);

$gf_item = array();
if(!empty($_POST['action']) && $_POST['action'] == 'submit'){
	$gravity_form = $_POST['gravity_form'];
	$google_doc_url = $_POST['google_doc_url'];

	$splited_gf_form_info = explode('&&', $gravity_form);
	$gf_item['gf_form_title'] = $splited_gf_form_info[0];
	$gf_item['gf_form_id'] = $splited_gf_form_info[1];
	$gf_item['google_doc_url'] = $google_doc_url;

	$gf_submit_google_lists = get_option('gf_submit_google_lists');

	if(!empty($gf_submit_google_lists)){
		array_push($gf_submit_google_lists, $gf_item);
		update_option( 'gf_submit_google_lists', $gf_submit_google_lists);
	}
	else{
		$gf_submit_google_lists[0]['gf_form_title'] = $gf_item['gf_form_title'];
		$gf_submit_google_lists[0]['gf_form_id'] = $gf_item['gf_form_id'];
		$gf_submit_google_lists[0]['google_doc_url'] = $gf_item['google_doc_url'];
		update_option('gf_submit_google_lists', $gf_submit_google_lists);
	}
}
?>

<div class="wrap">
	<div class="title widefat">
		<h2>Add New</h2>
	</div>
	<div class="clearfix"></div>
	<div>
		<form id="gf_google_doc_submit_add_form" action="" method="POST">
			<input type="hidden" name="action" value="submit">

			<div class="item">
				<label for="gravity_form">Gravity Forms:</label>
				<?php 
				$select = '<select name="gravity_form" id="gravity_form"><option value=""></option>';
				$forms = RGFormsModel::get_forms( null, 'title' );
				if(!empty($forms)){
					foreach( $forms as $form ):
						$gf_submit_google_lists = get_option('gf_submit_google_lists');
						$is_disable = false;

						if(!empty($gf_submit_google_lists)){
							foreach ($gf_submit_google_lists as $key => $value) {
								if($value['gf_form_id'] == $form->id){
									$is_disable = true;
								}
							}
						}

						if($is_disable){
							$select .= '<option disabled value="'.$form->title.'&&'.$form->id.'" id="' . $form->id . '">' . $form->title . '</option>';
						}
						else{
							$select .= '<option value="'.$form->title.'&&'.$form->id.'" id="' . $form->id . '">' . $form->title . '</option>';
						}
						
					endforeach;
				}
				$select .= '</select>';

				echo "$select";

				?>				
			</div>
			<div class="clearfix"></div>
			<div class="item">
				<label for="google_doc_url">Google Doc URL:</label>
				<input type="text" name="google_doc_url" id="google_doc_url">
			</div>

			<div class="clearfix"></div>
			<input class="right button button-large button-primary" type="submit" tabindex="9002" value="Add">
		</form>
	</div>
</div>