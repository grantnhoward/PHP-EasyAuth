<?php 
include_once $_SERVER['DOCUMENT_ROOT'].'/globals.php';
include CLASSES.'/User.php';
session_start();
$user = $_SESSION['user'];

?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<link href="/css/style.css?v=<?php echo STATIC_VERSION;?>" rel="stylesheet" type="text/css" />
</head>
<body>
	<div id="wrapper">
	<?php include ELEMENTS.'/nav.php'; ?>
	<h1>Hello User.</h1>
	Welcome <b><?php echo $user->username;?></b>, to the post-login page.
	
	</div>
</body>
</html>