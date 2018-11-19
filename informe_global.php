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
    <link rel="stylesheet" type="text/css" href="styles/informe_s1.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
    <title>Proyecto Psicologia</title>
    <style type="text/css" media="print">
    
    </style>
</head>
<?php 
$suma_v_todos = 0;
$suma_m_todos = 0;
$suma_v_grupo = 0;
$suma_m_grupo = 0;
$count_grupo = 0;
$count_todos = 0;
$query = ' SELECT id,nombre FROM grupo';
$stmt = $dbh->prepare($query);
$stmt->execute();
$groups = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<body>
<div class="container">
<div class="img-header">
<img src="uploads/informe header.png" >
</div>
<br>
<div class="titulo"><h2>EN DESARROLO</h2></div>
<div class="titulo"><h2>INFORME DE ORIENTACIÓN SOCIO OCUPACIONAL - SESIÓN 1</h2></div>
<div class="chart">
<canvas id="myChart" class="chartjs"></canvas>
</div>
<?php 
foreach ($groups as $g) {

    $query = ' SELECT grupo.id, estudiantes.id, sesion_1.total_aptitud_matematica, sesion_1.total_aptitud_verbal FROM grupo INNER JOIN estudiantes Inner join sesion_1 on grupo.id=estudiantes.grupo_id and estudiantes.id=sesion_1.id_estudiante where grupo.id=?';
    //echo $query;
    $stmt = $dbh->prepare($query);
    $stmt->execute([$g['id']]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows as $row) {
        $suma_v_todos += $row['total_aptitud_verbal'];
        $suma_m_todos += $row['total_aptitud_matematica'];
        $suma_v_grupo += $row['total_aptitud_verbal'];
        $suma_m_grupo += $row['total_aptitud_matematica'];
        $count_grupo++;
        $count_todos++;
    }
    if ($count_grupo!=0){
    $total_verbal_grupo = $suma_v_grupo / $count_grupo;
    $total_matematica_grupo = $suma_m_grupo / $count_grupo;
    echo 'grupo: '. $g['id']. '    total verbal: ' . $total_verbal_grupo . ', total matematico: ' . $total_matematica_grupo . '<br>';
    }else{
        echo 'grupo: '. $g['nombre']. '    total verbal: ' . 'error' . ', total matematico: ' . 'error' . '<br>';
    }
    $count_grupo = 0;
}
$total_verbal_estudiantes = $suma_v_todos / $count_todos;
$total_matematica_estudiantes = $suma_m_todos / $count_todos;

echo $total_verbal_estudiantes . ',' . $total_matematica_estudiantes;
?>
<!--<script>
new Chart(document.getElementById("myChart"),{"type":"bar","data":{"labels":["Verbal","Matematico"],"datasets":[
    {"label":"Todos los estudiantes","data":[<?php //echo $total_verbal_estudiantes.','.$total_matematica_estudiantes?>],"fill":false,"backgroundColor":["rgba(255, 99, 132, 0.2)","rgba(255, 99, 132, 0.2)"],"borderColor":["rgb(255, 99, 132)","rgb(255, 99, 132)"],"borderWidth":1},
    {"label":"Tu grupo","data":[<?php //echo $total_verbal_grupo.','.$total_matematica_grupo?>],"fill":false,"backgroundColor":["rgba(20, 255, 20, 0.2)","rgba(20, 255, 20, 0.2)"],"borderColor":["rgb(20, 255, 20)","rgb(20, 255, 20)"],"borderWidth":1},
    {"label":"Tu","data":[<?php //echo $est['total_aptitud_verbal'].','.$est['total_aptitud_matematica']?>],"fill":false,"backgroundColor":["rgba(20, 20, 255, 0.2)","rgba(20, 20, 255, 0.2)"],"borderColor":["rgb(20, 20, 255)","rgb(20, 20, 255)"],"borderWidth":1},
    ]},
    "options":{ 
        responsive:true,
        maintainAspectRatio: false,
        "scales":{"yAxes":[{"ticks":{"beginAtZero":true}}]}}});
</script>-->
</div>

</div>
</body>
