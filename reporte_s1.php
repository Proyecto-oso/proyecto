<?php
include_once("config.php");
if (!isset($_SESSION)) {
    session_start();
}
include_once("functions.php");
if (!func::checkLoginState($dbh)) {
    echo '<script language="javascript">window.location="login.php"</script>';
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="theme-color" content="#000000">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Kanit" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="styles/sesion1.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
    <title>Proyecto Psicologia</title>
<style>
</style>
</head>
<body>
<div class="container">
<canvas id="myChart" class="chartjs" width="770" height="200" style="display: block; width: 770px; height: 385px;"></canvas>
<script>
new Chart(document.getElementById("myChart"),{"type":"bar","data":{"labels":["Verbal","Matematico"],"datasets":[
    {"label":"Todos los estudiantes","data":[65,30],"fill":false,"backgroundColor":["rgba(255, 99, 132, 0.2)","rgba(255, 99, 132, 0.2)"],"borderColor":["rgb(255, 99, 132)","rgb(255, 99, 132)"],"borderWidth":1},
    {"label":"Tu grupo","data":[30,40],"fill":false,"backgroundColor":["rgba(20, 255, 20, 0.2)","rgba(20, 255, 20, 0.2)"],"borderColor":["rgb(20, 255, 20)","rgb(20, 255, 20)"],"borderWidth":1},
    {"label":"Tu","data":[10,80],"fill":false,"backgroundColor":["rgba(20, 20, 255, 0.2)","rgba(20, 20, 255, 0.2)"],"borderColor":["rgb(20, 20, 255)","rgb(20, 20, 255)"],"borderWidth":1},
    ]},
    "options":{"scales":{"yAxes":[{"ticks":{"beginAtZero":true}}]}}});
</script>
</div>
</body>
<?php

include_once("footer.php");
?>

