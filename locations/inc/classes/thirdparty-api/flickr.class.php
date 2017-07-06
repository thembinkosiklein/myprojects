<?php

/**
* Flickr API Class (Getting Locations and location metadata)
* Responsible for all api functions to Flickr
* @author Rodney Ncane
*/

if ( !class_exists('Flickr') ) {

	class Flickr {

		private $burl = 'https://api.flickr.com/services/rest?';
		private $photo_url = 'https://farm{farm}.staticflickr.com/{server}/{id}_{secret}.jpg';
		private $api_key;
		private $secret;

		public function __construct($api_key, $secret=NULL) {
			// The API Key must be set before any calls can be made.  You can
			// get your own at https://www.flickr.com/services/api/misc.api_keys.html
			$this->api_key 	= $api_key;
			$this->secret 	= $secret;
		}

		function search_photos($params) {
			return $this->request("flickr.photos.search", $params);
		}

		function get_photo_info($params) {
			return $this->request("flickr.photos.getInfo", $params);
		}

		function img_url($data) {
			global $template;
			return $template->string_replace($data, $this->photo_url);
		}

		private function request($method, $params, $format='php_serial') {
			/**
			 * build the API URL to call
			 */
			$params['api_key'] 	= $this->api_key;
			$params['method']	= $method;
			$params['format'] 	= $format;
			$encoded_params 	= array();

			foreach ($params as $k => $v) {
				$encoded_params[] = urlencode($k).'='.urlencode($v);
			}

			/**
			 * call the API and decode the response
			 */
			$url 	= $this->burl.implode('&', $encoded_params);
			$rsp 	= file_get_contents($url, "r");
			$rsp_obj= unserialize($rsp);
			/**
			 * return response object (or an error if it failed)
			 */
			if (isset($rsp_obj['stat']) && $rsp_obj['stat'] == 'ok'){
				return $rsp_obj;
			}
			return false;
		}
	}
}

?>