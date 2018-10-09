<?php

  include_once("header.php");



  if( isset($_POST['student']) )
  {
    $sql = 'SELECT * FROM estudiantes WHERE id = '.$_POST['student'].'';
    foreach ($dbh->query($sql) as $row) {
        print "ID = ".$row['id'] . "<br/>";
        print "Nombre = ".$row['nombre'] . "<br/>";
        print "Documento =".$row['documento'] . "<br/>";
    }
  }
  elseif( isset($_POST['psicologo']) )
  {
    $sql = 'SELECT * FROM psicologos WHERE id = '.$_POST['psicologo'].'';
    foreach ($dbh->query($sql) as $row) {
        print "ID = ".$row['id'] . "<br/>";
        print "Nombre = ".$row['nombre'] . "<br/>";
        print "Correo =".$row['correo'] . "<br/>";
    }
  }


  elseif( isset($_POST['co_tallerista']) )
  {
    $sql = 'SELECT * FROM `co-talleristas` WHERE id = '.$_POST['co_tallerista'].'';
    foreach ($dbh->query($sql) as $row) {
        print "ID = ".$row['id'] . "<br/>";
        print "Nombre = ".$row['nombre'] . "<br/>";
        print "Correo =".$row['correo'] . "<br/>";
    }
  }

  elseif( isset($_POST['create_student']) )
  {
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
  }
  elseif (isset($_POST['newStudent'])) {

    $nombre = $_POST['nombre'];
    $documento = $_POST['documento'];
    $edad = $_POST['edad'];
    $grado = $_POST['grado'];
    $colegio =  $_POST['colegio'];
    echo "<h1>CREANDO ESTUDIANTE $nombre </h1>";

    $sql = "INSERT INTO estudiantes(nombre, grado, edad, documento, colegio) VALUES (\"$nombre\", \"$grado\",$edad,\"$documento\",\"$colegio\")";
    $return = $dbh->exec($sql);

    ?>
    <a href="director.php" class="w3-btn w3-black">Regresar al menu</a>
    <?php

  }

  elseif( isset($_POST['create_psicologo']) )
  {
    ?>
    <h1>Crear Psicologo</h1>
    <form class="" action="report.php" method="post">
      <input type="hidden" name="newPsicologo" value="">
      Nombre: <input type="text" name="nombre" value="">
      Correo: <input type="text" name="correo" value="">
      <input type="submit" name="" value="crear psicologo">
    </form>

    <?php
  }

  elseif (isset($_POST['newPsicologo'])) {

    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    echo "<h1>CREANDO PSICOLOGO $nombre </h1>";

    $sql = "INSERT INTO `psicologos`(`nombre`, `correo`) VALUES ( \" $nombre\",\"$correo\")";
    $return = $dbh->exec($sql);

    ?>
    <a href="director.php" class="w3-btn w3-black">Regresar al menu</a>
    <?php

  }

  elseif( isset($_POST['create_co-tallerista']) )
  {
    ?>
    <h1>Crear Co-tallerista</h1>
    <form class="" action="report.php" method="post">
      <input type="hidden" name="newCoTallerista" value="">
      Nombre: <input type="text" name="nombre" value="">
      Correo: <input type="text" name="correo" value="">
      <input type="submits" name="" value="Crear co-tallerista">
    </form>

    <?php
  }

  elseif (isset($_POST['newCoTallerista'])) {

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
