<?php 
	if(!empty($_POST['action']) && $_POST['action'] == 'delete'){
		$form_id = $_POST['form_id'];

		$gf_submit_google_lists = get_option('gf_submit_google_lists');
		$list_id = 0;
	
		if(!empty($gf_submit_google_lists)){
			for ($i=0; $i < sizeof($gf_submit_google_lists); $i++) { 
				if($gf_submit_google_lists[$i]['gf_form_id'] == $form_id){

					$list_id = $i;
				}				
			}

			array_splice($gf_submit_google_lists, $list_id, 1);
			update_option( 'gf_submit_google_lists', $gf_submit_google_lists);
		}
	}
 ?>
 <div class="wrap">
 	<div class="title widefat">
 		<h2>Registered
 			<a class="add-new-h2" href="<?php echo admin_url( 'admin.php?page=gf-google-doc-add-new-page', 'http' ); ?>">Add New</a>
 		</h2>
 	</div>
 	<div class="clearfix"></div>

 	<table class="gf_google_doc_submit_admin_table widefat fixed" cellspacing="0">
 		<thead>
 			<tr>
 				<th scope="col" class="manage-column column-title">Form Id</th>
 				<th scope="col" class="manage-column column-title">Form Title</th>
 				<th scope="col" class="manage-column column-title">Google Doc URL</th>
 				<th scope="col" class="manage-column column-title">Delete</th>
 			</tr>
 		</thead>
 		<tfoot>
 			<tr>
 				<th scope="col" class="manage-column">Form Id</th>
 				<th scope="col" class="manage-column">Form Title</th>
 				<th scope="col" class="manage-column">Google Doc URL</th>
 				<th scope="col" class="manage-column">Delete</th>
 			</tr>
 		</tfoot>

 		<tbody class="list:user user-list">
 			<?php 
 			$gf_submit_google_lists = get_option('gf_submit_google_lists');
 			if(!empty($gf_submit_google_lists)){
 				foreach ($gf_submit_google_lists as $key => $value) {
 					?>
 					<tr class='author-self' valign="top">
 						<td>
 							<?php echo $value['gf_form_id']; ?>
 						</td>
 						<td>
 							<?php 
 								$edit_url = admin_url( 'admin.php?page=gf-google-doc-edit-page&gform_id='.$value['gf_form_id'], 'http' );
 							 ?>
 							<a href="<?php echo $edit_url ; ?>">
 								<?php echo $value['gf_form_title']; ?>
 							</a>
 						</td>
 						<td>
 							<?php echo $value['google_doc_url']; ?>
 						</td>
 						<td>
 							<form class="gf_google_doc_submit_delete" action="" method="POST">
 								<input type="hidden" name="action" value="delete">
 								<input type="hidden" name="form_id" value="<?php echo $value['gf_form_id']; ?>">
								<input type="submit" value="X">
 							</form>
 						</td>
 					</tr>
 					<?php
 				}
 			}
 			?>
 		</tbody>
 	</table>
 </div>