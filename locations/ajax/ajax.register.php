<?php

/**************************************************************************************
 *	AJAX CALLS FOR THE REGISTRATION PAGE
 * 	- All ajax calls for registration page
 **************************************************************************************/

$json['success'] = false;

/* Create user's account
 * Insert user details into the database */
if (isset($_POST['create_account'])) {
	if (!empty($_POST['name']) && !empty($_POST['surname']) && !empty($_POST['username']) && !empty($_POST['password'])) {
		$json = $insert->user($_POST);
	}
}

echo json_encode($json);
die();


?>