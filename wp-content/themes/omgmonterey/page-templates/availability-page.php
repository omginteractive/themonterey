<?php
/**
 * Template Name: Availability Page
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
ini_set('error_reporting', E_ALL);
error_reporting(E_ALL);

get_header(); ?>
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri();?>/css/font-awesome-4.2.0/css/font-awesome.css" />

	<style type="text/css">
		.fa{
			display: none;
		}

		.SORT_ASC .fa-sort-asc{
			display: inline-block;
			margin-left: 10px;
		}

		.SORT_DESC .fa-sort-desc{
			display: inline-block;
			margin-left: 10px;
		}

		table th{
			cursor: pointer;
		}
	</style>

	<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery('table th').click(function(){
				var clicked_item = jQuery(this).attr('id');

				var cur_sort_item = jQuery('#sort_item').val();
				var cur_sort_direction = jQuery('#sort_direction').val();

				var sort_direction = "SORT_ASC";

				if(clicked_item == cur_sort_item){
					if(cur_sort_direction == "SORT_ASC"){
						sort_direction = "SORT_DESC";
					}
				}

				jQuery('#sort_item').val(clicked_item);
				jQuery('#sort_direction').val(sort_direction);
				jQuery('form').submit();
			});
			
			jQuery('#availability_page #filter_wrapper ul li a').click(function(e){
				e.preventDefault();
			});
				
			jQuery('#availability_page #filter_wrapper ul li').click(function(){
				if(jQuery(this).attr('filter') != '-1'){
					var filter = jQuery(this).attr('filter');
					
					if(filter == 'all'){
						jQuery('#availability_page #filter_wrapper ul li').removeClass('active');
						jQuery('#availability_page #filter_wrapper ul li').addClass('active');
					}else{
						jQuery('#availability_page #filter_wrapper ul li').removeClass('active');
						jQuery('#availability_page #filter_wrapper ul li:first-of-type').addClass('active');
						if(!jQuery(this).hasClass('active')){
							jQuery(this).addClass('active');
						}
					}
					
					jQuery('#availability_page table tbody tr').each(function(){
							if(filter == 'all'){
								// jQuery(this).find('.bedrooms').html();
								jQuery(this).removeClass('filtered');
							}
							else{
								if(jQuery(this).find('.bedrooms').html() == filter){
									jQuery(this).removeClass('filtered');
								}else{
									if(!jQuery(this).hasClass('filtered')){
										jQuery(this).addClass('filtered');
									}
								}
							}
					});	
						
				}else{
					if (jQuery(this).hasClass('active'))
						jQuery(this).addClass('active');
				}
			});
		});
	</script>
	<?php
		$sort_item = "beds";
		$sort_direction = "SORT_ASC";

		if(!empty($_POST['sort_item'])){
			$sort_item = $_POST['sort_item'];
			$sort_direction = $_POST['sort_direction'];
		}
	?>
	<form method="POST">
		<input type="hidden" name="sort_item" id="sort_item" value="<?php echo $sort_item; ?>">
		<input type="hidden" name="sort_direction" id="sort_direction" value="<?php echo $sort_direction; ?>">
	</form>
	<?php
		function validateDate($date)
		{
		  $d = DateTime::createFromFormat('Y-m-d', $date);
		  return $d && $d->format('Y-m-d') == $date;
		}

		function load_data_from_xml() {

		//$coupons_data = file_get_contents( 'http://www.urbanedgeny.com/feeds/3a45aff6b3.xml?1429273904' );
		$coupons_data = file_get_contents(ABSPATH.'/feed/30PUnitAvailability.xml');

		libxml_use_internal_errors( true );
		$xml = simplexml_load_string( $coupons_data );

		if ( $xml === false ) {
			$errors = "";
			foreach ( libxml_get_errors() as $error ) {
				$errors .= $error->message . "\n";
			}

			throw new Exception( $errors );
		}
// echo "<pre>";
// print_r($xml->Property->FloorPlan);
// echo "</pre>";
		foreach($xml->Property->FloorPlan as $k => $v){
			// // echo "<pre>";
			// // print_r($v);
			// // echo "</pre>";
			// if($k == 'FloorPlan'){
				$floorplan = (array)$v;

				$unit = $floorplan['@attributes']['id'];
				$bedrooms = '';
				$bathrooms = '';
				foreach($floorplan['Room'] as $room){
					$room = (array) $room;
					if($room['@attributes']['type'] == 'Bedroom')
						$bedrooms = $room['Count'];
					else if ($room['@attributes']['type'] == 'Bathroom')
						$bathrooms = $room['Count'];
				}
				$date_available = $floorplan['availableOn'];
				$floorplan['MarketRent'] = (array) $floorplan['MarketRent'];
				$price = $floorplan['MarketRent']['@attributes']['min'];
				$floorplan['File'] = (array)$floorplan['File'];

				if($floorplan['File']['@attributes']['id'])
					$floorplan_url = site_url()."/feed/floorplans/".$floorplan['File']['@attributes']['id'];
				else
					$floorplan_url = '';

				$data[] = array(
					'Unit' => $unit,
					'Bedrooms' => $bedrooms,
					'Bathrooms' => $bathrooms,
					'Price' => number_format($price),
					'date_available' => $date_available,
					'floorplan_url' => $floorplan_url
				);
			// }
		}
		return $data;
			/*
		$xml = (array) $xml;
		if($xml['FloorPlan']){

			foreach($xml['FloorPlan'] as $floorplan){
				$floorplan = (array) $floorplan;
				$unit = $floorplan['@attributes']['id'];
				$bedrooms = '';
				$bathrooms = '';
				foreach($floorplan['Room'] as $room){
					$room = (array) $room;
					if($room['@attributes']['type'] == 'Bedroom')
						$bedrooms = $room['Count'];
					else if ($room['@attributes']['type'] == 'Bathroom')
						$bathrooms = $room['Count'];
				}
				$date_available = $floorplan['availableOn'];
				$floorplan['MarketRent'] = (array) $floorplan['MarketRent'];
				$price = $floorplan['MarketRent']['@attributes']['min'];
				$floorplan['File'] = (array)$floorplan['File'];

				if($floorplan['File']['@attributes']['id'])
					$floorplan_url = site_url()."/feed/floorplans/".$floorplan['File']['@attributes']['id'];
				else
					$floorplan_url = '';
			
				$data[] = array(
					'Unit' => $unit,
					'Bedrooms' => $bedrooms, 
					'Bathrooms' => $bathrooms,
					'Price' => number_format($price),
					'date_available' => $date_available,
					'floorplan_url' => $floorplan_url
				);
			}

			return $data;
		} else {
			return [];		
		}
			*/
	}
	/*
		foreach ($xml["property"] as $item) {
			$item = (array) $item;

				$brewster[] = $item;
		}
		$data = array();

		foreach ($brewster as $floorplan) {

			if($floorplan['@attributes']['url'] == "http://www.montereyatpark.com"){
				// $unit = (array) $floorplan['@attributes']['id'];

				$unit = (array) $floorplan['location']->apartment;			
				$bedrooms = (array) $floorplan['details']->bedrooms;			
				$bathrooms = (array) $floorplan['details']->bathrooms;
				$price = (array) $floorplan['details']->price;
				$date_available = (array) $floorplan['details']->availableOn;
				$description = (array) $floorplan['details']->description;
				
				$floorplan_url = "";
				
				// if(!empty($floorplan['media']->floorplan->attributes()['url'][0])){
				// 	$floorplan_url = $floorplan['media']->floorplan->attributes()['url'][0];
				// }
				if (!empty($floorplan['media']->floorplan)) {
					$floorplan_url = $floorplan['media']->floorplan->attributes();
					$floorplan_url = $floorplan_url['url'][0];
				}

				$data[] = array(
					'Unit' => $unit[0],
					'Bedrooms' => $bedrooms[0], 
					'Bathrooms' => $bathrooms[0],
					'Price'=> number_format($price[0]),
					'date_available'=> $date_available[0],
					'Description'=> $description[0],
					'floorplan_url'=> $floorplan_url
					);
			}
		}

		return $data;
	}*/

	$data = load_data_from_xml();

	$Unit = array();
	$Bedrooms = array();
	$Bathrooms = array();
	$Price = array();
	$date_available = array();
	$Description = array();
	$floorplan_url = array();

	$is_florrplan_display = false;
	foreach ($data as $key => $value) {
		$Unit[$key] = $value['Unit'];
		$Bedrooms[$key] = $value['Bedrooms'];
		$Bathrooms[$key] = $value['Bathrooms'];
		$Price[$key] = $value['Price'];
		$date_available[$key] = $value['date_available'];
		//$Description[$key] = $value['Description'];
		$floorplan_url[$key] = $value['floorplan_url'];
		if(!empty($floorplan_url[$key])){
			$is_florrplan_display = true;
		}
	}

	switch ($sort_item) {
		case 'unit':
		if($sort_direction == "SORT_ASC"){
			array_multisort($FloorplanName, SORT_ASC, $data);
		}
		else{
			array_multisort($FloorplanName, SORT_DESC, $data);
		}
		break;
		case 'beds':
		if($sort_direction == "SORT_ASC"){
			array_multisort($Bedrooms, SORT_ASC, $data);
		}
		else{
			array_multisort($Bedrooms, SORT_DESC, $data);
		}
		break;
		case 'baths':
		if($sort_direction == "SORT_ASC"){
			array_multisort($Bathrooms, SORT_ASC, $data);
		}
		else{
			array_multisort($Bathrooms, SORT_DESC, $data);
		}
		break;
		case 'rent':
		if($sort_direction == "SORT_ASC"){
			array_multisort($Price, SORT_ASC, $data);
		}
		else{
			array_multisort($Price, SORT_DESC, $data);
		}
		break;
		case 'date_available':
		if($sort_direction == "SORT_ASC"){
			array_multisort($date_available, SORT_ASC, $data);
		}
		else{
			array_multisort($date_available, SORT_DESC, $data);
		}
		break;
	}
	 ?>

	<div id="availability_page" class="content-area">
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
		 	<div class="top_text">
		 		<?php 
		 		$top_text = get_field("top_text");
		 		?>
		 		<p><?php echo $top_text; ?></p>
		 	</div>
		 	<div class="clearfix"></div>
		 	
		 	<div id="filter_wrapper">
		 		<ul>
		 			<li class="active" filter="-1"><a>AVAILABILITY</a><span>|</span></li>
		 			<li class="active" filter="Studio"><a href="#">STUDIO</a><span>|</span></li>
		 			<li class="active" filter="1 BR"><a href="#">1 BEDROOM</a><span>|</span></li>
		 			<li class="active" filter="2 BR"><a href="#">2 BEDROOM</a><span>|</span></li>
		 			<li class="active" filter="all"><a href="#">ALL</a><span>|</span></li>
		 		</ul>
		 	</div>

		 	<div class="clearfix"></div>

			<?php 
				$contact_image = get_template_directory_uri()."/images/availability-contact-button.png";
			 ?>

		 	<table>
		 		<thead>
		 			<tr>
		 				<th id="unit" <?php if($sort_item == "unit"){echo 'class = '.$sort_direction;} ?>>Unit<i class="fa fa-sort-asc"></i><i class="fa fa-sort-desc"></i>
		 				<th id="beds" <?php if($sort_item == "beds"){echo 'class = '.$sort_direction;} ?>>Bedrooms<i class="fa fa-sort-asc"></i><i class="fa fa-sort-desc"></i></th>
		 				<th id="baths" <?php if($sort_item == "baths"){echo 'class = '.$sort_direction;} ?>>Bathrooms<i class="fa fa-sort-asc"></i><i class="fa fa-sort-desc"></i></th>
		 				<th id="date_available" <?php if($sort_item == "date_available"){echo 'class = '.$sort_direction;} ?>>Date Available<i class="fa fa-sort-asc"></i><i class="fa fa-sort-desc"></i></th>
		 				<th id="rent" <?php if($sort_item == "rent"){echo 'class = '.$sort_direction;} ?>>Price<i class="fa fa-sort-asc"></i><i class="fa fa-sort-desc"></i></th>
		 				<?php 
			 				if($is_florrplan_display){
		 				?>
		 						<th>Floorplan</th>
		 				<?php
				 			}
			 			?>
		 				<th>Contact</th>
		 			</tr>
		 		</thead>

		 		<tbody>
		 			<?php 
		 				foreach ($data as $key => $value) {
		 					if($value['Bedrooms'] == 0){
		 						$value['Bedrooms'] = "Studio";
		 					}
		 					else{
		 						$value['Bedrooms'] = $value['Bedrooms']." BR";
		 					}

		 					$date = strtotime($value['date_available']);
							
							if((bool)$date) {
			 					if (strtotime('now') > $date)
			 					{
			 						$value['date_available'] = "Immediately";
			 					}
			 					else{
			 						$value['date_available'] = date('F j', $date);
			 					}
							}
							if($value['date_available'] == '' || !$value['date_available'])
								$value['date_available'] = "Immediately";

		 					$value['Bathrooms'] = $value['Bathrooms']." BA";
		 			?>
			 			<tr>
			 				<td><?php echo $value['Unit']; ?></td>
			 				<td class="bedrooms"><?php echo $value['Bedrooms']; ?></td>
			 				<td><?php echo $value['Bathrooms']; ?></td>
			 				<td><?php echo $value['date_available']; ?></td>
			 				<td>$<?php echo $value['Price']; ?></td>
			 				<?php 
			 					if($is_florrplan_display){
			 				?>
			 						<td>
					 					<?php 
					 						if(!empty($value['floorplan_url'])){
					 					 ?>
							 					<a href="<?php echo $value['floorplan_url']; ?>" class="download_button" target="_blank">Download</a>
					 					<?php 
					 						}
					 					 ?>
					 				</td>
			 				<?php
			 					}
			 				 ?>
			 				<td>
			 					<?php 
			 						$contact_url = esc_url(get_permalink(get_page_by_title('contact')));
			 						$contact_url = $contact_url."?layout=".$value['Bedrooms'];
			 					 ?>
			 					<a class="contact_button" href="<?php echo $contact_url; ?>"><img src="<?php echo $contact_image; ?>"></a>
			 				</td>
			 			</tr>
		 			<?php
		 				}
		 			 ?>
		 		</tbody>
		 	</table>
		 </div>
	</div><!-- .content-area -->
<?php get_footer(); ?>