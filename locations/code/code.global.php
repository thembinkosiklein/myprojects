<?php

	/* Log out code
	 * Check if logout REQUEST var is passed through the url
	 * and if the user is already logged in */
	if (isset($_REQUEST['logout']) && $auth->isAuth()) {
		$auth->logout();
	}

	// page loader
	$loader = ($viewPage == "login" || $viewPage == "register") ? 'display: none' : '';

	// Check if user is logged in
	$loggedIn = ($auth->isAuth()) ? 'user-logged-in' : '';

?>