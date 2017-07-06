<?php 

/**************************************************************************************
 *	AJAX CALLS FOR THE ACCOUNT PAGE
 * 	- All ajax calls for account page
 **************************************************************************************/

$json['success'] = false;

/* Add / Remove Location to/from User's custom list */
if (isset($_POST['custom_list'])) {
	if (isset($_POST['action'])) {
		switch ($_POST['action']) {

			// Add location to user's custom list
			case 'add':
				$json = $insert->user_location($_POST);
				break;

			// Remove location from user's custom list
			case 'remove':
				$json = $delete->user_location($_POST);
				break;
		}
	}
}

/* Get User's custom list from the database
 * Use html object to build html of the page */
if (isset($_REQUEST['get_custom_list']) && $auth->isAuth()) {
	$user 		= $auth->getUser();
	$locations 	= $get->location(array('user_id'=>$user['id']));
	$object 	= file_get_contents('pages/objects/explore-location-list-item.php');
	$venues 	= '';
	$coords 	= array();

	if (is_array($locations) && !empty($locations)) {
		foreach ($locations as $key => $venue) {
			$data['id']		 	= $venue['location_id'];
			$data['name'] 	 	= $venue['location_name'];
			$data['lat'] 	 	= $venue['lat'];
			$data['lng'] 	 	= $venue['lng'];
			$data['city'] 	 	= $venue['location_city'];
			$data['state'] 	 	= $venue['location_state'];
			$data['country'] 	= $venue['location_country'];
			$data['address'] 	= $venue['location_address'];
			$data['enc_name']	= strtolower(urlencode($data['name']));
			$data['addr']  	 	= trim($data['address'].' '.$data['city'].' '.$data['state']);
			$data['categories']	= $venue['categories'];
			$data['favourite']	= (!empty($venue['chk'])) ? 'is-favourite' : '';
			$data['btn-txt']	= (!empty($venue['chk'])) ? 'Remove from List' : 'Save to List';
			$coords[]			= array('lat'=>$data['lat'],'lng'=>$data['lng']);
			$venues .= $template->string_replace($data, $object);
		}
	}
	$json['venues'] = $venues;
	$json['coords'] = $coords;
	$json['success']= true;
}

echo json_encode($json);
die();


?>