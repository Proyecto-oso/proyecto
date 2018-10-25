<?php
include_once("config.php");
if (!isset($_SESSION)) {
    session_start();
}
include_once("functions.php");
if (!func::checkLoginState($dbh)) {
    echo '<script language="javascript">window.location="login.php"</script>';
}

if(isset($_POST['id_estudiante'])){
    $id_estudiante = $_POST['id_estudiante'];
    $id_grupo = $_POST['id_grupo'];
    
}else{
    echo '<script language="javascript">window.location="sesion1.php"</script>';
}

$suma_v_todos = 0;
$suma_m_todos = 0;
$suma_v_grupo = 0;
$suma_m_grupo = 0;
$v_estudiante=0;
$m_estudiante=0;

$query = ' SELECT id FROM estudiantes WHERE grupo_id=?';
$stmt = $dbh->prepare($query);
$stmt->execute([$id_grupo]);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
$grupo=[];
foreach($rows as $row){
    array_push($grupo, $row['id']);
}

$query = ' SELECT id_estudiante,total_aptitud_verbal,total_aptitud_matematica FROM sesion_1';
$stmt = $dbh->prepare($query);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($rows as $row) {
    $suma_v_todos += $row['total_aptitud_verbal'];
    $suma_m_todos += $row['total_aptitud_matematica'];
    if (in_array($row['id_estudiante'], $grupo)) {
        $suma_v_grupo += $row['total_aptitud_verbal'];
        $suma_m_grupo += $row['total_aptitud_matematica'];
    }

}

$query = ' SELECT * FROM sesion_1 WHERE id_estudiante=?';
$stmt = $dbh->prepare($query);
$stmt->execute([$id_estudiante]);
$est = $stmt->fetch(PDO::FETCH_ASSOC);

$query = ' SELECT * FROM estudiantes WHERE id=?';
$stmt = $dbh->prepare($query);
$stmt->execute([$id_estudiante]);
$info= $stmt->fetch(PDO::FETCH_ASSOC);

$total_verbal_estudiantes = $suma_v_todos / count($rows);
$total_matematica_estudiantes = $suma_m_todos / count($rows);

$total_verbal_grupo = $suma_v_grupo / count($grupo);
$total_matematica_grupo = $suma_m_grupo / count($grupo);


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
<body>
<div class="container">
<div class="img-header">
<img src="uploads/informe header.png" >
</div>
<br>
<div class="titulo"><h2>INFORME DE ORIENTACIÓN SOCIO OCUPACIONAL - SESIÓN 1</h2></div>
<div class="info">
<h3 style="text-align:center">Datos del participante</h3>
<?php
    echo '<p> Nombre: '.$info['nombre'].'<br>';
    echo ' Edad: '.$info['edad'].'</p>';
?>
</div>
<div class="totales">
<?php
    echo '<h5> Total Aptitud Verbal: '.$est['total_aptitud_verbal'].'</h5>';
    echo '<h5> Total Aptitud Matemática: '.$est['total_aptitud_matematica'].'</h5>';
?>
</div>
<div class="chart">
<canvas id="myChart" class="chartjs"></canvas>
</div>
<script>
new Chart(document.getElementById("myChart"),{"type":"bar","data":{"labels":["Verbal","Matematico"],"datasets":[
    {"label":"Todos los estudiantes","data":[<?php echo $total_verbal_estudiantes.','.$total_matematica_estudiantes?>],"fill":false,"backgroundColor":["rgba(255, 99, 132, 0.2)","rgba(255, 99, 132, 0.2)"],"borderColor":["rgb(255, 99, 132)","rgb(255, 99, 132)"],"borderWidth":1},
    {"label":"Tu grupo","data":[<?php echo $total_verbal_grupo.','.$total_matematica_grupo?>],"fill":false,"backgroundColor":["rgba(20, 255, 20, 0.2)","rgba(20, 255, 20, 0.2)"],"borderColor":["rgb(20, 255, 20)","rgb(20, 255, 20)"],"borderWidth":1},
    {"label":"Tu","data":[<?php echo $est['total_aptitud_verbal'].','.$est['total_aptitud_matematica']?>],"fill":false,"backgroundColor":["rgba(20, 20, 255, 0.2)","rgba(20, 20, 255, 0.2)"],"borderColor":["rgb(20, 20, 255)","rgb(20, 20, 255)"],"borderWidth":1},
    ]},
    "options":{ 
        responsive:true,
        maintainAspectRatio: false,
        "scales":{"yAxes":[{"ticks":{"beginAtZero":true}}]}}});
</script>
<div class="informe_via">
<?php
    echo '<h5> Informe valores, intereses y aptitudes:</h5>';
    echo '<p> '.$est['informe_via'].'</p>';
?>
</div>

</div>
</body>
