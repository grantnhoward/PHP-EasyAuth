<?php 
include_once $_SERVER['DOCUMENT_ROOT'].'/globals.php';
include_once UTIL.'/validators.php';

session_start();
$action = array();
$text = array();

if($_SESSION['result'] == 'error' ){
	array_push($text, $_SESSION['msg']);
}
$action['errors'] = $text;
unset($_SESSION['result']);
session_destroy();

?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<link href="/view/css/style.css?v=<?php echo STATIC_VERSION;?>" rel="stylesheet" type="text/css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js" ></script>
</head>
<body>
	<div id="wrapper">
	<?php include ELEMENTS.'/nav.php'; ?>
	<h1>Login</h1>
	<form name="login" method="post" action="src/actions/login.php">
	<?php echo show_errors($action); ?>
		<div>
    		<label for="username">Username\Login:</label> <br/>
    		<input type="text" name="username" id="username"/>
    	</div>
    	<div>
    		<label for="password">Password:</label> <br/>
    		<input type="password" name="password" id="password" />
    	</div>
    	<div>
    		<br/>
    		<input type="submit" value="Login" class="large green button" name="Submit" />
    	</div>
    		
	</form>
	<?php include ELEMENTS.'/footer.php'; ?>
	</div>
</body>
</html>