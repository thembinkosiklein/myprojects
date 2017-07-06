<?php 


class Get extends Database {

	protected $db;

	function __construct() {
        $this->db = new Database();		
	}

	function location($params) {

		switch (TRUE) {
			
			// Get location by name
			case (isset($params['name'])):
				$query = $this->db->select("*");
				$query.= $this->db->from("locations");
				$query.= $this->db->where("location_name=:name");
				$this->db->query($query);
				$this->db->bind(":name", $params['name']);
				$data  = $this->db->single();
				return (isset($data['id']) && !empty($data['id'])) ? $data : false;
				break;
			
			case (isset($params['term']) && isset($params['user_id'])):
				$search= explode(',', $params['term']);
				$query = $this->db->select("l.*, u.id AS chk");
				$query.= $this->db->from("locations l");
				$query.= $this->db->join("user_locations u on u.location = l.location_name AND u.user_id=:user_id", "LEFT");

				// check if term or gps coordinates have been used
				if ((isset($search[0]) && is_numeric($search[0])) && (isset($search[1]) && is_numeric($search[1]))) {
					$query.= $this->db->where("l.term=:term OR (l.lat=:lat OR l.lng=:lng)");
					$query.= $this->db->order("l.id");
					$this->db->query($query);
					$this->db->bind(":lat", trim($search[0]));
					$this->db->bind(":lng", trim($search[1]));
				} else {
					$query.= $this->db->where("l.term=:term");
					$query.= $this->db->order("l.id");
					$this->db->query($query);
				}
				$this->db->bind(":term", 	$params['term']);
				$this->db->bind(":user_id", $params['user_id']);
				$data  = $this->db->resultset();
				return (is_array($data) && !empty($data)) ? $data : false;
				break;
			
			// Get location by search term
			case (isset($params['term'])):
				$search= explode(',', $params['term']);
				$query = $this->db->select("*");
				$query.= $this->db->from("locations");

				// check if term or gps coordinates have been used
				if ((isset($search[0]) && is_numeric($search[0])) && (isset($search[1]) && is_numeric($search[1]))) {
					$query.= $this->db->where("term=:term OR (lat=:lat OR lng=:lng)");
					$query.= $this->db->order("id");
					$this->db->query($query);
					$this->db->bind(":lat", trim($search[0]));
					$this->db->bind(":lng", trim($search[1]));
				} else {
					$query.= $this->db->where("term=:term");
					$query.= $this->db->order("id");
					$this->db->query($query);
				}
				$this->db->bind(":term", $params['term']);
				$data  = $this->db->resultset();
				return (is_array($data) && !empty($data)) ? $data : false;
				break;
			
			// Get user's custom [saved] locations
			case ($params['user_id']):
				$query = $this->db->select("l.*, u.id AS chk");
				$query.= $this->db->from("locations l");
				$query.= $this->db->join("user_locations u on u.location = l.location_name");
				$query.= $this->db->where("u.user_id=:user_id");
				$query.= $this->db->order("l.id");
				$this->db->query($query);
				$this->db->bind(":user_id", $params['user_id']);
				$data  = $this->db->resultset();
				return (is_array($data) && !empty($data)) ? $data : false;
				break;
		}

		
	}

	function image($params) {

		switch (TRUE) {
			case (isset($params['id'])):
				$query = $this->db->select("*");
				$query.= $this->db->from("images");
				$query.= $this->db->where("image_id=:id");
				$this->db->query($query);
				$this->db->bind(":id", $params['id']);
				$data  = $this->db->single();
				return (isset($data['id']) && !empty($data['id'])) ? $data : false;
				break;
			
			case (isset($params['location_name'])):
				$query = $this->db->select("*");
				$query.= $this->db->from("images");
				$query.= $this->db->where("location_name=:location_name");
				$this->db->query($query);
				$this->db->bind(":location_name", $params['location_name']);
				$data  = $this->db->resultset();
				return (is_array($data) && !empty($data)) ? $data : false;
				break;
		}
	}

	function user($params) {

		switch (TRUE) {
			case (isset($params['username'])):
				$query = $this->db->select("*");
				$query.= $this->db->from("users");
				$query.= $this->db->where("username=:username");
				$this->db->query($query);
				$this->db->bind(":username", $params['username']);
				$data  = $this->db->single();
				return (isset($data['id']) && !empty($data['id'])) ? $data : false;
				break;
		}
	}
}

?>