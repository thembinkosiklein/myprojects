<?php

/**************************************************************************************
 *	AJAX CALLS FOR THE EXPLORE PAGE
 * 	- All ajax calls for explore page
 **************************************************************************************/

$json['success'] = false;

switch ($viewPage) {

	/**********************************************************************************
	 * Location listing page
	 **********************************************************************************/

	case 'explore':

		/* Check if the requested location exists in database, and
		 * put all related locations from the database, 
		 * otherwise use Foursquare API and do database inserts */

		$json = $_REQUEST;

		if ($auth->isAuth()) {
			$user 		= $auth->getUser();
			$locations 	= $get->location(array('term'=>trim($json['q']), 'user_id'=>$user['id']));
		} else {
			$locations 	= $get->location(array('term'=>trim($json['q'])));
		}
		$object 	= file_get_contents('pages/objects/explore-location-list-item.php');
		$venues 	= '';
		$coords 	= array();

		if (is_array($locations) && !empty($locations)) {
			foreach ($locations as $key => $venue) {
				// out($venue);
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
		} else {

			include('inc/classes/thirdparty-api/foursquare.class.php');
			$foursquare = new Foursquare(FOURSQUARE_API_KEY, FOURSQUARE_API_SECRET);
			$result 	= @$foursquare->search_location(trim($json['q']));

			if ($result && is_array($result)) {
				foreach ($result as $key => $venue) {
					$data['term']		= $json['q'];
					$data['id']		 	= $venue['id'];
					$data['name'] 	 	= $venue['name'];
					$data['lat'] 	 	= $venue['location']['lat'];
					$data['lng'] 	 	= $venue['location']['lng'];
					$data['city'] 	 	= $venue['location']['city'];
					$data['state'] 	 	= $venue['location']['state'];
					$data['country'] 	= $venue['location']['country'];
					$data['address'] 	= $venue['location']['address'];
					$data['enc_name']	= strtolower(urlencode($data['name']));
					$data['addr']  	 	= trim($data['address'].' '.$data['city'].' '.$data['state']);
					$data['btn-txt']	= (!empty($venue['chk'])) ? 'Remove from List' : 'Save to List';
					$data['categories']	= '';
					$coords[]			= array('lat'=>$data['lat'],'lng'=>$data['lng']);
					$first 				= true;

					// Get location categories
					if (is_array($venue['categories']) && !empty($venue['categories'])) {
						foreach ($venue['categories'] as $k => $cat) {
							$data['categories'] .= ($first) ? $cat['shortName'] : ', '.$cat['shortName'];
							$first 				 = false;
						}
					}
					$venues .= $template->string_replace($data, $object);
					// Insert location into the database
					$insert->location($data);
				}
			}
		}
		$json['venues'] = $venues;
		$json['coords'] = $coords;
		$json['success']= true;
		
		break;


	/**********************************************************************************
	 * Image listing page
	 **********************************************************************************/

	case 'photo':

		/* Check if the requested image info exists in database, and
		 * get all images from the database, 
		 * otherwise use Flickr API and do database inserts */

		include('inc/classes/thirdparty-api/flickr.class.php');
		$flickr 	= new Flickr(FLICKR_API_KEY);
		$uri 		= explode('/', $_REQUEST['uri']);
		$gps 		= explode(',', $uri[2]);
		$images 	= $get->image(array('location_name'=>$uri[1]));
		$location 	= $get->location(array('name'=>$uri[1]));
		$object 	= file_get_contents('pages/objects/explore-image-list-item.php');
		$photos 	= '';

		if (is_array($images) && !empty($images)) {
			foreach ($images as $key => $photo) {
				$photo['bpath'] = BASE_PATH;
				$data['id']		= $photo['image_id'];
				$data['title']	= $photo['image_title'];
				$data['owner']	= $photo['image_owner'];
				$data['server']	= $photo['image_server'];
				$data['secret']	= $photo['image_secret'];
				$data['farm']	= $photo['image_farm'];
				$data['img'] 	= $flickr->img_url($data);
				$photos 	   .= $template->string_replace($data, $object);
			}
		} else {

			$result = @$flickr->search_photos(array('text'=>$uri[1],'lat'=>$gps[0], 'lon'=>$gps[1],'content_type'=>1));

			if (isset($result['photos']['photo'])) {
				foreach ($result['photos']['photo'] as $key => $photo) {
					$photo['location']	= $location['location_name'];
					$photo['bpath'] 	= BASE_PATH;
					$photo['img'] 		= $flickr->img_url($photo);
					$photos 	   	   .= $template->string_replace($photo, $object);
					// Insert image into the database
					$insert->photo($photo);
				}
			}
		}
		$json['location'] 	= $location;
		$json['photos'] 	= $photos;
		$json['success']	= true;
		break;

}

echo json_encode($json);
die();

?>