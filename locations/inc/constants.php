<?php
/**************************************************************************************************
*									CONSTANTS | CONFIGURATION
*	Variables that are used through out the website are all Declared here.
**************************************************************************************************/
	
	# Database Variables
	define('DB_HOST', '');		# <YOUR_DATABASE_HOST>
	define('DB_USER', '');		# <YOUR_DATABASE_USER>
	define('DB_PASS', '');		# <YOUR_DATABASE_PASSWORD>
	define('DB_NAME', ''); 		# <YOUR_DATABASE_NAME>

	# Flickr API Settings
	define('FLICKR_API_KEY', '');	# <YOUR_FLICKR_API_KEY>

	# Foursquare API Settings
	define('FOURSQUARE_API_KEY', '');		# <YOUR_FOURSQUARE_API_KEY>
	define('FOURSQUARE_API_SECRET', '');	# <YOUR_FOURSQUARE_API_SECRET>

	# Database Connection/Queries classes
	include('inc/classes/db.class.php');
	include('queries/auth.queries.php');
	include('queries/insert.queries.php');
	include('queries/get.queries.php');
	include('queries/delete.queries.php');
	$auth 	= new Auth();
	$insert = new Insert();
	$get 	= new Get();
	$delete	= new Delete();
	
	# Set the Absolute Base Path Here
	define('BASE_PATH', dirname($_SERVER['PHP_SELF']) . '/');
	
	# FRAMEWORK ARRAY Declartion
	$_FRAMEWORK = array();

	# Website Name for pages/header.php <title> tag
	define('SITE_NAME', 'Location Listing');

/**************************************************************************************************
*										/CONSTANTS
**************************************************************************************************/
?>