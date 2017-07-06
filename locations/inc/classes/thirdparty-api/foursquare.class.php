<?php

/**
* Foursquare API Class (Getting images and image metadata)
* Responsible for all api functions to Foursquare
* @author Rodney Ncane
*/

if ( !class_exists('Foursquare') ) {

	class Foursquare {

		private $burl = 'https://api.foursquare.com/v2/';
		private $api_key;
		private $secret;

		public function __construct($api_key, $secret) {
			$this->api_key 	= $api_key;
			$this->secret 	= $secret;
		}

		public function search_location($location) {
			return $this->request("venues/search?", array('near'=>$location));
		}

		private function request($uri, $params) {
			/**
			 * build the API URL to call
			 */
			$params['client_id'] 	= $this->api_key;
			$params['client_secret']= $this->secret;
			$params['v']			= date('Ymd');
			$encoded_params 		= array();

			foreach ($params as $k => $v) {
				$encoded_params[] = urlencode($k).'='.urlencode($v);
			}

			/**
			 * call the API and decode the response
			 */
			$url 	= $this->burl.$uri.implode('&', $encoded_params);
			$rsp 	= json_decode(file_get_contents($url, "r"), true);
			
			/**
			 * return response object (or an error if it failed)
			 */
			if (isset($rsp['meta']['code']) && $rsp['meta']['code'] == 200 && isset($rsp['response']['venues'])){
				return $rsp['response']['venues'];
			}
			return false;
		}

	}

}

?>