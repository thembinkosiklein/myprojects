<?php 

/* Explore page function */
function explore() {
	/* Make sure that this page is not accessible
	 * if the search query is not defined */
	if (!isset($_GET['q'])) {
		js_redirect('home');
	}
}

/* Explore photo page function */
function photo() {
	/* Make sure that this page is not accessible
	 * if the GET uri variable is not defined */
	if (!isset($_GET['uri'])) {
		js_redirect('home');
	}

	// Explode the uri to get image details (id, name and coordinates)
	$uri 			= explode('/', $_GET['uri']);
	$data['id'] 	= $uri[0];
	$data['name'] 	= urlencode($uri[1]);
	$data['coords'] = $uri[2];
	
	return $data;
}

/* Explore view page function */
function view() {
	global $get;
	/* Make sure that this page is not accessible
	 * if the GET uri variable is not defined */
	if (!isset($_GET['uri'])) {
		js_redirect('home');
	}

	/* Use the Flickr API [or class] to get Image metadata
	 * Build image url using Flickr class */
	include('inc/classes/thirdparty-api/flickr.class.php');
	$result 				= array();
	$tags 					= '';
	$flickr 				= new Flickr(FLICKR_API_KEY);
	$result 				= $flickr->get_photo_info(array('photo_id'=>$_GET['uri']));
	$data['id'] 			= $result['photo']['id'];
	$data['title'] 			= $result['photo']['title']['_content'];
	$data['description'] 	= $result['photo']['description']['_content'];
	$data['dateuploaded'] 	= date('F d, Y', $result['photo']['dateuploaded']);
	$data['img_path'] 		= $flickr->img_url($result['photo']);
	$data['owner_name']		= $result['photo']['owner']['realname'];
	$data['comments']		= $result['photo']['comments']['_content'].' ';
	
	// Get image tags
	if (isset($result['photo']['tags']['tag'])) {
		$first = true;
		foreach ($result['photo']['tags']['tag'] as $key => $tag) {
			$tags .= ($first) ? $tag['raw'] : ', '.$tag['raw'];
			$first = false;
		}
	}
	$data['tags'] = $tags;

	return $data;
}

?>