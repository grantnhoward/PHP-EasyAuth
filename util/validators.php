<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/globals.php';
include_once DAO.'/UserDao.php';

	function validEmail($email)
	{
	   $isValid = true;
	   $atIndex = strrpos($email, "@");
	   if (is_bool($atIndex) && !$atIndex)
	   {
	      $isValid = false;
	   }
	   else
	   {
	      $domain = substr($email, $atIndex+1);
	      $local = substr($email, 0, $atIndex);
	      $localLen = strlen($local);
	      $domainLen = strlen($domain);
	      if ($localLen < 1 || $localLen > 64)
	      {
	         // local part length exceeded
	         $isValid = false;
	      }
	      else if ($domainLen < 1 || $domainLen > 255)
	      {
	         // domain part length exceeded
	         $isValid = false;
	      }
	      else if ($local[0] == '.' || $local[$localLen-1] == '.')
	      {
	         // local part starts or ends with '.'
	         $isValid = false;
	      }
	      else if (preg_match('/\\.\\./', $local))
	      {
	         // local part has two consecutive dots
	         $isValid = false;
	      }
	      else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))
	      {
	         // character not valid in domain part
	         $isValid = false;
	      }
	      else if (preg_match('/\\.\\./', $domain))
	      {
	         // domain part has two consecutive dots
	         $isValid = false;
	      }
	      else if(!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\","",$local)))
	      {
	         // character not valid in local part unless 
	         // local part is quoted
	         if (!preg_match('/^"(\\\\"|[^"])+"$/',
	             str_replace("\\\\","",$local)))
	         {
	            $isValid = false;
	         }
	      }
	   }
	   return $isValid;
	}
	
	function checkEmail($email, $dbh) {
	  $email = trim($email); // strip any white space
	  $response = array(); 
	  $dao = new UserDao($dbh);
	  
	  // if the email is blank
	  if (!$email) {
	    $response = array(
	      'ok' => false, 
	      'msg' => "Please enter an email address.");
	      
	  // if the email has invalid pattern
	  } else if (!validEmail($email)) {
	    $response = array(
	      'ok' => false, 
	      'msg' => "Invalid email address.");
	      
	  } else if ($dao->emailAccountTaken($email, $dbh)) {
	    $response = array(
	      'ok' => false, 
	      'msg' => "An account with this email exists.");
	      
	  // it's all good
	  } else {
	    $response = array(
	      'ok' => true, 
	      'msg' => "");
	  }
	  return $response;        
	}
	
	function checkUsername($username, $dbh) {
	  $username = trim($username); // strip any white space
	  $response = array();
	  $dao = new UserDao($dbh);
	  
	  // if the username is blank
	  if (!$username) {
	    $response = array(
	      'ok' => false, 
	      'msg' => "Please enter a username.");
	      
	  // if the username does not match a-z, 0-9 or '.', '-', '_' then it's not valid
	  } else if (!preg_match('/^[a-z0-9.-_]+$/', $username)) {
	    $response = array(
	      'ok' => false, 
	      'msg' => "Characters allowed: (a-z0-9.-_)");
	      
	  } else if (strlen($username) < 4){
	    $response = array(
	      'ok' => false, 
	      'msg' => "Username must be at least 4 characters.");
	      
	  // check if the username is taken
	  } else if ($dao->usernameTaken($username)) {
	    $response = array(
	      'ok' => false, 
	      'msg' => "Username unavailable.");
	      
	  // it's all good
	  } else {
	    $response = array(
	      'ok' => true, 
	      'msg' => "");
	  }
	  return $response;        
	}
	
	function checkPassword($password) {
	  $response = array();
	  
	  // if the password is blank
	  if (!$password) {
	    $response = array(
	      'ok' => false, 
	      'msg' => "Please enter a password.");
	      
	  } else if (strlen($password) < 6){
	    $response = array(
	      'ok' => false, 
	      'msg' => "Password must be at least 6 characters.");
	      
	  // it's all good
	  } else {
	    $response = array(
	      'ok' => true, 
	      'msg' => "");
	  }
	  return $response;        
	}
	
	function validRegistration($username, $password, $email, $dbh){
		$results = array();
		$errors = array();
		
		$validUser = checkUsername($username, $dbh);
		$validPw = checkPassword($password, $dbh);
		$validEmail = checkEmail($email, $dbh);
		
		if(!$validUser['ok']){
			array_push($errors, $validUser['msg']);
		}
		if(!$validPw['ok']){
			array_push($errors, $validPw['msg']);
		}
		if(!$validEmail['ok']){
			array_push($errors, $validEmail['msg']);
		}
		
		$results['errors'] = $errors;
		return $results;
	}
	
	function show_errors($action){
		$error = false;
		if(!empty($action['errors'])){
			$error = "<ul id=\"errors\" class=\"alert error\">"."\n";
			foreach($action['errors'] as $text){
				$error .= "<li><p>$text</p></li>"."\n";
			}	
			$error .= "</ul>"."\n";
		}
		return $error;
	}
	
?>