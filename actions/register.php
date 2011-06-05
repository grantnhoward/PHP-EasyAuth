<?php
	include_once $_SERVER['DOCUMENT_ROOT'].'/globals.php';
	include_once CONF.'/config.php';
	include CLASSES.'/User.php';
	include DAO.'/UserDao.php';
	include_once UTIL.'/validators.php';
	require UTIL.'/PasswordHash.php';
	session_start();

	$validation = array();
	$username = trim($_POST['username']);
	$email = $_POST['email'];
	$password = $_POST['password'];
	$dao = new UserDao($dbh);
	
	//validation
	$validation = validRegistration($username, $password, $email, $dbh);
	
	if(empty($validation['errors'])){
		$hasher = new PasswordHash(8, FALSE);
		$hash = $hasher->HashPassword($password);
	    $count = $dao->insertNewUser($username, $hash, $email);

		if($count = 1){		
			$user = $dao->getUser($username);	
			$user->password = '';		
			$_SESSION['user'] = $user;	
			header("location:/home.php");
		}else{
			break;
		}
		
	}else{
		$_SESSION['results'] = $validation;
		$_SESSION['username'] = $username;
		$_SESSION['email'] = $email;
		session_commit();
		
		header("location:/register.php");
		
		}

?>