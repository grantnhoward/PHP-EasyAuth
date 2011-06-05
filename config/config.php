<?php

//local
$server = 'localhost';
$database = 'testing_db';
$db_user = 'root';
$db_pass = '';

//prod
//$server = 'localhost';
//$database = '';
//$db_user = '';
//$db_pass = '';

try {
    $dbh = new PDO("mysql:host=$server;dbname=$database", $db_user, $db_pass);
}
catch(PDOException $e){
    echo $e->getMessage();
}

?>