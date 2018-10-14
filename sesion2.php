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
</head>

<body>
  <?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {

      if (isset($_POST['id_ses'])) {
          $query = 'UPDATE `sesion_2` SET';

          $query .= '`informe_pn' . '`="' . $_POST["informe_pn"] . '",';
          $query .= '`informe_mrb' . '`="' . $_POST["informe_mrb"] . '",';

          for ($i = 0; $i < 8; $i++) {
            $I = $i+1;
            $query .= '`factor_tncf_' . $I . '`= ' . $_POST["factor_tncf_$I"] . ',';
          }

          for ($i = 0; $i < 4; $i++) {
            $I = $i+1;
            $query .= '`factor_paf_' . $I . '`=' . $_POST["factor_paf_$I"] . ',';
          }

          for ($i = 0; $i < 5; $i++) {
            $I = $i+1;
            $query .= '`factor_icppf_' . $I . '`=' . $_POST["factor_icppf_$I"] . ',';
          }

          for ($i = 0; $i < 4; $i++) {
            $I = $i+1;
            $query .= '`factor_tivf_' . $I . '`=' . $_POST["factor_tivf_$I"] . ',';
          }

          $query .= '`total_factor_tncf' . '`=' . $_POST["factor_tivf_$I"] . ',';
          $query .= '`total_factor_paf' . '`=' . $_POST["factor_tivf_$I"] . ',';
          $query .= '`total_factor_icppf'  . '`=' . $_POST["factor_tivf_$I"] . ',';
          $query .= '`total_factor_tivf' . '`=' . $_POST["factor_tivf_$I"] . ',';

          for ($i = 0; $i < 2; $i++) {
            $I = $i+1;
            $query .= '`eet_economico_' . $I . '`=' . $_POST["eet_economico_$I"] . ',';
          }

          for ($i = 0; $i < 3; $i++) {
            $I = $i+1;
            $query .= '`eet_laboral_' . $I . '`=' . $_POST["eet_laboral_$I"] . ',';
          }

          for ($i = 0; $i < 3; $i++) {
            $I = $i+1;
            $query .= '`eet_familiar_' . $I . '`=' . $_POST["eet_familiar_$I"] . ',';
          }
          for ($i = 0; $i < 2; $i++) {
            $I = $i+1;
            $query .= '`eet_vida_' . $I . '`=' . $_POST["eet_vida_$I"] . ',';
          }
          for ($i = 0; $i < 3; $i++) {
            $I = $i+1;
            $query .= '`eet_academico_' . $I . '`=' . $_POST["eet_academico_$I"] . ',';
          }

          $query .= '`total_eet_economico' . '`=' . $_POST["total_eet_economico"] . ',';
          $query .= '`total_eet_laboral'  . '`=' . $_POST["total_eet_laboral"] . ',';
          $query .= '`total_eet_familiar'  . '`=' . $_POST["total_eet_familiar"] . ',';
          $query .= '`total_eet_vida' . '`=' . $_POST["total_eet_vida"] . ',';
          $query .= '`total_eet_academico'  . '`=' . $_POST["total_eet_academico"] . '';
          $query .= ' WHERE id_estudiante=' . $_POST['id_ses'] . ' ';


          //We start our transaction.
          #echo $query;
          $dbh->beginTransaction();

          try {
              $stmt = $dbh->prepare($query);
              $stmt->execute();
              $dbh->commit();
              echo '<script language="javascript">';
              echo 'alert("Guardado correctamente")';
              echo '</script>';
              echo '<script language="javascript">window.location="sesion2.php"</script>';

          } catch (Exception $e) {
              $dbh->rollBack();
              if (strpos($e->getMessage(), 'Incorrect integer value')) {
                  echo '<script language="javascript">';
                  echo 'alert("ERROR: el total debe ser un número")';
                  echo '</script>';
                  echo '<script language="javascript">window.location="sesion1.php"</script>';
              }/*else{
                  echo '<script language="javascript">';
                  echo 'alert("'.$e->getMessage().'")';
                  echo '</script>';
                  echo '<script language="javascript">window.location="sesion1.php"</script>';
              }*/
              if (strpos($e->getMessage(), ' Data too long for column')) {
                  echo '<script language="javascript">';
                  echo 'alert("ERROR: debe ser unicamente un caracter")';
                  echo '</script>';
                  echo '<script language="javascript">window.location="sesion1.php"</script>';
              }
          }
      } else {

          $query = 'INSERT INTO `sesion_2`(`id_estudiante`, `informe_pn`, `informe_mrb`, `factor_tncf_1`, `factor_tncf_2`, `factor_tncf_3`, `factor_tncf_4`, `factor_tncf_5`, `factor_tncf_6`, `factor_tncf_7`, `factor_tncf_8`, `factor_paf_1`, `factor_paf_2`, `factor_paf_3`, `factor_paf_4`, `factor_icppf_1`, `factor_icppf_2`, `factor_icppf_3`, `factor_icppf_4`, `factor_icppf_5`, `factor_tivf_1`, `factor_tivf_2`, `factor_tivf_3`, `factor_tivf_4`, `total_factor_tncf`, `total_factor_paf`, `total_factor_icppf`, `total_factor_tivf`, `eet_economico_1`, `eet_economico_2`, `eet_laboral_1`, `eet_laboral_2`, `eet_laboral_3`, `eet_familiar_1`, `eet_familiar_2`, `eet_familiar_3`, `eet_vida_1`, `eet_vida_2`, `eet_academico_1`, `eet_academico_2`, `eet_academico_3`, `total_eet_economico`, `total_eet_laboral`, `total_eet_familiar`, `total_eet_vida`, `total_eet_academico`) VALUES (';
          $query .= $_POST["id"] . ',';

          $query .= '"' . $_POST["informe_pn"] . '",';
          $query .= '"' . $_POST["informe_mrb"] . '",';

          for ($i = 0; $i < 8; $i++) {
            $I = $i+1;
            $query .=  $_POST["factor_tncf_$I"] . ',';
          }

          for ($i = 0; $i < 4; $i++) {
            $I = $i+1;
            $query .=  $_POST["factor_paf_$I"] . ',';
          }

          for ($i = 0; $i < 5; $i++) {
            $I = $i+1;
            $query .=  $_POST["factor_icppf_$I"] . ',';
          }

          for ($i = 0; $i < 4; $i++) {
            $I = $i+1;
            $query .=  $_POST["factor_tivf_$I"] . ',';
          }

          $query .=  $_POST["factor_tivf_$I"] . ',';
          $query .=  $_POST["factor_tivf_$I"] . ',';
          $query .=  $_POST["factor_tivf_$I"] . ',';
          $query .=  $_POST["factor_tivf_$I"] . ',';

          for ($i = 0; $i < 2; $i++) {
            $I = $i+1;
            $query .= $_POST["eet_economico_$I"] . ',';
          }

          for ($i = 0; $i < 3; $i++) {
            $I = $i+1;
            $query .=  $_POST["eet_laboral_$I"] . ',';
          }

          for ($i = 0; $i < 3; $i++) {
            $I = $i+1;
            $query .= $_POST["eet_familiar_$I"] . ',';
          }
          for ($i = 0; $i < 2; $i++) {
            $I = $i+1;
            $query .= $_POST["eet_vida_$I"] . ',';
          }

          for ($i = 0; $i < 3; $i++) {
            $I = $i+1;
            $query .= $_POST["eet_academico_$I"] . ',';
          }

          $query .=  $_POST["total_eet_economico"] . ',';
          $query .=  $_POST["total_eet_laboral"] . ',';
          $query .=  $_POST["total_eet_familiar"] . ',';
          $query .=  $_POST["total_eet_vida"] . ',';
          $query .=  $_POST["total_eet_academico"] . ')';


          echo $query;
          //We start our transaction.
          $dbh->beginTransaction();

          try {
              $stmt = $dbh->prepare($query);
              $stmt->execute();
              $dbh->commit();
              echo '<script language="javascript">';
              echo 'alert("Guardado correctamente")';
              echo '</script>';
              echo '<script language="javascript">window.location="sesion2.php"</script>';

          } catch (Exception $e) {
              $dbh->rollBack();
              if (strpos($e->getMessage(), 'Incorrect integer value')) {
                  echo '<script language="javascript">';
                  echo 'alert("ERROR: el total debe ser un número")';
                  echo '</script>';
                  echo '<script language="javascript">window.location="sesion1.php"</script>';
              }/*else{
                  echo '<script language="javascript">';
                  echo 'alert("'.$e->getMessage().'")';
                  echo '</script>';
                  echo '<script language="javascript">window.location="sesion1.php"</script>';
              }*/
              if (strpos($e->getMessage(), ' Data too long for column')) {
                  echo '<script language="javascript">';
                  echo 'alert("ERROR: debe ser unicamente un caracter")';
                  echo '</script>';
                  echo '<script language="javascript">window.location="sesion1.php"</script>';
              }
          }
      }

  } else { ?>




    <div class="flow-container">
    <table class="tb">
    <tr>
    <th>Nombre</th>
    <th>INFORME PN</th>
    <th>INFORME MRB</th>
    <th>factor tncf 1 </th>
    <th>factor tncf 2 </th>
    <th>factor tncf 3 </th>
    <th>factor tncf 4 </th>
    <th>factor tncf 5 </th>
    <th>factor tncf 6 </th>
    <th>factor tncf 7 </th>
    <th>factor tncf 8 </th>
    <th>factor paf 1 </th>
    <th>factor paf 2 </th>
    <th>factor paf 3 </th>
    <th>factor paf 4 </th>
    <th>factor icppf 1 </th>
    <th>factor icppf 2 </th>
    <th>factor icppf 3 </th>
    <th>factor icppf 4 </th>
    <th>factor icppf 5 </th>
    <th>factor tivf 1 </th>
    <th>factor tivf 2 </th>
    <th>factor tivf 3 </th>
    <th>factor tivf 4 </th>
    <th>total factor tncf </th>
    <th>total factor paf </th>
    <th> total factor icppf</th>
    <th> total factor tivf</th>
    <th>eet economico 1 </th>
    <th>eet economico 2 </th>
    <th>eet laboral 1 </th>
    <th>eet laboral 2 </th>
    <th>eet laboral 3 </th>
    <th>eet familiar 1 </th>
    <th>eet familiar 2 </th>
    <th>eet familiar 3 </th>
    <th>eet vida 1 </th>
    <th>eet vida 2 </th>
    <th>eet academico 1 </th>
    <th>eet academico 2 </th>
    <th>eet academico 3 </th>
    <th>total eet economico </th>
    <th>total eet laboral </th>
    <th>total eet familiar </th>
    <th>total eet vida </th>
    <th>total eet academico </th>


    <th>GUARDAR</th>
    </tr>
    <?php
    $query = ' SELECT * FROM estudiantes WHERE grupo_id = ? ';
    $stmt = $dbh->prepare($query);
    $stmt->execute([$_SESSION['grupo_id']]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows as $row) {
        $id = $row['id'];
        $query = ' SELECT * FROM sesion_2 WHERE id_estudiante = ? ';
        $stmt = $dbh->prepare($query);
        $stmt->execute([$id]);
        $s = $stmt->fetch(PDO::FETCH_ASSOC);
        echo ' <tr>
                <th> ' . $row['nombre'] . ' </th> ';

        //si no esta creado se crean los espacios
        if (!isset($s['id_estudiante'])) {
            echo ' <form method = "post" action = "' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">';

              echo '<td><input class="inf" type="text" name="informe_pn" value="" /></td>';
              echo '<td><input class="inf" type="text" name="informe_mrb" value="" /></td>';


              $factor_tncf = [NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL];

              for ($i = 0; $i < 8; $i++) {
                  //echo '<td><input class="in" type="text" name="factor_tncf_' . ($i + 1) . '" value="" /></td>';
                  ?>

                  <td>
                    <?php echo '<input type="radio" name= "'."factor_tncf_" . ($i + 1) . '"' ;  ?>  <?php if (isset($factor_tncf[$i]) && $factor_tncf[$i]=="0") echo "checked";?> value="0">Si
                    <?php echo '<input type="radio" name= "'."factor_tncf_" . ($i + 1) . '"' ;  ?>  <?php if (isset($factor_tncf[$i]) && $factor_tncf[$i]=="1") echo "checked";?> value="1">No
                  </td>
                  <?php

              }

              $factor_paf = [NULL,NULL,NULL,NULL];
              for ($i = 0; $i < 4; $i++) {
                  //echo '<td><input class="in" type="text" name="factor_paf_' . ($i + 1) . '" value="" /></td>';
                  ?>
                  <td>
                    <?php echo '<input type="radio" name= "'."factor_paf_" . ($i + 1) . '"';  ?>  <?php if (isset($factor_paf[$i]) && $factor_paf[$i] == "1") echo "checked";?> value="1">Si
                    <?php echo '<input type="radio" name= "'."factor_paf_" . ($i + 1) . '"';  ?>  <?php if (isset($factor_paf[$i]) && $factor_paf[$i] == "0") echo "checked";?> value="0">No
                  </td>
                  <?php


              }

              $factor_icppf = [NULL,NULL,NULL,NULL,NULL];
              for ($i = 0; $i < 5; $i++) {
                  //echo '<td><input class="in" type="text" name="factor_icppf_' . ($i + 1) . '" value="" /></td>';

                  ?>
                  <td>
                    <?php echo '<input type="radio" name= "'."factor_icppf_" . ($i + 1) . '"';  ?>  <?php if ( isset($factor_icppf[$i]) && $factor_icppf[$i] =="1") echo "checked";?> value="1">Si
                    <?php echo '<input type="radio" name= "'."factor_icppf_" . ($i + 1) . '"';  ?>  <?php if ( isset($factor_icppf[$i]) && $factor_icppf[$i] =="0") echo "checked";?> value="0">No
                  </td>
                  <?php

              }
              $factor_tivf = [NULL,NULL,NULL,NULL];
              for ($i = 0; $i < 4; $i++) {
                  //echo '<td><input class="in" type="text" name="factor_tivf_' . ($i + 1) . '" value="" /></td>';
                  ?>
                  <td>
                    <?php echo '<input type="radio" name= "'."factor_tivf_" . ($i + 1) . '"';  ?>  <?php if (isset($factor_tivf[$i]) && $factor_tivf[$i] =="1") echo "checked";?> value="1">Si
                    <?php echo '<input type="radio" name= "'."factor_tivf_" . ($i + 1) . '"';  ?>  <?php if (isset($factor_tivf[$i]) && $factor_tivf[$i] =="0") echo "checked";?> value="0">No
                  </td>
                  <?php

              }

              echo '<td><input class="in" type="text" name="total_factor_tncf " value="0" /></td>';
              echo '<td><input class="in" type="text" name="total_factor_paf" value="0" /></td>';
              echo '<td><input class="in" type="text" name="total_factor_icppf" value="0" /></td>';
              echo '<td><input class="in" type="text" name="total_factor_tivf" value="0" /></td>';

              $eet_economico = [NULL,NULL];
              for ($i = 0; $i < 2; $i++) {
                  //echo '<td><input class="in" type="text" name="eet_econnomico_' . ($i + 1) . '" value="" /></td>';

                  ?>
                  <td>
                    <?php echo '<input type="radio" name= "'."eet_economico_" . ($i + 1) . '"';  ?>  <?php if (isset($eet_econnomico[$i]) && $eet_econnomico[$i] =="1") echo "checked";?> value="1">Si
                    <?php echo '<input type="radio" name= "'."eet_economico_" . ($i + 1) . '"';  ?>  <?php if (isset($eet_econnomico[$i]) && $eet_econnomico[$i] =="0") echo "checked";?> value="0">No
                  </td>
                  <?php
              }

              $eet_laboral = [NULL,NULL,NULL];
              for ($i = 0; $i < 3; $i++) {
                  //echo '<td><input class="in" type="text" name="eet_laboral_' . ($i + 1) . '" value="" /></td>';
                  ?>
                  <td>
                    <?php echo '<input type="radio" name= "'."eet_laboral_" . ($i + 1) . '"';  ?>  <?php if (isset($eet_laboral[$i]) && $eet_laboral[$i] =="1") echo "checked";?> value="1">Si
                    <?php echo '<input type="radio" name= "'."eet_laboral_" . ($i + 1) . '"';  ?>  <?php if (isset($eet_laboral[$i]) && $eet_laboral[$i] =="0") echo "checked";?> value="0">No
                  </td>
                  <?php
              }

              $eet_familiar = [NULL,NULL,NULL];
              for ($i = 0; $i < 3; $i++) {
                  //echo '<td><input class="in" type="text" name="eet_familiar_' . ($i + 1) . '" value="" /></td>';
                  ?>
                  <td>
                    <?php echo '<input type="radio" name= "'."eet_familiar_" . ($i + 1) . '"';  ?>  <?php if (isset($eet_familiar[$i]) && $eet_familiar[$i] =="1") echo "checked";?> value="1">Si
                    <?php echo '<input type="radio" name= "'."eet_familiar_" . ($i + 1) . '"';  ?>  <?php if (isset($eet_familiar[$i]) && $eet_familiar[$i] =="0") echo "checked";?> value="0">No
                  </td>
                  <?php
              }

              $eet_vida = [NULL,NULL];
              for ($i = 0; $i < 2; $i++) {
                  //echo '<td><input class="in" type="text" name="eet_vida_' . ($i + 1) . '" value="" /></td>';
                  ?>
                  <td>
                    <?php echo '<input type="radio" name= "'."eet_vida_" . ($i + 1) . '"';  ?>  <?php if (isset($eet_vida[$i]) && $eet_vida[$i] =="1") echo "checked";?> value="1">Si
                    <?php echo '<input type="radio" name= "'."eet_vida_" . ($i + 1) . '"';  ?>  <?php if (isset($eet_vida[$i]) && $eet_vida[$i] =="0") echo "checked";?> value="0">No
                  </td>
                  <?php
              }

              $eet_academico = [NULL,NULL,NULL];
              for ($i = 0; $i < 3; $i++) {
                  //echo '<td><input class="in" type="text" name="eet_academico_' . ($i + 1) . '" value="" /></td>';
                  ?>
                  <td>
                    <?php echo '<input type="radio" name= "'. "eet_academico_" . ($i + 1) . '"';  ?>  <?php if (isset($eet_academico[$i]) && $eet_academico[$i] =="1") echo "checked";?> value="1">Si
                    <?php echo '<input type="radio" name= "'."eet_academico_" . ($i + 1) . '"';  ?>  <?php if (isset($eet_academico[$i]) && $eet_academico[$i] =="0") echo "checked";?> value="0">No
                  </td>
                  <?php
              }

              echo '<td><input class="in" type="text" name="total_eet_economico" value="0" /></td>';
              echo '<td><input class="in" type="text" name="total_eet_laboral" value="0" /></td>';
              echo '<td><input class="in" type="text" name="total_eet_familiar" value="0" /></td>';
              echo '<td><input class="in" type="text" name="total_eet_vida" value="0" /></td>';
              echo '<td><input class="in" type="text" name="total_eet_academico" value="0" /></td>';


              echo '<input type="hidden" name="name" value="' . $row['nombre'] . '" />';
              echo '<input type="hidden" name="id" value="' . $row['id'] . '" />';
              echo '<td><input type="submit" value="Enviar"/></td>';

            echo '</form>';

        } else { //si esta creado los espacios se llenan con los correspondientes elementos que ya estan en la base de datos
          /*
          */
            echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">';

              echo '<td><input class="inf" type="text" name="informe_pn" value="'.$s["informe_pn"].'" /></td>';
              echo '<td><input class="inf" type="text" name="informe_mrb" value="'.$s["informe_mrb"].'" /></td>';


              $factor_tncf = [NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL];

              for ($i = 0; $i < 8; $i++) {
                  //echo '<td><input class="in" type="text" name="factor_tncf_' . ($i + 1) . '" value="" /></td>';
                  $I = $i+1;
                  $factor_tncf[$i]= $s["factor_tncf_$I"];
                  ?>
                  <td>

                    <?php echo '<input type="radio" name= "'."factor_tncf_".$I. '"' ;  ?>  <?php if (isset($factor_tncf[$i]) && $factor_tncf[$i]=="0") echo "checked";?> value="0">Si
                    <?php echo '<input type="radio" name= "'."factor_tncf_".$I. '"' ;  ?>  <?php if (isset($factor_tncf[$i]) && $factor_tncf[$i]=="1") echo "checked";?> value="1">No
                  </td>
                  <?php

              }

              $factor_paf = [NULL,NULL,NULL,NULL];
              for ($i = 0; $i < 4; $i++) {
                  //echo '<td><input class="in" type="text" name="factor_paf_' . ($i + 1) . '" value="" /></td>';
                  $I = $i+1;
                  $factor_paf[$i]= $s["factor_paf_$I"];


                  ?>
                  <td>
                    <?php echo '<input type="radio" name= "'."factor_paf_" . ($i + 1) . '"';  ?>  <?php if (isset($factor_paf[$i]) && $factor_paf[$i] == "1") echo "checked";?> value="1">Si
                    <?php echo '<input type="radio" name= "'."factor_paf_" . ($i + 1) . '"';  ?>  <?php if (isset($factor_paf[$i]) && $factor_paf[$i] == "0") echo "checked";?> value="0">No
                  </td>
                  <?php

              }
              $factor_icppf = [NULL,NULL,NULL,NULL,NULL];
              for ($i = 0; $i < 5; $i++) {
                  //echo '<td><input class="in" type="text" name="factor_icppf_' . ($i + 1) . '" value="" /></td>';
                  $I = $i+1;
                  $factor_icppf[$i]= $s["factor_icppf_$I"];
                  ?>
                  <td>
                    <?php echo '<input type="radio" name= "'."factor_icppf_" . ($i + 1) . '"';  ?>  <?php if ( isset($factor_icppf[$i]) && $factor_icppf[$i] =="1") echo "checked";?> value="1">Si
                    <?php echo '<input type="radio" name= "'."factor_icppf_" . ($i + 1) . '"';  ?>  <?php if ( isset($factor_icppf[$i]) && $factor_icppf[$i] =="0") echo "checked";?> value="0">No
                  </td>
                  <?php

              }
              $factor_tivf = [NULL,NULL,NULL,NULL];
              for ($i = 0; $i < 4; $i++) {
                  //echo '<td><input class="in" type="text" name="factor_tivf_' . ($i + 1) . '" value="" /></td>';
                  $I = $i+1;
                  $factor_tivf[$i]= $s["factor_tivf_$I"];

                  ?>
                  <td>
                    <?php echo '<input type="radio" name= "'."factor_tivf_" . ($i + 1) . '"';  ?>  <?php if (isset($factor_tivf[$i]) && $factor_tivf[$i] =="1") echo "checked";?> value="1">Si
                    <?php echo '<input type="radio" name= "'."factor_tivf_" . ($i + 1) . '"';  ?>  <?php if (isset($factor_tivf[$i]) && $factor_tivf[$i] =="0") echo "checked";?> value="0">No
                  </td>
                  <?php

              }

              echo '<td><input class="in" type="text" name="total_factor_tncf " value="'.$s["total_factor_tncf"].'" /></td>';
              echo '<td><input class="in" type="text" name="total_factor_paf"   value="'.$s["total_factor_paf"].'" /></td>';
              echo '<td><input class="in" type="text" name="total_factor_icppf" value="'.$s["total_factor_icppf"].'" /></td>';
              echo '<td><input class="in" type="text" name="total_factor_tivf"  value="'.$s["total_factor_tivf"].'" /></td>';

              $eet_economico = [NULL,NULL];
              for ($i = 0; $i < 2; $i++) {
                  //echo '<td><input class="in" type="text" name="eet_econnomico_' . ($i + 1) . '" value="" /></td>';
                  $I = $i+1;
                  $eet_economico[$i]= $s["eet_economico_$I"];
                  ?>
                  <td>
                    <?php echo '<input type="radio" name= "'."eet_economico_" . ($i + 1) . '"';  ?>  <?php if (isset($eet_economico[$i]) && $eet_economico[$i] =="1") echo "checked";?> value="1">Si
                    <?php echo '<input type="radio" name= "'."eet_economico_" . ($i + 1) . '"';  ?>  <?php if (isset($eet_economico[$i]) && $eet_economico[$i] =="0") echo "checked";?> value="0">No
                  </td>
                  <?php
              }

              $eet_laboral = [NULL,NULL,NULL];
              for ($i = 0; $i < 3; $i++) {
                  //echo '<td><input class="in" type="text" name="eet_laboral_' . ($i + 1) . '" value="" /></td>';
                  $I = $i+1;
                  $eet_laboral[$i]= $s["eet_laboral_$I"];
                  ?>
                  <td>
                    <?php echo '<input type="radio" name= "'."eet_laboral_" . ($i + 1) . '"';  ?>  <?php if (isset($eet_laboral[$i]) && $eet_laboral[$i] =="1") echo "checked";?> value="1">Si
                    <?php echo '<input type="radio" name= "'."eet_laboral_" . ($i + 1) . '"';  ?>  <?php if (isset($eet_laboral[$i]) && $eet_laboral[$i] =="0") echo "checked";?> value="0">No
                  </td>
                  <?php
              }

              $eet_familiar = [NULL,NULL,NULL];
              for ($i = 0; $i < 3; $i++) {
                  //echo '<td><input class="in" type="text" name="eet_familiar_' . ($i + 1) . '" value="" /></td>';
                  $I = $i+1;
                  $eet_familiar[$i]= $s["eet_familiar_$I"];
                  ?>
                  <td>
                    <?php echo '<input type="radio" name= "'."eet_familiar_" . ($i + 1) . '"';  ?>  <?php if (isset($eet_familiar[$i]) && $eet_familiar[$i] =="1") echo "checked";?> value="1">Si
                    <?php echo '<input type="radio" name= "'."eet_familiar_" . ($i + 1) . '"';  ?>  <?php if (isset($eet_familiar[$i]) && $eet_familiar[$i] =="0") echo "checked";?> value="0">No
                  </td>
                  <?php
              }

              $eet_vida = [NULL,NULL];
              for ($i = 0; $i < 2; $i++) {
                  //echo '<td><input class="in" type="text" name="eet_vida_' . ($i + 1) . '" value="" /></td>';
                  $I = $i+1;
                  $eet_vida[$i]= $s["eet_vida_$I"];
                  ?>
                  <td>
                    <?php echo '<input type="radio" name= "'."eet_vida_" . ($i + 1) . '"';  ?>  <?php if (isset($eet_vida[$i]) && $eet_vida[$i] =="1") echo "checked";?> value="1">Si
                    <?php echo '<input type="radio" name= "'."eet_vida_" . ($i + 1) . '"';  ?>  <?php if (isset($eet_vida[$i]) && $eet_vida[$i] =="0") echo "checked";?> value="0">No
                  </td>
                  <?php
              }

              $eet_academico = [NULL,NULL,NULL];
              for ($i = 0; $i < 3; $i++) {
                  //echo '<td><input class="in" type="text" name="eet_academico_' . ($i + 1) . '" value="" /></td>';
                  $I = $i+1;
                  $eet_academico[$i]= $s["eet_academico_$I"];
                  ?>
                  <td>
                    <?php echo '<input type="radio" name= "'."eet_academico_" . ($i + 1) . '"';  ?>  <?php if (isset($eet_academico[$i]) && $eet_academico[$i] =="1") echo "checked";?> value="1">Si
                    <?php echo '<input type="radio" name= "'."eet_academico_" . ($i + 1) . '"';  ?>  <?php if (isset($eet_academico[$i]) && $eet_academico[$i] =="0") echo "checked";?> value="0">No
                  </td>
                  <?php
              }

              echo '<td><input class="in" type="text" name="total_eet_economico" value="'.$s["total_eet_economico"].'" /></td>';
              echo '<td><input class="in" type="text" name="total_eet_laboral"   value="'.$s["total_eet_laboral"].'" /></td>';
              echo '<td><input class="in" type="text" name="total_eet_familiar"  value="'.$s["total_eet_familiar"].'" /></td>';
              echo '<td><input class="in" type="text" name="total_eet_vida"      value="'.$s["total_eet_vida"].'" /></td>';
              echo '<td><input class="in" type="text" name="total_eet_academico" value="'.$s["total_eet_academico"].'" /></td>';


              echo '<input type="hidden" name="name" value="' . $row['nombre'] . '" />';
              echo '<input type="hidden" name="id" value="' . $row['id'] . '" />';
              echo '<input type="hidden" name="id_ses" value="' . $s['id_estudiante'] . '" />';
              echo '<td><input type="submit" value="Enviar"/></td>';

            echo '</form>';
        }
        echo '</tr>';
    }

    ?>
    </table>
    </form>
    </div>
</body>
<?php
}
include_once("footer.php");
?>