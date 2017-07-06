<?php

/**************************************************************************************
 *	AJAX CALLS FOR THE LOGIN PAGE
 * 	- All ajax calls for login page
 **************************************************************************************/

$json['success'] = false;

/* User login
 * Check if user exists in database
 * Login the user by validating login details */
if (isset($_POST['login'])) {
	if (isset($_POST['username']) && isset($_POST['password'])) {
		if ($auth->setAuth($_POST['username'], $_POST['password'])) {
			if ($auth->userExists()) {
				if ($auth->login()) {
					$json['success'] = true;
				}
			}
		};
		$errors = $auth->getErrors();
		if (is_array($errors) && !empty($errors)) {
			$json['error'] = '';
			foreach ($errors as $key => $value) {
				$json['error'] .= $value.'. ';
			}
		}
	} else $json['error'] = 'Access denied!';
}

echo json_encode($json);
die();


?>