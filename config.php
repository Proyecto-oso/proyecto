<?php



  ini_set('display_errors',1);
  ini_set('display_stratup_errors',1);
  error_reporting(E_ALL);

  $dbh = new PDO('mysql:host=localhost;dbname=proyect_oso', 'root','');


  


/*
*/

/*
  $host_name = 'db746299236.db.1and1.com';
  $database = 'db746299236';
  $user_name = 'dbo746299236';
  $password = 'Gameshow*38';

  $dbh = null;
  try {
    $dbh = new PDO("mysql:host=$host_name; dbname=$database;", $user_name, $password);
  } catch (PDOException $e) {
    echo "Error!: " . $e->getMessage() . "<br/>";
    die();
  }
  */
?>
