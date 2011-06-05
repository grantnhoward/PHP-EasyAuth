<?php
	include_once $_SERVER['DOCUMENT_ROOT'].'/globals.php';
	include_once CONF.'/config.php';
	include CLASSES.'/User.php';
	include DAO.'/UserDao.php';
	require_once UTIL.'/PasswordHash.php';
	
	$username=$_POST['username'];
	$password=$_POST['password'];
	$error=false;
	
	/*** simple validation ***/
	if(empty($password) || empty($username)){ $error = true;}
	
    /*** fetch the results ***/
	$dao = new UserDao($dbh);
    $result = $dao->getUser($username);
    
    /*** check pw ***/
	$stored_pw = $result->password;
	$hasher = new PasswordHash(8, FALSE);
	$check = $hasher->CheckPassword($password, $stored_pw);
	
	if ($check && !$error) {
		$uid = (int)$result->id;
		$dbh->exec("UPDATE users set last_login = null WHERE id = $uid");
		
		session_start();
		$user = clone($result);
		$user->password = '';
		$_SESSION['user'] = $user;
		
		header("location:/home.php");
	}
	else {
		session_start();
		$_SESSION['result'] = 'error';
		$_SESSION['msg']='Invalid username or password. Please try again.';
		session_commit();
		
		header("location:/login.php");
	}
?>
