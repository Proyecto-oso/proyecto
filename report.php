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
    <form class="" action="index.html" method="post">
      Nombre: <input type="text" name="" value="">
      Documento: <input type="text" name="" value="">
    </form>

    <?php
  }

  elseif( isset($_POST['create_psicologo']) )
  {
    ?>
    <h1>Crear Psicologo</h1>
    <form class="" action="index.html" method="post">
      Nombre: <input type="text" name="" value="">
      Correo: <input type="text" name="" value="">
    </form>

    <?php
  }

  elseif( isset($_POST['create_co-tallerista']) )
  {
    ?>
    <h1>Crear Co-tallerista</h1>
    <form class="" action="index.html" method="post">
      Nombre: <input type="text" name="" value="">
      Correo: <input type="text" name="" value="">
    </form>

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
