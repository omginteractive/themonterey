<?php
	/*
	Plugin Name: Gravity-Forms-Google-Doc-Submit
	Description: This is a plugin to submit gravity forms infomation to google doc
	version: 1.0
	Author: author
	License: GPL2
	*/

	//include style sheet
	add_action( 'admin_head', 'admin_css' );

	function admin_css(){
		wp_enqueue_style( 'google-doc-submit-style-sheet', plugins_url().'/Gravity-Forms-Google-Doc-Submit/library/css/style.css', array(), '1.0' );
	}

	//include simple html dom
	include_once 'library/simplehtmldom/simple_html_dom.php';

	// add a submenu to gravity forms menu
	add_filter("gform_addon_navigation", "add_menu_item");
	function add_menu_item($menu_items){
	    $menu_items[] = array("name" => "gform_google_doc_submit", "label" => "Google Doc Submit", "callback" => "gform_google_doc_submit", "permission" => "edit_posts");
	    return $menu_items;
	}

	function gform_google_doc_submit(){
		include 'main-page.php';
	}

	// add new page with out menu
	add_action('admin_menu', 'gf_google_doc_submit_add_submenus');
	
	function gf_google_doc_submit_add_submenus() {
		add_submenu_page( '_doesnt_exist', 'gf_google_doc_add_new_page', 'GF Google Doc Add New', 'manage_options', 'gf-google-doc-add-new-page', 'gf_google_doc_add_new_page' ); 
	}

	function gf_google_doc_add_new_page(){
		include "add-new-page.php";
	}

	add_action('admin_menu', 'gf_google_doc_submit_edit_submenu');
	
	function gf_google_doc_submit_edit_submenu() {
		add_submenu_page( '_doesnt_exist', 'gf_google_doc_edit_page', 'GF Google Doc Edit', 'manage_options', 'gf-google-doc-edit-page', 'gf_google_doc_edit_page' ); 
	}

	function gf_google_doc_edit_page(){
		include "edit-page.php";
	}

	// custom functions to call at the template file
	function gf_google_doc_submit($form_id){
		$google_doc_url = '';
		$form_title = '';

		$gf_submit_google_lists = get_option('gf_submit_google_lists');
		if(!empty($gf_submit_google_lists)){
			foreach ($gf_submit_google_lists as $key => $value) {
				if($value['gf_form_id'] == $form_id){
					$form_title = $value['gf_form_title'];
					$google_doc_url = $value['google_doc_url'];
				}
			}
		}

		$curl_url = $google_doc_url;
		$google_doc_url = str_replace("/viewform", "/formResponse", $curl_url);;
		// Get cURL resource
		$curl = curl_init();
		curl_setopt( $curl, CURLOPT_URL, $curl_url );
		curl_setopt( $curl, CURLOPT_VERBOSE , 1 );
		curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER , FALSE );
		curl_setopt( $curl, CURLOPT_SSL_VERIFYHOST , FALSE );
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER , true );
		curl_setopt( $curl, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded', 'Connection: keep-alive') );
		// curl_setopt( $curl, CURLOPT_POST, 1 );
		// curl_setopt( $curl, CURLOPT_POSTFIELDS, $data );

		$resp = curl_exec($curl);
		$response = str_get_html($resp);
		$count = 0;
		$ids = array();

		if(!empty($response)){
			foreach ($response->find('.ss-form-container .ss-form form div[role="listitem"] .ss-item .ss-form-entry input') as $key => $value) {
				$ids[$count] = $value->name;
				$count++;
			}
		}

		$data_set = "";
		for ($i=0; $i < $count; $i++) { 
			if($i != $count -1){
				$data_set .= "'".$ids[$i]."':requests[".$i."],";
			}
			else{
				$data_set .= "'".$ids[$i]."':requests[".$i."]";
			}
		}

		$script_write = "<script>
	jQuery(document).ready(function(){
		gformInitSpinner(".$form_id.", 'http://google.com');

		var z=_uGC(document.cookie,'__utmz=',';');
		var source=_uGC(z,'utmcsr=','|');
		var medium=_uGC(z,'utmcmd=','|');
		var term=_uGC(z,'utmctr=','|');
		var content=_uGC(z,'utmcct=','|');
		var campaign=_uGC(z,'utmccn=','|');
		var gclid=_uGC(z,'utmgclid=','|');
		if(gclid!=\"-\"){source='google';medium='cpc';}
		var csegment=_uGC(document.cookie,'__utmv=',';');
		if(csegment!='-')
			{var csegmentex=/[1-9]*?.(.*)/;csegment=csegment.match(csegmentex);csegment=csegment[1];}
		else{csegment='(not set)';}
		var a=_uGC(document.cookie,'__utma=',';');
		var aParts=a.split(\".\");
		var nVisits=aParts[5];

		var ga_array = new Array();
		ga_array[0] = source;
		ga_array[1] = medium;
		ga_array[2] = term;
		ga_array[3] = content;
		ga_array[4] = campaign;
		ga_array[5] = csegment;
		ga_array[6] = nVisits;

		jQuery('.gform_body > .gform_fields > .gform_hidden').each(function(index){
			jQuery(this).find('input').val(ga_array[index]);
		});

		jQuery('#gform_ajax_frame_".$form_id."').load( function(){			
			var contents = jQuery(this).contents().find('*').html();
	        var is_postback = contents.indexOf('GF_AJAX_POSTBACK') >= 0;
	        if(!is_postback){return;}
	        var form_content = jQuery(this).contents().find('#gform_wrapper_".$form_id."');
	        var is_redirect = contents.indexOf('gformRedirect(){') >= 0;
	        var is_form = !(form_content.length <= 0 || is_redirect);

	        var google_doc_url = '".$google_doc_url."';

	        if(is_form){
        	}
        	else if(!is_redirect){ //when submit
    			var requests = new Array();
				var field_count = 0;

				jQuery('form .gform_fields > li .ginput_container input, form .gform_fields > li .ginput_container textarea, form .gform_fields > li .ginput_container select').each(function(index){
					requests[index] = jQuery(this).val();
					field_count++;
	    		});

				for (var i = 0; i < 7; i++) {
	    			requests[field_count + i] = ga_array[i];
	    		};

	    		jQuery.ajax({
	    			type: 'POST',
	    			async: false,
	    			url: '".$google_doc_url."',
	    			data: {
	    				".$data_set."
	    			}, 
	    			dataType: 'xml',
		           statusCode: {
	                   
	               }
	    		});
        	}
        	else{
        		var requests = new Array();
				var field_count = 0;

				jQuery('form .gform_fields > li .ginput_container input, form .gform_fields > li .ginput_container textarea, form .gform_fields > li .ginput_container select').each(function(index){
					requests[index] = jQuery(this).val();
					field_count++;
	    		});

	    		for (var i = 0; i < 7; i++) {
	    			requests[field_count + i] = ga_array[i];
	    		};

	    		jQuery.ajax({
	    			type: 'POST',
	    			async: false,
	    			url: '".$google_doc_url."',
	    			data: {
	    				".$data_set."
	    			}, 
	    			dataType: 'xml',
		           statusCode: {
	                   
	               }
	    		});
        	}
		});
	});
</script>";

		echo $script_write;

		curl_close( $curl );
	}
	// end custom functions to call at the template file
?>