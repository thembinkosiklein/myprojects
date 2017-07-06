<?php 


class Delete extends Database {

	protected $db;

	function __construct() {
        $this->db = new Database();	
	}

	function user_location($data) {
		global $auth;
		$user 	= $auth->getUser();
		$query 	= $this->db->delete('user_locations', 'user_id=:user_id AND location=:location');
		$this->db->query($query);
		$this->db->bind(':user_id', 	$user['id']);
		$this->db->bind(':location', 	$data['location']);
		return array('success'=>$this->db->execute());
	}
}

?>