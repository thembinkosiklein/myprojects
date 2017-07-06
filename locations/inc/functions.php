<?php
/**************************************************************************************************
*										FUNCTIONS
*	List of functions to used globally through out the Website.
**************************************************************************************************/

	function out( $data ){
		if(is_array($data)){
			echo "<pre>".print_r($data, true)."</pre>";
		}else if(is_object($data)){
			echo "<pre>".print_r($data,true)."</pre>";
		}else{
			echo $data;
		}
	}

	function js_redirect($page, $base_path = null) {
        $base_path = (!is_null($base_path)) ? $base_path : BASE_PATH;
		echo '<script>window.location = "'.$base_path.$page.'";</script>';
        die();
	}

	function file_not_found($page, $folder = '') {
		if (empty($folder)) {
			return 	!file_exists("pages/".$page.".php") 			&&
					!file_exists("pages/".$page."/".$page.".php");
		} else {
			return 	!file_exists("pages/".$page.".php") 			&&
					!file_exists("pages/".$page."/".$page.".php") 	&& 
					!file_exists("pages/".$folder."/".$page.".php");
		}
	}

	function create_salt() {
		$text = md5(uniqid(rand(), true));
		return substr($text, 0, 3);
	}


/**************************************************************************************************
*										/FUNCTIONS
**************************************************************************************************/
?>