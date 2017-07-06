<?php
/*************************************************
* 				START OF PHP LOGIC
*************************************************/

# include and instantiate framework class
include_once("inc/classes/template.class.php");
GLOBAL $template;
$template = new Template();

# Get sid - Gets the session id, if has been passed into the url.
if (isset($_GET['sid'])) {
	# Setting the SESSION id.
	session_id($_GET['sid']);
}

session_start();
$sid = isset($_REQUEST['sid']) ? $_REQUEST['sid'] : session_id();

$folder = '';

# Check page URl or default to home
if (isset($_GET['subpage'])) {

	$_FRAMEWORK['subpage'] = $_GET['subpage'];

	if (!empty($_GET['root'])) {
		$folder	  = $_GET['root'];
	} else {
		$folder   = '';
	}	

	$rootPage 	= $_GET['subpage'];
	$relPathRef = '../';

} elseif ((isset($_GET['root'])) && (!empty($_GET['root']))) {
	$rootPage 	= $_GET['root'];
	$relPathRef = '';
} else {
	$rootPage 	= 'home';
	$relPathRef = '';
}

# Set the view - this can be changed in code. pages
$viewPage 			= $rootPage;
$_FRAMEWORK['root'] = $rootPage;

												
# Include Global Code
include_once( "inc/constants.php" );
include_once( "inc/functions.php" );

# If the file does not exist
# Redirect to the 404 page
if ($viewPage <> "account" && file_not_found($viewPage, $folder)) {
	header("Location: " . BASE_PATH . "404");
}

# If log out page is called
# use auth class to log out
if ($viewPage == "logout") {
	$auth->logout();
}

if (isset($_REQUEST['ajax_on'])) {		

	# include global ajax page
	include_once( "ajax/ajax.global.php" );	

	# Include ajax page based on page URL
	if (file_exists("ajax/ajax." . $folder . ".php")) {
		include_once("ajax/ajax." . $folder . ".php");
	} elseif (file_exists("ajax/ajax." . $rootPage . ".php")) {
		include_once("ajax/ajax." . $rootPage . ".php");
	}

} else {				

	# include global code page
	include_once( "code/code.global.php" );		

	# Include Code page based on page URL
	if (file_exists("code/code." . $folder . ".php")) {
		include_once("code/code." . $folder . ".php");
	} elseif (file_exists("code/code." . $rootPage . ".php")) {
		include_once("code/code." . $rootPage . ".php");
	}
}

# Set the JS & CSS Filename into FRAMEWORK Variable.
if ($folder == '') {
	$_FRAMEWORK['fileNameJsCss'] = $viewPage;
} else {
	$_FRAMEWORK['fileNameJsCss'] = $folder;
}

# Check if Ajax or show headertoke
(isset($_REQUEST['ajax_on'])) ? "" : include_once( "pages/header.php" );

$function = str_replace("-", "_", $viewPage);

# Include page base on URL
if ($folder == '') {

	if (file_exists("pages/".$viewPage."/".$viewPage.".php")) {
		$content = file_get_contents("pages/" . $viewPage . "/" . $viewPage . ".php");
		if (function_exists($function)) {
			$data = $function();
		} elseif ($viewPage == '404') {
			if (function_exists('fourZeroFour')) {
				$data = fourZeroFour();
			}
		}
		if ($template->valid($data, 'array')) {
			$content = $template->string_replace($data, $content);
		}
		echo $content;
	} elseif ( file_exists( "pages/" . $viewPage . ".php" ) ) {	
		$content = file_get_contents( "pages/" . $viewPage . ".php" );
		if (function_exists($function)) {
			$data = $function();
		} elseif ($viewPage == '404') {
			if (function_exists('fourZeroFour')) {
				$data = fourZeroFour();
			}
		}
		if ($template->valid( $data, 'array')) {
			$content = $template->string_replace($data, $content);
		}
		echo $content;	
	}

} else {

	if (file_exists("pages/" . $folder . "/" . $viewPage . ".php")) {
		$content = file_get_contents("pages/" . $folder . "/" . $viewPage . ".php");
		if (function_exists($function)) {
			$data = $function();
		} elseif ($viewPage == '404') {
			$data = fourZeroFour();
		}
		if ($template->valid($data, 'array')) {
			$content = $template->string_replace($data, $content);
		}
		echo $content;
	}
}

# Check if Ajax or show footer
(isset($_REQUEST['ajax_on'])) ? "" : include_once("pages/footer.php");


/*************************************************
* 				END OF PHP LOGIC
*************************************************/
?>