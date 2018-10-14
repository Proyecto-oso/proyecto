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
<?php
include_once("footer.php");
if (isset($_POST['institucion_id'])) {
  ?>
    <h3 class="titles">Estudiantes</h3>


<table>
  <tr>
    <th>Nombre</th>
    <th>Identificacion</th>
    <th>grado</th>
    <th>edad</th>
    <th>Institución</th>
  </tr>



<?php
  // set the resulting array to associative
$sql = 'SELECT * FROM estudiantes WHERE grupo_id =?';
$stmt = $dbh->prepare($sql);
$stmt->execute([$_POST['institucion_id']]);
$est = $stmt->fetchAll();
foreach ($est as $row) {
  echo '
            <tr>
              <form class="" action="report.php" method="post">
                <input type="hidden" name="student" value="' . $row['id'] . '">
                <th>' . $row['nombre'] . '</th>
                <th>' . $row['documento'] . '</th>
                <th>' . $row['grado'] . '</th>
                <th>' . $row['edad'] . '</th>
                <th>' . $_POST['institucion_nombre'] . '</th>
              </form>
            </tr>
          ';

//<th><input type="submit" name="ver estduiante" value="Ver Estudiante"></th>
}
} elseif (isset($_POST['psicologo'])) {
  $sql = 'SELECT * FROM psicologos WHERE id = ' . $_POST['psicologo'] . '';
  foreach ($dbh->query($sql) as $row) {
    print "ID = " . $row['id'] . "<br/>";
    print "Nombre = " . $row['nombre'] . "<br/>";
    print "Correo =" . $row['correo'] . "<br/>";
  }
} elseif (isset($_POST['co_tallerista'])) {
  $sql = 'SELECT * FROM `co-talleristas` WHERE id = ' . $_POST['co_tallerista'] . '';
  foreach ($dbh->query($sql) as $row) {
    print "ID = " . $row['id'] . "<br/>";
    print "Nombre = " . $row['nombre'] . "<br/>";
    print "Correo =" . $row['correo'] . "<br/>";
  }
} elseif (isset($_POST['create_student'])) {
  ?>
    <h1>Crear estudiante</h1>
    <form class="" action="report.php" method="post">
      <input type="hidden" name="newStudent" value="1">
      Nombre: <input type="text" name="nombre" value="">
      Documento: <input type="text" name="documento" value="">
      Edad: <input type="number" name="edad" value="">
      Grado: <input type="text" name="grado" value="">
      Colegio: <input type="text" name="colegio" value="">
      <input type="submit" name="" value="crear estudiante">
    </form>

    <?php

  } elseif (isset($_POST['newStudent'])) {

    $nombre = $_POST['nombre'];
    $documento = $_POST['documento'];
    $edad = $_POST['edad'];
    $grado = $_POST['grado'];
    $colegio = $_POST['colegio'];
    echo "<h1>CREANDO ESTUDIANTE $nombre </h1>";

    $sql = "INSERT INTO estudiantes(nombre, grado, edad, documento, colegio) VALUES (\"$nombre\", \"$grado\",$edad,\"$documento\",\"$colegio\")";
    $return = $dbh->exec($sql);

    ?>
    <a href="director.php" class="w3-btn w3-black">Regresar al menu</a>
    <?php

  } elseif (isset($_POST['create_psicologo'])) {
    ?>
    <h1>Crear Psicologo</h1>
    <form class="" action="report.php" method="post">
      <input type="hidden" name="newPsicologo" value="">
      Nombre: <input type="text" name="nombre" value="">
      Correo: <input type="text" name="correo" value="">
      <input type="submit" name="" value="crear psicologo">
    </form>

    <?php

  } elseif (isset($_POST['newPsicologo'])) {

    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    echo "<h1>CREANDO PSICOLOGO $nombre </h1>";

    $sql = "INSERT INTO `psicologos`(`nombre`, `correo`) VALUES ( \" $nombre\",\"$correo\")";
    $return = $dbh->exec($sql);

    ?>
    <a href="director.php" class="w3-btn w3-black">Regresar al menu</a>
    <?php

  } elseif (isset($_POST['create_co-tallerista'])) {
    ?>
    <h1>Crear Co-tallerista</h1>
    <form class="" action="report.php" method="post">
      <input type="hidden" name="newCoTallerista" value="">
      Nombre: <input type="text" name="nombre" value="">
      Correo: <input type="text" name="correo" value="">
      <input type="submits" name="" value="Crear co-tallerista">
    </form>

    <?php

  } elseif (isset($_POST['newCoTallerista'])) {

    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    echo "<h1>CREANDO CO-TALLERISTA $nombre </h1>";

    $sql = "INSERT INTO `co-talleristas` (`nombre`, `correo`) VALUES (\"$nombre\", \"$correo\")";
    $return = $dbh->exec($sql);
    ?>
    <a href="director.php" class="w3-btn w3-black">Regresar al menu</a>
    <?php

  }




  /*
  $sql = 'SELECT * FROM estudiantes JOIN  grupos';
  foreach ($dbh->query($sql) as $row) {
      print_r($row) ;
      echo "</br>";

  }

  // set the resulting array to associative
    $arrayName = array();
    $sql = 'SELECT * FROM estudiantes';
    foreach ($dbh->query($sql) as $row) {
        print $row['id'] . "\t";
        print $row['nombre'] . "\t";
        print $row['documento'] . "<br/>";
        array_push($arrayName, $row['nombre']);
    }


?>
  <select class="" name="">
    <?php
      $limit = 10;
      for ($i=0; $i < sizeof($arrayName); $i++) {
        ?>
        <option value=<?php echo '"'.$arrayName[$i].'"'; ?> > <?php echo $arrayName[$i]; ?></option>
      <?php
      }

    ?>
  </select>

<?php

   */
  ?>
