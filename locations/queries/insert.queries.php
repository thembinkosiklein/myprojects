<?php 


class Insert extends Database {

	protected $db;

	function __construct() {
        $this->db = new Database();	
	}

	function location($data) {

		global $get;

		// Eliminate duplicate locations in the database
		if ($get->location($data)) {
			return true;
		}

		// Do databaase insert
		$insert = "null, :term, :id, :name, :address, :city, :state, :country, :lat, :lng, :categories";
		$query  = $this->db->insert('locations', $insert);
		$this->db->query($query);
		$this->db->bind(':term', 		$data['term']);
		$this->db->bind(':id', 			$data['id']);
		$this->db->bind(':name', 		$data['name']);
		$this->db->bind(':address',		$data['address']);
		$this->db->bind(':city',		$data['city']);
		$this->db->bind(':state', 		$data['state']);
		$this->db->bind(':country', 	$data['country']);
		$this->db->bind(':lat', 		$data['lat']);
		$this->db->bind(':lng', 		$data['lng']);
		$this->db->bind(':categories', 	$data['categories']);
		return $this->db->execute();
	}

	function photo($data) {

		global $get;

		// Eliminate duplicate images in the database
		if ($get->image($data['id'])) {
			return true;
		}

		// Do databaase insert
		$insert = "null, :location, :id, :owner, :secret, :server, :farm, :title";
		$query 	= $this->db->insert('images', $insert);
		$this->db->query($query);
		$this->db->bind(':location',$data['location']);
		$this->db->bind(':id', 		$data['id']);
		$this->db->bind(':owner', 	$data['owner']);
		$this->db->bind(':secret', 	$data['secret']);
		$this->db->bind(':server', 	$data['server']);
		$this->db->bind(':farm', 	$data['farm']);
		$this->db->bind(':title', 	$data['title']);
		return $this->db->execute();
	}

	function user($data) {

		global $get;

		// Eliminate duplicate images in the database
		if ($get->user(trim($data['email']))) {
			return array('success'=>false, 'error'=>'User already exists!');
		}

		$hash = hash('sha256', $data['password']);
		$salt = create_salt();
		$pswd = hash('sha256', $salt . $hash);

		// Do databaase insert
		$insert = "null, :name, :surname, :username, :password, :salt, :createpdt";
		$query 	= $this->db->insert('users', $insert);
		$this->db->query($query);
		$this->db->bind(':name', 		$data['name']);
		$this->db->bind(':surname', 	$data['surname']);
		$this->db->bind(':username', 	$data['username']);
		$this->db->bind(':password', 	$pswd);
		$this->db->bind(':salt', 		$salt);
		$this->db->bind(':createpdt', 	date('U'));
		return array('success'=>$this->db->execute());
	}

	function user_location($data) {
		global $auth;
		$user 	= $auth->getUser();
		$insert = "null, :user_id, :location";
		$query 	= $this->db->insert('user_locations', $insert);
		$this->db->query($query);
		$this->db->bind(':user_id', 	$user['id']);
		$this->db->bind(':location', 	$data['location']);
		return array('success'=>$this->db->execute());
	}
}

?>