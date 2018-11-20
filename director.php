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
    <title>Proyecto Psicologia</title>
<style>
<?php include('styles/Index.css'); ?>
</style>

<style media="screen">

table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}

.titles {
  margin-top: 50px;

}

input{
  float: right;
}

.creation{
  float: left;
}

.new_element{
  display: none;
}

</style>
</head>
<section class="parent">
    <div class="child">
    <h2>Director</h2>
    <!--<a href="pruebas.php">Crear prueba</a>-->
    </div>
</section>


<?php

$arrayName = array();


?>

<?php
/*
<h3 class="titles">Estudiantes</h3>


<table>
  <tr>
    <th>Nombre</th>
    <th>Identificacion</th>
    <th>grado</th>
    <th>edad</th>
    <th>Institución</th>
  </tr>




  // set the resulting array to associative
$sql = 'SELECT * FROM estudiantes';
foreach ($dbh->query($sql) as $row) {
  $q = 'SELECT * FROM grupo WHERE id=?';
  $stmt = $dbh->prepare($q);
  $stmt->execute([$row['grupo_id']]);
  $ins = $stmt->fetch();
  echo '
            <tr>
              <form class="" action="report.php" method="post">
                <input type="hidden" name="student" value="' . $row['id'] . '">
                <th>' . $row['nombre'] . '</th>
                <th>' . $row['documento'] . '</th>
                <th>' . $row['grado'] . '</th>
                <th>' . $row['edad'] . '</th>
                <th>' . $ins['nombre'] . '</th>
              </form>
            </tr>
          ';

//<th><input type="submit" name="ver estduiante" value="Ver Estudiante"></th>
        }*/

        /*</table>
<form class="" action="report.php" method="post">
  <input type="submit" class="creation" name="create_student" value="Crear estudiante">
</form>


<hr>*/
?>

<h2><a href="informe_global.php">RESULTADOS</a></h2>
<form action="export_excel.php" method="post">
 <button type="submit" id="export_data" name='export_data'
value="Export to excel" class="btn btn-info">Exportar a Excel</button>
 </form>

<h3 class="titles">Psicologos</h3>

<table>

    <tr>
      <th><a  > Nombre </a></th>
      <th>Correo</th>
    </tr>

<?php
  // set the resulting array to associative
$sql = 'SELECT * FROM psicologos';

foreach ($dbh->query($sql) as $row) {
  echo '
            <tr>
              <form class="" action="report.php" method="post">
                <input type="hidden" name="psicologo" value="' . $row['id'] . '">
                <th>' . $row['nombre'] . '</th>
                <th>' . $row['correo'] . '
              </form>
            </tr>
          ';
}

?>
</table>
<!--<form class="" action="report.php" method="post">
  <input type="submit" class="creation" name="create_psicologo" value="Crear psicologo">
</form>-->

<hr>
<h3 class="titles">co-talleristas</h3>



<table>
  <tr>
    <th>Nombre</th>
    <th>Correo</th>
  </tr>

<?php
  // set the resulting array to associative
$sql = 'SELECT * FROM `co-talleristas`';

foreach ($dbh->query($sql) as $row) {

  echo '
            <tr>
              <form class="" action="report.php" method="post">
                <input type="hidden" name="co_tallerista" value="' . $row['id'] . '">
                <th>' . $row['nombre'] . '</th>
                <th>' . $row['correo'] . '
              </form>
            </tr>
          ';



}

?>
</table>
<!--<form class="" action="report.php" method="post">
  <input type="submit" class="creation" name="create_co-tallerista" value="Crear co-tallerista">
</form>-->

<hr>
<h3 class="titles">Grupos</h3>

<table>
  <tr>
    <th>Nombre</th>
    <th>Psicologo</th>
    <th>Co-tallerista</th>
  </tr>

<?php
  // set the resulting array to associative
$sql = 'SELECT * FROM `grupo`';

foreach ($dbh->query($sql) as $row) {
  $q = 'SELECT * FROM psicologos WHERE id=?';
  $stmt = $dbh->prepare($q);
  $stmt->execute([$row['psicologo_id']]);
  $psicologo = $stmt->fetch();
  $q = 'SELECT * FROM `co-talleristas` WHERE id=?';
  $stmt = $dbh->prepare($q);
  $stmt->execute([$row["co-tallerista_id"]]);
  $co_tallerista = $stmt->fetch();

  echo '
            <tr>
              <form class="" action="report.php" method="post">
                <input type="hidden" name="institucion_id" value="' . $row['id'] . '">
                <input type="hidden" name="institucion_nombre" value="' . $row['nombre'] . '">
                <th>' . $row['nombre'] . '</th>
                <th>' . $psicologo['nombre'] . '</th>
                <th>' . $co_tallerista['nombre'] . '</th>
                <th><input type="submit" name="ver estduiante" value="Ver Estudiantes"></th>
              </form>
            </tr>
          ';



}

?>
</table>
<hr>
<?php
function showGrupos($dbh)
{
  $query1 = 'SELECT * FROM `grupo`;';
  $stmt = $dbh->prepare($query1);
  $stmt->execute();
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
  foreach ($rows as $r) {
    echo '
            <form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">
            <input type="hidden" name="name" value="' . $r['nombre'] . '" />
            <input type="hidden" name="id" value="' . $r['id'] . '" />
                <button type="submit" name="nombre" class="estudiante">
                    <p><b>Institucion:</b> ' . $r['nombre'] . '</br>
                </button>
            </form>';

  }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $_SESSION['grupo_id'] = $_POST['id'];
        echo '<h3>Institucion: ' . $_POST['name'] . '</h3>';
        echo '<a href="sesion1.php"><h5>SESIÓN 1</h5></a>';
        echo '<a href="sesion2.php"><h5>SESIÓN 2</h5></a>';
        echo '<a href="sesion3.php"><h5>SESIÓN 3</h5></a>';
        echo '<a href="sesion4.php"><h5>SESIÓN 4</h5></a>';
        echo '<a href="sesion5.php"><h5>SESIÓN 5</h5></a>';
        echo '<a href="sesion6.php"><h5>SESIÓN 6</h5></a>';
        echo '<a href="sesion7.php"><h5>SESIÓN 7</h5></a>';
        echo '<a href="sesion8.php"><h5>SESIÓN 8</h5></a>';
    } else {
        echo '<h3>Instituciones:</h3>';
        showGrupos($dbh);
    }
?>
<?php
include_once("footer.php");
?>