<?php

  include_once("header.php");

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


?>
