<?php

/*
$host_name = 'db757505496.db.1and1.com';
$database = 'db757505496';
$user_name = 'dbo757505496';
$password = 'OsoUnal2018#';

$dbh = null;
try {
  $dbh = new PDO("mysql:host=$host_name; dbname=$database;", $user_name, $password);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo "Error!: " . $e->getMessage() . "<br/>";
  die();
}


*/


/*
*/

ini_set('display_errors',1);
ini_set('display_stratup_errors',1);
error_reporting(E_ALL);

$dbh = new PDO('mysql:host=localhost;dbname=proyect_oso', 'root','');
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>
