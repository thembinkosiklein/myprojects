<?php 

/* Account page function */
function account() {
	global $auth;
	/* Make sure that this page is not accessible
	 * if the user is not logged in */
	if (!$auth->isAuth()) {
		js_redirect('home');
	}
}

?>