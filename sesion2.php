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
    <link rel="stylesheet" type="text/css" href="styles/sesion2.css">
    <title>Proyecto Psicologia</title>
    <style>
/* Use overflow:scroll on your container to enable scrolling: */

.tb-container {
  max-width: 100%;
  max-height: 700px;
  overflow: scroll;
}


/* Use position: sticky to have it stick to the edge
 * and top, right, or left to choose which edge to stick to: */

thead th {
  position: sticky;
  top: 0;
}

tbody th {
  position: sticky;
  left: 0;
}


/* To have the header in the first column stick to the left: */

thead th:first-child {
  left: 0;
  z-index: 1;
}


/* Just to display it nicely: */

thead th {
    background-color: #4CAF50;
    color: white;
}

tbody th {
  background: #FFF;
  border-right: 1px solid #CCC;
}

table {
  border-collapse: collapse;
}

td,
th {
  padding: 0.5em;
}
</style>
</head>

<body>
  <?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['informe_grupo'])) {

      $originales = array("'", '"');
      $correctos = array("\'", '\"');
      $_POST['informe_mrb'] = str_replace($originales, $correctos, $_POST['informe_mrb']);

      $query = 'UPDATE `grupo` SET `informe_mrb` = "' . $_POST['informe_mrb'] . '" WHERE `grupo`.`id` = ' . $_SESSION['grupo_id'] . '; ';
      $dbh->beginTransaction();
      $stmt = $dbh->prepare($query);
      $stmt->execute();
      $dbh->commit();
      echo '<script language="javascript">';
      echo 'alert("Guardado correctamente")';
      echo '</script>';
      echo '<script language="javascript">window.location="sesion2.php"</script>';
    } elseif (isset($_POST['informe_grupo2'])) {

      $originales = array("'", '"');
      $correctos = array("\'", '\"');
      $_POST['informe_pn'] = str_replace($originales, $correctos, $_POST['informe_pn']);

      $query = 'UPDATE `grupo` SET `informe_pn` = "' . $_POST['informe_pn'] . '" WHERE `grupo`.`id` = ' . $_SESSION['grupo_id'] . '; ';
      $dbh->beginTransaction();
      $stmt = $dbh->prepare($query);
      $stmt->execute();
      $dbh->commit();
      echo '<script language="javascript">';
      echo 'alert("Guardado correctamente")';
      echo '</script>';
      echo '<script language="javascript">window.location="sesion2.php"</script>';
    } else {
      $query = ' SELECT * FROM estudiantes WHERE grupo_id = ? ';
      $stmt = $dbh->prepare($query);
      $stmt->execute([$_SESSION['grupo_id']]);
      $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
      foreach ($rows as $row) {
        $id = $row['id'];
        if (isset($_POST['id_ses' . $id])) {
          $query = 'UPDATE `sesion_2` SET';

              //$query .= '`informe_pn' . '`="' . $_POST["informe_pn"] . '",';
              //$query .= '`informe_mrb' . '`="' . $_POST["informe_mrb"] . '",';
          $query .= '`asistencia`= ' . $_POST[$id . "_asistencia"] . ',';

          for ($i = 0; $i < 8; $i++) {
            $I = $i + 1;
            if (isset($_POST[$id . "factor_tncf_$I"])) {
              $query .= '`factor_tncf_' . $I . '`= ' . $_POST[$id . "factor_tncf_$I"] . ',';
            } else {
              $query .= '`factor_tncf_' . $I . '`= ' . '-1' . ',';
            }
          }

          for ($i = 0; $i < 4; $i++) {
            $I = $i + 1;
            if (isset($_POST[$id . "factor_paf_$I"])) {
              $query .= '`factor_paf_' . $I . '`=' . $_POST[$id . "factor_paf_$I"] . ',';
            } else {
              $query .= '`factor_paf_' . $I . '`= ' . '-1' . ',';
            }
          }

          for ($i = 0; $i < 5; $i++) {
            $I = $i + 1;
            if (isset($_POST[$id . "factor_icppf_$I"])) {
              $query .= '`factor_icppf_' . $I . '`=' . $_POST[$id . "factor_icppf_$I"] . ',';
            } else {
              $query .= '`factor_icppf_' . $I . '`= ' . '-1' . ',';
            }
          }

          for ($i = 0; $i < 4; $i++) {
            $I = $i + 1;
            if (isset($_POST[$id . "factor_tivf_$I"])) {
              $query .= '`factor_tivf_' . $I . '`=' . $_POST[$id . "factor_tivf_$I"] . ',';
            } else {
                  // code...
              $query .= '`factor_tivf_' . $I . '`= ' . '-1' . ',';
            }
          }

    //***********************************************************
          if (isset($_POST[$id . "total_factor_tncf"])) {
            $query .= '`total_factor_tncf' . '`=' . $_POST[$id . "total_factor_tncf"] . ',';
          } else {
            $query .= '`total_factor_tncf' . '`=' . '0' . ',';
          }
          if (isset($_POST[$id . "total_factor_paf"])) {
            $query .= '`total_factor_paf' . '`=' . $_POST[$id . "total_factor_paf"] . ',';
          } else {
            $query .= '`total_factor_paf' . '`=' . '0' . ',';
          }
          if (isset($_POST[$id . "total_factor_icppf"])) {
            $query .= '`total_factor_icppf' . '`=' . $_POST[$id . "total_factor_icppf"] . ',';
          } else {
            $query .= '`total_factor_icppf' . '`=' . '0' . ',';
          }
          if (isset($_POST[$id . "total_factor_tivf"])) {
            $query .= '`total_factor_tivf' . '`=' . $_POST[$id . "total_factor_tivf"] . ',';
          } else {
            $query .= '`total_factor_tivf' . '`=' . '0' . ',';
          }

    //********************************************************
          for ($i = 0; $i < 2; $i++) {
            $I = $i + 1;
            if (isset($_POST[$id . "eet_economico_$I"])) {
              $query .= '`eet_economico_' . $I . '`=' . $_POST[$id . "eet_economico_$I"] . ',';

            } else {
              $query .= '`eet_economico_' . $I . '`= ' . '-1' . ',';
            }
          }

          for ($i = 0; $i < 3; $i++) {
            $I = $i + 1;
            if (isset($_POST[$id . "eet_laboral_$I"])) {
              $query .= '`eet_laboral_' . $I . '`=' . $_POST[$id . "eet_laboral_$I"] . ',';

            } else {
              $query .= '`eet_laboral_' . $I . '`= ' . '-1' . ',';
            }
          }

          for ($i = 0; $i < 3; $i++) {
            $I = $i + 1;
            if (isset($_POST[$id . "eet_familiar_$I"])) {

              $query .= '`eet_familiar_' . $I . '`=' . $_POST[$id . "eet_familiar_$I"] . ',';
            } else {
              $query .= '`eet_familiar_' . $I . '`= ' . '-1' . ',';
            }
          }
          for ($i = 0; $i < 2; $i++) {
            $I = $i + 1;
            if (isset($_POST[$id . "eet_vida_$I"])) {
              $query .= '`eet_vida_' . $I . '`=' . $_POST[$id . "eet_vida_$I"] . ',';

            } else {
              $query .= '`eet_vida_' . $I . '`= ' . '-1' . ',';
            }
          }
          for ($i = 0; $i < 3; $i++) {
            $I = $i + 1;
            if (isset($_POST[$id . "eet_academico_$I"])) {
              $query .= '`eet_academico_' . $I . '`=' . $_POST[$id . "eet_academico_$I"] . ',';
            } else {
              $query .= '`eet_academico_' . $I . '`= ' . '-1' . ',';
            }
          }

          $query .= '`total_eet_economico' . '`=' . $_POST[$id . "total_eet_economico"] . ',';
          $query .= '`total_eet_laboral' . '`=' . $_POST[$id . "total_eet_laboral"] . ',';
          $query .= '`total_eet_familiar' . '`=' . $_POST[$id . "total_eet_familiar"] . ',';
          $query .= '`total_eet_vida' . '`=' . $_POST[$id . "total_eet_vida"] . ',';
          $query .= '`total_eet_academico' . '`=' . $_POST[$id . "total_eet_academico"] . ',';
          $originales = array("'", '"');
          $correctos = array("\'", '\"');
          $_POST[$id . "observaciones"] = str_replace($originales, $correctos, $_POST[$id . "observaciones"]);
          $query .= '`observaciones' . '`="' . $_POST[$id . "observaciones"] . '"';
          $query .= ' WHERE id_estudiante=' . $_POST['id_ses' . $id] . ' ';


              //We start our transaction.
              #echo $query;
          $dbh->beginTransaction();

          try {
            $stmt = $dbh->prepare($query);
            $stmt->execute();
            $dbh->commit();
            #echo $query;


          } catch (Exception $e) {
            echo '<script language="javascript">';
            echo 'alert("Erro al guardar intente nuevamente")';
            echo '</script>';
            $dbh->rollBack();
          }
        } else {
          $query = 'INSERT INTO `sesion_2`(`id_estudiante`,`asistencia`, `factor_tncf_1`, `factor_tncf_2`, `factor_tncf_3`, `factor_tncf_4`, `factor_tncf_5`, `factor_tncf_6`, `factor_tncf_7`, `factor_tncf_8`, `factor_paf_1`, `factor_paf_2`, `factor_paf_3`, `factor_paf_4`, `factor_icppf_1`, `factor_icppf_2`, `factor_icppf_3`, `factor_icppf_4`, `factor_icppf_5`, `factor_tivf_1`, `factor_tivf_2`, `factor_tivf_3`, `factor_tivf_4`, `total_factor_tncf`, `total_factor_paf`, `total_factor_icppf`, `total_factor_tivf`, `eet_economico_1`, `eet_economico_2`, `eet_laboral_1`, `eet_laboral_2`, `eet_laboral_3`, `eet_familiar_1`, `eet_familiar_2`, `eet_familiar_3`, `eet_vida_1`, `eet_vida_2`, `eet_academico_1`, `eet_academico_2`, `eet_academico_3`, `total_eet_economico`, `total_eet_laboral`, `total_eet_familiar`, `total_eet_vida`, `total_eet_academico`, `observaciones`) VALUES (';
          $query .= $id . ',';
          $query .=  $_POST[$id . "_asistencia"] . ',';

          for ($i = 0; $i < 8; $i++) {
            $I = $i + 1;
            if (isset($_POST[$id . "factor_tncf_$I"])) {
              $query .= $_POST[$id . "factor_tncf_$I"] . ',';
            } else {
              $query .= '-1' . ',';
            }
          }

          for ($i = 0; $i < 4; $i++) {
            $I = $i + 1;
            if (isset($_POST[$id . "factor_paf_$I"])) {
              $query .= $_POST[$id . "factor_paf_$I"] . ',';
            } else {
              $query .= '-1' . ',';
            }
          }

          for ($i = 0; $i < 5; $i++) {
            $I = $i + 1;
            if (isset($_POST[$id . "factor_icppf_$I"])) {

              $query .= $_POST[$id . "factor_icppf_$I"] . ',';
            } else {
              $query .= '-1' . ',';
            }
          }

          for ($i = 0; $i < 4; $i++) {
            $I = $i + 1;
            if (isset($_POST[$id . "factor_tivf_$I"])) {
              $query .= $_POST[$id . "factor_tivf_$I"] . ',';
            } else {
              $query .= '-1' . ',';
            }
          }
    //*****************************************************************
          if (isset($_POST[$id . "total_factor_tncf"])) {
            $query .= $_POST[$id . "total_factor_tncf"] . ',';
          } else {
            $query .= '0' . ',';
          }

          if (isset($_POST[$id . "total_factor_paf"])) {
            $query .= $_POST[$id . "total_factor_paf"] . ',';
          } else {
            $query .= '0' . ',';
          }

          if (isset($_POST[$id . "total_factor_icppf"])) {
            $query .= $_POST[$id . "total_factor_icppf"] . ',';
          } else {
            $query .= '0' . ',';
          }
          if (isset($_POST[$id . "total_factor_tivf"])) {
            $query .= $_POST[$id . "total_factor_tivf"] . ',';
          } else {
            $query .= '0' . ',';
          }

    //******************************************************************
          for ($i = 0; $i < 2; $i++) {
            $I = $i + 1;
            if (isset($_POST[$id . "eet_economico_$I"])) {
              $query .= $_POST[$id . "eet_economico_$I"] . ',';
            } else {
              $query .= '-1' . ',';
            }
          }

          for ($i = 0; $i < 3; $i++) {
            $I = $i + 1;
            if (isset($_POST[$id . "eet_laboral_$I"])) {
              $query .= $_POST[$id . "eet_laboral_$I"] . ',';
            } else {
              $query .= '-1' . ',';
            }
          }

          for ($i = 0; $i < 3; $i++) {
            $I = $i + 1;
            if (isset($_POST[$id . "eet_familiar_$I"])) {
              $query .= $_POST[$id . "eet_familiar_$I"] . ',';
            } else {
              $query .= '-1' . ',';
            }
          }
          for ($i = 0; $i < 2; $i++) {
            $I = $i + 1;
            if (isset($_POST[$id . "eet_vida_$I"])) {
              $query .= $_POST[$id . "eet_vida_$I"] . ',';
            } else {
              $query .= '-1' . ',';
            }
          }

          for ($i = 0; $i < 3; $i++) {
            $I = $i + 1;
            if (isset($_POST[$id . "eet_academico_$I"])) {
              $query .= $_POST[$id . "eet_academico_$I"] . ',';
            } else {
              $query .= '-1' . ',';
            }
          }
          if (isset($_POST[$id . "total_eet_economico"])) {
            $query .= $_POST[$id . "total_eet_economico"] . ',';
          } else {
            $query .= '0' . ',';
          }
          if (isset($_POST[$id . "total_eet_laboral"])) {
            $query .= $_POST[$id . "total_eet_laboral"] . ',';
          } else {
            $query .= '0' . ',';
          }
          if (isset($_POST[$id . "total_eet_familiar"])) {
            $query .= $_POST[$id . "total_eet_familiar"] . ',';
          } else {
            $query .= '0' . ',';
          }
          if (isset($_POST[$id . "total_eet_vida"])) {
            $query .= $_POST[$id . "total_eet_vida"] . ',';
          } else {
            $query .= '0' . ',';
          }
          if (isset($_POST[$id . "total_eet_academico"])) {
            $query .= $_POST[$id . "total_eet_academico"] . ',';
          } else {
            $query .= '0' . ',';
          }

          if (isset($_POST[$id . "observaciones"])) {
            $originales = array("'", '"');
            $correctos = array("\'", '\"');
            $_POST[$id . "observaciones"] = str_replace($originales, $correctos, $_POST[$id . "observaciones"]);

            $query .= '"' . $_POST[$id . "observaciones"] . '")';
          } else {
            $query .= '""' . ')';
          }
          #echo $query;


              //echo $query;
              //We start our transaction.
          $dbh->beginTransaction();

          try {
            $stmt = $dbh->prepare($query);
            $stmt->execute();
            $dbh->commit();
          } catch (Exception $e) {
            $dbh->rollBack();
            echo '<script language="javascript">';
            echo 'alert("Erro al guardar intente nuevamente")';
            echo '</script>';
          }
        }

      }
      echo '<script language="javascript">';
      echo 'alert("Guardado correctamente")';
      echo '</script>';
      echo '<script language="javascript">window.location="sesion2.php"</script>';


    }

  } ?>


    <form id="form1" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"></form>

    <div class="tb-container">
    <table class="table">
    <thead>
    <tr class="titles">
    <th>Nombre</th>
    <th > <div style="width: 170px">Asistencia </div></th>
    <th> <div class ="container2"> factor tendencia a no centrarse en el futuro 1 </div> </th>
    <th> <div class ="container2"> factor tendencia a no centrarse en el futuro 2 </div> </th>
    <th> <div class ="container2"> factor tendencia a no centrarse en el futuro 3 </div> </th>
    <th> <div class ="container2"> factor tendencia a no centrarse en el futuro 4 </div> </th>
    <th> <div class ="container2"> factor tendencia a no centrarse en el futuro 5 </div> </th>
    <th> <div class ="container2"> factor tendencia a no centrarse en el futuro 6 </div> </th>
    <th> <div class ="container2"> factor tendencia a no centrarse en el futuro 7 </div> </th>
    <th> <div class ="container2"> factor tendencia a no centrarse en el futuro 8 </div> </th>
    <th> <div class ="container2"> factor planeacion activa del futuro 1 </div> </th>
    <th> <div class ="container2"> factor planeacion activa del futuro 2 </div> </th>
    <th> <div class ="container2"> factor planeacion activa del futuro 3 </div> </th>
    <th> <div class ="container2"> factor planeacion activa del futuro 4 </div> </th>
    <th> <div style="width: 200px"> factor influencia de la conducta pasada y presente en el futuro 1 </div> </th>
    <th> <div style="width: 200px"> factor influencia de la conducta pasada y presente en el futuro 2 </div> </th>
    <th> <div style="width: 200px"> factor influencia de la conducta pasada y presente en el futuro 3 </div> </th>
    <th> <div style="width: 200px"> factor influencia de la conducta pasada y presente en el futuro 4 </div> </th>
    <th> <div style="width: 200px"> factor influencia de la conducta pasada y presente en el futuro 5 </div> </th>
    <th> <div class ="container2"> factor tendencia a imaginarse la vida en el futuro 1 </div> </th>
    <th> <div class ="container2"> factor tendencia a imaginarse la vida en el futuro 2 </div> </th>
    <th> <div class ="container2"> factor tendencia a imaginarse la vida en el futuro 3 </div> </th>
    <th> <div class ="container2"> factor tendencia a imaginarse la vida en el futuro 4 </div> </th>

    <th> <div style="width: 200px"> total factor tendencia a no centrarse en el futuro  </div> </th>
    <th> <div class ="container2"> total factor planeacion activa del futuro  </div> </th>
    <th> <div style="width: 200px"> total factor influencia de la conducta pasada y presente en el futuro </div> </th>
    <th> <div style="width: 200px"> total factor tendencia a imaginarse la vida en el futuro  </div> </th>

    <th> <div class ="container2"> extension temporal economico comprar casa </div> </th>
    <th> <div class ="container2"> extension temporal economico comprar carro </div> </th>
    <th> <div class ="container2"> extension temporal laboral conseguir empleo estable </div> </th>
    <th> <div style="width: 200px"> extension temporal laboral terminar una carrera profesional </div> </th>
    <th> <div class ="container2"> extension temporal laboral crear negocio propio </div> </th>
    <th> <div class ="container2"> extension temporal familiar casarme o irme con mi pareja </div> </th>
    <th> <div style="width: 220px"> extension temporal familiar irme de mi casa o dejar de vivir con mis padres </div> </th>
    <th> <div class ="container2"> extension temporal familiar tener mi primer hijo </div> </th>
    <th> <div style="width: 250px"> ¿Cuantos años quisieras vivir? diferencia entre la edad acutal y la edad proyectada </div> </th>
    <th> <div style="width: 250px"> ¿Cuantos años crees que vas a vivir? diferencia entre la edad acutal y la edad proyectada </div> </th>
    <th> <div style="width: 200px"> extension temporal academico terminar mis estudios de bachillerato </div> </th>
    <th> <div class ="container2"> extension temporal academico irme al ejercito o la policia </div> </th>
    <th> <div style="width: 250px"> extension temporal academico ingresar a estudiar una carrera profesional </div> </th>
    <th>total escala de extension economico </th>
    <th>total escala de extension laboral </th>
    <th>total escala de extension familiar </th>
    <th>total escala de extension vida </th>
    <th>total escala de extension academico </th>
    <th>Observaciones </th>
    <th>Subir linea de vida</th>

    </tr>
    </thead>
    <tbody>
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

        $asistencia = 0;
        ?>
        <td>
          <input <?php echo ' type="radio" class="radioBttn" name= "' . $id . "_asistencia".'"' ; ?>  <?php if ($asistencia == 1) echo "checked"; ?> value="1" form="form1">Si</br>
          <input <?php echo ' type="radio" class="radioBttn" name= "' . $id . "_asistencia".'"' ; ?>  <?php if ($asistencia == 2) echo "checked"; ?> value="2" form="form1">Si, pero no completo</br>
          <input <?php echo ' type="radio" class="radioBttn" name= "' . $id . "_asistencia".'"' ; ?>  <?php if ($asistencia == 0) echo "checked"; ?> value="0" form="form1">No
        </td>
        <?php

            //echo '<td><input class="inf" type="number" name="informe_pn" value="" /></td>';
            //echo '<td><input class="inf" type="number" name="informe_mrb" value="" /></td>';

            //echo '<td><textarea rows="4" cols="40" name="informe_pn" form="form_'.$s['id_estudiante'].'"></textarea></td>';
            //echo '<td><textarea rows="4" cols="40" name="informe_mrb" form="form_'.$s['id_estudiante'].'"></textarea></td>';


        #echo ' <form method = "post" action = "' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" id="form_' . $s['id_estudiante'] . '" >';

        $factor_tncf = [null, null, null, null, null, null, null, null];

        for ($i = 0; $i < 8; $i++) {
                  //echo '<td><input class="in" type="number" name="factor_tncf_' . ($i + 1) . '" value="" /></td>';
          ?>

            <td>
              <?php echo '<input type="radio" class="radioBttn" name= "' . $id . "factor_tncf_" . ($i + 1) . '"'; ?>  <?php if (isset($factor_tncf[$i]) && $factor_tncf[$i] == "0") echo "checked"; ?> value="0" form="form1">Si</br>
              <?php echo '<input type="radio" class="radioBttn" name= "' . $id . "factor_tncf_" . ($i + 1) . '"'; ?>  <?php if (isset($factor_tncf[$i]) && $factor_tncf[$i] == "1") echo "checked"; ?> value="1" form="form1">No
            </td>
            <?php

          }

          $factor_paf = [null, null, null, null];
          for ($i = 0; $i < 4; $i++) {
            //echo '<td><input class="in" type="number" name="factor_paf_' . ($i + 1) . '" value="" /></td>';
            ?>
            <td>
              <?php echo '<input type="radio" class="radioBttn" name= "' . $id . "factor_paf_" . ($i + 1) . '"'; ?>  <?php if (isset($factor_paf[$i]) && $factor_paf[$i] == "1") echo "checked"; ?> value="1" form="form1">Si</br>
              <?php echo '<input type="radio" class="radioBttn" name= "' . $id . "factor_paf_" . ($i + 1) . '"'; ?>  <?php if (isset($factor_paf[$i]) && $factor_paf[$i] == "0") echo "checked"; ?> value="0" form="form1">No
            </td>
            <?php


          }

          $factor_icppf = [null, null, null, null, null];
          for ($i = 0; $i < 5; $i++) {
            //echo '<td><input class="in" type="number" name="factor_icppf_' . ($i + 1) . '" value="" /></td>';

            ?>
            <td>
              <?php echo '<input type="radio" class="radioBttn" name= "' . $id . "factor_icppf_" . ($i + 1) . '"'; ?>  <?php if (isset($factor_icppf[$i]) && $factor_icppf[$i] == "1") echo "checked"; ?> value="1" form="form1">Si</br>
              <?php echo '<input type="radio" class="radioBttn" name= "' . $id . "factor_icppf_" . ($i + 1) . '"'; ?>  <?php if (isset($factor_icppf[$i]) && $factor_icppf[$i] == "0") echo "checked"; ?> value="0" form="form1">No
            </td>
            <?php

          }
          $factor_tivf = [null, null, null, null];
          for ($i = 0; $i < 4; $i++) {
            //echo '<td><input class="in" type="number" name="factor_tivf_' . ($i + 1) . '" value="" /></td>';
            ?>
            <td>
              <?php echo '<input type="radio" class="radioBttn" name= "' . $id . "factor_tivf_" . ($i + 1) . '"'; ?>  <?php if (isset($factor_tivf[$i]) && $factor_tivf[$i] == "1") echo "checked"; ?> value="1" form="form1">Si</br>
              <?php echo '<input type="radio" class="radioBttn" name= "' . $id . "factor_tivf_" . ($i + 1) . '"'; ?>  <?php if (isset($factor_tivf[$i]) && $factor_tivf[$i] == "0") echo "checked"; ?> value="0" form="form1">No
            </td>
            <?php

          }

          echo '<td><input class="in" type="number" form="form1" name="' . $id . 'total_factor_tncf" value="0" /> </td>';
          echo '<td><input class="in" type="number" form="form1" name="' . $id . 'total_factor_paf" value="0" />   </td>';
          echo '<td><input class="in" type="number" form="form1" name="' . $id . 'total_factor_icppf" value="0" /> </td>';
          echo '<td><input class="in" type="number" form="form1" name="' . $id . 'total_factor_tivf" value="0" />  </td>';

          $eet_economico = [null, null];
          for ($i = 0; $i < 2; $i++) {
            //echo '<td><input class="in" type="number" name="eet_econnomico_' . ($i + 1) . '" value="" /></td>';

            ?>
            <td>
              <?php echo '<input type="radio" class="radioBttn" name= "' . $id . "eet_economico_" . ($i + 1) . '"'; ?>  <?php if (isset($eet_economico[$i]) && $eet_economico[$i] == "1") echo "checked"; ?> value="1" form="form1">Si</br>
              <?php echo '<input type="radio" class="radioBttn" name= "' . $id . "eet_economico_" . ($i + 1) . '"'; ?>  <?php if (isset($eet_economico[$i]) && $eet_economico[$i] == "0") echo "checked"; ?> value="0" form="form1">No
            </td>
            <?php

          }

          $eet_laboral = [null, null, null];
          for ($i = 0; $i < 3; $i++) {
            //echo '<td><input class="in" type="number" name="eet_laboral_' . ($i + 1) . '" value="" /></td>';
            ?>
            <td>
              <?php echo '<input type="radio" class="radioBttn" name= "' . $id . "eet_laboral_" . ($i + 1) . '"'; ?>  <?php if (isset($eet_laboral[$i]) && $eet_laboral[$i] == "1") echo "checked"; ?> value="1" form="form1">Si</br>
              <?php echo '<input type="radio" class="radioBttn" name= "' . $id . "eet_laboral_" . ($i + 1) . '"'; ?>  <?php if (isset($eet_laboral[$i]) && $eet_laboral[$i] == "0") echo "checked"; ?> value="0" form="form1">No
            </td>
            <?php

          }

          $eet_familiar = [null, null, null];
          for ($i = 0; $i < 3; $i++) {
            //echo '<td><input class="in" type="number" name="eet_familiar_' . ($i + 1) . '" value="" /></td>';
            ?>
            <td>
              <?php echo '<input type="radio" class="radioBttn" name= "' . $id . "eet_familiar_" . ($i + 1) . '"'; ?>  <?php if (isset($eet_familiar[$i]) && $eet_familiar[$i] == "1") echo "checked"; ?> value="1" form="form1">Si</br>
              <?php echo '<input type="radio" class="radioBttn" name= "' . $id . "eet_familiar_" . ($i + 1) . '"'; ?>  <?php if (isset($eet_familiar[$i]) && $eet_familiar[$i] == "0") echo "checked"; ?> value="0" form="form1">No
            </td>
            <?php

          }

          $eet_vida = [null, null];
          for ($i = 0; $i < 2; $i++) {
            //echo '<td><input class="in" type="number" name="eet_vida_' . ($i + 1) . '" value="" /></td>';
            ?>
            <td>
              <?php echo '<input type="number" form="form1" name= "' . $id . "eet_vida_" . ($i + 1) . '"' . 'value="0">' ?>
            </td>
            <?php

          }

          $eet_academico = [null, null, null];
          for ($i = 0; $i < 3; $i++) {
            //echo '<td><input class="in" type="number" name="eet_academico_' . ($i + 1) . '" value="" /></td>';
            ?>
            <td>
              <?php echo '<input type="radio" class="radioBttn" name= "' . $id . "eet_academico_" . ($i + 1) . '"'; ?>  <?php if (isset($eet_academico[$i]) && $eet_academico[$i] == "1") echo "checked"; ?> value="1" form="form1">Si</br>
              <?php echo '<input type="radio" class="radioBttn" name= "' . $id . "eet_academico_" . ($i + 1) . '"'; ?>  <?php if (isset($eet_academico[$i]) && $eet_academico[$i] == "0") echo "checked"; ?> value="0" form="form1">No
            </td>
            <?php

          }

          echo '<td><input class="in" type="number" form="form1" name="' . $id . 'total_eet_economico" value="0" /></td>';
          echo '<td><input class="in" type="number" form="form1" name="' . $id . 'total_eet_laboral" value="0" /></td>';
          echo '<td><input class="in" type="number" form="form1" name="' . $id . 'total_eet_familiar" value="0" /></td>';
          echo '<td><input class="in" type="number" form="form1" name="' . $id . 'total_eet_vida" value="0" /></td>';
          echo '<td><input class="in" type="number" form="form1" name="' . $id . 'total_eet_academico" value="0" /></td>';
          echo '<td><textarea rows="4" cols="40"  form="form1" name="' . $id . 'observaciones" > </textarea></td>';


          echo '<input type="hidden" name="name" form="form1" value="' . $row['nombre'] . '" />';
          echo '<input type="hidden" name="id" form="form1" value="' . $row['id'] . '" />';
          #echo '<td><input  class="button" type="submit" value="Enviar"/></td>';
          #echo '</form>';
          echo '<td>';

        } else { //si esta creado los espacios se llenan con los correspondientes elementos que ya estan en la base de datos
    /*
           */

    //echo '<td><textarea rows="4" cols="40" name="informe_pn"  form="form_'.$s['id_estudiante'].'"  >'.$s["informe_pn"].' </textarea></td>';
    //echo '<td><textarea rows="4" cols="40" name="informe_mrb" form="form_'.$s['id_estudiante'].'"  >'.$s["informe_mrb"].'</textarea></td>';

          #echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '"  id="form_' . $s['id_estudiante'] . '" >';

        //echo '<td><input class="inf" type="number" name="informe_pn" value="'.$s["informe_pn"].'" /></td>';
        //echo '<td><input class="inf" type="number" name="informe_mrb" value="'.$s["informe_mrb"].'" /></td>';

          $asistencia =  $s["asistencia"];
          ?>
          <td>
            <input <?php echo ' type="radio" class="radioBttn" name= "' . $id . "_asistencia".'"' ; ?>  <?php if ($asistencia == 1) echo "checked"; ?> value="1" form="form1">Si</br>
            <input <?php echo ' type="radio" class="radioBttn" name= "' . $id . "_asistencia".'"' ; ?>  <?php if ($asistencia == 2) echo "checked"; ?> value="2" form="form1">Si, pero no completo</br>
            <input <?php echo ' type="radio" class="radioBttn" name= "' . $id . "_asistencia".'"' ; ?>  <?php if ($asistencia == 0) echo "checked"; ?> value="0" form="form1">No
          </td>
          <?php


          $factor_tncf = [null, null, null, null, null, null, null, null];

          for ($i = 0; $i < 8; $i++) {
            //echo '<td><input class="in" type="number" name="factor_tncf_' . ($i + 1) . '" value="" /></td>';
            $I = $i + 1;
            $factor_tncf[$i] = $s["factor_tncf_$I"];
            ?>
            <td>
              <?php echo '<input type="radio" class="radioBttn" name= "' . $id . "factor_tncf_" . $I . '"'; ?>  <?php if (isset($factor_tncf[$i]) && $factor_tncf[$i] == "0") echo "checked"; ?> value="0" form="form1">Si</br>
              <?php echo '<input type="radio" class="radioBttn" name= "' . $id . "factor_tncf_" . $I . '"'; ?>  <?php if (isset($factor_tncf[$i]) && $factor_tncf[$i] == "1") echo "checked"; ?> value="1" form="form1">No
            </td>
            <?php

          }

          $factor_paf = [null, null, null, null];
          for ($i = 0; $i < 4; $i++) {
            //echo '<td><input class="in" type="number" name="factor_paf_' . ($i + 1) . '" value="" /></td>';
            $I = $i + 1;
            $factor_paf[$i] = $s["factor_paf_$I"];


            ?>
            <td>
              <?php echo '<input type="radio" class="radioBttn" name= "' . $id . "factor_paf_" . ($i + 1) . '"'; ?>  <?php if (isset($factor_paf[$i]) && $factor_paf[$i] == "1") echo "checked"; ?> value="1" form="form1">Si</br>
              <?php echo '<input type="radio" class="radioBttn" name= "' . $id . "factor_paf_" . ($i + 1) . '"'; ?>  <?php if (isset($factor_paf[$i]) && $factor_paf[$i] == "0") echo "checked"; ?> value="0" form="form1">No
            </td>
            <?php

          }
          $factor_icppf = [null, null, null, null, null];
          for ($i = 0; $i < 5; $i++) {
            //echo '<td><input class="in" type="number" name="factor_icppf_' . ($i + 1) . '" value="" /></td>';
            $I = $i + 1;
            $factor_icppf[$i] = $s["factor_icppf_$I"];
            ?>
            <td>
              <?php echo '<input type="radio" class="radioBttn" name= "' . $id . "factor_icppf_" . ($i + 1) . '"'; ?>  <?php if (isset($factor_icppf[$i]) && $factor_icppf[$i] == "1") echo "checked"; ?> value="1" form="form1">Si</br>
              <?php echo '<input type="radio" class="radioBttn" name= "' . $id . "factor_icppf_" . ($i + 1) . '"'; ?>  <?php if (isset($factor_icppf[$i]) && $factor_icppf[$i] == "0") echo "checked"; ?> value="0" form="form1">No
            </td>
            <?php

          }
          $factor_tivf = [null, null, null, null];
          for ($i = 0; $i < 4; $i++) {
            //echo '<td><input class="in" type="number" name="factor_tivf_' . ($i + 1) . '" value="" /></td>';
            $I = $i + 1;
            $factor_tivf[$i] = $s["factor_tivf_$I"];

            ?>
            <td>
              <?php echo '<input type="radio" class="radioBttn" name= "' . $id . "factor_tivf_" . ($i + 1) . '"'; ?>  <?php if (isset($factor_tivf[$i]) && $factor_tivf[$i] == "1") echo "checked"; ?> value="1" form="form1">Si</br>
              <?php echo '<input type="radio" class="radioBttn" name= "' . $id . "factor_tivf_" . ($i + 1) . '"'; ?>  <?php if (isset($factor_tivf[$i]) && $factor_tivf[$i] == "0") echo "checked"; ?> value="0" form="form1">No
            </td>
            <?php

          }

          echo '<td><input class="in" type="number" form="form1" name="' . $id . 'total factor tncf" value="' . $s["total_factor_tncf"] . '" /></td>';
          echo '<td><input class="in" type="number" form="form1" name="' . $id . 'total_factor_paf"   value="' . $s["total_factor_paf"] . '" /></td>';
          echo '<td><input class="in" type="number" form="form1" name="' . $id . 'total_factor_icppf" value="' . $s["total_factor_icppf"] . '" /></td>';
          echo '<td><input class="in" type="number" form="form1" name="' . $id . 'total_factor_tivf"  value="' . $s["total_factor_tivf"] . '" /></td>';

          $eet_economico = [null, null];
          for ($i = 0; $i < 2; $i++) {
            //echo '<td><input class="in" type="number" name="eet_econnomico_' . ($i + 1) . '" value="" /></td>';
            $I = $i + 1;
            $eet_economico[$i] = $s["eet_economico_$I"];
            ?>
            <td>
              <?php echo '<input type="radio" class="radioBttn" name= "' . $id . "eet_economico_" . ($i + 1) . '"'; ?>  <?php if (isset($eet_economico[$i]) && $eet_economico[$i] == "1") echo "checked"; ?> value="1" form="form1">Si</br>
              <?php echo '<input type="radio" class="radioBttn" name= "' . $id . "eet_economico_" . ($i + 1) . '"'; ?>  <?php if (isset($eet_economico[$i]) && $eet_economico[$i] == "0") echo "checked"; ?> value="0" form="form1">No
            </td>
            <?php

          }

          $eet_laboral = [null, null, null];
          for ($i = 0; $i < 3; $i++) {
            //echo '<td><input class="in" type="number" name="eet_laboral_' . ($i + 1) . '" value="" /></td>';
            $I = $i + 1;
            $eet_laboral[$i] = $s["eet_laboral_$I"];
            ?>
            <td>
              <?php echo '<input type="radio" class="radioBttn" name= "' . $id . "eet_laboral_" . ($i + 1) . '"'; ?>  <?php if (isset($eet_laboral[$i]) && $eet_laboral[$i] == "1") echo "checked"; ?> value="1" form="form1">Si</br>
              <?php echo '<input type="radio" class="radioBttn" name= "' . $id . "eet_laboral_" . ($i + 1) . '"'; ?>  <?php if (isset($eet_laboral[$i]) && $eet_laboral[$i] == "0") echo "checked"; ?> value="0" form="form1">No
            </td>
            <?php

          }

          $eet_familiar = [null, null, null];
          for ($i = 0; $i < 3; $i++) {
            //echo '<td><input class="in" type="number" name="eet_familiar_' . ($i + 1) . '" value="" /></td>';
            $I = $i + 1;
            $eet_familiar[$i] = $s["eet_familiar_$I"];
            ?>
            <td>
              <?php echo '<input type="radio" class="radioBttn" name= "' . $id . "eet_familiar_" . ($i + 1) . '"'; ?>  <?php if (isset($eet_familiar[$i]) && $eet_familiar[$i] == "1") echo "checked"; ?> value="1" form="form1">Si</br>
              <?php echo '<input type="radio" class="radioBttn" name= "' . $id . "eet_familiar_" . ($i + 1) . '"'; ?>  <?php if (isset($eet_familiar[$i]) && $eet_familiar[$i] == "0") echo "checked"; ?> value="0" form="form1">No
            </td>
            <?php

          }


          for ($i = 0; $i < 2; $i++) {
            //echo '<td><input class="in" type="number" name="eet_vida_' . ($i + 1) . '" value="" /></td>';
            $I = $i + 1;
            ?>
            <td>
              <?php echo '<input type="number" form="form1" name= "' . $id . "eet_vida_" . ($i + 1) . '"' . 'value="' . $s["eet_vida_$I"] . '" form="form1">' ?>
            </td>
            <?php

          }

          $eet_academico = [null, null, null];
          for ($i = 0; $i < 3; $i++) {
            //echo '<td><input class="in" type="number" name="eet_academico_' . ($i + 1) . '" value="" /></td>';
            $I = $i + 1;
            $eet_academico[$i] = $s["eet_academico_$I"];
            ?>
            <td>
              <?php echo '<input type="radio" class="radioBttn" name= "' . $id . "eet_academico_" . ($i + 1) . '"'; ?>  <?php if (isset($eet_academico[$i]) && $eet_academico[$i] == "1") echo "checked"; ?> value="1" form="form1">Si</br>
              <?php echo '<input type="radio" class="radioBttn" name= "' . $id . "eet_academico_" . ($i + 1) . '"'; ?>  <?php if (isset($eet_academico[$i]) && $eet_academico[$i] == "0") echo "checked"; ?> value="0" form="form1">No
            </td>
            <?php

          }

          echo '<td><input class="in" type="number" name="' . $id . 'total_eet_economico" form="form1"  value="' . $s["total_eet_economico"] . '" /></td>';
          echo '<td><input class="in" type="number" name="' . $id . 'total_eet_laboral"   form="form1"  value="' . $s["total_eet_laboral"] . '" /></td>';
          echo '<td><input class="in" type="number" name="' . $id . 'total_eet_familiar"  form="form1"  value="' . $s["total_eet_familiar"] . '" /></td>';
          echo '<td><input class="in" type="number" name="' . $id . 'total_eet_vida"      form="form1"  value="' . $s["total_eet_vida"] . '" /></td>';
          echo '<td><input class="in" type="number" name="' . $id . 'total_eet_academico" form="form1"  value="' . $s["total_eet_academico"] . '" /></td>';
          echo '<td><textarea rows="4" cols="40"  name="' . $id . 'observaciones" form="form1">' . $s["observaciones"] . ' </textarea></td>';


          echo '<input type="hidden" name="name" value="' . $row['nombre'] . '" form="form1" />';
          echo '<input type="hidden" name="id" value="' . $row['id'] . '" form="form1" />';
          echo '<input type="hidden" name="id_ses' . $id . '" value="' . $s['id_estudiante'] . '" form="form1"/>';


          #echo '</form>';

          echo '<td>';
        }
        #echo '<td><input class="button" type="submit" value="Enviar" form="form1"/></td>';


        $path = 'uploads/sesion2/' . $row['id'];
        if (glob($path . '.*')) {
          $arr = glob($path . '.*');
          echo '<a href="' . $arr[0] . '">Ver archivo</a>';

        }
        echo '
                      <form action="upload.php" method="post" enctype="multipart/form-data">
                          Selecciona el archivo:
                          <input type="hidden" name="Sesion2" value="Sesion2" />
                          <input type="hidden" name="redirect" value="sesion2" />
                          <input type="hidden" name="image_id" value="' . $row['id'] . '" />
                          <input class="fileToUpload" type="file" name="fileToUpload" id="fileToUpload">
                          <input class="upload" type="submit" value="Subir archivo" name="submit">
                      </form>
                    </td>';
        echo '</tr>';
      }

      ?>
      </tbody>
    </table>
    </form>
    </div>
    <input class="button" type="submit" value="Guardar" form="form1"/>
    <?php


    $query = ' SELECT * FROM `grupo` WHERE id = ' . $_SESSION['grupo_id'] . ' ';
    $stmt = $dbh->prepare($query);
    $stmt->execute([$_SESSION['grupo_id']]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows as $row) {
      echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '"  id="form_pn" >';
      echo '<div class="group_container">';
      echo '<input type="hidden" name="informe_grupo2" value="" />';
      echo '<p class="titulo_informe"> INFORME SOBRE EVENTOS POSITIVOS Y NEGATIVOS DEL GRUPO</p>';
      echo '<td><textarea rows="6" cols="150" name="informe_pn"  form="form_pn" class="informe_grupo"  >' . $row["informe_pn"] . ' </textarea></td></br>';
      echo '<td><input class="button" type="submit" value="Enviar informe del grupo"/></td>';
      echo '</div>';
      echo '</form>';
    }



    $query = ' SELECT * FROM `grupo` WHERE id = ' . $_SESSION['grupo_id'] . ' ';
    $stmt = $dbh->prepare($query);
    $stmt->execute([$_SESSION['grupo_id']]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows as $row) {
      echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '"  id="form_mrb" >';
      echo '<div class="group_container">';
      echo '<input type="hidden" name="informe_grupo" value="" />';
      echo '<p class="titulo_informe" >INFORME METAS, RECURSOS Y BARRERAS DEL GRUPO</p>';
      echo '<td><textarea rows="6" cols="150" name="informe_mrb"  form="form_mrb" class="informe_grupo"  >' . $row["informe_mrb"] . ' </textarea></td></br>';
      echo '<td><input class="button" type="submit" value="Enviar informe del grupo"/></td>';
      echo '</div>';
      echo '</form>';

    }

    echo '
        <div style="margin-left: 30px;">
        <h2>Lista asistencia</h2>';
    $path = 'uploads/sesion2/lista'.$_SESSION['grupo_id'].'';
    if (glob($path . '.*')) {
      $arr = glob($path . '.*');
      echo '<h3><a href="' . $arr[0] . '">Ver Lista</a></h3>';

    }
    echo '<form action="upload.php" method="post" enctype="multipart/form-data">
            Selecciona el archivo:
            <input type="hidden" name="Sesion2" value="Sesion2" />
            <input type="hidden" name="redirect" value="sesion2" />
            <input type="hidden" name="image_id" value="lista'.$_SESSION['grupo_id'].'" />
            <input class="fileToUpload" type="file" name="fileToUpload" id="fileToUpload">
            <input class="upload" type="submit" value="Subir archivo" name="submit">
        </form>
        </div>';

    echo '
        <div style="margin-left: 30px;">
        <h2>Acta Sesión</h2>';
    $path = 'uploads/sesion2/acta'.$_SESSION['grupo_id'].'';
    if (glob($path . '.*')) {
      $arr = glob($path . '.*');
      echo '<h3><a href="' . $arr[0] . '">Ver Acta</a></h3>';

    }
    echo '<form action="upload.php" method="post" enctype="multipart/form-data">
            Selecciona el archivo:
            <input type="hidden" name="Sesion2" value="Sesion2" />
            <input type="hidden" name="redirect" value="sesion2" />
            <input type="hidden" name="image_id" value="acta'.$_SESSION['grupo_id'].'" />
            <input class="fileToUpload" type="file" name="fileToUpload" id="fileToUpload">
            <input class="upload" type="submit" value="Subir archivo" name="submit">
        </form>
        </div>';
    ?>

</body>
<?php


include_once("footer.php");
?>
