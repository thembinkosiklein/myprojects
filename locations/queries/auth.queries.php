<?php

class Auth extends Database {
	
	private $user;
	private $pass;
	private $user_info;
	private $db;

	private $temp_usr;

	public $error;
	public $errorLog = array();

	// important keys
	private $info_session_key = '___infoSessKey';
	private $auth_session_key = '___authSessKey';

	function __construct() {
        $this->db = new Database();		
	}

	public function getErrors() {
		return $this->errorLog;
	}

	public function check() {
		if(isset($_REQUEST['root']) && $_REQUEST['root'] !== "login") {
			if(!isset($_SESSION[$this->auth_session_key])) {
				header("Location: ".BASE_PATH."home");
			}
		}
	}

	public function isAuth() {
		return isset($_SESSION[$this->auth_session_key]) && $_SESSION[$this->auth_session_key];
	}

	public function setAuth($username, $password) {

		if(isset($username) && !empty($username)) {
			$this->user = $username;
		} else {
			$this->error   		= TRUE;
			$this->errorLog[] 	= "Username cannot be blank";
			return FALSE;
		}
		if(isset($password) && !empty($password)) {
			$this->pass = $password;
		} else {
			$this->error   		= TRUE;
			$this->errorLog[] 	= "Password cannot be blank";
			return FALSE;
		}

		return TRUE;

	}

	public function userExists($username = null) {

		$username = (!is_null($username)) ? $username : $this->user;

		// used to check if the user exists or not...
		$query = $this->db->select("*");
		$query.= $this->db->from("users");
		$query.= $this->db->where("username=:u");
		$this->db->query($query);
		$this->db->bind(':u', $username);
		$this->temp_usr = $this->db->single();
		return $this->temp_usr;
	}

	private function userCheck() {

		try {
			// used to check if the user exists or not...
			$query = $this->db->select("*");
			$query.= $this->db->from("users");
			$query.= $this->db->where("username=:u AND password=:p");

			// password encryption process
			$hash = hash('sha256', $this->pass);
			$salt  = $this->temp_usr['salt'];
			$pswd  = hash('sha256', $salt . $hash);

			$this->db->query($query);
			$this->db->bind(':u', $this->user);
			$this->db->bind(':p', $pswd);
			if($row = $this->db->single()) {
				$this->user_info 					= $row;
				$_SESSION[$this->info_session_key] 	= $row;
				$_SESSION[$this->auth_session_key] 	= TRUE;
				return TRUE;
			} else {
				$this->errorLog[] = "Access Denied";
				return FALSE;
			}

		} catch(PDOException $e) {
			die($e->getMessage());
			$this->error 		= TRUE;
			$this->errorLog[] 	= $e->getMessage();
		}
			
	}

	public function getUser() {
		if(!empty($this->user_info))
			return $this->user_info;
		else if(isset($_SESSION[$this->info_session_key]) && !empty($_SESSION[$this->info_session_key]))
			return $_SESSION[$this->info_session_key];
	}

	public function login() {
		return $this->userCheck();
	}

	public function logout() {
		unset($_SESSION[$this->auth_session_key]);
		unset($_SESSION[$this->info_session_key]);
		header("Location: ".BASE_PATH."home?logged_out");
	}
}

?>