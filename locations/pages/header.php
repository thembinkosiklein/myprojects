<!DOCTYPE html>
<html lang="en">
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?php echo SITE_NAME ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Google Fonts API -->
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Oswald:300|Lato:300,400,300i,400i" media="all">

    <!-- Libraries -->
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_PATH ?>lib/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_PATH ?>lib/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_PATH ?>css/main.css?v=0.9">
    
</head>

<body class="load-page-<?php echo $viewPage ?> <?php echo $loggedIn ?>" data-basepath="<?php echo BASE_PATH ?>">

	<nav class="navbar navbar-default">
	  	<div class="container-fluid">
		    <!-- Brand and toggle get grouped for better mobile display -->
		    <div class="navbar-header">
		     	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
			        <span class="sr-only">Toggle navigation</span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
		      	</button>
		      	<a class="navbar-brand" href="<?php echo BASE_PATH ?>home">Home</a>
		    </div>

		    <!-- Collect the nav links, forms, and other content for toggling -->
		    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		      	<ul class="nav navbar-nav navbar-right">
		      		<?php if ($auth->isAuth()) : ?>
	      			<li><span class="welcome">Welcome Back!&nbsp;&nbsp;</span></li>
			        <li><a href="<?php echo BASE_PATH ?>account" class="login">My Custom List</a></li>
			        <li><a href="<?php echo BASE_PATH ?>?logout" class="register">Log Out</a></li>
		      		<?php else: ?>
			        <li><a href="<?php echo BASE_PATH ?>login" class="login">Log In</a></li>
			        <li><a href="<?php echo BASE_PATH ?>register" class="register">Create Account</a></li>
			    	<?php endif; ?>
		      	</ul>
		    </div><!-- /.navbar-collapse -->
	  	</div><!-- /.container-fluid -->
	</nav>

<?php if ($viewPage <> "home" && $viewPage <> "view") : ?>
	<div id="no-results" style="<?php echo $loader ?>">
		<?php if ($viewPage <> "login" && $viewPage <> "register") : ?>
		<div id="no-results-box" class="text-center" style="margin-top: 150px; display: none">
			<h3 style="padding-bottom: 10px;">
				<i class="fa fa-frown-o fa-2x" style="display: block; margin-bottom: 10px;"></i>
				<strong>Sorry, no results found...</strong>
			</h3>
			<a href="<?php echo BASE_PATH ?>home" class="btn btn-default btn-lg">
				<i class="fa fa-refresh"></i>
				Try Again
			</a>
		</div>
		<?php endif; ?>
		<div id="page-loader" class="loadmore text-center" style="margin-top: 110px;">
			<button class="btn-loadmore loading"><i class="fa fa-3x fa-cog fa-spin"></i></button>
		</div>
	</div>
<?php endif; ?>