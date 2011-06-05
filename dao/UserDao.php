<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/globals.php';
	include_once CLASSES.'/User.php';
	
	class UserDao{
		public $dbh;
	
		public function __construct($dbh){
			$this->dbh = $dbh;
		}
		
		public function insertNewUser($username, $pw_hash, $email){
			$stmt = $this->dbh->prepare("INSERT INTO `users` VALUES(NULL, :username, :email, :hashpw, NULL)");
		    $stmt->bindParam(':username', $username, PDO::PARAM_STR, 50);
		    $stmt->bindParam(':hashpw', $pw_hash, PDO::PARAM_STR, 128);
		    $stmt->bindParam(':email', $email, PDO::PARAM_STR, 250);
		
		    $count = $stmt->execute();
		    return $count;
		}
		
		public function getUser($key){
			$stmt = $this->dbh->prepare("SELECT * FROM users WHERE (username = :key OR email = :key) LIMIT 1");
		    $stmt->bindParam(':key', $key, PDO::PARAM_STR, 250);
		    $stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'User'); 
		    $stmt->execute();
		    
		    $user = $stmt->fetch();
		    return $user;
		}
		
		public function usernameTaken($username){
			$stmt = $this->dbh->prepare("SELECT count(*) FROM users where username = :username");
			$stmt->bindParam(':username', $username, PDO::PARAM_STR, 50);
			$stmt->execute();
			
			$count = $stmt->fetchColumn();
			return $count>0;
		}
		
		public function emailAccountTaken($email){
			$stmt = $this->dbh->prepare("SELECT count(*) FROM users where email = :email");
			$stmt->bindParam(':email', $email, PDO::PARAM_STR, 250);
			$stmt->execute();
			
			$count = $stmt->fetchColumn();
			return $count>0;
		}
	}


?>